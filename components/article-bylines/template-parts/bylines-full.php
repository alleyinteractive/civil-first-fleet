<?php
/**
 * Tmeplate part for displaying bylines w/ bios on single posts
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$ai_component = ai_get_var( 'component' );
$author_id = get_the_author_meta( 'ID' );
$coauthor_meta = get_the_coauthor_meta( 'ID', $author_id );
$coauthor_id = array_pop( $coauthor_meta );
?>

<!-- avatars, bylines, and bios -->
<div class="<?php ai_the_classnames( [ 'wrapper', 'full' ] ); ?>">

	<span class="<?php ai_the_classnames( [ 'avatar' ] ); ?>">
		<?php $ai_component->author_avatar( $coauthor_id, 'avatar-large' ); ?>
	</span>

	<div class="<?php ai_the_classnames( [ 'bio-content-wrapper' ] ); ?>" id="<?php echo esc_attr( $ai_component->get_bio_frag_id( $coauthor_id ) ); ?>">
		<span class="<?php ai_the_classnames( [ 'bio-name' ] ); ?>">
			<?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
		</span>

		<?php if ( ! empty( $ai_component->get_author_twitter_handle( $coauthor_id ) ) ) : ?>
			<?php $ai_component->author_twitter_handle( $coauthor_id ); ?>
		<?php endif; ?>

		<div class="<?php ai_the_classnames( [ 'bio-content-inner' ] ); ?>">
			<div class="<?php ai_the_classnames( [ 'bio-content' ] ); ?>">
				<?php
				echo wp_kses(
					get_post_meta( $coauthor_id, 'biography', true ),
					[
						'a' => [ 'href' => [] ],
						'em' => [],
						'strong' => [],
					]
				);
				?>
			</div>
		</div>
	</div>
</div>
