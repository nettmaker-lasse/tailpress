<?php

/**
 * Theme header template.
 *
 * @package TailPress
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class('min-h-screen flex flex-col bg-white text-slate-900'); ?>>
	<?php wp_body_open(); ?>
	<header class="site-header border-b border-slate-200 bg-white/90 backdrop-blur">
			<div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-semibold text-slate-900">
					<?php bloginfo('name'); ?>
				</a>
				<button type="button" class="menu-toggle lg:hidden" aria-controls="site-menu" aria-expanded="false">
					<span class="sr-only"><?php esc_html_e('Open menu', 'tailpress'); ?></span>
					<span class="menu-toggle-icon" aria-hidden="true"></span>
				</button>
				<nav id="site-menu" class="site-menu-overlay" aria-label="<?php esc_attr_e('Primary navigation', 'tailpress'); ?>" data-menu-open="false">
					<div class="site-menu-panel h-screen">
						<div class="site-menu-header lg:hidden">
							<a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-semibold text-slate-900">
								<?php bloginfo('name'); ?>
							</a>
							<button type="button" class="menu-close" aria-controls="site-menu" aria-expanded="false">
								<span class="sr-only"><?php esc_html_e('Close menu', 'tailpress'); ?></span>
								<span class="menu-close-icon" aria-hidden="true"></span>
							</button>
						</div>
						<?php
						wp_nav_menu([
							'theme_location' => 'primary',
							'container' => false,
							'menu_class' => 'site-menu-list',
							'fallback_cb' => false,
							'depth' => 3,
							'walker' => new TailPress_Nav_Walker(),
						]);
						?>
					</div>
				</nav>
			</div>
		</header>
	<main id="primary" class="site-main flex-1">
