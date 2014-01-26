<?php
/*
Plugin Name: WordPress SEO Weight Loss Program
Description: Lose some of the fat that comes from eating Yoast's spam sandwich.
Version: 1.0.0
Author: John Parris
Author URI: http://www.johnparris.com/
License: GPLv2
*/

function jp_wpseo_fat_slicer() {

	// Only do this for users who don't have Editor capabilities
	if ( ! current_user_can( 'edit_others_posts' ) ) {

		add_action( 'add_meta_boxes', 'jp_remove_yoast_metabox', 99 );
		add_filter( 'wp_before_admin_bar_render', 'jp_admin_bar_seo_cleanup' );
		add_filter( 'manage_edit-post_columns', 'jp_remove_columns' );
		add_filter( 'manage_edit-page_columns', 'jp_remove_columns' );
		// add_filter( 'manage_edit-CPTNAME_columns', 'jp_remove_columns' ); // Replace CPTNAME with your custom post type name, for example "restaurants".
	}
}
add_action( 'init', 'jp_wpseo_fat_slicer' );



/**
 * Removes the WordPress SEO meta box from posts and pages
 *
 * @since 1.0.0
 * @uses remove_meta_box()
 */
function jp_remove_yoast_metabox() {

	$post_types = array( 'page', 'post' ); // add any custom post types here

	foreach( $post_types as $post_type ) {
		remove_meta_box( 'wpseo_meta', $post_type, 'normal' );
	}
}



/**
 * Removes the SEO item from the admin bar
 *
 * @since 1.0.0
 * @uses remove_menu
 */
function jp_admin_bar_seo_cleanup() {

	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'wpseo-menu' );
}



/**
 * Removes the extra columns on the post/page listing screens.
 *
 * @since 1.0.0
 */
function jp_remove_columns( $columns ) {

	unset( $columns['wpseo-score'] );
	unset( $columns['wpseo-title'] );
	unset( $columns['wpseo-metadesc'] );
	unset( $columns['wpseo-focuskw'] );

	return $columns;
}
