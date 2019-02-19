<?php
/**
 * Template part for displaying the IFrame component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );

// iframe context cannot be from site.
$home_url_parts = wp_parse_url( home_url() );
$src_url_parts = wp_parse_url( $component->get_data( 'src' ) );

// No hosts found.
if ( empty( $home_url_parts['host'] ) || empty( $src_url_parts['host'] ) ) {
	return;
}

// Disallow same hosts.
if ( $home_url_parts['host'] === $src_url_parts['host'] ) {
	return;
}
?>

<iframe
	allowfullscreen="false"
	frameborder="0"
	sandbox="allow-forms allow-scripts allow-same-origin"
	src="<?php echo esc_url( $component->get_data( 'src' ) ); ?>"
	height="<?php echo esc_attr( $component->get_data( 'height' ) ); ?>"
	width="<?php echo esc_attr( $component->get_data( 'width' ) ); ?>"
	<?php echo ! empty( $component->get_data( 'scrolling' ) ) ? 'scrolling="' . esc_attr( $component->get_data( 'scrolling' ) ) . '"' : ''; ?>
	style="<?php echo esc_attr( $component->get_data( 'style' ) ); ?>"
	class="<?php echo esc_attr( $component->get_data( 'classes' ) ); ?>"
></iframe>
