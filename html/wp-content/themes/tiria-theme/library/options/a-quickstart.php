<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Quick start guide
*****************************************************
*/

$prefix = 'quickstart-';

if ( 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) {

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "quickstart",
	"title" => __( 'Quickstart', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "quickstart",
		"list" => array(
			__( 'Quickstart guide', 'clifden_domain_panel' )
			)
	),

	array(
		"type" => "sub-section-open",
		"sub-section-id" => "quickstart-1",
		"title" => __( 'Quickstart guide', 'clifden_domain_panel' )
	),
		array(
			"type" => "intro",
			"content" => '<img src="' . WM_ASSETS_ADMIN . 'img/logos/logo-webman-icon-92x92.png" class="left" />Thank you for purchasing the <strong>"' . WM_THEME_NAME . '"</strong> theme. <br />This quickstart guide will help you to set up the basic options. For more advanced settings feel free to explore sections of this admin panel. <br /><br /><a href="http://www.webmandesign.eu" target="_blank">WebMan</a>'
		),

		array(
			"type" => "heading4",
			"content" => "Congratulation on your purchase of powerful <strong>" . WM_THEME_NAME . "</strong> responsive business WordPress theme.<br />Let's unleash the power of flexibility! Please take time to read the steps below for basic theme setup and customization.",
		),
			array(
				"type" => "hr"
			),

		array(
			"type" => "box",
			"content" => "<small>Please note that this theme is being sold exclusively via <a href='http://www.mojo-themes.com/user/webmandesign/' target='_blank'>Mojo Themes</a>.<br /><br /><strong>In case you've obtained the theme on some file sharing network</strong>, please note that you are using pirated, possibly modified version. I've put a lot of time and effort into building this theme and to support me in delivering new high quality themes please purchase the license to use the theme on live website. The theme license price is more than reasonable for the functionality you get!<br /><br />
				<em>Thank you for understanding!</em></small>",
		),
			array(
				"type" => "hr"
			),

		array(
			"type" => "paragraph",
			"content" => '<span class="dropcap">1</span><br /><br />',
		),
			array(
				"type" => "heading4",
				"content" => "Start by basic WordPress settings",
			),
			array(
				"type" => "paragraph",
				"content" => "Please navigate to <strong>Settings</strong> section of the main WordPress admin menu and go through all the subsections and options. For better Search Engine Optimization (SEO) it is recommended to set permalinks structure to <em>\"Post name\"</em>. <br /><br />
					<em>Read more about <a href='http://codex.wordpress.org/Administration_Screens#Settings_-_Configuration_Settings' target='_blank'>WordPress settings</a>.<br />
					If you are new to WordPress, you can find some instructions on how to use this system in <a href='http://codex.wordpress.org/WordPress_Lessons' target='_blank'>WordPress lessons</a>.</em><br /><br />
					<a class='button-primary' href='" . get_admin_url() . "options-general.php' target='_blank'>Let's set it up!</a> <em>- opens the link in new tab/window</em>
					",
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "paragraph",
			"content" => '<span class="dropcap">2</span><br /><br />',
		),
			array(
				"type" => "heading4",
				"content" => "Theme settings",
			),
			array(
				"type" => "paragraph",
				"content" => "When you get the basic WordPress settings done, it is time to set up the theme itself. Please go through the sections of this admin panel and have a look at different options you can set. You will notice the options have already been preset with their default values, but feel free to change them to your needs. The most necessary sections to go through are:",
			),
			array(
				"type" => "paragraph",
				"content" => "<strong>General</strong> - here you can disable/enable theme features, page templates, custom posts, set image sizes and basic options<br />
				<strong>Branding</strong> - where you can set your logo, favicon, touch icons, footer text and tweak the login and admin area<br />
				<strong>SEO settings</strong> - please set default keywords and description of your website",
			),
			array(
				"type" => "paragraph",
				"content" => "After you set required settings, don't forget to save them. Once you save your settings for the first time, this Quickstart guide will no longer appear and admin panel will be de-branded. Please also make sure you keep backup of your theme settings (navigate to <strong>Appearance &raquo; Options Export/Import</strong> section).",
			),
			array(
				"type" => "hr"
			),

		array(
			"type" => "heading3",
			"content" => "And that's it! You are done with basic theme setup! <br /><br /><em>Enjoy <strong>" . WM_THEME_NAME . "</strong>!</em>",
		),
			array(
				"type" => "space"
			),

		array(
			"type" => "info",
			"content" => "<strong>Do you often get lost? ;)</strong><br /><br /> For such cases <strong>" . WM_THEME_NAME . "</strong> offers handy contextual help for almost every topic related to the theme. Just press <strong>Help</strong> button in the upper right corner of the screen and related instructions will be revealed.",
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

}

?>