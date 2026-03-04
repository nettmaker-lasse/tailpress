<?php
/**
 * Theme setup and supports.
 *
 * @package TailPress
 */

add_action('tailpress/init', static function (): void {
    add_action('after_setup_theme', static function (): void {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('editor-styles');
        add_theme_support('html5', ['search-form', 'gallery', 'caption', 'comment-form', 'comment-list', 'style', 'script']);

        register_nav_menus([
            'primary' => __('Primary Menu', 'tailpress'),
            'footer' => __('Footer Menu', 'tailpress'),
        ]);

        add_editor_style('dist/styles/main.min.css');
    });

    add_action('admin_menu', static function (): void {
        remove_submenu_page('themes.php', 'theme-editor.php');
    }, 999);

    add_action('admin_init', static function (): void {
        global $pagenow;

        if ($pagenow !== 'theme-editor.php') {
            return;
        }

        wp_safe_redirect(admin_url('themes.php'));
        exit;
    });
});
