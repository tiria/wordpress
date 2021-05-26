<?php
$positions = array(
	'date-special',
	'formaticon',
	);
wm_meta( $positions, 'date-special' );
?>

<div <?php post_class( 'article-content' ); ?>>
	<?php
	$mediaURL = apply_filters( 'wmhook_format_audio_mediaURL', trim( get_post_meta( get_the_ID(), '_format_audio_embed', true ) ) );

	if ( ! $mediaURL ) {
		$mediaURL = trim( wm_meta_option( 'audio-url' ) );
	}

	if ( false !== strpos( $mediaURL, '[audio ' ) ) {

			echo do_shortcode( $mediaURL );

	} elseif ( $mediaURL ) {

		$album_art = '';

		if ( has_post_thumbnail() ) {
			global $blogLayout;
			$imageSize = ( ' masonry-container' == $blogLayout ) ? ( 'mobile' ) : ( 'content-width' );
			$imageSrc  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $imageSize );
			$album_art = ( $imageSrc ) ? ( ' album_art="' . esc_url( $imageSrc[0] ) . '"' ) : ( '' );
		}

		echo do_shortcode( '[audio url="' . esc_url( $mediaURL ) . '"' . $album_art . ' /]' );

	} else {

		echo do_shortcode( '[box color="red" icon="warning"]' . __( 'Please set "MP3 file URL address" option', 'clifden_domain' ) . '[/box]' );

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