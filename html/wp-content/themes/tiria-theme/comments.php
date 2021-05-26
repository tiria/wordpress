<?php
if ( post_password_required() )
	return;

if ( ( comments_open() || have_comments() ) && ! is_attachment() ) {

	if ( is_page_template( 'tpl-sections.php' ) ) {
		echo '<section class="wrap-section section-comments"><div class="wrap-inner"><div class="twelve pane">';
	}
?>
<div id="comments">

<?php
//Do not delete these lines
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );
?>

	<h2 id="comments-title">
	<?php echo apply_filters( 'wmhook_comments_title', sprintf( __( 'Comments (%s)', 'clifden_domain' ), get_comments_number() ) ); ?>
	</h2>

<?php
if ( comments_open() && 'desc' == get_option( 'comment_order' ) ) {
	//Comments form
	if ( ! file_exists( get_stylesheet_directory() . '/library/options/a-comments-form.php' ) )
		require_once( WM_OPTIONS . 'a-comments-form.php' );
	else
		require_once( get_stylesheet_directory() . '/library/options/a-comments-form.php' );

	comment_form( $commentFormArgs );
}
?>

<?php
if ( have_comments() ) :
?>
	<?php if ( ! comments_open() ) echo apply_filters( 'wmhook_comments_closed_html', '<h3 class="comments-closed">' . __( 'Comments are closed. You can not add new comments.', 'clifden_domain' ) . '</h3>' ); ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { //are there comments to navigate through ?>
	<nav id="comment-nav-above" class="comments-nav">
		<h3 class="assistive-text invisible"><?php _e( 'Comment navigation', 'clifden_domain' ); ?></h3>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older comments', 'clifden_domain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer comments &rarr;', 'clifden_domain' ) ); ?></div>
	</nav>
	<?php } ?>

	<ol class="commentlist">
		<?php
		wp_list_comments( array(
			'type' => 'comment',
			'callback' => 'wm_comment'
			) );
		?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { //are there comments to navigate through ?>
	<nav id="comment-nav-below" class="comments-nav">
		<h3 class="assistive-text invisible"><?php _e( 'Comment navigation', 'clifden_domain' ); ?></h3>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older comments', 'clifden_domain' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer comments &rarr;', 'clifden_domain' ) ); ?></div>
	</nav>
	<?php } ?>

<?php
endif;

if ( have_comments() )
	wm_pings()
?>

<?php
if ( comments_open() && 'desc' != get_option( 'comment_order' ) ) {
	//Comments form
	if ( ! file_exists( get_stylesheet_directory() . '/library/options/a-comments-form.php' ) )
		require_once( WM_OPTIONS . 'a-comments-form.php' );
	else
		require_once( get_stylesheet_directory() . '/library/options/a-comments-form.php' );

	comment_form( $commentFormArgs );
}
?>

</div><!-- #comments -->
<?php
	if ( is_page_template( 'tpl-sections.php' ) ) {
		echo '</div></div></section>';
	}

} // /if comments open or have comments
?>