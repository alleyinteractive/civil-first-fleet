<?php
/**
 * Template part for displaying the Site Footer component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component      = ai_get_var( 'component' );
$contact_email  = $component->get_data( 'contact_email' );
$copyright_text = $component->get_data( 'copyright_text' );
?>
<footer class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">
		<div class="<?php ai_the_classnames( [ 'footer-logo' ] ); ?>">
			<?php
			// Render Logo.
			\Civil_First_Fleet\Component\logo()
				->set_setting( 'context', 'newsroom' )
				->set_setting( 'version', 'black' )
				->set_setting( 'location', 'footer' )
				->render();
			?>
		</div>

		<nav class="<?php ai_the_classnames( [ 'content' ] ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' supplemental menu' ); ?>">
			<?php
			$menus = [
				'newsroom-footer-one',
				'newsroom-footer-two',
				'newsroom-footer-three',
				'newsroom-footer-four',
			];
			?>

			<?php foreach ( $menus as $location ) : ?>
				<?php if ( has_nav_menu( $location ) ) : ?>
					<div class="<?php ai_the_classnames( [ 'nav-wrapper' ] ); ?>">
						<?php
						if ( ! empty( $component->get_menu_name( $location ) ) ) {
							$component->menu_name( $location );
						}
						wp_nav_menu(
							[
								'theme_location' => $location,
								'menu_id'        => $location,
								'container'      => '',
							]
						);
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>

			<div class="<?php ai_the_classnames( [ 'subscribe-wrapper' ] ); ?>">
				<?php
				\WP_Render\render(
					( new \Civil_First_Fleet\Components\Call_To_Action\Button() )
						->set_config( 'width', 'full' )
						->set_config( 'id', 'subscribe-button-footer' )
						->parse_from_fm_data(
							get_option( 'newsroom-settings' )['footer']['call_to_action_button'] ?? []
						)
				);

				if ( ! empty( $contact_email ) ) :
					?>
					<div class="<?php ai_the_classnames( [ 'contact-email' ] ); ?>">
						<a
							href="mailto:<?php echo sanitize_email( $contact_email ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>"
						>
							<?php
							printf(
								// translators: %1$s: Email address.
								esc_html__( 'Contact Us at %1$s', 'civil-first-fleet' ),
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								sanitize_email( $contact_email )
							);
							?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</nav>
		<span class="<?php ai_the_classnames( [ 'copyright' ] ); ?>">
			<?php
			printf(
				/* translators: Copyright [year] [blog name] */
				esc_html__( 'Copyright © %1$s %2$s', 'civil-first-fleet' ),
				absint( date( 'Y' ) ), // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
				esc_html( $copyright_text )
			);
			?>
		</span>
	</div>
</footer>
