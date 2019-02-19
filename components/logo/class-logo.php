<?php
/**
 * Logo component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Logo component class.
 */
class Logo extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'logo';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return array(
			// Options are 'civil' or 'newsroom'.
			'context'  => 'civil',
			'version'  => 'white',
			'location' => 'header',
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Logo  An instance of this component.
 */
function logo( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Logo {
	return new Logo( $settings, $data );
}
