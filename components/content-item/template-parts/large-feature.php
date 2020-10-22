<?php
/**
 * Template part for displaying a large feature Content Item component layout.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component          = ai_get_var( 'component' );
$post_id            = $component->get_data( 'post_id' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$layout             = $component->get_setting( 'layout' );
$ai_coauthors       = get_coauthors( $post_id );
$is_opinion         = ! empty( $component->get_label( $post_id ) );
$featured_video_url = (string) get_post_meta( $component->data( 'post_id' ), 'featured_video_url', true );
?>

<div class="<?php ai_the_classnames( [ 'content-item', 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'content' ], [ 'has-video' => $featured_video_url ] ); ?>">
		<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">
			<?php if ( $is_opinion ) : ?>
				<span class="<?php ai_the_classnames( [ 'label' ] ); ?>">
					<?php $component->label( $post_id ); ?>
				</span>
			<?php else : ?>
				<span class="<?php ai_the_classnames( [ 'eyebrow' ] ); ?>">
					<?php $component->eyebrow(); ?>
				</span>
			<?php endif; ?>
			<h2 class="<?php ai_the_classnames( [ 'title' ] ); ?>">
				<?php
				$component->open_permalink();
				echo esc_html( get_the_title( $post_id ) );
				$component->close_permalink();
				?>
			</h2>
			<ul class="<?php ai_the_classnames( [ 'authors' ] ); ?>" data-tablist>
			<?php foreach ( $ai_coauthors as $coauthor ) : ?>
				<li>
					<a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ); ?>" class="<?php ai_the_classnames( [ 'avatar' ] ); ?>">
						<?php $component->author_avatar( $coauthor->ID ); ?>
						<span class="<?php ai_the_classnames( [ 'byline' ] ); ?>"><?php echo esc_html( $coauthor->display_name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
			<?php if ( ! empty( $component->get_dek() ) ) : ?>
				<p class="<?php ai_the_classnames( [ 'dek' ] ); ?>"><?php $component->dek(); ?></p>
			<?php endif; ?>
			<span class="<?php ai_the_classnames( [ 'date' ] ); ?>">
				<?php $component->published_date(); ?>
			</span>
		</div>
	</div>
	<?php if ( empty( $featured_video_url ) ) : ?>
		<div class="<?php ai_the_classnames( [ 'image' ] ); ?>">
			<?php
			$component->open_permalink();
			$component->featured_image()
				->size( 'large-feature' )
				->aspect_ratio( 2 / 3 )
				->render();
			$component->close_permalink();
			?>
		</div>
	<?php else : ?>
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
	<?php endif; ?>

</div>
