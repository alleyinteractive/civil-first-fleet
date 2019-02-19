<?php
/**
 * Customizations for internal (this site's) RSS, Atom, JSON, etc. feeds.
 *
 * See api.php for external feeds.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

add_filter( 'the_author', __NAMESPACE__ . '\show_guest_author_name_in_feeds', 10, 1 );
/**
 * Change the author in feeds to the Co-Authors Plus author(s), if available.
 *
 * @param  string $author_display_name Display name of the author.
 */
function show_guest_author_name_in_feeds( $author_display_name ) {
	if ( ! is_feed() ) {
		return $author_display_name;
	}

	$authors_array = array();
	$coauthors = get_coauthors( $post_id );

	if ( empty( $coauthors ) || ! is_array( $coauthors ) ) {
		return $author_display_name;
	}

	foreach ( $coauthors as $author ) {
		$authors_array[] = esc_html( $author->display_name );
	}

	$author_output = implode( ', ', $authors_array );

	return $author_output;
};
