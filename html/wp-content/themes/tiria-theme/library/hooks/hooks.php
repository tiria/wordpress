<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Hooks
*
* CONTENT:
* - 1) Header
* - 2) Main content area
* - 3) Sidebar
* - 4) Footer
*****************************************************
*/





/*
*****************************************************
*      1) HEADER
*****************************************************
*/
	/*
	* Before website's header
	*/
	function wm_before_header() {
		do_action( 'wm_before_header' );
	}

	/*
	* After website's header
	*/
	function wm_after_header() {
		do_action( 'wm_after_header' );
	}





/*
*****************************************************
*      2) MAIN CONTENT AREA
*****************************************************
*/
	/*
	* Before main content (immediately after DIV.content)
	*/
	function wm_before_main_content() {
		do_action( 'wm_before_main_content' );
	}

	/*
	* After main content (last thing in DIV.content)
	*/
	function wm_after_main_content() {
		do_action( 'wm_after_main_content' );
	}

	/*
	* Main content start
	*/
	function wm_start_main_content() {
		do_action( 'wm_start_main_content' );
	}

	/*
	* Before post content
	*/
	function wm_before_post() {
		do_action( 'wm_before_post' );
	}

	/*
	* After post content
	*/
	function wm_after_post() {
		do_action( 'wm_after_post' );
	}

	/*
	* Post/page content start
	*/
	function wm_start_post() {
		do_action( 'wm_start_post' );
	}

	/*
	* Post/page content end
	*/
	function wm_end_post() {
		do_action( 'wm_end_post' );
	}

	/*
	* Before posts list
	*/
	function wm_before_list() {
		do_action( 'wm_before_list' );
	}

	/*
	* After posts list
	*/
	function wm_after_list() {
		do_action( 'wm_after_list' );
	}

	/*
	* Before post bottom metas
	*/
	function wm_before_bottom_meta() {
		do_action( 'wm_before_bottom_meta' );
	}





/*
*****************************************************
*      3) SIDEBAR
*****************************************************
*/
	/*
	* Sidebar top
	*/
	function wm_start_sidebar() {
		do_action( 'wm_start_sidebar' );
	}

	/*
	* Sidebar bottom
	*/
	function wm_end_sidebar() {
		do_action( 'wm_end_sidebar' );
	}





/*
*****************************************************
*      4) FOOTER
*****************************************************
*/
	/*
	* Before website's footer
	*/
	function wm_before_footer() {
		do_action( 'wm_before_footer' );
	}

	/*
	* After website's footer
	*/
	function wm_after_footer() {
		do_action( 'wm_after_footer' );
	}

?>