<?php
/**
 * Template part for displaying a sponsor.
 */

namespace Civil_First_Fleet;

use function \WP_Render\{find_child, find_child_by_name, get_component, render, get_config};

$image         = find_child_by_name( 'image' );
$message       = find_child( 'context', 'message' );
$short_message = find_child( 'context', 'short_message' );

// print_r($image); die();
$theme = 'featured-article';
?>
<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'intro' ] ); ?>"><?php esc_html_e( 'Supported Today By', 'civil-first-fleet' ); ?></div>
	<div class="<?php ai_the_classnames( [ 'info' ] ); ?>">
		<div class="<?php ai_the_classnames( [ 'image' ] ); ?>">Image</div>
		<p><a href="<?php echo esc_url( get_config( 'link' ) ); ?>"><?php render( $message ); ?></a></p>
	</div>
	<div class="<?php ai_the_classnames( [ 'meta' ] ); ?>">
		<p>
			<a href="<?php echo esc_url( home_url( '/sponsor-policy/' ) ); ?>">
				<?php esc_html_e( 'Read our ethics policy on underwriting.', 'civil-first-fleet' ); ?>
			</a>
		</p>
		<p>
			<a href="<?php echo esc_url( home_url( '/sponsorships/' ) ); ?>">
				<?php esc_html_e( 'Want to sponsor The Sun?', 'civil-first-fleet' ); ?>
			</a>
		</p>
	</div>

</div>
