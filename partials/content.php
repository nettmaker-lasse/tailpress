<?php
/**
 * Fallback content partial.
 *
 * @package TailPress
 */
?>
<article <?php post_class('rounded-xl bg-white p-8 shadow-sm ring-1 ring-slate-200'); ?>>
    <header class="mb-4">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900">
            <a href="<?php the_permalink(); ?>" class="hover:text-blue-600"><?php the_title(); ?></a>
        </h2>
    </header>
    <div class="prose max-w-none prose-slate">
        <?php the_excerpt(); ?>
    </div>
</article>
