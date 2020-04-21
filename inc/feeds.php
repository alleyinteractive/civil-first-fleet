<?php
/**
 * Customizations for internal (this site's) RSS, Atom, JSON, etc. feeds.
 *
 * See api.php for external feeds.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

add_filter( 'the_author', __NAMESPACE__ . '\show_guest_author_name_in_feeds', 10, 1 );
/**
 * Change the author in feeds to the Co-Authors Plus author(s), if available.
 *
 * @param  string $author_display_name Display name of the author.
 */
function show_guest_author_name_in_feeds( $author_display_name ) {
	global $post;

	if ( ! is_feed() ) {
		return $author_display_name;
	}

	$authors_array = array();
	$coauthors = get_coauthors( $post->ID );

	if ( empty( $coauthors ) || ! is_array( $coauthors ) ) {
		return $author_display_name;
	}

	foreach ( $coauthors as $author ) {
		$authors_array[] = esc_html( $author->display_name );
	}

	$author_output = implode( ', ', $authors_array );

	return $author_output;
};

/**
 * Add featured image to the begining of each rss article.
 *
 * @param string $content Content to go in rss feed.
 *
 * @return string
 */
function rss_post_thumbnail( $content ) {
	global $post;

	// Get newsroom RSS Feed settings.
	$add_featured_image_to_rss_feeds  = ( new \Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'feeds', 'rss_feed_settings', 'add_featured_image_to_rss_feeds' );

	if ( has_post_thumbnail( $post->ID ) && $add_featured_image_to_rss_feeds ){
		$content = '<div>' . get_the_post_thumbnail( $post->ID, 'medium' ) .'</div>' . $content;
	}
	return $content;
}

add_action( 'the_excerpt_rss', __NAMESPACE__ . '\rss_post_thumbnail' );
add_action( 'the_content_feed', __NAMESPACE__ . '\rss_post_thumbnail' );
