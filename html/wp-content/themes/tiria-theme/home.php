<?php
/*
Template Name: Blog
*/

get_header();
?>
<div class="wrap-inner">

<?php
//check whether current user can display the page
$allowed = ( wm_option( 'general-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
if ( is_home() )
	$allowed = wm_restriction_page( get_option( 'page_for_posts' ) );
if ( $allowed ) {
	$postId          = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
	$sidebarLayout   = ( wm_meta_option( 'layout', $postId ) ) ? ( wm_meta_option( 'layout', $postId ) ) : ( WM_SIDEBAR_DEFAULT_POSITION );
	$overrideSidebar = ( wm_meta_option( 'sidebar', $postId ) && -1 != wm_meta_option( 'sidebar', $postId ) ) ? ( wm_meta_option( 'sidebar', $postId ) ) : ( WM_SIDEBAR_FALLBACK );

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

<section class="main clearfix<?php echo $mainPanes; ?>">

	<?php
	wm_start_main_content();

	//Blog page content
	if ( 2 > $paged ) {
		$blogPage = get_post( $postId );
		$content  = $blogPage->post_content;
		$content  = apply_filters( 'the_content', $content );
		$content  = str_replace( ']]>', ']]&gt;', $content );

		if ( is_home() && ! $postId )
			$content = null;

		if ( $content ) {
			echo '<div class="article-content">' . $content . '</div>';
			wm_after_post();
		}
	}
	?>

	<!-- BLOG ENTRIES -->
	<?php
	//Blog posts list
	$loopType = ( is_page_template( 'home.php' ) && ! is_home() ) ? ( 'blogpage' ) : ( 'index' );
	get_template_part( 'inc/loop/loop', $loopType );
	?>

</section> <!-- /main -->

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