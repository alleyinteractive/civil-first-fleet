<?php
/**
 * Subscribe Button component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Subscribe_Button component class.
 */
class Subscribe_Button extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'subscribe-button';

	/**
	 * Default component settings.
	 * Supported height / width: 'full' / 'standard'.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return array(
			'height' => 'standard',
			'width'  => 'full',
		);
	}

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		$button_text = $this->get_option( 'newsroom-settings', 'component_defaults', 'paywall_call_to_action', 'button_text' ) ?: __( 'Subscribe', 'civil-cms' );

		return [
			'id'            => 'subscribe-button',
			'subscribe_url' => '',
			'text'          => $button_text,
		];
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Component_Name  An instance of this component.
 */
function subscribe_button( array $settings = [], array $data = [], array $fm_fields = [] ) : Subscribe_Button {
	return new Subscribe_Button( $settings, $data );
}
