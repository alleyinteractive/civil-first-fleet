<?php
/**
 * Sponsors.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Class to manage sponsor functionality.
 */
class Sponsors {

	use Singleton;

	/**
	 * Setup this class singleton.
	 */
	public function setup() {

	}

	public function get_scheduling_fields() {
		return [
			'schedules' => new \Fieldmanager_Group(
				[
					'label'          => __( 'Schedules', 'civil-first-fleet' ),
					'limit'          => 0,
					'extra_elements' => 0,
					'label'          => __( 'New Schedule', 'fortune' ),
					'label_macro'    => [ __( 'From %s-%s', 'fortune' ), 'start_date', 'end_date' ],
					'add_more_label' => __( 'Add Schedule', 'fortune' ),
					'collapsed'      => true,
					'collapsible'    => true,
					'sortable'       => true,
					'children'       => [
						'sponsor'    => new \Fieldmanager_Zone_Field(
								[
									'label'      => __( 'Sponsor', 'cpr' ),
									'query_args' => [
										'post_type' => [ 'sponsor' ],
										'limit'     => 1,
									],
								]
							),
						'start_date' => new \Fieldmanager_Datepicker(
							[
								'label' => __( 'Start Date', 'civil-first-fleet' ),
							]
						),
						'end_date'   => new \Fieldmanager_Datepicker(
							[
								'label' => __( 'Start Date', 'civil-first-fleet' ),
							]
						),
					],
				]
			),
		];
	}
}
