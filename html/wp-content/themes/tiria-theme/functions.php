<?php
/*
*****************************************************
*      Clifden WordPress Theme
*
*      Author: Tiria - www.tiria.fr
*      Initial Author: Webman - www.webmandesign.eu
*****************************************************
*/

/**
 * @since    1.0
 * @version  3.0
 */


/*
* Translation / Localization
*
* The theme splits translation into 4 sections:
*  1) website front-end
*  2) main WordPress admin extensions (like post metaboxes)
*  3) theme's contextual help texts
*  4) theme admin panel (accessed by administrators only)
* You can find all theme translation .PO files (and place translated .MO files) in "clifden/langs/" folder and subsequent subfolders.
*
* Theme uses these textdomains:
*  1) clifden_domain
*  2) clifden_domain_adm
*  3) clifden_domain_help
*  4) clifden_domain_panel
*/



//Getting theme data
	$shortname = get_template();

	$themeData     = wp_get_theme( $shortname );
	$themeName     = $themeData->Name;
	$themeVersion  = $themeData->Version;
	$pageTemplates = wp_get_theme()->get_page_templates();

	if( ! $themeVersion ) {
		$themeVersion = '';
	}

	$options   = $options_ei = $widgetAreas = array();
	$shortname = str_replace( '-v' . $themeVersion, '', $shortname );



//Theme constants
	//Basic constants
		define( 'WM_THEME_NAME',      $themeName );
		define( 'WM_THEME_SHORTNAME', $shortname );
		define( 'WM_THEME_VERSION',   $themeVersion );

		define( 'WM_THEME_SETTINGS_PREFIX', 'wm-' );
		define( 'WM_THEME_SETTINGS',        WM_THEME_SETTINGS_PREFIX . $shortname );
		define( 'WM_THEME_SETTINGS_META',   WM_THEME_SETTINGS_PREFIX . 'meta' );
		define( 'WM_THEME_SETTINGS_STATIC', WM_THEME_SETTINGS . '-static' );

		define( 'WM_ADMIN_LIST_THUMB',         '64x64' ); //thumbnail size (width x height) on post/page/custom post listings
		define( 'WM_CSS_EXPIRATION',           ( WP_DEBUG || 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) ? ( 30 ) : ( 1209600 ) ); //60sec * 60min * 24hours * 14days
		define( 'WM_DEFAULT_EXCERPT_LENGTH',   40 ); //words count
		define( 'WM_SCRIPTS_VERSION',          trim( WM_THEME_VERSION ) );
		define( 'WM_TWITTER_CACHE_EXPIRATION', 900 ); //60sec * 15min
		define( 'WM_WP_COMPATIBILITY',         3.7 );

	//Directories
		define( 'WM_SKINS',      get_template_directory() . '/assets/css/skins/' );
		define( 'WM_CLASSES',    get_template_directory() . '/library/classes/' );
		define( 'WM_CUSTOMS',    get_template_directory() . '/library/custom-posts/' );
		define( 'WM_HELP',       get_template_directory() . '/library/help/' );
		define( 'WM_HOOKS',      get_template_directory() . '/library/hooks/' );
		define( 'WM_LANGUAGES',  get_template_directory() . '/langs' );
		define( 'WM_LIBRARY',    get_template_directory() . '/library/' );
		define( 'WM_META',       get_template_directory() . '/library/meta/' );
		define( 'WM_OPTIONS',    get_template_directory() . '/library/options/' );
		define( 'WM_PRESETS',    get_template_directory() . '/option-presets/' );
		define( 'WM_SHORTCODES', get_template_directory() . '/library/shortcodes/' );
		define( 'WM_SLIDERS',    get_template_directory() . '/library/sliders/' );
		define( 'WM_STYLES',     get_template_directory() . '/library/styles/' );
		define( 'WM_WIDGETS',    get_template_directory() . '/library/widgets/' );

	//URLs
		define( 'WM_ASSETS_THEME', get_template_directory_uri() . '/assets/' );
		define( 'WM_ASSETS_ADMIN', get_template_directory_uri() . '/library/assets/' );

	//Theme layout constants
		//"left", "right", "none"
		define( 'WM_SIDEBAR_FALLBACK',         'default' ); //fallback sidebar ID
		define( 'WM_SIDEBAR_DEFAULT_POSITION', 'right' );
		define( 'WM_SIDEBAR_WIDTH',            ' four pane' );
		//text color switcher treshold
		define( 'WM_COLOR_TRESHOLD', 140 );

	//Others
		define( 'WM_MSG_ACCESS_DENIED', apply_filters( 'wmhook_access_denied_html', '<article class="main twelve pane">[box color="red" icon="warning"]' . __( 'You do not have sufficient rights to display this page.', 'clifden_domain' ) . '[/box]</article>' ) );
		define( 'WM_ONLINE_MANUAL_URL', 'http://www.webmandesign.eu/manual/' . $shortname . '/' );



//Global variables
	//Custom post WordPress admin menu position
		if ( ! isset( $cpMenuPosition ) )
			$cpMenuPosition = array(
				'projects'        => 30,
				'logos'           => 33,
				'slides'          => 36,
				'content-modules' => 39,
				'faq'             => 42,
				'prices'          => 45,
				'staff'           => 48
				);

	//Get theme options
		$themeOptions = get_option( WM_THEME_SETTINGS );

	//Available social icons
		$socialIconsArray = array(
				'behance.net'          => 'Behance',
				'blogspot.com'         => 'Blogger',
				'delicious.com'        => 'Delicious',
				'deviantart.com'       => 'DeviantART',
				'digg.com'             => 'Digg',
				'dribbble.com'         => 'Dribbble',
				'facebook.com'         => 'Facebook',
				'flickr.com'           => 'Flickr',
				'forrst.me'            => 'Forrst',
				'github.com'           => 'GitHub',

				'plus.google.com'      => 'Google+',
				'last.fm'              => 'Lastfm',
				'linkedin.com'         => 'LinkedIn',
				'myspace.com'          => 'MySpace',
				'picasaweb.google.com' => 'Picasa',
				'pinterest.com'        => 'Pinterest',
				'posterous.com'        => 'Posterous',
				'reddit.com'           => 'Reddit',
				'no-rssAnyURL'         => 'RSS',
				'skype:'               => 'Skype',

				'soundcloud.com'       => 'SoundCloud',
				'stumbleupon.com'      => 'StumbleUpon',
				'twitter.com'          => 'Twitter',
				'vimeo.com'            => 'Vimeo',
				'wordpress.com'        => 'WordPress',
				'youtube.com'          => 'YouTube'
			);

	//Font icons
		$fontIcons = array(
				'icon-glass', 'icon-music', 'icon-search', 'icon-envelope-o', 'icon-heart', 'icon-star', 'icon-star-o', 'icon-user', 'icon-film', 'icon-th-large', 'icon-th', 'icon-th-list', 'icon-check', 'icon-remove', 'icon-close', 'icon-times', 'icon-search-plus', 'icon-search-minus', 'icon-power-off', 'icon-signal', 'icon-gear', 'icon-cog', 'icon-trash-o', 'icon-home', 'icon-file-o', 'icon-clock-o', 'icon-road', 'icon-download', 'icon-arrow-circle-o-down', 'icon-arrow-circle-o-up', 'icon-inbox', 'icon-play-circle-o', 'icon-rotate-right', 'icon-repeat', 'icon-refresh', 'icon-list-alt', 'icon-lock', 'icon-flag', 'icon-headphones', 'icon-volume-off', 'icon-volume-down', 'icon-volume-up', 'icon-qrcode', 'icon-barcode', 'icon-tag', 'icon-tags', 'icon-book', 'icon-bookmark', 'icon-print', 'icon-camera', 'icon-font', 'icon-bold', 'icon-italic', 'icon-text-height', 'icon-text-width', 'icon-align-left', 'icon-align-center', 'icon-align-right', 'icon-align-justify', 'icon-list', 'icon-dedent', 'icon-outdent', 'icon-indent', 'icon-video-camera', 'icon-photo', 'icon-image', 'icon-picture-o', 'icon-pencil', 'icon-map-marker', 'icon-adjust', 'icon-tint', 'icon-edit', 'icon-pencil-square-o', 'icon-share-square-o', 'icon-check-square-o', 'icon-arrows', 'icon-step-backward', 'icon-fast-backward', 'icon-backward', 'icon-play', 'icon-pause', 'icon-stop', 'icon-forward', 'icon-fast-forward', 'icon-step-forward', 'icon-eject', 'icon-chevron-left', 'icon-chevron-right', 'icon-plus-circle', 'icon-minus-circle', 'icon-times-circle', 'icon-check-circle', 'icon-question-circle', 'icon-info-circle', 'icon-crosshairs', 'icon-times-circle-o', 'icon-check-circle-o', 'icon-ban', 'icon-arrow-left', 'icon-arrow-right', 'icon-arrow-up', 'icon-arrow-down', 'icon-mail-forward', 'icon-share', 'icon-expand', 'icon-compress', 'icon-plus', 'icon-minus', 'icon-asterisk', 'icon-exclamation-circle', 'icon-gift', 'icon-leaf', 'icon-fire', 'icon-eye', 'icon-eye-slash', 'icon-warning', 'icon-exclamation-triangle', 'icon-plane', 'icon-calendar', 'icon-random', 'icon-comment', 'icon-magnet', 'icon-chevron-up', 'icon-chevron-down', 'icon-retweet', 'icon-shopping-cart', 'icon-folder', 'icon-folder-open', 'icon-arrows-v', 'icon-arrows-h', 'icon-bar-chart-o', 'icon-bar-chart', 'icon-twitter-square', 'icon-facebook-square', 'icon-camera-retro', 'icon-key', 'icon-gears', 'icon-cogs', 'icon-comments', 'icon-thumbs-o-up', 'icon-thumbs-o-down', 'icon-star-half', 'icon-heart-o', 'icon-sign-out', 'icon-linkedin-square', 'icon-thumb-tack', 'icon-external-link', 'icon-sign-in', 'icon-trophy', 'icon-github-square', 'icon-upload', 'icon-lemon-o', 'icon-phone', 'icon-square-o', 'icon-bookmark-o', 'icon-phone-square', 'icon-twitter', 'icon-facebook-f', 'icon-facebook', 'icon-github', 'icon-unlock', 'icon-credit-card', 'icon-rss', 'icon-hdd-o', 'icon-bullhorn', 'icon-bell', 'icon-certificate', 'icon-hand-o-right', 'icon-hand-o-left', 'icon-hand-o-up', 'icon-hand-o-down', 'icon-arrow-circle-left', 'icon-arrow-circle-right', 'icon-arrow-circle-up', 'icon-arrow-circle-down', 'icon-globe', 'icon-wrench', 'icon-tasks', 'icon-filter', 'icon-briefcase', 'icon-arrows-alt', 'icon-group', 'icon-users', 'icon-chain', 'icon-link', 'icon-cloud', 'icon-flask', 'icon-cut', 'icon-scissors', 'icon-copy', 'icon-files-o', 'icon-paperclip', 'icon-save', 'icon-floppy-o', 'icon-square', 'icon-navicon', 'icon-reorder', 'icon-bars', 'icon-list-ul', 'icon-list-ol', 'icon-strikethrough', 'icon-underline', 'icon-table', 'icon-magic', 'icon-truck', 'icon-pinterest', 'icon-pinterest-square', 'icon-google-plus-square', 'icon-google-plus', 'icon-money', 'icon-caret-down', 'icon-caret-up', 'icon-caret-left', 'icon-caret-right', 'icon-columns', 'icon-unsorted', 'icon-sort', 'icon-sort-down', 'icon-sort-desc', 'icon-sort-up', 'icon-sort-asc', 'icon-envelope', 'icon-linkedin', 'icon-rotate-left', 'icon-undo', 'icon-legal', 'icon-gavel', 'icon-dashboard', 'icon-tachometer', 'icon-comment-o', 'icon-comments-o', 'icon-flash', 'icon-bolt', 'icon-sitemap', 'icon-umbrella', 'icon-paste', 'icon-clipboard', 'icon-lightbulb-o', 'icon-exchange', 'icon-cloud-download', 'icon-cloud-upload', 'icon-user-md', 'icon-stethoscope', 'icon-suitcase', 'icon-bell-o', 'icon-coffee', 'icon-cutlery', 'icon-file-text-o', 'icon-building-o', 'icon-hospital-o', 'icon-ambulance', 'icon-medkit', 'icon-fighter-jet', 'icon-beer', 'icon-h-square', 'icon-plus-square', 'icon-angle-double-left', 'icon-angle-double-right', 'icon-angle-double-up', 'icon-angle-double-down', 'icon-angle-left', 'icon-angle-right', 'icon-angle-up', 'icon-angle-down', 'icon-desktop', 'icon-laptop', 'icon-tablet', 'icon-mobile-phone', 'icon-mobile', 'icon-circle-o', 'icon-quote-left', 'icon-quote-right', 'icon-spinner', 'icon-circle', 'icon-mail-reply', 'icon-reply', 'icon-github-alt', 'icon-folder-o', 'icon-folder-open-o', 'icon-smile-o', 'icon-frown-o', 'icon-meh-o', 'icon-gamepad', 'icon-keyboard-o', 'icon-flag-o', 'icon-flag-checkered', 'icon-terminal', 'icon-code', 'icon-mail-reply-all', 'icon-reply-all', 'icon-star-half-empty', 'icon-star-half-full', 'icon-star-half-o', 'icon-location-arrow', 'icon-crop', 'icon-code-fork', 'icon-unlink', 'icon-chain-broken', 'icon-question', 'icon-info', 'icon-exclamation', 'icon-superscript', 'icon-subscript', 'icon-eraser', 'icon-puzzle-piece', 'icon-microphone', 'icon-microphone-slash', 'icon-shield', 'icon-calendar-o', 'icon-fire-extinguisher', 'icon-rocket', 'icon-maxcdn', 'icon-chevron-circle-left', 'icon-chevron-circle-right', 'icon-chevron-circle-up', 'icon-chevron-circle-down', 'icon-html5', 'icon-css3', 'icon-anchor', 'icon-unlock-alt', 'icon-bullseye', 'icon-ellipsis-h', 'icon-ellipsis-v', 'icon-rss-square', 'icon-play-circle', 'icon-ticket', 'icon-minus-square', 'icon-minus-square-o', 'icon-level-up', 'icon-level-down', 'icon-check-square', 'icon-pencil-square', 'icon-external-link-square', 'icon-share-square', 'icon-compass', 'icon-toggle-down', 'icon-caret-square-o-down', 'icon-toggle-up', 'icon-caret-square-o-up', 'icon-toggle-right', 'icon-caret-square-o-right', 'icon-euro', 'icon-eur', 'icon-gbp', 'icon-dollar', 'icon-usd', 'icon-rupee', 'icon-inr', 'icon-cny', 'icon-rmb', 'icon-yen', 'icon-jpy', 'icon-ruble', 'icon-rouble', 'icon-rub', 'icon-won', 'icon-krw', 'icon-bitcoin', 'icon-btc', 'icon-file', 'icon-file-text', 'icon-sort-alpha-asc', 'icon-sort-alpha-desc', 'icon-sort-amount-asc', 'icon-sort-amount-desc', 'icon-sort-numeric-asc', 'icon-sort-numeric-desc', 'icon-thumbs-up', 'icon-thumbs-down', 'icon-youtube-square', 'icon-youtube', 'icon-xing', 'icon-xing-square', 'icon-youtube-play', 'icon-dropbox', 'icon-stack-overflow', 'icon-instagram', 'icon-flickr', 'icon-adn', 'icon-bitbucket', 'icon-bitbucket-square', 'icon-tumblr', 'icon-tumblr-square', 'icon-long-arrow-down', 'icon-long-arrow-up', 'icon-long-arrow-left', 'icon-long-arrow-right', 'icon-apple', 'icon-windows', 'icon-android', 'icon-linux', 'icon-dribbble', 'icon-skype', 'icon-foursquare', 'icon-trello', 'icon-female', 'icon-male', 'icon-gittip', 'icon-gratipay', 'icon-sun-o', 'icon-moon-o', 'icon-archive', 'icon-bug', 'icon-vk', 'icon-weibo', 'icon-renren', 'icon-pagelines', 'icon-stack-exchange', 'icon-arrow-circle-o-right', 'icon-arrow-circle-o-left', 'icon-toggle-left', 'icon-caret-square-o-left', 'icon-dot-circle-o', 'icon-wheelchair', 'icon-vimeo-square', 'icon-turkish-lira', 'icon-try', 'icon-plus-square-o', 'icon-space-shuttle', 'icon-slack', 'icon-envelope-square', 'icon-wordpress', 'icon-openid', 'icon-institution', 'icon-bank', 'icon-university', 'icon-mortar-board', 'icon-graduation-cap', 'icon-yahoo', 'icon-google', 'icon-reddit', 'icon-reddit-square', 'icon-stumbleupon-circle', 'icon-stumbleupon', 'icon-delicious', 'icon-digg', 'icon-pied-piper', 'icon-pied-piper-alt', 'icon-drupal', 'icon-joomla', 'icon-language', 'icon-fax', 'icon-building', 'icon-child', 'icon-paw', 'icon-spoon', 'icon-cube', 'icon-cubes', 'icon-behance', 'icon-behance-square', 'icon-steam', 'icon-steam-square', 'icon-recycle', 'icon-automobile', 'icon-car', 'icon-cab', 'icon-taxi', 'icon-tree', 'icon-spotify', 'icon-deviantart', 'icon-soundcloud', 'icon-database', 'icon-file-pdf-o', 'icon-file-word-o', 'icon-file-excel-o', 'icon-file-powerpoint-o', 'icon-file-photo-o', 'icon-file-picture-o', 'icon-file-image-o', 'icon-file-zip-o', 'icon-file-archive-o', 'icon-file-sound-o', 'icon-file-audio-o', 'icon-file-movie-o', 'icon-file-video-o', 'icon-file-code-o', 'icon-vine', 'icon-codepen', 'icon-jsfiddle', 'icon-life-bouy', 'icon-life-buoy', 'icon-life-saver', 'icon-support', 'icon-life-ring', 'icon-circle-o-notch', 'icon-ra', 'icon-rebel', 'icon-ge', 'icon-empire', 'icon-git-square', 'icon-git', 'icon-hacker-news', 'icon-tencent-weibo', 'icon-qq', 'icon-wechat', 'icon-weixin', 'icon-send', 'icon-paper-plane', 'icon-send-o', 'icon-paper-plane-o', 'icon-history', 'icon-genderless', 'icon-circle-thin', 'icon-header', 'icon-paragraph', 'icon-sliders', 'icon-share-alt', 'icon-share-alt-square', 'icon-bomb', 'icon-soccer-ball-o', 'icon-futbol-o', 'icon-tty', 'icon-binoculars', 'icon-plug', 'icon-slideshare', 'icon-twitch', 'icon-yelp', 'icon-newspaper-o', 'icon-wifi', 'icon-calculator', 'icon-paypal', 'icon-google-wallet', 'icon-cc-visa', 'icon-cc-mastercard', 'icon-cc-discover', 'icon-cc-amex', 'icon-cc-paypal', 'icon-cc-stripe', 'icon-bell-slash', 'icon-bell-slash-o', 'icon-trash', 'icon-copyright', 'icon-at', 'icon-eyedropper', 'icon-paint-brush', 'icon-birthday-cake', 'icon-area-chart', 'icon-pie-chart', 'icon-line-chart', 'icon-lastfm', 'icon-lastfm-square', 'icon-toggle-off', 'icon-toggle-on', 'icon-bicycle', 'icon-bus', 'icon-ioxhost', 'icon-angellist', 'icon-cc', 'icon-shekel', 'icon-sheqel', 'icon-ils', 'icon-meanpath', 'icon-buysellads', 'icon-connectdevelop', 'icon-dashcube', 'icon-forumbee', 'icon-leanpub', 'icon-sellsy', 'icon-shirtsinbulk', 'icon-simplybuilt', 'icon-skyatlas', 'icon-cart-plus', 'icon-cart-arrow-down', 'icon-diamond', 'icon-ship', 'icon-user-secret', 'icon-motorcycle', 'icon-street-view', 'icon-heartbeat', 'icon-venus', 'icon-mars', 'icon-mercury', 'icon-transgender', 'icon-transgender-alt', 'icon-venus-double', 'icon-mars-double', 'icon-venus-mars', 'icon-mars-stroke', 'icon-mars-stroke-v', 'icon-mars-stroke-h', 'icon-neuter', 'icon-facebook-official', 'icon-pinterest-p', 'icon-whatsapp', 'icon-server', 'icon-user-plus', 'icon-user-times', 'icon-hotel', 'icon-bed', 'icon-viacoin', 'icon-train', 'icon-subway', 'icon-medium'
			);
		sort( $fontIcons );

	//Skin attributes
		$skinAtts = array(
				'link-color'           => 'Link color',

				'type-blue-bg-color'   => 'Blue color',
				'type-blue-color'      => 'Text on blue',
				'type-gray-bg-color'   => 'Gray color',
				'type-gray-color'      => 'Text on gray',
				'type-green-bg-color'  => 'Green color',
				'type-green-color'     => 'Text on green',
				'type-orange-bg-color' => 'Orange color',
				'type-orange-color'    => 'Text on orange',
				'type-red-bg-color'    => 'Red color',
				'type-red-color'       => 'Text on red',

				'toppanel-icons'       => 'Top panel icons',
				'header-icons'         => 'Header icons',
				'navigation-icons'     => 'Navigation icons',
				'pageexcerpt-icons'    => 'Page excerpt icons',
				'content-icons'        => 'Content icons',
				'abovefooter-icons'    => 'Above footer icons',
				'breadcrumbs-icons'    => 'Breadcrumbs icons',
				'footer-icons'         => 'Footer icons',
				'bottom-icons'         => 'Bottom icons',

				'font-custom'          => 'Font embed',
				'font-primary'         => 'Font primary',
				'font-secondary'       => 'Font secondary',
				'font-terciary'        => 'Font terciary',
				'font-body-size'       => 'Font size',
			);
		$skinAttsStatic = array(
				'package'             => 'Package',
				'skin'                => 'Skin',
				'description'         => 'Description',
				'version'             => 'Version',
				'author'              => 'Author',

				'body-class'          => 'Body class',

				'font-primary-tags'   => 'Font primary elements',
				'font-secondary-tags' => 'Font secondary elements',
				'font-terciary-tags'  => 'Font terciary elements',

				'border-toppanel'     => 'Top panel bordered',
				'border-header'       => 'Header bordered',
				'border-navigation'   => 'Navigation bordered',
				'border-slider'       => 'Slider bordered',
				'border-mainheading'  => 'Main heading bordered',
				'border-pageexcerpt'  => 'Page excerpt bordered',
				'border-content'      => 'Content bordered',
				'border-abovefooter'  => 'Above footer bordered',
				'border-breadcrumbs'  => 'Breadcrumbs bordered',
				'border-footer'       => 'Footer bordered',
				'border-bottom'       => 'Bottom bordered',
			);
//Global functions
require_once( WM_LIBRARY . 'core.php' );
//Theme settings
require_once( WM_LIBRARY . 'setup.php' );
//Admin functions
require_once( WM_LIBRARY . 'admin.php' );
//Tiria functions
require_once( WM_LIBRARY . 'tiria.php' );
?>