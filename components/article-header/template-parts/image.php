<?php
/**
 * Template part for displaying an image in the article header.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Ensure we have a thumbnail.
if ( ! has_post_thumbnail( $component->data( 'post_id' ) ) ) {
	return;
}
?>

<div class="<?php ai_the_classnames( [ 'image' ] ); ?>">
	<?php
	// Output featured image.
	$component->featured_image()
		->set_setting( 'is_featured', true )
		->size( 'article-header' )
		->render();

	// Check if credit or caption exist.
	$image_credit  = $component->get_featured_image_credit();
	$image_caption = $component->get_featured_image_caption();
	if ( ! empty( $image_credit ) || ! empty( $image_caption ) ) :
		?>
		<figcaption class="<?php ai_the_classnames( [ 'image-meta' ] ); ?>">
			<?php
			if ( ! empty( $image_caption ) ) {
				echo wp_kses_post( $image_caption );
			}
			if ( ! empty( $image_credit ) ) {
				echo wp_kses_post( $image_credit );
			}
			?>
		</figcaption>
	<?php endif; ?>
</div>
