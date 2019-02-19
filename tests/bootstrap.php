<?php
if ( ! defined( 'WP_CONTENT_DIR' ) ) {
	$cwd = explode( 'wp-content', dirname( __FILE__ ) );
	define( 'WP_CONTENT_DIR', $cwd[0] . '/wp-content' );
}

// Load Core's test suite
$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( !$_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

/**
 * Setup our environment (theme, plugins).
 */
function _manually_load_environment() {
	// Remove action that flushes cache on theme switch.
	remove_action( 'switch_theme', 'rri_wpcom_action_switch_theme' );

	// Set our theme.
	switch_theme( 'civil-first-fleet' );

	// Re-add the action.
	add_action( 'switch_theme', 'rri_wpcom_action_switch_theme' );

	/*
	 * Tests won't start until the uploads directory is scanned, so use the
	 * lightweight directory from the test install.
	 *
	 * @see https://core.trac.wordpress.org/changeset/29120.
	 */
	add_filter( 'pre_option_upload_path', function () {
		return ABSPATH . 'wp-content/uploads';
	} );

	// Set up plugins.
	update_option( 'active_plugins', array(
		'jetpack/jetpack.php'
	) );

	if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {
		define( 'JETPACK_DEV_DEBUG', true );
	}

	/*
	 * If Edit Flow is enabled, the notifications module can hit errors because
	 * the unit test factory creates posts without authors.
	 */
	add_filter( 'ef_notification_status_change', '__return_false' );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_environment' );

/**
 * Simple getter/setter for random values. Simplifies testing of caching.
 *
 * @param  string $new_value Some new value to set.
 * @return string The most recently set value.
 */
function _cache_test_data( $new_value = null ) {
	static $value;
	if ( isset( $new_value ) ) {
		$value = $new_value;
	}
	return $value;
}

// Include core's bootstrap
require $_tests_dir . '/includes/bootstrap.php';
