<?php
/**
 * Gallery component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Gallery component class.
 */
class Gallery extends Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'gallery';

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'attributes' => [],
		];
	}

	/**
	 * Render this component.
	 */
	public function render() {
		\ai_get_template_part(
			$this->get_component_path(),
			[
				'component'  => $this,
				'stylesheet' => $this->slug,
			]
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @return Gallery  An instance of this component.
 */
function gallery( array $settings = [], array $data = [] ) : Gallery {
	return new Gallery( $settings, $data );
}

/**
 * Render function for gallery block
 *
 * @param  array $attributes Block attributes.
 * @param  array $content    Instance data.
 * @return Gallery  An instance of this component.
 */
function render_block_lightbox_gallery( $attributes, $content ) {
	ob_start();
	gallery()
		->set_data( 'attributes', $attributes )
		->render();
	return ob_get_clean();
}

/**
 * Register Gutenberg block type Call to Action on init.
 */
function register_block_lightbox_gallery() {
	if ( function_exists( 'register_block_type' ) ) {
		register_block_type(
			'civil/lightbox-gallery',
			[
				'render_callback' => __NAMESPACE__ . '\render_block_lightbox_gallery',
			]
		);
	}
}
add_action( 'init', __NAMESPACE__ . '\register_block_lightbox_gallery' );
