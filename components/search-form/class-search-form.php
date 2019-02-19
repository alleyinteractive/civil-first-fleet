<?php
/**
 * Search Form component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Search_Form component class.
 */
class Search_Form extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'search-form';

	/**
	 * Default component settings.
	 *
	 * @todo Set up a version that includes a submit button?
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return array(
			'include_button' => false,
			'context' => '',
		);
	}

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'search_query' => '',
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
function search_form( array $settings = [], array $data = [], array $fm_fields = [] ) : Search_Form {
	return new Search_Form( $settings, $data );
}
