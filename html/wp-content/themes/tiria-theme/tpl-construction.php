<?php
/*
Template Name: Under construction
*/

get_header();
?>

<section class="countdown-timer-wrap">
<div class="wrap-inner">

	<?php
	if ( wm_meta_option( 'construction-date' ) )
		echo do_shortcode( '[countdown time="' . ( wm_meta_option( 'construction-date' ) . ' ' . wm_meta_option( 'construction-time' ) ) . '" /]' );
	?>

	<?php
		if ( wm_meta_option( 'construction-timer-widgets' ) && is_active_sidebar( wm_meta_option( 'construction-timer-widgets' ) ) ) {
			echo '<div class="timer-widgets-wrap clearfix">';
			wm_sidebar( wm_meta_option( 'construction-timer-widgets' ), 'widgets columns twelve pane', 5 ); //restricted to 5 widgets
			echo '</div>';
		}
	?>

</div> <!-- /wrap-inner -->
</section>

<div class="wrap-inner">

<article class="main twelve pane">

	<?php wm_start_main_content(); ?>

	<?php get_template_part( 'inc/loop/loop', 'singular' ); ?>

</article> <!-- /main -->

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>