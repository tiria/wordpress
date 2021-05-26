<?php
/**************************************************************
 *                                                            *
 *   Provides a notification to the user everytime            *
 *   your WordPress theme is updated                          *
 *                                                            *
 *   Author: Joao Araujo                                      *
 *   Profile: http://themeforest.net/user/unisphere           *
 *   Follow me: http://twitter.com/unispheredesign            *
 *                                                            *
 **************************************************************/

/**
 * @since    1.0
 * @version  3.0
 */

/*
*
* Modified by WebMan - www.webmandesign.eu
*
* CONTENT:
* 1) Constants
* 2) Actions and filters
* 3) Dashboard menu and admin bar
* 4) Update notifier page
* 5) Remote XML data
*
*/





/*
*****************************************************
*      1) CONTSTANTS
*****************************************************
*/
	//Constants for the theme name, folder and remote XML url
	define( 'NOTIFIER_XML_FILE', 'http://www.webmandesign.eu/updates/' . WM_THEME_SHORTNAME . '/' . WM_THEME_SHORTNAME . '-version.xml' ); //The remote notifier XML file containing the latest version of the theme and changelog
	define( 'NOTIFIER_CACHE_INTERVAL', 86400 ); //The time interval for the remote XML cache in the database (86400 seconds = 24 hours)





/*
*****************************************************
*      2) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
	add_action( 'admin_menu', 'update_notifier_menu' );
	add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );





/*
*****************************************************
*      3) DASHBOARD MENU AND ADMIN BAR
*****************************************************
*/
	//Adds an update notification to the WordPress Dashboard menu
	function update_notifier_menu() {
		if ( function_exists( 'simplexml_load_string' ) ) { //Stop if simplexml_load_string funtion isn't available
			if ( ! is_super_admin() ) //Don't display notification if the current user isn't an administrator
				return;

			$xml = get_latest_theme_version( NOTIFIER_CACHE_INTERVAL ); //Get the latest remote XML file on our server

			//support for nested point releases (such as v1.0.1) - works for versions of up to 9.9
			$latestVersion    = sanitize_title( str_replace( '.', '', $xml->latest ) ); //1.0.1 => 101
			$latestVersion    = substr( $latestVersion, 0, 1 ) . '.' . substr( $latestVersion, 1 ); //101 => 1.01
			$installedVersion = sanitize_title( str_replace( '.', '', WM_THEME_VERSION ) ); //1.0.1 => 101
			$installedVersion = substr( $installedVersion, 0, 1 ) . '.' . substr( $installedVersion, 1 ); //101 => 1.01

			if ( (float) $latestVersion > (float) $installedVersion ) { //Compare current theme version with the remote XML version
				add_theme_page(
					//page_title
					sprintf( __( '%s Theme Updates', 'clifden_domain_adm' ), WM_THEME_NAME ),
					//menu_title
					__( 'Theme Updates', 'clifden_domain_adm' ) . ' <span class="update-plugins count-1"><span class="update-count">1</span></span>',
					//capability
					'switch_themes',
					//menu_slug
					'theme-update-notifier',
					//function
					'update_notifier'
				);
			}
		}
	} // /update_notifier_menu



	//Adds an update notification to the WordPress 3.1+ Admin Bar
	function update_notifier_bar_menu() {
		if ( function_exists( 'simplexml_load_string' ) ) { //Stop if simplexml_load_string funtion isn't available
			global $wp_admin_bar, $wpdb;

			if ( ! is_super_admin() || ! is_admin_bar_showing() ) //Don't display notification in admin bar if it's disabled or the current user isn't an administrator
				return;

			$xml = get_latest_theme_version( NOTIFIER_CACHE_INTERVAL ); //Get the latest remote XML file on our server

			//support for nested point releases (such as v1.0.1) - works for versions of up to 9.9
			$latestVersion    = sanitize_title( str_replace( '.', '', $xml->latest ) ); //1.0.1 => 101
			$latestVersion    = substr( $latestVersion, 0, 1 ) . '.' . substr( $latestVersion, 1 ); //101 => 1.01
			$installedVersion = sanitize_title( str_replace( '.', '', WM_THEME_VERSION ) ); //1.0.1 => 101
			$installedVersion = substr( $installedVersion, 0, 1 ) . '.' . substr( $installedVersion, 1 ); //101 => 1.01

			if( (float) $latestVersion > (float) $installedVersion ) { //Compare current theme version with the remote XML version
				$wp_admin_bar->add_menu( array(
						'id'    => 'update_notifier',
						'title' => '<span>' . WM_THEME_NAME . ' <span id="ab-updates">1</span></span>',
						'href'  => get_admin_url() . 'themes.php?page=theme-update-notifier'
					) );
			}
		}
	} // /update_notifier_bar_menu





/*
*****************************************************
*      4) UPDATE NOTIFIER PAGE
*****************************************************
*/
	function update_notifier() {
		$xml = get_latest_theme_version( NOTIFIER_CACHE_INTERVAL ); // Get the latest remote XML file on our server
		?>
		<div class="wrap update-notifier">

			<div id="icon-tools" class="icon32"></div>
			<h2><?php printf( __( '<strong>%s</strong> Theme Updates', 'clifden_domain_adm' ), WM_THEME_NAME ); ?></h2>

			<br />

			<div id="message" class="updated below-h2">
				<p>
				<strong><?php echo $xml->message; ?></strong><br />
				<?php printf( __( 'You have version %1$s installed. Update to version %2$s.', 'clifden_domain_adm' ), WM_THEME_VERSION, trim( $xml->latest ) ); ?>
				</p>
			</div>

			<div id="instructions">
				<?php
				if ( isset( $xml->instructions ) && trim( $xml->instructions ) ) {
					echo trim( $xml->instructions );
				} else {
				?>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/screenshot.png" alt="" class="theme-img" />

					<h3><?php _e( 'Update Download and Instructions', 'clifden_domain_adm' ); ?></h3>

					<p><?php _e( 'To update the theme, login to <a href="http://www.themeforest.net/" target="_blank">ThemeForest</a>, head over to <strong>downloads section</strong> and re-download the theme like you did when you bought it. Feel free to leave any feedback and rating :)', 'clifden_domain_adm' ); ?></p>

					<p><?php _e( 'To install the new updated theme unzipp the zipped theme package file obtained from ThemeForest on your computer. Open the theme package folder and head over to <code>install</code> subfolder where you will find a theme installation ZIP file.', 'clifden_domain_adm' ); ?></p>

					<p><?php _e( 'Now use one of these options to update the theme:', 'clifden_domain_adm' ); ?></p>

					<ol>
						<li>
							<strong><?php _e( 'Easier, but might take longer time', 'clifden_domain_adm' ); ?></strong><br />
							<?php _e( 'Unzip the theme installation ZIP file on your computer. Upload the unzipped theme folder using FTP client to your server (into <code>YOUR_WORDPRESS_INSTALLATION/wp-content/themes/</code>) overwriting all the current theme files.', 'clifden_domain_adm' ); ?>

							<p class="note"><?php _e( "<strong>Note:</strong> <em>If you didn't make any changes to the theme files, you are free to overwrite files with the new ones without the risk of loosing theme settings, pages, posts, etc, and backwards compatibility is guaranteed. In case you have made changes to the theme files, make sure you have a backup copy of your changes before you overwrite theme files.</em>", 'clifden_domain_adm' ); ?></p>
						</li>
						<li>
							<strong><?php _e( 'More advanced', 'clifden_domain_adm' ); ?></strong><br />
							<?php printf( __( 'Upload the theme installation ZIP file using FTP client to your server (into <code>YOUR_WORDPRESS_INSTALLATION/wp-content/themes/</code>). Using your FTP client, rename the old theme folder (for example from %1s to %2s). When the old theme folder is renamed, unzip the theme installation zip file on the server. After checking if the theme works fine, delete the renamed old theme folder from server (or keep it as a backup, but it will take space on your server unnecessarily...).', 'clifden_domain_adm' ), '<code>' . WM_THEME_SHORTNAME . '</code>', '<code>' . WM_THEME_SHORTNAME . '-old</code>' ); ?>
						</li>
					</ol>
				<?php } ?>
			</div>

			<div id="changelog" class="note">
				<div class="icon32 icon32-posts-page" id="icon-edit-pages"><br /></div><h2><?php _e( 'Update Changes', 'clifden_domain_adm' ); ?></h2>
				<?php echo $xml->changelog; ?>
				<hr />
				<h3><?php _e( 'Files changed:', 'clifden_domain_adm' ); ?></h3>
				<code><?php echo str_replace( ', ', '</code><br /><code>', $xml->changefiles ); ?></code>
			</div>
		</div>
		<?php
	} // /update_notifier





/*
*****************************************************
*      5) REMOTE XML DATA
*****************************************************
*/
	//Get the remote XML file contents and return its data (Version and Changelog)
	//Uses the cached version if available and inside the time interval defined
	function get_latest_theme_version( $interval ) {
		$db_cache_field              = 'notifier-cache-' . WM_THEME_SHORTNAME;
		$db_cache_field_last_updated = 'notifier-cache-' . WM_THEME_SHORTNAME . '-last-updated';
		$last                        = get_option( $db_cache_field_last_updated );
		$now                         = time();

		//check the cache
		if ( ! $last || ( ( $now - $last ) > $interval ) || 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) {

			//cache doesn't exist, or is old, so refresh it
			$response = wp_remote_get( NOTIFIER_XML_FILE );
			if ( is_wp_error( $response ) ) {
				$error = $response->get_error_message();
				$cache = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><message><![CDATA[<span style="font-size:125%;color:#f33">Something went wrong: ' . $error . '</span>]]></message><changelog></changelog><changefiles></changefiles></notifier>';
			} else {
				$cache = $response['body'];
			}

			if ( $cache ) {
				//we got good results
				update_option( $db_cache_field, $cache );
				update_option( $db_cache_field_last_updated, time() );
			}

			//read from the cache file
			$notifier_data = get_option( $db_cache_field );

		} else {

			//cache file is fresh enough, so read from it
			$notifier_data = get_option( $db_cache_field );

		}

		//Let's see if the $xml data was returned as we expected it to.
		//If it didn't, use the default 1.0 as the latest version so that we don't have problems when the remote server hosting the XML file is down
		if ( strpos( (string) $notifier_data, '<notifier>' ) === false ) {
			$notifier_data = '<?xml version="1.0" encoding="UTF-8"?><notifier><latest>1.0</latest><message></message><changelog></changelog><changefiles></changefiles></notifier>';
		}

		//Load the remote XML data into a variable and return it
		$xml = simplexml_load_string( $notifier_data );

		return $xml;
	} // /get_latest_theme_version

?>