<?php
/**
 * Homepage routing.
 *
 * @package Civil_First_Fleet
 */

switch ( get_post_type( get_the_ID() ) ) {
	case 'landing-page':
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
		break;

	case 'page':
	default:
		while ( have_posts() ) {
			the_post();
			ai_get_template_part(
				'template-parts/page',
				[
					'stylesheet' => 'page-template',
				]
			);
		}
		break;
}
