<?php
/**
 * Template part for displaying the Page Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Get this instance.
$component = ai_get_var( 'component' );
?>
<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<?php
	\Civil_CMS\Component\body_content()
		->center()
		->render();
	?>
</section>
