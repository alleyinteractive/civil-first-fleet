
<?php
/**
 * Template file for the Google Tag Manager code.
 *
 * @package Civil_First_Fleet
 */

// Get the site's property code.
$gtm_property_code = ( new \Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'analytics', 'properties', 'gmt_property_code' );

// No code found.
if ( empty( $gtm_property_code ) ) {
	return;
}

?>

<!-- Google Tag Manager -->
<script>
	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer', '<?php echo esc_js( $gtm_property_code ); ?>');
</script>
<!-- End Google Tag Manager -->
