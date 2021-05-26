<?php get_header(); ?>
<div class="wrap-inner">

<section class="main page-404 twelve pane">

	<?php wm_start_main_content(); ?>

	<article class="text-center">

		<img src="<?php echo esc_url( wm_option( 'p404-image' ) ); ?>" alt="<?php echo wm_option( 'p404-title' ); ?>" />

		<?php echo do_shortcode( wm_option( 'p404-text' ) ); ?>

	</article>

</section> <!-- /main -->

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>