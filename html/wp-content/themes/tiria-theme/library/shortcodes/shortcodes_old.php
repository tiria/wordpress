<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Shortcodes registration
*
* CONTENT:
* - 1) Actions and filters
* - 2) Helper functions
* - 3) Shortcodes
* - Access shortcodes
* - Accordion
* - Audio and video
* - Boxes
* - Buttons
* - Columns
* - Countdown timer
* - Divider
* - Dropcaps
* - Icon
* - Lists
* - Login form
* - Markers
* - Posts / pages / custom posts
* - Pullquotes
* - Raw code (pre HTML tag)
* - Slideshow
* - Social icons
* - Split
* - Table
* - Tabs
* - Text
* - Toggles
* - Widgets
*****************************************************
*/




/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//FILTERS
	//Allows "[shortcode][/shortcode]" in RAW/PRE shortcode output
	add_filter( 'the_content', 'wm_preprocess_shortcode', 7 );
	add_filter( 'wm_default_content_filters', 'wm_preprocess_shortcode', 7 );
	//Shortcodes in text widget
	add_filter( 'widget_text', 'wm_preprocess_shortcode', 7 );
	add_filter( 'widget_text', 'do_shortcode' );
	//Fixes HTML issues created by wpautop
	add_filter( 'the_content', 'wm_shortcode_paragraph_insertion_fix' );





/*
*****************************************************
*      2) HELPER FUNCTIONS
*****************************************************
*/
	/*
	* Plugin Name: Shortcode Empty Paragraph Fix
	* Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
	* Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
	* Author URI: http://www.johannheyne.de
	* Version: 0.1
	* Put this in /wp-content/plugins/ of your Wordpress installation
	*
	* Update: by WebMan - www.webmandesign.eu, www.webmandesign.eu
	*/
	if ( ! function_exists( 'wm_shortcode_paragraph_insertion_fix' ) ) {
		function wm_shortcode_paragraph_insertion_fix( $content ) {
			$fix = array(
				'<p>['            => '[',
				']</p>'           => ']',
				']<br />'         => ']',
				']<br>'           => ']',

				'<p></p>'         => '<span class="br"></span>',
				'<p>&nbsp;</p>'   => '<span class="br"></span>',

				'<h1></h1>'       => '<span class="br"></span>',
				'<h1>&nbsp;</h1>' => '<span class="br"></span>',

				'<h2></h2>'       => '<span class="br"></span>',
				'<h2>&nbsp;</h2>' => '<span class="br"></span>',

				'<h3></h3>'       => '<span class="br"></span>',
				'<h3>&nbsp;</h3>' => '<span class="br"></span>',

				'<h4></h4>'       => '<span class="br"></span>',
				'<h4>&nbsp;</h4>' => '<span class="br"></span>',

				'<h5></h5>'       => '<span class="br"></span>',
				'<h5>&nbsp;</h5>' => '<span class="br"></span>',

				'<h6></h6>'       => '<span class="br"></span>',
				'<h6>&nbsp;</h6>' => '<span class="br"></span>'
			);
			$content = strtr( $content, $fix );

			return $content;
		}
	} // /wm_shortcode_paragraph_insertion_fix



	/*
	* Preprocess [raw] and [pre] shortcodes to allow "[shortcode][/shortcode]" in them
	*
	* Source: http://betterwp.net/17-protect-shortcodes-from-wpautop-and-the-likes/
	*/
	if ( ! function_exists( 'wm_preprocess_shortcode' ) ) {
		function wm_preprocess_shortcode( $content ) {
			global $shortcode_tags;

			//Backup current registered shortcodes and clear them all out
			$orig_shortcode_tags = $shortcode_tags;
			$shortcode_tags      = array();
			remove_all_shortcodes();

			//To let [shortcode][/shortcode] in preformated text
			add_shortcode( 'raw', 'wm_shortcode_raw' );
			add_shortcode( 'pre', 'wm_shortcode_raw' );

			/*
			Preprocess shortcodes using inline HTML tags not to mess up with <p> tags openings and closings (or maybe all shortcodes? - some themes do that - but what for?).

			These shortcodes will be processed also normally (outside preprocessing) to retain compatibility with do_shortcode() (in sliders for example). Surely, if the shortcode was applied in preprocess, it shouldn't appear again in the content.
			*/
			add_shortcode( 'button', 'wm_shortcode_button' );
			add_shortcode( 'dropcap', 'wm_shortcode_dropcap' );
			add_shortcode( 'marker', 'wm_shortcode_marker' );
			add_shortcode( 'icon', 'wm_shortcode_icon' );
			add_shortcode( 'last_update', 'wm_shortcode_posts_update' );
			add_shortcode( 'social', 'wm_shortcode_social' );
			//text shortcodes:
				add_shortcode( 'big_text', 'wm_shortcode_big_text' );
				add_shortcode( 'huge_text', 'wm_shortcode_huge_text' );
				add_shortcode( 'small_text', 'wm_shortcode_small_text' );
				add_shortcode( 'uppercase', 'wm_shortcode_uppercase' );

			//Do the shortcode (only the above ones)
			$content = do_shortcode( $content );

			//Put the original shortcodes back
			$shortcode_tags = $orig_shortcode_tags;

			return $content;
		}
	} // /wm_preprocess_shortcode





/*
*****************************************************
*      3) SHORTCODES:
*****************************************************
*/

	/*
	*****************************************************
	*      ACCESS SHORTCODES
	*****************************************************
	*/
		/*
		* [administrator]content[/administrator]
		*
		* Displays content only for Administrators
		*/
		if ( ! function_exists( 'wm_shortcode_administrator' ) ) {
			function wm_shortcode_administrator( $atts, $content = null ) {
				if ( current_user_can( 'edit_dashboard' ) )
					return do_shortcode( $content );
			}
		} // /wm_shortcode_administrator
		add_shortcode( 'administrator', 'wm_shortcode_administrator' );



		/*
		* [author]content[/author]
		*
		* Displays content only for Authors
		*/
		if ( ! function_exists( 'wm_shortcode_author' ) ) {
			function wm_shortcode_author( $atts, $content = null ) {
				if ( current_user_can( 'edit_published_posts' ) && ! current_user_can( 'read_private_pages' ) )
					return do_shortcode( $content );
			}
		} // /wm_shortcode_author
		add_shortcode( 'author', 'wm_shortcode_author' );



		/*
		* [contributor]content[/contributor]
		*
		* Displays content only for Contributors
		*/
		if ( ! function_exists( 'wm_shortcode_contributor' ) ) {
			function wm_shortcode_contributor( $atts, $content = null ) {
				if ( current_user_can( 'edit_posts' ) && ! current_user_can( 'delete_published_posts' ) )
					return do_shortcode( $content );
			}
		} // /wm_shortcode_contributor
		add_shortcode( 'contributor', 'wm_shortcode_contributor' );



		/*
		* [editor]content[/editor]
		*
		* Displays content only for Editors
		*/
		if ( ! function_exists( 'wm_shortcode_editor' ) ) {
			function wm_shortcode_editor( $atts, $content = null ) {
				if ( current_user_can( 'moderate_comments' ) && ! current_user_can( 'edit_dashboard' ) )
					return do_shortcode( $content );
			}
		} // /wm_shortcode_editor
		add_shortcode( 'editor', 'wm_shortcode_editor' );



		/*
		* [subscriber]content[/subscriber]
		*
		* Displays content only for Subscribers
		*/
		if ( ! function_exists( 'wm_shortcode_subscriber' ) ) {
			function wm_shortcode_subscriber( $atts, $content = null ) {
				if ( current_user_can('moderate_comments') && ! current_user_can( 'delete_posts' ) )
					return do_shortcode( $content );
			}
		} // /wm_shortcode_subscriber
		add_shortcode( 'subscriber', 'wm_shortcode_subscriber' );





	/*
	*****************************************************
	*      ACCORDION
	*****************************************************
	*/
		/*
		* [accordion auto="1"]content[/accordion]
		*
		* Accordion wrapper
		*
		* auto = BOOLEAN/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_accordion' ) ) {
			function wm_shortcode_accordion( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'auto' => ''
					), $atts, 'accordion' )
					);

				//validation
				$duration = '';
				if ( $auto ) {
					if ( is_numeric( $auto ) && 1000 < absint( $auto ) )
						$duration = '<script>var autoAccordionDuration = ' . absint( $auto ) . ';</script>';
					$auto = ' auto';
				}

				//output
				$out = '<div class="accordion-wrapper' . $auto . '"><ul>' . do_shortcode( $content ) . '</ul></div>' . $duration;
				return $out;
			}
		} // /wm_shortcode_accordion
		add_shortcode( 'accordion', 'wm_shortcode_accordion' );



		/*
		* [accordion_item title="Accordion item title"]content[/accordion_item]
		*
		* Accordion item
		*
		* title = TEXT
		*/
		if ( ! function_exists( 'wm_shortcode_accordion_item' ) ) {
			function wm_shortcode_accordion_item( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'title' => ''
					), $atts, 'accordion_item' )
					);

				//validation
				if ( '' == $title )
					$title = 'Accordion';

				$title = strip_tags( $title, '<img><strong><span><small><em><b><i>' );

				//output
				$out = '<li><h3 class="accordion-heading">' . $title . '</h3>' . wpautop( do_shortcode( $content ) ) . '</li>';
				return $out;
			}
		} // /wm_shortcode_accordion_item
		add_shortcode( 'accordion_item', 'wm_shortcode_accordion_item' );





	/*
	*****************************************************
	*      AUDIO AND VIDEO
	*****************************************************
	*/

		/**
		 * [audio url="http://audioUrl" /]
		 *
		 * Video (makes native [embed] responsive and extends in with Screenr support)
		 *
		 * @param url [URL (video URL address)]
		 *
		 * @return [embed] video + Screenr video
		 */
		if ( ! function_exists( 'wm_shortcode_audio' ) ) {
			function wm_shortcode_audio( $atts, $content = null, $shortcode ) {
				global $is_IE;

				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'class'     => '',
						'album_art' => '',
						'url'       => '',
						//WP [audio] shortcode atts
						'autoplay' => '',
						'loop'     => '',
						'preload'  => '',
						'src'      => '',
							'mp3' => '',
							'm4a' => '',
							'ogg' => '',
							'wav' => '',
							'wma' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				$atts = shortcode_atts( $defaults, $atts, $shortcode );
				extract( $atts );

				$out = '';

				$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
				$class    = trim( 'audio-container wrap-player ' . esc_attr( $class ) );

				//validation
				$url = esc_url( $url );

				if ( false !== strpos( $url, ',' ) ) {
					$self_hosted_formats = array( 'mp3', 'm4a', 'ogg', 'wav', 'wma' );

					$url = str_replace( ' ', '', $url );
					$url = array_filter( explode( ',', $url ) );

					foreach ( $url as $single_url ) {
						foreach ( $self_hosted_formats as $format ) {
							if ( strpos( $single_url, '.' . $format ) ) {
								$atts[ $format ] = esc_url( $single_url );
							}
						}
					}

					$url = $atts['url'] = '';
				}

				if ( ! $url && $atts['src'] ) {
					$url = esc_url( $atts['src'] );
				}
				if ( ! $url && $atts['mp3'] ) {
					$url = esc_url( $atts['mp3'] );
				}
				$url = str_replace( 'https', $protocol, $url );

				if ( false !== strpos( $url, 'soundcloud.com' ) ) {
				//SoundCloud audios

					$out = '<div class="' . $class . '">' . wp_oembed_get( esc_url( $url ) ) . '</div>';

				} elseif ( false !== strpos( $url, '.mp3' ) ) {
				//Self hosted audio using WP [audio] shortcode function

					$atts['mp3'] = esc_url( $url );

					$album_art = trim( $album_art );
					if ( $album_art ) {
						$album_art = '<img src="' . esc_url( $album_art ) . '" alt="" />';
					}

					$out = '<div class="' . $class . '">' . $album_art . wp_audio_shortcode( array_filter( $atts ) ) . '</div>';

				}

				//output
				if ( ! $out ) {
					$out = do_shortcode( '[box color="red" icon="warning"]' . __( 'Please check the audio URL', 'clifden_domain' ) . '[/box]' );
				}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_audio

		if ( wm_check_wp_version( '3.6' ) ) {
			remove_shortcode( 'audio' );
		}
		add_shortcode( 'audio', 'wm_shortcode_audio' );



		/**
		 * [video url="http://videoUrl" /]
		 *
		 * Video (makes native [embed] responsive and extends in with Screenr support)
		 *
		 * @param url [URL (video URL address)]
		 *
		 * @return [embed] video + Screenr video
		 */
		if ( ! function_exists( 'wm_shortcode_video' ) ) {
			function wm_shortcode_video( $atts, $content = null, $shortcode ) {
				global $is_IE;

				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'class'          => '',
						'player'         => false,
						'player_preview' => '',
						'url'            => '',
						//WP [video] shortcode atts
						'autoplay' => '',
						'height'   => '',
						'loop'     => '',
						'poster'   => '',
						'preload'  => '',
						'src'      => '',
							'flv'  => '',
							'm4v'  => '',
							'mp4'  => '',
							'ogv'  => '',
							'webm' => '',
							'wmv'  => '',
						'width'    => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				$atts = shortcode_atts( $defaults, $atts, $shortcode );
				extract( $atts );

				$out = '';

				$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
				$class    = trim( 'video-container wrap-player ' . esc_attr( $class ) );

				$embedPlayerURL = array(
						'screenr' => $protocol . '://www.screenr.com/embed/',
					);

				//legacy
				$poster = $player_preview;

				//validation
				$url = esc_url( $url );

				if ( false !== strpos( $url, ',' ) ) {
					$self_hosted_formats = array( 'flv', 'm4v', 'mp4', 'ogv', 'webm', 'wmv' );

					$url = str_replace( ' ', '', $url );
					$url = array_filter( explode( ',', $url ) );

					foreach ( $url as $single_url ) {
						foreach ( $self_hosted_formats as $format ) {
							if ( strpos( $single_url, '.' . $format ) ) {
								$atts[ $format ] = esc_url( $single_url );
							}
						}
					}

					$url = $atts['url'] = '';
				}

				if ( ! $url && $atts['src'] ) {
					$url = esc_url( $atts['src'] );
				}
				if ( ! $url && $atts['mp4'] ) {
					$url = esc_url( $atts['mp4'] );
				}
				$url = str_replace( 'https', $protocol, $url );

				if ( false !== strpos( $url, 'screenr.com' ) ) {
				//Screenr
				//http://www.screenr.com/ScrID

					$url = str_replace( array( 'http://www.screenr.com/', 'http://screenr.com/' ), $embedPlayerURL['screenr'], $url );

					if ( $is_IE )
						$iFrameAtts = ' frameborder="0" scrolling="no" marginheight="0" marginwidth="0"';
					else
						$iFrameAtts = '';

					$out = '<div class="' . $class . '"><iframe src="' . esc_url( $url ) . '"' . $iFrameAtts . '></iframe></div>';

				} elseif ( false !== strpos( $url, '.mp4' ) ) {
				//Self hosted video using WP [video] shortcode function

					$atts['mp4'] = esc_url( $url );

					$out = '<div class="' . $class . '">' . wp_video_shortcode( array_filter( $atts ) ) . '</div>';

				} elseif ( $url ) {
				//All other embeds

					$out = '<div class="' . $class . '">' . wp_oembed_get( esc_url( $url ) ) . '</div>';

				}

				//output
				if ( ! $out ) {
					$out = do_shortcode( '[box color="red" icon="warning"]' . __( 'Please check the video URL', 'clifden_domain' ) . '[/box]' );
				}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_video

		if ( wm_check_wp_version( '3.6' ) ) {
			remove_shortcode( 'video' );
		}
		add_shortcode( 'video', 'wm_shortcode_video' );





	/*
	*****************************************************
	*      BOXES
	*****************************************************
	*/
		/*
		* [box color="green" title="Box title" icon="check" transparent="" hero=""]content[/box]
		*
		* color       = gray/green/blue/orange/red/NONE
		* icon        = info/question/check/warning/cancel/NONE
		* hero        = BOOLEAN/NONE
		* title       = TEXT
		* transparent = BOOLEAN/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_box' ) ) {
			function wm_shortcode_box( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'color'       => 'gray',
					'icon'        => '',
					'hero'        => '',
					'title'       => '',
					'transparent' => '',
					), $atts, 'box' )
					);

				$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );
				$iconList    = array( 'info', 'question', 'check', 'warning', 'cancel' );

				//validation
				$color = ( in_array( $color, $colorsArray ) ) ? ( esc_attr( $color ) ) : ( 'gray' );
				$hero  = ( $hero ) ? ( ' hero' ) : ( '' );

				if ( $title && ! $hero )
					$boxTitle = '<h2>' . $title . '</h2>';
				elseif ( $title && $hero )
					$boxTitle = '<p class="size-big"><strong>' . $title . '</strong></p>';
				else
					$boxTitle = '';

				$icon        = ( in_array( $icon, $iconList ) ) ? ( ' icon-box icon-' . esc_attr( $icon ) ) : ( '' );
				$transparent = ( $transparent ) ? ( ' no-background' ) : ( '' );

				//output
				return '<div class="box color-' . $color . $icon . $transparent . $hero . '">' . $boxTitle . do_shortcode( $content ) . '</div>';
			}
		} // /wm_shortcode_box
		add_shortcode( 'box', 'wm_shortcode_box' );





	/*
	*****************************************************
	*      BUTTONS
	*****************************************************
	*/
		/*
		* [button url="#" color="green" size="" text_color="fff" background_color="012345" align="right" new_window="" icon=""]content[/button]
		*
		* align            = right/left/NONE
		* background_color = #HEX/NONE
		* color            = gray/green/blue/orange/red/NONE
		* icon             = TEXT/NONE
		* new_window       = BOOLEAN/NONE
		* size             = s/m/l/xl/NONE
		* text_color       = #HEX/NONE
		* url              = URL/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_button' ) ) {
			function wm_shortcode_button( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'align'            => '',
					'background_color' => '',
					'color'            => '',
					'icon'             => '',
					'new_window'       => false,
					'size'             => 'm',
					'text_color'       => '',
					'url'              => '#',
					), $atts, 'button' )
					);

				$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );
				$buttonSizes = array(
					'all' => array( 's', 'm', 'l', 'xl' ),
					's'   => 'small',
					'm'   => 'medium',
					'l'   => 'large',
					'xl'  => 'extra-large',
					 );

				//validation
				$url   = esc_url( $url );
				$color = ( in_array( $color, $colorsArray ) ) ? ( ' color-' . esc_attr( $color ) ) : ( '' );
				$size  = ( in_array( $size, $buttonSizes['all'] ) ) ? ( ' size-' . esc_attr( $buttonSizes[$size] ) ) : ( ' size-medium' );

				$colorText  = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $text_color ) ); //remove non-numeric characters
				$colorRough = $colorText;
				$colorText  = ( 6 === strlen( $colorText ) || 3 === strlen( $colorText ) ) ? ( 'color:#' . $colorText . ';' ) : ( '' );
				$textShadow = null;

				$icon = ( $icon && false === strstr( $icon, 'icon-' ) ) ? ( 'icon-' . sanitize_title( $icon ) ) : ( $icon );
				$icon = ( $icon ) ? ( '<i class="' . $icon . '"></i> ' ) : ( '' );

				$align = ( 'right' === $align ) ? ( ' alignright' ) : ( '' );

				if ( $colorText )
					$textShadow = ( WM_COLOR_TRESHOLD < wm_color_brightness( $colorRough ) ) ? ( 'text-shadow:0 -1px rgba(0,0,0, 0.5);' ) : ( 'text-shadow:0 1px rgba(255,255,255, 0.5);' );

				$colorBackground = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $background_color ) ); //remove non-numeric characters
				$colorBackground = ( 6 === strlen( $colorBackground ) || 3 === strlen( $colorBackground ) ) ? ( 'background-color:#' . $colorBackground . ';border-color:#' . $colorBackground . ';' ) : ( '' );

				$newWindow = ( $new_window ) ? ( ' target="_blank"' ) : ( '' );

				//output
				$out = '<a href="' . $url . '" class="btn' . $size . $color . $align . '" style="' . $colorText . $textShadow . $colorBackground . '"' . $newWindow . '>' . $icon . do_shortcode( $content ) . '</a>';
				return $out;
			}
		} // /wm_shortcode_button
		add_shortcode( 'button', 'wm_shortcode_button' );





	/*
	*****************************************************
	*      CALL TO ACTION
	*****************************************************
	*/
		/*
		* [call_to_action title="" subtitle="" button_text="Button text" button_url="#" button_color="green" new_window="" color="" background_color="" text_color="" background_pattern=""]content[/call_to_action]
		*
		* background_color   = #HEX/NONE
		* background_pattern = stripes-dark/stripes-light/squares/URL/NONE
		* button_color       = gray/green/blue/orange/red/NONE
		* button_text        = TEXT
		* button_url         = URL
		* color              = gray/green/blue/orange/red/NONE
		* new_window         = BOOLEAN/NONE
		* text_color         = #HEX/NONE
		* subtitle           = TEXT
		* title              = TEXT
		*/
		if ( ! function_exists( 'wm_shortcode_call_to_action' ) ) {
			function wm_shortcode_call_to_action( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'background_color'   => '',
					'background_pattern' => '',
					'button_color'       => 'green',
					'button_text'        => '',
					'button_url'         => '',
					'color'              => '',
					'new_window'         => false,
					'text_color'         => '',
					'subtitle'           => '',
					'title'              => '',
					), $atts, 'call_to_action' )
					);

				$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );
				$bgPatterns  = array(
					'stripes-dark'  => WM_ASSETS_THEME . 'img/patterns/dark_stripes-10.png',
					'stripes-light' => WM_ASSETS_THEME . 'img/patterns/light_stripes-10.png',
					'squares'       => WM_ASSETS_THEME . 'img/patterns/square_bg.png',
					'checker'       => WM_ASSETS_THEME . 'img/patterns/checkered_pattern.png',
					'dots'          => WM_ASSETS_THEME . 'img/patterns/absurdidad.png',
					);

				//validation
				$subtitle        = ( $subtitle ) ? ( ' <small>' . $subtitle . '</small>' ) : ( '' );
				$title           = ( $title ) ? ( '<div class="call-to-action-title"><h2>' . $title . $subtitle . '</h2></div>' ) : ( '' );
				$titleClass      = ( $title ) ? ( ' has-title' ) : ( '' );

				$buttonText      = $button_text;
				$buttonUrl       = esc_url( $button_url );
				$buttonColor     = ( in_array( $button_color, $colorsArray ) ) ? ( esc_attr( $button_color ) ) : ( 'green' );
				$newWindow       = ( $new_window ) ? ( '1' ) : ( '' );

				$color           = ( in_array( $color, $colorsArray ) ) ? ( esc_attr( ' color-' . $color ) ) : ( '' );
				$colorText       = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $text_color ) ); //remove non-numeric characters
				$colorText       = ( 6 === strlen( $colorText ) || 3 === strlen( $colorText ) ) ? ( 'color:#' . $colorText . ';' ) : ( '' );
				$colorBackground = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $background_color ) ); //remove non-numeric characters
				$colorBackground = ( 6 === strlen( $colorBackground ) || 3 === strlen( $colorBackground ) ) ? ( ' background-color:#' . $colorBackground . '; border-color:#' . $colorBackground . ';' ) : ( '' );

				$pattern         = ( in_array( $background_pattern, array_flip( $bgPatterns ) ) ) ? ( ' background-image: url(' . esc_url( $bgPatterns[$background_pattern] ) . ');' ) : ( 'background-image: url(' . esc_url( $background_pattern ) . ');' );

				//output
				$out  = '<div class="call-to-action clearfix' . $color . $titleClass . '" style="' . $colorText . $colorBackground . $pattern . '">';
				$out .= $title . '<div class="cta-text">' . $content . '</div>';
				$out .= '[button url="' . $buttonUrl . '" color="' . $buttonColor . '" size="xl" new_window="' . $newWindow . '"]' . $buttonText . '[/button]';
				$out .= '</div>';

				return do_shortcode( shortcode_unautop( $out ) );
			}
		} // /wm_shortcode_call_to_action
		add_shortcode( 'call_to_action', 'wm_shortcode_call_to_action' );





	/*
	*****************************************************
	*      COLUMNS
	*****************************************************
	*/
		/**
		* [column size="1/4 last"]content[/column]
		*
		* Single column
		*
		* @param class [optional:STRING/NONE]
		* @param last  [optional/legacy:BOOLEAN/NONE]
		* @param size  [predefined,NONE]
		*/
		if ( ! function_exists( 'wm_shortcode_column' ) ) {
			function wm_shortcode_column( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'class' => '',
					'last'  => false,
					'size'  => '1/2',
					), $atts, 'column' )
					);

				$columnSizes = array(
					'1/2',
						'1/2 last',
					'1/3',
						'1/3 last',
					'2/3',
						'2/3 last',
					'1/4',
						'1/4 last',
					'3/4',
						'3/4 last',
					'1/5',
						'1/5 last',
					'2/5',
						'2/5 last',
					'3/5',
						'3/5 last',
					'4/5',
						'4/5 last',
					'1/6',
						'1/6 last',
					'5/6',
						'5/6 last',
					);

				//validation
				$classes  = ( in_array( trim( $size ), $columnSizes ) ) ? ( 'col-' . str_replace( '/', '', trim( $size ) ) ) : ( 'col-12' );
				$classes .= ( $last ) ? ( ' last' ) : ( '' );
				$classes .= ( $class ) ? ( ' ' . trim( $class ) ) : ( '' );

				//output
				$out = '<div class="column ' . $classes . '">' . do_shortcode( $content ) . '</div>';
				return $out;
			}
		} // /wm_shortcode_column
		add_shortcode( 'column', 'wm_shortcode_column' );





	/*
	*****************************************************
	*      COUNTDOWN TIMER
	*****************************************************
	*/
		/**
		* [countdown time="" size="" /]
		*
		* Countdown timer
		*
		* @param size [s/m/l/xl/NONE]
		* @param time [DATE: Y-m-d H:i]
		*/
		if ( ! function_exists( 'wm_shortcode_countdown' ) ) {
			function wm_shortcode_countdown( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'size' => 'xl',
					'time' => '',
					), $atts, 'countdown' )
					);

				//validation
				if ( ! trim( $time ) || ! strtotime( trim( $time ) ) || strtotime( trim( $time ) ) < strtotime( 'now' ) )
					return;

				static $countdownIDs;

				$sizes = array(
					'all' => array( 's', 'm', 'l', 'xl' ),
					's'   => 'small',
					'm'   => 'medium',
					'l'   => 'large',
					'xl'  => 'extra-large',
					);

				$size = ( in_array( trim( $size ), $sizes['all'] ) ) ? ( ' size-' . esc_attr( $sizes[trim( $size )] ) ) : ( ' size-medium' );
				$time = strtotime( trim( $time ) );

				$out = '<!-- Countdown timer -->
					<div class="countdown-timer' . $size . '">
						<div id="countdown-timer-' . absint( ++$countdownIDs ) . '">
							<div class="dash weeks_dash">
								<span class="dash_title">' . apply_filters( 'wmhook_countdown_text_weeks', __( 'Weeks', 'clifden_domain' ) ) . '</span>
								<div class="digit first">0</div>
								<div class="digit">0</div>
							</div>

							<div class="dash days_dash">
								<span class="dash_title">' . apply_filters( 'wmhook_countdown_text_days', __( 'Days', 'clifden_domain' ) ) . '</span>
								<div class="digit first">0</div>
								<div class="digit">0</div>
							</div>

							<div class="dash hours_dash">
								<span class="dash_title">' . apply_filters( 'wmhook_countdown_text_hours', __( 'Hours', 'clifden_domain' ) ) . '</span>
								<div class="digit first">0</div>
								<div class="digit">0</div>
							</div>

							<div class="dash minutes_dash">
								<span class="dash_title">' . apply_filters( 'wmhook_countdown_text_minutes', __( 'Minutes', 'clifden_domain' ) ) . '</span>
								<div class="digit first">0</div>
								<div class="digit">0</div>
							</div>

							<div class="dash seconds_dash">
								<span class="dash_title">' . apply_filters( 'wmhook_countdown_text_seconds', __( 'Seconds', 'clifden_domain' ) ) . '</span>
								<div class="digit first">0</div>
								<div class="digit">0</div>
							</div>
						</div>
					</div>

				<script><!--
				jQuery( function() {
					jQuery( "#countdown-timer-' . absint( $countdownIDs ) . '" ).countDown( {
						targetDate: {
							"day"   : ' . date( 'j', $time ) . ',
							"month" : ' . date( 'n', $time ) . ',
							"year"  : ' . date( 'Y', $time ) . ',
							"hour"  : ' . date( 'G', $time ) . ',
							"min"   : ' . intval( date( 'i', $time ) ) . ',
							"sec"   : 0
						}
					} );
				} );
				//--></script>';

				//output
				if ( $out ) {
					wp_enqueue_script( 'lwtCountdown' );
					return $out . "\r\n\r\n";
				}
			}
		} // /wm_shortcode_countdown
		add_shortcode( 'countdown', 'wm_shortcode_countdown' );





	/*
	*****************************************************
	*      DIVIDER
	*****************************************************
	*/
		/*
		* [divider type="space" height="60" no_border="1" opacity="10" top_link="" unit="em" /]
		*
		* height    = #/NONE
		* no_border = BOOLEAN
		* opacity   = 0-100
		* top_link  = BOOLEAN
		* type      = space/dotted/dashed/shadow-top/shadow-bottom/NONE
		* unit      = px/em/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_divider' ) ) {
			function wm_shortcode_divider( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'height'    => '',
					'no_border' => false,
					'opacity'   => 15,
					'top_link'  => false,
					'type'      => '',
					'unit'      => 'px',
					), $atts, 'divider' )
					);

				$spaceTypes = array( 'shadow-top', 'shadow-bottom', 'dots', 'dashes' );
				$units      = array( 'px', 'em', '%' );

				//validation
				$unit        = ( in_array( $unit, $units ) ) ? ( $unit ) : ( 'px' );
				$height      = ( isset( $height ) && $height ) ? ( ' style="margin-bottom:' . ( absint( $height ) ) . $unit . '"' ) : ( '' );
				$type        = ( in_array( $type, $spaceTypes ) ) ? ( ' type-' . esc_attr( $type ) ) : ( '' );
				$border      = ( $no_border ) ? ( ' no-border' ) : ( '' );
				$opacity     = ( $opacity && 101 > absint( $opacity ) ) ? ( ' style="opacity: ' . ( absint( str_replace( '%', '', $opacity ) ) / 100 ) . '; filter: alpha(opacity=' . str_replace( '%', '', $opacity ) . ');"' ) : ( '' );
				$shadow      = ( ' type-shadow-top' == $type || ' type-shadow-bottom' == $type ) ? ( str_replace( ' type-shadow-', '', $type ) ) : ( '' );
				$shadowImage = ( $shadow ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/shadows/shadow-' . $shadow . '.png"' . $opacity . ' alt="" />' ) : ( '' );
				$shadowClass = ( $shadow ) ? ( ' shadow shadow-' . $shadow . ' no-border' ) : ( '' );
				$height      = ( $shadow ) ? ( '' ) : ( $height );

				//output
				$out = '<div class="divider' . $type . $border . $shadowClass . '"' . $height . '>' . $shadowImage;
				$out .= ( $top_link ) ? ( '<a href="#top" class="top-of-page">' . __( 'Top', 'clifden_domain' ) . '</a>' ) : ( '' );
				$out .= '</div>';
				return $out;
			}
		} // /wm_shortcode_divider
		add_shortcode( 'devider', 'wm_shortcode_divider' ); //legacy...
		add_shortcode( 'divider', 'wm_shortcode_divider' );





	/*
	*****************************************************
	*      DROPCAPS
	*****************************************************
	*/
		/*
		* [dropcap type="round"]content[/dropcap]
		*
		* type = round/square/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_dropcap' ) ) {
			function wm_shortcode_dropcap( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'type' => ''
					), $atts, 'dropcap' )
					);

				$dropcapTypes = array( 'round', 'square', 'leaf' );

				//validation
				$type = ( in_array( $type, $dropcapTypes ) ) ? ( ' ' . $type ) : ( '' );

				//output
				$out = '<span class="dropcap' . $type . '">' . do_shortcode( $content ) . '</span>';
				return $out;
			}
		} // /wm_shortcode_dropcap
		add_shortcode( 'dropcap', 'wm_shortcode_dropcap' );





	/*
	*****************************************************
	*      ICON
	*****************************************************
	*/
		/*
		* [icon type="icon-adjust" size="" /]
		*
		* type = predefined/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_icon' ) ) {
			function wm_shortcode_icon( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'size' => '',
					'type' => ''
					), $atts, 'icon' )
					);

				//validation
				$size = ( $size ) ? ( ' style="font-size:' . esc_attr( $size ) . '; line-height:' . esc_attr( $size ) . ';"' ) : ( '' );
				$type = ( false !== stripos( $type, 'icon-' ) ) ? ( $type ) : ( 'icon-' . $type );

				//output
				$out = ( ! $type ) ? ( '' ) : ( '<i class="' . esc_attr( $type ) . '"' . $size . '></i>' );
				return $out;
			}
		} // /wm_shortcode_icon
		add_shortcode( 'icon', 'wm_shortcode_icon' );





	/*
	*****************************************************
	*      LISTS
	*****************************************************
	*/
		/*
		* [list icon="star"]content[/list]
		*
		* icon = icon name/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_list' ) ) {
			function wm_shortcode_list( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'icon'  => '',
					), $atts, 'list' )
					);

				$icon = ( $icon && false === strstr( $icon, 'icon-' ) ) ? ( 'icon-' . sanitize_title( $icon ) ) : ( $icon );
				$icon = ( $icon ) ? ( ' ' . esc_attr( $icon ) ) : ( '' );

				//output
				$out = do_shortcode( shortcode_unautop( str_replace( '<li>', '<li class="' . $icon . '">', $content ) ) );
				return $out;
			}
		} // /wm_shortcode_list
		add_shortcode( 'list', 'wm_shortcode_list' );





	/*
	*****************************************************
	*      LOGIN FORM
	*****************************************************
	*/
		/*
		* [login stay="" /]
		*
		* stay = BOOLEAN/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_login' ) ) {
			function wm_shortcode_login( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'stay' => false,
					), $atts, 'login' )
					);

				$redirect = ( $stay ) ? ( get_permalink() ) : ( home_url() );

				$out = '';
				$out .= '<div class="wrap-login">';


				if ( ! is_user_logged_in() ) {
					$out .= '<h3>' . __( 'Log in', 'clifden_domain' ) . '</h3>';

					$out .= wp_login_form( array(
						'echo'           => false,
						'redirect'       => $redirect,
						'form_id'        => 'form-login',
						'label_username' => __( 'Username', 'clifden_domain' ),
						'label_password' => __( 'Password', 'clifden_domain' ),
						'label_remember' => __( 'Remember Me', 'clifden_domain' ),
						'label_log_in'   => __( 'Log In', 'clifden_domain' ),
						'id_username'    => 'user_login',
						'id_password'    => 'user_pass',
						'id_remember'    => 'rememberme',
						'id_submit'      => 'wp-submit',
						'remember'       => true,
						'value_username' => null,
						'value_remember' => false
						) );

					$out .= '<p class="note"><small><a href="' . wp_lostpassword_url( get_permalink() ) . '" title="' . __( 'Password will be resent to your e-mail address.', 'clifden_domain' ) . '">' . __( 'I have lost my password', 'clifden_domain' ) . '</a></small></p>';
				} else {
					$out .= '[button url="' . wp_logout_url( get_permalink() ) . '" color="red" size="xl"]' . __( 'Log out', 'clifden_domain' ) . '[/button]';
				}

				$out .= '</div>';

				//output
				return do_shortcode( $out );
			}
		} // /wm_shortcode_login
		add_shortcode( 'login', 'wm_shortcode_login' );





	/*
	*****************************************************
	*      MARKERS
	*****************************************************
	*/
		/*
		* [marker color="green" text_color="fff" background_color="012345"]content[/marker]
		*
		* background_color = #HEX/NONE
		* color            = gray/green/blue/orange/red/NONE
		* text_color       = #HEX/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_marker' ) ) {
			function wm_shortcode_marker( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'background_color' => '',
					'color'            => 'gray',
					'text_color'       => '',
					), $atts, 'marker' )
					);

				$colorsArray = array( 'gray', 'green', 'blue', 'orange', 'red' );

				//validation
				$color = ( in_array( $color, $colorsArray ) ) ? ( ' color-' . esc_attr( $color ) ) : ( ' color-gray' );

				$colorText = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $text_color ) ); //remove non-numeric characters
				$colorText = ( 6 === strlen( $colorText ) || 3 === strlen( $colorText ) ) ? ( 'color:#' . $colorText . ';' ) : ( '' );

				$colorBackground = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $background_color ) ); //remove non-numeric characters
				$colorBackground = ( 6 === strlen( $colorBackground ) || 3 === strlen( $colorBackground ) ) ? ( 'background-color:#' . $colorBackground . ';' ) : ( '' );

				//output
				$out = '<span class="marker' . $color . '" style="' . $colorText . $colorBackground . '">' . do_shortcode( $content ) . '</span>';
				return $out;
			}
		} // /wm_shortcode_marker
		add_shortcode( 'marker', 'wm_shortcode_marker' );





	/*
	*****************************************************
	*      POSTS / PAGES / CUSTOM POSTS
	*****************************************************
	*/
		/*
		* [content_module id="123" no_thumb="" no_title="" layout="" randomize="" /]
		*
		* Content module
		*
		* id        = POST ID OR SLUG [required]
		* layout    = center/NONE
		* no_thumb  = BOOLEAN
		* no_title  = BOOLEAN
		* randomize = CONTENT MODULE TAG ID OR SLUG
		* widget    = BOOLEAN
		*/
		if ( ! function_exists( 'wm_shortcode_content_module' ) ) {
			function wm_shortcode_content_module( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'id'        => null,
					'layout'    => '',
					'no_thumb'  => false,
					'no_title'  => false,
					'randomize' => null,
					'widget'    => true,
					), $atts, 'content_module' )
					);
				if ( ! $id && ! $randomize )
					return;

				static $displayedIds = array();

				$id        = ( is_numeric( $id ) ) ? ( absint( $id ) ) : ( sanitize_title( $id ) );
				$postQuery = ( is_numeric( $id ) ) ? ( 'p' ) : ( 'name' );
				$randomize = ( is_numeric( $randomize ) ) ? ( absint( $randomize ) ) : ( sanitize_title( $randomize ) );
				$field     = ( is_numeric( $randomize ) ) ? ( 'id' ) : ( 'slug' );

				$out = '';

				//get the Content Module content
				wp_reset_query();

				if ( $randomize )
					$queryArgs = array(
						'post_type'           => 'wm_modules',
						'posts_per_page'      => 1,
						'ignore_sticky_posts' => 1,
						'orderby'             => 'rand',
						'tax_query'           => array( array(
								'taxonomy' => 'content-module-tag',
								'field'    => $field,
								'terms'    => $randomize
							) ),
						'post__not_in'        => $displayedIds,
						);
				else
					$queryArgs = array(
						'post_type' => 'wm_modules',
						$postQuery  => $id,
						);

				$the_module = new WP_Query( $queryArgs );
				if ( $the_module->have_posts() ) {

					$the_module->the_post();

					$displayedIds[] = get_the_ID();

					$moreURL   = esc_url( stripslashes( wm_meta_option( 'module-link' ) ) );
					$iconBg    = ( wm_meta_option( 'module-icon-box-color' ) ) ? ( ' style="background-color: ' . wm_meta_option( 'module-icon-box-color', get_the_ID(), 'color' ) . ';"' ) : ( '' );
					$iconColor = ( wm_meta_option( 'module-font-icon-color' ) ) ? ( ' style="color: ' . wm_meta_option( 'module-font-icon-color', get_the_ID(), 'color' ) . ';"' ) : ( '' );
					$layout    = ( $layout ) ? ( ' layout-' . $layout ) : ( null );

					//HTML to display output
					$classWrapper  = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( ' icon-module' ) : ( '' );
					$classWrapper .= ( $no_thumb ) ? ( ' no-thumb' ) : ( '' );
					$classWrapper .= ( $no_title ) ? ( ' no-title' ) : ( '' );
					$classWrapper .= ( wm_meta_option( 'module-icon-box-transparent' ) ) ? ( ' transparent-icon-bg' ) : ( '' );

					$moduleTitle = '<h3>';
					$moduleTitle .= ( $moreURL ) ? ( '<a href="' . $moreURL . '">' ) : ( '' );
					$moduleTitle .= get_the_title();
					$moduleTitle .= ( $moreURL ) ? ( '</a>' ) : ( '' );
					$moduleTitle .= '</h3>';

					$out .= '<div class="content-module-' . get_the_ID() . $classWrapper . $layout . '">';

						if ( 'icon' === wm_meta_option( 'module-type' ) && wm_meta_option( 'module-font-icon' ) ) {

							$imageContainerClass  = 'icon-container font-icon';
							$imageContainerClass .= ( $iconBg ) ? ( ' colored-background' ) : ( '' );
							$out .= '<div class="' . $imageContainerClass . '"' . $iconBg . '>';
								if ( $moreURL ) {
									$out .= '<a href="' . $moreURL . '">';
								}
								$out .= '<i class="' . wm_meta_option( 'module-font-icon' ) . '"' . $iconColor . '></i>';
								if ( $moreURL ) {
									$out .= '</a>';
								}
							$out .= '</div>';

						} elseif ( has_post_thumbnail() && ! $no_thumb ) {

							$imageContainerClass = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( 'icon-container' ) : ( 'image-container' );
							$out .= '<div class="' . $imageContainerClass . '">';
							if ( $moreURL ) {
								$out .= '<a href="' . $moreURL . '">';
							}
							//if icon module and featured image - make featured image 64x64 pixels ("widget" size), else use "mobile" width image while keep proportions
							$fullImg = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( get_the_post_thumbnail( get_the_ID(), 'widget' ) ) : ( get_the_post_thumbnail( get_the_ID(), 'mobile' ) );
							$out .= preg_replace( '/(width|height)=\"\d*\"\s/', "", $fullImg );
							if ( $moreURL ) {
								$out .= '</a>';
							}
							$out .= '</div>';

						}

						if ( ! $no_title )
							$out .= $moduleTitle;

						$out .= '<div class="module-content clearfix">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';

						$customs = get_post_custom();

					$out .= '</div>';

				}	else {

					return;

				}
				wp_reset_query();

				//output
				$out = apply_filters( 'wmhook_shortcode_' . 'content_module' . '_output', $out, $atts );
				if ( $widget )
					return '<div class="widget wm-content-module">' . $out . '</div>';
				else
					return $out;
			}
		} // /wm_shortcode_content_module
		add_shortcode( 'content_module', 'wm_shortcode_content_module' );



		/*
		* [faq category="5" filter="left" order="new" filter_color="blue" align=""][/faq]
		*
		* FAQ list
		*
		* align        = left/right/NONE
		* category     = FAQ CATEGORY ID OR SLUG
		* desc_size    = #/NONE
		* filter       = above/left/right/NONE
		* filter_color = gray/green/blue/orange/red/NONE
		* order        = new/old/name/random/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_faq' ) ) {
			function wm_shortcode_faq( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'align'        => 'left',
					'category'     => null,
					'desc_size'    => 4,
					'filter'       => '',
					'filter_color' => '',
					'order'        => 'name',
					), $atts, 'faq' )
					);

				if ( 'disable' === wm_option( 'general-role-faq' ) )
					return;

				//validation
				$align           = ( 'right' === $align ) ? ( $align ) : ( 'left' );
				$colsDesc        = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
				$toggleAnimation = ''; //sets simple toggle() animation when Isotope is used
				$isotopeLayout   = 'vertical';
				$filterContent   = $out = '';
				$colorsArray     = array( 'gray', 'green', 'blue', 'orange', 'red' );
				$filterPositions = array( 'above', 'left', 'right' );
				$orderMethod     = array(
						'all'    => array( 'new', 'old', 'name', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'name'   => array( 'title', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$filterBtnClass  = ( $filter_color && in_array( $filter_color, $colorsArray ) ) ? ( 'btn color-' . $filter_color ) : ( 'btn' );

				$filter   = ( $filter && in_array( $filter, $filterPositions ) ) ? ( $filter ) : ( false );
				$order    = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['name'] );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'faq-category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				//get the faq
				wp_reset_query();

				$queryArgs = array(
						'post_type'           => 'wm_faq',
						'posts_per_page'      => -1,
						'ignore_sticky_posts' => 1,
						'orderby'             => $order[0],
						'order'               => $order[1]
					);
				if ( $category )
					$queryArgs['tax_query'] = array( array(
						'taxonomy' => 'faq-category',
						'field'    => 'id',
						'terms'    => $category
					) );

				$faq = new WP_Query( $queryArgs );
				if ( $faq->have_posts() ) {

					$out .= '<div class="wrap-faq-shortcode filterable-content clearfix">';
					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last">' );
						$filter = false;
					}

					//filter output code
					if ( $filter ) {
						$toggleAnimation = ' animation-fade';
						$realLinks       = ( stripos( $filter, '-links' ) ) ? ( true ) : ( false );
						$filterContent  .= '<ul><li><a href="#" data-filter="*" class="active ' . $filterBtnClass . '">' . __( 'All', 'clifden_domain' ) . '</a></li>';
						$filterBtnClass  = ( $filterBtnClass ) ? ( ' class="' . $filterBtnClass . '"' ) : ( '' );

						if ( $category ) { //if parent category set - filter from child categories
							$terms  = get_term_children( $category, 'faq-category' );
							$count  = count( $terms );
							if ( ! is_wp_error( $terms ) && $count > 0 ) {
								$outFilter = array();
								foreach ( $terms as $child ) {
									$href = ( $realLinks ) ? ( get_term_link( $term->slug, 'faq-category' ) ) : ( '#' );
									$term = get_term_by( 'id', $child, 'faq-category' );

									$outArray['<li><a href="' . $href . '" data-filter=".faq-category-' . $term->slug . '"' . $filterBtnClass . '>' . $term->name . '</a></li>'] = $term->name;
								}
								asort( $outArray );
								$outArray = array_flip( $outArray );
								$filterContent .= implode( '', $outArray );
							}
						} else { //no parent category - filter from all categories
							$terms = get_terms( 'faq-category' );
							$count = count( $terms );
							if ( ! is_wp_error( $terms ) && $count > 0 ) {
								foreach ( $terms as $term ) {
									$href = ( $realLinks ) ? ( get_term_link( $term->slug, 'faq-category' ) ) : ( '#' );

									$filterContent .= '<li><a href="' . $href . '" data-filter=".faq-category-' . $term->slug . '"' . $filterBtnClass . '>' . $term->name . '</a></li>';
								}
							}
						}

						$filterContent .= '</ul>';
					}

					if ( 'above' === $filter )
						$out .= '<div class="wrap-filter">' . $filterContent . '</div><div class="wrap-faqs filter-this" data-layout-mode="' . $isotopeLayout . '">';
					elseif ( 'left' === $filter )
						$out .= '<div class="wrap-filter column col-15">' . $filterContent . '</div><div class="wrap-faqs column col-45 last filter-this" data-layout-mode="' . $isotopeLayout . '">';
					elseif ( 'right' === $filter )
						//$out .= '<div class="wrap-faqs column col-45 filter-this" data-layout-mode="' . $isotopeLayout . '">';
						$out .= '<div class="wrap-filter column col-15 alignright ml0 mr0">' . $filterContent . '</div><div class="wrap-faqs column col-45 filter-this" data-layout-mode="' . $isotopeLayout . '">';
					else
						$out .= '<div class="wrap-faqs">';

					while ( $faq->have_posts() ) : //output post content
						$faq->the_post();

						$terms      = get_the_terms( get_the_ID() , 'faq-category' );
						$termsClass = '';
						if ( ! is_wp_error( $terms ) && $terms ) {
							foreach( $terms as $term ) {
								$termsClass .= ' faq-category-' . $term->slug;
							}
						}

						$out   .= '<article class="item item-' . get_the_ID() . $termsClass . '"><div class="toggle-wrapper">';
							$out .= '<h3 class="toggle-heading question' . $toggleAnimation . '">' . get_the_title() . '</h3>';
							$out .= '<div class="answer">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
						$out   .= '</div></article>';
					endwhile;

					if ( '1right' === $filter )
						$out .= '</div><div class="wrap-filter column col-15 last">' . $filterContent . '</div>';
					else
						$out .= '</div>';

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '</div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' );
					}

					$out .= '</div>';

				}
				wp_reset_query();

				if ( $filter )
					wp_enqueue_script( 'isotope' );

				$out = apply_filters( 'wmhook_shortcode_' . 'faq' . '_output', $out, $atts );
				return $out;
			}
		} // /wm_shortcode_faq
		add_shortcode( 'faq', 'wm_shortcode_faq' );



		/*
		* [last_update format="" item="" /]
		*
		* Date of last update of posts or projects
		*
		* item   = projects/posts/NONE
		* format = text/NONE (PHP date format)
		*/
		if ( ! function_exists( 'wm_shortcode_posts_update' ) ) {
			function wm_shortcode_posts_update( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'item'   => 'posts',
					'format' => get_option( 'date_format' ),
					), $atts, 'last_update' )
					);

				$itemArray = array(
					'projects' => 'wm_projects',
					'posts'    => 'post'
					);
				if ( 'disable' === wm_option( 'general-role-projects' ) )
					$itemArray = array(
						'posts' => 'post'
						);

				$item = ( in_array( $item, array_flip( $itemArray ) ) ) ? ( $itemArray[$item] ) : ( 'post' );

				$post = get_posts( array(
					'numberposts' => 1,
					'post_type'   => $item,
					) );

				return date( $format, strtotime( $post[0]->post_date ) );
			}
		} // /wm_shortcode_posts_update
		add_shortcode( 'last_update', 'wm_shortcode_posts_update' );



		/*
		* [logos columns="5" count="10" order="new" align="left"]content[/logos]
		*
		* Logos (of clients/partners)
		*
		* align     = left/right/NONE
		* category  = LOGOS CATEGORY ID OR SLUG
		* columns   = #/NONE (2 - 6)
		* count     = #/NONE
		* desc_size = #/NONE
		* order     = new/old/name/random/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_logos' ) ) {
			function wm_shortcode_logos( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'align'     => 'left',
					'category'  => null,
					'columns'   => 4,
					'count'     => 4,
					'desc_size' => 4,
					'order'     => 'random',
					), $atts, 'logos' )
					);

				if ( 'disable' === wm_option( 'general-role-logos' ) )
					return;

				$out = '';

				//validation
				$align       = ( 'right' === $align ) ? ( $align ) : ( 'left' );
				$cols        = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
				$colsDesc    = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
				$count       = ( $count ) ? ( absint( $count ) ) : ( 4 );
				$orderMethod = array(
						'all'    => array( 'new', 'old', 'name', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'name'   => array( 'title', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$order       = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'logos-category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				//get the logos
				wp_reset_query();

				$queryArgs = array(
						'post_type'           => 'wm_logos',
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'orderby'             => $order[0],
						'order'               => $order[1]
					);
				if ( $category )
					$queryArgs['tax_query'] = array( array(
						'taxonomy' => 'logos-category',
						'field'    => 'id',
						'terms'    => $category
					) );

				$logos = new WP_Query( $queryArgs );
				if ( $logos->have_posts() ) {

					$i    = $row = 0;
					$out .= '<div class="wrap-logos-shortcode clearfix">';

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-logos"><div class="row">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-logos"><div class="row">' ); //if description on the right - open logos container and inner container only ELSE output content column and open logos container
					} else {
					//if no description (no shortcode content)
						$out .= '<div class="wrap-logos"><div class="row">';
					}

						while ( $logos->have_posts() ) : //output post content
							$logos->the_post();

							$link   = ( wm_meta_option( 'client-link' ) ) ? ( esc_url( wm_meta_option( 'client-link' ) ) ) : ( null );
							$rel    = ( wm_meta_option( 'client-link-rel' ) ) ? ( ' rel="' . esc_attr( wm_meta_option( 'client-link-rel' ) ) . '"' ) : ( null );
							$target = ( wm_meta_option( 'client-link-action' ) ) ? ( wm_meta_option( 'client-link-action' ) ) : ( '_blank' );

							$row    = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out   .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
							$out   .= '<article class="column col-1' . $cols . ' no-margin">';
								$out .= ( $link ) ? ( '<a href="' . $link . '" target="' . $target . '"' . $rel . '>' ) : ( '' );
								$out .= '<img src="' . esc_url( wm_meta_option( 'client-logo' ) ) . '" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
								$out .= ( $link ) ? ( '</a>' ) : ( '' );
							$out   .= '</article>';
						endwhile;

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '</div></div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div></div>' ); //if description on the right - close logos container and its inner container and output content column ELSE just close logos container and its inner container
					} else {
					//if no description (no shortcode content)
						$out .= '</div></div>';
					}

					$out .= '</div>';

				}
				wp_reset_query();

				$out = apply_filters( 'wmhook_shortcode_' . 'logos' . '_output', $out, $atts );
				return $out;
			}
		} // /wm_shortcode_logos
		add_shortcode( 'logos', 'wm_shortcode_logos' );



		/*
		* [posts columns="5" count="10" category="5" order="new" related="0" align="left" scroll="" thumb="0"]content[/posts]
		*
		* Post list
		*
		* align          = left/right/NONE
		* category       = POSTS CATEGORY ID OR SLUG
		* columns        = #/NONE (1 - 6) *Modified by Tiria*
		* count          = #/NONE
		* desc_size      = #/NONE
		* excerpt_length = #/NONE
		* order          = new/old/name/random/NONE
		* related        = BOOLEAN
		* scroll         = BOOLEAN
		* thumb          = BOOLEAN
		* thumbsize      = THUMBNAIL SIZE
		* datedisplay	 = BOOLEAN *Added by Tiria*
		*
		* Modified by Tiria to allow 1 column posts and add possibility to disable date
		*
		*/
		if ( ! function_exists( 'wm_shortcode_posts' ) ) {
			function wm_shortcode_posts( $atts, $content = null, $shortcode ) {
				extract( shortcode_atts( array(
					'align'          => 'left',
					'category'       => null,
					'columns'        => 1,
					'count'          => 4,
					'desc_size'      => 4,
					'excerpt_length' => 20,
					'order'          => 'new',
					'related'        => false,
					'scroll'         => false,
					'thumb'          => true,
					'thumbsize'		 => 'thumbnail',
					'datedisplay'    => true,
					), $atts, $shortcode )
					);

				$out = '';

				$imgSize = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );
				$imgSize = ( '' != $thumbsize && in_array( $thumbsize, get_intermediate_image_sizes() ) ) ? ( $thumbsize ) : ( $imgSize );
				//validation
				$align       = ( 'right' === $align ) ? ( $align ) : ( 'left' );
				$cols        = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 1 );
				$colsDesc    = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
				$count       = ( $count ) ? ( absint( $count ) ) : ( 4 );
				$orderMethod = array(
						'all'    => array( 'new', 'old', 'name', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'name'   => array( 'title', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$order       = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );
				$classScroll = ( $scroll ) ? ( ' scrollable' ) : ( '' );
				$thumb       = ( $thumb ) ? ( true ) : ( false );
				$excerptLength = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 10 );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				//get the posts
				wp_reset_query();

				$queryArgs = array(
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'cat'                 => $category,
						'orderby'             => $order[0],
						'order'               => $order[1],
						'tax_query'           => array( array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => array( 'post-format-quote', 'post-format-status' ),
							'operator' => 'NOT IN',
							) )
					);

				if ( $related ) {
					global $post;

					if ( isset( $post->ID ) ) {
						//Get current post categories
							$taxonomies = array();
							$terms      = get_the_terms( $post->ID , 'category' );
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								foreach( $terms as $term ) {
									$taxonomies[] = $term->term_id;
								}
							}
						$queryArgs['cat'] = implode( ',', $taxonomies );

						//Get current post tags
							$taxonomies = array();
							$terms      = get_the_terms( $post->ID , 'post_tag' );
							if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
								foreach( $terms as $term ) {
									$taxonomies[] = $term->slug;
								}
							}
						$queryArgs['tag'] = implode( ',', $taxonomies );

						$queryArgs['post__not_in'] = array( $post->ID );
					}
				}

				$queryArgs = apply_filters( 'wmhook_shortcode_posts_query', $queryArgs );

				$posts = new WP_Query( $queryArgs );

				if ( $posts->have_posts() ) {

					$i    = $row = 0;
					$out .= '<div class="wrap-posts-shortcode clearfix">';

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-posts' . $classScroll . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-posts' . $classScroll . '">' ); //if description on the right - open posts container and inner container only ELSE output content column and open posts container
					} else {
					//if no description (no shortcode content)
						$out .= '<div class="wrap-posts' . $classScroll . '">';
					}

						$out .= '<div class="row">';

						while ( $posts->have_posts() ) : //output post content
							$posts->the_post();
							
							$evenodd = (isset($evenodd) && $evenodd=='even') ? 'odd' : 'even'; // Added by Tiria
							if ( 0 < $excerptLength ) {
								$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', get_the_excerpt(), $excerptLength );
							} else {
								$excerptText = '';
							}
							$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerptText, get_the_id(), $atts );

							$postOutput = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
									'date'    => '<time class="post-publish-time">' . esc_html( get_the_date() ) . '</time>',
									'thumb'   => wm_thumb( array(
											'class'        => 'post-thumb',
											'size'         => $imgSize,
											'list'         => true,
											'link'         => true,
											'placeholder'  => true,
										) ),
									'title'   => '<h4 class="post-title text-element"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>',
									'excerpt' => $excerptText,
									'more'    => ' | ' . wm_more( 'nobtn' )
								), get_the_id(), $atts );

							$row    = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out   .= ( $i % $cols === 1 && 0 < $row ) ? ( '</div><div class="row">' ) : ( '' );
							$out   .= '<article class="column col-1' . $cols . ' '.$evenodd.' no-margin">';
								$out .= ( $thumb ) ? ( $postOutput['thumb'] ) : ( '' );
								$out .= '<div class="text">';
									$out .= $postOutput['title'];
									if($datedisplay) $out .= '<div class="text-element post-date">' . $postOutput['date'] . '</div>';
									$out .= '<div class="post-excerpt text-element">' . $postOutput['excerpt'] . '</div>';
									$out .= apply_filters( 'wmhook_shortcode_' . 'posts' . '_single_output', '', $atts, $postOutput );
								$out .= '</div>';
							$out   .= '</article>';
						endwhile;

						$out .= '</div>';

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '</div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div>' ); //if description on the right - close posts container and its inner container and output content column ELSE just close posts container and its inner container
					} else {
					//if no description (no shortcode content)
						$out .= '</div>';
					}

					$out .= '</div>';

				}
				wp_reset_query();

				$out = apply_filters( 'wmhook_shortcode_' . 'posts' . '_output', $out, $atts );
				return $out;
			}
		} // /wm_shortcode_posts
		add_shortcode( 'posts', 'wm_shortcode_posts' );



		/*
		* [prices table="123" /]
		*
		* Price tables
		*
		* table = PRICE TABLE ID OR SLUG [required]
		*/
		if ( ! function_exists( 'wm_shortcode_prices' ) ) {
			function wm_shortcode_prices( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'table' => null
					), $atts, 'prices' )
					);

				if ( 'disable' === wm_option( 'general-role-prices' ) )
					return;

				if ( ! $table )
					return;

				$i            = 0;
				$out          = '';
				$columnsArray = array();
				$table        = ( is_numeric( $table ) ) ? ( absint( $table ) ) : ( sanitize_title( $table ) );
				$field        = ( is_numeric( $table ) ) ? ( 'id' ) : ( 'slug' );

				//get the table columns
				wp_reset_query();
				$price_table = new WP_Query( array(
					'post_type'      => 'wm_price',
					'posts_per_page' => 6,
					'tax_query'      => array( array(
							'taxonomy' => 'price-table',
							'field'    => $field,
							'terms'    => $table
						) ),
					'post__not_in'   => get_option( 'sticky_posts' )
					) );
				if ( $price_table->have_posts() && $table ) {
					$columnSize = $price_table->post_count;

					$out .= '<div id="price-table-' . $table . '" class="price-table">';

					while ( $price_table->have_posts() ) :

						$price_table->the_post();

						$i++;

						//$last = ( $columnSize === $i ) ? ( ' last' ) : ( '' );

						$colorBg = ( wm_meta_option( 'price-color' ) ) ? ( wm_meta_option( 'price-color', null, 'color' ) ) : ( null );
						$styles  = ( $colorBg ) ? ( ' style="background-color: ' . $colorBg . '"' ) : ( '' );
						$classBg = '';
						if ( $colorBg )
							$classBg = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_meta_option( 'price-color' ) ) ) ? ( ' light-icons' ) : ( ' dark-icons' );

						$outColumn = '<div class="price-column column no-margin col-1' . $columnSize . wm_meta_option( 'price-style' ) . '">';

							$outColumn .= '<div class="price-heading' . $classBg . '"' . $styles . '>';
								$outColumn .= '<h3>' . get_the_title() . '</h3>';
								$outColumn .= '<p class="cost">' . wm_meta_option( 'price-cost' ) . '</p>';
								$outColumn .= '<p class="note">' . wm_meta_option( 'price-note' ) . '</p>';
								$outColumn .= '<div class="price-button">';
									$outColumn .= ( wm_meta_option( 'price-btn-text' ) ) ? ( '<p class="wrap-button">[button url="' . esc_url( wm_meta_option( 'price-btn-url' ) ) . '" color="' . wm_meta_option( 'price-btn-color' ) . '" size="medium"]' . wm_meta_option( 'price-btn-text' ) . '[/button]</p>' ) : ( '' );
								$outColumn .= '</div>';
							$outColumn .= '</div>';

							$outColumn .= '<div class="price-spec">';
							$outColumn .= apply_filters( 'wm_default_content_filters', get_the_content() );
							$outColumn .= '</div>';

							$outColumn .= ( ' featured' === wm_meta_option( 'price-style' ) ) ? ( '<div class="bottom"' . $styles . '></div>' ) : ( '' );

						$outColumn .= '</div>';

						$colOrder = ( wm_meta_option( 'price-order' ) ) ? ( wm_meta_option( 'price-order' ) ) : ( -7 + $i );
						$columnsArray[$colOrder] = $outColumn;

					endwhile;

					ksort( $columnsArray );
					$out .= implode( "\r\n", $columnsArray );
					$out .= '</div>';

				}
				wp_reset_query();

				//output
				$out = apply_filters( 'wmhook_shortcode_' . 'prices' . '_output', $out, $atts );
				return do_shortcode( $out );
			}
		} // /wm_shortcode_prices
		add_shortcode( 'prices', 'wm_shortcode_prices' );



		/*
		* [projects align="" filter="" columns="5" count="10" category="" order="" pagination="" thumb="1"]content[/projects]
		*
		* Projects list
		*
		* align          = left/right/NONE
		* category       = PROJECTS CATEGORY ID OR SLUG
		* columns        = #/NONE (2 - 6)
		* count          = #/NONE
		* desc_size      = #/NONE
		* excerpt_length = #/NONE
		* filter         = BOOLEAN
		* order          = newest/oldest/name/random/NONE
		* pagination     = BOOLEAN
		* scroll         = BOOLEAN
		* thumb          = BOOLEAN
		*/
		if ( ! function_exists( 'wm_shortcode_projects' ) ) {
			function wm_shortcode_projects( $atts, $content = null, $shortcode ) {
				global $paged;

				extract( shortcode_atts( array(
					'align'          => 'left',
					'category'       => '',
					'columns'        => 4,
					'count'          => -1,
					'desc_size'      => 4,
					'excerpt_length' => 12,
					'filter'         => false,
					'order'          => 'new',
					'pagination'     => false,
					'scroll'         => false,
					'thumb'          => true,
					), $atts, $shortcode )
					);

				if ( 'disable' === wm_option( 'general-role-projects' ) )
					return;

				$out = $filterContent = '';

				$imgSize = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );

				//validation
				$align       = ( 'right' === $align ) ? ( $align ) : ( 'left' );
				$cols        = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
				$colsDesc    = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
				$count       = ( $count ) ? ( intval( $count ) ) : ( -1 );
				$orderMethod = array(
						'all'    => array( 'new', 'old', 'name', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'name'   => array( 'title', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$order       = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );
				$classScroll = ( $scroll ) ? ( ' scrollable' ) : ( '' );
				$thumb       = ( $thumb ) ? ( true ) : ( false );

				$excerptLength  = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 12 );
				$isotopeLayout  = 'fitRows';
				$filter         = ( $filter ) ? ( true ) : ( false );
				$filterable     = ( $filter ) ? ( ' filterable-content' ) : ( '' );
				$filterThis     = ( $filter ) ? ( ' filter-this' ) : ( '' );
				$iconColorClass = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-accent-color' ) ) ) ? ( ' light-icons' ) : ( ' dark-icons' );
				$iconColor      = ( ' light-icons' === $iconColorClass ) ? ( 'white' ) : ( 'black' );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'project-category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				$projectIcons = array(
						'static-project' => 'icon-picture',
						'flex-project'   => 'icon-play-circle',
						'video-project'  => 'icon-film',
						'audio-project'  => 'icon-music',
					);

				//get the projects
				wp_reset_query();

				$queryArgs = array(
						'paged'               => $paged,
						'post_type'           => 'wm_projects',
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'orderby'             => $order[0],
						'order'               => $order[1]
					);
				if ( $category )
					$queryArgs['tax_query'] = array( array(
						'taxonomy' => 'project-category',
						'field'    => 'id',
						'terms'    => $category
					) );

				$projects = new WP_Query( $queryArgs );

				$pagination      = ( $pagination ) ? ( wm_pagination( $projects, array( 'print' => false ) ) ) : ( '' );
				$paginationClass = ( $pagination ) ? ( ' paginated' ) : ( '' );

				if ( $projects->have_posts() ) {

					$i    = $row = 0;
					$out .= '<div class="wrap-projects-shortcode clearfix' . $filterable . $iconColorClass . $paginationClass . '">';

					//filter output code
					if ( $filter ) {
						$filterContent .= '<div class="wrap-filter"><ul>';

						if ( $category ) {
						//if parent category set - filter from child categories

							$parentCategory = get_term_by( 'id', $category, 'project-category' );
							$filterContent .= '<li><a href="#" data-filter="*" class="active">' . apply_filters( 'wmhook_filter_text_all_category', sprintf( __( 'All <span>%s</span>', 'clifden_domain' ), $parentCategory->name ) ) . '</a></li>';

							$terms  = get_term_children( $category, 'project-category' );
							$count  = count( $terms );
							if ( ! is_wp_error( $terms ) && $count > 0 ) {
								$outFilter = array();
								foreach ( $terms as $child ) {
									$term = get_term_by( 'id', $child, 'project-category' );

									$outArray['<li><a href="#" data-filter=".project-category-' . $term->slug . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>'] = $term->name;
								}
								asort( $outArray );
								$outArray = array_flip( $outArray );
								$filterContent .= implode( '', $outArray );
							}

						} else {
						//no parent category - filter from all categories

							$filterContent .= '<li><a href="#" data-filter="*" class="active">' . apply_filters( 'wmhook_filter_text_all', __( 'All', 'clifden_domain' ) ) . '</a></li>';

							$terms = get_terms( 'project-category' );
							$count = count( $terms );
							if ( ! is_wp_error( $terms ) && $count > 0 ) {
								foreach ( $terms as $term ) {
									$filterContent .= '<li><a href="#" data-filter=".project-category-' . $term->slug . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>';
								}
							}

						}

						$filterContent .= '</ul></div>';
					} // if filter

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '">' . $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll . '" data-layout-mode="' . $isotopeLayout . '">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last">' . $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll . '" data-layout-mode="' . $isotopeLayout . '">' ); //if description on the right - open projects container and inner container only ELSE output content column and open projects container
					} else {
					//if no description (no shortcode content)
						$out .= $filterContent . '<div class="wrap-projects' . $filterThis . $classScroll . '" data-layout-mode="' . $isotopeLayout . '">';
					}

						$out .= ( ! $filter ) ? ( '<div class="row">' ) : ( '' );

						while ( $projects->have_posts() ) : //output post content
							$projects->the_post();

							$terms         = get_the_terms( get_the_ID() , 'project-category' );
							$termsClass    = '';
							$termsOutArray = array();
							if ( ! is_wp_error( $terms ) && $terms ) {
								foreach( $terms as $term ) {
									//$termsOutArray[] = '<a href="' . get_term_link( $term->slug, 'project-category' ) . '" class="item">' . $term->name . '</a>';
									$termsOutArray[] = '<span class="item">' . $term->name . '</span>';
									$termsClass .= ' project-category-' . $term->slug;
								}
							}

							$link        = ( wm_meta_option( 'project-link-list' ) ) ? ( esc_url( wm_meta_option( 'project-link' ) ) ) : ( get_permalink() );
							$anchorClass = wm_meta_option( 'project-link-list' );
							if ( 'true' === $anchorClass || '1' === $anchorClass )
								$anchorClass = 'modal'; //pre-2.0 compatibility
							$linkAtts    = ( 'target-blank' == $anchorClass ) ? ( ' target="_blank"' ) : ( '' );
							$linkAtts   .= ( trim( wm_meta_option( 'project-rel-text' ) ) ) ? ( ' rel="' . trim( wm_meta_option( 'project-rel-text' ) ) . '" data-rel="' . trim( wm_meta_option( 'project-rel-text' ) ) . '"' ) : ( ' data-rel=""' );

							if ( 0 < $excerptLength && has_excerpt() ) {
								$excerptText = get_the_excerpt();
							} else {
								$excerptText = '';
							}
							$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', $excerptText, $excerptLength );
							$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerptText, get_the_id(), $atts );

							$icon = ( ! wm_meta_option( 'project-type' ) ) ? ( 'icon-picture' ) : ( $projectIcons[wm_meta_option( 'project-type' )] );

							$projectOutput = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
									'category' => '<div class="project-category text-element">' . implode( ', ', $termsOutArray ) . '</div>',
									'thumb'    => wm_thumb( array(
											'class'        => 'post-thumb',
											'size'         => $imgSize,
											'list'         => true,
											'link'         => array( $link, $anchorClass ),
											'placeholder'  => true,
											'a-attributes' => $linkAtts,
										) ),
									'title'    => '<h3 class="project-title text-element"><a href="' . $link . '" class="' . $anchorClass . '"' . $linkAtts . '>' . get_the_title() . '</a></h3>',
									'type'     => '<a class="project-icon ' . $anchorClass . '" href="' . $link . '"' . $linkAtts . '><i class="' . $icon . '" title="' . get_the_title() . '"></i></a>',
									'excerpt'  => ( $excerptText ) ? ( '<div class="project-excerpt text-element">' . $excerptText . '</div>' ) : ( '' ),
								), get_the_id(), $atts );

							if ( ! $filter ) {
								$row  = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
								$out .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
							}

							$out   .= '<article class="column col-1' . $cols . ' no-margin item item-' . get_the_ID() . $termsClass . '">';
								$out .= ( $thumb ) ? ( $projectOutput['thumb'] ) : ( '' );
								$out .= '<div class="text">';
									$out .= $projectOutput['type'];
									$out .= $projectOutput['title'];
									$out .= $projectOutput['category'];
									$out .= $projectOutput['excerpt'];
									$out .= apply_filters( 'wmhook_shortcode_' . 'projects' . '_single_output', '', $atts, $projectOutput );
								$out .= '</div>';
							$out   .= '</article>';
						endwhile;

						$out .= ( ! $filter ) ? ( '</div>' ) : ( '' );

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '</div>' . $pagination . '</div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' . $pagination . '</div>' ); //if description on the right - close projects container and its inner container and output content column ELSE just close projects container and its inner container
					} else {
					//if no description (no shortcode content)
						$out .= '</div>' . $pagination;
					}

					$out .= '</div>';

				}
				wp_reset_query();

				if ( $filter )
					wp_enqueue_script( 'isotope' );

				$out = apply_filters( 'wmhook_shortcode_' . 'projects' . '_output', $out, $atts );
				return $out;
			}
		} // /wm_shortcode_projects
		add_shortcode( 'projects', 'wm_shortcode_projects' );



		/*
		* [project_attributes title="" /]
		*
		* Project attributes
		*
		* title = text/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_project_attributes' ) ) {
			function wm_shortcode_project_attributes( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'title' => ''
					), $atts, 'project_attributes' )
					);

				if ( 'disable' === wm_option( 'general-role-projects' ) )
					return;

				$out   = '';
				$title = ( $title ) ? ( '<h3>' . $title . '</h3>' . "\r\n" ) : ( '' );

				if ( wm_meta_option( 'project-link' ) ) {
					$link = wm_meta_option( 'project-link' );
					$out .= apply_filters( 'wmhook_project_attributes_link_html', '<li class="attribute-link"><strong class="attribute-heading">' . __( 'Project URL', 'clifden_domain' ) . ':</strong> <a href="' . esc_url( $link ) . '">' . $link . '</a></li>', $link );
				}

				if ( wm_meta_option( 'project-attributes' ) ) {
					foreach ( wm_meta_option( 'project-attributes' ) as $item ) {
						if ( $item['attr'] && $item['val'] ) {
							$out .= '<li><strong class="attribute-heading">' . $item['attr'] . ':</strong> ';
							$out .= $item['val'] . '</li>';
						}
					}
				}

				$out = ( $out ) ? ( do_shortcode( '<div class="attributes">' . $title . '<ul class="no-bullets">' . $out . '</ul></div>' ) ) : ( null );

				//output
				return $out;
			}
		} // /wm_shortcode_project_attributes
		add_shortcode( 'project_attributes', 'wm_shortcode_project_attributes' );



		/*
		* [staff columns="5" count="10" department="5" order="new" align="left" thumb="1"]content[/staff]
		*
		* Staff list
		*
		* align      = left/right/NONE
		* columns    = #/NONE (2 - 6)
		* count      = #/NONE
		* department = STAFF DEPARTMENT ID OR SLUG
		* desc_size  = #/NONE
		* order      = new/old/name/random/NONE
		* thumb      = BOOLEAN
		*/
		if ( ! function_exists( 'wm_shortcode_staff' ) ) {
			function wm_shortcode_staff( $atts, $content = null, $shortcode ) {
				extract( shortcode_atts( array(
					'align'      => 'left',
					'columns'    => 4,
					'count'      => 4,
					'department' => null,
					'desc_size'  => 4,
					'order'      => 'new',
					'thumb'      => true,
					), $atts, $shortcode )
					);

				if ( 'disable' === wm_option( 'general-role-staff' ) )
					return;

				$out = '';

				$imgSize = ( wm_option( 'general-staff-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-staff-image-ratio' ) ) : ( 'mobile-ratio-169' );

				//validation
				$align         = ( 'right' === $align ) ? ( $align ) : ( 'left' );
				$cols          = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
				$colsDesc      = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
				$count         = ( $count ) ? ( absint( $count ) ) : ( 4 );
				$orderMethod   = array(
						'all'    => array( 'new', 'old', 'name', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'name'   => array( 'title', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$order         = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );
				$thumb         = ( $thumb ) ? ( true ) : ( false );

				if ( $department )
					if ( is_numeric( $department ) ) {
						$department = absint( $department );
					} else {
						$department = get_term_by( 'slug', sanitize_title( $department ), 'department' );
						$department = ( $department && isset( $department->term_id ) ) ? ( $department->term_id ) : ( null );
					}
				else
					$department = null;

				//get the staff
				wp_reset_query();

				$queryArgs = array(
						'post_type'           => 'wm_staff',
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'orderby'             => $order[0],
						'order'               => $order[1]
					);
				if ( 0 < $department )
					$queryArgs['tax_query'] = array( array(
						'taxonomy' => 'department',
						'field'    => 'id',
						'terms'    => explode( ',', $department )
					) );

				$staff = new WP_Query( $queryArgs );
				if ( $staff->have_posts() ) {

					$i    = $row = 0;
					$out .= '<div class="wrap-staff-shortcode clearfix">';

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '<div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . '"><div class="wrap-staff"><div class="row">' ) : ( '<div class="column col-1' . $colsDesc . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . ( $colsDesc - 1 ) . $colsDesc . ' last"><div class="wrap-staff"><div class="row">' ); //if description on the right - open staff container and inner container only ELSE output content column and open staff container
					} else {
					//if no description (no shortcode content)
						$out .= '<div class="wrap-staff"><div class="row">';
					}

						while ( $staff->have_posts() ) : //output post content
							$staff->the_post();

							if ( wm_option( 'general-staff-rich' ) ) {
								$excerptText  = ( has_excerpt() ) ? ( get_the_excerpt() ) : ( '' );
							} else {
								$excerptText = get_the_content();
							}
							$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', $excerptText, 999 );
							$excerptText = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerptText, get_the_id(), $atts );

							$contacts = '';
							if ( wm_meta_option( 'staff-phone' ) )
								$contacts .= '<li class="icon-phone">' . wm_meta_option( 'staff-phone' ) . '</li>';
							if ( wm_meta_option( 'staff-email' ) )
								$contacts .= '<li class="icon-envelope"><a href="#" data-address="' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
							if ( wm_meta_option( 'staff-linkedin' ) )
								$contacts .= '<li class="icon-linkedin"><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
							if ( wm_meta_option( 'staff-skype' ) )
								$contacts .= '<li class="icon-headphones"><a href="skype:' . sanitize_title( wm_meta_option( 'staff-skype' ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';
							if ( is_array( wm_meta_option( 'staff-custom-contacts' ) ) ) {
								foreach ( wm_meta_option( 'staff-custom-contacts' ) as $contact ) {
									$contacts .= '<li class="' . $contact['attr'] . '">' . strip_tags( trim( $contact['val'] ), '<a><img><strong><span><small><em><b><i>' ) . '</li>';
								}
							}
							$excerptText .= ( $contacts ) ? ( '<ul>' . $contacts . '</ul>' ) : ( '' );

							$staffOutput = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
									'thumb'      => wm_thumb( array(
											'class'        => 'staff-thumb',
											'size'         => $imgSize,
											'list'         => true,
											'link'         => 'modal',
											'placeholder'  => true,
										) ),
									'thumb-link' => wm_thumb( array(
											'class'        => 'staff-thumb',
											'size'         => $imgSize,
											'list'         => true,
											'link'         => true,
											'placeholder'  => true,
										) ),
									'title'      => '<h3 class="staff-title text-element"><strong>' . get_the_title() . '</strong></h3>',
									'title-link' => '<h3 class="staff-title text-element"><a href="' . get_permalink() . '"><strong>' . get_the_title() . '</strong></a></h3>',
									'position'   => '<p class="staff-position text-element">' . wm_meta_option( 'staff-position' ) . '</p>',
									'excerpt'    => $excerptText
								), get_the_id(), $atts );

							$row    = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
							$out   .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
							$out   .= '<article class="column col-1' . $cols . ' no-margin">';
								if ( $thumb )
									$out .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $staffOutput['thumb-link'] ) : ( $staffOutput['thumb'] );
								$out .= '<div class="text">';
									$out .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $staffOutput['title-link'] ) : ( $staffOutput['title'] );
									$out .= $staffOutput['position'];
									$out .= '<div class="staff-excerpt text-element">' . $staffOutput['excerpt'] . '</div>';
									$out .= apply_filters( 'wmhook_shortcode_' . 'staff' . '_single_output', '', $atts, $staffOutput );
								$out .= '</div>';
							$out   .= '</article>';
						endwhile;

					if ( $content ) {
					//if description (shortcode content)
						$out .= ( 'right' === $align ) ? ( '</div></div></div><div class="column col-1' . $colsDesc . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div></div>' ); //if description on the right - close staff container and its inner container and output content column ELSE just close staff container and its inner container
					} else {
					//if no description (no shortcode content)
						$out .= '</div></div>';
					}

					$out .= '</div>';

				}
				wp_reset_query();

				$out = apply_filters( 'wmhook_shortcode_' . 'staff' . '_output', $out, $atts );
				return $out;
			}
		} // /wm_shortcode_staff
		add_shortcode( 'staff', 'wm_shortcode_staff' );



		/*
		* [status count="5" speed="3" layout="large" date="1" /]
		*
		* Status posts
		*
		* count  = # [number of statuses to display]
		* date   = BOOLEAN [whether to display post date]
		* layout = normal/large/NONE
		* speed  = # [time to display one status in seconds]
		*/
		if ( ! function_exists( 'wm_shortcode_status' ) ) {
			function wm_shortcode_status( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'count'  => 1,
					'date'   => false,
					'layout' => 'normal',
					'speed'  => null,
					), $atts, 'status' )
					);

				if ( wm_option( 'blog-no-format-status' ) )
					return;

				$out    = '';
				$count  = absint( $count );
				$speed  = ( 1 < absint( $speed ) ) ? ( absint( $speed ) * 1000 ) : ( '' );
				$date   = ( $date ) ? ( true ) : ( false );
				$layout = ( 'large' == $layout ) ? ( ' large' ) : ( ' normal' );

				//get the status posts
				wp_reset_query();

				$queryArgs = array(
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'tax_query'           => array( array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => 'post-format-status',
							) )
					);

				$statuses = new WP_Query( $queryArgs );
				if ( $statuses->have_posts() ) {

					$i    = 0;
					if ( $speed )
						$out .= '<div class="wrap-status-shortcode' . $layout . '" data-time="' . $speed . '">';
					else
						$out .= '<div class="wrap-status-shortcode' . $layout . '">';

					while ( $statuses->have_posts() ) :

						$statuses->the_post();

						$out .= '<div class="status-post status-post-' . get_the_ID() . ' item-' . $i++ . '">';
							$out .= '<div class="status">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
							$out .= ( $date ) ? ( '<time class="date">' . esc_html( get_the_date() ) . ', ' . esc_html( get_the_time() ) . '</time>' ) : ( '' );
						$out .= '</div>';

					endwhile;

					$out .= '</div>';

				}
				wp_reset_query();

				if ( $speed )
					wp_enqueue_script( 'quovolver' );

				//output
				return do_shortcode( $out );
			}
		} // /wm_shortcode_status
		add_shortcode( 'status', 'wm_shortcode_status' );



		/*
		* [subpages depth="1" order="menu" parents="0" /]
		*
		* Subpages list
		*
		* depth   = # [0 = all levels, 1 = top level, 2+ = level depth]
		* order   = # [ordering]
		* parents = BOOLEAN [whether to display parent pages]
		*/
		if ( ! function_exists( 'wm_shortcode_subpages' ) ) {
			function wm_shortcode_subpages( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'depth'   => 0,
					'order'   => 'menu',
					'parents' => false,
					), $atts, 'subpages' )
					);

				global $post, $page_exclusions;

				$sortColumns = array(
					'title' => 'post_title',
					'menu'  => 'menu_order',
					);

				$post        = ( is_home() ) ? ( get_post( get_option( 'page_for_posts' ) ) ) : ( $post );
				$parents     = ( $parents ) ? ( true ) : ( false );
				$parentPages = ( isset( $post->ancestors ) && $parents ) ? ( $post->ancestors ) : ( null ); //get all parent pages in array
				$grandparent = ( ! empty( $parentPages ) ) ? ( end( $parentPages ) ) : ( '' ); //get the first parent page (at the end of the array)
				$order       = ( in_array( $order, array_flip( $sortColumns ) ) ) ? ( $sortColumns[$order] ) : ( 'menu_order' );
				$depth       = absint( $depth );

				$pageIDs = get_all_page_ids();

				foreach ( $pageIDs as $pageID ) {
					if ( ! wm_restriction_page( $pageID ) ) {
						$page_exclusions .= ( $page_exclusions ) ? ( ',' . $pageID ) : ( $pageID );
					}
				}

				//subpages or siblings
				if ( $grandparent )
					$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $grandparent . '&echo=0&depth=' . $depth );
				else
					$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $post->ID . '&echo=0&depth=' . $depth );

				$out = ( $children ) ? ( '<ul class="sub-pages">' . str_replace( 'page_item', 'page_item icon-file', $children ) . '</ul>' ) : ( '' );

				//output
				return do_shortcode( $out );
			}
		} // /wm_shortcode_subpages
		add_shortcode( 'subpages', 'wm_shortcode_subpages' );



		/*
		* [testimonials category="123" count="5" speed="3" layout="large" order="random" private="1" /]
		*
		* Testimonials
		*
		* category = TESTIMONIALS CATEGORY ID OR SLUG [optional]
		* count    = # [number of testimonials to display]
		* layout   = normal/large/NONE
		* order    = new/old/random/NONE
		* private  = BOOLEAN [whether to display also private status posts]
		* speed    = # [time to display one testimonial in seconds]
		*/
		if ( ! function_exists( 'wm_shortcode_testimonials' ) ) {
			function wm_shortcode_testimonials( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'category' => null,
					'count'    => 5,
					'layout'   => 'normal',
					'order'    => 'new',
					'private'  => false,
					'speed'    => 0,
					), $atts, 'testimonials' )
					);

				if ( wm_option( 'blog-no-format-quote' ) || ! $category )
					return;

				$out      = '';
				$count    = absint( $count );
				$speed    = ( 1 < absint( $speed ) ) ? ( ' data-time="' . absint( $speed ) * 1000 . '"' ) : ( false );
				$layout   = ( 'large' == $layout ) ? ( ' large' ) : ( ' normal' );
				$orderMethod = array(
						'all'    => array( 'new', 'old', 'random' ),
						'new'    => array( 'date', 'DESC' ),
						'old'    => array( 'date', 'ASC' ),
						'random' => array( 'rand', '' )
					);
				$order    = ( in_array( $order, $orderMethod['all'] ) ) ? ( $orderMethod[$order] ) : ( $orderMethod['new'] );
				$private  = ( ! $private ) ? ( 'publish' ) : ( array( 'publish', 'private' ) );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				//get the testimonials
				wp_reset_query();

				$queryArgs = array(
						'post_status'         => $private,
						'posts_per_page'      => $count,
						'ignore_sticky_posts' => 1,
						'cat'                 => $category,
						'orderby'             => $order[0],
						'order'               => $order[1],
						'tax_query'           => array( array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => 'post-format-quote',
							) )
					);

				$testimonials = new WP_Query( $queryArgs );
				if ( $testimonials->have_posts() ) {

					$i    = 0;
					$out .= '<div class="wrap-testimonials-shortcode' . $layout . '"' . $speed . '>';

					while ( $testimonials->have_posts() ) :

						$testimonials->the_post();

						$out .= '<blockquote class="testimonial testimonial-' . get_the_ID() . ' item-' . ++$i . '">';

							if ( has_post_thumbnail() ) {
								$imgUrl   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget' );
								$imgAlign = ( ' large' === $layout ) ? ( 'aligncenter' ) : ( 'alignleft' );
								$escImgAlt = esc_attr( strip_tags( strip_shortcodes( wm_meta_option( 'quoted-author' ) ) ) );
								$out     .= '<img src="' . $imgUrl[0] . '" alt="' . $escImgAlt . '" title="' . $escImgAlt . '" class="' . $imgAlign . ' frame" />';
							}

							$quote = get_the_content();
							$quote = preg_replace( '/<blockquote(.*?)>/i', '', $quote ); //removes all <blockquote anyparameter>
							$quote = preg_replace( '/<\/blockquote>/i', '', $quote ); //removes all </blockquote>

							$out .= apply_filters( 'wm_default_content_filters', $quote );
							$out .= '<p class="mt0"><cite class="quote-source">&mdash; ' . wm_meta_option( 'quoted-author' ) . '</cite></p>';

						$out .= '</blockquote>';

					endwhile;

					$out .= '</div>';

				}
				wp_reset_query();

				if ( $speed )
					wp_enqueue_script( 'quovolver' );

				//output
				$out = apply_filters( 'wmhook_shortcode_' . 'testimonials' . '_output', $out, $atts );
				return do_shortcode( $out );
			}
		} // /wm_shortcode_testimonials
		add_shortcode( 'testimonials', 'wm_shortcode_testimonials' );





	/*
	*****************************************************
	*      PULLQUOTES
	*****************************************************
	*/
		/*
		* [pullquote align="left"]content[/pullquote]
		*
		* align = left/right/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_pullquote' ) ) {
			function wm_shortcode_pullquote( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'align' => 'left'
					), $atts, 'pullquote' )
					);

				$pullquoteAlign = array( 'left', 'right' );;

				//validation
				$align = ( in_array( $align, $pullquoteAlign ) ) ? ( ' align' . $align ) : ( ' alignleft' );

				//output
				$out = '<blockquote class="pullquote ' . $align . '">' . do_shortcode( $content ) . '</blockquote>';
				return $out;
			}
		} // /wm_shortcode_pullquote
		add_shortcode( 'pullquote', 'wm_shortcode_pullquote' );





	/*
	*****************************************************
	*      RAW CODE (PRE HTML TAG)
	*****************************************************
	*/
		/*
		* [raw]content[/raw]
		* [pre]content[/pre]
		*/
		if ( ! function_exists( 'wm_shortcode_raw' ) ) {
			function wm_shortcode_raw( $atts, $content = null ) {
				$content = str_replace( '[', '&#91;', $content );
				$content = str_replace( array( '<p>', '</p>', '<br />', '<span class="br"></span>' ), '', $content );
				return '<pre>' . esc_html( shortcode_unautop( $content ) ) . '</pre>';
			}
		} // /wm_shortcode_raw





	/*
	*****************************************************
	*      SLIDESHOW
	*****************************************************
	*/
		/*
		* [slideshow group="123" images="imageUrl1, imageUrl2, imageUrl3" time="5"]
		*
		* Slideshow (slider)
		*
		* group  = SLIDES CATEGORY ID [required]
		* images = URL TEXT [image URLs separated with commas]
		* links  = URL TEXT [image links separated with commas]
		* time   = # (duration of slide display in seconds)
		*/
		if ( ! function_exists( 'wm_shortcode_slideshow' ) ) {
			function wm_shortcode_slideshow( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'category' => null,
					'group'    => null, //this is just synonym for "category"
					'images'   => '',
					'links'    => '',
					'time'     => 5,
					), $atts, 'slideshow' )
					);

				$out      = '';
				$category = ( $category ) ? ( $category ) : ( $group ); //if "group" set, make it category
				$images   = preg_replace( '/\s+/', '', $images );
				$images   = explode( ',', $images );
				$links    = preg_replace( '/\s+/', '', $links );
				$links    = explode( ',', $links );
				$time     = ( $time ) ? ( absint( $time ) * 1000 ) : ( 5000 );

				if ( $category )
					if ( is_numeric( $category ) ) {
						$category = absint( $category );
					} else {
						$category = get_term_by( 'slug', sanitize_title( $category ), 'slide-category' );
						$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
					}
				else
					$category = null;

				if ( ! $category && empty( $images ) )
					return;

				$imageSize = 'content-width';

				$out .= '<div class="slideshow flexslider slideshow-category-' . $category . '" data-time="' . $time . '"><ul class="slides">';

				if ( $category ) {

					//get the slideshow images
					wp_reset_query();

					$slideshow = new WP_Query( array(
						'post_type'           => 'wm_slides',
						'ignore_sticky_posts' => 1,
						'posts_per_page'      => -1,
						'tax_query'           => array( array(
								'taxonomy' => 'slide-category',
								'field'    => 'id',
								'terms'    => $category
							) )
						) );

					if ( $slideshow->have_posts() ) {
						while ( $slideshow->have_posts() ) :

							$slideshow->the_post();

							$style = ( wm_css_background_meta( 'slide-' ) ) ? ( ' style="' . wm_css_background_meta( 'slide-' ) . '"' ) : ( '' );

							$out .= '<li' . $style . '>';

							//Image
							$link = ( wm_meta_option( 'slide-link' ) ) ? ( esc_url( wm_meta_option( 'slide-link' ) ) ) : ( null );

							$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '">' ) : ( '' );
							if ( has_post_thumbnail() ) {
								$imageId = get_post_thumbnail_id();
								$imgUrl  = wp_get_attachment_image_src( $imageId, $imageSize );
								$out    .= '<img src="' . $imgUrl[0] . '" alt="" />';
							}
							$out .= ( $link ) ? ( '</a>' ) : ( '' );

							$out .= '</li>';

						endwhile;
					}
					wp_reset_query();

				} elseif ( ! empty ( $images ) ) {

					if ( 'gallery' === $images[0] ) {
						$postID = ( isset( $images[1] ) ) ? ( absint( $images[1] ) ) : ( get_the_ID() );
						$images = $links = array();
						$imagesArray = wm_get_post_images( $postID );
						$imageSize   = ( wm_option( 'general-gallery-image-ratio' ) ) ? ( wm_option( 'general-gallery-image-ratio' ) ) : ( 'mobile-ratio-169' );
						$fullImgSize = ( wm_option( 'general-lightbox-img' ) ) ? ( wm_option( 'general-lightbox-img' ) ) : ( 'full' );
						foreach ( $imagesArray as $image ) {
							$imageUrl  = wp_get_attachment_image_src( $image['id'], $imageSize );
							$imageFull = wp_get_attachment_image_src( $image['id'], $fullImgSize );
							$images[]  = $imageUrl[0];
							$links[]   = $imageFull[0];
						}
					}

					$i = 0;
					foreach ( $images as $image ) {
						$out .= '<li>';
						$out .= ( isset( $links[$i] ) && $links[$i] ) ? ( '<a href="' . esc_url( $links[$i] ) . '">' ) : ( '' );
						$out .= '<img src="' . esc_url( $image ) . '" alt="" />';
						$out .= ( isset( $links[$i] ) && $links[$i] ) ? ( '</a>' ) : ( '' );
						$out .= '</li>';
						$i++;
					}

				}

				$out .= '</ul></div>';

				wp_enqueue_script( 'flex' );

				//output
				return $out;
			}
		} // /wm_shortcode_slideshow
		add_shortcode( 'slideshow', 'wm_shortcode_slideshow' );





	/*
	*****************************************************
	*      SOCIAL ICONS
	*****************************************************
	*/
		/*
		* [social url="#" icon="" title="" size="" /]
		*
		* Social icons
		*
		* icon  = TEXT (has to match predefined value)
		* rel   = TEXT
		* size  = s/m/l/xl/NONE
		* title = TEXT
		* url   = URL
		*/
		if ( ! function_exists( 'wm_shortcode_social' ) ) {
			function wm_shortcode_social( $atts, $content = null ) {
				global $socialIconsArray;

				extract( shortcode_atts( array(
					'icon'  => '',
					'rel'   => '',
					'size'  => 'l',
					'title' => '',
					'url'   => '#',
					), $atts, 'social' )
					);

				//validation
				$iconType = '';
				$sizes = array(
						's'  => '16x16/',
						'm'  => '24x24/',
						'l'  => '32x32/',
						'xl' => '48x48/'
					);
				$size = ( $size && in_array( $size, array_flip( $sizes ) ) ) ? ( $sizes[$size] ) : ( '32x32/' );
				if ( $icon && in_array( $icon, $socialIconsArray ) ) {
					$iconType = $icon;
					$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . $icon . '.png';
				} else {
					foreach ( $socialIconsArray as $inUrl => $type ) {
						$iconType = $type;
						if ( false !== stripos( $url, $inUrl ) ) {
							$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . $type . '.png';
							break;
						} else {
							$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . 'Facebook.png';
						}
					}
				}

				$url = ( 'Skype' != $iconType ) ? ( esc_url( $url ) ) : ( $url );
				$rel = ( $rel ) ? ( ' rel="' . $rel . '"' ) : ( '' );

				//output
				$out = '<a href="' . $url . '" title="' . esc_attr( $title ) . '"' . $rel . ' class="icon-social" target="_blank"><img src="' . esc_url( $icon ) . '" alt="' . esc_attr( $title ) . '" /></a>';
				return $out;
			}
		} // /wm_shortcode_social
		add_shortcode( 'social', 'wm_shortcode_social' );





	/*
	*****************************************************
	*      SPLIT
	*****************************************************
	*/
		/**
		* [section class="" style=""][/section]
		*
		* Sections page template split
		*
		* @param class [PREDEFINED TEXT]
		* @param style [TEXT]
		*/
		if ( ! function_exists( 'wm_shortcode_section' ) ) {
			function wm_shortcode_section( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'class' => '',
					'style' => '',
					), $atts, 'section' )
					);

				$firstClass = ( trim( $class ) ) ? ( explode( ' ', trim( $class ) ) ) : ( '' );
				$id         = ( isset( $firstClass[0] ) && $firstClass[0] && 'alt' != $firstClass[0] ) ? ( ' id="section-' . esc_attr( sanitize_title( $firstClass[0] ) ) . '"' ) : ( '' );
				$style      = ( trim( $style ) ) ? ( ' style="' . trim( $style ) . '"' ) : ( '' );

				//output
				return "\r\n" . '<section class="wrap-section ' . esc_attr( trim( $class ) ) . '"' . $id . $style . '><div class="wrap-inner"><div class="twelve pane">' . do_shortcode( $content ) . '</div></div></section>' . "\r\n";
			}
		} // /wm_shortcode_section
		add_shortcode( 'section', 'wm_shortcode_section' );





	/*
	*****************************************************
	*      TABLE
	*****************************************************
	*/
		/*
		* [table class="css-class" cols="" data="" separator="" heading_col=""]content[/table]
		*
		* Table
		*
		* class       = TEXT
		* cols        = TEXT (heading cells separated by separator)
		* data        = TEXT (table cells separated by separator)
		* heading_col = # (styles the # cell in the row as heading)
		* separator   = TEXT (separator character)
		*/
		if ( ! function_exists( 'wm_shortcode_table' ) ) {
			function wm_shortcode_table( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'class'       => '',
					'cols'        => '',
					'data'        => '',
					'heading_col' => 0,
					'separator'   => ';',
					), $atts, 'table' )
					);

				$class = ( $class ) ? ( ' class="' . esc_attr( sanitize_title( $class ) ) . '"' ) : ( '' );

				//output
				if ( $cols && $data ) {

					$cols       = explode( $separator, $cols );
					$data       = explode( $separator, $data );
					$colsNumber = count( $cols );

					$heading_col = ( $heading_col ) ? ( absint( $heading_col ) ) : ( -1 );
					$heading_col = ( -1 < $heading_col && $colsNumber <= $heading_col ) ? ( 0 ) : ( $heading_col );

					$out  = '<table' . $class . '>';

					if ( ! empty( $cols ) ) {
						$outCol = '';
						$i      = 0;

						foreach ( $cols as $col ) {
							if ( $col )
								$outCol .= '<th class="table-column-' . ++$i . '">' . $col . '</th>';
						}

						$out .= ( $outCol ) ? ( '<thead><tr class="table-row-0">' . $outCol . '</tr></thead>' ) : ( '' );
					}

					if ( ! empty( $data ) ) {
						$out .= '<tbody>';

						$i = $j = 0;
						$class = ' alt';
						foreach ( $data as $cell ) {
							$i++;

							$cellNumber = $i % $colsNumber;

							if ( 1 === $i % $colsNumber ) {
								if ( ' alt' === $class )
									$class = '';
								else
									$class = ' alt';
								$out .= '<tr class="table-row-' . ++$j . $class . '">';
							}

							if ( 0 === $i % $colsNumber )
								$cellNumber = $colsNumber;

							if ( -1 < $heading_col && ( $heading_col === $i % $colsNumber ) )
								$out .= '<th class="table-column-' . $cellNumber . ' text-left">' . $cell . '</th>';
							else
								$out .= '<td class="table-column-' . $cellNumber . '">' . $cell . '</td>';

							if ( 0 === $i % $colsNumber )
								$out .= '</tr>';
						}

						$out .= '</tbody>';
					}

					$out .= '</table>';

				} else {

					$out = '<table' . $class . '>' . do_shortcode( $content ) . '</table>';

				}

				return $out;
			}
		} // /wm_shortcode_table
		add_shortcode( 'table', 'wm_shortcode_table' );



		/*
		* [trow]content[/trow]
		*
		* Table row
		*/
		if ( ! function_exists( 'wm_shortcode_table_row' ) ) {
			function wm_shortcode_table_row( $atts, $content = null ) {
				//output
				return '<tr>' . do_shortcode( $content ) . '</tr>';
			}
		} // /wm_shortcode_table_row
		add_shortcode( 'trow', 'wm_shortcode_table_row' );



		/*
		* [trow_alt]content[/trow_alt]
		*
		* Table row altered
		*/
		if ( ! function_exists( 'wm_shortcode_table_row_alt' ) ) {
			function wm_shortcode_table_row_alt( $atts, $content = null ) {
				//output
				return '<tr class="alt">' . do_shortcode( $content ) . '</tr>';
			}
		} // /wm_shortcode_table_row_alt
		add_shortcode( 'trow_alt', 'wm_shortcode_table_row_alt' );



		/*
		* [tcell]content[/tcell]
		*
		* Table cell
		*/
		if ( ! function_exists( 'wm_shortcode_table_cell' ) ) {
			function wm_shortcode_table_cell( $atts, $content = null ) {
				//output
				return '<td>' . do_shortcode( $content ) . '</td>';
			}
		} // /wm_shortcode_table_cell
		add_shortcode( 'tcell', 'wm_shortcode_table_cell' );



		/*
		* [tcell_heading]content[/tcell_heading]
		*
		* Table heading cell
		*/
		if ( ! function_exists( 'wm_shortcode_table_cell_heading' ) ) {
			function wm_shortcode_table_cell_heading( $atts, $content = null ) {
				//output
				return '<th>' . do_shortcode( $content ) . '</th>';
			}
		} // /wm_shortcode_table_cell_heading
		add_shortcode( 'tcell_heading', 'wm_shortcode_table_cell_heading' );





	/*
	*****************************************************
	*      TABS
	*****************************************************
	*/
		/*
		* [tabs type="fullwidth"]content[/tabs]
		*
		* Tabs wrapper
		*
		* type = vertical/fullwidth/vertical tour/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_tabs' ) ) {
			function wm_shortcode_tabs( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'type' => ''
					), $atts, 'tabs' )
					);
				$tabTypes = array( 'vertical', 'vertical tour', 'fullwidth' );

				$type = ( in_array( $type, $tabTypes ) ) ? ( ' ' . $type ) : ( ' normal' );

				//output
				$out = '<div class="tabs-wrapper' . $type . '"><ul>' . do_shortcode( $content ) . '</ul></div>';
				return $out;
			}
		} // /wm_shortcode_tabs
		add_shortcode( 'tabs', 'wm_shortcode_tabs' );



		/*
		* [tab title="Tab title"]content[/tab]
		*
		* Tab item/content
		*
		* title = TEXT, required
		*/
		if ( ! function_exists( 'wm_shortcode_tab' ) ) {
			function wm_shortcode_tab( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'title' => ''
					), $atts, 'tab' )
					);

				//validation
				if ( '' == $title )
					return;

				$title = strip_tags( $title, '<img><strong><span><small><em><b><i>' );

				//output
				$out = '<li><h3 class="tab-heading">' . $title . '</h3>' . do_shortcode( $content ) . '</li>';
				return $out;
			}
		} // /wm_shortcode_tab
		add_shortcode( 'tab', 'wm_shortcode_tab' );





	/*
	*****************************************************
	*      TEXT
	*****************************************************
	*/
		/*
		* [big_text]Text[/big_text]
		*
		* Big text
		*/
		if ( ! function_exists( 'wm_shortcode_big_text' ) ) {
			function wm_shortcode_big_text( $atts, $content = null ) {
				return do_shortcode( '<span class="size-big">' . $content . '</span>' );
			}
		} // /wm_shortcode_big_text
		add_shortcode( 'big_text', 'wm_shortcode_big_text' );



		/*
		* [huge_text]Text[/huge_text]
		*
		* Huge text
		*/
		if ( ! function_exists( 'wm_shortcode_huge_text' ) ) {
			function wm_shortcode_huge_text( $atts, $content = null ) {
				return do_shortcode( '<span class="size-huge">' . $content . '</span>' );
			}
		} // /wm_shortcode_huge_text
		add_shortcode( 'huge_text', 'wm_shortcode_huge_text' );



		/*
		* [small_text]Text[/small_text]
		*
		* Small text
		*/
		if ( ! function_exists( 'wm_shortcode_small_text' ) ) {
			function wm_shortcode_small_text( $atts, $content = null ) {
				return do_shortcode( '<small>' . $content . '</small>' );
			}
		} // /wm_shortcode_small_text
		add_shortcode( 'small_text', 'wm_shortcode_small_text' );



		/*
		* [uppercase]Text[/uppercase]
		*
		* Uppercase
		*/
		if ( ! function_exists( 'wm_shortcode_uppercase' ) ) {
			function wm_shortcode_uppercase( $atts, $content = null ) {
				return do_shortcode( '<span class="uppercase">' . $content . '</span>' );
			}
		} // /wm_shortcode_uppercase
		add_shortcode( 'uppercase', 'wm_shortcode_uppercase' );



		/*
		* [yes color="colored" /]
		*
		* Yes icon
		*
		* color = black/white/green/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_yes' ) ) {
			function wm_shortcode_yes( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'color' => ''
					), $atts, 'yes' )
					);

				$colorArray = array(
					'black'   => WM_ASSETS_THEME . 'img/icons/yes-no/yes-black.png',
					'colored' => WM_ASSETS_THEME . 'img/icons/yes-no/yes-colored.png',
					'white'   => WM_ASSETS_THEME . 'img/icons/yes-no/yes-white.png',
					);

				$icon = ( $color && in_array( $color, array_flip( $colorArray ) ) ) ? ( $colorArray[$color] ) : ( WM_ASSETS_THEME . 'img/icons/yes-no/yes-black.png' );

				return '<img src="' . esc_url( $icon ) . '" alt="" />';
			}
		} // /wm_shortcode_yes
		add_shortcode( 'yes', 'wm_shortcode_yes' );



		/*
		* [no color="colored" /]
		*
		* No icon
		*
		* color = black/white/red/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_no' ) ) {
			function wm_shortcode_no( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'color' => ''
					), $atts, 'no' )
					);

				$colorArray = array(
					'black'   => WM_ASSETS_THEME . 'img/icons/yes-no/no-black.png',
					'colored' => WM_ASSETS_THEME . 'img/icons/yes-no/no-colored.png',
					'white'   => WM_ASSETS_THEME . 'img/icons/yes-no/no-white.png',
					);

				$icon = ( $color && in_array( $color, array_flip( $colorArray ) ) ) ? ( $colorArray[$color] ) : ( WM_ASSETS_THEME . 'img/icons/yes-no/no-black.png' );

				return '<img src="' . esc_url( $icon ) . '" alt="" />';
			}
		} // /wm_shortcode_no
		add_shortcode( 'no', 'wm_shortcode_no' );





	/*
	*****************************************************
	*      TOGGLES
	*****************************************************
	*/
		/*
		* [toggle title="Toggle title" open="1"]content[/toggle]
		*
		* open  = BOOLEAN/NONE
		* title = TEXT, required
		*/
		if ( ! function_exists( 'wm_shortcode_toggle' ) ) {
			function wm_shortcode_toggle( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'open'  => false,
					'title' => '',
					), $atts, 'toggle' )
					);

				//validation
				if ( '' == $title )
					return;

				$title = strip_tags( $title, '<img><strong><span><small><em><b><i>' );
				$open  = ( $open ) ? ( ' active' ) : ( '' );

				//output
				$out = '<div class="toggle-wrapper' . $open . '"><h3 class="toggle-heading">' . $title . '</h3>' . wpautop( do_shortcode( $content ) ) . '</div>';
				return $out;
			}
		} // /wm_shortcode_toggle
		add_shortcode( 'toggle', 'wm_shortcode_toggle' );





	/*
	*****************************************************
	*      WIDGETS
	*****************************************************
	*/
		/*
		* [widgets area="default" style="" /]
		*
		* area  = widget area ID
		* style = vertical/horizontal/sidebar-left/sidebar-right/NONE
		*/
		if ( ! function_exists( 'wm_shortcode_widget_area' ) ) {
			function wm_shortcode_widget_area( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'area'  => '',
					'style' => 'horizontal',
					), $atts, 'widgets' )
					);

				$widgetAreas      = array_flip( wm_widget_areas() );
				$widgetAreaStyles = array(
					'horizontal'    => 'columns',
					'vertical'      => 'vertical',
					'sidebar-left'  => 'sidebar sidebar-left',
					'sidebar-right' => 'sidebar sidebar-right'
					);

				//validation
				$area            = ( in_array( $area, $widgetAreas ) && '' != $area ) ? ( $area ) : ( null );
				$class           = ( in_array( $style, array_flip( $widgetAreaStyles ) ) ) ? ( $widgetAreaStyles[$style] ) : ( 'columns' );
				$restrictedCount = ( 'horizontal' != $class ) ? ( null ) : ( 5 );

				//wm_sidebar($defaultSidebar, $class, $restrictCount, $print)
				if ( $area )
					return wm_sidebar( $area, $class, $restrictedCount, false );
			}
		} // /wm_shortcode_widget_area
		add_shortcode( 'widgets', 'wm_shortcode_widget_area' );

		
	/*
	*****************************************************
	*      MAP - Added by Tiria
	*****************************************************
	*/

		if ( ! function_exists( 'wm_shortcode_mgmap' ) ) {
			function wm_shortcode_mgmap( $atts, $content = null ) {
				extract( shortcode_atts( array(
					'height'  => '300px',
					'width' => '100%',
					'lat' => '0',
					'long' => '0',
					'invert' => 'false',
					'zoom' => '12',
					'style' => '',
					'info' => '',
					'marker' => 'false',
					'saturation' => '0',
					), $atts )
					);
				$width = (substr($width,-1,1)=='%' || substr($width,-2,2)=='px') ? $width : $width.'px';
				$height = (substr($height,-1,1)=='%' || substr($height,-2,2)=='px') ? $height : $height.'px';
				
				$out = '<div id="mgmap" class="map" style="height:' . $height . '; width:' . $width . ';"></div>';
				$out .= '<script>var mapName="' . __( 'Custom', 'clifden_domain' ) . '", mapStyle="' . $style . '", mapZoom=' . intval( 2 + $zoom ) . ', mapLat=' . $lat . ', mapLong=' . $long . ', mapMarker="' . $marker . '", mapInfo="' . str_replace( '"', '\"',$info) . '", mapCenter=0, mapInvert=' . $invert . ', mapSat=' . $saturation . ', themeImgs="' . WM_ASSETS_THEME . 'img/";</script>';
				wp_enqueue_script('gmap-infobox');
				wp_enqueue_script('mgmap');
				
				return $out;
			}
		} // /wm_shortcode_widget_area
		add_shortcode( 'mgmap', 'wm_shortcode_mgmap' );
?>