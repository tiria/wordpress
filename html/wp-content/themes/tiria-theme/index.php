<?php
get_header();

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

if ( is_archive() && wm_option( 'blog-archive-no-sidebar' ) )
	$mainPanes = ' twelve pane';
?>
<div class="wrap-inner">

<section class="main<?php echo $mainPanes; ?>">

	<?php
	wm_start_main_content();

	$catDesc = category_description();
	if ( ! empty( $catDesc ) )
		echo '<div class="cat-desc">' . apply_filters( 'the_content', category_description() ) . '</div>';

	if ( is_author() )
		wm_author_info();
	?>

	<?php get_template_part( 'inc/loop/loop', 'index' ); ?>

</section> <!-- /main -->

<?php
$class = 'sidebar clearfix sidebar-right' . $sidebarPanes;

wm_sidebar( WM_SIDEBAR_FALLBACK, $class );
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>