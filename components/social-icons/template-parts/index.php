<?php
/**
 * Template part for displaying the Social Icons component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );
$context   = $component->get_data( 'context' );
$facebook  = $component->get_option( 'newsroom-settings', 'contact', 'social', 'facebook' );
$twitter   = $component->get_option( 'newsroom-settings', 'contact', 'social', 'twitter' );
$instagram = $component->get_option( 'newsroom-settings', 'contact', 'social', 'instagram' );
$linkedin  = $component->get_option( 'newsroom-settings', 'contact', 'social', 'linkedin' );

?>
<div class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<span class="<?php ai_the_classnames( [ 'follow-text' ] ); ?>">
		<?php esc_html_e( 'Follow us:', 'civil-first-fleet' ); ?>
	</span>
	<nav class="<?php ai_the_classnames( [ 'social-icon-nav' ] ); ?>">
		<ul>
			<?php if ( ! empty( $facebook ) ) { ?>
			<li>
				<a class="social-icon-nav--facebook" href="<?php echo esc_url( $facebook ); ?>" target="_blank">
					<?php ai_get_template_part( $component->get_component_path( 'svg/facebook.svg' ) ); ?>
				</a>
			</li>
			<?php } ?>
			<?php if ( ! empty( $twitter ) ) { ?>
			<li>
				<a class="social-icon-nav--twitter" href="<?php echo esc_url( $twitter ); ?>" target="_blank">
					<?php ai_get_template_part( $component->get_component_path( 'svg/twitter.svg' ) ); ?>
				</a>
			</li>
			<?php } ?>
			<?php if ( ! empty( $instagram ) ) { ?>
			<li>
				<a class="social-icon-nav--instagram" href="<?php echo esc_url( $instagram ); ?>" target="_blank">
					<?php ai_get_template_part( $component->get_component_path( 'svg/instagram.svg' ) ); ?>
				</a>
			</li>
			<?php } ?>
			<?php if ( ! empty( $linkedin ) ) { ?>
			<li>
				<a class="social-icon-nav--linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank">
					<?php ai_get_template_part( $component->get_component_path( 'svg/linkedin.svg' ) ); ?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</nav>
</div>
