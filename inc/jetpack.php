<?php
/**
 * This file holds functions for jetpack sharing overrides.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Disable Jetpack CSS concatenation.
add_filter( 'jetpack_implode_frontend_css', '__return_false' );

/**
 * Remove the Jetpack Sharing and Like buttons.
 */
function remove_jetpack_shares() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	if ( class_exists( '\Jetpack_Likes' ) ) {
		remove_filter( 'the_content', array( \Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
	}
}

add_action( 'loop_start', __NAMESPACE__ . '\remove_jetpack_shares' );

/**
 * Dequeue Jetpack styles.
 */
function deregister_jetpack_styles() {
	wp_deregister_style( 'sharedaddy' );
	wp_deregister_style( 'sharing' );
}

add_action( 'wp_print_styles', __NAMESPACE__ . '\deregister_jetpack_styles', 100 );

// Enable Jetpack Email share.
add_filter( 'sharing_services_email', '__return_true' );

/**
 * Modify available Jetpack modules.
 *
 * @param array $modules Available Jetpack modules.
 * @return array
 */
function jetpack_modify_available_modules( $modules ) {

	$modules_to_disable = [
		'after-the-deadline',
		'carousel',
		'comment-likes',
		'comments',
		'contact-form',
		'custom-content-types',
		'enhanced-distribution',
		'google-analytics',
		'gravatar-hovercards',
		'infinite-scroll',
		'json-api',
		'latex',
		'lazy-images',
		'likes',
		'markdown',
		'masterbar',
		'minileven',
		'notes',
		'post-by-email',
		'protect',
		'publicize',
		'pwa',
		'search',
		'seo-tools',
		'shortcodes',
		'shortlinks',
		'sitemaps',
		'subscriptions',
		'tiled-gallery',
		'videopress',
		'widget-visibility',
		'widgets',
		'wordads',
	];

	foreach ( $modules_to_disable as $module ) {
		if ( isset( $modules[ $module ] ) ) {
			unset( $modules[ $module ] );
		}
	}

	return $modules;
}
add_filter( 'jetpack_get_available_modules', __NAMESPACE__ . '\jetpack_modify_available_modules' );
