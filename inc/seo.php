<?php
/**
 * SEO modifications.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Disable Jetpack's Open Graph.
add_filter( 'jetpack_enable_open_graph', '__return_false' );

/**
 * Modify post types that WP SEO applies to.
 *
 * @param  array $post_types Default post types for WP SEO.
 * @return array             Corrected post types for WP SEO.
 */
function wp_seo_single_post_types( $post_types ) {

	// Build an array of post types to remove from WP SEO.
	$post_types_to_remove = array(
		'guest-author',
	);

	// Remove post types.
	foreach ( $post_types_to_remove as $post_type_to_remove ) {
		if ( isset( $post_types[ $post_type_to_remove ] ) ) {
			unset( $post_types[ $post_type_to_remove ] );
		}
	}

	return $post_types;
}
add_filter( 'wp_seo_single_post_types', __NAMESPACE__ . '\wp_seo_single_post_types' );

/**
 * Return an array of the social meta tag properties.
 *
 * @return array Array of meta properties.
 */
function generate_header_meta() {
	$queried_object = get_queried_object();

	/**
	 * Determine the ID.
	 */
	if ( \Civil_First_Fleet\is_landing_page() ) {
		$id = get_the_ID();
	} elseif ( $queried_object instanceof \WP_Post || 'guest-author' === $queried_object->type ) {
		$id = $queried_object->ID;
	} elseif ( $queried_object instanceof \WP_Term ) {
		$id = $queried_object->term_id;
	} else {
		return [];
	}

	/**
	 * Determine title.
	 */
	$title = get_post_meta( $id, '_meta_title', true );
	if ( empty( $title ) ) {
		if ( is_category() || is_tag() ) {
			$title = $queried_object->name;
		} else {
			$title = get_the_title( $id );
		}
	}

	/**
	 * Determine URL.
	 */
	if ( is_category() ) {
		$url = get_category_link( $id );
	} elseif ( is_tag() ) {
		$url = get_tag_link( $id );
	} elseif ( is_front_page() || 'homepage' === get_query_var( 'dispatch' ) ) {
		$url = get_home_url();
	} else {
		$url = get_permalink( $id );
	}

	// Setup array.
	$meta = array(
		'title'         => $title,
		'og:title'      => $title,
		'og:url'        => $url,
		'og:site_name'  => get_bloginfo( 'name' ),
		'og:type'       => 'website',
		'twitter:card'  => 'summary_large_image',
		'twitter:title' => $title,
	);

	// Get newsroom SEO settings.
	$component             = new \Civil_First_Fleet\Component();
	$newsroom_seo_settings = $component->get_option( 'newsroom-settings', 'seo', 'social' );

	// Add Facebook App ID.
	if ( ! empty( $newsroom_seo_settings['facebook_app_id'] ) ) {
		$meta['fb:app_id'] = $newsroom_seo_settings['facebook_app_id'];
	}

	// Add Twitter.
	if ( ! empty( $newsroom_seo_settings['twitter_handle'] ) ) {
		$meta['twitter:site'] = '@' . $newsroom_seo_settings['twitter_handle'];
	}

	/**
	 * Determine the description.
	 */
	if ( is_single() || is_page() || \Civil_First_Fleet\is_landing_page() ) {
		$description = (string) get_post_meta( $id, '_meta_description', true );
		if ( empty( $description ) ) {
			// Fallback to excerpt.
			$description = \Civil_First_Fleet\Component\content_item()
				->set_data( 'post_id', $id )
				->get_dek();
		}
	} elseif ( is_author() ) {
		$description = get_post_meta( $id, 'biography', true );
	} elseif ( is_category() || is_tag() ) {
		$description = $queried_object->description;
	}

	if ( ! empty( $description ) ) {
		$meta['description'] = $description;
		$meta['og:description'] = $description;
		$meta['twitter:description'] = $description;
	}

	/**
	 * Determine the keywords.
	 */
	$keywords = get_post_meta( $id, '_meta_keywords', true );
	if ( ! empty( $keywords ) ) {
		$meta['keywords'] = $keywords;
	}

	// Determine the image.
	if ( \Civil_First_Fleet\is_landing_page() ) {
		$landing_page_meta = get_post_meta( $id, 'homepage', true );
		$image_url         = wp_get_attachment_url( $landing_page_meta['featured_image']['image'] ?? 0 );
	} elseif ( is_author() ) {
		$avatar_id = get_post_meta( $id, '_thumbnail_id', true );

		if ( ! empty( $avatar_id ) ) {
			$image_url = wp_get_attachment_url( $avatar_id );
		} else {
			$image_url = get_avatar_url( $avatar_id, 75 );
		}
	} else {
		$image_url = get_the_post_thumbnail_url( $id, 'full' );
	}

	// Set image url.
	if ( ! empty( $image_url ) ) {

		// Validate and add photon args.
		$image_url = strtok( $image_url, '?' );
		$image_url = add_query_arg( 'resize', '1200,630', $image_url );

		// Ensure the correct avatar style is used.
		if ( strpos( $image_url, 'gravatar' ) ) {
			$image_url = add_query_arg( 'd', 'mm', $image_url );
		}

		$meta['og:image']      = $image_url;
		$meta['twitter:image'] = $image_url;
	}

	/**
	 * Clean and format array.
	 *
	 * @var array
	 */
	$cleaned_meta = array();
	foreach ( $meta as $key => $value ) {
		$cleaned_meta[] = array(
			'property' => esc_attr( $key ),
			'content'  => esc_attr( $value ),
		);
	}

	return $cleaned_meta;
}

/**
 * Output a post's or page's social meta tags.
 */
function social_meta() {
	if ( is_single() || is_page() || \Civil_First_Fleet\is_landing_page() || is_archive() ) {

		$meta = generate_header_meta();
		array_walk(
			$meta,
			function( $meta ) {

				// Output meta tag.
				printf(
					'<meta property="%1$s" content="%2$s" />',
					esc_attr( $meta['property'] ),
					esc_attr( $meta['content'] )
				);

				// Makes the output a little nicer.
				echo "\n";
			}
		);
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\social_meta' );
