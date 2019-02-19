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
					'name'                  => __( 'Landing Pages', 'civil-cms' ),
					'singular_name'         => __( 'Landing Page', 'civil-cms' ),
					'add_new'               => __( 'Add New Landing Page', 'civil-cms' ),
					'add_new_item'          => __( 'Add New Landing Page', 'civil-cms' ),
					'edit_item'             => __( 'Edit Landing Page', 'civil-cms' ),
					'new_item'              => __( 'New Landing Page', 'civil-cms' ),
					'view_item'             => __( 'View Landing Page', 'civil-cms' ),
					'view_items'            => __( 'View Landing Pages', 'civil-cms' ),
					'search_items'          => __( 'Search Landing Pages', 'civil-cms' ),
					'not_found'             => __( 'No landing pages found', 'civil-cms' ),
					'not_found_in_trash'    => __( 'No landing pages found in Trash', 'civil-cms' ),
					'parent_item_colon'     => __( 'Parent Landing Page:', 'civil-cms' ),
					'all_items'             => __( 'All Landing Pages', 'civil-cms' ),
					'archives'              => __( 'Landing Page Archives', 'civil-cms' ),
					'attributes'            => __( 'Landing Page Attributes', 'civil-cms' ),
					'insert_into_item'      => __( 'Insert into landing page', 'civil-cms' ),
					'uploaded_to_this_item' => __( 'Uploaded to this landing page', 'civil-cms' ),
					'filter_items_list'     => __( 'Filter landing pages list', 'civil-cms' ),
					'items_list_navigation' => __( 'Landing Pages list navigation', 'civil-cms' ),
					'items_list'            => __( 'Landing Pages list', 'civil-cms' ),
					'menu_name'             => __( 'Landing Pages', 'civil-cms' ),
				],
				'public' => true,
				'show_in_rest' => true,
				'menu_icon' => 'dashicons-layout',
				'supports' => [ 'title', 'revisions' ],
			]
		);
	}
}
$civil_cms_post_type_landing_page = new Civil_Cms_Post_Type_Landing_Page();
