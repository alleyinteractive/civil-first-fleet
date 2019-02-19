<?php
/**
 * Template part for displaying the Article Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component                = ai_get_var( 'component' );
$credibility_indicators   = (array) get_post_meta( $component->data( 'post_id' ), 'credibility_indicators', true );
$call_to_action           = get_post_meta( $component->data( 'post_id' ), 'call_to_action', true );
$featured_articles_widget = $component->get_option( 'featured-articles-widget-settings', 'featured_articles_widget' );

// Get indicators for this post (keys only).
$post_indicators = array_filter( $credibility_indicators );
?>
<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<aside class="<?php ai_the_classnames( [ 'sidebar-left' ] ); ?>">
		<?php
		\Civil_First_Fleet\Component\credibility_indicators()
			->set_data( $credibility_indicators ?? [] )
			->render();
		?>
	</aside>

	<?php
	\Civil_First_Fleet\Component\body_content()->render();
	?>

	<aside class="<?php ai_the_classnames( [ 'sidebar-right' ] ); ?>">
		<?php
		if ( ! empty( $call_to_action['enable'] ) ) {
			// Always use the inline theme for the sidebar.
			\Civil_First_Fleet\Component\call_to_action()
				->set_setting( $call_to_action['settings'] )
				->set_setting( 'layout', 'inline' )
				->set_data( $call_to_action['data'] )
				->set_data( 'context', 'sidebar' )
				->render();
		}

		// Output featured articles widget if turned on.
		if ( (bool) $featured_articles_widget['enable'] ?? false ) :
			\Civil_First_Fleet\Component\featured_articles_widget()
				->data( $featured_articles_widget ?? [] )
				->render();
		endif;
		?>
	</aside>

	<?php
	// Output Article Footer.
	\Civil_First_Fleet\Component\article_footer()
		->set_post_id( get_the_ID() )
		->render();
	?>

</div>
