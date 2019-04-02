<?php
/**
 * Template part for displaying a sponsor.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

use function \WP_Render\{find_child, find_child_by_name, get_component, render, get_config};

$below_sponsor = find_child( 'context', 'below_sponsor' );
$image         = find_child_by_name( 'image' );
$label         = get_config( 'label' );
$message       = find_child( 'context', 'message' );
$theme         = 'theme-' . get_config( 'theme' );
?>

<div class="<?php ai_the_classnames( [ 'wrapper', $theme ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">

		<div class="<?php ai_the_classnames( [ 'main' ] ); ?>">
			<?php if ( ! empty( $label ) ) : ?>
				<div class="<?php ai_the_classnames( [ 'intro' ] ); ?>">
					<?php echo esc_html( $label ); ?>
				</div>
			<?php endif; ?>

			<div class="<?php ai_the_classnames( [ 'info' ] ); ?>">
				<a href="<?php echo esc_url( get_config( 'link' ) ); ?>">
					<?php if ( $image ) : ?>
						<div class="<?php ai_the_classnames( [ 'image' ] ); ?>"><?php $image->render(); ?></div>
					<?php endif; ?>
					<?php if ( $message ) : ?>
						<div class="<?php ai_the_classnames( [ 'message' ] ); ?>"><?php render( $message ); ?></div>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<?php if ( $below_sponsor ) : ?>
			<div class="<?php ai_the_classnames( [ 'meta' ] ); ?>">
				<?php render( $below_sponsor ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
