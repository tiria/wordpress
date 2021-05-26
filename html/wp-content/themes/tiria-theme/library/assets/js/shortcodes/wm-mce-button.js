/*
*****************************************************
*      WEBMAN TINYMCE BUTTON
*****************************************************
*/
// if ( ! jQuery.browser.msie ) {

(function() {
	tinymce.create( 'tinymce.plugins.wmShortcodes', {
		/**
		* Initializes the plugin, this will be executed after the plugin has been created.
		* This call is done before the editor instance has finished it's initialization so use the onInit event
		* of the editor instance to intercept that event.
		*
		* @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		* @param {string} url Absolute URL to where the plugin is located.
		*/
		init : function( ed, url ) {

			//SHORTCODES GENERATOR BUTTON
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand( 'wmShortcodes', function() {
				jQuery( '#wm-shortcode-generator' ).dialog( 'open' );
			} );

			// Register example button
			ed.addButton( 'wm_mce_button_shortcodes', {
				title : 'Shortcode Generator',
				image : url + '/../../img/shortcodes/shortcodes.png',
				cmd   : 'wmShortcodes'
			} );



			//LINE BEFORE BUTTON
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand( 'wmLineAbove', function() {
				if ( window.tinyMCE ) {
					var node        = tinyMCE.activeEditor.selection.getNode(),
					    parents     = tinyMCE.activeEditor.dom.getParents(node).reverse(),
					    grandParent = parents[2];
					    insertion   = document.createElement('p');

					insertion.innerHTML = '&nbsp;';

					if ( typeof 'undefined' != grandParent )
						grandParent.parentNode.insertBefore( insertion, grandParent );
					else if ( typeof 'undefined' != node )
						node.parentNode.insertBefore( insertion, node );

					var range    = document.createRange(),
					    textNode = insertion;

					range.setStart( textNode, 0 );
					range.setEnd( textNode, 0 );

					tinyMCE.activeEditor.selection.setRng( range );
				}
			} );

			// Register example button
			ed.addButton( 'wm_mce_button_line_above', {
				title : 'New line above',
				image : url + '/../../img/shortcodes/line-above.png',
				cmd   : 'wmLineAbove'
			} );



			//LINE AFTER BUTTON
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand( 'wmLineBelow', function() {
				if ( window.tinyMCE ) {
					var node        = tinyMCE.activeEditor.selection.getNode(),
					    parents     = tinyMCE.activeEditor.dom.getParents(node).reverse(),
					    grandParent = parents[2];
					    insertion   = document.createElement('p');

					insertion.innerHTML = '&nbsp;';

					if ( typeof 'undefined' != grandParent )
						tinyMCE.activeEditor.dom.insertAfter( insertion, grandParent );
					else if ( typeof 'undefined' != node )
						tinyMCE.activeEditor.dom.insertAfter( insertion, node );

					var range    = document.createRange(),
					    textNode = insertion;

					range.setStart( textNode, 0 );
					range.setEnd( textNode, 0 );

					tinyMCE.activeEditor.selection.setRng( range );
				}
			} );

			// Register example button
			ed.addButton( 'wm_mce_button_line_below', {
				title : 'New line below',
				image : url + '/../../img/shortcodes/line-below.png',
				cmd   : 'wmLineBelow'
			} );

		},

		/**
		* Returns information about the plugin as a name/value array.
		* The current keys are longname, author, authorurl, infourl and version.
		*
		* @return {Object} Name/value array containing information about the plugin.
		*/
		getInfo : function() {
			return {
				longname  : 'Shortcode Generator',
				author    : 'Tiria - www.tiria.fr',
				authorurl : 'http://www.tiria.fr',
				infourl   : '',
				version   : '1.0'
			};
		}
	} );

	// Register plugin
	tinymce.PluginManager.add( 'wm_mce_button', tinymce.plugins.wmShortcodes );
})();

// } // /MS IE check (issue with shortcode insertion on cursor position in Internet Explorer)