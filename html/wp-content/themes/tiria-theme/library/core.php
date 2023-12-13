<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* File prefixes used:
* a-            options array
* cp-           custom post
* ct-           custom taxonomies
* m-            meta box
* s-            slider content
* w-            widget
* no prefix     core function files
*
* Core functions
*
* CONTENT:
* - 1) Required files
* - 2) Actions and filters
* - 3) Register styles and scripts
* - 4) Variables
* - 5) Get/save theme/meta options
* - 6) Widget areas
* - 7) Breadcrumbs and pagination
* - 8) Password protected post
* - 9) Comments
* - 10) Sliders
* - 11) Header and footer functions
* - 12) SEO functions
* - 13) Post/page functions
* - 14) Other functions
*****************************************************
*/





/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	//Navigation enhancements
	require_once( WM_CLASSES . 'nav-walker.php' );

	//Theme hooks
	require_once( WM_HOOKS . 'hooks.php' );

	//Slider generator functions
	require_once( WM_SLIDERS . 's-flex.php' );
	require_once( WM_SLIDERS . 's-nivo.php' );
	require_once( WM_SLIDERS . 's-roundabout.php' );





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering theme styles and scripts
		add_action( 'init', 'wm_register_assets' );
		//Meta title
		add_filter( 'wp_title', 'wm_seo_title', 10, 2 );
		//Main content start
		add_action( 'wm_after_header', 'wm_slider', 10 );
		add_action( 'wm_after_header', 'wm_heading', 20 );
		add_action( 'wm_after_header', 'wm_page_excerpt', 30 );
		if ( 'top' === wm_option( 'layout-breadcrumbs' ) || 'both' === wm_option( 'layout-breadcrumbs' ) )
			add_action( 'wm_after_header', 'wm_display_breadcrumbs', 100 );
		if ( 'bottom' === wm_option( 'layout-breadcrumbs' ) || 'both' === wm_option( 'layout-breadcrumbs' ) || 'stick' === wm_option( 'layout-breadcrumbs' ) )
			add_action( 'wm_before_footer', 'wm_display_breadcrumbs', 100 );
		//Posts list
		add_action( 'wm_after_list', 'wm_pagination', 1 );
		//Post/page end
		add_action( 'wm_end_post', 'wm_post_parts', 10 );
		add_action( 'wm_after_post', 'wm_post_attachments', 1 );
		add_action( 'wm_after_post', 'wm_display_gallery', 5 );
		add_action( 'wm_after_post', 'wm_author_info', 10 );
		//Custom scripts
		add_action( 'wp_footer', 'wm_scripts_footer', 9998 ); //9998 for better compatibility with plugins
		//Feeds
		//add_filter( 'feed_link', 'wm_feedburner', 1, 2 );
		add_action( 'wp_head', 'wm_custom_feed', 10 );
		//Remove recent comments <style> from HTML head
		add_action( 'widgets_init', 'wm_remove_recent_comments_style' );
		//Blog page query modification
		add_action( 'pre_get_posts', 'wm_home_query', 1 );

	//FILTERS
		//Search form
		add_filter( 'get_search_form', 'wm_search_form' );
		//Password protected post
		add_filter( 'the_password_form', 'wm_password_form' );
		//Remove invalid HTML5 rel attribute
		add_filter( 'the_category', 'wm_remove_rel' );
		//Feed
		if ( wm_option( 'social-projects-in-feed' ) )
			add_filter( 'request', 'wm_feed_include_post_types' );
		add_filter( 'pre_get_posts', 'wm_feed_exclude_post_formats' );
		//Media uploader and media library
		add_filter( 'post_mime_types', 'wm_media_filters' );
		//add_filter( 'upload_mimes', 'wm_custom_mime_types' );
		add_filter( 'image_size_names_choose', 'wm_media_uploader_image_sizes' );
		add_filter( 'attachment_fields_to_edit', 'wm_attachment_meta_fields', 10, 2 );
		add_filter( 'attachment_fields_to_save', 'wm_attachment_meta_fields_save', 10, 2 );
		//HTML in widget title ([e][/e] and [s][/s])
		add_filter( 'widget_title', 'wm_html_widget_title' );
		//WordPress [gallery] shortcode improvements
		add_filter( 'post_gallery', 'wm_shortcode_gallery', 10, 2 );
		//WordPress image with caption shortcode improvements
		add_filter( 'img_caption_shortcode', 'wm_shortcode_image_caption', 10, 3 );
		//Default WordPress content filters only
		add_filter( 'wm_default_content_filters', 'wm_default_content_filters', 10 );
		//Search filter
		add_filter( 'pre_get_posts', 'wm_search_filter' );
		//Default content filters (from "wp-includes/default-filters.php"):
		add_filter( 'wmhook_content_default_filters', 'wptexturize'        );
		add_filter( 'wmhook_content_default_filters', 'convert_smilies'    );
		add_filter( 'wmhook_content_default_filters', 'convert_chars'      );
		add_filter( 'wmhook_content_default_filters', 'do_shortcode'       ); //Added by WebMan
		add_filter( 'wmhook_content_default_filters', 'wpautop'            );
		add_filter( 'wmhook_content_default_filters', 'shortcode_unautop'  );
		add_filter( 'wmhook_content_default_filters', 'prepend_attachment' );





/*
*****************************************************
*      3) REGISTER STYLES AND SCRIPTS
*****************************************************
*/
	/*
	* Registering theme styles and scripts
	*/
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {
			$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );

			//STYLES
				//frontend
				if ( file_exists( get_stylesheet_directory() . '/assets/css/style.css.php' ) ) {
					wp_register_style( 'wm-global', get_stylesheet_directory_uri() . '/assets/css/style.css.php', false, WM_SCRIPTS_VERSION, 'screen' );
				} else {
					wp_register_style( 'wm-global', WM_ASSETS_THEME . 'css/style.css.php', false, WM_SCRIPTS_VERSION, 'screen' );
				}
				if ( file_exists( get_stylesheet_directory() . '/assets/css/print.css' ) ) {
					wp_register_style( 'wm-print', get_stylesheet_directory_uri() . '/assets/css/print.css', false, WM_SCRIPTS_VERSION, 'print' );
				} else {
					wp_register_style( 'wm-print', WM_ASSETS_THEME . 'css/print.css', false, WM_SCRIPTS_VERSION, 'print' );
				}

				//for jquery plugins
				wp_register_style( 'prettyphoto', WM_ASSETS_THEME . 'css/prettyphoto/prettyphoto.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'fancybox', WM_ASSETS_ADMIN . 'js/fancybox/jquery.fancybox.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'color-picker', WM_ASSETS_ADMIN . 'css/colorpicker.css', false, WM_SCRIPTS_VERSION, 'screen' );

				//sliders
				wp_register_style( 'flex', WM_ASSETS_THEME . 'css/flex/flex.css', false, WM_SCRIPTS_VERSION, 'all' );
				wp_register_style( 'nivo', WM_ASSETS_THEME . 'css/nivo/nivo.css', false, WM_SCRIPTS_VERSION, 'all' );
				wp_register_style( 'roundabout', WM_ASSETS_THEME . 'css/roundabout/roundabout.css', false, WM_SCRIPTS_VERSION, 'all' );

				//other backend
				wp_register_style( 'wm-icons', WM_ASSETS_THEME . 'css/icons.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-options-panel-white-label', WM_ASSETS_ADMIN . 'css/wm-options/wm-options-panel.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-options-panel-branded', WM_ASSETS_ADMIN . 'css/wm-options/wm-options-panel-branded.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-admin-addons', WM_ASSETS_ADMIN . 'css/admin-addon.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-admin-addons-38', WM_ASSETS_ADMIN . 'css/admin-addon-38.css', false, WM_SCRIPTS_VERSION, 'screen' );
				wp_register_style( 'wm-buttons', WM_ASSETS_ADMIN . 'css/shortcodes/shortcodes.css', false, WM_SCRIPTS_VERSION, 'screen' );

			//SCRIPTS
				//backend
				wp_register_script( 'jquery-cookies', WM_ASSETS_ADMIN . 'js/jquery.cookies.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'easing', WM_ASSETS_THEME . 'js/jquery.easing/jquery.easing-1.3.pack.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'drag', WM_ASSETS_THEME . 'js/jquery.dragdrop/jquery.event.drag.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'drop', WM_ASSETS_THEME . 'js/jquery.dragdrop/jquery.event.drop.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'fancybox', WM_ASSETS_ADMIN . 'js/fancybox/jquery.fancybox.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'color-picker', WM_ASSETS_ADMIN . 'js/colorpicker.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true);

				//other backend
				wp_register_script( 'wm-wp-admin', WM_ASSETS_ADMIN . 'js/wm-scripts.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-options-panel', WM_ASSETS_ADMIN . 'js/wm-options-panel.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-options-panel-tabs', WM_ASSETS_ADMIN . 'js/wm-options-panel-tabs.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'wm-shortcodes', WM_ASSETS_ADMIN . 'js/shortcodes/wm-shortcodes.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );

				//sliders
				wp_register_script( 'flex', WM_ASSETS_THEME . 'js/flex/jquery.flexslider-min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'apply-flex', WM_ASSETS_THEME . 'js/flex/apply-flex.js.php', array( 'jquery', 'flex' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'nivo', WM_ASSETS_THEME . 'js/nivo/jquery.nivo.slider.pack.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'apply-nivo', WM_ASSETS_THEME . 'js/nivo/apply-nivo.js.php', array( 'jquery', 'nivo' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'roundabout', WM_ASSETS_THEME . 'js/roundabout/jquery.roundabout.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'roundabout-shapes', WM_ASSETS_THEME . 'js/roundabout/jquery.roundabout-shapes.min.js', array( 'jquery', 'roundabout' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'apply-roundabout', WM_ASSETS_THEME . 'js/roundabout/apply-roundabout.js.php', array( 'jquery', 'roundabout' ), WM_SCRIPTS_VERSION, true );

				//frontend
				wp_register_script( 'wm-theme-scripts', WM_ASSETS_THEME . 'js/scripts.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'imagesloaded', WM_ASSETS_THEME . 'js/imagesloaded/jquery.imagesloaded.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'prettyphoto', WM_ASSETS_THEME . 'js/prettyphoto/jquery.prettyPhoto.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'isotope', WM_ASSETS_THEME . 'js/isotope/jquery.isotope.min.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'lwtCountdown', WM_ASSETS_THEME . 'js/lwtCountdown/jquery.lwtCountdown-1.0.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'quovolver', WM_ASSETS_THEME . 'js/quovolver/jquery.quovolver.js', array( 'jquery' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'gmapapi', $protocol . '://maps.googleapis.com/maps/api/js?callback=initializeMap&libraries=marker&key=' . wm_option( 'general-map-api-key' ), false, '', true );
				wp_register_script( 'gmap-infobox', WM_ASSETS_THEME . 'js/infobox.js', array( 'gmapapi' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'gmap', WM_ASSETS_THEME . 'js/maps.js', array( 'gmapapi' ), WM_SCRIPTS_VERSION, true );
				wp_register_script( 'mgmap', WM_ASSETS_THEME . 'js/mgmaps.js', array( 'gmapapi' ), WM_SCRIPTS_VERSION, true );
		}
	} // /wm_register_assets





/*
*****************************************************
*      4) VARIABLES
*****************************************************
*/
	/*
	* Taxonomy list - returns array [slug => name]
	*
	* $args = ARRAY [see below for options]
	*/
	if ( ! function_exists( 'wm_tax_array' ) ) {
		function wm_tax_array( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'all'          => true, //whether to display "all" option
					'allCountPost' => 'post', //post type to count posts for "all" option, if left empty, the posts count will not be displayed
					'allText'      => __( 'All posts', 'clifden_domain_adm' ), //"all" option text
					'hierarchical' => '1', //whether taxonomy is hierarchical
					'orderBy'      => 'name', //in which order the taxonomy titles should appear
					'parentsOnly'  => false, //will return only parent (highest level) categories
					'return'       => 'slug', //what to return as a value (slug, or term_id?)
					'tax'          => 'category', //taxonomy name
				) );

			$outArray = array();
			$terms    = get_terms( $args['tax'], 'orderby=' . $args['orderBy'] . '&hide_empty=0&hierarchical=' . $args['hierarchical'] );

			if ( $args['all'] ) {
				if ( ! $args['allCountPost'] ) {
					$allCount = '';
				} else {
					$readable = ( in_array( $args['allCountPost'], array( 'post', 'page' ) ) ) ? ( 'readable' ) : ( null );
					$allCount = wp_count_posts( $args['allCountPost'], $readable );
					$allCount = ( isset( $allCount->publish ) ) ? ' (' . absint( $allCount->publish ) . ')' : '';
				}
				$outArray[''] = '- ' . $args['allText'] . $allCount . ' -';
			}

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( ! $args['parentsOnly'] ) {
						$outArray[$term->{$args['return']}] = $term->name;
						$outArray[$term->{$args['return']}] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					} elseif ( $args['parentsOnly'] && ! $term->parent ) { //get only parent categories, no children
						$outArray[$term->{$args['return']}] = $term->name;
						$outArray[$term->{$args['return']}] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					}
				}
			}

			return $outArray;
		}
	} // /wm_tax_array



	/*
	* Pages list - returns array [post_name (slug) => name]
	*
	* $return  = 'post_name' OR 'ID'
	*/
	if ( ! function_exists( 'wm_pages' ) ) {
		function wm_pages( $return = 'post_name' ) {
			$pages       = get_pages();
			$outArray    = array();
			$outArray[0] = __( '- Select page -', 'clifden_domain_adm' );

			foreach ( $pages as $page ) {
				$indents = $pagePath = '';
				$ancestors = get_post_ancestors( $page->ID );

				if ( ! empty( $ancestors ) ) {
					$indent = ( $page->post_parent ) ? ( '&ndash; ' ) : ( '' );
					$ancestors = array_reverse( $ancestors );
					foreach ( $ancestors as $ancestor ) {
						if ( 'post_name' == $return ) {
							$parent = get_page( $ancestor );
							$pagePath .= $parent->post_name . '/';
						}
						$indents .= $indent;
					}
				}

				$pagePath .= $page->post_name;
				$returnParam = ( 'post_name' == $return ) ? ( $pagePath ) : ( $page->ID );

				$outArray[$returnParam] = $indents . strip_tags( $page->post_title );
			}

			return $outArray;
		}
	} // /wm_pages



	/*
	* Get array of widget areas - returns array [id => name]
	*/
	if ( ! function_exists( 'wm_widget_areas' ) ) {
		function wm_widget_areas() {
			global $wp_registered_sidebars;

			$outArray     = array();
			$outArray[''] = __( '- Select area -', 'clifden_domain_adm' );

			foreach ( $wp_registered_sidebars as $area ) {
				$outArray[ $area['id'] ] = $area['name'];
			}

			asort( $outArray );

			return $outArray;
		}
	} // /wm_widget_areas



	/*
	* Get skins
	*/
	if ( ! function_exists( 'wm_skins' ) ) {
		function wm_skins() {
			//empty item
			$themeSkins = array();

			//get files
			$files = array();

			if ( $dir = @opendir( WM_SKINS ) ) {
				//this is the correct way to loop over the directory
				while ( false != ( $file = readdir( $dir ) ) ) {
					$files[] = $file;
				}
				closedir( $dir );
			}

			asort( $files );

			//create output array
			foreach ( $files as $file ) {
				if ( 5 < strlen( $file ) && 'css' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
					if(wm_skin_meta($file,'skin') && wm_skin_meta($file,'package')) { // Modified by Tiria
						//$themeSkins[$file] = wm_skin_meta( $file, 'skin' );
						$fileName      = str_replace( array( '.css', '.CSS' ), '', $file );
						$previewImage  = WM_ASSETS_THEME . 'css/skins/preview/' . $fileName . '.png';
						$item          = array();
						$item['name']  = wm_skin_meta( $file, 'skin' );
						if (WM_THEME_NAME != wm_skin_meta($file,'package')) $item['desc']='/!\ Skin for '.wm_skin_meta($file,'package').' theme /!\ - ';else $item['desc']=''; // Added by tiria
						$item['desc'] .= wm_skin_meta( $file, 'skin' ) . ' - ' . wm_skin_meta( $file, 'description' );
						$item['id']    = esc_attr( $fileName );
						$item['value'] = esc_attr( $file );
						$item['img']   = ( file_exists( WM_SKINS . '/preview/' . $fileName . '.png' ) ) ? ( $previewImage ) : ( WM_ASSETS_ADMIN . 'img/skin.png' );
						$themeSkins[]  = $item;
					}
				}
			}

			return $themeSkins;
		}
	} // /wm_skins



	/*
	* Get theme assets files
	*
	* $folder = TEXT [subfolder of theme assets folder - defaults to "img/patterns/"]
	* $format = TEXT [file format to look for - defaults to ".png"]
	*/
	if ( ! function_exists( 'wm_get_image_files' ) ) {
		function wm_get_image_files( $folder = 'img/patterns/', $format = '.png' ) {
			//empty item
			$filesArray = array(
				array(
					'name' => __( '- None -', 'clifden_domain_adm' ),
					'id'   => '',
					'img'  => ''
				)
			);

			//get files
			$files = array();

			if ( $dir = @opendir( get_template_directory() . '/assets/' . $folder ) ) {
				//this is the correct way to loop over the directory
				while ( false != ( $file = readdir( $dir ) ) ) {
					$files[] = $file;
				}
				closedir( $dir );
			}

			asort( $files );

			//create output array
			foreach ( $files as $file ) {
				if ( 5 < strlen( $file ) && 'png' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
					$fileName = str_replace( $format, '', $file );
					$itemName = str_replace( array( '-', '_' ), ' ', $fileName );

					$item         = array();
					$item['name'] = ucwords( $itemName );
					$item['id']   = esc_attr( $fileName );
					$item['img']  = esc_url( WM_ASSETS_THEME . $folder . $file );
					$filesArray[] = $item;
				}
			}

			return $filesArray;
		}
	} // /wm_get_image_files



	/*
	* Users list [user-nicename => display-name]
	*/
	if ( ! function_exists( 'wm_users' ) ) {
		function wm_users() {
			$outArray = array();

			$users = get_users( array(
				'orderby' => 'display_name',
				'fields'  => array( 'user_login', 'display_name' ) //get user login and display name only
			) );

			$outArray[''] = __( '&mdash; Select user or user group &mdash;', 'clifden_domain_adm' );

			$outArray['1OPTGROUP'] = __( 'User groups', 'clifden_domain_adm' );
				//group-CAPABILITY
				$outArray['group-read']          = __( 'Subscribers', 'clifden_domain_adm' );
				$outArray['group-edit_posts']    = __( 'Contributors', 'clifden_domain_adm' );
				$outArray['group-publish_posts'] = __( 'Authors', 'clifden_domain_adm' );
				$outArray['group-publish_pages'] = __( 'Editors', 'clifden_domain_adm' );
				$outArray['group-switch_themes'] = __( 'Administrators', 'clifden_domain_adm' );
			$outArray['1/OPTGROUP'] = '';

			$outArray['2OPTGROUP'] = __( 'Users', 'clifden_domain_adm' );
				$outArray['-1'] = __( '&mdash; All users (logged in)', 'clifden_domain_adm' );
			foreach ( $users as $user ) {
				$outArray[$user->user_login] = $user->display_name;
			}
			$outArray['2/OPTGROUP'] = '';

			return $outArray;
		}
	} // /wm_users





/*
*****************************************************
*      5) GET/SAVE THEME/META OPTIONS
*****************************************************
*/
	/*
	* Checks whether array value is "-1"
	*/
	if ( ! function_exists( 'wm_remove_negative_array' ) ) {
		function wm_remove_negative_array( $id ) {
			return ( -1 != intval( $id ) );
		}
	} // /wm_remove_negative_array

	/*
	* Checks whether array value is zero or negative
	*/
	if ( ! function_exists( 'wm_remove_zero_negative_array' ) ) {
		function wm_remove_zero_negative_array( $id ) {
			return ( 0 < intval( $id ) );
		}
	} // /wm_remove_zero_negative_array

	/*
	* Checks whether array value is empty array
	*/
	if ( ! function_exists( 'wm_remove_empty_array' ) ) {
		function wm_remove_empty_array( $array ) {
			$arrayEmptyValuesOut = array_filter( $array );
			return ! empty( $arrayEmptyValuesOut );
		}
	} // /wm_remove_empty_array



	/*
	* Get page ID by its slug
	*/
	if ( ! function_exists( 'wm_remove_recent_comments_style' ) ) {
		function wm_page_slug_to_id( $slug = null ) {
			$page = get_page_by_path( $slug );
			return ( $slug && $page ) ? ( $page->ID ) : ( null );
		}
	} // /wm_page_slug_to_id



	/*
	* Get or echo the option
	*
	* $name  = TEXT [option name]
	* $css   = TEXT ["css", "bgimg" - outputs CSS color or background image]
	* $print = TEXT ["print" the value]
	*/
	function wm_option( $name, $css = null, $print = null ) {
		if ( ! isset( $name ) )
			return;

		global $themeOptions;

		$options = ( $themeOptions ) ? ( $themeOptions ) : ( get_option( WM_THEME_SETTINGS ) );
		$name    = WM_THEME_SETTINGS_PREFIX . $name;

		if ( ! isset( $options[$name] ) || ! $options[$name] )
			return;

		$array = ( is_array( $options[$name] ) ) ? ( true ) : ( false );

		//CSS output helper
		$color = ( is_string( $css ) && 5 <= strlen( $css ) && 'color' == substr( $css, 0, 5 ) ) ? ( '#' . str_replace( '#', '', stripslashes( $options[$name] ) ) ) : ( '' );
			$colorSuffix = ( $color && 5 < strlen( $css ) ) ? ( str_replace( 'color', '', $css ) ) : ( '' ); // use for example like "color !important"
		$bg = ( is_string( $css ) && 5 <= strlen( $css ) && 'bgimg' == substr( $css, 0, 5 ) ) ? ( 'url(' . esc_url( stripslashes( $options[$name] ) ) . ')' ) : ( '' );
			$bgSuffix = ( $bg && 5 < strlen( $css ) ) ? ( str_replace( 'bgimg', '', $css ) ) : ( '' ); // use for example for css positioning, repeat, ...

		//setting the output
		if ( $bg )
			$output = $bg . $bgSuffix;
		elseif ( $color )
			$output = $color . $colorSuffix;
		else
			$output = ( $array ) ? ( $options[$name] ) : ( stripslashes( $options[$name] ) );

		//output method
		if ( 'print' == $print )
			echo $output;
		else
			return $output;
	} // /wm_option



	/*
	* Get the static option
	*
	* $name = TEXT [option name]
	*/
	if ( ! function_exists( 'wm_static_option' ) ) {
		function wm_static_option( $name ) {
			$options = get_option( WM_THEME_SETTINGS_STATIC );

			if ( isset( $options[$name] ) )
				return stripslashes( $options[$name] );
		}
	} // /wm_static_option



	/*
	* Get or echo post/page meta option
	*
	* $name   = TEXT [option name]
	* $postId = # [specific post ID, else uses the current post ID]
	* $css    = TEXT ["css", "bgimg" - outputs CSS color or background image]
	* $print  = TEXT ["print" the value]
	*/
	if ( ! function_exists( 'wm_meta_option' ) ) {
		function wm_meta_option( $name, $postId = null, $css = null, $print = null ) {
			global $post;
			$postIdObj = ( $post ) ? ( $post->ID ) : ( null );
			$postId    = ( $postId ) ? ( absint( $postId ) ) : ( $postIdObj );

			if ( ! isset( $name ) || ! $postId )
				return;

			$meta = get_post_meta( $postId, WM_THEME_SETTINGS_META, true ); //TRUE = retrieve only the first value of a given key;
			$name = WM_THEME_SETTINGS_PREFIX . $name;

			if ( ! isset( $meta[$name] ) || ! $meta[$name] )
				return;

			$array = ( is_array( $meta[$name] ) ) ? ( true ) : ( false );

			//CSS output helper
			$color = ( is_string( $css ) && 5 <= strlen( $css ) && 'color' == substr( $css, 0, 5 ) ) ? ( '#' . str_replace( '#', '', stripslashes( $meta[$name] ) ) ) : ( '' );
				$colorSuffix = ( $color && 5 < strlen( $css ) ) ? ( str_replace( 'color', '', $css ) ) : ( '' ); // use for example like "color !important"
			$bg = ( is_string( $css ) && 5 <= strlen( $css ) && 'bgimg' == substr( $css, 0, 5 ) ) ? ( 'url(' . esc_url( stripslashes( $meta[$name] ) ) . ')' ) : ( '' );
				$bgSuffix = ( $bg && 5 < strlen( $css ) ) ? ( str_replace( 'bgimg', '', $css ) ) : ( '' ); // use for example for css positioning, repeat, ...

			//setting the output
			if ( $bg )
				$output = $bg . $bgSuffix;
			elseif ( $color )
				$output = $color . $colorSuffix;
			else
				$output = ( $array ) ? ( $meta[$name] ) : ( stripslashes( $meta[$name] ) );

			//output method
			if ( 'print' == $print )
				echo $output;
			else
				return $output;
		}
	} // /wm_meta_option



	/*
	* Saves post/page meta (custom fields)
	*
	* $post_id = # [current post ID]
	* $options = ARRAY [options array to save]
	*/
	if ( ! function_exists( 'wm_save_meta' ) ) {
		function wm_save_meta( $post_id, $options ) {
			if ( ! isset( $options ) || ! is_array( $options ) || empty( $options ) || ! $post_id )
				return;

			$newMetaOptions = get_post_meta( $post_id, WM_THEME_SETTINGS_META, true );
			if ( ! $newMetaOptions || empty( $newMetaOptions ) )
				$newMetaOptions = array();

			foreach ( $options as $value ) {

				if ( isset( $value['id'] ) ) {
					$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

					if ( isset( $_POST[$valId] ) ) {

						if ( is_array( $_POST[$valId] ) && ! empty( $_POST[$valId] ) ) {
							$updVal = $_POST[$valId];
							if ( isset( $value['field'] ) && in_array( $value['field'], array( 'attributes', 'attributes-selectable' ) ) ) {
								$updVal = array_filter( $updVal, 'wm_remove_empty_array' );
							} else {
								$updVal = array_filter( $updVal, 'strlen' ); //removes null array items
								$updVal = array_filter( $updVal, 'wm_remove_negative_array' ); //removes '-1' array items
							}
						} else {
							$updVal = stripslashes( $_POST[$valId] );
						} //if value is array or not

						if ( isset( $value['validate'] ) ) {
							switch ( $value['validate'] ) {
								case 'lineBreakComma':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), ', ', $updVal );
								break;
								case 'lineBreakSpace':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), ' ', $updVal );
								break;
								case 'lineBreakHTML':
									$updVal = str_replace( array( "\r\n", "\r", "\n" ), '<br />', $updVal );
								break;
								case 'url':
									$updVal = esc_url( $updVal );
								break;
								case 'absint':
									$updVal = absint( $updVal );
								break;
								case 'int':
									$updVal = intval( $updVal );
								break;
								default:
								break;
							}
						} // if ['validate']

					} //if $_POST set

					if ( isset( $_POST[$valId] ) && $value['id'] )
						$newMetaOptions[$valId] = $updVal;
					else
						$newMetaOptions[$valId] = '';
				} //if value ID set

			} // /foreach options

			update_post_meta( $post_id, WM_THEME_SETTINGS_META, $newMetaOptions );
		}
	} // /wm_save_meta



	/*
	* Get skin meta
	*
	* $skinFile = TEXT [skin file name]
	* $meta     = TEXT [meta info title]
	*/
	if ( ! function_exists( 'wm_skin_meta' ) ) {
		function wm_skin_meta( $skinFile, $meta ) {
			if ( ! $skinFile || ! $meta || ! file_exists( WM_SKINS . $skinFile ) )
				return;

			global $skinAtts, $skinAttsStatic;

			$default_headers = $skinAttsStatic;
			$default_headers = array_merge( $default_headers, $skinAtts );

			$fileMeta = get_file_data( WM_SKINS . $skinFile, $default_headers );

			$out = '';

			if ( $fileMeta['skin'] && $fileMeta['package'] ) { // Modified by Tiria
				if ( is_array( $meta ) && ! empty( $meta ) ) {
					$metaArray = $fileMeta[ $meta[0] ];
					$metaArray = explode( ', ', $metaArray );
					$out = array();
					foreach ( $metaArray as $metaValue ) {
						$keyValue = explode( ' = ', $metaValue );
						$out[ $keyValue[0] ] = $keyValue[1];
					}
					$out = ( isset( $out[ $meta[1] ] ) ) ? ( $out[ $meta[1] ] ) : ( null );
				} else {
					//$out = ( isset( $fileMeta[$meta] ) ) ? ( $fileMeta[$meta] ) : ( null );
					$out = $fileMeta[$meta];
				}
			}

			return $out;
		}
	} // /wm_skin_meta





/*
*****************************************************
*      6) WIDGET AREAS
*****************************************************
*/
	/*
	* Display widget area (sidebar)
	*
	* $defaultSidebar = TEXT [widget area ID to fall back as default (if not set, the first widget area defined is used)]
	* $class          = TEXT [CSS class added on area container]
	* $restrictCount  = # [do not display the sidebar if the number of widgets contained is higher]
	* $print          = BOOLEAN [print or return the sidebar]
	* $hasInner       = TEXT [whether it contains inner content wrapper]
	*/
	if ( ! function_exists( 'wm_sidebar' ) ) {
		function wm_sidebar( $sidebar = WM_SIDEBAR_FALLBACK, $class = 'sidebar', $restrictCount = null, $print = true, $hasInner = null ) {
			global $post, $wp_registered_sidebars, $_wp_sidebars_widgets;

			//restriction = 0 means any number of widgets allowed
			$restrictCount = ( isset( $restrictCount ) && $restrictCount ) ? ( absint( $restrictCount ) ) : ( 0 );
			//set the sidebar to display - default sidebar
			$sidebar       = ( isset( $sidebar ) && $sidebar ) ? ( $sidebar ) : ( WM_SIDEBAR_FALLBACK );
			//fall back to default if the sidebar doesn't exist
			$sidebar       = ( ! in_array( $sidebar, array_keys( $wp_registered_sidebars ) ) ) ? ( WM_SIDEBAR_FALLBACK ) : ( $sidebar );
			//get all widgets in all widget areas into array
			$widgetsList   = wp_get_sidebars_widgets();

			/*
			//cut the widgets over the restricted amount
			if( count($widgetsList[$sidebar]) > $restrictCount ) {
				$slicedWidgets = array_slice( $widgetsList[$sidebar], 0, $restrictCount );
				$widgetsList[$sidebar] = $slicedWidgets;
				wp_set_sidebars_widgets($widgetsList);
			}
			*/

			//if there are some widgets in $sidebar AND no restrictions applied or the number of the widgets in $sidebar is not greater then restriction
			$out = '';

			if ( is_active_sidebar( $sidebar ) && ( 0 == $restrictCount || ( $restrictCount >= count( $widgetsList[$sidebar] ) ) ) ) {
				if ( $hasInner )
					$out .= '<div class="' . $sidebar . '-wrap wrap-widgets"><div class="wrap-inner"><div class="twelve pane">' . "\r\n";

				$out .= '<section data-id="' . $sidebar . '" class="widgets count-' . sizeof( $widgetsList[$sidebar] ) . ' ' . $class . '">' . "\r\n";

				$out .= wm_start_sidebar(); //hook

				if ( function_exists( 'ob_start' ) && function_exists( 'ob_get_clean' ) ) {
					ob_start();
					dynamic_sidebar( $sidebar );
					$out .= ob_get_clean(); //output and clean the buffer
				}

				$out .= wm_end_sidebar(); //hook

				$sidebarSeparator = ( in_array( 'sidebar-left', explode( ' ', $class) ) ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/shadows/shadow-left.png" class="sidebar-separator" alt="" />' ) : ( '<img src="' . WM_ASSETS_THEME . 'img/shadows/shadow-right.png" class="sidebar-separator" alt="" />' );
				$sidebarSeparator = ( in_array( 'sidebar', explode( ' ', $class) ) ) ? ( $sidebarSeparator ) : ( '' );

				$out .= $sidebarSeparator . '<!-- /' . $sidebar . ' /widgets --></section>' . "\r\n";

				if ( $hasInner )
					$out .= '<!-- /wrap-widgets --></div></div></div>' . "\r\n";
			}

			//output
			if ( $print )
				echo $out;
			else
				return $out;
		}
	} // /wm_sidebar





/*
*****************************************************
*      7) BREADCRUMBS AND PAGINATION
*****************************************************
*/
	/*
	* Pagination
	*
	* $atts = ARRAY [array of settings:
			label_previous = TEXT ["Previous"]
			label_next     = TEXT ["Next"]
			before_output  = HTML [wrapper tag strat]
			after_output   = HTML [wrapper tag end]
		]
	*/
	if ( ! function_exists( 'wm_pagination' ) ) {
		function wm_pagination( $query = null, $atts = array() ) {
			$atts = wp_parse_args( $atts, array(
					'label_previous' => __( 'Prev', 'clifden_domain' ),
					'label_next'     => __( 'Next', 'clifden_domain' ),
					'before_output'  => '<div class="pagination">',
					'after_output'   => '</div> <!-- /pagination -->',
					'print'          => true
				) );
			$atts = apply_filters( 'wmhook_pagination_atts', $atts );

			//WP-PageNavi plugin support (http://wordpress.org/plugins/wp-pagenavi/)
			if ( function_exists( 'wp_pagenavi' ) ) {
				//Set up WP-PageNavi attributes
					$atts_pagenavi = array(
							'echo' => false,
						);
					if ( $query ) {
						$atts_pagenavi['query'] = $query;
					}
					$atts_pagenavi = apply_filters( 'wmhook_wppagenavi_atts', $atts_pagenavi );

				//Output
					if ( $atts['print'] ) {
						echo $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
						return;
					} else {
						return $atts['before_output'] . wp_pagenavi( $atts_pagenavi ) . $atts['after_output'];
					}
			}

			global $wp_query, $wp_rewrite;

			//Override global WordPress query if custom used
				if ( $query ) {
					$wp_query = $query;
				}

			//WordPress pagination settings
				$pagination = array(
						'prev_text' => $atts['label_previous'],
						'next_text' => $atts['label_next'],
					);

			//Output
				if ( 1 < $wp_query->max_num_pages ) {
					if ( $atts['print'] ) {
						echo $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
					} else {
						return $atts['before_output'] . paginate_links( $pagination ) . $atts['after_output'];
					}
				}
		}
	} // /wm_pagination



	/*
	* Breadcrumbs
	*
	* $args = ARRAY [array of settings:
			separator        = TEXT [">"]
			before_output    = HTML [wrapper tag strat]
			after_output     = HTML [wrapper tag end]
			curently_reading = TEXT
			back_to          = TEXT
		]
	*/
	if ( ! function_exists( 'wm_breadcrumbs' ) ) {
		function wm_breadcrumbs( $args = array() ) {
			global $post, $wp_query;

			$defaults = array(
				'separator'        => '&raquo;',
				'before_output'    => '<div class="breadcrumbs' . wm_option( 'layout-breadcrumbs-animate-search' ) . wm_option( 'design-breadcrumbs-icons' ) . '"><div class="wrap-inner"><div class="twelve pane">',
				'after_output'     => '</div></div></div>',
				'curently_reading' => __( 'Currently viewing %s', 'clifden_domain' ),
				'back_to'          => __( 'Back to homepage', 'clifden_domain' )
				);
			$args      = wp_parse_args( $args, $defaults );
			$out       = '';

			$cats      = ( $post ) ? ( get_the_category() ) : ( array() );

			$parents   = ( isset( $post->ancestors ) ) ? ( $post->ancestors ) : ( null ); //get all parent pages in array
			$parents   = ( ! empty( $parents ) ) ? ( array_reverse( $parents ) ) : ( '' );  //flip the array

			$separator = ' <span class="separator">' . $args['separator'] . '</span> ';

			$topLink   = ( 'bottom' === wm_option( 'layout-breadcrumbs' ) || 'both' === wm_option( 'layout-breadcrumbs' ) || 'stick' === wm_option( 'layout-breadcrumbs' ) ) ? ( '<a href="#top" class="top-of-page" title="' . __( 'Back to top of page', 'clifden_domain' ) . '">' . __( 'Back to top', 'clifden_domain' ) . '</a>' ) : ( null );

			//Do not display breadcrumbs on homepage or main blog page
			if ( ! is_home() && ! is_front_page() ) {
			//no front page, nor home (posts list) page

				$out = $args['before_output'] . '<a href="' . home_url() . '" class="home-item" title="' . $args['back_to'] . '">' . __( 'Home', 'clifden_domain' ) . '</a>' . $separator;

				if ( is_category() ) {
				//output single cat name and its parents

					$catId    = intval( get_query_var('cat') );
					$parent   = get_category( $catId );
					$catsOut  = '';
					$blogPage = ( get_option( 'page_for_posts' ) ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					if ( is_wp_error( $parent ) )
						return $parent;
					if ( $parent->parent && ( $parent->parent != $parent->term_id ) )
						$catsOut .= get_category_parents( $parent->parent, true, $separator );

					$out .= $blogPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( single_cat_title( '', FALSE ) ) ) ) . '">' . single_cat_title( '', FALSE ) . '</span>';;

				} elseif ( is_date() ) {
				//date archives

					$year      = get_the_time('Y');
					$month     = get_the_time('m');
					$monthname = get_the_time('F');
					$day       = get_the_time('d');
					$dayname   = get_the_time('l');

					if ( is_year() )
						$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'year %d archive', 'clifden_domain' ), absint( $year ) ) ) . '">' . sprintf( __( 'Year %d archive', 'clifden_domain' ), absint( $year ) ) . '</span>';
					if ( is_month() )
						$out .= '<a href="' . get_year_link( $year ) . '">' . $year . '</a>' . $separator . '<span class="current-item">' . sprintf( __( '%s archive', 'clifden_domain' ), $monthname ) . '</span>';
					if ( is_day() )
						$out .= '<a href="' . get_year_link( $year ) . '">' . $year . '</a>' . $separator . '<a href="' . get_month_link( $year, $month ) . '">' . $monthname . '</a>' . $separator . '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'day %1$d, %2$s archive', 'clifden_domain' ), $day, $dayname ) ) . '">' . sprintf( __( 'Day %1$d, %2$s archive', 'clifden_domain' ), $day, $dayname ) . '</span>';

				} elseif ( is_author() ) {
				//author archives

					$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( 'posts by %s', 'clifden_domain' ), $curauth->display_name ) ) . '">' . sprintf( __( 'Posts by <em>%s</em>', 'clifden_domain' ), $curauth->display_name ) . '</span>';

				} elseif ( is_tag() ) {
				//tag archives

					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], sprintf( __( '%s tag archive', 'clifden_domain' ), single_tag_title( '', false ) ) ) . '">' . sprintf( __( '<em>%s</em> tag archive', 'clifden_domain' ), single_tag_title( '', false ) ) . '</span>';

				} elseif ( is_search() ) {
				//search results

					$out .= '<span class="current-item">' . sprintf( __( 'Search results for <em>"%s"</em>', 'clifden_domain' ), get_search_query() ) . '</span>';

				} elseif ( is_single() && ! empty( $cats ) ) {
				//single post with hierarchical categories

					$cat      = ( isset( $cats[0] ) ) ? ( $cats[0] ) : ( null );
					$catsOut  = '';
					$blogPage = ( get_option( 'page_for_posts' ) ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					if ( is_object( $cat ) ) {
						if ( 0 != $cat->parent ) {
							$catsOut = get_category_parents( $cat->term_id, true, $separator );
						} else {
							$catsOut = '<a href="' . get_category_link( $cat->term_id ) . '">' . $cat->name . '</a>' . $separator;
						}
					}

					$out .= $blogPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_single() && 'wm_projects' == $post->post_type ) {
				//single portfolio

					$terms = get_the_terms( $post->ID , 'project-category' );
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach( $terms as $term ) {
							$cats[] = $term;
						}
					}

					$catsOut = $portfolioPage = '';
					$cat     = ( isset( $cats[0] ) ) ? ( $cats[0] ) : ( null );

					$portfolioPage   = wm_option( 'layout-breadcrumbs-portfolio-page' );
					$portfolioPageID = wm_page_slug_to_id( $portfolioPage );
					$catURL          = ( $portfolioPage ) ? ( get_permalink( $portfolioPageID ) ) : ( home_url() );

					if ( is_object( $cat ) )
						$catsOut = '<a href="' . $catURL . '">' . $cat->name . '</a>' . $separator;

					if ( $portfolioPageID )
						$portfolioPage = '<a href="' . get_permalink( $portfolioPageID ) . '">' . get_the_title( $portfolioPageID ) . '</a>' . $separator;

					$out .= $portfolioPage . $catsOut . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_single() ) {
				//single post

					$blogPage = ( get_option( 'page_for_posts' ) && 'post' == $post->post_type ) ? ( '<a href="' . get_permalink( get_option( 'page_for_posts' ) ) . '">' . get_the_title( get_option( 'page_for_posts' ) ) . '</a>' . $separator ) : ( null );

					$out .= $blogPage . '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} elseif ( is_404() ) {
				//error 404 page

					$out .= '<span class="current-item">' . __( 'Page not found', 'clifden_domain' ) . '</span>';

				} elseif ( is_page() ) {
				//page with hierarchical parent pages

					if ( $parents ) {
						foreach ( $parents as $parent ) {
							$out .= '<a href="' . get_permalink( $parent ) . '">' . get_the_title( $parent ) . '</a>' . $separator; // print all page parents
						}
					}
					$out .= '<span class="current-item" title="' . sprintf( $args['curently_reading'], esc_attr( strip_tags( get_the_title() ) ) ) . '">' . get_the_title() . '</span>';

				} else {
				//default

					$out .= '<span class="current-item">' . __( 'Archive', 'clifden_domain' ) . '</span>';

				}

				//output
				echo $out . $topLink;
				if ( ! wm_option( 'layout-breadcrumbs-no-search' ) )
					the_widget( 'WP_Widget_Search' );
				echo $args['after_output'];

			} elseif ( is_home() ) {
			//home (posts list) page

				//$title = ( wm_option( 'pages-default-archives-title' ) ) ? ( wm_option( 'pages-default-archives-title' ) ) : ( __( 'Archives', 'clifden_domain' ) );
				$title = get_the_title( get_option( 'page_for_posts' ) );

				if ( get_option( 'page_for_posts' ) ) {
					echo $args['before_output'];
					echo '<a href="' . home_url() . '" class="home-item">' . __( 'Home', 'clifden_domain' ) . '</a>' . $separator . '<span class="current-item">' . $title . '</span>' . $topLink;
					if ( ! wm_option( 'layout-breadcrumbs-no-search' ) )
						the_widget( 'WP_Widget_Search' );
					echo $args['after_output'];
				}

			} elseif ( is_front_page() ) {
			//front (home) page

				$title = get_the_title( get_option( 'page_on_front' ) );

				if ( get_option( 'page_on_front' ) ) {
					echo $args['before_output'];
					echo '<a href="' . home_url() . '" class="home-item">' . __( 'Home', 'clifden_domain' ) . '</a>' . $topLink;
					if ( ! wm_option( 'layout-breadcrumbs-no-search' ) )
						the_widget( 'WP_Widget_Search' );
					echo $args['after_output'];
				}

			}
		}
	} // /wm_breadcrumbs

	/*
	* Display breadcrumbs
	*/
	if ( ! function_exists( 'wm_display_breadcrumbs' ) ) {
		function wm_display_breadcrumbs() {
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			if ( 'none' != wm_option( 'layout-breadcrumbs' ) && ! wm_meta_option( 'breadcrumbs', $postId ) ) {

				if (
						( ( is_archive() || is_home() ) && wm_option( 'layout-breadcrumbs-archives' ) ) ||
						( is_404() && wm_option( 'layout-breadcrumbs-404' ) ) ||
						( is_page_template( 'tpl-landing.php' ) ) ||
						( is_page_template( 'tpl-construction.php' ) )
					) {
					return;
				} else {
					wm_breadcrumbs();
				}

			}
		}
	} // /wm_display_breadcrumbs





/*
*****************************************************
*      8) PASSWORD PROTECTED POST
*****************************************************
*/
	/*
	* Password protected post form
	*/
	if ( ! function_exists( 'wm_password_form' ) ) {
		function wm_password_form() {
			global $post;
			$label     = 'pwbox-' . ( ( empty( $post->ID ) ) ? ( rand() ) : ( $post->ID ) );
			$checkPage = ( wm_check_wp_version( 3.4 ) ) ? ( 'wp-login.php?action=postpass' ) : ( 'wp-pass.php' );
			$out       = '';

			$out = do_shortcode( '[box color="red" icon="warning"]<form class="protected-post-form" action="' . get_option( 'siteurl' ) . '/' . $checkPage . '" method="post"><h4>' . apply_filters( 'wmhook_password_form_text', __( 'Enter password to view the content:', 'clifden_domain' ) ) . '</h4><p><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" id="submit" value="' . esc_attr__( 'Submit', 'clifden_domain' ) . '" /></p></form>[/box]' );

			return $out;
		}
	} // /wm_password_form





/*
*****************************************************
*      9) COMMENTS
*****************************************************
*/
	/*
	* Prints comment/trackback
	*
	* $comment, $args, $depth - check WordPress codex for info
	*/
	if ( ! function_exists( 'wm_comment' ) ) {
		function wm_comment( $comment, $args, $depth ) {
			$GLOBALS['comment'] = $comment;

			switch ( $comment->comment_type ) {
				case 'pingback' :
				case 'trackback' :

				?>
				<li class="pingback">
					<p>
						<strong><?php _e( 'Pingback:', 'clifden_domain' ); ?></strong>
						<?php comment_author_link(); ?>
						<?php
						if ( get_edit_comment_link() )
							echo ' | <a href="' . get_edit_comment_link() . '" class="edit-link">' . __( 'Edit', 'clifden_domain' ) . '</a>';
						?>

					</p>
				<?php

				break;
				default :

				?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<article>
						<div class="comment-heading">
							<strong class="author"><?php comment_author_link(); ?></strong>

							<?php
							if ( get_edit_comment_link() )
								echo '<a href="' . get_edit_comment_link() . '" class="comment-edit-link">' . __( 'Edit', 'clifden_domain' ) . '</a>';

							comment_reply_link( array_merge( $args, array(
								'reply_text' => apply_filters( 'wmhook_comment_reply_text', __( 'Reply', 'clifden_domain' ) ),
								'depth'      => $depth,
								'max_depth'  => $args['max_depth']
								) ) );
							?>

							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="published-on">
								<time datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php printf( __( '%1$s at %2$s', 'clifden_domain' ), esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?></time>
							</a>
						</div> <!-- /comment-heading -->

						<div class="comment-content">
							<div class="gravatar"><?php
								$avatar_size = 50;
								echo get_avatar( $comment, $avatar_size );
							?></div> <!-- /gravatar -->

							<div class="comment-text border-color">
								<?php
								if ( '0' == $comment->comment_approved )
									echo '<p class="awaiting"><em>' . __( 'Your comment is awaiting moderation.', 'clifden_domain' ) . '</em></p>';

								comment_text();
								?>
							</div> <!-- /comment-text -->
						</div> <!-- /comment-content -->
					</article>
				<?php

				break;
			} // /switch
		}
	} // /wm_comment



	/*
	* List pingbacks and trackback
	*
	* $tag = TEXT ["h2" heading wrapper tag]
	*/
	if ( ! function_exists( 'wm_pings' ) ) {
		function wm_pings( $tag = 'h2' ) {
			$haveTrackbacks = array();
			$haveTrackbacks = get_comments( array( 'type' => 'pings' ) );

			if ( ! empty( $haveTrackbacks ) ) {
				echo '<' . $tag . '>' . __( 'Pingbacks list', 'clifden_domain' ) . '</' . $tag . '>';
				?>
				<ol class="commentlist pingbacks">
					<?php
					wp_list_comments( array(
						'type'     => 'pings',
						'callback' => 'wm_comment'
						) );
					?>
				</ol>
				<?php
			}
		}
	} // /wm_pings





/*
*****************************************************
*      10) SLIDERS
*****************************************************
*/
	/*
	* Slider type switch
	*/
	if ( ! function_exists( 'wm_slider' ) ) {
		function wm_slider() {
			global $paged, $page;

			if ( ( ! is_singular() && ! is_home() ) || 1 < $paged || 1 < $page )
				//do nothing if no post, page or blog displayed, or if paginated
				return;

			if ( is_page() && wm_option( 'general-client-area' ) && ! wm_restriction_page() )
				//also do nothing if on page that current user can not display
				return;

			$out = $class = $height = '';
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//Slider type
				$sliderType = ( wm_meta_option( 'slider-type', $postId ) ) ? ( wm_meta_option( 'slider-type', $postId ) ) : ( 'none' );

				//for map page
				if ( is_page_template( 'tpl-map.php' ) )
					$sliderType = 'map';

				//for project posts
				$project = ( 'wm_projects' == get_post_type() && 'plain' === wm_meta_option( 'project-single-layout' ) ) ? ( true ) : ( false );
				if ( $project && wm_meta_option( 'project-type' ) )
					$sliderType = wm_meta_option( 'project-type' );

				//for gallery in slider
				if ( 'slider' === wm_meta_option( 'gallery' ) )
					$sliderType = 'gallery';

				//Do not continue, if no slider type selected
				if ( 'none' == $sliderType )
					return;

			//number of slides
			$slidesCount = ( wm_meta_option( 'slider-count', $postId ) ) ? ( wm_meta_option( 'slider-count', $postId ) ) : ( 10 );

			//slider image size
			$imageSize = 'full';

			//custom posts, post gallery or blog posts to populate slides
			$slidesContent = ( wm_meta_option( 'slider-content', $postId ) ) ? ( wm_meta_option( 'slider-content', $postId ) ) : ( 'wm_slides' );

			//set category only if custom posts or blog posts populate the slider
			$slidesCat = null;
			if ( 'wm_slides' == wm_meta_option( 'slider-content', $postId ) ) {
				$slidesCatSlug = wm_meta_option( 'slider-slides-cat', $postId );
				$slidesCat = get_term_by( 'slug', sanitize_title( $slidesCatSlug ), 'slide-category' );
				$slidesCat = ( $slidesCat && isset( $slidesCat->term_id ) ) ? ( $slidesCat->term_id ) : ( null );
			}

			//slider wrapper background color
			if ( 'gallery' !== $sliderType )
				$styles = ( wm_meta_option( 'slider-bg-color', $postId ) ) ? ( ' style="background-color: ' . wm_meta_option( 'slider-bg-color', $postId, 'color' ) . ';"' ) : ( null );
			else
				$styles = ( wm_meta_option( 'gallery-bg-color', $postId ) ) ? ( ' style="background-color: ' . wm_meta_option( 'gallery-bg-color', $postId, 'color' ) . ';"' ) : ( null );

			//choose slider type
			switch ( $sliderType ) {
				case 'flex':

					$out .= wm_slider_flex( $slidesCount, $slidesContent, $slidesCat, $imageSize, wm_meta_option( 'slider-width', $postId ) );

					$class = '';

				break;
				case 'nivo':

					$out .= wm_slider_nivo( $slidesCount, $slidesContent, $slidesCat, $imageSize, wm_meta_option( 'slider-width', $postId ) );

					$class = '';

				break;
				case 'roundabout':

					if ( 'slide' === $imageSize )
						$imageSize = 'portfolio';

					$out  .= wm_slider_roundabout( $slidesCount, $slidesContent, $slidesCat, $imageSize, wm_meta_option( 'slider-width', $postId ) );

					$class = '';

				break;
				case 'video':

					if ( ! wm_meta_option( 'slider-video-url', $postId ) )
						return;

					$videoURL = esc_url( wm_meta_option( 'slider-video-url', $postId ) );

					$coverImage    = '';
					$hasCoverImage = ' no-cover';

					if ( has_post_thumbnail( $postId ) && get_post( get_post_thumbnail_id( $postId ) ) ) {
						//Post featured image used as video cover image
						$attachment    = get_post( get_post_thumbnail_id( $postId ) );
						$coverImage    = get_the_post_thumbnail( $postId, $imageSize, array( 'class' => 'video-cover', 'title' => esc_attr( $attachment->post_title ) ) );
						$coverImage    = preg_replace( '/(width|height)=\"\d*\"\s/', '', $coverImage );
						$hasCoverImage = ' has-cover';
					}

					$out .= '<div class="wrap-inner">' . $coverImage . '<div id="video-slider" class="video-slider slider-content' . $hasCoverImage . ' twelve pane">';
					$out .= do_shortcode( apply_filters( 'wmhook_wm_slider_video_shortcode', '[video url="' . $videoURL . '" /]' ) );
					$out .= '</div></div> <!-- /video-slider -->';

					$class = ' video';

				break;
				case 'static':

					if ( has_post_thumbnail( $postId ) && get_post( get_post_thumbnail_id( $postId ) ) ) {

						//Post featured image
						$attachment = get_post( get_post_thumbnail_id( $postId ) );
						$link       = get_post_meta( $attachment->ID, 'image-url', true );
						$image      = get_the_post_thumbnail( $postId, $imageSize, array( 'title' => esc_attr( $attachment->post_title ) ) );
						$image      = preg_replace( '/(width|height)=\"\d*\"\s/', '', $image );
						$width      = ( wm_meta_option( 'slider-static-stretch', $postId ) ) ? ( ' stretch-image' ) : ( null );

						$out .= '<div id="static-slider" class="static-slider slider-content img-content' . $width . '">';

						$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '">' ) : ( '' );
						$out .= $image;
						$out .= ( $link ) ? ( '</a>' ) : ( '' );

						$layout = ( get_post_meta( $attachment->ID, 'caption-alignment', true ) ) ? ( get_post_meta( $attachment->ID, 'caption-alignment', true ) . get_post_meta( $attachment->ID, 'caption-padding', true ) ) : ( ' column col-13 no-margin alignright' );
						if ( 0 < absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) && 100 > absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) )
							$bg = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . get_post_meta( $attachment->ID, 'caption-color', true ) . '/' . absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) . '.png)';
						else
							$bg = ( 100 == absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) ) ? ( get_post_meta( $attachment->ID, 'caption-color', true ) ) : ( 'transparent' );
						$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

						$iconsColorClass = ( 'black' == get_post_meta( $attachment->ID, 'caption-color', true ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

						$content = '';
						$content .= ( $attachment->post_excerpt ) ? ( '<h2>' . wptexturize( $attachment->post_excerpt ) . '</h2>' ) : ( '' );
						$content .= ( $attachment->post_content ) ? ( wptexturize( $attachment->post_content ) ) : ( '' );

						if ( $content ) {
							$out .= '<div class="wrap-caption">';
							$out .= '<div class="slider-caption-content">';
							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"></a>' ) : ( '' );
							$out .= '<div class="caption-inner bg-' . get_post_meta( $attachment->ID, 'caption-color', true ) . $iconsColorClass . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', $content );
							$out .= '</div></div></div>';
							$out .= '</div>';
						}

						$out .= '</div> <!-- /static-slider -->';

						$class = '';

					}

				break;
				case 'flex-project':

					$out .= wm_slider_flex( 20, 'gallery', null, $imageSize, 'fullwidth' );

					$class = '';

				break;
				case 'video-project':

					$videoURL = wm_meta_option( 'project-video' );

					if ( false === strpos( $videoURL, '[video ' ) ) {

						$coverImage    = '';
						$hasCoverImage = ' no-cover';

						if ( has_post_thumbnail( $postId ) && get_post( get_post_thumbnail_id( $postId ) ) ) {
							//Post featured image used as video cover image
							$attachment    = get_post( get_post_thumbnail_id( $postId ) );
							$coverImage    = get_the_post_thumbnail( $postId, $imageSize, array( 'class' => 'video-cover', 'title' => esc_attr( $attachment->post_title ) ) );
							$coverImage    = preg_replace( '/(width|height)=\"\d*\"\s/', "", $coverImage );
							$hasCoverImage = ' has-cover';
						}

						$out .= '<div class="wrap-inner">' . $coverImage . '<div id="video-slider" class="video-slider slider-content' . $hasCoverImage . ' twelve pane">[video url="' . esc_url( $videoURL ) . '" /]';

					} else {

						$out .= '<div class="wrap-inner"><div id="video-slider" class="video-slider slider-content no-cover twelve pane">' . $videoURL;

					}

					$out = do_shortcode( apply_filters( 'wmhook_wm_slider_video-project_shortcode', $out ) ) . '</div></div> <!-- /video-slider -->';

					$class = ' video';

				break;
				case 'audio-project':

					$audioURL = wm_meta_option( 'project-audio' );

					if ( false !== strpos( $audioURL, '[audio ' ) ) {

						$out .= $audioURL;

					} else if ( $audioURL ) {

						$album_art  = '';
						$previewImg = wm_meta_option( 'project-audio-preview' );
						if ( isset( $previewImg['url'] ) && isset( $previewImg['id'] ) ) {
							$imageSize = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 'content-width' ) : ( 'mobile' );
							$imageSrc  = wp_get_attachment_image_src( $previewImg['id'], $imageSize );
							$album_art = ( $imageSrc ) ? ( ' album_art="' . esc_url( $imageSrc[0] ) . '"' ) : ( '' );
						}

						$out .= '[audio src="' . esc_url( $audioURL ) . '"' . $album_art . ' /]';

					} else {

						$out .= '[box color="red" icon="warning"]' . __( 'Please set "Audio URL" option', 'clifden_domain' ) . '[/box]';

					}

					$out = '<div class="wrap-inner"><div id="audio-slider" class="audio-slider slider-content no-cover twelve pane"' . do_shortcode( apply_filters( 'wmhook_wm_slider_audio-project_shortcode', $out ) ) . '</div></div> <!-- /video-slider -->';

					$class = ' audio';

				break;
				case 'static-project':

					$imageArray = wm_meta_option( 'project-image' );

					if ( isset( $imageArray['url'] ) && isset( $imageArray['id'] ) ) {

						//Post featured image
						$attachment = get_post( $imageArray['id'] );
						if ( ! $attachment )
							return;

						$link       = get_post_meta( $imageArray['id'], 'image-url', true );
						$attachment = get_post( $imageArray['id'] );
						$imageAlt   = get_post_meta( $imageArray['id'], '_wp_attachment_image_alt', true );
						$imageTitle = '';
						if ( is_object( $attachment ) && ! empty( $attachment ) ) {
							$imageTitle  = $attachment->post_title;
							$imageTitle .= ( $attachment->post_excerpt ) ? ( ' - ' . $attachment->post_excerpt ) : ( '' );
						}
						$imageSrc   = wp_get_attachment_image_src( $imageArray['id'], $imageSize );
						$image      = '<img src="' . $imageSrc[0] . '" alt="' . esc_attr( $imageAlt ) . '" title="' . esc_attr( $imageTitle ) . '" />';
						$width      = ( wm_meta_option( 'slider-static-stretch' ) ) ? ( ' stretch-image' ) : ( null );

						$out .= '<div id="static-slider" class="static-slider slider-content img-content' . $width . '">';

						$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '">' ) : ( '' );
						$out .= $image;
						$out .= ( $link ) ? ( '</a>' ) : ( '' );

						$layout = ( get_post_meta( $attachment->ID, 'caption-alignment', true ) ) ? ( get_post_meta( $attachment->ID, 'caption-alignment', true ) . get_post_meta( $attachment->ID, 'caption-padding', true ) ) : ( ' column col-13 no-margin alignright' );
						if ( 0 < absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) && 100 > absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) )
							$bg = 'url(' . WM_ASSETS_THEME . 'img/transparent/' . get_post_meta( $attachment->ID, 'caption-color', true ) . '/' . absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) . '.png)';
						else
							$bg = ( 100 == absint( get_post_meta( $attachment->ID, 'caption-opacity', true ) ) ) ? ( get_post_meta( $attachment->ID, 'caption-color', true ) ) : ( 'transparent' );
						$style = ( $bg ) ? ( ' style="background:' . $bg . '"' ) : ( '' );

						$content = '';
						$content .= ( $attachment->post_excerpt ) ? ( '<h2>' . wptexturize( $attachment->post_excerpt ) . '</h2>' ) : ( '' );
						$content .= ( $attachment->post_content ) ? ( wptexturize( $attachment->post_content ) ) : ( '' );

						if ( $content ) {
							$out .= '<div class="wrap-caption">';
							$out .= '<div class="slider-caption-content">';
							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '"></a>' ) : ( '' );
							$out .= '<div class="caption-inner bg-' . get_post_meta( $attachment->ID, 'caption-color', true ) . $layout . '"' . $style . '><div class="caption-inner-centered">';
							$out .= apply_filters( 'wm_default_content_filters', $content );
							$out .= '</div></div></div>';
							$out .= '</div>';
						}

						$out .= '</div> <!-- /static-slider -->';

						$class = '';

					}

				break;
				case 'map': // Modified by Tiria

					$height   = ( wm_meta_option( 'map-height' ) ) ? ( ' style="height: ' . wm_meta_option( 'map-height' ) . 'px"' ) : ( ' style="height: 300px"' );
					$location = ( wm_meta_option( 'map-gps' ) ) ? ( preg_replace( '/\s+/', '', wm_meta_option( 'map-gps' ) ) ) : ( '0,0' );
					$location = explode( ',', $location );
					$lat      = $location[0];
					$long     = $location[1];

					if ( $location ) {
						$mapInvert = ( 'dark.css' === wm_option( 'design-skin' ) ) ? ( 'true' ) : ( 'false' );
						$out .= '<div id="map" class="map"' . $height . '></div>';
						$out .= '<script>var mapName="' . apply_filters( 'wmhook_map_custom_name', __( 'Custom', 'clifden_domain' ) ) . '", mapSat="' . wm_meta_option( 'map-saturation' ) . '", mapStyle="' . wm_meta_option( 'map-style' ) . '", mapZoom=' . intval( 2 + wm_meta_option( 'map-zoom' ) ) . ', mapLat=' . $lat . ', mapLong=' . $long . ', mapInfo="'. str_replace( '"', '\"', do_shortcode( wm_meta_option( 'map-info' ) ) ) . '", mapCenter=' . intval( wm_meta_option( 'map-center' ) ) . ', mapInvert=' . $mapInvert . ', themeImgs="' . WM_ASSETS_THEME . 'img/";</script>';
					} else {
						$out .= '<div class="wrap-inner"><div class="twelve pane"><br /><div class="box color-red text-center"><h3>' . __( 'Please, set the map location', 'clifden_domain' ) . '</h3></div></div></div>';
					}

				break;
				case 'gallery':

					$columns = wm_meta_option( 'gallery-columns' );
					$images  = wm_meta_option( 'gallery-images' );
					$images  = ( is_array( $images ) && ! empty( $images ) ) ? ( implode( ',', $images ) ) : ( '' );

					$galleryWidth = ( ! wm_meta_option( 'gallery-width' ) ) ? ( ' twelve pane' ) : ( '' );

					$out .= ( $galleryWidth ) ? ( '<div class="wrap-inner">' ) : ( '' );
					$out .= '<div id="gallery-slider" class="gallery-slider slider-content' . $galleryWidth . '">';
					$out .= do_shortcode( '[gallery columns="' . $columns . '" include="' . $images . '" link="special" sardine="1" /]' );
					$out .= '</div>';
					$out .= ( $galleryWidth ) ? ( '</div>' ) : ( '' );

				break;
				case 'custom':

					$customSliderWidth = ( ! wm_meta_option( 'slider-width', $postId ) ) ? ( ' twelve pane' ) : ( '' );

					$out .= ( $customSliderWidth ) ? ( '<div class="wrap-inner">' ) : ( '' );
					$out .= '<div class="custom-slider slider-content' . $customSliderWidth . '">';
					$out .= do_shortcode( wm_meta_option( 'slider-custom-shortcode', $postId ) );
					$out .= '</div>';
					$out .= ( $customSliderWidth ) ? ( '</div>' ) : ( '' );

					$class = '';

				break;
				case 'none':
				break;
				case 'default':
				default:
				break;
			} // /switch

			//slider background color class
			$setBgSlider = ( wm_css_background( 'design-slider-' ) ) ? ( 'set-bg' ) : ( null );

			if ( $out && ! is_page_template( 'tpl-map.php' ) ) {
				echo apply_filters( 'wmhook_wm_slider_output', '<section class="slider-main-wrap slider ' . $setBgSlider . $class . '"' . $styles . '>' . $out . '</section>' );
			} else if ( $out && is_page_template( 'tpl-map.php' ) ) {
				echo apply_filters( 'wmhook_wm_slider_output', '<section class="map-section">' . $out . '</section>' );
			}
		}
	} // /wm_slider





/*
*****************************************************
*      11) HEADER AND FOOTER FUNCTIONS
*****************************************************
*/
	/*
	* Prints logo
	*/
	if ( ! function_exists( 'wm_logo' ) ) {
		function wm_logo() {
			$separator   = ( wm_option( 'seo-meta-title-separator' ) ) ? ( ' ' . strip_tags( wm_option( 'seo-meta-title-separator' ) ) . ' ' ) : ( ' | ' );
			$description = ( get_bloginfo( 'description' ) ) ? ( get_bloginfo( 'name' ) . $separator . get_bloginfo( 'description' ) ) : ( get_bloginfo( 'name' ) );
			$logoType    = ( wm_option( 'branding-logo-type' ) ) ? ( wm_option( 'branding-logo-type' ) ) : ( 'img' );
			$skin        = ( wm_option( 'design-skin' ) ) ? ( '/' . str_replace( '.css', '', wm_option( 'design-skin' ) ) ) : ( '' );
			$logoURL     = ( wm_option( 'branding-logo-img-url' ) ) ? ( esc_url( wm_option( 'branding-logo-img-url' ) ) ) : ( WM_ASSETS_THEME . 'img/branding' . $skin . '/logo-' . WM_THEME_SHORTNAME . '.png' );

			//SEO logo HTML tag
			if ( is_front_page() )
				$logoTag = 'h1';
			else
				$logoTag = 'div';

			//output
			$out  = '<' . $logoTag . ' class="logo ' . $logoType . '-only">';
			$out .= '<a href="' . home_url() . '" title="' . esc_attr( $description ) . '">';
			if ( 'text' === $logoType )
				$out .= '<span class="text-logo">' . get_bloginfo( 'name' ) . '</span>';
			else
				$out .= '<img src="' . $logoURL . '" alt="' . esc_attr( apply_filters( 'wmhook_logo_image_alt', sprintf( __( '%s logo', 'clifden_domain' ), trim( get_bloginfo( 'name' ) ) ) ) ) . '" title="' . esc_attr( $description ) . '" />
					<span class="invisible">' . get_bloginfo( 'name' ) . '</span>';

			if ( get_bloginfo( 'description' ) )
				$out .= '<span class="description">' . get_bloginfo( 'description' ) . '</span>';
			$out .= '</a>';
			$out .= '</' . $logoTag . '>';

			echo $out;
		}
	} // /wm_logo



	/*
	* Prints favicon and touch icon
	*/
	if ( ! function_exists( 'wm_favicon' ) ) {
		function wm_favicon() {
			$out = '';

			if ( wm_option( 'branding-touch-icon-url-144' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . esc_url( wm_option( 'branding-touch-icon-url-144' ) ) . '" /> <!-- for retina iPad -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-114' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . esc_url( wm_option( 'branding-touch-icon-url-114' ) ) . '" /> <!-- for retina iPhone -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-72' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( wm_option( 'branding-touch-icon-url-72' ) ) . '" /> <!-- for legacy iPad -->' . "\r\n";
			if ( wm_option( 'branding-touch-icon-url-54' ) )
				$out .= '<link rel="apple-touch-icon-precomposed" href="' . esc_url( wm_option( 'branding-touch-icon-url-54' ) ) . '" /> <!-- for non-retina devices -->' . "\r\n";

			if ( wm_option( 'branding-favicon-url-png' ) )
				$out .= '<link rel="icon" type="image/png" href="' . esc_url( wm_option( 'branding-favicon-url-png' ) ) . '" /> <!-- standard favicon -->' . "\r\n";
			if ( wm_option( 'branding-favicon-url-ico' ) )
				$out .= '<link rel="shortcut icon" href="' . esc_url( wm_option( 'branding-favicon-url-ico' ) ) . '" /> <!-- IE favicon -->' . "\r\n";

			if ( $out )
				$out = "<!-- icons and favicon -->\r\n$out\r\n";

			echo $out;
		}
	} // /wm_favicon



	/*
	* Prints copyright text
	*/
	if ( ! function_exists( 'wm_credits' ) ) {
		function wm_credits( $class = null ) {
			$copyText = '';
			if ( is_page_template( 'tpl-landing.php' ) && wm_meta_option( 'landing-credits' ) )
				$copyText = wm_meta_option( 'landing-credits' );
			elseif ( is_page_template( 'tpl-construction.php' ) && wm_meta_option( 'construction-credits' ) )
				$copyText = wm_meta_option( 'construction-credits' );
			elseif ( wm_option( 'branding-credits' ) )
				$copyText = wm_option( 'branding-credits' );
			else
				$copyText = '&copy; ' . get_bloginfo( 'name' );

			$replaceArray = array(
				'(c)'  => '&copy;',
				'(C)'  => '&copy;',

				'(r)'  => '&reg;',
				'(R)'  => '&reg;',

				'(tm)' => '&trade;',
				'(TM)' => '&trade;',

				'YEAR' => date( 'Y' )
			);
			$copyText = strtr( $copyText, $replaceArray );
			?>
			<!-- CREDITS -->
			<div class="credits<?php if ( $class ) echo ' ' . $class; ?>">
				<?php	echo $copyText; ?>
			</div> <!-- /credits -->
			<?php
		}
	} // /wm_credits





/*
*****************************************************
*      12) SEO FUNCTIONS
*****************************************************
*/
	/*
	* SEO website title
	*/
	if ( ! function_exists( 'wm_seo_title' ) ) {
		function wm_seo_title( $title, $sep ) {
			global $page, $paged;

			$sep   = ( wm_option( 'seo-meta-title-separator' ) ) ? ( ' ' . strip_tags( wm_option( 'seo-meta-title-separator' ) ) . ' ' ) : ( ' | ' );
			if ( wm_option( 'seo-no-website-title' ) )
				$sep = '';
			$title = ( is_singular() && wm_meta_option( 'seo-title' ) ) ? ( wm_meta_option( 'seo-title' ) ) : ( $title );

			if ( is_feed() )
				return $title;

			if ( is_tag() ) {
			//tag archive

				$title = apply_filters( 'wmhook_meta_title_archive_tag', sprintf( __( 'Tag archive for "%s"', 'clifden_domain' ), single_tag_title( '', false ) ) ) . $sep;

			} elseif ( is_search() ) {
			//search

				$title = apply_filters( 'wmhook_meta_title_search', sprintf( __( 'Search for "%s"', 'clifden_domain' ), get_search_query() ) ) . $sep;

			} elseif ( is_archive() ) {
			//general archive

				$title = apply_filters( 'wmhook_meta_title_archive', sprintf( __( 'Archive for %s', 'clifden_domain' ), $title ) ) . $sep;

			} elseif ( is_singular() && ! is_404() && ! is_front_page() && ! is_home() ) {
			//is page or post but not 404, front page nor home page post list

				$title = $title . $sep;

			} elseif ( is_404() ) {
			//404 page

				$title = ( wm_option( 'p404-title' ) ) ? ( wm_option( 'p404-title' ) . $sep ) : ( apply_filters( 'wmhook_meta_title_404', __( 'Web page was not found', 'clifden_domain' ) ) . $sep );

			} elseif ( is_home() && get_option( 'page_for_posts' ) ) {
			//post page (if set) - get the actual page title

				$title = get_the_title( get_option( 'page_for_posts' ) ) . $sep;

			}

			$websiteName = ( is_front_page() && wm_meta_option( 'seo-title' ) ) ? ( '' ) : ( get_bloginfo( 'name' ) );
			if ( ! wm_option( 'seo-no-website-title' ) )
				$title .= $websiteName;

			//if title is stll empty, use website name
			if ( ! trim( $title ) )
				$title .= get_bloginfo( 'name' );

			//paginated
			if ( 1 < $paged )
				$title .= apply_filters( 'wmhook_meta_title_paged', sprintf( __( ' (page %s)', 'clifden_domain' ), $paged ) );
			//article parts
			if ( 1 < $page )
				$title .= apply_filters( 'wmhook_meta_title_parted', sprintf( __( ' (part %s)', 'clifden_domain' ), $page ) );

			return esc_attr( trim( $title ) );
		}
	} // /wm_seo_title



	/*
	* SEO description
	*/
	if ( ! function_exists( 'wm_seo_desc' ) ) {
		function wm_seo_desc() {
			$out         = '';
			$description = ( wm_option( 'seo-description' ) ) ? ( wm_option( 'seo-description' ) ) : ( get_bloginfo( 'description' ) );

			if ( is_singular() && ! ( is_404() || is_home() || is_front_page() ) ) {
			//is page or post but not 404, front page nor home page post list
				global $posts;

				if ( isset( $posts[0] ) && is_object( $posts[0] ) ) {
					if ( wm_meta_option( 'seo-description', $posts[0]->ID ) ) {
						$out .= wm_meta_option( 'seo-description', $posts[0]->ID );
					} else {
						$excerpt = ( isset( $posts[0]->post_excerpt ) && $posts[0]->post_excerpt ) ? ( strip_tags( $posts[0]->post_excerpt ) ) : ( strip_tags( $posts[0]->post_content ) );
						$excerpt = wp_trim_words( $excerpt, $words = 20, $more = '...' );
						$out .= $excerpt;
					}
				}
			}

			if ( ! $out || ' ' == $out )
				$out .= $description;

			return esc_attr( $out );
		}
	} // /wm_seo_desc



	/*
	* SEO keywords
	*/
	if ( ! function_exists( 'wm_seo_keywords' ) ) {
		function wm_seo_keywords() {
			$out       = '';
			$separator = ', ';
			$keywords  = ( is_singular() && wm_meta_option( 'seo-keywords' ) ) ? ( wm_meta_option( 'seo-keywords' ) ) : ( wm_option( 'seo-keywords' ) );

			if ( is_tag() ) {
			//tag archive

				$out .= single_tag_title( '', false );
				if ( $keywords )
					$out .= $separator . $keywords;

			} elseif ( is_archive() ) {
			//general archive

				$out .= sprintf( __( '%s archive', 'clifden_domain' ), wp_title( '', false ) );
				if ( $keywords )
					$out .= $separator . $keywords;

			} elseif ( is_singular() && ! is_404() ) {
			//is page or post but not 404
				global $post;

				if ( 'wm_projects' === $post->post_type ) {
					$terms = get_the_terms( $post->ID , 'project-category' );
					if ( $terms ) {
						foreach ( $terms as $term ) {
							$out .= $term->name . $separator . $keywords;
						}
					}
				}

				if ( get_the_category() && ! is_page() ) {
				//get post categories
					foreach ( get_the_category() as $categoryKeyword ) {
						$out .= $categoryKeyword->cat_name . $separator;
					}
				}
				if ( get_the_tags() && ! is_page() ) {
				//get post tags
					$i = 0;
					foreach ( get_the_tags() as $tagKeyword ) {
						if ( $i )
							$out .= $separator;
						$out .= $tagKeyword->name;
						++$i;
					}
				}

			}

			if ( '' == $out || ' ' == $out )
				$out .= $keywords;

			return esc_attr( $out );
		}
	} // /wm_seo_keywords



	/*
	* Prints footer scripts (analytics)
	*/
	if ( ! function_exists( 'wm_scripts_footer' ) ) {
		function wm_scripts_footer() {
			$out    = '';
			$pageId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//analitics
				if ( ! ( wm_option( 'seo-no-logged' ) && is_user_logged_in() && current_user_can( wm_option( 'seo-no-logged' ) ) ) ) {
					$code = wm_option( 'seo-custom-footer' );

					if ( is_page() && is_page_template( 'tpl-landing.php' ) )
						$code = wm_meta_option( 'landing-tracking' );

					$out .= '<!-- Custom scripts -->' . "\r\n" . $code . "\r\n\r\n";
				}

			//Roundabout slider tilt - needs to be set before the Roundabout slider apply script
				if ( is_page() && 'roundabout' === wm_meta_option( 'slider-type', $pageId ) ) {
					$out .= '<script>var roundaboutTilt = ' . ( intval( wm_meta_option( 'slider-roundabout-tilt', $pageId ) ) / 100 ) . ';</script>' . "\r\n\r\n";
				}

			//Social sharing buttons JS - output at the end as it is not so important, so can be loaded as last script
				$social = '';
				//Facebook
				if ( wm_option( 'social-share-facebook' ) ) {
					$social .= '<!-- Facebook -->' . "\r\n" . '<div id="fb-root"></div>' . "\r\n" . '<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>' . "\r\n\r\n";
				}
				//Twitter
				if ( wm_option( 'social-share-twitter' ) ) {
					$social .= '<!-- Twitter -->' . "\r\n" . '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>' . "\r\n\r\n";
				}
				//Google+
				if ( wm_option( 'social-share-googleplus' ) ) {
					$social .= "<!-- Google+ -->\r\n<script>(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();</script>" . "\r\n\r\n";
				}
				//Pinterest
				if ( wm_option( 'social-share-pinterest' ) ) {
					$social .= '<!-- Pinterest -->' . "\r\n" . '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>' . "\r\n\r\n";
				}
				//social output
				if (
						$social
						&& ( is_single() || ( is_page() && wm_option( 'social-share-pages' ) ) )
						&& ! wm_meta_option( 'no-sharing' )
						&& ! ( 'wm_projects' == get_post_type() && wm_option( 'social-share-no-projects' ) )
					) {
					$out .= $social;
				}

			echo "\r\n\r\n" . $out;
		}
	} // /wm_scripts_footer





/*
*****************************************************
*      13) POST/PAGE FUNCTIONS
*****************************************************
*/
	/**
	* Modify blog page query
	*/
	if ( ! function_exists( 'wm_home_query' ) ) {
		function wm_home_query( $query ) {
			if ( $query->is_home() && $query->is_main_query() ) {
				$thisPageId   = get_option( 'page_for_posts' );
				$articleCount = ( wm_meta_option( 'blog-posts-count', $thisPageId ) ) ? ( wm_meta_option( 'blog-posts-count', $thisPageId ) ) : ( '' );
				$catsAction   = ( wm_meta_option( 'blog-cats-action', $thisPageId ) ) ? ( wm_meta_option( 'blog-cats-action', $thisPageId ) ) : ( 'category__not_in' );
				$cats         = ( wm_meta_option( 'blog-cats', $thisPageId ) ) ? ( array_filter( wm_meta_option( 'blog-cats', $thisPageId ) ) ) : ( array() );

				if ( 0 < count( $cats ) ) {
					//category slugs to IDs
					$catTemp = array();

					foreach ( $cats as $cat ) {
						if ( ! is_numeric( $cat ) ) {
							$catObj    = get_category_by_slug( $cat );
							$catTemp[] = ( $catObj && isset( $catObj->term_id ) ) ? ( $catObj->term_id ) : ( null );
						} else {
							$catTemp[] = $cat;
						}
					}
					array_filter( $catTemp ); //remove empty (if any)

					$cats = $catTemp;
				}

				$query->set( 'posts_per_page', absint( $articleCount ) );
				if ( 0 < count( $cats ) )
					$query->set( $catsAction, $cats );
			}
		}
	} // /wm_home_query



	/*
	* H1 or H2 headings (on singular pages also checks for subtitle)
	*
	* $list = TEXT [if set, outputs H2 instead of H1]
	* $wrap = HTML ["span" inside H1/H2 text wrapper]
	*/
	if ( ! function_exists( 'wm_heading' ) ) {
		function wm_heading( $list = null, $wrap = null ) {
			if ( is_page_template( 'tpl-construction.php' ) || is_404() )
				return;

			global $post, $page, $paged, $wp_query;

			$blogPageId   = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			$subheading   = ( ! is_archive() ) ? ( wm_meta_option( 'subheading', $blogPageId ) ) : ( '' );
			$headingAlign = wm_meta_option( 'main-heading-alignment', $blogPageId );
			$authorInfo   = '';

			if ( is_page_template( 'tpl-landing.php' ) ) {
				$subheading   = wm_meta_option( 'landing-subheading' );
				$headingAlign = wm_meta_option( 'landing-main-heading-alignment' );
			}

			$headingAlign = ( $headingAlign ) ? ( $headingAlign ) : ( wm_option( 'design-main-heading-alignment' ) );

			if ( is_search() && ! is_home() )
				$subheading = apply_filters( 'wmhook_heading_subtitle_search', sprintf( __( 'Number of items found: %s', 'clifden_domain' ), $wp_query->found_posts ) );

			if ( is_author() && 2 > $paged ) {
				$userID = $wp_query->query_vars['author'];

				$authorDescription = get_the_author_meta( 'description', $userID );

				if ( $authorDescription ) {
					$authorDescription = '<div class="desc">' . $authorDescription . '</div>';

					$authorWebsite = ( get_the_author_meta( 'user_url', $userID ) ) ? ( '<div class="website"><a href="' . esc_url( get_the_author_meta( 'user_url', $userID ) ) . '">' . __( "Visit author's website", 'clifden_domain' ) . '</a></div>' ) : ( '' );
					$authorAvatar  = get_avatar( $userID, 180 );
					$authorName    = get_the_author_meta( 'display_name', $userID );

					$authorSocial = array();
					if ( get_the_author_meta( 'facebook', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'facebook', $userID ) ) . '" icon="Facebook" title="' . sprintf( __( '%s on Facebook', 'clifden_domain' ), $authorName ) . '" size="m"]';
					if ( get_the_author_meta( 'googleplus', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'googleplus', $userID ) ) . '" icon="Google+" title="' . sprintf( __( '%s on Google+', 'clifden_domain' ), $authorName ) . '" size="m" rel="me"]';
					if ( get_the_author_meta( 'twitter', $userID ) )
						$authorSocial[] = '[social url="' . esc_url( get_the_author_meta( 'twitter', $userID ) ) . '" icon="Twitter" title="' . sprintf( __( '%s on Twitter', 'clifden_domain' ), $authorName ) . '" size="m"]';
					$authorSocial = ( ! empty( $authorSocial ) ) ? ( '<div class="socials">' . implode( ' ', $authorSocial ) . '</div>' ) : ( '' );

					$authorInfo = apply_filters( 'wm_default_content_filters', $authorAvatar . $authorDescription . $authorWebsite . $authorSocial );
					$authorInfo = apply_filters( 'wmhook_heading_author_info_html', $authorInfo );
				}
			}

			if ( is_attachment() && ! empty( $post->post_parent ) )
				$subheading = apply_filters( 'wmhook_heading_subtitle_attachment', '<a href="' . get_permalink( $post->post_parent ) . '" title="' . esc_attr( sprintf( __( 'Return to %s', 'clifden_domain' ), strip_tags( get_the_title( $post->post_parent ) ) ) ) . '">&laquo; ' . get_the_title( $post->post_parent ) . '</a>' );

			//List title
			if ( isset( $list ) && $list ) {
				$out = '';

				if ( has_post_format( 'status' ) )
					$out .= ( get_the_title() ) ? ( get_the_title() ) : ( '' );
				else
					$out .= ( get_the_title() ) ? ( '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' ) : ( '' );

				$titleSticky = '';
				if ( is_sticky() )
					$titleSticky = ' title="' . __( 'This is featured post', 'clifden_domain' ) . '"';

				$output =  ( $out ) ? ( '<h2 class="post-title"' . $titleSticky . '>' . $out . '</h2>' ) : ( '' );

				//output
				echo $output;
				return;
			}

			//Main H1 title
			$out = '';
			if ( is_singular() || $blogPageId ) {
			//post or page

				$title = ( isset( $wrap ) && $wrap ) ? ( '<' . $wrap . '>' . get_the_title( $blogPageId ) . '</' . $wrap . '>' ) : ( get_the_title( $blogPageId ) );
				if ( 1 < $page ) {
					$out .= ( $title ) ? ( '<a href="' . get_permalink() . '">' . $title . '</a> <small>' . sprintf( __( ' (part %s)', 'clifden_domain' ), $page ) . '</small>' ) : ( '' );
				} else {
					$out .= ( $title ) ? ( $title ) : ( '' );
				}

			} elseif ( is_day() ) {
			//dayly archives

				$out .= apply_filters( 'wmhook_heading_archives_daily', sprintf( __( '<span>Daily Archives: </span>%s', 'clifden_domain' ), get_the_date() ) );

			} elseif ( is_month() ) {
			//monthly archives

				$out .= apply_filters( 'wmhook_heading_archives_monthly', sprintf( __( '<span>Monthly Archives: </span>%s', 'clifden_domain' ), get_the_date( 'F Y' ) ) );

			} elseif ( is_year() ) {
			//yearly archives

				$out .= apply_filters( 'wmhook_heading_archives_yearly', sprintf( __( '<span>Yearly Archives: </span>%s', 'clifden_domain' ), get_the_date( 'Y' ) ) );

			} elseif ( is_author() ) {
			//author archive

				$userID = $wp_query->query_vars['author'];

				$out .= apply_filters( 'wmhook_heading_archives_author', sprintf( __( '<span>Posts by </span>%s', 'clifden_domain' ), get_the_author_meta( 'display_name', $userID ) ) );

			} elseif ( is_category() ) {
			//category archive

				$out .= apply_filters( 'wmhook_heading_archives_category', sprintf( __( '<span>Posts in </span>%s', 'clifden_domain' ), single_cat_title( '', false ) ) );

			} elseif ( is_tag() ) {
			//tag archive

				$out .= apply_filters( 'wmhook_heading_archives_tag', sprintf( __( '<span>Posts Tagged as </span>%s', 'clifden_domain' ), single_tag_title( '', false ) ) );

			} elseif ( is_search() ) {
			//search

				$out .= apply_filters( 'wmhook_heading_search', sprintf( __( '<span>Search results for </span>%s', 'clifden_domain' ), get_search_query() ) );

			} elseif ( is_tax( 'project-category' ) ) {
			//custom taxonomy

				$portfolioPage   = wm_option( 'layout-breadcrumbs-portfolio-page' );
				$portfolioPageID = wm_page_slug_to_id( $portfolioPage );
				$portfolioPage   = ( $portfolioPageID ) ? ( get_the_title( $portfolioPageID ) . ' / ' ) : ( '' );

				$out .= $portfolioPage . $wp_query->queried_object->name;

			} else {
			//other situations

				$out .= ( wm_option( 'pages-default-archives-title' ) ) ? ( wm_option( 'pages-default-archives-title' ) ) : ( '' );

			}

			//paged
			$out .= ( 1 < $paged ) ? ( ' <small>(page ' . $paged . ')</small>' ) : ( '' );

			//post, page title and subtitle display
			$class = '';
			$classContainer = '';
			if (
					wm_meta_option( 'no-heading', $blogPageId )
					|| ( is_page_template( 'tpl-landing.php' ) && wm_meta_option( 'landing-no-heading' ) )
					|| ! $out
				) {
				$class           = ( ( is_singular() || is_home() ) && $subheading ) ? ( 'invisible' ) : ( '' );
				$classContainer .= ( ( is_singular() || is_home() ) && ! $subheading ) ? ( ' invisible' ) : ( ' visible' );
			} else {
				$classContainer .= ' visible';
			}

			$subtitleH2      = ( $subheading ) ? ( '<h2 class="subtitle">' . do_shortcode( $subheading ) . '</h2>' ) : ( '' );
			$subtitleH2      = ( $authorInfo ) ? ( '<div class="authorinfo">' . $authorInfo . '</div>' ) : ( $subtitleH2 );
			$classContainer .= ( $subtitleH2 ) ? ( ' has-subtitle' ) : ( '' );
			$wrapper         = $wrapperEnd = '';

			//main heading background color class
			$classContainer .= ( wm_css_background( 'design-main-heading-' ) ) ? ( 'set-bg' ) : ( '' );
			$classContainer .= ( ( is_singular() || is_home() ) && $headingAlign ) ? ( ' text-' . $headingAlign ) : ( '' );

			//icon
			$headingIcon     = ( ! wm_meta_option( 'main-heading-icon', $blogPageId ) ) ? ( '' ) : ( '<i class="' . wm_meta_option( 'main-heading-icon', $blogPageId ) . '"></i>' );
			$classContainer .= ( ! wm_meta_option( 'main-heading-icon', $blogPageId ) ) ? ( '' ) : ( ' has-icon' );

			$before = '<header id="main-heading" class="main-heading ' . $classContainer . '"><div class="wrap-inner"><div class="twelve pane">';
			$after  = '</div></div></header>';

			$mainHeadingTag = ( ! is_front_page() ) ? ( '1' ) : ( '2' );
			if ( is_front_page() )
				$class .= ' h1-style';
			if ( $class )
				$class = ' class="' . trim( $class ) . '"';

			//output
			echo $before . $wrapper . $headingIcon . '<h' . $mainHeadingTag . $class . '>' . $out . '</h' . $mainHeadingTag . '>' . $subtitleH2 . $wrapperEnd . $after;
		}
	} // /wm_heading



	/**
	* Thumbnail image
	*
	* @param $args [ARRAY: array of different function options (see below)]
	*
	* @return HTML of post thumbnail in image container
	*/
	if ( ! function_exists( 'wm_thumb' ) ) {
		function wm_thumb( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'a-attributes' => '',          //TEXT: additional <A> HTML tag parameters (like " target='_blank'" for example)
					'class'        => '',          //TEXT: image container additional CSS class name
					'img-attr'     => null,        //ARRAY: check WordPress codex on this
					'link'         => true,        //BOOLEAN = whether to apply a permalink, TEXT = either 'modal' or URL, ARRAY = [url, class]
					'list'         => false,       //BOOLEAN: set to use post permalink in [posts] even when shortcode on single post or page (@todo: test this, not sure if still required...)
					'overlay'      => '',          //TEXT: link overlay content
					'placeholder'  => false,       //BOOLEAN: whether to display placeholder image if featured image does not exist
					'post'         => null,        //OBJECT: WordPress post object
					'size'         => 'thumbnail', //TEXT: image size
				) );

			$post = $args['post'];
			if ( ! $post )
				global $post;

			$attachment         = ( has_post_thumbnail() ) ? ( get_post( get_post_thumbnail_id( $post->ID ) ) ) : ( '' );
			$attachmentTitle[0] = ( isset( $attachment->post_title ) ) ? ( trim( strip_tags( $attachment->post_title ) ) ) : ( '' );
			$attachmentTitle[1] = ( isset( $attachment->post_excerpt ) ) ? ( trim( strip_tags( $attachment->post_excerpt ) ) ) : ( '' );

			$args['img-attr']   = wp_parse_args( $args['img-attr'], array( 'title' => $attachmentTitle[0] ) );

			$attachmentTitle    = apply_filters( 'wmhook_thumbnail_title', esc_attr( implode( ' - ', array_filter( $attachmentTitle ) ) ), $attachmentTitle );

			$anchorClass = '';

			$theClass      = ( $args['class'] ) ? ( ' ' . esc_attr( $args['class'] ) ) : ( '' );
			$image         = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, $args['size'], $args['img-attr'] ) ) : ( '' );
			$image         = ( ! $image && $args['placeholder'] ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/placeholder/' . $args['size'] . '.png" alt="" />' ) : ( $image );
			$largeImageUrl = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), wm_option( 'general-lightbox-img' ) ) ) : ( array( '' ) );

			if ( is_array( $args['link'] ) ) {
				$linkURL = $largeImageUrl[0] = $args['link'][0];
				$anchorClass = ' class="' . $args['link'][1] . '"';
			} elseif ( false === strpos( $args['link'], 'http' ) ) {
				if ( 'modal' === $args['link'] && $largeImageUrl[0] )
					$linkURL = $largeImageUrl[0];
				elseif ( 'modal' !== $args['link'] )
					$linkURL = get_permalink();
				else
					$linkURL = '';
			} else {
				$linkURL = $largeImageUrl[0] = $args['link'];
			}

			if ( $args['overlay'] )
				$args['overlay'] = '<span class="overlay">' . $args['overlay'] . '</span>';

			$out = '';
			if ( is_singular() && isset( $post->ID ) && ! $args['list'] ) {

				if ( $image ) {
					$out .= '<div class="image-container' . $theClass . '">';
					$out .= ( $args['link'] ) ? ( '<a href="' . $largeImageUrl[0] . '"' . $args['a-attributes'] . $anchorClass . ' title="' . $attachmentTitle . '">' ) : ( '' );
					$out .= $image;
					$out .= ( $args['link'] ) ? ( $args['overlay'] . '</a>' ) : ( '' );
					$out .= '</div>';
				}

			} else {

				if ( $image ) {
					$out .= '<div class="image-container' . $theClass . '">';
					$out .= ( $args['link'] && $linkURL ) ? ( '<a href="' . $linkURL . '"' . $args['a-attributes'] . $anchorClass . ' title="' . $attachmentTitle . '">' ) : ( '' );
					$out .= $image;
					$out .= ( $args['link'] && $linkURL ) ? ( $args['overlay'] . '</a>' ) : ( '' );
					$out .= '</div>';
				}

			}

			return apply_filters( 'wmhook_thumbnail_html', $out );
		}
	} // /wm_thumb



	/*
	* Get all images attached to the post
	*
	* $numberposts = # [number of images to get (-1 = all)]
	* $post_id     = # [specific post id, else current post id used]
	* $size        = TEXT [image size]
	*/
	if ( ! function_exists( 'wm_get_post_images' ) ) {
		function wm_get_post_images( $post_id = null, $size = null, $numberposts = -1, $noFeatured = false ) {
			global $post;
			if ( ! $post_id && ! $post ) {
				return;
			}

			$post_id     = ( $post_id ) ? ( absint( $post_id ) ) : ( $post->ID );
			$size        = ( $size ) ? ( $size ) : ( 'widget' );
			$outputArray = array();

			$args = array(
					'numberposts'    => $numberposts,
					'post_parent'    => $post_id,
					'orderby'        => 'menu_order',
					'order'          => 'asc',
					'post_mime_type' => 'image',
					'post_type'      => 'attachment'
				);
			if ( $noFeatured ) {
				$args['exclude'] = get_post_thumbnail_id( $post_id );
			}
			$images = get_children( $args );

			if ( ! empty( $images ) ) {
				foreach ( $images as $attachment_id => $attachment ) {
					$imgUrlArray    = wp_get_attachment_image_src( $attachment_id, $size );
					$imgTitle       = trim( strip_tags( $attachment->post_title ) );
					$imgCaption     = trim( strip_tags( $attachment->post_excerpt ) );

					$entry          = array();
					$entry['name']  = ( $imgCaption ) ? ( esc_attr( $imgTitle . ' - ' . $imgCaption ) ) : ( esc_attr( $imgTitle ) );
					$entry['id']    = esc_attr( $attachment_id );
					$entry['img']   = $imgUrlArray[0];
					$entry['title'] = esc_attr( $imgTitle );
					$entry['alt']   = esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );

					$outputArray[]  = $entry;
				}
			}

			return $outputArray;
		}
	} // /wm_get_post_images



	/*
	* Media uploader image sizes
	*
	* $sizes = ARRAY [check WordPress codex on this]
	*/
	if ( ! function_exists( 'wm_media_uploader_image_sizes' ) ) {
		function wm_media_uploader_image_sizes( $sizes ) {
			global $createImagesArray;

			$imageSizes = array(
					//landscape
					'mobile-ratio-11'  => __( 'Square', 'clifden_domain_panel' ),
					'mobile-ratio-43'  => __( 'Landscape 4 to 3 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-32'  => __( 'Landscape 3 to 2 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-169' => __( 'Landscape 16 to 9 ratio (widescreen)', 'clifden_domain_panel' ),
					'mobile-ratio-21'  => __( 'Landscape 2 to 1 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-31'  => __( 'Landscape 3 to 1 ratio', 'clifden_domain_panel' ),
					//portrait
					'mobile-ratio-34'  => __( 'Portrait 3 to 4 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-23'  => __( 'Portrait 2 to 3 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-916' => __( 'Portrait 9 to 16 ratio', 'clifden_domain_panel' ),
					'mobile-ratio-12'  => __( 'Portrait 1 to 2 ratio', 'clifden_domain_panel' ),
				);

			$customSizes = array();
			$customSizes['mobile'] = __( 'Mobile', 'clifden_domain_panel' );
			foreach ( $createImagesArray as $imageSize ) {
				$customSizes['mobile-' . $imageSize] = $imageSizes['mobile-' . $imageSize];
			}

			return array_merge( $sizes, $customSizes );
		}
	} // /wm_media_uploader_image_sizes



	/*
	* Add meta fields to media uploader
	*
	* $form_fields = ARRAY [fields to include in attachment form]
	* $post        = OBJECT [attachment record in database]
	*/
	if ( ! function_exists( 'wm_attachment_meta_fields' ) ) {
		function wm_attachment_meta_fields( $form_fields, $post ) {
			if ( false !== strpos( $post->post_mime_type, 'image' ) ) {
			//only for images

				//helper output variables
				$captionPositions = array(
					' column col-14 no-margin alignleft'   => __( 'Left, 1/4 column', 'clifden_domain_adm' ),
					' column col-13 no-margin alignleft'   => __( 'Left, 1/3 column', 'clifden_domain_adm' ),
					' column col-12 no-margin alignleft'   => __( 'Left, 1/2 column', 'clifden_domain_adm' ),
					' column col-23 no-margin alignleft'   => __( 'Left, 2/3 column', 'clifden_domain_adm' ),
					' column col-34 no-margin alignleft'   => __( 'Left, 3/4 column', 'clifden_domain_adm' ),

					' column col-14 no-margin alignright'  => __( 'Right, 1/4 column', 'clifden_domain_adm' ),
					' column col-13 no-margin alignright'  => __( 'Right, 1/3 column', 'clifden_domain_adm' ),
					' column col-12 no-margin alignright'  => __( 'Right, 1/2 column', 'clifden_domain_adm' ),
					' column col-23 no-margin alignright'  => __( 'Right, 2/3 column', 'clifden_domain_adm' ),
					' column col-34 no-margin alignright'  => __( 'Right, 3/4 column', 'clifden_domain_adm' ),

					' column col-11 no-margin aligntop'    => __( 'Top, full width', 'clifden_domain_adm' ),
					' column col-11 no-margin centered'    => __( 'Center, full width', 'clifden_domain_adm' ),
					' column col-11 no-margin alignbottom' => __( 'Bottom, full width', 'clifden_domain_adm' ),
					);
				$captionPositionsOut = $captionTransparencyOut = '';
				foreach ( $captionPositions as $value => $position ) {
					$captionPositionsOut .= '<option value="' . $value . '" ' . selected( get_post_meta( $post->ID, 'caption-alignment', true ), $value, false ) . '>';
					$captionPositionsOut .= $position;
					$captionPositionsOut .= '</option>';
				}
				for ( $i = 0; $i <= 20; $i++ ) {
					$value = $i * 5;
					$captionTransparencyOut .= '<option value="' . $value . '" ' . selected( get_post_meta( $post->ID, 'caption-opacity', true ), $value, false ) . '>' . $value . '%</option>';
				}

				//additional form fields
				$form_fields['separator-1']['tr'] = '<tr><td colspan="2" style="text-align: center;"><hr style="width: 100%; border: none; border-top: 1px dashed #dfdfdf; outline: none;" /></td></tr>';
				$form_fields['text-1']['tr'] = '<tr><th valign="top" scope="row" class="label"><label></label></th><td>
				<p><span class="button toggle-switcher">' . __( 'Slider', 'clifden_domain_adm' ) . ' <small class="button-change">[+]</small></span></p>
				<div class="toggle-these-settings" style="display: none;">
				<p><small><em>' . __( 'Following section sets the image caption options when the image is displayed in image gallery slider only (<strong>page slider must be set to display image gallery</strong>).', 'clifden_domain_adm' ) . '</em></small></p>' .
					'<p style="margin-top:0;">
						<label style="display:inline-block; width:130px; for="attachments[' . $post->ID . '][image-url]"><strong>' . __( 'Custom link URL', 'clifden_domain_adm' ) . ':</strong></label>
						<input type="text" class="text" id="attachments[' . $post->ID . '][image-url]" name="attachments[' . $post->ID . '][image-url]" value="' . esc_url( get_post_meta( $post->ID, 'image-url', true ) ) . '" />
					</p>' .
					'<p>
						<label style="display:inline-block; width:130px;" for="attachments[' . $post->ID . '][caption-alignment]"><strong>' . __( 'Caption position', 'clifden_domain_adm' ) . ':</strong></label>
						<select name="attachments[' . $post->ID . '][caption-alignment]" id="attachments[' . $post->ID . '][caption-alignment]">' . $captionPositionsOut . '</select>
					</p>' .
					'<p>
						<label style="display:inline-block; width:130px;" for="attachments[' . $post->ID . '][caption-color]"><strong>' . __( 'Caption background', 'clifden_domain_adm' ) . ':</strong></label>
						<select name="attachments[' . $post->ID . '][caption-color]" id="attachments[' . $post->ID . '][caption-color]">
							<option value="black" ' . selected( get_post_meta( $post->ID, 'caption-color', true ), 'black', false ) . '>' . __( 'Black (white text)', 'clifden_domain_adm' ) . '</option>
							<option value="white" ' . selected( get_post_meta( $post->ID, 'caption-color', true ), 'white', false ) . '>' . __( 'White (black text)', 'clifden_domain_adm' ) . '</option>
						</select>
					</p>' .
					'<p>
						<label style="display:inline-block; width:130px;" for="attachments[' . $post->ID . '][caption-opacity]"><strong>' . __( 'Caption opacity', 'clifden_domain_adm' ) . '</strong></label>
						<select name="attachments[' . $post->ID . '][caption-opacity]" id="attachments[' . $post->ID . '][caption-opacity]">' . $captionTransparencyOut . '</select>
					</p>' .
					'<p>
						<label style="display:inline-block; width:130px;"><strong>' . __( 'Caption padding', 'clifden_domain_adm' ) . ':</strong></label>
						<input type="radio" name="attachments[' . $post->ID . '][caption-padding]" id="attachments[' . $post->ID . '][caption-padding][0]" value="" ' . checked( get_post_meta( $post->ID, 'caption-padding', true ), '', false ) . ' /> <label for="attachments[' . $post->ID . '][caption-padding][0]">' . __( 'Yes', 'clifden_domain_adm' ) . '</label>&nbsp;&nbsp;&nbsp;
						<input type="radio" name="attachments[' . $post->ID . '][caption-padding]" id="attachments[' . $post->ID . '][caption-padding][1]" value=" no-padding" ' . checked( get_post_meta( $post->ID, 'caption-padding', true ), ' no-padding', false ) . ' /> <label for="attachments[' . $post->ID . '][caption-padding][1]">' . __( 'No', 'clifden_domain_adm' ) . '</label>
					</p>' .
					'</div></td></tr>';
				$form_fields['separator-2']['tr'] = '<tr><td colspan="2" style="text-align: center;"><hr style="width: 100%; border: none; border-top: 1px dashed #dfdfdf; outline: none;" /></td></tr>';

			} // /if image

			//output
			return $form_fields;
		}
	} // /wm_attachment_meta_fields



	/*
	* Save meta fields for attachments in media uploader
	*
	* $attachment = ARRAY [$_POST fields]
	* $post       = OBJECT [attachment record in database]
	*/
	if ( ! function_exists( 'wm_attachment_meta_fields_save' ) ) {
		function wm_attachment_meta_fields_save( $post, $attachment ) {
			if ( isset( $attachment['image-url'] ) )
				update_post_meta( $post['ID'], 'image-url', esc_url( $attachment['image-url'] ) );
			if ( isset( $attachment['caption-alignment'] ) )
				update_post_meta( $post['ID'], 'caption-alignment', $attachment['caption-alignment'] );
			if ( isset( $attachment['caption-color'] ) )
				update_post_meta( $post['ID'], 'caption-color', $attachment['caption-color'] );
			if ( isset( $attachment['caption-opacity'] ) )
				update_post_meta( $post['ID'], 'caption-opacity', $attachment['caption-opacity'] );
			if ( isset( $attachment['caption-padding'] ) )
				update_post_meta( $post['ID'], 'caption-padding', $attachment['caption-padding'] );

			return $post;
		}
	} // /wm_attachment_meta_fields_save



	/*
	* Additional file uploader mime types
	*/
	if ( ! function_exists( 'wm_custom_mime_types' ) ) {
		function wm_custom_mime_types( $mimes ) {
			return array_merge( $mimes, array(
					'ac3' => 'audio/ac3',
					'flv' => 'video/x-flv',
					'ico' => 'image/x-icon'
				) );
		}
	} // /wm_custom_mime_types



	/*
	* Media library filters
	*/
	if ( ! function_exists( 'wm_media_filters' ) ) {
		function wm_media_filters( $mimes ) {
			//multimedia
			$mimes['image/x-icon'] = array(
					__( 'Icons', 'clifden_domain_adm' ),
					__( 'Manage icons', 'clifden_domain_adm' ),
					_n_noop( 'Icon <span class="count">(%s)</span>', 'Icons <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/x-shockwave-flash'] = array(
					__( 'SWFs', 'clifden_domain_adm' ),
					__( 'Manage SWFs', 'clifden_domain_adm' ),
					_n_noop( 'SWF <span class="count">(%s)</span>', 'SWFs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);

			//office documents
			$mimes['application/msword'] = array(
					__( 'MS Word documents', 'clifden_domain_adm' ),
					__( 'Manage MS Word documents', 'clifden_domain_adm' ),
					_n_noop( 'MS Word document <span class="count">(%s)</span>', 'MS Word documents <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/vnd.ms-excel'] = array(
					__( 'MS Excel spreadsheets', 'clifden_domain_adm' ),
					__( 'Manage MS Excel spreadsheets', 'clifden_domain_adm' ),
					_n_noop( 'MS Excel spreadsheet <span class="count">(%s)</span>', 'MS Excel spreadsheets <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/vnd.ms-powerpoint'] = array(
					__( 'MS Powerpoint presentations', 'clifden_domain_adm' ),
					__( 'Manage MS Powerpoint presentations', 'clifden_domain_adm' ),
					_n_noop( 'MS Powerpoint presentation <span class="count">(%s)</span>', 'MS Powerpoint presentations <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/rtf'] = array(
					__( 'RTFs', 'clifden_domain_adm' ),
					__( 'Manage RTFs', 'clifden_domain_adm' ),
					_n_noop( 'RTF <span class="count">(%s)</span>', 'RTFs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.text'] = array(
					__( 'ODT documents', 'clifden_domain_adm' ),
					__( 'Manage ODT documents', 'clifden_domain_adm' ),
					_n_noop( 'ODT document <span class="count">(%s)</span>', 'ODT documents <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.spreadsheet'] = array(
					__( 'ODS spreadsheets', 'clifden_domain_adm' ),
					__( 'Manage ODS spreadsheets', 'clifden_domain_adm' ),
					_n_noop( 'ODS spreadsheet <span class="count">(%s)</span>', 'ODS spreadsheets <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/vnd.oasis.opendocument.presentation'] = array(
					__( 'ODP presentations', 'clifden_domain_adm' ),
					__( 'Manage ODP presentations', 'clifden_domain_adm' ),
					_n_noop( 'ODP presentation <span class="count">(%s)</span>', 'ODP presentations <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);

			//pdf
			$mimes['application/pdf'] = array(
					__( 'PDFs', 'clifden_domain_adm' ),
					__( 'Manage PDFs', 'clifden_domain_adm' ),
					_n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);

			//packages
			$mimes['application/zip'] = array(
					__( 'ZIPs', 'clifden_domain_adm' ),
					__( 'Manage ZIPs', 'clifden_domain_adm' ),
					_n_noop( 'ZIP <span class="count">(%s)</span>', 'ZIPs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/x-gzip'] = array(
					__( 'GZIPs', 'clifden_domain_adm' ),
					__( 'Manage GZIPs', 'clifden_domain_adm' ),
					_n_noop( 'GZIP <span class="count">(%s)</span>', 'GZIPs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/rar'] = array(
					__( 'RARs', 'clifden_domain_adm' ),
					__( 'Manage RARs', 'clifden_domain_adm' ),
					_n_noop( 'RAR <span class="count">(%s)</span>', 'RARs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);
			$mimes['application/x-msdownload'] = array(
					__( 'EXEs', 'clifden_domain_adm' ),
					__( 'Manage EXEs', 'clifden_domain_adm' ),
					_n_noop( 'EXE <span class="count">(%s)</span>', 'EXEs <span class="count">(%s)</span>', 'clifden_domain_adm' )
				);

			return $mimes;
		}
	} // /wm_media_filters



	/*
	* WP gallery improvements
	*
	* Improves WordPress [gallery] shortcode: removes inline CSS, changes HTML markup to valid, makes it easier to remove images from gallery.
	* $attr = ARRAY [check WordPress codex on this]
	*
	* Original source code from wp-includes/media.php
	*/
	if ( ! function_exists( 'wm_shortcode_gallery' ) ) {
		function wm_shortcode_gallery( $output, $attr ) {
			$post = get_post();

			static $instance = 0;
			$instance++;
			//WordPress passes $attr variable only to the filter, so the above needs to be reset

			$output = '';

			// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
			if ( isset( $attr['orderby'] ) ) {
				$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
				if ( ! $attr['orderby'] )
					unset( $attr['orderby'] );
			}

			extract( shortcode_atts( array(
				'order'      => 'ASC',
				'orderby'    => 'menu_order ID',
				'id'         => $post->ID,
				'itemtag'    => 'figure',
				'icontag'    => 'span',
				'captiontag' => 'div',
				'columns'    => 3,
				'size'       => ( wm_option( 'general-gallery-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-gallery-image-ratio' ) ) : ( 'mobile-ratio-169' ),
				'include'    => '',
				'exclude'    => '',
				//custom theme additions:
					'remove'     => '', //remove images by order number
					'flexible'   => '', //if set, masonry gallery displayed
					'sardine'    => '', //no margins between gallery images
					'frame'      => '', //frames gallery images
				// /custom theme additions
			), $attr ) );

			//custom theme additions:
				$excludeImages = ( 'exclude' === wm_meta_option( 'gallery' ) || 'excludedGallery' === wm_meta_option( 'gallery' ) ) ? ( wm_meta_option( 'gallery-images' ) ) : ( null );
				if ( is_array( $excludeImages ) && ! empty( $excludeImages ) ) {
					/*
					* WP3.5 generates multiple galleries per post with "ids" parameter (see above) that translates into "include".
					* That's why we need to manage that one too for the theme gallery improvements.
					* Basically, remove all the excluded images from "include" only when "ids" parameter set, otherwise leave include untouched.
					*/
					if ( isset( $attr['ids'] ) && ! empty( $attr['ids'] ) ) {
						$include       = str_replace( ' ', '', $include );
						$includeRemove = explode( ',', $include );
						foreach ( $includeRemove as $key => $value ) {
							if ( in_array( $value, $excludeImages ) )
								unset( $includeRemove[$key] );
						}
						$include = implode( ',', $includeRemove );
					}

					$excludeImages = implode( ',', $excludeImages );
				}

				$exclude = ( $exclude ) ? ( $exclude ) : ( $excludeImages );
				$remove  = preg_replace( '/[^0-9,]+/', '', $remove );
				$remove  = ( $remove ) ? ( explode( ',', $remove ) ) : ( array() );
				$sardine = ( $sardine ) ? ( ' no-margin' ) : ( '' );
				$frame   = ( $frame ) ? ( ' frame' ) : ( '' );
			// /custom theme additions

			$id = intval( $id );
			if ( 'RAND' == $order )
				$orderby = 'none';

			if ( ! empty( $include ) ) {
				$include = preg_replace( '/[^0-9,]+/', '', $include ); //not in WP 3.5 but keeping it
				$_attachments = get_posts( array(
						'include'        => $include,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );

				$attachments = array();
				foreach ( $_attachments as $key => $val ) {
					$attachments[$val->ID] = $_attachments[$key];
				}
			} elseif ( ! empty( $exclude ) ) {
				$exclude     = preg_replace( '/[^0-9,]+/', '', $exclude ); //not in WP 3.5 but keeping it
				$attachments = get_children( array(
						'post_parent'    => $id,
						'exclude'        => $exclude,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );
			} else {
				$attachments = get_children( array(
						'post_parent'    => $id,
						'post_status'    => 'inherit',
						'post_type'      => 'attachment',
						'post_mime_type' => 'image',
						'order'          => $order,
						'orderby'        => $orderby
					) );
			}

			if ( empty( $attachments ) || is_feed() )
				return ''; //this will make the default WordPress function to take care of processing

			$itemtag    = tag_escape( $itemtag );
			$captiontag = tag_escape( $captiontag );
			$columns    = absint( $columns );
			$float      = is_rtl() ? 'right' : 'left';

			//custom theme additions:
				$wrapper    = ( 'li' == $itemtag ) ? ( '<ul>' ) : ( '' );
				$wrapperEnd = ( $wrapper ) ? ( '</ul>' ) : ( '' );
				$columns    = ( 1 > $columns || 9 < $columns ) ? ( 3 ) : ( $columns ); //only 1 to 9 columns allowed

				if ( 1 === absint( $columns ) )
					$size = 'content-width';

				$flexible = ( ( $flexible || 'mobile' == $size || 'content-width' == $size ) && 1 < $columns ) ? ( true ) : ( false );

				if ( $flexible ) {
					$flexible = ' masonry-container';
					$size     = 'mobile';
					if ( 1 === absint( $columns ) )
						$size = 'content-width';
					wp_enqueue_script( 'jquery-masonry' );
				}
			// /custom theme additions

			$selector   = "gallery-{$instance}";
			$size_class = sanitize_html_class( $size );
			$output     = "<div id='$selector' class='gallery galleryid-{$id} clearfix gallery-columns-{$columns} gallery-columns gallery-size-{$size_class}{$flexible}'>" . $wrapper; //custom theme additions

			$i = $j = 0; //$i = every image from gallery, $j = only displayed images
			foreach ( $attachments as $id => $attachment ) { //custom theme additions in this foreach
				$fullImgSize = ( wm_option( 'general-lightbox-img' ) ) ? ( wm_option( 'general-lightbox-img' ) ) : ( 'full' );
				$fullImg     = wp_get_attachment_image_src( $id, $fullImgSize, false );
				$imageArray  = wp_get_attachment_image_src( $id, $size, false );
				$titleText   = array( ucfirst( $attachment->post_title ), $attachment->post_excerpt );
				$titleText   = esc_attr( implode( ' - ', array_filter( $titleText ) ) );
				$image       = '<img src="' . $imageArray[0] . '" alt="' . $titleText . '" title="' . $titleText . '" />';

				$linkAtts = $link = '';
				$specialLink = trim( get_post_meta( $attachment->ID, 'image-url', true ) );
				if ( ! wm_option( 'general-no-lightbox' ) )
					$linkAtts .= ' rel="prettyPhoto[pp_gal]"';
				if ( isset( $attr['link'] ) && 'special' == $attr['link'] && $specialLink )
					$link = '<a href="' . esc_url( $specialLink ) . '" title="' . $titleText . '">' . $image . '</a>';
				else
					$link = '<a href="' . $fullImg[0] . '" title="' . $titleText . '"' . $linkAtts . '>' . $image . '</a>';

				$i++;

				if ( ! in_array( $i, $remove ) ) {
					if ( ++$j % $columns == 0 )
						$last = ' last';
					else
						$last = '';

					$last .= ( $j <= $columns ) ? ( ' first-row' ) : ( null );

					$output .= "<{$itemtag} class='gallery-item column$sardine col-1{$columns}$last$frame'>";
					$output .= "<{$icontag} class='gallery-icon'>$link</{$icontag}>";
					if ( $captiontag && trim( $attachment->post_excerpt ) ) {
						$output .= "
							<{$captiontag} class='wp-caption-text gallery-caption'>
							" . apply_filters( 'wm_default_content_filters', $attachment->post_excerpt ) . "
							</{$captiontag}>";
					}
					$output .= "</{$itemtag}>";
					if ( $columns > 0 && $i % $columns == 0 )
						$output .= '';
				}
			}

			$output .= $wrapperEnd . "</div>\r\n"; //custom theme additions

			return $output;
		}
	} // /wm_shortcode_gallery

	/*
	* Displays gallery
	*/
	if ( ! function_exists( 'wm_display_gallery' ) ) {
		function wm_display_gallery() {
			global $page, $numpages; //display only on the last page of paged post

			if ( ( 'gallery' === wm_meta_option( 'gallery' ) || 'excludedGallery' === wm_meta_option( 'gallery' ) ) && $numpages === $page ) {
				$columns = wm_meta_option( 'gallery-columns' );
				$images  = wm_meta_option( 'gallery-images' );
				$images  = ( is_array( $images ) && ! empty( $images ) ) ? ( implode( ',', $images ) ) : ( '' );

				echo do_shortcode( '<div class="meta-bottom">[gallery columns="' . $columns . '" include="' . $images . '" link="file" /]</div>' );
			}
		}
	} // /wm_display_gallery



	/**
	* WordPress image captions
	*
	* Improves WordPress image captions by removing inline styling.
	*
	* @param $attr [ARRAY : check WordPress codex on this]
	*
	* Original source code from wp-includes/media.php
	*/
	if ( ! function_exists( 'wm_shortcode_image_caption' ) ) {
		function wm_shortcode_image_caption( $val, $attr, $content = null ) {
			extract( shortcode_atts( array(
					'id'      => '',
					'align'   => 'alignnone',
					'width'   => '',
					'caption' => '',
					'class'   => '',
					), $attr, 'caption' )
				);

			if ( 1 > (int) $width || empty( $caption ) )
				return $content;

			if ( $id )
				$id = 'id="' . esc_attr( $id ) . '" ';

			$class = trim( 'wp-caption ' . $align . ' ' . $class );

			return '<div ' . $id . 'class="' . esc_attr( $class ) . '"><figure>' . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . do_shortcode( $caption ) . '</figcaption></figure></div>';
		}
	} // /wm_shortcode_image_caption



	/*
	* Excerpt
	*
	* $length_fn = FN [callback function setting the excerpt length]
	* $more_fn   = FN [callback function setting the "..." string after excerpt]
	*/
	if ( ! function_exists( 'wm_excerpt' ) ) {
		function wm_excerpt( $length_fn = null, $more_fn = null ) {
			if ( $length_fn && is_callable( $length_fn ) )
				add_filter( 'excerpt_length', $length_fn, 999 );
			else
				add_filter( 'excerpt_length', 'wm_excerpt_length_blog', 999 );

			if ( $more_fn && is_callable( $more_fn ) )
				add_filter( 'excerpt_more', $more_fn );
			else
				add_filter( 'excerpt_more', 'wm_excerpt_more' );

			$excerpt = trim( get_the_excerpt() ); //shortcodes are being stripped out by WordPress by default

			$out = '';
			if ( $excerpt ) {
				if ( post_password_required() )
					$excerpt = apply_filters( 'wmhook_excerpt_text_password_protected', '<strong>' . __( 'Password protected', 'clifden_domain' ) . '</strong>' );
				$out .= '<div class="excerpt">';
				$out .= apply_filters( 'wm_default_content_filters', $excerpt );
				$out .= '</div>';
			}

			echo $out;
		}
	} // /wm_excerpt

	//Page excerpt
	if ( ! function_exists( 'wm_page_excerpt' ) ) {
		function wm_page_excerpt() {
			global $post;

			if ( is_page() ) {
				$allowed = ( wm_option( 'general-client-area' ) ) ? ( wm_restriction_page() ) : ( true );

				$excerpt = get_post_meta( $post->ID, 'page_excerpt', true );

				if ( $excerpt && $allowed )
					echo '<div class="page-excerpt' . wm_option( 'design-pageexcerpt-icons' ) . '"><div class="wrap-inner"><div class="twelve pane">' . apply_filters( 'wm_default_content_filters', $excerpt ) . '</div></div></div>';
			}
		}
	} // /wm_page_excerpt

	/*
	* Different excerpt length callback functions
	*/
	if ( ! function_exists( 'wm_excerpt_length_blog' ) ) {
		function wm_excerpt_length_blog( $length ) {
			$defaultLength = ( wm_option( 'blog-excerpt-length' ) ) ? ( wm_option( 'blog-excerpt-length' ) ) : ( WM_DEFAULT_EXCERPT_LENGTH );
			$customLength  = ( wm_option( 'blog-excerpt-length' ) ) ? ( wm_option( 'blog-excerpt-length' ) ) : ( $defaultLength );
			return $customLength;
		}
	} // /wm_excerpt_length_blog

	if ( ! function_exists( 'wm_excerpt_length_short' ) ) {
		function wm_excerpt_length_short( $length ) {
			$customLength = ( wm_option( 'blog-excerpt-length-short' ) ) ? ( wm_option( 'blog-excerpt-length-short' ) ) : ( 25 );
			return $customLength;
		}
	} // /wm_excerpt_length_short

	if ( ! function_exists( 'wm_excerpt_length_very_short' ) ) {
		function wm_excerpt_length_very_short( $length ) {
			$customLength = ( wm_option( 'blog-excerpt-length-shortest' ) ) ? ( wm_option( 'blog-excerpt-length-shortest' ) ) : ( 10 );
			return $customLength;
		}
	} // /wm_excerpt_length_very_short

	/*
	* Excerpt "more" callback function
	*/
	if ( ! function_exists( 'wm_excerpt_more' ) ) {
		function wm_excerpt_more( $more ) {
			return '&hellip;';
		}
	} // /wm_excerpt_more

	/*
	* Displays excerpt
	*/
	if ( ! function_exists( 'wm_display_excerpt' ) ) {
		function wm_display_excerpt() {
			if ( is_single() && has_excerpt() )
				wm_excerpt( 'wm_excerpt_length_blog', null );
		}
	} // /wm_display_excerpt

	/*
	* Post content or excerpt depending on using <!--more--> tag
	*/
	if ( ! function_exists( 'wm_content_or_excerpt' ) ) {
		function wm_content_or_excerpt( $post ) {
			$out = '';

			if ( isset( $post ) && $post ) {
				if ( false !== stripos( $post->post_content, '<!--more-->' ) ) {
					global $more; //required for <!--more--> tag to work
					$more = 0; //required for <!--more--> tag to work
					$out .= '<div class="excerpt">';
					if ( has_excerpt() && ! post_password_required() )
						$out .= '<div class="excerpt">' . apply_filters( 'wm_default_content_filters', get_the_excerpt() ) . '</div>';

					$out .= ( ! post_password_required() ) ? ( apply_filters( 'wm_default_content_filters', get_the_content( '' ) ) ) : ( '<strong>' . __( 'Password protected', 'clifden_domain' ) . '</strong>' );
					$out .= '</div>';
					$out .= '<p><a href="' . get_permalink() . '#more-' . $post->ID . '" class="more-link">' . apply_filters( 'wmhook_excerpt_text_continue', __( 'Continue reading &raquo;', 'clifden_domain' ) ) . '</a></p>';
				} else {
					$out .= wm_excerpt( 'wm_excerpt_length_blog', 'wm_excerpt_more' );
					$out .= '<p><a href="' . get_permalink() . '" class="more-link">' . apply_filters( 'wmhook_excerpt_text_continue', __( 'Continue reading &raquo;', 'clifden_domain' ) ) . '</a></p>';
				}
			}

			return $out;
		}
	} // /wm_content_or_excerpt



	/*
	* "Read more" button
	*
	* $print = TEXT ["print" the value]
	* $class = TEXT [like "btn color-green" for example]
	*/
	if ( ! function_exists( 'wm_more' ) ) {
		function wm_more( $class = 'more-link', $print = null ) {
			$out = '<a href="' . get_permalink() . '" class="' . $class . '">' . __( 'Read more &raquo;', 'clifden_domain' ) . '</a>';

			if ( $print )
				echo apply_filters( 'wmhook_read_more_html', $out );
			else
				return apply_filters( 'wmhook_read_more_html', $out );
		}
	} // /wm_more



	/*
	* Post meta info
	*
	* $positions = ARRAY [array of meta information positions]
	* $class     = TEXT [like "btn color-green" for example]
	* $tag       = TEXT [wrapper HTML tag]
	*/
	if ( ! function_exists( 'wm_meta' ) ) {
		function wm_meta( $positions = null, $class = null, $tag = 'footer', $print = true ) {
			if ( ( is_page() || is_front_page() || is_home() ) && ! $positions )
			  return;

			if ( ! $positions )
				$positions = array(
					'formaticon',
					'date',
					'comments',
					'cats',
					'author',
					'tags'
					);

			$out    = '';
			$tag    = ( $tag ) ? ( $tag ) : ( 'footer' );
			$format = ( get_post_format() ) ? ( get_post_format() ) : ( 'standard' );

			if ( ! empty( $positions ) ) {
				foreach ( $positions as $position ) {
					switch ( $position ) {
						case 'author':

							if ( ! wm_option( 'blog-disable-author' ) )
								$out .= '<span class="author vcard meta-item">' . apply_filters( 'wmhook_meta_text_author', sprintf( __( 'By %s', 'clifden_domain' ), '<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" rel="author">' . get_the_author() . '</a>' ) ) . '</span>';

						break;
						case 'cats':

							if ( ! wm_option( 'blog-disable-cats' ) )
								$out .= ( get_the_category_list( '' ) ) ? ( '<span class="categories meta-item">' . apply_filters( 'wmhook_meta_text_category', sprintf( __( 'In %s', 'clifden_domain' ), get_the_category_list( ', ' ) ) ) . '</span>' ) : ( '' );

						break;
						case 'comments':

							if ( ! wm_option( 'blog-disable-comments-count' ) && ( comments_open() || get_comments_number() ) ) {
							//comments displayed only when enabled by admin panel AND if the post has comments eventhough commenting disabled for the post now

								$elementId = ( get_comments_number() ) ? ( '#comments' ) : ( '#respond' );
								$out      .= '<span class="comments meta-item"><a href="' . get_permalink() . $elementId . '">' . sprintf( __( 'Comments: %s', 'clifden_domain' ), '<span class="comments-count" title="' . get_comments_number() . '">' . get_comments_number() . '</span>' ) . '</a></span>';
							}

						break;
						case 'date':

							if ( ! wm_option( 'blog-disable-date' ) )
								$out .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date meta-item" title="' . esc_attr( get_the_date() ) . '">' . esc_html( get_the_date() ) . '</time>';

						break;
						case 'date-special':

							if ( ! wm_option( 'blog-disable-date' ) )
								$out .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date meta-item" title="' . esc_attr( get_the_date() ) . '">
									<span class="month">' . get_the_time( 'M' ) . '</span>
									<span class="day">' . get_the_date( 'd' ) . '</span>
									<span class="year">' . get_the_time( 'Y' ) . '</span>
									<span class="time">' . get_the_time() . '</span>
									</time>';

						break;
						case 'formaticon':

							$newWindow        = '';
							$permalinkFormats = array( 'standard', 'audio', 'gallery', 'link', 'quote', 'status', 'video' );
							if ( 'link' === $format ) {
								$link      = ( wm_meta_option( 'link-url' ) ) ? ( esc_url( wm_meta_option( 'link-url' ) ) ) : ( '#' );
								$newWindow = ( wm_meta_option( 'link-target' ) ) ? ( ' target="_blank"' ) : ( null );
							} else {
								$link = get_permalink();
							}

							if ( ! wm_option( 'blog-disable-format' ) && in_array( $format, $permalinkFormats ) )
								$out .= '<span class="icon-format meta-item"><a href="' . $link . '"' . $newWindow . '><img src="' .  WM_ASSETS_THEME . 'img/icons/formats/white/icon-' . $format . '.png" alt="" /></a></span>';

						break;
						case 'tags':

							if ( ! wm_option( 'blog-disable-tags' ) )
								$out .= ( get_the_tag_list( '', '', '' ) ) ? ( '<span class="tags meta-item">' . sprintf( __( 'Tags: %s', 'clifden_domain' ), get_the_tag_list( '', ', ', '' ) ) . '</span>' ) : ( '' );

						break;
						case 'sharing':

							$out .= wm_social_share_buttons();

						break;
						default:
						break;
					} // /switch
				} // /foreach

				$out = ( $out ) ? ( '<' . $tag . ' class="meta-article clearfix ' . $class . '">' . $out . '</' . $tag . '>' ) : ( '' );
			} // /if $position

			if ( $print )
				echo apply_filters( 'wmhook_meta_html', $out );
			else
				return apply_filters( 'wmhook_meta_html', $out );
		}
	} // /wm_meta



	/*
	* Post/page parts pagination
	*/
	if ( ! function_exists( 'wm_post_parts' ) ) {
		function wm_post_parts() {
			wp_link_pages( array(
				'before'         => '<p class="pagination post">',
				'after'          => '</p>',
				'next_or_number' => 'number',
				'pagelink'       => '<span class="page-numbers">' . __( 'Part %', 'clifden_domain' ) . '</span>',
			) );
		}
	} // /wm_post_parts



	/*
	* Post author info
	*/
	if ( ! function_exists( 'wm_author_info' ) ) {
		function wm_author_info() {
			$authorDescription = get_the_author_meta( 'description' );

			if (
					$authorDescription &&
					is_single() &&
					'post' == get_post_type() &&
					! ( wm_meta_option( 'author' ) || wm_option( 'blog-disable-bio' ) )
				) {

				$authorDescription = explode( '<!--more-->', $authorDescription ); //allows using WordPress more tag to display short description on single posts and full info on author archives pages

				$authorName     = get_the_author_meta( 'display_name' );
				$authorWebsite  = ( get_the_author_meta( 'user_url' ) ) ? ( apply_filters( 'wmhook_authorbox_html_website', ' <small><a href="' . esc_url( get_the_author_meta( 'user_url' ) ) . '">' . __( "Visit author's website", 'clifden_domain' ) . '</a></small>' ) ) : ( '' );
				$authorPostsUrl = get_author_posts_url( get_the_author_meta( 'ID' ) );
				$authorAvatar   = get_avatar( get_the_author_meta( 'ID' ), 70 );

				$out = '<div class="bio meta-bottom clearfix">';
				$out .= '<div class="avatar-container"><a href="' . $authorPostsUrl . '">' . $authorAvatar . '</a></div><div class="author-details">';

				$outSocial = '';
				if ( get_the_author_meta( 'facebook' ) )
					$outSocial .= '[social url="' . esc_url( get_the_author_meta( 'facebook' ) ) . '" icon="Facebook" title="' . sprintf( __( '%s on Facebook', 'clifden_domain' ), $authorName ) . '" size="s"]';
				if ( get_the_author_meta( 'googleplus' ) )
					$outSocial .= '[social url="' . esc_url( get_the_author_meta( 'googleplus' ) ) . '" icon="Google+" title="' . sprintf( __( '%s on Google+', 'clifden_domain' ), $authorName ) . '" size="s" rel="me"]';
				if ( get_the_author_meta( 'twitter' ) )
					$outSocial .= '[social url="' . esc_url( get_the_author_meta( 'twitter' ) ) . '" icon="Twitter" title="' . sprintf( __( '%s on Twitter', 'clifden_domain' ), $authorName ) . '" size="s"]';

				$out .= '<h3 class="mt0"><small>' . apply_filters( 'wmhook_authorbox_text_by', __( 'By', 'clifden_domain' ) ) . '</small> <a href="' . $authorPostsUrl . '"><strong>' . $authorName . '</strong></a>';

				if ( $outSocial )
					$out .= '<span class="author-social-links">' . $outSocial . $authorWebsite . '</span>';

				$out .= '</h3>';

				$out .= '<div class="desc">' . do_shortcode( wptexturize( trim( $authorDescription[0] ) ) ) . '</div>';

				/*
				$out .= apply_filters( 'wmhook_authorbox_text_posts', '<h4>More from the author</h4>' );
				$out .= '<ul class="posts-by-author">';
					wp_reset_query();
					$queryArgs = array(
							'author'              => get_the_author_meta( 'ID' ),
							'posts_per_page'      => 3,
							'ignore_sticky_posts' => 1,
							'post__not_in'        => array( get_the_ID() )
						);
					$authorPosts = new WP_Query( $queryArgs );
					if ( $authorPosts->have_posts() ) {
						while ( $authorPosts->have_posts() ) {
							$authorPosts->the_post();
							$out .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
						}
					}
					wp_reset_query();
				$out .= '</ul>';
				*/

				$out .= ' <!-- /author-details --></div><!-- /bio --></div>';

				echo do_shortcode( $out );

			}
		}
	} // /wm_author_info



	/*
	* Prints no content found message
	*/
	if ( ! function_exists( 'wm_not_found' ) ) {
		function wm_not_found() {
			$out  = '<article class="not-found">';
			$out .= apply_filters( 'wmhook_not_fount_text', '<h2>' . __( 'No item found', 'clifden_domain' ) . '</h2>' );
			$out .= '</article>';

			echo $out;
		}
	} // /wm_not_found





/*
*****************************************************
*      14) OTHER FUNCTIONS
*****************************************************
*/
	/**
	* Use default WordPress content filters only
	*
	* Some plugins (such as JetPack) extend the "the_content" filters, causing issue when the filter is applied on different content sections of the website (such as excerpt...).
	* Use apply_filters( 'wm_default_content_filters', $content ) to prevent this.
	*/
	if ( ! function_exists( 'wm_default_content_filters' ) ) {
		function wm_default_content_filters( $content ) {
			return apply_filters( 'wmhook_content_default_filters', $content );
		}
	} // /wm_default_content_filters



	/*
	* Check WordPress version
	*
	* $version = #FLOAT ["3.1" - at least this version]
	*/
	if ( ! function_exists( 'wm_check_wp_version' ) ) {
		function wm_check_wp_version( $version = WM_WP_COMPATIBILITY ) {
			global $wp_version;

			return version_compare( floatval( $wp_version ), $version, '>=' );
		}
	} // /wm_check_wp_version



	/*
	* Prevent your email address from stealing (requires jQuery functions)
	*
	* $email  = TEXT [email address to encrypt]
	* $method = TEXT ["wp" encrypt method]
	*/
	if ( ! function_exists( 'wm_nospam' ) ) {
		function wm_nospam( $email, $method = null ) {
			if ( ! isset( $email ) || ! $email )
				return;

			if ( 'wp' == $method ) {
				$email = antispambot( $email );
			} else {
				$email = strrev( $email );
				$email = preg_replace( '[@]', ']ta[', $email );
				$email = preg_replace( '[\.]', '/', $email );
			}

			return $email;
		}
	} // /wm_nospam



	/*
	* CSS output minimizer
	*
	* $buffer = TEXT [code text to minimize]
	*/
	if ( ! function_exists( 'wm_minimize_css' ) ) {
		function wm_minimize_css( $buffer ) {
			$buffer = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer ); //remove css comments
			$buffer = str_replace( array( "\r\n", "\r", "\n", "\t", "  ", "    " ), '', $buffer ); //remove tabs, spaces, line breaks, etc.

			return $buffer;
		}
	} // /wm_minimize_css



	/*
	* Custom avatar
	*
	* $avatar_defaults = ARRAY [default WordPress gravatars array]
	*/
	if ( ! function_exists( 'wm_custom_avatar' ) ) {
		function wm_custom_avatar( $avatar_defaults ) {
			$customAvatar = WM_ASSETS_THEME . 'img/gravatar.gif';
			$avatar_defaults[$customAvatar] = get_bloginfo( 'name' );

			return $avatar_defaults;
		}
	} // /wm_custom_avatar



	/*
	* Get background CSS styles
	*
	* $optionBase = TEXT [wm_option base name (option full name minus function suffixes: bg-color, bg-img-url, bg-img-repeat, bg-img-attachment, bg-img-position, bg-pattern)]
	*/
	if ( ! function_exists( 'wm_css_background' ) ) {
		function wm_css_background( $optionBase = '' ) {
			$patternsSubfolder = 'img/patterns/';
			$patternFileFormat = '.png';

			//get background color
			$bgColor = ( wm_option( $optionBase . 'bg-color' ) ) ? ( '#' . wm_option( $optionBase . 'bg-color' ) ) : ( '' );

			//get background image
			if ( wm_option( $optionBase . 'bg-pattern' ) )
				$bgImg = ' url(' . esc_url( WM_ASSETS_THEME . $patternsSubfolder . wm_option( $optionBase . 'bg-pattern' ) . $patternFileFormat ) . ')';
			else
				$bgImg = ( wm_option( $optionBase . 'bg-img-url' ) ) ? ( ' url(' . esc_url( wm_option( $optionBase . 'bg-img-url' ) ) . ')' ) : ( '' );

			$bgImgRepeat     = ( wm_option( $optionBase . 'bg-img-repeat' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-repeat' ) ) : ( '' );
			$bgImgAttachment = ( wm_option( $optionBase . 'bg-img-attachment' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-attachment' ) ) : ( '' );
			$bgImgPosition   = ( wm_option( $optionBase . 'bg-img-position' ) ) ? ( ' ' . wm_option( $optionBase . 'bg-img-position' ) ) : ( '' );
			$bgImgParameters = $bgImgRepeat . $bgImgAttachment . $bgImgPosition;

			if ( wm_option( $optionBase . 'bg-pattern' ) )
				$bgImgParameters = ' repeat' . $bgImgAttachment;

			if ( $bgImg )
				$bgImg .= $bgImgParameters;

			if ( $bgColor || $bgImg )
				return ( $bgColor . $bgImg );
		}
	} // /wm_css_background



	/*
	* Get background CSS styles from post meta
	*
	* $optionBase = TEXT [wm_meta_option base name (option full name minus function suffixes: bg-color, bg-img-url, bg-img-repeat, bg-img-attachment, bg-img-position, bg-pattern)]
	*/
	if ( ! function_exists( 'wm_css_background_meta' ) ) {
		function wm_css_background_meta( $optionBase = '' ) {
			$patternsSubfolder = 'img/patterns/';
			$patternFileFormat = '.png';
			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

			//get background color
			$bgColor = ( wm_meta_option( $optionBase . 'bg-color', $postId ) ) ? ( '#' . wm_meta_option( $optionBase . 'bg-color', $postId ) ) : ( '' );

			//get background image
			if ( wm_meta_option( $optionBase . 'bg-pattern', $postId ) )
				$bgImg = ' url(' . esc_url( WM_ASSETS_THEME . $patternsSubfolder . wm_meta_option( $optionBase . 'bg-pattern', $postId ) . $patternFileFormat ) . ')';
			else
				$bgImg = ( wm_meta_option( $optionBase . 'bg-img-url', $postId ) ) ? ( ' url(' . esc_url( wm_meta_option( $optionBase . 'bg-img-url', $postId ) ) . ')' ) : ( '' );

			$bgImgRepeat     = ( wm_meta_option( $optionBase . 'bg-img-repeat', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-repeat', $postId ) ) : ( '' );
			$bgImgAttachment = ( wm_meta_option( $optionBase . 'bg-img-attachment', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-attachment', $postId ) ) : ( '' );
			$bgImgPosition   = ( wm_meta_option( $optionBase . 'bg-img-position', $postId ) ) ? ( ' ' . wm_meta_option( $optionBase . 'bg-img-position', $postId ) ) : ( '' );
			$bgImgParameters = $bgImgRepeat . $bgImgAttachment . $bgImgPosition;

			if ( wm_meta_option( $optionBase . 'bg-pattern', $postId ) )
				$bgImgParameters = ' repeat' . $bgImgAttachment;

			if ( $bgImg )
				$bgImg .= $bgImgParameters;

			if ( $bgColor || $bgImg )
				return ( $bgColor . $bgImg );
		}
	} // /wm_css_background_meta



	/*
	* Custom feed link
	*/
	if ( ! function_exists( 'wm_custom_feed' ) ) {
		function wm_custom_feed() {
			$customRSS = wm_option( 'social-feed-array' );

			if ( empty( $customRSS ) )
				return;

			if ( 1 < count( $customRSS ) )
				$i = 1;
			else
				$i = null;

			foreach ( $customRSS as $feed ) {
				$j = ( $i ) ? ( ' ' . $i ) : ( null );
				if ( is_array( $feed ) && ! empty( $feed ) && $feed['attr'] && $feed['val'] )
					echo '<link rel="alternate" type="' . $feed['attr'] . '" title="' . sprintf( __( '%s feed', 'clifden_domain' ), get_bloginfo( 'name' ) ) . $j . '" href="' . $feed['val'] . '" />' . "\r\n";
				$i++;
			}
		}
	} // /wm_custom_feed



	/*
	* Remove invalid HTML5 rel attribute
	*/
	if ( ! function_exists( 'wm_remove_rel' ) ) {
		function wm_remove_rel( $link ) {
			return ( str_replace ( 'rel="category tag"', '', $link ) );
		}
	} // /wm_remove_rel



	/*
	* Exclude post formats from feed
	*/
	if ( ! function_exists( 'wm_feed_exclude_post_formats' ) ) {
		function wm_feed_exclude_post_formats( &$wp_query ) {
			if ( $wp_query->is_feed() ) {

				//post formats to exclude by slug
				$formatsToExclude = array(
					'post-format-aside',
					'post-format-chat',
					'post-format-status'
					);

				//extra query to hack onto the $wp_query
				$extraQuery = array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => $formatsToExclude,
					'operator' => 'NOT IN'
					);

				$query = $wp_query->get( 'tax_query' );

				if ( is_array( $query ) )
					$query = $query + $extraQuery;
				else
					$query = array( $extraQuery );

				$wp_query->set( 'tax_query', $query );
			}
		}
	} // /wm_feed_exclude_post_formats



	/*
	* Include post types in feed
	*/
	if ( ! function_exists( 'wm_feed_include_post_types' ) ) {
		function wm_feed_include_post_types( $query ) {
			if ( isset( $query['feed'] ) && ! isset( $query['post_type'] ) )
				$query['post_type'] = array( 'post', 'wm_projects' );

			return $query;
		}
	} // /wm_feed_include_post_types



	/*
	* Color brightness detection
	*
	* $hex = HEX [color hex string (either ffffff or fff, without "#")]
	*/
	if ( ! function_exists( 'wm_color_brightness' ) ) {
		function wm_color_brightness( $hex ) {
			$hex = preg_replace( "/[^0-9A-Fa-f]/", '', $hex );
			$rgb = array();

			if ( 6 == strlen( $hex ) ) {

				$color    = hexdec( $hex );
				$rgb['r'] = 0xFF & ( $color >> 0x10 );
				$rgb['g'] = 0xFF & ( $color >> 0x8 );
				$rgb['b'] = 0xFF & $color;

			} elseif ( 3 == strlen( $hex ) ) { //if shorthand notation, need some string manipulations

				$rgb['r'] = hexdec( str_repeat( substr( $hex, 0, 1 ), 2 ) );
				$rgb['g'] = hexdec( str_repeat( substr( $hex, 1, 1 ), 2 ) );
				$rgb['b'] = hexdec( str_repeat( substr( $hex, 2, 1 ), 2 ) );

			} else {
				return;
			}

			$brightness = ( ( $rgb['r'] * 299 ) + ( $rgb['g'] * 587 ) + ( $rgb['b'] * 114 ) ) / 1000; //returns value from 0 to 255

			return $brightness;
		}
	} // /wm_color_brightness



	/*
	* Social share buttons
	*/
	if ( ! function_exists( 'wm_social_share_buttons' ) ) {
		function wm_social_share_buttons() {
			if ( ! is_singular() || wm_meta_option( 'no-sharing' ) )
				return;

			$out = '';

			if ( wm_option( 'social-share-facebook' ) )
				$out .= '<div class="share-button facebook"><div class="fb-like" data-href="' . get_permalink() . '" data-send="false" data-layout="button_count" data-width="80" data-show-faces="true"></div></div>';

			if ( wm_option( 'social-share-twitter' ) )
				$out .= '<div class="share-button twitter"><a href="https://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink() . '">Tweet</a></div>';

			if ( wm_option( 'social-share-googleplus' ) )
				$out .= '<div class="share-button googleplus"><div class="g-plusone" data-size="medium" data-href="' . get_permalink() . '"></div></div>';

			if ( wm_option( 'social-share-pinterest' ) ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'mobile' );
				$out .= '<div class="share-button pinterest"><a href="http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&media=' . urlencode( $image[0] ) . '&description=' . urlencode( get_the_excerpt() ) . '" class="pin-it-button" count-layout="horizontal" target="_blank"><img src="//assets.pinterest.com/images/PinExt.png" title="Pin It" alt="" /></a></div>';
			}

			if ( $out )
				return '<div class="social-share">' . $out . '</div>';
		}
	} // /wm_social_share_buttons



	/*
	* Get post attachments list (except images)
	*/
	if ( ! function_exists( 'wm_post_attachments' ) ) {
		function wm_post_attachments() {
			global $post;

			if ( ! is_singular() )
				return;

			$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( $post->ID );

			if ( ! wm_meta_option( 'attachments-list', $postId ) )
				return;

			$out = '';

			$args = array(
					'post_type'      => 'attachment',
					'post_mime_type' => 'application,audio,video',
					'numberposts'    => -1,
					'post_status'    => null,
					'post_parent'    => $postId,
					'orderby'        => 'menu_order',
					'order'          => 'ASC'
				);

			$attachments = get_posts( $args );

			if ( $attachments ) {
				foreach ( $attachments as $attachment ) {
					$out .= '<li class="attachment mime-' . sanitize_title( $attachment->post_mime_type ) . '"><a href="' . wp_get_attachment_url( $attachment->ID ) . '" title="' . $attachment->post_title . '">' . $attachment->post_title . '</a></li>';
				}
				$out = '<div class="list-attachments meta-bottom"><ul class="download">' . $out . '</ul></div>';
			}

			echo $out;
		}
	} // /wm_post_attachments



	/*
	* Search form (needs to be function to maintain return output of get_search_form())
	*/
	if ( ! function_exists( 'wm_search_form' ) ) {
		function wm_search_form( $form ) {
			$form = '
				<form method="get" class="form-search" action="' . home_url( '/' ) . '">
				<fieldset>
					<label class="assistive-text invisible">' . __( 'Search for:', 'clifden_domain' ) . '</label>
					<input type="text" class="text" name="s" placeholder="' . wm_option( 'general-search-placeholder' ) . '" />
					<input type="submit" class="submit" value="' . __( 'Submit', 'clifden_domain' ) . '" />
				</fieldset>
				</form>
				';

			return $form;
		}
	} // /wm_search_form



	/*
	* HTML (basic) in widget titles
	*/
	if ( ! function_exists( 'wm_html_widget_title' ) ) {
		function wm_html_widget_title( $title ) {

			$replaceArray = array(
				//HTML tag opening/closing brackets
				'['  => '<',
				'[/' => '</',
				//<strong></strong>
				's]' => 'strong>',
				//<em></em>
				'e]' => 'em>',
			);
			$title = strtr( $title, $replaceArray );

			return $title;
		}
	} // /wm_html_widget_title



	/*
	* Can user view the page?
	*
	* Outputs TRUE or FALSE
	*/
	if ( ! function_exists( 'wm_restriction_page' ) ) {
		function wm_restriction_page( $pageId = null ) {
			$restriction = wm_meta_option( 'restrict-access', $pageId );
			$noGroup     = ! stripos( $restriction, 'roup-' );
			$capability  = str_replace( 'group-', '', $restriction );

			if ( $restriction ) {

				if ( ! is_user_logged_in() ) {
					//no user logged in
					$display = false;
				} else {
					global $user_login;
					get_currentuserinfo();

					//user logged in
					if ( $noGroup && -1 !== $restriction && $user_login === $restriction )
						//specific user logged in
						$display = true;
					elseif ( $noGroup && -1 === $restriction )
						//any logged in user
						$display = true;
					elseif ( ! $noGroup && $restriction && @current_user_can( $capability ) )
						//user group allowed
						$display = true;
					else
						//otherwise restrict
						$display = false;
				}

				return $display;

			} else {

				return true;

			}
		}
	} // /wm_restriction_page



	/*
	* Remove "recent comments" <style> from HTML head
	*/
	if ( ! function_exists( 'wm_remove_recent_comments_style' ) ) {
		function wm_remove_recent_comments_style( $pageId = null ) {
			global $wp_widget_factory;
			remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
		}
	} // /wm_remove_recent_comments_style



	/*
	* Remove restricted pages from search results
	*/
	if ( ! function_exists( 'wm_search_filter' ) ) {
		function wm_search_filter( $query ) {
			if ( $query->is_search ) {
				$removePages = array();

				$pages = get_pages();
				foreach ( $pages as $page ) {
					if ( wm_meta_option( 'restrict-access', $page->ID ) )
						$removePages[] = $page->ID;
				}

				$query->set( 'post__not_in', $removePages );
			}
			return $query;
		}
	} // /wm_search_filter



	/**
	 * Remove shortcodes from string
	 *
	 * This function keeps the text between shortcodes,
	 * unlike WordPress native strip_shortcodes() function.
	 *
	 * @param  string $content
	 */
	if ( ! function_exists( 'wm_remove_shortcodes' ) ) {
		function wm_remove_shortcodes( $content ) {
			return apply_filters( 'wmhook_wm_remove_shortcodes_output', preg_replace( '|\[(.+?)\]|s', '', $content ) );
		}
	} // /wm_remove_shortcodes

?>