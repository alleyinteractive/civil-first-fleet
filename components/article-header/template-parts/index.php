<?php
/**
 * Template part for displaying the Article Header component.
 *
 * @todo  refactor parts of this file into additional template parts
 *        (within this component).
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );
$post_id = $component->data( 'post_id' );
$ai_coauthors = get_coauthors( $post_id );
$is_opinion = ! empty( $component->get_label() );
$has_dek = ! empty( $component->get_dek() );

// Secondary bylines.
$component->set_data( 'secondary_bylines', get_post_meta( $post_id, 'secondary_bylines', true ) );

/**
 * Determine what kind of media to display.
 *
 * If a featured video url exists, hide the image and display that.
 * If `disable_featured_image` is true, hide the image.
 * Othewise, display the image.
 */
$featured_video_url = (bool) get_post_meta( $post_id, 'featured_video_url', true );
if ( $featured_video_url ) {
	\ai_get_template_part(
		$component->get_component_path( 'video' ), array(
			'component' => $component,
		)
	);
} else {
	$disable_featured_image = (bool) get_post_meta( $post_id, 'disable_featured_image', true );
	if ( ! $disable_featured_image ) {
		\ai_get_template_part(
			$component->get_component_path( 'image' ), array(
				'component' => $component,
			)
		);
	}
}
?>

<header class="
	<?php
	ai_the_classnames(
		[ 'wrapper' ], [
			'opinion' => $is_opinion,
			'with-dek' => $has_dek,
		]
	);
	?>
	">
	<div class="<?php ai_the_classnames( [ 'header' ] ); ?>">

		<h1 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php echo esc_html( get_the_title( $post_id ) ); ?></h1>

		<?php if ( $has_dek ) : ?>
			<p class="<?php ai_the_classnames( [ 'dek' ] ); ?>"><?php $component->dek(); ?></p>
		<?php endif; ?>

		<?php $component->published_date(); ?>

		<?php $component->eyebrow(); ?>

		<?php if ( $is_opinion ) : ?>
			<span class="<?php ai_the_classnames( [ 'label' ] ); ?>">
				<?php $component->label(); ?>
			</span>
		<?php endif; ?>

	</div>

	<!-- meta: bylines, bios, shares, tip -->
	<div class="<?php ai_the_classnames( [ 'meta-wrapper' ] ); ?>">

		<?php \Civil_CMS\Component\article_bylines()->render(); ?>

		<!-- secondary bylines -->
		<?php if ( ! empty( $component->get_data( 'secondary_bylines' ) ) ) : ?>
			<div class="<?php ai_the_classnames( [ 'bylines-wrapper' ] ); ?>">
				<?php $component->secondary_bylines(); ?>
			</div>
		<?php endif; ?>

		<!-- shares and tip -->
		<div class="<?php ai_the_classnames( [ 'shares-wrapper' ] ); ?>">
			<!-- shares: no_mobile -->
			<div class="<?php ai_the_classnames( [ 'social-shares' ] ); ?>">
				<?php $component->jetpack_sharing_display(); ?>
			</div>
			<?php
			/**
			Not applicable for launch
			<button class="<?php ai_the_classnames( [ 'tip' ] ); ?>">
				<span class="<?php ai_the_classnames( [ 'tip-icon' ] ); ?>"></span>
				Tip $0.25+
			</button>
			 */
			?>
		</div>

	</div>

</header>
