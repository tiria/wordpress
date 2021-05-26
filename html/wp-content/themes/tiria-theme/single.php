<?php
if ( wm_option( 'general-staff-rich' ) )
	$redirectToHome = array( 'wm_logos', 'wm_slides', 'wm_modules', 'wm_faq', 'wm_price' );
else
	$redirectToHome = array( 'wm_logos', 'wm_slides', 'wm_modules', 'wm_faq', 'wm_price', 'wm_staff' );

if ( in_array( get_post_type( $post->ID ), $redirectToHome ) ) {
	wp_redirect( home_url(), 301 );
	exit;
}

get_header();

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
<div class="wrap-inner">

<article class="main<?php echo $mainPanes; ?>">

	<?php wm_start_main_content(); ?>

	<?php
	if ( 'wm_staff' == get_post_type( $post->ID ) )
		get_template_part( 'inc/loop/loop', 'staff' );
	else
		get_template_part( 'inc/loop/loop', 'singular' );
	?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes;

	wm_sidebar( $overrideSidebar, $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>