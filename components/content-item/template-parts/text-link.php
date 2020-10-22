<?php
/**
 * Template part for displaying a Content Item component as just a text link.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component    = ai_get_var( 'component' );
$post_id      = $component->get_data( 'post_id' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$layout       = $component->get_setting( 'layout' );
$ai_coauthors = get_coauthors( $post_id );
?>

<div class="<?php ai_the_classnames( [ 'content-item' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'content' ] ); ?>">
		<h3 class="<?php ai_the_classnames( [ 'title' ] ); ?>">
			<?php
			$component->open_permalink();
			echo esc_html( get_the_title( $post_id ) );
			$component->close_permalink();
			?>
		</h3>
		<ul class="<?php ai_the_classnames( [ 'authors' ] ); ?>" data-tablist>
			<?php foreach ( $ai_coauthors as $coauthor ) : ?>
				<li>
					<a href="<?php echo esc_url( get_author_posts_url( $coauthor->ID, $coauthor->user_nicename ) ); ?>">
						<span class="<?php ai_the_classnames( [ 'byline' ] ); ?>"><?php echo esc_html( $coauthor->display_name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<span class="<?php ai_the_classnames( [ 'date' ] ); ?>">
			<?php $component->published_date(); ?>
		</span>
	</div>
</div>
