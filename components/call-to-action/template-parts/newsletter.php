<?php
/**
 * Template part for displaying the Newsletter component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get settings.
$theme      = $component->get_setting( 'theme' );
$layout     = $component->get_setting( 'layout' );
$newsletter = $component->get_setting( 'newsletter' );

// Get data.
$button_text = $component->get_data( 'button' )['label'] ?? $component->get_data( 'button_text' );
$description = $component->get_data( 'description' );
$title       = $component->get_data( 'title' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$location    = $component->get_data( 'location' );
?>

<section
	class="<?php ai_the_classnames( [ 'civil__call-to-action__wrapper', "civil__call-to-action__theme-{$theme}", "civil__call-to-action__layout-{$layout}", "newsletter-{$newsletter}" ], [ $location => ! empty( $location ) ] ); ?>"
	data-component="<?php echo esc_attr( $component->slug ); ?>"
>
	<?php if ( ! empty( $title ) ) : ?>
		<h2 class="<?php ai_the_classnames( [ 'civil__call-to-action__heading' ] ); ?>">
			<?php echo esc_html( $title ); ?>
		</h2>
	<?php endif; ?>

	<div class="<?php ai_the_classnames( [ 'civil__call-to-action__body' ] ); ?>">
		<?php if ( ! empty( $description ) ) : ?>
			<p class="<?php ai_the_classnames( [ 'civil__call-to-action__text' ] ); ?>">
				<?php echo esc_html( $description ); ?>
			</p>
		<?php endif; ?>

		<form
			class="<?php ai_the_classnames( [ 'civil__call-to-action__form' ] ); ?>"
			accept-charset="UTF-8"
			enctype="multipart/form-data"
			method="POST"
		>
			<input
				class="<?php ai_the_classnames( [ 'civil__call-to-action__newsletter-list' ] ); ?>"
				type="hidden"
				name="list"
				value="<?php echo esc_attr( $newsletter ); ?>"
			>
			<div>
				<label class="<?php ai_the_classnames( [ 'screen-reader-text' ] ); ?>"><?php esc_html_e( 'Email Address', 'civil-first-fleet' ); ?></label>
			</div>
			<div class="<?php ai_the_classnames( [ 'civil__call-to-action__input-wrapper' ] ); ?>">
				<input
					autocomplete="email"
					class="<?php ai_the_classnames( [ 'civil__call-to-action__newsletter-email' ] ); ?>"
					name="email"
					placeholder="<?php esc_attr_e( 'Email Address', 'civil-first-fleet' ); ?>"
					required
					type="email"
					value=""
				>
			</div>
			<div class="<?php ai_the_classnames( [ 'civil__call-to-action__submit-wrapper' ] ); ?>">
				<input
					class="<?php ai_the_classnames( [ 'civil__call-to-action__newsletter-submit' ] ); ?>"
					type="submit"
					value="<?php echo esc_attr( $button_text ); ?>"
				>
			</div>
			<div class="<?php ai_the_classnames( [ 'civil__call-to-action__newsletter-data' ] ); ?>">
				<div class="<?php ai_the_classnames( [ 'civil__call-to-action__newsletter-message' ] ); ?>"></div>
			</div>
		</form>
	</div>
</section>
