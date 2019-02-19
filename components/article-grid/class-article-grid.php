<?php
/**
 * Article Grid component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Article Grid component class.
 */
class Article_Grid extends \Civil_First_Fleet\Component\Content_List {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-grid';
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Article_Grid  An instance of this component.
 */
function article_grid( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Article_Grid {
	return new Article_Grid( $settings, $data, $fm_fields );
}
