<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - General
*****************************************************
*/
$default_gmap_api_key='AIzaSyCdJtmeY-OtPEfgYyYfchI8jho6Yt7BWZg';

$imageSizes = array(
		//landscape
		'ratio-11'  => __( 'Square', 'clifden_domain_panel' ),
		'ratio-43'  => __( 'Landscape 4 to 3', 'clifden_domain_panel' ),
		'ratio-32'  => __( 'Landscape 3 to 2', 'clifden_domain_panel' ),
		'ratio-169' => __( 'Landscape 16 to 9 (widescreen)', 'clifden_domain_panel' ),
		'ratio-21'  => __( 'Landscape 2 to 1', 'clifden_domain_panel' ),
		'ratio-31'  => __( 'Landscape 3 to 1', 'clifden_domain_panel' ),
		//portrait
		'ratio-34'  => __( 'Portrait 3 to 4', 'clifden_domain_panel' ),
		'ratio-23'  => __( 'Portrait 2 to 3', 'clifden_domain_panel' ),
		'ratio-916' => __( 'Portrait 9 to 16', 'clifden_domain_panel' ),
		'ratio-12'  => __( 'Portrait 1 to 2', 'clifden_domain_panel' ),
	);

$prefix = 'general-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "general",
	"title" => __( 'General', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "general",
		"list" => array(
			__( 'Basics', 'clifden_domain_panel' ),
			__( 'Images', 'clifden_domain_panel' ),
			__( 'Custom posts', 'clifden_domain_panel' ),
			__( 'Page templates', 'clifden_domain_panel' ),
			__( 'Client area', 'clifden_domain_panel' ),
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-1",
		"title" => __( 'Basics', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Maps', 'clifden_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "text",
				"id" => $prefix."map-api-key",
				"label" => __( 'Google map api key', 'clifden_domain_panel' ),
				"desc" => __( 'New google map api need an api key', 'clifden_domain_panel' ),
				"default" => __( $default_gmap_api_key, 'clifden_domain_panel' ),
				"cols" => 60,
				"rows" => 3,
				"empty" => true
			),
			array(
				"type" => "hr"
			),
		array(
			"type" => "heading3",
			"content" => __( 'Comments', 'clifden_domain_panel' ),
		),
			array(
				"type" => "warning",
				"content" => __( 'Please note that these settings will affect pages/posts/projects you create from now on. If there are comments already active for the existing pages/posts/projects, you will need to disable them manually. This is default WordPress behaviour.', 'clifden_domain_panel' )
			),
			array(
				"type" => "box",
				"content" => '<p><strong>' . __( 'To disable comments manually for each already created page/post/project you have 2 options:', 'clifden_domain_panel' ) . '</strong></p><ol><li>' . __( 'On page/posts/projects list table in WordPress admin select all the affected pages/posts/projects and choose "Edit" from "Bulk action" dropdown above the table, and press [Apply] button. Then just disable the comments option. This will disable the comments for already created pages/posts/projects in a batch.', 'clifden_domain_panel' ) . '</li><li>' . __( 'On page/post/project edit screen make sure the "Discussion" metabox is enabled in "Screen Options" (in upper right corner of the screen). Then just uncheck the checkboxes in that metabox.', 'clifden_domain_panel' ) . '</li></ol>'
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."page-comments",
				"label" => __( 'Disallow page comments', 'clifden_domain_panel' ),
				"desc" => __( 'Disables page comments and pingbacks only (even if global comments are enabled)', 'clifden_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."post-comments",
				"label" => __( 'Disallow post comments', 'clifden_domain_panel' ),
				"desc" => __( 'Disables post comments and pingbacks only (even if global comments are enabled)', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."project-comments",
				"label" => __( 'Disallow project comments', 'clifden_domain_panel' ),
				"desc" => __( 'Disables project comments and pingbacks only (even if global comments are enabled)', 'clifden_domain_panel' ),
				"default" => "true"
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "text",
				"id" => $prefix."comments-introduction",
				"label" => __( 'Comments introduction text', 'clifden_domain_panel' ),
				"desc" => __( 'Introduction text at the top of comments form', 'clifden_domain_panel' ),
				"default" => __( 'Join the discussion, leave a reply!', 'clifden_domain_panel' ),
				"cols" => 60,
				"rows" => 3,
				"empty" => true
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Others', 'clifden_domain_panel' )
		),
			array(
				"type" => "text",
				"id" => $prefix."website-author",
				"label" => __( 'Website author meta tag', 'clifden_domain_panel' ),
				"desc" => __( 'Place your name or your company name in meta tag in HTML head', 'clifden_domain_panel' ),
				"default" => 'Tiria - www.tiria.fr'
			),
			array(
				"type" => "text",
				"id" => $prefix."search-placeholder",
				"label" => __( 'Search form placeholder text', 'clifden_domain_panel' ),
				"desc" => __( 'Placeholder text displayed in search field', 'clifden_domain_panel' ),
				"default" => __( 'Search term', 'clifden_domain' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."gzip",
				"label" => __( 'Enable basic GZIP compression', 'clifden_domain_panel' ),
				"desc" => __( 'GZIP compression will speed up your website load time, so it is recommended to turn it on (except when you use a plugin to apply it).<br />Before enabling GZIP compression, please make sure your webhost (web server) supports this compression algorithm and it is enabled (you may get error note if the compression is not supported on your server).', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."valid-html",
				"label" => __( 'Make valid HTML code', 'clifden_domain_panel' ),
				"desc" => __( 'Removes recommended, but invalid (according to W3C validator) meta tags from HTML head (whole Dublin core and X-UA-Compatible will be removed)', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-css-cache",
				"label" => __( 'Disable theme CSS caching', 'clifden_domain_panel' ),
				"desc" => __( 'By default the theme applies 14 days cache header on its main CSS stylesheet. You can disable it here.', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-help",
				"label" => __( 'Disable theme contextual help', 'clifden_domain_panel' ),
				"desc" => __( 'Removes theme help texts from WordPress contextual help', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-update-notifier",
				"label" => __( 'Disable theme update notifier', 'clifden_domain_panel' ),
				"desc" => __( 'The theme is using update notifier script that checks for new theme update by connecting to WebMan server. If you notice slow response of WordPress admin, please try to disable update notifier as it is possible that your server can not connect and obtain correct theme version which causes the slowdown.', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."default-menu",
				"label" => __( 'Default WordPress menu order', 'clifden_domain_panel' ),
				"desc" => __( 'As you can see, the theme slightly changes positions of default WordPress admin menu items. With some plugins this might cause potential problems. Enable default menu order if the menu item created by the plugin is not displayed. If the problem with menu item of plugin still occurs even after enabling default WordPress menu order, contact WebMan support for assistance.', 'clifden_domain_panel' )
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-2",
		"title" => __( 'Images', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Image sizes used in different website sections', 'clifden_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "box",
				"content" => '<p>' . __( 'Please decide on and set the image sizes up for different website sections right after the theme installation. If you change the image sizes later on, the settings will apply only on newly uploaded images - so the images you upload after you change the settings below. All previous images will keep their original sizes.', 'clifden_domain_panel' ) . '</p>' . __( 'If you, however, wish to resize the previously uploaded images to new sizes set below, you can use a plugin for this. Recommended plugins are <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> or <a href="http://wordpress.org/extend/plugins/ajax-thumbnail-rebuild/" target="_blank">AJAX Thumbnail Rebuild</a>.', 'clifden_domain_panel' ),
			),
			array(
				"type" => "select",
				"id" => $prefix."projects-image-ratio",
				"label" => __( 'Projects and Posts shortcodes image aspect ratio', 'clifden_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of projects images displayed in portfolio list and post thumbnails in posts list shortcodes', 'clifden_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-32"
			),
			array(
				"type" => "select",
				"id" => $prefix."post-image-ratio",
				"label" => __( 'Blog list image aspect ratio', 'clifden_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of post thumbnail images displayed on Blog pages', 'clifden_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-32"
			),
			array(
				"type" => "select",
				"id" => $prefix."gallery-image-ratio",
				"label" => __( 'Gallery image aspect ratio', 'clifden_domain_panel' ),
				"desc" => __( 'Choose the default aspect ratio of gallery images', 'clifden_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-32"
			),
			array(
				"type" => "select",
				"id" => $prefix."staff-image-ratio",
				"label" => __( 'Staff image aspect ratio', 'clifden_domain_panel' ),
				"desc" => __( 'Choose the aspect ratio of staff portraits', 'clifden_domain_panel' ),
				"options" => $imageSizes,
				"default" => "ratio-11"
			),
			array(
				"type" => "select",
				"id" => $prefix."lightbox-img",
				"label" => __( 'Zoomed image size', 'clifden_domain_panel' ),
				"desc" => __( 'Choose what image size should be displayed when projects or blog featured image is zoomed', 'clifden_domain_panel' ),
				"options" => array(
					'full'  => __( 'Full size image', 'clifden_domain_panel' ),
					'large' => __( 'Large image (can be set in Settings > Media)', 'clifden_domain_panel' ),
					),
				"default" => "large"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-lightbox",
				"label" => __( "Disable theme's lightbox", 'clifden_domain_panel' ),
				"desc" => __( 'Disables PrettyPhoto lightbox image zooming effect for the whole website', 'clifden_domain_panel' )
			),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-3",
		"title" => __( 'Custom posts', 'clifden_domain_panel' )
	),
		array(
			"type" => "box",
			"content" => '<h4>' . __( 'In this section you can enable/disable several different custom post types or set their privilegues and permalink slugs.', 'clifden_domain_panel' ) . '</h4><p>' . __( 'When setting permalinks, please use URL address allowed characters only.', 'clifden_domain_panel' ) . '</p><p>' . __( 'For several custom posts you can enable revisions. These will allow you to restore previous content of the specific custom post, however, keep in mind that revisions take space in your database which is not desirable most of the time.', 'clifden_domain_panel' ) . '</p><p>' . __( 'For Projects custom post type you can choose which project type will be supported by the theme.', 'clifden_domain_panel' ) . '</p>' . __( 'Logos, Content Modules, FAQ, Prices and Slides (and, if rich staff pages are disabled, also Staff) custom posts are being redirected to homepage when visited directly. There is no need to display them individually.', 'clifden_domain_panel' )
		),

		//Modules
		array(
			"type" => "heading3",
			"content" => __( 'Content modules', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."modules-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-modules",
				"label" => __( 'Content Modules', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'post' => __( 'As post', 'clifden_domain_panel' ),
					'page' => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "page"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-module",
				"label" => __( '"module" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'clifden_domain_panel' ),
				"default" => "module"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."modules-revisions",
				"label" => __( 'Enable revisions', 'clifden_domain_panel' ),
				"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'clifden_domain_panel' )
			),
		array(
			"id" => $prefix."modules-role-container",
			"type" => "inside-wrapper-close"
		),

		//FAQ
		array(
			"type" => "heading3",
			"content" => __( '<abbr title="Frequently Asked Questions">FAQ</abbr>', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."faq-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-faq",
				"label" => __( 'FAQ', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'disable' => __( 'Disable', 'clifden_domain_panel' ),
					'post'    => __( 'As post', 'clifden_domain_panel' ),
					'page'    => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "post"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-faq",
				"label" => __( '"faq" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'clifden_domain_panel' ),
				"default" => "faq"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."faq-revisions",
				"label" => __( 'Enable revisions', 'clifden_domain_panel' ),
				"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'clifden_domain_panel' )
			),
		array(
			"id" => $prefix."faq-role-container",
			"type" => "inside-wrapper-close"
		),

		//Logos
		array(
			"type" => "heading3",
			"content" => __( 'Logos (of clients, partners)', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."logos-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-logos",
				"label" => __( 'Logos', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'disable' => __( 'Disable', 'clifden_domain_panel' ),
					'post'    => __( 'As post', 'clifden_domain_panel' ),
					'page'    => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "post"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-logos",
				"label" => __( '"logo" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'clifden_domain_panel' ),
				"default" => "logo"
			),
		array(
			"id" => $prefix."logos-role-container",
			"type" => "inside-wrapper-close"
		),

		//Prices
		array(
			"type" => "heading3",
			"content" => __( 'Prices (price tables)', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."prices-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-prices",
				"label" => __( 'Prices', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'disable' => __( 'Disable', 'clifden_domain_panel' ),
					'post'    => __( 'As post', 'clifden_domain_panel' ),
					'page'    => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "page"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-price",
				"label" => __( '"price" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'clifden_domain_panel' ),
				"default" => "price"
			),
		array(
			"id" => $prefix."prices-role-container",
			"type" => "inside-wrapper-close"
		),

		//Projects
		array(
			"type" => "heading3",
			"content" => __( 'Projects (portfolio)', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."projects-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-projects",
				"label" => __( 'Projects', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'disable' => __( 'Disable', 'clifden_domain_panel' ),
					'post'    => __( 'As post', 'clifden_domain_panel' ),
					'page'    => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "post"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-project",
				"label" => __( '"project" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Projects posts permalink base - you might need to change this for localization purposes', 'clifden_domain_panel' ),
				"default" => "project"
			),
				array(
					"type" => "text",
					"id" => $prefix."permalink-project-category",
					"label" => __( 'Project "category" permalink', 'clifden_domain_panel' ),
					"desc" => __( 'Project categories permalink base - you might need to change this for localization purposes', 'clifden_domain_panel' ),
					"default" => "project/category"
				),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-revisions",
				"label" => __( 'Enable revisions', 'clifden_domain_panel' ),
				"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'clifden_domain_panel' )
			),
			array(
				"type" => "hr",
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-disable-image",
				"label" => __( 'Disable image projects', 'clifden_domain_panel' ),
				"desc" => __( 'Removes image project type from dropdown in Project settings', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-disable-slider",
				"label" => __( 'Disable image slider projects', 'clifden_domain_panel' ),
				"desc" => __( 'Removes image slider project type from dropdown in Project settings', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-disable-audio",
				"label" => __( 'Disable audio projects', 'clifden_domain_panel' ),
				"desc" => __( 'Removes audio project type from dropdown in Project settings', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."projects-disable-video",
				"label" => __( 'Disable video projects', 'clifden_domain_panel' ),
				"desc" => __( 'Removes video project type from dropdown in Project settings', 'clifden_domain_panel' )
			),
			array(
				"type" => "hr",
			),
			array(
				"type" => "select",
				"id" => $prefix."project-default-layout",
				"label" => __( 'Default project page layout', 'clifden_domain_adm' ),
				"desc" => __( 'Sets the default layout for project pages', 'clifden_domain_adm' ),
				"options" => $projectLayouts,
				"default" => "me-4",
				"optgroups" => true
			),
			array(
				"type" => "hr",
			),
			array(
				"type" => "additems",
				"id" => $prefix."projects-default-atts",
				"label" => __( 'Preset project attribute names', 'clifden_domain_panel' ),
				"desc" => __( 'Easy your project editing with preset project attribute names (you will just need to add a value on project edit screen). <br />You will still be able to remove or add new attributes per project basis.', 'clifden_domain_panel' ),
				"default" => ''
			),
		array(
			"id" => $prefix."projects-role-container",
			"type" => "inside-wrapper-close"
		),

		//Slides
		array(
			"type" => "heading3",
			"content" => __( 'Slides (for slideshows)', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."slides-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-slides",
				"label" => __( 'Slides', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'post' => __( 'As post', 'clifden_domain_panel' ),
					'page' => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "page"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-slide",
				"label" => __( '"slide" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'Although this post type is being redirected to homepage, you might want to change its slug in case the permalink collides with some plugins', 'clifden_domain_panel' ),
				"default" => "slide"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."slides-revisions",
				"label" => __( 'Enable revisions', 'clifden_domain_panel' ),
				"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'clifden_domain_panel' )
			),
		array(
			"id" => $prefix."slides-role-container",
			"type" => "inside-wrapper-close"
		),

		//Staff
		array(
			"type" => "heading3",
			"content" => __( 'Staff', 'clifden_domain_panel' )
		),
		array(
			"id" => $prefix."staff-role-container",
			"type" => "inside-wrapper-open",
			"class" => "toggle box"
		),
			array(
				"type" => "select",
				"id" => $prefix."role-staff",
				"label" => __( 'Staff', 'clifden_domain_panel' ),
				"desc" => __( 'Choose how this post type should be treated', 'clifden_domain_panel' ),
				"options" => array(
					'disable' => __( 'Disable', 'clifden_domain_panel' ),
					'post'    => __( 'As post', 'clifden_domain_panel' ),
					'page'    => __( 'As page', 'clifden_domain_panel' ),
					),
				"default" => "page"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."staff-rich",
				"label" => __( 'Rich staff members profiles', 'clifden_domain_panel' ),
				"desc" => __( 'By default whole staff member information is displayed in staff list (Staff shortcode). This option will, however, enable to display only short excerpt in the Staff shortcode and the whole information on a dedicated staff member page.', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "text",
				"id" => $prefix."permalink-staff",
				"label" => __( '"staff" permalink', 'clifden_domain_panel' ),
				"desc" => __( 'If rich Staff posts used, you might need to change their permalink base for localization purposes', 'clifden_domain_panel' ),
				"default" => "staff"
			),
				array(
					"type" => "text",
					"id" => $prefix."permalink-staff-department",
					"label" => __( 'Staff "department" permalink', 'clifden_domain_panel' ),
					"desc" => __( 'Staff departments permalink base - you might need to change this for localization purposes', 'clifden_domain_panel' ),
					"default" => "staff/department"
				),
			array(
				"type" => "checkbox",
				"id" => $prefix."staff-revisions",
				"label" => __( 'Enable revisions', 'clifden_domain_panel' ),
				"desc" => __( 'Revisions will allow you to restore previous state of the custom post. However, keep in mind that they take space in database.', 'clifden_domain_panel' )
			),
		array(
			"id" => $prefix."staff-role-container",
			"type" => "inside-wrapper-close"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-4",
		"title" => __( 'Page templates', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Disable unnecessary page templates', 'clifden_domain_panel' ),
			"class" => "first"
		)
	);
	if ( function_exists( 'wp_get_theme' ) ) { //WP3.3 and below cannot get the array of page templates - it is not even in database
		foreach ( $pageTemplates as $file => $name ) {
			$id = str_replace( array( '-', '/', '.' ), '_', $file );
			if ( ! ( 'tpl_portfolio_php' === $id && 'disable' === wm_option( 'general-role-projects' ) ) )
				array_push( $options,
					array(
						"type" => "checkbox",
						"id" => $prefix."tpl-".$id,
						"label" => sprintf( __( '%s template', 'clifden_domain_panel' ), $name ),
						"desc" => __( 'Hides this page template from template dropdown list', 'clifden_domain_panel' )
					),
					array(
						"type" => "space"
					)
				);
		}
	} else {
		array_push( $options,
				array(
					"type" => "warning",
					"content" => __( 'Sorry this function is available only for WordPress version 3.4 and up.', 'clifden_domain_panel' )
				)
			);
	}
	array_push( $options,
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "general-5",
		"title" => __( 'Client area', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Clients area', 'clifden_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "box",
				"content" => '<p class="info">' . __( 'Please read the information below before enabling and using the Client area.', 'clifden_domain_panel' ) . '</p><br /><br />
					<h4>' . __( 'What is Client area and how can I use it?', 'clifden_domain_panel' ) . '</h4>
					<p>' . sprintf( __( 'Client area makes it possible to restrict a visitor access to certain pages. The restriction can be set to registered users individually or to certain registered user group, such as "Subscribers" or "Contributors" &rarr; <a href="%s" target="_blank">manage users</a>. Restricted pages will be also removed from all menus, including Submenu widget, Custom Menu widget and Pages widget and also from search results when visitor access denied.', 'clifden_domain_panel' ), get_admin_url() . 'users.php' ) . '</p>
					<p>' . __( 'You can use this functionality to provide a special access to your clients specific files or information. Client will only see the pages (and menu items) after logging in (you can even use Login shortcode to place the form on any page or into text widget).', 'clifden_domain_panel' ) . '</p>
					<p>' . __( 'When you enable Client area below, a new option will be added to the bottom of <strong>"General" tab</strong> in <strong>"Page settings"</strong> metabox on page edit screen.', 'clifden_domain_panel' ) . '</p>
					<h4>' . __( 'How about security?', 'clifden_domain_panel' ) . '</h4>
					<p>' . __( 'Clients area is built upon WordPress native functionality, so it is as secure as your WordPress installation is. However, it does not provide restriction on attachment files, so if the visitor by any chance knows the exact URL of specific attachment file (even if it was attached to restricted page), it can be easily accessed. As a workaround you can use password protected ZIP files for this reason, for example.', 'clifden_domain_panel' ) . '</p>
					<h4>' . __( 'Can I restrict access to any page?', 'clifden_domain_panel' ) . '</h4>
					<p>' . __( 'Client area supports these page templates only: <strong>default</strong> page template, <strong>Blog</strong> page template, <strong>Map</strong> page template, <strong>Portfolio</strong> page template and <strong>Widgetized</strong> page template.', 'clifden_domain_panel' ) . '</p>
					<h4>' . __( 'How about posts or other content?', 'clifden_domain_panel' ) . '</h4>' . __( 'You can restrict access just for page templates mentioned previously. All the other content will be accessible.', 'clifden_domain_panel' ),
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."client-area",
				"label" => __( 'Enable client area', 'clifden_domain_panel' ),
				"desc" => __( 'Enables client area capabilities', 'clifden_domain_panel' )
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