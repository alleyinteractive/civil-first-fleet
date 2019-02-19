<?php
/**
 * Template part for displaying the Newsletter component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );
?>

<div class="<?php ai_the_classnames( [ 'wrapper', 'civil__sticky-footer__wrapper' ] ); ?>">
	<input class="<?php ai_the_classnames( [ 'close' ] ); ?>" type="checkbox" name="close-call-to-action" id="close-call-to-action" />
	<label class="<?php ai_the_classnames( [ 'label' ] ); ?>" for="close-call-to-action"><?php esc_html_e( 'Close', 'civil-first-fleet' ); ?></label>
	<?php
	\ai_get_template_part(
		$component->get_component_path( $component->setting( 'type' ) ), [
			'component'  => $component,
			'stylesheet' => $component->slug,
		]
	);
	?>
</div>
