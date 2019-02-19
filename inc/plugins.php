<?php
/**
 * Load and customize plugins
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Plugin dependencies.
$civil_first_fleet_plugins = [
	'Coauthors Plus'        => 'co-authors-plus',
	'FM Zones'              => 'fm-zones/fm-zones.php',
	'MSM Sitemap'           => 'msm-sitemap',
	'Safe Redirect Manager' => 'safe-redirect-manager',
	'Fieldmanager'          => 'wordpress-fieldmanager/fieldmanager.php',
	'WP Asset Manager'      => 'wp-asset-manager/asset-manager.php',
	'WP SEO'                => 'wp-seo',
	'Thumbnail Editor'      => 'wpcom-thumbnail-editor',
];
foreach ( $civil_first_fleet_plugins as $label => $path ) {
	if ( function_exists( 'wpcom_vip_load_plugin' ) ) {
		wpcom_vip_load_plugin( $path );
	} elseif ( file_exists( CIVIL_FIRST_FLEET_PATH . '/plugins/' . $path ) ) {
		require_once CIVIL_FIRST_FLEET_PATH . '/plugins/' . $path;
	}
}

// Disable plugin credibility indicators since the theme has them built in.
add_filter( 'civil_enable_credibility_indicators', '__return_false' );

add_filter( 'pre_option_sharedaddy_disable_resources', '__return_true' );