<?php
/**
 * @since    1.0
 * @version  3.0
 */

/*
* Include the TGM_Plugin_Activation class.
*/
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );



/*
* Register the required plugins for this theme.
*
* This function is hooked into tgmpa_init, which is fired within the
* TGM_Plugin_Activation class constructor.
*/
function my_theme_register_required_plugins() {
	/*
	* Array of plugin arrays. Required keys are name and slug.
	* If the source is NOT from the .org repo, then source is also required.
	*/
	$plugins = array(
		// Pre-packaged with a theme
		array(
			'name'               => 'Revolution Slider', // The plugin name
			'slug'               => 'revslider', // The plugin slug (typically the folder name)
			'source'             => WM_LIBRARY . 'plugins/revslider.zip', // The plugin source
			'required'           => true, // If false, the plugin is only 'recommended' instead of required
			'version'            => '4.6.92', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '', // If set, overrides default API URL and points to an external URL
		),
	);

	tgmpa( $plugins );
}

?>