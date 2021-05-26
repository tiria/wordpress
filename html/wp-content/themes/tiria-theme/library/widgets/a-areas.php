<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Predefined widget areas
*****************************************************
*/

//Widget areas
$widgetAreas = array(

	array(
		'name'          => __( 'Default Sidebar', 'clifden_domain_adm' ),
		'id'            => 'default',
		'description'   => '[widgets area=default /] ' . __( 'The default sidebar widget area.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	),

	array(
		'name'          => __( 'Top Bar Widgets', 'clifden_domain_adm' ),
		'id'            => 'top-bar-widgets',
		'description'   => __( 'Flexible layout, maximum 2 widgets. Recommended widgets are Custom menu, Text or Search.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	),

	array(
		'name'          => __( 'Above Footer Widgets', 'clifden_domain_adm' ),
		'id'            => 'above-footer-widgets',
		'description'   => __( 'Flexible layout, maximum 5 widgets.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	),

	array(
		'name'          => __( 'Footer Widgets Row 1', 'clifden_domain_adm' ),
		'id'            => 'footer1-widgets',
		'description'   => __( 'Flexible layout, maximum 5 widgets.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	),

	array(
		'name'          => __( 'Footer Widgets Row 2', 'clifden_domain_adm' ),
		'id'            => 'footer2-widgets',
		'description'   => __( 'Flexible layout, maximum 5 widgets.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	)
);

if ( wm_option( 'general-client-area' ) )
	array_push( $widgetAreas, array(
		'name'          => __( 'Clients Area Access Denied', 'clifden_domain_adm' ),
		'id'            => 'access-denied',
		'description'   => __( 'Flexible layout, maximum 5 widgets.', 'clifden_domain_adm' ),
		'before_widget' => '<div class="widget %1$s %2$s">',
		'after_widget'  => '</div> <!-- /widget -->',
		'before_title'  => '<h3 class="widget-heading"><span>',
		'after_title'   => '</span></h3>'
	) );

?>