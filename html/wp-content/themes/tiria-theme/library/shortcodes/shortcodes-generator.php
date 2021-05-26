<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* WebMan Shortcodes Generator
*
* CONTENT:
* - 1) Actions and filters
* - 2) Assets needed
* - 3) TinyMCE button registration
* - 4) Shortcodes array
* - 5) Shortcode generator HTML
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );
		if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {
			add_action( 'admin_enqueue_scripts', 'wm_mce_assets', 1000 );
			add_action( 'init', 'wm_shortcode_generator_button' );
			add_action( 'admin_footer', 'wm_add_generator_popup', 1000 );
		}





/*
*****************************************************
*      2) ASSETS NEEDED
*****************************************************
*/
	/*
	* Assets files
	*/
	if ( ! function_exists( 'wm_mce_assets' ) ) {
		function wm_mce_assets() {
			global $pagenow;

			$wmGeneratorIncludes = array( 'post.php', 'post-new.php' );

			if ( in_array( $pagenow, $wmGeneratorIncludes ) ) {

				//WP3.9+ required
					if ( wm_check_wp_version( '3.9' ) ) {
						wp_enqueue_style( 'wp-jquery-ui-dialog' );
						wp_enqueue_script( 'wpdialogs' );
					}

				//styles
				wp_enqueue_style( 'wm-buttons' );

				//scripts
				wp_enqueue_script( 'wm-shortcodes' );
			}
		}
	} // /wm_mce_assets





/*
*****************************************************
*      3) TINYMCE BUTTON REGISTRATION
*****************************************************
*/
	/*
	* Register visual editor custom button position
	*/
	if ( ! function_exists( 'wm_register_tinymce_buttons' ) ) {
		function wm_register_tinymce_buttons( $buttons ) {
			$wmButtons = array( '|', 'wm_mce_button_line_above', 'wm_mce_button_line_below', '|', 'wm_mce_button_shortcodes' );

			array_push( $buttons, implode( ',', $wmButtons ) );

			return $buttons;
		}
	} // /wm_register_tinymce_buttons



	/*
	* Register the button functionality script
	*/
	if ( ! function_exists( 'wm_add_tinymce_plugin' ) ) {
		function wm_add_tinymce_plugin( $plugin_array ) {
			$plugin_array['wm_mce_button'] = WM_ASSETS_ADMIN . 'js/shortcodes/wm-mce-button.js?ver=' . WM_SCRIPTS_VERSION;

			return $plugin_array;
		}
	} // /wm_add_tinymce_plugin



	/*
	* Adding the button to visual editor
	*/
	if ( ! function_exists( 'wm_shortcode_generator_button' ) ) {
		function wm_shortcode_generator_button() {
			if ( ! ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) )
				return;

			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				//filter the tinymce buttons and add custom ones
				add_filter( 'mce_external_plugins', 'wm_add_tinymce_plugin' );
				add_filter( 'mce_buttons_2', 'wm_register_tinymce_buttons' );
			}
		}
	} // /wm_shortcode_generator_button





/*
*****************************************************
*      4) SHORTCODES ARRAY
*****************************************************
*/
	/*
	* Shortcodes settings for Shortcode Generator
	*/
	if ( ! function_exists( 'wm_shortcode_generator_tabs' ) ) {
		function wm_shortcode_generator_tabs() {
			global $socialIconsArray, $fontIcons;
			$imgSizes = array();

			$socialIcons = array();
			foreach ( $socialIconsArray as $network ) {
				$socialIcons[$network] = $network;
			}
			//Get thumbnail sizes - *Added by Tiria*
			$thumbSizes = get_image_sizes();
			foreach ( $thumbSizes as $name => $size ) {
				$imgSizes[$name] = $name.' - '.$size['width'].'x'.$size['height'];
				if ( $size['crop'] ) $imgSizes[$name] .= ' cropped';
			}
			//Get Content Module posts
			$wm_modules_posts = get_posts( array(
				'post_type'   => 'wm_modules',
				'order'       => 'ASC',
				'orderby'     => 'title',
				'numberposts' => -1,
				) );
			$modulePosts = array( '' => '' );
			foreach ( $wm_modules_posts as $post ) {
				$modulePosts[$post->post_name] = $post->post_title;

				$terms = get_the_terms( $post->ID , 'content-module-tag' );
				if ( $terms ) {
					$moduleTags = array();
					foreach ( $terms as $term ) {
						if ( isset( $term->name ) )
							$moduleTags[] = $term->name;
					}
					$modulePosts[$post->post_name] .= sprintf( __( ' (tags: %s)', 'clifden_domain_adm' ), implode( ', ', $moduleTags ) );
				}
			}

			//Get icons
			$menuIcons = array();
			$menuIconsEmpty = array( '' => '' );
			foreach ( $fontIcons as $icon ) {
				$menuIcons[$icon] = ucwords( str_replace( '-', ' ', substr( $icon, 4 ) ) );
			}

			$wmShortcodeGeneratorTabs = array(

				//Accordion
					array(
						'id' => 'accordion',
						'name' => __( 'Accordion', 'clifden_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[accordion_item title=""][/accordion_item]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[accordion][/accordion]</code> parent shortcode.', 'clifden_domain_adm' ),
						'settings' => array(
							'auto' => array(
								'label' => __( 'Automatic accordion', 'clifden_domain_adm' ),
								'desc'  => __( 'Select whether the accordion should automatically animate. You can also set the automatic animation speed in miliseconds if you set a number greater than 1000 for this attribute.', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[accordion{{auto}}] [accordion_item title="TEXT"]TEXT[/accordion_item] [/accordion]'
					),

				//Audio
					array(
						'id' => 'audio',
						'name' => __( 'Audio', 'clifden_domain_adm' ),
						'desc' => __( 'Use syntax of <a href="http://codex.wordpress.org/Audio_Shortcode" target="_blank">WordPress Audio shortcode</a>.', 'clifden_domain_adm' ),
						'settings' => array(
							'src' => array(
								'label' => __( 'MP3 file URL', 'clifden_domain_adm' ),
								'desc'  => __( 'Insert MP3 file URL address', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[audio{{src}} /]'
					),

				//Box
					array(
						'id' => 'box',
						'name' => __( 'Box', 'clifden_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose box color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose an icon for this box', 'clifden_domain_adm' ),
								'value' => array(
									''         => __( 'No icon', 'clifden_domain_adm' ),
									'cancel'   => __( 'Cancel icon', 'clifden_domain_adm' ),
									'check'    => __( 'Check icon', 'clifden_domain_adm' ),
									'info'     => __( 'Info icon', 'clifden_domain_adm' ),
									'question' => __( 'Question icon', 'clifden_domain_adm' ),
									'warning'  => __( 'Warning icon', 'clifden_domain_adm' ),
									)
								),
							'title' => array(
								'label' => __( 'Optional title', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional box title', 'clifden_domain_adm' ),
								'value' => ''
								),
							'transparent' => array(
								'label' => __( 'Opacity', 'clifden_domain_adm' ),
								'desc'  => __( 'Whether box background is colored or not', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Opaque', 'clifden_domain_adm' ),
									'1' => __( 'Transparent', 'clifden_domain_adm' ),
									)
								),
							'hero' => array(
								'label' => __( 'Hero box', 'clifden_domain_adm' ),
								'desc'  => __( 'Specially styled hero box', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Normal box', 'clifden_domain_adm' ),
									'1' => __( 'Hero box', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[box{{color}}{{title}}{{icon}}{{transparent}}{{hero}}]TEXT[/box]'
					),

				//Big text
					array(
						'id' => 'big_text',
						'name' => __( 'Big text', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'clifden_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[big_text]TEXT[/big_text]'
					),

				//Button
					array(
						'id' => 'button',
						'name' => __( 'Button', 'clifden_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'clifden_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'clifden_domain_adm' ),
								'value' => ''
								),
							'color' => array(
								'label' => __( 'Color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose button color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'size' => array(
								'label' => __( 'Size', 'clifden_domain_adm' ),
								'desc'  => __( 'Button size', 'clifden_domain_adm' ),
								'value' => array(
									'm'  => __( 'Medium', 'clifden_domain_adm' ),
									's'  => __( 'Small', 'clifden_domain_adm' ),
									'l'  => __( 'Large', 'clifden_domain_adm' ),
									'xl' => __( 'Extra large', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Align', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'left'  => __( 'Left', 'clifden_domain_adm' ),
									'right' => __( 'Right', 'clifden_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'clifden_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'icon' => array(
								'label' => __( 'Icon image', 'clifden_domain_adm' ),
								'desc'  => __( 'Select optional button icon image', 'clifden_domain_adm' ),
								'value' => array_merge( $menuIconsEmpty, $menuIcons ),
								'image-before' => true,
								),
							'text_color' => array(
								'label'     => __( 'Text color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom text color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							'background_color' => array(
								'label'     => __( 'Background color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom background color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							),
						'output-shortcode' => '[button{{url}}{{color}}{{size}}{{text_color}}{{background_color}}{{align}}{{new_window}}{{icon}}]TEXT[/button]'
					),

				//Call to action
					array(
						'id' => 'cta',
						'name' => __( 'Call to action', 'clifden_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Optional title', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional call to action title', 'clifden_domain_adm' ),
								'value' => ''
								),
							'subtitle' => array(
								'label' => __( 'Optional subtitle', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional call to action subtitle', 'clifden_domain_adm' ),
								'value' => ''
								),
							'button_url' => array(
								'label' => __( 'Button URL', 'clifden_domain_adm' ),
								'desc'  => __( 'Button link URL address', 'clifden_domain_adm' ),
								'value' => ''
								),
							'button_text' => array(
								'label' => __( 'Button text', 'clifden_domain_adm' ),
								'desc'  => __( 'Button text', 'clifden_domain_adm' ),
								'value' => ''
								),
							'button_color' => array(
								'label' => __( 'Button color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose button color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'new_window' => array(
								'label' => __( 'New window', 'clifden_domain_adm' ),
								'desc'  => __( 'Open URL address in new window when button clicked', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'color' => array(
								'label' => __( 'Area color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose call to action area color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Transparent', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'background_pattern' => array(
								'label' => __( 'Background pattern', 'clifden_domain_adm' ),
								'desc'  => __( 'Call to action background pattern', 'clifden_domain_adm' ),
								'value' => array(
									''              => '',
									'stripes-dark'  => __( 'Dark stripes', 'clifden_domain_adm' ),
									'stripes-light' => __( 'Light stripes', 'clifden_domain_adm' ),
									'squares'       => __( 'Squares', 'clifden_domain_adm' ),
									'checker'       => __( 'Checker', 'clifden_domain_adm' ),
									'dots'          => __( 'Dots', 'clifden_domain_adm' ),
									'http://URL'    => __( 'Custom image URL address', 'clifden_domain_adm' ),
									)
								),
							'text_color' => array(
								'label'     => __( 'Text color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom text color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							'background_color' => array(
								'label'     => __( 'Background color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom background color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							),
						'output-shortcode' => '[call_to_action{{title}}{{subtitle}}{{button_text}}{{button_url}}{{button_color}}{{new_window}}{{color}}{{background_color}}{{text_color}}{{background_pattern}}]TEXT[/call_to_action]'
					),

				//Columns
					array(
						'id' => 'columns',
						'name' => __( 'Columns', 'clifden_domain_adm' ),
						'settings' => array(
							'size' => array(
								'label' => __( 'Column size', 'clifden_domain_adm' ),
								'desc'  => __( 'Select column size', 'clifden_domain_adm' ),
								'value' => array(
									'1OPTGROUP'   =>  __( 'Halfs', 'clifden_domain_adm' ),
										'1/2'      => '1/2',
										'1/2 last' => '1/2' . __( ' last in row', 'clifden_domain_adm' ),
									'1/OPTGROUP'  => '',
									'2OPTGROUP'   =>  __( 'Thirds', 'clifden_domain_adm' ),
										'1/3'      => '1/3',
										'1/3 last' => '1/3' . __( ' last in row', 'clifden_domain_adm' ),
										'2/3'      => '2/3',
										'2/3 last' => '2/3' . __( ' last in row', 'clifden_domain_adm' ),
									'2/OPTGROUP'  => '',
									'3OPTGROUP'   =>  __( 'Quarters', 'clifden_domain_adm' ),
										'1/4'      => '1/4',
										'1/4 last' => '1/4' . __( ' last in row', 'clifden_domain_adm' ),
										'3/4'      => '3/4',
										'3/4 last' => '3/4' . __( ' last in row', 'clifden_domain_adm' ),
									'3/OPTGROUP'  => '',
									'4OPTGROUP'   =>  __( 'Fifths', 'clifden_domain_adm' ),
										'1/5'      => '1/5',
										'1/5 last' => '1/5' . __( ' last in row', 'clifden_domain_adm' ),
										'2/5'      => '2/5',
										'2/5 last' => '2/5' . __( ' last in row', 'clifden_domain_adm' ),
										'3/5'      => '3/5',
										'3/5 last' => '3/5' . __( ' last in row', 'clifden_domain_adm' ),
										'4/5'      => '4/5',
										'4/5 last' => '4/5' . __( ' last in row', 'clifden_domain_adm' ),
									'4/OPTGROUP'  => '',
									'5OPTGROUP'   =>  __( 'Sixths', 'clifden_domain_adm' ),
										'1/6'      => '1/6',
										'1/6 last' => '1/6' . __( ' last in row', 'clifden_domain_adm' ),
										'5/6'      => '5/6',
										'5/6 last' => '5/6' . __( ' last in row', 'clifden_domain_adm' ),
									'5/OPTGROUP'  => '',
									)
								),
							'class' => array(
								'label' => __( 'Custom CSS class', 'clifden_domain_adm' ),
								'desc'  => __( 'Insert optional custom CSS class', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[column{{size}}{{class}}]TEXT[/column]'
					),

				//Content Modules
					array(
						'id' => 'content_module',
						'name' => __( 'Content Module', 'clifden_domain_adm' ),
						'settings' => array(
							'id' => array(
								'label' => __( 'Content Module', 'clifden_domain_adm' ),
								'desc'  => __( 'Select Content Module to display', 'clifden_domain_adm' ),
								'value' => $modulePosts
								),
							'randomize' => array(
								'label' => __( 'Or randomize from', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a tag from where random content module will be chosen', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select tag', 'clifden_domain_adm' ),
										'hierarchical' => '0',
										'tax'          => 'content-module-tag',
									) )
								),
							'no_thumb' => array(
								'label' => __( 'Thumb', 'clifden_domain_adm' ),
								'desc'  => __( 'Select whether you want the thumbnail image to be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'clifden_domain_adm' ),
									'1' => __( 'Hide', 'clifden_domain_adm' )
									)
								),
							'no_title' => array(
								'label' => __( 'Title', 'clifden_domain_adm' ),
								'desc'  => __( 'Select whether you want the module title to be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Show', 'clifden_domain_adm' ),
									'1' => __( 'Hide', 'clifden_domain_adm' )
									)
								),
							'layout' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose which layout to use', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'center' => __( 'Centered', 'clifden_domain_adm' )
									)
								),
							),
						'output-shortcode' => '[content_module{{id}}{{randomize}}{{no_thumb}}{{no_title}}{{layout}} /]'
					),

				//Countdown timer
					array(
						'id' => 'countdown',
						'name' => __( 'Countdown timer', 'clifden_domain_adm' ),
						'settings' => array(
							'time' => array(
								'label' => __( 'Time <small>YYYY-MM-DD HH:mm</small>', 'clifden_domain_adm' ),
								'desc'  => __( 'Insert the time in "YYYY-MM-DD HH:mm" format (Y = year, M = month, D = day, H = hours, m = minutes)', 'clifden_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Timer size', 'clifden_domain_adm' ),
								'desc'  => __( 'Select timer size', 'clifden_domain_adm' ),
								'value' => array(
									'xl' => __( 'Extra large', 'clifden_domain_adm' ),
									'l'  => __( 'Large', 'clifden_domain_adm' ),
									'm'  => __( 'Medium', 'clifden_domain_adm' ),
									's'  => __( 'Small', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[countdown{{time}}{{size}} /]'
					),

				//Divider
					array(
						'id' => 'divider',
						'name' => __( 'Divider', 'clifden_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Type of divider', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''              => __( 'Spacer', 'clifden_domain_adm' ),
									'dots'          => __( 'Dotted border', 'clifden_domain_adm' ),
									'dashes'        => __( 'Dashed border', 'clifden_domain_adm' ),
									'shadow-top'    => __( 'Shadow top', 'clifden_domain_adm' ),
									'shadow-bottom' => __( 'Shadow bottom', 'clifden_domain_adm' ),
									)
								),
							'top_link' => array(
								'label' => __( 'Display top link', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'height' => array(
								'label' => __( 'Space height', 'clifden_domain_adm' ),
								'desc'  => __( 'Height of empty space after divider (in pixels). If border is visible, there will be also 30px top margin applied.', 'clifden_domain_adm' ),
								'value' => array(
									''    => __( 'Default', 'clifden_domain_adm' ),
									'10'  => 10,
									'20'  => 20,
									'30'  => 30,
									'40'  => 40,
									'50'  => 50,
									'60'  => 60,
									'70'  => 70,
									'80'  => 80,
									'90'  => 90,
									'100' => 100,
									'110' => 110,
									'120' => 120,
									'130' => 130,
									'140' => 140,
									'150' => 150,
									'160' => 160,
									'170' => 170,
									'180' => 180,
									'190' => 190,
									'200' => 200,
									'210' => 210,
									'220' => 220,
									'230' => 230,
									'240' => 240,
									'250' => 250,
									'260' => 260,
									'270' => 270,
									'280' => 280,
									'290' => 290,
									'300' => 300,
									'300' => 300,
									'310' => 310,
									'320' => 320,
									'330' => 330,
									'340' => 340,
									'350' => 350,
									'360' => 360,
									'370' => 370,
									'380' => 380,
									'390' => 390,
									'400' => 400
									)
								),
							'no_border' => array(
								'label' => __( 'Border', 'clifden_domain_adm' ),
								'desc'  => __( 'Select whether you want to display or hide the border. Only for spacers.', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'1' => __( 'No', 'clifden_domain_adm' )
									)
								),
							'opacity' => array(
								'label' => __( 'Shadow opacity', 'clifden_domain_adm' ),
								'desc'  => __( 'Percentual value of shadow opacity - 0 = transparent, 100 = opaque', 'clifden_domain_adm' ),
								'value' => array(
									''    => __( 'Default', 'clifden_domain_adm' ),
									'5'  => 5,
									'10' => 10,
									'15' => 15,
									'20' => 20,
									'25' => 25,
									'30' => 30,
									'35' => 35,
									'40' => 40,
									'45' => 45,
									'50' => 50,
									'55' => 55,
									'60' => 60,
									'65' => 65,
									'70' => 70,
									'75' => 75,
									'80' => 80,
									'85' => 85,
									'90' => 90,
									'95' => 95,
									)
								),
							),
						'output-shortcode' => '[divider{{type}}{{top_link}}{{height}}{{no_border}}{{opacity}} /]'
					),

				//Dropcaps
					array(
						'id' => 'dropcaps',
						'name' => __( 'Dropcaps', 'clifden_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Dropcap type', 'clifden_domain_adm' ),
								'desc'  => __( 'Select prefered dropcap styling', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Basic dropcap', 'clifden_domain_adm' ),
									'round'  => __( 'Rounded dropcap', 'clifden_domain_adm' ),
									'square' => __( 'Squared dropcap', 'clifden_domain_adm' ),
									'leaf'   => __( 'Leaf dropcap', 'clifden_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[dropcap{{type}}]A[/dropcap]'
					),

				//FAQ
					'faq' => array(
						'id' => 'faq',
						'name' => __( 'FAQ', 'clifden_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag. However, note that this will disable the filter. FAQ shortcode can not be on the same page with the Projects shortcode when animation (filter) used.', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'FAQ category', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_faq',
										'allText'      => __( 'All FAQs', 'clifden_domain_adm' ),
										'tax'          => 'faq-category',
									) )
								),
							'filter' => array(
								'label' => __( 'Filter', 'clifden_domain_adm' ),
								'desc'  => __( 'Whether to display filter and where to place it', 'clifden_domain_adm' ),
								'value' => array(
									''      => __( 'No filter', 'clifden_domain_adm' ),
									'above' => __( 'Filter above the FAQ list', 'clifden_domain_adm' ),
									'left'  => __( 'Filter left from FAQ list', 'clifden_domain_adm' ),
									'right' => __( 'Filter right from FAQ list', 'clifden_domain_adm' ),
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'filter_color' => array(
								'label' => __( 'Filter color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose filter color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'clifden_domain_adm' ),
								'desc'  => __( 'Description text alignement (when used - it will disable the filter)', 'clifden_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'clifden_domain_adm' ),
									'right' => __( 'Description text on the right', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[faq{{category}}{{filter}}{{order}}{{filter_color}}{{align}}][/faq]'
					),

				//Gallery
					array(
						'id' => 'gallery',
						'name' => __( 'Gallery', 'clifden_domain_adm' ),
						'desc' => __( 'Please upload images for the post/page gallery via "Add Media" button above visual editor.', 'clifden_domain_adm' ),
						'settings' => array(
							'columns' => array(
								'label' => __( 'Columns', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of gallery columns', 'clifden_domain_adm' ),
								'value' => array(
									1 => 1,
									2 => 2,
									3 => 3,
									4 => 4,
									5 => 5,
									6 => 6,
									)
								),
							'flexible' => array(
								'label' => __( 'Flexibile layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Preserves images aspect ratio and uses masonry display', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'frame' => array(
								'label' => __( 'Framed', 'clifden_domain_adm' ),
								'desc'  => __( 'Display frame around images', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'remove' => array(
								'label' => __( 'Remove', 'clifden_domain_adm' ),
								'desc'  => __( 'Image order numbers separated with commas (like "1,2,5" will remove first, second and fifth image from gallery)', 'clifden_domain_adm' ),
								'value' => ''
								),
							'sardine' => array(
								'label' => __( 'Sardine', 'clifden_domain_adm' ),
								'desc'  => __( 'Removes margins around images', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[gallery{{columns}}{{flexible}}{{frame}}{{remove}}{{sardine}} /]'
					),

				//Huge text
					array(
						'id' => 'huge_text',
						'name' => __( 'Huge text', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'clifden_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[huge_text]TEXT[/huge_text]'
					),

				//Icons
					array(
						'id' => 'icon',
						'name' => __( 'Icons', 'clifden_domain_adm' ),
						'desc' => __( 'Only predefined icons of Font Awesome can be displayed with this shortcode.', 'clifden_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Icon type', 'clifden_domain_adm' ),
								'desc'  => __( 'Select one of predefined icons', 'clifden_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							'size' => array(
								'label' => __( 'Icon size', 'clifden_domain_adm' ),
								'desc'  => __( 'Set the "font-size" CSS rule compatible values', 'clifden_domain_adm' ),
								'value' => '',
								)
							),
						'output-shortcode' => '[icon{{type}}{{size}} /]'
					),

				//Lists
					array(
						'id' => 'lists',
						'name' => __( 'Lists', 'clifden_domain_adm' ),
						'settings' => array(
							'icon' => array(
								'label' => __( 'Bullet image', 'clifden_domain_adm' ),
								'desc'  => __( 'Select list bullet image', 'clifden_domain_adm' ),
								'value' => $menuIcons,
								'image-before' => true,
								),
							),
						'output-shortcode' => '[list{{icon}}]' . __( 'Unordered list goes here', 'clifden_domain_adm' ) . '[/list]'
					),

				//Last update
					array(
						'id' => 'lastupdate',
						'name' => __( 'Last update', 'clifden_domain_adm' ),
						'desc' => __( 'Displays the date when most recent blog post or project was added.', 'clifden_domain_adm' ),
						'settings' => array(
							'item' => array(
								'label' => __( 'Items to watch', 'clifden_domain_adm' ),
								'desc'  => __( 'What item group will be watched for last update date', 'clifden_domain_adm' ),
								'value' => array(
									''        => __( 'Blog posts', 'clifden_domain_adm' ),
									'project' => __( 'Projects', 'clifden_domain_adm' ),
									)
								),
							'format' => array(
								'label' => __( 'Date format', 'clifden_domain_adm' ),
								'desc'  => "",
								'value' => array(
									get_option( 'date_format' ) => date( get_option( 'date_format' ) ),
									'F j, Y'                    => date( 'F j, Y' ),
									'M j, Y'                    => date( 'M j, Y' ),
									'jS F Y'                    => date( 'jS F Y' ),
									'jS M Y'                    => date( 'jS M Y' ),
									'j F Y'                     => date( 'j F Y' ),
									'j M Y'                     => date( 'j M Y' ),
									'j. n. Y'                   => date( 'j. n. Y' ),
									'j. F Y'                    => date( 'j. F Y' ),
									'j. M Y'                    => date( 'j. M Y' ),
									'Y/m/d'                     => date( 'Y/m/d' ),
									'm/d/Y'                     => date( 'm/d/Y' ),
									'd/m/Y'                     => date( 'd/m/Y' ),
									)
								),
							),
						'output-shortcode' => '[last_update{{format}}{{item}} /]'
					),

				//Login form
					array(
						'id' => 'login',
						'name' => __( 'Login form', 'clifden_domain_adm' ),
						'settings' => array(
							'stay' => array(
								'label' => __( 'Redirection', 'clifden_domain_adm' ),
								'desc'  => __( 'Where the user will be redirected to after successful log in', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Go to homepage', 'clifden_domain_adm' ),
									'1' => __( 'Stay here', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[login{{stay}} /]'
					),

				//Logos
					'logos' => array(
						'id' => 'logos',
						'name' => __( 'Logos', 'clifden_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Logos category', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_logos',
										'allText'      => __( 'All logos', 'clifden_domain_adm' ),
										'tax'          => 'logos-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'clifden_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'clifden_domain_adm' ),
									'3' => __( '3 columns', 'clifden_domain_adm' ),
									'4' => __( '4 columns', 'clifden_domain_adm' ),
									'5' => __( '5 columns', 'clifden_domain_adm' ),
									'6' => __( '6 columns', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Logo count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'clifden_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'clifden_domain_adm' ),
									'right' => __( 'Description text on the right', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[logos{{category}}{{columns}}{{count}}{{order}}{{align}}][/logos]'
					),


				//Email nospam
					array(
						'id' => 'mailprotect',
						'name' => __( 'Mail spam protection', 'clifden_domain_adm' ),
						'settings' => array(
							'mail' => array(
								'label' => __( 'Mail', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => ''
								),
							'link' => array(
								'label' => __( 'Active link', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									'1'  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'class' => array(
								'label' => __( 'Additional classes', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => ''
								)
							),
						'output-shortcode' => '[mailprotect{{mail}}{{link}}{{class}} /]'
					),
				//Map - Added by Tiria
					array(
						'id' => 'map',
						'name' => __( 'Map', 'clifden_domain_adm' ),
						'desc' => __( 'You can include a single map on your page with this shortcode, multiples maps dont work.', 'clifden_domain_adm' ),
						'settings' => array(
							'height' => array(
								'label' => __( 'Height', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose height of map (default 300px)', 'clifden_domain_adm' ),
								'value' => '',
								'maxlength' => 6
								),
							'width' => array(
								'label'     => __( 'Width', 'clifden_domain_adm' ),
								'desc'      => __( 'Choose width of map (default 100%)', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							'lat' => array(
								'label'     => __( 'Latitude', 'clifden_domain_adm' ),
								'desc'      => __( 'Latitude of address you want to display', 'clifden_domain_adm' ),
								'value'     => '0',
								'maxlength' => 12
								),
							'long' => array(
								'label'     => __( 'Longitude', 'clifden_domain_adm' ),
								'desc'      => __( 'Longitude of address you want to display', 'clifden_domain_adm' ),
								'value'     => '0',
								'maxlength' => 12
								),
							'zoom' => array(
								'label'     => __( 'Zoom', 'clifden_domain_adm' ),
								'desc'      => __( 'Define default zoom on map (default:12)', 'clifden_domain_adm' ),
								'value'     => '12',
								'maxlength' => 12
								),
							'marker' => array(
								'label'     => __( 'Marker', 'clifden_domain_adm' ),
								'desc'      => __( 'Define if you want marker to be displayed on map', 'clifden_domain_adm' ),
								'value' => array(
									'false'  => __( 'Hidden', 'clifden_domain_adm' ),
									'true'   => __( 'Normal', 'clifden_domain_adm' ),
									'bounce' => __( 'Bounce', 'clifden_domain_adm' ),
									)
								),
							'info' => array(
								'label'     => __( 'Info text', 'clifden_domain_adm' ),
								'desc'      => __( 'Define the text you want to display when click on marker (need a marker to be displayed)', 'clifden_domain_adm' ),
								'value' 	=> '',
								'maxlength' => 255
								),
							'saturation' => array(
								'label'     => __( 'Saturation', 'clifden_domain_adm' ),
								'desc'      => __( '0=black and white map, 100=colored map', 'clifden_domain_adm' ),
								'value' 	=> '0',
								'maxlength' => 3
								),
							'style' => array(
								'label'     => __( 'Style', 'clifden_domain_adm' ),
								'desc'      => __( 'Define the map styling', 'clifden_domain_adm' ),
								'value' => array(
									'theme'   => __( 'Default theme styling', 'clifden_domain_adm' ),
									'nopoi'   => __( 'Disable point of interest', 'clifden_domain_adm' ),
									'notext'  => __( 'Disable all text', 'clifden_domain_adm' ),
									'default' => __( 'Default google map styling', 'clifden_domain_adm' ),
									)
								),
							'invert' => array(
								'label'     => __( 'Color invert', 'clifden_domain_adm' ),
								'desc'      => __( 'If you want color to be inverted', 'clifden_domain_adm' ),
								'value' => array(
									'false' => __( 'No', 'clifden_domain_adm' ),
									'true'  => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[mgmap{{height}}{{width}}{{lat}}{{long}}{{invert}}{{zoom}}{{style}}{{marker}}{{saturation}}{{info}} /]'
					),
				
				//Marker
					array(
						'id' => 'marker',
						'name' => __( 'Marker', 'clifden_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose marker color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'gray'   => __( 'Gray', 'clifden_domain_adm' ),
									'green'  => __( 'Green', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'red'    => __( 'Red', 'clifden_domain_adm' ),
									)
								),
							'text_color' => array(
								'label'     => __( 'Text color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom text color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							'background_color' => array(
								'label'     => __( 'Background color', 'clifden_domain_adm' ),
								'desc'      => __( 'Custom background color. Use hexadecimal color code without "#".', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 6
								),
							),
						'output-shortcode' => '[marker{{color}}{{text_color}}{{background_color}}]TEXT[/marker]'
					),

				//Posts *Modified by Tiria* - added : 1 column, datedisplay, thumbsize
					array(
						'id' => 'posts',
						'name' => __( 'Posts', 'clifden_domain_adm' ),
						'desc' => __( 'Does not display Quote and Status posts. You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Posts category', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array()
								),
							'columns' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'clifden_domain_adm' ),
								'value' => array(
									'1' => __( '1 column', 'clifden_domain_adm' ),
									'2' => __( '2 columns', 'clifden_domain_adm' ),
									'3' => __( '3 columns', 'clifden_domain_adm' ),
									'4' => __( '4 columns', 'clifden_domain_adm' ),
									'5' => __( '5 columns', 'clifden_domain_adm' ),
									'6' => __( '6 columns', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Posts count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'excerpt_length' => array(
								'label' => __( 'Excerpt length', 'clifden_domain_adm' ),
								'desc'  => __( 'In words', 'clifden_domain_adm' ),
								'value' => array(
									''  => '',
									'0' => 0,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'clifden_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'clifden_domain_adm' ),
									'right' => __( 'Description text on the right', 'clifden_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'thumbsize' => array( 
								'label' => __( 'Thumbnail image size', 'clifden_domain_adm' ),
								'desc'  => __( 'Select thumbnail size it will display', 'clifden_domain_adm' ),
								'value' => $imgSizes
								),
							'datedisplay' => array( 
								'label' => __( 'Date of post', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'catdisplay' => array( 
								'label' => __( 'Display post categories', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'related' => array(
								'label' => __( 'Display related posts?', 'clifden_domain_adm' ),
								'desc'  => __( 'Displays related posts to the current post upon its category and tags settings.', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'social' => array( 
								'label' => __( 'Social share', 'clifden_domain_adm' ),
								'desc' => __( 'Display share buttons for selected social networks', 'clifden_domain_adm' ),
								'value' => array(
									'fb' => 'Facebook',
									'tt' => 'Twitter',
									'in' => 'LinkedIn',
									'gp' => 'Google+',
									),
								'multiple' => true
								),
							),
						'output-shortcode' => '[posts{{category}}{{columns}}{{count}}{{excerpt_length}}{{order}}{{align}}{{thumb}}{{thumbsize}}{{datedisplay}}{{catdisplay}}{{related}}{{social}}][/posts]'
					),
				
				//Posts slideshow *Added by Tiria*
					array(
						'id' => 'posts_slideshow',
						'name' => __( 'Posts Slideshow', 'clifden_domain_adm' ),
						'desc' => __( 'Display posts in a slideshow', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Posts category', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array()
								),
							'columns' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Select number of columns to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => __( '1 column', 'clifden_domain_adm' ),
									'2' => __( '2 columns', 'clifden_domain_adm' ),
									'3' => __( '3 columns', 'clifden_domain_adm' ),
									'4' => __( '4 columns', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Posts count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									)
								),
							'excerpt_length' => array(
								'label' => __( 'Excerpt length', 'clifden_domain_adm' ),
								'desc'  => __( 'In words', 'clifden_domain_adm' ),
								'value' => array(
									''  => '',
									'0' => 0,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'thumbsize' => array( 
								'label' => __( 'Thumbnail image size', 'clifden_domain_adm' ),
								'desc'  => __( 'Select thumbnail size it will display', 'clifden_domain_adm' ),
								'value' => $imgSizes
								),
							'datedisplay' => array( 
								'label' => __( 'Date of post', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'catdisplay' => array( 
								'label' => __( 'Categories of post', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'timer' => array( 
								'label' => __( 'Slideshow time', 'clifden_domain_adm' ),
								'desc' => __( 'how much time a slide display in seconds', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Default', 'clifden_domain_adm' ),
									'5000' => 5,
									'6000' => 6,
									'7000' => 7,
									'8000' => 8,
									'9000' => 9,
									'10000' => 10,
									'11000' => 11,
									'12000' => 12,
									'13000' => 13,
									'14000' => 14,
									'15000' => 15,
									'none'  => __( 'None', 'clifden_domain_adm' ),
									)
								),
							'social' => array( 
								'label' => __( 'Social share', 'clifden_domain_adm' ),
								'desc' => __( 'display share buttons for selected social networks', 'clifden_domain_adm' ),
								'value' => array(
									'fb' => 'Facebook',
									'tt' => 'Twitter',
									'in' => 'LinkedIn',
									'gp' => 'Google+',
									),
								'multiple' => true
								),
							),
						'output-shortcode' => '[posts_slideshow{{category}}{{columns}}{{count}}{{excerpt_length}}{{order}}{{thumb}}{{thumbsize}}{{datedisplay}}{{catdisplay}}{{timer}}{{social}}][/posts_slideshow]'
					),

				//Price table
					'prices' => array(
						'id' => 'price_table',
						'name' => __( 'Price Table', 'clifden_domain_adm' ),
						'settings' => array(
							'table' => array(
								'label' => __( 'Select table', 'clifden_domain_adm' ),
								'desc'  => __( 'Select price table to display', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => '',
										'allText'      => __( 'Select price table', 'clifden_domain_adm' ),
										'hierarchical' => '0',
										'tax'          => 'price-table',
									) )
								),
							),
						'output-shortcode' => '[prices{{table}} /]'
					),

				//Projects
					'projects' => array(
						'id' => 'projects',
						'name' => __( 'Projects', 'clifden_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag. Can not be on the same page with the FAQ shortcode when animation (filter) used.', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Projects category', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_projects',
										'allText'      => __( 'All projects', 'clifden_domain_adm' ),
										'parentsOnly'  => true,
										'tax'          => 'project-category',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'clifden_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'clifden_domain_adm' ),
									'3' => __( '3 columns', 'clifden_domain_adm' ),
									'4' => __( '4 columns', 'clifden_domain_adm' ),
									'5' => __( '5 columns', 'clifden_domain_adm' ),
									'6' => __( '6 columns', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Projects count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'' => __( 'All projects (in category)', 'clifden_domain_adm' ),
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'clifden_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'clifden_domain_adm' ),
									'right' => __( 'Description text on the right', 'clifden_domain_adm' ),
									)
								),
							'filter' => array(
								'label' => __( 'Projects filter', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional projects filter', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No filter', 'clifden_domain_adm' ),
									'1' => __( 'Animated filtering', 'clifden_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[projects{{align}}{{filter}}{{columns}}{{count}}{{category}}{{order}}{{thumb}}][/projects]'
					),

				//Project attributes
					'projectAtts' => array(
						'id' => 'project_attributes',
						'name' => __( 'Project attributes', 'clifden_domain_adm' ),
						'desc' => __( 'Use on project page only. Displays table of project attributes.', 'clifden_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Title', 'clifden_domain_adm' ),
								'desc'  => __( 'Attributes table title', 'clifden_domain_adm' ),
								'value' => ''
								)
							),
						'output-shortcode' => '[project_attributes{{title}} /]'
					),

				//Pullquote
					array(
						'id' => 'pullquote',
						'name' => __( 'Pullquote', 'clifden_domain_adm' ),
						'settings' => array(
							'align' => array(
								'label' => __( 'Align', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose pullquote alignment', 'clifden_domain_adm' ),
								'value' => array(
									'left'  => __( 'Left', 'clifden_domain_adm' ),
									'right' => __( 'Right', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[pullquote{{align}}]TEXT[/pullquote]'
					),

				//Raw / pre
					array(
						'id' => 'raw',
						'name' => __( 'Raw preformated text', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'clifden_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[raw]TEXT[/raw]'
					),

				//Section
					array(
						'id' => 'section',
						'name' => __( 'Section', 'clifden_domain_adm' ),
						'desc' => __( 'Use on "Sections" page template only! This will split the page into sections. You can set a custom CSS class and then style the sections individually. You can use "alt" class for alternative section styling.', 'clifden_domain_adm' ),
						'settings' => array(
							'class' => array(
								'label' => __( 'Class', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional CSS class name', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[section{{class}}]TEXT[/section]'
					),

				//Slideshow
					array(
						'id' => 'slideshow',
						'name' => __( 'Slideshow', 'clifden_domain_adm' ),
						'settings' => array(
							'group' => array(
								'label' => __( 'Slides group', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose which Slides custom post group should be displayed', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_slides',
										'allText'      => __( 'Select group of slides', 'clifden_domain_adm' ),
										'parentsOnly'  => true,
										'tax'          => 'slide-category',
									) )
								),
							'images' => array(
								'label' => __( 'Image URLs', 'clifden_domain_adm' ),
								'desc'  => __( 'Insert image URL addresses separated with commas or type in "gallery" to display post image gallery in slideshow', 'clifden_domain_adm' ),
								'value' => ''
								),
							'links' => array(
								'label' => __( 'Image links', 'clifden_domain_adm' ),
								'desc'  => __( 'If image URLs set, you can set also links that will be applied on those images. Keep the structure (number) the same as for Image URLs, separate each link (even empty) with comma.', 'clifden_domain_adm' ),
								'value' => ''
								),
							'time' => array(
								'label' => __( 'Time in seconds', 'clifden_domain_adm' ),
								'desc'  => __( 'Time to display one slide in seconds', 'clifden_domain_adm' ),
								'value' => array(
									'1'  => 1,
									'2'  => 2,
									'3'  => 3,
									'4'  => 4,
									'5'  => 5,
									'6'  => 6,
									'7'  => 7,
									'8'  => 8,
									'9'  => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'caption' => array(
								'label' => __( 'Caption', 'clifden_domain_adm' ),
								'desc'  => __( 'Display captions', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'background' => array(
								'label' => __( 'Background', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose caption background', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Default', 'clifden_domain_adm' ),
									'white'  => __( 'White', 'clifden_domain_adm' ),
									'black' => __( 'Black', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Align', 'clifden_domain_adm' ),
								'desc'  => __( 'Choose caption alignment', 'clifden_domain_adm' ),
								'value' => array(
									'bottom' => __( 'Bottom', 'clifden_domain_adm' ),
									'center' => __( 'Center', 'clifden_domain_adm' ),
									'top'  => __( 'Top', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[slideshow{{group}}{{images}}{{links}}{{time}}{{caption}}{{background}}{{align}} /]'
					),

				//Small text
					array(
						'id' => 'small_text',
						'name' => __( 'Small text', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'clifden_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[small_text]TEXT[/small_text]'
					),

				//Social icons
					array(
						'id' => 'social',
						'name' => __( 'Social', 'clifden_domain_adm' ),
						'settings' => array(
							'url' => array(
								'label' => __( 'Link URL', 'clifden_domain_adm' ),
								'desc'  => __( 'Social icon link URL address', 'clifden_domain_adm' ),
								'value' => ''
								),
							'icon' => array(
								'label' => __( 'Icon', 'clifden_domain_adm' ),
								'desc'  => __( 'Select icon to be displayed', 'clifden_domain_adm' ),
								'value' => $socialIcons
								),
							'title' => array(
								'label' => __( 'Title text', 'clifden_domain_adm' ),
								'desc'  => __( 'This text will be displayed when mouse hovers over the icon', 'clifden_domain_adm' ),
								'value' => ''
								),
							'size' => array(
								'label' => __( 'Icon size', 'clifden_domain_adm' ),
								'desc'  => __( 'Select icon size', 'clifden_domain_adm' ),
								'value' => array(
									's'  => __( 'Small', 'clifden_domain_adm' ),
									'm'  => __( 'Medium', 'clifden_domain_adm' ),
									'l'  => __( 'Large', 'clifden_domain_adm' ),
									'xl' => __( 'Extra large', 'clifden_domain_adm' ),
									)
								),
							'rel' => array(
								'label' => __( 'Optional link relation', 'clifden_domain_adm' ),
								'desc'  => __( 'This will set up the link "rel" HTML attribute', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[social{{url}}{{icon}}{{title}}{{size}}{{rel}} /]'
					),

				//Staff
					'staff' => array(
						'id' => 'staff',
						'name' => __( 'Staff', 'clifden_domain_adm' ),
						'desc' => __( 'You can include a description of the list created with the shortcode. Just place the text between opening and closing shortcode tag.', 'clifden_domain_adm' ),
						'settings' => array(
							'department' => array(
								'label' => __( 'Department', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a department from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array(
										'allCountPost' => 'wm_staff',
										'allText'      => __( 'All staff', 'clifden_domain_adm' ),
										'tax'          => 'department',
									) )
								),
							'columns' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => __( 'Select number of columns to lay out the list', 'clifden_domain_adm' ),
								'value' => array(
									'2' => __( '2 columns', 'clifden_domain_adm' ),
									'3' => __( '3 columns', 'clifden_domain_adm' ),
									'4' => __( '4 columns', 'clifden_domain_adm' ),
									'5' => __( '5 columns', 'clifden_domain_adm' ),
									'6' => __( '6 columns', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Staff count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'name'   => __( 'By name', 'clifden_domain_adm' ),
									'new'    => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'align' => array(
								'label' => __( 'Description align', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional list description alignement', 'clifden_domain_adm' ),
								'value' => array(
									''      => '',
									'left'  => __( 'Description text on the left', 'clifden_domain_adm' ),
									'right' => __( 'Description text on the right', 'clifden_domain_adm' ),
									)
								),
							'thumb' => array(
								'label' => __( 'Thumbnail image', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							'category' => array(
								'label' => __( 'Display category', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'margin' => array(
								'label' => __( 'Margin', 'clifden_domain_adm' ),
								'desc'  => __( 'Separate columns', 'clifden_domain_adm' ),
								'value' => array(
									''  => __( 'Yes', 'clifden_domain_adm' ),
									'0' => __( 'No', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[staff{{department}}{{columns}}{{count}}{{order}}{{align}}{{thumb}}{{category}}{{margin}}][/staff]'
					),

				//Statuses
					'status' => array(
						'id' => 'status',
						'name' => __( 'Status', 'clifden_domain_adm' ),
						'settings' => array(
							'date' => array(
								'label' => __( 'Display date', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								),
							'count' => array(
								'label' => __( 'Statuses count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'speed' => array(
								'label' => __( 'Speed in seconds', 'clifden_domain_adm' ),
								'desc'  => __( 'If set, statuses will be animated. This sets the time to display one status in seconds', 'clifden_domain_adm' ),
								'value' => array(
									''   => '',
									'1'  => 1,
									'2'  => 2,
									'3'  => 3,
									'4'  => 4,
									'5'  => 5,
									'6'  => 6,
									'7'  => 7,
									'8'  => 8,
									'9'  => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'layout' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => __( 'Normal', 'clifden_domain_adm' ),
									'large' => __( 'Large', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[status{{date}}{{count}}{{speed}}{{layout}} /]'
					),
					
				//styles by TIRIA
					array(
						'id' => 'styles',
						'name' => __( 'Styles', 'clifden_domain_adm' ),
						'settings' => array(
							'color' => array(
								'label' => __( 'Color', 'clifden_domain_adm' ),
								'desc'  => __( 'Prefefined text color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'grey'   => __( 'Grey', 'clifden_domain_adm' ),
									'dark-grey'  => __( 'Dark grey', 'clifden_domain_adm' ),
									'white'    => __( 'White', 'clifden_domain_adm' ),
									)
								),
							'background' => array(
								'label' => __( 'Background', 'clifden_domain_adm' ),
								'desc'  => __( 'Predefined background color', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Default', 'clifden_domain_adm' ),
									'orange' => __( 'Orange', 'clifden_domain_adm' ),
									'blue'   => __( 'Blue', 'clifden_domain_adm' ),
									'grey'   => __( 'Grey', 'clifden_domain_adm' ),
									'dark-grey'  => __( 'Dark grey', 'clifden_domain_adm' ),
									'white'    => __( 'White', 'clifden_domain_adm' ),
									)
								),
							'class' => array(
								'label'     => __( 'Class', 'clifden_domain_adm' ),
								'desc'      => __( 'Predefined class', 'clifden_domain_adm' ),
								'value'     => '',
								'maxlength' => 80
								),
							'type' => array(
								'label'     => __( 'Tag type', 'clifden_domain_adm' ),
								'desc'      => __( 'Type of html tag to generate', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Paragraph (p)', 'clifden_domain_adm' ),
									'h1' => __( 'Title 1 (h1)', 'clifden_domain_adm' ),
									'h2' => __( 'Title 2 (h2)', 'clifden_domain_adm' ),
									'h3' => __( 'Title 3 (h3)', 'clifden_domain_adm' ),
									'h4' => __( 'Title 4 (h4)', 'clifden_domain_adm' ),
									'h5' => __( 'Title 5 (h5)', 'clifden_domain_adm' ),
									'h6' => __( 'Title 6 (h6)', 'clifden_domain_adm' ),
									'span'   => __( 'Portion of text (span)', 'clifden_domain_adm' ),
									'div'   => __( 'Block (div)', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[styles{{color}}{{background}}{{class}}{{type}}]TEXT[/styles]'
					),

				//Subpages
					array(
						'id' => 'subpages',
						'name' => __( 'Subpages', 'clifden_domain_adm' ),
						'settings' => array(
							'depth' => array(
								'label' => __( 'Hierarchy levels', 'clifden_domain_adm' ),
								'desc'  => __( 'Select the depth of page hierarchy to display', 'clifden_domain_adm' ),
								'value' => array(
									'0' => __( 'All levels', 'clifden_domain_adm' ),
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									'menu'  => __( 'By menu order', 'clifden_domain_adm' ),
									'title' => __( 'By title', 'clifden_domain_adm' ),
									)
								),
							'parents' => array(
								'label' => __( 'Display parents?', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[subpages{{depth}}{{order}}{{parents}} /]'
					),

				//Table
					array(
						'id' => 'table',
						'name' => __( 'Table', 'clifden_domain_adm' ),
						'desc' => __( 'For simple data tables use the shortcode below.', 'clifden_domain_adm' ) . '<br />' . __( 'However, if you require more control over your table you can use sub-shortcodes for table row (<code>[trow][/trow]</code> or <code>[trow_alt][/trow_alt]</code> for alternatively styled table row), table cell (<code>[tcell][/tcell]</code>) and table heading cell (<code>[tcell_heading][/tcell_heading]</code>). All wrapped in <code>[table][/table]</code> parent shortcode.', 'clifden_domain_adm' ),
						'settings' => array(
							'cols' => array(
								'label' => __( 'Heading row', 'clifden_domain_adm' ),
								'desc'  => __( 'Titles of columns, separated with separator character. This is required to determine the number of columns for the table.', 'clifden_domain_adm' ),
								'value' => ''
								),
							'data' => array(
								'label' => __( 'Table data', 'clifden_domain_adm' ),
								'desc'  => __( 'Table cells data separated with separator character. Will be automatically aligned into columns (depending on "Heading row" setting).', 'clifden_domain_adm' ),
								'value' => ''
								),
							'separator' => array(
								'label' => __( 'Separator character', 'clifden_domain_adm' ),
								'desc'  => __( 'Individual table cell data separator used in previous input fields', 'clifden_domain_adm' ),
								'value' => ';'
								),
							'heading_col' => array(
								'label' => __( 'Heading column', 'clifden_domain_adm' ),
								'desc'  => __( 'If you wish to display a whole column of the table as a heading, set its order number here', 'clifden_domain_adm' ),
								'value' => array(
									''  => '',
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10
									)
								),
							'class' => array(
								'label' => __( 'CSS class', 'clifden_domain_adm' ),
								'desc'  => __( 'Optional custom css class applied on the table HTML tag', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[table{{class}}{{cols}}{{data}}{{separator}}{{heading_col}} /]'
					),

				//Tabs
					array(
						'id' => 'tabs',
						'name' => __( 'Tabs', 'clifden_domain_adm' ),
						'desc' => __( 'Please, copy the <code>[tab title=""][/tab]</code> sub-shortcode as many times as you need. But keep them wrapped in <code>[tabs][/tabs]</code> parent shortcode.', 'clifden_domain_adm' ),
						'settings' => array(
							'type' => array(
								'label' => __( 'Tabs type', 'clifden_domain_adm' ),
								'desc'  => __( 'Select tabs styling', 'clifden_domain_adm' ),
								'value' => array(
									''              => __( 'Normal tabs', 'clifden_domain_adm' ),
									'fullwidth'     => __( 'Full width tabs', 'clifden_domain_adm' ),
									'vertical'      => __( 'Vertical tabs', 'clifden_domain_adm' ),
									'vertical tour' => __( 'Vertical tabs - tour', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[tabs{{type}}] [tab title="TEXT"]TEXT[/tab] [/tabs]'
					),

				//Testimonials
					'testimonials' => array(
						'id' => 'testimonials',
						'name' => __( 'Testimonials', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode will display Quote posts. If featured image of the post set, it will be used as quoted person photo (please upload square images only).', 'clifden_domain_adm' ),
						'settings' => array(
							'category' => array(
								'label' => __( 'Category (required)', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a category from where the list will be populated', 'clifden_domain_adm' ),
								'value' => wm_tax_array( array( 'all' => false ) )
								),
							'count' => array(
								'label' => __( 'Testimonials count', 'clifden_domain_adm' ),
								'desc'  => __( 'Number of items to display', 'clifden_domain_adm' ),
								'value' => array(
									'1' => 1,
									'2' => 2,
									'3' => 3,
									'4' => 4,
									'5' => 5,
									'6' => 6,
									'7' => 7,
									'8' => 8,
									'9' => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									)
								),
							'order' => array(
								'label' => __( 'Order', 'clifden_domain_adm' ),
								'desc'  => __( 'Select order in which items will be displayed', 'clifden_domain_adm' ),
								'value' => array(
									''       => __( 'Newest first', 'clifden_domain_adm' ),
									'old'    => __( 'Oldest first', 'clifden_domain_adm' ),
									'random' => __( 'Randomly', 'clifden_domain_adm' ),
									)
								),
							'speed' => array(
								'label' => __( 'Speed in seconds', 'clifden_domain_adm' ),
								'desc'  => __( 'Time to display one testimonial in seconds', 'clifden_domain_adm' ),
								'value' => array(
									''  => '',
									'3'  => 3,
									'4'  => 4,
									'5'  => 5,
									'6'  => 6,
									'7'  => 7,
									'8'  => 8,
									'9'  => 9,
									'10' => 10,
									'11' => 11,
									'12' => 12,
									'13' => 13,
									'14' => 14,
									'15' => 15,
									'16' => 16,
									'17' => 17,
									'18' => 18,
									'19' => 19,
									'20' => 20,
									)
								),
							'layout' => array(
								'label' => __( 'Layout', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => __( 'Normal', 'clifden_domain_adm' ),
									'large' => __( 'Large', 'clifden_domain_adm' ),
									)
								),
							'private' => array(
								'label' => __( 'Display private posts?', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[testimonials{{category}}{{count}}{{order}}{{speed}}{{layout}}{{private}} /]'
					),

				//Toggles
					array(
						'id' => 'toggles',
						'name' => __( 'Toggles', 'clifden_domain_adm' ),
						'settings' => array(
							'title' => array(
								'label' => __( 'Toggle title', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => ''
								),
							'open' => array(
								'label' => __( 'Open by default?', 'clifden_domain_adm' ),
								'desc'  => '',
								'value' => array(
									''      => '',
									''  => __( 'No', 'clifden_domain_adm' ),
									'1' => __( 'Yes', 'clifden_domain_adm' ),
									)
								)
							),
						'output-shortcode' => '[toggle{{title}}{{open}}]TEXT[/toggle]'
					),

				//Uppercase text
					array(
						'id' => 'uppercase',
						'name' => __( 'Uppercase text', 'clifden_domain_adm' ),
						'desc' => __( 'This shortcode has no settings.', 'clifden_domain_adm' ),
						'settings' => array(),
						'output-shortcode' => '[uppercase]TEXT[/uppercase]'
					),

				//Videos
					array(
						'id' => 'video',
						'name' => __( 'Video', 'clifden_domain_adm' ),
						'desc' => __( 'Use syntax of <a href="http://codex.wordpress.org/Video_Shortcode" target="_blank">WordPress Video shortcode</a>.', 'clifden_domain_adm' ),
						'settings' => array(
							'src' => array(
								'label' => __( 'Video URL', 'clifden_domain_adm' ),
								'desc'  => __( 'Insert YouTube, Vimeo, Screenr or self-hosted video URL address', 'clifden_domain_adm' ),
								'value' => ''
								),
							),
						'output-shortcode' => '[video{{src}} /]'
					),

				//Widget areas
					array(
						'id' => 'widgetarea',
						'name' => __( 'Widget area', 'clifden_domain_adm' ),
						'settings' => array(
							'area' => array(
								'label' => __( 'Area to display', 'clifden_domain_adm' ),
								'desc'  => __( 'Select a widget area from dropdown menu', 'clifden_domain_adm' ),
								'value' => wm_widget_areas()
								),
							'style' => array(
								'label' => __( 'Style', 'clifden_domain_adm' ),
								'desc'  => __( 'Widgets layout of the widget area', 'clifden_domain_adm' ),
								'value' => array(
									''              => __( 'Horizontal', 'clifden_domain_adm' ),
									'vertical'      => __( 'Vertical', 'clifden_domain_adm' ),
									'sidebar-left'  => __( 'Sidebar left', 'clifden_domain_adm' ),
									'sidebar-right' => __( 'Sidebar right', 'clifden_domain_adm' ),
									)
								),
							),
						'output-shortcode' => '[widgets{{area}}{{style}} /]'
					)

			);

			//remove shortcodes from array if Custom Posts or Post Formats disabled
				if ( 'disable' === wm_option( 'general-role-faq' ) )
					unset( $wmShortcodeGeneratorTabs['faq'] );
				if ( 'disable' === wm_option( 'general-role-logos' ) )
					unset( $wmShortcodeGeneratorTabs['logos'] );
				if ( 'disable' === wm_option( 'general-role-prices' ) )
					unset( $wmShortcodeGeneratorTabs['prices'] );
				if ( 'disable' === wm_option( 'general-role-projects' ) ) {
					unset( $wmShortcodeGeneratorTabs['projects'] );
					unset( $wmShortcodeGeneratorTabs['projectAtts'] );
				}
				if ( 'disable' === wm_option( 'general-role-staff' ) )
					unset( $wmShortcodeGeneratorTabs['staff'] );
				if ( wm_option( 'blog-no-format-status' ) )
					unset( $wmShortcodeGeneratorTabs['status'] );
				if ( wm_option( 'blog-no-format-quote' ) )
					unset( $wmShortcodeGeneratorTabs['testimonials'] );

			return $wmShortcodeGeneratorTabs;
		}
	} // /wm_shortcode_generator_tabs





/*
*****************************************************
*      5) SHORTCODE GENERATOR HTML
*****************************************************
*/
	/*
	* Shortcode generator popup form
	*/
	if ( ! function_exists( 'wm_add_generator_popup' ) ) {
		function wm_add_generator_popup() {
			$shortcodes = wm_shortcode_generator_tabs();

			$out = '
				<div id="wm-shortcode-generator" class="selectable">
				<div id="wm-shortcode-form">
				';

			if ( ! empty( $shortcodes ) ) {

				//tabs
				/*
				$out .= '<ul class="wm-tabs">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<li><a href="#' . $shortcodeId . '">' . $shortcode['name'] . '</a></li>';
				}
				$out .= '</ul>';
				*/

				//select
				$out .= '<div class="wm-select-wrap"><label for="select-shortcode">' . __( 'Select a shortcode:', 'clifden_domain_adm' ) . '</label><select id="select-shortcode" class="wm-select">';
				foreach ( $shortcodes as $shortcode ) {
					$shortcodeId = 'wm-generate-' . $shortcode['id'];
					$out .= '<option value="#' . $shortcodeId . '">' . $shortcode['name'] . '</option>';
				}
				$out .= '</select></div>';

				//content
				$out .= '<div class="wm-tabs-content">';
				foreach ( $shortcodes as $shortcode ) {

					$shortcodeId     = 'wm-generate-' . $shortcode['id'];
					$settings        = ( isset( $shortcode['settings'] ) ) ? ( $shortcode['settings'] ) : ( null );
					$shortcodeOutput = ( isset( $shortcode['output-shortcode'] ) ) ? ( $shortcode['output-shortcode'] ) : ( null );
					$close           = ( isset( $shortcode['close'] ) ) ? ( ' ' . $shortcode['close'] ) : ( null );
					$settingsCount   = count( $settings );

					$out .= '
						<div id="' . $shortcodeId . '" class="tab-content">
						<p class="shortcode-title"><strong>' . $shortcode['name'] . '</strong> ' . __( 'shortcode', 'clifden_domain_adm' ) . '</p>
						';

					if ( isset( $shortcode['desc'] ) && $shortcode['desc'] )
						$out .= '<p class="shortcode-desc">' . $shortcode['desc'] . '</p>';

					$out .= '
						<div class="form-wrap">
						<form method="get" action="">
						<table class="items-' . $settingsCount . '">
						';

					if ( $settings ) {
						$i = 0;
						foreach ( $settings as $id => $labelValue ) {
							$i++;
							$desc      = ( isset( $labelValue['desc'] ) ) ? ( esc_attr( $labelValue['desc'] ) ) : ( '' );
							$maxlength = ( isset( $labelValue['maxlength'] ) ) ? ( ' maxlength="' . absint( $labelValue['maxlength'] ) . '"' ) : ( '' );

							$out .= '<tr class="item-' . $i . '"><td>';
							$out .= '<label for="' . $shortcodeId . '-' . $id . '" title="' . $desc . '">' . $labelValue['label'] . '</label></td><td>';
							if ( is_array( $labelValue['value'] ) ) {
								$imageBefore  = ( isset( $labelValue['image-before'] ) && $labelValue['image-before'] ) ? ( '<div class="image-before"></div>' ) : ( '' );
								$shorterClass = ( $imageBefore ) ? ( ' class="shorter set-image"' ) : ( '' );
								
								$selectMultiple = ( isset( $labelValue['multiple'] ) && $labelValue['multiple'] ) ? ( ' multiple="multiple"' ) : ( '' );
								
								$out .= $imageBefore . '<select name="' . $shortcodeId . '-' . $id . '" id="' . $shortcodeId . '-' . $id . '" title="' . $desc . '" data-attribute="' . $id . '"' . $shorterClass . $selectMultiple . '>';
								foreach ( $labelValue['value'] as $value => $valueName ) {
									if ( 'OPTGROUP' === substr( $value, 1 ) )
										$out .= '<optgroup label="' . $valueName . '">';
									elseif ( '/OPTGROUP' === substr( $value, 1 ) )
										$out .= '</optgroup>';
									else
										$out .= '<option value="' . $value . '">' . $valueName . '</option>';
								}
								$out .= '</select>';

							} else {

								$out .= '<input type="text" name="' . $shortcodeId . '-' . $id . '" value="' . $labelValue['value'] . '" id="' . $shortcodeId . '-' . $id . '" class="widefat" title="' . $desc . '"' . $maxlength . ' data-attribute="' . $id . '" /><img src="' . WM_ASSETS_ADMIN . 'img/shortcodes/add16.png" alt="' . __( 'Apply changes', 'clifden_domain_adm' ) . '" title="' . __( 'Apply changes', 'clifden_domain_adm' ) . '" class="ico-apply" />';

							}
							$out .= '</td></tr>';
						}
					}

					$out .= '<tr><td>&nbsp;</td><td><p><a data-parent="' . $shortcodeId . '" class="send-to-generator button-primary">' . __( 'Insert into editor', 'clifden_domain_adm' ) . '</a></p></td></tr>';
					$out .= '
						</table>
						</form>
						';
					$out .= '<p><strong>' . __( 'Or copy and paste in this shortcode:', 'clifden_domain_adm' ) . '</strong></p>';
					$out .= '<form><textarea class="wm-shortcode-output' . $close . '" cols="30" rows="2" readonly="readonly" onfocus="this.select();" data-reference="' . esc_attr( $shortcodeOutput ) . '">' . esc_attr( $shortcodeOutput ) . '</textarea></form>';
					$out .= '<!-- /form-wrap --></div>';
					$out .= '<!-- /tab-content --></div>';

				}
				$out .= '<!-- /wm-tabs-content --></div>';

			}

			$out .= '
				<!-- /wm-shortcode-form --></div>
				<p class="credits"><small>&copy; <a href="http://www.tiria.fr" target="_blank">Tiria</a></small></p>
				<!-- /wm-shortcode-generator --></div>
				';

			echo $out;
		}
	} // /wm_add_generator_popup

?>