<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Prices custom post meta boxes
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
	if ( ! function_exists( 'wm_price_meta_fields' ) ) {
		function wm_price_meta_fields() {
			$prefix   = 'price-';

			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general-settings",
					"title" => __( 'Price set up', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."cost",
						"label" => __( 'Price cost (including currency)', 'clifden_domain_adm' ),
						"desc" => __( 'The actual price cost displayed including currency', 'clifden_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."note",
						"label" => __( 'Note text', 'clifden_domain_adm' ),
						"desc" => __( 'Additional note displayed below price cost', 'clifden_domain_adm' )
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "text",
						"id" => $prefix."order",
						"label" => __( 'Price column order', 'clifden_domain_adm' ),
						"desc" => __( 'Set a number to order price columns in price table. Higher number will move the column further to the right in the price table.<br />Leave empty or set to 0 (zero) to keep the default ordering (by date created).', 'clifden_domain_adm' ),
						"size" => 3,
						"maxlength" => 3,
						"validate" => "absint"
					),
				array(
					"type" => "section-close"
				),



				//Button
				array(
					"type" => "section-open",
					"section-id" => "button-settings",
					"title" => __( 'Button set up', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."btn-text",
						"label" => __( 'Button text', 'clifden_domain_adm' ),
						"desc" => __( 'Price button text', 'clifden_domain_adm' ),
						"default" => ""
					),
					array(
						"type" => "text",
						"id" => $prefix."btn-url",
						"label" => __( 'Button link', 'clifden_domain_adm' ),
						"desc" => __( 'Price button URL link', 'clifden_domain_adm' ),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."btn-color",
						"label" => __( 'Button color', 'clifden_domain_adm' ),
						"desc" => __( 'Choose style of the button', 'clifden_domain_adm' ),
						"options" => array(
							''       => __( 'Link color button (default)', 'clifden_domain_adm' ),
							'gray'   => __( 'Gray button', 'clifden_domain_adm' ),
							'green'  => __( 'Green button', 'clifden_domain_adm' ),
							'blue'   => __( 'Blue button', 'clifden_domain_adm' ),
							'orange' => __( 'Orange button', 'clifden_domain_adm' ),
							'red'    => __( 'Red button', 'clifden_domain_adm' ),
							),
						"default" => ""
					),
				array(
					"type" => "section-close"
				),



				//Styling
				array(
					"type" => "section-open",
					"section-id" => "styling-settings",
					"title" => __( 'Styling', 'clifden_domain_adm' )
				),
					array(
						"type" => "radio",
						"id" => $prefix."style",
						"label" => __( 'Column style', 'clifden_domain_adm' ),
						"desc" => __( 'Select, how this column should be styles', 'clifden_domain_adm' ),
						"options" => array(
							''          => __( 'Price column', 'clifden_domain_adm' ),
							' featured' => __( 'Featured price column', 'clifden_domain_adm' ),
							' legend'   => __( 'Legend', 'clifden_domain_adm' ),
							),
					),
					array(
						"type" => "space"
					),
					array(
						"type" => "color",
						"id" => $prefix."color",
						"label" => __( 'Custom column color', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the custom price column background color', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"type" => "section-close"
				),

			);

			return $metaFields;
		}
	} // /wm_price_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_price_generate_metabox' ) ) {
		function wm_price_generate_metabox() {
			$wm_price_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_price_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_price-meta',
				//post types
				'pages'          => array( 'wm_price' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Price settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_price_generate_metabox

	add_action( 'init', 'wm_price_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>