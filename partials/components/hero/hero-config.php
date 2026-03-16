<?php
/**
 * Hero component config.
 *
 * @var ComponentArgs $args
 */

$args->add_option_default('align', 'left');
$args->add_option_default('title_level', 1);
$args->add_option_default('image_size', 'full');
$args->add_option_default('actions', []);

$args->mark_as_option('kicker');
$args->mark_as_option('title');
$args->mark_as_option('description');
$args->mark_as_option('title_level');
$args->mark_as_option('background_image_id');
$args->mark_as_option('image_id');
$args->mark_as_option('image');
$args->mark_as_option('image_size');
$args->mark_as_option('actions');
$args->mark_as_option('align');

$hero_image_id = component_image_id($args->get('image_id'));
if ($hero_image_id === 0) {
    $hero_image_id = component_image_id($args->get('image'));
}
if ($hero_image_id > 0) {
    $args->set('image_id', $hero_image_id);
}

$background_image_id = component_image_id($args->get('background_image_id'));
if ($background_image_id > 0) {
    $bg_url = wp_get_attachment_image_url($background_image_id, 'full');
    if (is_string($bg_url) && $bg_url !== '') {
        $existing_style = trim((string) $args->get('style', ''));
        $bg_style = 'background-image: url(' . esc_url_raw($bg_url) . ')';
        $args->set('style', trim($existing_style . '; ' . $bg_style, '; '));
    }
}

$args->add_default_class([
    'component-hero',
    'component-hero--align-' . sanitize_html_class((string) $args->get('align')),
]);
