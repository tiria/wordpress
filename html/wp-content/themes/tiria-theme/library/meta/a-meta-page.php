<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Page meta boxes
*****************************************************
*/

/*
* Meta settings options for pages
*
* Has to be set up as function to pass the custom taxonomies array.
* Custom taxonomies are hooked onto 'init' action which is executed after the theme's functions file has been included.
* So if you're looking for taxonomy terms directly in the functions file, you're doing so before they've actually been registered.
* Meta box generator, which uses these settings options, is hooked onto 'add_meta_boxes' which is executed after 'init' action.
*/
if ( ! function_exists( 'wm_meta_page_options' ) ) {
	function wm_meta_page_options() {
		global $post, $portfolioLayout, $sidebarPosition, $websiteLayout, $current_screen, $fontIcons;

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


		//Page settings
		$metaPageOptions = $availableSliders = array();

		$availableSliders['default'] = __( '- default slider -', 'clifden_domain_adm' );
		$availableSliders['none'] = __( '- no slider -', 'clifden_domain_adm' );
		if ( ! wm_option( 'slider-flex-remove' ) )
			$availableSliders['flex'] = __( 'Flex Slider', 'clifden_domain_adm' );
		if ( ! wm_option( 'slider-nivo-remove' ) )
			$availableSliders['nivo'] = __( 'Nivo Slider', 'clifden_domain_adm' );
		if ( ! wm_option( 'slider-roundabout-remove' ) )
			$availableSliders['roundabout'] = __( 'Roundabout Slider', 'clifden_domain_adm' );
		$availableSliders['video'] = __( 'Video', 'clifden_domain_adm' );
		$availableSliders['static'] = __( 'Static featured image', 'clifden_domain_adm' );
		if ( ! wm_option( 'slider-custom-remove' ) )
			$availableSliders['custom'] = __( 'Custom slider', 'clifden_domain_adm' );



		//Redirect settings
		if ( ! wm_option( 'general-tpl-tpl_redirect_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "redirect-section",
					"title" => __( 'Redirect', 'clifden_domain_adm' ),
					"onlyfor" => array( 'tpl-redirect.php' )
				),
					array(
						"type" => "box",
						"content" => __( 'No page content will be displayed. The page will be automatically redirected to URL set below.', 'clifden_domain_adm' ),
					),

					array(
						"type" => "text",
						"id" => $prefix."redirect-link",
						"label" => __( 'Redirect link', 'clifden_domain_adm' ),
						"desc" => __( 'URL where the page will be automatically redirected to', 'clifden_domain_adm' ),
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefix."redirect-page",
						"label" => __( '...or choose a page', 'clifden_domain_adm' ),
						"desc" => __( 'Select a page to redirect to', 'clifden_domain_adm' ),
						"options" => wm_pages(),
					),
					array(
						"type" => "select",
						"id" => $prefix."redirect-status",
						"label" => __( 'Redirect status', 'clifden_domain_adm' ),
						"desc" => __( 'Select which redirect method to use', 'clifden_domain_adm' ),
						"options" => array(
							'301' => __( 'Permanent redirect (301)', 'clifden_domain_adm' ),
							'302' => __( 'Temporary redirect (302)', 'clifden_domain_adm' ),
							)
					),
				array(
					"type" => "section-close"
				)
			);



		//Map settings
		if ( ! wm_option( 'general-tpl-tpl_map_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "map-section",
					"title" => __( 'Map', 'clifden_domain_adm' ),
					"onlyfor" => array( 'tpl-map.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display a map', 'clifden_domain_adm' ) . '</h4>
							' . sprintf( __( 'View map page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-map.png" class="fancybox"' ),
					),

					array(
						"type" => "text",
						"id" => $prefix."map-gps",
						"label" => __( 'Map location GPS', 'clifden_domain_adm' ),
						"desc" => __( 'Insert the place geographic coordinates (latitude and longitude separated with comma, such as "40.78414, -73.96614"). ', 'clifden_domain_adm' )
							. '<br /><a href="http://www.webmandesign.eu/getgps" class="fancybox iframe">' . __( 'You can use external app to find geographic coordinates.', 'clifden_domain_adm' ) . '</a>',
						"default" => "0, 0",
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."map-center",
						"label" => __( 'Always center map on location', 'clifden_domain_adm' ),
						"desc" => __( 'Map will return to the location even after dragged out', 'clifden_domain_adm' ),
						"value" => 1
					),
					/***** Bypass by Tiria ***** 
					array(
						"type" => "checkbox",
						"id" => $prefix."map-style",
						"label" => __( 'Use default map styling', 'clifden_domain_adm' ),
						"desc" => __( 'Sets default Google Map styling', 'clifden_domain_adm' ) . '<br /><br />',
						"value" => "default"
					),
					***************************/
					array(
						"type" => "textarea",
						"id" => $prefix."map-info",
						"label" => __( 'Info bubble text', 'clifden_domain_adm' ),
						"desc" => __( 'Set map location info bubble text', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"rows" => 3
					),
					array(
						"type" => "slider",
						"id" => $prefix."map-zoom",
						"label" => __( 'Map zoom', 'clifden_domain_adm' ),
						"desc" => __( 'Map zoom on location', 'clifden_domain_adm' ),
						"default" => 10,
						"min" => 1,
						"max" => 17,
						"step" => 1,
						"validate" => "absint"
					),
					//***** Added by Tiria *****//
					array(
						"type" => "slider",
						"id" => $prefix."map-saturation",
						"label" => __( 'Map saturation', 'clifden_domain_adm' ),
						"desc" => __( 'Map saturation, 0 -> black and white map, 100 -> colored map', 'clifden_domain_adm' ),
						"default" => 10,
						"min" => 0,
						"max" => 100,
						"step" => 5,
						"validate" => "absint"
					),
					//**************************//
					array(
						"type" => "slider",
						"id" => $prefix."map-height",
						"label" => __( 'Map height', 'clifden_domain_adm' ),
						"desc" => __( 'Sets map height in pixels', 'clifden_domain_adm' ),
						"default" => 300,
						"min" => 100,
						"max" => 1000,
						"step" => 10,
						"validate" => "absint"
					),
					//***** Added by Tiria *****//
					array(
						"type" => "select",
						"id" => $prefix."map-style",
						"label" => __( 'Map Styling', 'clifden_domain_adm' ),
						"desc" => __( 'Choose styl', 'clifden_domain_adm' ),
						"options" => array(
							'theme'   => __( 'Default theme styling', 'clifden_domain_adm' ),
							'nopoi'   => __( 'Disable point of interest', 'clifden_domain_adm' ),
							'notext'  => __( 'Disable all text', 'clifden_domain_adm' ),
							'default' => __( 'Default google map styling', 'clifden_domain_adm' ),
							)
					),
					//**************************//
					array(
						"type" => "checkbox",
						"id" => $prefix."map-top",
						"label" => __( 'Map beneath header', 'clifden_domain_adm' ),
						"desc" => __( 'You can move map beneath the website header just by selecting the option below', 'clifden_domain_adm' ),
					),
				array(
					"type" => "section-close"
				)
			);



		//Blog section
		if ( ! wm_option( 'general-tpl-home_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "blog-section",
					"title" => __( 'Blog', 'clifden_domain_adm' ),
					"onlyfor" => array( 'blog-page', 'home.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display blog posts', 'clifden_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View blog page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-blog.png" class="fancybox"' ) . ' ' . __( 'The actual content of the page will be displayed above blog posts list. You can set blog posts list options below.', 'clifden_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'post-new.php">' . __( 'Add new post', 'clifden_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit.php">' . __( 'Edit posts', 'clifden_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">' . __( 'Edit post categories', 'clifden_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=post_tag">' . __( 'Edit post tags', 'clifden_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "slider",
						"id" => $prefix."blog-posts-count",
						"label" => __( 'Number of posts to display', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the number of posts listed on this page only. Other archives will display posts according to WordPress settings. <br />Value of "-1" will display all posts. When you set the value of "0", WordPress settings are applied.', 'clifden_domain_adm' ),
						"default" => get_option( 'posts_per_page' ),
						"min" => -1,
						"max" => 25,
						"step" => 1,
						"validate" => "int"
					),
					array(
						"type" => "hr"
					),

					array(
						"type" => "additems",
						"id" => $prefix."blog-cats",
						"label" => __( 'Posts source', 'clifden_domain_adm' ),
						"desc" => __( 'You can choose to display all posts or posts from specific categories. <br />Press [+] button to add a category and select the category name from dropdown list.', 'clifden_domain_adm' ),
						"default" => "0",
						"field" => "select",
						"options" => wm_tax_array()
					),
					array(
						"conditional" => array(
							"field" => $prefix."blog-cats",
							"value" => "",
							"type" => "not"
							),
						"type" => "radio",
						"id" => $prefix."blog-cats-action",
						"label" => __( 'Exclude / use categories', 'clifden_domain_adm' ),
						"desc" => __( 'Choose whether above categories should be excluded or used (does not apply on "All posts")', 'clifden_domain_adm' ),
						"options" => array(
							'category__in'     => __( 'Posts just from these categories', 'clifden_domain_adm' ),
							'category__not_in' => __( 'Exclude posts from these categories', 'clifden_domain_adm' )
							),
						"default" => "category__in"
					),
				array(
					"type" => "section-close"
				)
			);



		//Portfolio settings
		if ( 'disable' != wm_option( 'general-role-projects' ) && ! wm_option( 'general-tpl-tpl_portfolio_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "portfolio-section",
					"title" => __( 'Portfolio', 'clifden_domain_adm' ),
					"onlyfor" => array( 'tpl-portfolio.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This page will display portfolio of your projects', 'clifden_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View portfolio page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-portfolio.png" class="fancybox"' ) . ' ' . __( 'The actual content of the page will be displayed above projects list. You can set projects list options below.', 'clifden_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'post-new.php?post_type=wm_projects">' . __( 'Add new project', 'clifden_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit.php?post_type=wm_projects">' . __( 'Edit projects', 'clifden_domain_adm' ) . '</a>
							<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=project-category&amp;post_type=wm_projects">' . __( 'Edit project categories', 'clifden_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "select",
						"id" => $prefix."portfolio-category",
						"label" => __( 'Projects main category', 'clifden_domain_adm' ),
						"desc" => __( 'Select whether to display all projects or just the ones from specific main category (only first level categories can be chosen)', 'clifden_domain_adm' ),
						"options" => wm_tax_array( array(
								'allCountPost' => 'wm_projects',
								'allText'      => __( 'All projects', 'clifden_domain_adm' ),
								'parentsOnly'  => true,
								'tax'          => 'project-category',
							) ),
						"default" => ""
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."portfolio-filter",
						"label" => __( 'Display filter', 'clifden_domain_adm' ),
						"desc" => __( 'Use animated filtering on the projects list', 'clifden_domain_adm' )
					),
					array(
						"type" => "space",
					),
					array(
						"type" => "slider",
						"id" => $prefix."portfolio-count",
						"label" => __( 'Number of projects', 'clifden_domain_adm' ),
						"desc" => __( 'This will affect the number of projects listed on the page. Set "-1" to display all items, set "0" to use default WordPress settings.', 'clifden_domain_adm' ),
						"default" => get_option( 'posts_per_page' ),
						"min" => -1,
						"max" => 32,
						"step" => 1,
						"validate" => "int"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."portfolio-pagination",
						"label" => __( 'Display pagination', 'clifden_domain_adm' ),
						"desc" => __( 'By default the pagination on projects list is disabled. You can enable it with this setting.', 'clifden_domain_adm' )
					),
					array(
						"type" => "space",
					),
					array(
						"type" => "layouts",
						"id" => $prefix."portfolio-columns",
						"label" => __( 'Layout', 'clifden_domain_adm' ),
						"desc" => __( 'Choose how many columns should the projects list be split to', 'clifden_domain_adm' ),
						"options" => $portfolioLayout,
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."portfolio-order",
						"label" => __( 'List ordering', 'clifden_domain_adm' ),
						"desc" => __( 'Choose how projects should be ordered', 'clifden_domain_adm' ),
						"options" => array(
							'new'    => __( 'Newest first', 'clifden_domain_adm' ),
							'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
							'name'   => __( 'Alphabetically', 'clifden_domain_adm' ),
							'random' => __( 'Random selection', 'clifden_domain_adm' )
							)
					),
				array(
					"type" => "section-close"
				)
			);



		//Landing page settings
		if ( ! wm_option( 'general-tpl-tpl_landing_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "landing-section",
					"title" => __( 'Landing page', 'clifden_domain_adm' ),
					"onlyfor" => array( 'tpl-landing.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'This is a special landing page layout', 'clifden_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View landing page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-landing.png" class="fancybox"' ) . ' ' . __( 'Please note that a new navigation menu area was created for this page. This allows you to display diferent menu on this page opposite to the rest of the website. If no menu assigned, only logo and header text area (set below) will be displayed in header.', 'clifden_domain_adm' ) . '</p>
							<a class="button confirm" href="' . get_admin_url() . 'nav-menus.php">' . __( 'Assign a menu to', 'clifden_domain_adm' ) . ' <strong>"' . get_the_title() . '" ' . __( 'page navigation', 'clifden_domain_adm' ) . '</strong></a>
							',
					),

					array(
						"type" => "checkbox",
						"id" => $prefix."landing-no-heading",
						"label" => __( 'Disable main heading', 'clifden_domain_adm' ),
						"desc" => __( 'Hides post/page main heading - the title', 'clifden_domain_adm' ),
						"value" => "true"
					),
					array(
						"type" => "space"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-subheading",
						"label" => __( 'Subtitle', 'clifden_domain_adm' ),
						"desc" => __( 'If defined, the specially styled subtitle will be displayed', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"rows" => 2
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-main-heading-alignment",
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
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-header-right",
						"label" => __( 'Header text', 'clifden_domain_adm' ),
						"desc" => __( 'Text in area right from logo in website header. You can use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'clifden_domain_adm' ),
						"default" => wm_option( 'layout-header-right' ),
						"cols" => 60,
						"validate" => "lineBreakHTML",
						"rows" => 5
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-above-footer-widgets",
						"label" => __( 'Above footer widgets area', 'clifden_domain_adm' ),
						"desc" => __( 'Sets above footer widgets area', 'clifden_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-footer1-widgets",
						"label" => __( 'Footer top row widgets area', 'clifden_domain_adm' ),
						"desc" => __( 'Sets footer top row widgets area', 'clifden_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "select",
						"id" => $prefix."landing-footer2-widgets",
						"label" => __( 'Footer bottom row widgets area', 'clifden_domain_adm' ),
						"desc" => __( 'Sets footer bottom row widgets area', 'clifden_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-credits",
						"label" => __( 'Credits / copyright text', 'clifden_domain_adm' ),
						"desc" => __( 'Leave empty to display default text. Use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade; or YEAR for current year.', 'clifden_domain_adm' ),
						"default" => "",
						"cols" => 60,
						"validate" => "lineBreakHTML",
						"rows" => 3
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."landing-tracking",
						"label" => __( 'Custom tracking code', 'clifden_domain_adm' ),
						"desc" => __( 'Google Analytics custom tracking code (the default one will be replaced) - include <code>&lt;script&gt;</code> HTML tag', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakSpace",
						"class" => "code",
						"cols" => 60,
						"rows" => 3
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "layouts",
						"id" => $prefix."landing-boxed",
						"label" => __( 'Page layout', 'clifden_domain_adm' ),
						"desc" => __( 'Choose layout for this page', 'clifden_domain_adm' ),
						"options" => $websiteLayout,
						"default" => wm_option( 'layout-boxed' )
					),
				array(
					"type" => "section-close"
				)
			);



		//Under construction settings
		if ( ! wm_option( 'general-tpl-tpl_construction_php' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "section-open",
					"section-id" => "construction-section",
					"title" => __( 'Under construction', 'clifden_domain_adm' ),
					"onlyfor" => array( 'tpl-construction.php' )
				),
					array(
						"type" => "box",
						"content" => '
							<h4>' . __( 'Countdown timer will be displayed on this page', 'clifden_domain_adm' ) . '</h4>
							<p>' . sprintf( __( 'View under construction page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-under-construction.png" class="fancybox"' ) . ' ' . __( 'The page displays information of when your website is about to be lounched. You can set the date, when it is planned to go live and the countdown timer will be displayed.', 'clifden_domain_adm' ) . '</p>
							<a class="button-primary confirm" href="' . get_admin_url() . 'options-reading.php">' . __( 'Set this page as homepage', 'clifden_domain_adm' ) . '</a> (' . __( 'do not forget to <strong>save/update the page first</strong>', 'clifden_domain_adm' ) . ')
							',
					),
					array(
						"type" => "datepicker",
						"id" => $prefix."construction-date",
						"label" => __( 'Date', 'clifden_domain_adm' ),
						"desc" => __( 'Set the date when the website will be ready', 'clifden_domain_adm' ),
						"class" => "future"
					),
					array(
						"type" => "select",
						"id" => $prefix."construction-time",
						"label" => __( 'Optional time', 'clifden_domain_adm' ),
						"desc" => __( 'Set the exact hour when the website will be ready', 'clifden_domain_adm' ),
						"options" => array(
								"00:00" => "00:00",
								"01:00" => "01:00",
								"02:00" => "02:00",
								"03:00" => "03:00",
								"04:00" => "04:00",
								"05:00" => "05:00",
								"06:00" => "06:00",
								"07:00" => "07:00",
								"08:00" => "08:00",
								"09:00" => "09:00",
								"10:00" => "10:00",
								"11:00" => "11:00",
								"12:00" => "12:00",
								"13:00" => "13:00",
								"14:00" => "14:00",
								"15:00" => "15:00",
								"16:00" => "16:00",
								"17:00" => "17:00",
								"18:00" => "18:00",
								"19:00" => "19:00",
								"20:00" => "20:00",
								"21:00" => "21:00",
								"22:00" => "22:00",
								"23:00" => "23:00"
							),
						"default" => "00:00"
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."construction-header-right",
						"label" => __( 'Header text', 'clifden_domain_adm' ),
						"desc" => __( 'Text in area right from logo in website header. You can use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'clifden_domain_adm' ),
						"default" => wm_option( 'layout-header-right' ),
						"validate" => "lineBreakHTML",
						"cols" => 60,
						"rows" => 5
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "select",
						"id" => $prefix."construction-timer-widgets",
						"label" => __( 'Below timer widgets area', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the widget area below countdown timer', 'clifden_domain_adm' ),
						"options" => wm_widget_areas(),
						"default" => ""
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "textarea",
						"id" => $prefix."construction-credits",
						"label" => __( 'Credits / copyright text', 'clifden_domain_adm' ),
						"desc" => __( 'Leave empty to display default text. Use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade; or YEAR for current year.', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "lineBreakHTML",
						"cols" => 60,
						"rows" => 3
					),
				array(
					"type" => "section-close"
				)
			);



		array_push( $metaPageOptions,

			//General settings
			array(
				"type" => "section-open",
				"section-id" => "general-section",
				"title" => __( 'General', 'clifden_domain_adm' ),
				"exclude" => array( 'tpl-landing.php', 'tpl-construction.php', 'tpl-redirect.php' )
			),
				//default page tpl
					array(
						"id" => "pagetpl-default",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View default page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-default.png" class="fancybox"' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "default"
							),
						"id" => "pagetpl-default",
						"type" => "inside-wrapper-close"
					),

				//sections page tpl
					array(
						"id" => "pagetpl-sections",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View sections page <a %1s>layout structure</a>. Please note that you have to use the %2s shortcode to display content inside website content box dimensions.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-sections.png" class="fancybox"', '<code> [section class="TEXT"&#93; TEXT [/section&#93; </code>' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "tpl-sections.php"
							),
						"id" => "pagetpl-sections",
						"type" => "inside-wrapper-close"
					),

				//sitemap page tpl
					array(
						"id" => "pagetpl-sitemap",
						"type" => "inside-wrapper-open"
					),
						array(
							"type" => "box",
							"content" => sprintf( __( 'View sitemap page <a %s>layout structure</a>.', 'clifden_domain_adm' ), 'href="' . WM_ASSETS_ADMIN . 'img/layouts/page-sitemap.png" class="fancybox"' )
						),
					array(
						"conditional" => array(
							"field" => "page_template",
							"value" => "tpl-sitemap.php"
							),
						"id" => "pagetpl-sitemap",
						"type" => "inside-wrapper-close"
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

			if ( is_active_sidebar( 'top-bar-widgets' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-top-bar",
						"label" => __( 'Disable top bar', 'clifden_domain_adm' ),
						"desc" => __( 'Disables top bar widget area on this page', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( 'none' != wm_option( 'layout-breadcrumbs' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."breadcrumbs",
						"label" => __( 'Disable breadcrumbs', 'clifden_domain_adm' ),
						"desc" => __( 'Disables breadcrumbs navigation on this page', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-above-footer-widgets",
						"label" => __( 'Disable widgets above footer', 'clifden_domain_adm' ),
						"desc" => __( 'Hides widget area above footer', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if (
					( wm_option( 'social-share-facebook' )
					|| wm_option( 'social-share-twitter' )
					|| wm_option( 'social-share-googleplus' )
					|| wm_option( 'social-share-pinterest' ) )
					&& wm_option( 'social-share-pages' )
				)
				array_push( $metaPageOptions,
					array(
						"type" => "checkbox",
						"id" => $prefix."no-sharing",
						"label" => __( 'Disable share buttons', 'clifden_domain_adm' ),
						"desc" => __( 'Disables sharing buttons for this post only', 'clifden_domain_adm' ),
						"value" => "true"
					)
				);

			if ( is_active_sidebar( 'top-bar-widgets' ) || 'none' != wm_option( 'layout-breadcrumbs' ) || is_active_sidebar( 'above-footer-widgets' ) )
				array_push( $metaPageOptions,
					array(
						"type" => "hr"
					)
				);

			array_push( $metaPageOptions,
				array(
					"type" => "checkbox",
					"id" => "attachments-list",
					"label" => __( 'Display post attachments list', 'clifden_domain_adm' ),
					"desc" => __( 'Displays links to download all post attachments except images', 'clifden_domain_adm' ),
					"value" => "true"
				)
			);

			if ( wm_option( 'general-client-area' ) )
			array_push( $metaPageOptions,
				array(
					"type" => "hr"
				),
				array(
					"type" => "select",
					"id" => $prefix."restrict-access",
					"label" => __( 'Restrict access', 'clifden_domain_adm' ),
					"desc" => __( 'Restricts access to certain users or user groups', 'clifden_domain_adm' ),
					"options" => wm_users(),
					"optgroups" => true
				)
			);

			array_push( $metaPageOptions,
			array(
				"type" => "section-close"
			),



			//Slider settings
			array(
				"type" => "section-open",
				"section-id" => "slider-section",
				"title" => __( 'Slider', 'clifden_domain_adm' ),
				"exclude" => array( 'tpl-redirect.php', 'tpl-map.php' )
			),
				array(
					"type" => "box",
					"content" => '
						<h4>' . __( 'Choose what slider to display on this page', 'clifden_domain_adm' ) . '</h4>
						<p>' . __( 'You can display "Slides" custom posts or page image gallery in the slider (it is possible to choose, what images will be displayed in slider).', 'clifden_domain_adm' ) . '</p>
						<a class="button-primary confirm" href="' . get_admin_url() . 'post-new.php?post_type=wm_slides">' . __( 'Add new Slides custom post', 'clifden_domain_adm' ) . '</a>
						<a class="button-primary thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&TB_iframe=1">' . __( 'Add images to page', 'clifden_domain_adm' ) . '</a>
						<a class="button confirm" href="' . get_admin_url() . 'edit.php?post_type=wm_slides">' . __( 'Edit Slides posts', 'clifden_domain_adm' ) . '</a>
						<a class="button confirm" href="' . get_admin_url() . 'edit-tags.php?taxonomy=slide-category&amp;post_type=wm_slides">' . __( 'Edit Slide groups', 'clifden_domain_adm' ) . '</a>
						',
				),

				array(
					"type" => "select",
					"id" => $prefix."slider-type",
					"label" => __( 'Enable slider', 'clifden_domain_adm' ),
					"desc" => __( 'Select a slider type from the dropdown list below', 'clifden_domain_adm' ),
					"options" => $availableSliders,
					"default" => "default"
				),

					array(
						"id" => $prefix."slider-settings",
						"type" => "inside-wrapper-open"
					),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "static"
								),
							"type" => "checkbox",
							"id" => $prefix."slider-static-stretch",
							"label" => __( 'Stretch (fit) the image', 'clifden_domain_adm' ),
							"desc" => __( 'Image fits the full website width', 'clifden_domain_adm' ) . '<br /><br />',
							"value" => "fullwidth"
						),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "video"
								),
							"type" => "text",
							"id" => $prefix."slider-video-url",
							"label" => __( 'Video URL', 'clifden_domain_adm' ),
							"desc" => __( 'Enter full video URL (supports YouTube, Vimeo and Screenr - does not support self-hosted videos)', 'clifden_domain_adm' ),
							"validate" => "url"
						),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "custom"
								),
							"type" => "text",
							"id" => $prefix."slider-custom-shortcode",
							"label" => __( 'Custom slider shortcode', 'clifden_domain_adm' ),
							"desc" => __( 'Most of custom slider plugins let you display the slider using shortcode. Please, insert such slider shortcode into this text field. The slider will then be displayed in main slider area of the website.', 'clifden_domain_adm' ),
						),

						array(
							"id" => $prefix."slider-settings-content",
							"type" => "inside-wrapper-open"
						),

							array(
								"conditional" => array(
									"field" => $prefix."slider-type",
									"value" => "roundabout"
									),
								"type" => "slider",
								"id" => $prefix."slider-roundabout-width",
								"label" => __( 'Width corrections', 'clifden_domain_adm' ),
								"desc" => __( 'Adjust Roundabout slider width', 'clifden_domain_adm' ),
								"default" => 0,
								"min" => -400,
								"max" => 0,
								"step" => 1,
								"validate" => "int",
								"zero" => true
							),
								array(
									"conditional" => array(
										"field" => $prefix."slider-type",
										"value" => "roundabout"
										),
									"type" => "slider",
									"id" => $prefix."slider-roundabout-height",
									"label" => __( 'Height corrections', 'clifden_domain_adm' ),
									"desc" => __( 'Adjust Roundabout slider height', 'clifden_domain_adm' ),
									"default" => 400,
									"min" => 100,
									"max" => 660,
									"step" => 1,
									"validate" => "int"
								),
								array(
									"conditional" => array(
										"field" => $prefix."slider-type",
										"value" => "roundabout"
										),
									"type" => "slider",
									"id" => $prefix."slider-roundabout-tilt",
									"label" => __( 'Slider tilting', 'clifden_domain_adm' ),
									"desc" => __( 'Adjust Roundabout slider tilt', 'clifden_domain_adm' ),
									"default" => 0,
									"min" => -300,
									"max" => 300,
									"step" => 1,
									"validate" => "int",
									"zero" => true
								),
								array(
									"conditional" => array(
										"field" => $prefix."slider-type",
										"value" => "roundabout"
										),
									"type" => "slider",
									"id" => $prefix."slider-roundabout-bottom",
									"label" => __( 'Slides bottom position correction', 'clifden_domain_adm' ),
									"desc" => __( 'Correct Roundabout slider bottom position', 'clifden_domain_adm' ),
									"default" => 0,
									"min" => -100,
									"max" => 100,
									"step" => 1,
									"validate" => "int",
									"zero" => true
								),

							array(
								"conditional" => array(
									"field" => $prefix."slider-type",
									"value" => "nivo,flex,custom"
									),
								"type" => "checkbox",
								"id" => $prefix."slider-width",
								"label" => __( 'Fit website width', 'clifden_domain_adm' ),
								"desc" => __( 'Stretches the slider full website width', 'clifden_domain_adm' ) . '<br /><br />',
								"value" => "fullwidth"
							),


							array(
								"id" => $prefix."slider-settings-standard",
								"type" => "inside-wrapper-open"
							),
								array(
									"type" => "slider",
									"id" => $prefix."slider-count",
									"label" => __( 'Number of slides', 'clifden_domain_adm' ),
									"desc" => __( 'Maximum number of slides (items) to be displayed in the slider', 'clifden_domain_adm' ),
									"default" => 8,
									"min" => 1,
									"max" => ( wm_option( 'slider-max-number' ) ) ? ( wm_option( 'slider-max-number' ) ) : ( 8 ),
									"step" => 1,
									"validate" => "absint"
								),
								array(
									"type" => "select",
									"id" => $prefix."slider-content",
									"label" => __( 'Slider content', 'clifden_domain_adm' ),
									"desc" => __( 'Choose which content type will populate the slider', 'clifden_domain_adm' ),
									"options" => array(
										'wm_slides' => __( 'Slides custom posts', 'clifden_domain_adm' ),
										'gallery'   => __( 'Image gallery', 'clifden_domain_adm' )
										),
									"default" => "wm_slides"
								),
									array(
										"conditional" => array(
											"field" => $prefix."slider-content",
											"value" => "wm_slides"
											),
										"type" => "select",
										"id" => $prefix."slider-slides-cat",
										"label" => __( 'Slides group', 'clifden_domain_adm' ),
										"desc" => __( 'Choose which slides group will populate the slider', 'clifden_domain_adm' ),
										"options" => wm_tax_array( array(
												'allCountPost' => 'wm_slides',
												'allText'      => __( 'All Slides', 'clifden_domain_adm' ),
												'tax'          => 'slide-category',
											) ),
										"default" => 0
									),
									array(
										"conditional" => array(
											"field" => $prefix."slider-content",
											"value" => "gallery"
											),
										"type" => "patterns",
										"id" => $prefix."slider-gallery-images",
										"label" => __( 'Choose slider images', 'clifden_domain_adm' ),
										"desc" => __( 'Select which images will be displayed in the slider (you may need to save/update the post to see the images)', 'clifden_domain_adm' ) . '<br /><a class="button thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&type=image&TB_iframe=1">' . __( 'Add images to gallery', 'clifden_domain_adm' ) . '</a>',
										"options" => ( is_numeric( $postId ) ) ? ( wm_get_post_images( $postId, null, -1, true ) ) : ( null ),
										"field" => "checkbox",
										"default" => ""
									),
							array(
								"conditional" => array(
									"field" => $prefix."slider-type",
									"value" => "roundabout,nivo,flex"
									),
								"id" => $prefix."slider-settings-standard",
								"type" => "inside-wrapper-close"
							),

						array(
							"conditional" => array(
								"field" => $prefix."slider-type",
								"value" => "roundabout,nivo,flex,custom"
								),
							"id" => $prefix."slider-settings-content",
							"type" => "inside-wrapper-close"
						),

						array(
							"type" => "color",
							"id" => $prefix."slider-bg-color",
							"label" => __( 'Slider background color', 'clifden_domain_adm' ),
							"desc" => __( 'Sets the custom slider background color', 'clifden_domain_adm' ),
							"validate" => "color",
							"default" => ""
						),
						array(
							"type" => "checkbox",
							"id" => $prefix."slider-top",
							"label" => __( 'Slider beneath header', 'clifden_domain_adm' ),
							"desc" => __( 'You can move slider beneath the website header just by selecting the option below', 'clifden_domain_adm' ),
						),

				array(
					"conditional" => array(
						"field" => $prefix."slider-type",
						"value" => "roundabout,nivo,static,video,flex,custom"
						),
					"id" => $prefix."slider-settings",
					"type" => "inside-wrapper-close"
				),
			array(
				"type" => "section-close"
			),



			//Gallery settings
			array(
				"type" => "section-open",
				"section-id" => "gallery-section",
				"title" => __( 'Gallery', 'clifden_domain_adm' ),
				"exclude" => array( 'blog-page', 'home.php', 'tpl-map.php', 'tpl-portfolio.php', 'tpl-sitemap.php', 'tpl-landing.php', 'tpl-construction.php', 'tpl-redirect.php', 'tpl-sections.php' )
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
				"title" => __( 'Sidebar', 'clifden_domain_adm' ),
				"exclude" => array( 'tpl-sitemap.php', 'tpl-construction.php', 'tpl-redirect.php', 'tpl-sections.php' )
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
			),



			//Design - website background settings
			array(
				"type" => "section-open",
				"section-id" => "background-settings",
				"title" => __( 'Background', 'clifden_domain_adm' ),
				"exclude" => array( 'tpl-redirect.php' )
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

		return $metaPageOptions;
	}
} // /wm_meta_page_options

?>