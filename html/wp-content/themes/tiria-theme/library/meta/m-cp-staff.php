<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Staff custom post meta boxes
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
	if ( ! function_exists( 'wm_staff_meta_fields' ) ) {
		function wm_staff_meta_fields() {
			global $sidebarPosition, $fontIcons;

			$skin     = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
			$prefix   = 'staff-';
			$prefixBg = 'background-';

			//Get icons
			$icons = array();
			$icons[''] = __( '- select icon -', 'clifden_domain_adm' );
			foreach ( $fontIcons as $icon ) {
				$icons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'clifden_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'clifden_domain_adm' ) . '</a>' ) : ( '' );

			$metaFields = array(

				//Position settings
				array(
					"type" => "section-open",
					"section-id" => "position",
					"title" => __( 'Position', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."position",
						"label" => __( 'Position', 'clifden_domain_adm' ),
						"desc" => __( 'Staff member position', 'clifden_domain_adm' )
					),
				array(
					"type" => "section-close"
				),



				//Contacts settings
				array(
					"type" => "section-open",
					"section-id" => "contact",
					"title" => __( 'Contact', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."phone",
						"label" => __( 'Phone', 'clifden_domain_adm' ),
						"desc" => __( 'Phone number', 'clifden_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."email",
						"label" => __( 'E-mail', 'clifden_domain_adm' ),
						"desc" => __( 'E-mail (spam protection will be applied)', 'clifden_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."linkedin",
						"label" => __( 'LinkedIn', 'clifden_domain_adm' ),
						"desc" => __( 'LinkedIn account URL', 'clifden_domain_adm' )
					),
					array(
						"type" => "text",
						"id" => $prefix."skype",
						"label" => __( 'Skype username', 'clifden_domain_adm' ),
						"desc" => __( 'Skype username', 'clifden_domain_adm' )
					),
					array(
						"type" => "additems",
						"id" => $prefix."custom-contacts",
						"label" => __( 'Custom contacts', 'clifden_domain_adm' ),
						"desc" => __( 'Press [+] button to add new custom contact info', 'clifden_domain_adm' ),
						"field" => "attributes-selectable",
						"options-attr" => $icons,
					),
				array(
					"type" => "section-close"
				)

			);

			if ( wm_option( 'general-staff-rich' ) ) {
				array_push( $metaFields,
					//Sidebar settings
					array(
						"type" => "section-open",
						"section-id" => "sidebar-section",
						"title" => __( 'Layout', 'clifden_domain_adm' )
					),
						array(
							"type" => "checkbox",
							"id" => $prefix."no-rich",
							"label" => __( 'Disable rich staff profile', 'clifden_domain_adm' ),
							"desc" => __( 'Disables rich staff profile page for this staff member only (use theme admin panel to disable this globally).<br />Only excerpt content will be displayed in staff members list.', 'clifden_domain_adm' )
						),
						array(
							"type" => "space"
						),

						array(
							"type" => "box",
							"content" => '<h4>' . __( 'Choose a sidebar and its position on the post/page', 'clifden_domain_adm' ) . '</h4>' . $widgetsButtons,
						),

						array(
							"type" => "layouts",
							"id" => "layout",
							"label" => __( 'Sidebar position', 'clifden_domain_adm' ),
							"desc" => __( 'Choose a sidebar position on the post/page (set the first one to use the theme default settings)', 'clifden_domain_adm' ),
							"options" => $sidebarPosition,
							"default" => ""
						),
						array(
							"type" => "select",
							"id" => "sidebar",
							"label" => __( 'Choose a sidebar', 'clifden_domain_adm' ),
							"desc" => __( 'Select a widget area used as a sidebar for this post/page (if not set, the dafault theme settings will apply)', 'clifden_domain_adm' ),
							"options" => wm_widget_areas(),
							"default" => ""
						),
					array(
						"type" => "section-close"
					),



					//Design - website background settings
					array(
						"type" => "section-open",
						"section-id" => "background-settings",
						"title" => __( 'Background', 'clifden_domain_adm' )
					),
						array(
							"type" => "color",
							"id" => $prefixBg."bg-color",
							"label" => __( 'Background color', 'clifden_domain_adm' ),
							"desc" => __( 'Sets the custom website background color', 'clifden_domain_adm' ),
							"default" => "",
							"validate" => "color"
						),
						array(
							"type" => "image",
							"id" => $prefixBg."bg-img-url",
							"label" => __( 'Custom background image', 'clifden_domain_adm' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_adm' ),
							"default" => "",
							"validate" => "url"
						),
						array(
							"type" => "select",
							"id" => $prefixBg."bg-img-position",
							"label" => __( 'Background image position', 'clifden_domain_adm' ),
							"desc" => __( 'Set background image position', 'clifden_domain_adm' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'clifden_domain_adm' ),
								'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_adm' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_adm' ),
								'0 0'       => __( 'Left, top', 'clifden_domain_adm' ),
								'0 50%'     => __( 'Left, center vertically', 'clifden_domain_adm' ),
								'0 100%'    => __( 'Left, bottom', 'clifden_domain_adm' ),
								'100% 0'    => __( 'Right, top', 'clifden_domain_adm' ),
								'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_adm' ),
								'100% 100%' => __( 'Right, bottom', 'clifden_domain_adm' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefixBg."bg-img-repeat",
							"label" => __( 'Background image repeat', 'clifden_domain_adm' ),
							"desc" => __( 'Set background image repeating', 'clifden_domain_adm' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'clifden_domain_adm' ),
								'repeat'    => __( 'Repeat', 'clifden_domain_adm' ),
								'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_adm' ),
								'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_adm' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefixBg."bg-img-attachment",
							"label" => __( 'Background image attachment', 'clifden_domain_adm' ),
							"desc" => __( 'Set background image attachment', 'clifden_domain_adm' ),
							"options" => array(
								'fixed'  => __( 'Fixed position', 'clifden_domain_adm' ),
								'scroll' => __( 'Move on scrolling', 'clifden_domain_adm' )
								),
							"default" => 'fixed'
						),
						array(
							"type" => "checkbox",
							"id" => $prefixBg."bg-img-fit-window",
							"label" => __( 'Fit browser window width', 'clifden_domain_adm' ),
							"desc" => __( 'Makes the image to scale to browser window width. Note that background image position and repeat options does not apply when this is checked.', 'clifden_domain_adm' ),
							"value" => "true"
						),
					array(
						"type" => "section-close"
					)
				);
			}

			return $metaFields;
		}
	} // /wm_staff_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_staff_generate_metabox' ) ) {
		function wm_staff_generate_metabox() {
			$wm_staff_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_staff_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_staff-meta',
				//post types
				'pages'          => array( 'wm_staff' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Staff info', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_staff_generate_metabox

	add_action( 'init', 'wm_staff_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>