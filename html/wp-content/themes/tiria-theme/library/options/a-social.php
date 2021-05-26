<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Sharing and feeds
*****************************************************
*/

$prefix = 'social-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "social",
	"title" => __( 'Sharing & feed', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "social",
		"list" => array(
			__( 'Social sharing', 'clifden_domain_panel' ),
			__( 'Feed', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "social-1",
		"title" => __( 'Social sharing', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Social share buttons on posts and projects', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-facebook",
			"label" => __( 'Facebook sharing', 'clifden_domain_panel' ),
			"desc" => __( 'Enables this sharing button', 'clifden_domain_panel' ),
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-twitter",
			"label" => __( 'Twitter sharing', 'clifden_domain_panel' ),
			"desc" => __( 'Enables this sharing button', 'clifden_domain_panel' ),
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-googleplus",
			"label" => __( 'Google+ sharing', 'clifden_domain_panel' ),
			"desc" => __( 'Enables this sharing button', 'clifden_domain_panel' ),
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-pinterest",
			"label" => __( 'Pinterest sharing', 'clifden_domain_panel' ),
			"desc" => __( 'Enables this sharing button', 'clifden_domain_panel' ),
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-no-projects",
			"label" => __( 'Disable on projects', 'clifden_domain_panel' ),
			"desc" => __( 'Disables sharing buttons on project pages', 'clifden_domain_panel' ),
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."share-pages",
			"label" => __( 'Enable on pages', 'clifden_domain_panel' ),
			"desc" => __( 'Enables the sharing icons on all pages', 'clifden_domain_panel' )
		),
		array(
			"type" => "hrtop"
		),
	array(
		"type" => "sub-section-close"
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "social-2",
		"title" => __( 'Feed', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Set up custom feed links', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."projects-in-feed",
			"label" => __( 'Include projects in RSS feed', 'clifden_domain_panel' ),
			"desc" => __( 'Include portfolio projects in your website RSS feed', 'clifden_domain_panel' )
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."no-auto-feed-link",
			"label" => __( 'Disable WordPress feed links', 'clifden_domain_panel' ),
			"desc" => __( 'Removes WordPress automatic feed links from website HTML head', 'clifden_domain_panel' ),
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "additems",
			"id" => $prefix."feed-array",
			"label" => __( 'Custom feed links', 'clifden_domain_panel' ),
			"desc" => __( 'Press [+] button to add new custom feed link. Enter the type into the first field and full URL into the second one. Use predefined types such as "application/rss+xml" for RSS or "application/atom+xml" for Atom feed. Links will be placed into HTML head of the website.', 'clifden_domain_panel' ),
			"default" => "",
			"field" => "attributes",
			"field-labels" => array( __( 'Type', 'clifden_domain_adm' ), __( 'Feed URL', 'clifden_domain_adm' ) )
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