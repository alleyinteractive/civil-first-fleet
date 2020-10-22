<?php
/**
 * Tmeplate part for displaying bylines w/ bios on single posts
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$ai_component = ai_get_var( 'component' );
$post_id      = $ai_component->data( 'post_id' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$ai_coauthors = get_coauthors( $post_id );
?>

<!-- avatars, bylines, and bios -->
<div data-component="article-bylines" class="<?php ai_the_classnames( [ 'wrapper', 'expandable' ] ); ?>">

	<?php foreach ( $ai_coauthors as $coauthor ) : ?>

		<section class="<?php ai_the_classnames( [ 'bio' ] ); ?>">

			<header class="<?php ai_the_classnames( [ 'bio-header' ] ); ?>">

				<a
					href="
					<?php
						/**
						 * Allow clients to link directly to coauthor if needed.
						 *
						 * @param string $coauthor_link Coauthor bio fragment by default.
						 * @param object $coauthor Coauthor object.
						 */
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'civil_first_fleet_get_expandable_coauthor_link',
							esc_attr( '#' . $ai_component->get_bio_frag_id( $coauthor->ID ) ),
							$coauthor
						);
					?>
					"
					class="<?php ai_the_classnames( [ 'byline-expand' ] ); ?>"
				>
					<span class="<?php ai_the_classnames( [ 'avatar' ] ); ?>">
						<?php $ai_component->author_avatar( $coauthor->ID ); ?>
					</span>

					<span class="<?php ai_the_classnames( [ 'bio-name' ] ); ?>">
						<?php echo esc_html( $coauthor->display_name ); ?>
					</span>
				</a>

				<?php if ( ! empty( $ai_component->get_author_twitter_handle( $coauthor->ID ) ) ) : ?>
					<?php $ai_component->author_twitter_handle( $coauthor->ID ); ?>
				<?php endif; ?>

			</header>

			<div class="<?php ai_the_classnames( [ 'bio-content-wrapper' ] ); ?>" id="<?php echo esc_attr( $ai_component->get_bio_frag_id( $coauthor->ID ) ); ?>">
				<span class="<?php ai_the_classnames( [ 'bio-content-inner' ] ); ?>">
					<p class="<?php ai_the_classnames( [ 'bio-content' ] ); ?>">
						<?php
						echo wp_kses(
							get_post_meta( $coauthor->ID, 'biography', true ),
							[
								'a'      => [ 'href' => [] ],
								'em'     => [],
								'strong' => [],
							]
						);
						?>
					</p>

					<a class="<?php ai_the_classnames( [ 'bio-more' ] ); ?>" href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ); ?>">
						<?php esc_html_e( 'See more', 'civil-first-fleet' ); ?>
					</a>
				</span>
			</div>

		</section>

	<?php endforeach; ?>

</div>
