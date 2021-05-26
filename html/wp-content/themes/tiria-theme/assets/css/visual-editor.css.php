<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by WebMan - www.webmandesign.eu
*
* CSS stylesheet for WordPress visual editor
*****************************************************
*/

	//include WP core
		require_once '../../../../../wp-load.php';





/*
*****************************************************
*      OUTPUT
*****************************************************
*/

	$out = '';

	ob_start(); //This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.



	//Start including files and editing output
	@readfile( 'normalize.css' );
	@readfile( 'core.css' );
	@readfile( 'wp-styles.css' );
	@readfile( 'typography.css' );
	@readfile( 'icons.css' );
	@readfile( 'columns-content.css' );
	@readfile( 'columns-s930.css' );
	@readfile( 'shortcodes.css' );
	@readfile( 'visual-editor-core.css' );

	//Stop including files and editing output
	$out = ob_get_clean(); //output and clean the buffer





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/

	//fonts
		$basicPrimaryFontElements = '
			body,
			.font-primary,
			.quote-source,
			input, select, textarea,
			a.btn, input[type="submit"]
			';
		$basicSecondaryFontElements = '
			.font-secondary,
			h1, h2, h3, h4, h5, h6,
			.hero, .call-to-action,
			blockquote
			';
		$basicTerciaryFontElements = '
			.main-heading h2,
			.size-huge
			';



	//Array of custom styles from admin panel
		$customStyles = array(

			//line-height fix (not to include SPAN with inline styles in visual editor)
				array(
					'selector' => 'body',
					'styles'   => array(
						'line-height' => 'auto',
						)
				),

			/* fonts */
				array(
					'selector' => $basicPrimaryFontElements,
					'styles' => array(
						'font-family' => 'Helvetica, Arial, sans-serif',
						'font-size' => '13px',
					)
				),
				array(
					'selector' => $basicSecondaryFontElements,
					'styles' => array(
						'font-family' => 'Georgia, serif',
					)
				),
				array(
					'selector' => $basicTerciaryFontElements,
					'styles' => array(
						'font-family' => 'Georgia, serif',
					)
				),
				array(
					'selector' => 'h1, h2, h3, h4, h5, h6',
					'styles' => array(
						'font-family' => 'Helvetica, Arial, sans-serif',
						)
				),

		);



	//Generate CSS output
	if ( ! empty( $customStyles ) ) {
		$outStyles = '';

		foreach ( $customStyles as $selector ) {
			if ( isset( $selector['styles'] ) && is_array( $selector['styles'] ) && ! empty( $selector['styles'] ) ) {
				$selectorStyles = '';
				foreach ( $selector['styles'] as $property => $style ) {
					if ( isset( $style ) && $style )
						$selectorStyles .= $property . ': ' . $style . '; ';
				}

				if ( $selectorStyles )
					$outStyles .= $selector['selector'] . ' {' . $selectorStyles . '}' . "\r\n";
			}
		}

		if ( $outStyles )
			$out .= "\r\n\r\n\r\n/* Custom styles */\r\n" . $outStyles;
	}





/*
*****************************************************
*      CSS HEADER
*****************************************************
*/

	$expireTime = ( wm_option( 'general-no-css-cache' ) ) ? ( 0 ) : ( WM_CSS_EXPIRATION );

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expireTime ) . ' GMT' );
	header( 'cache-control: public, max-age=' . $expireTime );

	$out = wm_minimize_css( $out );

	echo $out;

	//Clean the buffer
	//ob_end_clean();

?>