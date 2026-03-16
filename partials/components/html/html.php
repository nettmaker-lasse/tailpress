<?php
/**
 * Trusted HTML component.
 *
 * @var ComponentArgs $args
 */

if (!$args->has('content')) {
    return;
}

echo wp_kses_post((string) $args->get('content'));
