<?php
/**
 * Custom post type for Landing Pages
 *
 * @package Civil_First_Fleet
 */

/**
 * Class for the landing-page post type.
 */
class Civil_First_Fleet_Post_Type_Landing_Page extends Civil_First_Fleet_Post_Type {

	/**
	 * Name of the custom post type.
	 *
	 * @var string
	 */
	public $name = 'landing-page';

	/**
	 * Creates the post type.
	 */
	public function create_post_type() {
		register_post_type(
			$this->name,
			[
				'labels'       => [
					'name'                     => __( 'Landing Pages', 'civil-first-fleet' ),
					'singular_name'            => __( 'Landing Page', 'civil-first-fleet' ),
					'add_new'                  => __( 'Add New Landing Page', 'civil-first-fleet' ),
					'add_new_item'             => __( 'Add New Landing Page', 'civil-first-fleet' ),
					'edit_item'                => __( 'Edit Landing Page', 'civil-first-fleet' ),
					'new_item'                 => __( 'New Landing Page', 'civil-first-fleet' ),
					'view_item'                => __( 'View Landing Page', 'civil-first-fleet' ),
					'view_items'               => __( 'View Landing Pages', 'civil-first-fleet' ),
					'search_items'             => __( 'Search Landing Pages', 'civil-first-fleet' ),
					'not_found'                => __( 'No landing pages found', 'civil-first-fleet' ),
					'not_found_in_trash'       => __( 'No landing pages found in Trash', 'civil-first-fleet' ),
					'parent_item_colon'        => __( 'Parent Landing Page:', 'civil-first-fleet' ),
					'all_items'                => __( 'All Landing Pages', 'civil-first-fleet' ),
					'archives'                 => __( 'Landing Page Archives', 'civil-first-fleet' ),
					'attributes'               => __( 'Landing Page Attributes', 'civil-first-fleet' ),
					'insert_into_item'         => __( 'Insert into landing page', 'civil-first-fleet' ),
					'uploaded_to_this_item'    => __( 'Uploaded to this landing page', 'civil-first-fleet' ),
					'featured_image'           => __( 'Featured Image', 'civil-first-fleet' ),
					'set_featured_image'       => __( 'Set featured image', 'civil-first-fleet' ),
					'remove_featured_image'    => __( 'Remove featured image', 'civil-first-fleet' ),
					'use_featured_image'       => __( 'Use as featured image', 'civil-first-fleet' ),
					'filter_items_list'        => __( 'Filter landing pages list', 'civil-first-fleet' ),
					'items_list_navigation'    => __( 'Landing Pages list navigation', 'civil-first-fleet' ),
					'items_list'               => __( 'Landing Pages list', 'civil-first-fleet' ),
					'item_published'           => __( 'Landing Page published.', 'civil-first-fleet' ),
					'item_published_privately' => __( 'Landing Page published privately.', 'civil-first-fleet' ),
					'item_reverted_to_draft'   => __( 'Landing Page reverted to draft.', 'civil-first-fleet' ),
					'item_scheduled'           => __( 'Landing Page scheduled.', 'civil-first-fleet' ),
					'item_updated'             => __( 'Landing Page updated.', 'civil-first-fleet' ),
					'menu_name'                => __( 'Landing Pages', 'civil-first-fleet' ),
				],
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-layout',
				'supports'     => [ 'title', 'revisions' ],
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
				__( 'Preview landing page', 'civil-first-fleet' )
			);

			// Scheduled post preview link.
			$scheduled_post_link_html = sprintf(
				' <a target="_blank" href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				__( 'Preview landing page', 'civil-first-fleet' )
			);

			// View-post link.
			$view_post_link_html = sprintf(
				' <a href="%1$s">%2$s</a>',
				esc_url( $permalink ),
				__( 'View landing page', 'civil-first-fleet' )
			);
		}

		$messages[ $this->name ] = [
			1  => __( 'Landing Page updated.', 'civil-first-fleet' ) . $view_post_link_html,
			2  => __( 'Custom field updated.', 'civil-first-fleet' ),
			3  => __( 'Custom field updated.', 'civil-first-fleet' ),
			4  => __( 'Landing Page updated.', 'civil-first-fleet' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Landing Page restored to revision from %s.', 'civil-first-fleet' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			6  => __( 'Landing Page published.', 'civil-first-fleet' ) . $view_post_link_html,
			7  => __( 'Landing Page saved.', 'civil-first-fleet' ),
			8  => __( 'Landing Page submitted.', 'civil-first-fleet' ) . $preview_post_link_html,
			/* translators: %s: date on which the landing page is currently scheduled to be published */
			9  => sprintf( __( 'Landing Page scheduled for: %s.', 'civil-first-fleet' ), '<strong>' . $scheduled_date . '</strong>' ) . $scheduled_post_link_html,
			10 => __( 'Landing Page draft updated.', 'civil-first-fleet' ) . $preview_post_link_html,
		];

		return $messages;
	}
}
$civil_first_fleet_post_type_landing_page = new Civil_First_Fleet_Post_Type_Landing_Page();
