<?php
/**
 * Body Content (rich text) component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Article Body component class.
 */
class Body_Content extends \Civil_First_Fleet\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'body-content';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'layout' => 'sidebar',
		];
	}

	/**
	 * Center the body content within the template
	 */
	public function center() {
		$this->set_setting( 'layout', 'centered' );
		return $this;
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
 * @param  array $settings   Instance settings.
 * @param  array $data       Instance data.
 * @param  array $fm_fields  Instance FM fields.
 * @return Body_Content An instance of this component.
 */
function body_content( array $settings = [], array $data = [], array $fm_fields = [] ) : Body_Content {
	return new Body_Content( $settings, $data, $fm_fields );
}
