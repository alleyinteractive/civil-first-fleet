<?php
/**
 * Template part for displaying the Featured Articles Widget component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get Content Items for this component.
$articles = (array) $component->get_content_items();
if ( empty( $articles ) ) {
	return;
}

// Get title.
$title = $component->get_data( 'meta', 'title' );
if ( empty( $title ) ) {
	$title = __( 'Featured Articles', 'civil-cms' );
}
?>

<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<h2 class="<?php ai_the_classnames( [ 'headline' ] ); ?>"><?php echo esc_html( $title ); ?></h2>
	<ul class="<?php ai_the_classnames( [ 'list' ] ); ?>">
		<?php foreach ( $articles as $article ) { ?>
			<li><?php $article->set_setting( 'layout', 'text-link' )->render(); ?></li>
		<?php } ?>
	</ul>
</section>
