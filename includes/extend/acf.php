<?php
/**
 * ACF integrations.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    $acf_json_path = TAILPRESS_PATH . '/includes/acf-json';

    add_action('admin_notices', static function (): void {
        if (class_exists('ACF')) {
            return;
        }

        echo '<div class="notice notice-warning"><p>';
        echo esc_html__('TailPress requires Advanced Custom Fields Pro for custom blocks.', 'tailpress');
        echo '</p></div>';
    });

    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    if (!is_dir($acf_json_path)) {
        wp_mkdir_p($acf_json_path);
    }

    add_filter('acf/settings/save_json', static function () use ($acf_json_path): string {
        return $acf_json_path;
    });

    add_filter('acf/settings/load_json', static function (array $paths) use ($acf_json_path): array {
        $paths[] = $acf_json_path;
        return array_unique($paths);
    });

    add_filter('acf/json/save_file_name', static function (string $filename, array $post): string {
        if (!empty($post['key']) && strpos($post['key'], 'group_') === 0) {
            return $post['key'] . '.json';
        }

        return $filename;
    }, 10, 2);
});
