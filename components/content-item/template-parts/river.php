<?php
/**
 * Template part for displaying a river Content Item component layout.
 *
 * @package Civil_First_Fleet
 */

// @TODO: this markup is almost identical to large-feature.php. This works fine for now, but we might consider consolidating them somehow in the future.
namespace Civil_First_Fleet;

// Get this instance.
$component   = ai_get_var( 'component' );
$post_id     = $component->get_data( 'post_id' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$layout      = $component->get_setting( 'layout' );
$show_avatar = $component->get_setting( 'show_avatar' );
$is_opinion  = ! empty( $component->get_label( $post_id ) );
$is_video    = ! empty( $component->get_image_label( $post_id ) );
$component->set_data( 'coauthors', get_coauthors( $post_id ) );
?>

<div class="
	<?php
	ai_the_classnames(
		[
			'content-item',
			'wrapper',
		],
		[
			'no-image' => ! has_post_thumbnail( $post_id ),
			'video'    => $is_video,
		]
	);
	?>
	">
	<div class="<?php ai_the_classnames( [ 'content' ] ); ?>">
		<h2 class="<?php ai_the_classnames( [ 'title' ] ); ?>">
			<?php
			$component->open_permalink();
			echo esc_html( get_the_title( $post_id ) );
			$component->close_permalink();
			?>
		</h2>

		<?php
		if ( ! empty( $component->get_byline() ) ) {
			$component->byline( $show_avatar );
		}
		?>

		<?php if ( $is_opinion ) : ?>
			<span class="<?php ai_the_classnames( [ 'label' ] ); ?>">
				<?php $component->label( $post_id ); ?>
			</span>
		<?php else : ?>
			<span class="<?php ai_the_classnames( [ 'eyebrow' ] ); ?>">
				<?php $component->eyebrow(); ?>
			</span>
		<?php endif; ?>

		<span class="<?php ai_the_classnames( [ 'date' ] ); ?>">
			<?php $component->published_date(); ?>
		</span>
	</div>

	<?php if ( has_post_thumbnail( $post_id ) ) : ?>
		<div class="<?php ai_the_classnames( [ 'image' ] ); ?>">
			<?php
			$component->open_permalink();
			$component->featured_image()
				->size( 'river' )
				->aspect_ratio( 1 / 1 )
				->render();
			$component->close_permalink();
			?>
			<?php if ( $is_video ) : ?>
				<span class="<?php ai_the_classnames( [ 'image-label' ] ); ?>">
					<?php $component->image_label( $post_id ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
