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
			'label' => '',
			'link'  => '',
			'theme' => 'module',
		];
	}

	/**
	 * Hook into post being set.
	 *
	 * @return self
	 */
	public function post_has_set() : self {

		$label = (string) get_post_meta( $this->get_post_id(), 'label', true );
		if ( empty( $label ) ) {
			$label = self::get_default_eyebrow_label();
		}
		$this->set_config( 'label', $label );
		$this->set_config( 'link', get_post_meta( $this->get_post_id(), 'link', true ) );

		// Append the message and short_message as HTML components.
		$this->append_children(
			[
				// Message HTML component.
				( new \WP_Components\HTML() )
					->set_config( 'context', 'message' )
					->set_config( 'content', (string) get_post_meta( $this->get_post_id(), 'message', true ) ),
				self::get_content_below_sponsor_component(),
			]
		);

		// Add the sponsor logo as a child component.
		$logo_id = get_post_meta( $this->get_post_id(), 'logo_id', true );
		if ( ! empty( $logo_id ) ) {
			$this->append_child(
				// Note: We're mixing component libraries here. Sponsor uses WP
				// Components, and this image class is an older version. This
				// is because to use the WP Component's image we'd have to
				// refactor quite a bit, so we'll come back to this later.
				\Civil_First_Fleet\Component\image()
					->set_post_id( $logo_id )
					->size( 'sponsor-logo' )
					->aspect_ratio( false )
					->set_data( 'alt', $this->wp_post_get_title() )
					->disable_lazyload()
			);
		}

		return $this;
	}

	/**
	 * Get the default eyebrow label text.
	 *
	 * @return string
	 */
	public static function get_default_eyebrow_label() {
		return __( 'Supported Today By', 'civil-first-fleet' );
	}

	/**
	 * Get the FM fields used for the sponsor post type.
	 *
	 * @return array
	 */
	public static function get_fm_fields() {
		return [
			'label'   => new \Fieldmanager_Textfield(
				[
					'label'         => __( 'Eyebrow Label', 'civil-first-fleet' ),
					'default_value' => self::get_default_eyebrow_label(),
					'description'   => __( 'Intro that appears above/next to the logo.', 'civil-first-fleet' ),
				]
			),
			'link'    => new \Fieldmanager_Link(
				[
					'label'       => __( 'Link', 'civil-first-fleet' ),
					'description' => __( 'When your sponsor is clicked, where should the user go?', 'civil-first-fleet' ),
				]
			),
			'logo_id' => new \Fieldmanager_Media(
				[
					'label'       => __( 'Logo', 'civil-first-fleet' ),
					'description' => __( 'Logo of the sponsor. This will automatically resize as needed.', 'civil-first-fleet' ),
				]
			),
			'message' => new \Fieldmanager_RichTextArea(
				[
					'label'       => __( 'Message', 'civil-first-fleet' ),
					'description' => __( 'Mesage from the sponsor.', 'civil-first-fleet' ),
				]
			),
		];
	}

	/**
	 * Get the FM fields used to schedule sponsors.
	 *
	 * @return array
	 */
	public static function get_schedule_fm_fields() : array {
		return [
			'schedules' => new \Fieldmanager_Group(
				[
					'label'          => __( 'Sponsor Schedules', 'civil-first-fleet' ),
					'limit'          => 0,
					'extra_elements' => 0,
					'label'          => __( 'New Schedule', 'civil-first-fleet' ),
					'label_macro'    => [ '%s', 'sponsor_id' ],
					'add_more_label' => __( 'Add Schedule', 'civil-first-fleet' ),
					'collapsed'      => true,
					'collapsible'    => true,
					'sortable'       => true,
					'children'       => [
						'sponsor_id'      => new \Fieldmanager_Autocomplete(
							[
								'datasource' => new \Fieldmanager_Datasource_Post(
									[
										'query_args' => [
											'post_type' => 'sponsor',
										],
									]
								),
							]
						),
						'enable_schedule' => new \Fieldmanager_Checkbox( __( 'Schedule this sponsor?', 'civil-first-fleet' ) ),
						'start_date'      => new \Fieldmanager_Datepicker(
							[
								'label'       => __( 'Start Date', 'civil-first-fleet' ),
								'description' => __( 'Sponsorship will begin at 12:01am on this date.', 'civil-first-fleet' ),
								'display_if'  => [
									'src'   => 'enable_schedule',
									'value' => true,
								],
							]
						),
						'end_date'        => new \Fieldmanager_Datepicker(
							[
								'label'       => __( 'End Date', 'civil-first-fleet' ),
								'description' => __( 'Sponsorship will end at 12:01 on this date (this date _will not_ display the sponsor).', 'civil-first-fleet' ),
								'display_if'  => [
									'src'   => 'enable_schedule',
									'value' => true,
								],
							]
						),
					],
				]
			),
		];
	}

	/**
	 * Parse the first valid sponsor from an array of scheduled sponsors.
	 *
	 * @param array $schedules Schedules.
	 * @return self
	 */
	public function parse_from_schedule_fm_data( array $schedules ) : self {

		// Loop through schedules to determine which sponsor should be displayed.
		foreach ( $schedules as $schedule ) {

			// Validate the schedule shape.
			$schedule = wp_parse_args(
				$schedule,
				[
					'enable_schedule' => false,
					'end_date'        => '',
					'sponsor_id'      => 0,
					'start_date'      => '',
				]
			);

			// If enable schedule is false, use this sponsor.
			if ( ! filter_var( $schedule['enable_schedule'] ?? false, FILTER_VALIDATE_BOOLEAN ) ) {
				$this->set_post( $schedule['sponsor_id'] ?? 0 );
				return $this;
			}

			// phpcs:disable WordPress.DateTime.CurrentTimeTimestamp.Requested
			$current_time = current_time( 'timestamp' );

			// Determine which sponsor should display based on the scheduled
			// dates.
			// @todo figure out timezone offsets.
			if (
				! empty( $schedule['start_date'] )
				&& ! empty( $schedule['end_date'] )
				&& $current_time > $schedule['start_date']
				&& $current_time < $schedule['end_date']
			) {
				// Start date and end date aren't empty.
				// Current time is between start date and end date.
				$this->set_post( $schedule['sponsor_id'] ?? 0 );
				return $this;
			} elseif (
				! empty( $schedule['start_date'] )
				&& $current_time > $schedule['start_date']
			) {
				// Show sponsor if there isn't an end date, and start date has
				// passed.
				$this->set_post( $schedule['sponsor_id'] ?? 0 );
				return $this;
			} elseif (
				! empty( $schedule['end_date'] )
				&& $current_time < $schedule['end_date']
			) {
				// Show sponsor if there isn't a start date, and we're before
				// the end date.
				$this->set_post( $schedule['sponsor_id'] ?? 0 );
				return $this;
			}
		}

		// No valid sponsor has been set.
		$this->set_invalid();

		return $this;
	}

	/**
	 * Get the FM fields for the submenu settings.
	 *
	 * @return array
	 */
	public static function get_submenu_fm_fields() {
		return [
			'settings' => new \Fieldmanager_Group(
				[
					'label'    => __( 'Content Below Sponsor', 'civil-first-fleet' ),
					'children' => [
						'below_sponsor' => new \Fieldmanager_RichTextArea(
							[
								'description' => __( 'This content will appear below the sponsor. Use it for disclaimers or calls to action.', 'civil-first-fleet' ),
							]
						),
					],
				]
			),
		];
	}

	/**
	 * Get the HTML component for the content below the sponsor.
	 *
	 * @return \WP_Components
	 */
	public static function get_content_below_sponsor_component() {
		$newsroom_settings = (array) get_option( 'newsroom-settings' );
		$content           = $newsroom_settings['sponsors']['settings']['below_sponsor'] ?? '';
		$component         = new \WP_Components\HTML();

		if ( empty( $content ) ) {
			$component->set_invalid();
		} else {
			$component->set_config( 'context', 'below_sponsor' );
			$component->set_config( 'content', $content );
		}

		return $component;
	}
}
