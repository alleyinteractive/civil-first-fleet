<?php
/**
 * Template part for displaying a video in the article header.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get featured video url.
$featured_video_url = (string) get_post_meta( $component->data( 'post_id' ), 'featured_video_url', true );
if ( empty( $featured_video_url ) ) {
	return;
}
?>

<div class="<?php ai_the_classnames( [ 'video' ] ); ?>">
	<?php
	echo do_shortcode(
		wp_kses(
			wp_oembed_get( $featured_video_url ),
			[
				'iframe' => [
					'src'             => [],
					'width'           => [],
					'height'          => [],
					'frameborder'     => [],
					'gesture'         => [],
					'allow'           => [],
					'allowfullscreen' => [],
				],
			]
		)
	);
	?>
</div>
