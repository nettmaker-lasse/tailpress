<?php
/**
 * Button component template.
 *
 * @var ComponentArgs $args
 */

$label = $args->get('label', '');
if (!is_string($label) || trim($label) === '') {
    return;
}

if ($args->has('href')) :
?>
    <a<?php $args->the_attributes(); ?> href="<?php echo esc_url((string) $args->get('href')); ?>">
        <?php echo esc_html($label); ?>
    </a>
<?php else : ?>
    <button<?php $args->the_attributes(); ?> type="<?php echo esc_attr((string) $args->get('type', 'button')); ?>">
        <?php echo esc_html($label); ?>
    </button>
<?php endif; ?>
