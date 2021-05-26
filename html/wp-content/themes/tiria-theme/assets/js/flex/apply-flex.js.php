<?php
//include WP core
require_once '../../../../../../wp-load.php';

/*
*****************************************************
*      OUTPUT
*****************************************************
*/

$out     = '';
$prefix  = 'slider-flex-';
$setFlex = array();

$setFlexKeys = array(
	'animation'      => 'text',
	//'slideshowSpeed' => null,
	'animationSpeed' => null,
	'pauseOnAction'  => null,
	'pauseOnHover'   => null,
	'controlNav'     => null,
	'directionNav'   => null,
	'easing'         => 'text'
	);

foreach ( $setFlexKeys as $key => $treatment ) {
	$getOption = strval( wm_option( $prefix . $key ) );

	if ( $getOption ) {
		$value = ( 'text' == $treatment ) ? ( '"' . $getOption . '"' ) : ( $getOption );

		$setFlex[ $key ] = $value;
	}
}

$setFlex = wp_parse_args( $setFlex, $setFlexDefaults );

if ( ! empty( $setFlex ) ) {
	$separator = '';

	$out .= "jQuery(function(){
		var transitionEffectSpeed = " . wm_option( $prefix . 'animationSpeed' ) . ",
		    container             = jQuery('#flex-slider'),
		    durationTime          = container.data('time');

		function runFlex() {
			container.flexslider({";
				foreach ( $setFlex as $key => $value ) {
					$out .= $separator . "\r\n" . $key . ':' . $value;
					$separator = ',';
				}
				$out .= ",
				slideshowSpeed: durationTime,
				start:function(slider){
					var container = jQuery('#flex-slider').addClass('animation-" . wm_option( $prefix . 'animation' ) . "'),
					    slides    = jQuery('#flex-slider.bg-ready ul.slides > li'),
					    addition  = ( jQuery('#flex-slider').hasClass('animation-fade') ) ? ( 0 ) : ( 1 );

					slides.each(function(item){
							getStyles = jQuery(this).attr('data-style');
							if(getStyles)
								getStyles = 'background: ' + getStyles;
							container.closest('section.slider').append('<div class=\"slide-bg\" style=\"' + getStyles + '\"></div>');
						});

					jQuery('section.slider .slide-bg').eq(slider.animatingTo - addition).show();

					jQuery('#flex-slider .slider-caption-content').fadeIn();
				},
				before:function(slider){
					var addition = ( jQuery('#flex-slider').hasClass('animation-fade') ) ? ( 0 ) : ( 1 ),
					    slideID  = slider.animatingTo + addition;

					jQuery('section.slider .slide-bg').eq(slideID).fadeIn(transitionEffectSpeed).siblings('.slide-bg').fadeOut(transitionEffectSpeed);

					jQuery('#flex-slider .slider-caption-content').fadeOut();
				},
				after:function(){
					jQuery('#flex-slider .slider-caption-content').fadeIn();
				}
			});
		}; // /runFlex

		if ( jQuery('html').hasClass('ie') ) {
			runFlex();
		} else {
			container.imagesLoaded( function() {
				runFlex();
			});
		}

		});";
}





/*
*****************************************************
*      JS HEADER
*****************************************************
*/
	$expireTime = ( wm_option( 'general-no-css-cache' ) ) ? ( 0 ) : ( WM_CSS_EXPIRATION );

	header( 'content-type: text/javascript; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expireTime ) . ' GMT' );
	header( 'cache-control: public, max-age=' . $expireTime );

	echo $out;

?>