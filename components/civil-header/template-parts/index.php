<?php
/**
 * Template part for displaying the Civil Header component.
 *
 * @todo  Write markup and CSS for this component.
 *
 * @package Civil_First_Fleet
 */

// @TODO add accessibility.
namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
?>

<header class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" data-component="<?php echo esc_attr( $component->slug ); ?>">
	<div class="<?php ai_the_classnames( [ 'inner' ] ); ?>">
		<?php
		// Render Logo.
		\Civil_First_Fleet\Component\logo()->render();
		?>

		<button class="<?php ai_the_classnames( [ 'menu-trigger' ] ); ?>" aria-controls="civil-header-left" aria-expanded="false">
			<span class="<?php ai_the_classnames( [ 'arrow' ] ); ?>"></span>
			<span class="<?php ai_the_classnames( [ 'text' ] ); ?>"><?php esc_html_e( 'Expand Menu', 'civil-first-fleet' ); ?></span>
		</button>

		<?php
		$component->civil_wp_nav_menu(
			[
				'theme_location'  => 'civil-header-left',
				'menu_id'         => 'civil-header-left',
				'container'       => 'nav',
				'container_class' => ai_get_classnames( [ 'left-nav' ] ),
			]
		);
		?>

		<div class="<?php ai_the_classnames( [ 'right-nav-wrapper' ] ); ?>">
			<?php
			$component->civil_wp_nav_menu(
				[
					'theme_location'  => 'civil-header-right',
					'menu_id'         => 'civil-header-right',
					'container'       => 'nav',
					'container_class' => ai_get_classnames( [ 'right-nav' ] ),
				]
			);
			?>
			<a href="#" class="<?php ai_the_classnames( [ 'login' ] ); ?>"><?php esc_html_e( 'Log In', 'civil-first-fleet' ); ?></a>
			<button class="<?php ai_the_classnames( [ 'button-secondary-dark' ] ); ?>"><?php esc_html_e( 'Get Started', 'civil-first-fleet' ); ?></button>
		</nav><!-- #site-navigation -->
	</div>
</header>
