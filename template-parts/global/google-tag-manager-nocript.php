
<?php
/**
 * Template file for the Google Tag Manager noscript code.
 *
 * @package Civil_First_Fleet
 */

// Get the site's property code.
$gtm_property_code = ( new \Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'analytics', 'properties', 'gmt_property_code' );

// No code found.
if ( empty( $gtm_property_code ) ) {
	return;
}

$url = 'https://www.googletagmanager.com/ns.html?id=' . $gtm_property_code;

?>

<!-- Google Tag Manager (noscript) -->
<noscript>
	<iframe
		src='<?php echo esc_url( $url ); ?>'
		height='0'
		width='0'
		style='display:none;visibility:hidden'>
	</iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
