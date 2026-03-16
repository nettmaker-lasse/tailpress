<?php
/**
 * Hero component template.
 *
 * @var ComponentArgs $args
 */

$title = (string) $args->get('title', '');
$kicker = (string) $args->get('kicker', '');
$description = (string) $args->get('description', '');
$title_level = (int) $args->get('title_level', 1);
$title_level = max(1, min(6, $title_level));
$heading_tag = 'h' . $title_level;
$image_id = (int) $args->get('image_id', 0);
$image_size = (string) $args->get('image_size', 'full');
$actions = $args->get('actions', []);
?>
<section<?php $args->the_attributes(); ?>>
    <div class="component-hero__inner">
        <?php if ($kicker !== '') : ?>
            <p class="component-hero__kicker"><?php echo esc_html($kicker); ?></p>
        <?php endif; ?>

        <?php if ($title !== '') : ?>
            <<?php echo esc_html($heading_tag); ?> class="component-hero__title"><?php echo esc_html($title); ?></<?php echo esc_html($heading_tag); ?>>
        <?php endif; ?>

        <?php if ($description !== '') : ?>
            <div class="component-hero__description"><?php echo wp_kses_post($description); ?></div>
        <?php endif; ?>

        <?php if (is_array($actions) && $actions !== []) : ?>
            <div class="component-hero__actions inline-flex gap-2 mt-2">
                <?php foreach ($actions as $action) : ?>
                    <?php
                    if ($action instanceof ComponentView) {
                        echo $action;
                        continue;
                    }

                    if (is_array($action)) {
                        echo component('button', $action);
                    }
                    ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($image_id > 0) : ?>
            <figure class="component-hero__media">
                <?php echo wp_get_attachment_image($image_id, $image_size, false, ['loading' => 'lazy']); ?>
            </figure>
        <?php endif; ?>
    </div>
</section>
