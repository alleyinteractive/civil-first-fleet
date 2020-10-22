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
function civil_first_fleet_fm_post_landing_page_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'post-landing-page-settings',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'landing_page_type' => new Fieldmanager_Select(
					[
						'first_empty' => true,
						'options'     => \Civil_First_Fleet\get_landing_page_types(),
					]
				),
				'homepage'          => new Fieldmanager_Group(
					[
						'label'      => __( 'Homepage', 'civil-first-fleet' ),
						'tabbed'     => 'vertical',
						'display_if' => [
							'src'   => 'landing_page_type',
							'value' => 'homepage',
						],
						'children'   => \Civil_First_Fleet\get_homepage_fields(),
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Landing Page Settings', 'civil-first-fleet' ), [ 'landing-page' ], 'normal', 'high' );
}
add_action( 'fm_post_landing-page', 'civil_first_fleet_fm_post_landing_page_settings' );
/* end fm:post-landing-page-settings */

/* begin fm:post-guest-author-info */
/**
 * `post-guest-author-info` Fieldmanager fields.
 */
function civil_first_fleet_fm_post_guest_author_info() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'post-guest-author-info',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'email'     => new Fieldmanager_TextField( __( 'Email', 'civil-first-fleet' ) ),
				'twitter'   => new Fieldmanager_TextField(
					[
						'label'    => __( 'Twitter', 'civil-first-fleet' ),
						'sanitize' => function( $value ) { return str_replace( '@', '', $value ); },
					]
				),
				'biography' => new Fieldmanager_RichTextArea(
					[
						'label'           => __( 'Biography', 'civil-first-fleet' ),
						'buttons_1'       => [ 'bold', 'italic', 'link' ],
						'buttons_2'       => [],
						'sanitize'        => 'wp_filter_post_kses',
						'editor_settings' => [
							'media_buttons' => false,
						],
						'attributes'      => [
							'style' => 'width: 100%',
							'rows'  => 4,
						],
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Info', 'civil-first-fleet' ), [ 'guest-author' ], 'normal' );
}
add_action( 'fm_post_guest-author', 'civil_first_fleet_fm_post_guest_author_info' );
/* end fm:post-guest-author-info */

/* begin fm:submenu-newsroom-settings */
/**
 * `newsroom-settings` Fieldmanager fields.
 */
function civil_first_fleet_fm_submenu_newsroom_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'newsroom-settings',
			'tabbed'         => 'vertical',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'branding'           => new Fieldmanager_Group(
					[
						'label'    => __( 'Branding', 'civil-first-fleet' ),
						'children' => [
							'logo'           => new Fieldmanager_Group(
								[
									'label'    => __( 'Logo', 'civil-first-fleet' ),
									'children' => [
										'image_id' => new Fieldmanager_Media( __( 'Upload a logo image', 'civil-first-fleet' ) ),
										'svg'      => new Fieldmanager_TextArea( __( 'Logo SVG', 'civil-first-fleet' ) ),
									],
								]
							),
							'footer_logo'    => new Fieldmanager_Group(
								[
									'label'    => __( 'Footer Logo', 'civil-first-fleet' ),
									'children' => [
										'image_id' => new Fieldmanager_Media( __( 'Upload a logo image', 'civil-first-fleet' ) ),
										'svg'      => new Fieldmanager_TextArea( __( 'Logo SVG', 'civil-first-fleet' ) ),
									],
								]
							),
							'civil_branding' => new Fieldmanager_Group(
								[
									'label'    => __( 'Civil Branding', 'civil-first-fleet' ),
									'children' => [
										'disable_header_cta' => new Fieldmanager_Checkbox( __( "Disable 'This Newsroom runs on Civil' call to action in header.", 'civil-first-fleet' ) ),
										'disable_footer'     => new Fieldmanager_Checkbox( __( 'Disable the Civil footer.', 'civil-first-fleet' ) ),
									],
								]
							),
						],
					]
				),
				'analytics'          => new Fieldmanager_Group(
					[
						'label'    => __( 'Analytics', 'civil-first-fleet' ),
						'children' => [
							'ga_property_code'  => new Fieldmanager_TextField(
								[
									'label'       => __( 'Google Analytics Property ID', 'civil-first-fleet' ),
									'description' => __( "This is the Google Analytics Property ID that will be used to track all data on this site. (i.e. 'UA-XXXXX-Y')", 'civil-first-fleet' ),
								]
							),
							'gtm_property_code' => new Fieldmanager_TextField(
								[
									'label'       => __( 'Google Tag Manager Property ID', 'civil-first-fleet' ),
									'description' => __( "This is the Google Tag Manager Property ID that will be used to track all data on this site. (i.e. 'GTM-XXXX')", 'civil-first-fleet' ),
								]
							),
						],
					]
				),
				'seo'                => new Fieldmanager_Group(
					[
						'label'    => __( 'SEO', 'civil-first-fleet' ),
						'children' => [
							'social' => new Fieldmanager_Group(
								[
									'label'    => __( 'Social', 'civil-first-fleet' ),
									'children' => [
										'facebook_app_id' => new Fieldmanager_TextField(
											[
												'label'       => __( 'Facebook App ID', 'civil-first-fleet' ),
												'description' => __( 'Newsroom Facebook App ID', 'civil-first-fleet' ),
											]
										),
										'twitter_handle'  => new Fieldmanager_TextField(
											[
												'label'       => __( 'Twitter Handle', 'civil-first-fleet' ),
												'description' => __( 'Newsroom Twitter Handle', 'civil-first-fleet' ),
												'sanitize'    => function( $value ) { return str_replace( '@', '', $value ); },
											]
										),
									],
								]
							),
						],
					]
				),
				'header'             => new Fieldmanager_Group(
					[
						'label'    => __( 'Header', 'civil-first-fleet' ),
						'children' => [
							'call_to_action_button' => new Fieldmanager_Group(
								[
									'label'    => __( 'Call To Action Button', 'civil-first-fleet' ),
									'children' => \Civil_First_Fleet\Components\Call_To_Action\Button::get_fm_fields(),
								]
							),
						],
					]
				),
				'footer'             => new Fieldmanager_Group(
					[
						'label'    => __( 'Footer', 'civil-first-fleet' ),
						'children' => [
							'call_to_action_button' => new Fieldmanager_Group(
								[
									'label'    => __( 'Call To Action Button', 'civil-first-fleet' ),
									'children' => \Civil_First_Fleet\Components\Call_To_Action\Button::get_fm_fields(),
								]
							),
							'copyright'             => new Fieldmanager_Group(
								[
									'label'    => __( 'Copyright', 'civil-first-fleet' ),
									'children' => [
										'copyright_text' => new Fieldmanager_TextField(
											[
												'label'       => __( 'Copyright Text', 'civil-first-fleet' ),
												'description' => __( 'The text to display after the year. Defaults to site title.', 'civil-first-fleet' ),
											]
										),
									],
								]
							),
						],
					]
				),
				'newsletter'         => new Fieldmanager_Group(
					[
						'label'    => __( 'Newsletter', 'civil-first-fleet' ),
						'children' => [
							'mailchimp_api_key'     => new Fieldmanager_TextField( __( 'MailChimp API Key', 'civil-first-fleet' ) ),
							'mailchimp_list_id'     => new Fieldmanager_TextField(
								[
									'label'       => __( 'MailChimp List ID', 'civil-first-fleet' ),
									'attributes'  => [
										'disabled' => true,
									],
									'description' => __( 'This field has been deprecated. Please add a new list below to use Mailchimp.', 'civil-first-fleet' ),
								]
							),
							'success_message'       => new Fieldmanager_TextField(
								[
									'label'         => __( 'Success Message', 'civil-first-fleet' ),
									'description'   => __( 'The message shown to the user after a successful signup.', 'civil-first-fleet' ),
									'default_value' => __( 'Thank you for subscribing!', 'civil-first-fleet' ),
								]
							),
							'mailchimp_lists'       => new Fieldmanager_Group(
								[
									'label'    => __( 'Mailchimp Lists', 'civil-first-fleet' ),
									'children' => [
										'lists' => new Fieldmanager_Group(
											[
												'label'          => __( 'New List', 'civil-first-fleet' ),
												'label_macro'    => [ '%s', 'name' ],
												'limit'          => 0,
												'collapsed'      => true,
												'add_more_label' => __( 'Add List', 'civil-first-fleet' ),
												'children'       => [
													'name' => new Fieldmanager_TextField( __( 'List Name', 'civil-first-fleet' ) ),
													'id'   => new Fieldmanager_TextField( __( 'List ID', 'civil-first-fleet' ) ),
												],
											]
										),
									],
								]
							),
							'sticky_call_to_action' => new Fieldmanager_Group(
								[
									'label'     => __( 'Sticky CTA', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => \Civil_First_Fleet\Component\call_to_action()->set_fm_fields( \Civil_First_Fleet\Component\call_to_action()->sticky_cta_fm_fields() )->get_fm_fields(),
								]
							),
						],
					]
				),
				'sponsors'           => new Fieldmanager_Group(
					[
						'label'    => __( 'Sponsors', 'civil-first-fleet' ),
						'children' => \Civil_First_Fleet\Components\Sponsor::get_submenu_fm_fields(),
					]
				),
				'component_defaults' => new Fieldmanager_Group(
					[
						'label'    => __( 'Component Defaults', 'civil-first-fleet' ),
						'children' => [
							'paywall_call_to_action'    => new Fieldmanager_Group(
								[
									'label'     => __( 'Paywall Call to Action', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => [
										'button_text' => new Fieldmanager_TextField(
											[
												'label'         => __( 'Button Text', 'civil-first-fleet' ),
												'description'   => __( 'E.g. the "Subscribe" buttons in header and footer navs', 'civil-first-fleet' ),
												'default_value' => __( 'Subscribe', 'civil-first-fleet' ),
											]
										),
									],
								]
							),
							'credibility_indicators'    => new Fieldmanager_Group(
								[
									'label'     => __( 'Credibility Indicators', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => \Civil_First_Fleet\Component\credibility_indicators()->get_fm_fields(),
								]
							),
							'newsletter_call_to_action' => new Fieldmanager_Group(
								[
									'label'     => __( 'Newsletter CTA', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => \Civil_First_Fleet\Component\call_to_action()->set_setting( 'type', 'newsletter' )->remove_fm_field( 'enable' )->remove_fm_field( 'settings' )->get_fm_fields(),
								]
							),
							'subscribe_call_to_action'  => new Fieldmanager_Group(
								[
									'label'     => __( 'Subscribe CTA', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => \Civil_First_Fleet\Component\call_to_action()->set_setting( 'type', 'subscribe' )->remove_fm_field( 'enable' )->remove_fm_field( 'settings' )->get_fm_fields(),
								]
							),
							'featured_articles'         => new Fieldmanager_Group(
								[
									'label'     => __( 'Featured Articles', 'civil-first-fleet' ),
									'collapsed' => true,
									'children'  => [
										'show_avatar' => new Fieldmanager_Checkbox( __( 'Show author avatars in featured article lists', 'civil-first-fleet' ) ),
									],
								]
							)
						],
					]
				),
				'contact'            => new Fieldmanager_Group(
					[
						'label'    => __( 'Contact Info', 'civil-first-fleet' ),
						'children' => [
							'email'  => new Fieldmanager_TextField( __( 'Email Address', 'civil-first-fleet' ) ),
							'social' => new Fieldmanager_Group(
								[
									'label'    => __( 'Social Media Links', 'civil-first-fleet' ),
									'children' => [
										'facebook'                  => new Fieldmanager_Link( __( 'Facebook URL', 'civil-first-fleet' ) ),
										'twitter'                   => new Fieldmanager_Link( __( 'Twitter URL', 'civil-first-fleet' ) ),
										'instagram'                 => new Fieldmanager_Link( __( 'Instagram URL', 'civil-first-fleet' ) ),
										'linkedin'                  => new Fieldmanager_Link( __( 'LinkedIn URL', 'civil-first-fleet' ) ),
										'show_social_in_header_nav' => new Fieldmanager_Checkbox( __( 'Show social media links in header navigation.', 'civil-first-fleet' ) ),
									],
								]
							),
						],
					]
				),
				'search'             => new Fieldmanager_Group(
					[
						'label'    => __( 'Search', 'civil-first-fleet' ),
						'children' => [
							'search_display' => new Fieldmanager_Group(
								[
									'label'    => __( 'Search Form Display', 'civil-first-fleet' ),
									'children' => [
										'show_search_in_header_nav' => new Fieldmanager_Checkbox( __( 'Show search form in header navigation.', 'civil-first-fleet' ) ),
										'search_form_style'         => new Fieldmanager_Select(
											[
												'label'   => __( 'Display style:', 'civil-first-fleet' ),
												'options' => [
													'trigger' => __( 'Toggle: Hide search form until user clicks icon to display it', 'civil-first-fleet' ),
													'inline'  => __( 'Inline: Show a search form in the header navigation', 'civil-first-fleet' ),
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
						'label'    => __( 'Article Taxonomies', 'civil-first-fleet' ),
						'children' => \Civil_First_Fleet\Component\article_taxonomies()->get_fm_fields(),
					]
				),
				'feeds'              => new Fieldmanager_Group(
					[
						'label'    => __( 'Feeds', 'civil-first-fleet' ),
						'children' => [
							'rss_feed_settings' => new Fieldmanager_Group(
								[
									'label'    => __( 'RSS Feed Settings', 'civil-first-fleet' ),
									'children' => [
										'add_featured_image_to_rss_feeds' => new Fieldmanager_Checkbox( __( 'Add featured image to post content in RSS feeds.', 'civil-first-fleet' ) ),
									],
								]
							),
						],
					]
				),
			],
		]
	);
	$fm->activate_submenu_page();
}
add_action( 'fm_submenu_newsroom-settings', 'civil_first_fleet_fm_submenu_newsroom_settings' );
if ( function_exists( 'fm_register_submenu_page' ) ) {
	fm_register_submenu_page( 'newsroom-settings', 'options-general.php', __( 'Newsroom Settings', 'civil-first-fleet' ), __( 'Newsroom Settings', 'civil-first-fleet' ), 'manage_options' );
}
/* end fm:submenu-newsroom-settings */

/* begin fm:post-post-article-settings */
/**
 * `post-post-article-settings` Fieldmanager fields.
 */
function civil_first_fleet_fm_post_post_article_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'post-post-article-settings',
			'tabbed'         => 'vertical',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'settings_group'               => new Fieldmanager_Group(
					[
						'label'          => __( 'Settings', 'civil-first-fleet' ),
						'serialize_data' => false,
						'add_to_prefix'  => false,
						'children'       => [
							'dek'                 => new Fieldmanager_TextArea(
								[
									'label'      => __( 'Deck', 'civil-first-fleet' ),
									'attributes' => [
										'style' => 'width: 100%;',
										'rows'  => '5',
									],
								]
							),
							'primary_category_id' => new Fieldmanager_Autocomplete(
								[
									'label'       => __( 'Primary Category', 'civil-first-fleet' ),
									'description' => __( 'Begin typing to select a primary category.', 'civil-first-fleet' ),
									'datasource'  => new Fieldmanager_Datasource_Term(
										[
											'taxonomy'               => 'category',
											'taxonomy_save_to_terms' => false,
											'only_save_to_taxonomy'  => false,
										]
									),
								]
							),
							'label'               => new Fieldmanager_Checkboxes(
								[
									'label'   => __( 'Enable Label', 'civil-first-fleet' ),
									'options' => \Civil_First_Fleet\Component\Content_Item()->get_label_options(),
								]
							),
						],
					]
				),
				'featured_media'               => new Fieldmanager_Group(
					[
						'label'          => __( 'Featured Media', 'civil-first-fleet' ),
						'serialize_data' => false,
						'add_to_prefix'  => false,
						'children'       => [
							'disable_featured_image'        => new Fieldmanager_Checkbox(
								[
									'label'       => __( 'Hide image on article header', 'civil-first-fleet' ),
									'description' => __( 'This will still display as the thumbnail on archives.', 'civil-first-fleet' ),
								]
							),
							'featured_video_url'            => new Fieldmanager_Link( __( 'Video URL for the featured homepage slot and article header.', 'civil-first-fleet' ) ),
							'featured_image_custom_caption' => new Fieldmanager_TextArea(
								[
									'label'       => __( 'Enter a custom caption for the featured image (optional):', 'civil-first-fleet' ),
									'description' => __( 'This will display instead of the caption saved in the Media Library.', 'civil-first-fleet' ),
								]
							),
						],
					]
				),
				'credibility_indicators_group' => new Fieldmanager_Group(
					[
						'label'          => __( 'Credibility Indicators', 'civil-first-fleet' ),
						'serialize_data' => false,
						'add_to_prefix'  => false,
						'children'       => [
							'credibility_indicators' => new Fieldmanager_Group(
								[
									'children' => \Civil_First_Fleet\Component\credibility_indicators()->article_fields(),
								]
							),
						],
					]
				),
				'call_to_action_group'         => new Fieldmanager_Group(
					[
						'label'          => __( 'Call to Action', 'civil-first-fleet' ),
						'serialize_data' => false,
						'add_to_prefix'  => false,
						'children'       => [
							'call_to_action' => new Fieldmanager_Group(
								[
									'children' => \Civil_First_Fleet\Component\call_to_action()->get_fm_fields(),
								]
							),
						],
					]
				),
				'secondary_bylines_group'      => new Fieldmanager_Group(
					[
						'label'          => __( 'Secondary Bylines', 'civil-first-fleet' ),
						'serialize_data' => false,
						'add_to_prefix'  => false,
						'children'       => [
							'secondary_bylines' => new Fieldmanager_Group(
								[
									'limit'          => 0,
									'add_more_label' => __( 'Add Byline', 'civil-first-fleet' ),
									'label'          => __( 'New Byline', 'civil-first-fleet' ),
									'label_macro'    => [ 'Byline: %s', 'type' ],
									'minimum_count'  => 0,
									'extra_elements' => 0,
									'collapsed'      => true,
									'sortable'       => true,
									'children'       => [
										'role'        => new Fieldmanager_TextField(
											[
												'label'       => __( 'Role', 'civil-first-fleet' ),
												'description' => __( 'e.g., "Edited by", "Fact-checked by"', 'civil-first-fleet' ),
											]
										),
										'id'          => new Fieldmanager_Autocomplete(
											[
												'label'       => __( 'Name', 'civil-first-fleet' ),
												'description' => __( 'Begin typing to select a user.', 'civil-first-fleet' ),
												'datasource'  => new Fieldmanager_Datasource_Post(
													[
														'query_args' => [
															'post_type' => [ 'guest-author' ],
														],
													]
												),
												'display_if'  => [
													'src'   => 'name_toggle',
													'value' => false,
												],
											]
										),
										'custom_name' => new Fieldmanager_TextField(
											[
												'label'       => __( 'Name', 'civil-first-fleet' ),
												'description' => __( 'Enter a custom name.', 'civil-first-fleet' ),
												'display_if'  => [
													'src'   => 'name_toggle',
													'value' => true,
												],
											]
										),
										'name_toggle' => new Fieldmanager_Checkbox( __( 'Manually enter name.', 'civil-first-fleet' ) ),
									],
								]
							),
						],
					]
				),
				'sponsorship'                  => new Fieldmanager_Group(
					[
						'label'    => __( 'Sponsorship Schedule', 'civil-first-fleet' ),
						'children' => \Civil_First_Fleet\Components\Sponsor::get_schedule_fm_fields(),
					]
				),
				'canonical_url'                => new Fieldmanager_Link(
					[
						'label'       => __( 'Canonical URL', 'civil-first-fleet' ),
						'description' => __( 'Use this field to override the canonical URL. You should only set this in cases where an article is syndicated from another source.', 'civil-first-fleet' ),
					]
				),
			],
		]
	);
	$fm->add_meta_box( __( 'Article Settings', 'civil-first-fleet' ), [ 'post' ] );
}
add_action( 'fm_post_post', 'civil_first_fleet_fm_post_post_article_settings' );
/* end fm:post-post-article-settings */

/* begin fm:post-sponsor-settings */
/**
 * `post-sponsor-settings` Fieldmanager fields.
 */
function civil_first_fleet_fm_post_sponsor_settings() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'post-sponsor-settings',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => \Civil_First_Fleet\Components\Sponsor::get_fm_fields(),
		]
	);
	$fm->add_meta_box( __( 'Settings', 'civil-first-fleet' ), [ 'sponsor' ], 'normal', 'high' );
}
add_action( 'fm_post_sponsor', 'civil_first_fleet_fm_post_sponsor_settings' );
/* end fm:post-sponsor-settings */

/* begin fm:term-mixed-sponsorship */
/**
 * `term-mixed-sponsorship` Fieldmanager fields.
 */
function civil_first_fleet_fm_term_mixed_sponsorship() {
	$fm = new Fieldmanager_Group(
		[
			'name'           => 'term-mixed-sponsorship',
			'serialize_data' => false,
			'add_to_prefix'  => false,
			'children'       => [
				'sponsorship' => new Fieldmanager_Group(
					[
						'children' => \Civil_First_Fleet\Components\Sponsor::get_schedule_fm_fields(),
					]
				),
			],
		]
	);
	$fm->add_term_meta_box( __( 'Sponsored Content', 'civil-first-fleet' ), [ 'category', 'post_tag' ] );
}
add_action( 'fm_term_category', 'civil_first_fleet_fm_term_mixed_sponsorship' );
add_action( 'fm_term_post_tag', 'civil_first_fleet_fm_term_mixed_sponsorship' );
/* end fm:term-mixed-sponsorship */
