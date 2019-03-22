<?php
/**
 * Template part for displaying the Search Form component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component      = ai_get_var( 'component' );
$search_query   = $component->get_data( 'search_query' );
$include_button = $component->get_data( 'include_button' );
$context        = $component->get_data( 'context' );

// Make the input field ID unique if we've been provided a context.
$search_input_id = $context ? 'search-input-' . $context : 'search-input';

?>

<form action="/" class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>" name="search-form" aria-role="search">
	<label class="<?php ai_the_classnames( [ 'label' ] ); ?>" for="search-input">
		<?php esc_html_e( 'Search', 'civil-first-fleet' ); ?>
	</label>

	<input
		class="<?php ai_the_classnames( [ 'input' ] ); ?>"
		value="<?php echo esc_attr( $search_query ); ?>"
		id="<?php echo sanitize_html_class( $search_input_id ); ?>"
		type="search"
		autocorrect="off"
		autocapitalize="off"
		spellcheck="false"
		name="s"
		placeholder="<?php printf( 'Search %1$s', esc_attr( get_bloginfo( 'name' ) ) ); ?>"
	>

	<?php if ( $include_button ) { ?>
		<input
			class="<?php ai_the_classnames( [ 'submit' ] ); ?>"
			type="submit"
			value="<?php echo esc_attr__( 'Search', 'civil-first-fleet' ); ?>">
	<?php } ?>
</form>
