/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Admin scripts
*
* CONTENT:
* - 1) Widgets
* - 2) Contextual help toggles
* - 3) Gallery settings
* - 4) Image attachment settings toggle
* - 5) Page list images
* - 6) Setting post ID when adding a new post
*****************************************************
*/

jQuery(function() {



//open "View" button in new window
jQuery( '#view-post-btn a, .view a' ).attr( 'target', '_blank' );

//top of page link
jQuery( '.wm-wrap .separator.top a' ).click( function() {
		jQuery( 'html, body' ).animate({ scrollTop: 0 }, 400 );
		return false;
	} );



/*
*****************************************************
*      1) WIDGETS
*****************************************************
*/
	jQuery( '#widgets-right div.widgets-holder-wrap' ).addClass( 'closed' );
	jQuery( 'div[id*="wmcs-"]' ).prev( 'div.sidebar-name' ).addClass( 'custom-sidebar-name' );

	var $descriptions = jQuery( "#widgets-right .sidebar-description .description" );

	$descriptions.each( function( item ) {
		var $this     = jQuery( this ),
		    $thisText = $this.text();

		$thisText = $thisText.replace( "[", "<strong>Shortcode:</strong><br /><input type='text' onfocus='this.select();' readonly='readonly' value='[" );
		$thisText = $thisText.replace( "]", "]' class='widefat' /></p><p>" );

		$this.html( $thisText );
	} );



/*
*****************************************************
*      2) CONTEXTUAL HELP TOGGLES
*****************************************************
*/
	jQuery( 'div.contextual-help-tab-content.toggle-content, div.shortcode-help-content' ).hide();
	jQuery( 'div.shortcode-help-content' ).prev( 'h3' ).addClass( 'small-toggle-title' );

	jQuery( 'h2.contextual-help-tab-title.toggle-title, .small-toggle-title' ).click( function() {
		jQuery( this ).toggleClass( 'active' ).next( 'div.contextual-help-tab-content.toggle-content, div.shortcode-help-content' ).slideToggle().toggleClass( 'active' );
	} );

	jQuery( '.stick-button' ).click( function() {
		jQuery( this ).closest( '.sticky-content' ).toggleClass( 'active' );
	} );
	jQuery( '.sticky-content' ).hover( function() {
		var $this = jQuery( this );

		if ( $this.hasClass( 'active' ) ) {
			if ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
				$this.stop().animate({ right: 0 }, 250 );
			else
				$this.stop().animate({ left: 0 }, 250 );
		}
	}, function() {
		var $this = jQuery( this );

		if ( $this.hasClass( 'active' ) ) {
			if ( 'rtl' != jQuery( 'html' ).attr( 'dir' ) )
				$this.stop().animate({ right: -270 }, 250 );
			else
				$this.stop().animate({ left: -270 }, 250 );
		}
	} );



/*
*****************************************************
*      3) GALLERY SETTINGS
*****************************************************
*/
	jQuery( '#gallery-settings tbody tr:first-child' ).hide();
	jQuery( '#gallery-settings select#columns option[value="7"], #gallery-settings select#columns option[value="8"], #gallery-settings select#columns option[value="9"]' ).remove();



/*
*****************************************************
*      4) IMAGE ATTACHMENT SETTINGS TOGGLE
*****************************************************
*/
	jQuery( document ).on( 'click', '.toggle-switcher', function() {
			var $this      = jQuery( this ),
			    buttonText = ( '[+]' == $this.find( '.button-change' ).text() ) ? ( '[&ndash;]' ) : ( '[+]' );

			$this.find( '.button-change' ).html( buttonText );
			$this.parent().next( 'div.toggle-these-settings' ).slideToggle();
		} );



/*
*****************************************************
*      5) PAGE LIST IMAGES
*****************************************************
*/
	jQuery( '.wm-image-container.has-thumb' ).hover( function() {
			jQuery( this ).find( '.overlay' ).stop( true, true ).fadeOut( 250 );
		}, function() {
			jQuery( this ).find( '.overlay' ).stop( true, true ).fadeIn( 250 );
		} );



/*
*****************************************************
*      6) SETTING POST ID WHEN ADDING A NEW POST
*****************************************************
*/
	if ( jQuery( 'body.post-new-php input#post_ID' ).length ) {
		var postIdToSet = jQuery( 'body.post-new-php input#post_ID' ).val();

		jQuery( '.js-post-id' ).each( function() {
				var $this        = jQuery( this ),
				    originalHref = $this.attr( 'href' );

				$this.attr( 'href', originalHref.replace( '{{{post_id}}}', postIdToSet ) );
			} );
	}



});