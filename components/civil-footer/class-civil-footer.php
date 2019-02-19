<?php
/**
 * Site Footer component.
 *
 * @todo  Write markup and CSS for this component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Site Footer component class.
 */
class Civil_Footer extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'civil-footer';

	/**
	 * Output a wp_nav_menu for a specific id.
	 *
	 * @todo Add caching to this method.
	 *
	 * @param array $args Arguments for wp_nav_menu.
	 */
	public function civil_wp_nav_menu( array $args ) {
		\Civil_CMS\civ_switch_to_blog();
		wp_nav_menu( $args );
		\Civil_CMS\civ_restore_current_blog();
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings  Instance settings.
 * @param  array $data      Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Civil_Footer  An instance of this component.
 */
function civil_footer( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Civil_Footer {
	return new Civil_Footer( $settings, $data );
}
