<?php
/**
 * Homepage Template (for AJAX).
 *
 * @package Civil_First_Fleet
 */

// Get settings for this homepage.
$homepage_id  = absint( ai_get_var( 'homepage_id' ) );
$homepage     = get_post_meta( $homepage_id, 'homepage', true );
$hide_sidebar = (bool) $homepage['featured_articles']['meta']['hide_sidebar'] ?? false;

// Replicate code ran on homepage to account for curated ids and backfill.
\Civil_First_Fleet\Component\featured_articles()
	->set_setting( 'items', $hide_sidebar ? 1 : 7 )
	->data( $homepage['featured_articles'] ?? [] )
	->get_content_items();

// Replicate code ran on homepage to account for curated ids and backfill.
\Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', 9 )
	->data( $homepage['articles_grid'] ?? [] )
	->get_content_items();

// Run the pagination query directly.
$query_args = [
	'fields'         => 'ids',
	'paged'          => absint( get_query_var( 'pagination', 1 ) ) - 1,
	'post__not_in'   => Unique_WP_Query_Manager::$used_post_ids,
	'post_status'    => 'publish',
	'post_type'      => 'post',
	'posts_per_page' => 9,
];

// Apply the articles_grid filters to the query being ran.
$query_args = \Civil_First_Fleet\Component\content_list()
	->apply_query_filters(
		$query_args,
		$homepage['articles_grid']['filters']['filter']
	);

// Execute query.
$paginated_posts = new \WP_Query( $query_args );

// Reset post_ids so we can use it again but not be stuck with the same ids.
$homepage['articles_grid']['curate']['post_ids'] = [];

// Output grid with query results.
\Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', count( $paginated_posts->posts ) )
	->set_data(
		'curate',
		[
			'post_ids' => $paginated_posts->posts,
		]
	)
	->render();
