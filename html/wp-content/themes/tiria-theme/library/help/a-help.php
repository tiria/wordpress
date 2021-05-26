<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Contextual help texts
*****************************************************
*/





/*
* Generate shortcode help
*
* $shortcodes - ARRAY [shortcodes description array]
*
* example of $shortcodes info:
* array(
*   'titleDesc'   => 'Shortcode_title_description',
*   'title'       => 'Shortcode_title',
*   'example'     => 'Shortcode_example_usage',
*   'description' => array( 'Shortcode_description_each_paragraph_separate_array_item' ),
*   'parameters'  => array(
*     'Parameter_name' => array(
*       'Parameter_type',
*       'Parameter_description'
*     ),
*   ),
* )
*/
if ( ! function_exists( 'wm_help_shortcodes' ) ) {
	function wm_help_shortcodes( $shortcodes ) {

		if ( ! is_array( $shortcodes ) || empty( $shortcodes ) )
			return '';

		$out = '';

		$replaceArray = array(
			'desc' => array(
				'[' => '<code>[',
				']' => ']</code>',
				'{' => '<code>',
				'}' => '</code>',
			),
			'param' => array(
				'{'  => '<code>',
				'}'  => '</code>',
				'=d' => '<sup title="' . __( 'Default value', 'clifden_domain_help' ) . '">*</sup>',
			),
		);

		foreach ( $shortcodes as $shortcode ) {

			$titleDesc   = ( isset( $shortcode['titleDesc'] ) ) ? ( $shortcode['titleDesc'] ) : ( 'SHORTCODE DESCRIPTION' );
			$title       = ( isset( $shortcode['title'] ) ) ? ( $shortcode['title'] ) : ( 'SHORTCODE' );
			$example     = ( isset( $shortcode['example'] ) ) ? ( $shortcode['example'] ) : ( 'EXAMPLE' );
			$description = ( isset( $shortcode['description'] ) ) ? ( $shortcode['description'] ) : ( array( 'DESCRIPTION' ) );
			$description = implode( '</p><p>', $description );
			$description = strtr( $description, $replaceArray['desc'] );
			$parameters  = ( isset( $shortcode['parameters'] ) ) ? ( $shortcode['parameters'] ) : ( false );

			$out .= '<div class="shortcode-help">';

				//title and description
				$out .= '<h3 title="' . esc_attr( $titleDesc ) . '">' . $title . '</h3>';
				$out .= '<div class="shortcode-help-content">';

					$out .= '<p>' . __( 'Example:', 'clifden_domain_help' ) . '<br /><input type="text" onfocus="this.select();" readonly="readonly" value="' . esc_attr( $example ) . '" class="example" /></p>';
					$out .= '<p>' . $description . '</p>';

					//parameters
					if ( $parameters && is_array( $parameters ) && ! empty( $parameters ) ) {
						$out .= '<table class="attributes" cellspacing="0"><tbody>';
						foreach ( $parameters as $parameterName => $parameter ) {
							$parameterDesc = strtr( $parameter[1], $replaceArray['param'] );
							$out .= '<tr>';
								$out .= '<th class="parameter-name"><code>' . $parameterName . '</code></th>'; //parameter name
								$out .= '<td class="parameter-type"><small>' . $parameter[0] . '</small></td>'; //parameter type
								$out .= '<td class="parameter-desc">' . $parameterDesc . '</td>'; //parameter description
							$out .= '</tr>';
						}
						$out .= '</tbody></table><p><small>* ' . __( 'Default value of predefined parameter values set', 'clifden_domain_help' ) . '</small></p>';
					} else if ( 'NONE' === $parameters ) {
						$out .= '';
					} else {
						$out .= '<p><em>' . __( 'There are no parameters for this shortcode.', 'clifden_domain_help' ) . '</em></p>';
					}

			$out .= '</div></div>';

		}

		return $out;
	}
} // /wm_help_shortcodes





$prefix = 'wm-help-';

/* Repeatable texts */
	$predefinedSentences = array(
		'noclose'    => __( 'No closing tag required, please close the shortcode with slash before the closing square bracket.', 'clifden_domain_help' ),
		'close'      => __( 'Place the content between opening and closing shortcode tag.', 'clifden_domain_help' ),
		'predefined' => __( 'One of these values (leave blank for default):', 'clifden_domain_help' ),
		'seo'        => ( ! wm_option( 'seo-metaboxes' ) ) ? ( '<hr /><h3>' . __( 'SEO settings', 'clifden_domain_help' ) . '</h3><p>' . __( 'You can set a specific SEO meta description and keywords and/or disable indexing of this post/page in "SEO settings" metabox.', 'clifden_domain_help' ) . '</p>' ) : ( '' ),
		);
	$widgetAreas = wm_widget_areas();
	$widgetAreas = implode( '}, {', array_filter( array_flip( $widgetAreas ) ) );

	$shortcodesHelp = array(
			//access shortcodes
			'access' => array(
				//login form
				array(
					'titleDesc'   => __( 'Displays login form', 'clifden_domain_help' ),
					'title'       => __( 'Login Form', 'clifden_domain_help' ),
					'example'     => '[login stay="1" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'stay' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Leave empty to redirect to homepage after successful login or set {1} to stay on the current page.', 'clifden_domain_help' )
						),
					),
				),

				//user group access
				array(
					'titleDesc'   => __( 'Displays content just for specific user group', 'clifden_domain_help' ),
					'title'       => __( 'User groups', 'clifden_domain_help' ),
					'example'     => '[administrator]TEXT[/administrator]',
					'description' => array( $predefinedSentences['close'], __( 'The available shortcodes are: [administrator]TEXT[/administrator], [author]TEXT[/author], [contributor]TEXT[/contributor], [editor]TEXT[/editor], [subscriber]TEXT[/subscriber].', 'clifden_domain_help' ) ),
				),
			),

			//media shortcodes
			'media' => array(
				//audio
				array(
					'titleDesc'   => __( 'Inserts SoundCloud or self-hosted audio', 'clifden_domain_help' ),
					'title'       => __( 'Audio', 'clifden_domain_help' ),
					'example'     => '[audio src="URL" /]',
					'description' => array( __( 'Use syntax of <a href="http://codex.wordpress.org/Audio_Shortcode" target="_blank">WordPress Audio shortcode</a>.', 'clifden_domain_adm' ) ),
					'parameters'  => 'NONE',
				),

				//gallery
				array(
					'titleDesc'   => __( 'Inserts post/page image gallery', 'clifden_domain_help' ),
					'title'       => __( 'Gallery', 'clifden_domain_help' ),
					'example'     => '[gallery columns="4" flexible="1" frame="1" remove="1,3,5" sardine="1" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'This is basically the native WordPress gallery shortcode enhanced with some cool features. For default gallery parameters check the <a href="http://codex.wordpress.org/Gallery_Shortcode" target="_blank">WordPress codex</a>. Parameters below are just theme enhancements. The theme also improves gallery HTML markup and CSS styling.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'flexible' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to keep image proportions and display a gallery in masonry style.', 'clifden_domain_help' )
						),
						'frame' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} display frame around gallery images.', 'clifden_domain_help' )
						),
						'remove' => array(
							__( 'numbers', 'clifden_domain_help' ),
							__( 'Insert numbers separated with commas. For default "exclude" gallery parameter you would need to insert the actual image IDs. This makes the process simpler. You just insert a numerical position of the image in gallery to remove. For example {1,3,5} will remove first, third and fifth image from gallery.', 'clifden_domain_help' )
						),
						'sardine' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display images without margins.', 'clifden_domain_help' )
						),
					),
				),

				//video
				array(
					'titleDesc'   => __( 'Inserts YouTube, Vimeo, Screenr or self-hosted video', 'clifden_domain_help' ),
					'title'       => __( 'Video', 'clifden_domain_help' ),
					'example'     => '[video src="URL" /]',
					'description' => array( __( 'Use syntax of <a href="http://codex.wordpress.org/Video_Shortcode" target="_blank">WordPress Video shortcode</a>.', 'clifden_domain_adm' ) ),
					'parameters'  => 'NONE',
				),

				//slideshow
				array(
					'titleDesc'   => __( 'Inserts image slideshow', 'clifden_domain_help' ),
					'title'       => __( 'Slideshow', 'clifden_domain_help' ),
					'example'     => '[slideshow group="slug" images="URL1, URL2" links="URL1, URL2" time="5" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'group' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'Slides group slug (preferred) or ID. If set, slides from specific slides group will be displayed. You can find the Slides group slug in <strong>Slides > Slide groups</strong>.', 'clifden_domain_help' )
						),
						'images' => array(
							__( 'URL', 'clifden_domain_help' ),
							__( 'If slides group is not set, you can insert set of image URL addresses separated with commas. If you want to display post/page gallery in slider, just type in "gallery".', 'clifden_domain_help' )
						),
						'links' => array(
							__( 'URL', 'clifden_domain_help' ),
							__( 'If you use set of image URL addresses for "images" parameter, you can set custom links for each image in the set. Just make sure the number of links is the same as number of images. Separate links with commas. Use empty space for no link on specific image, such as {URL, ,URL}.', 'clifden_domain_help' )
						),
						'time' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Duration in seconds to display one slide.', 'clifden_domain_help' )
						),
					),
				),
			),

			//special shortcodes
			'special' => array(
				//accordion
				array(
					'titleDesc'   => __( 'Creates interactive accordion', 'clifden_domain_help' ),
					'title'       => __( 'Accordion', 'clifden_domain_help' ),
					'example'     => '[accordion auto="1"][accordion_item title="TEXT"]TEXT[/accordion_item][/accordion]',
					'description' => array( __( 'Place the accordion item content between [accordion_item] and [/accordion_item] shortcodes and wrap them all in [accordion] and [/accordion] shortcode. You can create as many accordion items as needed, just remember to enclose them in [accordion_item] shortcode.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'auto' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to make accordion automatically animated or leave empty to use normal accordion. You can also set the automatic animation speed in miliseconds here if you enter a number greater than {1000}.', 'clifden_domain_help' )
						),
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Required accordion section (item) title. Clicking the title reveals the accordion section.', 'clifden_domain_help' )
						),
					),
				),

				//content module
				array(
					'titleDesc'   => __( 'Display a specific content module', 'clifden_domain_help' ),
					'title'       => __( 'Content modules', 'clifden_domain_help' ),
					'example'     => '[content_module id="slug" layout="" no_thumb="" no_title="" randomize="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Content modules can be used to inject a content into a page or post or to be displayed as an icon module (which can be usefull for services presentation, for example).', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'id' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the Content Module to be displayed. You can find the Content Module slug in <strong>Content Modules > Content Modules</strong> in "Shortcode" column of the table.', 'clifden_domain_help' )
						),
						'layout' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Sets the layout - either normal or centered one.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {normal}=d, {centered}.',
						),
						'no_thumb' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to hide Content Module featured image.', 'clifden_domain_help' )
						),
						'no_title' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to hide Content Module title.', 'clifden_domain_help' )
						),
						'randomize' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the tag (the group of Content Modules) where the Content Module will be randomly chosen from. You can find the tag slug in <strong>Content Modules > Tags</strong>.', 'clifden_domain_help' )
						),
					),
				),

				//countdown
				array(
					'titleDesc'   => __( 'Displays countdown timer', 'clifden_domain_help' ),
					'title'       => __( 'Countdown timer', 'clifden_domain_help' ),
					'example'     => '[countdown time="2013-12-31 12:00" size="m" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays countdown timer counting down until specific time.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}, {l}, {xl}=d.',
						),
						'time' => array(
							__( 'time value (YYYY-MM-DD HH:mm format)', 'clifden_domain_help' ),
							__( 'Set the time in predefined format: Y = year, M = month, D = day, H = hour, m = minute. Example for noon on December 31st, 2013: {2013-12-31 12:00}.', 'clifden_domain_help' )
						),
					),
				),

				//faq
				'faq' => array(
					'titleDesc'   => __( 'Display frequently asked questions', 'clifden_domain_help' ),
					'title'       => __( 'FAQ', 'clifden_domain_help' ),
					'example'     => '[faq align="" category="slug" filter="left" filter_color="blue" order="new"][/faq]',
					'description' => array( __( 'Displays list of frequently asked questions. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If description set, this will set its alignment.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the FAQ category to be displayed. You can find the FAQ category slug in <strong>FAQ > FAQ categories</strong>.', 'clifden_domain_help' )
						),
						'filter' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If you want to display a filter, set this value. Otherwise leave blank.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {above}, {left}, {right}.',
						),
						'filter_color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}=d, {green}, {blue}, {orange}, {red}.',
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}, {old}, {name}=d, {random}.',
						),
					),
				),

				//logos
				'logos' => array(
					'titleDesc'   => __( 'Display clients/partners logos', 'clifden_domain_help' ),
					'title'       => __( 'Logos', 'clifden_domain_help' ),
					'example'     => '[logos align="left" category="" columns="5" count="10" order="new"][/logos]',
					'description' => array( __( 'Displays logos. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If description set, this will set its alignment.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the logo category to be displayed. You can find the logo category slug in <strong>Logos > Categories</strong>.', 'clifden_domain_help' )
						),
						'columns' => array(
							__( 'number', 'clifden_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'clifden_domain_help' ),
						),
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the number of items displayed.', 'clifden_domain_help' ),
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}, {old}, {name}, {random}=d.',
						),
					),
				),

				//posts
				array(
					'titleDesc'   => __( 'Displays posts', 'clifden_domain_help' ),
					'title'       => __( 'Posts', 'clifden_domain_help' ),
					'example'     => '[posts align="left" category="" columns="5" count="10" excerpt_length="" order="new" related="0"][/posts]',
					'description' => array( __( 'Displays blog posts. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If description set, this will set its alignment.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the blog category to be displayed. You can find the blog category slug in <strong>Posts > Categories</strong>.', 'clifden_domain_help' )
						),
						'columns' => array(
							__( 'number', 'clifden_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'clifden_domain_help' ),
						),
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the number of items displayed.', 'clifden_domain_help' ),
						),
						'excerpt_length' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the length of the excerpt in words.', 'clifden_domain_help' ),
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'related' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Whether to display posts related to the current one upon its category and tag settings.', 'clifden_domain_help' ),
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'clifden_domain_help' )
						),
					),
				),

				//price table
				'prices' => array(
					'titleDesc'   => __( 'Display a specific pricing table', 'clifden_domain_help' ),
					'title'       => __( 'Pricing tables', 'clifden_domain_help' ),
					'example'     => '[prices table="slug" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'table' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the table to be displayed. You can find the price table slug in <strong>Prices > Price tables</strong>.', 'clifden_domain_help' )
						),
					),
				),

				//projects
				'projects' => array(
					'titleDesc'   => __( 'Displays projects', 'clifden_domain_help' ),
					'title'       => __( 'Projects', 'clifden_domain_help' ),
					'example'     => '[projects align="left" category="" columns="5" count="10" filter="1" order="new"][/projects]',
					'description' => array( __( 'Displays list of projects. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If description set, this will set its alignment.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'category' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the projects category to be displayed. You can find the projects category slug in <strong>Projects > Project categories</strong>.', 'clifden_domain_help' )
						),
						'columns' => array(
							__( 'number', 'clifden_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'clifden_domain_help' ),
						),
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the number of items displayed.', 'clifden_domain_help' ),
						),
						'filter' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display a filter above projects list.', 'clifden_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'clifden_domain_help' )
						),
					),
				),

				//project attributes
				'projectAtts' => array(
					'titleDesc'   => __( 'Displays current project attributes', 'clifden_domain_help' ),
					'title'       => __( 'Project attributes', 'clifden_domain_help' ),
					'example'     => '[project_attributes title="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Use on project page only.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'If set, a heading (HTML heading 3) will be applied on the attributes list.', 'clifden_domain_help' )
						),
					),
				),

				//sections
				array(
					'titleDesc'   => __( 'Splits the "Sections" page template', 'clifden_domain_help' ),
					'title'       => __( '"Sections" page template section', 'clifden_domain_help' ),
					'example'     => '[section class="TEXT"]TEXT[/section]',
					'description' => array( __( 'Use this shortcode on "Sections" page template only. It will split the page into sections.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'class' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional section CSS class for styling purposes. You can use "alt" class to apply alternative styling.', 'clifden_domain_help' )
						),
					),
				),

				//social icons
				array(
					'titleDesc'   => __( 'Display specific social icon', 'clifden_domain_help' ),
					'title'       => __( 'Social icons', 'clifden_domain_help' ),
					'example'     => '[social icon="Twitter" size="l" title="TEXT" url="URL" rel="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'icon' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Normally, the icon will be set automatically from the URL parameter. However, you can force a specific icon here.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {' . implode( '}, {', $socialIconsArray ) . '}.',
						),
						'rel' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional link relation. This sets up the "rel" HTML attribute.', 'clifden_domain_help' ),
						),
						'size' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}, {l}=d, {xl}.',
						),
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Sets optional text which will be displayed when mouse hovers over the icon.', 'clifden_domain_help' ),
						),
						'url' => array(
							__( 'URL', 'clifden_domain_help' ),
							__( 'The actual link URL of the icon. When "icon" parameter left empty, this will be used to determine the icon.', 'clifden_domain_help' ),
						),
					),
				),

				//staff
				'staff' => array(
					'titleDesc'   => __( 'Displays staff info', 'clifden_domain_help' ),
					'title'       => __( 'Staff', 'clifden_domain_help' ),
					'example'     => '[staff align="left" columns="5" count="10" department="" order="new"][/staff]',
					'description' => array( __( 'Displays blog posts. You can insert a description between an opening and closing shortcode tag and set an "align" parameter to display it on left or right.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'If description set, this will set its alignment.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'columns' => array(
							__( 'number', 'clifden_domain_help' ) . ' (2-6)',
							__( 'Sets the layout.', 'clifden_domain_help' ),
						),
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the number of items displayed.', 'clifden_domain_help' ),
						),
						'department' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'The slug (preferred) or ID of the department to be displayed. You can find the department slug in <strong>Staff > Departments</strong>.', 'clifden_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {name}, {random}.',
						),
						'thumb' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'By default the thumbnail image is displayed (set to {1}).', 'clifden_domain_help' )
						),
					),
				),

				//statuses
				'status' => array(
					'titleDesc'   => __( 'Display status posts', 'clifden_domain_help' ),
					'title'       => __( 'Statuses', 'clifden_domain_help' ),
					'example'     => '[status count="5" date="1" layout="large" speed="3" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays status posts in a list or animated sequence one by one.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Number of status posts to display.', 'clifden_domain_help' )
						),
						'date' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display status post publish date and time.', 'clifden_domain_help' )
						),
						'layout' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {normal}=d, {large}.',
						),
						'speed' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Duration to display one status in seconds. This will make the statuses to be displayed in animation one by one. If not set, statuses will be displayed in simple list.', 'clifden_domain_help' )
						),
					),
				),

				//subpages
				array(
					'titleDesc'   => __( 'Display list of subpages', 'clifden_domain_help' ),
					'title'       => __( 'Subpages', 'clifden_domain_help' ),
					'example'     => '[subpages depth="1" order="menu" parents="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays list of subpages.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'depth' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Set the depth level of pages hierarchy to display.', 'clifden_domain_help' )
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {title}=d, {menu}.',
						),
						'parents' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display also page parents. Otherwise only children and siblings will be displayed.', 'clifden_domain_help' )
						),
					),
				),

				//tabs
				array(
					'titleDesc'   => __( 'Creates interactive tabs', 'clifden_domain_help' ),
					'title'       => __( 'Tabs', 'clifden_domain_help' ),
					'example'     => '[tabs type="fullwidth"][tab title="TEXT"]TEXT[/tab][/tabs]',
					'description' => array( __( 'Place the tab content between [tab] and [/tab] shortcodes and wrap them all in [tabs] and [/tabs] shortcode. You can create as many tab items as needed, just remember to enclose them in [tab] shortcode.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Required tab title. Clicking the title reveals the tabbed content.', 'clifden_domain_help' )
						),
						'type' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {vertical}, {vertical tour} , {fullwidth}.',
						),
					),
				),

				//testimonials
				'testimonials' => array(
					'titleDesc'   => __( 'Display testimonials', 'clifden_domain_help' ),
					'title'       => __( 'Testimonials', 'clifden_domain_help' ),
					'example'     => '[testimonials category="slug" count="5" layout="large" order="random" private="1" speed="3" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'Displays quote posts in a list or animated sequence one by one. If featured image of the post set, it will be used as quoted person photo (please upload square images only).', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'category' => array(
							__( 'slug or ID', 'clifden_domain_help' ),
							__( 'Slug (preferred) or ID of blog category where the quote posts are chosen from. You can find the category slug in <strong>Posts > Categories</strong>.', 'clifden_domain_help' )
						),
						'count' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Number of quote posts to display.', 'clifden_domain_help' )
						),
						'layout' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {normal}=d, {large}.',
						),
						'order' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {new}=d, {old}, {random}.',
						),
						'private' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Should the testimonials shortcode display posts with status of "private" (these are normally displayed to post author only and are hidden for other website visitors)?', 'clifden_domain_help' )
						),
						'speed' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Duration to display one testimonial in seconds. This will make the testimonials to be displayed in animation one by one. If not set, testimonials will be displayed in simple list.', 'clifden_domain_help' )
						),
					),
				),

				//toggles
				array(
					'titleDesc'   => __( 'Creates interactive toggles', 'clifden_domain_help' ),
					'title'       => __( 'Toggles', 'clifden_domain_help' ),
					'example'     => '[toggle open="1" title="TEXT"]TEXT[/toggle]',
					'description' => array( __( 'Place the toggle content between [toggle] and [/toggle] shortcode. The content will be displayed after clicking the toggle title.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'open' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Should the toggle be open by default?', 'clifden_domain_help' )
						),
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Required toggle title. Clicking the title toggles the content.', 'clifden_domain_help' )
						),
					),
				),

				//widget area
				array(
					'titleDesc'   => __( 'Displays specific widget area', 'clifden_domain_help' ),
					'title'       => __( 'Widget areas', 'clifden_domain_help' ),
					'example'     => '[widgets area="default" style="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'area' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {' . $widgetAreas . '}.',
						),
						'style' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'By default the widget area will be displayed horizontally and will take maximum of 5 widgets. However, you can change that and set vertical styling of the widget area here.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {horizontal}=d, {vertical}, {sidebar-left} , {sidebar-right}.',
						),
					),
				),

				//yes/no icon
				array(
					'titleDesc'   => __( 'Inserts "yes" or "no" icon', 'clifden_domain_help' ),
					'title'       => __( 'Yes / No icon', 'clifden_domain_help' ),
					'example'     => '[yes color="colored" /] [no color="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Sets the icon color. If {colored} set, "Yes" icon will be green, "No" icon will be red.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {black}=d, {colored}, {white}.',
						),
					),
				),
			),

			//text shortcodes
			'text' => array(
				//big text
				array(
					'titleDesc'   => __( 'Enlarges text', 'clifden_domain_help' ),
					'title'       => __( 'Big text', 'clifden_domain_help' ),
					'example'     => '[big_text]TEXT[/big_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="size-big"&gt;&lt;/span&gt;}.', 'clifden_domain_help' ) ),
				),

				//boxes
				array(
					'titleDesc'   => __( 'Inserts a message box', 'clifden_domain_help' ),
					'title'       => __( 'Boxes', 'clifden_domain_help' ),
					'example'     => '[box color="green" icon="check" hero="" title="TEXT" transparent=""]TEXT[/box]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}=d, {green}, {blue}, {orange}, {red}.',
						),
						'icon' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {info}, {question}, {check}, {warning}, {cancel}.',
						),
						'hero' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to style the box as hero box.', 'clifden_domain_help' )
						),
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional box title.', 'clifden_domain_help' )
						),
						'transparent' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display box with transparent background - only border will be visible.', 'clifden_domain_help' )
						),
					),
				),

				//buttons
				array(
					'titleDesc'   => __( 'Inserts a button', 'clifden_domain_help' ),
					'title'       => __( 'Buttons', 'clifden_domain_help' ),
					'example'     => '[button align="" background_color="123456" color="green" icon="" new_window="" size="l" text_color="123456" url="URL"]TEXT[/button]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
						'background_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'icon' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Icon image class name. Please use shortcode generator for all possible icons.', 'clifden_domain_help' )
						),
						'new_window' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to open button link in new browser window or tab.', 'clifden_domain_help' )
						),
						'size' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {s}, {m}=d, {l}, {xl}.',
						),
						'text_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'url' => array(
							__( 'URL', 'clifden_domain_help' ),
							__( 'Button link URL address.', 'clifden_domain_help' )
						),
					),
				),

				//call to action
				array(
					'titleDesc'   => __( 'Creates call to action box', 'clifden_domain_help' ),
					'title'       => __( 'Call to action', 'clifden_domain_help' ),
					'example'     => '[call_to_action background_color="" background_pattern="" button_color="green" button_text="TEXT" button_url="URL" color="" new_window="" text_color="" title="TEXT" subtitle="TEXT"]TEXT[/call_to_action]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'background_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'background_pattern' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {checker}, {dots}, {squares}, {stripes-dark}, {stripes-light}.',
						),
						'button_color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}=d, {blue}, {orange}, {red}.',
						),
						'button_text' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Button text.', 'clifden_domain_help' )
						),
						'button_url' => array(
							__( 'URL', 'clifden_domain_help' ),
							__( 'Button link URL address.', 'clifden_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'new_window' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to open button link in new browser window or tab.', 'clifden_domain_help' )
						),
						'text_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'title' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional call to action box title.', 'clifden_domain_help' )
						),
						'subtitle' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional call to action box subtitle.', 'clifden_domain_help' )
						),
					),
				),

				//columns
				array(
					'titleDesc'   => __( 'Creates columns', 'clifden_domain_help' ),
					'title'       => __( 'Columns', 'clifden_domain_help' ),
					'example'     => '[column size="1/4 last" class=""]TEXT[/column]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'class' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Optional custom CSS class applied on the column.', 'clifden_domain_help' )
						),
						'size' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {1/2}=d, {1/2 last}, {1/3}, {1/3 last}, {2/3}, {2/3 last}, {1/4}, {1/4 last}, {3/4}, {3/4 last}, {1/5}, {1/5 last}, {2/5}, {2/5 last}, {3/5}, {3/5 last}, {4/5}, {4/5 last}, {1/6}, {1/6 last}, {5/6}, {5/6 last}. ' . __( 'Set "last" when the column is the last one in row of columns.', 'clifden_domain_help' ),
						),
					),
				),

				//divider
				array(
					'titleDesc'   => __( 'Inserts a divider', 'clifden_domain_help' ),
					'title'       => __( 'Divider', 'clifden_domain_help' ),
					'example'     => '[divider height="60" no_border="1" opacity="10" top_link="" type="dots" unit="em" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'height' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'Sets the height of bottom padding of the divider (in "unit" setting).', 'clifden_domain_help' ),
						),
						'no_border' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to hide the border.', 'clifden_domain_help' ),
						),
						'opacity' => array(
							__( 'number', 'clifden_domain_help' ) . ' (0 - 100)',
							__( 'Opacity of the shadow image when divider type set to display shadow.', 'clifden_domain_help' ),
						),
						'top_link' => array(
							__( 'yes (1) / no (0)', 'clifden_domain_help' ),
							__( 'Set {1} to display link to the top of page.', 'clifden_domain_help' ),
						),
						'type' => array(
							__( 'predefined', 'clifden_domain_help' ),
						$predefinedSentences['predefined'] . ' {spacer}, {dots}, {dashes}, {shadow-top}, {shadow-bottom}.',
						),
						'unit' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {px}=d, {em}, {%}.',
						),
					),
				),

				//dropcap
				array(
					'titleDesc'   => __( 'Creates a dropcap', 'clifden_domain_help' ),
					'title'       => __( 'Dropcaps', 'clifden_domain_help' ),
					'example'     => '[dropcap type="round"]A[/dropcap]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'type' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {round}, {square}, {leaf}.',
						),
					),
				),

				//huge text
				array(
					'titleDesc'   => __( 'Enlarges text', 'clifden_domain_help' ),
					'title'       => __( 'Huge text', 'clifden_domain_help' ),
					'example'     => '[huge_text]TEXT[/huge_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="size-huge"&gt;&lt;/span&gt;}.', 'clifden_domain_help' ) ),
				),

				//icons
				array(
					'titleDesc'   => __( 'Creates a Font Awesome icon', 'clifden_domain_help' ),
					'title'       => __( 'Icons (Font Awesome)', 'clifden_domain_help' ),
					'example'     => '[icon size="64px" type="icon-asterisk" /]',
					'description' => array( $predefinedSentences['noclose'], __( 'Only predefined icons of Font Awesome can be displayed with this shortcode. For the icons list see below or use Shortcode Generator.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'size' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Set the icon size in font-size CSS rule compatble values.', 'clifden_domain_help' ),
						),
						'type' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {' . implode( '}, {', $fontIcons ) . '}.',
						),
					),
				),

				//last update
				array(
					'titleDesc'   => __( 'Displays date and time when the posts or projects were last updated', 'clifden_domain_help' ),
					'title'       => __( 'Last update', 'clifden_domain_help' ),
					'example'     => '[last_update format="" item="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'format' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Sets the time format. By default it uses WordPress settings (set it in <strong>Settings > General > Date Format</strong>). You can, however, set any <a href="http://php.net/manual/en/function.date.php" target="_blank">PHP valid value</a> here.', 'clifden_domain_help' ),
						),
						'item' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Choose which elements should be checked for the last update.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {posts}=d, {projects}.',
						),
					),
				),

				//lists
				array(
					'titleDesc'   => __( 'Styles unordered lists', 'clifden_domain_help' ),
					'title'       => __( 'Lists (unordered)', 'clifden_domain_help' ),
					'example'     => '[list icon="icon-star"]&lt;ul&gt;...&lt;/ul&gt;[/list]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Place unordered list in between opening and closing shortcode tag.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'icon' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Icon image class name. Please use shortcode generator for all possible icons.', 'clifden_domain_help' )
						),
					),
				),

				//markers
				array(
					'titleDesc'   => __( 'Marks, highlights the text', 'clifden_domain_help' ),
					'title'       => __( 'Markers (highlights)', 'clifden_domain_help' ),
					'example'     => '[marker background_color="" color="green" text_color=""]TEXT[/marker]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'background_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'text_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
					),
				),

				//pullquotes
				array(
					'titleDesc'   => __( 'Displays pullquotes', 'clifden_domain_help' ),
					'title'       => __( 'Pullquotes', 'clifden_domain_help' ),
					'example'     => '[pullquote align="left"]TEXT[/pullquote]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'align' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {left}=d, {right}.',
						),
					),
				),

				//raw/pre text
				array(
					'titleDesc'   => __( 'Raw preformated text', 'clifden_domain_help' ),
					'title'       => __( 'Raw, preformated text', 'clifden_domain_help' ),
					'example'     => '[raw]TEXT[/raw]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;pre&gt;&lt;/pre&gt;}.', 'clifden_domain_help' ) ),
				),

				//small text
				array(
					'titleDesc'   => __( 'Makes text smaller', 'clifden_domain_help' ),
					'title'       => __( 'Small text', 'clifden_domain_help' ),
					'example'     => '[small_text]TEXT[/small_text]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;small&gt;&lt;/small&gt;}.', 'clifden_domain_help' ) ),
				),

				//table
				array(
					'titleDesc'   => __( 'Creates table', 'clifden_domain_help' ),
					'title'       => __( 'Table', 'clifden_domain_help' ),
					'example'     => '[table class="" cols="TEXT" data="TEXT" heading_col="" separator="" /]',
					'description' => array( $predefinedSentences['noclose'] . ' ' . __( 'This will display simple data table. Perfectly suitable to display data from CSV files.', 'clifden_domain_help' ), __( 'If you require more control over your table you can use sub-shortcodes for table row ([trow][/trow] or [trow_alt][/trow_alt] for alternatively styled table row), table cell ([tcell][/tcell]) and table heading cell ([tcell_heading][/tcell_heading]). All wrapped in [table][/table] parent shortcode without any parameter.', 'clifden_domain_help' ) ),
					'parameters'  => array(
						'class' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Applies custom CSS class on the table for custom stylings.', 'clifden_domain_help' ),
						),
						'cols' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Columns headings. This setting is required as it sets the number of columns to which the data will be separated. Separate each column heading (title) with separator character ({;} is used by default). If you do not need the table headings to be displayed, just type in separators required times, such as {;;;} will separate data in the table into 4 (yes, 4 as there would be normally a column title after the last separator character, so basically keep in mind to insert the "columns count minus one" number of separators) columns but without any column heading.', 'clifden_domain_help' ),
						),
						'data' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'The actual table data. Again, separate with separator character ({;} by default). This text can be as long as you wish as it will be separated into columns by the above setting.', 'clifden_domain_help' ),
						),
						'heading_col' => array(
							__( 'number', 'clifden_domain_help' ),
							__( 'If you need to style any of the table columns as headings, set its position number here (starting with 1).', 'clifden_domain_help' ),
						),
						'separator' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Separator character used to separate "cols" and "data" datas. Semicolon ({;}) is used by default.', 'clifden_domain_help' ),
						),
					),
				),

				//uppercase text
				array(
					'titleDesc'   => __( 'Transforms letters of text to uppercase', 'clifden_domain_help' ),
					'title'       => __( 'Uppercase letters', 'clifden_domain_help' ),
					'example'     => '[uppercase]TEXT[/uppercase]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="uppercase"&gt;&lt;/span&gt;}.', 'clifden_domain_help' ) ),
				),
			),

			//menu allowed shortcodes
			'menuAllowed' => array(
				//last update
				array(
					'titleDesc'   => __( 'Displays date and time when the posts or projects were last updated', 'clifden_domain_help' ),
					'title'       => __( 'Last update', 'clifden_domain_help' ),
					'example'     => '[last_update format="" item="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'format' => array(
							__( 'text', 'clifden_domain_help' ),
							__( 'Sets the time format. By default it uses WordPress settings (set it in <strong>Settings > General > Date Format</strong>). You can, however, set any <a href="http://php.net/manual/en/function.date.php" target="_blank">PHP valid value</a> here.', 'clifden_domain_help' ),
						),
						'item' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Choose which elements should be checked for the last update.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {posts}=d, {projects}.',
						),
					),
				),

				//markers
				array(
					'titleDesc'   => __( 'Marks, highlights the text', 'clifden_domain_help' ),
					'title'       => __( 'Markers (highlights)', 'clifden_domain_help' ),
					'example'     => '[marker background_color="" color="green" text_color=""]TEXT[/marker]',
					'description' => array( $predefinedSentences['close'] ),
					'parameters'  => array(
						'background_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							$predefinedSentences['predefined'] . ' {gray}, {green}, {blue}, {orange}, {red}.',
						),
						'text_color' => array(
							__( 'color code', 'clifden_domain_help' ),
							__( 'Optional custom hexadecimal color code without "#".', 'clifden_domain_help' )
						),
					),
				),

				//uppercase text
				array(
					'titleDesc'   => __( 'Transforms letters of text to uppercase', 'clifden_domain_help' ),
					'title'       => __( 'Uppercase letters', 'clifden_domain_help' ),
					'example'     => '[uppercase]TEXT[/uppercase]',
					'description' => array( $predefinedSentences['close'] . ' ' . __( 'Encloses the text into {&lt;span class="uppercase"&gt;&lt;/span&gt;}.', 'clifden_domain_help' ) ),
				),

				//yes/no icon
				array(
					'titleDesc'   => __( 'Inserts "yes" or "no" icon', 'clifden_domain_help' ),
					'title'       => __( 'Yes / No icon', 'clifden_domain_help' ),
					'example'     => '[yes color="colored" /] [no color="" /]',
					'description' => array( $predefinedSentences['noclose'] ),
					'parameters'  => array(
						'color' => array(
							__( 'predefined', 'clifden_domain_help' ),
							__( 'Sets the icon color. If {colored} set, "Yes" icon will be green, "No" icon will be red.', 'clifden_domain_help' ) . ' ' . $predefinedSentences['predefined'] . ' {black}=d, {colored}, {white}.',
						),
					),
				),
			),
		);

		//remove shortcodes from array if Custom Posts or Post Formats disabled
			if ( 'disable' === wm_option( 'general-role-faq' ) )
				unset( $shortcodesHelp['special']['faq'] );
			if ( 'disable' === wm_option( 'general-role-logos' ) )
				unset( $shortcodesHelp['special']['logos'] );
			if ( 'disable' === wm_option( 'general-role-prices' ) )
				unset( $shortcodesHelp['special']['prices'] );
			if ( 'disable' === wm_option( 'general-role-projects' ) ) {
				unset( $shortcodesHelp['special']['projects'] );
				unset( $shortcodesHelp['special']['projectAtts'] );
			}
			if ( 'disable' === wm_option( 'general-role-staff' ) )
				unset( $shortcodesHelp['special']['staff'] );
			if ( wm_option( 'blog-no-format-status' ) )
				unset( $shortcodesHelp['special']['status'] );
			if ( wm_option( 'blog-no-format-quote' ) )
				unset( $shortcodesHelp['special']['testimonials'] );

	$visualEditor = '<h3>' . __( 'The <code>Styles</code> button', 'clifden_domain_help' ) . '</h3>
		<p>' . __( 'As the theme supports the true <abbr title="What You See Is What You Get">WYSIWYG</abbr> content editing, you can use the <code>Styles</code> button to create content elements on the fly. However, due to limitations, it is not possible to replicate all shortcodes with styles, nor can be applied style edited easily afterwards (you have to switch to HTML editor and edit the actual HTML code). If you need to remove all styles from specific element, select the element and click the "Remove formatting" button right from <code>Styles</code> button. For instructions on how to apply specific styles, hover over the question icon (<i class="icon-question-sign"></i>) right from a certain style name in styles dropdown and/or on the styles group heading.', 'clifden_domain_help' ) . '</p>
		<hr />
		<h3>' . __( 'The <code>[S]</code> ("Shortcodes Generator") button', 'clifden_domain_help' ) . '</h3>
		<p>' . __( 'With Shortcode Generator it is very easy to insert any shortcode into post/page content. Simply select the right shortcode from the dropdown, set its options if required and click the "Insert into editor" button (or copy it and insert manually). The shortcode will be included on current cursor position. Note that Shortcode Generator is not compatible with Internet Explorer browsers.', 'clifden_domain_help' ) . '</p>
		<hr />
		<h3>' . __( 'The "New line" buttons', 'clifden_domain_help' ) . '</h3>
		<p>' . __( 'Sometimes you will need to add a new line above or below certain elements in content and sometimes this can be quite tricky to do, as you would have to switch to HTML editor to do so. The theme comes with 2 handy buttons to do this while not leaving the visual editor. Just place the cursor on the element before or after which you need the line to be inserted and click the appropriate button. You can find these 2 buttons left from <code>[S]</code> ("Shortcode Generator") button.', 'clifden_domain_help' ) . '</p>
		';

	$menuIcons = '
	<div class="sticky-content">
		<h4>' . __( 'Copy the icon class', 'clifden_domain_help' ) . ' <small class="stick-button" title="' . __( 'This is really usefull when editing long menus. Please keep the contextual help open.', 'clifden_domain_help' ) . '"><i class="icon-pushpin"></i> ' . __( 'Stick table right', 'clifden_domain_help' ) . '</small></h4>
		<div class="table-wrap">
			<table class="attributes" cellspacing="0">
				<thead>
					<tr>
						<th class="text-center">' . __( 'ID', 'clifden_domain_help' ) . '</th>
						<th class="text-center">' . __( 'Icon', 'clifden_domain_help' ) . '</th>
						<th>' . __( 'Icon class', 'clifden_domain_help' ) . '</th>
					</tr>
				</thead>
				<tbody>';
		$i = 0;
		foreach ( $fontIcons as $icon ) {
			$menuIcons .= '<tr>
						<td class="text-center no-bg"><small>' . ++$i . '</small></td>
						<th class="text-center"><i class="' . $icon . '" title="' . $icon . '"></i></th>
						<td><input type="text" onfocus="this.select();" readonly="readonly" value="' . $icon . '" class="shortcode-in-list-table"></td>
					</tr>';
		}
		$menuIcons .= '</tbody>
			</table>
		</div>
	</div>';





/* Contextual help main text array */
	$helpTexts = array(

		/*
		* PAGES
		*/
		'page' => array(
			array(
				'tabId'      => $prefix . 'page-settings',
				'tabTitle'   => __( 'Page Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Page settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please select a page template first. The "Page Settings" will be displayed according to page template selected. Go through the available options for specific page template and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Page excerpt', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'The theme allows you to set additional content area on certain pages. To find out, whether the specific page template supports displaying of page excerpt content, click the "layout structure" link in page settings description. The link will open popup window with an image of design elements layout for the page template.', 'clifden_domain_help' ) . '</p>'
					. $predefinedSentences['seo'],
			),
			array(
				'tabId'      => $prefix . 'sliders',
				'tabTitle'   => __( 'Slider', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'How to set up a slider', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'In "Page Settings" metabox click the "Slider" tab. Choose a slider type from "Enable slider" dropdown option.', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'If you select "Video" slider, a single video will be displayed in the slider area and featured image will be set as video cover image. For "Static featured image" make sure the featured image is set up. You can set to stretch the image to fit website box width, otherwise the actual image in full size will be displayed.', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'For other slider types set the appropriate options. You can display a "Slides" custom posts in slider, which gives you more control and flexibility over slides, or display images from post/page gallery in slider. When displaying images from gallery, you can set the image caption and description text. Both will be displayed as slide caption. Besides you can set also image custom URL link and slide caption layout - all can be set when editing the image. Images from gallery will be displayd in gallery order.', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'Also it is possible to display the actual image gallery in slider area without any slider effect, just as a gallery. Please check the "Gallery" tab of "Page settings" metabox for this.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Size of images in slider', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Slider usually displays full size images but this depends on slider type chosen (you can get more information about slider types in theme admin panel). If "Fit website width" option set, the slider will try to stretch the image to fit the website box width (while keeping the slide caption text in main website content area). The theme allows for 2 main content widths: 1160 and 930 pixels. Please make sure to upload image of this width for slider if you want to match the main website content width.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* POSTS
		*/
		'post' => array(
			array(
				'tabId'      => $prefix . 'page-settings',
				'tabTitle'   => __( 'Post Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Post settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please select a post format first. The "Post Settings" will be displayed according to post format selected. Go through the available options and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Excerpt', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Post excerpt will be displayed in post list. If no excerpt set, a portion of post content will take its place. Post excerpt will also be displayed at the top of the post content on single post page. Please note that you will probably have to enable post excerpt field in "Screen Options" first.', 'clifden_domain_help' ) . '</p>'
					. $predefinedSentences['seo'],
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP PROJECTS
		*/
		'wm_projects' => array(
			array(
				'tabId'      => $prefix . 'projects-settings',
				'tabTitle'   => __( 'Projects Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Project settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available project options in "Project settings" metabox and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Excerpt', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'The theme displays project excerpt as basic project info next to project media (please check the "General and layout" tab of "Project settings" metabox for more info about project layout) and in projects list. By default project attributes will be displayed on top of project excerpt on single project page, but you can change this by inserting a <code>[project_attributes title="Project info" /]</code> shortcode anywhere in the project content or excerpt area.', 'clifden_domain_help' ) . '</p>'
					. $predefinedSentences['seo'],
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP SLIDES
		*/
		'wm_slides' => array(
			array(
				'tabId'      => $prefix . 'slides-settings',
				'tabTitle'   => __( 'Slide Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Slide settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available slide options in "Slide settings" metabox and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Size of images in slider', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Slider usually displays full size images but this depends on slider type chosen (you can get more information about slider types in theme admin panel). The theme allows for 2 main content widths: 1160 and 930 pixels. Please make sure to upload image of this width for the slide if you want to match the main website content width. Slide background will be stretched full website box width.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP CONTENT MODULES
		*/
		'wm_modules' => array(
			array(
				'tabId'      => $prefix . 'content-module-settings',
				'tabTitle'   => __( 'Content Module Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'What is Content Module?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Content Modules can be used as a content injection to various website areas. You can display it in page or post content or in any widget area (custom widget included). Content Modules can be styled as icon boxes, so they are perfect for your services presentation (for example). You can even conveniently group them using tags and then have a module generated randomly just by choosing the Content Module tag group.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Content Module settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available Content Module options in "Content Module settings" metabox and set required ones to fit your needs. If "Icon box" option is checked, you can upload a custom icon as a featured image.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP FAQ
		*/
		'wm_faq' => array(
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP PRICES
		*/
		'wm_price' => array(
			array(
				'tabId'      => $prefix . 'prices-settings',
				'tabTitle'   => __( 'Price Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'How to use prices?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Prices are being displayed in a table. Each price post is displayed as a column in price table. Please, make sure you set the price table (in "Price tables" metabox) for each price post. A price post can be displayed in several different price tables. One price table can display up to 6 prices (columns). Make sure all the price package/column features are displayed as an unordered list (they will be centered automatically in price table).', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Price settings', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available price options in "Price settings" metabox and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* CP STAFF
		*/
		'wm_staff' => array(
			array(
				'tabId'      => $prefix . 'staff-settings',
				'tabTitle'   => __( 'Staff Settings', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Staff profile and Excerpt field', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Excerpts are only displayed when rich staff profiles are enabled. Excerpt will be displayed in staff members list as a basic information about the person. You can surely leave it blank, though. When visitors of your website clicks the staff profile image (featured image), they will be taken to staff member profile page (no excerpt will be displayed here).', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'Otherwise, if rich staff profiles are disabled, the whole content will be displayed in staff members list and clicking the person profile image will just open image larger.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Staff info', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please go through the available staff information options in "Staff info" metabox and set required ones to fit your needs.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'visual-editor',
				'tabTitle'   => __( 'Visual Editor', 'clifden_domain_help' ),
				'tabContent' => $visualEditor,
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* WIDGETS
		*/
		'widgets' => array(
			array(
				'tabId'      => $prefix . 'widget-colors',
				'tabTitle'   => __( 'Widgets and widget areas', 'clifden_domain_help' ),
				'tabContent' =>	'<h3>' . __( 'Why there are different colors of widgets and widget areas?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'This is to quickly distinguish the special widgets and widget areas. Custom theme widgets are colored dark as oposed to native or other WordPress widgets. Custom widget areas (the ones created in theme admin panel) are blue to separate them from predefined widget areas.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Why the widget area is not displayed on website?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Some widget areas, when displayed horizontally, can take maximum of 5 widgets. If there is more widgets in the area then the amount it can take in horizontal layout, the area will not be displayed. This information can be found in widget area description when you open the widget area. Widgets in these areas will be aligned to columns automatically. You can insert any widget area into page or post content with <code>[widgets area="ID"]</code> shortcode. Note also that widget area will not be displayed when it contains no widgets.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'Can I use shortcodes in widgets?', 'clifden_domain_help' ) . '</h3>
					<p>' . sprintf( __( 'Yes, you can use shortcodes in Text widget. However, the theme offers much convenient way of inserting a formated content in widget areas just by using the <strong>%s Content Module</strong> widget. You can create a new Content Module custom post and edit it using visual editor and then include this specific post into widget area using the widget. You can find shortcode reference in other tabs of this contextual help.', 'clifden_domain_help' ), WM_THEME_NAME ) . '</p>
					<hr />
					<h3>' . __( 'Can I style widget titles?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'The theme allows to use bold (strong) and italic (emphasized) text stylings in widget titles. Just use <code>[s]TEXT[/s]</code> shortcode for strong text and <code>[e]TEXT[/e]</code> for emphasized text.', 'clifden_domain_help' ) . '</p>',
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),



		/*
		* MENUS
		*/
		'nav-menus' => array(
			array(
				'tabId'      => $prefix . 'general',
				'tabTitle'   => __( 'Theme Menu Locations', 'clifden_domain_help' ),
				'tabContent' =>
					'<p>' . __( 'The theme allows you to create as many menus as you want. However these menus can be placed only into predefined locations. The 3 main predefined menu locations are:', 'clifden_domain_help' ) . '</p>
					<ol>
					<li><strong>' . __( 'Main navigation', 'clifden_domain_help' ) . '</strong><br />' . __( 'This is main navigation area in the header of the website. The menu can be nested and hierarchically organised. Subtle animation is applied when revealing submenu items, but the menu will work even with JavaScript disabled.', 'clifden_domain_help' ) . '</li>
					<li><strong>' . __( 'Footer navigation', 'clifden_domain_help' ) . '</strong><br />' . __( 'This is navigation area displayed in the website footer in credits area. Just first hierarchical level of the menu will be displayed.', 'clifden_domain_help' ) . '</li>
					<li><strong>' . __( 'Sitemap links', 'clifden_domain_help' ) . '</strong><br />' . __( 'Instead of placing a list of pages into sitemap page, this offers a greater control over links. Most of the time you would display a main navigation menu here. Please note that menu title will be used as section title on sitemap page.', 'clifden_domain_help' ) . '</li>
					</ol>
					<p>' . __( 'Besides these predefined menu locations there will be new ones created for each landing page. This will allow you to completly disable menu on specific landing pages (simply by not assigning any menu to the location) or to use different menu on such pages.', 'clifden_domain_help' ) . '</p>',
			),
			array(
				'tabId'      => $prefix . 'advanced',
				'tabTitle'   => __( 'Advanced Menus', 'clifden_domain_help' ),
				'tabContent' =>
					'<p>' . __( 'The theme allows you to put icons and description text into main menu items, style them as buttons or align them right. This is all possible by using CSS classes. First, please make sure the "CSS Classes" and "Description" meta fields are enabled for menu items. You can check this in "Screen Options" tab after closing this contextual help.', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'You can also use simple format shortcodes in menu items (such as <code>[marker color="red"][/marker]</code>). For SEO purposes it is also recommended to set "Title Attribute" field.', 'clifden_domain_help' ) . '</p>
					<h3>' . __( 'How to align a menu item to the right?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'You can align a certain menu item to the right just by adding an <code>alignright</code> class to it.', 'clifden_domain_help' ) . '</p>
					<hr />
					<h3>' . __( 'How to make the menu item a button?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please add one of the following CSS classes to the menu item:', 'clifden_domain_help' ) . '</p>
					<ul>
						<li>' . __( 'Blue button:', 'clifden_domain_help' ) . ' <code>button-blue</code></li>
						<li>' . __( 'Gray button:', 'clifden_domain_help' ) . ' <code>button-gray</code></li>
						<li>' . __( 'Green button:', 'clifden_domain_help' ) . ' <code>button-green</code></li>
						<li>' . __( 'Orange button:', 'clifden_domain_help' ) . ' <code>button-orange</code></li>
						<li>' . __( 'Red button:', 'clifden_domain_help' ) . ' <code>button-red</code></li>
					</ul>
					<hr />
					<h3>' . __( 'How to insert an icon into menu item?', 'clifden_domain_help' ) . '</h3>
					<p>' . __( 'Please use the below classes to insert a specific icon.', 'clifden_domain_help' ) . '</p>'
					. $menuIcons,
			),

			array(
				'tabId'      => $prefix . 'shortcodes',
				'tabTitle'   => __( 'Shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['menuAllowed'] ),
			),
		),



		/*
		* ADMIN PANEL
		*/
		'appearance_page_' . WM_THEME_SHORTNAME . '-options' => array(
			array(
				'tabId'      => $prefix . 'general',
				'tabTitle'   => __( 'Admin Panel', 'clifden_domain_help' ),
				'tabContent' => '<h4>' . __( 'Welcome to beautiful WebMan Admin Panel. It is as easy to use as it gets and offers several different intuitive options fields and input types which help to set the right option values.', 'clifden_domain_help' ) . '</h4>
					<p>' . __( 'When you install the theme, you will be presented with Quickstart Guide. Please read through the steps in this guide and set what is required for your website. The guide is branded by WebMan, but as soon as you hit the "Save changes" button for the first time, the admin panel will be debranded. You can basically set the branding to your needs - even for WordPress administration.', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'Many options in this admin panel are predefined with default values. To reset the default value click the reset button (rounded arrows) right from the option (where applicable).', 'clifden_domain_help' ) . '</p>
					<p>' . __( 'Please navigate to <strong>Appearance > Options Export/Import</strong> to make backups of your theme settings or to load previously saved theme settings.', 'clifden_domain_help' ) . '</p>',
			),

			array(
				'tabId'      => $prefix . 'access-shortcodes',
				'tabTitle'   => __( 'Access shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['access'] ),
			),
			array(
				'tabId'      => $prefix . 'media-shortcodes',
				'tabTitle'   => __( 'Media shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['media'] ),
			),
			array(
				'tabId'      => $prefix . 'special-shortcodes',
				'tabTitle'   => __( 'Special shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['special'] ),
			),
			array(
				'tabId'      => $prefix . 'text-shortcodes',
				'tabTitle'   => __( 'Text and layout shortcodes', 'clifden_domain_help' ),
				'tabContent' => wm_help_shortcodes( $shortcodesHelp['text'] ),
			),
		),

	);

?>