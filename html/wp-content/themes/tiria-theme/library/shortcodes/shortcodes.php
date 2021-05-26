<?php
/**
 * WEBMAN'S WORDPRESS THEME FRAMEWORK
 * Created by WebMan - www.webmandesign.eu
 *
 * Shortcodes registration
 *
 * @since    1.0
 * @version  3.0
 *
 * CONTENT:
 *
 * 1. Actions and filters
 * 2. Helpers
 * 3. Shortcodes
 *    3.01 Access and visibility shortcodes
 *    3.02 Accordion
 *    3.03 Audio and video
 *    3.04 Boxes
 *    3.05 Buttons
 *    3.06 Call to action
 *    3.07 Columns
 *    3.08 Countdown timer
 *    3.09 Divider
 *    3.10 Dropcaps
 *    3.11 Icon
 *    3.12 Lists
 *    3.13 Login form
 *    3.14 Markers
 *    3.15 Posts / pages / custom posts
 *    3.16 Pullquotes
 *    3.17 Raw code (pre HTML tag)
 *    3.18 Slideshow
 *    3.19 Social icons
 *    3.20 Split
 *    3.21 Table
 *    3.22 Tabs
 *    3.23 Text
 *    3.24 Toggles
 *    3.25 Widgets
 */




/**
 * 1. Actions and filters
 */

	/**
	 * Filters
	 */

		//Allows "[shortcode][/shortcode]" in RAW/PRE shortcode output
			add_filter( 'the_content', 'wm_preprocess_shortcode', 7 );
			add_filter( 'wm_default_content_filters', 'wm_preprocess_shortcode', 7 );
		//Shortcodes in text widget
			add_filter( 'widget_text', 'wm_preprocess_shortcode', 7 );
			add_filter( 'widget_text', 'do_shortcode' );
		//Fixes HTML issues created by wpautop
			add_filter( 'the_content', 'wm_shortcode_paragraph_insertion_fix' );





/**
 * 2. Helpers
 */

	/**
	 * Plugin Name: Shortcode Empty Paragraph Fix
	 * Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
	 * Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
	 * Author URI: http://www.johannheyne.de
	 * Version: 0.1
	 * Put this in /wp-content/plugins/ of your Wordpress installation
	 *
	 * Update: by WebMan - www.webmandesign.eu
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



	/**
	 * Preprocess certain shortcodes to prevent HTML errors
	 *
	 * @link http://betterwp.net/17-protect-shortcodes-from-wpautop-and-the-likes/
	 *
	 * @since    1.0
	 * @version  3.0
	 */
	if ( ! function_exists( 'wm_preprocess_shortcode' ) ) {
		function wm_preprocess_shortcode( $content ) {
			global $shortcode_tags;

			//Backup current registered shortcodes and clear them all out
			$orig_shortcode_tags = $shortcode_tags;
			remove_all_shortcodes();

			//To let [shortcode][/shortcode] in preformated text
			add_shortcode( 'raw', 'wm_shortcode_raw' );
			add_shortcode( 'pre', 'wm_shortcode_raw' );

			/*
			Preprocess shortcodes using inline HTML tags not to mess up with <p> tags openings and closings (or maybe all shortcodes? - some themes do that - but what for?).
			These shortcodes will be processed also normally (outside preprocessing) to retain compatibility with do_shortcode() (in sliders for example).
			Surely, if the shortcode was applied in preprocess, it shouldn't appear again in the content.
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

			//Do the shortcodes (only the above ones)
			$content = do_shortcode( $content );

			//Put the original shortcodes back
			$shortcode_tags = $orig_shortcode_tags;

			return $content;
		}
	} // /wm_preprocess_shortcode





/**
 * 3. Shortcodes
 */

	/**
	 * 3.01 Access and visibility shortcodes
	 */

		/**
		 * [administrator]content[/administrator]
		 *
		 * Displays content only for Administrators
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_administrator' ) ) {
			function wm_shortcode_administrator( $atts, $content = null, $shortcode ) {
				if ( current_user_can( 'edit_dashboard' ) ) {
					return do_shortcode( $content );
				}
			}
		} // /wm_shortcode_administrator

		add_shortcode( 'administrator', 'wm_shortcode_administrator' );



		/**
		 * [author]content[/author]
		 *
		 * Displays content only for Authors
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_author' ) ) {
			function wm_shortcode_author( $atts, $content = null, $shortcode ) {
				if ( current_user_can( 'edit_published_posts' ) && ! current_user_can( 'read_private_pages' ) ) {
					return do_shortcode( $content );
				}
			}
		} // /wm_shortcode_author

		add_shortcode( 'author', 'wm_shortcode_author' );



		/**
		 * [contributor]content[/contributor]
		 *
		 * Displays content only for Contributors
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_contributor' ) ) {
			function wm_shortcode_contributor( $atts, $content = null, $shortcode ) {
				if ( current_user_can( 'edit_posts' ) && ! current_user_can( 'delete_published_posts' ) ) {
					return do_shortcode( $content );
				}
			}
		} // /wm_shortcode_contributor

		add_shortcode( 'contributor', 'wm_shortcode_contributor' );



		/**
		 * [editor]content[/editor]
		 *
		 * Displays content only for Editors
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_editor' ) ) {
			function wm_shortcode_editor( $atts, $content = null, $shortcode ) {
				if ( current_user_can( 'moderate_comments' ) && ! current_user_can( 'edit_dashboard' ) ) {
					return do_shortcode( $content );
				}
			}
		} // /wm_shortcode_editor

		add_shortcode( 'editor', 'wm_shortcode_editor' );



		/**
		 * [subscriber]content[/subscriber]
		 *
		 * Displays content only for Subscribers
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_subscriber' ) ) {
			function wm_shortcode_subscriber( $atts, $content = null, $shortcode ) {
				if ( current_user_can('moderate_comments') && ! current_user_can( 'delete_posts' ) ) {
					return do_shortcode( $content );
				}
			}
		} // /wm_shortcode_subscriber

		add_shortcode( 'subscriber', 'wm_shortcode_subscriber' );





	/**
	 * 3.02 Accordion
	 */

		/**
		 * [accordion auto="1"]content[/accordion]
		 *
		 * Accordion wrapper
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param auto [BOOLEAN/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_accordion' ) ) {
			function wm_shortcode_accordion( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_efaults', array(
						'auto' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$duration = '';
					if ( $auto ) {
						if ( is_numeric( $auto ) && 1000 < absint( $auto ) )
							$duration = '<script>var autoAccordionDuration = ' . absint( $auto ) . ';</script>';
						$auto = ' auto';
					}

				//Output
					$out = '<div class="accordion-wrapper' . $auto . '"><ul>' . do_shortcode( $content ) . '</ul></div>' . $duration;
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_accordion

		add_shortcode( 'accordion', 'wm_shortcode_accordion' );



		/**
		 * [accordion_item title="Accordion item title"]content[/accordion_item]
		 *
		 * Accordion item
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param title [TEXT]
		 */
		if ( ! function_exists( 'wm_shortcode_accordion_item' ) ) {
			function wm_shortcode_accordion_item( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'title'       => '',
						'heading_tag' => 'h3',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//validation
				if ( '' == $title ) {
					$title = 'Accordion';
				}

				$title = strip_tags( $title, '<img><strong><span><small><em><b><i>' );

				//Output
					$out = '<li><' . tag_escape( $heading_tag ) . ' class="accordion-heading">' . $title . '</' . tag_escape( $heading_tag ) . '>' . wpautop( do_shortcode( $content ) ) . '</li>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_accordion_item

		add_shortcode( 'accordion_item', 'wm_shortcode_accordion_item' );





	/**
	 * 3.03 Audio and video
	 */

		/**
		 * [audio url="http://audioUrl" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param class     [TEXT]
		 * @param album_art [URL]
		 * @param url       [URL]
		 *
		 * @return [embed]
		 */
		if ( ! function_exists( 'wm_shortcode_audio' ) ) {
			function wm_shortcode_audio( $atts, $content = null, $shortcode ) {
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

				//Helper variables
					$out = '';

					$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
					$class    = trim( 'audio-container wrap-player ' . $class );

				//Validation
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
					$url = str_replace( array( 'http:', 'https:' ), $protocol . ':', $url );

					if ( false !== strpos( $url, 'soundcloud.com' ) ) {
					//SoundCloud audios

						$out = '<div class="' . esc_attr( $class ) . '">' . wp_oembed_get( esc_url( $url ) ) . '</div>';

					} elseif ( false !== strpos( $url, '.mp3' ) ) {
					//Self hosted audio using WP [audio] shortcode function

						$atts['mp3'] = esc_url( $url );

						$album_art = trim( $album_art );

						if ( $album_art ) {
							$album_art = '<img src="' . esc_url( $album_art ) . '" alt="" />';
						}

						$out = '<div class="' . esc_attr( $class ) . '">' . $album_art . wp_audio_shortcode( array_filter( $atts ) ) . '</div>';

					}

				//Output
					if ( ! $out ) {
						$out = do_shortcode( '[box color="red" icon="warning"]' . __( 'Please check the audio URL', 'clifden_domain' ) . '[/box]' );
					}

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
		 * IMPORTANT: Preserve $protocol variable! Otherwise the native WP embed won't work.
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param class          [TEXT]
		 * @param player         [BOOLEAN]
		 * @param player_preview [URL]
		 * @param url            [URL]
		 *
		 * @return [embed] video + Screenr video
		 */
		if ( ! function_exists( 'wm_shortcode_video' ) ) {
			function wm_shortcode_video( $atts, $content = null, $shortcode ) {
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

				//Helper variables
					$out = '';

					$protocol = ( is_ssl() ) ? ( 'https' ) : ( 'http' );
					$class    = trim( 'video-container wrap-player ' . $class );

					$embed_palyer_url = array(
							'screenr' => $protocol . '://www.screenr.com/embed/',
						);

					//Legacy
						$poster = $player_preview;

				//Validation
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
					$url = str_replace( array( 'http:', 'https:' ), $protocol . ':', $url );

					if ( false !== strpos( $url, 'screenr.com' ) ) {
					//Screenr
					//http://www.screenr.com/ScrID

						$url = str_replace( array( 'http://www.screenr.com/', 'http://screenr.com/' ), $embed_palyer_url['screenr'], $url );

						if ( $GLOBALS['is_IE'] ) {
							$iframe_atts = ' frameborder="0" scrolling="no" marginheight="0" marginwidth="0"';
						} else {
							$iframe_atts = '';
						}

						$out = '<div class="' . esc_attr( $class ) . '"><iframe src="' . esc_url( $url ) . '"' . $iframe_atts . '></iframe></div>';

					} elseif ( false !== strpos( $url, '.mp4' ) ) {
					//Self hosted video using WP [video] shortcode function

						$atts['mp4'] = esc_url( $url );

						$out = '<div class="' . esc_attr( $class ) . '">' . wp_video_shortcode( array_filter( $atts ) ) . '</div>';

					} elseif ( $url ) {
					//All other embeds

						$out = '<div class="' . esc_attr( $class ) . '">' . wp_oembed_get( esc_url( $url ) ) . '</div>';

					}

				//Output
					if ( ! $out ) {
						$out = do_shortcode( '[box color="red" icon="warning"]' . __( 'Please check the video URL', 'clifden_domain' ) . '[/box]' );
					}

					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_video

		if ( wm_check_wp_version( '3.6' ) ) {
			remove_shortcode( 'video' );
		}
		add_shortcode( 'video', 'wm_shortcode_video' );





	/**
	 * 3.04 Boxes
	 */

		/**
		 * [box color="green" style="" title="Box title" icon="check" transparent="" hero=""]content[/ box]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param color       [gray/green/blue/orange/red/NONE]
		 * @param icon        [info/question/check/warning/cancel/NONE]
		 * @param hero        [BOOLEAN/NONE]
		 * @param style       [TEXT]
		 * @param title       [TEXT]
		 * @param transparent [BOOLEAN/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_box' ) ) {
			function wm_shortcode_box( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'color'       => 'gray',
						'icon'        => '',
						'heading_tag' => 'h2',
						'hero'        => '',
						'style'       => '',
						'title'       => '',
						'transparent' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors = array( 'gray', 'green', 'blue', 'orange', 'red' );
					$icons  = array( 'info', 'question', 'check', 'warning', 'cancel' );

					$color = ( in_array( trim( $color ), $colors ) ) ? ( esc_attr( $color ) ) : ( 'gray' );
					$hero  = ( $hero ) ? ( ' hero' ) : ( '' );
					$style = ( trim( $style ) ) ? ( ' style="' . esc_attr( trim( $style ) ) . '"' ) : ( '' );
					$title = trim( $title );

					if ( $title && ! $hero ) {
						$boxTitle = '<' . tag_escape( $heading_tag ) . '>' . $title . '</' . tag_escape( $heading_tag ) . '>';
					} elseif ( $title && $hero ) {
						$boxTitle = '<p class="size-big"><strong>' . $title . '</strong></p>';
					} else {
						$boxTitle = '';
					}

					$icon        = ( in_array( trim( $icon ), $icons ) ) ? ( ' icon-box icon-' . esc_attr( $icon ) ) : ( '' );
					$transparent = ( $transparent ) ? ( ' no-background' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<div class="box color-' . esc_attr( $color . $icon . $transparent . $hero ) . '"' . $style . '>' . $boxTitle . do_shortcode( $content ) . '</div>', $atts );
			}
		} // /wm_shortcode_box

		add_shortcode( 'box', 'wm_shortcode_box' );





	/**
	 * 3.05 Buttons
	 */

		/**
		 * [button url="#" color="green" size="" text_color="fff" background_color="012345"  align="right" new_window="" icon=""]content[/button]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align            [right/left/NONE]
		 * @param background_color [#HEX/NONE]
		 * @param color            [gray/green/blue/orange/red/NONE]
		 * @param icon             [TEXT/NONE]
		 * @param new_window       [BOOLEAN/NONE]
		 * @param size             [s/m/l/xl/NONE]
		 * @param text_color       [#HEX/NONE]
		 * @param url              [URL/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_button' ) ) {
			function wm_shortcode_button( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'align'            => '',
						'background_color' => '',
						'color'            => '',
						'icon'             => '',
						'new_window'       => false,
						'size'             => 'm',
						'text_color'       => '',
						'url'              => '#',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );


				//Validation
					$colors = array( 'gray', 'green', 'blue', 'orange', 'red' );
					$sizes  = array(
							's'  => 'small',
							'm'  => 'medium',
							'l'  => 'large',
							'xl' => 'extra-large',
						 );

					$color = ( in_array( trim( $color ), $colors ) ) ? ( ' color-' . esc_attr( trim( $color ) ) ) : ( '' );
					$size  = ( in_array( trim( $size ), array_keys( $sizes ) ) ) ? ( ' size-' . esc_attr( $sizes[ trim( $size ) ] ) ) : ( ' size-medium' );

					$color_text  = preg_replace( '/[^a-fA-F0-9]/', '', esc_attr( $text_color ) ); //remove non-numeric characters
					$color_raw   = $color_text;
					$color_text  = ( $color_text ) ? ( 'color: #' . $color_text . ';' ) : ( '' );
					$text_shadow = '';

					$icon = ( $icon && false === strstr( $icon, 'icon-' ) ) ? ( 'icon-' . sanitize_html_class( $icon ) ) : ( $icon );
					$icon = ( $icon ) ? ( '<i class="' . esc_attr( $icon ) . '"></i> ' ) : ( '' );

					$align = ( 'right' === trim( $align ) ) ? ( ' alignright' ) : ( '' );

					if ( $color_text ) {
						$text_shadow = ( WM_COLOR_TRESHOLD < wm_color_brightness( $color_raw ) ) ? ( 'text-shadow: 0 -1px rgba(0,0,0, .5);' ) : ( 'text-shadow: 0 1px rgba(255,255,255, .5);' );
					}

					$color_bg = preg_replace( '/[^a-fA-F0-9]/', '', esc_attr( $background_color ) ); //remove non-numeric characters
					$color_bg = ( $color_bg ) ? ( 'background-color: #' . $color_bg . '; border-color: #' . $color_bg . ';' ) : ( '' );

					$target = ( $new_window ) ? ( ' target="_blank"' ) : ( '' );

				//Output
					$out = '<a href="' . esc_url( $url ) . '" class="btn' . esc_attr( $size . $color . $align ) . '" style="' . esc_attr( $color_text . $text_shadow . $color_bg ) . '"' . $target . '>' . $icon . do_shortcode( $content ) . '</a>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_button

		add_shortcode( 'button', 'wm_shortcode_button' );





	/**
	 * 3.06 Call to action
	 */

		/**
		 * [call_to_action title="" subtitle="" button_text="Button text" button_url="#"  button_color="green" new_window="" color="" background_color="" text_color=""  background_pattern=""]content[/call_to_action]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param background_color   [#HEX/NONE]
		 * @param background_pattern [stripes-dark/stripes-light/squares/URL/NONE]
		 * @param button_color       [gray/green/blue/orange/red/NONE]
		 * @param button_text        [TEXT]
		 * @param button_url         [URL]
		 * @param color              [gray/green/blue/orange/red/NONE]
		 * @param new_window         [BOOLEAN/NONE]
		 * @param text_color         [#HEX/NONE]
		 * @param subtitle           [TEXT]
		 * @param title              [TEXT]
		 */
		if ( ! function_exists( 'wm_shortcode_call_to_action' ) ) {
			function wm_shortcode_call_to_action( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
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
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors   = array( 'gray', 'green', 'blue', 'orange', 'red' );
					$patterns = array(
							'stripes-dark'  => WM_ASSETS_THEME . 'img/patterns/dark_stripes-10.png',
							'stripes-light' => WM_ASSETS_THEME . 'img/patterns/light_stripes-10.png',
							'squares'       => WM_ASSETS_THEME . 'img/patterns/square_bg.png',
							'checker'       => WM_ASSETS_THEME . 'img/patterns/checkered_pattern.png',
							'dots'          => WM_ASSETS_THEME . 'img/patterns/absurdidad.png',
						);

					$subtitle    = ( $subtitle ) ? ( ' <small>' . strip_tags( $subtitle ) . '</small>' ) : ( '' );
					$title       = ( $title ) ? ( '<div class="call-to-action-title"><h2>' . $title . $subtitle . '</h2></div>' ) : ( '' );
					$title_class = ( $title ) ? ( ' has-title' ) : ( '' );

					$button_color = ( in_array( $button_color, $colors ) ) ? ( $button_color ) : ( 'green' );

					$color            = ( in_array( trim( $color ), $colors ) ) ? ( esc_attr( ' color-' . trim( $color ) ) ) : ( '' );
					$text_color       = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $text_color ) ); //remove non-numeric characters
					$text_color       = ( $text_color ) ? ( 'color: #' . $text_color . ';' ) : ( '' );
					$background_color = preg_replace( '/[^a-fA-F0-9]/', '', sanitize_title( $background_color ) ); //remove non-numeric characters
					$background_color = ( $background_color ) ? ( ' background-color: #' . $background_color . '; border-color: #' . $background_color . ';' ) : ( '' );

					$pattern = ( in_array( $background_pattern, array_keys( $patterns ) ) ) ? ( ' background-image: url(' . esc_url( $patterns[ $background_pattern ] ) . ');' ) : ( 'background-image: url(' . esc_url( $background_pattern ) . ');' );

				//Output
					$out  = '<div class="call-to-action clearfix' . esc_attr( $color . $title_class ) . '" style="' . esc_attr( $text_color . $background_color . $pattern ) . '">';
					$out .= $title . '<div class="cta-text">' . $content . '</div>';
					$out .= '[button url="' . esc_url( $button_url ) . '" color="' . esc_attr( $button_color ) . '" size="xl" new_window="' . esc_attr( $new_window ) . '"]' . $button_text . '[/button]';
					$out .= '</div>';

					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( shortcode_unautop( $out ) ), $atts );
			}
		} // /wm_shortcode_call_to_action

		add_shortcode( 'call_to_action', 'wm_shortcode_call_to_action' );





	/**
	 * 3.07 Columns
	 */

		/**
		 * [column size="1/4 last"]content[/column]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param class [optional:STRING/NONE]
		 * @param last  [optional/legacy:BOOLEAN/NONE]
		 * @param size  [predefined,NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_column' ) ) {
			function wm_shortcode_column( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'class' => '',
						'last'  => false,
						'size'  => '1/2',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$sizes = array(
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

					$classes  = ( in_array( trim( $size ), $sizes ) ) ? ( 'col-' . str_replace( '/', '', trim( $size ) ) ) : ( 'col-12' );
					$classes .= ( $last ) ? ( ' last' ) : ( '' );
					$classes .= ( $class ) ? ( ' ' . trim( $class ) ) : ( '' );

				//Output
					$out = '<div class="column ' . esc_attr( $classes ) . '">' . do_shortcode( $content ) . '</div>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_column

		add_shortcode( 'column', 'wm_shortcode_column' );





	/**
	 * 3.08 Countdown timer
	 */

		/**
		 * [countdown time="" size="" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param size [s/m/l/xl/NONE]
		 * @param time [DATE: Y-m-d H:i]
		 */
		if ( ! function_exists( 'wm_shortcode_countdown' ) ) {
			function wm_shortcode_countdown( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'size' => 'xl',
						'time' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if (
							! trim( $time )
							|| ! strtotime( trim( $time ) )
							|| strtotime( trim( $time ) ) < strtotime( 'now' )
						) {
						return;
					}

				//Validation
					static $countdown_id;

					$sizes = array(
							's'  => 'small',
							'm'  => 'medium',
							'l'  => 'large',
							'xl' => 'extra-large',
						);

					$size = ( in_array( trim( $size ), array_keys( $sizes ) ) ) ? ( ' size-' . esc_attr( $sizes[ trim( $size ) ] ) ) : ( ' size-medium' );
					$time = strtotime( trim( $time ) );

					$out = '<!-- Countdown timer -->
						<div class="countdown-timer' . esc_attr( $size ) . '">
							<div id="countdown-timer-' . absint( ++$countdown_id ) . '">
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
						jQuery( "#countdown-timer-' . absint( $countdown_id ) . '" ).countDown( {
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

				//Output
					if ( $out ) {
						wp_enqueue_script( 'lwtCountdown' );
						return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out . "\r\n\r\n", $atts );
					}
			}
		} // /wm_shortcode_countdown

		add_shortcode( 'countdown', 'wm_shortcode_countdown' );





	/**
	 * 3.09 Divider
	 */

		/**
		 * [divider type="space" height="60" no_border="1" opacity="10" top_link="" unit="em" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param height    [#/NONE]
		 * @param no_border [BOOLEAN]
		 * @param opacity   [#/NONE]
		 * @param top_link  [BOOLEAN]
		 * @param type      [space/dotted/dashed/shadow-top/shadow-bottom/NONE]
		 * @param unit      [px/em/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_divider' ) ) {
			function wm_shortcode_divider( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'height'    => '',
						'no_border' => false,
						'opacity'   => 15,
						'top_link'  => false,
						'type'      => '',
						'unit'      => 'px',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$types = array( 'shadow-top', 'shadow-bottom', 'dots', 'dashes' );
					$units = array( 'px', 'em', '%' );

					$unit         = ( in_array( trim( $unit ), $units ) ) ? ( trim( $unit ) ) : ( 'px' );
					$height       = ( isset( $height ) && $height ) ? ( ' style="margin-bottom: ' . esc_attr( absint( $height ) ) . $unit . '"' ) : ( '' );
					$type         = ( in_array( trim( $type ), $types ) ) ? ( ' type-' . esc_attr( trim( $type ) ) ) : ( '' );
					$border       = ( $no_border ) ? ( ' no-border' ) : ( '' );
					$opacity      = ( $opacity ) ? ( ' style="opacity: ' . esc_attr( min( 100, absint( str_replace( '%', '', $opacity ) ) ) / 100 ) . '; filter: alpha(opacity=' . min( 100, absint( str_replace( '%', '', $opacity ) ) ) . ');"' ) : ( '' );
					$shadow       = ( ' type-shadow-top' == $type || ' type-shadow-bottom' == $type ) ? ( str_replace( ' type-shadow-', '', $type ) ) : ( '' );
					$shadow_image = ( $shadow ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/shadows/shadow-' . $shadow . '.png"' . $opacity . ' alt="" />' ) : ( '' );
					$shadow_class = ( $shadow ) ? ( ' shadow shadow-' . $shadow . ' no-border' ) : ( '' );
					$height       = ( $shadow ) ? ( '' ) : ( $height );

				//Output
					$out = '<div class="divider' . esc_attr( $type . $border . $shadow_class ) . '"' . $height . '>' . $shadow_image;
					$out .= ( $top_link ) ? ( '<a href="#top" class="top-of-page">' . __( 'Top', 'clifden_domain' ) . '</a>' ) : ( '' );
					$out .= '</div>';

					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_divider

		add_shortcode( 'devider', 'wm_shortcode_divider' ); //legacy...
		add_shortcode( 'divider', 'wm_shortcode_divider' );





	/**
	 * 3.10 Dropcaps
	 */

		/**
		 * [dropcap type="round"]content[/dropcap]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param type [round/square/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_dropcap' ) ) {
			function wm_shortcode_dropcap( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'type' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$types = array( 'round', 'square', 'leaf' );

					$type = ( in_array( trim( $type ), $types ) ) ? ( ' ' . trim( $type ) ) : ( '' );

				//Output
					$out = '<span class="dropcap' . esc_attr( $type ) . '">' . do_shortcode( $content ) . '</span>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_dropcap

		add_shortcode( 'dropcap', 'wm_shortcode_dropcap' );





	/**
	 * 3.11 Icon
	 */

		/**
		 * [icon type="icon-adjust" size="" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param size [TEXT/NONE]
		 * @param type [predefined/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_icon' ) ) {
			function wm_shortcode_icon( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'size' => '',
						'type' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$size = ( $size ) ? ( ' style="font-size: ' . esc_attr( $size ) . '; line-height:' . esc_attr( $size ) . ';"' ) : ( '' );
					$type = ( false !== stripos( $type, 'icon-' ) ) ? ( $type ) : ( 'icon-' . $type );

				//Output
					$out = ( ! $type ) ? ( '' ) : ( '<i class="' . esc_attr( $type ) . '"' . $size . '></i>' );
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_icon

		add_shortcode( 'icon', 'wm_shortcode_icon' );





	/**
	 * 3.12 Lists
	 */

		/**
		 * [list icon="star"]content[/list]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param icon [legacy - the same as bullet]
		 */
		if ( ! function_exists( 'wm_shortcode_list' ) ) {
			function wm_shortcode_list( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'icon' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$icon = ( $icon && false === strstr( $icon, 'icon-' ) ) ? ( 'icon-' . sanitize_html_class( $icon ) ) : ( $icon );
					$icon = ( $icon ) ? ( ' ' . esc_attr( $icon ) ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( shortcode_unautop( str_replace( '<li>', '<li class="' . esc_attr( $icon ) . '">', $content ) ) ), $atts );
			}
		} // /wm_shortcode_list

		add_shortcode( 'list', 'wm_shortcode_list' );





	/**
	 * 3.13 Login form
	 */

		/**
		 * [login stay="" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param stay [BOOLEAN/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_login' ) ) {
			function wm_shortcode_login( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'stay' => false,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$redirect = ( $stay ) ? ( get_permalink() ) : ( home_url() );

					$out = '<div class="wrap-login">';

					if ( ! is_user_logged_in() ) {

						$out .= '<h3>' . __( 'Log in', 'clifden_domain' ) . '</h3>';

						$out .= wp_login_form( apply_filters( 'wmhook_shortcode_' . $shortcode . '_login_form_args', array(
								'echo'           => false,
								'redirect'       => esc_url( $redirect ),
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
							) ) );

						$out .= '<p class="note"><small><a href="' . wp_lostpassword_url( get_permalink() ) . '" title="' . __( 'Password will be resent to your e-mail address.', 'clifden_domain' ) . '">' . __( 'I have lost my password', 'clifden_domain' ) . '</a></small></p>';

					} else {

						$out .= '[button url="' . wp_logout_url( esc_url( get_permalink() ) ) . '" color="red" size="xl"]' . __( 'Log out', 'clifden_domain' ) . '[/button]';

					}

					$out .= '</div>';

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( $out ), $atts );
			}
		} // /wm_shortcode_login

		add_shortcode( 'login', 'wm_shortcode_login' );





	/**
	 * 3.14 Markers
	 */

		/**
		 * [marker color="green" text_color="fff" background_color="012345"]content[/marker]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param background_color [#HEX/NONE]
		 * @param color            [gray/green/blue/orange/red/NONE]
		 * @param text_color       [#HEX/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_marker' ) ) {
			function wm_shortcode_marker( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'background_color' => '',
						'color'            => 'gray',
						'text_color'       => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors = array( 'gray', 'green', 'blue', 'orange', 'red' );

					$color = ( in_array( trim( $color ), $colors ) ) ? ( ' color-' . esc_attr( trim( $color ) ) ) : ( ' color-gray' );

					$color_text = preg_replace( '/[^a-fA-F0-9]/', '', esc_attr( $text_color ) ); //remove non-numeric characters
					$color_text = ( $color_text ) ? ( 'color: #' . $color_text . ';' ) : ( '' );

					$color_bg = preg_replace( '/[^a-fA-F0-9]/', '', esc_attr( $background_color ) ); //remove non-numeric characters
					$color_bg = ( $color_bg ) ? ( 'background-color: #' . $color_bg . ';' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<span class="marker' . esc_attr( $color ) . '" style="' . esc_attr( $colorText . $color_bg ) . '">' . do_shortcode( $content ) . '</span>', $atts );
			}
		} // /wm_shortcode_marker

		add_shortcode( 'marker', 'wm_shortcode_marker' );





	/**
	 * 3.15 Posts / pages / custom posts
	 */

		/**
		 * [content_module id="123" no_thumb="" no_title="" layout="" randomize="" /]
		 *
		 * Content module
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param id        [POST ID OR SLUG [required]]
		 * @param layout    [center/NONE]
		 * @param module    [the same as id]
		 * @param no_thumb  [BOOLEAN]
		 * @param no_title  [BOOLEAN]
		 * @param randomize [CONTENT MODULE TAG ID OR SLUG]
		 * @param widget    [BOOLEAN]
		 */
		if ( ! function_exists( 'wm_shortcode_content_module' ) ) {
			function wm_shortcode_content_module( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'id'        => null,
						'layout'    => '',
						'module'    => null,
						'no_thumb'  => false,
						'no_title'  => false,
						'randomize' => null,
						'widget'    => true,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				$id = ( trim( $module ) ) ? ( trim( $module ) ) : ( trim( $id ) );

				//Requirements check
					if ( ! $id && ! $randomize ) {
						return;
					}

				//Validation
					static $displayed_ids = array();

					$id         = ( is_numeric( $id ) ) ? ( absint( $id ) ) : ( sanitize_title( $id ) );
					$post_query = ( is_numeric( $id ) ) ? ( 'p' ) : ( 'name' );
					$randomize  = ( is_numeric( $randomize ) ) ? ( absint( $randomize ) ) : ( sanitize_title( $randomize ) );

					$out = '';

					//Get the Content Module content
						wp_reset_query();

						if ( $randomize ) {

							$query = array(
									'post_type'           => 'wm_modules',
									'posts_per_page'      => 1,
									'ignore_sticky_posts' => 1,
									'orderby'             => 'rand',
									'tax_query'           => array( array(
											'taxonomy' => 'content-module-tag',
											'field'    => ( is_numeric( $randomize ) ) ? ( 'id' ) : ( 'slug' ),
											'terms'    => $randomize
										) ),
									'post__not_in'        => $displayed_ids,
								);

						} else {

							$query = array(
									'post_type' => 'wm_modules',
									$post_query => $id,
								);

						}

						$the_module = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $the_module->have_posts() ) {

							$the_module->the_post();

							$displayed_ids[] = get_the_ID();

							$more_link  = esc_url( stripslashes( wm_meta_option( 'module-link' ) ) );
							$icon_bg    = ( wm_meta_option( 'module-icon-box-color' ) ) ? ( ' style="background-color: ' . esc_attr( wm_meta_option( 'module-icon-box-color', get_the_ID(), 'color' ) ) . ';"' ) : ( '' );
							$icon_color = ( wm_meta_option( 'module-font-icon-color' ) ) ? ( ' style="color: ' . esc_attr( wm_meta_option( 'module-font-icon-color', get_the_ID(), 'color' ) ) . ';"' ) : ( '' );
							$layout     = ( $layout ) ? ( ' layout-' . esc_attr( $layout ) ) : ( null );

							//HTML to display output
								$class_wrap  = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( ' icon-module' ) : ( '' );
								$class_wrap .= ( $no_thumb ) ? ( ' no-thumb' ) : ( '' );
								$class_wrap .= ( $no_title ) ? ( ' no-title' ) : ( '' );
								$class_wrap .= ( wm_meta_option( 'module-icon-box-transparent' ) ) ? ( ' transparent-icon-bg' ) : ( '' );

								$module_title  = '<h3>';
								$module_title .= ( $more_link ) ? ( '<a href="' . esc_url( $more_link ) . '">' ) : ( '' );
								$module_title .= get_the_title();
								$module_title .= ( $more_link ) ? ( '</a>' ) : ( '' );
								$module_title .= '</h3>';

								$out .= '<div class="content-module-' . esc_attr( get_the_ID() . $class_wrap . $layout ) . '">';

									if ( 'icon' === wm_meta_option( 'module-type' ) && wm_meta_option( 'module-font-icon' ) ) {

										$class_image_container  = 'icon-container font-icon';
										$class_image_container .= ( $icon_bg ) ? ( ' colored-background' ) : ( '' );

										$out .= '<div class="' . esc_attr( $class_image_container ) . '"' . $icon_bg . '>';
											if ( $more_link ) {
												$out .= '<a href="' . esc_url( $more_link ) . '">';
											}
											$out .= '<i class="' . esc_attr( wm_meta_option( 'module-font-icon' ) ) . '"' . $icon_color . '></i>';
											if ( $more_link ) {
												$out .= '</a>';
											}
										$out .= '</div>';

									} elseif ( has_post_thumbnail() && ! $no_thumb ) {

										$class_image_container  = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( 'icon-container' ) : ( 'image-container' );
										$class_image_container .= ( $icon_bg ) ? ( ' colored-background' ) : ( '' );

										$out .= '<div class="' . esc_attr( $class_image_container ) . '"' . $icon_bg . '>';
											if ( $more_link ) {
												$out .= '<a href="' . esc_url( $more_link ) . '">';
											}
											//if icon module and featured image - make featured image 64x64 pixels ("widget" size), else use "mobile" width image while keep proportions
											$image_full = ( 'icon' === wm_meta_option( 'module-type' ) ) ? ( get_the_post_thumbnail( get_the_ID(), apply_filters( 'wmhook_shortcode_' . $shortcode . '_image_size', 'widget', $atts ) ) ) : ( get_the_post_thumbnail( get_the_ID(), apply_filters( 'wmhook_shortcode_' . $shortcode . '_image_size', 'mobile', $atts ) ) );
											$out .= preg_replace( '/(width|height)=\"\d*\"\s/', '', $image_full );
											if ( $more_link ) {
												$out .= '</a>';
											}
										$out .= '</div>';

									}

									if ( ! $no_title ) {
										$out .= $module_title;
									}

									$out .= '<div class="module-content clearfix">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';

									$customs = get_post_custom();

								$out .= '</div>';

						}	else {

							return;

						}

						wp_reset_query();

				//Output
					$out = apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
					if ( $widget ) {
						return '<div class="widget wm-content-module">' . $out . '</div>';
					} else {
						return $out;
					}
			}
		} // /wm_shortcode_content_module

		add_shortcode( 'content_module', 'wm_shortcode_content_module' );



		/**
		 * [faq category="5" filter="left" order="new" filter_color="blue" align=""][/faq]
		 *
		 * FAQ list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align        [left/right/NONE]
		 * @param category     [FAQ CATEGORY ID OR SLUG]
		 * @param desc_size    [#/NONE]
		 * @param filter       [above/left/right/NONE]
		 * @param filter_color [gray/green/blue/orange/red/NONE]
		 * @param order        [new/old/name/random/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_faq' ) ) {
			function wm_shortcode_faq( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'align'        => 'left',
						'category'     => null,
						'desc_size'    => 4,
						'filter'       => '',
						'filter_color' => '',
						'order'        => 'name',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-faq' ) ) {
						return;
					}

				//Validation
					$out = $content_filter = '';

					$align            = ( 'right' === $align ) ? ( $align ) : ( 'left' );
					$desc_cols        = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
					$animation_toggle = ''; //sets simple toggle() animation when Isotope is used
					$layout_isotope   = 'vertical';
					$colors           = array( 'gray', 'green', 'blue', 'orange', 'red' );
					$positions        = array( 'above', 'left', 'right' );
					$order_by     = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$filter_btn_class = ( $filter_color && in_array( $filter_color, $colors ) ) ? ( 'btn color-' . esc_attr( $filter_color ) ) : ( 'btn' );

					$filter = ( $filter && in_array( $filter, $positions ) ) ? ( $filter ) : ( false );
					$order  = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['name'] );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'faq-category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					//Get the FAQ
						wp_reset_query();

						$query = array(
								'post_type'           => 'wm_faq',
								'posts_per_page'      => -1,
								'ignore_sticky_posts' => 1,
								'orderby'             => $order[0],
								'order'               => $order[1]
							);

						if ( $category ) {
							$query['tax_query'] = array( array(
								'taxonomy' => 'faq-category',
								'field'    => ( is_numeric( $category ) ) ? ( 'term_id' ) : ( 'slug' ),
								'terms'    => $category
							) );
						}

						$faq = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $faq->have_posts() ) {

							$out .= '<div class="wrap-faq-shortcode filterable-content clearfix">';

							if ( $content ) {
							//if description (shortcode content)
								$out .= ( 'right' === $align ) ? ( '<div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . '">' ) : ( '<div class="column col-1' . esc_attr( $desc_cols ) . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . ' last">' );
								$filter = false;
							}

							//Filter output code
								if ( $filter ) {

									$animation_toggle = ' animation-fade';
									$links_real       = ( stripos( $filter, '-links' ) ) ? ( true ) : ( false );
									$content_filter  .= '<ul><li><a href="#" data-filter="*" class="active ' . esc_attr( $filter_btn_class ) . '">' . apply_filters( 'wmhook_shortcode_' . $shortcode . '_filter_text_all', __( 'All', 'clifden_domain' ) ) . '</a></li>';
									$filter_btn_class = ( $filter_btn_class ) ? ( ' class="' . esc_attr( $filter_btn_class ) . '"' ) : ( '' );

									if ( $category ) {
									//if parent category set - filter from child categories

										$terms = get_term_children( $category, 'faq-category' );
										$count = count( $terms );

										if ( ! is_wp_error( $terms ) && $count > 0 ) {
											$out_array = array();

											foreach ( $terms as $child ) {
												$href = ( $links_real ) ? ( get_term_link( $term->slug, 'faq-category' ) ) : ( '#' );
												$term = get_term_by( 'id', $child, 'faq-category' );

												$out_array['<li><a href="' . esc_url( $href ) . '" data-filter=".faq-category-' . esc_attr( $term->slug ) . '"' . $filter_btn_class . '>' . $term->name . '</a></li>'] = $term->name;
											} // /foreach

											asort( $out_array );

											$out_array = array_flip( $out_array );

											$content_filter .= implode( '', $out_array );
										}

									} else {
									//no parent category - filter from all categories

										$terms = get_terms( 'faq-category' );
										$count = count( $terms );

										if ( ! is_wp_error( $terms ) && $count > 0 ) {
											foreach ( $terms as $term ) {
												$href = ( $links_real ) ? ( get_term_link( $term->slug, 'faq-category' ) ) : ( '#' );

												$content_filter .= '<li><a href="' . esc_url( $href ) . '" data-filter=".faq-category-' . esc_attr( $term->slug ) . '"' . $filter_btn_class . '>' . $term->name . '</a></li>';
											} // /foreach
										}

									}

									$content_filter .= '</ul>';
								}

							if ( 'above' === $filter ) {
								$out .= '<div class="wrap-filter">' . $content_filter . '</div><div class="wrap-faqs filter-this" data-layout-mode="' . esc_attr( $layout_isotope ) . '">';
							} elseif ( 'left' === $filter ) {
								$out .= '<div class="wrap-filter column col-15">' . $content_filter . '</div><div class="wrap-faqs column col-45 last filter-this" data-layout-mode="' . esc_attr( $layout_isotope ) . '">';
							} elseif ( 'right' === $filter ) {
								//$out .= '<div class="wrap-faqs column col-45 filter-this" data-layout-mode="' . $layout_isotope . '">';
								$out .= '<div class="wrap-filter column col-15 alignright ml0 mr0">' . $content_filter . '</div><div class="wrap-faqs column col-45 filter-this" data-layout-mode="' . esc_attr( $layout_isotope ) . '">';
							} else {
								$out .= '<div class="wrap-faqs">';
							}

							while ( $faq->have_posts() ) : //output post content

								$faq->the_post();

								$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

								if ( ! $out_single ) {

									$terms       = get_the_terms( get_the_ID() , 'faq-category' );
									$class_terms = '';

									if ( ! is_wp_error( $terms ) && $terms ) {
										foreach( $terms as $term ) {
											$class_terms .= ' faq-category-' . $term->slug;
										} // /foreach
									}

									$out_single .= '<article class="item item-' . esc_attr( get_the_ID() . $class_terms ) . '"><div class="toggle-wrapper">';
										$out_single .= '<h3 class="toggle-heading question' . esc_attr( $animation_toggle ) . '">' . get_the_title() . '</h3>';
										$out_single .= '<div class="answer">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
									$out_single .= '</div></article>';

								}

								$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

							endwhile;

							if ( 'right' === $filter ) {
								$out .= '</div><div class="wrap-filter column col-15 last">' . $content_filter . '</div>';
							} else {
								$out .= '</div>';
							}

							if ( $content ) {
							//if description (shortcode content)
								$out .= ( 'right' === $align ) ? ( '</div><div class="column col-1' . esc_attr( $desc_cols ) . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' );
							}

							$out .= '</div>';

						}

						wp_reset_query();

					if ( $filter ) {
						wp_enqueue_script( 'isotope' );
					}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_faq

		add_shortcode( 'faq', 'wm_shortcode_faq' );



		/**
		 * [last_update format="" item="" /]
		 *
		 * Date of last update of posts or projects
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param item   [projects/posts/NONE]
		 * @param format [text/NONE (PHP date format)]
		 */
		if ( ! function_exists( 'wm_shortcode_posts_update' ) ) {
			function wm_shortcode_posts_update( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'item'   => 'posts',
						'format' => get_option( 'date_format' ),
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$items = array(
							'projects' => 'wm_projects',
							'posts'    => 'post'
						);

					if ( 'disable' === wm_option( 'general-role-projects' ) ) {
						$items = array(
								'posts' => 'post'
							);
					}

					$item = ( in_array( $item, array_keys( $items ) ) ) ? ( $items[ $item ] ) : ( 'post' );

					$post = get_posts( array(
							'numberposts' => 1,
							'post_type'   => $item,
						) );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', date( $format, strtotime( $post[0]->post_date ) ), $atts );
			}
		} // /wm_shortcode_posts_update

		add_shortcode( 'last_update', 'wm_shortcode_posts_update' );



		/**
		 * [logos columns="5" count="10" order="new" align="left"]content[/logos]
		 *
		 * Logos (of clients/partners)
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align     [left/right/NONE]
		 * @param category  [LOGOS CATEGORY ID OR SLUG]
		 * @param columns   [#/NONE (2 - 6)]
		 * @param count     [#/NONE]
		 * @param desc_size [#/NONE]
		 * @param order     [new/old/name/random/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_logos' ) ) {
			function wm_shortcode_logos( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'align'     => 'left',
						'category'  => null,
						'columns'   => 4,
						'count'     => 4,
						'desc_size' => 4,
						'order'     => 'random',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-logos' ) ) {
						return;
					}

				//Validation
					$out = '';

					$align       = ( 'right' === $align ) ? ( $align ) : ( 'left' );
					$cols        = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
					$desc_cols   = ( 1 < absint( $desc_size ) && 6 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
					$count       = ( $count ) ? ( absint( $count ) ) : ( 4 );
					$order_by = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order       = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'logos-category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					//Get the Logos
						wp_reset_query();

						$query = array(
								'post_type'           => 'wm_logos',
								'posts_per_page'      => $count,
								'ignore_sticky_posts' => 1,
								'orderby'             => $order[0],
								'order'               => $order[1]
							);

						if ( $category ) {
							$query['tax_query'] = array( array(
								'taxonomy' => 'logos-category',
								'field'    => ( is_numeric( $category ) ) ? ( 'term_id' ) : ( 'slug' ),
								'terms'    => $category
							) );
						}

						$logos = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $logos->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="wrap-logos-shortcode clearfix">';

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '<div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . '"><div class="wrap-logos"><div class="row">' ) : ( '<div class="column col-1' . esc_attr( $desc_cols ) . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . ' last"><div class="wrap-logos"><div class="row">' ); //if description on the right - open logos container and inner container only ELSE output content column and open logos container

							} else {
							//if no description (no shortcode content)

								$out .= '<div class="wrap-logos"><div class="row">';

							}

								while ( $logos->have_posts() ) : //output post content

									$logos->the_post();

									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

									if ( ! $out_single ) {

										$link   = ( wm_meta_option( 'client-link' ) ) ? ( esc_url( wm_meta_option( 'client-link' ) ) ) : ( null );
										$rel    = ( wm_meta_option( 'client-link-rel' ) ) ? ( ' rel="' . esc_attr( wm_meta_option( 'client-link-rel' ) ) . '"' ) : ( null );
										$target = ( wm_meta_option( 'client-link-action' ) ) ? ( wm_meta_option( 'client-link-action' ) ) : ( '_blank' );

										$row         = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
										$out_single .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );

										$out_single .= '<div class="column col-1' . esc_attr( $cols ) . ' item item-' . esc_attr( get_the_ID() ) . ' no-margin">';
											$out_single .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '" target="' . esc_attr( $target ) . '"' . $rel . '>' ) : ( '' );
											$out_single .= '<img src="' . esc_url( wm_meta_option( 'client-logo' ) ) . '" alt="' . esc_attr( get_the_title() ) . '" title="' . esc_attr( get_the_title() ) . '" />';
											$out_single .= ( $link ) ? ( '</a>' ) : ( '' );
										$out_single   .= '</div>';

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

								endwhile;

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '</div></div></div><div class="column col-1' . esc_attr( $desc_cols ) . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div></div>' ); //if description on the right - close logos container and its inner container and output content column ELSE just close logos container and its inner container

							} else {
							//if no description (no shortcode content)

								$out .= '</div></div>';

							}

							$out .= '</div>';

						}

						wp_reset_query();

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_logos

		add_shortcode( 'logos', 'wm_shortcode_logos' );



		/**
		 * [posts columns="5" count="10" category="5" order="new" related="0" align="left" scroll=""  thumb="0"]content[/posts]
		 *
		 * Post list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align          [left/right/NONE]
		 * @param category       [POSTS CATEGORY ID OR SLUG]
		 * @param columns        [#/NONE (1 - 6)] *Modified by Tiria*
		 * @param count          [#/NONE]
		 * @param desc_size      [#/NONE]
		 * @param excerpt_length [#/NONE]
		 * @param order          [new/old/name/random/NONE]
		 * @param related        [BOOLEAN]
		 * @param scroll         [BOOLEAN]
		 * @param thumb          [BOOLEAN]
		 * @param thumbsize      [THUMBNAIL SIZE]
		 * @param datedisplay	 [BOOLEAN] *Added by Tiria*
		 *
		 * Modified by Tiria to allow 1 column posts and add possibility to disable date
		 *
		 */
		if ( ! function_exists( 'wm_shortcode_posts' ) ) {
			function wm_shortcode_posts( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
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
						'catdisplay'     => true,
						'social'		 => 'null',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$out = '';

					$image_size = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );
					$image_size = ( '' != $thumbsize && in_array( $thumbsize, get_intermediate_image_sizes() ) ) ? ( $thumbsize ) : ( $image_size );
					
					$align          = ( 'right' === $align ) ? ( $align ) : ( 'left' );
					$cols           = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 1 );
					$desc_cols      = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
					$count          = ( $count ) ? ( absint( $count ) ) : ( 4 );
					$order_by = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order          = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$class_scroll   = ( $scroll ) ? ( ' scrollable' ) : ( '' );
					$thumb          = ( $thumb ) ? ( true ) : ( false );
					$excerpt_length = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 10 );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					//Get the posts
						wp_reset_query();

						$query = array(
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
								$query['cat'] = implode( ',', $taxonomies );

								//Get current post tags
									$taxonomies = array();
									$terms      = get_the_terms( $post->ID , 'post_tag' );
									if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
										foreach( $terms as $term ) {
											$taxonomies[] = $term->slug;
										}
									}
								$query['tag'] = implode( ',', $taxonomies );

								$query['post__not_in'] = array( $post->ID );
							}
						}

						$posts = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $posts->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="wrap-posts-shortcode clearfix">';

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '<div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . '"><div class="wrap-posts' . esc_attr( $class_scroll ) . '">' ) : ( '<div class="column col-1' . esc_attr( $desc_cols ) . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . ' last"><div class="wrap-posts' . esc_attr( $class_scroll ) . '">' ); //if description on the right - open posts container and inner container only ELSE output content column and open posts container

							} else {
							//if no description (no shortcode content)

								$out .= '<div class="wrap-posts' . $class_scroll . '">';

							}

								$out .= '<div class="row">';

								while ( $posts->have_posts() ) : //output post content

									$posts->the_post();

									$evenodd = (isset($evenodd) && $evenodd=='even') ? 'odd' : 'even'; // Added by Tiria
									
									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

									if ( ! $out_single ) {

										if ( 0 < $excerpt_length ) {
											$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', get_the_excerpt(), $excerpt_length );
										} else {
											$excerpt_text = '';
										}
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerpt_text, get_the_id(), $atts );
										
										$output_cat='';
										if($catdisplay){
											$categories = get_the_category();
											$first_cat = ' first';
											foreach($categories as $cat){
												$output_cat .= '<a class="post-category'.$first.'" href="' . esc_url( get_category_link( $cat->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'clifden' ), $cat->name ) ) . '">' . esc_html( $cat->name ) . '</a>';
												$first_cat='';
											}
										}
										
										$output_social='';
										if($social && $social!='null'){
											$socials=explode(',',$social);
											foreach($socials as $s){
												switch($s){
													case 'fb':
														$output_social.='<a class="social-link facebook" target="_blank" href="http://www.facebook.com/sharer.php?u='.esc_url(get_permalink()).'" ></a>';
													break;
													case 'tt':
														$output_social.='<a class="social-link twitter" target="_blank" href="http://twitter.com/share?url='.esc_url(get_permalink()).'&text='. urlencode_deep(get_the_title()) .'" ></a>';
													break;
													case 'gp':
														$output_social.='<a class="social-link googleplus" target="_blank" href="https://plus.google.com/share?url='.esc_url(get_permalink()).'" ></a>';
													break;
													case 'in':
														$output_social.='<a class="social-link linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url='.esc_url(get_permalink()).'" ></a>';
													break;
												}
											}
										}

										$output_post = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
												'date'    => '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="post-publish-time">' . esc_html( get_the_date() ) . '</time>',
												'thumb'   => wm_thumb( array(
														'class'        => 'post-thumb',
														'size'         => $image_size,
														'list'         => true,
														'link'         => true,
														'placeholder'  => true,
													) ),
												'title'   => '<h3 class="post-title text-element"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>',
												'excerpt' => $excerpt_text,
												'more'    => '<a class="readmore" href="' . esc_url( get_permalink() ) . '">' . __( 'Read More', 'clifden_domain' ) . '</a>'
											), get_the_id(), $atts );

										$row         = ( ++$i % $cols === 1 || ($cols==1 && $i>1)) ? ( $row + 1 ) : ( $row );
										$out_single .= ( ($i % $cols === 1 && 0 < $row ) || ($cols==1 && $i>1)) ? ( '</div><div class="row">' ) : ( '' );

										$out_single .= '<article class="column col-1' . esc_attr( $cols ) . $evenodd . ' item item-' . esc_attr( get_the_ID() ) . ' no-margin">';
											if($datedisplay || $catdisplay) $out_single .= '<div class="post-details">';
											if($catdisplay) $out_single .= '<div class="post-categories">'.$output_cat.'</div>';
											if($datedisplay) $out_single .= '<div class="post-date">' . $output_post['date'] . '</div>';
											if($datedisplay || $catdisplay) $out_single .= '</div>';
											$out_single .= ( $thumb ) ? ( $output_post['thumb'] ) : ( '' );
											$out_single .= '<div class="text">';
												$out_single .= $output_post['title'];
												if($datedisplay) $out_single .= '<div class="text-element post-date">' . $output_post['date'] . '</div>';
												$out_single .= '<div class="post-excerpt text-element">' . $output_post['excerpt'] . '</div>';
												$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $output_post );
											$out_single .= '</div>';
											if($output_social=='') $out_single .= $output_post['more'];
											if($output_social!='') $out_single .= '<div class="actions">'.$output_post['more'].'<div class="social-share">'.$output_social.'</div></div>';
											$out_single .= '<div class="clearfix"></div>';
										$out_single .= '</article>';

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

								endwhile;

								$out .= '</div>';

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '</div></div><div class="column col-1' . esc_attr( $desc_cols ) . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div>' ); //if description on the right - close posts container and its inner container and output content column ELSE just close posts container and its inner container

							} else {
							//if no description (no shortcode content)

								$out .= '</div>';

							}

							$out .= '</div>';

						}

						wp_reset_query();

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_posts

		add_shortcode( 'posts', 'wm_shortcode_posts' );

		
		/* ADDED BY TIRIA */
		/**
		 * [posts_slideshow columns="5" count="10" category="5" order="new" related="0" align="left" scroll="" thumb="0" thumbsize="" datedisplay="" catdisplay="" timer="" social="null"][/posts_slideshow]
		 *
		 * Post list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param category       [POSTS CATEGORY ID OR SLUG]
		 * @param columns        [#/NONE (1 - 6)]
		 * @param count          [#/NONE]
		 * @param excerpt_length [#/NONE]
		 * @param order          [new/old/name/random/NONE]
		 * @param thumb          [BOOLEAN]
		 * @param thumbsize      [THUMBNAIL SIZE]
		 * @param datedisplay	 [BOOLEAN]
		 * @param catdisplay	 [BOOLEAN]
		 * @param timer	 		 [#/NONE (5000 - 15000)]
		 * @param social	 	 [null or multiple values]
		 *
		 */
		if ( ! function_exists( 'wm_shortcode_posts_slideshow' ) ) {
			function wm_shortcode_posts_slideshow( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'category'       => null,
						'columns'        => 1,
						'count'          => 5,
						'excerpt_length' => 20,
						'order'          => 'new',
						'thumb'          => true,
						'thumbsize'		 => 'thumbnail',
						'datedisplay'    => true,
						'catdisplay'     => true,
						'timer'     	 => 10000,
						'social'		 => 'null',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$out = '';

					$image_size = ( '' != $thumbsize && in_array( $thumbsize, get_intermediate_image_sizes() ) ) ? ( $thumbsize ) : 'thumbnail';
					
					$cols     = ( 0 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 1 );
					$count          = ( $count ) ? ( absint( $count ) ) : ( 5 );
					$order_by = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order          = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$thumb          = ( $thumb ) ? ( true ) : ( false );
					$excerpt_length = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 20 );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					//Get the posts
						wp_reset_query();

						$query = array(
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

						$posts = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $posts->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="posts-slideshow clearfix" data-timer="'.$timer.'">';
							
							// controls
							$out .= '<div class="posts-slideshow-navigation navigation-left"></div>';
							$out .= '<div class="posts-slideshow-navigation navigation-right"></div>';
							
							$out .= '<div class="posts-slideshow-mask">';
							$out .= '<div class="posts-slideshow-container">';
								$out .= '<div class="posts-slideshow-row" data-row="'.$row.'">';
								while ( $posts->have_posts() ) : //output post content

									$posts->the_post();

									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

									if ( ! $out_single ) {

										if ( 0 < $excerpt_length ) {
											// $excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', get_the_excerpt(), $excerpt_length );
											$excerpt_text = apply_filters( 'wmhook_shortcode_posts_excerpt_text', get_the_excerpt(), $excerpt_length );
										} else {
											$excerpt_text = '';
										}
										// $excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerpt_text, get_the_id(), $atts );
										$excerpt_text = apply_filters( 'wmhook_shortcode_posts_excerpt', $excerpt_text, get_the_id(), $atts );
										
										$output_cat='';
										if($catdisplay){
											$categories = get_the_category();
											$first_cat = ' first';
											foreach($categories as $cat){
												$output_cat .= '<a class="post-category'.$first.'" href="' . esc_url( get_category_link( $cat->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'clifden' ), $cat->name ) ) . '">' . esc_html( $cat->name ) . '</a>';
												$first_cat='';
											}
										}
										
										$output_social='';
										if($social && $social!='null'){
											$socials=explode(',',$social);
											foreach($socials as $s){
												switch($s){
													case 'fb':
														$output_social.='<a class="social-link facebook" target="_blank" href="http://www.facebook.com/sharer.php?u='.esc_url(get_permalink()).'" ></a>';
													break;
													case 'tt':
														$output_social.='<a class="social-link twitter" target="_blank" href="http://twitter.com/share?url='.esc_url(get_permalink()).'&text='. urlencode_deep(get_the_title()) .'" ></a>';
													break;
													case 'gp':
														$output_social.='<a class="social-link googleplus" target="_blank" href="https://plus.google.com/share?url='.esc_url(get_permalink()).'" ></a>';
													break;
													case 'in':
														$output_social.='<a class="social-link linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url='.esc_url(get_permalink()).'" ></a>';
													break;
												}
											}
										}
										
										$output_post = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
												'date'    => '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="post-publish-time">' . esc_html( get_the_date() ) . '</time>',
												'thumb'   => wm_thumb( array(
														'class'        => 'post-thumb',
														'size'         => $image_size,
														'list'         => true,
														'link'         => true,
														'placeholder'  => true,
													) ),
												'title'   => '<h3 class="post-title text-element"><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>',
												'excerpt' => $excerpt_text,
												'more'    => '<a class="readmore" href="' . esc_url( get_permalink() ) . '">' . __( 'Read More', 'clifden_domain' ) . '</a>'
											), get_the_id(), $atts );

										$row         = ( ++$i % $cols === 1 || ($cols==1 && $i>1)) ? ( $row + 1 ) : ( $row );
										$out_single .= ( ($i % $cols === 1 && 0 < $row ) || ($cols==1 && $i>1)) ? ( '</div><div class="posts-slideshow-row" data-row="'.$row.'">' ) : ( '' );
										
										$out_single .= '<article class="column col-1' . esc_attr( $cols ) . $evenodd . ' item item-' . esc_attr( get_the_ID() ) . ' no-margin">';
											if($datedisplay || $catdisplay) $out_single .= '<div class="post-details">';
											if($catdisplay) $out_single .= '<div class="post-categories">'.$output_cat.'</div>';
											if($datedisplay) $out_single .= '<div class="post-date">' . $output_post['date'] . '</div>';
											if($datedisplay || $catdisplay) $out_single .= '</div>';
											$out_single .= ( $thumb ) ? ( $output_post['thumb'] ) : ( '' );
											$out_single .= '<div class="text">';
												$out_single .= $output_post['title'];
												$out_single .= '<div class="post-excerpt text-element">' . $output_post['excerpt'] . '</div>';
											$out_single .= '</div>';
											if($output_social=='') $out_single .= $output_post['more'];
											if($output_social!='') $out_single .= '<div class="actions">'.$output_post['more'].'<div class="social-share">'.$output_social.'</div></div>';
											$out_single .= '<div class="clearfix"></div>';
										$out_single .= '</article>';

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

								endwhile;
								$out .= '</div>';
							$out .= '</div>';
							$out .= '</div>';
							
							$out .= '</div>';

						}

						wp_reset_query();

				//Output
				wp_enqueue_script('psshow');
				return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_posts

		add_shortcode( 'posts_slideshow', 'wm_shortcode_posts_slideshow' );
		

		/**
		 * [prices table="123" /]
		 *
		 * Price tables
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param table [PRICE TABLE ID OR SLUG]
		 */
		if ( ! function_exists( 'wm_shortcode_prices' ) ) {
			function wm_shortcode_prices( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'table' => null,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-prices' ) ) {
						return;
					}

					if ( ! $table ) {
						return;
					}

				//Validation
					$i   = 0;
					$out = '';

					$array_columns = array();

					$table = ( is_numeric( $table ) ) ? ( absint( $table ) ) : ( sanitize_title( $table ) );

					//Get the Table columns
						wp_reset_query();

						$query = array(
								'post_type'      => 'wm_price',
								'posts_per_page' => 6,
								'tax_query'      => array( array(
										'taxonomy' => 'price-table',
										'field'    => ( is_numeric( $table ) ) ? ( 'term_id' ) : ( 'slug' ),
										'terms'    => $table
									) ),
								'post__not_in'   => get_option( 'sticky_posts' )
							);

						$price_table = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $price_table->have_posts() && $table ) {

							$column_size = $price_table->post_count;

							$out .= '<div id="price-table-' . esc_attr( $table ) . '" class="price-table">';

							while ( $price_table->have_posts() ) :

								$price_table->the_post();

								$i++;

								$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

								if ( ! $out_single ) {

									//$last = ( $column_size === $i ) ? ( ' last' ) : ( '' );

									$color_bg = ( wm_meta_option( 'price-color' ) ) ? ( wm_meta_option( 'price-color', null, 'color' ) ) : ( null );
									$styles   = ( $color_bg ) ? ( ' style="background-color: ' . esc_attr( $color_bg ) . '"' ) : ( '' );

									$class_bg = '';

									if ( $color_bg ) {
										$class_bg = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_meta_option( 'price-color' ) ) ) ? ( ' light-icons' ) : ( ' dark-icons' );
									}

									$out_single = '<div class="price-column column no-margin col-1' . esc_attr( $column_size . wm_meta_option( 'price-style' ) ) . '">';

										$out_single .= '<div class="price-heading' . esc_attr( $class_bg ) . '"' . $styles . '>';
											$out_single .= '<h3>' . get_the_title() . '</h3>';
											$out_single .= '<p class="cost">' . wm_meta_option( 'price-cost' ) . '</p>';
											$out_single .= '<p class="note">' . wm_meta_option( 'price-note' ) . '</p>';
											$out_single .= '<div class="price-button">';
												$out_single .= ( wm_meta_option( 'price-btn-text' ) ) ? ( '<p class="wrap-button">[button url="' . esc_url( wm_meta_option( 'price-btn-url' ) ) . '" color="' . esc_attr( wm_meta_option( 'price-btn-color' ) ) . '" size="medium"]' . wm_meta_option( 'price-btn-text' ) . '[/button]</p>' ) : ( '' );
											$out_single .= '</div>';
										$out_single .= '</div>';

										$out_single .= '<div class="price-spec">';
										$out_single .= apply_filters( 'wm_default_content_filters', get_the_content() );
										$out_single .= '</div>';

										$out_single .= ( ' featured' === wm_meta_option( 'price-style' ) ) ? ( '<div class="bottom"' . $styles . '></div>' ) : ( '' );

									$out_single .= '</div>';

								}

								$col_order = ( wm_meta_option( 'price-order' ) ) ? ( wm_meta_option( 'price-order' ) ) : ( -7 + $i );

								$array_columns[ $col_order ] = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

							endwhile;

							ksort( $array_columns );

							$out .= implode( "\r\n", $array_columns );
							$out .= '</div>';

						}

						wp_reset_query();

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( $out ), $atts );
			}
		} // /wm_shortcode_prices

		add_shortcode( 'prices', 'wm_shortcode_prices' );



		/**
		 * [projects align="" filter="" columns="5" count="10" category="" order="" pagination=""  thumb="1"]content[/projects]
		 *
		 * Projects list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align          [left/right/NONE]
		 * @param category       [PROJECTS CATEGORY ID OR SLUG]
		 * @param columns        [#/NONE (2 - 6)]
		 * @param count          [#/NONE]
		 * @param desc_size      [#/NONE]
		 * @param excerpt_length [#/NONE]
		 * @param filter         [BOOLEAN]
		 * @param order          [newest/oldest/name/random/NONE]
		 * @param pagination     [BOOLEAN]
		 * @param scroll         [BOOLEAN]
		 * @param thumb          [BOOLEAN]
		 */
		if ( ! function_exists( 'wm_shortcode_projects' ) ) {
			function wm_shortcode_projects( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
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
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-projects' ) ) {
						return;
					}

				//Validation
					global $paged;

					if ( ! isset( $paged ) ) {
						$paged = 1;
					}

					$out = $content_filter = '';

					$image_size = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );

					$align        = ( 'right' === $align ) ? ( $align ) : ( 'left' );
					$cols         = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
					$desc_cols    = ( 1 < absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
					$count        = ( $count ) ? ( intval( $count ) ) : ( -1 );
					$order_by = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order        = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$class_scroll = ( $scroll ) ? ( ' scrollable' ) : ( '' );
					$thumb        = ( $thumb ) ? ( true ) : ( false );

					$excerpt_length = ( isset( $excerpt_length ) ) ? ( absint( $excerpt_length ) ) : ( 12 );
					$layout_isotope = 'fitRows';
					$filter         = ( $filter ) ? ( true ) : ( false );
					$filterable     = ( $filter ) ? ( ' filterable-content' ) : ( '' );
					$filter_this    = ( $filter ) ? ( ' filter-this' ) : ( '' );

					$class_icon_color = ( WM_COLOR_TRESHOLD > wm_color_brightness( wm_option( 'design-accent-color' ) ) ) ? ( ' light-icons' ) : ( ' dark-icons' );
					$color_icon      = ( ' light-icons' === $class_icon_color ) ? ( 'white' ) : ( 'black' );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'project-category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					$icons_project = array(
							'static-project' => 'icon-picture',
							'flex-project'   => 'icon-play-circle',
							'video-project'  => 'icon-film',
							'audio-project'  => 'icon-music',
						);

					//Get the Projects
						wp_reset_query();

						$query = array(
								'paged'               => $paged,
								'post_type'           => 'wm_projects',
								'posts_per_page'      => $count,
								'ignore_sticky_posts' => 1,
								'orderby'             => $order[0],
								'order'               => $order[1]
							);

						if ( $category ) {
							$query['tax_query'] = array( array(
								'taxonomy' => 'project-category',
								'field'    => 'id',
								'terms'    => $category
							) );
						}

						$projects = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						$pagination       = ( $pagination ) ? ( wm_pagination( $projects, array( 'print' => false ) ) ) : ( '' );
						$class_pagination = ( $pagination ) ? ( ' paginated' ) : ( '' );

						if ( $projects->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="wrap-projects-shortcode clearfix' . esc_attr( $filterable . $class_icon_color . $class_pagination ) . '">';

							//Filter output code
								if ( $filter ) {

									$content_filter .= '<div class="wrap-filter"><ul>';

									if ( $category ) {
									//if parent category set - filter from child categories

										$category_parent = get_term_by( 'id', $category, 'project-category' );
										$content_filter .= '<li><a href="#" data-filter="*" class="active">' . apply_filters( 'wmhook_shortcode_' . $shortcode . '_filter_text_all_category', sprintf( __( 'All <span>%s</span>', 'clifden_domain' ), $category_parent->name ), $category_parent ) . '</a></li>';

										$terms = get_term_children( $category, 'project-category' );
										$count = count( $terms );

										if ( ! is_wp_error( $terms ) && $count > 0 ) {
											$out_array = array();

											foreach ( $terms as $child ) {
												$term = get_term_by( 'id', $child, 'project-category' );

												$out_array['<li><a href="#" data-filter=".project-category-' . esc_attr( $term->slug ) . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>'] = $term->name;
											} // /foreach

											asort( $out_array );

											$out_array = array_flip( $out_array );

											$content_filter .= implode( '', $out_array );
										}

									} else {
									//no parent category - filter from all categories

										$content_filter .= '<li><a href="#" data-filter="*" class="active">' . apply_filters( 'wmhook_shortcode_' . $shortcode . '_filter_text_all', __( 'All', 'clifden_domain' ) ) . '</a></li>';

										$terms = get_terms( 'project-category' );
										$count = count( $terms );

										if ( ! is_wp_error( $terms ) && $count > 0 ) {
											foreach ( $terms as $term ) {
												$content_filter .= '<li><a href="#" data-filter=".project-category-' . esc_attr( $term->slug ) . '">' . $term->name . ' <span class="count">(' . $term->count . ')</span></a></li>';
											} // /foreach
										}

									}

									$content_filter .= '</ul></div>';

								} // if filter

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '<div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . '">' . $content_filter . '<div class="wrap-projects' . esc_attr( $filter_this . $class_scroll ) . '" data-layout-mode="' . esc_attr( $layout_isotope ) . '">' ) : ( '<div class="column col-1' . esc_attr( $desc_cols ) . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . ' last">' . $content_filter . '<div class="wrap-projects' . esc_attr( $filter_this . $class_scroll ) . '" data-layout-mode="' . esc_attr( $layout_isotope ) . '">' ); //if description on the right - open projects container and inner container only ELSE output content column and open projects container

							} else {
							//if no description (no shortcode content)

								$out .= $content_filter . '<div class="wrap-projects' . esc_attr( $filter_this . $class_scroll ) . '" data-layout-mode="' . esc_attr( $layout_isotope ) . '">';

							}

								$out .= ( ! $filter ) ? ( '<div class="row">' ) : ( '' );

								while ( $projects->have_posts() ) : //output post content

									$projects->the_post();

									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

									if ( ! $out_single ) {

										$terms           = get_the_terms( get_the_ID() , 'project-category' );
										$class_term      = '';
										$out_array_terms = array();

										if ( ! is_wp_error( $terms ) && $terms ) {
											foreach( $terms as $term ) {
												//$out_array_terms[] = '<a href="' . get_term_link( $term->slug, 'project-category' ) . '" class="item">' . $term->name . '</a>';
												$out_array_terms[] = '<span class="item">' . $term->name . '</span>';
												$class_term .= ' project-category-' . $term->slug;
											} // /foreach
										}

										$link         = ( wm_meta_option( 'project-link-list' ) ) ? ( wm_meta_option( 'project-link' ) ) : ( get_permalink() );
										$class_anchor = wm_meta_option( 'project-link-list' );
										if ( 'true' === $class_anchor || '1' === $class_anchor ) {
											$class_anchor = 'modal'; //pre-2.0 compatibility
										}
										$atts_link    = ( 'target-blank' == $class_anchor ) ? ( ' target="_blank"' ) : ( '' );
										$atts_link   .= ( trim( wm_meta_option( 'project-rel-text' ) ) ) ? ( ' rel="' . esc_attr( trim( wm_meta_option( 'project-rel-text' ) ) ) . '" data-rel="' . esc_attr( trim( wm_meta_option( 'project-rel-text' ) ) ) . '"' ) : ( ' data-rel=""' );

										if ( 0 < $excerpt_length && has_excerpt() ) {
											$excerpt_text = get_the_excerpt();
										} else {
											$excerpt_text = '';
										}
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', $excerpt_text, $excerpt_length );
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerpt_text, get_the_id(), $atts );

										$icon = ( ! wm_meta_option( 'project-type' ) ) ? ( 'icon-picture' ) : ( $icons_project[ wm_meta_option( 'project-type' ) ] );

										$out_project = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
												'category' => '<div class="project-category text-element">' . implode( ', ', $out_array_terms ) . '</div>',
												'thumb'    => wm_thumb( array(
														'class'        => 'post-thumb',
														'size'         => $image_size,
														'list'         => true,
														'link'         => array( $link, $class_anchor ),
														'placeholder'  => true,
														'a-attributes' => $atts_link,
													) ),
												'title'    => '<h3 class="project-title text-element"><a href="' . esc_url( $link ) . '" class="' . esc_attr( $class_anchor ) . '"' . $atts_link . '>' . get_the_title() . '</a></h3>',
												'type'     => '<a class="project-icon ' . esc_attr( $class_anchor ) . '" href="' . esc_url( $link ) . '"' . $atts_link . '><i class="' . esc_attr( $icon ) . '" title="' . esc_attr( get_the_title() ) . '"></i></a>',
												'excerpt'  => ( $excerpt_text ) ? ( '<div class="project-excerpt text-element">' . $excerpt_text . '</div>' ) : ( '' ),
											), get_the_id(), $atts );

										if ( ! $filter ) {
											$row         = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
											$out_single .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
										}

										$out_single .= '<article class="column col-1' . esc_attr( $cols . ' no-margin item item-' . get_the_ID() . $class_term ) . '">';
											$out_single .= ( $thumb ) ? ( $out_project['thumb'] ) : ( '' );
											$out_single .= '<div class="text">';
												$out_single .= $out_project['type'];
												$out_single .= $out_project['title'];
												$out_single .= $out_project['category'];
												$out_single .= $out_project['excerpt'];
												$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $out_project );
											$out_single .= '</div>';
										$out_single .= '</article>';

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

								endwhile;

								$out .= ( ! $filter ) ? ( '</div>' ) : ( '' );

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '</div>' . $pagination . '</div><div class="column col-1' . esc_attr( $desc_cols ) . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div>' . $pagination . '</div>' ); //if description on the right - close projects container and its inner container and output content column ELSE just close projects container and its inner container

							} else {
							//if no description (no shortcode content)

								$out .= '</div>' . $pagination;

							}

							$out .= '</div>';

						}

						wp_reset_query();

					if ( $filter ) {
						wp_enqueue_script( 'isotope' );
					}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_projects

		add_shortcode( 'projects', 'wm_shortcode_projects' );



		/**
		 * [project_attributes title="" /]
		 *
		 * Project attributes
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param title [text/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_project_attributes' ) ) {
			function wm_shortcode_project_attributes( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'title' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					if ( 'disable' === wm_option( 'general-role-projects' ) ) {
						return;
					}

					$out   = '';
					$title = ( trim( $title ) ) ? ( '<h3>' . trim( $title ) . '</h3>' . "\r\n" ) : ( '' );

					if ( wm_meta_option( 'project-link' ) ) {
						$link = wm_meta_option( 'project-link' );
						$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_link_html', '<li class="attribute-link"><strong class="attribute-heading">' . __( 'Project URL', 'clifden_domain' ) . ':</strong> <a href="' . esc_url( $link ) . '">' . $link . '</a></li>', $link );
					}

					if ( wm_meta_option( 'project-attributes' ) ) {
						foreach ( wm_meta_option( 'project-attributes' ) as $item ) {
							if ( $item['attr'] && $item['val'] ) {
								$out .= '<li><strong class="attribute-heading">' . $item['attr'] . ':</strong> ';
								$out .= $item['val'] . '</li>';
							}
						}
					}

					$out = ( $out ) ? ( do_shortcode( '<div class="attributes">' . $title . '<ul class="no-bullets">' . $out . '</ul></div>' ) ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_project_attributes

		add_shortcode( 'project_attributes', 'wm_shortcode_project_attributes' );



		/**
		 * [staff columns="5" count="10" department="5" order="new" align="left" thumb="1" category="0" margin="1"]content[/ staff]
		 *
		 * Staff list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align      [left/right/NONE]
		 * @param columns    [#/NONE (1 - 6)]
		 * @param count      [#/NONE]
		 * @param department [STAFF DEPARTMENT ID OR SLUG]
		 * @param desc_size  [#/NONE]
		 * @param order      [new/old/name/random/NONE]
		 * @param thumb      [BOOLEAN]
		 * @param category   [BOOLEAN]
		 * @param margin     [BOOLEAN]
		 */
		if ( ! function_exists( 'wm_shortcode_staff' ) ) {
			function wm_shortcode_staff( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'align'      => 'left',
						'columns'    => 4,
						'count'      => 4,
						'department' => null,
						'desc_size'  => 4,
						'order'      => 'new',
						'thumb'      => true,
						'category'   => false,
						'margin'     => true,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-staff' ) ) {
						return;
					}

				//Validation
					$out = '';

					$image_size = ( wm_option( 'general-staff-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-staff-image-ratio' ) ) : ( 'mobile-ratio-169' );

					$align         = ( 'right' === $align ) ? ( $align ) : ( 'left' );
					$cols          = ( 1 <= absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
					$desc_cols     = ( 1 <= absint( $desc_size ) && 7 > absint( $desc_size ) ) ? ( absint( $desc_size ) ) : ( 4 );
					$count         = ( $count ) ? ( absint( $count ) ) : ( 4 );
					$order_by      = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order         = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$thumb         = ( $thumb ) ? ( true ) : ( false );

					if ( $department ) {

						if ( is_numeric( $department ) ) {
							$department = absint( $department );
						} else {
							$department = get_term_by( 'slug', sanitize_title( $department ), 'department' );
							$department = ( $department && isset( $department->term_id ) ) ? ( $department->term_id ) : ( null );
						}

					} else {

						$department = null;

					}

					//Get the Staff
						wp_reset_query();

						$query = array(
								'post_type'           => 'wm_staff',
								'posts_per_page'      => $count,
								'ignore_sticky_posts' => 1,
								'orderby'             => $order[0],
								'order'               => $order[1]
							);

						if ( 0 < $department ) {
							$query['tax_query'] = array( array(
								'taxonomy' => 'department',
								'field'    => 'term_id',
								'terms'    => explode( ',', $department )
							) );
						}

						$staff = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $staff->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="wrap-staff-shortcode clearfix">';

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '<div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . '"><div class="wrap-staff"><div class="row">' ) : ( '<div class="column col-1' . esc_attr( $desc_cols ) . ' wrap-description">' . do_shortcode( $content ) . '</div><div class="column col-' . esc_attr( ( $desc_cols - 1 ) . $desc_cols ) . ' last"><div class="wrap-staff"><div class="row">' ); //if description on the right - open staff container and inner container only ELSE output content column and open staff container

							} else {
							//if no description (no shortcode content)

								$out .= '<div class="wrap-staff"><div class="row">';

							}

								
							if ( $category ) { $prev_cat = false; }
								
								while ( $staff->have_posts() ) : //output post content

									$staff->the_post();

									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

									
									if ( $category ) {
										$categories = get_the_terms( get_the_ID(), 'department' );
										$cat = ( isset( $categories[0] ) ) ? $categories[0] : false;
									}
									
									if ( ! $out_single ) {

										if ( wm_option( 'general-staff-rich' ) ) {
											$excerpt_text = ( has_excerpt() ) ? ( get_the_excerpt() ) : ( '' );
				 						} else {
											$excerpt_text = get_the_content();
										}
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', $excerpt_text, $atts );
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerpt_text, get_the_id(), $atts );

										$contacts = '';

										if ( wm_meta_option( 'staff-phone' ) ) {
											$contacts .= '<li class="icon-phone">' . wm_meta_option( 'staff-phone' ) . '</li>';
										}
										if ( wm_meta_option( 'staff-email' ) ) {
											$contacts .= '<li class="icon-envelope"><a href="#" data-address="' . esc_attr( wm_nospam( wm_meta_option( 'staff-email' ) ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
										}
										if ( wm_meta_option( 'staff-linkedin' ) ) {
											$contacts .= '<li class="icon-linkedin"><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
										}
										if ( wm_meta_option( 'staff-skype' ) ) {
											$contacts .= '<li class="icon-headphones"><a href="skype:' . esc_attr( sanitize_title( wm_meta_option( 'staff-skype' ) ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';
										}
										if ( is_array( wm_meta_option( 'staff-custom-contacts' ) ) ) {
											foreach ( wm_meta_option( 'staff-custom-contacts' ) as $contact ) {
												$contacts .= '<li class="' . esc_attr( $contact['attr'] ) . '">' . strip_tags( trim( $contact['val'] ), '<a><img><strong><span><small><em><b><i>' ) . '</li>';
											} // /foreach
										}

										$contact_text = ( $contacts ) ? ( '<ul class="contacts">' . $contacts . '</ul>' ) : ( '' );

										$out_staff = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
												'thumb'      => wm_thumb( array(
														'class'        => 'staff-thumb',
														'size'         => $image_size,
														'list'         => true,
														'link'         => 'modal',
														'placeholder'  => true,
													) ),
												'thumb-link' => wm_thumb( array(
														'class'        => 'staff-thumb',
														'size'         => $image_size,
														'list'         => true,
														'link'         => true,
														'placeholder'  => true,
													) ),
												'title'      => '<h3 class="staff-title text-element"><strong>' . get_the_title() . '</strong></h3>',
												'title-link' => '<h3 class="staff-title text-element"><a href="' . esc_url( get_permalink() ) . '"><strong>' . get_the_title() . '</strong></a></h3>',
												'position'   => '<p class="staff-position text-element">' . wm_meta_option( 'staff-position' ) . '</p>',
												'excerpt'    => $excerpt_text,
												'contact'    => $contact_text,
											), get_the_id(), $atts );

										$row         = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
										$out_single .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );

										if( $margin ) {
											$out_margin	= ( ($i+1) % $cols === 1 ) ? ( 'last' ) : ( '' );
										}
										else $out_margin = 'no-margin';
										
										if ( $category ) {
											
											$out_single .= '<div class="column col-1' . esc_attr( $cols ) . ' ' . $out_margin . '">';
											
											if ( $cat && $cat->name != $prev_cat->name ) $out_single .= '<h3 class="category">' . esc_html( $cat->name ) . '</h3>';
											
											$out_single .= '<article class="item item-' . get_the_ID() . '">';
												if ( $thumb ) {
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['thumb-link'] ) : ( $out_staff['thumb'] );

												}
												$out_single .= '<div class="text">';
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['title-link'] ) : ( $out_staff['title'] );

													$out_single .= '<div class="staff-excerpt text-element">' . $out_staff['excerpt'] . '</div>';
													$out_single .= $out_staff['position'];
													$out_single .= $out_staff['contact'];
													$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $out_staff );
												$out_single .= '</div>';
											$out_single .= '</article>';
											
											$out_single .= '</div>';
											
										}
										else {
											
											$out_single .= '<article class="column col-1' . esc_attr( $cols ) . ' item item-' . get_the_ID() . ' ' . $out_margin . '">';
												if ( $thumb ) {
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['thumb-link'] ) : ( $out_staff['thumb'] );
												}
												$out_single .= '<div class="text">';
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['title-link'] ) : ( $out_staff['title'] );
													$out_single .= '<div class="staff-excerpt text-element">' . $out_staff['excerpt'] . '</div>';
													$out_single .= $out_staff['position'];
													$out_single .= $out_staff['contact'];
													$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $out_staff );
												$out_single .= '</div>';
											$out_single .= '</article>';
										
										}

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

									if ( $category ) $prev_cat = $cat;
									
								endwhile;

							if ( $content ) {
							//if description (shortcode content)

								$out .= ( 'right' === $align ) ? ( '</div></div></div><div class="column col-1' . esc_attr( $desc_cols ) . ' last wrap-description">' . do_shortcode( $content ) . '</div>' ) : ( '</div></div></div>' ); //if description on the right - close staff container and its inner container and output content column ELSE just close staff container and its inner container

							} else {
							//if no description (no shortcode content)

								$out .= '</div></div>';

							}

							$out .= '</div>';

						}

						wp_reset_query();

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_staff

		add_shortcode( 'staff', 'wm_shortcode_staff' );

		
		/**
		 * [staffdetails columns="3" count="6" department="5" order="new" thumb="1" category="0" margin="1" /]
		 *
		 * Staff list with detail popup
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param columns    [#/NONE (2 - 6)]
		 * @param count      [#/NONE]
		 * @param department [STAFF DEPARTMENT ID OR SLUG]
		 * @param order      [new/old/name/random/NONE]
		 * @param thumb      [BOOLEAN]
		 * @param category   [BOOLEAN]
		 * @param margin     [BOOLEAN]
		 */
		if ( ! function_exists( 'wm_shortcode_staffdetails' ) ) {
			function wm_shortcode_staffdetails( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'columns'    => 3,
						'count'      => 6,
						'department' => null,
						'order'      => 'new',
						'thumb'      => true,
						'category'   => false,
						'margin'     => true,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( 'disable' === wm_option( 'general-role-staff' ) ) {
						return;
					}

				//Validation
					$out = '';

					$image_size = ( wm_option( 'general-staff-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-staff-image-ratio' ) ) : ( 'mobile-ratio-169' );

					$cols          = ( 1 < absint( $columns ) && 7 > absint( $columns ) ) ? ( absint( $columns ) ) : ( 4 );
					$count         = ( $count ) ? ( absint( $count ) ) : ( 4 );
					$order_by      = array(
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'name'   => array( 'title', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order         = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$thumb         = ( $thumb ) ? ( true ) : ( false );

					if ( $department ) {

						if ( is_numeric( $department ) ) {
							$department = absint( $department );
						} else {
							$department = get_term_by( 'slug', sanitize_title( $department ), 'department' );
							$department = ( $department && isset( $department->term_id ) ) ? ( $department->term_id ) : ( null );
						}

					} else {

						$department = null;

					}

					//Get the Staff
						wp_reset_query();

						$query = array(
								'post_type'           => 'wm_staff',
								'posts_per_page'      => $count,
								'ignore_sticky_posts' => 1,
								'orderby'             => $order[0],
								'order'               => $order[1]
							);

						if ( 0 < $department ) {
							$query['tax_query'] = array( array(
								'taxonomy' => 'department',
								'field'    => 'term_id',
								'terms'    => explode( ',', $department )
							) );
						}

						$staff = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $staff->have_posts() ) {

							$i = $row = 0;

							$out .= '<div class="wrap-staffdetails-shortcode clearfix">';

							$out .= '<div class="wrap-staffdetails"><div class="row">';

								
							if ( $category ) { $prev_cat = false; }
								
								while ( $staff->have_posts() ) : //output post content

									$staff->the_post();

									$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );
									
									if ( $category ) {
										$categories = get_the_terms( get_the_ID(), 'department' );
										$cat = ( isset( $categories[0] ) ) ? $categories[0] : false;
									}
									
									if ( ! $out_single ) {

										$excerpt_text = ( has_excerpt() ) ? ( get_the_excerpt() ) : ( '' );
				 						
										
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt_text', $excerpt_text, $atts );
										$excerpt_text = apply_filters( 'wmhook_shortcode_' . $shortcode . '_excerpt', $excerpt_text, get_the_id(), $atts );

										$content_text = apply_filters( 'the_content', get_the_content() );
										
										$contacts = '';

										if ( wm_meta_option( 'staff-phone' ) ) {
											$contacts .= '<li class="icon-phone">' . wm_meta_option( 'staff-phone' ) . '</li>';
										}
										if ( wm_meta_option( 'staff-email' ) ) {
											$contacts .= '<li class="icon-envelope"><a href="#" data-address="' . esc_attr( wm_nospam( wm_meta_option( 'staff-email' ) ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
										}
										if ( wm_meta_option( 'staff-linkedin' ) ) {
											$contacts .= '<li class="icon-linkedin"><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
										}
										if ( wm_meta_option( 'staff-skype' ) ) {
											$contacts .= '<li class="icon-headphones"><a href="skype:' . esc_attr( sanitize_title( wm_meta_option( 'staff-skype' ) ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';
										}
										if ( is_array( wm_meta_option( 'staff-custom-contacts' ) ) ) {
											foreach ( wm_meta_option( 'staff-custom-contacts' ) as $contact ) {
												$contacts .= '<li class="' . esc_attr( $contact['attr'] ) . '">' . strip_tags( trim( $contact['val'] ), '<a><img><strong><span><small><em><b><i>' ) . '</li>';
											} // /foreach
										}

										$contact_text = ( $contacts ) ? ( '<ul class="contacts">' . $contacts . '</ul>' ) : ( '' );

										$out_staff = apply_filters( 'wmhook_shortcode_' . $shortcode . '_item_output_array', array(
												'thumb'      => wm_thumb( array(
														'class'        => 'staff-thumb',
														'img-attr'	   => array(
																			'class'		=> 'modal-link',
																			'data-bio'	=> get_the_ID(),
																		),
														'size'         => $image_size,
														'list'         => true,
														'link'         => 'modal',
														'placeholder'  => true,
													) ),
												'thumb-link' => wm_thumb( array(
														'class'        => 'staff-thumb',
														'img-attr'	   => array(
																			'class'		=> 'modal-link',
																			'data-bio'	=> get_the_ID(),
																		),
														'size'         => $image_size,
														'list'         => true,
														'link'         => false,//array(0=>'#content',1=>'modal-link'),
														'placeholder'  => true,
													) ),
												'title'      => '<h3 class="staff-title text-element"><strong>' . get_the_title() . '</strong></h3>',
												'title-link' => '<h3 class="staff-title text-element"><a class="modal-link" data-bio="' . get_the_ID() . '"><strong>' . get_the_title() . '</strong></a></h3>',
												'position'   => '<p class="staff-position text-element">' . wm_meta_option( 'staff-position' ) . '</p>',
												'excerpt'    => $excerpt_text,
												'contact'    => $contact_text,
												'more'		 => '<a class="readmore modal-link" data-bio="' . get_the_ID() . '">BIOGRAPHY</a>',
											), get_the_id(), $atts );

										$row         = ( ++$i % $cols === 1 ) ? ( $row + 1 ) : ( $row );
										$out_single .= ( $i % $cols === 1 && 1 < $row ) ? ( '</div><div class="row">' ) : ( '' );
										if( $margin ) {
											$out_margin	= ( ($i+1) % $cols === 1 ) ? ( 'last' ) : ( '' );
										}
										else $out_margin = 'no-margin';
										
										if ( $category ) {
											
											$out_single .= '<div class="column col-1' . esc_attr( $cols ) . ' ' . $out_margin . '">';
											
											if ( $cat && $cat->name != $prev_cat->name ) $out_single .= '<h3 class="category">' . esc_html( $cat->name ) . '</h3>';
											
											$out_single .= '<article class="item item-' . get_the_ID() . '">';
												if ( $thumb ) {
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['thumb-link'] ) : ( $out_staff['thumb'] );
												}
												$out_single .= '<div class="text">';
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['title-link'] ) : ( $out_staff['title'] );
													$out_single .= $out_staff['position'];
													$out_single .= '<div class="staff-excerpt text-element">' . $out_staff['excerpt'] . '</div>';
													$out_single .= $out_staff['more'];
													$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $out_staff );
												$out_single .= '</div>';
												$out_single .= '<div id="modal-' . get_the_ID() . '" class="modal"><div class="close-modal">X</div>';
													$out_single .= '<div class="biography">' . $content_text . '</div>';
													$out_single .= '<div class="details">';
														$out_single .= $out_staff['thumb-link'];
														$out_single .= $out_staff['contact'];
													$out_single .= '</div>';
												$out_single .= '</div>';
											$out_single .= '</article>';
											
											$out_single .= '</div>';
											
										}
										else {
											
											$out_single .= '<article class="column col-1' . esc_attr( $cols ) . ' item item-' . get_the_ID() . ' ' . $out_margin . '">';
												if ( $thumb ) {
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['thumb-link'] ) : ( $out_staff['thumb'] );
												}
												$out_single .= '<div class="text">';
													$out_single .= ( wm_option( 'general-staff-rich' ) && ! wm_meta_option( 'staff-no-rich' ) ) ? ( $out_staff['title-link'] ) : ( $out_staff['title'] );
													$out_single .= $out_staff['position'];
													$out_single .= '<div class="staff-excerpt text-element">' . $out_staff['excerpt'] . '</div>';
													$out_single .= $out_staff['more'];
													$out_single .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_additional_output', '', $atts, $out_staff );
												$out_single .= '</div>';
												$out_single .= '<div id="modal-' . get_the_ID() . '" class="modal"><div class="close-modal">X</div>';
													$out_single .= '<div class="biography">' . $content_text . '</div>';
													$out_single .= '<div class="details">';
														$out_single .= $out_staff['thumb-link'];
														$out_single .= $out_staff['contact'];
													$out_single .= '</div>';
												$out_single .= '</div>';
											$out_single .= '</article>';
										
										}

									}

									$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

									if ( $category ) $prev_cat = $cat;
									
								endwhile;

							$out .= '</div></div>';

							$out .= '</div>';

						}

						wp_reset_query();

				//Output
					wp_enqueue_script('staffdetails');
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_staffdetails

		add_shortcode( 'staffdetails', 'wm_shortcode_staffdetails' );
		
		/**
		 * [status count="5" speed="3" layout="large" date="1" /]
		 *
		 * Status posts
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param count  [#]
		 * @param date   [BOOLEAN]
		 * @param layout [normal/large/NONE]
		 * @param speed  [#]
		 */
		if ( ! function_exists( 'wm_shortcode_status' ) ) {
			function wm_shortcode_status( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'count'  => 1,
						'date'   => false,
						'layout' => 'normal',
						'speed'  => 0,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( wm_option( 'blog-no-format-status' ) ) {
						return;
					}

				//Validation
					$out    = '';
					$speed  = ( 1 < absint( $speed ) ) ? ( absint( $speed ) * 1000 ) : ( 0 );
					$date   = ( $date ) ? ( true ) : ( false );
					$layout = ( 'large' == $layout ) ? ( ' large' ) : ( ' normal' );

					//Get the status posts
						wp_reset_query();

						$query = apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', array(
								'posts_per_page'      => absint( $count ),
								'ignore_sticky_posts' => 1,
								'tax_query'           => array( array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => 'post-format-status',
									) )
							) );

						$statuses = new WP_Query( $query );

						if ( $statuses->have_posts() ) {

							$i = 0;

							if ( $speed ) {
								$out .= '<div class="wrap-status-shortcode' . esc_attr( $layout ) . '" data-time="' . esc_attr( $speed ) . '">';
							} else {
								$out .= '<div class="wrap-status-shortcode' . esc_attr( $layout ) . '">';
							}

							while ( $statuses->have_posts() ) :

								$statuses->the_post();

								$out .= '<div class="status-post status-post-' . esc_attr( get_the_ID() ) . ' item-' . esc_attr( $i++ ) . '">';
									$out .= '<div class="status">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
									$out .= ( $date ) ? ( '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date">' . esc_html( get_the_date() ) . ', ' . esc_html( get_the_time() ) . '</time>' ) : ( '' );
								$out .= '</div>';

							endwhile;

							$out .= '</div>';

						}

						wp_reset_query();

					if ( $speed ) {
						wp_enqueue_script( 'quovolver' );
					}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( $out ), $atts );
			}
		} // /wm_shortcode_status

		add_shortcode( 'status', 'wm_shortcode_status' );



		/**
		 * [subpages depth="1" order="menu" parents="0" /]
		 *
		 * Subpages list
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param depth   [# [0 = all levels, 1 = top level, 2+ = level depth]]
		 * @param order   [TEXT]
		 * @param parents [BOOLEAN]
		 */
		if ( ! function_exists( 'wm_shortcode_subpages' ) ) {
			function wm_shortcode_subpages( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'depth'   => 0,
						'order'   => 'menu',
						'parents' => false,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					global $post, $page_exclusions;

					$sort_by = array(
							'title' => 'post_title',
							'menu'  => 'menu_order',
						);

					$post         = ( is_home() ) ? ( get_post( get_option( 'page_for_posts' ) ) ) : ( $post );
					$parents      = ( $parents ) ? ( true ) : ( false );
					$parent_pages = ( isset( $post->ancestors ) && $parents ) ? ( $post->ancestors ) : ( null ); //get all parent pages in array
					$grandparent  = ( ! empty( $parent_pages ) ) ? ( end( $parent_pages ) ) : ( '' ); //get the first parent page (at the end of the array)
					$order        = ( in_array( trim( $order ), array_flip( $sort_by ) ) ) ? ( $sort_by[ trim( $order ) ] ) : ( 'menu_order' );
					$depth        = absint( $depth );

					$page_ids = get_all_page_ids();

					foreach ( $page_ids as $page_id ) {
						if ( ! wm_restriction_page( $page_id ) ) {
							$page_exclusions .= ( $page_exclusions ) ? ( ',' . $page_id ) : ( $page_id );
						}
					} // /foreach

					//Subpages or siblings
						if ( $grandparent ) {
							$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $grandparent . '&echo=0&depth=' . $depth );
						} else {
							$children = wp_list_pages( 'sort_column=' . $order . '&exclude=' . $page_exclusions . '&title_li=&child_of=' . $post->ID . '&echo=0&depth=' . $depth );
						}

						$out = ( $children ) ? ( '<ul class="sub-pages">' . str_replace( 'page_item', 'page_item icon-file', $children ) . '</ul>' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( $out ), $atts );
			}
		} // /wm_shortcode_subpages

		add_shortcode( 'subpages', 'wm_shortcode_subpages' );



		/**
		 * [testimonials category="123" count="5" speed="3" layout="large" order="random" private="1"  /]
		 *
		 * Testimonials
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param category [TESTIMONIALS CATEGORY ID OR SLUG [optional]]
		 * @param count    [# [number of testimonials to display]]
		 * @param layout   [normal/large/NONE]
		 * @param order    [new/old/random/NONE]
		 * @param private  [BOOLEAN [whether to display also private status posts]]
		 * @param speed    [# [time to display one testimonial in seconds]]
		 */
		if ( ! function_exists( 'wm_shortcode_testimonials' ) ) {
			function wm_shortcode_testimonials( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'category' => null,
						'count'    => 5,
						'layout'   => 'normal',
						'order'    => 'new',
						'private'  => false,
						'speed'    => 0,
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Requirements check
					if ( wm_option( 'blog-no-format-quote' ) || ! $category ) {
						return;
					}

				//Validation
					$out = '';

					$count    = absint( $count );
					$speed    = ( 1 < absint( $speed ) ) ? ( ' data-time="' . absint( $speed ) * 1000 . '"' ) : ( false );
					$layout   = ( 'large' == $layout ) ? ( ' large' ) : ( ' normal' );
					$order_by = array(
							'all'    => array( 'new', 'old', 'random' ),
							'new'    => array( 'date', 'DESC' ),
							'old'    => array( 'date', 'ASC' ),
							'random' => array( 'rand', '' )
						);
					$order    = ( in_array( $order, array_keys( $order_by ) ) ) ? ( $order_by[ $order ] ) : ( $order_by['new'] );
					$private  = ( ! $private ) ? ( 'publish' ) : ( array( 'publish', 'private' ) );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					//Get the Testimonials
						wp_reset_query();

						$query = array(
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

						$testimonials = new WP_Query( apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', $query, $atts ) );

						if ( $testimonials->have_posts() ) {

							$i = 0;

							$out .= '<div class="wrap-testimonials-shortcode' . esc_attr( $layout ) . '"' . $speed . '>';

							while ( $testimonials->have_posts() ) :

								$testimonials->the_post();

								$out_single = apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_custom_output', '', get_the_id(), $atts );

								if ( ! $out_single ) {

									$out_single .= '<blockquote class="testimonial testimonial-' . esc_attr( get_the_ID() ) . '">';

										if ( has_post_thumbnail() ) {
											$image_url   = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget' );
											$image_align = ( ' large' === $layout ) ? ( 'aligncenter' ) : ( 'alignleft' );
											$image_alt   = strip_tags( strip_shortcodes( wm_meta_option( 'quoted-author' ) ) );

											$out_single .= '<img src="' . esc_url( $image_url[0] ) . '" alt="' . esc_attr( $image_alt ) . '" title="' . esc_attr( $image_alt ) . '" class="' . esc_attr( $image_align ) . ' frame" />';
										}

										$quote = get_the_content();
										$quote = preg_replace( '/<blockquote(.*?)>/i', '', $quote ); //removes all <blockquote anyparameter>
										$quote = preg_replace( '/<\/blockquote>/i', '', $quote ); //removes all </blockquote>

										$out_single .= apply_filters( 'wm_default_content_filters', $quote );
										$out_single .= '<p class="mt0"><cite class="quote-source">&mdash; ' . wm_meta_option( 'quoted-author' ) . '</cite></p>';

									$out_single .= '</blockquote>';

								}

								$out .= apply_filters( 'wmhook_shortcode_' . $shortcode . '_single_item_output', $out_single, get_the_id(), $atts );

							endwhile;

							$out .= '</div>';

						}

						wp_reset_query();

					if ( $speed ) {
						wp_enqueue_script( 'quovolver' );
					}

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( $out ), $atts );
			}
		} // /wm_shortcode_testimonials

		add_shortcode( 'testimonials', 'wm_shortcode_testimonials' );





	/**
	 * 3.16 Pullquotes
	 */

		/**
		 * [pullquote align="left"]content[/pullquote]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param align [left/right/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_pullquote' ) ) {
			function wm_shortcode_pullquote( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'align' => 'left',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$aligns = array( 'left', 'right' );

					$align = ( in_array( trim( $align ), $aligns ) ) ? ( ' align' . trim( $align ) ) : ( ' alignleft' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<blockquote class="pullquote ' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '</blockquote>', $atts );
			}
		} // /wm_shortcode_pullquote

		add_shortcode( 'pullquote', 'wm_shortcode_pullquote' );





	/**
	 * 3.17 Raw code (pre HTML tag)
	 */

		/**
		 * [raw]content[/raw]
		 * [pre]content[/pre]
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_raw' ) ) {
			function wm_shortcode_raw( $atts, $content = null, $shortcode ) {
				//Validation
					$content = str_replace( '[', '&#91;', $content );
					$content = str_replace( array( '<p>', '</p>', '<br />', '<span class="br"></span>' ), '', $content );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<pre>' . esc_html( shortcode_unautop( $content ) ) . '</pre>', $atts );
			}
		} // /wm_shortcode_raw





	/**
	 * 3.18 Slideshow
	 */

		/**
		 * [slideshow group="123" images="imageUrl1, imageUrl2, imageUrl3" time="5"]
		 *
		 * Slideshow (slider)
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param group  [SLIDES CATEGORY ID]
		 * @param images [TEXT image URLs separated with commas]
		 * @param links  [TEXT image links URLs separated with commas]
		 * @param time   [#/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_slideshow' ) ) {
			function wm_shortcode_slideshow( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'category' => null,
						'group'    => null, //just a synonym for "category"
						'images'   => '',
						'links'    => '',
						'time'     => 5,
						'caption'  => 0,
						'align'	   => 'bottom',
						'background' => 'white',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$out      = '';

					$category = ( trim( $category ) ) ? ( trim( $category ) ) : ( trim( $group ) ); //if "group" set, make it category
					$images   = preg_replace( '/\s+/', '', $images );
					$images   = explode( ',', $images );

					$links    = preg_replace( '/\s+/', '', $links );
					$links    = explode( ',', $links );

					$time     = ( $time ) ? ( absint( $time ) * 1000 ) : ( 5000 );

					if ( $category ) {

						if ( is_numeric( $category ) ) {
							$category = absint( $category );
						} else {
							$category = get_term_by( 'slug', sanitize_title( $category ), 'slide-category' );
							$category = ( $category && isset( $category->term_id ) ) ? ( $category->term_id ) : ( null );
						}

					} else {

						$category = null;

					}

					if ( ! $category && empty( $images ) ) {
						return;
					}

					$image_size = 'content-width';

					$out .= '<div class="slideshow flexslider slideshow-category-' . esc_attr( $category ) . '" data-time="' . esc_attr( $time ) . '"><ul class="slides">';

					if ( $category ) {

						//get the slideshow images
						wp_reset_query();

						$slideshow = new WP_Query( (array) apply_filters( 'wmhook_shortcode_' . $shortcode . '_query', array(
								'post_type'           => 'wm_slides',
								'ignore_sticky_posts' => 1,
								'posts_per_page'      => -1,
								'tax_query'           => array( array(
										'taxonomy' => 'slide-category',
										'field'    => ( is_numeric( $category ) ) ? ( 'term_id' ) : ( 'slug' ),
										'terms'    => $category
									) )
							) ) );

						if ( $slideshow->have_posts() ) {

							while ( $slideshow->have_posts() ) :

								$slideshow->the_post();

								$style = ( wm_css_background_meta( 'slide-' ) ) ? ( ' style="' . wm_css_background_meta( 'slide-' ) . '"' ) : ( '' );

								$out .= '<li' . $style . '>';

								//Image
								$link = ( wm_meta_option( 'slide-link' ) ) ? ( esc_url( wm_meta_option( 'slide-link' ) ) ) : ( null );

								$out .= ( $link ) ? ( '<a href="' . esc_url( $link ) . '">' ) : ( '' );

								if ( has_post_thumbnail() ) {
									$image_id  = get_post_thumbnail_id();
									$image_url = wp_get_attachment_image_src( $image_id, $image_size );
									$out      .= '<img src="' . esc_url( $image_url[0] ) . '" alt="" />';
								}
								
								if ( get_the_content() && $caption ) {
									$layout = ( $align ) ? ( ' align'.$align ) : ( ' alignbottom' );
				
									$iconsColorClass = ( 'black' == $background ) ? ( ' light-icons' ) : ( ' dark-icons' );

									$out .= '<div class="wrap-caption">';
									$out .= '<div class="slider-caption-content">';
									$out .= '<div class="caption-inner bg-' . $background . $iconsColorClass . " column col-11 no-margin" . $layout . '"><div class="caption-inner-centered">';
									$out .= apply_filters( 'wm_default_content_filters',  get_the_content() );
									$out .= '</div></div></div>';
									$out .= '</div>';
								}

								$out .= ( $link ) ? ( '</a>' ) : ( '' );

								$out .= '</li>';

							endwhile;

						}

						wp_reset_query();

					} elseif ( ! empty ( $images ) ) {

						if ( 'gallery' === $images[0] ) {

							$post_id = ( isset( $images[1] ) ) ? ( absint( $images[1] ) ) : ( get_the_ID() );

							$images = $links = array();

							$images_array = wm_get_post_images( $post_id );

							$image_size      = ( wm_option( 'general-gallery-image-ratio' ) ) ? ( wm_option( 'general-gallery-image-ratio' ) ) : ( 'mobile-ratio-169' );
							$image_size_full = ( wm_option( 'general-lightbox-img' ) ) ? ( wm_option( 'general-lightbox-img' ) ) : ( 'full' );

							foreach ( $images_array as $image ) {

								$image_src      = wp_get_attachment_image_src( $image['id'], $image_size );
								$image_src_full = wp_get_attachment_image_src( $image['id'], $image_size_full );

								$images[] = $image_src[0];
								$links[]  = $image_src_full[0];

							} // /foreach

						}

						$i = 0;

						foreach ( $images as $image ) {

							$out .= '<li>';
							$out .= ( isset( $links[ $i ] ) && $links[ $i ] ) ? ( '<a href="' . esc_url( $links[ $i ] ) . '">' ) : ( '' );
							$out .= '<img src="' . esc_url( $image ) . '" alt="" />';
							$out .= ( isset( $links[ $i ] ) && $links[ $i ] ) ? ( '</a>' ) : ( '' );
							$out .= '</li>';

							$i++;

						} // /foreach

					}

					$out .= '</ul></div>';

					wp_enqueue_script( 'flex' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_slideshow

		add_shortcode( 'slideshow', 'wm_shortcode_slideshow' );





	/**
	 * 3.19 Social icons
	 */

		/**
		 * [social url="#" icon="" title="" size="" /]
		 *
		 * Social icons
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param icon  [PREDEFINED TEXT]
		 * @param rel   [TEXT]
		 * @param size  [s/m/l/xl/NONE]
		 * @param title [TEXT]
		 * @param url   [URL]
		 */
		if ( ! function_exists( 'wm_shortcode_social' ) ) {
			function wm_shortcode_social( $atts, $content = null, $shortcode ) {
				global $socialIconsArray;

				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'icon'  => '',
						'rel'   => '',
						'size'  => 'l',
						'title' => '',
						'url'   => '#',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$icon_type = '';

					$sizes = array(
							's'  => '16x16/',
							'm'  => '24x24/',
							'l'  => '32x32/',
							'xl' => '48x48/'
						);

					$size = ( trim( $size ) && in_array( trim( $size ), array_keys( $sizes ) ) ) ? ( $sizes[ trim( $size ) ] ) : ( '32x32/' );

					if ( trim( $icon ) && in_array( trim( $icon ), $socialIconsArray ) ) {

						$icon_type = trim( $icon );
						$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . trim( $icon ) . '.png';

					} else {

						foreach ( $socialIconsArray as $in_url => $type ) {

							$icon_type = $type;

							if ( false !== stripos( $url, $in_url ) ) {
								$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . $type . '.png';
								break;
							} else {
								$icon = WM_ASSETS_THEME . 'img/icons/social/' . $size . 'Facebook.png';
							}

						} // /foreach

					}

					$url = ( 'Skype' != $icon_type ) ? ( esc_url( $url ) ) : ( $url );
					$rel = ( $rel ) ? ( ' rel="' . esc_attr( $rel ) . '"' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<a href="' . $url . '" title="' . esc_attr( $title ) . '"' . $rel . ' class="icon-social" target="_blank"><img src="' . esc_url( $icon ) . '" alt="' . esc_attr( $title ) . '" /></a>', $atts );
			}
		} // /wm_shortcode_social

		add_shortcode( 'social', 'wm_shortcode_social' );





	/**
	 * 3.20 Split
	 */

		/**
		 * [section class="" style=""][/section]
		 *
		 * Sections page template split
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param class [PREDEFINED TEXT]
		 * @param style [TEXT]
		 */
		if ( ! function_exists( 'wm_shortcode_section' ) ) {
			function wm_shortcode_section( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'class' => '',
						'style' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$class_first = ( trim( $class ) ) ? ( explode( ' ', trim( esc_attr( $class ) ) ) ) : ( '' );
					$id          = ( isset( $class_first[0] ) && $class_first[0] && 'alt' != $class_first[0] ) ? ( ' id="section-' . esc_attr( sanitize_html_class( $class_first[0] ) ) . '"' ) : ( '' );
					$style       = ( trim( $style ) ) ? ( ' style="' . trim( esc_attr( $style ) ) . '"' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', "\r\n" . '<section class="wrap-section ' . esc_attr( trim( $class ) ) . '"' . $id . $style . '><div class="wrap-inner"><div class="twelve pane">' . do_shortcode( $content ) . '</div></div></section>' . "\r\n", $atts );
			}
		} // /wm_shortcode_section

		add_shortcode( 'section', 'wm_shortcode_section' );





	/**
	 * 3.21 Table
	 */

		/**
		 * [table class="css-class" cols="" data="" separator="" heading_col=""]content[/table]
		 *
		 * Table
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param class       [TEXT]
		 * @param cols        [TEXT (heading cells separated by separator)]
		 * @param data        [TEXT (table cells separated by separator)]
		 * @param heading_col [# (styles the # cell in the row as heading)]
		 * @param separator   [TEXT (separator character)]
		 */
		if ( ! function_exists( 'wm_shortcode_table' ) ) {
			function wm_shortcode_table( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'class'       => '',
						'cols'        => '',
						'data'        => '',
						'heading_col' => 0,
						'separator'   => ';',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$class = ( trim( $class ) ) ? ( ' class="' . esc_attr( $class ) . '"' ) : ( '' );
					$data  = trim( $data );

				//Output
					if ( $cols && $data ) {

						$cols       = explode( $separator, $cols );
						$data       = explode( $separator, $data );
						$cols_count = count( $cols );

						$heading_col = ( $heading_col ) ? ( absint( $heading_col ) ) : ( -1 );
						$heading_col = ( -1 < $heading_col && $cols_count <= $heading_col ) ? ( 0 ) : ( $heading_col );

						$out  = '<table' . $class . '>';

						if ( ! empty( $cols ) ) {
							$out_column = '';

							$i = 0;

							foreach ( $cols as $col ) {
								if ( $col ) {
									$out_column .= '<th class="table-column-' . esc_attr( ++$i ) . '">' . $col . '</th>';
								}
							} // /foreach

							$out .= ( $out_column ) ? ( '<thead><tr class="table-row-0">' . $out_column . '</tr></thead>' ) : ( '' );
						}

						if ( ! empty( $data ) ) {
							$out .= '<tbody>';

							$i = $j = 0;

							$class = ' alt';

							foreach ( $data as $cell ) {
								$i++;

								$cell_number = $i % $cols_count;

								if ( 1 === $i % $cols_count ) {
									if ( ' alt' === $class ) {
										$class = '';
									} else {
										$class = ' alt';
									}
									$out .= '<tr class="table-row-' . esc_attr( ++$j . $class ) . '">';
								}

								if ( 0 === $i % $cols_count ) {
									$cell_number = $cols_count;
								}

								if ( -1 < $heading_col && ( $heading_col === $i % $cols_count ) ) {
									$out .= '<th class="table-column-' . esc_attr( $cell_number ) . ' text-left">' . $cell . '</th>';
								} else {
									$out .= '<td class="table-column-' . esc_attr( $cell_number ) . '">' . $cell . '</td>';
								}

								if ( 0 === $i % $cols_count ) {
									$out .= '</tr>';
								}
							} // /foreach

							$out .= '</tbody>';
						}

						$out .= '</table>';

					} else {

						$out = '<table' . $class . '>' . do_shortcode( $content ) . '</table>';

					}

					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_table

		add_shortcode( 'table', 'wm_shortcode_table' );



		/**
		 * [trow]content[/trow]
		 *
		 * Table row
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_table_row' ) ) {
			function wm_shortcode_table_row( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<tr>' . do_shortcode( $content ) . '</tr>', $atts );
			}
		} // /wm_shortcode_table_row

		add_shortcode( 'trow', 'wm_shortcode_table_row' );



		/**
		 * [trow_alt]content[/trow_alt]
		 *
		 * Table row altered
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_table_row_alt' ) ) {
			function wm_shortcode_table_row_alt( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<tr class="alt">' . do_shortcode( $content ) . '</tr>', $atts );
			}
		} // /wm_shortcode_table_row_alt

		add_shortcode( 'trow_alt', 'wm_shortcode_table_row_alt' );



		/**
		 * [tcell]content[/tcell]
		 *
		 * Table cell
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_table_cell' ) ) {
			function wm_shortcode_table_cell( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<td>' . do_shortcode( $content ) . '</td>', $atts );
			}
		} // /wm_shortcode_table_cell

		add_shortcode( 'tcell', 'wm_shortcode_table_cell' );



		/**
		 * [tcell_heading]content[/tcell_heading]
		 *
		 * Table heading cell
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_table_cell_heading' ) ) {
			function wm_shortcode_table_cell_heading( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<th>' . do_shortcode( $content ) . '</th>', $atts );
			}
		} // /wm_shortcode_table_cell_heading

		add_shortcode( 'tcell_heading', 'wm_shortcode_table_cell_heading' );





	/**
	 * 3.22 Tabs
	 */

		/**
		 * [tabs type="fullwidth"]content[/tabs]
		 *
		 * Tabs wrapper
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param type [vertical/fullwidth/vertical tour/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_tabs' ) ) {
			function wm_shortcode_tabs( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'type' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$types = array( 'vertical', 'vertical tour', 'fullwidth' );

					$type = ( in_array( trim( $type ), $types ) ) ? ( ' ' . trim( $type ) ) : ( ' normal' );

				//Output
					$out = '<div class="tabs-wrapper' . esc_attr( $type ) . '"><ul>' . do_shortcode( $content ) . '</ul></div>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_tabs

		add_shortcode( 'tabs', 'wm_shortcode_tabs' );



		/**
		 * [tab title="Tab title"]content[/tab]
		 *
		 * Tab item/content
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param title [TEXT]
		 */
		if ( ! function_exists( 'wm_shortcode_tab' ) ) {
			function wm_shortcode_tab( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'title' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					if ( ! trim( $title ) ) {
						return;
					}

					$title = strip_tags( trim( $title ), '<img><strong><span><small><em><b><i>' );

				//Output
					$out = '<li><h3 class="tab-heading">' . $title . '</h3>' . do_shortcode( $content ) . '</li>';
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', $out, $atts );
			}
		} // /wm_shortcode_tab

		add_shortcode( 'tab', 'wm_shortcode_tab' );





	/**
	 * 3.23 Text
	 */

		/**
		 * [big_text]Text[/big_text]
		 *
		 * Big text
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_big_text' ) ) {
			function wm_shortcode_big_text( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( '<span class="size-big">' . $content . '</span>' ), $atts );
			}
		} // /wm_shortcode_big_text

		add_shortcode( 'big_text', 'wm_shortcode_big_text' );



		/**
		 * [huge_text]Text[/huge_text]
		 *
		 * Huge text
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_huge_text' ) ) {
			function wm_shortcode_huge_text( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( '<span class="size-huge">' . $content . '</span>' ), $atts );
			}
		} // /wm_shortcode_huge_text

		add_shortcode( 'huge_text', 'wm_shortcode_huge_text' );



		/**
		 * [small_text]Text[/small_text]
		 *
		 * Small text
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_small_text' ) ) {
			function wm_shortcode_small_text( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( '<small>' . $content . '</small>' ), $atts );
			}
		} // /wm_shortcode_small_text

		add_shortcode( 'small_text', 'wm_shortcode_small_text' );



		/**
		 * [uppercase]Text[/uppercase]
		 *
		 * Uppercase
		 *
		 * @since    1.0
		 * @version  3.0
		 */
		if ( ! function_exists( 'wm_shortcode_uppercase' ) ) {
			function wm_shortcode_uppercase( $atts, $content = null, $shortcode ) {
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( '<span class="uppercase">' . $content . '</span>' ), $atts );
			}
		} // /wm_shortcode_uppercase

		add_shortcode( 'uppercase', 'wm_shortcode_uppercase' );



		/**
		 * [yes color="colored" /]
		 *
		 * Yes icon
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param color [black/white/green/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_yes' ) ) {
			function wm_shortcode_yes( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'color' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors = array(
							'black'   => WM_ASSETS_THEME . 'img/icons/yes-no/yes-black.png',
							'colored' => WM_ASSETS_THEME . 'img/icons/yes-no/yes-colored.png',
							'white'   => WM_ASSETS_THEME . 'img/icons/yes-no/yes-white.png',
						);

					$icon = ( trim( $color ) && in_array( trim( $color ), array_keys( $colors ) ) ) ? ( $colors[ trim( $color ) ] ) : ( WM_ASSETS_THEME . 'img/icons/yes-no/yes-black.png' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<img src="' . esc_url( $icon ) . '" alt="" />', $atts );
			}
		} // /wm_shortcode_yes

		add_shortcode( 'yes', 'wm_shortcode_yes' );



		/**
		 * [no color="colored" /]
		 *
		 * No icon
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param color [black/white/green/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_no' ) ) {
			function wm_shortcode_no( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'color' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors = array(
							'black'   => WM_ASSETS_THEME . 'img/icons/yes-no/no-black.png',
							'colored' => WM_ASSETS_THEME . 'img/icons/yes-no/no-colored.png',
							'white'   => WM_ASSETS_THEME . 'img/icons/yes-no/no-white.png',
						);

					$icon = ( trim( $color ) && in_array( trim( $color ), array_keys( $colors ) ) ) ? ( $colors[ trim( $color ) ] ) : ( WM_ASSETS_THEME . 'img/icons/yes-no/no-black.png' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<img src="' . esc_url( $icon ) . '" alt="" />', $atts );
			}
		} // /wm_shortcode_no

		add_shortcode( 'no', 'wm_shortcode_no' );





	/**
	 * 3.24 Toggles
	 */

		/**
		 * [toggle title="Toggle title" open="1"]content[/toggle]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param open  [BOOLEAN/NONE]
		 * @param title [TEXT, required]
		 */
		if ( ! function_exists( 'wm_shortcode_toggle' ) ) {
			function wm_shortcode_toggle( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'open'  => false,
						'title' => '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					if ( ! trim( $title ) ) {
						return;
					}

					$title = strip_tags( trim( $title ), '<img><strong><span><small><em><b><i>' );
					$open  = ( $open ) ? ( ' active' ) : ( '' );

				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', '<div class="toggle-wrapper' . esc_attr( $open ) . '"><h3 class="toggle-heading">' . $title . '</h3>' . wpautop( do_shortcode( $content ) ) . '</div>', $atts );
			}
		} // /wm_shortcode_toggle

		add_shortcode( 'toggle', 'wm_shortcode_toggle' );





	/**
	 * 3.25 Widgets
	 */

		/**
		 * [widgets area="default" style="" /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @uses  wm_sidebar( $defaultSidebar, $class, $restrictCount, $print )
		 *
		 * @param area  [widget area ID]
		 * @param style [vertical/horizontal/sidebar-left/sidebar-right/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_widget_area' ) ) {
			function wm_shortcode_widget_area( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'area'  => '',
						'style' => 'horizontal',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$areas   = array_flip( wm_widget_areas() );
					$layouts = array(
							'horizontal'    => 'columns',
							'vertical'      => 'vertical',
							'sidebar-left'  => 'sidebar sidebar-left',
							'sidebar-right' => 'sidebar sidebar-right'
						);

					$area  = ( in_array( trim( $area ), $areas ) && trim( $area ) ) ? ( trim( $area ) ) : ( '' );
					$class = ( in_array( trim( $style ), array_flip( $layouts ) ) ) ? ( $layouts[ trim( $style ) ] ) : ( 'columns' );
					$count = ( 'horizontal' != $class ) ? ( null ) : ( 5 );

				//Output
					if ( function_exists( 'wm_sidebar' ) && $area ) {
						return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', wm_sidebar( $area, $class, $count, false ), $atts );
					}
			}
		} // /wm_shortcode_widget_area

		add_shortcode( 'widgets', 'wm_shortcode_widget_area' );
	/**
	 * 3.26 Map - added by TIRIA
	 */

		/**
		 * [map /]
		 *
		 * @since    1.0
		 * @version  3.0
		 *
		 * @param height		[height with px or %]
		 * @param width			[width with px or %]
		 * @param lat			[latitude]
		 * @param long			[longitude]
		 * @param invert		[BOOLEAN]
		 * @param zoom			[1-16]
		 * @param style			[theme|nopoi|notext|default]
		 * @param info			[STRING]
		 * @param marker		[true|false|bounce]
		 * @param saturation	[0-100]
		 */
		 
		if ( ! function_exists( 'wm_shortcode_mgmap' ) ) {
			function wm_shortcode_mgmap( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
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
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );
				
				$width = (substr($width,-1,1)=='%' || substr($width,-2,2)=='px') ? $width : $width.'px';
				$height = (substr($height,-1,1)=='%' || substr($height,-2,2)=='px') ? $height : $height.'px';
				
				$out = '<div id="mgmap" class="map" style="height:' . $height . '; width:' . $width . ';"></div>';
				$out .= '<script>var mapName="' . __( 'Custom', 'clifden_domain' ) . '", mapStyle="' . $style . '", mapZoom=' . intval( 2 + $zoom ) . ', mapLat=' . $lat . ', mapLong=' . $long . ', mapMarker="' . $marker . '", mapInfo="' . str_replace( '"', '\"',$info) . '", mapCenter=0, mapInvert=' . $invert . ', mapSat=' . $saturation . ', themeImgs="' . WM_ASSETS_THEME . 'img/";</script>';
				wp_enqueue_script('gmap-infobox');
				wp_enqueue_script('mgmap');
				
				return $out;
			}
		} // /wm_shortcode_mgmap
		
		add_shortcode( 'mgmap', 'wm_shortcode_mgmap' );
	
	/**
	 * 3.26 Class styles - added by TIRIA
	 */
		
		/**
		 * [styles color="green" class="myclass" type="p"]content[/styles]
		 *
		 * @since    1.0
		 * @version  3.0
		 * @param color     [orange/blue/grey/dark-grey/white/NONE]
		 * @param class   	[string/NONE]
		 * @param type   	[p/h1/h2/h3/h4/h5/h6/span/div/section/NONE]
		 */
		if ( ! function_exists( 'wm_shortcode_styles' ) ) {
			function wm_shortcode_styles( $atts, $content = null, $shortcode ) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'color' 	=> '',
						'background'=> '',
						'class' 	=> '',
						'type'		=> 'p',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );

				//Validation
					$colors = array( 'orange', 'blue', 'grey', 'dark-grey', 'white' );
					$types = array( 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'section' );

					$color = ( in_array( trim( $color ), $colors ) ) ? ( ' color-' . esc_attr( trim( $color ) ) ) : ( '' );

					$background = ( in_array( trim( $background ), $colors ) ) ? ( ' ' . esc_attr( trim( $background ) ) . '-bg' ) : ( '' );

					$class = (esc_attr( $class ) != '') ?  esc_attr( trim( $class )) : '';
					
					$type = ( in_array( trim( $type ), $types ) ) ? esc_attr( trim( $type )) : '';
						
				//Output
					return apply_filters( 'wmhook_shortcode_' . $shortcode . '_output', do_shortcode( '<' . $type . ' class="' . $class . $color . $background . '">' .  $content . '</' . $type . '>'), $atts );
			}
		} // /wm_shortcode_marker

		add_shortcode( 'styles', 'wm_shortcode_styles' );
	
	/**
	 * 3.26 Mail protection - added by TIRIA
	 */
	
		/*
		* [mailprotect mail="" link=""]content[/mailprotect]
		*
		* mail      = STRING email address to protect
		* link 		= BOOLEAN/NONE
		* class 	= STRING/NONE additionnal class to add
		*/
		if ( ! function_exists( 'wm_shortcode_mailprotect' ) ) {
			function wm_shortcode_mailprotect( $atts, $content = null, $shortcode) {
				$defaults = apply_filters( 'wmhook_shortcode_defaults', array(
						'mail'      => '',
						'link'		=> true,
						'class'		=> '',
					), $shortcode );
				$atts = apply_filters( 'wmhook_shortcode_attributes', $atts, $shortcode );
				extract( shortcode_atts( $defaults, $atts, $shortcode ) );
				
				if(filter_var($mail,FILTER_VALIDATE_EMAIL)!==false){
					$mail=str_replace(array('.','@'),array('/','[at]'),$mail);
					$mail=strrev($mail);
					$block = ($link) ? 'a' : 'span';
					$data_address = ($link) ? ' data-address="'.$mail.'"' : '';
					return '<' . $block . ' class="email-nospam ' . $class . '"' . $data_address . '>' . $mail . '</' . $block . '>';
				}
				else return '';
			}
		} // /wm_shortcode_mailprotect
		add_shortcode( 'mailprotect', 'wm_shortcode_mailprotect' );
		
		
?>