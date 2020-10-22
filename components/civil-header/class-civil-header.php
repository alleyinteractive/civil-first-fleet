<?php
/**
 * Site Header component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Site Header component class.
 */
class Civil_Header extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'civil-header';

	/**
	 * Output a wp_nav_menu for a specific id.
	 *
	 * @todo Add caching to this method.
	 *
	 * @param array $args Arguments for wp_nav_menu.
	 */
	public function civil_wp_nav_menu( array $args ) {
		\Civil_First_Fleet\civ_switch_to_blog();
		wp_nav_menu( $args );
		\Civil_First_Fleet\civ_restore_current_blog();
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Civil_Header  An instance of this component.
 */
function civil_header( array $settings = [], array $data = [], array $fm_fields = [] ) : Civil_Header {
	return new Civil_Header( $settings, $data );
}
