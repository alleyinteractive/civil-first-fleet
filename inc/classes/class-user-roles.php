<?php
/**
 * Customize user roles.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

/**
 * Class User_Roles.
 */
class User_Roles {
	use Singleton;

	/**
	 * The cache key.
	 *
	 * @var string
	 */
	private $cache_key = 'civil_user_roles_hash';

	/**
	 * An array of the user roles to add.
	 *
	 * @var array
	 */
	private $user_roles = [];

	/**
	 * Setup the class.
	 */
	private function setup() {
		// Create the user roles.
		$this->user_roles = [
			'administrator' => [
				'display_name' => __( 'Administrator', 'civil-first-fleet' ),
				'action'       => 'merge',
				'caps'         => [
					// Edit flow.
					'ef_view_calendar'        => true,
					'edit_post_subscriptions' => true,
					'ef_view_story_budget'    => true,
					'edit_usergroups'         => true,
				],
			],
			'editor'        => [
				'display_name' => __( 'Editor', 'civil-first-fleet' ),
				'action'       => 'merge',
				'caps'         => [
					'unfiltered_html'         => false,
					'create_users'            => true,
					'delete_users'            => true,
					'edit_users'              => true,
					'list_users'              => true,
					'promote_users'           => true,
					'remove_users'            => true,
					// Edit flow.
					'ef_view_calendar'        => true,
					'edit_post_subscriptions' => true,
					'ef_view_story_budget'    => true,
				],
			],
			'author'        => [
				'display_name' => __( 'Author', 'civil-first-fleet' ),
				'action'       => 'merge',
				'caps'         => [
					'publish_posts'           => false,
					'edit_published_posts'    => false,
					'delete_published_posts'  => false,
					// Edit flow.
					'ef_view_calendar'        => true,
					'edit_post_subscriptions' => true,
					'ef_view_story_budget'    => true,
				],
			],
			'contributor'   => [
				'display_name' => __( 'Contributor', 'civil-first-fleet' ),
				'action'       => 'merge',
				'caps'         => [
					'upload_files'         => true,
					// Edit flow.
					'ef_view_calendar'     => true,
					'ef_view_story_budget' => true,
				],
			],
		];

		$this->setup_multisite();

		// Setup the user roles.
		$this->setup_user_roles();
	}

	/**
	 * Setup up roles and filters required for unfiltered_html on multisite. (On non-multisite, regular admins have unfiltered_html cap.)
	 */
	private function setup_multisite() {
		if ( ! is_multisite() ) {
			return;
		}

		// Create unfiltered administrator caps based on administrator caps.
		$admin_unfiltered_caps = [
			'unfiltered_html'         => true,
			// Edit flow.
			'ef_view_calendar'        => true,
			'edit_post_subscriptions' => true,
			'ef_view_story_budget'    => true,
			'edit_usergroups'         => true,
		];
		$admin_role            = get_role( 'administrator' );
		if ( $admin_role instanceof \WP_Role ) {
			$admin_unfiltered_caps = array_replace(
				$admin_role->capabilities,
				$admin_unfiltered_caps
			);
		}

		$this->user_roles['administrator_unfiltered'] = [
			'display_name' => __( 'Administrator (unfiltered)', 'civil-first-fleet' ),
			'action'       => 'add',
			'caps'         => $admin_unfiltered_caps,
		];

		$this->user_roles['administrator']['caps']['unfiltered_html'] = false;

		add_filter( 'editable_roles', [ $this, 'restrict_administrator_unfiltered' ] );
		add_filter( 'map_meta_cap', [ $this, 'unfilter_multisite' ], 10, 4 );
	}

	/**
	 * Restrict roles such that only superadmins can add administrator_unfiltered's.
	 *
	 * @param array $all_roles List of roles that can be assigned to users.
	 * @return array Filtered list.
	 */
	public function restrict_administrator_unfiltered( $all_roles ) {
		if ( ! is_super_admin( get_current_user_id() ) ) {
			unset( $all_roles['administrator_unfiltered'] );
		}
		return $all_roles;
	}

	/**
	 * Add the unfiltered_html capability back in to newer WordPress multisite. Copied from Automattic's "Unfiltered MU" plugin.
	 *
	 * @param array  $caps Capabilities for meta capability.
	 * @param string $cap  Meta capability name.
	 */
	public function unfilter_multisite( $caps, $cap ) {
		if ( 'unfiltered_html' === $cap ) {
			unset( $caps );
			$caps[] = $cap;
		}
		return $caps;
	}

	/**
	 * Check if we need to add the user roles.
	 */
	private function setup_user_roles() {
		// Check if we have already added our roles.
		$current_hash = get_transient( $this->cache_key );

		// We have not setup the user roles yet or they changed.
		if (
			false === $current_hash
			|| $current_hash !== $this->get_roles_hash()
		) {
			$this->add_user_roles();

			// Save the current hash.
			set_transient( $this->cache_key, $this->get_roles_hash() );
		}
	}

	/**
	 * Add the user roles.
	 */
	private function add_user_roles() {
		// Reset user roles to the WordPress defaults.
		if ( ! function_exists( 'populate_roles' ) ) {
			require_once ABSPATH . 'wp-admin/includes/schema.php';
		}

		populate_roles();

		// Loop through each custom role.
		foreach ( $this->user_roles as $role => $args ) {
			// Do nothing if no action is supplied.
			if ( empty( $args['action'] ) ) {
				continue;
			}

			switch ( $args['action'] ) {
				case 'remove':
					remove_role( $role );
					break;
				case 'merge':
					$this->merge_user_role_capabilities( $role, $args['display_name'], $args['caps'] );
					break;
				case 'add':
					remove_role( $role );

					if ( function_exists( 'wpcom_vip_add_role' ) ) {
						wpcom_vip_add_role( $role, $args['display_name'], $args['caps'] );
					} else {
						// phpcs:ignore WordPress.VIP.RestrictedFunctions.custom_role_add_role
						add_role( $role, $args['display_name'], $args['caps'] );
					}

					break;
			}
		}
	}

	/**
	 * Merge the existing user role capabilities with the new capabilities.
	 *
	 * @param string $role_slug        The current role slug.
	 * @param string $display_name     The new display name.
	 * @param array  $new_capabilities The new capabilities.
	 */
	private function merge_user_role_capabilities( string $role_slug, string $display_name, array $new_capabilities ) {
		// Get the current role.
		$role = get_role( $role_slug );

		// No role found.
		if ( ! ( $role instanceof \WP_Role ) ) {
			return;
		}

		// Remove the existing role.
		remove_role( $role_slug );

		// Add the new updated role.
		$capabilities = $role->capabilities;
		if ( ! empty( $new_capabilities ) ) {
			$capabilities = array_merge( $capabilities, $new_capabilities );
		}

		if ( function_exists( 'wpcom_vip_add_role' ) ) {
			wpcom_vip_add_role( $role_slug, $display_name, $capabilities );
		} else {
			// phpcs:ignore WordPress.VIP.RestrictedFunctions.custom_role_add_role
			add_role( $role_slug, $display_name, $capabilities );
		}
	}

	/**
	 * Get the roles hash.
	 *
	 * @return string The hash code from the current state of the user roles.
	 */
	private function get_roles_hash() {
		return md5( wp_json_encode( $this->user_roles ) );
	}
}

User_Roles::instance();
