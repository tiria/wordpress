<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Tiria functions
*
*****************************************************
*/

function tiria_register_assets(){
	//register style
	/*** exemple *** : wp_register_style( 'scrollbarcss', WM_ASSETS_THEME . 'css/scrollbar/jquery.mCustomScrollbar.css', false, WM_SCRIPTS_VERSION, 'screen' );

	//register scripts
	/*** exemple *** : wp_register_script( 'scrollbar', WM_ASSETS_THEME . 'js/jquery.scrollbar/jquery.mCustomScrollbar.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );**/
	wp_register_script( 'psshow', WM_ASSETS_THEME . 'js/psshow.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
	wp_register_script( 'staffdetails', WM_ASSETS_THEME . 'js/staffdetails.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
	wp_register_script( 'tiriascripts', WM_ASSETS_THEME . 'js/tiriascripts.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
}
add_action('init','tiria_register_assets');

//enqueue style (head) and scripts (footer)
function tiria_scripts(){
	wp_enqueue_script( 'tiriascripts' );
}
add_action('wp_enqueue_scripts','tiria_scripts');

//compatibility with new contact form db
function contactic_elementor_compat($record, $ajax_handler){
	$data = (object)[
		'title' => $record->get_form_settings( 'form_name' ),
		'posted_data' => $record->get_formatted_data( true ),
	];
	// Call hook to submit data
	do_action_ref_array( 'cfdb_submit', [ $data ] );
}
add_action('elementor_pro/forms/new_record','contactic_elementor_compat',10,2);

//woocommerce support
function woocommerce_support(){
    add_theme_support( 'woocommerce' );
} 
add_action('after_setup_theme','woocommerce_support');

//mailpoet admin style fix
function tiria_mailpoet_conflict($styles){
	$styles[] = 'admin-addon.css';
	$styles[] = 'admin-addon-38.css';
	return $styles;
}
add_filter('mailpoet_conflict_resolver_whitelist_style', 'tiria_mailpoet_conflict');

//print customised script
/*** exemple ***
 *function active_scrollbar() { ?>
 *<script type="text/javascript">
 *	jQuery(document).ready(function($) {
 *		$(".scrollbar").mCustomScrollbar({
 *			theme:"rounded-dark"
 *		});
 *	});
 *</script><?php }
 *add_action('wp_footer', 'active_scrollbar');
 ***/

//functions
function get_image_sizes( $size = '' ) {
	global $_wp_additional_image_sizes;
	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();
	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {
		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
			$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
			$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
			$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array( 
				'width' => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
			);
		}
	}
	// Get only 1 size if found
	if ( $size ) {
		if( isset( $sizes[ $size ] ) ) {
			return $sizes[ $size ];
		} else {
			return false;
		}
	}
	return $sizes;
}