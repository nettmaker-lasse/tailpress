<?php
/**
 * Main template file.
 *
 * @package TailPress
 */

get_header();
?>
<section class="mx-auto w-full max-w-6xl px-6 py-12">
    <?php if (have_posts()) : ?>
        <div class="space-y-10">
            <?php while (have_posts()) : the_post(); ?>
                <?php tailpress_template_router(); ?>
            <?php endwhile; ?>
        </div>
        <div class="mt-8">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <p><?php esc_html_e('No posts found.', 'tailpress'); ?></p>
    <?php endif; ?>
</section>
<?php
get_footer();
