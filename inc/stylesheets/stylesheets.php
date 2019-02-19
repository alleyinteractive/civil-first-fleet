<?php
/**
 * An implementation and manager for localized classes produced by CSS Modules
 *
 * @package Civil_First_Fleet
 * @copyright 2014-2017 Alley Interactive
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2 or greater,
 * as published by the Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * The license for this software can likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

// Load required classes.
require_once __DIR__ . '/class-stylesheets.php';

if ( ! function_exists( 'ai_get_classnames' ) ) :
	/**
	 * Get a string of valid classes from a provided series of arguments (arrays or strings)
	 *
	 * @param array  $static_classes Indexed array of classes to merge.
	 * @param array  $dynamic_classes Associative array of classes.
	 *  Keys are classes, values are booleans determining if that class should print.
	 * @param string $stylesheet  Optional. Stylesheet to get classname from. If not provided,
	 *                             will use stylesheet provided via ai_use_stylesheet.
	 * @return string              The variable or $default.
	 */
	function ai_get_classnames( $static_classes, $dynamic_classes = [], $stylesheet = false ) {
		$valid_classes = \Civil_First_Fleet\Stylesheets::instance()->get_classnames( $static_classes, $dynamic_classes, $stylesheet );
		return implode( ' ', $valid_classes );
	}
endif;

if ( ! function_exists( 'ai_the_classnames' ) ) :
	/**
	 * Print a string of valid classes from a provided series of arguments (arrays or strings)
	 *
	 * @param array  $static_classes Indexed array of classes to merge.
	 * @param array  $dynamic_classes Associative array of classes.
	 *  Keys are classes, values are booleans determining if that class should print.
	 * @param string $stylesheet  Optional. Stylesheet to get classname from. If not provided,
	 *                             will use stylesheet provided via ai_use_stylesheet.
	 */
	function ai_the_classnames( $static_classes, $dynamic_classes = [], $stylesheet = false ) {
		$valid_classes = \Civil_First_Fleet\Stylesheets::instance()->get_classnames( $static_classes, $dynamic_classes, $stylesheet );
		echo esc_attr( implode( ' ', $valid_classes ) );
	}
endif;

if ( ! function_exists( 'ai_use_stylesheet' ) ) :

	/**
	 * Set the current stylesheet. This allows you to use ai_the_classnames or ai_get_classnames without explicitly providing a stylesheet each time.
	 *
	 * @param  string $stylesheet Stylesheet to set.
	 *
	 * @return void
	 */
	function ai_use_stylesheet( $stylesheet ) {
		\Civil_First_Fleet\Stylesheets::instance()->use_stylesheet( $stylesheet );
	}

endif;
