<?php
/**
 * TailPress includes
 *
 * Choose which directories should get loaded, and in which order.
 * By default the core is loaded first and then extended with site
 * specific functionality.
 */
$boot_sequence = [
    'includes/core/*.php',
    'includes/extend/*.php',
];

foreach ($boot_sequence as $path) {
    $includes = glob(get_template_directory() . '/' . $path) ?: [];
    sort($includes);

    foreach ($includes as $entry) {
        include_once $entry;
    }
}

do_action('tailpress/init');
