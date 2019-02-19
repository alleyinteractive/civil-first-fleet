<?php
/**
 * Page Header component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Page Header component class.
 */
class Page_Header extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'page-header';

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'title' => '',
		];
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings   Instance settings.
 * @param  array $data       Instance data.
 * @param  array $fm_fields  Instance FM fields.
 * @return Page_Header An instance of this component.
 */
function page_header( array $settings = [], array $data = [], array $fm_fields = [] ) : Page_Header {
	return new Page_Header( $settings, $data, $fm_fields );
}
