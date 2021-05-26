<?php
/*
Template Name: Sitemap
*/

get_header();
?>
<div class="wrap-inner">

<article class="main twelve pane">

	<?php wm_start_main_content(); ?>

	<?php get_template_part( 'inc/loop/loop', 'sitemap' ); ?>

</article> <!-- /main -->

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>