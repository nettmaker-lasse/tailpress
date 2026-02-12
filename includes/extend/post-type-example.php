<?php

namespace TailPress\PostType\Example;

const POSTTYPE = 'sample-post-type';

function create() {
	register_post_type( POSTTYPE,
		array(
			/* 'labels' => array(
				'name' => __( 'SamplePostTypes', 'reactor' ),
				'menu_name' => __( 'SamplePostTypes', 'reactor' ),
				'singular_name' => __( 'SamplePostType', 'reactor' ),
				'add_new' => __( 'Add SamplePostType', 'reactor' ),
				'add_new_item' => __( 'Add new SamplePostType', 'reactor' ),
				'edit_item' => __( 'Edit SamplePostType', 'reactor' ),
				'new_item' => __( 'New SamplePostType', 'reactor' ),
				'view_item' => __( 'View SamplePostType', 'reactor' ),
				'search_items' => __( 'Search SamplePostType', 'reactor' ),
				'not_found' => __( 'No SamplePostTypes found', 'reactor' ),
				'not_found_in_trash' => __( 'No SamplePostTypes found in trash', 'reactor' ),
			), */
			'label' => 'Example',
			'public' => true,
			'show_ui' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'sample-post-type' ),
			'menu_position' => 25,
			'show_in_menu' => true,
			'supports' => array( 'title' ),
			'menu_icon' => 'dashicons-archive', // Check out https://developer.wordpress.org/resource/dashicons/
		)
	);
}
// add_action( 'init', __NAMESPACE__ . '\create' );

function get_posts( array $args = [] ) {
	$args = array_merge( array(
		'post_type' => POSTTYPE,
	), $args );

	return \get_posts( $args );
}
