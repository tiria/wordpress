<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Widget areas generator
*
* CONTENT:
* - 1) Required files
* - 2) Widget areas registration
* - 3) Custom widget areas registration
*****************************************************
*/





/*
*****************************************************
*      1) REQUIRED FILES
*****************************************************
*/
	//Load widget areas array
	require_once( WM_WIDGETS . 'a-areas.php' );

	//Add widgets
	require_once( WM_WIDGETS . 'w-default-widgets.php' );
	require_once( WM_WIDGETS . 'w-contact.php' );
	require_once( WM_WIDGETS . 'w-cpmodules.php' );
	require_once( WM_WIDGETS . 'w-cpprojects.php' );
	require_once( WM_WIDGETS . 'w-postslist.php' );
	require_once( WM_WIDGETS . 'w-subpages.php' );
	require_once( WM_WIDGETS . 'w-status.php' );
	require_once( WM_WIDGETS . 'w-twitter.php' );





/*
*****************************************************
*      2) WIDGET AREAS REGISTRATION
*****************************************************
*/
	//Register predefined widget areas (sidebars)
	foreach( $widgetAreas as $widgetArea ) {
		register_sidebar( array(
			'name'          => $widgetArea['name'],
			'id'            => $widgetArea['id'],
			'description'   => $widgetArea['description'],
			'before_widget' => $widgetArea['before_widget'],
			'after_widget'  => $widgetArea['after_widget'],
			'before_title'  => $widgetArea['before_title'],
			'after_title'   => $widgetArea['after_title']
			) );
	}



/*
*****************************************************
*      3) CUSTOM WIDGET AREAS REGISTRATION
*****************************************************
*/
	$widgetAreasCustom      = array();
	$sidebarArraysCheck     = array();
	$widgetAreasCustomNames = wm_option( 'widgets-sidebars' );
	$sidebarDescription     = sprintf( __( 'Custom widget area created in %s admin panel. Flexible layout, maximum 5 widgets (when displayed horizontally).', 'clifden_domain_adm' ), WM_THEME_NAME );

	if ( is_array( $widgetAreasCustomNames ) && ! empty( $widgetAreasCustomNames ) ) {
		foreach ( $widgetAreasCustomNames as $sidebarName ) {

			$sidebarID = 'wmcs-' . sanitize_title( $sidebarName ); //creating sidebar ID

			//creating custom sidebars array
			if ( 'wmcs-' != $sidebarID && ! in_array( $sidebarID, $sidebarArraysCheck ) ) {
				$newSidebar = array(
						'name' => esc_attr( preg_replace( '/\s+/', ' ', $sidebarName ) ), //remove spaces
						'id'   => $sidebarID
					);
				array_push( $widgetAreasCustom, $newSidebar ); //add a sidebar at the end of all sidebars array
				array_push( $sidebarArraysCheck, $sidebarID ); //add a sidebar at the end of all sidebars array
			}

		}
	}

	//Register custom widget areas (sidebars)
	if ( ! empty( $widgetAreasCustom ) ) {
		foreach ( $widgetAreasCustom as $widgetAreaCustom ) {
			register_sidebar( array(
				'name'          => $widgetAreaCustom['name'],
				'id'            => $widgetAreaCustom['id'],
				'description'   => '[widgets area=' . $widgetAreaCustom['id'] . ' /] ' . $sidebarDescription,
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div> <!-- /widget -->',
				'before_title'  => '<h3 class="widget-heading"><span>',
				'after_title'   => '</span></h3>'
				) );
		}
	}

?>