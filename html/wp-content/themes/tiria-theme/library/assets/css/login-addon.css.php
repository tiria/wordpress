<?php
//include WP core
require_once '../../../../../../wp-load.php';





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/
	$out = '';

	//$loginError = ( wm_option( 'security-login-error' ) ) ? ( '#login_error {display: none}' ) : ( '' );

	//Array of custom styles from admin panel
		$customStyles = array(

			array(
				'selector' => 'html, body.login',
				'styles' => array(
					'height' => '100%',
					'background' => wm_css_background( 'branding-login-' ),
					)
			),

			array(
				'selector' => '#loginform, #registerform, #lostpasswordform',
				'styles' => array(
					'background' => wm_option( 'branding-login-form-bg-color', 'color' ),
					'border' => 'none',
					'-webkit-box-shadow' => '0 4px 10px -1px rgba(0,0,0, 0.5)',
					'-mox-box-shadow' => '0 4px 10px -1px rgba(0,0,0, 0.5)',
					'box-shadow' => '0 4px 10px -1px rgba(0,0,0, 0.5)',
					)
			),

			array(
				'selector' => 'label',
				'styles' => array(
					'color' => ( wm_option( 'branding-login-form-bg-color' ) && WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'branding-login-form-bg-color' ) ) ) ? ( '#ccc !important' ) : ( '#333 !important' ),
					)
			),

			array(
				'selector' => 'input[type=submit]',
				'styles' => array(
					'background' => wm_option( 'branding-login-form-button-bg-color', 'color !important' ),
					'border-color' => wm_option( 'branding-login-form-button-bg-color', 'color !important' ),
					'color' => ( wm_option( 'branding-login-form-button-bg-color' ) && WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'branding-login-form-button-bg-color' ) ) ) ? ( '#fff !important' ) : ( '#000 !important' ),
					'text-transform' => 'uppercase',
					'text-shadow' => 'none',
					)
			),

			array(
				'selector' => '.login .message, .login #login_error',
				'styles' => array(
					'background' => wm_option( 'branding-login-message-bg-color', 'color' ),
					'border-color' => wm_option( 'branding-login-message-bg-color', 'color' ),
					'color' => ( wm_option( 'branding-login-message-bg-color' ) && WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'branding-login-message-bg-color' ) ) ) ? ( '#fff !important' ) : ( '#000 !important' ),
					)
			),
			array(
				'selector' => '.login .message a, .login #login_error a',
				'styles' => array(
					'color' => ( wm_option( 'branding-login-message-bg-color' ) && WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'branding-login-message-bg-color' ) ) ) ? ( '#fff !important' ) : ( '#000 !important' ),
					)
			),

			array(
				'selector' => 'h1 a, #login h1 a',
				'styles' => array(
					'background' => wm_option( 'branding-login-logo', 'bgimg' ),
					'background-repeat' => 'no-repeat',
					'background-position' => '50% 50%',
					'background-size' => 'contain',
					'display' => 'block',
					'width' => '310px',
					'height' => ( wm_option( 'branding-login-logo-height' ) ) ? ( absint( wm_option( 'branding-login-logo-height' ) ) . 'px' ) : ( '100px' ),
					'margin-left' => '10px',
					'padding' => '0',
					'text-indent' => '-999em',
					'overflow' => 'hidden',
					)
			),

			array(
				'selector' => '.login #nav a, .login #backtoblog a, .login #nav a:hover, .login #backtoblog a:hover, .login #login_error a, .login #login_error a:hover',
				'styles' => array(
					'background' => wm_option( 'branding-login-link-bg-color', 'color' ),
					'color' => wm_option( 'branding-login-link-color', 'color !important' ),
					'padding' => '3px',
					'text-shadow' => 'none',
					)
			)

		);



	//WordPress 3.1
		if ( ! wm_check_wp_version( '3.2' ) ) {
			array_push( $customStyles,
				array(
					'selector' => 'p#backtoblog',
					'styles' => array(
						'display' => 'inline',
						'width' => '320px',
						'height' => 'auto',
						'left' => '50%',
						'top' => '0',
						'border' => 'none',
						'padding' => '0',
						'margin' => '0 0 0 -160px',
						'text-align' => 'center',
						'line-height' => '18px',
						'background' => 'transparent'
					)
				)
			);
		}



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
			$out .= "/* Custom login styles */\r\n" . $outStyles;
	}

	//$out .= $loginError;





/*
*****************************************************
*      CSS HEADER
*****************************************************
*/

	$expireTime = ( wm_option( 'general-no-css-cache' ) ) ? ( 0 ) : ( WM_CSS_EXPIRATION );

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expireTime ) . ' GMT' );
	header( 'cache-control: public, max-age=' . $expireTime );

	if ( ( isset( $_GET['c'] ) && $_GET['c'] ) || ( wm_option( 'branding-minimize-css' ) ) )
		$out = wm_minimize_css( $out );

	echo $out;

?>