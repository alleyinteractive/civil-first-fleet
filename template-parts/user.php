<?php
/**
 * User Archive Template.
 *
 * @package Civil_First_Fleet
 */

global $wp_query;

\Civil_First_Fleet\Component\article_bylines()
	->set_setting( 'layout', 'full' )
	->render();

printf(
	'<h2 class="%1$s">%2$s %3$s</h2>',
	esc_attr( ai_get_classnames( [ 'heading' ] ) ),
	esc_html__( 'Articles By', 'civil-first-fleet' ),
	esc_html( get_the_author_meta( 'display_name' ) )
);

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
$current_page = absint( get_query_var( 'paged', 1 ) );
if ( 0 === $current_page ) {
	$current_page = 1;
}
if ( $current_page < $total_pages ) {
	$article_grid->set_setting( 'load_more', true );
}

// Render Article Grid.
$article_grid->render();
