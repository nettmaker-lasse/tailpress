<?php
/**
 * Button component config.
 *
 * @var ComponentArgs $args
 */

$args->add_option_default('variant', 'primary');
$args->add_option_default('size', 'md');
$args->add_option_default('type', 'button');

$args->mark_as_option('label');
$args->mark_as_option('acf_link');
$args->mark_as_option('variant');
$args->mark_as_option('size');
$args->mark_as_option('href');
$args->mark_as_option('type');

$acf_link = $args->get('acf_link');
if (is_array($acf_link)) {
    if (!$args->has('href') && !empty($acf_link['url'])) {
        $args->set('href', (string) $acf_link['url']);
    }

    if (!$args->has('label') && !empty($acf_link['title'])) {
        $args->set('label', (string) $acf_link['title']);
    }

    if (!$args->has('target') && !empty($acf_link['target'])) {
        $args->set('target', (string) $acf_link['target']);
    }
}

if ($args->get('target') === '_blank') {
    $rel = trim((string) $args->get('rel', ''));
    $tokens = preg_split('/\s+/', $rel) ?: [];
    $tokens = array_filter($tokens, static fn($token): bool => $token !== '');

    foreach (['noopener', 'noreferrer'] as $required_token) {
        if (!in_array($required_token, $tokens, true)) {
            $tokens[] = $required_token;
        }
    }

    $args->set('rel', implode(' ', $tokens));
}

$args->add_default_class([
    'component-button',
    'component-button--' . sanitize_html_class((string) $args->get('variant')),
    'component-button--' . sanitize_html_class((string) $args->get('size')),
	'p-2 inline-flex bg-slate-950 !no-underline dark:bg-white dark:!text-slate-950 border rounded-lg !text-white dark:hover:bg-slate-950 dark:hover:border dark:hover:border-white dark:hover:!text-white hover:border hover:border-slate-950 hover:!text-slate-950 hover:bg-white'
]);
