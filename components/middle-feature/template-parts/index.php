<?php
/**
 * Template part for displaying the Featured Articles component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Component is not enabled.
if ( ! wp_validate_boolean( $component->get_data( 'enable' ) ) ) {
	return;
}

// Get Content Items for this component.
$articles = (array) $component->get_content_items();
if ( empty( $articles ) ) {
	return;
}

// Setup title.
$title = $component->get_data( 'meta', 'title' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
?>

<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'middle-feature' ] ); ?>">
		<h2 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php echo esc_html( $title ); ?></h2>
		<div class="<?php ai_the_classnames( [ 'grid-wrapper' ] ); ?>">
			<?php
			foreach ( $articles as $article ) {
				$article->set_setting( 'layout', 'card' )->render();
			}
			?>
		</div>
	</div>
	<div class="<?php ai_the_classnames( [ 'sidebar' ] ); ?>">
		<div class="<?php ai_the_classnames( [ 'sticky' ] ); ?>">
			<?php
			if ( class_exists( 'Ad_Layers_Ad_Server' ) ) {
				Ad_Layers_Ad_Server::instance()->get_ad_unit( 'HP_Middle_Sidebar', false );
			}
			echo do_shortcode( wp_kses_post( $component->get_data( 'meta', 'sidebar_content' ) ) );
			?>
		</div>
	</div>
</section>
