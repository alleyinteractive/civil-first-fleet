<?php
/**
 * Manage static assets.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

define( 'CIVIL_FIRST_FLEET_ASSET_VERSION', '1.3' );

add_filter(
	'am_inline_script_context',
	function () {
		return 'civilCMS';
	}
);

/**
 * Set reusable conditions for when/where to load certain assets.
 *
 * @return array
 */
function asset_conditions() {
	return [
		'global'         => true,
		'archive'        => is_archive(),
		'article'        => is_single(),
		'page'           => is_page() || is_404(),
		'content-single' => is_single() || is_page(),
		'home'           => is_home() || is_front_page() || is_archive() || is_search(),
	];
};
add_filter( 'am_asset_conditions', __NAMESPACE__ . '\asset_conditions' );

/**
 * Get the version for a given asset.
 *
 * @param string $asset_path Entry point and asset type separated by a '.'.
 * @return string The asset version.
 */
function ai_get_versioned_asset( $asset_path ) {
	static $asset_map;

	if ( ! isset( $asset_map ) ) {
		$asset_map_file = CIVIL_FIRST_FLEET_PATH . '/client/build/assetMap.json';

		if ( file_exists( $asset_map_file ) && 0 === validate_file( $asset_map_file ) ) {
			ob_start();
			include $asset_map_file;
			$asset_map = json_decode( ob_get_clean(), true );
		} else {
			$asset_map = [];
		}
	}

	/*
	 * Appending a '.' ensures the explode() doesn't generate a notice while
	 * allowing the variable names to be more readable via list().
	 */
	list( $entrypoint, $type ) = explode( '.', "$asset_path." );

	return isset( $asset_map[ $entrypoint ][ $type ] ) ? $asset_map[ $entrypoint ][ $type ] : '';
}

/**
 * Enqueues scripts and styles for the frontend
 */
function enqueue_assets() {
	// Font enqueues.
	am_enqueue_style(
		[
			'handle' => 'civil-webfonts',
			'src'    => 'https://fonts.googleapis.com/css?family=Libre+Franklin:300,300i,400,400i,700,700i,800,800i|Spectral:200,200i,400,400i,800,800i',
		]
	);
	am_enqueue_style(
		[
			'handle'      => 'civil-async-webfonts',
			'src'         => 'https://fonts.googleapis.com/css?family=Libre+Franklin:500,500i,900,900i',
			'load_method' => 'async',
		]
	);

	// Inlined JS vars.
	am_enqueue_script(
		[
			'handle'      => 'commonData',
			'load_method' => 'inline',
			'src'         => [
				'ajaxUrl'         => admin_url( 'admin-ajax.php' ),
				'newsletterNonce' => wp_create_nonce( 'civil_newsletter_nonce' ),
				'bioExpand'       => __( 'Expand', 'civil-first-fleet' ),
			],
		]
	);

	// Dev-specific scripts.
	if (
		( false !== strpos( get_site_url(), '.dev' ) || false !== strpos( get_site_url(), '.test' ) )
		&& get_query_var( 'civil-first-fleet-dev', false )
	) {
		am_enqueue_script(
			[
				'handle'  => 'dev',
				'src'     => '//localhost:8080/client/build/js/dev.bundle.js',
				'version' => '1.0',
			]
		);
	} else {
		// Common assets.
		am_enqueue_script(
			[
				'handle'  => 'civil-first-fleet-common-js',
				'src'     => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'common.js' ),
				'deps'    => [ 'jquery' ],
				'version' => '1.0',
			]
		);
		am_enqueue_style(
			[
				'handle'  => 'civil-first-fleet-common-css',
				'src'     => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'common.css' ),
				'version' => '1.0',
			]
		);

		// Home assets.
		am_enqueue_script(
			[
				'handle'      => 'civil-first-fleet-home-js',
				'src'         => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'home.js' ),
				'deps'        => [ 'civil-first-fleet-common-js' ],
				'version'     => '1.0',
				'load_method' => 'async',
				'condition'   => 'home',
			]
		);
		am_enqueue_style(
			[
				'handle'    => 'civil-first-fleet-home-css',
				'src'       => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'home.css' ),
				'version'   => '1.0',
				'condition' => 'home',
			]
		);

		// Article assets.
		am_enqueue_script(
			[
				'handle'      => 'civil-first-fleet-article-js',
				'src'         => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'article.js' ),
				'deps'        => [ 'civil-first-fleet-common-js' ],
				'version'     => '1.0',
				'load_method' => 'async',
				'condition'   => 'content-single',
			]
		);
		am_enqueue_style(
			[
				'handle'    => 'civil-first-fleet-article-css',
				'src'       => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'article.css' ),
				'version'   => '1.0',
				'condition' => 'article',
			]
		);

		// Page assets.
		am_enqueue_style(
			[
				'handle'    => 'civil-first-fleet-page-css',
				'src'       => get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( 'page.css' ),
				'version'   => '1.0',
				'condition' => 'page',
			]
		);
	}
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );

/**
 * Enqueues scripts and styles for admin screens
 */
function enqueue_admin() {
	wp_enqueue_script( 'civil-first-fleet-admin-js', get_template_directory_uri() . '/client/build/js/admin.bundle.js', [], CIVIL_FIRST_FLEET_ASSET_VERSION, true );
	wp_enqueue_style( 'civil-first-fleet-admin-css', get_template_directory_uri() . '/client/build/css/admin.css', [], CIVIL_FIRST_FLEET_ASSET_VERSION );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_admin' );

/**
 * Enqueues scripts and styles for admin screens
 */
function enqueue_gutenberg() {
	wp_enqueue_style( 'civil-first-fleet-gutenberg-css', get_template_directory_uri() . '/client/build/css/editor.css', [], CIVIL_FIRST_FLEET_ASSET_VERSION );
}
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_gutenberg' );

/**
 * Removes scripts that could potentially cause style conflicts
 */
function dequeue_scripts() {
	wp_dequeue_style( 'jetpack-slideshow' );
	wp_dequeue_style( 'jetpack-carousel' );
}
add_action( 'wp_print_scripts', __NAMESPACE__ . '\dequeue_scripts' );
