<?php
/**
 * Site Footer component.
 *
 * @todo  Write markup and CSS for this component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Site Footer component class.
 */
class Newsroom_Footer extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'newsroom-footer';

	/**
	 * Menu name helper.
	 *
	 * @param string $location The menu's theme_location.
	 *
	 * @return string The menu name markup.
	 */
	public function get_menu_name( $location ) {
		$theme_locations = get_nav_menu_locations();
		$menu_obj = get_term( $theme_locations[ $location ], 'nav_menu' );
		return sprintf(
			'<h3 class="%2$s">%1$s</h3>',
			esc_html( $menu_obj->name ),
			ai_get_classnames( [ 'nav-heading' ] )
		);
	}

	/**
	 * Display the menu name.
	 *
	 * @param string $location The menu's theme_location.
	 */
	public function menu_name( $location ) {
		echo wp_kses_post( $this->get_menu_name( $location ) );
	}

	/**
	 * Generic function that executes before render.
	 */
	public function pre_render() {
		// Set `contact_email` to the options setting or default to `support@civil.co`.
		$this->set_data( 'contact_email', $this->get_option( 'newsroom-settings', 'contact', 'email' ) ?? 'support@civil.co' );
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings  Instance settings.
 * @param  array $data      Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Newsroom_Footer  An instance of this component.
 */
function newsroom_footer( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Newsroom_Footer {
	return new Newsroom_Footer( $settings, $data );
}
