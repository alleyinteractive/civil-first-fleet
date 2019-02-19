<?php
/**
 * Template part for displaying the Subscribe Button component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component     = ai_get_var( 'component' );
$subscribe_url = $component->get_data( 'subscribe_url' );
$text          = $component->get_data( 'text' );
$id            = $component->get_data( 'id' );

// Set default.
if ( empty( $text ) ) {
	$text = $component->default_data()['text'];
}

$classnames = [ 'button' ];

if ( 'standard' === $component->get_setting( 'height' ) ) {
	$classnames[] = 'standard-height';
} else if ( 'full' === $component->get_setting( 'height' ) ) {
	$classnames[] = 'full-height';
}

if ( 'standard' === $component->get_setting( 'width' ) ) {
	$classnames[] = 'standard-width';
} else if ( 'full' === $component->get_setting( 'width' ) ) {
	$classnames[] = 'full-width';
}
?>

<a id="<?php echo esc_attr( $id ); ?>" class="<?php ai_the_classnames( $classnames ); ?>"><?php echo esc_html( $text ); ?></a>
