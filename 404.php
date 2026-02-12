<?php
/**
 * 404 template.
 *
 * @package TailPress
 */

get_header();
?>
<section class="mx-auto w-full max-w-3xl px-6 py-20 text-center">
    <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">404</p>
    <h1 class="mt-2 text-4xl font-bold text-slate-900"><?php esc_html_e('Page not found', 'tailpress'); ?></h1>
    <p class="mt-4 text-slate-600"><?php esc_html_e('The page you are looking for does not exist or has been moved.', 'tailpress'); ?></p>
    <a class="mt-8 inline-flex rounded-md bg-slate-900 px-5 py-3 text-sm font-medium text-white hover:bg-slate-700" href="<?php echo esc_url(home_url('/')); ?>">
        <?php esc_html_e('Back to home', 'tailpress'); ?>
    </a>
</section>
<?php
get_footer();
