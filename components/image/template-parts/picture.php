<?php
/**
 * Template part for rendering an image in a <picture> element
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component    = ai_get_var( 'component' );
$aspect_ratio = $component->get_setting( 'aspect_ratio' );
?>
<picture style="<?php echo esc_attr( $component->get_aspect_ratio_padding() ); ?>" class="<?php ai_the_classnames( [ 'wrapper' ], [ 'intrinsic' => $aspect_ratio ] ); ?>">
	<?php
	$component->source_tags();

	\ai_get_template_part(
		$component->get_component_path( 'img' ),
		[
			'component'  => $component,
			'srcset'     => $component->get_base_url(),
			'stylesheet' => 'image',
		]
	);
	?>
</picture>
