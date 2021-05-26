<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Options Panel - Export / import
*****************************************************
*/

$prefix = 'export-';

array_push( $options_ei,

array(
	"type" => "section-open",
	"section-id" => "export",
	"title" => __( 'Export / import', 'clifden_domain_panel' )
),

	array(
		"type" => "sub-tabs",
		"parent-section-id" => "export",
		"list" => array(
			__( 'Export / import', 'clifden_domain_panel' )
			)
	),

	array(
		"type" => "sub-section-open",
		"sub-section-id" => "export-1",
		"title" => __( 'Export / import', 'clifden_domain_panel' )
	),
		array(
			"type" => "heading3",
			"content" => __( 'Theme settings export / import', 'clifden_domain_panel' ),
			"class" => "first"
		),
		array(
			"type" => "settingsExporter",
			"id" => "settingsExporter",
			"label-export" => __( 'Export', 'clifden_domain_panel' ),
			"desc-export" => __( 'To export the current settings copy and keep (save to external file) the settings string from the textarea below or click the "Create a file" button to save the settings in a new theme options file inside a <code>%s/option-presets/</code> folder.', 'clifden_domain_panel' ),
			"label-import" => __( 'Import', 'clifden_domain_panel' ),
			"desc-import" => __( 'To import previously saved settings, insert the settings string into textarea below or choose one of preset files (if exist) from the dropdown and save changes. Note that by importing new settings you will loose all current ones. Always keep the backup of current settings.', 'clifden_domain_panel' )
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