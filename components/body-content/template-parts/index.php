<?php
/**
 * Template part for displaying the Article Body component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
?>
<div
	class="<?php ai_the_classnames( [ 'wrapper', 'rich-text', $component->get_setting( 'layout' ) ] ); ?>"
	data-component="body-content"
>
<?php
the_content(
	sprintf(
		wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers. */
			__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'civil-first-fleet' ),
			array(
				'span' => array(
					'class' => array(),
				),
			)
		),
		get_the_title()
	)
);
?>
</div>
