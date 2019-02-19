<?php
/**
 * Partials class file.
 *
 * @copyright 2014-2017 Alley Interactive
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

/**
 * Template partials controller.
 */
class Partials {

	/**
	 * Set the default cache TTL to 15 minutes for cached partials.
	 *
	 * @var integer
	 */
	public $default_cache_ttl = 900;

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
	 * The stack of $GLOBALS['post'] prior to this class altering it.
	 *
	 * @var WP_Post
	 */
	public $original_posts = array();

	/**
	 * The template stack.
	 *
	 * @var array
	 */
	public $stack = array();

	/**
	 * The currently-active partial.
	 *
	 * @var Partial
	 */
	public $current_partial;

	/**
	 * Backup the current global `$post`.
	 *
	 * @access protected
	 */
	protected function preserve_post() {
		if ( ! empty( $GLOBALS['post'] ) ) {
			$this->original_posts[] = $GLOBALS['post'];
		} else {
			$this->original_posts[] = null;
		}
	}

	/**
	 * Restore the backup of the global $post.
	 *
	 * If our template part changed the global post, we reset it to what it was
	 * before loading the template part. Note that we're not calling
	 * `wp_reset_postdata()` because `$post` may not have been the current post
	 * from the global query.
	 *
	 * @access protected
	 */
	protected function restore_post() {
		global $post;

		if ( empty( $this->original_posts ) ) {
			return;
		}

		$original_post = array_pop( $this->original_posts );

		if ( $original_post !== $post ) {
			$post = $original_post; // WPCS: override ok.

			if ( $post instanceof \WP_Post ) {
				setup_postdata( $post );
			}
		}
	}

	/**
	 * Dispatch the template load.
	 *
	 * This method allows you to load a template part in a variety of helpful
	 * ways. For instance, you can iterate over an array, loading the partial
	 * once for each member of the array, or you can run The Loop, loading the
	 * partial once for each post in the query.
	 *
	 * If the global `$post` and postdata change throughout this process, it
	 * will be restored at the end.
	 *
	 * @see Partials::preserve_post().
	 * @see Partials::restore_post().
	 * @see Partials::loop().
	 * @see Partials::iterate().
	 * @see Partials::load_single().
	 *
	 * @param array $args {
	 *     Options for loading the partial.
	 *
	 *     @type string         $slug      The template slug/base to load.
	 *     @type string         $name      Optional. The template name/variation to load.
	 *     @type array          $variables Optional. key => value pairs you want the
	 *                                     partial to be able to access.
	 *     @type WP_Query|array $loop      Optional. WP_Query, array of WP_Posts, or
	 *                                     array of post IDs to loop over.
	 *                                     {@see Partials::loop()}.
	 *     @type array          $iterate   Optional. Array of values to iterate over.
	 *                                     {@see Partials::iterate()}.
	 *     @type string         $parent    Optional. The parent template's slug. This is
	 *                                     set automatically, but you can override it if
	 *                                     need be.
	 *     @type bool|array     $cache     If set, the template part will be cached. If
	 *                                     true, results will be cached for
	 *                                     {@see Partials::$default_cache_ttl} and
	 *                                     the transient will be generated from this
	 *                                     variable. Optionally, either can be set by
	 *                                     passing an array with 'key' and/or 'ttl' keys.
	 * }
	 */
	public function load( $args ) {
		// `slug` is required.
		if ( empty( $args['slug'] ) ) {
			return;
		}

		$cache = ! empty( $args['cache'] );
		if ( ! empty( $args['return'] ) ) {
			// Individual Partial objects can also accept this arg for more
			// advanced integrations. We don't need it to here, so unset it.
			unset( $args['return'] );
			$return = true;
		} else {
			$return = false;
		}

		if ( $cache ) {
			if ( is_bool( $args['cache'] ) ) {
				$args['cache'] = array();
			}

			// If no key was provided, make one.
			if ( empty( $args['cache']['key'] ) ) {
				$args['cache']['key'] = self::cache_key( $args );
			}

			// If no TTL was supplied, set a default.
			if ( ! isset( $args['cache']['ttl'] ) ) {
				$args['cache']['ttl'] = $this->default_cache_ttl;
			}

			// If we have a cache hit, serve it.
			$partial = get_transient( $args['cache']['key'] );
			if ( false !== $partial ) {
				if ( $return ) {
					return $partial;
				} else {
					echo $partial; // wpcs: xss ok.
					return;
				}
			}
		}

		if ( $return || $cache ) {
			ob_start();
		}

		if ( ! isset( $args['parent'] ) && isset( $this->current_partial->slug ) ) {
			$args['parent'] = array( $this->current_partial->slug, $this->current_partial->name );
		}

		$this->preserve_post();

		if ( isset( $args['loop'] ) ) {
			$results = $this->loop( $args );
		} elseif ( isset( $args['iterate'] ) ) {
			$results = $this->iterate( $args );
		} else {
			$results = $this->load_single( $args );
		}

		$this->restore_post();

		// If we are returning or caching, kill the output buffer.
		if ( $return || $cache ) {
			$contents = ob_get_clean();

			if ( $cache ) {
				set_transient( $args['cache']['key'], $contents, $args['cache']['ttl'] );
			}

			if ( $return ) {
				return $contents;
			} else {
				echo $contents; // wpcs: xss ok.
			}
		}
	}

	/**
	 * Load an individual partial.
	 *
	 * @see Partial::load().
	 * @see Partials::push().
	 * @see Partials::pop().
	 *
	 * @param array $args {@see Partials::load()}.
	 */
	public function load_single( $args ) {
		$this->push( new Partial( $args ) );
		$results = $this->current_partial->load();
		$this->pop();
		return $results;
	}

	/**
	 * Iterate a WP_Query or array of posts or post IDs over a given template
	 * part.
	 *
	 * While iterating, the postdata is setup for each post. Therefore, each
	 * partial can use functions required to be in The Loop (e.g. the_title()).
	 *
	 * @see Partials::loop_query()
	 * @see Partials::loop_posts()
	 *
	 * @param array $args {@see Partials::loop()}.
	 */
	public function loop( $args ) {
		$source = $args['loop'];
		unset( $args['loop'] );
		if ( $source instanceof \WP_Query ) {
			return $this->loop_query( $source, $args );
		} elseif ( is_array( $source ) ) {
			return $this->loop_posts( $source, $args );
		}
	}

	/**
	 * Load a partial for each post in a WP_Query loop.
	 *
	 * @access protected
	 *
	 * @see Partials::load_single()
	 *
	 * @param WP_Query $query WP_Query object to loop.
	 * @param array    $args {@see Partials::loop()}.
	 */
	protected function loop_query( $query, $args ) {
		$return = array();

		while ( $query->have_posts() ) {
			$query->the_post();
			$args['variables']['index'] = $query->current_post;
			$return[] = $this->load_single( $args );
		}

		return $return;
	}

	/**
	 * Load a partial for each post in an array of posts or post IDs.
	 *
	 * @access protected
	 *
	 * @see Partials::load_single()
	 *
	 * @param array $posts WP_Post objects or Post IDs.
	 * @param array $args {@see Partials::loop()}.
	 */
	protected function loop_posts( $posts, $args ) {
		$return = array();
		global $post;

		foreach ( $posts as $i => $post ) {
			if ( ! ( $post instanceof \WP_Post ) ) {
				$post = get_post( $post ); // WPCS: override ok.
			}

			setup_postdata( $post );
			$args['variables']['index'] = $i;
			$return[] = $this->load_single( $args );
		}

		return $return;
	}

	/**
	 * Iterate over an array, loading a given template part for each item in the
	 * array.
	 *
	 * This method will load the given partial and add two variables to its
	 * variables array: `index` and `item`. `index` will hold the array key, and
	 * `item` will hold the array value.
	 *
	 * @see Partials::load_single()
	 *
	 * @param array $args {@see Partials::loop()}.
	 */
	public function iterate( $args ) {
		$return = array();
		$items = (array) $args['iterate'];
		unset( $args['iterate'] );

		foreach ( $items as $index => $item ) {
			$args['variables']['item'] = $item;
			$args['variables']['index'] = $index;
			$return[] = $this->load_single( $args );
		}

		return $return;
	}

	/**
	 * Get a variable for the currently-active partial.
	 *
	 * @see Partial::get_var().
	 *
	 * @param  string $key     {@see Partial::get_var()}.
	 * @param  mixed  $default {@see Partial::get_var()}.
	 * @return mixed           {@see Partial::get_var()}.
	 */
	public function get_var( $key, $default = null ) {
		if ( empty( $this->current_partial ) ) {
			return $default;
		}

		return $this->current_partial->get_var( $key, $default );
	}

	/**
	 * Push a partial onto the stack and set it as the current partial.
	 *
	 * @param  Partial $partial The partial we're loading.
	 */
	protected function push( $partial ) {
		$this->stack[] = $partial;
		$this->current_partial = $partial;
	}

	/**
	 * Pop a partial off the top of the stack and set the current partial to the
	 * next one down.
	 */
	protected function pop() {
		array_pop( $this->stack );
		$this->current_partial = end( $this->stack );
	}

	/**
	 * Generate a cache key from arbitrary arguments.
	 *
	 * @param  mixed $args Arguments to md5 into a cache key.
	 * @return string
	 */
	public static function cache_key( $args ) {
		return 'partial_' . md5( serialize( $args ) );
	}
}
