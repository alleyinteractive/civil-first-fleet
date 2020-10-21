<?php
/**
 * Post featured image template part.
 *
 * @package Civil_First_Fleet
 */

$featured_image = $this->get( 'featured_image' );

if ( empty( $featured_image ) ) {
	return;
}

$amp_html       = $featured_image['amp_html'];
$custom_caption = get_post_meta( get_the_ID(), 'featured_image_custom_caption', true );
$caption        = ! empty( $custom_caption ) ? $custom_caption : $featured_image['caption'];
?>
<figure class="amp-wp-article-featured-image wp-caption">
	<?php echo $amp_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php if ( $caption ) : ?>
		<figcaption class="wp-caption-text">
			<?php echo wp_kses_data( $caption ); ?>
		</figcaption>
	<?php endif; ?>
</figure>
