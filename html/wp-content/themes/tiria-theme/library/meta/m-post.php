<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Post meta boxes generator
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
	require_once( WM_META . 'a-meta-post.php' ); //Have to insert this to keep the localization impact minimal





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_post_generate_metabox' ) ) {
		function wm_post_generate_metabox() {
			$wm_post_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_meta_post_options(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-post-meta',
				//post types
				'pages'          => array( 'post' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Post settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
				'visual-wrapper-add' => wm_meta_post_options_formats(),
			) );
		}
	} // /wm_post_generate_metabox

	add_action( 'init', 'wm_post_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>