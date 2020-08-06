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
	 * Default component data.
	 *
	 * @todo unique id
	 * @return array Default data.
	 */
	public function default_data() : array {
		$data = parent::default_data();
		// $data['call_to_action']   = null;
		// $data['sponsorship']      = false;
		// $data['hide_sidebar']     = false;
		// $data['disable_backfill'] = false;
		return $data;
	}

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

	/**
	 * Before render, modify the number of items needed based on other
	 * settings.
	 */
	public function pre_render() {
		// $items               = absint( $this->get_setting( 'items' ) );
		// $hide_sidebar        = (bool) $this->get_data( 'meta', 'hide_sidebar' ) ?? false;
		// $show_call_to_action = (bool) $this->get_data( 'meta', 'call_to_action', 'enable' ) ?? false;
		// $disable_backfill    = (bool) $this->get_data( 'meta', 'disable_backfill' ) ?? false;

		// // Set the sponsorship data.
		// $this->set_data( 'sponsorship', $this->get_data( 'meta', 'sponsorship' ) );

		// if ( true === $hide_sidebar ) {
		// 	// Only 1 item if we're hiding the sidebar.
		// 	$this->set_setting( 'items', 1 );

		// } elseif ( true === $show_call_to_action ) {
		// 	// Only 6 items if rendering a call to action.
		// 	$this->set_setting( 'items', 6 );
		// }

		// // Set backfill setting.
		// $this->set_setting( 'disable_backfill', $disable_backfill );
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
