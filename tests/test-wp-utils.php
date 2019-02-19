<?php
namespace Civil_CMS;

class TestWPUtils extends \WP_UnitTestCase {
	function test_is_wp_post() {
		$this->assertTrue( WP_Utils::is_wp_post( $this->factory->post->create_and_get() ) );
		$this->assertFalse( WP_Utils::is_wp_post( $this->factory->term->create_and_get() ) );
	}

	function test_is_wp_query() {
		$this->assertTrue( WP_Utils::is_wp_query( new \WP_Query() ) );
		$this->assertFalse( WP_Utils::is_wp_query( $this->factory->post->create_and_get() ) );
	}

	function test_is_wp_user() {
		$this->assertTrue( WP_Utils::is_wp_user( $this->factory->user->create_and_get() ) );
		$this->assertFalse( WP_Utils::is_wp_user( $this->factory->post->create_and_get() ) );
	}

	function test_sanitize_posts_per_page() {
		$this->assertSame( 1, WP_Utils::sanitize_posts_per_page( -1 ) );
		$this->assertSame( 100, WP_Utils::sanitize_posts_per_page( 101 ) );
		$this->assertSame( 42, WP_Utils::sanitize_posts_per_page( 42 ) );
	}
}
