<?php
/**
 * Template part for rendering an image in an <img> element
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component         = ai_get_var( 'component' );
$aspect_ratio      = $component->get_setting( 'aspect_ratio' );
$is_featured_image = $component->get_setting( 'is_featured' );
?>

<span style="<?php echo esc_attr( $component->get_aspect_ratio_padding() ); ?>" class="
	<?php
	ai_the_classnames(
		[ 'wrapper' ],
		[
			'intrinsic'      => $aspect_ratio,
			'featured-image' => $is_featured_image,
		]
	);
	?>
">
	<?php
	\ai_get_template_part(
		$component->get_component_path( 'img' ),
		[
			'component'  => $component,
			'srcset'     => implode( ',', $component->get_srcset() ),
			'stylesheet' => 'image',
		]
	);
	?>
</span>
