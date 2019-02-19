<?php
/**
 * Custom rewrite modifications
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Custom rewrites using the Path_Dispatch class
 */
function dispatch_rewrites() {
	\path_dispatch()->add_path(
		[
			'path'     => 'homepage',
			'rewrite'  => array(
				'rule'       => 'page/([0-9]+)/?',
				'redirect'   => 'index.php?dispatch=homepage&pagination=$matches[1]',
				'query_vars' => 'pagination',
			),
		]
	);
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\dispatch_rewrites' );

/**
 * Redirect some pagination results that aren't using AJAX.
 */
function disable_non_ajax_pagination() {

	// Disable non-ajax pagination.
	if (
		! \Civil_First_Fleet\is_ajax_request()
		&& ( is_archive() || is_search() )
		&& 1 <= get_query_var( 'paged' )
	) {
		$queried_object = get_queried_object();

		// Just switch anyway. This is more readable than a bunch of ifs.
		switch ( true ) {
			case $queried_object instanceof \WP_Term:
				$redirect_url = get_term_link( $queried_object, $queried_object->taxonomy );
				wp_safe_redirect( esc_url( $redirect_url ), 301 );
				exit();

			case $queried_object instanceof \WP_User:
				$redirect_url = get_author_posts_url( $queried_object->ID, $queried_object->data->user_nicename );
				wp_safe_redirect( esc_url( $redirect_url ), 301 );
				exit();

			case ! empty( get_query_var( 's' ) ):
				$redirect_url = add_query_arg(
					's',
					get_query_var( 's' ),
					home_url()
				);
				wp_safe_redirect( esc_url( $redirect_url ), 301 );
				exit();
		}
	}
}
add_action( 'template_redirect', __NAMESPACE__ . '\disable_non_ajax_pagination' );
