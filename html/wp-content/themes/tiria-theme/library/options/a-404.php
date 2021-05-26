<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Error 404 page
*****************************************************
*/

$prefix = 'p404-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "p404",
	"title" => __( 'Error 404 page', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "p404",
		"list" => array(
			__( 'Error 404 page', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "p404-1",
		"title" => __( 'Error 404 page', 'clifden_domain_panel' )
	),
		array(
			"type" => "text",
			"id" => $prefix."title",
			"label" => __( 'Page title', 'clifden_domain_panel' ),
			"desc" => __( 'Error 404 page title', 'clifden_domain_panel' ),
			"default" => __( 'Web page was not found', 'clifden_domain' )
		),
		array(
			"type" => "textarea",
			"id" => $prefix."text",
			"label" => __( 'Page text', 'clifden_domain_panel' ),
			"desc" => __( 'You can use HTML tags', 'clifden_domain_panel' ),
			"default" => "<h1>" . __( 'Oops', 'clifden_domain' ) . "</h1>
<h2>" . __( 'The page you are looking for was moved, deleted or does not exist.', 'clifden_domain' ) . "</h2>
<p>[button color=\"blue\" icon=\"icon-home\" size=\"xl\" url=\"" . home_url() . "\"]" . __( 'Return to homepage', 'clifden_domain' ) . "[/button]</p>
",
			"cols" => 70,
			"rows" => 7
		),
		array(
			"type" => "image",
			"id" => $prefix."image",
			"label" => __( 'Error 404 image', 'clifden_domain_panel' ),
			"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_panel' ),
			"default" => WM_ASSETS_THEME . "img/404.png",
			"validate" => "url"
		),
		array(
			"type" => "hr"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."no-above-footer-widgets",
			"label" => __( 'Disable widgets above footer', 'clifden_domain_panel' ),
			"desc" => __( 'Disables Above Footer widgets area on Error 404 page', 'clifden_domain_panel' ),
			"value" => "no"
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