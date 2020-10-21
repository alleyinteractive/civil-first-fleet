<?php
/**
 * Template part for displaying a single article in the Article Grid component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );
$articles  = (array) $component->get_content_items();
?>

<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" data-component="content-list">
	<?php
	$component->open_load_more_wrapper( ai_get_classnames( [ 'grid-wrapper' ] ) );
	foreach ( $articles as $article ) {
		$article->set_setting( 'layout', 'card' )->render();
	}
	$component->close_load_more_wrapper();

	$component->render_load_more();
	?>
</div>
