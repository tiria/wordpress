<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Content Module custom post meta boxes
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
	if ( ! function_exists( 'wm_modules_meta_fields' ) ) {
		function wm_modules_meta_fields() {
			global $post, $sidebarPosition, $projectLayouts, $fontIcons;

			$prefix = 'module-';
			$postId = ( $post ) ? ( $post->ID ) : ( null );

			if ( ! $postId && isset( $_GET['post'] ) )
				$postId = absint( $_GET['post'] );

			if ( ! $postId )
				$postId = '{{{post_id}}}';

			//Get icons
			$menuIcons     = array();
			$menuIcons[''] = __( '- select icon -', 'clifden_domain_adm' );
			$i = 0;
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) ) . '  (' . str_pad( ++$i, 3, '0', STR_PAD_LEFT ) . ')';
			}

			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'Content module settings', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( 'Custom link', 'clifden_domain_adm' ),
						"desc" => __( 'If set, the link will be applied on featured image and module title', 'clifden_domain_adm' ),
						"validate" => "url"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."type",
						"label" => __( 'Icon box', 'clifden_domain_adm' ),
						"desc" => __( 'Style this module as icon box (please upload the icon as featured image) or select one below.', 'clifden_domain_adm' ) . '<br />' . __( 'The featured image icon dimensions should be 32&times;32 px in default layout, or 64&times;64 px in centered icon box display layout. Layout can be set in shortcode or in widget parameters when displaying the Content Module.', 'clifden_domain_adm' ) . '<br /><a class="button thickbox button-set-featured-image js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Set featured image', 'clifden_domain_adm' ) . '</a>',
						"value" => "icon"
					),

					array(
						"id" => "icon-box-settings",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "space"
						),
						array(
							"type" => "select",
							"id" => $prefix."font-icon",
							"label" => __( 'Predefined font icon', 'clifden_domain_adm' ),
							"desc" => __( 'Select a font icon to display with this icon module. This icon will be prioritized over the featured image.', 'clifden_domain_adm' ),
							"options" => $menuIcons,
							"icons" => true
						),
						array(
							"type" => "color",
							"id" => $prefix."font-icon-color",
							"label" => __( 'Custom icon color', 'clifden_domain_adm' ),
							"desc" => __( 'Applies only for font icons', 'clifden_domain_adm' ),
							"default" => "",
							"validate" => "color"
						),
						array(
							"type" => "color",
							"id" => $prefix."icon-box-color",
							"label" => __( 'Custom icon background', 'clifden_domain_adm' ),
							"desc" => __( 'Leave empty to use default (accent) color', 'clifden_domain_adm' ),
							"default" => "",
							"validate" => "color"
						),
					array(
						"conditional" => array(
							"field" => WM_THEME_SETTINGS_PREFIX . $prefix . "type",
							"custom" => array( "input", "name", "checkbox" ),
							"value" => "icon"
							),
						"id" => "icon-box-settings",
						"type" => "inside-wrapper-close"
					),
				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_modules_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_modules_generate_metabox' ) ) {
		function wm_modules_generate_metabox() {
			$wm_modules_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_modules_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_modules-meta',
				//post types
				'pages'          => array( 'wm_modules' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Module settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_modules_generate_metabox

	add_action( 'init', 'wm_modules_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes
?>