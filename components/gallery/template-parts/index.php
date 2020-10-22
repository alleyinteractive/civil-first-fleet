<?php
/**
 * Template part for displaying the Gallery component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component     = ai_get_var( 'component' );
$attributes    = $component->get_data( 'attributes' );
$columns_class = 'columns-' . ( $attributes['columns'] ?? 3 );
if ( empty( $attributes['images'] ) ) {
	return;
}
?>
<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" data-component="gallery">
	<ul class="
		<?php
		ai_the_classnames(
			[
				$columns_class,
				'wp-block-civil-lightbox-gallery',
			],
			[
				'is-cropped' => $attributes['imageCrop'] ?? false,
			]
		);
		?>
	">
		<?php foreach ( $attributes['images'] as $idx => $image ) : ?>
			<li class="lightbox-gallery__item" data-index=<?php echo esc_attr( $idx ); ?>>
				<figure>
					<img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
				</figure>
			</li>
		<?php endforeach; ?>
	</ul>

	<div class="<?php ai_the_classnames( [ 'lightbox-wrapper' ] ); ?>">
		<button class="<?php ai_the_classnames( [ 'close' ] ); ?>">
			<span class="screen-reader-text">Close</span>
			<?php ai_get_template_part( $component->get_component_path( 'svg/close.svg' ) ); ?>
		</button>
		<div class="<?php ai_the_classnames( [ 'direction-controls' ] ); ?>">
			<button class="<?php ai_the_classnames( [ 'previous' ] ); ?>">
				<span class="screen-reader-text">Previous Slide</span>
				<?php ai_get_template_part( $component->get_component_path( 'svg/chevron-down.svg' ) ); ?>
			</button>
			<button class="<?php ai_the_classnames( [ 'next' ] ); ?>">
				<span class="screen-reader-text">Next Slide</span>
				<?php ai_get_template_part( $component->get_component_path( 'svg/chevron-down.svg' ) ); ?>
			</button>
		</div>
		<ul class="<?php ai_the_classnames( [ 'lightbox-gallery' ] ); ?>">
			<?php foreach ( $attributes['images'] as $idx => $image ) : ?>
				<li class="<?php ai_the_classnames( [ 'slide' ] ); ?>" data-id="<?php echo esc_attr( $image['id'] ); ?>" data-index=<?php echo esc_attr( $idx ); ?>>
					<figure class="<?php ai_the_classnames( [ 'figure' ] ); ?>">
						<?php
						$image_url     = wp_get_attachment_url( $image['id'] );
						$image_caption = get_post( $image['id'] )->post_excerpt;
						$image_credit  = get_image_credit( $image['id'] );
						( new Component\image() )
							->set_url( $image_url )
							->size( 'gallery-fullscreen' )
							->aspect_ratio( false )
							->render();
						?>

						<?php if ( ! empty( $image_credit ) || ! empty( $image_caption ) ) : ?>
							<figcaption class="<?php ai_the_classnames( [ 'image-meta' ] ); ?>">
								<?php if ( ! empty( $image_credit ) ) : ?>
									<span class="<?php ai_the_classnames( [ 'credit' ] ); ?>">
										<?php echo wp_kses_post( $image_credit ); ?>
									</span>
								<?php endif; ?>
								<?php if ( ! empty( $image_caption ) ) : ?>
									<span class="<?php ai_the_classnames( [ 'caption' ] ); ?>">
										<?php echo wp_kses_post( $image_caption ); ?>
									</span>
								<?php endif; ?>
							</figcaption>
						<?php endif; ?>
					</figure>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
