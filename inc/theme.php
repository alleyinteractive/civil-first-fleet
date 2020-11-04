<?php
/**
 * Theme setup.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as
 * indicating support post thumbnails.
 */
function theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 *
	 * load_theme_textdomain( 'civil-first-fleet', THEME_PATH . '/languages' );
	 */

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add styles to visual editor.
	add_editor_style( 'client/build/css/editor.css' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Set up theme's use of wp_nav_menu(), unless this is a single WP install
	// (non-multisite) or if this is the main site in a multisite network.
	if ( ! is_multisite() || 1 !== get_current_blog_id() ) {
		register_nav_menus(
			[
				'newsroom-footer-one'   => __( 'Footer (Column One)', 'civil-first-fleet' ),
				'newsroom-footer-two'   => __( 'Footer (Column Two)', 'civil-first-fleet' ),
				'newsroom-footer-three' => __( 'Footer (Column Three)', 'civil-first-fleet' ),
				'newsroom-footer-four'  => __( 'Footer (Column Four)', 'civil-first-fleet' ),
				'newsroom-header'       => __( 'Header', 'civil-first-fleet' ),
			]
		);
	}

	// Enable support for HTML5 components.
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\body_classes' );

/**
 * Set global content width for max width on media & oEmbeds.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 863;
}
