<?php
/**
 * Homepage Template.
 *
 * @package Civil_First_Fleet
 */

// Get settings for this homepage.
$homepage_id = absint( ai_get_var( 'homepage_id' ) );
$homepage    = get_post_meta( $homepage_id, 'homepage', true );
$sticky_cta  = ( new Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'newsletter', 'sticky_call_to_action' );

// Output Featured Articles.
\Civil_First_Fleet\Component\featured_articles()
	->set_setting( 'items', 7 )
	->data( $homepage['featured_articles'] ?? [] )
	->render();

// Call To Action Number 1.
if ( ! empty( $homepage['call_to_action_1']['enable'] ) ) {
	\Civil_First_Fleet\Component\call_to_action()
		->set_setting( $homepage['call_to_action_1']['settings'] )
		->set_data( $homepage['call_to_action_1']['data'] )
		->set_data( 'context', 'home-upper' )
		->render();
}

// ZipRecruiter Block.
if ( ! empty( $homepage['ziprecruiter_jobs_block']['enable'] ) ) {
	\Civil_First_Fleet\Component\ziprecruiter_jobs_block()
		->set_data( $homepage['ziprecruiter_jobs_block'] ?? [] )
		->render();
}

// Call To Action Number 2.
if ( ! empty( $homepage['call_to_action_2']['enable'] ) ) {
	\Civil_First_Fleet\Component\call_to_action()
		->set_setting( $homepage['call_to_action_2']['settings'] )
		->set_data( $homepage['call_to_action_2']['data'] )
		->set_data( 'context', 'home-upper' )
		->render();
}

// Output Middle Feature.
\Civil_First_Fleet\Component\middle_feature()
	->set_setting( 'items', 4 )
	->data( $homepage['middle_feature'] ?? [] )
	->render();

// Output Article Grid.
\Civil_First_Fleet\Component\article_grid()
	->set_setting( 'items', 9 )
	->data( $homepage['articles_grid'] ?? [] )
	->render();

// Call To Action Number 3.
if ( ! empty( $homepage['call_to_action_3']['enable'] ) ) {
	\Civil_First_Fleet\Component\call_to_action()
		->set_setting( $homepage['call_to_action_3']['settings'] )
		->set_data( $homepage['call_to_action_3']['data'] )
		->set_data( 'context', 'home-lower' )
		->render();
}

if ( (bool) $sticky_cta['enable'] ?? false ) :
	\Civil_First_Fleet\Component\call_to_action()
		->set_setting( $sticky_cta['settings'] ?? [] )
		->set_setting( 'layout', 'sticky' )
		->set_data( $sticky_cta['data'] ?? [] )
		->set_data( 'type', 'newsletter' )
		->set_data( 'context', 'sticky-cta' )
		->render();
endif;
