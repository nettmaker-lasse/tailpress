<?php
/**
 * TailPress component runtime.
 *
 * @package TailPress
 */

if (!function_exists('component')) {
    function component(string $name, array $args = []): ComponentView
    {
        return component_get($name, $args);
    }
}

if (!function_exists('component_get')) {
    function component_get(string $name, array $args = []): ComponentView
    {
        return new ComponentView($name, $args);
    }
}

if (!function_exists('component_print')) {
    function component_print(string $name, array $args = []): void
    {
        component_get($name, $args)->print();
    }
}

if (!function_exists('component_html')) {
    function component_html(string $html): ComponentView
    {
        return component('html', ['content' => $html]);
    }
}

if (!class_exists('ComponentView')) {
    class ComponentView
    {
        public string $name;
        public ComponentArgs $args;

        public function __construct(string $name, array $args = [])
        {
            $this->name = sanitize_key($name);
            $this->args = new ComponentArgs($args);
        }

        public function render(): string
        {
            ob_start();

            $args = apply_filters('component/component_args', $this->args, $this->name);
            if (!$args instanceof ComponentArgs) {
                $args = new ComponentArgs(is_array($args) ? $args : []);
            }

            if (!$args->is('should_render', true)) {
                ob_end_clean();
                return '';
            }

            $component_dir = trailingslashit(get_template_directory()) . 'partials/components/' . $this->name;
            $config_path = $component_dir . '/' . $this->name . '-config.php';
            $template_path = $component_dir . '/' . $this->name . '.php';

            if (file_exists($config_path)) {
                include $config_path;
            }

            if (!file_exists($template_path)) {
                ob_end_clean();
                return '';
            }

            include $template_path;
            $html = (string) ob_get_clean();

            $wrapper = $args->get('wrapper');
            if (!is_array($wrapper) || $wrapper === []) {
                return $html;
            }

            return $this->wrap_html($html, $wrapper);
        }

        public function print(): void
        {
            echo $this->render();
        }

        public function __toString(): string
        {
            return $this->render();
        }

        private function wrap_html(string $html, array $wrapper): string
        {
            $tag = isset($wrapper['tag']) ? preg_replace('/[^a-z0-9_-]/i', '', (string) $wrapper['tag']) : 'div';
            if (!$tag) {
                $tag = 'div';
            }

            $attrs = [];
            if (!empty($wrapper['class'])) {
                $attrs['class'] = $wrapper['class'];
            }

            if (!empty($wrapper['attrs']) && is_array($wrapper['attrs'])) {
                $attrs = array_merge($attrs, $wrapper['attrs']);
            }

            $attr_string = ComponentArgs::build_attribute_string($attrs);
            return '<' . $tag . $attr_string . '>' . $html . '</' . $tag . '>';
        }
    }
}

if (!class_exists('ComponentArgs')) {
    class ComponentArgs
    {
        /** @var array<string,mixed> */
        private array $values = [];

        /** @var array<string,bool> */
        private array $attribute_map = [];

        public ?ComponentArgs $parent_args = null;

        public function __construct(array $args = [])
        {
            if (!empty($args['_parent_args']) && $args['_parent_args'] instanceof self) {
                $this->parent_args = $args['_parent_args'];
                unset($args['_parent_args']);
            }

            $this->values = $args;

            $this->add_default('class', []);
            $this->add_default('style', []);
            $this->add_option_default('should_render', true);
            $this->add_option_default('wrapper', null);

            foreach (array_keys($this->values) as $key) {
                if (!isset($this->attribute_map[$key])) {
                    $this->attribute_map[$key] = true;
                }
            }

            $this->mark_as_option('should_render');
            $this->mark_as_option('wrapper');
        }

        public function set(string $key, $value): void
        {
            $this->values[$key] = $value;
            if (!isset($this->attribute_map[$key])) {
                $this->attribute_map[$key] = true;
            }
        }

        public function add_default(string $key, $default = null, ?bool $is_attribute = null): void
        {
            if (!$this->has_key($key)) {
                $this->values[$key] = $default;
            }

            if (!isset($this->attribute_map[$key])) {
                $this->attribute_map[$key] = true;
            }

            if ($is_attribute !== null) {
                $this->attribute_map[$key] = $is_attribute;
            }
        }

        public function add_option_default(string $key, $value): void
        {
            $this->add_default($key, $value, false);
        }

        public function mark_as_option(string $key): void
        {
            $this->attribute_map[$key] = false;
        }

        public function set_as_attribute(string $key, bool $is_attribute): void
        {
            $this->attribute_map[$key] = $is_attribute;
        }

        public function add_default_class($class): void
        {
            $current = self::normalize_class_list($this->get('class', []));
            $incoming = self::normalize_class_list($class);
            $this->values['class'] = array_values(array_unique(array_merge($current, $incoming)));
            $this->attribute_map['class'] = true;
        }

        public function has(string $key): bool
        {
            if (!$this->has_key($key)) {
                return false;
            }

            $value = $this->values[$key];
            if ($value === null) {
                return false;
            }

            if (is_string($value) && trim($value) === '') {
                return false;
            }

            if (is_array($value) && $value === []) {
                return false;
            }

            return true;
        }

        public function empty(string $key): bool
        {
            return !$this->has($key);
        }

        public function is(string $key, $expected): bool
        {
            return $this->get($key) === $expected;
        }

        public function get(string $key, $default = '')
        {
            return $this->has_key($key) ? $this->values[$key] : $default;
        }

        public function the_attributes(): void
        {
            echo $this->get_attributes();
        }

        public function get_attributes(): string
        {
            $attrs = [];

            foreach ($this->values as $key => $value) {
                if (($this->attribute_map[$key] ?? true) === false) {
                    continue;
                }

                if ($key === '' || $key[0] === '_') {
                    continue;
                }

                $attrs[$key] = $value;
            }

            return self::build_attribute_string($attrs);
        }

        public function component(string $component_name, string $key): void
        {
            if (!$this->has($key)) {
                return;
            }

            $item = $this->get($key);
            echo $this->render_child_item($item, $component_name);
        }

        public function component_children(string $key): void
        {
            $children = $this->get($key, []);
            if (!is_array($children)) {
                return;
            }

            foreach ($children as $child) {
                echo $this->render_child_item($child);
            }
        }

        public static function build_attribute_string(array $attrs): string
        {
            $output = [];

            foreach ($attrs as $key => $value) {
                if ($value === null || $value === false) {
                    continue;
                }

                $name = trim((string) $key);
                if ($name === '' || !preg_match('/^[a-zA-Z_:][-a-zA-Z0-9_:.]*$/', $name)) {
                    continue;
                }

                if ($name === 'class') {
                    $value = implode(' ', self::normalize_class_list($value));
                }

                if ($name === 'style') {
                    $value = self::normalize_style_value($value);
                }

                if ($value === '' || $value === []) {
                    continue;
                }

                if ($value === true) {
                    $output[] = ' ' . esc_attr($name);
                    continue;
                }

                $output[] = ' ' . esc_attr($name) . '="' . esc_attr((string) $value) . '"';
            }

            return implode('', $output);
        }

        private function has_key(string $key): bool
        {
            return array_key_exists($key, $this->values);
        }

        private static function normalize_class_list($value): array
        {
            $classes = [];

            if (is_string($value)) {
                $value = preg_split('/\s+/', trim($value)) ?: [];
            }

            if (!is_array($value)) {
                return [];
            }

            foreach ($value as $class) {
                if (!is_string($class)) {
                    continue;
                }

                $class = trim($class);
                if ($class !== '') {
                    $classes[] = $class;
                }
            }

            return $classes;
        }

        private static function normalize_style_value($value): string
        {
            if (is_string($value)) {
                return trim($value);
            }

            if (!is_array($value)) {
                return '';
            }

            $styles = [];
            foreach ($value as $property => $style_value) {
                if (!is_string($property)) {
                    continue;
                }

                $property = trim($property);
                if ($property === '') {
                    continue;
                }

                if (is_scalar($style_value)) {
                    $styles[] = $property . ': ' . trim((string) $style_value);
                }
            }

            return implode('; ', $styles);
        }

        private function render_child_item($child, ?string $force_component = null): string
        {
            if ($child instanceof ComponentView) {
                return $child->render();
            }

            if ($child instanceof Closure) {
                $result = $child($this);
                return $this->render_child_item($result, $force_component);
            }

            if (is_string($child)) {
                return $child;
            }

            if (is_array($child)) {
                if ($force_component !== null) {
                    return component($force_component, $child)->render();
                }

                if (!empty($child['component']) && is_string($child['component'])) {
                    $component_name = $child['component'];
                    unset($child['component']);
                    return component($component_name, $child)->render();
                }
            }

            return '';
        }
    }
}

if (!function_exists('component_image_id')) {
    function component_image_id($image): int
    {
        if (is_numeric($image)) {
            return (int) $image;
        }

        if (is_array($image)) {
            if (isset($image['ID']) && is_numeric($image['ID'])) {
                return (int) $image['ID'];
            }

            if (isset($image['id']) && is_numeric($image['id'])) {
                return (int) $image['id'];
            }
        }

        return 0;
    }
}
