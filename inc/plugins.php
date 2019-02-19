<?php
/**
 * Load and customize plugins.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Display an admin notice if a required plugin is missing from the theme.
 *
 * @param string $plugin_name Plugin name.
 */
function missing_plugin_notice( $plugin_name ) {
	add_action(
		'admin_notices',
		function() use ( $plugin_name ) {
			echo '<div class="notice notice-error"><p>';
			printf(
				// Translators: %1$s, plugin name.
				esc_html__( 'Could not load required plugin %1$s. Your site will not work without it. Please reference theme documentation for information on installing.', 'civil-first-fleet' ),
				esc_html( $plugin_name )
			);
			echo '</p></div>';
		}
	);
}

// Ensure various plugins are loaded.
if ( ! defined( 'FM_VERSION' ) ) {
	missing_plugin_notice( __( 'Fieldmanager', 'civil-first-fleet' ) );
}

// Disable plugin credibility indicators since the theme has them built in.
add_filter( 'civil_enable_credibility_indicators', '__return_false' );

add_filter( 'pre_option_sharedaddy_disable_resources', '__return_true' );
