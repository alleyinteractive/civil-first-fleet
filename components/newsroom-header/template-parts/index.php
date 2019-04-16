<?php
/**
 * Template part for displaying the Newsroom Header component.
 *
 * @todo  Write markup and CSS for this component.
 *
 * @package Civil_First_Fleet
 */

// @TODO add accessibility.
namespace Civil_First_Fleet;

// Get this instance.
$ai_component = ai_get_var( 'component' );
?>

<header class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" data-component="<?php echo esc_attr( $ai_component->slug ); ?>">
	<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">
		<?php
		// Render Logo.
		\Civil_First_Fleet\Component\logo()
			->set_setting( 'context', 'newsroom' )
			->set_setting( 'version', 'black' )
			->render();
		?>

		<div id="newsroom-nav" class="<?php ai_the_classnames( [ 'nav-wrapper' ] ); ?>">
			<?php
			if ( has_nav_menu( 'newsroom-header' ) ) {
				wp_nav_menu(
					array(
						'theme_location'  => 'newsroom-header',
						'menu_id'         => 'newsroom-header-nav',
						'container'       => 'nav',
						'container_class' => ai_get_classnames( [ 'nav' ] ),
					)
				);
			}
			?>

			<?php
			// If this newsroom is showing a search widget in the header nav.
			if ( $ai_component->get_option( 'newsroom-settings', 'search', 'search_display', 'show_search_in_header_nav' ) ) {
				$search_style = $ai_component->get_option( 'newsroom-settings', 'search', 'search_display', 'search_form_style' );
				?>
				<div class="<?php ai_the_classnames( [ 'search-wrapper' ] ); ?>">
					<?php
					if ( 'trigger' === $search_style ) {
						?>
						<button class="<?php ai_the_classnames( [ 'search-trigger' ] ); ?>" aria-hidden="true">
							<span class="<?php ai_the_classnames( [ 'search-trigger__icon' ] ); ?>"></span>
							<span class="<?php ai_the_classnames( [ 'search-trigger__label' ] ); ?>" style="display: none;"><?php echo esc_html__( 'Search', 'civil-first-fleet' ); ?></span>
						</button>
						<div class="<?php ai_the_classnames( [ 'hidden-search' ] ); ?>">
							<?php
							\Civil_First_Fleet\Component\search_form()
								->set_data( 'include_button', true )
								->set_data( 'context', 'header' )
								->render();
							?>
						</div>
						<?php
					} elseif ( 'inline' === $search_style ) {
						\Civil_First_Fleet\Component\search_form()
							->set_data( 'include_button', true )
							->set_data( 'context', 'header' )
							->render();
					}
					?>
				</div>
				<?php
			}
			?>

			<div class="<?php ai_the_classnames( [ 'subscribe-wrapper' ] ); ?>">
				<?php
				\WP_Render\render(
					( new \Civil_First_Fleet\Components\Call_To_Action\Button() )
						->set_config( 'id', 'subscribe-button-header' )
						->parse_from_fm_data(
							get_option( 'newsroom-settings' )['header']['call_to_action_button'] ?? []
						)
				);
				?>
			</div>

			<span class="<?php ai_the_classnames( [ 'runs-on-civil--nav' ] ); ?>"><a href="https://civil.co" target="_blank"><?php ai_get_template_part( $ai_component->get_component_path( 'svg/runs-on-civil-black-inline.svg' ) ); ?></a></span>
		</div><!-- #site-navigation -->

		<button class="<?php ai_the_classnames( [ 'menu-trigger' ] ); ?>" aria-controls="newsroom-nav" aria-expanded="false">
			<span><?php ai_get_template_part( $ai_component->get_component_path( 'svg/hamburger.svg' ) ); ?></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Newsroom Navigation', 'civil-first-fleet' ); ?></span>
		</button>

		<span class="<?php ai_the_classnames( [ 'runs-on-civil' ] ); ?>"><a href="https://civil.co" target="_blank"><?php ai_get_template_part( $ai_component->get_component_path( 'svg/runs-on-civil-black.svg' ) ); ?></a></span>
	</div>
</header>
