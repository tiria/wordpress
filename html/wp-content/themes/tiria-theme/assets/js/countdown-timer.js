/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* Theme scripts
*****************************************************
*/

jQuery( function() {



/*
*****************************************************
*      DEFAULT ACTIONS
*****************************************************
*/
	function getDateBreakdown() {
		var date      = new Date(),
		    breakdown = {};

		breakdown.hours   = date.getHours();
		breakdown.minutes = date.getMinutes() - 1;
		breakdown.seconds = date.getSeconds();

		return breakdown;
	};

	var breakdown = getDateBreakdown();

	jQuery( 'ul#hours' ).roundabout( {
		shape         : 'waterWheel',
		startingChild : breakdown.hours,
		minScale      : 1
	} );

	jQuery( 'ul#minutes' ).roundabout( {
		shape         : 'waterWheel',
		startingChild : breakdown.minutesOnes,
		minScale      : 1
	} );

	jQuery( 'ul#seconds' ).roundabout( {
		shape         : 'waterWheel',
		startingChild : breakdown.seconds,
		minScale      : 1
	} );

	setInterval( function() {
		var breakdown = getDateBreakdown();

		jQuery( 'ul#hours' ).roundabout( 'animateToChild', breakdown.hours );
		jQuery( 'ul#minutes' ).roundabout( 'animateToChild', breakdown.minutes );
		jQuery( 'ul#seconds' ).roundabout( 'animateToChild', breakdown.seconds );
	}, 1000 );



} );