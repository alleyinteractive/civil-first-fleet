<?php
/**
 * This file changes the default output of the oEmbed component when a post
 * from this website is shared. (To see an example, append `/embed/` to the end
 * of any post URL in the network.) It also adds additional provider support.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Returns the post deck (AKA 'dek' or subtitle) for the embed excerpt if one is
 * available. Otherwise falls back to the excerpt generated by WordPress.
 *
 * @param  string $output Post excerpt.
 */
function get_excerpt_embed( $output ) {
	$dek = \Civil_First_Fleet\Component\content_item()
		->set_data( 'post_id', get_the_ID() )
		->get_dek();

	if ( ! empty( $dek ) ) {
		$output = sanitize_text_field( wp_trim_words( $dek ) );
	}

	return $output;
}
add_filter( 'the_excerpt_embed', __NAMESPACE__ . '\get_excerpt_embed' );

/**
 * Adds CSS to the embed to make it better match Civil's design patterns:
 * - Changes the typography.
 * - Hides the comments and share button icons.
 */
function add_embed_css() {
	$excerpt_css = <<<HTML
<style>
.wp-embed {
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 15px;
	color: #3f3c39;
	line-height: 1.4;
}

.wp-embed-heading a {
	color: #3f3c39;
	transition: color 0.25s;
}

.wp-embed-heading a:hover {
	color: #2b56ff;
	text-decoration: none;
}

.wp-embed-meta {
	display: none;
}
</style>
HTML;

	echo filter_var( $excerpt_css, FILTER_UNSAFE_RAW ); // phpcs:ignore WordPressVIPMinimum.Security.PHPFilterFunctions.RestrictedFilter
}
add_filter( 'embed_head', __NAMESPACE__ . '\add_embed_css' );

/**
 * Add Flourish oEmbed support.
 *
 * @see https://flourish.studio/developers/integration/.
 */
wp_oembed_add_provider(
	'https://public.flourish.studio/(visualisation|story)/*',
	'https://app.flourish.studio/api/v1/oembed',
	true
);
