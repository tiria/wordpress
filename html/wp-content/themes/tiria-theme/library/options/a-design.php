<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Design
*****************************************************
*/

$prefix = 'design-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "design",
	"title" => __( 'Design', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "design",
		"list" => array(
			__( 'Skin', 'clifden_domain_panel' ),
			__( 'Colors', 'clifden_domain_panel' ),
			__( 'Fonts', 'clifden_domain_panel' ),
			__( 'Stylesheet', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-1",
		"title" => __( 'Skin', 'clifden_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'clifden_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 14 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Website main theme skin', 'clifden_domain_panel' )
		),

		array(
			"type" => "skins",
			"id" => $prefix."skin",
			"label" => __( 'Theme skins', 'clifden_domain_panel' ),
			"desc" => __( 'It is recommended to set a website color skin first to be used as a base for your additional design changes. When color skin is changed, it will automatically reset several different options, such as font embeding, font stacks or link color. So, be sure to keep a backup of previous settings state (use export/import feature of this admin panel).', 'clifden_domain_panel' ),
			"options" => wm_skins(),
			"default" => "default.css"
		),
		array(
			"type" => "info",
			"content" => ( ! wm_option( 'design-skin' ) ) ? ( '<strong>' . wm_skin_meta( wm_option( 'default.css' ), 'skin' ) . ' ' . __( 'skin description', 'clifden_domain_panel' ) . ':</strong><br />' . wm_skin_meta( 'default.css', 'description' ) ) : ( '<strong>' . wm_skin_meta( wm_option( 'design-skin' ), 'skin' ) . ' ' . __( 'skin description', 'clifden_domain_panel' ) . ':</strong><br />' . wm_skin_meta( wm_option( 'design-skin' ), 'description' ) . '<br />&mdash; by ' . wm_skin_meta( wm_option( 'design-skin' ), 'author' ) )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Skin tweaking', 'clifden_domain_panel' )
		),
			array(
				"type" => "color",
				"id" => $prefix."link-color",
				"label" => __( 'Link color', 'clifden_domain_panel' ),
				"desc" => __( 'The main link color. Will be used also on various other elements, like default button color for example.', 'clifden_domain_panel' ),
				"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'link-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'link-color' ) ),
				"validate" => "color"
			),
			array(
				"type" => "space",
			),

		//basic colors:
		array(
			"type" => "box",
			"content" => __( 'Basic colors, which can be set below, are used on elements like buttons, boxes or markers', 'clifden_domain_panel' ),
		),

			//blue
				array(
					"type" => "heading4",
					"content" => __( 'Blue color', 'clifden_domain_panel' ),
					"id" => "heading-to-set-blue"
				),
				array(
					"id" => $prefix."set-blue",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefix."type-blue-bg-color",
						"label" => __( 'General blue color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-blue-bg-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-blue-bg-color' ) ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."type-blue-color",
						"label" => __( 'Text on blue color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-blue-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-blue-color' ) ),
						"validate" => "color"
					),
				array(
					"id" => $prefix."set-blue",
					"type" => "inside-wrapper-close"
				),

			//gray
				array(
					"type" => "heading4",
					"content" => __( 'Gray color', 'clifden_domain_panel' ),
					"id" => "heading-to-set-gray"
				),
				array(
					"id" => $prefix."set-gray",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefix."type-gray-bg-color",
						"label" => __( 'General gray color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-gray-bg-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-gray-bg-color' ) ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."type-gray-color",
						"label" => __( 'Text on gray color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-gray-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-gray-color' ) ),
						"validate" => "color"
					),
				array(
					"id" => $prefix."set-gray",
					"type" => "inside-wrapper-close"
				),

			//green
				array(
					"type" => "heading4",
					"content" => __( 'Green color', 'clifden_domain_panel' ),
					"id" => "heading-to-set-green"
				),
				array(
					"id" => $prefix."set-green",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefix."type-green-bg-color",
						"label" => __( 'General green color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-green-bg-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-green-bg-color' ) ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."type-green-color",
						"label" => __( 'Text on green color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-green-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-green-color' ) ),
						"validate" => "color"
					),
				array(
					"id" => $prefix."set-green",
					"type" => "inside-wrapper-close"
				),

			//orange
				array(
					"type" => "heading4",
					"content" => __( 'Orange color', 'clifden_domain_panel' ),
					"id" => "heading-to-set-orange"
				),
				array(
					"id" => $prefix."set-orange",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefix."type-orange-bg-color",
						"label" => __( 'General orange color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-orange-bg-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-orange-bg-color' ) ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."type-orange-color",
						"label" => __( 'Text on orange color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-orange-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-orange-color' ) ),
						"validate" => "color"
					),
				array(
					"id" => $prefix."set-orange",
					"type" => "inside-wrapper-close"
				),

			//red
				array(
					"type" => "heading4",
					"content" => __( 'Red color', 'clifden_domain_panel' ),
					"id" => "heading-to-set-red"
				),
				array(
					"id" => $prefix."set-red",
					"type" => "inside-wrapper-open",
					"class" => "toggle box"
				),
					array(
						"type" => "color",
						"id" => $prefix."type-red-bg-color",
						"label" => __( 'General red color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-red-bg-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-red-bg-color' ) ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."type-red-color",
						"label" => __( 'Text on red color', 'clifden_domain_panel' ),
						"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'type-red-color' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'type-red-color' ) ),
						"validate" => "color"
					),
				array(
					"id" => $prefix."set-red",
					"type" => "inside-wrapper-close"
				),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-2",
		"title" => __( 'Colors', 'clifden_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'clifden_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 14 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Custom design', 'clifden_domain_panel' )
		),
		array(
			"type" => "box",
			"content" => '<p>' . __( 'Here you can set your custom design. You can mainly set background color, image or texture here, alongside with the text, links or border colors of different website sections. Some sections allows you to set additional layout options (can be found on "Colors and layout" tab for these). Please, also make sure to set proper basic icons color according to your background color settings.', 'clifden_domain_panel' ) . '</p>' . sprintf( __( 'Also please check <a href="%s/website-layers.png" class="fancybox">the website layers layout</a> for better understanding how different elements of the design are layed out.', 'clifden_domain_adm' ), WM_ASSETS_ADMIN . 'img/layouts' )
		),

		//backgrounds:

			//top panel background
			array(
				"type" => "heading3",
				"content" => __( 'Top bar', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."toppanel-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."toppanel-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."toppanel-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."toppanel-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."toppanel-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."toppanel-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."toppanel-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."toppanel-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."toppanel-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."toppanel-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."toppanel-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."toppanel-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."toppanel-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."toppanel-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."toppanel-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//header background
			array(
				"type" => "heading3",
				"content" => __( 'Header', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."header-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."header-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."header-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."header-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."header-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."header-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."header-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."header-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."header-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."header-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."header-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."header-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."header-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."header-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."header-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."header-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."header-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//navigation background
			array(
				"type" => "heading3",
				"content" => __( 'Navigation', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."navigation-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."navigation-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."navigation-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "color",
						"id" => $prefix."subnavigation-"."bg-color",
						"label" => __( 'Subnavigation background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."subnavigation-"."color",
						"label" => __( 'Subnavigation text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."navigation-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."navigation-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."navigation-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."navigation-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."navigation-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."navigation-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."navigation-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."navigation-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."navigation-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."navigation-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."navigation-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."navigation-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//slider background
			array(
				"type" => "heading3",
				"content" => __( 'Slider', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."slider-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."slider-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."slider-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."slider-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"id" => $prefix."slider-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."slider-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."slider-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."slider-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."slider-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."slider-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."slider-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."slider-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."slider-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."slider-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."slider-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//main heading background
			array(
				"type" => "heading3",
				"content" => __( 'Main heading / title', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."mainheading-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors and layout', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."mainheading-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."alt-color",
						"label" => __( 'Alternative text color', 'clifden_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'clifden_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."mainheading-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-alignment",
						"label" => __( 'Text alignment', 'clifden_domain_panel' ),
						"desc" => __( 'Sets the default text alignment for main heading area', 'clifden_domain_panel' ),
						"options" => array(
								"left"   => __( 'Left', 'clifden_domain_panel' ),
								"center" => __( 'Center', 'clifden_domain_panel' ),
								"right"  => __( 'Right', 'clifden_domain_panel' ),
							)
					),
				array(
					"id" => $prefix."mainheading-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."mainheading-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."mainheading-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."mainheading-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."mainheading-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."mainheading-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."mainheading-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."mainheading-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."mainheading-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."mainheading-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."mainheading-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//page excerpt background
			array(
				"type" => "heading3",
				"content" => __( 'Page excerpt area', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."pageexcerpt-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."pageexcerpt-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."alt-color",
						"label" => __( 'Alternative text color', 'clifden_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'clifden_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."pageexcerpt-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."pageexcerpt-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."pageexcerpt-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."pageexcerpt-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."pageexcerpt-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."pageexcerpt-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."pageexcerpt-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."pageexcerpt-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."pageexcerpt-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."pageexcerpt-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."pageexcerpt-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."pageexcerpt-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."pageexcerpt-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//content background
			array(
				"type" => "heading3",
				"content" => __( 'Content', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."content-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."content-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."content-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."content-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."content-"."alt-color",
						"label" => __( 'Alternative text color', 'clifden_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'clifden_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."content-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."content-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."content-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."content-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."content-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."content-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."content-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."content-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."content-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."content-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."content-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."content-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."content-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//above footer background
			array(
				"type" => "heading3",
				"content" => __( 'Above footer area', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."abovefooter-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."abovefooter-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."alt-color",
						"label" => __( 'Alternative text color', 'clifden_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'clifden_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."abovefooter-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."abovefooter-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."abovefooter-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."abovefooter-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."abovefooter-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."abovefooter-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."abovefooter-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."abovefooter-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."abovefooter-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."abovefooter-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."abovefooter-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."abovefooter-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."abovefooter-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//breadcrumbs background
			array(
				"type" => "heading3",
				"content" => __( 'Breadcrumbs', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."breadcrumbs-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."breadcrumbs-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."breadcrumbs-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."breadcrumbs-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."breadcrumbs-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."breadcrumbs-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."breadcrumbs-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."breadcrumbs-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."breadcrumbs-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."breadcrumbs-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."breadcrumbs-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."breadcrumbs-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."breadcrumbs-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."breadcrumbs-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."breadcrumbs-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//footer background
			array(
				"type" => "heading3",
				"content" => __( 'Footer', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."footer-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."footer-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."alt-color",
						"label" => __( 'Alternative text color', 'clifden_domain_panel' ),
						"default" => "",
						"desc" => __( 'This color will be used for headings for example', 'clifden_domain_panel' ),
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."footer-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."footer-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."footer-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."footer-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."footer-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."footer-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."footer-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."footer-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."footer-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."footer-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."footer-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."footer-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."footer-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//credits / bottom background
			array(
				"type" => "heading3",
				"content" => __( 'Bottom / credits area', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."bottom-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."bottom-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."color",
						"label" => __( 'Text color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."link-color",
						"label" => __( 'Link color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "color",
						"id" => $prefix."bottom-"."border-color",
						"label" => __( 'Border color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "hr",
					),
					array(
						"type" => "select",
						"id" => $prefix."bottom-"."icons",
						"label" => __( 'Icons color', 'clifden_domain_panel' ),
						"desc" => __( 'Here you can override the default skin icons color for this section (also affects border and form elements color)', 'clifden_domain_panel' ),
						"options" => array(
							""             => "",
							" dark-icons"  => __( 'Dark icons', 'clifden_domain_panel' ),
							" light-icons" => __( 'Light icons', 'clifden_domain_panel' )
							),
					),
				array(
					"id" => $prefix."bottom-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."bottom-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."bottom-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."bottom-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."bottom-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."bottom-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."bottom-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."bottom-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."bottom-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."bottom-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."bottom-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//wrap background
			array(
				"type" => "heading3",
				"content" => __( 'Main wrap background (only for boxed layout)', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."mainwrap-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."mainwrap-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."mainwrap-"."bg-color",
						"label" => __( 'Background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"id" => $prefix."mainwrap-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."mainwrap-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "image",
						"id" => $prefix."mainwrap-"."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_panel' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."mainwrap-"."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
							),
						"default" => '50% 0'
					),
					array(
						"type" => "select",
						"id" => $prefix."mainwrap-"."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
							),
						"default" => 'no-repeat'
					),
					array(
						"type" => "radio",
						"id" => $prefix."mainwrap-"."bg-img-attachment",
						"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
						"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
						"options" => array(
							'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
							'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
							),
						"default" => 'scroll'
					),
				array(
					"id" => $prefix."mainwrap-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."mainwrap-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "patterns",
						"id" => $prefix."mainwrap-"."bg-pattern",
						"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
						"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
						"options" => wm_get_image_files(),
						"default" => "",
						"preview" => true
					),
				array(
					"id" => $prefix."mainwrap-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."mainwrap-"."bg-container",
				"type" => "inside-wrapper-close"
			),



			//website background
			array(
				"type" => "heading3",
				"content" => __( 'Website background', 'clifden_domain_panel' )
			),
			array(
				"id" => $prefix."html-"."bg-container",
				"type" => "inside-wrapper-open",
				"class" => "toggle box"
			),
				array(
					"type" => "inside-tabs",
					"tabs" => array( __( 'Colors', 'clifden_domain_panel' ), __( 'Image', 'clifden_domain_panel' ), __( 'Pattern', 'clifden_domain_panel' ) )
				),

				//colors
				array(
					"id" => $prefix."html-"."sub-1",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					array(
						"type" => "color",
						"id" => $prefix."html-"."bg-color",
						"label" => __( 'Backmost layer background color', 'clifden_domain_panel' ),
						"default" => "",
						"validate" => "color"
					),
				array(
					"id" => $prefix."html-"."sub-1",
					"type" => "inside-wrapper-close"
				),

				//image
				array(
					"id" => $prefix."html-"."sub-2",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					//image backmost layer
					array(
						"type" => "heading3",
						"content" => __( 'Backmost layer', 'clifden_domain_panel' ),
						"class" => "first"
					),
						array(
							"type" => "image",
							"id" => $prefix."html-"."bg-img-url",
							"label" => __( 'Custom background image', 'clifden_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
							"default" => "",
							"validate" => "url"
						),
						array(
							"type" => "select",
							"id" => $prefix."html-"."bg-img-position",
							"label" => __( 'Background image position', 'clifden_domain_panel' ),
							"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
								'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."html-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
								'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."html-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
								),
							"default" => 'scroll'
						),

					array(
						"type" => "hr",
					),

					//image topmost layer
					array(
						"type" => "heading3",
						"content" => __( 'Topmost layer', 'clifden_domain_panel' ),
					),
						array(
							"type" => "image",
							"id" => $prefix."body-"."bg-img-url",
							"label" => __( 'Custom background image', 'clifden_domain_panel' ),
							"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
							"default" => "",
							"validate" => "url"
						),
						array(
							"type" => "select",
							"id" => $prefix."body-"."bg-img-position",
							"label" => __( 'Background image position', 'clifden_domain_panel' ),
							"desc" => __( 'Set background image position', 'clifden_domain_panel' ),
							"options" => array(
								'50% 50%'   => __( 'Center', 'clifden_domain_panel' ),
								'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_panel' ),
								'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_panel' ),
								'0 0'       => __( 'Left, top', 'clifden_domain_panel' ),
								'0 50%'     => __( 'Left, center vertically', 'clifden_domain_panel' ),
								'0 100%'    => __( 'Left, bottom', 'clifden_domain_panel' ),
								'100% 0'    => __( 'Right, top', 'clifden_domain_panel' ),
								'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_panel' ),
								'100% 100%' => __( 'Right, bottom', 'clifden_domain_panel' ),
								),
							"default" => '50% 0'
						),
						array(
							"type" => "select",
							"id" => $prefix."body-"."bg-img-repeat",
							"label" => __( 'Background image repeat', 'clifden_domain_panel' ),
							"desc" => __( 'Set background image repeating', 'clifden_domain_panel' ),
							"options" => array(
								'no-repeat' => __( 'Do not repeat', 'clifden_domain_panel' ),
								'repeat'    => __( 'Repeat', 'clifden_domain_panel' ),
								'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_panel' ),
								'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_panel' )
								),
							"default" => 'no-repeat'
						),
						array(
							"type" => "radio",
							"id" => $prefix."body-"."bg-img-attachment",
							"label" => __( 'Background image attachment', 'clifden_domain_panel' ),
							"desc" => __( 'Set the background image attachment', 'clifden_domain_panel' ),
							"options" => array(
								'scroll' => __( 'Move on scrolling', 'clifden_domain_panel' ),
								'fixed'  => __( 'Fixed position', 'clifden_domain_panel' )
								),
							"default" => 'scroll'
						),
				array(
					"id" => $prefix."html-"."sub-2",
					"type" => "inside-wrapper-close"
				),

				//pattern
				array(
					"id" => $prefix."html-"."sub-3",
					"type" => "inside-wrapper-open",
					"class" => "inside-tab-content"
				),
					//pattern backmost layer
					array(
						"type" => "heading3",
						"content" => __( 'Backmost layer', 'clifden_domain_panel' ),
						"class" => "first"
					),
						array(
							"type" => "patterns",
							"id" => $prefix."html-"."bg-pattern",
							"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
							"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
							"options" => wm_get_image_files(),
							"default" => "",
							"preview" => true
						),

					array(
						"type" => "hr",
					),

					//pattern topmost layer
					array(
						"type" => "heading3",
						"content" => __( 'Topmost layer', 'clifden_domain_panel' ),
					),
						array(
							"type" => "patterns",
							"id" => $prefix."body-"."bg-pattern",
							"label" => __( 'Set background pattern', 'clifden_domain_panel' ),
							"desc" => __( 'Patterns are prioritized over background image. For transparent patterns you can also set the background color. Background image attachment setting will affect patterns too. Upload new patterns into <code>assets/img/patterns</code> folder of this theme.', 'clifden_domain_panel' ),
							"options" => wm_get_image_files(),
							"default" => "",
							"preview" => true
						),
				array(
					"id" => $prefix."html-"."sub-3",
					"type" => "inside-wrapper-close"
				),
			array(
				"id" => $prefix."html-"."bg-container",
				"type" => "inside-wrapper-close"
			),

	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-3",
		"title" => __( 'Fonts', 'clifden_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'clifden_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 14 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Font families', 'clifden_domain_panel' )
		),
			array(
				"type" => "textarea",
				"id" => $prefix."font-custom",
				"label" => __( 'Custom font stylesheet link (HTML)', 'clifden_domain_panel' ),
				"desc" => __( 'Use <code>&lt;link&gt;</code> HTML tags to embed custom fonts (can be obtained from <a href="http://www.google.com/webfonts" target="_blank">Google Web Fonts</a>, for example)', 'clifden_domain_panel' ),
				"default" => ( wm_option( 'design-skin' ) ) ? ( wm_skin_meta( wm_option( 'design-skin' ), 'font-custom' ) ) : ( null ),
				"cols" => 70,
				"rows" => 8,
				"class" => "code"
			),
			array(
				"type" => "text",
				"id" => $prefix."font-primary",
				"label" => __( 'Primary font stack', 'clifden_domain_panel' ),
				"desc" => __( 'Enter font names hierarchically separated with commas. Provide also the most basic fallback ("sans-serif" or "serif").', 'clifden_domain_panel' ),
				"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'font-primary' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'font-primary' ) ),
				"size" => "",
				"maxlength" => ""
			),
			array(
				"type" => "text",
				"id" => $prefix."font-secondary",
				"label" => __( 'Secondary font stack', 'clifden_domain_panel' ),
				"desc" => __( 'Enter font names hierarchically separated with commas. Provide also the most basic fallback ("sans-serif" or "serif").', 'clifden_domain_panel' ),
				"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'font-secondary' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'font-secondary' ) ),
				"size" => "",
				"maxlength" => ""
			),
			array(
				"type" => "text",
				"id" => $prefix."font-terciary",
				"label" => __( 'Terciary font stack', 'clifden_domain_panel' ),
				"desc" => __( 'Enter font names hierarchically separated with commas. Provide also the most basic fallback ("sans-serif" or "serif").', 'clifden_domain_panel' ),
				"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'font-terciary' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'font-terciary' ) ),
				"size" => "",
				"maxlength" => ""
			),

		array(
			"type" => "hr"
		),
		array(
			"type" => "heading3",
			"content" => __( 'Basic website font', 'clifden_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."font-body-stack",
				"label" => __( 'Basic website font stack', 'clifden_domain_panel' ),
				"desc" => __( 'Select previously set font stack for entire website', 'clifden_domain_panel' ),
				"options" => array(
					"primary" => __( 'Primary font stack', 'clifden_domain_panel' ),
					"secondary" => __( 'Secondary font stack', 'clifden_domain_panel' ),
					"terciary"  => __( 'Terciary font stack', 'clifden_domain_panel' )
					),
				"default" => "primary"
			),
			array(
				"type" => "slider",
				"id" => $prefix."font-body-size",
				"label" => __( 'Basic font size', 'clifden_domain_panel' ),
				"desc" => __( 'Set the basic font size of the website (in pixels).', 'clifden_domain_panel' ),
				"default" => ( ! wm_option( 'design-skin' ) ) ? ( wm_skin_meta( 'default.css', 'font-body-size' ) ) : ( wm_skin_meta( wm_option( 'design-skin' ), 'font-body-size' ) ),
				"min" => 9,
				"max" => 18,
				"step" => 1,
				"validate" => "absint"
			),

		array(
			"type" => "hr"
		),
		array(
			"type" => "heading3",
			"content" => __( 'Heading font', 'clifden_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."font-heading-stack",
				"label" => __( 'Headings font', 'clifden_domain_panel' ),
				"desc" => __( 'Select previously set font stack for website headings', 'clifden_domain_panel' ),
				"options" => array(
					"primary" => __( 'Primary font stack', 'clifden_domain_panel' ),
					"secondary" => __( 'Secondary font stack', 'clifden_domain_panel' ),
					"terciary"  => __( 'Terciary font stack', 'clifden_domain_panel' )
					),
				"default" => "secondary"
			),
			array(
				"type" => "hr"
			),
		array(
			"type" => "heading3",
			"content" => __( 'Huge text and main subtitle', 'clifden_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."font-subtitle-stack",
				"label" => __( 'Terciary font elements', 'clifden_domain_panel' ),
				"desc" => __( 'Select previously set font stack for main subtitle and huge text element', 'clifden_domain_panel' ),
				"options" => array(
					"primary"   => __( 'Primary font stack', 'clifden_domain_panel' ),
					"secondary" => __( 'Secondary font stack', 'clifden_domain_panel' ),
					"terciary"  => __( 'Terciary font stack', 'clifden_domain_panel' )
					),
				"default" => "terciary"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "design-4",
		"title" => __( 'Stylesheet', 'clifden_domain_panel' )
	),
		array(
			"type" => "help",
			"topic" => __( 'Why my changes are not being applied?', 'clifden_domain_panel' ),
			"content" => __( 'Please note, that CSS styles are being cached (the theme sets this to 14 days interval). If your changes are not being applied, clean the browser cache first and reload the website. Or you can put WordPress into debug mode when the cache interval decreases to 30 seconds.', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Other CSS settings ', 'clifden_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."minimize-css",
				"label" => __( 'Minimize CSS', 'clifden_domain_panel' ),
				"desc" => __( 'Compress the main CSS stylesheet file (speeds up website loading)', 'clifden_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."gzip-cssonly",
				"label" => __( 'Enable GZIP compression on main stylesheet file only', 'clifden_domain_panel' ),
				"desc" => __( 'If your web host applies GZIP compression by default, you can disable the main GZIP compression in "General" theme options. However, as main CSS stylesheet is being inserted as PHP file (and automatic GZIP compression is usually not applied on such files, you can enable it here.<br />You do not need to enable this GZIP compression if the global one (in "General" theme options) is enabled for the theme.', 'clifden_domain_panel' )
			),
			array(
				"type" => "hr"
			),

			array(
				"type" => "textarea",
				"id" => $prefix."custom-css",
				"label" => __( 'Custom CSS', 'clifden_domain_panel' ),
				"desc" => __( 'Type in custom CSS styles. These styles will be added to the end of the main CSS stylesheet file.', 'clifden_domain_panel' ),
				"default" => "",
				"cols" => 70,
				"rows" => 15,
				"class" => "code"
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),

array(
	"type" => "section-close"
)

);

?>