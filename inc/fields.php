<?php
/**
 * Fieldmanager fields
 *
 * @package Civil_First_Fleet
 */

/* begin fm:post-landing-page-settings */
/**
 * `post-landing-page-settings` Fieldmanager fields.
 */
function civil_cms_fm_post_landing_page_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name' => 'post-landing-page-settings',
			'serialize_data' => false,
			'add_to_prefix' => false,
			'children' => [
				'landing_page_type' => new Fieldmanager_Select(
					[
						'first_empty' => true,
						'options' => \Civil_CMS\get_landing_page_types(),
					]
				),
				'homepage' => new Fieldmanager_Group(
					[
						'label' => __( 'Homepage', 'civil-cms' ),
						'tabbed' => 'vertical',
						'display_if' => [
							'src' => 'landing_page_type',
							'value' => 'homepage',
						],
						'children' => \Civil_CMS\get_homepage_fields(),
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Landing Page Settings', 'civil-cms' ), [ 'landing-page' ], 'normal', 'high' );
}
add_action( 'fm_post_landing-page', 'civil_cms_fm_post_landing_page_settings' );
/* end fm:post-landing-page-settings */

/* begin fm:post-guest-author-info */
/**
 * `post-guest-author-info` Fieldmanager fields.
 */
function civil_cms_fm_post_guest_author_info() {
	$fm = new Fieldmanager_Group(
		[
			'name' => 'post-guest-author-info',
			'serialize_data' => false,
			'add_to_prefix' => false,
			'children' => [
				'email' => new Fieldmanager_TextField( __( 'Email', 'civil-cms' ) ),
				'twitter' => new Fieldmanager_TextField(
					[
						'label' => __( 'Twitter', 'civil-cms' ),
						'sanitize' => function( $value ) { return str_replace( '@', '', $value ); },
					]
				),
				'biography' => new Fieldmanager_RichTextArea(
					[
						'label' => __( 'Biography', 'civil-cms' ),
						'buttons_1' => [ 'bold', 'italic', 'link' ],
						'buttons_2' => [],
						'sanitize' => 'wp_filter_post_kses',
						'editor_settings' => [
							'media_buttons' => false,
						],
						'attributes' => [
							'style' => 'width: 100%',
							'rows' => 4,
						],
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Info', 'civil-cms' ), [ 'guest-author' ], 'normal' );
}
add_action( 'fm_post_guest-author', 'civil_cms_fm_post_guest_author_info' );
/* end fm:post-guest-author-info */

/* begin fm:submenu-newsroom-settings */
/**
 * `newsroom-settings` Fieldmanager fields.
 */
function civil_cms_fm_submenu_newsroom_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name' => 'newsroom-settings',
			'tabbed' => 'vertical',
			'serialize_data' => false,
			'add_to_prefix' => false,
			'children' => [
				'branding' => new Fieldmanager_Group(
					[
						'label' => __( 'Branding', 'civil-cms' ),
						'children' => [
							'logo' => new Fieldmanager_Group(
								[
									'label' => __( 'Logo', 'civil-cms' ),
									'children' => [
										'image_id' => new Fieldmanager_Media( __( 'Upload a logo image', 'civil-cms' ) ),
										'svg' => new Fieldmanager_TextArea( __( 'Logo SVG', 'civil-cms' ) ),
									],
								]
							),
							'footer_logo' => new Fieldmanager_Group(
								[
									'label' => __( 'Footer Logo', 'civil-cms' ),
									'children' => [
										'image_id' => new Fieldmanager_Media( __( 'Upload a logo image', 'civil-cms' ) ),
										'svg' => new Fieldmanager_TextArea( __( 'Logo SVG', 'civil-cms' ) ),
									],
								]
							),
						],
					]
				),
				'analytics' => new Fieldmanager_Group(
					[
						'label' => __( 'Analytics', 'civil-cms' ),
						'children' => [
							'ga_property_code' => new Fieldmanager_TextField(
								[
									'label' => __( 'Google Analytics Property ID', 'civil-cms' ),
									'description' => __( "This is the Google Analytics Property ID that will be used to track all data on this site. (i.e. 'UA-XXXXX-Y')", 'civil-cms' ),
								]
							),
						],
					]
				),
				'seo' => new Fieldmanager_Group(
					[
						'label' => __( 'SEO', 'civil-cms' ),
						'children' => [
							'social' => new Fieldmanager_Group(
								[
									'label' => __( 'Social', 'civil-cms' ),
									'children' => [
										'facebook_app_id' => new Fieldmanager_TextField(
											[
												'label' => __( 'Facebook App ID', 'civil-cms' ),
												'description' => __( 'Newsroom Facebook App ID', 'civil-cms' ),
											]
										),
										'twitter_handle' => new Fieldmanager_TextField(
											[
												'label' => __( 'Twitter Handle', 'civil-cms' ),
												'description' => __( 'Newsroom Twitter Handle', 'civil-cms' ),
												'sanitize' => function( $value ) { return str_replace( '@', '', $value ); },
											]
										),
									],
								]
							),
						],
					]
				),
				'newsletter' => new Fieldmanager_Group(
					[
						'label' => __( 'Newsletter', 'civil-cms' ),
						'children' => [
							'mailchimp_api_key' => new Fieldmanager_TextField( __( 'MailChimp API Key', 'civil-cms' ) ),
							'mailchimp_list_id' => new Fieldmanager_TextField(
								[
									'label' => __( 'MailChimp List ID', 'civil-cms' ),
									'attributes' => [
										'disabled' => true,
									],
									'description' => __( 'This field has been deprecated. Please add a new list below to use Mailchimp.', 'civil-cms' ),
								]
							),
							'success_message' => new Fieldmanager_TextField(
								[
									'label' => __( 'Success Message', 'civil-cms' ),
									'description' => __( 'The message shown to the user after a successful signup.', 'civil-cms' ),
									'default_value' => __( 'Thank you for subscribing!', 'civil-cms' ),
								]
							),
							'mailchimp_lists' => new Fieldmanager_Group(
								[
									'label' => __( 'Mailchimp Lists', 'civil-cms' ),
									'children' => [
										'lists' => new Fieldmanager_Group(
											[
												'label' => __( 'New List', 'civil-cms' ),
												'label_macro' => [ '%s', 'name' ],
												'limit' => 0,
												'collapsed' => true,
												'add_more_label' => __( 'Add List', 'civil-cms' ),
												'children' => [
													'name' => new Fieldmanager_TextField( __( 'List Name', 'civil-cms' ) ),
													'id' => new Fieldmanager_TextField( __( 'List ID', 'civil-cms' ) ),
												],
											]
										),
									],
								]
							),
							'sticky_call_to_action' => new Fieldmanager_Group(
								[
									'label' => __( 'Sticky CTA', 'civil-cms' ),
									'collapsed' => true,
									'children' => \Civil_CMS\Component\call_to_action()->set_fm_fields( \Civil_CMS\Component\call_to_action()->sticky_cta_fm_fields() )->get_fm_fields(),
								]
							),
						],
					]
				),
				'component_defaults' => new Fieldmanager_Group(
					[
						'label' => __( 'Component Defaults', 'civil-cms' ),
						'children' => [
							'paywall_call_to_action' => new Fieldmanager_Group(
								[
									'label' => __( 'Paywall Call to Action', 'civil-cms' ),
									'collapsed' => true,
									'children' => [
										'button_text' => new Fieldmanager_TextField(
											[
												'label' => __( 'Button Text', 'civil-cms' ),
												'description' => __( 'E.g. the "Subscribe" buttons in header and footer navs', 'civil-cms' ),
												'default_value' => __( 'Subscribe', 'civil-cms' ),
											]
										),
									],
								]
							),
							'credibility_indicators' => new Fieldmanager_Group(
								[
									'label' => __( 'Credibility Indicators', 'civil-cms' ),
									'collapsed' => true,
									'children' => \Civil_CMS\Component\credibility_indicators()->get_fm_fields(),
								]
							),
							'newsletter_call_to_action' => new Fieldmanager_Group(
								[
									'label' => __( 'Newsletter CTA', 'civil-cms' ),
									'collapsed' => true,
									'children' => \Civil_CMS\Component\call_to_action()->set_setting( 'type', 'newsletter' )->remove_fm_field( 'enable' )->remove_fm_field( 'settings' )->get_fm_fields(),
								]
							),
							'subscribe_call_to_action' => new Fieldmanager_Group(
								[
									'label' => __( 'Subscribe CTA', 'civil-cms' ),
									'collapsed' => true,
									'children' => \Civil_CMS\Component\call_to_action()->set_setting( 'type', 'subscribe' )->remove_fm_field( 'enable' )->remove_fm_field( 'settings' )->get_fm_fields(),
								]
							),
						],
					]
				),
				'contact' => new Fieldmanager_Group(
					[
						'label' => __( 'Contact Info', 'civil-cms' ),
						'children' => [
							'email' => new Fieldmanager_TextField(
								[
									'label' => __( 'Email Address', 'civil-cms' ),
									'default_value' => 'support@civil.co',
								]
							),
						],
					]
				),
				'search' => new Fieldmanager_Group(
					[
						'label' => __( 'Search', 'civil-cms' ),
						'children' => [
							'search_display' => new Fieldmanager_Group(
								[
									'label' => __( 'Search Form Display', 'civil-cms' ),
									'children' => [
										'show_search_in_header_nav' => new Fieldmanager_Checkbox( __( 'Show search form in header navigation.', 'civil-cms' ) ),
										'search_form_style' => new Fieldmanager_Select(
											[
												'label' => __( 'Display style:', 'civil-cms' ),
												'options' => [
													'trigger' => __( 'Toggle: Hide search form until user clicks icon to display it', 'civil-cms' ),
													'inline' => __( 'Inline: Show a search form in the header navigation', 'civil-cms' ),
												],
											]
										),
									],
								]
							),
						],
					]
				),
				'article_taxonomies' => new Fieldmanager_Group(
					[
						'label' => __( 'Article Taxonomies', 'civil-cms' ),
						'children' => \Civil_CMS\Component\article_taxonomies()->get_fm_fields(),
					]
				),
			],
		]
	);
	$fm->activate_submenu_page();
}
add_action( 'fm_submenu_newsroom-settings', 'civil_cms_fm_submenu_newsroom_settings' );
if ( function_exists( 'fm_register_submenu_page' ) ) {
	fm_register_submenu_page( 'newsroom-settings', 'options-general.php', __( 'Newsroom Settings', 'civil-cms' ), __( 'Newsroom Settings', 'civil-cms' ), 'manage_options' );
}
/* end fm:submenu-newsroom-settings */

/* begin fm:post-post-article-settings */
/**
 * `post-post-article-settings` Fieldmanager fields.
 */
function civil_cms_fm_post_post_article_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name' => 'post-post-article-settings',
			'tabbed' => 'vertical',
			'serialize_data' => false,
			'add_to_prefix' => false,
			'children' => [
				'settings_group' => new Fieldmanager_Group(
					[
						'label' => __( 'Settings', 'civil-cms' ),
						'serialize_data' => false,
						'add_to_prefix' => false,
						'children' => [
							'dek' => new Fieldmanager_TextArea(
								[
									'label' => __( 'Deck', 'civil-cms' ),
									'attributes' => [
										'style' => 'width: 100%;',
										'rows' => '5',
									],
								]
							),
							'primary_category_id' => new Fieldmanager_Autocomplete(
								[
									'label' => __( 'Primary Category', 'civil-cms' ),
									'description' => __( 'Begin typing to select a primary category.', 'civil-cms' ),
									'datasource' => new Fieldmanager_Datasource_Term(
										[
											'taxonomy' => 'category',
											'taxonomy_save_to_terms' => false,
											'only_save_to_taxonomy' => false,
										]
									),
								]
							),
							'label' => new Fieldmanager_Checkboxes(
								[
									'label' => __( 'Enable Label', 'civil-cms' ),
									'options' => \Civil_CMS\Component\Content_Item()->get_label_options(),
								]
							),
						],
					]
				),
				'featured_media' => new Fieldmanager_Group(
					[
						'label' => __( 'Featured Media', 'civil-cms' ),
						'serialize_data' => false,
						'add_to_prefix' => false,
						'children' => [
							'disable_featured_image' => new Fieldmanager_Checkbox(
								[
									'label' => __( 'Hide image on article header', 'civil-cms' ),
									'description' => __( 'This will still display as the thumbnail on archives.', 'civil-cms' ),
								]
							),
							'featured_video_url' => new Fieldmanager_Link( __( 'Video URL for the featured homepage slot and article header.', 'civil-cms' ) ),
						],
					]
				),
				'credibility_indicators_group' => new Fieldmanager_Group(
					[
						'label' => __( 'Credibility Indicators', 'civil-cms' ),
						'serialize_data' => false,
						'add_to_prefix' => false,
						'children' => [
							'credibility_indicators' => new Fieldmanager_Group(
								[
									'children' => \Civil_CMS\Component\credibility_indicators()->article_fields(),
								]
							),
						],
					]
				),
				'call_to_action_group' => new Fieldmanager_Group(
					[
						'label' => __( 'Call to Action', 'civil-cms' ),
						'serialize_data' => false,
						'add_to_prefix' => false,
						'children' => [
							'call_to_action' => new Fieldmanager_Group(
								[
									'children' => \Civil_CMS\Component\call_to_action()->get_fm_fields(),
								]
							),
						],
					]
				),
				'secondary_bylines_group' => new Fieldmanager_Group(
					[
						'label' => __( 'Secondary Bylines', 'civil-cms' ),
						'serialize_data' => false,
						'add_to_prefix' => false,
						'children' => [
							'secondary_bylines' => new Fieldmanager_Group(
								[
									'limit' => 0,
									'add_more_label' => __( 'Add Byline', 'civil-cms' ),
									'label' => __( 'New Byline', 'civil-cms' ),
									'label_macro' => [ 'Byline: %s', 'type' ],
									'minimum_count' => 0,
									'extra_elements' => 0,
									'collapsed' => true,
									'sortable' => true,
									'children' => [
										'role' => new Fieldmanager_TextField(
											[
												'label' => __( 'Role', 'civil-cms' ),
												'description' => __( 'e.g., "Edited by", "Fact-checked by"', 'civil-cms' ),
											]
										),
										'id' => new Fieldmanager_Autocomplete(
											[
												'label' => __( 'Name', 'civil-cms' ),
												'description' => __( 'Begin typing to select a user.', 'civil-cms' ),
												'datasource' => new Fieldmanager_Datasource_Post(
													[
														'query_args' => [
															'post_type' => [ 'guest-author' ],
														],
													]
												),
												'display_if' => [
													'src' => 'name_toggle',
													'value' => false,
												],
											]
										),
										'custom_name' => new Fieldmanager_TextField(
											[
												'label' => __( 'Name', 'civil-cms' ),
												'description' => __( 'Enter a custom name.', 'civil-cms' ),
												'display_if' => [
													'src' => 'name_toggle',
													'value' => true,
												],
											]
										),
										'name_toggle' => new Fieldmanager_Checkbox( __( 'Manually enter name.', 'civil-cms' ) ),
									],
								]
							),
						],
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Article Settings', 'civil-cms' ), [ 'post' ] );
}
add_action( 'fm_post_post', 'civil_cms_fm_post_post_article_settings' );
/* end fm:post-post-article-settings */
