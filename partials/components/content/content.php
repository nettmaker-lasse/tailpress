<?php
/**
 * Content component template.
 *
 * @var ComponentArgs $args
 */

$title = (string) $args->get('title', '');
$intro = (string) $args->get('intro', '');
$content = (string) $args->get('content', '');
$title_level = (int) $args->get('title_level', 2);
$title_level = max(1, min(6, $title_level));
$heading_tag = 'h' . $title_level;
$actions = $args->get('actions', []);
?>
<section<?php $args->the_attributes(); ?>>
    <?php if ($title !== '') : ?>
        <<?php echo esc_html($heading_tag); ?> class="component-content__title"><?php echo esc_html($title); ?></<?php echo esc_html($heading_tag); ?>>
    <?php endif; ?>

    <?php if ($intro !== '') : ?>
        <p class="component-content__intro"><?php echo esc_html($intro); ?></p>
    <?php endif; ?>

    <?php if ($content !== '') : ?>
        <div class="component-content__body"><?php echo wp_kses_post($content); ?></div>
    <?php endif; ?>

    <?php if (is_array($actions) && $actions !== []) : ?>
        <div class="component-content__actions mt-2">
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

    <?php $args->component_children('children'); ?>
</section>
