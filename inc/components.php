<?php
/**
 * This file holds configuration settings for components.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Filter the namespace for autoloading.
add_filter(
	'wp_components_theme_components_namespace',
	function() {
		return 'Civil_First_Fleet\Components';
	}
);

// Filter the theme component path for autoloading.
add_filter(
	'wp_components_theme_components_path',
	function( $class, $dirs ) {
		return get_template_directory() . '/components' . implode( '/', $dirs ) . "/class-{$class}.php";
	},
	10,
	2
);

// Filter for component asset path.
add_filter(
	'wp_render_asset_path',
	function( $path, $name, $type ) {
		return get_template_directory_uri() . '/client/build/' . ai_get_versioned_asset( "{$name}.{$type}" );
	},
	10,
	3
);

// Before WP Render outputs a component, capture the stylesheet and load the component's stylesheet.
add_filter(
	'wp_render_pre_component_render',
	function( $component_instance ) {
		$current_stylesheet_name = \Civil_First_Fleet\Stylesheets::instance()->current_stylesheet;
		\ai_use_stylesheet( $component_instance->name );
		return $current_stylesheet_name;
	}
);

// After WP Render outputs a component, load the parent stylesheet.
add_action(
	'wp_render_post_component_render',
	function( $component_instance, $old_name ) {
		\ai_use_stylesheet( $old_name );
	},
	10,
	2
);
