<?php
/**
 * Term Archive Template.
 *
 * @package Civil_First_Fleet
 */

global $wp_query;

printf(
	'<h1 class="archive-header">%1$s</h1>',
	esc_html( get_queried_object()->name )
);

// Output Featured Articles.
\Civil_First_Fleet\Component\featured_articles()
	->set_setting( 'items', 0 )
	->set_data(
		'curate',
		[
			'post_ids' => array_slice( $wp_query->posts, 0, 7 ),
		]
	)
	->render();

// Output Article Grid.
$article_grid = \Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', 0 )
	->set_data(
		'curate',
		[
			'post_ids' => array_slice( $wp_query->posts, 7 ),
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
