<?php

/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
</main>
<footer class="mt-auto border-t border-slate-200 bg-white">
	<div class="mx-auto w-full max-w-6xl px-6 py-8 text-sm text-slate-600">
		<p>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>