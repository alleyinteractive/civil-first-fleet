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
				'labels' => [
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
				'public' => true,
				'show_in_rest' => true,
				'publicly_queryable' => false,
				'menu_icon' => 'dashicons-groups',
				'supports' => [ 'title' ],
			]
		);
	}
}
$civil_first_fleet_post_type_sponsor = new Civil_First_Fleet_Post_Type_Sponsor();
