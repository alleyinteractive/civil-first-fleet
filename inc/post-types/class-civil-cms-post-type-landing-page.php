<?php
/**
 * Custom post type for Landing Pages
 *
 * @package Civil_First_Fleet
 */

/**
 * Class for the landing-page post type.
 */
class Civil_Cms_Post_Type_Landing_Page extends Civil_Cms_Post_Type {

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
				'labels' => [
					'name'                  => __( 'Landing Pages', 'civil-first-fleet' ),
					'singular_name'         => __( 'Landing Page', 'civil-first-fleet' ),
					'add_new'               => __( 'Add New Landing Page', 'civil-first-fleet' ),
					'add_new_item'          => __( 'Add New Landing Page', 'civil-first-fleet' ),
					'edit_item'             => __( 'Edit Landing Page', 'civil-first-fleet' ),
					'new_item'              => __( 'New Landing Page', 'civil-first-fleet' ),
					'view_item'             => __( 'View Landing Page', 'civil-first-fleet' ),
					'view_items'            => __( 'View Landing Pages', 'civil-first-fleet' ),
					'search_items'          => __( 'Search Landing Pages', 'civil-first-fleet' ),
					'not_found'             => __( 'No landing pages found', 'civil-first-fleet' ),
					'not_found_in_trash'    => __( 'No landing pages found in Trash', 'civil-first-fleet' ),
					'parent_item_colon'     => __( 'Parent Landing Page:', 'civil-first-fleet' ),
					'all_items'             => __( 'All Landing Pages', 'civil-first-fleet' ),
					'archives'              => __( 'Landing Page Archives', 'civil-first-fleet' ),
					'attributes'            => __( 'Landing Page Attributes', 'civil-first-fleet' ),
					'insert_into_item'      => __( 'Insert into landing page', 'civil-first-fleet' ),
					'uploaded_to_this_item' => __( 'Uploaded to this landing page', 'civil-first-fleet' ),
					'filter_items_list'     => __( 'Filter landing pages list', 'civil-first-fleet' ),
					'items_list_navigation' => __( 'Landing Pages list navigation', 'civil-first-fleet' ),
					'items_list'            => __( 'Landing Pages list', 'civil-first-fleet' ),
					'menu_name'             => __( 'Landing Pages', 'civil-first-fleet' ),
				],
				'public' => true,
				'show_in_rest' => true,
				'menu_icon' => 'dashicons-layout',
				'supports' => [ 'title', 'revisions' ],
			]
		);
	}
}
$civil_first_fleet_post_type_landing_page = new Civil_Cms_Post_Type_Landing_Page();
