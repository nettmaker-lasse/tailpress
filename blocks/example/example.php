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
<section class="tailpress-example mx-auto w-full max-w-6xl py-10">
    <div class="lg:bg-slate-100 rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:bg-slate-800">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white"><?php echo esc_html( get_field('example_title') ?: __('Example block heading', 'tailpress') ); ?></h2>
        <p class="mt-4 text-slate-800 dark:text-slate-300"><?php echo esc_html( get_field('example_description') ?: __('This block follows the new TailPress block.json contract.', 'tailpress') ); ?></p>
    </div>
</section>
