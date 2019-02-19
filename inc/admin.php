<?php
/**
 * Add any admin manipulations here
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Remove the "Custom Fields" meta box.
 *
 * It generates an expensive query and is almost never used in practice.
 */
function remove_postcustom() {
	remove_meta_box( 'postcustom', null, 'normal' );

	// Remove all default coauthor meta fields.
	remove_meta_box( 'coauthors-manage-guest-author-bio', null, 'normal' );
	remove_meta_box( 'coauthors-manage-guest-author-contact-info', null, 'normal' );
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\remove_postcustom', 11 );

/**
 * Set up CSS Modules functionality for Gutenberg blocks
 */
function admin_init_cssmodules() {
	\Civil_First_Fleet\Stylesheets::instance()->setup( true );
}
add_action( 'admin_init', __NAMESPACE__ . '\admin_init_cssmodules', 11 );

/**
 * Remove unnecessary contact methods from user profile.
 *
 * @param  array $contact_methods Array of contact methods.
 * @return array
 */
function user_contact_methods( $contact_methods ) {
	unset( $contact_methods['website'] );
	unset( $contact_methods['aim'] );
	unset( $contact_methods['jabber'] );
	unset( $contact_methods['yim'] );

	return $contact_methods;
}
add_filter( 'user_contactmethods', __NAMESPACE__ . '\update_contact_methods' );

/**
 * Remove the post excerpt field.
 */
function remove_excerpt_field() {
	remove_post_type_support( 'post', 'excerpt' );
}
add_action( 'init', __NAMESPACE__ . '\remove_excerpt_field', 11 );
