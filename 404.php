<?php
/**
 * 404 routing.
 *
 * @package Civil_First_Fleet
 */

while ( have_posts() ) {
	the_post();
	ai_get_template_part( 'template-parts/404' );
}
