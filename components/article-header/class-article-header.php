<?php
/**
 * Article Header component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Article Header component class.
 */
class Article_Header extends \Civil_First_Fleet\Component\Content_Item {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-header';

	/**
	 * Render this component.
	 */
	public function render() {
		\ai_get_template_part(
			$this->get_component_path(),
			[
				'component'  => $this,
				'stylesheet' => $this->slug,
			]
		);
	}

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'stylesheet' => $this->slug,
		];
	}

	/**
	 * Display Jetpack share links.
	 */
	public function jetpack_sharing_display() {
		if ( function_exists( 'sharing_display' ) ) {
			sharing_display( '', true );
		}
	}

	/**
	 * Secondary byline helper.
	 */
	public function secondary_bylines() {
		// Loop through bylines.
		foreach ( $this->get_data( 'secondary_bylines' ) as $byline ) {

			// Validate that something has been set.
			if ( empty( $byline['custom_name'] ) && empty( $byline['id'] ) ) {
				return null;
			}

			$format = '<span class="%1$s">%2$s %3$s</span>';
			$role   = $byline['role'] ?? '';

			// Is custom entry enabled?
			if ( ! empty( $byline['name_toggle'] ) ) {

				// Output custom entry byline.
				echo wp_kses_post(
					sprintf(
						$format,
						ai_get_classnames( [ 'byline' ] ),
						esc_html( $role ),
						esc_html( $byline['custom_name'] )
					)
				);
			} else {

				// Get CAP/user data.
				$display_name = (string) get_post_meta( $byline['id'], 'cap-display_name', true );
				$user_login   = (string) get_post_meta( $byline['id'], 'cap-user_login', true );

				// Default author_markup is just the name.
				$author_markup = $display_name;

				// Query for any posts.
				$author_query = new \WP_Query(
					[
						'author_name'    => $user_login,
						'post_status'    => 'publish',
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'fields'         => 'ids',
						'no_found_rows'  => true,
					]
				);

				// Modify to an anchor to the user's posts.
				if ( $author_query->have_posts() ) {
					$author_markup = sprintf(
						'<a href="%2$s">%1$s</a>',
						$display_name,
						esc_url( get_author_posts_url( $byline['id'], $user_login ) )
					);
				}

				// Output entire byline.
				echo wp_kses_post(
					sprintf(
						$format,
						ai_get_classnames( [ 'byline' ] ),
						esc_html( $role ),
						$author_markup
					)
				);
			}
		}
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Article_Header  An instance of this component.
 */
function article_header( array $settings = [], array $data = [], array $fm_fields = [] ) : Article_Header {
	return new Article_Header( $settings, $data );
}
