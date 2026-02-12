<?php
/**
 * Generic editor preview wrapper for blocks.
 *
 * @var string $title
 * @var string $description
 * @var string $image_url
 *
 * @package TailPress
 */

$title = isset($title) ? (string) $title : __('Block Preview', 'tailpress');
$description = isset($description) ? (string) $description : __('Configure this block to see the final output.', 'tailpress');
$image_url = isset($image_url) ? (string) $image_url : '';
?>
<div class="tailpress-block-preview rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
    <h3 class="m-0 text-lg font-semibold text-slate-900"><?php echo esc_html($title); ?></h3>
    <p class="mt-2 text-sm text-slate-600"><?php echo esc_html($description); ?></p>
    <?php if ($image_url) : ?>
        <img class="mx-auto mt-4 max-w-full rounded-md" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
    <?php endif; ?>
</div>
