<?php

/**
 * Theme footer template.
 *
 * @package TailPress
 */
?>
</main>
<?php
$social_icon_allowed_html = [
	'svg' => [
		'viewBox' => true,
		'aria-hidden' => true,
		'xmlns' => true,
	],
	'path' => [
		'd' => true,
		'fill' => true,
	],
];
?>
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
				'icon' => tailpress_get_inline_svg('assets/images/icon-facebook.svg'),
			],
			'linkedin' => [
				'url' => get_field('social_linkedin', 'option'),
				'label' => __('LinkedIn', 'tailpress'),
				'icon' => tailpress_get_inline_svg('assets/images/icon-linkedin.svg'),
			],
			'instagram' => [
				'url' => get_field('social_ig', 'option'),
				'label' => __('Instagram', 'tailpress'),
				'icon' => tailpress_get_inline_svg('assets/images/icon-instagram.svg'),
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
							<?php echo wp_kses((string) $social['icon'], $social_icon_allowed_html); ?>
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
