<?php
/**
 * Template file for Civil SCG logo.
 *
 * @package Civil_First_Fleet
 */

// Echo this, otherwise PHP could read `<?` as an opening tag.
echo '<?xml version="1.0" encoding="UTF-8"?>';

$version = ai_get_var( 'version', 'white' );
if ( 'white' === $version ) {
	$fill = '#FFFFFF';
} else {
	$fill = '#000000';
}
?>
<svg xmlns="http://www.w3.org/2000/svg" width="54" height="14" viewBox="0 0 54 14">
	<path fill="<?php echo esc_attr( $fill ); ?>" fill-rule="nonzero" d="M0 7c0-4.031 3.107-7 7.027-7 2.552 0 4.327.99 5.51 2.639l-1.664 1.173c-.924-1.21-2.07-1.87-3.92-1.87-2.737 0-4.734 2.163-4.734 5.058 0 2.969 2.034 5.058 4.808 5.058 1.775 0 3.107-.66 4.142-1.98l1.664 1.137C11.428 13.084 9.616 14 6.953 14 3.07 14 0 11.031 0 7zm16.917-7h2.333v14h-2.333V0zm5.25 0h2.301l3.935 9.26L32.227 0h2.19L28.44 14h-.111L22.167 0zm15.75 0h2.333v14h-2.333V0zm7 0h2.16v12.043h6.006V14h-8.166V0z"/>
</svg>
