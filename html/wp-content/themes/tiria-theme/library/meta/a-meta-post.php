<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Post meta boxes
*****************************************************
*/

/*
* Meta settings options for posts
*
* Has to be set up as function to pass the custom taxonomies array.
* Custom taxonomies are hooked onto 'init' action which is executed after the theme's functions file has been included.
* So if you're looking for taxonomy terms directly in the functions file, you're doing so before they've actually been registered.
* Meta box generator, which uses these settings options, is hooked onto 'add_meta_boxes' which is executed after 'init' action.
*/
if ( ! function_exists( 'wm_meta_post_options' ) ) {
	function wm_meta_post_options() {
		global $post, $sidebarPosition, $current_screen, $fontIcons;

		$skin     = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
		$postId   = ( $post ) ? ( $post->ID ) : ( null );
		$prefix   = '';
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

		$widgetsButtons = ( current_user_can( 'switch_themes' ) ) ? ( '<a class="button confirm" href="' . get_admin_url() . 'widgets.php">' . __( 'Manage widget areas', 'clifden_domain_adm' ) . '</a> <a class="button confirm" href="' . get_admin_url() . 'admin.php?page=' . WM_THEME_SHORTNAME . '-options">' . __( 'Create new widget areas', 'clifden_domain_adm' ) . '</a>' ) : ( '' );

		$metaPostOptions = array(

			//General settings
			array(
				"type" => "section-open",
				"section-id" => "general-section",
				"title" => __( 'General', 'clifden_domain_adm' )
			),

				array(
					"type" => "checkbox",
					"id" => $prefix."no-heading",
					"label" => __( 'Disable main heading', 'clifden_domain_adm' ),
					"desc" => __( 'Hides post/page main heading - the title', 'clifden_domain_adm' ),
					"value" => "true"
				),
					array(
						"type" => "space"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."subheading",
						"label" => __( 'Subtitle', 'clifden_domain_adm' ),
						"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"rows" => 2,
						"cols" => 57
					),
					array(
						"type" => "select",
						"id" => $prefix."main-heading-alignment",
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
						"id" => $prefix."main-heading-icon",
						"label" => __( 'Main heading icon', 'clifden_domain_adm' ),
						"desc" => __( 'Select an icon to display in main heading area', 'clifden_domain_adm' ),
						"options" => $menuIcons,
						"icons" => true
					),
				array(
					"type" => "hr"
				)
			);

			if ( ! wm_option( 'blog-disable-featured-image' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."disable-featured-image",
						"label" => __( 'Disable featured image for this post', 'clifden_domain_adm' ),
						"desc" => __( 'Disables featured image on single post view', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'top-bar-widgets' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-top-bar",
						"label" => __( 'Disable top bar', 'clifden_domain_adm' ),
						"desc" => __( 'Disables top bar widget area on this post', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( 'none' != wm_option( 'layout-breadcrumbs' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."breadcrumbs",
						"label" => __( 'Disable breadcrumbs', 'clifden_domain_adm' ),
						"desc" => __( 'Disables breadcrumbs navigation on this post', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( ! wm_option( 'blog-disable-bio' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."author",
						"label" => __( 'Disable author details', 'clifden_domain_adm' ),
						"desc" => __( 'Disables author information below the post content', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-above-footer-widgets",
						"label" => __( 'Disable widgets above footer', 'clifden_domain_adm' ),
						"desc" => __( 'Hides widget area above footer', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if (
					wm_option( 'social-share-facebook' )
					|| wm_option( 'social-share-twitter' )
					|| wm_option( 'social-share-googleplus' )
					|| wm_option( 'social-share-pinterest' )
				)
				array_push( $metaPostOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-sharing",
						"label" => __( 'Disable share buttons', 'clifden_domain_adm' ),
						"desc" => __( 'Disables sharing buttons for this post only', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( ! wm_option( 'blog-disable-featured-image' ) || is_active_sidebar( 'top-bar-widgets' ) || 'none' != wm_option( 'layout-breadcrumbs' ) || ! wm_option( 'blog-disable-bio' ) || is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaPostOptions,
					array(
						"type" => "hr"
					)
				);

			array_push( $metaPostOptions,
				array(
					"type" => "checkbox",
					"id" => "attachments-list",
					"label" => __( 'Display post attachments list', 'clifden_domain_adm' ),
					"desc" => __( 'Displays links to download all post attachments except images', 'clifden_domain_adm' ),
					"value" => "true"
				),
			array(
				"type" => "section-close"
			),



			//Gallery settings
			array(
				"type" => "section-open",
				"section-id" => "gallery-section",
				"title" => __( 'Gallery', 'clifden_domain_adm' )
			),
				array(
					"type" => "box",
					"content" => '
						<p>' . __( 'These settings will help you tweak the gallery inserted directly into post/page content (you can easily remove images from it) and create additional gallery at the bottom of the post/page or in slider area.', 'clifden_domain_adm' ) . '</p>
						<a class="button-primary thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&tab=gallery&TB_iframe=1">' . __( 'Insert gallery or add images', 'clifden_domain_adm' ) . '</a>
						',
				),

				array(
					"type" => "patterns",
					"id" => $prefix."gallery-images",
					"label" => __( 'Selected images from gallery', 'clifden_domain_adm' ),
					"desc" => __( 'Select which images should be processed with action set below. If there are no images displayed, save/update the post/page first.', 'clifden_domain_adm' ) . '<br /><a class="button thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add images to gallery', 'clifden_domain_adm' ) . '</a>',
					"options" => ( is_numeric( $postId ) ) ? ( wm_get_post_images( $postId, null, -1, true ) ) : ( null ),
					"field" => "checkbox",
					"default" => ""
				),
				array(
					"type" => "select",
					"id" => $prefix."gallery",
					"label" => __( 'Selected images action', 'clifden_domain_adm' ),
					"desc" => __( 'Choose what to do with the above images', 'clifden_domain_adm' ),
					"options" => array(
						'exclude'         => __( 'Remove them from post gallery', 'clifden_domain_adm' ),
						'excludedGallery' => __( 'Remove them from post gallery and create a new one at the bottom', 'clifden_domain_adm' ),
						'gallery'         => __( 'Create a new gallery at the bottom', 'clifden_domain_adm' ),
						'slider'          => __( 'Create a gallery in slider area', 'clifden_domain_adm' )
						),
					"default" => "exclude"
				),
				array(
					"conditional" => array(
						"field" => $prefix."gallery",
						"value" => "gallery,excludedGallery,slider"
						),
					"type" => "slider",
					"id" => $prefix."gallery-columns",
					"label" => __( 'Gallery columns', 'clifden_domain_adm' ),
					"desc" => __( 'Set the number of columns for this gallery', 'clifden_domain_adm' ),
					"default" => 3,
					"min" => 1,
					"max" => 6,
					"step" => 1,
					"validate" => "absint"
				),
				array(
					"conditional" => array(
						"field" => $prefix."gallery",
						"value" => "slider"
						),
					"type" => "color",
					"id" => $prefix."gallery-bg-color",
					"label" => __( 'Gallery background color', 'clifden_domain_adm' ),
					"desc" => __( 'Sets the custom gallery background color', 'clifden_domain_adm' ),
					"default" => "",
					"validate" => "color"
				),
				array(
					"conditional" => array(
						"field" => $prefix."gallery",
						"value" => "slider"
						),
					"type" => "checkbox",
					"id" => "gallery-width",
					"label" => __( 'Fullwidth', 'clifden_domain_adm' ),
					"desc" => __( 'Make the gallery spread the full width of the website', 'clifden_domain_adm' ),
					"value" => "true"
				),
			array(
				"type" => "section-close"
			),



			//Sidebar settings
			array(
				"type" => "section-open",
				"section-id" => "sidebar-section",
				"title" => __( 'Sidebar', 'clifden_domain_adm' )
			),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Choose a sidebar and its position on the post/page', 'clifden_domain_adm' ) . '</h4>' . $widgetsButtons,
				),

				array(
					"type" => "layouts",
					"id" => $prefix."layout",
					"label" => __( 'Sidebar position', 'clifden_domain_adm' ),
					"desc" => __( 'Choose a sidebar position on the post/page (set the first one to use the theme default settings)', 'clifden_domain_adm' ),
					"options" => $sidebarPosition,
					"default" => ""
				),
				array(
					"type" => "select",
					"id" => $prefix."sidebar",
					"label" => __( 'Choose a sidebar', 'clifden_domain_adm' ),
					"desc" => __( 'Select a widget area used as a sidebar for this post/page (if not set, the dafault theme settings will apply)', 'clifden_domain_adm' ),
					"options" => wm_widget_areas(),
					"default" => ""
				),
			array(
				"type" => "section-close"
			)
		);

		if (
				isset( $current_screen ) && 'edit' === $current_screen->parent_base &&
				'boxed' != wm_option( 'layout-boxed' ) &&
				'default.css' !== $skin
			)
			return $metaPostOptions;

		array_push( $metaPostOptions,

			//Design - website background settings
			array(
				"type" => "section-open",
				"section-id" => "background-settings",
				"title" => __( 'Background', 'clifden_domain_adm' ),
				"exclude" => array()
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

		return $metaPostOptions;
	}
} // /wm_meta_post_options



if ( ! function_exists( 'wm_meta_post_options_formats' ) ) {
	function wm_meta_post_options_formats() {
		global $post;

		$postId   = ( $post ) ? ( $post->ID ) : ( null );
		$prefix   = '';

		if ( ! $postId && isset( $_GET['post'] ) )
			$postId = absint( $_GET['post'] );

		if ( ! $postId )
			$postId = '{{{post_id}}}';

		$metaPostOptions = array(

			//audio post
			array(
				"id" => "post-format-audio",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "text",
					"id" => $prefix."audio-url",
					"label" => __( 'SoundCloud audio URL or <code>[audio]</code> shortcode', 'clifden_domain_adm' ),
					"desc" => __( 'Set the <a href="http://www.soundcloud.com" target="_blank">SoundCloud.com</a> audio clip URL address', 'clifden_domain_adm' ) . '<br />' . __( 'Or you can set the <a href="http://codex.wordpress.org/Audio_Shortcode" target="_blank"><code>[audio]</code> shortcode</a> here.', 'clifden_domain_adm' ),
				),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Audio post format', 'clifden_domain_adm' ) . '</h4>' . __( 'Displays audio player to play the predefined audio file. Could be used for Podcasting. You can place audio description into post content. Featured image will be used as artwork or album cover art.', 'clifden_domain_adm' )
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "audio",
					"value" => "audio"
					),
				"id" => "post-format-audio",
				"type" => "inside-wrapper-close"
			),

			//gallery post
			array(
				"id" => "post-format-gallery",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "checkbox",
					"id" => $prefix."gallery-slider",
					"label" => __( 'Slideshow on post page', 'clifden_domain_adm' ),
					"desc" => __( 'Displays slideshow from gallery images in single post view (so you do not have to include gallery in the post content)', 'clifden_domain_adm' ),
				),
				array(
					"type" => "space",
				),
				array(
					"type" => "box",
					"content" => '
						<h4>' . __( 'Gallery post format', 'clifden_domain_adm' ) . '</h4>
						<p>' . __( 'A gallery of images will be displayed in slideshow.', 'clifden_domain_adm' ) . '</p>
						<a class="button-primary thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&TB_iframe=1">' . __( 'Add images to post', 'clifden_domain_adm' ) . '</a>
						'
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "gallery",
					"value" => "gallery"
					),
				"id" => "post-format-gallery",
				"type" => "inside-wrapper-close"
			),

			//link post
			array(
				"id" => "post-format-link",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "text",
					"id" => $prefix."link-url",
					"label" => __( 'Link URL', 'clifden_domain_adm' ),
					"desc" => __( 'Enter a link URL address', 'clifden_domain_adm' )
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."link-target",
					"label" => __( 'Open in new window / tab', 'clifden_domain_adm' )
				),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Link post format', 'clifden_domain_adm' ) . '</h4>' . __( 'Displays useful URL link. Please insert a link URL address into the field above. You can place link description into post content area.', 'clifden_domain_adm' )
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "link",
					"value" => "link"
					),
				"id" => "post-format-link",
				"type" => "inside-wrapper-close"
			),

			//quote post
			array(
				"id" => "post-format-quote",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "text",
					"id" => $prefix."quoted-author",
					"label" => __( 'Quote source', 'clifden_domain_adm' ),
					"desc" => __( 'Enter quoted author name', 'clifden_domain_adm' )
				),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Quote post format', 'clifden_domain_adm' ) . '</h4>' . __( 'A quotation. Please place the actual quote directly into post content (use just simple stylings, do not use blockquotes as those will be applied automatically) and do not forget to fill in quoted author name above (you can use simple HTML tags in the field). This post format will populate the Testimonials shortcode. If featured image set, it will be used as quoted person photo in Testimonials shortcode (please upload square images only).', 'clifden_domain_adm' )
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "quote",
					"value" => "quote"
					),
				"id" => "post-format-quote",
				"type" => "inside-wrapper-close"
			),

			//status post
			array(
				"id" => "post-format-status",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Status post format', 'clifden_domain_adm' ) . '</h4>' . __( 'A short status update, similar to a Twitter status update. Please place the actual status text directly into post content area. Status posts can be displayed in various areas of the website (as shortcode or widget).', 'clifden_domain_adm' )
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "status",
					"value" => "status"
					),
				"id" => "post-format-status",
				"type" => "inside-wrapper-close"
			),

			//video post
			array(
				"id" => "post-format-video",
				"type" => "inside-wrapper-open"
			),
				array(
					"type" => "text",
					"id" => $prefix."video-url",
					"label" => __( 'Video URL or <code>[video]</code> shortcode', 'clifden_domain_adm' ),
					"desc" => sprintf( __( 'Enter full video URL (<a%s>supported video portals</a> and Screenr videos only)', 'clifden_domain_adm' ), ' href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank"' ) . '<br />' . __( 'Or you can set the <a href="http://codex.wordpress.org/Video_Shortcode" target="_blank"><code>[video]</code> shortcode</a> here.', 'clifden_domain_adm' ),
				),
				array(
					"type" => "box",
					"content" => '<h4>' . __( 'Video post format', 'clifden_domain_adm' ) . '</h4>' . __( 'A single video. Please insert a video URL or upload an MP4 video file. Video player will be automatically added to the post. You can place video description into post content. For self-hosted videos set also featured image that will be used as video cover/preview.', 'clifden_domain_adm' )
				),
			array(
				"conditional" => array(
					"field" => "post_format",
					"custom" => array( "input", "name", "radio" ),
					"post-format" => "video",
					"value" => "video"
					),
				"id" => "post-format-video",
				"type" => "inside-wrapper-close"
			)

		);

		return $metaPostOptions;
	}
} // /wm_meta_post_options_formats

?>