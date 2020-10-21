<?php
/**
 * Article Bylines component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Article Bylines component class.
 */
class Article_Bylines extends \Civil_First_Fleet\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-bylines';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'layout' => 'expandable',
		];
	}

	/**
	 * Render this component.
	 */
	public function render() {
		$layout = "bylines-{$this->get_setting( 'layout' )}";
		\ai_get_template_part(
			$this->get_component_path( $layout ),
			[
				'component'  => $this,
				'stylesheet' => 'article-bylines',
			]
		);
	}

	/**
	 * Authors tabpanel link helper.
	 *
	 * @param int $author_id Author ID.
	 * @return string The frag-id for the author bio tabpanel.
	 */
	public function get_bio_frag_id( $author_id ) {
		return 'bio-link-' . $author_id;
	}

	/**
	 * Author Twitter handle.
	 *
	 * @param int $coauthor_id Author ID.
	 *
	 * @return null|string The twitter link, if exists.
	 */
	public function get_author_twitter_handle( $coauthor_id ) {
		$twitter_handle = get_post_meta( $coauthor_id, 'twitter', true );

		if ( ! empty( $twitter_handle ) ) {
			return sprintf(
				'<a class="%1$s" href="https://twitter.com/%2$s">@%2$s</a>',
				ai_get_classnames( [ 'twitter-handle' ], [], $this->get_setting( 'stylesheet' ) ),
				esc_html( $twitter_handle )
			);
		}

		return null;
	}

	/**
	 * Display author Twitter link.
	 *
	 * @param int $coauthor_id Author ID.
	 */
	public function author_twitter_handle( $coauthor_id ) {
		echo wp_kses_post( $this->get_author_twitter_handle( $coauthor_id ) );
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Article_Bylines  An instance of this component.
 */
function article_bylines( array $settings = [], array $data = [], array $fm_fields = [] ) : Article_Bylines {
	return new Article_Bylines( $settings, $data );
}
