/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel scripts
*
* CONTENT:
* - 1) Basics
* - 2) Toggles
* - 3) Colorpicker
* - 4) File uploader
* - 5) Dynamicly add items
* - 6) Button "Default value"
* - 7) Messages
* - 8) Date picker
* - 9) Pattern preview, layout boxes
* - 10) Inside tabs
* - 11) Select icons
* - 12) WordPress 3.5 media uploader
* - 100) Required auto changes
*****************************************************
*/

jQuery( function() {



/*
*****************************************************
*      1) BASICS
*****************************************************
*/
	//Display form only if JS active
	jQuery( '.wm-wrap' ).removeClass( 'no-js' ).find( '.no-js' ).removeClass( 'no-js' );

	//Submit button position
	if ( jQuery( '#primary-submit' ).length ) {
		var submitButton         = jQuery( '#primary-submit' ),
		    submitButtonPosition = submitButton.offset(),
		    submitButtonWidth    = submitButton.outerWidth(),
		    submitButtonPosRight = jQuery( window ).width() - submitButtonPosition.left - submitButtonWidth;

		submitButton.css( {
				position : 'fixed',
				width    : submitButtonWidth,
				right    : submitButtonPosRight,
				top      : submitButtonPosition.top,
				zIndex   : 9
			} );

		if ( 'rtl' == jQuery( 'html' ).attr( 'dir' ) && ! jQuery( '.wm-wrap' ).hasClass( 'force-ltr' ) )
			jQuery( '.wm-wrap #main' ).css({ marginLeft : submitButtonWidth });
		else
			jQuery( '.wm-wrap #main' ).css({ marginRight : submitButtonWidth });
	}



/*
*****************************************************
*      2) TOGGLES
*****************************************************
*/
	var toggleSections = jQuery( '.option.toggle' ).addClass( 'hide border-top' ),
			togglePatterns = jQuery( '.toggle-patterns' );

	toggleSections.prev( 'h3, h4' ).addClass( 'toggle-heading' );

	toggleSections.prev( 'h3, h4' ).click( function() {
			var $this = jQuery( this ).toggleClass( 'active' ),
			    toggleSection = $this.next( '.option.toggle' );

			if ( toggleSection.hasClass( 'hide' ) )
				toggleSection.removeClass( 'hide' ).hide();

			toggleSection.slideToggle( 250 );
		} );

	togglePatterns.find( '.pattern-boxes' ).hide();
	togglePatterns.find( '.main-label' ).click( function() {
			jQuery( this ).toggleClass( 'active' ).closest( '.toggle-patterns' ).find( '.pattern-boxes' ).slideToggle( 250 );
		} );

	jQuery( '.wm-wrap .help' ).click( function() {
			jQuery( this ).find( 'em' ).fadeToggle().css({ display: 'block' });
		} );



/*
*****************************************************
*      3) COLORPICKER
*****************************************************
*/
	if ( jQuery().ColorPicker ) {
		function rgb2hex( rgb ) {
			if ( -1 == rgb.search( 'rgb' ) ) {
				return rgb; //in case the browser sends hex value already, just return it (IE7 does)
			} else {
				rgb = rgb.match( /^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/ );
				function hex( x ) {
					return ( '0' + parseInt( x ).toString( 16 ) ).slice( -2 );
				}
				return '#' + hex( rgb[1] ) + hex( rgb[2] ) + hex( rgb[3] );
			}
		}

		jQuery( '.color-wrapper' ).mouseenter( function() {
			var $this        = jQuery( this );
			    currentColor = rgb2hex( $this.find( '.color-select .color-display' ).css( 'backgroundColor' ) );

			$this.find( '.color-select' ).ColorPicker({
				onBeforeShow: function() {
						jQuery( this ).ColorPickerSetColor( currentColor );
					},
				onChange: function( hsb, hex, rgb ) {
						$this.find( '.color-select .color-display' ).css({ backgroundColor: '#' + hex });
						jQuery( '.post-type-wm_modules #postimagediv #set-post-thumbnail' ).css({ backgroundColor: '#' + hex });
						//$this.find('.color-text .color-code').text(hex);
						$this.find( '.color-text input[type="text"]' ).attr( 'value', hex );

						if ( $this.data( 'onchange' ) )
							jQuery( $this.data( 'onchange' ) ).css( { backgroundColor : '#' + hex } );
					}
			});
		} );
	}



/*
*****************************************************
*      4) FILE UPLOADER
*****************************************************
*/
	//new media uploader
	jQuery( '.upload-image' ).click( function() {
		var targetFileUploader = jQuery( this ).parent().attr('id'),
		    sendAttachmentBkp  = wp.media.editor.send.attachment;

		wp.media.editor.send.attachment = function( props, attachment ) {
			jQuery( '#' + targetFileUploader + ' input[type="text"]' ).val( attachment.url );
			jQuery( '#' + targetFileUploader + ' input[type="hidden"]' ).val( attachment.id );
			jQuery( 'div.' + targetFileUploader ).removeClass( 'hide' ).find( 'a > img' ).attr( 'src', attachment.url );
			jQuery( 'div.' + targetFileUploader + ' > a' ).attr( 'href', attachment.url );

			wp.media.editor.send.attachment = sendAttachmentBkp;
		}

		wp.media.editor.open();

		return false;
	} );

	//live image preview change
	jQuery( '.image-input-container input' ).on( 'change', function() {
		var $this              = jQuery( this ),
		    imageSrc           = $this.val(),
		    targetFileUploader = $this.parent().attr('id');

		if ( imageSrc ) {
			jQuery( 'div.' + targetFileUploader ).removeClass( 'hide' ).find( 'a > img' ).attr( 'src', imageSrc );
			jQuery( 'div.' + targetFileUploader + ' > a' ).attr( 'href', imageSrc );
		} else {
			jQuery( 'div.' + targetFileUploader ).addClass( 'hide' );
		}
	} );

	//Call fancybox
	if ( jQuery().fancybox ) {
		jQuery( 'a.fancybox' ).fancybox({
			'padding'        : 0,
			'centerOnScroll' : false,
			'overlayOpacity' : 0.6,
			'overlayColor'   : '#000',
			'titleShow'      : false,
			'transitionIn'   : 'elastic',
			'transitionOut'  : 'elastic'
		});
		jQuery( 'a.fancybox.iframe' ).fancybox({
			'padding'        : 20,
			'centerOnScroll' : false,
			'overlayOpacity' : 0.6,
			'overlayColor'   : '#000',
			'width'          : '90%',
			'height'         : '90%',
			'transitionIn'   : 'elastic',
			'transitionOut'  : 'elastic',
			'onStart'        : function(){ jQuery( '#fancybox-content' ).addClass( 'bg-on' ); },
			'onClosed'       : function(){ jQuery( '#fancybox-content' ).removeClass( 'bg-on' ); }
		});
	}

	//upload audio
	jQuery( '.upload-audio' ).click( function() {
		var targetFileUploader = jQuery( this ).parent().attr('id');

		//tb_show('', 'media-upload.php?type=audio&TB_iframe=true');
		tb_show( 'Add/Choose Image', 'media-upload.php?post_id=&type=audio&TB_iframe=true&width=640&height=640' );

		window.send_to_editor = function( html ) {
			var audioUrl = jQuery( html ).attr( 'href' );

			jQuery( '#' + targetFileUploader + ' input[type="text"]' ).val( audioUrl );

			tb_remove();
		}

		return false;
	} );

	//upload video
	jQuery( '.upload-video' ).click( function() {
		var targetFileUploader = jQuery( this ).parent().attr('id');

		//tb_show('', 'media-upload.php?type=video&TB_iframe=true');
		tb_show( 'Add/Choose Image', 'media-upload.php?post_id=&type=video&TB_iframe=true' );

		window.send_to_editor = function( html ) {
			var videoUrl = jQuery( html ).attr( 'href' );

			jQuery( '#' + targetFileUploader + ' input[type="text"]' ).val( videoUrl );

			tb_remove();
		}

		return false;
	} );



/*
*****************************************************
*      5) DYNAMICLY ADD ITEMS
*****************************************************
*/
	jQuery( '.add-items .btn-add' ).click( function() {
		var $this         = jQuery( this ),
		    field         = $this.closest( 'div.add-items' ).find( 'ul li:last' ).clone(true),
		    fieldLocation = $this.closest( 'div.add-items' ).find( 'ul li:last' );

		if( fieldLocation.length < 1 ) {
			alert( 'Please, reload the page' );
			return false;
		}

		jQuery( '.input-field', field ).val( '' ).attr( 'name', function( index, name ) {
			return name.replace( /(\d+)/, function( fullMatch, n ) {
				return Number(n) + 1;
			} );
		} );

		field.insertAfter( fieldLocation, $this.closest( 'div.add-items' ) );

		return false;
	} );

	jQuery( '.add-items .rows .btn-remove' ).click( function() {
		jQuery( this ).parent().remove();
		return false;
	} );

	if ( jQuery().sortable ) {
		jQuery( '.add-items .rows' ).sortable({
			opacity : 0.6,
			revert  : true,
			cursor  : 'move',
			handle  : '.sort-handle'
		});
	}



/*
*****************************************************
*      6) BUTTON "DEFAULT VALUE"
*****************************************************
*/
	jQuery( '.btn-default' ).click( function() {
		var $this              = jQuery( this ),
		    targetInputFieldID = $this.data( 'default' ),
		    targetDefaultValue = $this.find( 'span' ).text();

		if ( $this.hasClass( 'default-color' ) ) {

			$this.parent().next().find( '.color-display' ).css({ backgroundColor: '#' + targetDefaultValue });
			jQuery( '#' + targetInputFieldID ).attr( 'value', targetDefaultValue );

		} else if ( $this.hasClass( 'default-slider' ) ) {

			jQuery( '#' + targetInputFieldID + '-slider' ).slider( 'option', 'value', targetDefaultValue );
			jQuery( '#' + targetInputFieldID ).attr( 'value', targetDefaultValue );

		} else {

			jQuery( '#' + targetInputFieldID ).attr( 'value', targetDefaultValue );

			//live image change
			if ( targetDefaultValue ) {
				jQuery( 'div.' + targetInputFieldID + '-file' ).removeClass( 'hide' ).find( 'a > img' ).attr( 'src', targetDefaultValue );
				jQuery( 'div.' + targetInputFieldID + '-file > a' ).attr( 'href', targetDefaultValue );
			} else {
				jQuery( 'div.' + targetInputFieldID + '-file' ).addClass( 'hide' );
			}

		}
	} );



/*
*****************************************************
*      7) MESSAGES
*****************************************************
*/
	if ( jQuery( '#message.wm-message' ).length ) {
		jQuery( '.wm-message' ).hide().fadeIn( 300, function() {
			var $this     = jQuery( this ),
			    delayTime = ( $this.hasClass( 'delay-long') ) ? ( 10000 ) : ( 3500 );

			$this.delay( delayTime ).fadeOut( 300, function() {
				$this.remove();
			} );
		} );
	}

	jQuery( '.wm-wrap .confirm' ).click( function() {
	    var btnUrl   = jQuery( this ).attr( 'href' ),
			    modalBox = jQuery( '.wm-wrap .modal-box' ).fadeIn();

			modalBox.find( 'a' ).click( function() {
					var modalAction = jQuery( this ).data( 'action' );

					if ( 'stay' === modalAction )
						modalBox.fadeOut();
					else
						window.location = btnUrl;
				} );

			return false;
		} );



/*
*****************************************************
*      8) DATE PICKER
*****************************************************
*/
	if ( jQuery().datepicker ) {
		jQuery( '.wm-wrap input[data-type="date"]' ).datepicker( {
				dateFormat : "yy-mm-dd"
			} );
		jQuery( '.wm-wrap input[data-type="date"].future' ).datepicker( "option", "minDate", new Date() );
		jQuery( '.wm-wrap input[data-type="date"].past' ).datepicker( "option", "maxDate", new Date() );
	} // /datepicker



/*
*****************************************************
*      9) PATTERN PREVIEW, LAYOUT BOXES
*****************************************************
*/
	jQuery( '.wm-wrap .pattern-box span' ).click( function() {
			var $this      = jQuery( this ),
			    background = $this.attr( 'style' );

			$this.closest( '.pattern-boxes' ).find( '.pattern-preview div' ).attr( 'style', background ).fadeIn();
		} );

	jQuery( '.pattern-boxes input' ).on( 'change', function() {
			jQuery( this ).parent().addClass( 'active' ).siblings( '.pattern-box' ).removeClass( 'active' );
		} );
	jQuery( '.layout-boxes input' ).on( 'change', function() {
			jQuery( this ).parent().addClass( 'active' ).siblings( '.layout-box' ).removeClass( 'active' );
		} );



/*
*****************************************************
*      10) INSIDE TABS
*****************************************************
*/
	jQuery( '.wm-wrap .inside-tab-content' ).hide();
	jQuery( '.wm-wrap .inside-tabs + .inside-tab-content' ).show();
	jQuery( '.wm-wrap .inside-tabs li:first-child' ).addClass( 'active' );

	jQuery( '.wm-wrap .inside-tabs a' ).click( function() {
			var $this = jQuery( this ).parent( 'li' );

			$this.addClass( 'active' ).siblings( 'li' ).removeClass( 'active' );
			$this.closest( '.option' ).find( '.inside-tab-content' ).hide().eq( $this.index() ).show();
			//$this.parent( '.inside-tabs' ).nextAll( '.inside-tab-content' ).hide().eq( $this.index() ).show();

			return false;
		} );



/*
*****************************************************
*      11) SELECT ICONS
*****************************************************
*/
	jQuery( '.icons-selector select' ).change( function () {
		var $this = jQuery( this );
		$this.prev( 'i' ).attr( 'class', $this.val() );
	} );



/*
*****************************************************
*      12) WORDPRESS 3.5 MEDIA UPLOADER
*****************************************************
*/
	//setting featured image
	wmFeaturedImage = {
		get: function() {
			return wp.media.view.settings.post.featuredImageId;
		},

		set: function( id ) {
			var settings = wp.media.view.settings;

			settings.post.featuredImageId = id;

			wp.media.post( 'set-post-thumbnail', {
					json         : true,
					post_id      : settings.post.id,
					thumbnail_id : settings.post.featuredImageId,
					_wpnonce     : settings.post.nonce
				} ).done( function( html ) {
					jQuery( '.inside', '#postimagediv' ).html( html );
				} );
		},

		frame: function() {
			if ( this._frame )
				return this._frame;

			this._frame = wp.media( {
					state: 'featured-image',
					states: [ new wp.media.controller.FeaturedImage() ]
				} );

			this._frame.on( 'toolbar:create:featured-image', function( toolbar ) {
					this.createSelectToolbar( toolbar, {
						text: wp.media.view.l10n.setFeaturedImage
					} );
				}, this._frame );

			this._frame.state('featured-image').on( 'select', this.select );

			return this._frame;
		},

		select: function() {
			var settings  = wp.media.view.settings,
			    selection = this.get( 'selection' ).single();

			if ( ! settings.post.featuredImageId )
				return;

			wmFeaturedImage.set( selection ? selection.id : -1 );
		},

		init: function() {
			//open the content media manager to the 'featured image' tab
			jQuery( '.button-set-featured-image' ).on( 'click', function( event ) {
					event.preventDefault();
					// Stop propagation to prevent thickbox from activating.
					event.stopPropagation();

					wmFeaturedImage.frame().open();
				} );
		}
	};
	wmFeaturedImage.init();



/*
*****************************************************
*      100) REQUIRED AUTO CHANGES
*****************************************************
*/
	//Required select field changes on load
	jQuery( 'select[name="page_template"], .wm-wrap select' ).change();



} );