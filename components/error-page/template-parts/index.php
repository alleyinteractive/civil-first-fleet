<?php
/**
 * Template part for displaying the Error Page component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
?>
<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'content' ] ); ?>">
		<h1 class="<?php ai_the_classnames( [ 'heading' ] ); ?>"><?php esc_html_e( '404', 'civil-first-fleet' ); ?></h1>
		<?php $component->default_content(); ?>
	</div>
</section>
