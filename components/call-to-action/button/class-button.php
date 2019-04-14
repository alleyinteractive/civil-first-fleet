<?php
/**
 * Button component for calls to action.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Components\Call_To_Action;

/**
 * Class for the call to action Button.
 */
class Button extends \WP_Components\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $name = 'cta-button';

	/**
	 * Define a default config.
	 *
	 * @return array Default config.
	 */
	public function default_config() : array {
		return [
			'action'  => 'link',
			'classes' => [],
			'height'  => 'standard',
			'id'      => '',
			'label'   => '',
			'link'    => '',
			'theme'   => 'module',
			'width'   => 'full',
		];
	}

	/**
	 * Get the FM fields used for the sponsor post type.
	 *
	 * @return array
	 */
	public static function get_fm_fields() {
		return [
			'label' => new \Fieldmanager_Textfield(
				[
					'label'         => __( 'Button Text', 'civil-first-fleet' ),
				]
			),
			'action'  => new \Fieldmanager_Select(
				[
					'label'   => __( 'Button Action', 'civil-first-fleet' ),
					'options' => [
						'link'              => __( 'Link', 'civil-first-fleet' ),
						'pico_registration' => __( 'Pico - Registration', 'civil-first-fleet' ),
						'pico_monetization' => __( 'Pico - Monetization', 'civil-first-fleet' ),
					],
				]
			),
			'link'  => new \Fieldmanager_Link(
				[
					'label'       => __( 'Link', 'civil-first-fleet' ),
					'display_if'  => [
						'src'   => 'action',
						'value' => 'link',
					],
				]
			),
		];
	}

	/**
	 * Setup this component using Fieldmanager data.
	 *
	 * @param array $data Array of data in the format outlined in
	 *                    get_fm_fields().
	 *
	 * @return self
	 */
	public function parse_from_fm_data( array $data ) : self {
		$this->merge_config( $data );
		$this->validate_data();
		return $this;
	}

	/**
	 * Set the component's valid state based on the current state.
	 *
	 * @return self
	 */
	public function validate_data() : self {

		// Missing label.
		if ( empty( $this->get_config( 'label' ) ) ) {
			return $this->set_invalid();
		}

		// Missing action.
		if ( empty( $this->get_config( 'action' ) ) ) {
			return $this->set_invalid();
		}

		// Missing link.
		if (
			'link' === $this->get_config( 'action' )
			&& empty( $this->get_config( 'link' ) )
		) {
			return $this->set_invalid();
		}

		// Everything looks good.
		return $this->set_valid();
	}

	/**
	 * Output the html tag for this instance.
	 *
	 * @return string
	 */
	public function get_tag() {
		// Links use anchors.
		if ( 'link' === $this->get_config( 'action' ) ) {
			return 'a';
		}

		// Everything else is a button.
		return 'button';
	}

	/**
	 * Get the classes.
	 *
	 * @return array
	 */
	public function get_classnames() : array {
		$classes = [ 'button' ];
		$classes = array_merge( $classes, $this->get_config( 'classes' ) );

		// Add classes based on action.
		switch ( $this->get_config( 'action' ) ) {
			case 'pico_registration':
				$classes[] = 'PicoSignal';
				$classes[] = 'PicoRule';
				break;
			case 'pico_monetization':
				$classes[] = 'PicoSignal';
				$classes[] = 'PicoPlan';
				break;
		}

		// Add height and width classes.
		if ( ! empty( $this->get_config( 'height' ) ) ) {
			$classes[] = $this->get_config( 'height' ) . '-height';
		}
		if ( ! empty( $this->get_config( 'width' ) ) ) {
			$classes[] = $this->get_config( 'width' ) . '-width';
		}

		return $classes;
	}
}
