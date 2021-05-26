<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Page excerpt metabox
*
* CONTENT:
* - 1) Actions and filters
* - 2) Meta box form
* - 3) Saving meta
* - 4) Add meta box
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding meta boxes
		add_action( 'add_meta_boxes', 'wm_excerpt_meta_admin_box' );
		add_action( 'save_post', 'wm_excerpt_metabox_save' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta form generator
	*
	* $post = OBJ [current post object]
	*/
	if ( ! function_exists( 'wm_excerpt_meta_form' ) ) {
		function wm_excerpt_meta_form( $post ) {
			//had to create a new metafield as excerpt is being HTML excaped...
			$excerpt = get_post_meta( $post->ID, 'page_excerpt', true );

			wp_nonce_field( 'wm_excerpt_meta-metabox-nonce', 'wm_excerpt_meta-metabox-nonce' );

			echo '<div class="wm-wrap meta">';
				wp_editor( $excerpt, 'page_excerpt' );
			echo '</div>';
		}
	} // /wm_excerpt_meta_form





/*
*****************************************************
*      3) SAVING META
*****************************************************
*/
	/*
	* Saves post meta options
	*
	* $post_id = # [current post ID]
	*/
	if ( ! function_exists( 'wm_excerpt_metabox_save' ) ) {
		function wm_excerpt_metabox_save( $post_id ) {
			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_excerpt_meta-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_excerpt_meta-metabox-nonce'], 'wm_excerpt_meta-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

			//Save the data
			if ( isset( $_POST['page_excerpt'] ) && $_POST['page_excerpt'] )
				update_post_meta( $post_id, 'page_excerpt', $_POST['page_excerpt'] );
			else
				delete_post_meta( $post_id, 'page_excerpt' );
		}
	} // /wm_excerpt_metabox_save





/*
*****************************************************
*      4) ADD META BOX
*****************************************************
*/
	/*
	* Add meta box
	*/
	if ( ! function_exists( 'wm_excerpt_meta_admin_box' ) ) {
		function wm_excerpt_meta_admin_box() {
			add_meta_box( 'wm-metabox-wm_excerpt_meta-meta', __( 'Page excerpt', 'clifden_domain_adm' ), 'wm_excerpt_meta_form', 'page', 'normal', 'high' );
		}
	} // /wm_excerpt_meta_admin_box

?>