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

<body <?php body_class('min-h-screen flex flex-col bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100'); ?>>
	<?php wp_body_open(); ?>
	<header class="site-header border-b border-slate-200 bg-white/90 backdrop-blur dark:border-slate-800 dark:bg-slate-950/90">
		<div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-semibold text-slate-900 dark:text-slate-100">
				<?php bloginfo('name'); ?>
			</a>
			<div class="flex items-center gap-3">
				<button type="button" class="menu-toggle lg:hidden" aria-controls="site-menu" aria-expanded="false">
					<span class="sr-only"><?php esc_html_e('Open menu', 'tailpress'); ?></span>
					<span class="menu-toggle-icon" aria-hidden="true"></span>
				</button>
				<nav id="site-menu" class="site-menu-overlay" aria-label="<?php esc_attr_e('Primary navigation', 'tailpress'); ?>" data-menu-open="false">
					<div class="site-menu-panel h-screen">
						<div class="site-menu-header lg:hidden">
							<a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-semibold text-slate-900 dark:text-slate-100">
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
				<button type="button" class="theme-toggle hidden lg:inline-flex cursor-pointer" data-theme-toggle aria-pressed="false">
					<span class="sr-only"><?php esc_html_e('Toggle dark mode', 'tailpress'); ?></span>
					<span class="theme-toggle-icon" aria-hidden="true">
						<svg class="theme-icon-sun" viewBox="0 0 28 28" fill="none">
							<circle cx="14" cy="14" r="3.5" stroke="currentColor"></circle>
							<path d="M14 8.5V6.5" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M17.889 10.1115L19.3032 8.69727" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M19.5 14L21.5 14" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M17.889 17.8885L19.3032 19.3027" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M14 21.5V19.5" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M8.69663 19.3029L10.1108 17.8887" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M6.5 14L8.5 14" stroke="currentColor" stroke-linecap="round"></path>
							<path d="M8.69663 8.69711L10.1108 10.1113" stroke="currentColor" stroke-linecap="round"></path>
						</svg>
						<svg class="theme-icon-moon" viewBox="0 0 28 28" fill="none">
							<path d="M10.5 9.99914C10.5 14.1413 13.8579 17.4991 18 17.4991C19.0332 17.4991 20.0176 17.2902 20.9132 16.9123C19.7761 19.6075 17.109 21.4991 14 21.4991C9.85786 21.4991 6.5 18.1413 6.5 13.9991C6.5 10.8902 8.39167 8.22304 11.0868 7.08594C10.7089 7.98159 10.5 8.96597 10.5 9.99914Z" stroke="currentColor" stroke-linejoin="round"></path>
							<path d="M16.3561 6.50754L16.5 5.5L16.6439 6.50754C16.7068 6.94752 17.0525 7.29321 17.4925 7.35607L18.5 7.5L17.4925 7.64393C17.0525 7.70679 16.7068 8.05248 16.6439 8.49246L16.5 9.5L16.3561 8.49246C16.2932 8.05248 15.9475 7.70679 15.5075 7.64393L14.5 7.5L15.5075 7.35607C15.9475 7.29321 16.2932 6.94752 16.3561 6.50754Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
							<path d="M20.3561 11.5075L20.5 10.5L20.6439 11.5075C20.7068 11.9475 21.0525 12.2932 21.4925 12.3561L22.5 12.5L21.4925 12.6439C21.0525 12.7068 20.7068 13.0525 20.6439 13.4925L20.5 14.5L20.3561 13.4925C20.2932 13.0525 19.9475 12.7068 19.5075 12.6439L18.5 12.5L19.5075 12.3561C19.9475 12.2932 20.2932 11.9475 20.3561 11.5075Z" fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
						</svg>
					</span>
				</button>
			</div>
		</div>
	</header>
	<main id="primary" class="site-main flex-1">
