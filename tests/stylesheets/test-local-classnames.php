<?php

/**
 * @group stylesheets
 */
class LocalClassnamesTest extends WP_UnitTestCase {

	public $test_classnames = [
		'alignleft' => 'article__alignleft___1cXIA',
		'alignright' => 'article__alignright___18ifD',
		'title' => 'article__title___2kGA7 _typography__header-main___2IME8',
		'article-body' => 'article__article-body___RnJE3',
	];

	protected function ob( $callback, $args = array() ) {
		ob_start();
		call_user_func_array( $callback, $args );
		return ob_get_clean();
	}

	public function setUp() {
		ob_start();
		\Civil_CMS\Stylesheets::instance()->setup( true, get_stylesheet_directory() . '/tests/stylesheets/mocks/mock-classnames.json' );
		ob_get_clean();
		ai_use_stylesheet( 'mock-one' );
	}

	public function test_use_stylesheet() {
		$this->assertEquals( $this->test_classnames, \Civil_CMS\Stylesheets::instance()->current_stylesheet_classnames );
	}

	public function test_get_classnames() {
		$classnames = ai_get_classnames( [ 'alignleft' ] );
		$this->assertEquals( 'article__alignleft___1cXIA article__alignleft', $classnames );
	}

	public function test_the_classnames() {
		$classnames = $this->ob( 'ai_the_classnames', [
			'static_classes' => [ 'alignleft' ],
		] );
		$this->assertEquals( 'article__alignleft___1cXIA article__alignleft', $classnames );
	}

	public function test_get_multiple_classnames() {
		$classnames = ai_get_classnames( [ 'alignleft', 'alignright' ] );
		$this->assertEquals( 'article__alignleft___1cXIA article__alignleft article__alignright___18ifD article__alignright', $classnames );
	}

	public function test_get_multiple_classnames_complex() {
		$classnames = ai_get_classnames( [
			'alignleft',
			'test-class',
		],
		[ 'alignright' => false ] );
		$this->assertEquals( 'article__alignleft___1cXIA article__alignleft test-class', $classnames );
	}

	public function test_get_classnames_alternate_stylesheet() {
		$classnames = ai_get_classnames( [ 'alignleft' ], [], 'mock-two' );
		$this->assertEquals( 'site__alignleft___Lww3s site__alignleft', $classnames );
	}
}
