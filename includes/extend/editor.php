<?php
/**
 * Editor customizations.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    // Inject main stylesheet into the editor canvas iframe (WP 6.3+ iframed editor).
    // enqueue_block_editor_assets only reaches the outer admin frame, not the iframe.
    add_action('after_setup_theme', static function (): void {
        add_editor_style(get_template_directory_uri() . '/dist/styles/main.min.css');
    });

    add_action('enqueue_block_editor_assets', static function (): void {
        $style = tailpress_get_dist_asset('dist/styles/main.min.css');

        if ($style) {
            wp_enqueue_style('tailpress-editor', $style['uri'], [], $style['version']);
        }
    });
});
