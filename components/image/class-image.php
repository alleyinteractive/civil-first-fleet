<?php
/**
 * Image component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Image component class.
 */
class Image extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'image';

	/**
	 * Register image sizes.
	 *
	 * @var array
	 */
	public static $sizes = [];

	/**
	 * Register image sizes.
	 *
	 * @var array
	 */
	public static $breakpoints = [];

	/**
	 * Register WPCOM Thumbnail Editor Sizes
	 *
	 * @var array
	 */
	public static $crop_sizes = [];

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'alt'         => '',
			'crops'       => [],
			'sources'     => [],
			'url'         => '',
		];
	}

	/**
	 * Default component settings.
	 *
	 * @return array Default data.
	 */
	public function default_settings() : array {
		return [
			'transform'    => 'resize',
			'retina'       => true,
			'lazyload'     => true,
			'picture'      => false,
			'aspect_ratio' => 9 / 16,
			'is_featured' => false,
		];
	}

	/**
	 * Register sizes at once.
	 *
	 * @param array $sizes Array of arguments for register_size.
	 */
	public static function register_sizes( array $sizes ) {
		self::$sizes = array_merge( self::$sizes, $sizes );
	}

	/**
	 * Register breakpoints.
	 *
	 * @param array $breakpoints Array of breakpoints.
	 */
	public static function register_breakpoints( array $breakpoints ) {
		self::$breakpoints = array_merge( self::$breakpoints, $breakpoints );
	}

	/**
	 * Register crops for WPCOM Thumbnail Editor.
	 *
	 * @param  array $crop_sizes Array of crop sizes.
	 */
	public static function register_crop_sizes( array $crop_sizes ) {
		self::$crop_sizes = array_merge( self::$crop_sizes, $crop_sizes );

		// Register image sizes.
		add_action(
			'after_setup_theme',
			function() {
				foreach ( Image::$crop_sizes as $crop_size ) {
					foreach ( $crop_size as $key => $params ) {
						$params = wp_parse_args(
							$params,
							[
								'crop'   => false,
								'height' => 0,
								'width'  => 0,
							]
						);
						add_image_size( $key, $params['width'], $params['height'], $params['crop'] );
					}
				}
			}
		);

		// Setup WPCOM Thumbnail Editor image ratio map.
		add_filter(
			'wpcom_thumbnail_editor_args',
			function( $args ) {
				$mapping = [];
				foreach ( Image::$crop_sizes as $key => $crop_size ) {
					$mapping[ $key ] = $mapping[ $key ] ?? [];
					$mapping[ $key ] = array_merge( $mapping[ $key ], array_keys( $crop_size ) );
				}
				$args['image_ratio_map'] = $mapping;
				return $args;
			}
		);
	}

	/**
	 * Setup this component using a post.
	 *
	 * @param int $post_id Post ID.
	 * @return Component Current instance of this class.
	 */
	public function set_post_id( int $post_id ) {
		// Get the URL.
		$url = strtok( wp_get_attachment_image_url( absint( $post_id ), 'full' ), '?' );

		$this->data( 'url', $url );

		// Get crops from post meta.
		$crops = (array) get_post_meta( $post_id, 'wpcom_thumbnail_edit', true );
		$this->set_data( 'crops', array_filter( $crops ) );

		return $this;
	}

	/**
	 * Set the URL.
	 *
	 * @param string $url Image URL.
	 * @return Component Current instance of this class.
	 */
	public function set_url( string $url ) {
		$this->data( 'url', $url );
		return $this;
	}

	/**
	 * Loads a predefined set of settings from the static sizes array.
	 *
	 * @param  string $key Key of the size.
	 * @return Component Current instance of this class.
	 */
	public function size( string $key ) {
		$sizes = self::$sizes;
		$crops = $this->data( 'crops' );

		// Sizes is a shortcut to set this components data.
		if ( ! empty( $sizes[ $key ] ) ) {
			$this->data( wp_parse_args( $sizes[ $key ], $this->data() ) );
		}

		// If the size key matches a crop option, apply that transform.
		if ( ! empty( $crops[ $key ] ) ) {
			$sources = $this->data( 'sources' );
			foreach ( $sources as &$source ) {

				// Convert stored coordinates into crop friendly parameters.
				$source['transforms'] = array_merge(
					[
						'crop' => [
							$crops[ $key ][0] . 'px',
							$crops[ $key ][1] . 'px',
							( $crops[ $key ][2] - $crops[ $key ][0] ) . 'px',
							( $crops[ $key ][3] - $crops[ $key ][1] ) . 'px',
						],
					],
					$source['transforms']
				);
			}
			$this->set_data( 'sources', $sources );
		}

		return $this;
	}

	/**
	 * Get base URL without any photon arguments applied.
	 *
	 * @return string Base URL.
	 */
	public function get_base_url() : string {
		return strtok( $this->data( 'url' ), '?' );
	}

	/**
	 * Get appropriate bottom-padding style for image aspect ratio
	 *
	 * @return string Padding-bottom setting.
	 */
	public function get_aspect_ratio_padding() : string {
		$ratio_setting = $this->get_setting( 'aspect_ratio' );

		// Turn off intrinsic sizing if aspect ratio is empty or false.
		if ( empty( $ratio_setting ) ) {
			return '';
		}

		$ratio_percentage = $ratio_setting * 100;
		return "padding-bottom: {$ratio_percentage}%;";
	}

	/**
	 * Get source URL for lqip functionality
	 *
	 * @return string LQIP source URL
	 */
	public function get_lqip_src() {
		$aspect_ratio = $this->get_setting( 'aspect_ratio' );
		return $this->apply_transforms(
			[
				'quality' => [ 60 ],
				'resize'  => [ 60, ( 60 * $aspect_ratio ) ],
			]
		);
	}

	/**
	 * Get the srcset for <img> element.
	 *
	 * @return array Sources.
	 */
	public function get_srcset() : array {
		$srcset  = [];
		$sources = (array) $this->data( 'sources' );

		foreach ( $sources as $params ) {
			// Get source URL.
			$this->apply_transforms( $params['transforms'] );
			$src_url = $this->data( 'url' );

			// Get descriptor.
			$descriptor = $params['descriptor'];

			// Add retina source to srcset, if applicable.
			if ( $this->get_setting( 'retina' ) ) {
				$this->apply_transforms( $params['transforms'], 2 );
				$retina_descriptor = $descriptor * 2;
				$srcset[]          = "{$this->data( 'url' )} {$retina_descriptor}w";
			}

			$srcset[] = "{$src_url} {$descriptor}w";
		}

		return $srcset;
	}

	/**
	 * Get the source string for <picture> element.
	 *
	 * @return void
	 */
	public function source_tags() {
		$source_tags = [];
		$sources     = (array) $this->data( 'sources' );

		foreach ( $sources as $params ) {
			// Get source URL.
			$transforms = $params['transforms'];
			$this->apply_transforms( $transforms );
			$src_url = $this->data( 'url' );

			// Add retina source to srcset, if applicable.
			if ( $this->get_setting( 'retina' ) ) {
				$this->apply_transforms( $transforms, 2 );
				$srcset_string = "{$src_url} 1x, {$this->data( 'url' )} 2x";
			} else {
				$srcset_string = $src_url;
			}

			// Set tag replace string based on layzload option.
			$tag_string = $this->get_setting( 'lazyload' ) ?
				'<source data-srcset="%1$s" media="%2$s" />' :
				'<source srcset="%1$s" media="%2$s" />';

			// Construct source tag.
			$source_tags[] = sprintf(
				$tag_string,
				esc_attr( $srcset_string ),
				esc_attr( $this->get_media( $params['media'] ) )
			);
		}

		// This prints <source> tags, all of which have been esacaped.
		// phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped, WordPress.Security.EscapeOutput.OutputNotEscaped
		echo implode( '', $source_tags );
		// phpcs:enable
	}

	/**
	 * Get media attribute for a specific source
	 *
	 * @param array $media_params Media query parameters.
	 * @return string Media attribute content.
	 */
	public function get_media( $media_params ) : string {
		$breakpoints = self::$breakpoints;

		if ( ! is_array( $media_params ) ) {
			return false;
		}

		// Use custom media if it's set.
		if ( ! empty( $media_params['custom'] ) ) {
			return $media_params['custom'];
		}

		// Compile min and max width settings.
		$min_width = ! empty( $media_params['min'] ) ?
			"(min-width: {$breakpoints[ $media_params['min'] ]})" :
			false;
		$max_width = ! empty( $media_params['max'] ) ?
			"(max-width: {$breakpoints[ $media_params['max'] ]})" :
			false;

		if ( $min_width && $max_width ) {
			return "{$min_width} and {$max_width}";
		} elseif ( $min_width ) {
			return $min_width;
		} elseif ( $max_width ) {
			return $max_width;
		}

		// Default to 'all'.
		return 'all';
	}

	/**
	 * Disable lazyloading for this instance.
	 */
	public function disable_lazyload() {
		$this->set_setting( 'lazyload', false );
		return $this;
	}

	/**
	 * Set aspect ratio of image for use with CSS intrinsic ratio sizing.
	 * Set to false to turn off intrinsic sizing.
	 *
	 * @param float|bool $ratio Aspect ratio of image expressed as a decimal.
	 */
	public function aspect_ratio( $ratio ) {
		$this->set_setting( 'aspect_ratio', $ratio );
		return $this;
	}

	/**
	 * Set the width of an image. Defaults to pixels, supports percentages.
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#w
	 *
	 * @param int $width  Resized width.
	 * @param int $density_multiplier screen density multiplier.
	 * @return Component Current instance of this class.
	 */
	public function w( int $width, $density_multiplier = 1 ) {
		$value = absint( $width ) * $density_multiplier;
		return $this->apply_transform( [ 'w' => $value ] );
	}

	/**
	 * Set the height of an image. Defaults to pixels, supports percentages.
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#h
	 *
	 * @param int $height  Resized height.
	 * @param int $density_multiplier screen density multiplier.
	 * @return Component Current instance of this class.
	 */
	public function h( int $height, $density_multiplier = 1 ) {
		$value = absint( $height ) * $density_multiplier;
		return $this->apply_transform( [ 'h' => $value ] );
	}

	/**
	 * Crop an image by percentages x-offset,y-offset,width,height (x,y,w,h).
	 * Percentages are used so that you don’t need to recalculate the cropping
	 * when transforming the image in other ways such as resizing it.Original
	 * image: 4-MCM_0830-1600×1064.jpgcrop=12,25,60,60 takes a 60% by 60%
	 * rectangle from the source image starting at 12% offset from the left and
	 * 25% offset from the top.
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#crop
	 *
	 * @param int|string $x      X-offset value.
	 * @param int|string $y      Y-offset value.
	 * @param int|string $width  Width.
	 * @param int|string $height Height.
	 * @return Component Current instance of this class.
	 */
	public function crop( $x, $y, $width, $height ) {
		$value = sprintf(
			'%1$s,%2$s,%3$s,%4$s',
			$x,
			$y,
			$width,
			$height
		);
		return $this->apply_transform( [ 'crop' => $value ] );
	}

	/**
	 * Resize and crop an image to exact width,height pixel dimensions. Set the
	 * first number as close to the target size as possible and then crop the
	 * rest. Which direction it’s resized and cropped depends on the aspect
	 * ratios of the original image and the target size.
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#resize
	 *
	 * @param int $width  Resized width.
	 * @param int $height Resized height.
	 * @param int $density_multiplier screen density multiplier.
	 * @return Component Current instance of this class.
	 */
	public function resize( int $width, int $height, $density_multiplier = 1 ) {
		$value = sprintf(
			'%1$d,%2$d',
			absint( $width ) * $density_multiplier,
			absint( $height ) * $density_multiplier
		);
		return $this->apply_transform( [ 'resize' => $value ] );
	}

	/**
	 * Fit an image to a containing box of width,height dimensions. Image
	 * aspect ratio is maintained.
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#fit
	 *
	 * @param int $width  Resized width.
	 * @param int $height Resized height.
	 * @param int $density_multiplier screen density multiplier.
	 * @return Component Current instance of this class.
	 */
	public function fit( int $width, int $height, $density_multiplier = 1 ) {
		$value = sprintf(
			'%1$d,%2$d',
			absint( $width ) * $density_multiplier,
			absint( $height ) * $density_multiplier
		);
		return $this->apply_transform( [ 'fit' => $value ] );
	}

	/**
	 * Modify compression quality of source image
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#quality
	 *
	 * @param int $percentage Quality percentage.
	 * @return Component Current instance of this class.
	 */
	public function quality( int $percentage ) {
		$value = absint( $percentage );
		return $this->apply_transform( [ 'quality' => $value ] );
	}

	/**
	 * Apply a single transform to the current source URL
	 *
	 * @see  https://developer.wordpress.com/docs/photon/api/#fit
	 *
	 * @param array $transform_args Transform keys/values to apply to source URL.
	 * @return Component Current instance of this class.
	 */
	public function apply_transform( $transform_args ) {
		return $this->set_url( add_query_arg( $transform_args, $this->data( 'url' ) ) );
	}

	/**
	 * Apply an array of transforms to an image src URL
	 *
	 * @param array $transforms         parameters for all transforms to apply.
	 * @param int   $density_multiplier screen density multiplier.
	 * @return Component Current instance of this class.
	 */
	public function apply_transforms( array $transforms, $density_multiplier = 1 ) {
		foreach ( $transforms as $transform => $values ) {
			if ( ! method_exists( $this, $transform ) ) {
				continue;
			}

			// Add multiplier.
			$values[] = $density_multiplier;

			call_user_func_array(
				array( $this, $transform ),
				$values
			);
		}

		return $this;
	}

	/**
	 * Render this component using the correct layout option.
	 */
	public function render_picture() {
		\ai_get_template_part(
			$this->get_component_path( 'picture' ),
			array(
				'component'  => $this,
				'stylesheet' => 'image',
			)
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Image  An instance of this component.
 */
function image( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Image {
	return new Image( $settings, $data );
}
