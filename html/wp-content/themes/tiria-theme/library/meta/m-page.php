<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Page meta boxes generator
*
* CONTENT:
* - 1) Meta box form
* - 2) Add meta box
*****************************************************
*/





/*
*****************************************************
*      1) META BOX FORM
*****************************************************
*/
	require_once( WM_META . 'a-meta-page.php' ); //Have to insert this to keep the localization impact minimal





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_page_generate_metabox' ) ) {
		function wm_page_generate_metabox() {
			$wm_page_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_meta_page_options(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-page-meta',
				//post types
				'pages'          => array( 'page' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Page settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_page_generate_metabox

	add_action( 'init', 'wm_page_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>