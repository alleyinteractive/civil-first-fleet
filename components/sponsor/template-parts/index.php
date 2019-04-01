<?php
/**
 * Template part for displaying a sponsor.
 */

namespace Civil_First_Fleet;

use function \WP_Render\{find_child, find_child_by_name, get_component, render, get_config};

$image   = find_child_by_name( 'image' );
$message = find_child( 'context', 'message' );
$theme   = get_config( 'theme' );
?>

<div class="<?php ai_the_classnames( [ 'wrapper', $theme ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">

		<div class="<?php ai_the_classnames( [ 'intro' ] ); ?>">
			<?php esc_html_e( 'Supported Today By', 'civil-first-fleet' ); ?>
		</div>

		<div class="<?php ai_the_classnames( [ 'info' ] ); ?>">
			<a href="<?php echo esc_url( get_config( 'link' ) ); ?>">
				<?php if ( $image ) : ?>
					<div class="<?php ai_the_classnames( [ 'image' ] ); ?>"><?php $image->render(); ?></div>
				<?php endif; ?>
				<p><?php render( $message ); ?></p>
			</a>
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
</div>
