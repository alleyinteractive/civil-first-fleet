<?php
/**
 * Article Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Article Body component class.
 */
class Article_Body extends \Civil_CMS\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-body';

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
 * @return Article_Body An instance of this component.
 */
function article_body( array $settings = [], array $data = [], array $fm_fields = [] ) : Article_Body {
	return new Article_Body( $settings, $data, $fm_fields );
}
