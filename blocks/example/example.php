<?php
/**
 * Example block renderer.
 *
 * Variables available:
 * - array $attributes
 * - string $content
 * - array $block
 * - bool $is_preview
 *
 * @package TailPress
 */

?>
<?php
$example_title = get_field('example_title') ?: __('Example block heading', 'tailpress');
$example_description = get_field('example_description') ?: __('This block follows the new TailPress block.json contract.', 'tailpress');

$hero = component('hero', [
    'class' => ['tailpress-example__hero', 'rounded-xl', 'border', 'border-slate-200', 'p-8', 'shadow-sm'],
    'kicker' => __('Component Library', 'tailpress'),
    'title' => $example_title,
    'description' => wpautop(esc_html($example_description)),
    'align' => 'left',
    'actions' => [
        [
            'label' => __('Primary action', 'tailpress'),
            'href' => '#',
            'variant' => 'primary',
        ],
        [
            'label' => __('Secondary action', 'tailpress'),
            'href' => '#',
            'variant' => 'secondary',
        ],
    ],
]);

$content_component = component('content', [
    'class' => ['tailpress-example__content', 'mt-8', 'rounded-xl', 'border', 'border-slate-200', 'p-6'],
    'title' => __('Content Component', 'tailpress'),
    'intro' => __('Reusable rich text section with optional actions.', 'tailpress'),
    'content' => wpautop(__('Use this component for body copy in custom blocks. It supports safe rich text rendering and CTA actions.', 'tailpress')),
    'actions' => [
        [
            'label' => __('Read documentation', 'tailpress'),
            'href' => '#',
            'variant' => 'ghost',
        ],
    ],
]);

$card_component = component('card', [
    'class' => ['tailpress-example__card', 'mt-8', 'rounded-xl', 'border', 'border-slate-200', 'p-6'],
    'title' => __('Card Component', 'tailpress'),
    'description' => __('Cards can render title, description, optional media, and a nested button.', 'tailpress'),
    'before_title' => [
        component_html('<p class="text-xs uppercase tracking-wide text-slate-500">' . esc_html__('Component demo', 'tailpress') . '</p>'),
    ],
    'button' => [
        'label' => __('Read more', 'tailpress'),
        'href' => '#',
        'variant' => 'primary',
    ],
]);

$button_component = component('button', [
    'class' => ['mt-8'],
    'label' => __('Standalone Button Component', 'tailpress'),
    'href' => '#',
    'variant' => 'secondary',
    'size' => 'md',
]);
?>

<section class="tailpress-example mx-auto w-full max-w-6xl py-10">
    <?php echo $hero; ?>
    <?php echo $content_component; ?>
    <?php echo $card_component; ?>
    <div class="mt-4">
        <?php echo $button_component; ?>
    </div>
</section>
