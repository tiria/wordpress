<?php
$positions = array(
	'date-special',
	'formaticon',
	);
wm_meta( $positions, 'date-special' );
?>

<div <?php post_class( 'article-content' ); ?>>
	<?php
	global $blogLayout;

	$link = trim( get_post_meta( get_the_ID(), '_format_link_url', true ) );
	if ( ! $link )
		$link = ( wm_meta_option( 'link-url' ) ) ? ( wm_meta_option( 'link-url' ) ) : ( '#' );

	$newWindow = ( wm_meta_option( 'link-target' ) ) ? ( ' target="_blank"' ) : ( null );
	$tag       = ( is_single() ) ? ( 'h2' ) : ( 'h3' );

	$smallerImage = ( ' masonry-container' == $blogLayout ) ? ( 'mobile-' ) : ( '' );
	$imageSize    = ( wm_option( 'general-post-image-ratio' ) ) ? ( $smallerImage . wm_option( 'general-post-image-ratio' ) ) : ( $smallerImage . 'ratio-169' );

	if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
		echo wm_thumb( array( 'size' => 'content-width', 'link' => esc_url( $link ), 'a-attributes' => ' target="_blank"' ) );
	elseif ( ! is_single() )
		echo wm_thumb( array( 'size' => $imageSize, 'link' => get_permalink() ) );
	?>

	<?php
	if ( ! is_single() )
		wm_heading( 'list' );
	?>

	<<?php echo $tag; ?> class="link">
		<strong><?php _e( 'Link:', 'clifden_domain' ); ?></strong> <a href="<?php echo esc_url( $link ); ?>"<?php echo $newWindow; ?>><?php echo $link; ?></a>
	</<?php echo $tag; ?>>

	<?php
	if ( '#' === $link )
		echo do_shortcode( '[box color="red" icon="warning"]' . __( 'Please set the URL address of the link', 'clifden_domain' ) . '[/box]' );

	$positions = array(
		'author',
		'cats',
		'comments',
		);
	wm_meta( $positions );

	if ( is_single() || wm_option( 'blog-full-posts' ) ) {
		if ( has_excerpt() && ! post_password_required() )
			echo '<div class="article-excerpt">' . apply_filters( 'wm_default_content_filters', get_the_excerpt() ) . '</div>';

		//wm_meta( array( 'sharing' ), 'sharing-post-start' );

		the_content();

		wm_end_post();
	} else {
		echo wm_content_or_excerpt( $post );
	}
	?>
</div>

<?php
wm_before_bottom_meta();

if ( is_single() )
	wm_meta( array( 'sharing' ), 'meta-bottom' );

if ( is_single() )
	wm_meta( array( 'tags' ), 'meta-bottom' );

?>