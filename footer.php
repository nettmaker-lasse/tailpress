<?php

/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
</main>
<footer class="site-footer mt-auto border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-950">
	<div class="mx-auto w-full max-w-6xl px-6 py-12 text-center">
		<nav class="footer-nav" aria-label="<?php esc_attr_e('Footer navigation', 'tailpress'); ?>">
			<?php
			wp_nav_menu([
				'theme_location' => 'footer',
				'container' => false,
				'menu_class' => 'footer-menu',
				'fallback_cb' => false,
				'depth' => 1,
			]);
			?>
		</nav>

		<?php
		$social_links = [
			'facebook' => [
				'url' => get_field('social_fb', 'option'),
				'label' => __('Facebook', 'tailpress'),
				'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 21v-8h2.7l.4-3h-3.1V8.1c0-.9.3-1.6 1.6-1.6h1.7V3.8c-.3 0-1.3-.1-2.5-.1-2.5 0-4.1 1.5-4.1 4.3V10H7.5v3h2.7v8h3.3z"/></svg>',
			],
			'linkedin' => [
				'url' => get_field('social_linkedin', 'option'),
				'label' => __('LinkedIn', 'tailpress'),
				'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.9 8.5a1.9 1.9 0 1 1 0-3.8 1.9 1.9 0 0 1 0 3.8zM5.3 20.2h3.2V9.9H5.3v10.3zM10.6 9.9v10.3h3.2v-5.7c0-1.5.3-3 2.2-3 1.8 0 1.8 1.7 1.8 3.1v5.6H21V14c0-3-1.6-4.4-3.8-4.4-1.8 0-2.6 1-3 1.7V9.9h-3.6z"/></svg>',
			],
			'instagram' => [
				'url' => get_field('social_ig', 'option'),
				'label' => __('Instagram', 'tailpress'),
				'icon' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 7.1a4.9 4.9 0 1 0 0 9.8 4.9 4.9 0 0 0 0-9.8zm0 8.1a3.2 3.2 0 1 1 0-6.4 3.2 3.2 0 0 1 0 6.4zM17.2 6.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2z"/><path d="M12 2.8c3 0 3.4 0 4.6.1 1 .1 1.6.2 2 .4.6.2 1 .4 1.5.9.4.4.7.8.9 1.5.2.5.3 1 .4 2 .1 1.2.1 1.6.1 4.6s0 3.4-.1 4.6c-.1 1-.2 1.6-.4 2-.2.6-.4 1-.9 1.5-.4.4-.8.7-1.5.9-.5.2-1 .3-2 .4-1.2.1-1.6.1-4.6.1s-3.4 0-4.6-.1c-1-.1-1.6-.2-2-.4a3.7 3.7 0 0 1-1.5-.9 3.7 3.7 0 0 1-.9-1.5c-.2-.5-.3-1-.4-2-.1-1.2-.1-1.6-.1-4.6s0-3.4.1-4.6c.1-1 .2-1.6.4-2 .2-.6.4-1 .9-1.5.4-.4.8-.7 1.5-.9.5-.2 1-.3 2-.4 1.2-.1 1.6-.1 4.6-.1zm0-1.8c-3 0-3.5 0-4.7.1-1.2.1-2 .3-2.7.6-.8.3-1.5.7-2.2 1.4C1.7 3.8 1.3 4.4 1 5.2c-.3.8-.5 1.5-.6 2.7C.3 9.1.3 9.6.3 12.6s0 3.5.1 4.7c.1 1.2.3 2 .6 2.7.3.8.7 1.5 1.4 2.2.7.7 1.3 1.1 2.2 1.4.8.3 1.5.5 2.7.6 1.2.1 1.7.1 4.7.1s3.5 0 4.7-.1c1.2-.1 2-.3 2.7-.6.8-.3 1.5-.7 2.2-1.4.7-.7 1.1-1.3 1.4-2.2.3-.8.5-1.5.6-2.7.1-1.2.1-1.7.1-4.7s0-3.5-.1-4.7c-.1-1.2-.3-2-.6-2.7-.3-.8-.7-1.5-1.4-2.2-.7-.7-1.3-1.1-2.2-1.4-.8-.3-1.5-.5-2.7-.6C15.5 1 15 1 12 1z"/></svg>',
			],
		];
		$active_socials = array_filter($social_links, static fn(array $item): bool => !empty($item['url']));
		?>

		<?php if (!empty($active_socials)) : ?>
			<ul class="footer-socials" aria-label="<?php esc_attr_e('Social links', 'tailpress'); ?>">
				<?php foreach ($active_socials as $social) : ?>
					<li>
						<a href="<?php echo esc_url((string) $social['url']); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer">
							<span class="sr-only"><?php echo esc_html((string) $social['label']); ?></span>
							<?php echo wp_kses((string) $social['icon'], ['svg' => ['viewBox' => true, 'aria-hidden' => true], 'path' => ['d' => true]]); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<p class="footer-copy text-sm text-slate-600 dark:text-slate-400">&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('All rights reserved.', 'tailpress'); ?></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
