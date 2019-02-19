<?php
/**
 * Template part for displaying the Article Footer component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component              = ai_get_var( 'component' );
$post_id                = $component->data( 'post_id' );
$ai_coauthors           = get_coauthors( $post_id );
$credibility_indicators = get_post_meta( $post_id, 'credibility_indicators', true );
$call_to_action         = get_post_meta( $post_id, 'call_to_action', true );
$taxonomies             = $component->get_option( 'newsroom-settings', 'article_taxonomies' );
?>

<footer class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">

	<!-- shares: no_mobile -->
	<div class="<?php ai_the_classnames( [ 'social-shares' ] ); ?>">
		<?php
		if ( function_exists( 'sharing_display' ) ) {
			sharing_display( '', true );
		}
		?>
	</div>

	<?php
	if ( ! empty( $call_to_action['enable'] ) ) {
		\Civil_First_Fleet\Component\call_to_action()
			->set_setting( $call_to_action['settings'] )
			->set_setting( 'layout', 'inline' )
			->set_data( $call_to_action['data'] )
			->set_data( 'context', 'sidebar' )
			->render();
	}
	?>

	<div class="<?php ai_the_classnames( [ 'bylines' ] ); ?>">
		<?php
		\Civil_First_Fleet\Component\article_bylines()
			->set_setting( 'layout', 'static' )
			->render();
		?>
	</div>

	<div class="<?php ai_the_classnames( [ 'indicators' ] ); ?>">
		<?php
		\Civil_First_Fleet\Component\credibility_indicators()
			->set_data( $credibility_indicators ?? [] )
			->render();
		?>
	</div>

	<div class="<?php ai_the_classnames( [ 'article-taxonomies' ] ); ?>">
		<?php
		// Get tags, if enabled.
		if ( ! empty( $taxonomies['tags']['enable'] ?? '' ) ) {
			\Civil_First_Fleet\Component\article_taxonomies()
				->set_setting( $taxonomies['tags'] )
				->set_data( 'taxonomy', 'post_tag' )
				->set_data( 'post_id', get_the_ID() )
				->render();
		}

		// Get categories, if enabled.
		if ( ! empty( $taxonomies['categories']['enable'] ?? '' ) ) {
			\Civil_First_Fleet\Component\article_taxonomies()
				->set_setting( $taxonomies['categories'] )
				->set_data( 'post_id', get_the_ID() )
				->set_data( 'taxonomy', 'category' )
				->render();
		}
		?>
	</div>

</footer>
