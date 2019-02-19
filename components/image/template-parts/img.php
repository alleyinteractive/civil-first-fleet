<?php
/**
 * Template part for displaying the Logo component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Get this instance.
$component = ai_get_var( 'component' );
$srcset = ai_get_var( 'srcset' );
$lazyload = $component->get_setting( 'lazyload' );

if ( $lazyload ) {
	printf(
		'<img src="%1$s" class="%2$s" data-srcset="%3$s" data-sizes="auto" alt="%4$s" />',
		esc_url( $component->get_lqip_src()->get_data( 'url' ) ),
		esc_attr( ai_get_classnames( [ 'lazyload', 'image', 'image-lazyload' ] ) ),
		esc_attr( $srcset ),
		esc_attr( $component->get_data( 'alt' ) )
	);
} else {
	printf(
		'<img class="%1$s" srcset="%2$s" data-sizes="auto" alt="%3$s" />',
		esc_attr( ai_get_classnames( [ 'image' ] ) ),
		esc_attr( $srcset ),
		esc_attr( $component->get_data( 'alt' ) )
	);
}
