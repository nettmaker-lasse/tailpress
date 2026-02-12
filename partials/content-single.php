<?php
/**
 * Single content partial fallback.
 *
 * @package TailPress
 */
?>
<article <?php post_class('rounded-xl bg-white p-8 shadow-sm ring-1 ring-slate-200'); ?>>
    <header class="mb-6">
        <h1 class="text-4xl font-bold tracking-tight text-slate-900"><?php the_title(); ?></h1>
    </header>
    <div class="prose max-w-none prose-slate">
        <?php the_content(); ?>
    </div>
</article>
