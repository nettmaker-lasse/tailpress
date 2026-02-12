<?php
/**
 * Frontend/editor asset loading.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    add_action('wp_enqueue_scripts', static function (): void {
        $style = tailpress_get_dist_asset('dist/styles/main.min.css');
        if ($style) {
            wp_enqueue_style('tailpress-main', $style['uri'], [], $style['version']);
        }

        $script = tailpress_get_dist_asset('dist/javascript/main.min.js');
        if ($script) {
            wp_enqueue_script('tailpress-main', $script['uri'], [], $script['version'], true);
        }
    });
});
