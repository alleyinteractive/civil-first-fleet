<?php
/**
 * Template part for displaying the load more button for content lists.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_First_Fleet;

// Get this instance.
$component = ai_get_var( 'component' );
?>

<div class="<?php ai_the_classnames( [ 'more-button-wrapper' ] ); ?>">
	<button class="<?php ai_the_classnames( [ 'load-more-button', 'button-secondary-light' ] ); ?>"><?php esc_html_e( 'More Stories', 'civil-first-fleet' ); ?></button>
</div>
