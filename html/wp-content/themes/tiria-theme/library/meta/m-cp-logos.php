<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Logos custom post meta boxes
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
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_logos_meta_fields' ) ) {
		function wm_logos_meta_fields() {
			$prefix = 'client-';
			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'Client info', 'clifden_domain_adm' )
				),
					array(
						"type" => "image",
						"id" => $prefix."logo",
						"label" => __( 'Logo', 'clifden_domain_adm' ),
						"desc" => __( 'Logo image URL. Keep the logo images constant aspect ratio to display correctly in Logos shortcode.', 'clifden_domain_adm' ),
						"default" => "",
						"imgsize" => 'full'
					),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( "Custom link URL", 'clifden_domain_adm' ),
						"desc" => __( 'When left blank, no link will be applied', 'clifden_domain_adm' ),
						"validate" => "url"
					),
						array(
							"type" => "select",
							"id" => $prefix."link-action",
							"label" => __( 'Link action', 'clifden_domain_adm' ),
							"desc" => __( 'Set the custom link action', 'clifden_domain_adm' ),
							"options" => array(
								'_blank' => __( 'Open in new window/tab', 'clifden_domain_adm' ),
								'_self'  => __( 'Open in the same window', 'clifden_domain_adm' ),
								),
						),
					array(
						"type" => "text",
						"id" => $prefix."link-rel",
						"label" => __( "Custom link relation", 'clifden_domain_adm' ),
						"desc" => __( 'Sets the "rel" HTML attribute', 'clifden_domain_adm' ),
					),
				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_logos_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_logos_generate_metabox' ) ) {
		function wm_logos_generate_metabox() {
			$wm_logos_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_logos_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_logos-meta',
				//post types
				'pages'          => array( 'wm_logos' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => false,
				//meta box title
				'title'          => __( 'Logo info', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_logos_generate_metabox

	add_action( 'init', 'wm_logos_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>