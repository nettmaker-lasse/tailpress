<?php
/**
 * Editor customizations.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    add_action('enqueue_block_editor_assets', static function (): void {
        $style = tailpress_get_dist_asset('dist/styles/main.min.css');

        if ($style) {
            wp_enqueue_style('tailpress-editor', $style['uri'], [], $style['version']);
        }
    });
});
