<?php
/**
 * Template part for displaying the Logo component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
$context   = $component->setting( 'context' );
// phpcs:disable WordPress.WP.GlobalVariablesOverride.Prohibited
$blog_id = 'civil' === $context ? 1 : null;
$link    = get_home_url( $blog_id, '/' );

open_anchor(
	$link,
	[
		'class' => ai_get_classnames(
			[
				'wrapper',
				$component->setting( 'context' ),
				$component->setting( 'version' ),
				$component->setting( 'location' ),
			]
		),
	]
);
if ( 'civil' === $context ) {
	ai_get_template_part( $component->get_component_path( 'svg/logo-civil.svg' ), [ 'version' => $component->setting( 'version' ) ] );
} else {

	// Modify path to data if it's a footer.
	$newsroom_location = 'logo';
	if ( 'footer' === $component->setting( 'location' ) ) {
		$newsroom_location = 'footer_logo';
	}

	// Use SVG for logo.
	$newsroom_logo_svg = $component->get_option( 'newsroom-settings', 'branding', $newsroom_location, 'svg' );
	if ( ! empty( $newsroom_logo_svg ) ) {
		echo wp_kses_post( (string) $newsroom_logo_svg );
	} else {

		// Use image for logo.
		$newsroom_logo_image_id = $component->get_option( 'newsroom-settings', 'branding', $newsroom_location, 'image_id' );
		if ( ! empty( $newsroom_logo_image_id ) ) {
			\Civil_First_Fleet\Component\image()
				->set_post_id( (int) $newsroom_logo_image_id )
				->size( 'newsroom-header-logo' )
				->aspect_ratio( false )
				->set_data( 'alt', get_bloginfo( 'name' ) )
				->disable_lazyload()
				->render();
		} else {

			// Use heading for logo.
			printf(
				'<h2 class="%2$s">%1$s</h2>',
				esc_html( get_bloginfo( 'name' ) ),
				esc_attr( ai_get_classnames( [ 'site-title' ] ) )
			);
		}
	}
}
close_anchor( $link );
