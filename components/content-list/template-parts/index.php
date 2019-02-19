<?php
/**
 * Template part for displaying an invalid layout Content List component.
 *
 * @package Civil_First_Fleet
 */

namespace Civil_CMS;

// Get this instance.
$component = ai_get_var( 'component' );
?>

<div class="content-list">
	<?php $component->render_content_items(); ?>
</div>
