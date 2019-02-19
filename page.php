<?php
/**
 * Page routing.
 *
 * @package Civil_First_Fleet
 */

while ( have_posts() ) {
	the_post();
	ai_get_template_part(
		'template-parts/page',
		[
			'stylesheet' => 'page-template',
		]
	);
}

