<?php
/**
 * Template part for displaying the Site Footer component.
 *
 * The nav menus here are hard-coded, instead of using the multisite network
 * main site's menus, because these menus still need to show up on sites
 * that are outside the civil.co multisite network.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Get this instance.
$component = ai_get_var( 'component' );
?>
<footer class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" data-component="civil-footer">
	<div class="<?php ai_the_classnames( [ 'left-wrapper' ] ); ?>">
		<?php
		// Render logo.
		\Civil_CMS\Component\logo()
			->set_setting( 'version', 'black' )
			->render();
		?>
		<nav>
			<ul class="menu">
				<li class="menu-item"><a href="https://civil.co/about/">About</a></li>
				<li class="menu-item"><a href="https://civil.co/constitution/">Civil Constitution</a></li>
				<li class="menu-item"><a href="https://civil.co/help/#faq">FAQ</a></li>
			</ul>
		</nav>
	</div>

	<div class="<?php ai_the_classnames( [ 'right-nav-wrapper' ] ); ?>">
		<nav>
			<ul class="menu">
				<li class="menu-item"><a href="https://civil.co/help/">Have a Problem?</a></li>
			</ul>
		</nav>
		<a href="https://civil.co/contact/" target="_blank"><button class="<?php ai_the_classnames( [ 'contact-button', 'button-secondary-light' ] ); ?>"><?php esc_html_e( 'Contact Civil', 'civil-cms' ); ?></button></a>
	</div>
</footer>
