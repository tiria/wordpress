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

	$smallerImage = ( ' masonry-container' == $blogLayout ) ? ( 'mobile-' ) : ( '' );
	$imageSize    = ( wm_option( 'general-post-image-ratio' ) ) ? ( $smallerImage . wm_option( 'general-post-image-ratio' ) ) : ( 'ratio-169' );

	if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
		echo wm_thumb( array( 'size' => 'content-width' ) );
	elseif ( ! is_single() )
		echo wm_thumb( array( 'size' => $imageSize, 'link' => get_permalink() ) );
	?>

	<?php
	if ( ! is_single() )
		wm_heading( 'list' );

	$positions = array(
		'author',
		'cats',
		'comments',
		);
	wm_meta( $positions );
	?>

	<?php
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