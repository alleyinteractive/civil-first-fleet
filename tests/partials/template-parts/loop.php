<?php
/* The brackets ensure that PHP doesn't kill the newline */
?>
[Parent loop post <?php echo esc_html( ai_get_var( 'index' ) ) ?>: <?php the_ID() ?>]
<?php ai_loop_template_part( ai_get_var( 'child_query' ), '_post' ); ?>
