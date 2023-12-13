<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Basic theme setup
*
* CONTENT:
* - 1) Actions and filters
* - 2) Globals
* - 3) Security
* - 4) Theme features
* - 5) Localization
* - 6) Assets and design
* - 7) Others
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Adding assets into HTML head
		add_action( 'wp_enqueue_scripts', 'wm_site_assets' );
		//Next/prev post
		add_action( 'wm_before_bottom_meta', 'wm_prevnext_post', 20 );
		//Jepack integration
		add_action( 'wm_before_post', 'wm_jetpack_sharing_remove' );
		add_action( 'wm_before_post', 'wm_jetpack_sharing_remove' );
		add_action( 'wm_before_bottom_meta', 'wm_jetpack_sharing_add', 10 );

	//FILTERS
		//WordPress header additions
		add_filter( 'wp_head', 'wm_head_styles', 9998 );
		//BODY classes
		add_filter( 'body_class', 'wm_body_classes' );
		//Shortcodes excerpts processing
		add_filter( 'wmhook_shortcode_posts_excerpt_text',    'wm_shortcode_excerpt',       10, 2 );
		add_filter( 'wmhook_shortcode_projects_excerpt_text', 'wm_shortcode_excerpt',       10, 2 );
		add_filter( 'wmhook_shortcode_staff_excerpt_text',    'wm_default_content_filters', 10    );





/*
*****************************************************
*      2) GLOBALS
*****************************************************
*/
	//Max content width
	if ( ! isset( $content_width ) )
		$content_width = ( 'r1160' === wm_option( 'layout-width' ) || 's1160' === wm_option( 'layout-width' ) ) ? ( 1160 ) : ( 930 );





/*
*****************************************************
*      3) SECURITY
*****************************************************
*/
	//Generic login error messages
	if ( ! function_exists( 'wm_login_generic_message' ) ) {
		function wm_login_generic_message() {
			return __( 'It seems something went wrong...', 'clifden_domain_adm' );
		}
	} // /wm_login_generic_message

	//Hide login errors
	if ( wm_option( 'security-login-error' ) )
		add_filter( 'login_errors', 'wm_login_generic_message' );

	//Remove WP version from HTML header
	if ( wm_option( 'security-wp-version' ) )
		remove_action( 'wp_head', 'wp_generator' );

	//Rremove Windows Live Writer support
	if ( wm_option( 'security-live-writer' ) )
		remove_action( 'wp_head', 'wlwmanifest_link' );





/*
*****************************************************
*      4) THEME FEATURES
*****************************************************
*/
	//Post formats
		$postFormats = array();
		if ( ! wm_option( 'blog-no-format-audio' ) )
			$postFormats[] = 'audio';
		if ( ! wm_option( 'blog-no-format-gallery' ) )
			$postFormats[] = 'gallery';
		if ( ! wm_option( 'blog-no-format-link' ) )
			$postFormats[] = 'link';
		if ( ! wm_option( 'blog-no-format-quote' ) )
			$postFormats[] = 'quote';
		if ( ! wm_option( 'blog-no-format-status' ) )
			$postFormats[] = 'status';
		if ( ! wm_option( 'blog-no-format-video' ) )
			$postFormats[] = 'video';
		if ( ! empty( $postFormats ) )
			add_theme_support( 'post-formats', $postFormats );

		if ( wm_check_wp_version( '3.6' ) ) {
			add_theme_support( 'structured-post-formats', array( 'audio', 'gallery', 'link', 'quote', 'status', 'video' ) );
		}



	//Feed links
		if ( ! wm_option( 'social-no-auto-feed-link' ) )
			add_theme_support( 'automatic-feed-links' );



	//HTML5
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );



	//Custom menus
		add_theme_support( 'menus' );
		//menus array
		$registeredMenusArray = array(
				'main-navigation'   => __( 'Main navigation', 'clifden_domain_adm' ),
				'footer-navigation' => __( 'Footer navigation', 'clifden_domain_adm' )
			);
			if ( ! wm_option( 'general-tpl-tpl-sitemap_php' ) )
				$registeredMenusArray['sitemap-links'] = __( 'Sitemap links', 'clifden_domain_adm' );

			//separate menu for each landing page
			$landingPages = get_pages( array(
					'meta_key'     => '_wp_page_template',
					'meta_value'   => 'tpl-landing.php',
					'hierarchical' => 0
				) );
			foreach ( $landingPages as $landingPage ) {
				$registeredMenusArray['menu-landing-page-' . $landingPage->ID] = '"' . $landingPage->post_title . '" ' . __( 'page navigation', 'clifden_domain_adm' );
			}
		//register menus
		register_nav_menus( $registeredMenusArray );



	//Thumbnails support
		add_theme_support( 'post-thumbnails' ); //thumbs just for posts in categories
		$addImageSizeArray = array(
				'content-width' => array(
						//landscape
						'ratio-11'  => array( $content_width, $content_width ),
						'ratio-43'  => array( $content_width, floor( 3 * $content_width / 4 ) ),
						'ratio-32'  => array( $content_width, floor( 2 * $content_width / 3 ) ),
						'ratio-169' => array( $content_width, floor( 9 * $content_width / 16 ) ),
						'ratio-21'  => array( $content_width, floor( $content_width / 2 ) ),
						'ratio-31'  => array( $content_width, floor( $content_width / 3 ) ),
						//portrait
						'ratio-34'  => array( $content_width, floor( 4 * $content_width / 3 ) ),
						'ratio-23'  => array( $content_width, floor( 3 * $content_width / 2 ) ),
						'ratio-916' => array( $content_width, floor( 16 * $content_width / 9 ) ),
						'ratio-12'  => array( $content_width, $content_width * 2 ),
					),
				'mobile' => array(
						//landscape
						'ratio-11'  => array( 700, 700 ),
						'ratio-43'  => array( 700, 525 ),
						'ratio-32'  => array( 700, 466 ),
						'ratio-169' => array( 700, 394 ),
						'ratio-21'  => array( 700, 350 ),
						'ratio-31'  => array( 700, 234 ),
						//portrait
						'ratio-34'  => array( 700, 934 ),
						'ratio-23'  => array( 700, 1050 ),
						'ratio-916' => array( 700, 1244 ),
						'ratio-12'  => array( 700, 1400 ),
					)
			);
		$createImagesArray = array(
				wm_option( 'general-projects-image-ratio' ),
				wm_option( 'general-post-image-ratio' ),
				wm_option( 'general-gallery-image-ratio' ),
				wm_option( 'general-staff-image-ratio' ),
			);
		if ( empty( $createImagesArray ) )
			$createImagesArray( 'ratio-169' );
		$createImagesArray = array_filter( $createImagesArray, 'strlen' );
		$createImagesArray = array_unique( $createImagesArray );

		//image sizes (x, y, crop)
			add_image_size( 'content-width', $content_width, 9999, false ); //website width, unlimited height
			add_image_size( 'mobile', 700, 9999, false ); //max mobile width, ulnimited height
			add_image_size( 'widget', 64, 64, true ); //small widget squere image, cropped
			foreach ( $createImagesArray as $ratio ) {
				add_image_size( $ratio, $addImageSizeArray['content-width'][$ratio][0], $addImageSizeArray['content-width'][$ratio][1], true );
				add_image_size( 'mobile-' . $ratio, $addImageSizeArray['mobile'][$ratio][0], $addImageSizeArray['mobile'][$ratio][1], true );
			}





/*
*****************************************************
*      5) LOCALIZATION
*****************************************************
*/
	/*
	* The theme splits translation into 4 sections:
	*  1) website front-end
	*  2) main WordPress admin extensions (like post metaboxes)
	*  3) theme's contextual help texts
	*  4) theme admin panel (accessed by administrators only)
	* You can find all theme translation .PO files (and place translated .MO files) in "clifden/langs/" folder and subsequent subfolders.
	*
	* Theme uses these textdomains:
	*  1) clifden_domain
	*  2) clifden_domain_adm
	*  3) clifden_domain_help
	*  4) clifden_domain_panel
	*/
	load_theme_textdomain( 'clifden_domain', WM_LANGUAGES );
	if( is_admin() )
		load_theme_textdomain( 'clifden_domain_adm', WM_LANGUAGES . '/admin' );
	if ( is_admin() && ! wm_option( 'general-no-help' ) )
		load_theme_textdomain( 'clifden_domain_help', WM_LANGUAGES . '/help' );
	if( is_admin() && current_user_can( 'switch_themes' ) )
		load_theme_textdomain( 'clifden_domain_panel', WM_LANGUAGES . '/wm-admin-panel' );





/*
*****************************************************
*      6) ASSETS AND DESIGN
*****************************************************
*/
	/*
	* Frontend HTML head assets
	*/
	if ( ! function_exists( 'wm_site_assets' ) ) {
		function wm_site_assets() {
			global $post;

			//styles
				if ( ! wm_option( 'general-no-lightbox' ) ) {
					wp_enqueue_style( 'prettyphoto' );
				}
				wp_enqueue_style( 'wm-global' );
				wp_enqueue_style( 'wm-print' );

			//scripts
				wp_enqueue_script( 'imagesloaded' );

				if ( ! wm_option( 'general-no-lightbox' ) ) {
					wp_enqueue_script( 'prettyphoto' );
				}

				if ( is_page_template( 'tpl-map.php' ) ) {
					wp_enqueue_script( 'gmapapi' );
					wp_enqueue_script( 'gmap' );
					// if ( wm_meta_option( 'map-info' ) ) {
						// wp_enqueue_script( 'gmap-infobox' );
					// }
				}

				wp_localize_script( 'wm-theme-scripts', 'wmLocalization', array(
						'mobileMenu' => __( 'Menu', 'clifden_domain' )
					) );
				wp_enqueue_script( 'wm-theme-scripts' );

				if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
					wp_enqueue_script( 'comment-reply', false, false, false, true ); //true to put it into footer
				}
		}
	} // /wm_site_assets



	/*
	* BODY classes
	*/
	if ( ! function_exists( 'wm_body_classes' ) ) {
		function wm_body_classes( $classes ) {
			global $post, $paged, $page;

			if ( ! isset( $paged ) )
				$paged = 0;
			if ( ! isset( $page ) )
				$page = 0;

			$paginated = false;
			if ( 1 < $paged || 1 < $page )
				$paginated = true;

			//variables needed
				//post ID
				$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				//theme skin used
				$skinUsed = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );
				//top panel display boolean variable
				$isTopBar = is_active_sidebar( 'top-bar-widgets' ) && ! ( ! is_archive() && ! is_search() && wm_meta_option( 'no-top-bar', $postId ) ) && ! is_page_template( 'tpl-landing.php' ) && ! is_page_template( 'tpl-construction.php' );

			//body classes
				$bodyClass    = array();
				$bodyClass[0] = ( 'boxed' === wm_option( 'layout-boxed' ) ) ? ( 'boxed' ) : ( 'fullwidth' );
				if (
						! is_search() && ! is_archive()
						&& wm_meta_option( 'boxed', $postId ) && 'default' != wm_meta_option( 'boxed', $postId )
					) {
					$bodyClass[0] = trim( wm_meta_option( 'boxed', $postId ) );
					$bodyClass[1] = 'page-settings-layout';
				}

				//website layout width class
					$bodyClass[2] = trim( wm_option( 'layout-width' ) );

				//top bar and breadcrumbs
					if ( $isTopBar )
						$bodyClass[3] = 'top-bar-enabled';
					if ( $isTopBar && wm_option( 'design-top-bar-fixed' ) )
						$bodyClass[4] = 'top-bar-fixed';
					if ( 'none' != wm_option( 'layout-breadcrumbs' ) && ! wm_meta_option( 'breadcrumbs', $postId ) )
						$bodyClass[5] = 'breadcrumbs-' . trim( wm_option( 'layout-breadcrumbs' ) );

				//theme skin body classes
					$bodyClass[6] = ( ! wm_skin_meta( $skinUsed, 'body-class' ) ) ? ( '' ) : ( wm_skin_meta( $skinUsed, 'body-class' ) );

				//fixed header?
					//slider / map beneath the header (affects also fixed header)
						if ( (
									( is_singular() || is_home() )
									&& isset( $post )
									&& (
										( 'none' != wm_meta_option( 'slider-type', $postId ) && wm_meta_option( 'slider-top', $postId ) )
										|| wm_meta_option( 'map-top', $postId )
									)
									&& ! $paginated
								)
							)
							$bodyClass[7] = 'absolute-header';

					//no fixed header
						if ( ! in_array( 'fixed-header', $bodyClass ) )
							$bodyClass[8] = 'no-fixed-header';

			//output
			$classes = array_merge( $classes, array_filter( $bodyClass ) );

			return $classes;
		}
	} // /wm_body_classes



	/*
	* WordPress head styles
	*/
	if ( ! function_exists( 'wm_head_styles' ) ) {
		function wm_head_styles() {
			global $post, $content_width;

			//variables needed
				//post ID
				$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				//theme skin used
				$skinUsed = ( ! wm_option( 'design-skin' ) ) ? ( 'default.css' ) : ( wm_option( 'design-skin' ) );

			//custom in-header styles
				$inHeaderStyles = '';

				//page background image
					if (
							( isset( $post ) || is_home() )
							&& ! is_search()
							&& ! is_archive()
							&& wm_css_background_meta( 'background-' )
						) {
						$applyOnBodyClass = ( 'default.css' !== $skinUsed ) ? ( '.boxed' ) : ( '' );
						$inHeaderStyles .= ( wm_meta_option( 'background-bg-img-fit-window', $postId ) ) ? ( "\t" . 'body' . $applyOnBodyClass . ' {background:none}' . "\r\n" ) : ( "\t" . 'body' . $applyOnBodyClass . ' {background:' . wm_css_background_meta( 'background-' ) . '}' . "\r\n" );
						$inHeaderStyles .= ( ! wm_meta_option( 'background-bg-color', $postId ) ) ? ( '' ) : ( "\t" . 'html {background: none}' . "\r\n" );
					}

				//roundabout slider settings
					if ( ( isset( $post ) || is_home() ) && 'roundabout' === wm_meta_option( 'slider-type', $postId ) ) {
						$sliderHeight = ( wm_meta_option( 'slider-roundabout-height', $postId ) ) ? ( ' height:' . absint( wm_meta_option( 'slider-roundabout-height', $postId ) ) . 'px !important;' ) : ( '' );
						$inHeaderStyles .= "\t" . '@media only screen and (min-width: 930px) { .roundabout-slider{width:' . ( $content_width + intval( wm_meta_option( 'slider-roundabout-width', $postId ) ) ) . 'px !important;' . $sliderHeight . ' margin-left: auto !important; margin-right: auto !important; float: none; margin-top:' . intval( 50 - wm_meta_option( 'slider-roundabout-bottom', $postId ) ) . 'px !important; margin-bottom:' . intval( wm_meta_option( 'slider-roundabout-bottom', $postId ) ) . 'px !important;} }' . "\r\n";
					}

				//wrapper padding when fixed header used
					if ( in_array( 'header-fixed', get_body_class() ) && 0 < wm_option( 'design-header-height' ) )
						$inHeaderStyles .= "\t" . '@media only screen and (min-width: 768px) { .wrap { padding-top: ' . absint( wm_option( 'design-header-height' ) ) . 'px; } }' . "\r\n";

			//output
			if ( $inHeaderStyles )
				$inHeaderStyles = "\r\n<!-- Custom header styles -->\r\n" . '<style type="text/css">' . "\r\n" . $inHeaderStyles . '</style>' . "\r\n";

			echo $inHeaderStyles;
		}
	} // /wm_head_styles





/*
*****************************************************
*      7) OTHERS
*****************************************************
*/

	/**
	 * Previous and next post/project links
	 */
	if ( ! function_exists( 'wm_prevnext_post' ) ) {
		function wm_prevnext_post() {
			//Requirements check
				if ( ! ( is_singular( 'post' ) || is_singular( 'wm_projects' ) ) ) {
					return;
				}

			//Helper variables
				$excluded_categories = $output = '';
				$in_same_cat         = true;
				$taxonomy            = ( 'wm_projects' == get_post_type() ) ? ( 'project-category' ) : ( 'category' );
				$taxonomy            = apply_filters( 'wmhook_wm_prevnext_post_taxonomy', $taxonomy );
				$posts               = array(
						get_previous_post( $in_same_cat, $excluded_categories, $taxonomy ),
						get_next_post( $in_same_cat, $excluded_categories, $taxonomy ),
					);

			//Preparing output
				if ( $posts[0] ) {
					$output .= '<a href="' . get_permalink( $posts[0]->ID ) . '" title="' . sprintf( __( 'Previous item: %s', 'clifden_domain' ), esc_attr( strip_tags( get_the_title( $posts[0]->ID ) ) ) ) . '" class="prev"><span class="screen-reader-text">' . trim( get_the_title( $posts[0]->ID ) ) . '</span></a>';
				}
				if ( $posts[1] ) {
					$output .= '<a href="' . get_permalink( $posts[1]->ID ) . '" title="' . sprintf( __( 'Next item: %s', 'clifden_domain' ), esc_attr( strip_tags( get_the_title( $posts[1]->ID ) ) ) ) . '" class="next"><span class="screen-reader-text">' . trim( get_the_title( $posts[1]->ID ) ) . '</span></a>';
				}
				if ( $output ) {
					$output = '<div id="next-prev-post-in-tax" class="clearfix meta-bottom next-prev-post-in-tax">' . $output . '</div>';
				}

			//Output
				echo apply_filters( 'wmhook_wm_prevnext_post_output', $output );
		}
	} // /wm_prevnext_post



	/**
	 * Jetpack sharing
	 */
	if ( ! function_exists( 'wm_jetpack_sharing_remove' ) ) {
		function wm_jetpack_sharing_remove() {
			remove_filter( 'the_content', 'sharing_display', 19 );
			remove_filter( 'the_excerpt', 'sharing_display', 19 );
		}
	} // /wm_jetpack_sharing_remove

	if ( ! function_exists( 'wm_jetpack_sharing_add' ) ) {
		function wm_jetpack_sharing_add() {
			if (
					( is_singular( 'post' ) || is_singular( 'wm_projects' ) )
					&& function_exists( 'sharing_display' )
				) {
				sharing_display( '', true );
			}
		}
	} // /wm_jetpack_sharing_add



	/**
	 * Projects and posts shortcode excerpt processing
	 *
	 * @param  string $excerpt
	 */
	if ( ! function_exists( 'wm_shortcode_excerpt' ) ) {
		function wm_shortcode_excerpt( $excerpt, $excerpt_length ) {
			return strip_tags( wm_remove_shortcodes( wp_trim_words( $excerpt, $excerpt_length, '&hellip;' ) ) );
		}
	} // /wm_shortcode_excerpt

?>