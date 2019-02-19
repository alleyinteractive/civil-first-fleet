<?php
/**
 * Stylesheets class file
 *
 * @copyright 2014-2018 Alley Interactive
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

/**
 * Template partials controller.
 */
class Stylesheets {
	/**
	 * JSON for classnames
	 *
	 * @var integer
	 */
	public $classname_json_filepath = false;

	/**
	 * Full classname manifest
	 *
	 * @var  array
	 */
	public $classname_manifest = [];

	/**
	 * Currently active stylesheet name
	 *
	 * @var string
	 */
	public $current_stylesheet;

	/**
	 * Currently active stylesheet classnames array
	 *
	 * @var string
	 */
	public $current_stylesheet_classnames = [];

	/**
	 * Holds references to the singleton instances.
	 *
	 * @var array
	 */
	private static $instance;

	/**
	 * Unused.
	 */
	private function __construct() {
		// Don't do anything, needs to be initialized via instance() method.
	}

	/**
	 * Get an instance of the class.
	 *
	 * @return Partials
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new static();
		}
		return self::$instance;
	}

	/**
	 * Set filepath of classnames manifest and read it in.
	 *
	 * @param bool  $ajax Whether or not this is an ajax call.
	 * @param mixed $json_filepath The JSON file path.
	 */
	public function setup( $ajax = false, $json_filepath = false ) {
		if ( empty( $json_filepath ) ) {
			$this->set_json_classname_filepath( CIVIL_CMS_PATH . '/client/build/classnames.json' );
		} else {
			$this->set_json_classname_filepath( $json_filepath );
		}

		$this->classname_manifest = $this->get_classname_manifest( $this->classname_json_filepath );

		if ( ! $ajax ) {
			$this->print_json( $this->classname_manifest );
		}
	}

	/**
	 * Set stylesheet to use for this context
	 *
	 * @param  string $stylesheet Stylesheet to get classnames from.
	 * @return void
	 */
	public function use_stylesheet( $stylesheet ) {
		$this->current_stylesheet = $stylesheet;
		if ( ! empty( $this->classname_manifest[ $stylesheet ] ) ) {
			$this->current_stylesheet_classnames = $this->classname_manifest[ $stylesheet ];
		} else {
			$this->current_stylesheet_classnames = [];
		}
	}

	/**
	 * Output classname mappings as JSON for use in javascript components.
	 *
	 * @param  array $manifest Classname mappings.
	 * @return void
	 */
	private function print_json( $manifest ) {
		$camel_mapping = [];
		foreach ( $manifest as $stylesheet => $classnames ) {
			$camel_classnames = [];
			foreach ( $classnames as $classname => $local ) {
				$camel_classnames[ $this->camel_case( $classname ) ] = $local;
			}
			$camel_mapping[ $stylesheet ] = $camel_classnames;
		}

		printf( '<script class="civil-class-mappings" type="text/javascript">window.civilCMSClassnames = %1$s</script>', wp_json_encode( $camel_mapping ) );
	}

	/**
	 * Convert a hyphenated string to camelCase
	 *
	 * @param  string $string String to convert to camelCase.
	 * @return string
	 */
	private function camel_case( $string ) {
		$words = explode( '-', $string );
		$uppercase_words = array_map(
			function( $word ) {
					return ucfirst( $word );
			}, $words
		);
		return lcfirst( implode( '', $uppercase_words ) );
	}

	/**
	 * Get a localized classname from this template part's stylesheet
	 *
	 * @param  string $classname The classname to get.
	 * @return string           The localized version of the provided classname if it exists, otherwise the unmodified classname.
	 */
	public function get_classname( $classname ) {
		if ( array_key_exists( $classname, $this->current_stylesheet_classnames ) ) {
			$classes = $this->current_stylesheet_classnames[ $classname ];
			$composed_class_list = array_map(
				function( $local_class ) {
						return sanitize_html_class( $local_class );
				},
				explode( ' ', $classes )
			);

			// Build an array of classnames without the CSS module hash.
			$base_classes = array_filter(
				array_map(
					function( $output_class ) {
						$base_class = explode( '___', $output_class );
						if ( 2 === count( $base_class ) ) {
							  return $base_class[0];
						}
					},
					$composed_class_list
				)
			);

			// Merge hash and unhashed versions.
			$composed_class_list = array_merge(
				$composed_class_list,
				$base_classes
			);

			return implode( ' ', $composed_class_list );
		}

		return $classname;
	}

	/**
	 * Get an array of classnames,
	 *
	 * @param array  $static_classes Indexed array of classes to merge.
	 * @param array  $dynamic_classes Associative array of classes.
	 *  Keys are classes, values are booleans determining if that class should print.
	 * @param string $stylesheet  Optional. Stylesheet to get classname from. If not provided,
	 *                            will use $this->current_stylesheet.
	 * @return array               Array of valid classnames
	 */
	public function get_classnames( array $static_classes, array $dynamic_classes = [], $stylesheet = false ) {
		$output_classes = [];

		// If explicit stylesheet name is provided, preserve currently set stylesheet.
		if ( $stylesheet ) {
			$old_stylesheet = $this->current_stylesheet;
			$this->use_stylesheet( $stylesheet );
		}

		// Loop through static classes and add them to output array.
		if ( ! empty( $static_classes ) ) {
			foreach ( $static_classes as $classname ) {
				$output_classes[] = $this->get_classname( $classname );
			}
		}

		// Loop through dynamic classes, evaluate value, and add to output array if true.
		if ( ! empty( $dynamic_classes ) ) {
			foreach ( $dynamic_classes as $classname => $should_print ) {
				if ( $should_print ) {
					$output_classes[] = $this->get_classname( $classname );
				}
			}
		}

		// If explicit stylesheet name is provided, restore currently set stylesheet.
		if ( $stylesheet ) {
			$this->use_stylesheet( $old_stylesheet );
		}

		return $output_classes;
	}

	/**
	 * Get a localized classname from this template part's stylesheet
	 *
	 * @param string $path set directory/location for json classname manifests.
	 * @return void
	 */
	public function set_json_classname_filepath( $path ) {
		$this->classname_json_filepath = $path;
	}

	/**
	 * Get a localized classname from this template part's stylesheet.
	 *
	 * @return array
	 */
	public function get_classname_manifest() {
		if ( file_exists( $this->classname_json_filepath ) && 0 === validate_file( $this->classname_json_filepath ) ) {
			ob_start();
			include $this->classname_json_filepath;
			return json_decode( ob_get_clean(), true );
		}

		return [];
	}
}
