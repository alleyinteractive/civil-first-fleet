<?php
/**
 * Error Page component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Error Page component class.
 */
class Error_Page extends \Civil_CMS\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'error-page';

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'civil_content'    => $this->get_civil_default_content(),
			'newsroom_content' => $this->get_newsroom_default_content(),
		];
	}

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'is_main_site' => false,
		];
	}

	/**
	 * Get the default Error Page content.
	 */
	public function default_content() {
		echo wp_kses_post(
			$this->get_setting( 'is_main_site' ) ?
				$this->get_data( 'civil_content' ) :
				$this->get_data( 'newsroom_content' )
		);
	}

	/**
	 * Get default Civil Error Page content.
	 */
	public function get_civil_default_content() {
		return '<p>' . sprintf(
			/* translators: 1: The site's home URL. 2: The Civil Help page. */
			__( 'Like the hearts of the vulture capitalists pillaging newsrooms around the world, this page is not found. Go to our <a href="%1$s">homepage</a> — or visit our <a href="%2$s">help section</a> if you’ve got any questions.', 'civil-cms' ),
			esc_url( home_url() ),
			esc_url( home_url( '/help/' ) )
		) . '</p>';
	}

	/**
	 * Get default Newsroom Error Page content.
	 */
	public function get_newsroom_default_content() {
		return '<p>' . sprintf(
			/* translators: 1: The site's home URL. */
			__( 'Stop the presses! This page was not found. Go to our <a href="%1$s">homepage</a>.', 'civil-cms' ),
			esc_url( home_url() )
		) . '</p>';
	}

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
 * @return Error_Page An instance of this component.
 */
function error_page( array $settings = [], array $data = [], array $fm_fields = [] ) : Error_Page {
	return new Error_Page( $settings, $data, $fm_fields );
}
