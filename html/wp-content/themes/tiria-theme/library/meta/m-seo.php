<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* SEO meta boxes on post/page edit screen
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
		add_action( 'add_meta_boxes', 'wm_seo_meta_admin_box' );
		//Saving CP
		add_action( 'save_post', 'wm_seo_meta_save_meta' );





/*
*****************************************************
*      2) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_seo_meta_meta_fields' ) ) {
		function wm_seo_meta_meta_fields() {
			$prefix     = 'seo-';
			$metaFields = array(

				//SEO settings
				array(
					"type" => "section-open",
					"section-id" => "seo-settings",
					"title" => __( 'SEO settings', 'clifden_domain_adm' )
				),
					array(
						"type" => "textarea",
						"id" => $prefix."description",
						"label" => __( "Description", 'clifden_domain_adm' ),
						"desc" => __( 'SEO meta description', 'clifden_domain_adm' ),
						"validate" => "lineBreakComma",
						"cols" => 34,
						"rows" => 3
					),
					array(
						"type" => "textarea",
						"id" => $prefix."keywords",
						"label" => __( "Keywords", 'clifden_domain_adm' ),
						"desc" => __( 'SEO keywords (comma separated)', 'clifden_domain_adm' ),
						"validate" => "lineBreakComma",
						"cols" => 34,
						"rows" => 2
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."noindex",
						"label" => __( 'Do not index', 'clifden_domain_adm' ),
						"desc" => __( 'Prevents search engines to index this page or post', 'clifden_domain_adm' ),
						"value" => "true"
					),
				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_seo_meta_meta_fields



	/*
	* Meta form generator
	*
	* $post = OBJ [current post object]
	*/
	if ( ! function_exists( 'wm_seo_meta_meta_options' ) ) {
		function wm_seo_meta_meta_options( $post ) {
			wp_nonce_field( 'wm_seo_meta-metabox-nonce', 'wm_seo_meta-metabox-nonce' );

			//Display custom meta box form HTML
			$metaFields = wm_seo_meta_meta_fields();

			wm_cp_meta_form_generator( $metaFields );
		}
	} // /wm_seo_meta_meta_options





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
	if ( ! function_exists( 'wm_seo_meta_save_meta' ) ) {
		function wm_seo_meta_save_meta( $post_id ) {
			//Return when doing an auto save
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;
			//If the nonce isn't there, or we can't verify it, return
			if ( ! isset( $_POST['wm_seo_meta-metabox-nonce'] ) || ! wp_verify_nonce( $_POST['wm_seo_meta-metabox-nonce'], 'wm_seo_meta-metabox-nonce' ) )
				return $post_id;
			//If current user can't edit this post, return
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;

			//Save each meta field separately
			$metaFields = wm_seo_meta_meta_fields();

			wm_save_meta( $post_id, $metaFields );
		}
	} // /wm_seo_meta_save_meta





/*
*****************************************************
*      4) ADD META BOX
*****************************************************
*/
	/*
	* Add meta box
	*/
	if ( ! function_exists( 'wm_seo_meta_admin_box' ) ) {
		function wm_seo_meta_admin_box() {
			add_meta_box( 'wm-metabox-wm_seo_meta-meta', __( 'SEO settings', 'clifden_domain_adm' ), 'wm_seo_meta_meta_options', 'page', 'side', 'default' );
			add_meta_box( 'wm-metabox-wm_seo_meta-meta', __( 'SEO settings', 'clifden_domain_adm' ), 'wm_seo_meta_meta_options', 'post', 'side', 'default' );
			add_meta_box( 'wm-metabox-wm_seo_meta-meta', __( 'SEO settings', 'clifden_domain_adm' ), 'wm_seo_meta_meta_options', 'wm_projects', 'side', 'default' );
			if ( wm_option( 'general-staff-rich' ) )
				add_meta_box( 'wm-metabox-wm_seo_meta-meta', __( 'SEO settings', 'clifden_domain_adm' ), 'wm_seo_meta_meta_options', 'wm_staff', 'side', 'default' );
		}
	} // /wm_seo_meta_admin_box

?>