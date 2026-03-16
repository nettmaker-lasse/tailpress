# TailPress Component Library

## Purpose
The component runtime provides reusable PHP-rendered UI primitives for custom blocks and templates.

## API

### `component(string $name, array $args = []): ComponentView`
Creates a component view object that can be echoed or rendered.

### `component_print(string $name, array $args = []): void`
Creates and prints a component directly.

### `component_html(string $html): ComponentView`
Wraps trusted/sanitized HTML content as a component view.

## Safety Rules
- Text: escaped with `esc_html()`.
- URLs: escaped with `esc_url()`.
- Attributes: escaped and validated in runtime.
- Rich content: sanitized with `wp_kses_post()`.

## Components

### `button`
Arguments:
- `label` string
- `href` string|null
- `target` string|null
- `rel` string|null
- `variant` string (`primary`, `secondary`, `ghost`)
- `size` string (`sm`, `md`, `lg`)
- `acf_link` array (ACF link field)
- `class` string|array

Example:
```php
<?php echo component('button', [
    'label' => 'Read more',
    'href' => get_permalink(),
    'variant' => 'primary',
]); ?>
```

### `card`
Arguments:
- `post` int|WP_Post (optional defaults)
- `title` string
- `description` string
- `image_id` int
- `image` int|array (ACF image)
- `image_size` string
- `href` string
- `acf_link` array
- `button` array (button args)
- `before_title` array (children)
- `after_title` array (children)
- `actions` array (children)
- `class` string|array

Example:
```php
<?php echo component('card', [
    'post' => get_post(),
    'before_title' => [component_html('<p class="date">Upcoming</p>')],
    'button' => [
        'label' => 'Read more',
    ],
]); ?>
```

### `hero`
Arguments:
- `kicker` string
- `title` string
- `title_level` int
- `description` string (supports rich content)
- `background_image_id` int|array
- `image_id` int|array
- `image` int|array
- `image_size` string
- `align` string (`left`, `center`)
- `actions` array (button configs or ComponentView)
- `class` string|array

Example:
```php
<?php echo component('hero', [
    'kicker' => get_field('kicker'),
    'title' => get_field('title'),
    'description' => get_field('description'),
    'actions' => [
        ['acf_link' => get_field('cta_link')],
    ],
]); ?>
```

### `content`
Arguments:
- `title` string
- `title_level` int
- `intro` string
- `content` string (WYSIWYG/HTML sanitized)
- `actions` array (button configs or ComponentView)
- `class` string|array

Example:
```php
<?php echo component('content', [
    'title' => get_field('title'),
    'intro' => get_field('intro'),
    'content' => get_field('content'),
    'actions' => [
        ['label' => 'Contact us', 'href' => '/contact'],
    ],
]); ?>
```

## Creating New Components
1. Create folder: `partials/components/{name}`.
2. Add `{name}.php` template.
3. Add optional `{name}-config.php` for defaults/normalization.
4. Use `ComponentArgs` helpers (`add_option_default`, `mark_as_option`, `add_default_class`).
5. Keep escaping strict by default.
