<?php

class WrapperTest extends WP_UnitTestCase {

	/**
	 * Provides data for test_wrapper_exceptions.
	 *
	 * @return array Test cases.
	 */
	public function wrapper_exceptions_data() {
		return array(
			array( '/var/www/civil-cms/wp-content/themes/civil-cms/index.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/themes/civil-cms/single.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/themes/civil-cms/single-person.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/themes/civil-cms/404.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/themes/vip/civil-cms/category.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/themes/vip/civil-cms/page.php', 'update' ),
			array( '/var/www/civil-cms/wp-content/plugins/msm-sitemap/templates/full-sitemap.php', 'ignore' ),
			array( '/var/www/civil-cms/wp-content/themes/vip/plugins/msm-sitemap/templates/full-sitemap.php', 'ignore' ),
		);
	}

	/**
	 * @dataProvider wrapper_exceptions_data
	 *
	 * @param  string $template Template path to test.
	 * @param  string $expected_result Expected result. Either 'update' or
	 *                                 'ignore' to update the path (to
	 *                                 wrapper.php) or ignore to keep as-is.
	 */
	public function test_wrapper_exceptions( $template, $expected_result ) {
		$new_template = Civil_CMS\Wrapping::wrap( $template );
		if ( 'ignore' === $expected_result ) {
			$this->assertSame( $template, $new_template );
		} else {
			$this->assertNotSame( $template, $new_template );
			$this->assertContains( 'wrapper.php', $new_template );
		}
	}

	public function test_wrapper_exception_filter() {
		$template = '/var/www/civil-cms/wp-content/themes/civil-cms/index.php';

		$new_template = Civil_CMS\Wrapping::wrap( $template );
		$this->assertNotSame( $template, $new_template );
		$this->assertContains( 'wrapper.php', $new_template );

		add_filter( 'civil_cms_skip_theme_wrapper', '__return_true' );
		$new_template = Civil_CMS\Wrapping::wrap( $template );
		$this->assertSame( $template, $new_template );
		remove_filter( 'civil_cms_skip_theme_wrapper', '__return_true' );
	}
}
