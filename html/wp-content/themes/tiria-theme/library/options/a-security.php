<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Security
*****************************************************
*/

$prefix = 'security-';

array_push( $options,

array(
	"type" => "section-open",
	"section-id" => "security",
	"title" => __( 'Security', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "security",
		"list" => array(
			__( 'Security settings', 'clifden_domain_panel' )
			)
	),



	array(
		"type" => "sub-section-open",
		"sub-section-id" => "security-1",
		"title" => __( 'Security settings', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Basic WordPress security', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."login-error",
			"label" => __( 'Replace login errors', 'clifden_domain_panel' ),
			"desc" => __( 'Login error messages will be replaced with generic one.<br />The actual login error text will not say what went wrong during the login process.', 'clifden_domain_panel' ),
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."wp-version",
			"label" => __( 'Disable WordPress version', 'clifden_domain_panel' ),
			"desc" => __( 'WordPress version will be removed from HTML head (recommended setting)', 'clifden_domain_panel' ),
			"default" => "true"
		),
		array(
			"type" => "checkbox",
			"id" => $prefix."live-writer",
			"label" => __( 'Disable Windows Live Writer support', 'clifden_domain_panel' ),
			"desc" => __( 'Eliminate potential security risk by removing Windows Live Writer support (recommended setting)', 'clifden_domain_panel' ),
			"default" => "true"
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "space"
		),
		array(
			"type" => "box",
			"content" => '
				<h3 class="pt0">' . __( 'WordPress security tips', 'clifden_domain_panel' ) . '</h3>
				<p>' . __( 'You can improve your WordPress installation security by taking these steps:', 'clifden_domain_panel' ) . '</p>
				<ul class="bullets pb0">
					<li>' . __( 'Set the Authentication Unique Keys and Salts in <code>wp-config.php</code> file', 'clifden_domain_panel' ) . '</li>
					<li>' . __( 'Set the <code>$table_prefix</code> variable in <code>wp-config.php</code> file (do not use the default "wp_" value) - this should be done before installing WordPress or you would have to change these in your database too', 'clifden_domain_panel' ) . '</li>
					<li>' . __( 'Do not use "admin" as user name and set strong passwords', 'clifden_domain_panel' ) . '</li>
					<li>' . __( 'After installing WordPress, remove <code>wp-admin/install.php</code> file', 'clifden_domain_panel' ) . '</li>
					<li><strong>' . __( 'Keep backups of the database and WordPress installation', 'clifden_domain_panel' ) . '</strong></li>
					<li><strong>' . __( 'Keep your WordPress installation up to date', 'clifden_domain_panel' ) . '</strong></li>
					<li>' . __( 'You can also try some security plugins (like <a href="http://wordpress.org/extend/plugins/limit-login-attempts/" target="_blank">Limit Login Attempts</a> for example).', 'clifden_domain_panel' ) . '</li>
				</ul>'
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