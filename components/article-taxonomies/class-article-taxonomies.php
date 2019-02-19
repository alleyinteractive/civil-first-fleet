<?php
/**
 * Article Taxonomies component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS\Component;

/**
 * Article Taxonomies component class.
 */
class Article_Taxonomies extends \Civil_CMS\Component {

	/**
	 * Unique component slug.
	 *
	 * @var string
	 */
	public $slug = 'article-taxonomies';

	/**
	 * Default component settings.
	 *
	 * @return array Default settings.
	 */
	public function default_settings() : array {
		return array(
			'tags' => array(
				'enable' => true,
				'label'  => __( 'This story is tagged in:', 'civil-cms' ),
				'hide_tags_prefixed_with_underscore' => true,
			),
			'categories'  => array(
				'enable' => false,
				'label'  => __( 'This story is categorized in:', 'civil-cms' ),
				'hide_categories_prefixed_with_underscore' => true,
			),
		);
	}

	/**
	 * Default component data.
	 *
	 * By default no taxonomy data (neither categories nor tags) is returned.
	 *
	 * @return array Default data.
	 */
	public function default_data() : array {
		return [];
	}

	/**
	 * Component Fieldmanager fields.
	 *
	 * @return array Fieldmanager fields.
	 */
	public function default_fm_fields() : array {
		// Add the 'Enabled' checkbox to the front of the list of fields.
		return [
			'tags' => new \Fieldmanager_Group(
				[
					'label' => __( 'Tags', 'civil-cms' ),
					'children' => [
						'enable' => new \Fieldmanager_Checkbox(
							__( 'Show a list of assigned tags in the article footer.', 'civil-cms' )
						),
						'label' => new \Fieldmanager_TextField(
							[
								'label'         => __( 'Label', 'civil-cms' ),
								'default_value' => __( 'This story is tagged in:', 'civil-cms' ),
								'display_if' => [
									'src'   => 'enable',
									'value' => true,
								],
							]
						),
						'hide_tags_prefixed_with_underscore' => new \Fieldmanager_Checkbox(
							[
								'label' => __( 'Don’t show tags that start with _ (an underscore).', 'civil-cms' ),
								'display_if' => [
									'src'   => 'enable',
									'value' => true,
								],
							]
						),
					],
				]
			),
			'categories' => new \Fieldmanager_Group(
				[
					'label' => __( 'Categories', 'civil-cms' ),
					'children' => [
						'enable' => new \Fieldmanager_Checkbox(
							__( 'Show a list of assigned categories in the article footer.', 'civil-cms' )
						),
						'label' => new \Fieldmanager_TextField(
							[
								'label'         => __( 'Label', 'civil-cms' ),
								'default_value' => __( 'This story is categorized in:', 'civil-cms' ),
								'display_if' => [
									'src'   => 'enable',
									'value' => true,
								],
							]
						),
						'hide_categories_prefixed_with_underscore' => new \Fieldmanager_Checkbox(
							[
								'label' => __( 'Don’t show categories that start with _ (an underscore).', 'civil-cms' ),
								'display_if' => [
									'src'   => 'enable',
									'value' => true,
								],
							]
						),
					],
				]
			),
		];
	}

	/**
	 * Before render, gather the list of terms in the requested taxonomy and
	 * filter it if necessary.
	 */
	public function pre_render() {
		$taxonomy = $this->get_data( 'taxonomy' );
		$hide_tags_prefixed_with_underscore = (bool) $this->get_setting( 'hide_tags_prefixed_with_underscore' ) ?? true;
		$hide_categories_prefixed_with_underscore = (bool) $this->get_setting( 'hide_categories_prefixed_with_underscore' ) ?? true;

		// Get the terms in the requested taxonomy.
		$terms = wp_get_post_terms( $this->get_data( 'post_id' ), $taxonomy );
		if ( $terms instanceof \WP_Error ) {
			$this->set_data( 'terms', [] );
			return;
		}

		// Remove any tags prefixed with an underscore.
		if ( 'post_tag' === $taxonomy && true === $hide_tags_prefixed_with_underscore ) {
			foreach ( $terms as $key => $term ) {
				if ( '_' === substr( $term->name, 0, 1 ) ) {
					unset( $terms[ $key ] );
				}
			}
		}

		// Remove any categories prefixed with an underscore.
		if ( 'category' === $taxonomy && true === $hide_categories_prefixed_with_underscore ) {
			foreach ( $terms as $key => $term ) {
				if ( '_' === substr( $term->name, 0, 1 ) ) {
					unset( $terms[ $key ] );
				}
			}
		}

		// Remove the 'Uncategorized' category.
		if ( 'category' === $taxonomy ) {
			foreach ( $terms as $key => $term ) {
				if ( 'Uncategorized' === $term->name ) {
					unset( $terms[ $key ] );
				}
			}
		}

		// Set the list of terms.
		$this->set_data( 'terms', $terms );
	}
}

/**
 * Helper for creating new instances of this component.
 *
 * @param  array $settings Instance settings.
 * @param  array $data     Instance data.
 * @param  array $fm_fields Fieldmanager fields for this component.
 * @return Featured_Articles  An instance of this component.
 */
function article_taxonomies( array $settings = array(), array $data = array(), array $fm_fields = array() ) : Article_Taxonomies {
	return new Article_Taxonomies( $settings, $data );
}
