<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Projects custom post meta boxes
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
	if ( ! function_exists( 'wm_projects_meta_fields' ) ) {
		function wm_projects_meta_fields() {
			global $post, $sidebarPosition, $projectLayouts, $fontIcons;

			$skin     = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
			$postId   = ( $post ) ? ( $post->ID ) : ( null );
			$prefix   = 'project-';
			$prefixBg = 'background-';

			if ( ! $postId && isset( $_GET['post'] ) )
				$postId = absint( $_GET['post'] );

			if ( ! $postId )
				$postId = '{{{post_id}}}';

			//Get icons
			$menuIcons = array();
			$menuIcons[''] = __( '- select icon -', 'clifden_domain_adm' );
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$defaultAttsNames = wm_option( 'general-projects-default-atts' );
			$defaultAtts      = array();
			if ( is_array( $defaultAttsNames ) && ! empty( $defaultAttsNames ) ) {
				foreach ( wm_option( 'general-projects-default-atts' ) as $attName ) {
					$defaultAtts[] = array( 'attr' => $attName, 'val' => '' );
				}
			}

			$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'clifden_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'clifden_domain_adm' ) . '</a>' ) : ( '' );


			$projectTypes = array();
			if ( ! wm_option( 'general-projects-disable-image' ) )
				$projectTypes['static-project'] = __( 'Static image', 'clifden_domain_adm' );
			if ( ! wm_option( 'general-projects-disable-slider' ) )
				$projectTypes['flex-project']   = __( 'Image slider', 'clifden_domain_adm' );
			if ( ! wm_option( 'general-projects-disable-video' ) )
				$projectTypes['video-project']  = __( 'Video', 'clifden_domain_adm' );
			if ( ! wm_option( 'general-projects-disable-audio' ) )
				$projectTypes['audio-project']  = __( 'Audio', 'clifden_domain_adm' );

			if ( empty( $projectTypes ) )
				$projectTypes['static-project'] = __( 'Static featured image', 'clifden_domain_adm' );

			$metaFields = array(
				//Featured media settings
				array(
					"type" => "section-open",
					"section-id" => "featured-media-section",
					"title" => __( 'Media', 'clifden_domain_adm' ),
					"exclude" => array()
				),
					array(
						"type" => "box",
						"content" => '
							<p>' . __( 'Featured image will be used in projects list so please set this always. Please save/update the project after you upload an image to be able to select it in options below.', 'clifden_domain_adm' ) . '</p>
							<a class="button-primary thickbox button-set-featured-image js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&tab=library&type=image&TB_iframe=1">' . __( 'Set featured image', 'clifden_domain_adm' ) . '</a>
							<a class="button-primary thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add images to project', 'clifden_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "select",
						"id" => $prefix."type",
						"label" => __( 'Project media type', 'clifden_domain_adm' ),
						"desc" => __( 'Select a type of project featured media', 'clifden_domain_adm' ),
						"options" => $projectTypes,
						"default" => "static"
					)
			);

			if ( isset( $projectTypes['static-project'] ) )
				array_push( $metaFields,
					//static image
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "static-project"
								),
							"type" => "image",
							"id" => $prefix."image",
							"label" => __( 'Project main image', 'clifden_domain_adm' ),
							"desc" => __( 'Used as main project preview image. To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post.', 'clifden_domain_adm' ),
							"default" => "",
							"readonly" => true,
							"imgsize" => 'mobile'
						)
				);

			if ( isset( $projectTypes['flex-project'] ) )
				array_push( $metaFields,
					//slider (Flex only)
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "flex-project"
								),
							"type" => "patterns",
							"id" => "slider-gallery-images",
							"label" => __( 'Choose slider images', 'clifden_domain_adm' ),
							"desc" => __( 'Select which images will be displayed in the slider (you may need to save/update the post to see the images)', 'clifden_domain_adm' ) . '<br /><a class="button thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add images to gallery', 'clifden_domain_adm' ) . '</a>',
							"options" => ( is_numeric( $postId ) ) ? ( wm_get_post_images( $postId, null, -1, true ) ) : ( null ),
							"field" => "checkbox",
							"default" => ""
						),
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "flex-project"
								),
							"type" => "slider",
							"id" => $prefix."slider-duration",
							"label" => __( 'Slide display time', 'clifden_domain_adm' ),
							"desc" => __( 'Display duration of single slide (in seconds)', 'clifden_domain_adm' ),
							"default" => 5,
							"min" => 1,
							"max" => 20,
							"step" => 1,
							"validate" => "absint"
						)
				);

			if ( isset( $projectTypes['video-project'] ) )
				array_push( $metaFields,
					//video
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "video-project"
								),
							"type" => "text",
							"id" => $prefix."video",
							"label" => __( 'Video URL or <code>[video]</code> shortcode', 'clifden_domain_adm' ),
							"desc" => sprintf( __( 'Enter full video URL (<a%s>supported video portals</a> and Screenr videos only)', 'clifden_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ) . '<br />' . __( 'Or you can set the <a href="http://codex.wordpress.org/Video_Shortcode" target="_blank"><code>[video]</code> shortcode</a> here.', 'clifden_domain_adm' ),
						)
				);

			if ( isset( $projectTypes['audio-project'] ) )
				array_push( $metaFields,
					//audio
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "audio-project"
								),
							"type" => "text",
							"id" => $prefix."audio",
							"label" => __( 'SoundCloud audio URL or <code>[audio]</code> shortcode', 'clifden_domain_adm' ),
							"desc" => __( 'Set the <a href="http://www.soundcloud.com" target="_blank">SoundCloud.com</a> audio clip URL address', 'clifden_domain_adm' ) . '<br />' . __( 'Or you can set the <a href="http://codex.wordpress.org/Audio_Shortcode" target="_blank"><code>[audio]</code> shortcode</a> here.', 'clifden_domain_adm' ),
						),
						array(
							"conditional" => array(
								"field" => $prefix."type",
								"value" => "audio-project"
								),
							"type" => "image",
							"id" => $prefix."audio-preview",
							"label" => __( 'Artwork or album cover', 'clifden_domain_adm' ),
							"desc" => __( 'Optional artwork or album cover image (does not apply for SoundCloud audios)', 'clifden_domain_adm' ),
							"default" => "",
							"readonly" => true,
							"imgsize" => 'mobile'
						)
				);

			array_push( $metaFields,
				array(
					"type" => "section-close"
				),



				//Attributes settings
				array(
					"type" => "section-open",
					"section-id" => "attributes-settings",
					"title" => __( 'Attributes', 'clifden_domain_adm' )
				),
					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( 'Project URL link', 'clifden_domain_adm' ),
						"desc" => __( 'When left blank, no link will be displayed', 'clifden_domain_adm' )
					),
						array(
							"type" => "select",
							"id" => $prefix."link-list",
							"label" => __( 'Link action', 'clifden_domain_adm' ),
							"desc" => __( 'Choose how to display/apply the link set above', 'clifden_domain_adm' ),
							"options" => array(
									"1OPTGROUP"      => __( 'Project page', 'clifden_domain_adm' ),
										""             => __( 'Display link on project page', 'clifden_domain_adm' ),
									"1/OPTGROUP"     => "",
									"2OPTGROUP"      => __( 'Apply directly in projects list (on portfolio pages)', 'clifden_domain_adm' ),
										"modal"        => __( 'Open in popup window (videos and images only)', 'clifden_domain_adm' ),
										"target-blank" => __( 'Open in new tab/window', 'clifden_domain_adm' ),
										"target-self"  => __( 'Open in same window', 'clifden_domain_adm' ),
									"2/OPTGROUP"     => "",
								),
							"default" => "",
							"optgroups" => true
						),
						array(
							"type" => "text",
							"id" => $prefix."rel-text",
							"label" => __( 'Link "rel" attribute', 'clifden_domain_adm' ),
							"desc" => __( 'Sets the custom link relationship attribute. No "rel" attribute will be added if left blank.', 'clifden_domain_adm' )
						),
						array(
							"type" => "hr"
						),
					array(
						"type" => "additems",
						"id" => $prefix."attributes",
						"label" => __( 'Project attributes', 'clifden_domain_adm' ),
						"desc" => __( 'Press [+] button to add an attribute, then type in the attribute name and value (you can use <code>[project_attributes title="Project info" /]</code> shortcode to display attributes anywhere in project content or excerpt - by default they will be displayed as first thing above project excerpt - you can set the layout on "General and layout" tab)', 'clifden_domain_adm' ),
						"default" => $defaultAtts,
						"field" => "attributes"
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
				),



				//Sidebar settings
				array(
					"type" => "section-open",
					"section-id" => "sidebar-section",
					"title" => __( 'Sidebar', 'clifden_domain_adm' ),
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



				//General and layout settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'General and layout', 'clifden_domain_adm' )
				),
					array(
						"type" => "select",
						"id" => $prefix."single-layout",
						"label" => __( 'Project page layout', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the layout for this project page', 'clifden_domain_adm' ),
						"options" => $projectLayouts,
						"default" => wm_option( 'general-project-default-layout' ),
						"optgroups" => true
					),
					array(
						"type" => "hr"
					),

					array(
						"type" => "checkbox",
						"id" => "no-heading",
						"label" => __( 'Disable main heading', 'clifden_domain_adm' ),
						"desc" => __( 'Hides post/page main heading - the title', 'clifden_domain_adm' ),
						"value" => "true"
					),
						array(
							"type" => "space"
						),
						array(
							"type" => "textarea",
							"id" => "subheading",
							"label" => __( 'Subtitle', 'clifden_domain_adm' ),
							"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'clifden_domain_adm' ),
							"default" => "",
							"validate" => "lineBreakHTML",
							"rows" => 2,
							"cols" => 57
						),
						array(
							"type" => "select",
							"id" => "main-heading-alignment",
							"label" => __( 'Main heading alignment', 'clifden_domain_adm' ),
							"desc" => __( 'Set the text alignment in main heading area', 'clifden_domain_adm' ),
							"options" => array(
									""       => __( 'Default', 'clifden_domain_adm' ),
									"left"   => __( 'Left', 'clifden_domain_adm' ),
									"center" => __( 'Center', 'clifden_domain_adm' ),
									"right"  => __( 'Right', 'clifden_domain_adm' ),
								),
							"default" => ""
						),
						array(
							"type" => "select",
							"id" => "main-heading-icon",
							"label" => __( 'Main heading icon', 'clifden_domain_adm' ),
							"desc" => __( 'Select an icon to display in main heading area', 'clifden_domain_adm' ),
							"options" => $menuIcons,
							"icons" => true
						),
						array(
							"type" => "hr"
						)
			);

			if ( ! wm_option( 'layout-no-related-projects' ) )
				array_push( $metaFields,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-related",
						"label" => __( 'Disable related projects', 'clifden_domain_adm' ),
						"desc" => __( 'Hides related projects list', 'clifden_domain_adm' )
					)
				);

			$sharingStatus = ( wm_option( 'social-share-facebook' ) || wm_option( 'social-share-twitter' ) || wm_option( 'social-share-googleplus' ) || wm_option( 'social-share-pinterest' ) ) && ! wm_option( 'social-share-no-projects' );

			if ( $sharingStatus )
				array_push( $metaFields,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-share",
						"label" => __( 'Disable sharing for this project', 'clifden_domain_adm' ),
						"desc" => __( 'Hides social sharing buttons for the project', 'clifden_domain_adm' )
					)
				);

			if ( is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaFields,
					array(
						"type" => "checkbox",
						"id" => "no-above-footer-widgets",
						"label" => __( 'Disable widgets above footer', 'clifden_domain_adm' ),
						"desc" => __( 'Hides widget area above footer', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			array_push( $metaFields,
				array(
					"type" => "section-close"
				)
			);

			return $metaFields;
		}
	} // /wm_projects_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_projects_generate_metabox' ) ) {
		function wm_projects_generate_metabox() {
			$wm_projects_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_projects_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_projects-meta',
				//post types
				'pages'          => array( 'wm_projects' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Projects settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_projects_generate_metabox

	add_action( 'init', 'wm_projects_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>