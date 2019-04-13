<?php
/**
 * Call To Action component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Call To Action component class.
 */
class Call_To_Action extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'call-to-action';

	/**
	 * Default component settings.
	 * Supported types: subscribe, newsletter
	 * Supported themes: light, medium, dark
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'layout'     => 'block',
			'newsletter' => '',
			'theme'      => 'light',
			'type'       => 'subscribe',
		];
	}

	/**
	 * Default component data.
	 *
	 * @todo unique id
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'customize'   => false,
			'id'          => 'call-to-action',
			'title'       => '',
			'description' => '',
			'button_text' => __( 'Subscribe Now', 'civil-first-fleet' ),
			'button'      => [],
		];
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

		return [
			'enable' => new \Fieldmanager_Checkbox( __( 'Enable', 'civil-first-fleet' ) ),
			'settings' => new \Fieldmanager_Group(
				[
					'label' => __( 'Settings', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'type'  => new \Fieldmanager_Select(
							[
								'label'   => __( 'Type', 'civil-first-fleet' ),
								'options' => array(
									'subscribe'  => __( 'Subscribe', 'civil-first-fleet' ),
									'newsletter' => __( 'Newsletter Sign up', 'civil-first-fleet' ),
								),
							]
						),
						'theme' => new \Fieldmanager_Select(
							[
								'label'   => __( 'Theme', 'civil-first-fleet' ),
								'options' => [
									'light'  => __( 'Light', 'civil-first-fleet' ),
									'medium' => __( 'Medium', 'civil-first-fleet' ),
									'dark'   => __( 'Dark', 'civil-first-fleet' ),
								],
							]
						),
						'layout' => new \Fieldmanager_Select(
							[
								'label'   => __( 'Layout', 'civil-first-fleet' ),
								'options' => [
									'block'  => __( 'Block', 'civil-first-fleet' ),
									'inline' => __( 'Inline', 'civil-first-fleet' ),
								],
							]
						),
						'newsletter' => new \Fieldmanager_Select(
							[
								'label'       => __( 'Newsletter', 'civil-first-fleet' ),
								'options'     => $this->get_newsletter_options(),
								'display_if'  => [
									'src'   => 'type',
									'value' => 'newsletter',
								],
							]
						),
					],
					'display_if' => [
						'src'   => 'enable',
						'value' => true,
					],
				]
			),
			'data' => new \Fieldmanager_Group(
				[
					'label'     => __( 'Override Copy', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'customize' => new \Fieldmanager_Checkbox( __( 'Customize Copy', 'civil-first-fleet' ) ),
						'title'       => new \Fieldmanager_Textfield(
							[
								'label' => __( 'Title', 'civil-first-fleet' ),
								'display_if' => [
									'src' => 'customize',
									'value' => true,
								],
							]
						),
						'description' => new \Fieldmanager_Textfield(
							[
								'label' => __( 'Description', 'civil-first-fleet' ),
								'display_if' => [
									'src' => 'customize',
									'value' => true,
								],
							]
						),
						'button' => new \Fieldmanager_Group(
							[
								'children' => \Civil_First_Fleet\Components\Call_To_Action\Button::get_fm_fields(),
							]
						),
					],
					'display_if' => [
						'src'   => 'enable',
						'value' => true,
					],
				]
			),
		];
	}
	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function sticky_cta_fm_fields() : array {
		return [
			'enable' => new \Fieldmanager_Checkbox( __( 'Enable', 'civil-first-fleet' ) ),
			'settings' => new \Fieldmanager_Group(
				[
					'label' => __( 'Settings', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'type'  => new \Fieldmanager_Select(
							[
								'label'   => __( 'Type', 'civil-first-fleet' ),
								'options' => array(
									'subscribe'  => __( 'Subscribe', 'civil-first-fleet' ),
									'newsletter' => __( 'Newsletter Sign up', 'civil-first-fleet' ),
								),
							]
						),
						'newsletter' => new \Fieldmanager_Select(
							[
								'label'       => __( 'Newsletter', 'civil-first-fleet' ),
								'options'     => $this->get_newsletter_options(),
								'display_if'  => [
									'src'   => 'type',
									'value' => 'newsletter',
								],
							]
						),
					],
					'display_if' => [
						'src'   => 'enable',
						'value' => true,
					],
				]
			),
			'data' => new \Fieldmanager_Group(
				[
					'label'     => __( 'Override Copy', 'civil-first-fleet' ),
					'collapsed' => true,
					'children'  => [
						'customize' => new \Fieldmanager_Checkbox( __( 'Customize Copy', 'civil-first-fleet' ) ),
						'title'       => new \Fieldmanager_Textfield(
							[
								'label' => __( 'Title', 'civil-first-fleet' ),
								'display_if' => [
									'src' => 'customize',
									'value' => true,
								],
							]
						),
						'description' => new \Fieldmanager_Textfield(
							[
								'label' => __( 'Description', 'civil-first-fleet' ),
								'display_if' => [
									'src' => 'customize',
									'value' => true,
								],
							]
						),
						'button_text' => new \Fieldmanager_Textfield(
							[
								'label' => __( 'Button Text', 'civil-first-fleet' ),
								'display_if' => [
									'src' => 'customize',
									'value' => true,
								],
							]
						),
					],
					'display_if' => [
						'src'   => 'enable',
						'value' => true,
					],
				]
			),
		];
	}

	/**
	 * Render this component using the correct layout option.
	 */
	public function render() {
		if ( false === (bool) $this->data( 'customize' ) ) {
			$type = $this->setting( 'type' );
			$defaults = (array) $this->get_option( 'newsroom-settings', 'component_defaults', "{$type}_call_to_action", 'data' );
			$this->set_data( $defaults );
		}

		if ( 'sticky' === $this->setting( 'layout' ) ) {
			\ai_get_template_part(
				$this->get_component_path( 'sticky' ), [
					'component'  => $this,
					'stylesheet' => 'sticky-cta',
				]
			);
		} else {
			\ai_get_template_part(
				$this->get_component_path( $this->setting( 'type' ) ), [
					'component'  => $this,
					'stylesheet' => $this->slug,
				]
			);
		}
	}

	/**
	 * Return an array of Mailchimp newsletter options.
	 *
	 * @return array Newsletters.
	 */
	public function get_newsletter_options() : array {
		$newsletters      = [];
		$newsletter_lists = (array) $this->get_option( 'newsroom-settings', 'newsletter', 'mailchimp_lists', 'lists' );

		// Loop through lists and build array.
		foreach ( $newsletter_lists as $list ) {
			$list = wp_parse_args(
				$list,
				[
					'id'   => '',
					'name' => '',
				]
			);

			// Validate both properties.
			if (
				! empty( $list['name'] )
				&& ! empty( $list['id'] )
			) {
				$newsletters[ sanitize_title( $list['name'] ) ] = $list['name'];
			}
		}

		return $newsletters;
	}

	/**
	 * Output the newsletter options in a format that Gutenberg can use.
	 */
	public function get_newsletter_options_for_gutenberg() {

		// Format newsletters for Gutenberg.
		$newsletters = [];
		foreach ( (array) $this->get_newsletter_options() as $value => $label ) {
			$newsletters[] = [
				'value' => $value,
				'label' => $label,
			];
		}

		return $newsletters;
	}

	/**
	 * Get a newsletter list id by the slugified name.
	 *
	 * @param  string $slug Slugified name.
	 * @return string Newsletter list id.
	 */
	public function get_newsletter_list_id_by_slug( string $slug = '' ) : string {
		$newsletter_lists = (array) $this->get_option( 'newsroom-settings', 'newsletter', 'mailchimp_lists', 'lists' );

		// Return the list id that corresponds to this slug.
		foreach ( $newsletter_lists as $list ) {
			if ( sanitize_title( $list['name'] ) === $slug ) {
				return $list['id'];
			}
		}

		// Return first value as a default value.
		return $newsletter_lists[0]['id'] ?? '';
	}

	/**
	 * Register Gutenberg blocks for this component.
	 *
	 * @return Component_Name  An instance of this component.
	 */
	public function register_blocks() {
		if ( function_exists( 'register_block_type' ) ) {
			register_block_type(
				"civil/{$this->slug}",
				[
					'editor_script' => 'block-js-' . $this->slug,
					'render_callback' => function( array $attributes ) {
						return $this->render_block_data( $attributes );
					},
					'attributes' => [
						'title' => [
							'type'    => 'text',
							'default' => __( 'CTA Title', 'civil-first-fleet' ),
						],
						'cta_text' => [
							'type'    => 'text',
							'default' => __( 'CTA Description', 'civil-first-fleet' ),
						],
						'cta_button_text' => [
							'type'    => 'text',
							'default' => __( 'CTA Button', 'civil-first-fleet' ),
						],
						'newsletter' => [
							'type' => 'boolean',
						],
						'newsletter_list' => [
							'type' => 'text',
						],
					],
				]
			);
		}

		return $this;
	}

	/**
	 * Format Gutenberg block data to appear in the component template and render it.
	 *
	 * @param Array $attributes A list of block attributes to be rendered dynamically.
	 * @return String Template output to be returned when the content is rendered.
	 */
	public function render_block_data( $attributes ) {
		$type = ! empty( $attributes['newsletter'] ) ? 'newsletter' : 'subscribe';
		$this->set_setting( 'type', $type );
		$this->set_setting( 'layout', 'inline' );
		$this->set_setting( 'newsletter', $attributes['newsletter_list'] ?? '' );
		$this->set_data( 'title', $attributes['title'] ?? 'Test' );
		$this->set_data( 'description', $attributes['cta_text'] ?? 'Whatever' );
		$this->set_data( 'button_text', $attributes['cta_button_text'] ?? '' );

		return ai_partial(
			[
				'slug' => $this->get_component_path( $this->setting( 'type' ) ),
				'return' => true,
				'variables' => [
					'component'  => $this,
					'stylesheet' => $this->slug,
				],
			]
		);
	}

	/**
	 * Expose newsletter options for CTA block
	 */
	public function provide_newsletter_options() {
		wp_add_inline_script(
			'civil-first-fleet-admin-js',
			sprintf(
				'var civilNewsletterOptions = %1$s;',
				wp_json_encode( $this->get_newsletter_options_for_gutenberg() )
			)
		);
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Component_Name  An instance of this component.
 */
function call_to_action( array $settings = [], array $data = [], array $fm_fields = [] ) : Call_To_Action {
	return new Call_To_Action( $settings, $data );
}

/**
 * Register Gutenberg block type Call to Action on init.
 */
add_action(
	'init',
	function() {
		call_to_action()->register_blocks();
	}
);

add_action(
	'admin_enqueue_scripts',
	function() {
		call_to_action()->provide_newsletter_options();
	},
	11
);

/**
 * Handle newsletter form submissions.
 */
function newsletter_submission_ajax() {

	/**
	 * Validate nonce.
	 */
	if ( ! isset( $_POST['newsletter_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['newsletter_nonce'] ) ), 'civil_newsletter_nonce' ) ) {
		wp_send_json_error( __( 'Something went wrong! Reload the page and try again.', 'civil-first-fleet' ) );
	}

	/**
	 * Validate email.
	 */
	if ( empty( $_POST['email'] ) ) {
		wp_send_json_error( __( 'Please provide an email.', 'civil-first-fleet' ) );
	}
	$email = sanitize_text_field( wp_unslash( $_POST['email'] ) );

	// Invalid email.
	if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		wp_send_json_error( __( 'Email is invalid, please enter a valid email address (i.e. email@example.com).', 'civil-first-fleet' ) );
	}

	/**
	 * Validate mailchimp list slug.
	 */
	$list = '';
	if ( ! empty( $_POST['list'] ) ) {
		// Get sanitized list slug.
		$list = sanitize_text_field( wp_unslash( $_POST['list'] ) );
	}

	/**
	 * Get various settings.
	 */
	$call_to_action     = new Call_To_Action();
	$newsletter_list_id = $call_to_action->get_newsletter_list_id_by_slug( $list );
	$mailchimp_api_key  = $call_to_action->get_option( 'newsroom-settings', 'newsletter', 'mailchimp_api_key' );
	$success_message    = $call_to_action->get_option( 'newsroom-settings', 'newsletter', 'success_message' );

	// Validate newsletter list id.
	if ( empty( $newsletter_list_id ) ) {
		wp_send_json_error( __( 'No email list found.', 'civil-first-fleet' ) );
	}

	// Fallback success message.
	if ( empty( $success_message ) ) {
		$success_message = __( 'Thank you for subscribing!', 'civil-first-fleet' );
	}

	// Mailchimp is not configured for this site.
	if ( empty( $mailchimp_api_key ) ) {
		wp_send_json_error( __( 'Mailchimp is not configured properly.', 'civil-first-fleet' ) );
	}

	// Get the domain.
	$domain = substr( $mailchimp_api_key, strpos( $mailchimp_api_key, '-' ) + 1 );

	// Send data to Mailchimp.
	$response = wp_remote_post(
		'https://' . $domain . '.api.mailchimp.com/3.0/lists/' . $newsletter_list_id . '/members',
		[
			'headers' => [
				'Authorization' => 'Basic ' . base64_encode( 'user:' . $mailchimp_api_key ),
				'Content Type'  => 'application/json',
			],
			'body' => wp_json_encode(
				[
					'email_address' => $email,
					'status'        => 'subscribed',
				]
			),
		]
	);

	// Check response.
	if ( is_wp_error( $response ) ) {
		wp_send_json_error( $response->get_error_message() );
	}

	// Get response body.
	$body = json_decode( wp_remote_retrieve_body( $response ), true );

	// New subscription confirmed.
	if ( ! empty( $body['id'] ) ) {
		wp_send_json_success( $success_message );
	}

	// Generic error if title and detail are unavailable.
	if ( empty( $body['title'] ) || empty( $body['detail'] ) ) {
		wp_send_json_success( esc_html__( 'Something went wrong. Unknown error.', 'civil-first-fleet' ) );
	}

	// Determine which response to use.
	switch ( $body['title'] ) {
		case 'Member Exists':
			$message = __( 'You are already subscribed to this list. Thanks!', 'civil-first-fleet' );
			break;

		default:
			$message = $body['detail'];
	}

	wp_send_json_success( $message );
}
add_action( 'wp_ajax_civil_newsletter_submission', __NAMESPACE__ . '\newsletter_submission_ajax' );
add_action( 'wp_ajax_nopriv_civil_newsletter_submission', __NAMESPACE__ . '\newsletter_submission_ajax' );
