<?php
/**
 * Homepage routing.
 *
 * @package Civil_First_Fleet
 */

$modifier = '';

if ( ! have_posts() ) {
	$modifier = 'error';
} elseif ( true === (bool) get_query_var( 'ajax' ) ) {
	$modifier = 'ajax';
}

ai_get_template_part(
	'template-parts/homepage',
	$modifier,
	[
		'homepage_id' => get_the_ID(),
	]
);
