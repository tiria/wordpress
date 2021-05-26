/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel navigation and tabs scripts
*****************************************************
*/

jQuery( function() {



/*
*****************************************************
*      TABS
*****************************************************
*/
	//reset HTML
		jQuery( '.tab-content' ).css({ border: 'none' }).hide();
		jQuery( '.tabs.sub' ).css({ display: 'block' });

		var defaultMainNav     = ( jQuery.cookie( 'wmOptPanelNav' ) ) ? ( jQuery.cookie( 'wmOptPanelNav' ) ) : ( 'item-1' ),
		    defaultMainSection = jQuery( '.wm-wrap #nav .tabs li.' + defaultMainNav + ' a' ).attr( 'href' ),
		    defaultSubTab      = ( jQuery.cookie( 'wmOptPanelSubnav' ) ) ? ( jQuery.cookie( 'wmOptPanelSubnav' ) ) : ( 'item-1' ),
		    defaultSubSection  = jQuery( '.wm-wrap ' + defaultMainSection + ' .tabs.sub li.' + defaultSubTab + ' a' ).attr( 'href' );

		if ( ! jQuery( '.wm-wrap #nav .tabs li.' + defaultMainNav ).length || ! jQuery( '.wm-wrap ' + defaultMainSection + ' .tabs.sub li.' + defaultSubTab ).length ) {
			var defaultMainNav = 'item-1',
			    defaultMainSection = jQuery( '.wm-wrap #nav .tabs li.' + defaultMainNav + ' a' ).attr( 'href' ),
			    defaultSubTab      = 'item-1',
		    	defaultSubSection  = jQuery( '.wm-wrap ' + defaultMainSection + ' .tabs.sub li.' + defaultSubTab + ' a' ).attr( 'href' );
		}

		jQuery( '.wm-wrap #nav .tabs li.' + defaultMainNav ).addClass( 'active' ).siblings().removeClass( 'active' );
		jQuery( '.wm-wrap ' + defaultMainSection + ' .tabs.sub li.' + defaultSubTab ).addClass( 'active' ).siblings().removeClass( 'active' );
		jQuery( defaultSubSection ).fadeIn();



	//set variables
		var targetNav       = jQuery( '#nav li.active a' ).attr( 'href' ),
		    targetSub       = jQuery( '.tabs.sub li.active a' ).attr( 'href' ),
		    mainNavSelected = jQuery( '.wm-wrap #nav li.active' ).attr( 'class' ).split( /\s+/ ),
		    sectionParent   = jQuery( '.wm-wrap #nav li.active a' ).attr( 'href' ),
		    subNavSelected  = jQuery( '.wm-wrap ' + sectionParent + ' .tabs.sub li.active' ).attr( 'class' ).split( /\s+/ );

	jQuery( targetNav ).show();
	jQuery( targetSub ).show();

	//set first cookies
		jQuery.cookie( 'wmOptPanelNav', mainNavSelected[0] );
		jQuery.cookie( 'wmOptPanelSubnav', subNavSelected[0] );



	//switching tabs
	jQuery( '.wm-wrap .tabs a' ).click( function() {
		var $this         = jQuery( this ),
		    target        = $this.attr( 'href' ),
		    subTabClicked = $this.closest('ul').hasClass('sub');

		$this.parent().addClass( 'active' ).siblings().removeClass( 'active' ); //activate tab
		jQuery( target ).fadeIn().show().siblings( '.tab-content' ).hide(); //display section

		if ( ! subTabClicked ) {
			jQuery( target + ' .tabs.sub li.item-1' ).addClass( 'active' ).siblings().removeClass( 'active' ); //activate first sub tab

			var targetSub = jQuery( target + ' .tabs.sub li.active a' ).attr( 'href' ); //get sub tab target
			jQuery( targetSub ).fadeIn().show().siblings( '.tab-content.sub' ).hide(); //display sub tab target
		}

		//set cookies
		var mainNavSelected = jQuery( '.wm-wrap #nav li.active' ).attr( 'class' ).split( /\s+/ ),
		    sectionParent   = jQuery( '.wm-wrap #nav li.active a' ).attr( 'href' ),
		    subNavSelected  = jQuery( '.wm-wrap ' + sectionParent + ' .tabs.sub li.active' ).attr( 'class' ).split( /\s+/ );

		jQuery.cookie( 'wmOptPanelNav', mainNavSelected[0] );
		jQuery.cookie( 'wmOptPanelSubnav', subNavSelected[0] );

		return false;
	} );



} );