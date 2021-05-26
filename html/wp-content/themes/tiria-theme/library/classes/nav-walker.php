<?php
/*
*****************************************************
* WEBMAN WORDPRESS THEME FRAMEWORK
* Created by WebMan - Oliver Juhás
*
* WordPress menu extensions
*
* Note: Requires exact function declarations due to
* PHP Strict Standards, else the PHP warning appears.
*****************************************************
*/

//Enhancing main menus
class wm_main_walker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		//Source function in "wp-includes/nav-menu-template.php" file
		$class_names = $isButton = $isIcon = '';
		$indent      = ( $depth ) ? ( str_repeat( "\t", $depth ) ) : ( '' );
		$classes     = ( empty( $item->classes ) ) ? ( array() ) : ( (array) $item->classes );
		$classes[]   = 'menu-item-' . $item->ID;

		//Adding the "first" class to first menu element
		if ( 1 === $item->menu_order ) {
			$classes[] = 'first';
		}

		//Make string from classes array
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

		//Setting button and icon of menu item before creating "class" attribute
		//stripos = Find the position of the first occurrence of a substring in a string. Faster.
		//stristr = Find the first occurrence of a string. Returns part of haystack string starting from and including the first occurrence of needle to the end of haystack.
		if ( false !== stripos( $class_names, 'button-' ) ) {
			$isButton = stristr( $class_names, 'button-' );
			$isButton = explode( ' ', $isButton );
			$isButton = str_replace( 'button-', '', $isButton[0] );
		}
		if ( false !== stripos( $class_names, 'icon-' ) ) {
			$isIcon = stristr( $class_names, 'icon-' );
			$isIcon = explode( ' ', $isIcon );
			$isIcon = sanitize_title( $isIcon[0] );
			$isIcon = '<i class="ico-nav ' . $isIcon . '"></i>';
		}

		//Preparing "class" attribute
		$class_names = ' class="'. esc_attr( str_replace( 'icon-', 'navicon-', $class_names ) ) . '"';

		//Setting menu item ID
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		//Link attributes
		$attributes  = $attributeTitle = ( ! empty( $item->attr_title ) ) ? ( ' title="' . esc_attr( $item->attr_title ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->target ) ) ? ( ' target="' . esc_attr( $item->target ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->xfn ) ) ? ( ' rel="' . esc_attr( $item->xfn ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->url ) ) ? ( ' href="' . esc_attr( $item->url ) . '"' ) : ( '' );
		$linkClasses  = ( ! empty( $item->description ) ) ? ( 'has-description ' ) : ( '' );
		$linkClasses .= ( $isButton ) ? ( 'btn color-' . esc_attr( $isButton ) ) : ( 'normal' );

		//Display desciption
		$mainItemStart = '<span>';
		$mainItemEnd   = '</span>';
		$description   = ( ! empty( $item->description ) ) ? ( '<small>' . strip_tags( $item->description ) . '</small>' ) : ( '' );

		//Preparing the output
		$item_output = $args->before;
			if ( ! empty( $item->url ) && 'http://' != $item->url && 'http://-' != $item->url && '-' != $item->url )
				$item_output .= '<a'. $attributes .' class="inner ' . esc_attr( $linkClasses ) . '">' . $isIcon;
			else
				$item_output .= '<span class="inner ' . esc_attr( $linkClasses ) . '"' . $attributeTitle . '>' . $isIcon;
			$item_output .= $args->link_before . $mainItemStart . apply_filters( 'the_title', do_shortcode( $item->title ), $item->ID ) . $mainItemEnd;
			$item_output .= $description . $args->link_after;
			if ( ! empty( $item->url ) && 'http://' != $item->url && 'http://-' != $item->url && '-' != $item->url )
				$item_output .= '</a>';
			else
				$item_output .= '</span>';
		$item_output .= $args->after;

		//Checking access
		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $item->object_id ) && $item->object_id ) ? ( $item->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		//Actual output
		if ( $allowed ) {
			$output .= $indent . '<li' . $class_names . $id . ' data-depth="' . $depth . '">' . apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	} // /start_el


	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		//Checking access
		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $item->object_id ) && $item->object_id ) ? ( $item->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		//Actual output
		$output .= ( $allowed ) ? ( "</li>\n" ) : ( '' );
	} // /end_el

} // /wm_main_walker





//Enhancing widget menus
class wm_widget_walker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		//Source function in "wp-includes/nav-menu-template.php" file
		$class_names = '';
		$indent      = ( $depth ) ? ( str_repeat( "\t", $depth ) ) : ( '' );
		$classes     = ( empty( $item->classes ) ) ? ( array() ) : ( (array) $item->classes );
		$classes[]   = 'menu-item-' . $item->ID;

		//Adding the "first" class to first menu element
		if ( 1 === $item->menu_order ) {
			$classes[] = 'first';
		}

		//Removing align classes
		$classes = array_diff( $classes, array( 'alignleft', 'alignright' ) );

		//Make string from classes array
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

		//Preparing "class" attribute
		$class_names = ' class="'. esc_attr( str_replace( 'icon-', 'navicon-', $class_names ) ) . '"';

		//Setting menu item ID
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		//Link attributes
		$attributes  = ( ! empty( $item->attr_title ) ) ? ( ' title="' . esc_attr( $item->attr_title ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->target ) ) ? ( ' target="' . esc_attr( $item->target ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->xfn ) ) ? ( ' rel="' . esc_attr( $item->xfn ) . '"' ) : ( '' );
		$attributes .= ( ! empty( $item->url ) ) ? ( ' href="' . esc_attr( $item->url ) . '"' ) : ( '' );

		//Display desciption
		$mainItemStart = '';
		$mainItemEnd   = '';

		//Preparing the output
		$item_output = $args->before;
			if ( ! empty( $item->url ) && 'http://' != $item->url && 'http://-' != $item->url && '-' != $item->url )
				$item_output .= '<a'. $attributes .' class="inner">';
			else
				$item_output .= '<span class="inner ' . esc_attr( $class_names ) . '">';
			$item_output .= $args->link_before . $mainItemStart . apply_filters( 'the_title', do_shortcode( $item->title ), $item->ID ) . $mainItemEnd . $args->link_after;
			if ( ! empty( $item->url ) && 'http://' != $item->url && 'http://-' != $item->url && '-' != $item->url )
				$item_output .= '</a>';
			else
				$item_output .= '</span>';
		$item_output .= $args->after;

		//Checking access
		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $item->object_id ) && $item->object_id ) ? ( $item->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		//Actual output
		if ( $allowed ) {
			$output .= $indent . '<li' . $class_names . $id . ' data-depth="' . $depth . '">' . apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	} // /start_el


	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		//Checking access
		if ( wm_option( 'access-client-area' ) ) {
			$pageId  = ( isset( $item->object_id ) && $item->object_id ) ? ( $item->object_id ) : ( 0 );
			$allowed = wm_restriction_page( $pageId );
		} else {
			$allowed = true;
		}

		//Actual output
		$output .= ( $allowed ) ? ( "</li>\n" ) : ( '' );
	} // /end_el

} // /wm_widget_walker

?>