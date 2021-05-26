<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Layout
*****************************************************
*/

$prefix = 'layout-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "layout",
	"title" => __( 'Layout', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "layout",
		"list" => array(
			__( 'Basics', 'clifden_domain_panel' ),
			__( 'Header', 'clifden_domain_panel' ),
			__( 'Breadcrums', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "layout-1",
		"title" => __( 'Basics', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Main website layout', 'clifden_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "layouts",
				"id" => $prefix."boxed",
				"label" => __( 'Layout', 'clifden_domain_panel' ),
				"desc" => __( 'Choose the default website layout', 'clifden_domain_panel' ),
				"options" => $websiteLayout,
				"default" => "fullwidth"
			),
			array(
				"type" => "select",
				"id" => $prefix."width",
				"label" => __( 'Website content', 'clifden_domain_panel' ),
				"desc" => __( 'Sets the maximum website content width and responsiveness of the design', 'clifden_domain_panel' ),
				"options" => array(
					'r930'  => __( 'Responsive 930px (1020px website box)', 'clifden_domain_panel' ),
					'r1160' => __( 'Responsive 1160px (1280px website box)', 'clifden_domain_panel' ),
					's930'  => __( 'Static 930px (1020px website box)', 'clifden_domain_panel' ),
					's1160' => __( 'Static 1160px (1280px website box)', 'clifden_domain_panel' ),
					),
				"default" => "r1160"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Sidebar', 'clifden_domain_panel' )
		),
			array(
				"type" => "select",
				"id" => $prefix."sidebar-width",
				"label" => __( 'Sidebar width', 'clifden_domain_panel' ),
				"desc" => __( 'Sets the sidebar width (ratio against the website content width set above)', 'clifden_domain_panel' ),
				"options" => array(
						" three pane" => __( 'Narrow sidebar (1/4)', 'clifden_domain_panel' ),
						" four pane"  => __( 'Normal sidebar (1/3)', 'clifden_domain_panel' ),
						" five pane"  => __( 'Wide sidebar (5/12)', 'clifden_domain_panel' ),
					),
				"default" => " four pane"
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => __( 'Project page', 'clifden_domain_panel' )
		),
			array(
				"type" => "checkbox",
				"id" => $prefix."no-related-projects",
				"label" => __( 'Disable related projects', 'clifden_domain_panel' ),
				"desc" => __( 'Globaly disables related projects displayed at the bottom of project pages', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "text",
				"id" => $prefix."related-projects-title",
				"label" => __( 'Related projects section title', 'clifden_domain_panel' ),
				"desc" => __( 'Customize the "Related projects" title if the section is enabled', 'clifden_domain_panel' )
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "layout-2",
		"title" => __( 'Header', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Website header', 'clifden_domain_panel' ),
			"class" => "first"
		),
			array(
				"type" => "slider",
				"id" => "design-header-height", //no prefix here to keep compatibility after moving from Design section to Layout
				"label" => __( 'Header height', 'clifden_domain_panel' ),
				"desc" => __( 'Set the header height (leave zero to use the default theme settings)', 'clifden_domain_panel' ),
				"default" => 0,
				"min" => 0,
				"max" => 300,
				"step" => 5,
				"validate" => "int",
				"zero" => true
			),
			array(
				"type" => "checkbox",
				"id" => "design-top-bar-fixed", //no prefix here to keep compatibility after moving from Design section to Layout
				"label" => __( 'Sticky top bar', 'clifden_domain_panel' ),
				"desc" => __( 'Sticks the top bar to the top of the browser window even when scrolling', 'clifden_domain_panel' )
			),
			array(
				"type" => "hr",
			),

			array(
				"type" => "select",
				"id" => $prefix."navigation-"."position",
				"label" => __( 'Navigation position', 'clifden_domain_panel' ),
				"desc" => __( 'Changes website header layout. If navigation right is selected, the right header text area will not be displayed.', 'clifden_domain_panel' ),
				"options" => array(
					' nav-bottom' => __( 'Navigation bottom', 'clifden_domain_panel' ),
					' nav-right'  => __( 'Navigation right', 'clifden_domain_panel' ),
					' nav-top'    => __( 'Navigation top', 'clifden_domain_panel' ),
					),
				"default" => " nav-right"
			),
			array(
				"type" => "hr",
			),

			array(
				"type" => "textarea",
				"id" => $prefix."header-right",
				"label" => __( 'Right header area text', 'clifden_domain_panel' ),
				"desc" => __( 'Text in area right from logo in website header. You can use (C) to display &copy; sign, (R) for &reg;, (TM) for &trade;, YEAR for current year or SEARCH to display a search form.', 'clifden_domain_panel' ),
				"default" => '<strong><i class="icon-phone"></i> 0999 123 456</strong> &nbsp;&nbsp;|&nbsp;&nbsp; [social url="#" icon="Facebook" size="s" /][social url="#" icon="Twitter" size="s" /][social url="#" icon="Google+" size="s" /][social url="#" icon="RSS" size="s" /]',
				"cols" => 60,
				"rows" => 10,
				"empty" => true
			),
			array(
				"type" => "slider",
				"id" => $prefix."header-right-margin",
				"label" => __( 'Right header/right navigation area padding', 'clifden_domain_panel' ),
				"desc" => __( 'Sets the top padding size for textarea in website header ("-1" sets the default theme value) or for navigation (when displayed right from logo)', 'clifden_domain_panel' ),
				"default" => -1,
				"min" => -1,
				"max" => 100,
				"step" => 1,
				"validate" => "int",
				"zero" => true
			),
			array(
				"type" => "hrtop"
			),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "layout-3",
		"title" => __( 'Breadcrumbs', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Breadcrumbs navigation settings', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "select",
			"id" => $prefix."breadcrumbs",
			"label" => __( 'Breadcrumbs position', 'clifden_domain_panel' ),
			"desc" => __( 'Select whether and where the breadcrumbs navigation should be displayed', 'clifden_domain_panel' ),
			"options" => array(
					'none'   => __( 'No breadcrumbs', 'clifden_domain_panel' ),
					'top'    => __( 'Top breadcrumbs', 'clifden_domain_panel' ),
					'bottom' => __( 'Bottom breadcrumbs', 'clifden_domain_panel' ),
					'both'   => __( 'Top and bottom breadcrumbs', 'clifden_domain_panel' ),
					'stick'  => __( 'Sticky breadcrumbs', 'clifden_domain_panel' )
				),
			"default" => "stick"
		),
		array(
			"type" => "info",
			"content" => __( 'The above option allows you to disable breadcrumbs navigation altogether. However, it is recommended to keep the breadcrumbs displayed as it improves <attr title="Search Engine Optimization">SEO</attr>. Alternatively you can choose to disable breadcrumbs in specific website sections only (see the settings below) or on certain posts and pages (see the post/page settings).', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-archives",
			"label" => __( 'Disable breadcrumbs on archives', 'clifden_domain_panel' ),
			"desc" => __( 'Disables breadcrumbs navigation on all archive pages', 'clifden_domain_panel' )
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-404",
			"label" => __( 'Disable breadcrumbs on Error 404 page', 'clifden_domain_panel' ),
			"desc" => __( 'Disables breadcrumbs navigation on Error 404 page', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-animate-search",
			"label" => __( 'Animate search form in breadcrumbs area', 'clifden_domain_panel' ),
			"desc" => __( 'Shrinks search input field when not in focus', 'clifden_domain_panel' ),
			"value" => " animated-form",
			"default" => " animated-form"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."breadcrumbs-no-search",
			"label" => __( 'Disable search form', 'clifden_domain_panel' ),
			"desc" => __( 'Hides search form in breadcrumbs bar', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "select",
			"id" => $prefix."breadcrumbs-portfolio-page",
			"label" => __( 'Portfolio page', 'clifden_domain_panel' ),
			"desc" => __( 'Select a main projects list page used as base for single project pages', 'clifden_domain_panel' ),
			"options" => wm_pages(),
			"default" => ""
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