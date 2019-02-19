<?php
/**
 * This file contains logic related to Gutenberg.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Disable all links to the Classic Editor.
remove_action( 'admin_init', 'gutenberg_add_edit_link_filters' );
remove_action( 'admin_print_scripts-edit.php', 'gutenberg_replace_default_add_new_button' );

/**
 * Get the post types that support Gutenberg.
 *
 * @return array The post types that support Gutenberg.
 */
function get_gutenberg_post_types() {
	return [
		'post',
		'page',
	];
}

/**
 * Filters post types that enable Gutenberg.
 *
 * @param bool   $can_edit  Whether the post type can be edited or not.
 * @param string $post_type The post type being checked.
 */
function gutenberg_post_types( $can_edit, $post_type ) {
	// Assume all post types have Gutenberg disabled.
	$can_edit = false;

	if ( in_array( $post_type, get_gutenberg_post_types(), true ) ) {
		$can_edit = true;
	}

	return $can_edit;
}
add_filter( 'gutenberg_can_edit_post_type', __NAMESPACE__ . '\gutenberg_post_types', PHP_INT_MAX, 2 );

/**
 * Add `align-wide` support for image blocks.
 */
function wide_image_alignment() {
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\wide_image_alignment' );

/**
 * Disable JS concatenation. Fixes Gutenberg.
 *
 * @param bool $do_concat Do the concatenation.
 */
add_filter(
	'js_do_concat',
	function( $do_concat ) {
		if ( is_admin() ) {
			return false;
		}
		return $do_concat;
	}
);
