<?php
/**
 * Static page content partial.
 *
 * @package TailPress
 */
?>
<article <?php post_class('tailpress-page-content'); ?>>
    <div class="prose max-w-none prose-slate">
        <?php the_content(); ?>
    </div>
</article>
