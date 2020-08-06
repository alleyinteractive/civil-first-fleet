<?php
/**
 * Landing page helpers.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Return a list of landing page types.
 *
 * @return array Landing page types.
 */
function get_landing_page_types() : array {
	return [
		'homepage' => __( 'Homepage', 'civil-first-fleet' ),
	];
}

/**
 * Return FM fields for the homepage landing page type.
 *
 * @return array FM fields.
 */
function get_homepage_fields() : array {
	return [
		'featured_articles' => Component\featured_articles(
			[
				'label' => __( 'Featured Articles', 'civil-first-fleet' ),
				'items' => 7,
			]
		)->get_fm_group(),
		'call_to_action_1' => Component\call_to_action(
			[
				'label' => __( 'Call To Action (below featured articles)', 'civil-first-fleet' ),
			]
		)->get_fm_group(),
		'middle_feature' => Component\middle_feature(
			[
				'label' => __( 'Middle Feature', 'civil-first-fleet' ),
				'items' => 4,
			]
		)->get_fm_group(),
		'articles_grid' => Component\content_list(
			[
				'label' => __( 'Articles Grid', 'civil-first-fleet' ),
				'items' => 7,
			]
		)
		->remove_fm_field( 'meta' )
		->remove_fm_field( 'curate' )
		->get_fm_group(),
		'call_to_action_2' => Component\call_to_action(
			[
				'label' => __( 'Call To Action (below article grid)', 'civil-first-fleet' ),
			]
		)->get_fm_group(),
		'featured_image' => new \Fieldmanager_Group(
			[
				'label' => __( 'Featured Image', 'civil-first-fleet' ),
				'children' => [
					'image' => new \Fieldmanager_Media(
						[
							'label'              => __( 'Featured Image', 'civil-first-fleet' ),
							'button_label'       => __( 'Select featured image', 'civil-first-fleet' ),
							'preview_size'       => 'card',
							'modal_button_label' => __( 'Use featured image', 'civil-first-fleet' ),
							'modal_title'        => __( 'Featured Image', 'civil-first-fleet' ),
						]
					),
				],
			]
		),
	];
}

/**
 * Get the post id of the newest published `landing-page` by type.
 *
 * @param string $type Type of landing page.
 * @return integer Landing page ID.
 */
function get_landing_page_id( $type = 'homepage' ) {
	$landing_page = new \WP_Query(
		[
			'meta_key'       => 'landing_page_type',
			'meta_value'     => 'homepage',
			'post_status'    => 'publish',
			'post_type'      => 'landing-page',
			'posts_per_page' => 1,
		]
	);

	return $landing_page->posts[0]->ID ?? 0;
}

/**
 * Return whether or not the current page is a landing page.
 *
 * @return bool
 */
function is_landing_page() {
	return is_front_page() ||
		'landing-page' === get_post_type() ||
		'homepage' === get_query_var( 'dispatch' );
}
