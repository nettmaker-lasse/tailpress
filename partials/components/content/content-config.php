<?php
/**
 * Content component config.
 *
 * @var ComponentArgs $args
 */

$args->add_option_default('title_level', 2);
$args->add_option_default('actions', []);

$args->mark_as_option('title');
$args->mark_as_option('intro');
$args->mark_as_option('content');
$args->mark_as_option('title_level');
$args->mark_as_option('actions');

$args->add_default_class('component-content');
