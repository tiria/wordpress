<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Contextual help generator
*
* CONTENT:
* - 1) Required files
* - 2) Actions and filters
* - 3) Help display
*****************************************************
*/





/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	//Load the help text
	require_once( WM_HELP . 'a-help.php' );





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Help
		add_action( 'contextual_help', 'wm_help', 10, 3 );





/*
*****************************************************
*      3) HELP DISPLAY
*****************************************************
*/
	/*
	* Contextual help text
	*
	* $contextual_help, $screen_id, $screen - check WordPress codex for info
	*/
	if ( ! function_exists( 'wm_help' ) ) {
		function wm_help( $contextual_help, $screen_id, $screen ) {
			global $helpTexts;

			if ( wm_check_wp_version( '3.3' ) ) {
			//WP3.3+

				if ( isset( $helpTexts[$screen_id] ) && is_array( $helpTexts[$screen_id] ) ) {
					$contextualHelpTabs = $helpTexts[$screen_id];
					foreach ( $contextualHelpTabs as $contextualHelpTab ) {
						$screen->add_help_tab( array(
							'id'      => $contextualHelpTab['tabId'],
							'title'   => $contextualHelpTab['tabTitle'],
							'content' => $contextualHelpTab['tabContent']
						) );
					}
				}

				//User Manual link everywhere
				$screen->add_help_tab( array(
					'id'      => 'theme-user-manual',
					'title'   => __( 'User Manual', 'clifden_domain_help' ),
					'content' => '<h3>' . __( 'Theme online user manual', 'clifden_domain_help' ) . '</h3><p>' . sprintf( __( 'For further assistance please check the online <a href="%1s" target="_blank">%2s User Manual</a>.', 'clifden_domain_help' ), WM_ONLINE_MANUAL_URL, WM_THEME_NAME ) . '</p>',
				) );

			} else {
			//WP3.3-

				return $contextual_help;

			}
		}
	} // /wm_help

?>