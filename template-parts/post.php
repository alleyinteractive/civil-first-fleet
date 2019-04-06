<?php
/**
 * Post Template.
 *
 * @package Civil_First_Fleet
 */

$credibility_indicators = (array) get_post_meta( get_the_ID(), 'credibility_indicators', true );
$sticky_cta             = ( new Civil_First_Fleet\Component() )->get_option( 'newsroom-settings', 'newsletter', 'sticky_call_to_action' );

// Get indicators for this post (keys only).
$post_indicators = array_filter( $credibility_indicators );
?>

<div class="<?php ai_the_classnames( [ 'wrapper' ], [ 'no-indicators' => empty( $post_indicators ) ] ); ?>">
	<?php
	// Output sponsor.
	$category_id = absint( get_post_meta( get_the_ID(), 'primary_category_id', true ) );
	$schedules   = array_filter( (array) get_term_meta( $category_id, 'sponsorship', true ) );
	\WP_Render\render(
		( new Civil_First_Fleet\Components\Sponsor() )
			->parse_from_schedule_fm_data( $schedules['schedules'] ?? [] )
			->set_config( 'theme', 'article' )
	);

	// Output Article Header.
	\Civil_First_Fleet\Component\article_header()
		->set_post_id( get_the_ID() )
		->render();

	// Output Article Body.
	\Civil_First_Fleet\Component\article_body()
		->set_post_id( get_the_ID() )
		->render();
	?>
</div>

<div class="<?php ai_the_classnames( [ 'comments-wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'comments-inner' ] ); ?>">
		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	</div>
</div>

<?php
/**
 * Render related posts from Jetpack.
 */
\Civil_First_Fleet\Component\article_grid()
	->load_jetpack_related_posts( 3, get_the_ID() )
	->set_setting( 'load_more', false )
	->render();

// Show sticky CTA if turned on.
if ( (bool) $sticky_cta['enable'] ?? false ) :
	\Civil_First_Fleet\Component\call_to_action()
		->set_setting( $sticky_cta['settings'] ?? [] )
		->set_setting( 'layout', 'sticky' )
		->set_data( $sticky_cta['data'] ?? [] )
		->set_data( 'type', 'newsletter' )
		->set_data( 'context', 'sticky-cta' )
		->render();
endif;
