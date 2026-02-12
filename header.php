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

<body <?php body_class('min-h-screen flex flex-col bg-slate-50 text-slate-900'); ?>>
	<?php wp_body_open(); ?>
	<header class="border-b border-slate-200 bg-white/90 backdrop-blur">
		<div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="text-lg font-semibold text-slate-900">
				<?php bloginfo('name'); ?>
			</a>
			<nav aria-label="Primary navigation">
				<?php
				wp_nav_menu([
					'theme_location' => 'primary',
					'container' => false,
					'menu_class' => 'flex gap-6 text-sm font-medium text-slate-700',
					'fallback_cb' => false,
				]);
				?>
			</nav>
		</div>
	</header>
	<main id="primary" class="site-main flex-1">