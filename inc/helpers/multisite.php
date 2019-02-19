<?php
/**
 * Multisite helpers.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

/**
 * Civil specific wrapper for switching to the civil.co blog.
 */
function civ_switch_to_blog() {
	if ( function_exists( 'switch_to_blog' ) ) {
		switch_to_blog( 1 );
	}
}

/**
 * Civil specific wrapper for switching back from the civil.co blog.
 */
function civ_restore_current_blog() {
	if ( function_exists( 'restore_current_blog' ) ) {
		restore_current_blog();
	}
}
