<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - SEO settings
*****************************************************
*/

$prefix = 'seo-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "seo",
	"title" => __( 'SEO & Tracking', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "seo",
		"list" => array(
			__( 'Basics', 'clifden_domain_panel' ),
			__( 'Tracking', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "seo-1",
		"title" => __( 'Basics', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Website Search Engine Optimization', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "box",
			"content" => __( 'Basic <abbr title="Search Engine Optimization">SEO</abbr> settings include global website keywords and description displayed in the HTML head section of the website. You can also set whether search engines should index archive lists or not. To improve the SEO it is recommended to set the permalink structure (in <strong>Settings / Permalinks</strong>) to "Post name".', 'clifden_domain_panel' )
		),
		array(
			"type" => "warning",
			"content" => __( 'For better SEO, you should use a specialized plugin (such as Yoast WordPress SEO plugin). If you do so, it is strongly recommended to disable theme SEO functionality below.', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."metaboxes",
			"label" => __( 'Disable theme SEO functionality', 'clifden_domain_panel' ),
			"desc" => __( 'If you are using a SEO plugin, you can disables SEO functions integrated into the theme here', 'clifden_domain_panel' ),
			"value" => "no"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."indexing",
			"label" => __( 'Do not index archives', 'clifden_domain_panel' ),
			"desc" => __( 'Disallow search engines to index all archive pages (like category, tag, author, date, search archive)', 'clifden_domain_panel' ),
			"value" => "no"
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "textarea",
			"id" => $prefix."keywords",
			"label" => __( 'Default meta keywords', 'clifden_domain_panel' ),
			"desc" => __( 'The theme generates meta keywords automatically (from categories and tags) or you can set them per page/post basis.', 'clifden_domain_panel' ),
			"default" => "",
			"rows" => 3
		),
		array(
			"type" => "textarea",
			"id" => $prefix."description",
			"label" => __( 'Default meta description', 'clifden_domain_panel' ),
			"desc" => __( 'The theme generates meta description automatically or you can set it per page/post basis. However you should set the default SEO description here. Most of search engines work with 160 character strings.', 'clifden_domain_panel' ),
			"default" => "",
			"rows" => 3
		),
		array(
			"type" => "text",
			"id" => $prefix."meta-title-separator",
			"label" => __( 'Website meta title separator', 'clifden_domain_panel' ),
			"desc" => __( 'Empty spaces will be applied on both sides of the separator, so no need to type them in', 'clifden_domain_panel' ),
			"default" => "|",
			"class" => "shortest text-center",
			"size" => 3,
			"maxlength" => 3
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "seo-2",
		"title" => __( 'Tracking', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Tracking codes or custom <abbr title="JavaScript">JS</abbr> scripts', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "textarea",
			"id" => $prefix."custom-footer",
			"label" => __( 'Scripts', 'clifden_domain_panel' ),
			"desc" => __( 'Custom scripts at the end of the website HTML code just before closing BODY tag. Can be used for tracking code placement. Do not forget to include <code>&lt;script&gt;</code> HTML tags.', 'clifden_domain_panel' ),
			"default" => "",
			"class" => "code",
			"cols" => 70,
			"rows" => 15,
		),
		array(
			"type" => "select",
			"id" => $prefix."no-logged",
			"label" => __( 'Do not track logged in users', 'clifden_domain_panel' ),
			"desc" => __( 'Removes the above scripts when user is logged in with certain minimum user role, thus preventing the tracking of logged-in users.', 'clifden_domain_panel' ),
			"options" => array(
				''                       => __( 'Track everyone', 'clifden_domain_panel' ),
				'read'                   => __( 'Subscribers (and above) - all logged in users', 'clifden_domain_panel' ),
				'delete_posts'           => __( 'Contributors (and above)', 'clifden_domain_panel' ),
				'delete_published_posts' => __( 'Authors (and above)', 'clifden_domain_panel' ),
				'read_private_pages'     => __( 'Editors (and above)', 'clifden_domain_panel' ),
				'edit_dashboard'         => __( 'Administrators', 'clifden_domain_panel' ),
				),
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