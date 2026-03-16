<?php
/**
 * Card component config.
 *
 * @var ComponentArgs $args
 */

$args->add_option_default('image_size', 'medium_large');
$args->add_option_default('before_title', []);
$args->add_option_default('after_title', []);
$args->add_option_default('actions', []);

$args->mark_as_option('post');
$args->mark_as_option('title');
$args->mark_as_option('description');
$args->mark_as_option('image_id');
$args->mark_as_option('image');
$args->mark_as_option('button');
$args->mark_as_option('before_title');
$args->mark_as_option('after_title');
$args->mark_as_option('actions');
$args->mark_as_option('acf_link');
$args->mark_as_option('image_size');

$post = $args->get('post');
$post_id = 0;

if ($post instanceof WP_Post) {
    $post_id = (int) $post->ID;
}

if (is_numeric($post)) {
    $post_id = (int) $post;
}

if ($post_id > 0) {
    if (!$args->has('href')) {
        $args->set('href', (string) get_permalink($post_id));
    }

    if (!$args->has('title')) {
        $args->set('title', (string) get_the_title($post_id));
    }

    if (!$args->has('description')) {
        $args->set('description', (string) get_the_excerpt($post_id));
    }

    if (!$args->has('image_id')) {
        $args->set('image_id', (int) get_post_thumbnail_id($post_id));
    }
}

$image_id = component_image_id($args->get('image_id'));
if ($image_id === 0) {
    $image_id = component_image_id($args->get('image'));
}
if ($image_id > 0) {
    $args->set('image_id', $image_id);
}

$acf_link = $args->get('acf_link');
if (!$args->has('href') && is_array($acf_link) && !empty($acf_link['url'])) {
    $args->set('href', (string) $acf_link['url']);
}

$button = $args->get('button');
if (is_array($button)) {
    if (empty($button['href']) && $args->has('href')) {
        $button['href'] = (string) $args->get('href');
    }

    if (empty($button['label'])) {
        $button['label'] = __('Read more', 'tailpress');
    }

    $args->set('button', $button);
}

$args->add_default_class('component-card');
