<?php
//include WP core
require_once '../../../../../../wp-load.php';

/*
*****************************************************
*      OUTPUT
*****************************************************
*/

$out     = '';
$prefix  = 'slider-nivo-';
$setNivo = array();

$setNivoKeys = array(
	'effect'           => 'text',
	'slices'           => null,
	'boxCols'          => null,
	'boxRows'          => null,
	'animSpeed'        => null,
	'pauseTime'        => null,
	'pauseOnHover'     => null,
	'directionNav'     => null,
	'directionNavHide' => null,
	'prevText'         => 'text',
	'nextText'         => 'text',
	'controlNav'       => null,
	'controlNavThumbs' => null
	);

foreach ( $setNivoKeys as $key => $treatment ) {
	$getOption = strval( wm_option( $prefix . $key ) );

	if ( $getOption ) {

		$value = ( 'text' == $treatment ) ? ( '"' . $getOption . '"' ) : ( $getOption );

		$setNivo[ $key ] = $value;

		if ( 'controlNavThumbs' == $key )
			$setNivo[ 'controlNavThumbsFromRel' ] = $value;

	}
}

$setNivo = wp_parse_args( $setNivo, $setNivoDefaults );

if ( ! empty( $setNivo ) ) {
	$separator = '';

	$out .= "jQuery(function(){
		var transitionEffectSpeed = " . wm_option( $prefix . 'animSpeed' ) . ";

		jQuery('#nivo-slider').nivoSlider({";
	foreach ( $setNivo as $key => $value ) {
		$out .= $separator . $key . ':' . $value;
		$separator = ',';
	}
	$out .= ",
		afterLoad:function(){
			var slider = jQuery('#nivo-slider'),
			    slides = jQuery('#nivo-slider.bg-ready img.slide');

			slides.each(function(item){
					getStyles = jQuery(this).attr('data-style');
					if(getStyles)
						getStyles = 'background: ' + getStyles;
					slider.closest('section.slider').append('<div class=\"slide-bg\" style=\"' + getStyles + '\"></div>');
				});

			jQuery('section.slider .slide-bg').first().show();

			jQuery('#nivo-slider .nivo-caption .slider-caption-content').fadeIn();
		},
		beforeChange:function(){
			var slideID = jQuery('#nivo-slider').data('nivo:vars').currentSlide + 1,
			    slidesCount = jQuery('#nivo-slider').data('nivo:vars').totalSlides;

			if(slideID > (slidesCount-1))
				slideID = 0;

			jQuery('section.slider .slide-bg').eq(slideID).fadeIn(transitionEffectSpeed).siblings('.slide-bg').fadeOut(transitionEffectSpeed);

			jQuery('#nivo-slider .nivo-caption .slider-caption-content').fadeOut();
		},
		afterChange:function(){
			jQuery('#nivo-slider .nivo-caption .slider-caption-content').fadeIn();
		}
	});

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