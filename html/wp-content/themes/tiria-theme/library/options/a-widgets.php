<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Widget areas
*****************************************************
*/

$prefix = 'widgets-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "widgets",
	"title" => __( 'Widget areas', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "widgets",
		"list" => array(
			__( 'Widget areas', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "widgets-1",
		"title" => __( 'Widget areas', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Adding a custom widget areas', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "info",
			"content" => __( 'In addition to predefined widget areas you can create custom ones directly from this Admin Panel, without any coding knowledge or editing theme files. To create a new widget area use the generator below.', 'clifden_domain_panel' )
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "additems",
			"id" => $prefix."sidebars",
			"label" => __( 'Create additional widget areas', 'clifden_domain_panel' ),
			"desc" => __( 'Press [+] button and enter the name for new widget area. If the widget area of the same name already exists, it will not be created again. To remove a custom widget area press [X] button preceding its name in the list. Note that renaming previously created widget area changes its ID and all widgets assigned to it will be lost! Do not forget to save the changes.', 'clifden_domain_panel' ),
			"default" => __( 'Custom widget area', 'clifden_domain_adm' )
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