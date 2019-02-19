<?php
/**
 * Archive routing.
 *
 * @package Civil_First_Fleet
 */

$queried_object = get_queried_object();
$modifier       = \Civil_First_Fleet\is_ajax_request() ? 'ajax' : '';
$template       = '404';

switch ( $queried_object ) {
	case $queried_object instanceof \WP_Term:
		$template = 'term';
		break;

	case $queried_object instanceof \WP_User:
	case 'guest-author' === ( $queried_object->type ?? '' ):
		$template = 'user';
		break;

	default:
		echo 'Unknown template';
}

ai_get_template_part(
	"template-parts/{$template}",
	$modifier,
	[
		'stylesheet' => $template . '-archive',
	]
);
