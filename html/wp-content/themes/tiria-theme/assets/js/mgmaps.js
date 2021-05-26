/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* Google Maps
*****************************************************
*/



function initializeMap() {

	mapStyle  = ( typeof mapStyle == 'undefined' ) ? ( '' ) : ( mapStyle );
	mapZoom   = ( typeof mapZoom == 'undefined' ) ? ( 10 ) : ( mapZoom );
	mapLat    = ( typeof mapLat == 'undefined' ) ? ( 0 ) : ( mapLat );
	mapLong   = ( typeof mapLong == 'undefined' ) ? ( 0 ) : ( mapLong );
	mapInfo   = ( typeof mapInfo == 'undefined' ) ? ( '' ) : ( mapInfo );
	mapMarker = ( typeof mapMarker == 'undefined' ) ? ( false ) : ( mapMarker );
	mapInvert = ( typeof mapInvert == 'undefined' ) ? ( false ) : ( mapInvert );
	themeImgs = ( typeof themeImgs == 'undefined' ) ? ( './' ) : ( themeImgs );
	imgBright = ( mapInvert && 'default' != mapStyle ) ? ( '-light' ) : ( '' );
	mapName   = ( typeof mapName == 'undefined' ) ? ( 'Custom' ) : ( mapName );
	mapSat = ( typeof mapSat == 'undefined' ) ? ( -100 ) : ( mapSat-100 );

	//Set location
	var myCenter = new google.maps.LatLng( mapLat, mapLong );

	//Map properties and map object
	var mapProperties = {
			//location and zoom
			center : myCenter,
			zoom   : mapZoom,
			//cursors
			draggableCursor : 'auto',
			draggingCursor  : '',
			//controls
			panControl            : false,
			zoomControl           : true,
			mapTypeControl        : true,
			scaleControl          : true,
			streetViewControl     : false,
			overviewMapControl    : false,
			rotateControl         : true,
			scrollwheel           : false,
			zoomControlOptions    : {
					style    : google.maps.ZoomControlStyle.AUTO,
					position : google.maps.ControlPosition.LEFT_CENTER
				},
			mapTypeControlOptions : {
					style      : google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
					position   : google.maps.ControlPosition.RIGHT_BOTTOM,
					mapTypeIds : [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
		};

	if ( 'default' == mapStyle )
		mapProperties['mapTypeControl'] = false;

	var map = new google.maps.Map( document.getElementById( 'mgmap' ), mapProperties );
	
	//Styling map
	var styleMap = [
			{
				stylers: [
					{ saturation       : mapSat },
					{ visibility       : 'simplified' },
					{ invert_lightness : mapInvert },
					{ weight           : 1.9 }
				]
			}
		];
	if ( 'nopoi' == mapStyle )
		styleMap = [
			{
				stylers: [
					{ saturation       : mapSat },
					{ visibility       : 'on' },
					{ invert_lightness : mapInvert },
					{ weight           : 1.9 }
				]
			},
			{
				featureType:'poi',
				stylers: [
					{ visibility       : 'off' }
				]
			}
		];
	if ( 'notext' == mapStyle )
		styleMap = [
			{
				stylers: [
					{ saturation       : mapSat },
					{ visibility       : 'simplified' },
					{ invert_lightness : mapInvert },
					{ weight           : 1.9 }
				]
			},
			{
				featureType:'poi',
				stylers: [
					{ visibility       : 'off' }
				]
			}
		];
	if ( 'default' == mapStyle )
		styleMap = [ { stylers: [] } ];
	var styledMap = new google.maps.StyledMapType( styleMap, { name: mapName } );
	map.mapTypes.set( 'map_style', styledMap );
	map.setMapTypeId( 'map_style' );

	//Location marker customization
	if(mapMarker && mapMarker!='false'){	
	var image = new google.maps.MarkerImage(
			themeImgs + 'map/marker' + imgBright + '.png',
			new google.maps.Size( 32, 44 ),
			new google.maps.Point( 0, 0 ),
			new google.maps.Point( 16, 44 )
		);
	var shadow = new google.maps.MarkerImage(
			themeImgs + 'map/marker-shadow.png',
			new google.maps.Size( 58, 44 ),
			new google.maps.Point( 0, 0 ),
			new google.maps.Point( 16, 44 )
		);
	var shape = {
			coord : [20,0,23,1,24,2,25,3,27,4,27,5,28,6,29,7,29,8,30,9,30,10,31,11,31,12,31,13,31,14,31,15,31,16,31,17,31,18,31,19,31,20,31,21,30,22,30,23,29,24,29,25,28,26,28,27,27,28,27,29,26,30,25,31,25,32,24,33,23,34,22,35,22,36,21,37,20,38,20,39,19,40,18,41,17,42,16,43,15,43,14,42,13,41,12,40,11,39,11,38,10,37,9,36,9,35,8,34,7,33,6,32,6,31,5,30,4,29,4,28,3,27,3,26,2,25,2,24,1,23,1,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,1,10,1,9,2,8,2,7,3,6,4,5,4,4,6,3,7,2,8,1,11,0,20,0],
			type  : 'poly'
		};
	var bounce = (mapMarker == 'bounce') ? google.maps.Animation.BOUNCE : false;
	var marker = new google.maps.Marker({
			raiseOnDrag : false,
			clickable   : true,
			icon        : image,
			shadow      : shadow,
			shape       : shape,
			map         : map,
			position    : myCenter,
			animation   : bounce,
			cursor      : 'pointer'
		});
	marker.setMap( map );
	}

	//Info bubble
	if(mapInfo!=''){
	var infoBoxOptions = {
			content                : mapInfo,
			disableAutoPan         : false,
			maxWidth               : 0,
			pixelOffset            : new google.maps.Size( -60, 17 ),
			zIndex                 : null,
			infoBoxClearance       : new google.maps.Size( 1, 1 ),
			isHidden               : false,
			pane                   : 'floatPane',
			enableEventPropagation : false
		};
	var infowindow = new InfoBox( infoBoxOptions );
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	}
	
	//Center map on location
	if ( mapCenter ) {
		google.maps.event.addListener( map, 'center_changed', function() {
				window.setTimeout( function() {
						map.panTo( marker.getPosition() );
					}, 2000 );
			});
	}

} // /initializeMap

google.maps.event.addDomListener( window, 'load', initializeMap );
