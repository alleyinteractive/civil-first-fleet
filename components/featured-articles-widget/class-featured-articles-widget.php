<?php
/**
 * Featured Articles Widget component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Featured Articles Widget component class.
 */
class Featured_Articles_Widget extends \Civil_First_Fleet\Component\Content_List {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'featured-articles-widget';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return wp_parse_args(
			[
				'items' => 10,
			],
			parent::default_settings()
		);
	}

	/**
	 * Default component data.
	 *
	 * @todo unique id
	 * @return array Default data.
	 */
	public function default_data() : array {
		$data = parent::default_data();
		return $data;
	}

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		// Get defaults.
		$fields = parent::default_fm_fields();

		// Add the 'Enabled' checkbox to the front of the list of fields.
		$fields = array_merge(
			[
				'enable' => new \Fieldmanager_Checkbox(
					__( 'Show list of featured articles in post sidebar.', 'civil-first-fleet' )
				),
			],
			$fields
		);

		// Change meta.
		$fields['meta'] = new \Fieldmanager_Group(
			[
				'label'      => __( 'Settings', 'civil-first-fleet' ),
				'collapsed'  => false,
				'children'   => [
					'title' => new \Fieldmanager_TextField(
						[
							'label'         => __( 'Title', 'civil-first-fleet' ),
							'default_value' => __( 'Featured Articles', 'civil-first-fleet' ),
						]
					),
				],
				'display_if' => [
					'src'   => 'enable',
					'value' => true,
				],
			]
		);

		// Hide the 'Curate' and 'Filters' boxes if 'Enabled' is not checked.
		$fields['curate']->display_if = [
			'src'   => 'enable',
			'value' => true,
		];

		$fields['filters']->display_if = [
			'src'   => 'enable',
			'value' => true,
		];

		// Un-collapse the 'Curate' box.
		$fields['curate']->collapsed = false;

		return $fields;
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Featured_Articles  An instance of this component.
 */
function featured_articles_widget( array $settings = [], array $data = [], array $fm_fields = [] ) : Featured_Articles_Widget {
	return new Featured_Articles_Widget( $settings, $data );
}
