<?php
/**
 * This class is a custom dispatch system.
 *
 * @package Civil_First_Fleet
 */

if ( ! class_exists( 'Path_Dispatch' ) ) :

	// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedClassFound

	/**
	 * Path Dispatch
	 * =============
	 *
	 * Simply and easily add a URL which fires an action, triggers a callback, and/or loads a template.
	 *
	 * Basic Usage: at any point before init,
	 *
	 *     Path_Dispatch()->add_path( array( 'path' => 'some-path', 'callback' => 'some_function' ) );
	 *
	 * This will cause http://domain.com/some-path/ to call some_function().
	 *
	 * IMPORTANT! You must flush your rewrites after adding a path.
	 *
	 * You can add multiple paths at once with `add_paths()`:
	 *
	 *     Path_Dispatch()->add_paths( array(
	 *         array( 'path' => 'some-path',        'callback' => 'some_function' ),
	 *         array( 'path' => 'custom-feed.json', 'callback' => 'custom_feed' ),
	 *         array( 'path' => 'custom-feed.xml',  'callback' => 'custom_feed' )
	 *     ) );
	 *
	 * The dispatch happens on parse_query, so you can then modify the query via pre_get_posts or do whatever
	 * you have to do. You can even just load a static file and exit if you simply need to render static content.
	 *
	 * When the path is loaded, the action dispatch_path_{$path} is fired. You can hook onto this instead of or
	 * in addition to passing a callback to add_path(s). The callback is optional.
	 *
	 * Lastly, you can set custom rewrites if your paths are more complex. In these cases, the 'path' argument
	 * essentially becomes a slug. See [add_rewrite_rule()](http://codex.wordpress.org/Rewrite_API/add_rewrite_rule)
	 * for details about 'rule', 'redirect' (rewrite), and 'position'.
	 *
	 * Here's a full breakdown of all the path options:
	 *
	 * Path_Dispatch()->add_path( array(
	 *     'path'     => 'some-path',     // required
	 *     'callback' => 'some_function', // optional
	 *     'action'   => '',              // fire this action instead of dispatch_path_{$path}
	 *     'template' => '',              // optional
	 *     'rewrite'  => array(           // optional
	 *         'query_vars' => array(),                          // optional
	 *         'rule'       => '',                               // required (assuming 'rewrite' is set)
	 *         'redirect'   => 'index.php?dispatch=$matches[1]', // optional
	 *         'position'   => 'top'                             // optional
	 *     )
	 * ) );
	 *
	 * Here are examples of using Path Dispatch:
	 *
	 * Simplest possible usages: fires the action 'dispatch_path_my-path' at http://domain.com/my-path/
	 *     Path_Dispatch()->add_path( array( 'path' => 'my-path' ) );
	 * This can even be simplified further as:
	 *     Path_Dispatch()->add_path( 'my-path' );
	 *
	 * Call the function 'my_function' at http://domain.com/my-path/
	 *     Path_Dispatch()->add_path( array(
	 *         'path' => 'my-path',
	 *         'callback' => 'my_function'
	 *     ) );
	 *
	 * Load the template file 'dispatch-custom-page.php' at http://domain.com/my-path/
	 *     Path_Dispatch()->add_path( array(
	 *         'path' => 'my-path',
	 *         'template' => 'custom-page'
	 *     ) );
	 *
	 * Add a custom rewrite rule. Fires the action 'dispatch_path_my-path' at e.g. http://domain.com/my-path/foo/
	 * and sets the query var 'my_path' to 'foo'. This assumes you already registered that query var.
	 *     Path_Dispatch()->add_path( array(
	 *         'path' => 'my-rewrite',
	 *         'rewrite' => array(
	 *             'rule' => 'my-path/(.*)/?',
	 *             'redirect' => 'index.php?dispatch=my-rewrite&my_path=$matches[1]'
	 *         )
	 *     ) );
	 *
	 * Same as above, but registers the query var automatically, and loads the template 'dispatch-my-page.php'.
	 *     Path_Dispatch()->add_path( array(
	 *         'path' => 'my-rewrite',
	 *         'rewrite' => array(
	 *             'rule' => 'my-path/(.+)/?',
	 *             'redirect' => 'index.php?dispatch=my-rewrite&my_path=$matches[1]',
	 *             'query_vars' => 'my_path'
	 *         ),
	 *         'template' => 'my-page'
	 *     ) );
	 *
	 * Same as above, but with multiple query vars, and with a callback instead of a template.
	 *     Path_Dispatch()->add_path( array(
	 *         'path' => 'my-rewrite',
	 *         'rewrite' => array(
	 *             'rule' => 'my-path/([^/]+)/(.+)/?',
	 *             'redirect' => 'index.php?dispatch=my-rewrite&my_path=$matches[1]&my_section=$matches[2]',
	 *             'query_vars' => array( 'my_path', 'my_section' )
	 *         ),
	 *         'callback' => array( My_Singleton(), 'my_method' )
	 *     ) );
	 */
	class Path_Dispatch {

		/**
		 * Query vars that should be allowed.
		 *
		 * @var array
		 */
		public $qv = [ 'dispatch' ];

		/**
		 * Array of baisc paths.
		 *
		 * @var array
		 */
		public $basic_paths = [];

		/**
		 * Array of rewrite paths.
		 *
		 * @var array
		 */
		public $rewrite_paths = [];

		/**
		 * Instance of this class.
		 *
		 * @var Path_Dispatch
		 */
		private static $instance;

		/**
		 * Constructor doesn't actually do anything on a singleton.
		 */
		private function __construct() {
			/* Don't do anything, needs to be initialized via instance() method */
		}

		/**
		 * Don't allow __clone.
		 */
		public function __clone() {
			wp_die( "Please don't __clone Path_Dispatch" );
		}

		/**
		 * Don't allow __wakeup.
		 */
		public function __wakeup() {
			wp_die( "Please don't __wakeup Path_Dispatch" );
		}

		/**
		 * Return the only instance of this class.
		 *
		 * @return Path_Dispatch
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new Path_Dispatch();
				self::$instance->setup();
			}
			return self::$instance;
		}

		/**
		 * Setup class for the first time.
		 */
		public function setup() {
			// Add our query_var, 'dispatch'.
			add_filter( 'query_vars', [ $this, 'add_query_var' ] );

			// Setup rewrite rules for our paths.
			add_action( 'init', [ $this, 'add_rewrite_rules' ], 5 );

			// We're doing this on parse_query to ensure that query vars are set.
			add_action( 'parse_query', [ $this, 'dispatch_path' ] );
		}

		/**
		 * Add a path. This method is the money maker; pass it an array with at least the 'path' key set
		 * (or a string, which will become an array).
		 *
		 * @param string|array $args {
		 *      If string, becomes array( 'path' => $args ). Otherwise, 'path' must be set. In addition to
		 *      the keys mentioned below, you can pass any other key => value pairs. This whole array will be
		 *      passed when the action fires, so you'll be able to access your data at that time.
		 *
		 *      @type string $path The dispatch path. This will be added as a rewrite rule, "($path)/?$".
		 *      @type callback $callback Optional. A valid callback function.
		 *      @type string $action Optional. The action to fire instead of "dispatch_path_{$path}". This action
		 *                           will still be passed this array of $args.
		 *      @type array $rewrite {
		 *          Optional. Add a custom rewrite rule and optionally register query vars.
		 *          @see http://codex.wordpress.org/Rewrite_API/add_rewrite_rule
		 *
		 *          @type string $rule The rewrite rule.
		 *          @type string $redirect Optional. The URL you would like to fetch. Default is 'index.php?dispatch=$matches[1]'
		 *          @type string $position Optional. The rewrite rule position. Default is 'top'.
		 *          @type string|array $query_vars  Optional. Query var(s) to register.
		 *                                          @see http://codex.wordpress.org/Plugin_API/Filter_Reference/query_vars
		 *      }
		 * }
		 *
		 * @uses Path_Dispatch::$basic_paths
		 * @uses Path_Dispatch::$rewrite_paths
		 * @uses Path_Dispatch::$qv
		 *
		 * @return void
		 */
		public function add_path( $args = [] ) {
			if ( is_string( $args ) && ! empty( $args ) ) {
				$args = [
					'path' => $args,
				];
			}

			if ( ! empty( $args['path'] ) ) {
				if ( ! empty( $args['rewrite'] ) ) {
					$this->rewrite_paths[ $args['path'] ] = $args;
					if ( ! empty( $args['rewrite']['query_vars'] ) ) {
						$this->qv = array_merge( $this->qv, (array) $args['rewrite']['query_vars'] );
					}
				} else {
					$this->basic_paths[ $args['path'] ] = $args;
				}

				if ( ! empty( $args['callback'] ) ) {
					add_action( 'dispatch_path_' . $args['path'], $args['callback'] );
				}
			}
		}

		/**
		 * Add multiple paths in one call.
		 *
		 * @see Path_Dispatch::add_path
		 * @uses Path_Dispatch::add_path
		 *
		 * @param array $paths An array of arrays that would be passed to add_path.
		 * @return void
		 */
		public function add_paths( $paths ) {
			foreach ( $paths as $path ) {
				$this->add_path( $path );
			}
		}

		/**
		 * Add the class query var "dispatch" as well as any others added through add_path.
		 *
		 * @uses Path_Dispatch::$qv
		 *
		 * @param array $qv The current query vars.
		 * @return array The modified query vars.
		 */
		public function add_query_var( $qv ) {
			return array_merge( $qv, $this->qv );
		}

		/**
		 * Add rewrite rules for our dispatched paths.
		 *
		 * @uses Path_Dispatch::$basic_paths
		 * @uses Path_Dispatch::$rewrite_paths
		 * @uses add_rewrite_rule
		 *
		 * @return void
		 */
		public function add_rewrite_rules() {
			if ( ! empty( $this->basic_paths ) ) {
				$slugs = array_map( 'preg_quote', array_keys( $this->basic_paths ) );
				$slugs = implode( '|', $slugs );
				add_rewrite_rule( "($slugs)/?$", 'index.php?dispatch=$matches[1]', 'top' );
			}

			if ( ! empty( $this->rewrite_paths ) ) {
				foreach ( $this->rewrite_paths as $args ) {
					if ( ! empty( $args['rewrite']['rule'] ) ) {
						if ( empty( $args['rewrite']['redirect'] ) ) {
							$args['rewrite']['redirect'] = 'index.php?dispatch=$matches[1]';
						}
						if ( empty( $args['rewrite']['position'] ) ) {
							$args['rewrite']['position'] = 'top';
						}
						add_rewrite_rule( $args['rewrite']['rule'], $args['rewrite']['redirect'], $args['rewrite']['position'] );
					}
				}
			}
		}

		/**
		 * Trigger an action when a dispatched path is requested. Also, potentially load
		 * a template if that was set.
		 *
		 * @param  array $query Dispatch query.
		 *
		 * @uses   Path_Dispatch::$basic_paths
		 * @uses   Path_Dispatch::$rewrite_paths
		 *
		 * @return void
		 */
		public function dispatch_path( &$query ) {
			$path = get_query_var( 'dispatch' );
			if ( $query->is_main_query() && $path ) {
				if ( ! empty( $this->basic_paths[ $path ] ) ) {
					$args = $this->basic_paths[ $path ];
				} elseif ( ! empty( $this->rewrite_paths[ $path ] ) ) {
					$args = $this->rewrite_paths[ $path ];
				}
				if ( empty( $args['action'] ) ) {
					do_action( 'dispatch_path_' . $path, $args ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
				} else {
					do_action( $args['action'], $args ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.DynamicHooknameFound
				}

				if ( ! empty( $args['template'] ) ) {
					get_template_part( 'dispatch', $args['template'] );
					exit;
				}
			}
		}
	}

	/**
	 * Return the path dispatch instance.
	 *
	 * @return Path_Dispatch
	 */
	function path_dispatch() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound
		return Path_Dispatch::instance();
	}

endif;
