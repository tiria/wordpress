<?php
if ( wm_option( 'general-gzip' ) )
	ob_start( 'ob_gzhandler' ); //Enable GZIP

global $is_opera, $is_IE;
$opera    = ( $is_opera ) ? ( ' browser-opera' ) : ( '' );
$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
$blogLayout = ''; //global for archives and single posts

//variables
	//post ID
	$postId = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
	//top panel display boolean variable
	$isTopBar = is_active_sidebar( 'top-bar-widgets' ) && ! ( ! is_archive() && ! is_search() && wm_meta_option( 'no-top-bar', $postId ) ) && ! is_page_template( 'tpl-landing.php' ) && ! is_page_template( 'tpl-construction.php' );

//wrap background color class
	$setBgWrap = ( wm_css_background( 'design-wrap-' ) ) ? ( ' set-bg' ) : ( '' );

//header classes
	$headerClasses  = '';
	$headerClasses .= ( wm_css_background( 'design-header-' ) ) ? ( ' set-bg' ) : ( '' );
	$headerClasses .= wm_option( 'layout-navigation-position' ) . wm_option( 'design-header-icons' );
?><!doctype html>

<!--[if lte IE 7]> <html class="ie ie7 lie8 lie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 lie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js<?php echo $opera; ?>" <?php language_attributes(); ?>><!--<![endif]-->

<head>
<!-- (c) Copyright <?php bloginfo( 'name' ); ?> -->
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if ( ! wm_option( 'general-valid-html' ) ) { ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<?php } ?>

<!-- website title -->
<title><?php wp_title( '', true ); ?></title>

<!-- website info -->
<meta name="author" content="<?php if ( ! wm_option( 'general-website-author' ) ) echo 'Tiria - www.tiria.fr'; else echo wm_option( 'general-website-author' ); ?>" />
<?php
if ( ! wm_option( 'seo-metaboxes' ) ) :
//Whether to use theme SEO functionality
$metaParam = 'description'; //must be like this for SEO plugins not to detect and try to automatically remove - this can be done in theme options
echo '<meta name="' . $metaParam . '" content="' . wm_seo_desc() . '" />' . "\r\n";
echo '<meta name="keywords" content="' . wm_seo_keywords() . '" />' . "\r\n";
if ( ! wm_option( 'general-valid-html' ) ) {
?>
<meta name="robots" content="<?php
	if ( is_archive() )
		echo wm_option( 'seo-indexing' );
	if (
			is_attachment() ||
			( is_singular() && wm_meta_option( 'seo-noindex' ) )
		)
		echo 'no';
	?>index, follow" />
<!-- Dublin Core Metadata : http://dublincore.org/ -->
<meta name="DC.title" content="<?php bloginfo( 'name' ); ?>" />
<meta name="DC.subject" content="<?php bloginfo('description'); ?>" />
<meta name="DC.creator" content="Tiria - www.tiria.fr" />
<?php
}
endif; //theme SEO enabled?
?>

<?php if ( 'r930' === wm_option( 'layout-width' ) || 'r1160' === wm_option( 'layout-width' ) ) : ?>
<!-- mobile viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<?php endif; ?>
<?php if ( $is_IE ) : ?>
<!--[if lt IE 9]>
<script src="<?php echo $protocol; ?>://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script>window.html5 || document.write('<script src="<?php echo WM_ASSETS_THEME; ?>js/html5.js"><\/script>')</script>
<script src="<?php echo $protocol; ?>://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<?php endif; ?>
<!-- profile and pingback -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- css stylesheets -->
<?php
if ( wm_option( 'design-font-custom' ) )
	echo wm_option( 'design-font-custom' ) . "\r\n";
?>

<?php wm_favicon(); ?>
<!-- wp_head() -->
<?php wp_head(); //WordPress head hook ?>
</head>



<body id="top" <?php body_class(); ?>>
<?php
//Background image fit browser window width
if (
		( isset( $post ) || is_home() ) &&
		wm_css_background_meta( 'background-' ) &&
		wm_meta_option( 'background-bg-img-fit-window', $postId )
	) {
	$imageURL      = wm_meta_option( 'background-bg-img-url', $postId );
	$imagePosition = ( 'fixed' === wm_meta_option( 'background-bg-img-attachment', $postId ) ) ? ( 'fixed' ) : ( 'absolute' );
	echo '<img src="' . $imageURL . '" alt="" style="position: ' . $imagePosition . '; width: 100%; left: 0; top: 0; z-index: 0;" />';
}

//TOP BAR
if ( $isTopBar ) {
	$class = ( wm_option( 'design-top-bar-fixed' ) ) ? ( ' fixed' ) : ( '' );

	echo "\r\n\r\n" . '<div id="top-bar" class="top-bar' . $class . wm_option( 'design-toppanel-icons' ) . '"><div class="wrap-inner"><div class="twelve pane clearfix">' . "\r\n" . '<!-- TOP BAR -->' . apply_filters( 'wmhook_skip_link_navigation_html', "\r\n" . '<a class="invisible" href="#nav-main">' . __( 'Go to main navigation', 'clifden_domain' ) . '</a>' . "\r\n" );

	wm_sidebar( 'top-bar-widgets', 'widgets', 2 ); //restricted to 2 widgets

	echo '<!-- /top-bar --></div></div></div>' . "\r\n\r\n\r\n";
}
?>
<div id="wrap" class="wrap<?php echo $setBgWrap; ?>">


<header id="header" class="clearfix header<?php echo $headerClasses; ?>">
<?php
if ( ! is_page_template( 'tpl-construction.php' ) && ' nav-top' === wm_option( 'layout-navigation-position' ) )
	//display only when top navigation header layout used and not Under construction template
	get_template_part( 'nav' );
?>

<!-- HEADER -->
<div class="wrap-inner">
	<div class="twelve pane clearfix">

	<?php wm_logo(); ?>

	<?php
	if (
			' nav-right' !== wm_option( 'layout-navigation-position' ) ||
			is_page_template( 'tpl-construction.php' ) ||
			( is_page_template( 'tpl-landing.php' ) && ' nav-right' == wm_option( 'layout-navigation-position' ) && ! has_nav_menu( 'menu-landing-page-' . get_the_ID() ) )
		) {

		//Header right area (display only when rich (normal) header layout used)
		$headerText = wm_option( 'layout-header-right' );
		$headerText = ( ' ' == $headerText ) ? ( '' ) : ( $headerText );

		if ( is_page_template( 'tpl-landing.php' ) )
			$headerText = wm_meta_option( 'landing-header-right' );
		if ( is_page_template( 'tpl-construction.php' ) )
			$headerText = wm_meta_option( 'construction-header-right' );

		$replaceArray = array(
			'(c)'    => '&copy;',
			'(C)'    => '&copy;',

			'(r)'    => '&reg;',
			'(R)'    => '&reg;',

			'(tm)'   => '&trade;',
			'(TM)'   => '&trade;',

			'YEAR'   => date( 'Y' ),
			'SEARCH' => get_search_form( false )
		);
		$headerText = strtr( $headerText, $replaceArray );
		$headerText = do_shortcode( $headerText );

		if ( $headerText )
			echo '<div class="header-right">' . apply_filters( 'wmhook_skip_link_navigation_html', '<a class="invisible" href="#nav-main">' . __( 'Go to main navigation', 'clifden_domain' ) . '</a>' ) . '<div>' . $headerText . '</div></div>';

	} else {

		get_template_part( 'nav' );

	}
	?>

	</div>
</div> <!-- /wrap-inner -->

<?php
if ( ! is_page_template( 'tpl-construction.php' ) && ' nav-bottom' === wm_option( 'layout-navigation-position' ) ) {
	//display only when bottom navigation header layout used and not Under construction template
	get_template_part( 'nav' );
}
?>
<!-- /header --></header>


<?php wm_after_header(); ?>

<div id="content" class="content clearfix<?php echo wm_option( 'design-content-icons' ); ?>">
<!-- CONTENT -->

<?php wm_before_main_content(); ?>
