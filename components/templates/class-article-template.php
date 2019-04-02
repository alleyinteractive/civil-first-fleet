<?php
/**
 * Article Template component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Components\Templates;

/**
 * Class for the Article template.
 */
class Article_Template extends \WP_Components\Component {

	use \WP_Components\WP_Post;

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $name = 'article-template';

	/**
	 * Hook into post being set.
	 *
	 * @return self
	 */
	public function post_has_set() : self {
		$body           = new \WP_Components\Body();
		$body->children = array_filter( $this->get_components() );
		return $this;
	}

	/**
	 * Get an array of all components.
	 *
	 * @return array
	 */
	public function get_components() : array {
		return [];
	}
}
