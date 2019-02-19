<?php
/**
 * Template part for displaying the Page Header component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Get this instance.
$component = ai_get_var( 'component' );
?>

<header class="newsroom-theme__header <?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<h1 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php echo esc_html( $component->data( 'title' ) ); ?></h1>
</header>
