<?php
/**
 * Search Template.
 *
 * @package Civil_First_Fleet
 */

global $wp_query;

// Output Search Form.
$article_grid = \Civil_First_Fleet\Component\search_form()
	->set_data( 'search_query', get_search_query() )
	->render();

// Output Article Grid.
$article_grid = \Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', 0 )
	->set_data(
		'curate',
		[
			'post_ids' => $wp_query->posts,
		]
	);

// Determine if pagination exists.
$total_pages  = ceil( $wp_query->found_posts / absint( get_query_var( 'posts_per_page', 9 ) ) );
$current_page = absint( get_query_var( 'pagination' ) );
if ( $current_page < $total_pages ) {
	$article_grid->set_setting( 'load_more', true );
}

// Render Article Grid.
$article_grid->render();
