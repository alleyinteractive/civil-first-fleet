<?php
/**
 * Template part for displaying the Featured Articles component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Get Content Items for this component.
$articles = (array) $component->get_content_items();
if ( empty( $articles ) ) {
	return;
}

// Get first content item as the featured article.
$featured_article = array_shift( $articles );

// Setup title.
$title = $component->get_data( 'meta', 'title' );
if ( empty( $title ) ) {
	$title = __( 'Top Stories', 'civil-first-fleet' );
}

// Determine if this component has a call to action.
$call_to_action = $component->get_data( 'meta', 'call_to_action' );

// Hide sidebar?
$hide_sidebar = (bool) $component->get_data( 'meta', 'hide_sidebar' );

// Show avatars in byline?
$show_avatar = (bool) $component->get_data( 'show_avatar' ) ?? false;
?>

<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'featured-article' ], [ 'single' => $hide_sidebar ] ); ?>">
		<?php
		// Get the first article and output as a `large-feature`.
		$featured_article->set_setting( 'layout', 'large-feature' )->render();

		// Display the sponsor.
		$sponsorship = (array) $component->get_data( 'meta', 'sponsorship' );
		if ( ! empty( $sponsorship ) ) {
			\WP_Render\render(
				( new \Civil_First_Fleet\Components\Sponsor() )
					->parse_from_schedule_fm_data( $sponsorship['schedules'] ?? [] )
					->set_config( 'theme', 'featured-article' )
			);
		}
		?>
	</div>
	<?php if ( ! $hide_sidebar ) : ?>
		<div class="<?php ai_the_classnames( [ 'feature-list' ] ); ?>">
			<h2 class="<?php ai_the_classnames( [ 'list-headline' ] ); ?>"><?php echo esc_html( $title ); ?></h2>
			<div class="articles">
				<?php
				foreach ( $articles as $article ) {
					$article
						->set_setting( 'layout', 'river' )
						->set_setting( 'show_avatar', $show_avatar )
						->render();
				}
				?>
			</div>
			<?php if ( isset( $call_to_action['enable'] ) && true === (bool) $call_to_action['enable'] ) : ?>
				<div class="call-to-action">
					<?php
					\Civil_First_Fleet\Component\call_to_action()
						->set_setting( $call_to_action['settings'] )
						->set_data( $call_to_action['data'] )
						->set_data( 'location', 'river' )
						->set_data( 'context', 'featured' )
						->render();
					?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</section>
