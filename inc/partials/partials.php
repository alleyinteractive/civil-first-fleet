<?php
/**
 * An advanced template loader to DRY up template code.
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
require_once __DIR__ . '/class-partial.php';
require_once __DIR__ . '/class-partials.php';

if ( ! function_exists( 'ai_get_template_part' ) ) :

	/**
	 * Get a template part while setting a global variable that can be read from
	 * within the template.
	 *
	 * $name can be ommitted, and $variables can optionally be the second
	 * function argument. e.g.
	 *
	 *      ai_get_template_part( 'sidebar', array( 'image_size' => 'thumbnail' ) )
	 *
	 * @param string $slug      Template slug. @see get_template_part().
	 * @param string $name      Optional. Template name. @see get_template_part().
	 * @param array  $variables Optional. key => value pairs you want to access
	 *                          from the template.
	 */
	function ai_get_template_part( $slug, $name = null, $variables = array() ) {
		list( $name, $variables ) = _ai_fix_template_part_args( $name, $variables );
		ai_partial( compact( 'slug', 'name', 'variables' ) );
	}

endif;

if ( ! function_exists( 'ai_get_cached_template_part' ) ) :

	/**
	 * Get a template part and cache the results.
	 *
	 * By default, results are cached in a generated key for 15 minutes. You can
	 * override both the key and the ttl by passing the variables '_cache_key'
	 * and '_cache_ttl'. For instance, here we set a custom key and cache
	 * indefinitely:
	 *
	 *     ai_get_cached_template_part( 'foo', [ '_cache_key' => 'my-cache-key', '_cache_ttl' => 0 ] );
	 *
	 * @param string $slug      Template slug. @see ai_get_template_part().
	 * @param string $name      Optional. Template name. @see ai_get_template_part().
	 * @param array  $variables Optional. Variables for the template.
	 *                          @see ai_get_template_part().
	 */
	function ai_get_cached_template_part( $slug, $name = null, $variables = array() ) {
		list( $name, $variables ) = _ai_fix_template_part_args( $name, $variables );
		$cache = array();
		if ( ! empty( $variables['_cache_key'] ) ) {
			$cache['key'] = $variables['_cache_key'];
		}
		if ( isset( $variables['_cache_ttl'] ) ) {
			$cache['ttl'] = $variables['_cache_ttl'];
		}
		if ( empty( $cache ) ) {
			$cache = true;
		}

		ai_partial( compact( 'slug', 'name', 'variables', 'cache' ) );
	}

endif;

if ( ! function_exists( 'ai_get_var' ) ) :

	/**
	 * Get a value from the global ai_vars array.
	 *
	 * @param  string $key     The key from the variables.
	 * @param  mixed  $default Optional. If the key is not in $ai_vars, the
	 *                         function returns this value. Defaults to null.
	 * @return mixed           The variable or $default.
	 */
	function ai_get_var( $key, $default = null ) {
		return \Civil_CMS\Partials::instance()->get_var( $key, $default );
	}

endif;

if ( ! function_exists( 'ai_loop_template_part' ) ) :

	/**
	 * Iterate a WP_Query or array over a given template part.
	 *
	 * @param WP_Query|array $loop      WP_Query object or array of items (including
	 *                                  post ids) to iterate over.
	 * @param string         $slug      Template slug. @see ai_get_template_part().
	 * @param string         $name      Optional. Template name. @see ai_get_template_part().
	 * @param array          $variables Optional. Variables for the template.
	 *                                  @see ai_get_template_part().
	 */
	function ai_loop_template_part( $loop, $slug, $name = null, $variables = array() ) {
		list( $name, $variables ) = _ai_fix_template_part_args( $name, $variables );
		ai_partial( compact( 'slug', 'name', 'variables', 'loop' ) );
	}

endif;

if ( ! function_exists( 'ai_iterate_template_part' ) ) :

	/**
	 * Iterate over an array of arbitrary items, passing the index and item to a
	 * given template part.
	 *
	 * This function will load the given partial and add two variables to its
	 * variables array: `index` and `item`. `index` will hold the array key, and
	 * `item` will hold the array value.
	 *
	 * @param array  $iterate   The items to iterate over.
	 * @param string $slug      Template slug. @see ai_get_template_part().
	 * @param string $name      Template name. @see ai_get_template_part().
	 * @param array  $variables Variables for the template. Adds 'index' and
	 *                          'item' as noted above. @see ai_get_template_part.
	 */
	function ai_iterate_template_part( $iterate, $slug, $name = null, $variables = array() ) {
		list( $name, $variables ) = _ai_fix_template_part_args( $name, $variables );
		ai_partial( compact( 'slug', 'name', 'variables', 'iterate' ) );
	}

endif;

if ( ! function_exists( '_ai_fix_template_part_args' ) ) {

	/**
	 * Sort out `$name` and `$variables` for all of the custom template part
	 * functions.
	 *
	 * `$name` comes before `$variables` in the argument order, but is optional.
	 * This helper determines if `$name` was actually provided or not.
	 *
	 * @access private
	 *
	 * @param  mixed $name      Technically, `$name` should be a string or null.
	 *                          However, because it's optional, it might be an array.
	 *                          In that case, it will be reset to null and its value
	 *                          transferred to `$variables`.
	 * @param  array $variables Variables to pass to template partials.
	 * @return array            In the format: `array( $name, $variables )`. This can be
	 *                          used with `list()` very easily.
	 */
	function _ai_fix_template_part_args( $name, $variables ) {
		if ( is_array( $name ) ) {
			$variables = $name;
			$name = null;
		}

		return array( $name, $variables );
	}
}

if ( ! function_exists( 'ai_partial' ) ) :

	/**
	 * Get a partial in one of several ways.
	 *
	 * @see \Civil_CMS\Partials::load().
	 *
	 * @param array $args Options for loading the partial.
	 */
	function ai_partial( $args ) {
		$use_stylesheet = class_exists( '\Civil_CMS\Stylesheets' ) && function_exists( 'ai_use_stylesheet' ) && ! empty( $args['variables']['stylesheet'] );
		$old_stylesheet = '';

		// Set stylesheet, assuming it has the same name as component slug.
		if ( $use_stylesheet ) {
			$old_stylesheet = \Civil_CMS\Stylesheets::instance()->current_stylesheet;
			\ai_use_stylesheet( $args['variables']['stylesheet'] );
		}

		$partial = \Civil_CMS\Partials::instance()->load( $args );

		// When finished rendering, reset stylesheet to what it was before.
		if ( $use_stylesheet ) {
			\ai_use_stylesheet( $old_stylesheet );
		}

		return $partial;
	}

endif;
