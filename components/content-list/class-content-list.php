<?php
/**
 * Content List component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Content List component class.
 */
class Content_List extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'content-list';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return wp_parse_args(
			[
				'label'         => __( 'Component List', 'civil-first-fleet' ),
				'items'         => 3,
				'paged'         => 1,
				'post_types'    => [
					'post',
				],
				'post__not_in' => [],
				'load_more'    => false,
			], parent::default_settings()
		);
	}

	/**
	 * Placeholder function that gets overridden by children classes.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'meta'     => [
				'title'     => '',
				'permalink' => '',
				'cta_text'  => '',
				'cta_url'   => '',
			],
			'curate' => [
				'post_ids' => [],
			],
			'filters' => [
				'filter' => [],
			],
		];
	}

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		return array(
			'meta' => new \Fieldmanager_Group(
				[
					'label' => __( 'Settings', 'civil-first-fleet' ),
					'collapsed' => true,
					'children' => [
						'title'     => new \Fieldmanager_Textfield( __( 'Title', 'civil-first-fleet' ) ),
						'permalink' => new \Fieldmanager_Link( __( 'Link', 'civil-first-fleet' ) ),
						'cta_text'  => new \Fieldmanager_Textfield( __( 'CTA Text', 'civil-first-fleet' ) ),
						'cta_url'   => new \Fieldmanager_Link( __( 'CTA URL', 'civil-first-fleet' ) ),
					],
				]
			),
			'curate' => new \Fieldmanager_Group(
				[
					'label'     => __( 'Curate Posts', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'post_ids'  => new \Fieldmanager_Zone_Field(
							array(
								'post_limit'     => absint( $this->setting( 'items' ) ),
								'query_args'     => [
									'post_type'  => (array) $this->setting( 'post_types' ),
								],
							)
						),
					],
				]
			),
			'filters' => new \Fieldmanager_Group(
				[
					'label' => __( 'Content Filters (Max of 3)', 'civil-first-fleet' ),
					'collapsed' => true,
					'children' => [
						'filter' => new \Fieldmanager_Group(
							[
								'children'       => $this->get_filters(),
								'label'          => __( 'Blank Filter', 'civil-first-fleet' ),
								'label_macro'    => array( '%s', 'type' ),
								'limit'          => 3,
								'minimum_count'  => 3,
								'sortable'       => false,
								'group_is_empty' => function( $values ) {
									$type = $values['type'] ?? '';
									if ( empty( $type ) ) {
										return true;
									}
									return false;
								},
							]
						),
					],
				]
			),
		);
	}

	/**
	 * Get filter options.
	 *
	 * @return array Filter options.
	 */
	public function get_filter_options() {
		return [
			'post_type' => __( 'Filter by Post Type', 'civil-first-fleet' ),
			'category'  => __( 'Filter by a Category', 'civil-first-fleet' ),
			'post_tag'  => __( 'Filter by a Tag', 'civil-first-fleet' ),
		];
	}

	/**
	 * Get filter fm fields for this component.
	 *
	 * @return array Filter FM fields.
	 */
	public function get_filters() {
		return [
			'type' => new \Fieldmanager_Select(
				[
					'first_empty' => true,
					'options' => $this->get_filter_options(),
				]
			),
			'post_type' => new \Fieldmanager_Select(
				array(
					'multiple' => true,
					'first_empty' => false,
					'attributes' => [
						'size' => 5,
					],
					'options' => [
						'post' => __( 'Posts', 'civil-first-fleet' ),
					],
					'display_if' => [
						'src' => 'type',
						'value' => 'post_type',
					],
				)
			),
			'category_id' => new \Fieldmanager_Select(
				array(
					'datasource' => new \Fieldmanager_Datasource_Term(
						array(
							'taxonomy' => 'category',
						)
					),
					'display_if' => [
						'src' => 'type',
						'value' => 'category',
					],
				)
			),
			'post_tag_id' => new \Fieldmanager_Select(
				array(
					'datasource' => new \Fieldmanager_Datasource_Term(
						array(
							'taxonomy' => 'post_tag',
						)
					),
					'display_if' => [
						'src' => 'type',
						'value' => 'post_tag',
					],
				)
			),
		];
	}

	/**
	 * Content items based on current component state.
	 *
	 * @return array Array of component items.
	 */
	public function get_content_items() {

		// Vars needed to get content items.
		$post_ids         = (array) $this->get_data( 'curate', 'post_ids' );
		$total_ids_needed = absint( $this->get_setting( 'items' ) );

		// Add curated IDs to the used list.
		\Unique_WP_Query_Manager::set_used_post_ids(
			array_merge(
				\Unique_WP_Query_Manager::$used_post_ids,
				$post_ids
			)
		);

		// Do we need backfill post ids?
		if ( count( $post_ids ) < $total_ids_needed ) {
			$backfill_post_ids = $this->get_backfill_post_ids( $total_ids_needed - count( $post_ids ) );

			// Merge backfill post ids.
			if ( ! empty( $backfill_post_ids ) ) {
				$post_ids = array_merge( $post_ids, $backfill_post_ids );
			}
		}

		if ( empty( $post_ids ) ) {
			return array();
		}

		// Build an array of content_items based on the post_ids.
		return array_filter(
			array_map(
				function( $post_id ) {
						return \Civil_First_Fleet\Component\content_item()->set_post_id( absint( $post_id ) );
				}, $post_ids
			)
		);
	}

	/**
	 * Get backfill post ids.
	 *
	 * @param  int $posts_required Number of posts required to backfill.
	 * @return array Array of post ids.
	 */
	public function get_backfill_post_ids( int $posts_required ) {
		$component_filters = $this->get_data( 'filters', 'filter' );

		// Build default query args.
		$query_args = [
			'fields'         => 'ids',
			'meta_query'     => [],
			'paged'          => $this->get_setting( 'paged' ),
			'post_status'    => 'publish',
			'post_type'      => [], // Set to an empty array to make filtering easier.
			'post__not_in'  => $this->get_setting( 'post__not_in' ),
			'posts_per_page' => $posts_required,
		];

		$query_args = $this->apply_query_filters( $query_args, (array) $component_filters );

		// Execute query to ensure no duplicates are found.
		$query = new \Unique_WP_Query( $query_args );

		if ( $query->found_posts > $this->get_setting( 'items' ) ) {
			$this->set_setting( 'load_more', true );
		}

		// Return posts ids.
		return $query->posts;
	}

	/**
	 * Apply component filters to an array of query arguments.
	 *
	 * @param  array $query_args        Query args.
	 * @param  array $component_filters Component filters.
	 * @return array
	 */
	public function apply_query_filters( $query_args, $component_filters ) {

		// Loop through component filters.
		foreach ( (array) array_filter( (array) $component_filters ) as $filter ) {

			// Ensure all expected filter fields are available.
			$filter = wp_parse_args( $filter, array_keys( $this->get_filter_options() ) );

			// Different action required for each filter.
			switch ( $filter['type'] ) {

				// Filter by post type(s).
				case 'post_type':
					$query_args['post_type'] = array_merge( $query_args['post_type'], $filter['post_type'] );
					break;

				// Filter by category taxonomy.
				case 'category':
					if ( 0 !== absint( $filter['category_id'] ) ) {
						$query_args['tax_query'][] = [
							'taxonomy' => 'category',
							'field'    => 'category_id',
							'terms'    => $filter['category_id'],
						];
					}
					break;

				// Filter by post_tag taxonomy.
				case 'post_tag':
					if ( 0 !== absint( $filter['post_tag_id'] ) ) {
						$query_args['tax_query'][] = [
							'taxonomy' => 'post_tag',
							'field'    => 'post_tag_id',
							'terms'    => $filter['post_tag_id'],
						];
					}
					break;
			}
		}

		// If `post_type` is empty, it was not affected by the custom filters,
		// so use component default.
		if ( empty( $query_args['post_type'] ) ) {
			$query_args['post_type'] = $this->setting( 'post_types' );
		}

		return $query_args;
	}

	/**
	 * Get the ids of the content items.
	 *
	 * @return array Content IDs.
	 */
	public function get_content_item_ids() {
		$items = $this->get_content_items();
		if ( empty( $items ) ) {
			return [];
		}

		// Map the IDs.
		return array_map(
			function( $item ) {
				return $item->get_data( 'post_id' );
			},
			$items
		);
	}

	/**
	 * Load Jetpack's related posts for this content item.
	 *
	 * @param  int $items How many posts to get.
	 * @param  int $post_id Post to get related posts for.
	 * @return Content_List  An instance of this component.
	 */
	public function load_jetpack_related_posts( int $items, int $post_id ) {
		$this->data( 'items', absint( $items ) );

		if (
			class_exists( 'Jetpack_RelatedPosts' )
			&& method_exists( 'Jetpack_RelatedPosts', 'init_raw' )
		) {
			$related = (array) Jetpack_RelatedPosts::init_raw()
				->get_for_post_id(
					$post_id,
					[
						'size' => absint( $items ),
					]
				);

			if ( ! empty( $related ) ) {
				$ids = wp_list_pluck( $related, 'id' );

				$this->set_data(
					'curate',
					[
						'post_ids' => (array) $ids,
					]
				);
			}
		}

		// Related posts need backfill.
		if ( count( $this->get_data( 'curate', 'post_ids' ) ?? 0 ) < $this->data( 'items' ) ) {

			// Add curated IDs to the used list.
			\Unique_WP_Query_Manager::set_used_post_ids(
				array_merge(
					\Unique_WP_Query_Manager::$used_post_ids,
					[ $post_id ]
				)
			);

			// Get IDs.
			$backfill_post_ids = $this->get_backfill_post_ids( $this->data( 'items' ) );
			$this->set_data(
				'curate',
				[
					'post_ids' => (array) $backfill_post_ids,
				]
			);
		}

		return $this;
	}

	/**
	 * Render the content items returned by `$this->get_content_items()`.
	 */
	public function render_content_items() {
		foreach ( (array) $this->get_content_items() as $content_item ) {
			$content_item->render();
		}
	}

	/**
	 * Render load more button
	 */
	public function render_load_more() {
		if ( true === $this->get_setting( 'load_more' ) ) {
			\ai_get_template_part(
				"{$this->path}/content-list/template-parts/load-more-button",
				[
					'stylesheet' => 'content-list',
				]
			);
		}
	}

	/**
	 * Render load more button
	 *
	 * @param string $additional_classnames Classes to add to the load more wrapper.
	 */
	public function open_load_more_wrapper( $additional_classnames = '' ) {
		printf(
			'<div class="%1$s %2$s">',
			esc_attr( ai_get_classnames( [ 'load-more-wrapper' ], [], 'content-list' ) ),
			esc_attr( $additional_classnames )
		);
	}

	/**
	 * Render load more button
	 */
	public function close_load_more_wrapper() {
		echo '</div>';
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings  Instance settings.
 * @param  array $data      Instance data.
 * @param  array $fm_fields Instance FM fields.
 * @return Content_List  An instance of this component.
 */
function content_list( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Content_List {
	return new Content_List( $settings, $data );
}
