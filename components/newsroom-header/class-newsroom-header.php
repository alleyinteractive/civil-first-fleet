<?php
/**
 * Newsroom Header component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Site Header component class.
 */
class Newsroom_Header extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'newsroom-header';
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Newsroom_Header  An instance of this component.
 */
function newsroom_header( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Newsroom_Header {
	return new Newsroom_Header( $settings, $data );
}
