<?php
/**
 * Credibility Indicators component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Credibility Indicators component class.
 */
class Credibility_Indicators extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'credibility-indicators';

	/**
	 * Helper to get indicators.
	 *
	 * @return array Credibility Indicators.
	 */
	public static function get_indicators() {
		return [
			'original_reporting' => [
				'label'         => __( 'Original Reporting', 'civil-first-fleet' ),
				'default_value' => __( 'This article contains new, firsthand information uncovered by its reporter(s). This includes directly interviewing sources and research / analysis of primary source documents.', 'civil-first-fleet' ),
			],
			'on_the_ground' => [
				'label'         => __( 'On the Ground', 'civil-first-fleet' ),
				'default_value' => __( 'Indicates that a Newsmaker/Newsmakers was/were physically present to report the article from some/all of the location(s) it concerns.', 'civil-first-fleet' ),
			],
			'sources_cited' => [
				'label'         => __( 'Sources Cited', 'civil-first-fleet' ),
				'default_value' => __( 'As a news piece, this article cites verifiable, third-party sources which have all been thoroughly fact-checked and deemed credible by the Newsroom in accordance with the Civil Constitution.', 'civil-first-fleet' ),
			],
			'subject_specialist' => [
				'label'         => __( 'Subject Specialist', 'civil-first-fleet' ),
				'default_value' => __( 'This Newsmaker has been deemed by this Newsroom as having a specialized knowledge of the subject covered in this article.', 'civil-first-fleet' ),
			],
		];
	}

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'indicators'      => self::get_indicators(),
			'learn_more_text' => __( 'Learn more about Civil’s Credibility Indicators', 'civil-first-fleet' ),
			'learn_more_link' => 'https://civil.co/credibility-indicators',
		];
	}

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		// Array to build fields.
		$data = [];

		// Loop through indicators and build FM fields.
		foreach ( self::get_indicators() as $key => $data ) {
			$data[ $key ] = false;
		}

		return $data;
	}

	/**
	 * Component Fieldmanager fields for a post's sidebar.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function article_fields() : array {
		// Array to build fields.
		$fields = [];

		// Loop through indicators and build FM fields.
		foreach ( self::get_indicators() as $key => $data ) {
			$fields[ $key ] = new \Fieldmanager_Checkbox(
				[
					'label' => $data['label'],
				]
			);
		}

		return $fields;
	}

	/**
	 * Component fields for newsrooms to customize.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {

		// Loop through indicators and build FM fields.
		$indicator_fm_fields = [];
		foreach ( self::get_indicators() as $key => $data ) {
			$indicator_fm_fields[ $key ] = new \Fieldmanager_Group(
				[
					'label'     => $data['label'],
					'collapsed' => true,
					'children'  => [
						'label' => new \Fieldmanager_Hidden(
							[
								'default_value' => $data['label'],
							]
						),
						'default_value' => new \Fieldmanager_Textarea(
							[
								'default_value' => $data['default_value'],
							]
						),
					],
				]
			);
		}

		return [
			'indicators'      => new \Fieldmanager_Group(
				[
					'children'  => $indicator_fm_fields,
				]
			),
			'learn_more_text' => new \Fieldmanager_Textfield(
				[
					'label'         => __( 'Learn More Text', 'civil-first-fleet' ),
					'default_value' => $this->get_setting( 'learn_more_text' ),
				]
			),
			'learn_more_link' => new \Fieldmanager_Link(
				[
					'label'         => __( 'Learn More Link', 'civil-first-fleet' ),
					'default_value' => $this->get_setting( 'learn_more_link' ),
				]
			),
		];
	}

	/**
	 * Set default data values before render.
	 */
	public function pre_render() {
		$newsroom_settings = (array) $this->get_option( 'newsroom-settings', 'component_defaults', 'credibility_indicators' );
		if ( ! empty( $newsroom_settings ) ) {
			$this->set_setting( $newsroom_settings );
		}
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Credibility_Indicators  An instance of this component.
 */
function credibility_indicators( array $settings = [], array $data = [], array $fm_fields = [] ) : Credibility_Indicators {
	return new Credibility_Indicators( $settings, $data, $fm_fields );
}
