<?php
/**
 * Sponsor component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Components;

/**
 * Class for the Article template.
 */
class Sponsor extends \WP_Components\Component {

	use \WP_Components\WP_Post;
	use \WP_Components\WP_Term;

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $name = 'sponsor';

	/**
	 * Define a default config.
	 *
	 * @return array Default config.
	 */
	public function default_config() : array {
		return [
			'link' => '',
		];
	}

	/**
	 * Hook into post being set.
	 *
	 * @return self
	 */
	public function post_has_set() : self {
		$schedules = get_post_meta( $this->get_post_id(), 'schedules', true );
		$this->parse_from_fm->data( $schedules );
		return $this;
	}

	/**
	 * Get the FM fields used to schedule
	 * @return [type] [description]
	 */
	public static function get_fm_fields() : array {
		return [
			'schedules' => new \Fieldmanager_Group(
				[
					'label'          => __( 'Schedules', 'civil-first-fleet' ),
					'limit'          => 0,
					'extra_elements' => 0,
					'label'          => __( 'New Schedule', 'civil-first-fleet' ),
					'label_macro'    => [ __( 'From %s-%s', 'civil-first-fleet' ), 'start_date', 'end_date' ],
					'add_more_label' => __( 'Add Schedule', 'civil-first-fleet' ),
					'collapsed'      => true,
					'collapsible'    => true,
					'sortable'       => true,
					'children'       => [
						'sponsor_ids'    => new \Fieldmanager_Zone_Field(
							[
								'label'      => __( 'Sponsor', 'cpr' ),
								'query_args' => [
									'post_type' => [ 'sponsor' ],
									'limit'     => 1,
								],
							]
						),
						'schedule'       => new \Fieldmanager_Checkbox( __( 'Schedule this sponsor?', 'civil-first-fleet' ) ),
						'start_date'     => new \Fieldmanager_Datepicker( __( 'Start Date', 'civil-first-fleet' ) ),
						'end_date'       => new \Fieldmanager_Datepicker( __( 'Start Date', 'civil-first-fleet' ) ),
					],
				]
			),
		];
	}

	public function parse_from_fm_data( $data ) : self {
		print($data); die();
		// Loop through schedules working from first to last. Using the first sponsor that either has no date range selected, or now() falls within that date range, display the sponsor (using whatever context we're in).

		$this->set_config( 'start_date', $data['start_date'] ?? '' );
		$this->set_config( 'end_date', $data['end_date'] ?? '' );

		$sponsor_id = $data['sponsor_ids'][0] ?? 0;
		$this->set_config( 'link', get_post_meta( $sponsor_id, 'link', true );
		$this->set_config( 'logo_id', get_post_meta( $sponsor_id, 'logo_id', true );
		$this->set_config( 'message', get_post_meta( $sponsor_id, 'message', true );
		$this->set_config( 'short_message', get_post_meta( $sponsor_id, 'short_message', true );

	}
}
