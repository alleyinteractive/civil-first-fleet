<?php
/**
 * Template part for displaying the component with subscribe button CTA
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get settings.
$theme  = $component->get_setting( 'theme' );
$layout = $component->get_setting( 'layout' );

// Get data.
$button_text = $component->get_data( 'button_text' );
$button      = (array) $component->get_data( 'button' );
$description = $component->get_data( 'description' );
// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
$title    = $component->get_data( 'title' );
$location = $component->get_data( 'location' );
$context  = $component->get_data( 'context' );
?>

<section class="<?php ai_the_classnames( [ 'civil__call-to-action__wrapper', "civil__call-to-action__theme-{$theme}", "civil__call-to-action__layout-{$layout}" ], [ $location => ! empty( $location ) ] ); ?>">
	<?php if ( ! empty( $title ) ) : ?>
		<h2 class="<?php ai_the_classnames( [ 'civil__call-to-action__heading' ] ); ?>">
			<?php echo esc_html( $title ); ?>
		</h2>
	<?php endif; ?>

	<div class="<?php ai_the_classnames( [ 'civil__call-to-action__body' ] ); ?>">
		<?php if ( ! empty( $description ) ) : ?>
			<p class="<?php ai_the_classnames( [ 'civil__call-to-action__text' ] ); ?>">
				<?php
				echo esc_html( $description );
				if ( 'inline' === $layout ) {
					\WP_Render\render(
						( new \Civil_First_Fleet\Components\Call_To_Action\Button() )
							->parse_from_fm_data( $button ?? [] )
							->set_config( 'id', 'subscribe-button-cta' )
							->set_config( 'width', '' )
							->set_config( 'classes', [ 'civil__call-to-action__inline-link' ] )
					);
				}
				?>
			</p>
		<?php endif; ?>

		<?php if ( 'inline' !== $layout ) : ?>
			<div class="<?php ai_the_classnames( [ 'civil__call-to-action__button-wrapper' ] ); ?>">
				<?php
				\WP_Render\render(
					( new \Civil_First_Fleet\Components\Call_To_Action\Button() )
						->parse_from_fm_data( $button ?? [] )
						->set_config( 'id', empty( $context ) ? 'subscribe-button-cta' : 'subscribe-button-cta-' . $context )
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
