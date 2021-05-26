<?php wm_after_main_content(); ?>

<!-- /content --></div>


<?php
//widget area variables
$aboveFooter = 'above-footer-widgets';
$footerRow1  = 'footer1-widgets';
$footerRow2  = 'footer2-widgets';
$pageId      = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

if ( is_page_template( 'tpl-landing.php' ) ) {
	$aboveFooter = wm_meta_option( 'landing-above-footer-widgets' );
	$footerRow1  = wm_meta_option( 'landing-footer1-widgets' );
	$footerRow2  = wm_meta_option( 'landing-footer2-widgets' );
}
if ( is_page_template( 'tpl-construction.php' ) )
	$aboveFooter = $footerRow1 = $footerRow2 = null;
if ( is_404() && wm_option( 'p404-no-above-footer-widgets' ) )
	$aboveFooter = null;

if ( $aboveFooter && is_active_sidebar( $aboveFooter ) && ! wm_meta_option( 'no-above-footer-widgets', $pageId ) ) {
	echo '<section class="above-footer-widgets-wrap' . wm_option( 'design-abovefooter-icons' ) . '"><div class="wrap-inner">';
	wm_sidebar( $aboveFooter, 'widgets columns twelve pane', 5 ); //no restriction
	echo '</div></section>';
}

wm_before_footer();
?>

<footer id="footer" class="footer<?php echo wm_option( 'design-footer-icons' ); ?>">
<!-- FOOTER -->

<?php

if ( $footerRow1 && is_active_sidebar( $footerRow1 ) ) {
	echo '<section class="footer-widgets-wrap first"><div class="wrap-inner">';
	wm_sidebar( $footerRow1, 'widgets columns twelve pane', 5 ); //restricted to 5 widgets
	echo '</div></section>';
}

if ( $footerRow2 && is_active_sidebar( $footerRow2 ) ) {
	echo '<section class="footer-widgets-wrap second"><div class="wrap-inner">';
	wm_sidebar( $footerRow2, 'widgets columns twelve pane', 5 ); //restricted to 5 widgets
	echo '</div></section>';
}
?>

<section class="bottom-wrap<?php echo wm_option( 'design-bottom-icons' ); ?>"><div class="wrap-inner">
	<div class="twelve pane clearfix">

	<?php
	if ( is_page_template( 'tpl-landing.php' ) )
		$menuLocationName = 'menu-landing-page-' . get_the_ID();
	else
		$menuLocationName = 'footer-navigation';

	//Display "back to top" link in footer when footer breadcrums not used
	$topLink = ( 'top' === wm_option( 'layout-breadcrumbs' ) || 'none' === wm_option( 'layout-breadcrumbs' ) ) ? ( '<li class="has-top-link"><a href="#top" class="top-of-page" title="' . __( 'Back to top of page', 'clifden_domain' ) . '">' . __( 'Back to top', 'clifden_domain' ) . '</a></li>' ) : ( null );

	if ( ! is_page_template( 'tpl-construction.php' ) )
		wp_nav_menu( array(
				'theme_location'  => $menuLocationName,
				'menu'            => null,
				'container'       => null,
				'container_class' => null,
				'container_id'    => null,
				'menu_class'      => 'menu-footer',
				'menu_id'         => null,
				'echo'            => true,
				'fallback_cb'     => null,
				'before'          => null,
				'after'           => null,
				'link_before'     => null,
				'link_after'      => null,
				'items_wrap'      => '<div class="%2$s"><ul>%3$s' . $topLink . '</ul></div>',
				'depth'           => 1,
				'walker'          => ( has_nav_menu( $menuLocationName ) ) ? ( new wm_widget_walker() ) : ( null )
			) );

	$class = ( is_page_template( 'tpl-construction.php' ) ) ? ( 'text-center column col-11 no-margin' ) : ( '' );

	wm_credits( $class );
	?>

	</div>
</div></section> <!-- /bottom-wrap -->
<!-- /footer --></footer>

<?php wm_after_footer(); ?>
<!-- /wrapper --></div>

<!-- wp_footer() -->
<?php wp_footer(); //WordPress footer hook ?>
</body>

<?php if ( ! wm_option( 'general-website-author' ) ) echo '<!-- ' . wm_static_option( 'static-webdesigner' ) . ' -->'; ?>

</html>