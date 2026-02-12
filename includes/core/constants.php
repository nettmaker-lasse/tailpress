<?php
/**
 * Theme constants.
 *
 * @package TailPress
 */

if (!defined('TAILPRESS_VERSION')) {
    $theme = wp_get_theme();
    define('TAILPRESS_VERSION', $theme->get('Version') ?: '1.0.0');
}

if (!defined('TAILPRESS_PATH')) {
    define('TAILPRESS_PATH', get_template_directory());
}

if (!defined('TAILPRESS_URI')) {
    define('TAILPRESS_URI', get_template_directory_uri());
}

if (!defined('TAILPRESS_DIST_PATH')) {
    define('TAILPRESS_DIST_PATH', TAILPRESS_PATH . '/dist');
}

if (!defined('TAILPRESS_DIST_URI')) {
    define('TAILPRESS_DIST_URI', TAILPRESS_URI . '/dist');
}
