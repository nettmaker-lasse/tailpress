<?php
/**
 * ACF block registration from block.json files.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    add_action('acf/init', static function (): void {
        if (!function_exists('register_block_type')) {
            return;
        }

        $block_metadata_files = glob(TAILPRESS_PATH . '/blocks/*/block.json') ?: [];
        sort($block_metadata_files);

        foreach ($block_metadata_files as $metadata_file) {
            $block_dir = dirname($metadata_file);
            $slug = basename($block_dir);
            $render_file = $block_dir . '/' . $slug . '.php';
            $helper_file = $block_dir . '/' . $slug . '-helper.php';

            if (!file_exists($render_file)) {
                if (defined('WP_DEBUG') && WP_DEBUG) {
                    error_log('TailPress: Missing render template for block ' . $slug);
                }
                continue;
            }

            register_block_type($block_dir, [
                'render_callback' => static function (array $attributes = [], string $content = '', $block_instance = null) use ($slug, $render_file, $helper_file): void {
                    $css_asset = TAILPRESS_PATH . '/dist/styles/' . $slug . '.min.css';
                    $js_asset = TAILPRESS_PATH . '/dist/javascript/' . $slug . '.min.js';

                    if (file_exists($css_asset)) {
                        wp_enqueue_style(
                            'tailpress-block-' . $slug,
                            tailpress_asset_path_to_uri($css_asset),
                            ['tailpress-main'],
                            tailpress_asset_version($css_asset)
                        );
                    }

                    if (file_exists($js_asset)) {
                        wp_enqueue_script(
                            'tailpress-block-' . $slug,
                            tailpress_asset_path_to_uri($js_asset),
                            [],
                            tailpress_asset_version($js_asset),
                            true
                        );
                    }

                    if (file_exists($helper_file)) {
                        include_once $helper_file;
                    }

                    $block = is_object($block_instance) ? (array) $block_instance : [];
                    $is_preview = is_admin();

                    include $render_file;
                },
            ]);
        }
    });
});
