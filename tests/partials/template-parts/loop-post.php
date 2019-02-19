<?php
/* The brackets ensure that `?>` doesn't kill the trailing newline */
?>
[Post <?php echo esc_html( ai_get_var( 'index' ) ) ?>: <?php the_ID() ?>]
