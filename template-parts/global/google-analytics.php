<?php
/**
 * Template file for the Google Analytics Tracking code.
 *
 * @package Civil_First_Fleet
 */

// Get the site's property code.
$ga_property_code = ( new \Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'analytics', 'properties', 'ga_property_code' );

// No code found.
if ( empty( $ga_property_code ) ) {
	return;
}

?>

<!-- Google Analytics -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo esc_js( $ga_property_code ); ?>', 'auto');
	ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
