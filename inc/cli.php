<?php // phpcs:disable

WP_CLI::add_command( 'civil-first-fleet', 'Civil_First_Fleet_CLI_Command' );

class Civil_First_Fleet_CLI_Command extends WP_CLI_Command {

	/**
	 * Prevent memory leaks from growing out of control
	 */
	function contain_memory_leaks() {
		global $wpdb, $wp_object_cache;
		$wpdb->queries = [];
		if ( ! is_object( $wp_object_cache ) ) {
			return;
		}
		$wp_object_cache->group_ops      = [];
		$wp_object_cache->stats          = [];
		$wp_object_cache->memcache_debug = [];
		$wp_object_cache->cache          = [];
		if ( method_exists( $wp_object_cache, '__remoteset' ) ) {
			$wp_object_cache->__remoteset();
		}
	}

	// Add subcommand(s) here

}
