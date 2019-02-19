<?php
/**
 * Template part for displaying the Page Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
?>
<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<?php
	\Civil_First_Fleet\Component\body_content()
		->center()
		->render();
	?>
</section>
