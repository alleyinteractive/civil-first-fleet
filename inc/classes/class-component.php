<?php
/**
 * This class is a Component system to make building WordPress components easy.
 *
 * @todo  Add unit tests.
 * @todo  Add additional documentation.
 * @todo  Add support for CSS modules.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Components
 * ==========
 * Build WordPress themes using Components.
 *
 * Components are reusable building blocks. They provide a base for easily
 * writing and maintaing nearly anything that can be considered stand alone
 * and discrete in functionality. If you follow the primary principles of
 * developing with components you'll cut time from your development cycle.
 *
 *
 * Components Concepts
 * ===================
 * Components are built to be reusable. As such they follow a few basic
 * rules.
 *
 * Your component should render identically when rendered with the same data.
 * Modifying the component output from an outside context is frowned upon.
 * This ensures components are predictable and helps with debugging. This means
 * component code should not contain any WordPress hooks, reference global
 * variables, or access outside variables. All data should be passed directly
 * to the component using settings or data.
 *
 * Components are most powerful when used for both the backend interface and
 * frontend rendering. With a deep integration for FieldManager, reusing your
 * components is very straight forward.
 *
 *
 * Using Components
 * ================
 * When extending this class, the only required field is $this->slug. This
 * slug is used as the unique handler for your component. This slug dictates
 * the path used to your component files.
 *
 * Components provide helper getters and setters to make manipulating and
 * controlling your components easy. There are also two main sources of
 * data for controlling and modifying the component.
 *
 * $this->settings contain meta data for the component. Classes, admin
 * interface modifications, or other display flags are useful as settings.
 *
 * $this->data is the raw data of the component used for rendering. Combine
 * this with the default_fm_fields function for a powerful combination that
 * allows you to easily pass stored data directly into a component for
 * rendering.
 *
 * Usage
 * ============
 *
 * Output a hero component anywhere.
 *
 *     Component\hero()
 *         ->set_option( 'classes', 'hero--homepage', true )
 *         ->set_data( get_post_meta( get_the_ID(), 'hero', true ) )
 *         ->render();
 *
 *
 * Render the Fieldmanager fields as a standalone meta box FM context.
 *
 * This will remove the `call_to_action` field from the Fieldmanager fields
 * before returning the group and also change the label to 'Post Hero'.
 *
 *     Component\hero()->
 *         ->set_option( 'hide_fm_fields', 'call_to_action', true )
 *         ->get_fm_group( [ 'label' => 'Post Hero' ] )
 *         ->add_meta_box(  __( 'Hero', 'i18n' ), array( 'post' ) );
 *
 *
 * Render the FM fields in the admin as part of a larger Fieldmanager Group.
 *
 *    $fm = new Fieldmanager_Group( [
 *        'name' => 'post-hero',
 *        'children' => array(
 *            'hero' => new Fieldmanager_Group( [
 *                'label' => __( 'Hero', 'i18n' ),
 *                'children' => \Component\hero()
 *                    ->set_option( 'hide_fm_fields', 'call_to_action', true )
 *                    ->get_fields(),
 *            ] ),
 *        ),
 *    ] );
 *    $fm->add_meta_box( __( 'Hero', 'i18n' ), array( 'post' ) );
 *
 *
 * Render the component FM fields within a scaffolder file.
 *
 *     "children": {
 *         "hero": {
 *             "label": { "__": "Hero" },
 *             "children": "`\\Component\\hero()
 *                             ->set_option( 'hide_fm_fields', 'call_to_action', true ) )
 *                             ->get_fm_fields()`"
 *         },
 *     },
 */
class Component {

	/**
	 * Component slug. Unique across components. This will be used as the
	 * folder path for your component.
	 *
	 * @var string
	 */
	public $slug = '';

	/**
	 * Alias for slug while refactoring occurs.
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * Path to components folder. Relative to theme root.
	 *
	 * @var string
	 */
	public $path = 'components';

	/**
	 * Component settings. This should be meta data about the component.
	 *
	 * @var array
	 */
	protected $settings = [];

	/**
	 * Component data. This is data used to output the component.
	 *
	 * @var array
	 */
	protected $data = [];

	/**
	 * Component Fieldmanager fields. These fields are the admin interface.
	 *
	 * @var array
	 */
	protected $fm_fields = [];

	/**
	 * Instantiate a new instance of this component.
	 *
	 * @param array $settings  Instance settings.
	 * @param array $data      Instance data.
	 * @param array $fm_fields Fieldmanager fields.
	 */
	public function __construct( array $settings = [], array $data = [], array $fm_fields = [] ) {
		$this->settings  = wp_parse_args( $settings, $this->default_settings() );
		$this->data      = wp_parse_args( $data, $this->default_data() );
		$this->fm_fields = wp_parse_args( $fm_fields, $this->default_fm_fields() );

		$this->name = $this->slug;
		return $this;
	}

	/**
	 * Placeholder function that gets overridden by children classes.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'label'          => '',
			'classes'        => [],
			'hide_fm_fields' => [],
		];
	}

	/**
	 * Placeholder function that gets overridden by children classes.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [];
	}

	/**
	 * Placeholder function that gets overridden by children classes.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		return [];
	}

	/**
	 * Setting and Data getters.
	 *
	 * These functions accepts any number of string aguments indicating the path
	 * of the setting. The function will return null if the path is invalid.
	 *
	 * Example:
	 * ========
	 * Get a nested value.
	 *
	 *     $component->get_data( 'social_media', 'facebook', 'url' );
	 *
	 * Will return $component->settings['social_media']['facebook']['url'],
	 * or null.
	 *
	 * Example:
	 * ========
	 * Combine with PHP's Null Coalesce operator to use a default value.
	 *
	 *     $title = $component->get_setting( 'title' ) ?? 'Default Component Title';
	 */

	/**
	 * Get setting.
	 *
	 * @return mixed|null Setting value,
	 */
	final public function get_setting() {
		return $this->get_nested_value( (array) func_get_args(), (array) $this->settings );
	}

	/**
	 * Get data.
	 *
	 * @return mixed|null Data value.
	 */
	final public function get_data() {
		return $this->get_nested_value( (array) func_get_args(), (array) $this->data );
	}

	/**
	 * Get option.
	 *
	 * @return mixed|null Option value.
	 */
	final public function get_option() {

		// Get and validate function arguments.
		$args = (array) func_get_args();
		if ( empty( $args ) ) {
			return null;
		}

		// First arg is the option key.
		$option_key  = array_shift( $args );
		$option_data = get_option( $option_key );

		// Return.
		if ( empty( $args ) ) {
			return $option_data;
		}
		return $this->get_nested_value( $args, (array) $option_data );
	}

	/**
	 * Get a nested value. Traverse the $args array and return the nested
	 * value within $data.
	 *
	 * @param  array $args Data path as an array of strings.
	 * @param  array $data Data to traverse.
	 * @return mixed|null  Data found.
	 */
	final public function get_nested_value( array $args, array $data ) {
		if ( empty( $args ) ) {
			return null;
		}

		foreach ( $args as $arg ) {
			if ( isset( $data[ $arg ] ) ) {
				$data = $data[ $arg ];
			} else {
				return null;
			}
		}

		return $data;
	}

	/**
	 * Setting and Data setters.
	 *
	 * These functions accepts a key, value, and boolean to handle pushing
	 * values onto an already existing array.
	 *
	 * Example:
	 * ========
	 * Set value that overwrites any previously existing data.
	 *
	 *     $component->set_data( 'social_media', [
	 *         'facebook' => [
	 *             'url' => 'facebook.com',
	 *         ],
	 *         'twitter' => [
	 *             'url' => 'twitter.com',
	 *         ],
	 *     ] );
	 *
	 *
	 * Use the $append boolean to append the value to previously existing data.
	 *
	 *     $component->set_data( 'social_media', [
	 *         'youtube' => [
	 *             'url' => 'youtube.com',
	 *         ],
	 *     ], true );
	 */

	/**
	 * Update setting value.
	 *
	 * @param  string|array $key    Key to update, or entire data array.
	 * @param  mixed        $value  Value to set.
	 * @param  boolean      $append Replace value, or append to existing value.
	 * @return Component Current instance of this class.
	 */
	final public function set_setting( $key, $value = null, $append = false ) {
		$this->set_value( 'settings', $key, $value, $append );
		return $this;
	}

	/**
	 * Update data value.
	 *
	 * @param  string|array $key    Key to update, or entire data array.
	 * @param  mixed        $value  Value to set.
	 * @param  boolean      $append Replace value, or append to existing value.
	 * @return Component Current instance of this class.
	 */
	final public function set_data( $key, $value = null, $append = false ) {
		$this->set_value( 'data', $key, $value, $append );
		return $this;
	}

	/**
	 * Update FM fields.
	 *
	 * @param array $fields FM fields.
	 */
	final public function set_fm_fields( array $fields ) {
		$this->fm_fields = $fields;
		return $this;
	}

	/**
	 * Update value.
	 *
	 * @param  string       $data   Which component data to update.
	 * @param  string|array $key    Key to update, or entire data array.
	 * @param  mixed        $value  Value to set.
	 * @param  boolean      $append Replace value, or append to existing value.
	 * @return Component Current instance of this class.
	 */
	final public function set_value( $data, $key, $value = null, $append = false ) {
		if ( ! in_array( $data, [ 'settings', 'data' ], true ) ) {
			return null;
		}

		if ( is_array( $key ) && is_null( $value ) ) {
			$this->$data = $key;
		} elseif ( $append ) {
			$current_value           = ( $this->$data )[ $key ] ?? [];
			( $this->$data )[ $key ] = array_merge( (array) $current_value, (array) $value );
		} else {
			( $this->$data )[ $key ] = $value;
		}
	}

	/**
	 * Helper function that can both get and set settings.
	 *
	 * @param array|string $key    Key to get or set.
	 * @param mixed        $value  Value to set.
	 * @param boolean      $append Append as array, or override.
	 * @return Component Current instance of this class.
	 */
	final public function setting( $key = null, $value = null, $append = false ) {
		if ( is_null( $key ) ) {
			return $this->settings;
		}
		if ( is_null( $value ) ) {
			return $this->get_setting( $key );
		}

		$this->set_setting( $key, $value, $append );
		return $this;
	}

	/**
	 * Helper function that can both get and set data.
	 *
	 * @param array|string $key    Key to get or set.
	 * @param mixed        $value  Value to set.
	 * @param boolean      $append Append as array, or override.
	 * @return Component Current instance of this class.
	 */
	final public function data( $key = null, $value = null, $append = false ) {
		if ( is_null( $key ) ) {
			return $this->data;
		}
		if ( ! is_array( $key ) && is_null( $value ) ) {
			return $this->get_data( $key );
		}

		$this->set_data( $key, $value, $append );
		return $this;
	}

	/**
	 * Helper to handle outputting a string of classes.
	 *
	 * @param  array $additional_classes Array of classes.
	 * @param  bool  $echo               Return or echo output.
	 */
	public function classes( array $additional_classes = [], bool $echo = true ) {

		// Merge component classes and additional classes.
		$classes = array_merge( (array) $this->get_setting( 'classes' ), (array) $additional_classes );

		// Validate.
		if ( ! is_array( $classes ) || empty( $classes ) ) {
			return;
		}

		$classes_string = implode( ' ', array_map( 'sanitize_html_class', $classes ) );

		if ( (bool) $echo ) {
			echo esc_attr( $classes_string );
		}

		return $classes_string;
	}

	/**
	 * Add key to the hide_fm_fields setting for future use.
	 *
	 * @todo update this to modify $this->fm_fields instead.
	 *
	 * @param  string $key FM field key.
	 */
	final public function hide_fm_field( $key ) {
		$this->set_setting( 'hide_fm_fields', $key, true );
	}

	/**
	 * Remove FM field directly.
	 *
	 * @param  string $key Key of field to remove.
	 * @return Component Current instance of this class.
	 */
	final public function remove_fm_field( $key ) {

		if ( isset( $this->fm_fields[ $key ] ) ) {
			unset( $this->fm_fields[ $key ] );
		}

		return $this;
	}

	/**
	 * Return this component's FieldManager fields after being filtered by
	 * the setting `hide_fm_fields`.
	 *
	 * @return array Array of FieldManager fields.
	 */
	final public function get_fm_fields() {

		$fm_fields     = $this->fm_fields;
		$keys_to_unset = (array) $this->get_setting( 'hide_fm_fields' );

		foreach ( $keys_to_unset as $key_to_unset ) {
			if ( isset( $fm_fields[ $key_to_unset ] ) ) {
				unset( $fm_fields[ $key_to_unset ] );
			}
		}

		return $fm_fields;
	}

	/**
	 * Get the FieldManger Fields already setup in a group.
	 *
	 * @param  array $group_settings Settings for the group.
	 * @return Fieldmanager_Group    Fieldmanager group.
	 */
	final public function get_fm_group( array $group_settings = [] ) : \Fieldmanager_Group {
		$group_settings = wp_parse_args(
			$group_settings,
			[
				'label'    => ! empty( $this->get_setting( 'label' ) ) ? $this->get_setting( 'label' ) : $this->slug,
				'children' => $this->get_fm_fields(),
			]
		);

		return new \Fieldmanager_Group( $group_settings );
	}

	/**
	 * Return the path to this component.
	 *
	 * @param  string $path Path within template parts folder.
	 * @return string       Component path from theme root.
	 */
	public function get_component_path( $path = 'index' ) {
		return "{$this->path}/{$this->slug}/template-parts/{$path}";
	}

	/**
	 * Render this component using an ai partial.
	 */
	public function render() {

		/**
		 * Executes before the template part is output.
		 *
		 * Allows for a pre_render function in children classes.
		 */
		if ( method_exists( $this, 'pre_render' ) ) {
			$this->pre_render();
		}

		if ( function_exists( 'ai_get_template_part' ) ) {
			\ai_get_template_part(
				$this->get_component_path(),
				[
					'component'  => $this,
					'stylesheet' => $this->slug,
				]
			);
		}

		/**
		 * Executes after the template part is output.
		 *
		 * Allows for a post_render function in children classes.
		 */
		if ( method_exists( $this, 'post_render' ) ) {
			$this->post_render();
		}
	}
}
