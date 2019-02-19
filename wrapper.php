<?php
/**
 * The primary HTML wrapper for our theme.
 *
 * @package Civil_First_Fleet
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php \Civil_CMS\Stylesheets::instance()->setup(); ?>

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'civil-cms' ); ?></a>

			<?php \Civil_CMS\Component\newsroom_header()->render(); ?>

			<div id="content" class="site-content">
				<div id="primary" class="content-area">
					<main id="main" class="site-main">
						<?php
						if ( is_search() ) {
							ai_get_template_part( 'search' );
						} elseif ( \Civil_CMS\is_landing_page() ) {
							ai_get_template_part( 'index' );
						} elseif ( have_posts() ) {
							/**
							 * Load the main template file, e.g. single.php.
							 */
							\Civil_CMS\get_main_template();
						} else {
							ai_get_template_part( 'template-parts/404' );
						}
						?>
					</main>
				</div>
			</div>

			<?php
			\Civil_CMS\Component\newsroom_footer()->render();
			\Civil_CMS\Component\civil_footer()->render();
			?>

		</div>

		<?php wp_footer(); ?>
	</body>
</html>
