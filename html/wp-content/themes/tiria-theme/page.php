<?php get_header(); ?>
<div class="wrap-inner">

<?php
//check whether current user can display the page
$allowed = ( wm_option( 'general-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
if ( $allowed ) {
	$sidebarLayout   = ( wm_meta_option( 'layout' ) ) ? ( wm_meta_option( 'layout' ) ) : ( WM_SIDEBAR_DEFAULT_POSITION );
	$overrideSidebar = ( wm_meta_option( 'sidebar' ) && -1 != wm_meta_option( 'sidebar' ) ) ? ( wm_meta_option( 'sidebar' ) ) : ( WM_SIDEBAR_FALLBACK );

	if ( is_active_sidebar( $overrideSidebar ) && 'none' != $sidebarLayout ) {
		$sidebarPanes = ( wm_option( 'layout-sidebar-width' ) ) ? ( esc_attr( wm_option( 'layout-sidebar-width' ) ) ) : ( WM_SIDEBAR_WIDTH );

		if ( ' four pane' === $sidebarPanes )
			$mainPanes = ' eight pane';
		elseif ( ' three pane' === $sidebarPanes )
			$mainPanes = ' nine pane';
		else
			$mainPanes = ' seven pane';

		if ( 'left' == $sidebarLayout )
			$mainPanes = ' sidebar-left margin-right' . $mainPanes;
	} else {
		$mainPanes    = ' twelve pane';
		$sidebarPanes = '';
	}
?>

<article class="main<?php echo $mainPanes; ?>">

	<?php wm_start_main_content(); ?>

	<?php get_template_part( 'inc/loop/loop', 'singular' ); ?>

	<?php
	if ( wm_option( 'social-share-pages' ) )
		wm_meta( array( 'sharing' ), 'project-sharing' );
	?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes;

	wm_sidebar( $overrideSidebar, $class );
}
?>

<?php
} else {
	echo do_shortcode( WM_MSG_ACCESS_DENIED );
	wm_sidebar( 'access-denied', 'widgets columns twelve pane', 5 );
} // /check whether current user can display the page
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>