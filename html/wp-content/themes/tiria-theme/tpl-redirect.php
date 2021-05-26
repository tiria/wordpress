<?php
/*
Template Name: Redirect
*/
$redirectPage   = wm_meta_option( 'redirect-page' );
$redirectPageID = wm_page_slug_to_id( $redirectPage );

if ( wm_meta_option( 'redirect-link' ) )
	$link = esc_url( wm_meta_option( 'redirect-link' ) );
elseif ( $redirectPageID )
	$link = get_permalink( $redirectPageID );
else
	$link = '';

if ( $link ) {
	wp_redirect( $link, wm_meta_option( 'redirect-status' ) );
	exit;
}

get_header();
?>
<div class="wrap-inner">

<article class="main twelve pane">

	<div class="article-content">
		<?php echo do_shortcode( '[box color="red" icon="warning"]' . __( 'Please, set the URL first.', 'clifden_domain' ) . '[/box]' ); ?>
	</div>

</article> <!-- /main -->

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>