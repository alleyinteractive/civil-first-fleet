<?php
/**
 * Civil CMS functions and definitions.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

define( 'CIVIL_CMS_PATH', dirname( __FILE__ ) );
define( 'CIVIL_CMS_URL', get_template_directory_uri() );
define( 'CIVIL_CMS_STATIC_VERSION', '1.0.3' );

// Activate and customize plugins.
require_once CIVIL_CMS_PATH . '/inc/plugins.php';

/**
 * Traits.
 */
require_once CIVIL_CMS_PATH . '/inc/traits/trait-singleton.php';

/**
 * Classes
 */
require_once CIVIL_CMS_PATH . '/inc/classes/class-component.php';
require_once CIVIL_CMS_PATH . '/inc/classes/class-path-dispatch.php';
require_once CIVIL_CMS_PATH . '/inc/classes/class-shortcode.php';
require_once CIVIL_CMS_PATH . '/inc/classes/class-user-roles.php';
require_once CIVIL_CMS_PATH . '/inc/classes/class-wp-utils.php';
require_once CIVIL_CMS_PATH . '/inc/classes/unique-wp-query/class-unique-wp-query-manager.php';
require_once CIVIL_CMS_PATH . '/inc/classes/unique-wp-query/class-unique-wp-query.php';

/**
 * Components
 */
// Top level Components.
require_once CIVIL_CMS_PATH . '/components/content-list/class-content-list.php';
require_once CIVIL_CMS_PATH . '/components/content-item/class-content-item.php';
require_once CIVIL_CMS_PATH . '/components/image/class-image.php';

// Extended Components.
require_once CIVIL_CMS_PATH . '/components/article-body/class-article-body.php';
require_once CIVIL_CMS_PATH . '/components/article-grid/class-article-grid.php';
require_once CIVIL_CMS_PATH . '/components/article-header/class-article-header.php';
require_once CIVIL_CMS_PATH . '/components/article-footer/class-article-footer.php';
require_once CIVIL_CMS_PATH . '/components/article-bylines/class-article-bylines.php';
require_once CIVIL_CMS_PATH . '/components/article-taxonomies/class-article-taxonomies.php';
require_once CIVIL_CMS_PATH . '/components/body-content/class-body-content.php';
require_once CIVIL_CMS_PATH . '/components/call-to-action/class-call-to-action.php';
require_once CIVIL_CMS_PATH . '/components/civil-footer/class-civil-footer.php';
require_once CIVIL_CMS_PATH . '/components/civil-header/class-civil-header.php';
require_once CIVIL_CMS_PATH . '/components/credibility-indicators/class-credibility-indicators.php';
require_once CIVIL_CMS_PATH . '/components/featured-articles/class-featured-articles.php';
require_once CIVIL_CMS_PATH . '/components/featured-articles-widget/class-featured-articles-widget.php';
require_once CIVIL_CMS_PATH . '/components/iframe/class-iframe.php';
require_once CIVIL_CMS_PATH . '/components/image/class-image.php';
require_once CIVIL_CMS_PATH . '/components/logo/class-logo.php';
require_once CIVIL_CMS_PATH . '/components/newsroom-footer/class-newsroom-footer.php';
require_once CIVIL_CMS_PATH . '/components/newsroom-header/class-newsroom-header.php';
require_once CIVIL_CMS_PATH . '/components/page-body/class-page-body.php';
require_once CIVIL_CMS_PATH . '/components/page-header/class-page-header.php';
require_once CIVIL_CMS_PATH . '/components/subscribe-button/class-subscribe-button.php';
require_once CIVIL_CMS_PATH . '/components/search-form/class-search-form.php';
require_once CIVIL_CMS_PATH . '/components/error-page/class-error-page.php';
require_once CIVIL_CMS_PATH . '/components/gallery/class-gallery.php';

/**
 * Helpers
 */
require_once CIVIL_CMS_PATH . '/inc/helpers/landing-page.php';
require_once CIVIL_CMS_PATH . '/inc/helpers/multisite.php';

// Admin customizations.
if ( is_admin() ) {
	require_once CIVIL_CMS_PATH . '/inc/admin.php';
}

// wp-cli command.
if ( WP_Utils::wp_cli() ) {
	require_once CIVIL_CMS_PATH . '/inc/cli.php';
}

// Ad integrations.
require_once CIVIL_CMS_PATH . '/inc/ads.php';

// Ajax.
require_once CIVIL_CMS_PATH . '/inc/ajax.php';

// Include classes used to integrate with external APIs.
require_once CIVIL_CMS_PATH . '/inc/api.php';

// Manage static assets (js and css).
require_once CIVIL_CMS_PATH . '/inc/assets.php';

// Authors.
require_once CIVIL_CMS_PATH . '/inc/authors.php';

// Cache.
require_once CIVIL_CMS_PATH . '/inc/cache.php';

// Include comments.
require_once CIVIL_CMS_PATH . '/inc/comments.php';

// Customizer additions.
require_once CIVIL_CMS_PATH . '/inc/customizer.php';

// This site's RSS, Atom, JSON, etc. feeds.
require_once CIVIL_CMS_PATH . '/inc/feeds.php';

// Gutenberg.
require_once CIVIL_CMS_PATH . '/inc/gutenberg.php';

// Jetpack.
require_once CIVIL_CMS_PATH . '/inc/jetpack.php';

// Media includes.
require_once CIVIL_CMS_PATH . '/inc/media.php';

// Navigation & Menus.
require_once CIVIL_CMS_PATH . '/inc/nav.php';

// oEmbed: How posts look when oEmbedded elsewhere.
require_once CIVIL_CMS_PATH . '/inc/oembed.php';

// Pico.
require_once CIVIL_CMS_PATH . '/inc/pico.php';

// Query modifications and manipulations.
require_once CIVIL_CMS_PATH . '/inc/query.php';

// Rewrites.
require_once CIVIL_CMS_PATH . '/inc/rewrites.php';

// Search.
require_once CIVIL_CMS_PATH . '/inc/search.php';

// SEO.
require_once CIVIL_CMS_PATH . '/inc/seo.php';

// Shortcodes.
require_once CIVIL_CMS_PATH . '/inc/shortcodes.php';

// Include sidebars and widgets.
require_once CIVIL_CMS_PATH . '/inc/sidebars.php';

// Helpers.
require_once CIVIL_CMS_PATH . '/inc/template-tags.php';

// Theme setup.
require_once CIVIL_CMS_PATH . '/inc/theme.php';

// Users.
require_once CIVIL_CMS_PATH . '/inc/users.php';

// Zoninator zones/customizations.
require_once CIVIL_CMS_PATH . '/inc/zones.php';

// Loader for stylesheets.
require_once CIVIL_CMS_PATH . '/inc/stylesheets/stylesheets.php';

// Loader for partials.
require_once CIVIL_CMS_PATH . '/inc/partials/partials.php';

// Template loader.
require_once CIVIL_CMS_PATH . '/inc/class-wrapping.php';

// Content types and taxonomies should be included below. In order to scaffold
// them, leave the Begin and End comments in place.
/* Begin Data Structures */

// Fieldmanager Fields.
require_once CIVIL_CMS_PATH . '/inc/fields.php';

// Post Type Base Class.
require_once CIVIL_CMS_PATH . '/inc/post-types/class-civil-cms-post-type.php';

// Landing Pages Post Type (cpt:landing-page).
require_once CIVIL_CMS_PATH . '/inc/post-types/class-civil-cms-post-type-landing-page.php';

/* End Data Structures */
