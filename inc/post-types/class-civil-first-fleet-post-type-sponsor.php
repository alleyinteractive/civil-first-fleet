<?php
/**
 * Custom post type for Sponsors
 *
 * @package Civil_First_Fleet
 */

/**
 * Class for the sponsor post type.
 */
class Civil_First_Fleet_Post_Type_Sponsor extends Civil_First_Fleet_Post_Type {

	/**
	 * Name of the custom post type.
	 *
	 * @var string
	 */
	public $name = 'sponsor';

	/**
	 * Creates the post type.
	 */
	public function create_post_type() {
		register_post_type(
			$this->name,
			[
				'labels'             => [
					'name'                     => __( 'Sponsors', 'civil-first-fleet' ),
					'singular_name'            => __( 'Sponsor', 'civil-first-fleet' ),
					'add_new'                  => __( 'Add New Sponsor', 'civil-first-fleet' ),
					'add_new_item'             => __( 'Add New Sponsor', 'civil-first-fleet' ),
					'edit_item'                => __( 'Edit Sponsor', 'civil-first-fleet' ),
					'new_item'                 => __( 'New Sponsor', 'civil-first-fleet' ),
					'view_item'                => __( 'View Sponsor', 'civil-first-fleet' ),
					'view_items'               => __( 'View Sponsors', 'civil-first-fleet' ),
					'search_items'             => __( 'Search Sponsors', 'civil-first-fleet' ),
					'not_found'                => __( 'No sponsors found', 'civil-first-fleet' ),
					'not_found_in_trash'       => __( 'No sponsors found in Trash', 'civil-first-fleet' ),
					'parent_item_colon'        => __( 'Parent Sponsor:', 'civil-first-fleet' ),
					'all_items'                => __( 'All Sponsors', 'civil-first-fleet' ),
					'archives'                 => __( 'Sponsor Archives', 'civil-first-fleet' ),
					'attributes'               => __( 'Sponsor Attributes', 'civil-first-fleet' ),
					'insert_into_item'         => __( 'Insert into sponsor', 'civil-first-fleet' ),
					'uploaded_to_this_item'    => __( 'Uploaded to this sponsor', 'civil-first-fleet' ),
					'featured_image'           => __( 'Featured Image', 'civil-first-fleet' ),
					'set_featured_image'       => __( 'Set featured image', 'civil-first-fleet' ),
					'remove_featured_image'    => __( 'Remove featured image', 'civil-first-fleet' ),
					'use_featured_image'       => __( 'Use as featured image', 'civil-first-fleet' ),
					'filter_items_list'        => __( 'Filter sponsors list', 'civil-first-fleet' ),
					'items_list_navigation'    => __( 'Sponsors list navigation', 'civil-first-fleet' ),
					'items_list'               => __( 'Sponsors list', 'civil-first-fleet' ),
					'item_published'           => __( 'Sponsor published.', 'civil-first-fleet' ),
					'item_published_privately' => __( 'Sponsor published privately.', 'civil-first-fleet' ),
					'item_reverted_to_draft'   => __( 'Sponsor reverted to draft.', 'civil-first-fleet' ),
					'item_scheduled'           => __( 'Sponsor scheduled.', 'civil-first-fleet' ),
					'item_updated'             => __( 'Sponsor updated.', 'civil-first-fleet' ),
					'menu_name'                => __( 'Sponsors', 'civil-first-fleet' ),
				],
				'public'             => true,
				'show_in_rest'       => true,
				'publicly_queryable' => false,
				'menu_icon'          => 'dashicons-groups',
				'supports'           => [ 'title' ],
			]
		);
	}

	/**
	 * Set post type updated messages.
	 *
	 * The messages are as follows:
	 *
	 *   1 => "Post updated. {View Post}"
	 *   2 => "Custom field updated."
	 *   3 => "Custom field deleted."
	 *   4 => "Post updated."
	 *   5 => "Post restored to revision from [date]."
	 *   6 => "Post published. {View post}"
	 *   7 => "Post saved."
	 *   8 => "Post submitted. {Preview post}"
	 *   9 => "Post scheduled for: [date]. {Preview post}"
	 *  10 => "Post draft updated. {Preview post}"
	 *
	 * (Via https://github.com/johnbillion/extended-cpts.)
	 *
	 * @param array $messages An associative array of post updated messages with post type as keys.
	 * @return array Updated array of post updated messages.
	 */
	public function set_post_updated_messages( $messages ) {
		global $post;

		$preview_url    = get_preview_post_link( $post );
		$permalink      = get_permalink( $post );
		$scheduled_date = date_i18n( 'M j, Y @ H:i', strtotime( $post->post_date ) );

		$preview_post_link_html   = '';
		$scheduled_post_link_html = '';
		$view_post_link_html      = '';

		if ( is_post_type_viewable( $this->name ) ) {
			// Preview-post link.
			$preview_post_link_html = sprintf(
				' <a target="_blank" href="%1$s">%2$s</a>',
				esc_url( $preview_url ),
				__( 'Preview sponsor', 'civil-first-fleet' )
			);

			// Scheduled post preview link.
			$scheduled_post_link_html = sprintf(
				' <a target="_blank" href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				__( 'Preview sponsor', 'civil-first-fleet' )
			);

			// View-post link.
			$view_post_link_html = sprintf(
				' <a href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				__( 'View sponsor', 'civil-first-fleet' )
			);
		}

		$messages[ $this->name ] = [
			1  => __( 'Sponsor updated.', 'civil-first-fleet' ) . $view_post_link_html,
			2  => __( 'Custom field updated.', 'civil-first-fleet' ),
			3  => __( 'Custom field updated.', 'civil-first-fleet' ),
			4  => __( 'Sponsor updated.', 'civil-first-fleet' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Sponsor restored to revision from %s.', 'civil-first-fleet' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			6  => __( 'Sponsor published.', 'civil-first-fleet' ) . $view_post_link_html,
			7  => __( 'Sponsor saved.', 'civil-first-fleet' ),
			8  => __( 'Sponsor submitted.', 'civil-first-fleet' ) . $preview_post_link_html,
			/* translators: %s: date on which the sponsor is currently scheduled to be published */
			9  => sprintf( __( 'Sponsor scheduled for: %s.', 'civil-first-fleet' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_post_link_html,
			10 => __( 'Sponsor draft updated.', 'civil-first-fleet' ) . $preview_post_link_html,
		];

		return $messages;
	}
}
$civil_first_fleet_post_type_sponsor = new Civil_First_Fleet_Post_Type_Sponsor();
