<?php
/**
 * Template part for displaying the ZipRecruiter Jobs Block component.
 *
 * @package Civil_First_Fleet
 */

// Get this instance.
$component = ai_get_var( 'component' );

// Component is not enabled.
if ( ! wp_validate_boolean( $component->get_data( 'enable' ) ) ) {
	return;
}

// Setup title.
$title         = $component->get_data( 'settings', 'title' );
$per_page      = (int) $component->get_data( 'settings', 'per_page' );
$show_location = $component->get_data( 'settings', 'show_location' );
$show_salary   = $component->get_data( 'settings', 'show_salary' );
?>

<section class="<?php ai_the_classnames( [ 'wrapper' ] ); ?>">
	<div class="<?php ai_the_classnames( [ 'ziprecruiter-jobs-block' ] ); ?>">
		<h2 class="<?php ai_the_classnames( [ 'title' ] ); ?>"><?php echo esc_html( $title ); ?></h2>
		<?php
		$ziprecruiter_jobs_block = render_block(
			[
				'blockName'    => 'ziprecruiter-jobs/job-board',
				'attrs'        => [
					'per_page' => $per_page,
					'filters'  => [
						'location' => $show_location,
						'salary'   => $show_salary,
					],
				],
				'innerBlocks'  => [],
				'innerHTML'    => '',
				'innerContent' => [],
			]
		);

		echo $ziprecruiter_jobs_block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</section>
