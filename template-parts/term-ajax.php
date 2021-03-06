<?php
/**
 * Term Archive Template (for AJAX).
 *
 * @package Civil_First_Fleet
 */

global $wp_query;

// Output Article Grid.
\Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', 0 )
	->set_data(
		'curate',
		[
			'post_ids' => $wp_query->posts,
		]
	)
	->render();
