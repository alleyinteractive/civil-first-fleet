<?php
/**
 * Class file for WP_Utils.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

/**
 * WordPress-specific helpers.
 */
class WP_Utils {
	/**
	 * Whether we're DOING_AUTOSAVE.
	 *
	 * @return bool
	 */
	public static function doing_autosave() {
		return ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE );
	}

	/**
	 * Whether this is VIP.
	 *
	 * @return bool
	 */
	public static function is_vip_env() {
		return ( defined( 'WPCOM_IS_VIP_ENV' ) && WPCOM_IS_VIP_ENV );
	}

	/**
	 * Whether something is a \WP_Post.
	 *
	 * @param mixed $thing Thing to check.
	 * @return bool
	 */
	public static function is_wp_post( $thing ) {
		return ( $thing instanceof \WP_Post );
	}

	/**
	 * Whether something is a \WP_Query.
	 *
	 * @param mixed $thing Thing to check.
	 * @return bool
	 */
	public static function is_wp_query( $thing ) {
		return ( $thing instanceof \WP_Query );
	}

	/**
	 * Whether something is a \WP_Term.
	 *
	 * @param mixed $thing Thing to check.
	 * @return bool
	 */
	public static function is_wp_term( $thing ) {
		return ( $thing instanceof \WP_Term );
	}

	/**
	 * Whether something is a \WP_User.
	 *
	 * @param mixed $thing Thing to check.
	 * @return bool
	 */
	public static function is_wp_user( $thing ) {
		return ( $thing instanceof \WP_User );
	}

	/**
	 * Sanitize a 'posts_per_page' value to help avoid nonperformant queries.
	 *
	 * @param int $value The value to sanitize.
	 * @return int Value between 1 and 100.
	 */
	public static function sanitize_posts_per_page( $value ) {
		return max( 1, min( 100, intval( $value ) ) );
	}

	/**
	 * Whether this is a WP_CLI session.
	 *
	 * @return bool
	 */
	public static function wp_cli() {
		return ( defined( 'WP_CLI' ) && WP_CLI );
	}

	/**
	 * Get the currently global $wp_query.
	 *
	 * @return mixed A query, in theory.
	 */
	public static function wp_query() {
		global $wp_query;
		return $wp_query;
	}

	/**
	 * Get the currently global $wp_the_query.
	 *
	 * @return mixed *The* query, in theory.
	 */
	public static function wp_the_query() {
		global $wp_the_query;
		return $wp_the_query;
	}
}
