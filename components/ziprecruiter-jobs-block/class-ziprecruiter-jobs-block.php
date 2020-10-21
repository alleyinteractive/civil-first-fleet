<?php
/**
 * ZipRecruiter Jobs Block component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Middle Feature component class.
 */
class Ziprecruiter_Jobs_Block extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'ziprecruiter-jobs-block';

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		if ( ! defined( 'FM_VERSION' ) ) {
			return [];
		}

		// Inject an `enable` checkbox before anything else.
		$fields = [
			'enable'   => new \Fieldmanager_Checkbox( __( 'Enable', 'civil-first-fleet' ) ),
			'settings' => new \Fieldmanager_Group(
				[
					'label'     => __( 'Settings', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'title'         => new \Fieldmanager_Textfield( __( 'Title', 'civil-first-fleet' ) ),
						'per_page'      => new \Fieldmanager_Textfield(
							[
								'label'         => __( 'Jobs to Show', 'civil-first-fleet' ),
								'default_value' => '10',
							]
						),
						'show_location' => new \Fieldmanager_Checkbox(
							[
								'label'         => __( 'Allow searching by location', 'civil-first-fleet' ),
								'default_value' => true,
							]
						),
						'show_salary'   => new \Fieldmanager_Checkbox(
							[
								'label'         => __( 'Allow searching by salary', 'civil-first-fleet' ),
								'default_value' => true,
							]
						),
					],
				]
			),
		];

		return $fields;
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings  Instance settings.
 * @param  array $data      Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Ziprecruiter_Jobs_Block An instance of this component.
 */
// phpcs:disable WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
function Ziprecruiter_Jobs_Block( array $settings = [], array $data = [], array $fm_fields = [] ) : Ziprecruiter_Jobs_Block {
	return new Ziprecruiter_Jobs_Block( $settings, $data );
}
