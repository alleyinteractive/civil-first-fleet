<?php
/**
 * EXAMPLE COMPONENT component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * EXAMPLE COMPONENT component class.
 */
class Example_Component extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'example-component';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [];
	}

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [];
	}

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		return [];
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings   Instance settings.
 * @param  array $data       Instance data.
 * @param  array $fm_fields  Instance FM fields.
 * @return Example_Component An instance of this component.
 */
function example_component( array $settings = [], array $data = [], array $fm_fields = [] ) : Example_Component {
	return new Example_Component( $settings, $data, $fm_fields );
}
