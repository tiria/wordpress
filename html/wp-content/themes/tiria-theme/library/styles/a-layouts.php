<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Layouts
*****************************************************
*/

//Website layout
$websiteLayout = array(

	array(
		'name' => __( 'Full width layout', 'clifden_domain_adm' ),
		'id'   => 'fullwidth',
		'desc' => __( 'Full width - website sections will spread across the whole browser window width', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-full-width.png'
	),

	array(
		'name' => __( 'Boxed layout', 'clifden_domain_adm' ),
		'id'   => 'boxed',
		'desc' => __( 'Boxed - website sections will be contained in a centered box', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-boxed.png'
	),

);



//Sidebar positions
$sidebarPosition = array(

	array(
		'name' => __( 'Default theme settings', 'clifden_domain_adm' ),
		'id'   => '',
		'desc' => __( 'Use default theme position of the sidebar', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-default.png'
	),

	array(
		'name' => __( 'Sidebar right', 'clifden_domain_adm' ),
		'id'   => 'right',
		'desc' => __( 'Sidebar is aligned right from the page/post content', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-right.png'
	),

	array(
		'name' => __( 'Sidebar left', 'clifden_domain_adm' ),
		'id'   => 'left',
		'desc' => __( 'Sidebar is aligned left from the page/post content', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-left.png'
	),

	array(
		'name' => __( 'No sidebar, full width', 'clifden_domain_adm' ),
		'id'   => 'none',
		'desc' => __( 'No sidebar is displayed, the page content takes the full width of the website', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-sidebar-none.png'
	)

);



//Project layouts
$projectLayouts = array(
	"1OPTGROUP"  => __( 'Media first', 'clifden_domain_adm' ),
		"me-4"     => __( '3/4 media - 1/4 excerpt, content below', 'clifden_domain_adm' ),
		"me-3"     => __( '2/3 media - 1/3 excerpt, content below', 'clifden_domain_adm' ),
		"me-2"     => __( '1/2 media - 1/2 excerpt, content below', 'clifden_domain_adm' ),
	"1/OPTGROUP" => "",

	"2OPTGROUP"  => __( 'Excerpt first', 'clifden_domain_adm' ),
		"em-4"     => __( '1/4 excerpt - 3/4 media, content below', 'clifden_domain_adm' ),
		"em-3"     => __( '1/3 excerpt - 2/3 media, content below', 'clifden_domain_adm' ),
		"em-2"     => __( '1/2 excerpt - 1/2 media, content below', 'clifden_domain_adm' ),
	"2/OPTGROUP" => "",

	"3OPTGROUP"  => __( 'Post layout', 'clifden_domain_adm' ),
		"plain"    => __( 'Plain post (large media area, content)', 'clifden_domain_adm' ),
	"3/OPTGROUP" => "",
);



//Portfolio layout
$portfolioLayout = array(

	array(
		'name' => __( 'Default theme settings', 'clifden_domain_adm' ),
		'id'   => '',
		'desc' => __( 'Use default theme portfolio layout', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-default.png'
	),

	array(
		'name' => __( 'Two columns', 'clifden_domain_adm' ),
		'id'   => '2',
		'desc' => __( 'Two columns preview with basic info', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-2.png'
	),

	array(
		'name' => __( 'Three columns', 'clifden_domain_adm' ),
		'id'   => '3',
		'desc' => __( 'Three columns preview with basic info', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-3.png'
	),

	array(
		'name' => __( 'Four columns', 'clifden_domain_adm' ),
		'id'   => '4',
		'desc' => __( 'Four columns preview with basic info', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-4.png'
	),

	array(
		'name' => __( 'One column', 'clifden_domain_adm' ),
		'id'   => '5',
		'desc' => __( 'Large preview and item description', 'clifden_domain_adm' ),
		'img'  => WM_ASSETS_ADMIN . 'img/layouts/layout-portfolio-columns-5.png'
	),

);

?>