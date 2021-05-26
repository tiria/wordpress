<?php
get_header();

$sidebarLayout = WM_SIDEBAR_DEFAULT_POSITION;

if ( is_active_sidebar( WM_SIDEBAR_FALLBACK ) ) {
	$sidebarPanes = ( wm_option( 'layout-sidebar-width' ) ) ? ( esc_attr( wm_option( 'layout-sidebar-width' ) ) ) : ( WM_SIDEBAR_WIDTH );

	if ( ' four pane' === $sidebarPanes )
		$mainPanes = ' eight pane';
	elseif ( ' three pane' === $sidebarPanes )
		$mainPanes = ' nine pane';
	else
		$mainPanes = ' seven pane';
} else {
	$mainPanes    = ' twelve pane';
	$sidebarPanes = '';
}
?>
<div class="wrap-inner">

<article class="main<?php echo $mainPanes; ?>">

	<?php wm_start_main_content(); ?>

	<?php get_template_part( 'inc/loop/loop', 'attachment' ); ?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes;

	wm_sidebar( 'default', $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>