<?php
/**
 * Middle Feature component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Middle Feature component class.
 */
class Middle_Feature extends \Civil_First_Fleet\Component\Content_List {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'middle-feature';

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		if ( ! defined( 'FM_VERSION' ) ) {
			return [];
		}

		// Inject an `enabel` checkbox before anything else.
		$fields = array_merge(
			[
				'enable' => new \Fieldmanager_Checkbox( __( 'Enable', 'civil-first-fleet' ) ),
			],
			parent::default_fm_fields(),
		);

		// Simplify the meta group.
		$fields['meta'] = new \Fieldmanager_Group(
			[
				'label'     => __( 'Settings', 'civil-first-fleet' ),
				'collapsed' => true,
				'children'  => [
					'title'              => new \Fieldmanager_Textfield( __( 'Title', 'civil-first-fleet' ) ),
					'side_advertisement' => new \Fieldmanager_Textarea( __( 'Sidebar Advertisement', 'civil-first-fleet' ) ),
				],
			]
		);

		return $fields;
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Middle_Feature  An instance of this component.
 */
function Middle_Feature( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Middle_Feature {
	return new Middle_Feature( $settings, $data );
}
