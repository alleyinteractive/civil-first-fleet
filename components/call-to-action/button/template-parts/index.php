<?php
/**
 * Template part for displaying a cta button.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

use function \WP_Render\{get_component, get_config};

$component = get_component();

printf(
	'<%1$s class="%2$s">%3$s</%1$s>',
	esc_attr( $component->get_tag() ),
	esc_attr( ai_get_classnames( $component->get_classnames(), [], 'cta-button' ) ),
	esc_html( get_config( 'label' ) )
);
