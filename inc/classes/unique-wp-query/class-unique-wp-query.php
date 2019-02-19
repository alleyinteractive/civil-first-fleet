<?php
/**
 * Extension of WP_Query.
 *
 * Interacts directly with WP_Query_Manager to ensure only unique posts are
 * ever returned. Use this exactly like WP_Query. The manager class will
 * ensure that duplicate posts are never returned by the query.
 *
 * @package Civil_First_Fleet
 * @version 1.0.0
 */

/**
 * Unique_WP_Query class.
 */
class Unique_WP_Query extends WP_Query {

	/**
	 * Class constructor.
	 *
	 * @param Array $args Query arguments.
	 */
	public function __construct( $args ) {
		// Act as a flag for pre_get_posts.
		$args['unique_wp_query'] = true;

		// Initialize the WP_Query object like normal.
		parent::__construct( $args );

		// Track used posts, and remove duplicates.
		Unique_WP_Query_Manager::process_posts(
			$this->posts,
			$this->post_count,
			$this->get( 'original_posts_per_page' )
		);
	}
}
