<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Nivo slider
*
* CONTENT:
* - 1) Actions and filters
* - 2) Settings
* - 3) Styles and scripts inclusion
* - 4) HTML generator
*****************************************************
*/

/**
 * @since    1.0
 * @version  3.0
 */





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		add_action( 'wp_enqueue_scripts', 'wm_slider_nivo_assets', 100 );





/*
*****************************************************
*      2) SETTINGS
*****************************************************
*/
	/*
	Nivo animation effects:
		sliceDown, sliceDownLeft, sliceUp, sliceUpLeft, sliceUpDown, sliceUpDownLeft
		fold
		fade
		random
		slideInRight, slideInLeft
		boxRandom
		boxRain, boxRainReverse, boxRainGrow, boxRainGrowReverse
	*/
	//Default Nivo slider settings
	$setNivoDefaults = array(
		//set the effect
		'effect'                  => '"sliceDown"', // animation effect
		//image slices
		'slices'                  => 8, // slice animation
		'boxCols'                 => 8, // box animation
		'boxRows'                 => 4, // box animation
		//speed
		'animSpeed'               => 500, // transition speed
		'pauseTime'               => 2000, // slide display time
		'pauseOnHover'            => 'false', // stop on mouseover
		'manualAdvance'           => 'false', // force manual slide switching
		//prev & next nav
		'directionNav'            => 'true', // activation
		'directionNavHide'        => 'false', // hide, show on mouseover
		'prevText'                => '"' . __( '&laquo; Previous', 'clifden_domain' ) . '"', // previous direction text
		'nextText'                => '"' . __( 'Next &raquo;', 'clifden_domain' ) . '"', // next direction text
		//buttons nav
		'controlNav'              => 'false', // activation
		'controlNavThumbs'        => 'false', // use thumbs
		//other settings
		'startSlide'              => 0, // set starting slide
		'randomStart'             => 'false', // start on a random slide
		/*
		'beforeChange'            =>  function(){}, // triggers before a slide transition
		'afterChange'             =>  function(){}, // triggers after a slide transition
		'slideshowEnd'            =>  function(){}, // triggers after all slides have been shown
		'lastSlide'               =>  function(){}, // triggers when last slide is shown
		'afterLoad'               =>  function(){} // triggers when slider has loaded
		*/
	);





/*
*****************************************************
*      3) STYLES AND SCRIPTS INCLUSION
*****************************************************
*/
	/*
	* Assets to include in footer
	*/
	if ( ! function_exists( 'wm_slider_nivo_assets' ) ) {
		function wm_slider_nivo_assets() {
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			if ( 'nivo' == wm_meta_option( 'slider-type', $blogPageId ) ) {
				//enqueue styles
				wp_enqueue_style( 'nivo' );

				//enqueue scripts
				wp_enqueue_script( 'nivo' );
				wp_enqueue_script( 'apply-nivo' );
			}
		}
	} // /wm_slider_nivo_assets





/*
*****************************************************
*      4) HTML GENERATOR
*****************************************************
*/
	/*
	* Slider generator
	*
	* $slidesCount   = # [number of slides to display]
	* $slidesContent = TEXT [type of slides content]
	* $slidesCat     = # [category from which slides content will be taken - only when using post or wm_slides as content]
	* $imageSize     = TEXT [image size in slider]
	* $width         = TEXT [normal or fullwidth]
	*/
	if ( ! function_exists( 'wm_slider_nivo' ) ) {
		function wm_slider_nivo( $slidesCount = 3, $slidesContent = null, $slidesCat = null, $imageSize = 'slide', $width = 'normal' ) {
			$out        = '';
			$prefix     = 'slider-nivo-';
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//Generating HTML output
			wp_reset_query();

			//Setting query
			if ( 'wm_slides' == $slidesContent && $slidesCat ) {

				//Slides custom posts with category specified
				$query_args = array(
						'post_type'      => $slidesContent,
						'posts_per_page' => $slidesCount,
						'tax_query'      => array( array(
								'taxonomy' => 'slide-category',
								'field'    => ( is_numeric( $slidesCat ) ) ? ( 'term_id' ) : ( 'slug' ),
								'terms'    => $slidesCat
							) ),
						'post__not_in'   => get_option( 'sticky_posts' )
					);
				$query_args = apply_filters( 'wmhook_slider_query_' . 'nivo', $query_args );
				$query_args = apply_filters( 'wmhook_slider_query_' . 'nivo' . '_cat_' . $slidesCat, $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'wm_slides' == $slidesContent ) {

				//Slides custom posts all
				$query_args = array(
						'post_type'      => $slidesContent,
						'posts_per_page' => $slidesCount,
						'post__not_in'   => get_option( 'sticky_posts' )
					);
				$query_args = apply_filters( 'wmhook_slider_query_' . 'nivo', $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'gallery' == $slidesContent ) {

				//Post gallery images
				$slides = apply_filters( 'wmhook_slider_gallery_' . 'nivo', wm_meta_option( 'slider-gallery-images', $blogPageId ), $blogPageId );

			}



			if ( 'gallery' != $slidesContent ) {

				if ( $slides->have_posts() ) {
					//Images
					if ( 'fullwidth' === $width )
						$out .= '<div id="nivo-slider" class="nivo-slider bg-ready slider-content">';
					else
						$out .= '<div class="wrap-inner"><div id="nivo-slider" class="nivo-slider bg-ready slider-content twelve pane">';

					$i = 0;
					while ( $slides->have_posts() ) {
						$slides->the_post();
						++$i;

						$link   = wm_meta_option( 'slide-link' );
						$target = '';

						//if video set, just link to it
						if ( wm_meta_option( 'slide-video' ) ) {
							$link   = esc_url( wm_meta_option( 'slide-video' ) );
							$target = ' target="_blank"';
						}

						$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"' . $target . '>' ) : ( '' );

						if ( has_post_thumbnail() ) {
							$attachment  = get_post( get_post_thumbnail_id() );
							$image       = get_the_post_thumbnail( get_the_ID(), $imageSize, array(
								'class'      => esc_attr( 'img-featured slide' ),
								'title'      => esc_attr( '#nivo-slider-caption-' . $i ),
								'data-style' => esc_attr( wm_css_background_meta( 'slide-' ) )
								) );
							$out        .= preg_replace( '/(width|height)=\"\d*\"\s/', "", $image );
						}

						$out .= ( $link ) ? ( '</a>' ) : ( '' );
					}

					if ( 'fullwidth' === $width )
						$out .= '</div> <!-- /nivo-slider -->';
					else
						$out .= '</div></div> <!-- /nivo-slider -->';

					//Captions
					$out .= '<div id="nivo-captions-container" class="hide">';

					$i = 0;
					while ( $slides->have_posts() ) {
						$slides->the_post();

						++$i;

						$link   = wm_meta_option( 'slide-link' );
						$target = '';

						//if video set, just link to it
						if ( wm_meta_option( 'slide-video' ) ) {
							$link   = esc_url( wm_meta_option( 'slide-video' ) );
							$target = ' target="_blank"';
						}

						$link   = ( $link ) ? ( '<a href="' . esc_url( $link ) . '" class="nivo-slide-link"' . $target . '></a>' ) : ( '' );
						$layout = ( wm_meta_option( 'slide-caption-alignment' ) ) ? ( wm_meta_option( 'slide-caption-alignment' ) . wm_meta_option( 'slide-caption-padding' ) ) : ( ' column col-12 no-margin alignright' );

						//Nivo has to display caption always - even empty. Else it uses previous slide caption if caption not set for the current slide.
						if ( 0 < wm_meta_option( 'slide-caption-opacity' ) && 100 > wm_meta_option( 'slide-caption-opacity' ) )
							$bg  = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . wm_meta_option( 'slide-caption-color' ) . '/' . wm_meta_option( 'slide-caption-opacity' ) . '.png)';
						else
							$bg  = ( 100 == wm_meta_option( 'slide-caption-opacity' ) ) ? ( wm_meta_option( 'slide-caption-color' ) ) : ( 'transparent; background:rgba(0,0,0, 0);' ); //the RGBA is for IE9 to work!
						$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

						$iconsColorClass = ( 'black' == wm_meta_option( 'slide-caption-color' ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

						$out .= '<div id="nivo-slider-caption-' . $i . '"><div class="slider-caption-content">' . $link;
						if ( get_the_content() ) {
							$out .= '<div class="caption-inner bg-' . wm_meta_option( 'slide-caption-color' ) . $iconsColorClass . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', get_the_content() );
							$out .= '</div></div>';
						}
						$out .= '</div><!-- /nivo-slider-caption-' . $i . ' --></div>';
					}

					$out .= '</div> <!-- /nivo-captions -->';
				} // /have_posts

			} elseif ( is_array( $slides ) && ! empty( $slides ) ) {

				$slides = array_slice( $slides, 0, $slidesCount );

				//Images
				if ( 'fullwidth' === $width )
					$out .= '<div id="nivo-slider" class="nivo-slider slider-content">';
				else
					$out .= '<div class="wrap-inner"><div id="nivo-slider" class="nivo-slider slider-content twelve pane">';

				$i = 0;
				foreach ( $slides as $imageId ) {
					++$i;
					$imgUrl    = wp_get_attachment_image_src( $imageId, $imageSize );
					$imageAlt  = get_post_meta( $imageId, '_wp_attachment_image_alt', true );
					$out      .= '<img src="' . $imgUrl[0] . '" class="img-featured slide" title="#nivo-slider-caption-' . $i . '" alt="' . esc_attr( $imageAlt ) . '" />';
				}

				if ( 'fullwidth' === $width )
					$out .= '</div> <!-- /nivo-slider -->';
				else
					$out .= '</div></div> <!-- /nivo-slider -->';

				//Captions
				$out .= '<div id="nivo-captions-container" class="hide">';

				$i = 0;
				foreach ( $slides as $imageId ) {
					++$i;

					//Caption
					$attachment = get_post( $imageId );
					$link       = get_post_meta( $attachment->ID, 'image-url', true );

					if ( $attachment ) {
						$content = '';
						$content .= ( $attachment->post_excerpt ) ? ( '<h2>' . wptexturize( $attachment->post_excerpt ) . '</h2>' ) : ( '' );
						$content .= ( $attachment->post_content ) ? ( wptexturize( $attachment->post_content ) ) : ( '' );

						$layout = ( get_post_meta( $attachment->ID, 'caption-alignment', true ) ) ? ( get_post_meta( $attachment->ID, 'caption-alignment', true ) . get_post_meta( $attachment->ID, 'caption-padding', true ) ) : ( ' column col-13 no-margin alignright' );
						if ( 0 < absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) && 100 > absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) )
							$bg = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . get_post_meta( $attachment->ID, 'caption-color', true ) . '/' . absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) . '.png)';
						else
							$bg = ( 100 == absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) ) ? ( get_post_meta( $attachment->ID, 'caption-color', true ) ) : ( 'transparent; background:rgba(0,0,0, 0);' ); //the RGBA is for IE9 to work!
						$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

						$iconsColorClass = ( 'black' == get_post_meta( $attachment->ID, 'caption-color', true ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

						$out .= '<div id="nivo-slider-caption-' . $i . '"><div class="slider-caption-content">';
						$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"></a>' ) : ( '' );
						if ( $content ) {
							$out .= '<div class="caption-inner bg-' . get_post_meta( $attachment->ID, 'caption-color', true ) . $iconsColorClass . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', $content );
							$out .= '</div></div>';
						}
						$out .= '</div><!-- /nivo-slider-caption-' . $i . ' --></div>';
					}
				}

				$out .= '</div> <!-- /nivo-captions -->';

			} // /slides gallery array

			wp_reset_query();

			$out = "\r\n\r\n" . $out;

			if ( $out )
				return $out;
			else
				return;
		}
	} // /wm_slider_nivo

?>