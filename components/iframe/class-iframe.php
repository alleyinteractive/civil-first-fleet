<?php
/**
 * IFrame component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * IFrame component class.
 */
class IFrame extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'iframe';

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'src'       => '',
			'width'     => 640,
			'height'    => 320,
			'scrolling' => '',
			'style'     => '',
			'classes'   => '',
		];
	}

	/**
	 * Returns the Gutenberg block settings.
	 *
	 * @return array The block settings.
	 */
	public function get_block_settings() {
		return [
			'src'       => [
				'type' => 'text',
			],
			'width'     => [
				'type'    => 'text',
				'default' => 640,
			],
			'height'    => [
				'type'    => 'text',
				'default' => 320,
			],
			'scrolling' => [
				'type' => 'text',
			],
			'style'     => [
				'type' => 'text',
			],
			'classes'   => [
				'type' => 'text',
			],
		];
	}

	/**
	 * Register Gutenberg blocks for this component.
	 *
	 * @return IFrame An instance of this component.
	 */
	public function register_blocks() {

		// Register block.
		wp_register_script(
			'block-js-' . $this->slug,
			get_template_directory_uri() . "/{$this->path}/{$this->slug}/assets/block.js",
			[ 'wp-blocks', 'wp-element' ],
			CIVIL_FIRST_FLEET_STATIC_VERSION
		);

		// Expose settings.
		wp_add_inline_script(
			'block-js-' . $this->slug,
			sprintf(
				'var civilIframeBlockSettings = %1$s;',
				wp_json_encode( $this->get_block_settings() )
			),
			'before'
		);

		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				"civil/{$this->slug}",
				[
					'editor_script'   => 'block-js-' . $this->slug,
					'render_callback' => function( array $attributes ) {
						return $this->render_block_data( $attributes );
					},
					'attributes'      => $this->get_block_settings(),
				]
			);
		}

		return $this;
	}

	/**
	 * Format Gutenberg block data to appear in the component template and render it.
	 *
	 * @param Array $attributes A list of block attributes to be rendered dynamically.
	 * @return String Template output to be returned when the content is rendered.
	 */
	public function render_block_data( $attributes ) {
		$this->set_data( 'src', $attributes['src'] ?? '' );
		$this->set_data( 'width', $attributes['width'] ?? '' );
		$this->set_data( 'height', $attributes['height'] ?? '' );
		$this->set_data( 'scrolling', $attributes['scrolling'] ?? '' );
		$this->set_data( 'style', $attributes['style'] ?? '' );
		$this->set_data( 'classes', $attributes['classes'] ?? '' );

		return ai_partial(
			[
				'slug'      => $this->get_component_path( 'index' ),
				'return'    => true,
				'variables' => [
					'component'  => $this,
					'stylesheet' => $this->slug,
				],
			]
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return IFrame An instance of this component.
 */
function iframe( array $settings = [], array $data = [], array $fm_fields = [] ) : IFrame {
	return new IFrame( $settings, $data );
}

/**
 * Register Gutenberg block type Call to Action on init.
 */
add_action(
	'init',
	function() {
		iframe()->register_blocks();
	}
);
