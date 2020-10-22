<?php
/**
 * Social Icons component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Social_Icons component class.
 */
class Social_Icons extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'social-icons';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'context' => '',
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
function social_icons( array $settings = [], array $data = [], array $fm_fields = [] ) : Social_Icons {
	return new Social_Icons( $settings, $data );
}
