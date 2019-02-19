<?php
/**
 * Article Footer component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Article Footer component class.
 */
class Article_Footer extends \Civil_First_Fleet\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-footer';

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
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Article_Footer  An instance of this component.
 */
function article_footer( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Article_Footer {
	return new Article_Footer( $settings, $data );
}
