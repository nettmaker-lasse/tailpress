<?php
/**
 * Card component template.
 *
 * @var ComponentArgs $args
 */

$title = (string) $args->get('title', '');
$description = (string) $args->get('description', '');
$image_id = (int) $args->get('image_id', 0);
$image_size = (string) $args->get('image_size', 'medium_large');
?>
<article<?php $args->the_attributes(); ?>>
    <?php if ($image_id > 0) : ?>
        <figure class="component-card__media">
            <?php echo wp_get_attachment_image($image_id, $image_size, false, ['loading' => 'lazy']); ?>
        </figure>
    <?php endif; ?>

    <div class="component-card__body">
        <?php $args->component_children('before_title'); ?>

        <?php if ($title !== '') : ?>
            <h3 class="component-card__title">
                <?php if ($args->has('href')) : ?>
                    <a href="<?php echo esc_url((string) $args->get('href')); ?>"><?php echo esc_html($title); ?></a>
                <?php else : ?>
                    <?php echo esc_html($title); ?>
                <?php endif; ?>
            </h3>
        <?php endif; ?>

        <?php $args->component_children('after_title'); ?>

        <?php if ($description !== '') : ?>
            <p class="component-card__description"><?php echo esc_html($description); ?></p>
        <?php endif; ?>

        <?php if (is_array($args->get('button'))) : ?>
            <div class="component-card__button mt-2">
                <?php echo component('button', (array) $args->get('button')); ?>
            </div>
        <?php endif; ?>

        <?php $args->component_children('actions'); ?>
    </div>
</article>
