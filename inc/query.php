<?php
/**
 * One-off query modifications and manipulations (e.g. through pre_get_posts).
 * Modifications tied to a larger features should reside with the rest of the
 * code for that feature.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Add custom query vars.
 *
 * @param array $vars Array of current query vars.
 * @return array $vars Array of query vars.
 */
function query_vars( $vars ) {
	// Add a query var to enable hot reloading.
	$vars[] = 'civil-first-fleet-dev';
	$vars[] = 'ajax';

	return $vars;
}
add_filter( 'query_vars', __NAMESPACE__ . '\query_vars' );

/**
 * Helper to determine if the request has an ajax query var.
 *
 * @return boolean Is ajax request.
 */
function is_ajax_request() {
	if ( true === (bool) get_query_var( 'ajax' ) ) {
		return true;
	}
	return false;
}

/**
 * Modify the front page query to pull a homepage post.
 *
 * @param  WP_Query $wp_query The global WP_Query.
 */
function modify_front_page( $wp_query ) {
	if (
		$wp_query->is_home()
		&& $wp_query->is_main_query()
		&& ! $wp_query->is_search()
	) {
		$wp_query->set( 'meta_key', 'landing_page_type' );
		$wp_query->set( 'meta_value', 'homepage' );
		$wp_query->set( 'post_status', 'publish' );
		$wp_query->set( 'post_type', 'landing-page' );
		$wp_query->set( 'posts_per_page', 1 );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\modify_front_page' );

/**
 * Modify term archives.
 *
 * @param  WP_Query $wp_query The global WP_Query.
 */
function modify_term_archives( $wp_query ) {
	if (
		! $wp_query->is_home()
		&& ! is_admin()
		&& ! $wp_query->is_author()
		&& $wp_query->is_main_query()
		&& $wp_query->is_archive()
	) {
		// Only get IDs.
		$wp_query->set( 'fields', 'ids' );

		// Is this ajax?
		if ( ! \Civil_First_Fleet\is_ajax_request() ) {
			// First page gets 16 posts in total.
			$wp_query->set( 'posts_per_page', 16 );
		} else {
			// Get current page and adjust for the way WP does it so we can use it
			// for pagination multiplication.
			$page = $wp_query->get( 'paged', 1 );
			$page = 0 === $page ? 1 : $page;
			$page--;

			// Manually calculate pagination using offset. We do this to ignore the
			// first 7 posts, since those are a different component and will screw
			// up the pagination.
			$wp_query->set( 'offset', 7 + ( 9 * $page ) );
			$wp_query->set( 'posts_per_page', 9 );
		}
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\modify_term_archives' );

/**
 * Modify author archives.
 *
 * @param  WP_Query $wp_query The global WP_Query.
 */
function modify_author_archives( $wp_query ) {
	if (
		! $wp_query->is_home()
		&& ! is_admin()
		&& $wp_query->is_author()
		&& $wp_query->is_main_query()
		&& $wp_query->is_archive()
	) {

		$wp_query->set( 'fields', 'ids' );
		$wp_query->set( 'posts_per_page', 9 );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\modify_author_archives' );

/**
 * Modify search query.
 *
 * @param  WP_Query $wp_query The global WP_Query.
 */
function modify_search( $wp_query ) {
	if (
		! $wp_query->is_home()
		&& ! is_admin()
		&& $wp_query->is_main_query()
		&& $wp_query->is_search()
	) {
		$wp_query->set( 'fields', 'ids' );
		$wp_query->set( 'posts_per_page', 9 );
		$wp_query->set( 'paged', get_query_var( 'pagination' ) );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\modify_search' );

/**
 * Setup load more ajax.
 *
 * @param WP_Query $wp_query The global WP_Query.
 */
function load_more( $wp_query ) {

	// Disable theme wrapper and setup stylesheets (without printing <script> tag).
	if ( \Civil_First_Fleet\is_ajax_request() ) {
		add_filter( 'civil_first_fleet_skip_theme_wrapper', '__return_true' );
		\Civil_First_Fleet\Stylesheets::instance()->setup( true );
	}
}
add_action( 'pre_get_posts', __NAMESPACE__ . '\load_more' );
