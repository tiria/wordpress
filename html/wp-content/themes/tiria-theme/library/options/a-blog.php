<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Blog
*****************************************************
*/

$prefix = 'blog-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "blog",
	"title" => __( 'Blog', 'clifden_domain_panel' )
)

);

if ( ! wm_check_wp_version( '3.6' ) )
	array_push( $options,

		array(
			"type" => "sub-tabs",
			"parent-section-id" => "blog",
			"list" => array(
				__( 'Basics', 'clifden_domain_panel' ),
				__( 'Post formats', 'clifden_domain_panel' )
				)
		)

	);
if ( wm_check_wp_version( '3.6' ) )
	array_push( $options,

		array(
			"type" => "sub-tabs",
			"parent-section-id" => "blog",
			"list" => array(
				__( 'Basics', 'clifden_domain_panel' )
				)
		)

	);

array_push( $options,

	array(
		"type" => "sub-section-open",
		"sub-section-id" => "blog-1",
		"title" => __( 'Basics', 'clifden_domain_panel' )
	),
		array(
			"type" => "slider",
			"id" => $prefix."blog-excerpt-length",
			"label" => __( 'Excerpt length', 'clifden_domain_panel' ),
			"desc" => __( 'Sets the default blog list excerpt length in words', 'clifden_domain_panel' ),
			"default" => 40,
			"min" => 10,
			"max" => 70,
			"step" => 1,
			"validate" => "absint"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."full-posts",
			"label" => __( '...or display full posts?', 'clifden_domain_panel' ),
			"desc" => __( 'Displays full posts on blog pages', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),

		array(
			"type" => "heading3",
			"content" => __( 'Blog entry meta information', 'clifden_domain_panel' )
		),
			array(
				"type" => "paragraph",
				"content" => __( 'Choose the post meta information to display. By default all the information below are displayed.', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-featured-image",
				"label" => __( 'Disable featured image in a single post view', 'clifden_domain_panel' ),
				"desc" => __( 'Hides featured image when displaying single post. This can be disabled also per post basis.', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-author",
				"label" => __( 'Disable author name', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post author name', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-date",
				"label" => __( 'Disable publish date', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post publish date and time', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-cats",
				"label" => __( 'Disable categories', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post categories links', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-tags",
				"label" => __( 'Disable tags', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post tags list', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-comments-count",
				"label" => __( 'Disable comments count', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post comments count link', 'clifden_domain_panel' )
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-format",
				"label" => __( 'Disable post format icon', 'clifden_domain_panel' ),
				"desc" => __( 'Hides post format icon', 'clifden_domain_panel' )
			),
			array(
				"type" => "space"
			),
			array(
				"type" => "checkbox",
				"id" => $prefix."disable-bio",
				"label" => __( 'Disable author biography altogether', 'clifden_domain_panel' ),
				"desc" => __( 'Hides author information below all posts (otherwise the information is displayed, but only if author entered Biographical Info in his/her user profile). You can hide this information also on per post basis (see corresponding post settings).', 'clifden_domain_panel' )
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "checkbox",
			"id" => $prefix."archive-no-sidebar",
			"label" => __( 'Disable sidebar on archive posts list', 'clifden_domain_panel' ),
			"desc" => __( 'Removes sidebar from archive posts list pages (such as category page)', 'clifden_domain_panel' )
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	)

);

if ( ! wm_check_wp_version( '3.6' ) )
	array_push( $options,

		array(
			"type" => "sub-section-open",
			"sub-section-id" => "blog-2",
			"title" => __( 'Post formats', 'clifden_domain_panel' )
		),
			array(
				"type" => "heading3",
				"content" => __( 'Disable unnecessary post formats', 'clifden_domain_panel' ),
				"class" => "first"
			),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-audio",
					"label" => __( 'Disable audio posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format', 'clifden_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-gallery",
					"label" => __( 'Disable gallery posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format', 'clifden_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-link",
					"label" => __( 'Disable link posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format', 'clifden_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-quote",
					"label" => __( 'Disable quote posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format. However, keep in mind that Quote post format is used to populate the Testimonials shortcode.', 'clifden_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-status",
					"label" => __( 'Disable status posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format', 'clifden_domain_panel' )
				),
				array(
					"type" => "space"
				),
				array(
					"type" => "checkbox",
					"id" => $prefix."no-format-video",
					"label" => __( 'Disable video posts', 'clifden_domain_panel' ),
					"desc" => __( 'Disables this post format', 'clifden_domain_panel' )
				),
			array(
				"type" => "hrtop"
			),
		array(
			"type" => "sub-section-close"
		)

	);

array_push( $options,

array(
	"type" => "section-close"
)

);

?>