<?php

/**
 * @group partials
 */
class PartialsTest extends WP_UnitTestCase {

	protected function ob( $callback, $args = array() ) {
		ob_start();
		call_user_func_array( $callback, $args );
		return ob_get_clean();
	}

	public function test_basic_load() {
		$contents = $this->ob( function() {
			ai_get_template_part( 'tests/partials/template-parts/basic' );
		} );
		$this->assertContains( 'Template loaded: successfully', $contents );
	}

	public function test_basic_load_name() {
		$contents = $this->ob( function() {
			ai_get_template_part( 'tests/partials/template-parts/basic', 'variant' );
		} );
		$this->assertContains( 'Variant loaded: successfully', $contents );
	}

	public function test_basic_load_name_fallback() {
		$contents = $this->ob( function() {
			ai_get_template_part( 'tests/partials/template-parts/basic', 'phony' );
		} );
		$this->assertContains( 'Template loaded: successfully', $contents );
	}

	public function test_basic_var() {
		$test = rand_str();
		$contents = $this->ob( function() use ( $test ) {
			ai_get_template_part( 'tests/partials/template-parts/basic', [ 'custom_var' => $test ] );
		} );
		$this->assertContains( "Template loaded: {$test}", $contents );
	}

	public function test_parent_child_load() {
		$contents = $this->ob( function() {
			ai_get_template_part( 'tests/partials/template-parts/parent' );
		} );
		$this->assertContains( 'Parent loaded: successfully', $contents );
		$this->assertContains( 'Child loaded: successfully', $contents );
	}

	public function test_iterate() {
		$items = [
			rand_str(),
			rand_str(),
			rand_str(),
		];
		$contents = $this->ob( function() use ( $items ) {
			ai_iterate_template_part( $items, 'tests/partials/template-parts/iterate-item' );
		} );
		foreach ( $items as $key => $value ) {
			$this->assertContains( "Item {$key}: {$value}", $contents );
		}
	}

	public function test_iterate_string_keys() {
		$items = [
			'one' => rand_str(),
			'two' => rand_str(),
			'three' => rand_str(),
		];
		$contents = $this->ob( function() use ( $items ) {
			ai_iterate_template_part( $items, 'tests/partials/template-parts/iterate-item' );
		} );
		foreach ( $items as $key => $value ) {
			$this->assertContains( "Item {$key}: {$value}", $contents );
		}
	}

	public function test_loop_array() {
		$posts = [
			$this->factory->post->create(),
			$this->factory->post->create(),
			$this->factory->post->create(),
		];
		$contents = $this->ob( function() use ( $posts ) {
			ai_loop_template_part( $posts, 'tests/partials/template-parts/loop-post' );
		} );
		foreach ( $posts as $key => $post_id ) {
			$this->assertContains( "Post {$key}: {$post_id}", $contents );
		}
	}

	public function test_loop_query() {
		$posts = [
			$this->factory->post->create( [ 'post_date' => '2003-01-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2002-01-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2001-01-01 00:00:00' ] ),
		];
		$contents = $this->ob( function() {
			ai_loop_template_part( new WP_Query( 'orderby=date&order=desc' ), 'tests/partials/template-parts/loop-post' );
		} );
		foreach ( $posts as $key => $post_id ) {
			$this->assertContains( "Post {$key}: {$post_id}", $contents );
		}
	}

	public function test_reset_post() {
		$posts = [
			$this->factory->post->create( [ 'post_date' => '2016-01-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-03-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-02-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-01-01 00:00:00' ] ),
		];

		global $post;
		$post = get_post( $posts[0] );
		setup_postdata( $post );
		$this->assertSame( $posts[0], get_the_ID() );

		$contents = $this->ob( function() {
			ai_loop_template_part( new WP_Query( 'year=2015' ), 'tests/partials/template-parts/loop-post' );
		} );
		foreach ( [ 1, 2, 3 ] as $i => $key ) {
			$this->assertContains( "Post {$i}: {$posts[ $key ]}", $contents );
		}

		$this->assertSame( $posts[0], get_the_ID() );
	}

	public function test_loop_array_string_keys() {
		$posts = [
			'one' => $this->factory->post->create(),
			'two' => $this->factory->post->create(),
			'three' => $this->factory->post->create(),
		];
		$contents = $this->ob( function() use ( $posts ) {
			ai_loop_template_part( $posts, 'tests/partials/template-parts/loop-post' );
		} );
		foreach ( $posts as $key => $post_id ) {
			$this->assertContains( "Post {$key}: {$post_id}", $contents );
		}
	}

	public function test_nested_loops() {
		$posts = [
			$this->factory->post->create( [ 'post_date' => '2016-01-01 00:00:00' ] ),

			$this->factory->post->create( [ 'post_date' => '2015-01-03 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-01-02 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-01-01 00:00:00' ] ),

			$this->factory->post->create( [ 'post_date' => '2014-01-03 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2014-01-02 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2014-01-01 00:00:00' ] ),
		];

		global $post;
		$post = get_post( $posts[0] );
		setup_postdata( $post );

		$this->assertSame( $posts[0], get_the_ID() );

		$contents = $this->ob( function() {
			ai_loop_template_part(
				new WP_Query( 'year=2015orderby=date&order=desc' ),
				'tests/partials/template-parts/loop',
				[ 'child_query' => new WP_Query( 'year=2014&orderby=date&order=desc' ) ]
			);
		} );

		$subloop = [
			"[Post 0: {$posts[4]}]",
			"[Post 1: {$posts[5]}]",
			"[Post 2: {$posts[6]}]",
		];

		$expected = [];
		foreach ( [ 1, 2, 3 ] as $key => $i ) {
			$expected[] = sprintf( "[Parent loop post %s: %d]\n%s\n", $key, $posts[ $i ], implode( "\n", $subloop ) );
		}
		$expected = implode( $expected );

		$this->assertSame( $expected, $contents );
		$this->assertSame( $posts[0], get_the_ID() );
		$this->assertEmpty( \Civil_CMS\Partials::instance()->original_posts );
	}

	public function test_basic_return() {
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/basic',
		] );
		$this->assertContains( 'Template loaded: successfully', $contents );
	}

	public function test_basic_return_name() {
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/basic',
			'name' => 'variant',
		] );
		$this->assertContains( 'Variant loaded: successfully', $contents );
	}

	public function test_basic_return_name_fallback() {
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/basic',
			'name' => 'phony',
		] );
		$this->assertContains( 'Template loaded: successfully', $contents );
	}

	public function test_parent_child_return() {
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/parent',
		] );
		$this->assertContains( 'Parent loaded: successfully', $contents );
		$this->assertContains( 'Child loaded: successfully', $contents );
	}

	public function test_iterate_return() {
		$items = [
			rand_str(),
			rand_str(),
			rand_str(),
		];
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/iterate-item',
			'iterate' => $items,
		] );
		foreach ( $items as $key => $value ) {
			$this->assertContains( "Item {$key}: {$value}", $contents );
		}
	}

	public function test_loop_array_return() {
		$posts = [
			$this->factory->post->create(),
			$this->factory->post->create(),
			$this->factory->post->create(),
		];
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/loop-post',
			'loop' => $posts,
		] );
		foreach ( $posts as $key => $post_id ) {
			$this->assertContains( "Post {$key}: {$post_id}", $contents );
		}
	}

	public function test_loop_query_return() {
		$posts = [
			$this->factory->post->create( [ 'post_date' => '2003-01-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2002-01-01 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2001-01-01 00:00:00' ] ),
		];
		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/loop-post',
			'loop' => new WP_Query( 'orderby=date&order=desc' ),
		] );
		foreach ( $posts as $key => $post_id ) {
			$this->assertContains( "Post {$key}: {$post_id}", $contents );
		}
	}

	public function test_nested_loops_return() {
		$posts = [
			$this->factory->post->create( [ 'post_date' => '2016-01-01 00:00:00' ] ),

			$this->factory->post->create( [ 'post_date' => '2015-01-03 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-01-02 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2015-01-01 00:00:00' ] ),

			$this->factory->post->create( [ 'post_date' => '2014-01-03 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2014-01-02 00:00:00' ] ),
			$this->factory->post->create( [ 'post_date' => '2014-01-01 00:00:00' ] ),
		];

		global $post;
		$post = get_post( $posts[0] );
		setup_postdata( $post );

		$this->assertSame( $posts[0], get_the_ID() );

		$contents = ai_partial( [
			'return' => true,
			'slug' => 'tests/partials/template-parts/loop',
			'loop' => new WP_Query( 'year=2015orderby=date&order=desc' ),
			'variables' => [ 'child_query' => new WP_Query( 'year=2014&orderby=date&order=desc' ) ],
		] );

		$subloop = [
			"[Post 0: {$posts[4]}]",
			"[Post 1: {$posts[5]}]",
			"[Post 2: {$posts[6]}]",
		];

		$expected = [];
		foreach ( [ 1, 2, 3 ] as $key => $i ) {
			$expected[] = sprintf( "[Parent loop post %s: %d]\n%s\n", $key, $posts[ $i ], implode( "\n", $subloop ) );
		}
		$expected = implode( $expected );

		$this->assertSame( $expected, $contents );
		$this->assertSame( $posts[0], get_the_ID() );
		$this->assertEmpty( \Civil_CMS\Partials::instance()->original_posts );
	}

	public function test_empty_post_restoring() {
		unset( $GLOBALS['post'] );

		$parent_post = $this->factory->post->create( [ 'post_date' => '2016-01-01 00:00:00' ] );
		$child_post = $this->factory->post->create( [ 'post_date' => '2015-01-03 00:00:00' ] );

		$contents = $this->ob( function() use ( $parent_post, $child_post ) {
			ai_loop_template_part(
				[ $parent_post ],
				'tests/partials/template-parts/loop',
				[ 'child_query' => [ $child_post ] ]
			);
		} );

		$this->assertSame( "[Parent loop post 0: {$parent_post}]\n[Post 0: {$child_post}]\n", $contents );
		$this->assertSame( null, $GLOBALS['post'] );
		$this->assertEmpty( \Civil_CMS\Partials::instance()->original_posts );
	}

	public function test_basic_cache_load() {
		$slug = 'tests/partials/template-parts/cache';

		// Set a dynamic value used in the template
		$rand = _cache_test_data( rand_str() );

		// Load the partial, verify it works and the transient gets set
		$contents = $this->ob( function() use ( $slug ) {
			ai_get_cached_template_part( $slug );
		} );
		$this->assertSame( "Template loaded: {$rand}", $contents );

		// Change the dynamic value used in the partial
		$new_rand = _cache_test_data( rand_str() );

		// Verify that the value has changed when not loading from cache
		$contents = $this->ob( function() use ( $slug ) {
			ai_get_template_part( $slug );
		} );
		$this->assertSame( "Template loaded: {$new_rand}", $contents );

		// ... but if we load the cached variant, it should give the old value
		$contents = $this->ob( function() use ( $slug ) {
			ai_get_cached_template_part( $slug );
		} );
		$this->assertSame( "Template loaded: {$rand}", $contents );
	}

	public function test_cache_load_custom_key() {
		$slug = 'tests/partials/template-parts/cache';
		$key = 'cached_partials_test';

		// Set a dynamic value used in the template
		$rand = _cache_test_data( rand_str() );

		// Load the partial, verify it works and the transient gets set
		$contents = $this->ob( function() use ( $slug, $key ) {
			ai_get_cached_template_part( $slug, [ '_cache_key' => $key ] );
		} );
		$this->assertSame( "Template loaded: {$rand}", $contents );
		$this->assertSame( "Template loaded: {$rand}", get_transient( $key ) );

		// Change the dynamic value used in the partial
		$new_rand = _cache_test_data( rand_str() );

		// Ensure that we get a cached response
		$contents = $this->ob( function() use ( $slug, $key ) {
			ai_get_cached_template_part( $slug, [ '_cache_key' => $key ] );
		} );
		$this->assertSame( "Template loaded: {$rand}", $contents );
		$this->assertSame( "Template loaded: {$rand}", get_transient( $key ) );

		// Delete the transient
		delete_transient( $key );

		// Verify that the value has changed
		$contents = $this->ob( function() use ( $slug, $key ) {
			ai_get_cached_template_part( $slug, [ '_cache_key' => $key ] );
		} );
		$this->assertSame( "Template loaded: {$new_rand}", $contents );
		$this->assertSame( "Template loaded: {$new_rand}", get_transient( $key ) );
	}
}
