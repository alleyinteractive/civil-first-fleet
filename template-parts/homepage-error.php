<?php
/**
 * Homepage Template (for errors).
 *
 * @package Civil_First_Fleet
 */

if ( is_user_logged_in() ) {
	printf(
		'<p><a href="%2$s">%1$s</a></p>',
		esc_html__( 'No homepage found. Create one to get started.', 'civil-cms' ),
		esc_url( admin_url( 'post-new.php?post_type=landing-page' ) )
	);
} else {
	printf(
		'<p>%1$s</p>',
		esc_html__( 'No homepage found. Please login to create one.', 'civil-cms' )
	);
}
