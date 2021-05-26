<?php
//include WP core
require_once '../../../../../../wp-load.php';

/*
*****************************************************
*      OUTPUT
*****************************************************
*/

$out           = '';
$prefix        = 'slider-roundabout-';
$setRoundabout = array();

$setRoundaboutKeys = array(
	'shape'                => 'text',
	'duration'             => null,
	'startingChild'        => null,
	'reflect'              => null,
	'enableDrag'           => null,
	'dropDuration'         => null,
	'minOpacity'           => 'float',
	'minScale'             => 'float',
	//'tilt'               => 'float',
	'responsive'           => null,
	'easing'               => 'text'
	);

if ( ! wm_option( 'slider-roundabout-autoplay' ) ) {
	$setRoundaboutKeys['autoplayDuration']     = null;
	$setRoundaboutKeys['autoplayPauseOnHover'] = null;
}

foreach ( $setRoundaboutKeys as $key => $treatment ) {
	$getOption = strval( wm_option( $prefix . $key ) );

	if ( $getOption ) {

		if ( 'text' == $treatment )
			$value = '"' . $getOption . '"';
		elseif ( 'float' == $treatment )
			$value = intval( $getOption ) / 100;
		else
			$value = $getOption;

		if ( '"none"' != $value ) {
			$setRoundabout[ $key ] = $value;

			if ( 'easing' == $key && isset( $setRoundabout[ 'easing' ] ) && isset( $setRoundabout[ 'enableDrag' ] ) )
				$setRoundabout[ 'dropEasing' ] = $value;

			if ( 'startingChild' == $key )
				$setRoundabout[ 'startingChild' ] = intval( $value ) - 1;
		}

	}
}

$setRoundabout = wp_parse_args( $setRoundabout, $setRoundaboutDefaults );

if ( ! empty( $setRoundabout ) ) {
	$separator = '';

	$paddingCorrection = ( isset( $setRoundabout['tilt'] ) ) ? ( intval( $setRoundabout['tilt'] * 30 ) ) : ( 0 );

	$out .= "jQuery(function(){
		var lastFocused = 0,
		    container   = jQuery('#roundabout-slider')
		    contHeight  = container.outerHeight(),
		    slides      = jQuery('#roundabout-slider.bg-ready article.slide'),
		    transitionEffectSpeed = " . ( wm_option( $prefix . 'duration' ) / 2 ) . ";

		slides.each(function(item){
				getStyles = jQuery(this).attr('data-style');
				if(getStyles)
					getStyles = 'background: ' + getStyles;
				container.closest('section.slider').append('<div class=\"slide-bg\" style=\"' + getStyles + '\"></div>');
			});

		roundaboutTilt = ( roundaboutTilt ) ? ( roundaboutTilt ) : ( 0 );

		container.css({ marginBottom : " . -$paddingCorrection . " });

		function runRoundabout() {
			container.roundabout({";
				foreach ( $setRoundabout as $key => $value ) {
					$out .= $separator . "\r\n" . $key . ':' . $value;
					$separator = ',';
				}
				$out .= ", tilt: roundaboutTilt});

			container.bind( 'animationEnd', function(){
				var slideID = jQuery('#roundabout-slider .roundabout-in-focus').index();

				jQuery('section.slider .slide-bg').eq(slideID).fadeIn(transitionEffectSpeed).siblings('.slide-bg').fadeOut(transitionEffectSpeed);
			});

			jQuery('section.slider .slide-bg').first().fadeIn(transitionEffectSpeed);
		}; // /runRoundabout

		if ( jQuery('html').hasClass('ie') ) {
			runRoundabout();
		} else {
			container.imagesLoaded( function() {
				runRoundabout();
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