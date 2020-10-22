<?php
/**
 * Easily register new Shortcake UI based shortcodes.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Shortcode class.
 */
class Shortcode {

	/**
	 * Shortcode settings.
	 *
	 * @var array
	 */
	public $settings = [];

	/**
	 * Class constructor.
	 *
	 * @param  array $settings Shortcode settings.
	 */
	public function __construct( $settings ) {

		// Parse and set settings.
		$this->settings = wp_parse_args(
			$settings,
			[
				'name'       => '',
				'label'      => '',
				'icon'       => '',
				'post_types' => [ 'post' ],
				'attributes' => [],
				'fields'     => [],
			]
		);

		add_shortcode( $this->settings['name'], [ $this, 'shortcode' ] );
		add_action( 'register_shortcode_ui', [ $this, 'register_shortcode_ui' ] );
	}

	/**
	 * Register shortcode.
	 *
	 * @param array $attributes Shortcode attributes.
	 */
	public function shortcode( $attributes ) {
		$attributes = shortcode_atts( $this->settings['attributes'], $attributes );

		// Output shortcode.
		ob_start();
		ai_get_template_part( "template-parts/shortcodes/{$this->settings['name']}/index", $attributes );
		return ob_get_clean();
	}

	/**
	 * Shortcode UI setup.
	 */
	public function register_shortcode_ui() {
		$settings = [
			'label'         => $this->settings['label'],
			'listItemImage' => $this->settings['icon'],
			'post_type'     => $this->settings['post_types'],
			'attrs'         => $this->settings['fields'],
		];
		shortcode_ui_register_for_shortcode( $this->settings['name'], $settings );
	}
}
