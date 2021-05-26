<?php
$portfolioPage   = wm_option( 'layout-breadcrumbs-portfolio-page' );
$portfolioPageID = wm_page_slug_to_id( $portfolioPage );

if ( $portfolioPage )
	wp_redirect( get_permalink( $portfolioPageID ), 301 );
else
	wp_redirect( home_url(), 301 );

exit;
?>