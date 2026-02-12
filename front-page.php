<?php
/**
 * Front page template.
 *
 * @package TailPress
 */

get_header();
?>
<section class="mx-auto w-full max-w-6xl px-6 py-12">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <?php tailpress_template_router(); ?>
        <?php endwhile; ?>
    <?php endif; ?>
</section>
<?php
get_footer();
