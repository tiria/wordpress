/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
* Copyright by WebMan - www.webmandesign.eu
*
* WebMan Shortcodes Generator scripts
*
* CONTENT:
* - 1) Add jQuery UI dialog
* - 2) Variables and default settings
* - 3) Realtime parameters change function
* - 4) Tabs and select
* - 5) Apply select and input changes
* - 6) Sending the output to content
*****************************************************
*/
jQuery( function() {



/*
*****************************************************
*      1) ADD JQUERY UI DIALOG
*****************************************************
*/
	if ( jQuery().dialog ) {
		jQuery( '#wm-shortcode-generator' ).dialog({
			modal       : true,
			dialogClass : 'wp-dialog',
			width       : 640,
			height      : 650,
			autoOpen    : false,
			title       : 'Shortcode Generator'
		});
	}



/*
*****************************************************
*      2) VARIABLES AND DEFAULT SETTINGS
*****************************************************
*/
	var generator              = jQuery( '#wm-shortcode-generator' ),
	    outputShortcodeElement = '.wm-shortcode-output',
	    target                 = ( generator.hasClass( 'tabbed' ) ) ? ( generator.find( '.wm-tabs li:first a' ).attr( 'href' ) ) : ( generator.find( '.wm-select' ).val() );

	if ( generator.hasClass( 'tabbed' ) )
		generator.find( '.wm-tabs li:first' ).addClass( 'active' ).siblings().removeClass( 'active' );
	generator.find( '.tab-content:first' ).show().siblings( '.tab-content' ).hide();



/*
*****************************************************
*      3) REALTIME PARAMETERS CHANGE FUNCTION
*****************************************************
*/
	function realTimeChange( target ) {
		var $parentTab    = jQuery( target );
		    countChildren = $parentTab.find( 'table tr' ).length - 1,
		    outShortcode  = $parentTab.find( outputShortcodeElement ).data( 'reference' );

		for ( i = 1; i <= countChildren; i++ ) {
			var inputField  = $parentTab.find( 'table tr.item-' + i + ' input' ),
			    selectField = $parentTab.find( 'table tr.item-' + i + ' select' );

			if ( inputField.length ) {

				var getPropertyName  = inputField.data( 'attribute' ),
				    getPropertyValue = inputField.val();

			} else {

				var getPropertyName  = selectField.data( 'attribute' ),
				    getPropertyValue = selectField.val();

			}

			var textToReplace = '{{' + getPropertyName + '}}';
			    outShortcode  = ( '' !== getPropertyValue ) ? ( outShortcode.replace( textToReplace, ' ' + getPropertyName + '="' + getPropertyValue + '"' ) ) : ( outShortcode.replace( textToReplace, '' ) );

			//replacing output shortcode
			$parentTab.find( outputShortcodeElement ).text( outShortcode );
		}
	} // /realTimeChange

	realTimeChange( target );



/*
*****************************************************
*      4) TABS AND SELECT
*****************************************************
*/
	if ( generator.hasClass( 'tabbed' ) ) {
		generator.find( '.wm-tabs a' ).click( function() {
			var target = jQuery( this ).attr( 'href' );

			jQuery( this ).parent().addClass( 'active' ).siblings().removeClass( 'active' ); //activate tab
			jQuery( target ).fadeIn().show().siblings( '.tab-content' ).hide(); //display section

			realTimeChange( target );

			return false; //prevent page reload
		} );
	} else if ( generator.hasClass( 'selectable' ) ) {
		generator.find( '.wm-select' ).change( function() {
			var target = jQuery( this ).val();

			jQuery( target ).fadeIn().show().siblings( '.tab-content' ).hide(); //display section

			//realTimeChange( target );

			return false; //prevent page reload
		} );
	}



/*
*****************************************************
*      5) APPLY SELECT AND INPUT CHANGES
*****************************************************
*/
	jQuery( 'select, input[type="text"]' ).change( function () {
		var $this  = jQuery( this ),
		    target = ( generator.hasClass( 'tabbed' ) ) ? ( jQuery( '#wm-shortcode-generator .wm-tabs li:first a' ).attr( 'href' ) ) : ( jQuery( '#wm-shortcode-generator .wm-select' ).val() );

		if ( $this.hasClass( 'set-image' ) )
			$this.prev( '.image-before' ).html( '<i class="' + $this.val() + '"></i>' );

		realTimeChange( target );
	} ).change();



/*
*****************************************************
*      6) SENDING THE OUTPUT TO CONTENT
*****************************************************
*/
	jQuery( '.send-to-generator' ).click( function( e ) {
		var parentElement     = jQuery( this ).data( 'parent' ),
		    outputThisElement = jQuery( '#' + parentElement + ' ' + outputShortcodeElement ),
		    outputThis        = outputThisElement.val();

		if ( ! outputThisElement.hasClass( 'dont-close' ) )
			jQuery( '#wm-shortcode-generator' ).dialog( 'close' );

		send_to_editor( outputThis );
		return false;
	} );



} );