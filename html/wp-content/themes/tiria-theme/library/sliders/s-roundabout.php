<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* Roundabout slider
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
		add_action( 'wp_enqueue_scripts', 'wm_slider_roundabout_assets', 100 );





/*
*****************************************************
*      2) SETTINGS
*****************************************************
*/
	//Default Roundabout slider settings
	$setRoundaboutDefaults = array(
		//Animation settings
		'shape'                      => '"lazySusan"',  //The path that moving elements follow. By default, Roundabout comes with one shape, which is lazySusan. When using Roundabout with the Roundabout Shapes plugin, there are many other shapes available.
		'minOpacity'                 => 0.4,            //The lowest opacity that will be assigned to a moving element. This occurs when the moving element is opposite of (that is, 180° away from) the focusBearing.
		'maxOpacity'                 => 1.0,            //The greatest opacity that will be assigned to a moving element. This occurs when the moving element is at the same bearing as the focusBearing.
		'minScale'                   => 0.4,            //The lowest size (relative to its starting size) that will be assigned to a moving element. This occurs when the moving element is opposite of (that is, 180° away from) the focusBearing.
		'maxScale'                   => 1.0,            //The greatest size (relative to its starting size) that will be assigned to a moving element. This occurs when the moving element is at the same bearing as the focusBearing.
		'easing'                     => '"swing"',
		'startingChild'              => 0,              //The child element that will start at the Roundabout’s focusBearing on load. This is a zero-based counter based on the order of markup.
		'reflect'                    => 'false',        //When true, reverses the direction in which Roundabout will operate. By default, next animations will rotate moving elements in a clockwise direction and previous animations will be counterclockwise. Using reflect will flip the two.
		'autoplay'                   => 'true',         //When true, Roundabout will automatically advance the moving elements to the next child at a regular interval (settable as autoplayDuration).
		'duration'                   => 600,            //The length of time Roundabout will take to move from one child element being in focus to another (when an animation is triggered). This value acts as the default for Roundabout, but each animation action can be given a custom duration for that animation.
		'autoplayInitialDelay'       => 0,              //The length of time (in milliseconds) to delay the start of Roundabout’s configured autoplay option. This only works with setting autoplay to true, and only on the first start of autoplay.
		'autoplayDuration'           => 3000,           //The length of time (in milliseconds) between animation triggers when a Roundabout’s autoplay is playing.
		'autoplayPauseOnHover'       => 'false',        //When true, Roundabout will pause autoplay when the user moves the cursor over the Roundabout container.

		//Touchscreen dragging
		'enableDrag'                 => 'false',        //Requires event.drag and event.drop plugins by ThreeDubMedia. Allows a user to rotate Roundabout be clicking and dragging the Roundabout area itself.
		'dropDuration'               => 600,            //The length of time (in milliseconds) the animation will take to animate Roundabout to the appropriate child when the Roundabout is “dropped.”
		//'dropEasing'               => '"swing"',      //The easing function to use when animating Roundabout after it has been “dropped.” With no other plugins, the standard jQuery easing functions are available. When using the jQuery easing plugin all of its easing functions will also be available.
		//'dropAnimateTo'            => '"nearest"',    //The animation method to use when a dragged Roundabout is “dropped.” Valid values are next, previous, or nearest.
		//'dropCallback'             => 'function(){}', //A function that will be called once the dropped animation has completed.
		//'dragAxis'                 => '"x"',          //The axis along which drag events are measured. Valid values are x and y.
		//'dragFactor'               => 4,              //Alters the rate at which dragging moves the Roundabout’s moving elements. Higher numbers will cause the moving elements to move less.

		//Navigation
		//'btnNext'                  => 'null',         //A jQuery selector of page elements that, when clicked, will trigger the Roundabout to animate to the next moving element.
		//'btnNextCallback'          => 'function(){}', //A function that will be called once the animation triggered by a btnNext-related click has finished.
		//'btnPrev'                  => 'null',         //A jQuery selector of page elements that, when clicked, will trigger the Roundabout to animate to the previous moving element.
		//'btnPrevCallback'          => 'function(){}', //A function that will be called once the animation triggered by a btnPrev-releated click has finished.
		//'btnToggleAutoplay'        => 'null',         //A jQuery selector of page elements that, when clicked, will toggle the Roundabout’s autoplay state (either starting or stopping).
		//'btnStartAutoplay'         => 'null',         //A jQuery selector of page elements that, when clicked, will start the Roundabout’s autoplay feature (if it’s currently stopped).
		//'btnStopAutoplay'          => 'null',         //A jQuery selector of page elements that, when clicked, will stop the Roundabout’s autoplay feature (if it’s current playing).
		//'clickToFocus'             => 'true',         //When true, Roundabout will bring non-focused moving elements into focus when they’re clicked. Otherwise, click events won’t be captured and will be passed through to the moving child elements.
		//'clickToFocusCallback'     => 'function(){}', //A function that will be called once the clickToFocus animation has completed.

		//Other settings and defaults
		'minZ'                       => 10,             //The lowest z-index that will be assigned to a moving element. This occurs when the moving element is opposite of (that is, 180° away from) the focusBearing.
		'maxZ'                       => 80,             //The greatest z-index that will be assigned to a moving element. This occurs when the moving element is at the same bearing as the focusBearing.
		//'tilt'                     => 0.0,            //Slightly alters the calculations of moving elements. In the default shape, it adjusts the apparent tilt. Other shapes will differ.
		//'bearing'                  => 0.0,            //The starting direction in which Roundabout should face relative to the focusBearing.
		//'focusBearing'             => 0.0,            //The bearing that Roundabout will use as the focus point. All animations that move Roundabout between children will animate the given child element to this bearing.
		'childSelector'            => '"article"',      //A jQuery selector of child elements within the elements Roundabout is called upon that will become the moving elements within Roundabout. By default, Roundabout works on unordered lists, but it can be changed to work with any nested set of child elements.
		//'floatComparisonThreshold' => 0.001,          //The maximum distance two values can be from one another to still be considered equal by Roundabout’s standards. This prevents JavaScript rounding errors.
		//'triggerFocusEvents'       => 'true',         //When true, a focus event will be triggered on the child element that moves into focus when it does so.
		//'triggerBlurEvents'        => 'true',         //When true, a blur event will be triggered on the child element that moves out of the focused position when it does so.
		'responsive'                 => 'true',         //When true, attaches a resize event onto the window and will automatically relayout Roundabout’s child elements as the holder element changes size.

		//Enable debugging
		//'debug'                    => 'true',         //When true, Roundabout will replace the contents of moving elements with information about the moving elements themselves.
	);





/*
*****************************************************
*      3) STYLES AND SCRIPTS INCLUSION
*****************************************************
*/
	/*
	* Assets to include in footer
	*/
	if ( ! function_exists( 'wm_slider_roundabout_assets' ) ) {
		function wm_slider_roundabout_assets() {
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			if ( 'roundabout' == wm_meta_option( 'slider-type', $blogPageId ) ) {
				$prefix = 'slider-roundabout-';

				//enqueue styles
				wp_enqueue_style( 'roundabout' );

				//enqueue scripts
				if ( wm_option( $prefix . 'easing' ) && 'none' != wm_option( $prefix . 'easing' ) )
					wp_enqueue_script( 'easing' );

				wp_enqueue_script( 'roundabout' );

				if ( wm_option( $prefix . 'shape' ) && 'lazySusan' != wm_option( $prefix . 'shape' ) )
					wp_enqueue_script( 'roundabout-shapes' );

				if ( wm_option( $prefix . 'enableDrag' ) ) {
					wp_enqueue_script( 'drag' );
					wp_enqueue_script( 'drop' );
				}

				wp_enqueue_script( 'apply-roundabout' );
			}
		}
	} // /wm_slider_roundabout_assets





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
	if ( ! function_exists( 'wm_slider_roundabout' ) ) {
		function wm_slider_roundabout( $slidesCount = 3, $slidesContent = null, $slidesCat = null, $imageSize = 'portfolio', $width = 'normal' ) {
			$out        = '';
			$prefix     = 'slider-roundabout-';
			$blogPageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//generate HTML
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
				$query_args = apply_filters( 'wmhook_slider_query_' . 'roundabout', $query_args );
				$query_args = apply_filters( 'wmhook_slider_query_' . 'roundabout' . '_cat_' . $slidesCat, $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'wm_slides' == $slidesContent ) {

				//Slides custom posts all
				$query_args = array(
						'post_type'      => $slidesContent,
						'posts_per_page' => $slidesCount,
						'post__not_in'   => get_option( 'sticky_posts' )
					);
				$query_args = apply_filters( 'wmhook_slider_query_' . 'roundabout', $query_args );
				$slides = new WP_Query( $query_args );

			} elseif ( 'gallery' == $slidesContent ) {

				//Post gallery images
				$slides = apply_filters( 'wmhook_slider_gallery_' . 'roundabout', wm_meta_option( 'slider-gallery-images', $blogPageId ), $blogPageId );

			}



			if ( 'gallery' != $slidesContent ) {

				if ( $slides->have_posts() ) {
					//Images
					if ( 'fullwidth' === $width )
						$out .= '<div id="roundabout-slider" class="roundabout-slider bg-ready slider-content">';
					else
						$out .= '<div class="wrap-inner"><div id="roundabout-slider" class="roundabout-slider bg-ready slider-content twelve pane">';

					$i = 0;
					while ( $slides->have_posts() ) {
						$slides->the_post();
						$i++;

						$link   = wm_meta_option( 'slide-link' );
						$target = '';

						//if video set, just link to it
						if ( wm_meta_option( 'slide-video' ) ) {
							$link   = esc_url( wm_meta_option( 'slide-video' ) );
							$target = ' target="_blank"';
						}

						$out .= '<article id="roundabout-' . $i . '" class="slide" data-style="' . wm_css_background_meta( 'slide-' ) . '">';

						if ( has_post_thumbnail() ) {
							$attachment = get_post( get_post_thumbnail_id() );
							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"' . $target . '>' ) : ( '' );
							$imageTag = get_the_post_thumbnail( get_the_ID(), $imageSize, array(
								'class'	=> 'img-featured',
								'alt'	  => esc_attr( trim( strip_tags( get_the_title() ) ) ),
								'title' => esc_attr( $attachment->post_title ),
								) );
							$out .= preg_replace( '/(width|height)=\"\d*\"\s/', "", $imageTag );
							$out .= ( $link ) ? ( '</a>' ) : ( '' );
						}

						$out .= '</article>';
					}

					if ( 'fullwidth' === $width )
						$out .= '</div> <!-- /roundabout-slider -->';
					else
						$out .= '</div></div> <!-- /roundabout-slider -->';
				} // /have_posts

			} elseif ( is_array( $slides ) && ! empty( $slides ) ) {

				$slides = array_slice( $slides, 0, $slidesCount );

				//Images
				if ( 'fullwidth' === $width )
					$out .= '<div id="roundabout-slider" class="roundabout-slider slider-content">';
				else
					$out .= '<div class="wrap-inner"><div id="roundabout-slider" class="roundabout-slider slider-content twelve pane">';

				$i = 0;
				foreach ( $slides as $imageId) {
					$i++;

					$attachment = get_post( $imageId );

					if ( $attachment ) {
						$out .= '<article id="roundabout-' . $i . '" class="slide">';

						$imageTag = wp_get_attachment_image( $imageId, $imageSize, null, array(
								'class'	=> 'img-featured',
								'title' => esc_attr( $attachment->post_title ),
								) );
						$out .= preg_replace( '/(width|height)=\"\d*\"\s/', "", $imageTag );

						$out .= '</article>';
					}
				}

				if ( 'fullwidth' === $width )
					$out .= '</div> <!-- /roundabout-slider -->';
				else
					$out .= '</div></div> <!-- /roundabout-slider -->';

			} // /slides gallery array

			wp_reset_query();

			if ( $out )
				return $out;
			else
				return;
		}
	} // /wm_slider_roundabout

?>