<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Slides custom post meta boxes
*
* CONTENT:
* - 1) Meta box form
* - 2) Add meta box
*****************************************************
*/






/*
*****************************************************
*      1) META BOX FORM
*****************************************************
*/
	/*
	* Meta box form fields
	*/
	if ( ! function_exists( 'wm_slides_meta_fields' ) ) {
		function wm_slides_meta_fields() {
			global $post;

			$prefix = $prefixBg = 'slide-';

			$postId = ( $post ) ? ( $post->ID ) : ( null );

			if ( ! $postId && isset( $_GET['post'] ) )
				$postId = absint( $_GET['post'] );

			if ( ! $postId )
				$postId = '{{{post_id}}}';

			$metaFields = array(

				//General settings
				array(
					"type" => "section-open",
					"section-id" => "general",
					"title" => __( 'Slide settings', 'clifden_domain_adm' )
				),
					array(
						"type" => "box",
						"content" => '
							<p>' . __( 'Set featured image and/or type in slide video URL. If both the video URL and featured image are set, the image is used as video preview and when clicked, video will play back. You can group slides into a slide groups and then display specific slides group in page slider.', 'clifden_domain_adm' ) . '</p>
							<a class="button-primary button-set-featured-image thickbox js-post-id" href="' . get_admin_url() . 'media-upload.php?post_id=' . $postId . '&tab=library&type=image&TB_iframe=1">' . __( 'Set featured image', 'clifden_domain_adm' ) . '</a>
							',
					),

					array(
						"type" => "text",
						"id" => $prefix."link",
						"label" => __( 'Custom link', 'clifden_domain_adm' ),
						"desc" => __( 'When left blank, no link will be applied (will not be applied also when video URL is set)', 'clifden_domain_adm' ),
						"validate" => "url"
					),
				array(
					"type" => "section-close"
				),



				//Caption settings
				array(
					"type" => "section-open",
					"section-id" => "caption",
					"title" => __( 'Caption', 'clifden_domain_adm' )
				),
					array(
						"type" => "select",
						"id" => $prefixBg."caption-alignment",
						"label" => __( 'Slide caption layout', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the position and size of the caption text on the slide', 'clifden_domain_adm' ),
						"options" => array(
							' column col-14 no-margin alignleft'   => __( 'Left, 1/4 column', 'clifden_domain_adm' ),
							' column col-13 no-margin alignleft'   => __( 'Left, 1/3 column', 'clifden_domain_adm' ),
							' column col-12 no-margin alignleft'   => __( 'Left, 1/2 column', 'clifden_domain_adm' ),
							' column col-23 no-margin alignleft'   => __( 'Left, 2/3 column', 'clifden_domain_adm' ),
							' column col-34 no-margin alignleft'   => __( 'Left, 3/4 column', 'clifden_domain_adm' ),

							' column col-14 no-margin alignright'  => __( 'Right, 1/4 column', 'clifden_domain_adm' ),
							' column col-13 no-margin alignright'  => __( 'Right, 1/3 column', 'clifden_domain_adm' ),
							' column col-12 no-margin alignright'  => __( 'Right, 1/2 column', 'clifden_domain_adm' ),
							' column col-23 no-margin alignright'  => __( 'Right, 2/3 column', 'clifden_domain_adm' ),
							' column col-34 no-margin alignright'  => __( 'Right, 3/4 column', 'clifden_domain_adm' ),

							' column col-11 no-margin aligntop'    => __( 'Top, full width', 'clifden_domain_adm' ),
							' column col-11 no-margin centered'    => __( 'Center, full width', 'clifden_domain_adm' ),
							' column col-11 no-margin alignbottom' => __( 'Bottom, full width', 'clifden_domain_adm' ),
							),
						"default" => " column col-12 no-margin alignright"
					),
					array(
						"type" => "checkbox",
						"id" => $prefix."caption-padding",
						"label" => __( 'No padding on caption', 'clifden_domain_adm' ),
						"desc" => __( 'Remove padding on slide caption', 'clifden_domain_adm' ),
						"value" => " no-padding"
					),
					array(
						"type" => "hr"
					),
					array(
						"type" => "radio",
						"id" => $prefixBg."caption-color",
						"label" => __( 'Caption color', 'clifden_domain_adm' ),
						"desc" => __( 'Select slide caption background color (will affect also text color, so choose accordingly)', 'clifden_domain_adm' ),
						"options" => array(
							'black' => __( 'Black background (white text)', 'clifden_domain_adm' ),
							'white' => __( 'White background (black text)', 'clifden_domain_adm' ),
							),
						"default" => "black"
					),
					array(
						"type" => "slider",
						"id" => $prefix."caption-opacity",
						"label" => __( 'Caption background opacity', 'clifden_domain_adm' ),
						"desc" => __( 'Sets slide caption background color opacity (set 0 to remove the color)', 'clifden_domain_adm' ),
						"default" => 50,
						"min" => 0,
						"max" => 100,
						"step" => 5,
						"validate" => "absint",
						"zero" => true
					),
				array(
					"type" => "section-close"
				),



				//Background
				array(
					"type" => "section-open",
					"section-id" => "background",
					"title" => __( 'Background', 'clifden_domain_adm' ),
					"exclude" => array()
				),
					array(
						"type" => "color",
						"id" => $prefixBg."bg-color",
						"label" => __( 'Slide background color', 'clifden_domain_adm' ),
						"desc" => __( 'Sets the custom slide background color', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "color"
					),
					array(
						"type" => "image",
						"id" => $prefixBg."bg-img-url",
						"label" => __( 'Custom background image', 'clifden_domain_adm' ),
						"desc" => __( 'To upload a new image, press the [+] button and use the Media Uploader as you would be adding an image into post', 'clifden_domain_adm' ),
						"default" => "",
						"validate" => "url"
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-position",
						"label" => __( 'Background image position', 'clifden_domain_adm' ),
						"desc" => __( 'Set background image position', 'clifden_domain_adm' ),
						"options" => array(
							'50% 50%'   => __( 'Center', 'clifden_domain_adm' ),
							'50% 0'     => __( 'Center horizontally, top', 'clifden_domain_adm' ),
							'50% 100%'  => __( 'Center horizontally, bottom', 'clifden_domain_adm' ),
							'0 0'       => __( 'Left, top', 'clifden_domain_adm' ),
							'0 50%'     => __( 'Left, center vertically', 'clifden_domain_adm' ),
							'0 100%'    => __( 'Left, bottom', 'clifden_domain_adm' ),
							'100% 0'    => __( 'Right, top', 'clifden_domain_adm' ),
							'100% 50%'  => __( 'Right, center vertically', 'clifden_domain_adm' ),
							'100% 100%' => __( 'Right, bottom', 'clifden_domain_adm' ),
							),
						"default" => '50% 50%'
					),
					array(
						"type" => "select",
						"id" => $prefixBg."bg-img-repeat",
						"label" => __( 'Background image repeat', 'clifden_domain_adm' ),
						"desc" => __( 'Set background image repeating', 'clifden_domain_adm' ),
						"options" => array(
							'no-repeat' => __( 'Do not repeat', 'clifden_domain_adm' ),
							'repeat'    => __( 'Repeat', 'clifden_domain_adm' ),
							'repeat-x'  => __( 'Repeat horizontally', 'clifden_domain_adm' ),
							'repeat-y'  => __( 'Repeat vertically', 'clifden_domain_adm' )
							),
						"default" => 'repeat'
					),
					array(
						"type" => "hidden",
						"id" => $prefixBg."bg-img-attachment",
						"default" => 'scroll'
					),
				array(
					"type" => "section-close"
				)

			);

			return $metaFields;
		}
	} // /wm_slides_meta_fields





/*
*****************************************************
*      2) ADD META BOX
*****************************************************
*/
	/*
	* Generate metabox
	*/
	if ( ! function_exists( 'wm_slides_generate_metabox' ) ) {
		function wm_slides_generate_metabox() {
			$wm_slides_META = new WM_Meta_Box( array(
				//where the meta box appear: normal (default), advanced, side
				'context'        => 'normal',
				//meta fields setup array
				'fields'         => wm_slides_meta_fields(),
				//meta box id, unique per meta box
				'id'             => 'wm-metabox-wm_slides-meta',
				//post types
				'pages'          => array( 'wm_slides' ),
				//order of meta box: high (default), low
				'priority'       => 'high',
				//tabbed meta box interface?
				'tabs'           => true,
				//meta box title
				'title'          => __( 'Slide settings', 'clifden_domain_adm' ),
				//wrap the meta form around visual editor?
				'visual-wrapper' => true,
			) );
		}
	} // /wm_slides_generate_metabox

	add_action( 'init', 'wm_slides_generate_metabox', 9999 ); //Has to be hooked to the end of init for taxonomies lists in metaboxes

?>