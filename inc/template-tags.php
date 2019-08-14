<?php
/**
 * Helper functions
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Get the base template part for the current request.
 */
function get_main_template() {
	ai_get_template_part( Wrapping::$base );
}

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date */
		_x( 'Posted on %s', 'post date', 'civil-first-fleet' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators: %s: post author */
		_x( 'by %s', 'post author', 'civil-first-fleet' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	$allowed_html = wp_kses_allowed_html( 'post' );
	$allowed_html['time'] = [
		'class'    => true,
		'datetime' => true,
	];

	echo wp_kses( '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>', $allowed_html );
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'civil-first-fleet' ) );
		if ( $categories_list ) {
			/* translators: 1: list of post categories */
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'civil-first-fleet' ) . '</span>', wp_kses_post( $categories_list ) );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'civil-first-fleet' ) );
		if ( $tags_list ) {
			/* translators: 1: list of tags */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'civil-first-fleet' ) . '</span>', wp_kses_post( $tags_list ) );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'civil-first-fleet' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'civil-first-fleet' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="' . esc_url( get_bloginfo( 'pingback_url' ) ) . '">';
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\pingback_header' );

/**
 * Add Google Analytics Tracking to the site.
 */
add_action(
	'wp_head',
	function() {
		ai_get_template_part( 'template-parts/global/google-analytics' );
		ai_get_template_part( 'template-parts/global/google-tag-manager' );
	},
	15
);

/**
 * Add Google Tag Manager NoScript Tracking to the site.
 */
add_action(
	'wp_body_open',
	function() {
		ai_get_template_part( 'template-parts/global/google-tag-manager-noscript' );
	}
);

/**
 * Remove Generator header tag, because it is unnecessary at best and a security
 * risk at worst.
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Open an anchor tag if $link is valid.
 *
 * @todo   Implement the Anchor attributes.
 *
 * @param  string $url        URL string.
 * @param  array  $attributes Anchor attributes.
 */
function open_anchor( $url, $attributes = array() ) {
	if ( empty( $url ) ) {
		return;
	}

	$attributes_string = '';

	foreach ( $attributes as $attr => $value ) {
		$attributes_string .= sprintf(
			'%1$s="%2$s" ',
			esc_attr( $attr ),
			esc_attr( $value )
		);
	}

	printf(
		'<a href="%1$s" %2$s>',
		esc_url( $url ),
		$attributes_string // phpcs:ignore WordPress.XSS.EscapeOutput, WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Close an anchor tag if $link is valid.
 *
 * @param  string $url URL string.
 */
function close_anchor( $url ) {
	if ( empty( $url ) ) {
		return;
	}
	printf( '</a>' );
}
