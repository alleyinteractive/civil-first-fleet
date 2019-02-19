<?php
/* The brackets ensure that `?>` doesn't kill the trailing newline */
?>
[Item <?php echo esc_html( ai_get_var( 'index' ) ) ?>: <?php echo esc_html( ai_get_var( 'item' ) ) ?>]
