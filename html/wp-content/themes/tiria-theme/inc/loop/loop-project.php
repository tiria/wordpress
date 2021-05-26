<?php if ( have_posts() ) : the_post();

$projectLayout = array();



//Portfolio description
	$content    = get_the_content();
	$excerpt    = ( has_excerpt() ) ? ( get_the_excerpt() ) : ( '' );
	$allContent = $excerpt . $content;

	if ( false !== stripos( $allContent, '[project_attributes' ) )
		$projectLayout['excerpt'] = apply_filters( 'wm_default_content_filters', $excerpt );
	else
		$projectLayout['excerpt'] = '[project_attributes title="" /] ' . apply_filters( 'wm_default_content_filters', $excerpt );

	$content = ( $content ) ? ( '<div class="project-content">' . apply_filters( 'the_content', get_the_content() ) . '</div>' ) : ( '' );
	$projectLayout['content'] = $content;



//Portfolio preview image/video
	$out = '';

	if ( 'static-project' === wm_meta_option( 'project-type' ) ) {

		$imageArray = wm_meta_option( 'project-image' );

		if ( isset( $imageArray['url'] ) && isset( $imageArray['id'] ) ) {
			$imageSize  = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 'content-width' ) : ( 'mobile' );
			$attachment = get_post( $imageArray['id'] );
			$imageAlt   = get_post_meta( $imageArray['id'], '_wp_attachment_image_alt', true );
			$imageTitle = '';
			if ( is_object( $attachment ) && ! empty( $attachment ) ) {
				$imageTitle  = $attachment->post_title;
				$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
			}
			$imageLarge = wp_get_attachment_image_src( $imageArray['id'], wm_option( 'general-lightbox-img' ) );
			$imageSrc   = wp_get_attachment_image_src( $imageArray['id'], $imageSize );

			$out .= '<a href="' . $imageLarge[0] . '" data-modal class="project-preview">';
			$out .= '<img src="' . $imageSrc[0] . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
			$out .= '</a>';
		} else {
			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Project main image" option', 'clifden_domain' ) . '[/box]';
		}

	} elseif ( 'flex-project' === wm_meta_option( 'project-type' ) ) {

		$slides = array();
		$separator = $imageLinks = '';

		$slideDuration = ( wm_meta_option( 'project-slider-duration' ) ) ? ( absint( wm_meta_option( 'project-slider-duration' ) ) ) : ( 5 );
		$imageSize     = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 'content-width' ) : ( 'mobile' );

		if ( wm_meta_option( 'slider-gallery-images' ) )
			$slides = wm_meta_option( 'slider-gallery-images' );

		if ( ! empty( $slides ) ) {
			$out .= '<div class="project-slider">[slideshow time="' . $slideDuration . '" images="';
			foreach ( $slides as $imageId) {
				$image = wp_get_attachment_image_src( $imageId, $imageSize );

				//Apply custom image link
					$link = get_post_meta( $imageId, 'image-url', true );

					//If link not set, link to full image
						if ( ! $link ) {
							$link = wp_get_attachment_image_src( $imageId, 'full' );
							$link = $link[0];
						}

				$out .= $separator . $image[0];
				$imageLinks .= $separator . $link;

				$separator = ', ';
			}
			$out .= '" links="' . $imageLinks . '" /]</div> <!-- /portfolio-slider -->';
		} else {
			$out .= '[box color="red" icon="warning"]' . __( 'Please upload project images and set "Choose slider images" option', 'clifden_domain' ) . '[/box]';
		}

	} elseif ( 'video-project' === wm_meta_option( 'project-type' ) ) {

		$videoURL = wm_meta_option( 'project-video' );

		if ( false !== strpos( $videoURL, '[video ' ) ) {

			$out .= $videoURL;

		} elseif ( $videoURL ) {

			$poster     = '';
			$previewImg = wm_meta_option( 'project-video-preview' );
			if ( isset( $previewImg['url'] ) && isset( $previewImg['id'] ) ) {
				$imageSize = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 'content-width' ) : ( 'mobile' );
				$imageSrc  = wp_get_attachment_image_src( $previewImg['id'], $imageSize );
				$poster    = ( $imageSrc ) ? ( ' poster="' . esc_url( $imageSrc[0] ) . '"' ) : ( '' );
			}

			$out .= '[video src="' . esc_url( $videoURL ) . '"' . $poster . ' /]';

		} else {

			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Video URL" option', 'clifden_domain' ) . '[/box]';

		}

	} elseif ( 'audio-project' === wm_meta_option( 'project-type' ) ) {

		$audioURL = wm_meta_option( 'project-audio' );

		if ( false !== strpos( $audioURL, '[audio ' ) ) {

			$out .= $audioURL;

		} elseif ( $audioURL ) {

			$album_art  = '';
			$previewImg = wm_meta_option( 'project-audio-preview' );
			if ( isset( $previewImg['url'] ) && isset( $previewImg['id'] ) ) {
				$imageSize = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 'content-width' ) : ( 'mobile' );
				$imageSrc  = wp_get_attachment_image_src( $previewImg['id'], $imageSize );
				$album_art = ( $imageSrc ) ? ( ' album_art="' . esc_url( $imageSrc[0] ) . '"' ) : ( '' );
			}

			$out .= '[audio src="' . esc_url( $audioURL ) . '"' . $album_art . ' /]';

		} else {

			$out .= '[box color="red" icon="warning"]' . __( 'Please set "Audio URL" option', 'clifden_domain' ) . '[/box]';

		}

	}

	$projectLayout['media'] = $out;



//Output
$sharing = '';
if ( ! wm_option( 'social-share-no-projects' ) && ! wm_meta_option( 'project-no-share' ) )
	$sharing = wm_meta( array( 'sharing' ), 'project-sharing', '', false );

$layout = ( wm_meta_option( 'project-single-layout' ) ) ? ( explode( '-', wm_meta_option( 'project-single-layout' ) ) ) : ( array( 'me', 4 ) );

if ( 2 === count( $layout ) ) {
	if ( 'me' == $layout[0] )
		echo do_shortcode( '<div class="column col-' . ( absint( $layout[1] ) - 1 ) . absint( $layout[1] ) . '">' . $projectLayout['media'] . '</div><div class="column col-1' . absint( $layout[1] ) . ' last">' . $projectLayout['excerpt'] . '</div><span class="br"></span>' . $sharing . $projectLayout['content'] );
	else
		echo do_shortcode( '<div class="column col-1' . absint( $layout[1] ) . '">' . $projectLayout['excerpt'] . '</div><div class="column col-' . ( absint( $layout[1] ) - 1 ) . absint( $layout[1] ) . ' last">' . $projectLayout['media'] . '</div><span class="br"></span>' . $sharing . $projectLayout['content'] );
}

?>

<?php wm_end_post(); ?>

<?php wp_reset_query(); endif; ?>

<?php comments_template( null, true ); ?>