<?php
/**
 * 404 Template.
 *
 * @package Civil_First_Fleet
 */

?>

<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<?php
	// Output Error Page content.
	\Civil_CMS\Component\error_page()
		->set_setting( 'is_main_site', is_main_site() )
		->render();
	?>
</div>
