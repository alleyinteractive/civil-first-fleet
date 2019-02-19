<?php
/**
 * Page Template.
 *
 * @package Civil_First_Fleet
 */

$sticky_cta = ( new Civil_CMS\Component() )->get_option( 'newsroom-settings', 'newsletter', 'sticky_call_to_action' );
?>

<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<?php
	// Output Page Header.
	\Civil_CMS\Component\page_header()
		->set_data( 'title', get_the_title() )
		->render();


	// Output Page Body.
	\Civil_CMS\Component\page_body()
		->set_post_id( get_the_ID() )
		->render();

	if ( (bool) $sticky_cta['enable'] ?? false ) :
		\Civil_CMS\Component\call_to_action()
			->set_setting( $sticky_cta['settings'] ?? [] )
			->set_setting( 'layout', 'sticky' )
			->set_data( $sticky_cta['data'] ?? [] )
			->set_data( 'type', 'newsletter' )
			->set_data( 'context', 'sticky-cta' )
			->render();
	endif;
	?>
</div>
