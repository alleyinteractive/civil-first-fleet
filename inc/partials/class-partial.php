<?php
/**
 * Partial class file.
 *
 * @copyright 2014-2017 Alley Interactive
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Template partial.
 */
class Partial {

	/**
	 * The template slug.
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * The template "name" (variation).
	 *
	 * @var string
	 */
	public $name = null;

	/**
	 * Template variables.
	 *
	 * @var array
	 */
	public $variables = [];

	/**
	 * The path to the calling/parent template.
	 *
	 * @var string
	 */
	public $parent;

	/**
	 * Should the template part be output (false) or returned (true).
	 *
	 * @var bool Default false.
	 */
	public $return = false;

	/**
	 * Class constructor.
	 *
	 * @param array $args {@see Partial::parse_args()}.
	 */
	public function __construct( $args ) {
		$this->parse_args( $args );
	}

	/**
	 * Parse the passed arguments into object properties.
	 *
	 * @see get_template_part().
	 *
	 * @param array $args {
	 *     Arguments defining this object's properties.
	 *
	 *     @type string $slug      Template slug.
	 *     @type string $name      Optional. Template name/variation.
	 *     @type array  $variables Optional. key => value pairs you want to
	 *                             access from the template.
	 *     @type array  $parent    Optional. The parent (calling) template's slug
	 *                             and name If $slug starts with an underscore,
	 *                             the parent template's filename will be prepended
	 *                             to $slug (and the underscore replaced with a
	 *                             dash). For instance, if $parent is
	 *                             'template-parts/foo/bar' and $slug is '_post',
	 *                             $slug will become 'template-parts/foo/bar-post'.
	 *     @type bool   $return    Optional. Set to true to return the template
	 *                             contents instead of output them.
	 * }
	 */
	public function parse_args( $args ) {
		if ( isset( $args['slug'] ) ) {
			$this->slug = $args['slug'];
		}
		if ( isset( $args['name'] ) ) {
			$this->name = $args['name'];
		}
		if ( isset( $args['variables'] ) ) {
			$this->variables = $args['variables'];
		}
		if ( isset( $args['parent'] ) ) {
			$this->parent = $args['parent'];
		}
		if ( isset( $args['return'] ) ) {
			$this->return = $args['return'];
		}

		// If the slug starts with an underscores, it's a sub-partial.
		if ( $this->parent && '_' === substr( $this->slug, 0, 1 ) ) {
			$this->slug = $this->get_parent_base() . str_replace( '_', '-', $this->slug );
		}
	}

	/**
	 * Load the template part.
	 *
	 * @see get_template_part().
	 */
	public function load() {
		if ( $this->return ) {
			return $this->get_contents();
		} else {
			$this->get_template_part();
		}
	}

	/**
	 * Load the template part.
	 *
	 * @see get_template_part().
	 */
	public function get_template_part() {
		if ( 0 === validate_file( $this->slug ) && 0 === validate_file( $this->name ) ) {
			get_template_part( $this->slug, $this->name );
		}
	}

	/**
	 * Return the template part, instead of outputting it.
	 *
	 * @return string
	 */
	public function get_contents() {
		ob_start();
		$this->get_template_part();
		return ob_get_clean();
	}

	/**
	 * Get a variable for this template part.
	 *
	 * @param string $key     The variable to get.
	 * @param mixed  $default Optional. If the variable doesn't exist, this will
	 *                        be returned. Defaults to null.
	 * @return mixed          The variable value if it exists, otherwise $default.
	 */
	public function get_var( $key, $default = null ) {
		if ( array_key_exists( $key, $this->variables ) ) {
			return $this->variables[ $key ];
		}

		return $default;
	}

	/**
	 * Determine the parent file that was actually loaded.
	 *
	 * `get_template_part()` doesn't let us know if the `$name` argument had any
	 * impact in loading the file. Therefore, we need to first identify the
	 * parent to always correctly load a sub-partial.
	 *
	 * @return string
	 */
	protected function get_parent_base() {
		// If there's no $name, we can keep it simple.
		if ( empty( $this->parent[1] ) ) {
			return $this->parent[0];
		}

		// Locate the parent template that was loaded.
		$templates = [];
		$name      = (string) $this->parent[1];
		if ( '' !== $name ) {
			$templates[] = "{$this->parent[0]}-{$name}.php";
		}
		$templates[] = "{$this->parent[0]}.php";
		$located     = locate_template( $templates, false );

		// If we have a located template, and it contains the $name, return it.
		if ( $located && false !== strpos( $located, "{$this->parent[0]}-{$name}.php" ) ) {
			return "{$this->parent[0]}-{$name}";
		}

		// Otherwise, just return the parent's slug.
		return $this->parent[0];
	}
}
