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
	$imageSize    = ( wm_option( 'general-post-image-ratio' ) ) ? ( $smallerImage . wm_option( 'general-post-image-ratio' ) ) : ( $smallerImage . 'ratio-169' );

	if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) && ! wm_meta_option( 'gallery-slider' ))
		echo wm_thumb( array( 'size' => 'content-width' ) );

	if ( ( is_single() && wm_meta_option( 'gallery-slider' ) ) || ! is_single() ) {
		$imagesArray = wm_get_post_images( $post->ID );
		$separator   = $links = '';
		$excluded    = ( ( 'exclude' == wm_meta_option( 'gallery' ) || 'excludedGallery' == wm_meta_option( 'gallery' ) ) && wm_meta_option( 'gallery-images' ) ) ? ( wm_meta_option( 'gallery-images' ) ) : ( array() );

		$sliderOut = '[slideshow images="';
		foreach ( $imagesArray as $image ) {
			if ( ! in_array( $image['id'], $excluded ) ) {
				$imageSize   = ( is_single() ) ? ( 'content-width' ) : ( $imageSize );
				$imageUrl    = wp_get_attachment_image_src( $image['id'], $imageSize );
				$fullImgSize = ( wm_option( 'general-lightbox-img' ) ) ? ( wm_option( 'general-lightbox-img' ) ) : ( 'full' );
				$fullImg     = wp_get_attachment_image_src( $image['id'], $fullImgSize, false );
				$sliderOut  .= $separator . $imageUrl[0];
				$links      .= ( ! is_single() ) ? ( $separator . get_permalink() ) : ( $separator . $fullImg[0] );
				$separator   = ', ';
			}
		}
		$sliderOut .= '" links="' . $links . '" /]';

		echo do_shortcode( $sliderOut );
	}
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