<?php
/*
Template Name: Sections
*/

get_header();

//check whether current user can display the page
$allowed = ( wm_option( 'general-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
if ( $allowed ) {

	wm_start_main_content();

	get_template_part( 'inc/loop/loop', 'sections' );

} else {

	echo '<div class="wrap-inner"><article class="main twelve pane">';
	echo do_shortcode( WM_MSG_ACCESS_DENIED );
	wm_sidebar( 'access-denied', 'widgets columns twelve pane', 5 );
	echo '</article> <!-- /main --></div> <!-- /wrap-inner -->';

} // /check whether current user can display the page
?>

<?php get_footer(); ?>