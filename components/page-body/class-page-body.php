<?php
/**
 * Page Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Page Body component class.
 */
class Page_Body extends \Civil_CMS\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'page-body';

	/**
	 * Render this component.
	 */
	public function render() {
		\ai_get_template_part(
			$this->get_component_path(), [
				'component'  => $this,
				'stylesheet' => $this->slug,
			]
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings   Instance settings.
 * @param  array $data       Instance data.
 * @param  array $fm_fields  Instance FM fields.
 * @return Page_Body An instance of this component.
 */
function page_body( array $settings = [], array $data = [], array $fm_fields = [] ) : Page_Body {
	return new Page_Body( $settings, $data, $fm_fields );
}
