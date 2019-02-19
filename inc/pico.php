<?php
/**
 * This file contains logic related to the Pico plugin.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Ensures that all gutenberg blocks have a valid structure.
 *
 * The Pico plugin that we are using appears to add some spaces to the block content
 * which breaks the `do_blocks` regex when it tries to find blocks to render. This
 * function is meant to ensure that all blocks have the proper HTML comment structure
 * to ensure they are picked up by the `do_blocks` regex.
 *
 * @param  string $content Post content.
 * @return string          Updated post content.
 */
function ensure_gutenberg_block_structure( $content ) {
	$rendered_content = '';

	$dynamic_block_names   = get_dynamic_block_names();
	$dynamic_block_pattern = (
		'/<!--\s+wp:(' .
		str_replace(
			'/', '\/',                 // Escape namespace, not handled by preg_quote.
			str_replace(
				'core/', '(?:core/)?', // Allow implicit core namespace, but don't capture.
				implode(
					'|',                   // Join block names into capture group alternation.
					array_map(
						'preg_quote',    // Escape block name for regular expression.
						$dynamic_block_names
					)
				)
			)
		) .
		/**
		 * We updated this part of the regex to account for an added space before
		 * the closing `-->`.
		 *
		 * Original string: `)(\s+(\{.*?\}))?\s+(\/)?-->/`
		 */
		')(\s+(\{.*?\}))?\s+(\/)? -->/'
	);

	while ( preg_match( $dynamic_block_pattern, $content, $block_match, PREG_OFFSET_CAPTURE ) ) {
		// We have a match.
		if ( ! empty( $block_match[0][0] ) ) {
			// Sanitize the block.
			$sanitized_block = str_replace( '/ -->', '/-->', $block_match[0][0] );

			// Update the block.
			$content = str_replace( $block_match[0][0], $sanitized_block, $content );
		}
	}

	return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\ensure_gutenberg_block_structure', 8 ); // Runs before `do_blocks`.
