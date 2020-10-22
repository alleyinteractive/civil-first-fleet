<?php
/**
 * Template part for displaying the Article Taxonomies component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );
$terms     = $component->get_data( 'terms' );
$title     = $component->get_setting( 'label' ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

/**
 * Determine if there are any terms to display. (There may have been none to
 * begin with, or none may remain after filtering.)
 */
if ( ! empty( $terms ) ) :
	?>

	<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
		<?php if ( ! empty( $title ) ) : ?>
		<h3 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>
		<ul class="<?php ai_the_classnames( [ 'list' ] ); ?>">
			<?php foreach ( $terms as $term ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
				<?php $link = get_term_link( $term ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
			<li><a class="<?php ai_the_classnames( [ 'link' ] ); ?>" href="<?php echo esc_url( is_string( $link ) ? $link : '' ); ?>"><?php echo esc_html( $term->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</section>

	<?php
endif;
?>
