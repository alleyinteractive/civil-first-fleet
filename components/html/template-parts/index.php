<?php
/**
 * Template for the HTML component.
 *
 * @package Civil_First_Fleet
 */

echo wp_kses_post( \WP_Render\get_config( 'content' ) );
