<?php
/**
 * This file holds configuration settings and functions for media, including
 * image sizes and custom field handling.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

\Civil_First_Fleet\Component\Image::register_breakpoints(
	[
		'xxl' => '90rem',
		'xl'  => '80rem',
		'lg'  => '64rem',
		'md'  => '48rem',
		'sm'  => '32rem',
	]
);

\Civil_First_Fleet\Component\Image::register_crop_sizes(
	[
		'Wide' => [
			'large-feature' => [
				'crop'   => false,
				'height' => 627,
				'width'  => 950,
			],
		],
		'16:9' => [
			'article-header' => [
				'height' => 810,
				'width'  => 1440,
			],
			'card' => [
				'height' => 258,
				'width'  => 460,
			],
		],
		'1:1' => [
			'avatar-small' => [
				'height' => 25,
				'width'  => 25,
			],
			'river' => [
				'height' => 140,
				'width'  => 140,
			],
		],
	]
);

/**
 * Register image sizes for use by the Image component.
 */
\Civil_First_Fleet\Component\Image::register_sizes(
	[
		'large-feature' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 950, 627 ],
					],
					'descriptor' => 949,
				],
				[
					'transforms' => [
						'resize' => [ 800, 528 ],
					],
					'descriptor' => 800,
				],
				[
					'transforms' => [
						'resize' => [ 480, 317 ],
					],
					'descriptor' => 480,
				],
				[
					'transforms' => [
						'resize' => [ 320, 211 ],
					],
					'descriptor' => 320,
				],
			],
		],
		'article-header' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 1440, 810 ],
					],
					'descriptor' => 1440,
				],
				[
					'transforms' => [
						'resize' => [ 1216, 684 ],
					],
					'descriptor' => 1216,
				],
				[
					'transforms' => [
						'resize' => [ 960, 540 ],
					],
					'descriptor' => 960,
				],
				[
					'transforms' => [
						'resize' => [ 768, 432 ],
					],
					'descriptor' => 768,
				],
				[
					'transforms' => [
						'resize' => [ 512, 288 ],
					],
					'descriptor' => 512,
				],
			],
		],
		'gallery-fullscreen' => [
			'sources' => [
				[
					'transforms' => [
						'fit' => [ 1920, 1080 ],
					],
					'descriptor' => 1920,
				],
				[
					'transforms' => [
						'fit' => [ 1440, 810 ],
					],
					'descriptor' => 1440,
				],
				[
					'transforms' => [
						'fit' => [ 1280, 720 ],
					],
					'descriptor' => 1280,
				],
				[
					'transforms' => [
						'fit' => [ 1024, 576 ],
					],
					'descriptor' => 1024,
				],
				[
					'transforms' => [
						'fit' => [ 768, 432 ],
					],
					'descriptor' => 768,
				],
				[
					'transforms' => [
						'fit' => [ 512, 288 ],
					],
					'descriptor' => 512,
				],
			],
		],
		'card' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 460, 258 ],
					],
					'descriptor' => 460,
				],
			],
		],
		'river' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 140, 140 ],
					],
					'descriptor' => 140,
				],
			],
		],
		'avatar-small' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 25, 25 ],
					],
					'descriptor' => 25,
				],
			],
		],
		'avatar-large' => [
			'sources' => [
				[
					'transforms' => [
						'resize' => [ 212, 212 ],
					],
					'descriptor' => 212,
				],
			],
		],
		'newsroom-header-logo' => [
			'sources' => [
				[
					'transforms' => [
						'w' => [ 225 ],
					],
					'descriptor' => 225,
				],
			],
		],
	]
);

/**
 * Override the default WordPress media templates.
 */
function custom_media_templates() {
	require_once CIVIL_FIRST_FLEET_PATH . '/template-parts/media-templates/attachment-details.php';
	require_once CIVIL_FIRST_FLEET_PATH . '/template-parts/media-templates/attachment-details-two-column.php';
}

add_action( 'print_media_templates', __NAMESPACE__ . '\custom_media_templates' );

/**
 * Gets an attachment's credit (renamed from description via `custom_media_templates`).
 *
 * @param  string $attachment_id The attachment ID.
 * @return string
 */
function get_image_credit( $attachment_id ) {
	$img = get_post( (int) $attachment_id );

	if ( $img instanceof \WP_Post ) {
		return $img->post_content;
	}

	return '';
}

/**
 * Filters the post content and adds a credit field below all images.
 *
 * @param string $content The HTML content.
 */
function add_credit_to_images( $content ) {
	// Collect image IDs and captions (if present).
	preg_match_all(
		"/<img.+?class=[\"'].*?wp-image-(\d{1,}).*?[\"'].*?>.*?(\n?.*?<figcaption.*?<\/figcaption>)?/i",
		$content,
		$images
	);

	if ( ! empty( $images[1] ) ) {
		// Loop through image IDs.
		foreach ( $images[1] as $index => $image_id ) {
			$image_tag = $images[0][ $index ];

			// Get the image credit.
			$image_credit = get_image_credit( $image_id );

			// Insert the image credit.
			if ( ! empty( $image_id ) && ! empty( $image_credit ) ) {
				$credit_tag = sprintf(
					'<span class="credit wp-credit-%1$s">%2$s</span>',
					esc_attr( $image_id ),
					esc_html( $image_credit )
				);

				$content = str_replace( $image_tag, $image_tag . $credit_tag, $content );
			}
		}
	}

	return $content;
}

add_filter( 'the_content', __NAMESPACE__ . '\add_credit_to_images', 9, 1 );
