<?php
/* The brackets ensure that `?>` doesn't kill the newline */
?>
[Parent loaded: <?php echo esc_html( ai_get_var( 'custom_var', 'successfully' ) ) ?>]
<?php ai_get_template_part( '_child', [ 'custom_var' => ai_get_var( 'child_var', 'successfully' ) ] ); ?>
