<?php
/**
 * Template part for displaying the Credibility Indicators component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get indicators for this post (keys only).
$post_indicators = array_filter( (array) $component->data() );

// Filter the indicator data so we only have those related to this post.
$indicators = array_intersect_key(
	(array) $component->setting( 'indicators' ) ?? [],
	$post_indicators
);

if ( empty( $indicators ) ) {
	return;
}
?>

<div class="<?php ai_the_classnames( [ 'wrapper', 'custom-block' ] ); ?>" data-component="credibility-indicators">
	<header class="<?php ai_the_classnames( [ 'intro' ] ); ?>">
		<h2 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php esc_html_e( 'Credibility Indicators', 'civil-first-fleet' ); ?></h2>
		<p class="<?php ai_the_classnames( [ 'description' ] ); ?>"><?php esc_html_e( 'These are selected by the writer and confirmed by the editor', 'civil-first-fleet' ); ?></p>
	</header>
	<ul class="<?php ai_the_classnames( [ 'list' ] ); ?>">
		<?php foreach ( (array) $indicators as $indicator_key => $indicator ) : ?>
			<li class="<?php ai_the_classnames( [ 'indicator' ] ); ?>">
				<button class="<?php ai_the_classnames( [ 'heading' ] ); ?>">
					<span class="<?php ai_the_classnames( [ 'icon' ] ); ?>"><?php ai_get_template_part( $component->get_component_path( "svg/{$indicator_key}.svg" ) ); ?></span>
					<p class="<?php ai_the_classnames( [ 'type' ] ); ?>"><?php echo esc_html( $indicator['label'] ?? '' ); ?></p>
					<span class="<?php ai_the_classnames( [ 'toggle' ] ); ?>">
						<span class="<?php ai_the_classnames( [ 'close-icon' ] ); ?>">&ndash;</span>
						<span class="<?php ai_the_classnames( [ 'open-icon' ] ); ?>">+</span>
					</span>
				</button>
				<div class="<?php ai_the_classnames( [ 'text' ] ); ?>">
					<?php echo esc_html( $indicator['default_value'] ?? '' ); ?>
				</div>
			</li>
		<?php endforeach; ?>
		<a
			class="<?php ai_the_classnames( [ 'learn-more' ] ); ?>"
			href="<?php echo esc_url( $component->get_setting( 'learn_more_link' ) ); ?>"
		>
			<?php echo esc_html( $component->get_setting( 'learn_more_text' ) ); ?>
		</a>
	</ul>
</div>
