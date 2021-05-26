<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by WebMan - www.webmandesign.eu
*
* CSS stylesheet generator
*****************************************************
*/

	//include WP core
		require_once '../../../../../wp-load.php';





/*
*****************************************************
*      OUTPUT
*****************************************************
*/

	$out = '';

	ob_start(); //This function will turn output buffering on. While output buffering is active no output is sent from the script (other than headers), instead the output is stored in an internal buffer.



	$themeSkin   = ( wm_option( 'design-skin' ) ) ? ( wm_option( 'design-skin' ) ) : ( 'default.css' );
	$layoutWidth = ( wm_option( 'layout-width' ) ) ? ( wm_option( 'layout-width' ) ) : ( 'r930' );

	//Start including files and editing output
		@readfile( 'normalize.css' );
		@readfile( 'core.css' );
		@readfile( 'columns-content.css' );
		@readfile( 'columns-' . $layoutWidth . '.css' );
		@readfile( 'wp-styles.css' );
		@readfile( 'forms.css' );
		@readfile( 'typography.css' );
		@readfile( 'icons.css' );
		@readfile( 'header.css' );
		@readfile( 'slider.css' );
		@readfile( 'content.css' );
		@readfile( 'comments.css' );
		@readfile( 'sidebar.css' );
		@readfile( 'footer.css' );
		@readfile( 'shortcodes.css' );
		@readfile( 'borders.css' );
		@readfile( 'skins/' . $themeSkin );
		if ( 'r930' === $layoutWidth || 'r1160' === $layoutWidth )
			@readfile( 'responsive.css' );
		@readfile( get_stylesheet_directory() . '/style.css' );

	//Stop including files and editing output
		$out = ob_get_clean(); //output and clean the buffer





/*
*****************************************************
*      CUSTOM STYLES FROM ADMIN PANEL
*****************************************************
*/

	/*
	* Compare skin and default elements returning CSS selectors string
	*
	* $skin    = STRING [string of elements from theme skin (every element must be prepended with - or +)]
	* $default = ARRAY [array of default theme elements to compare]
	*/
	if ( ! function_exists( 'wm_compare_elements' ) ) {
		function wm_compare_elements( $skin = '', $default = array() ) {
			$output = '';

			//make the skin elements array
			$skin      = array_filter( explode( ', ', $skin ) );
			$separator = ( ! empty( $default ) ) ? ( ', ' ) : ( '' );

			if ( ! empty( $skin ) ) {
			//if skin elements defined

				$default = array_flip( $default ); //prepare array for removing items

				foreach ( $skin as $value ) {
					$action = substr( $value, 0, 1 ); //whether to subtract (-) or add (+) elements

					if ( '-' == $action )
						unset( $default[substr( $value, 1 )] );
					else
						$output .= substr( $value, 1 ) . $separator;
				}

				$output .= implode( ', ', array_flip( $default ) );

			} else {
			//if skin elements not defined, use default theme elements

				$output .= implode( ', ', $default );

			}

			return $output;
		}
	} // /wm_compare_elements



	// E in variable names below stands for "Elements", BE stands for "BorderedElements"
	//fonts
		$themePrimaryFontE   = array( '.font-primary', '.logo', 'h1.logo', 'body', '.quote-source', 'input', 'select', 'textarea', 'a.btn', 'button', 'input[type="button"]', 'input[type="submit"]' );
		$themeSecondaryFontE = array( '.font-secondary', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', '.hero', '.call-to-action', 'blockquote', '.status', '#countdown-timer .dash .digit', '.numbering', '.article-excerpt', '.date-special .date .day', '.wrap-projects-shortcode .project-title', '.wrap-projects-shortcode .project-title', '.main-heading h2.h1-style' );
		$themeTerciaryFontE  = array( '.main-heading h1 + h2', '.main-heading .h1-style + h2', '.size-huge' );

		$primaryFontE   = wm_compare_elements( wm_skin_meta( $themeSkin, 'font-primary-tags' ), $themePrimaryFontE );
		$secondaryFontE = wm_compare_elements( wm_skin_meta( $themeSkin, 'font-secondary-tags' ), $themeSecondaryFontE );
		$terciaryFontE  = wm_compare_elements( wm_skin_meta( $themeSkin, 'font-terciary-tags' ), $themeTerciaryFontE );

	//borders
		/* anywhere bordered elements (from borders.css):
		'.bb1',
		'.accordion-wrapper > ul', '.accordion-heading', '.toggle-heading', '.accordion-content', '.toggle-content',
		'.divider',
		'.frame',
		'blockquote.left-border',
		'.wrap-staff-shortcode .staff-excerpt ul',
		'.tabs-wrapper ul.tabs li', '.tabs-wrapper .tabs + ul > li',
		'.tour-nav',
		'.widget li ul', '.widget li > a', '.widget_nav_menu .inner',
		'.widget_archive ul li', '.widget_categories ul li', '.widget_links ul li', '.widget_recent_comments ul li',
		'.wm-status .status-post + .status-post',
		'.wm-twitter .user-info',
		'.wm-post-list ul li',
		'.wm-projects-list article'
		*/
		$themeToppanelBE    = array();
		$themeHeaderBE      = array();
		$themeNavigationBE  = array();
		$themeSliderBE      = array(
			'.map-section',
			'.divider'
			);
		$themeMainheadingBE = array();
		$themePageexcerptBE = array(
			/* alocatable border elements */
			'.page-excerpt .bb1',
			'.page-excerpt .accordion-wrapper > ul', '.page-excerpt .accordion-heading', '.page-excerpt .toggle-heading', '.page-excerpt .accordion-content', '.page-excerpt .toggle-content',
			'.page-excerpt .divider',
			'.page-excerpt .frame',
			'.page-excerpt blockquote.left-border',
			'.page-excerpt .wrap-staff-shortcode .staff-excerpt ul',
			'.page-excerpt .tabs-wrapper ul.tabs li', '.page-excerpt .tabs-wrapper .tabs + ul > li',
			'.page-excerpt .tour-nav',
			'.page-excerpt .widget li ul', '.page-excerpt .widget li > a', '.page-excerpt .widget_nav_menu .inner',
			'.page-excerpt .widget_archive ul li', '.page-excerpt .widget_categories ul li', '.page-excerpt .widget_links ul li', '.page-excerpt .widget_recent_comments ul li',
			'.page-excerpt .wm-status .status-post + .status-post',
			'.page-excerpt .wm-twitter .user-info',
			'.page-excerpt .wm-post-list ul li',
			'.page-excerpt .wm-projects-list article'
			);
		$themeContentBE     = array(
			/* article meta info */
			'.meta-bottom', '#comments', '#content .main .sharedaddy', '.project-sharing',
			/* articles list */
			'.list-articles article',
			/* attributes */
			'.attributes ul', '.attributes ul li',
			/* author info */
			'.bio .author-social-links',
			/* comments */
			'.comment-heading', '.comment-reply-link', '.comment-edit-link',
			/* image captions */
			'.wp-caption figure',
			/* related projects */
			'.related-projects',
			/* sidebar */
			'.sidebar .widget:before',
			/* alocatable border elements */
			'.content .bb1',
			'.content .accordion-wrapper > ul', '.content .accordion-heading', '.content .toggle-heading', '.content .accordion-content', '.content .toggle-content',
			'.content .divider',
			'.content .frame',
			'.content blockquote.left-border',
			'.content .wrap-staff-shortcode .staff-excerpt ul',
			'.content .tabs-wrapper ul.tabs li', '.content .tabs-wrapper .tabs + ul > li',
			'.content .tour-nav',
			'.content .widget li ul', '.content .widget li > a', '.content .widget_nav_menu .inner',
			'.content .widget_archive ul li', '.content .widget_categories ul li', '.content .widget_links ul li', '.content .widget_recent_comments ul li',
			'.content .wm-status .status-post + .status-post',
			'.content .wm-twitter .user-info',
			'.content .wm-post-list ul li',
			'.content .wm-projects-list article'
			);
		$themeAbovefooterBE = array(
			/* alocatable border elements */
			'.above-footer-widgets-wrap .bb1',
			'.above-footer-widgets-wrap .accordion-wrapper > ul', '.above-footer-widgets-wrap .accordion-heading', '.above-footer-widgets-wrap .toggle-heading', '.above-footer-widgets-wrap .accordion-content', '.above-footer-widgets-wrap .toggle-content',
			'.above-footer-widgets-wrap .divider',
			'.above-footer-widgets-wrap .frame',
			'.above-footer-widgets-wrap blockquote.left-border',
			'.above-footer-widgets-wrap .wrap-staff-shortcode .staff-excerpt ul',
			'.above-footer-widgets-wrap .tabs-wrapper ul.tabs li', '.above-footer-widgets-wrap .tabs-wrapper .tabs + ul > li',
			'.above-footer-widgets-wrap .tour-nav',
			'.above-footer-widgets-wrap .widget li ul', '.above-footer-widgets-wrap .widget li > a', '.above-footer-widgets-wrap .widget_nav_menu .inner',
			'.above-footer-widgets-wrap .widget_archive ul li', '.above-footer-widgets-wrap .widget_categories ul li', '.above-footer-widgets-wrap .widget_links ul li', '.above-footer-widgets-wrap .widget_recent_comments ul li',
			'.above-footer-widgets-wrap .wm-status .status-post + .status-post',
			'.above-footer-widgets-wrap .wm-twitter .user-info',
			'.above-footer-widgets-wrap .wm-post-list ul li',
			'.above-footer-widgets-wrap .wm-projects-list article'
			);
		$themeBreadcrumbsBE = array();
		$themeFooterBE      = array(
			/* alocatable border elements */
			'.footer .bb1',
			'.footer .accordion-wrapper > ul', '.footer .accordion-heading', '.footer .toggle-heading', '.footer .accordion-content', '.footer .toggle-content',
			'.footer .divider',
			'.footer .frame',
			'.footer blockquote.left-border',
			'.footer .wrap-staff-shortcode .staff-excerpt ul',
			'.footer .tabs-wrapper ul.tabs li', '.footer .tabs-wrapper .tabs + ul > li',
			'.footer .tour-nav',
			'.footer .widget li ul', '.footer .widget li > a', '.footer .widget_nav_menu .inner',
			'.footer .widget_archive ul li', '.footer .widget_categories ul li', '.footer .widget_links ul li', '.footer .widget_recent_comments ul li',
			'.footer .wm-status .status-post + .status-post',
			'.footer .wm-twitter .user-info',
			'.footer .wm-post-list ul li',
			'.footer .wm-projects-list article'
			);
		$themeBottomBE      = array();

		$toppanelBE    = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-toppanel' ), $themeToppanelBE );
		$headerBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-header' ), $themeHeaderBE );
		$navigationBE  = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-navigation' ), $themeNavigationBE );
		$sliderBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-slider' ), $themeSliderBE );
		$mainheadingBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-mainheading' ), $themeMainheadingBE );
		$pageexcerptBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-pageexcerpt' ), $themePageexcerptBE );
		$contentBE     = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-content' ), $themeContentBE );
		$abovefooterBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-abovefooter' ), $themeAbovefooterBE );
		$breadcrumbsBE = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-breadcrumbs' ), $themeBreadcrumbsBE );
		$footerBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-footer' ), $themeFooterBE );
		$bottomBE      = wm_compare_elements( wm_skin_meta( $themeSkin, 'border-bottom' ), $themeBottomBE );

	//subnavigation border and hover overlay
		if ( wm_option( 'design-subnavigation-bg-color' ) )
			$subnavBorder = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-subnavigation-bg-color' ) ) ) ? ( 'url(../img/transparent/white/5.png)' ) : ( 'url(../img/transparent/black/5.png)' );
		else
			$subnavBorder = '';

		if ( wm_option( 'design-toppanel-bg-color' ) )
			$topbarSubnavBorder = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-toppanel-bg-color' ) ) ) ? ( 'url(../img/transparent/white/5.png)' ) : ( 'url(../img/transparent/black/5.png)' );
		else
			$topbarSubnavBorder = '';



	//Array of custom styles from admin panel
		$customStyles = array(

			/* link color */
				//basic link color (mainly applied in content area)
					array(
						'selector' => 'a, a:hover, .pagination a, .pagination span',
						'styles' => array(
							'color' => wm_option( 'design-link-color', 'color' ),
							)
					),
					array(
						'selector' => '.pagination .prev, .pagination .next, .wrap-projects-shortcode .wrap-filter li',
						'styles' => array(
							'border-color' => wm_option( 'design-link-color', 'color' ),
							)
					),

				//default buttons
					array(
						'selector' => 'a.btn, .nav-main .btn, button, input[type="button"], input[type="submit"]',
						'styles' => array(
							'background-color' => wm_option( 'design-link-color', 'color' ),
							'color' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-link-color' ) ) ) ? ( '#eee' ) : ( '#111' ), // IE8 fallback
							'color' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-link-color' ) ) ) ? ( 'rgba(255,255,255, 0.9)' ) : ( 'rgba(0,0,0, 0.9)' ),
							'border-color' => wm_option( 'design-link-color', 'color' ),
							)
					),

				//text selection
					array(
						'selector' => '::-moz-selection',
						'styles' => array(
							'background-color' => wm_option( 'design-link-color', 'color' ),
							'color' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-link-color' ) ) ) ? ( '#fff' ) : ( '#000' ),
						)
					),
					array(
						'selector' => '::selection',
						'styles' => array(
							'background' => wm_option( 'design-link-color', 'color' ),
							'color' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-link-color' ) ) ) ? ( '#fff' ) : ( '#000' ),
						)
					),

				//project overlay color
					array(
						'selector' => '.wrap-projects-shortcode .image-container, .related-projects .image-container, .wrap-projects-shortcode .project-icon',
						'styles' => array(
							'background-color' => wm_option( 'design-link-color', 'color' ),
							)
					),




			/* backgrounds and colors */
				array(
					'selector' => '\r\n' //new linebreak
				),

				//html and body
					array(
						'selector' => 'html',
						'styles' => array(
							'background-color' => ( wm_option( 'design-html-bg-color', 'color' ) && ! ( wm_option( 'design-html-bg-img-url' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_option( 'design-html-bg-color', 'color' ) ) : ( null ),
							'background' => ( ( wm_option( 'design-html-bg-img-url' ) || wm_option( 'design-html-bg-pattern' ) ) ) ? ( wm_css_background( 'design-html-' ) ) : ( null ),
						)
					),
					array(
						'selector' => 'body',
						'styles' => array(
							'background' => ( ( wm_option( 'design-body-bg-img-url' ) || wm_option( 'design-body-bg-pattern' ) ) ) ? ( wm_css_background( 'design-body-' ) ) : ( null ),
						)
					),

				//main wrap - only for boxed layout
					array(
						'selector' => '#wrap, .top-bar li ul',
						'styles' => array(
							'background' => wm_css_background( 'design-mainwrap-' ),
						)
					),

				//top panel
					array(
						'selector' => '.top-bar, .top-bar .widget li ul',
						'styles' => array(
							'background' => wm_css_background( 'design-toppanel-' ),
							'color' => wm_option( 'design-toppanel-color', 'color' ),
						)
					),
					array(
						'selector' => '.top-bar a, .top-bar .widget li li a',
						'styles' => array(
							'color' => wm_option( 'design-toppanel-link-color', 'color' ),
						)
					),
					array(
						'selector' => $toppanelBE,
						'styles' => array(
							'border-color' => wm_option( 'design-toppanel-border-color', 'color !important' ),
						)
					),
					array(
						'selector' => '.top-bar .widget li li, .top-bar .widget li li a:hover, .top-bar .widget li li.current-menu-ancestor > a, .top-bar .widget li li.current-menu-item > a',
						'styles' => array(
							'background-image' => $topbarSubnavBorder,
						)
					),

				//header
					array(
						'selector' => '.header',
						'styles' => array(
							'background' => wm_css_background( 'design-header-' ),
						)
					),
					array(
						'selector' => '.header, .logo .description, .header h1, .header h2, .header h3, .header h4, .header h5, .header h6',
						'styles' => array(
							'color' => wm_option( 'design-header-color', 'color' ),
						)
					),
					array(
						'selector' => $headerBE,
						'styles' => array(
							'border-color' => wm_option( 'design-header-border-color', 'color !important' ),
						)
					),

				//navigation
					array(
						'selector' => '.navigation-wrap',
						'styles' => array(
							'background' => wm_css_background( 'design-navigation-' ),
						)
					),
					array(
						'selector' => '.nav-main, .nav-main a.normal small, .nav-main .inner.normal small',
						'styles' => array(
							'color' => wm_option( 'design-navigation-color', 'color' ),
						)
					),
					array(
						'selector' => '.nav-main li ul',
						'styles' => array(
							'background' => wm_css_background( 'design-subnavigation-' ),
							'color' => wm_option( 'design-subnavigation-color', 'color' ),
						)
					),
					array(
						'selector' => '.header .nav-main li li, .nav-main li li a:hover, .nav-main li li.current-menu-ancestor > a, .nav-main li li.current-menu-item > a',
						'styles' => array(
							'background-image' => $subnavBorder,
						)
					),
					array(
						'selector' => $navigationBE,
						'styles' => array(
							'border-color' => wm_option( 'design-navigation-border-color', 'color !important' ),
						)
					),

				//slider
					array(
						'selector' => '.slider-main-wrap',
						'styles' => array(
							'background' => wm_css_background( 'design-slider-' ),
							'color' => wm_option( 'design-slider-color', 'color' ),
						)
					),
					array(
						'selector' => $sliderBE,
						'styles' => array(
							'border-color' => wm_option( 'design-slider-border-color', 'color !important' ),
						)
					),

				//main heading
					array(
						'selector' => '.main-heading',
						'styles' => array(
							'background' => wm_css_background( 'design-mainheading-' ),
						)
					),
					array(
						'selector' => '.main-heading, .main-heading h1, .main-heading h2.h1-style, .main-heading h2',
						'styles' => array(
							'color' => wm_option( 'design-mainheading-color', 'color' ),
						)
					),
					array(
						'selector' => '.main-heading h2',
						'styles' => array(
							'color' => wm_option( 'design-mainheading-alt-color', 'color' ),
						)
					),
					array(
						'selector' => '.main-heading a',
						'styles' => array(
							'color' => wm_option( 'design-mainheading-link-color', 'color' ),
						)
					),
					array(
						'selector' => $mainheadingBE,
						'styles' => array(
							'border-color' => wm_option( 'design-mainheading-border-color', 'color !important' ),
						)
					),

				//page excerpt
					array(
						'selector' => '.page-excerpt, .countdown-timer-wrap',
						'styles' => array(
							'background' => wm_css_background( 'design-pageexcerpt-' ),
						)
					),
					array(
						'selector' => '.page-excerpt, .countdown-timer-wrap',
						'styles' => array(
							'color' => wm_option( 'design-pageexcerpt-color', 'color' ),
						)
					),
					array(
						'selector' => '.page-excerpt h1, .page-excerpt h2, .page-excerpt h3, .page-excerpt h4, .page-excerpt h5, .page-excerpt h6, .page-excerpt .size-big, .page-excerpt .size-huge, .countdown-timer-wrap h1, .countdown-timer-wrap h2, .countdown-timer-wrap h3, .countdown-timer-wrap h4, .countdown-timer-wrap h5, .countdown-timer-wrap h6, .countdown-timer-wrap .size-big, .countdown-timer-wrap .size-huge',
						'styles' => array(
							'color' => ( wm_option( 'design-pageexcerpt-alt-color' ) ) ? ( wm_option( 'design-pageexcerpt-alt-color', 'color' ) ) : ( wm_option( 'design-pageexcerpt-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.page-excerpt a, .countdown-timer-wrap a',
						'styles' => array(
							'color' => wm_option( 'design-pageexcerpt-link-color', 'color' ),
						)
					),
					array(
						'selector' => $pageexcerptBE,
						'styles' => array(
							'border-color' => wm_option( 'design-pageexcerpt-border-color', 'color !important' ),
						)
					),

				//content
					array(
						'selector' => '.content',
						'styles' => array(
							'background' => wm_css_background( 'design-content-' ),
							'color' => wm_option( 'design-content-color', 'color' ),
						)
					),
					array(
						'selector' => '.content .box.no-background',
						'styles' => array(
							'color' => wm_option( 'design-content-color', 'color !important' ),
						)
					),
					array(
						'selector' => '.content h1, .content h2, .content h3, .content h4, .content h5, .content h6, .content .size-big, .content .size-huge',
						'styles' => array(
							'color' => ( wm_option( 'design-content-alt-color' ) ) ? ( wm_option( 'design-content-alt-color', 'color' ) ) : ( wm_option( 'design-content-color', 'color' ) ),
						)
					),
					array(
						'selector' => $contentBE,
						'styles' => array(
							'border-color' => wm_option( 'design-content-border-color', 'color !important' ),
						)
					),

				//above footer
					array(
						'selector' => '.above-footer-widgets-wrap',
						'styles' => array(
							'background' => wm_css_background( 'design-abovefooter-' ),
							'color' => wm_option( 'design-abovefooter-color', 'color' ),
						)
					),
					array(
						'selector' => '.above-footer-widgets-wrap h1, .above-footer-widgets-wrap h2, .above-footer-widgets-wrap h3, .above-footer-widgets-wrap h4, .above-footer-widgets-wrap h5, .above-footer-widgets-wrap h6, .above-footer-widgets-wrap .size-big, .above-footer-widgets-wrap .size-huge',
						'styles' => array(
							'color' => ( wm_option( 'design-abovefooter-alt-color' ) ) ? ( wm_option( 'design-abovefooter-alt-color', 'color' ) ) : ( wm_option( 'design-abovefooter-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.above-footer-widgets-wrap a',
						'styles' => array(
							'color' => wm_option( 'design-abovefooter-link-color', 'color' ),
						)
					),
					array(
						'selector' => $abovefooterBE,
						'styles' => array(
							'border-color' => wm_option( 'design-abovefooter-border-color', 'color !important' ),
						)
					),

				//breadcrumbs
					array(
						'selector' => '.breadcrumbs',
						'styles' => array(
							'background' => wm_css_background( 'design-breadcrumbs-' ),
							'color' => wm_option( 'design-breadcrumbs-color', 'color' ),
						)
					),
					array(
						'selector' => '.breadcrumbs a',
						'styles' => array(
							'color' => wm_option( 'design-breadcrumbs-link-color', 'color' ),
						)
					),
					array(
						'selector' => $breadcrumbsBE,
						'styles' => array(
							'border-color' => wm_option( 'design-breadcrumbs-border-color', 'color !important' ),
						)
					),

				//footer
					array(
						'selector' => '.footer',
						'styles' => array(
							'background' => wm_css_background( 'design-footer-' ),
							'color' => wm_option( 'design-footer-color', 'color' ),
						)
					),
					array(
						'selector' => '.footer h1, .footer h2, .footer h3, .footer h4, .footer h5, .footer h6, .footer .size-big, .footer .size-huge',
						'styles' => array(
							'color' => ( wm_option( 'design-footer-alt-color' ) ) ? ( wm_option( 'design-footer-alt-color', 'color' ) ) : ( wm_option( 'design-footer-color', 'color' ) ),
						)
					),
					array(
						'selector' => '.footer a',
						'styles' => array(
							'color' => wm_option( 'design-footer-link-color', 'color' ),
						)
					),
					array(
						'selector' => $footerBE,
						'styles' => array(
							'border-color' => wm_option( 'design-footer-border-color', 'color !important' ),
						)
					),

				//bottom panel - credits
					array(
						'selector' => '.bottom-wrap',
						'styles' => array(
							'background' => wm_css_background( 'design-bottom-' ),
							'color' => wm_option( 'design-bottom-color', 'color' ),
						)
					),
					array(
						'selector' => '.bottom-wrap a',
						'styles' => array(
							'color' => wm_option( 'design-bottom-link-color', 'color' ),
						)
					),
					array(
						'selector' => $bottomBE,
						'styles' => array(
							'border-color' => wm_option( 'design-bottom-border-color', 'color !important' ),
						)
					),

				//predefined colors for colored elements - blue, gray, green, orange, red
					//blue
						array(
							'selector' => '.box.color-blue, .btn.color-blue, .call-to-action.color-blue, .marker.color-blue',
							'styles' => array(
								'background-color' => wm_option( 'design-type-blue-bg-color', 'color' ),
								'color' => wm_option( 'design-type-blue-color', 'color' ),
								'text-shadow' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-blue-color' ) ) ) ? ( '0 1px rgba(255,255,255, 0.5)' ) : ( '0 -1px rgba(0,0,0, 0.5)' ),
							)
						),
							array(
								'selector' => '.box.color-blue, .btn.color-blue',
								'styles' => array(
									'border-color' => wm_option( 'design-type-blue-bg-color', 'color' ),
								)
							),
							array(
								'selector' => '.box.color-blue.icon-box',
								'styles' => array(
									'background-image' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-blue-bg-color' ) ) ) ? ( 'url(../img/icons/box/white/box-icon-sprite.png)' ) : ( 'url(../img/icons/box/black/box-icon-sprite.png)' ),
								)
							),

					//gray
						array(
							'selector' => '.box.color-gray, .btn.color-gray, .call-to-action.color-gray, .marker.color-gray',
							'styles' => array(
								'background-color' => wm_option( 'design-type-gray-bg-color', 'color' ),
								'color' => wm_option( 'design-type-gray-color', 'color' ),
								'text-shadow' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-gray-color' ) ) ) ? ( '0 1px rgba(255,255,255, 0.5)' ) : ( '0 -1px rgba(0,0,0, 0.5)' ),
							)
						),
							array(
								'selector' => '.box.color-gray, .btn.color-gray',
								'styles' => array(
									'border-color' => wm_option( 'design-type-gray-bg-color', 'color' ),
								)
							),
							array(
								'selector' => '.box.color-gray.icon-box',
								'styles' => array(
									'background-image' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-gray-bg-color' ) ) ) ? ( 'url(../img/icons/box/white/box-icon-sprite.png)' ) : ( 'url(../img/icons/box/black/box-icon-sprite.png)' ),
								)
							),

					//green
						array(
							'selector' => '.box.color-green, .btn.color-green, .call-to-action.color-green, .marker.color-green',
							'styles' => array(
								'background-color' => wm_option( 'design-type-green-bg-color', 'color' ),
								'color' => wm_option( 'design-type-green-color', 'color' ),
								'text-shadow' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-green-color' ) ) ) ? ( '0 1px rgba(255,255,255, 0.5)' ) : ( '0 -1px rgba(0,0,0, 0.5)' ),
							)
						),
							array(
								'selector' => '.box.color-green, .btn.color-green',
								'styles' => array(
									'border-color' => wm_option( 'design-type-green-bg-color', 'color' ),
								)
							),
							array(
								'selector' => '.box.color-green.icon-box',
								'styles' => array(
									'background-image' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-green-bg-color' ) ) ) ? ( 'url(../img/icons/box/white/box-icon-sprite.png)' ) : ( 'url(../img/icons/box/black/box-icon-sprite.png)' ),
								)
							),

					//orange
						array(
							'selector' => '.box.color-orange, .btn.color-orange, .call-to-action.color-orange, .marker.color-orange',
							'styles' => array(
								'background-color' => wm_option( 'design-type-orange-bg-color', 'color' ),
								'color' => wm_option( 'design-type-orange-color', 'color' ),
								'text-shadow' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-orange-color' ) ) ) ? ( '0 1px rgba(255,255,255, 0.5)' ) : ( '0 -1px rgba(0,0,0, 0.5)' ),
							)
						),
							array(
								'selector' => '.box.color-orange, .btn.color-orange',
								'styles' => array(
									'border-color' => wm_option( 'design-type-orange-bg-color', 'color' ),
								)
							),
							array(
								'selector' => '.box.color-orange.icon-box',
								'styles' => array(
									'background-image' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-orange-bg-color' ) ) ) ? ( 'url(../img/icons/box/white/box-icon-sprite.png)' ) : ( 'url(../img/icons/box/black/box-icon-sprite.png)' ),
								)
							),

					//red
						array(
							'selector' => '.box.color-red, .btn.color-red, .call-to-action.color-red, .marker.color-red',
							'styles' => array(
								'background-color' => wm_option( 'design-type-red-bg-color', 'color' ),
								'color' => wm_option( 'design-type-red-color', 'color' ),
								'text-shadow' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-red-color' ) ) ) ? ( '0 1px rgba(255,255,255, 0.5)' ) : ( '0 -1px rgba(0,0,0, 0.5)' ),
							)
						),
							array(
								'selector' => '.box.color-red, .btn.color-red',
								'styles' => array(
									'border-color' => wm_option( 'design-type-red-bg-color', 'color' ),
								)
							),
							array(
								'selector' => '.box.color-red.icon-box',
								'styles' => array(
									'background-image' => ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-type-red-bg-color' ) ) ) ? ( 'url(../img/icons/box/white/box-icon-sprite.png)' ) : ( 'url(../img/icons/box/black/box-icon-sprite.png)' ),
								)
							),



			/* paddings and heights */
				array(
					'selector' => '\r\n' //new linebreak
				),
				array(
					'selector' => '.header > .wrap-inner',
					'styles' => array(
						'height' => ( wm_option( 'design-header-height' ) ) ? ( absint( wm_option( 'design-header-height' ) ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => '.logo, h1.logo',
					'styles' => array(
						'padding-top' => ( -1 < intval( wm_option( 'branding-logo-margin' ) ) ) ? ( intval( wm_option( 'branding-logo-margin' ) ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => '.header-right, .nav-right .navigation-wrap',
					'styles' => array(
						'padding-top' => ( -1 < intval( wm_option( 'layout-header-right-margin' ) ) ) ? ( intval( wm_option( 'layout-header-right-margin' ) ) . 'px' ) : ( null ),
					)
				),



			/* fonts */
				array(
					'selector' => '\r\n' //new linebreak
				),

				array(
					'selector' => $primaryFontE,
					'styles' => array(
						'font-family' => ( wm_option( 'design-font-body-stack' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-' . wm_option( 'design-font-body-stack' ) ) ) ) : ( null ),
						'font-size' => ( wm_option( 'design-font-body-size' ) ) ? ( wm_option( 'design-font-body-size' ) . 'px' ) : ( null ),
					)
				),
				array(
					'selector' => $secondaryFontE,
					'styles' => array(
						'font-family' => ( wm_option( 'design-font-secondary' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-secondary' ) ) ) : ( null ),
					)
				),
				array(
					'selector' => $terciaryFontE,
					'styles' => array(
						'font-family' => ( wm_option( 'design-font-subtitle-stack' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-' . wm_option( 'design-font-subtitle-stack' ) ) ) . ' !important' ) : ( null ),
					)
				),
				array(
					'selector' => 'h1, h2, h3, h4, h5, h6',
					'styles' => array(
						'font-family' => ( wm_option( 'design-font-heading-stack' ) ) ? ( str_replace( ';', '', wm_option( 'design-font-' . wm_option( 'design-font-heading-stack' ) ) ) ) : ( null ),
					)
				),

		); // /$customStyles



	//Generate CSS output
		if ( ! empty( $customStyles ) && 2 === intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) {
			$outStyles = '';

			foreach ( $customStyles as $selector ) {
				if (
						isset( $selector['selector'] ) &&
						$selector['selector'] &&
						isset( $selector['styles'] ) &&
						is_array( $selector['styles'] ) &&
						! empty( $selector['styles'] )
					) {
					$selectorStyles = '';
					foreach ( $selector['styles'] as $property => $style ) {
						if ( isset( $style ) && $style )
							$selectorStyles .= $property . ': ' . $style . '; ';
					}

					if ( $selectorStyles )
						$outStyles .= $selector['selector'] . ' {' . $selectorStyles . '}' . "\r\n";
				} elseif ( isset( $selector['selector'] ) && '\r\n' === $selector['selector'] ) {
					$outStyles .= "\r\n";
				}
			}

			if ( $outStyles )
				$out .= "\r\n\r\n\r\n/* Custom design styles */\r\n" . $outStyles;
		}



	//Add manually written styles from admin panel
		$out .= ( wm_option( 'design-custom-css' ) ) ? ( "\r\n\r\n\r\n/* Custom CSS textarea styles */\r\n" . wm_option( 'design-custom-css' ) ) : ( '' );
		$out .= "\r\n\r\n" . '/* End of file */';





/*
*****************************************************
*      CSS HEADER
*****************************************************
*/

	$expireTime = ( wm_option( 'general-no-css-cache' ) ) ? ( 0 ) : ( WM_CSS_EXPIRATION );

	header( 'content-type: text/css; charset: UTF-8' );
	header( 'expires: ' . gmdate( 'D, d M Y H:i:s', time() + $expireTime ) . ' GMT' );
	header( 'cache-control: public, max-age=' . $expireTime );

	if ( ! isset( $_GET['noc'] ) && ( wm_option( 'design-minimize-css' ) ) )
		$out = wm_minimize_css( $out );

	if ( wm_option( 'general-gzip' ) || wm_option( 'design-gzip-cssonly' ) )
		ob_start( 'ob_gzhandler' ); //Enable GZIP
	echo $out;

?>