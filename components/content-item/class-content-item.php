<?php
/**
 * Content Item component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet\Component;

/**
 * Content Item component class.
 */
class Content_Item extends \Civil_First_Fleet\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'content-item';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return [
			'layout'      => 'single',
			'show_avatar' => true,
		];
	}

	/**
	 * Default component data.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [
			'post_id' => 0,
		];
	}

	/**
	 * Validate post before updating the data.
	 *
	 * @param int $post_id Post ID.
	 */
	public function set_post_id( $post_id = null ) {
		$post_id = $post_id ?? get_the_ID();
		$post    = get_post( $post_id );

		// Only update if a valid post_Id.
		if ( $post instanceof \WP_Post ) {
			if ( 'trash' === $post->post_status ) {
				return null;
			}

			$this->set_data( 'post_id', $post_id );
		}

		return $this;
	}

	/**
	 * Render this component using the correct layout option.
	 */
	public function render() {
		\ai_get_template_part(
			$this->get_component_path( $this->setting( 'layout' ) ),
			[
				'component'  => $this,
				'stylesheet' => $this->setting( 'layout' ),
			]
		);
	}

	/**
	 * Outputs open tag for the permalink.
	 */
	public function open_permalink() {
		printf(
			'<a href="%1$s" title="%2$s">',
			esc_url( get_permalink( $this->get_data( 'post_id' ) ) ),
			esc_attr( get_the_title( $this->get_data( 'post_id' ) ) )
		);
	}

	/**
	 * Outputs close tag for the permalink.
	 */
	public function close_permalink() {
		echo '</a>';
	}

	/**
	 * Get byline.
	 *
	 * @param bool $show_avatar Show avatar.
	 * @return string The byline.
	 */
	public function get_byline( $show_avatar = false ) {
		$coauthors = $this->get_data( 'coauthors' );
		if ( empty( $coauthors ) ) {
			return '';
		}

		$coauthor = array_shift( $coauthors );

		return sprintf(
			'<a href="%1$s" class="%2$s">%3$s%4$s</a>',
			esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ),
			ai_get_classnames( [ 'byline', 'avatar' ] ),
			$show_avatar ? $this->get_author_avatar( $coauthor->ID ) : '',
			esc_html( $coauthor->display_name )
		);
	}

	/**
	 * Display byline.
	 *
	 * @param bool $show_avatar Show avatar.
	 */
	public function byline( $show_avatar = false ) {
		echo wp_kses_post( $this->get_byline( $show_avatar ) );
	}

	/**
	 * Published date helper.
	 *
	 * @return string Published date.
	 */
	public function get_published_date() {
		return sprintf(
			'<time datetime="%1$s" class="%4$s"><span class="screen-reader-text">%3$s </span>%2$s</span></time>',
			get_the_date( 'Y-m-d H:i:s\Z', $this->data( 'post_id' ) ),
			get_the_date( 'M j, Y g:iA T', $this->data( 'post_id' ) ),
			esc_html__( 'Published on', 'civil-first-fleet' ),
			ai_get_classnames( [ 'date' ] )
		);
	}

	/**
	 * Published date helper.
	 */
	public function published_date() {
		echo wp_kses(
			$this->get_published_date(),
			[
				'time' => [
					'datetime' => [],
					'class'    => [],
				],
				'span' => [
					'class' => [],
				],
			]
		);
	}

	/**
	 * Get eyebrow markup.
	 */
	public function get_eyebrow() {

		// Get and validate primary category.
		$category_id = absint( get_post_meta( $this->data( 'post_id' ), 'primary_category_id', true ) );
		$category    = get_term_by( 'id', $category_id, 'category' );

		if ( ! $category instanceof \WP_Term ) {
			return;
		}

		$link = get_term_link( $category, 'category' );

		// Output.
		return sprintf(
			'<a href="%2$s" class="%4$s">%1$s <span class="screen-reader-text">%3$s</span></a>',
			esc_html( $category->name ),
			esc_url( is_string( $link ) ? $link : '' ),
			esc_html__( 'Primary category in which blog post is published', 'civil-first-fleet' ),
			ai_get_classnames( [ 'eyebrow' ] )
		);
	}

	/**
	 * Output eyebrow markup.
	 */
	public function eyebrow() {
		echo wp_kses_post( $this->get_eyebrow() );
	}

	/**
	 * Get dek.
	 *
	 * @return string Dek.
	 */
	public function get_dek() {
		return (string) get_post_meta( $this->data( 'post_id' ), 'dek', true );
	}

	/**
	 * Output dek.
	 */
	public function dek() {
		echo wp_kses_post( $this->get_dek() );
	}

	/**
	 * Return a list of available post labels.
	 *
	 * @return array List of post label options.
	 */
	public function get_label_options() {
		return [
			'opinion' => __( 'Is Opinion', 'civil-first-fleet' ),
		];
	}

	/**
	 * Get label.
	 *
	 * @param int $post_id ID of post to get label for.
	 * @return string The post's label or empty string.
	 */
	public function get_label( $post_id = null ) {
		$post_id = $post_id ?? get_the_ID();
		$labels  = get_post_meta( $post_id, 'label', true );
		if ( is_array( $labels ) && in_array( 'opinion', $labels, true ) ) {
			return sprintf(
				/* translators: 1: Label to identify opinion pieces. */
				'<span>%1$s</span>',
				esc_html__( 'Opinion', 'civil-first-fleet' )
			);
		}
		return '';
	}

	/**
	 * Display label.
	 *
	 * @param int $post_id ID of post to print label for.
	 * @return void
	 */
	public function label( $post_id = null ) {
		$post_id = $post_id ?? get_the_ID();
		echo wp_kses_post( $this->get_label( $post_id ) );
	}

	/**
	 * Get the author avatar.
	 *
	 * @param object $coauthor_id The coauthor ID.
	 * @param string $size Image size to use for avatar image.
	 */
	public function get_author_avatar( $coauthor_id, $size = 'avatar-small' ) {
		$avatar_id = get_post_meta( $coauthor_id, '_thumbnail_id', true );

		if ( ! empty( $avatar_id ) ) {
			ob_start();
			\Civil_First_Fleet\Component\image()
				->set_post_id( $avatar_id )
				->size( $size )
				->aspect_ratio( false )
				->render();
			return ob_get_clean();
		} else {
			return sprintf(
				'<img src="%1$s">',
				esc_url( get_avatar_url( $coauthor_id, 75 ) )
			);
		}
	}

	/**
	 * Display the author avatar.
	 *
	 * @param object $coauthor_id The coauthor ID.
	 * @param string $size Image size to use for avatar image.
	 */
	public function author_avatar( $coauthor_id, $size = 'avatar-small' ) {
		echo wp_kses_post( $this->get_author_avatar( $coauthor_id, $size ) );
	}

	/**
	 * Get the post's featured image caption from custom field.
	 * Fallback to default thumbnail caption.
	 *
	 * @return string|void Caption text, if image and caption exist.
	 */
	public function get_featured_image_caption() {

		// Check for featured image.
		$featured_image_id = absint( get_post_meta( $this->data( 'post_id' ), '_thumbnail_id', true ) );

		// No image found.
		if ( empty( $featured_image_id ) ) {
			return;
		}

		// Check for custom caption.
		$image_caption = get_post_meta( $this->data( 'post_id' ), 'featured_image_custom_caption', true );

		if ( empty( $image_caption ) ) {

			// Get the default caption.
			$image_caption = get_post( $featured_image_id )->post_excerpt;

			// No caption found.
			if ( empty( $image_caption ) ) {
				return;
			}
		}

		return sprintf(
			'<span class="%1$s wp-caption-%2$s">%3$s</span>',
			ai_get_classnames( [ 'caption' ] ),
			esc_attr( $featured_image_id ),
			esc_html( $image_caption )
		);
	}

	/**
	 * Return an image credit for the post's featured image.
	 */
	public function get_featured_image_credit() {
		$featured_image_id = absint( get_post_meta( $this->data( 'post_id' ), '_thumbnail_id', true ) );

		// No image found.
		if ( empty( $featured_image_id ) ) {
			return;
		}

		// Get the image credit.
		$image_credit = \Civil_First_Fleet\get_image_credit( $featured_image_id );

		// No credit found.
		if ( empty( $image_credit ) ) {
			return;
		}

		return sprintf(
			'<span class="%1$s wp-credit-%2$s">%3$s</span>',
			ai_get_classnames( [ 'credit' ] ),
			esc_attr( $featured_image_id ),
			esc_html( make_clickable( $image_credit ) )
		);
	}

	/**
	 * Return an image Component for the post's featured image.
	 */
	public function featured_image() {
		$featured_image_id = absint( get_post_meta( $this->data( 'post_id' ), '_thumbnail_id', true ) );
		return \Civil_First_Fleet\Component\image()
			->set_post_id( $featured_image_id )
			->set_data( 'alt', get_post_meta( $featured_image_id, '_wp_attachment_image_alt', true ) );
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings  Instance settings.
 * @param  array $data      Instance data.
 * @param  array $fm_fields Instance FM fields.
 * @return Content_Item  An instance of this component.
 */
function content_item( array $settings = [], array $data = [], array $fm_fields = [] ) : Content_Item {
	return new Content_Item( $settings, $data );
}
