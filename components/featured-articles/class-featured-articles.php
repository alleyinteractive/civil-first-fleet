<?php
/**
 * Featured Articles component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Featured Articles component class.
 */
class Featured_Articles extends \Civil_First_Fleet\Component\Content_List {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'featured-articles';

	/**
	 * Default component data.
	 *
	 * @todo unique id
	 * @return array Default data.
	 */
	public function default_data() : array {
		$data = parent::default_data();
		$data['call_to_action']   = null;
		$data['sponsorship']      = false;
		$data['hide_sidebar']     = false;
		$data['disable_backfill'] = false;
		$data['show_avatar']      = false;
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

		// Simplify meta and add CTA component.
		$fields['meta'] = new \Fieldmanager_Group(
			[
				'label'     => __( 'Settings', 'civil-first-fleet' ),
				'collapsed' => true,
				'children'  => [
					'title'            => new \Fieldmanager_Textfield( __( 'Title', 'civil-first-fleet' ) ),
					'hide_sidebar'     => new \Fieldmanager_Checkbox(
						[
							'label' => __( 'Hide Sidebar (only display one post)', 'civil-first-fleet' ),
						]
					),
					'disable_backfill' => new \Fieldmanager_Checkbox(
						[
							'label' => __( 'Disable Article Backfill (only display curated posts)', 'civil-first-fleet' ),
						]
					),
					'call_to_action'   => new \Fieldmanager_Group(
						[
							'label'     => __( 'Call To Action', 'civil-first-fleet' ),
							'collapsed' => true,
							'children'  => call_to_action()->get_fm_fields(),
						]
					),
					'sponsorship'      => new \Fieldmanager_Group(
						[
							'label'    => __( 'Sponsors', 'civil-first-fleet' ),
							'children' => \Civil_First_Fleet\Components\Sponsor::get_schedule_fm_fields(),
						]
					),
				],
			]
		);

		return $fields;
	}

	/**
	 * Before render, modify the number of items and display options needed based on
	 * other settings.
	 */
	public function pre_render() {
		$items               = absint( $this->get_setting( 'items' ) );
		$hide_sidebar        = (bool) $this->get_data( 'meta', 'hide_sidebar' ) ?? false;
		$show_call_to_action = (bool) $this->get_data( 'meta', 'call_to_action', 'enable' ) ?? false;
		$disable_backfill    = (bool) $this->get_data( 'meta', 'disable_backfill' ) ?? false;

		// Set the sponsorship data.
		$this->set_data( 'sponsorship', $this->get_data( 'meta', 'sponsorship' ) );

		if ( true === $hide_sidebar ) {
			// Only 1 item if we're hiding the sidebar.
			$this->set_setting( 'items', 1 );

		} elseif ( true === $show_call_to_action ) {
			// Only 6 items if rendering a call to action.
			$this->set_setting( 'items', 6 );
		}

		// Set backfill setting.
		$this->set_setting( 'disable_backfill', $disable_backfill );

		// Set option to display author avatars.
		$newsroom_settings = (array) $this->get_option( 'newsroom-settings', 'component_defaults', 'featured_articles' );
		$show_avatar       = (bool) $newsroom_settings[ 'show_avatar' ] ?? false;
		$this->set_data( 'show_avatar', $show_avatar );
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
function featured_articles( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Featured_Articles {
	return new Featured_Articles( $settings, $data );
}
