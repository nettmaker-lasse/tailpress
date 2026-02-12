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

$heading = get_field('heading') ?: __('Example block heading', 'tailpress');
$text = get_field('text') ?: __('This block follows the new TailPress block.json contract.', 'tailpress');
?>
<section class="tailpress-example mx-auto w-full max-w-6xl py-10">
    <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900"><?php echo esc_html($heading); ?></h2>
        <p class="mt-4 text-slate-600"><?php echo esc_html($text); ?></p>
    </div>
</section>
