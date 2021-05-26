<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Form generator
*
* CONTENT:
* - 1) Form element switch
* - 2) Helper funcions
* - 3) Form generator functions
* - 3.1) Sections and tabs
* - 3.2) Basic form elements
* - 3.3) Advanced form elements
* - 3.4) Text elements
*****************************************************
*/






/*
*****************************************************
*      1) FORM ELEMENT SWITCH
*****************************************************
*/
	/*
	* Render switcher
	*
	* $options = ARRAY [array of options to generate form from]
	* $isMeta  = TEXT [if set to "meta", generates post meta form styles, else generates admin panel form styles]
	*/
	if ( ! function_exists( 'wm_render_form' ) ) {
		function wm_render_form( $options, $isMeta = null, $pageTpl = null ) {
			//Rendering form according to $options ARRAY (for meta boxes use $isMeta = 'meta'
			if ( isset( $options ) && is_array( $options ) && ! empty( $options ) ) {

				foreach ( $options as $value ) {
					switch ( $value['type'] ) {

						//sections and tabs
						case 'section-open':
							wm_form_section_open( $value, $isMeta, $pageTpl );
						break;
						case 'section-close':
							wm_form_section_close();
						break;
						case 'sub-section-open':
							wm_form_sub_section_open( $value );
						break;
						case 'sub-section-close':
							wm_form_sub_section_close();
						break;
						case 'inside-wrapper-open':
							wm_form_inside_wrapper_open( $value );
						break;
						case 'inside-wrapper-close':
							wm_form_inside_wrapper_close( $value );
						break;
						case 'inside-tabs':
							wm_form_inside_tabs( $value );
						break;
						case 'sub-tabs':
							wm_form_sub_tabs( $value );
						break;

						//basic form elements
						case 'text':
							wm_form_text( $value, $isMeta );
						break;
						case 'textarea':
							wm_form_textarea( $value, $isMeta );
						break;
						case 'select':
							wm_form_select( $value, $isMeta );
						break;
						case 'radio':
							wm_form_radio( $value, $isMeta );
						break;
						case 'checkbox':
							wm_form_checkbox( $value, $isMeta );
						break;
						case 'hidden':
							wm_form_hidden( $value, $isMeta );
						break;

						//advanced form elements
						case 'settingsExporter':
							wm_form_settings_exporter( $value );
						break;
						case 'settingsExporterJSON':
							wm_form_settings_exporter_JSON( $value );
						break;
						case 'skins':
							wm_form_skins( $value, $isMeta );
						break;
						case 'skins-json':
							wm_form_skins_json( $value, $isMeta );
						break;
						case 'layouts':
							wm_form_layouts( $value, $isMeta );
						break;
						case 'patterns':
							wm_form_patterns( $value, $isMeta );
						break;
						case 'color':
							wm_form_color( $value, $isMeta );
						break;
						case 'image':
							wm_form_image( $value, $isMeta );
						break;
						case 'audio':
							wm_form_audio( $value, $isMeta );
						break;
						case 'video':
							wm_form_video( $value, $isMeta );
						break;
						case 'additems':
							wm_form_additems( $value, $isMeta );
						break;
						case 'slider':
							wm_form_slider( $value, $isMeta );
						break;
						case 'datepicker':
							wm_form_datepicker( $value, $isMeta );
						break;

						//text elements
						case 'intro':
							wm_form_intro( $value );
						break;
						case 'heading3':
							wm_form_heading3( $value );
						break;
						case 'heading4':
							wm_form_heading4( $value );
						break;
						case 'paragraph':
							wm_form_paragraph( $value );
						break;
						case 'ulist':
							wm_form_ulist( $value );
						break;
						case 'box':
							wm_form_box( $value );
						break;
						case 'info':
							wm_form_info( $value );
						break;
						case 'warning':
							wm_form_warning( $value );
						break;
						case 'help':
							wm_form_help( $value );
						break;
						case 'space':
							wm_form_br();
						break;
						case 'hr':
							wm_form_hr();
						break;
						case 'hrtop':
							wm_form_hrtop();
						break;

						default:
						break;
					} // /switch
				} // /foreach

			}
			return;
		}
	} // /wm_form_generator






/*
*****************************************************
*      2) HELPER FUNCTIONS
*****************************************************
*/
	/*
	* Generates custom posts meta tabs and fields
	*
	* $options = ARRAY [array of options to generate form from]
	* $tabs    = TEXT [if set, displays tabbed ui]
	*/
	if ( ! function_exists( 'wm_cp_meta_form_generator' ) ) {
		function wm_cp_meta_form_generator( $options, $tabs = null, $confirmLink = false ) {
			if ( ! isset( $options ) || ! is_array( $options ) || empty( $options ) )
				return;

			$out = '<div class="wm-wrap meta no-js' . ( ( $tabs ) ? ( ' jquery-ui-tabs' ) : ( '' ) ) . '">';

			if ( $tabs ) {
				//Tabs
				$out .= '<ul class="tabs no-js">';
				$i = 0;
				foreach ( $options as $tab ) {
					if ( 'section-open' == $tab['type'] ) {
						++$i;
						$out .= '<li class="item-' . $i . ' ' . $tab['section-id'] . '"><a href="#wm-meta-' . $tab['section-id'] . '">' . $tab['title'] . '</a></li>';
					}
				}
				$out .= '</ul> <!-- /tabs -->';
			}

			echo $out;

			//Content
			wm_render_form( $options, 'meta' );

			if ( $confirmLink )
				echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'clifden_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'clifden_domain_adm' ) . '</a></div>';

			echo '</div> <!-- /wm-wrap -->';
		}
	} // /wm_cp_meta_form_generator



	/*
	* Generates JS for conditional option display
	*
	* $value = ARRAY [current option value array]
	* $valId = TEXT [current option value id]
	*
	* To change checked element from select to input use: "custom" => array( "input", "name", "radio" )
	*/
	if ( ! function_exists( 'wm_conditional_show' ) ) {
		function wm_conditional_show( $value, $valId ) {
			if ( isset( $value['conditional'] ) ) :
				$operator = ( isset( $value['conditional']['type'] ) && 'not' == $value['conditional']['type'] ) ? ( '' ) : ( '-1 <' );
			?>
			<script><!--
			jQuery(function() {
				var valuesArray = [<?php

				$inArray   = explode( ',', $value['conditional']['value'] );
				$separator = '';

				foreach ( $inArray as $jsArray ) {
					echo $separator . "'" . $jsArray . "'";
					$separator = ', ';
				}

				if ( isset( $value['conditional']['custom'] ) && $value['conditional']['custom'] )
					$element = $value['conditional']['custom'][0] . '[' . $value['conditional']['custom'][1] . '="' . $value['conditional']['field'] . '"]';
				elseif ( isset( $value['conditional']['hidden'] ) )
					$element = 'input[id="' . $value['conditional']['field'] . '"]';
				else
					$element = 'select[id*="' . $value['conditional']['field'] . '"]';

				?>],
				    conditionalField = jQuery( '<?php echo $element; ?>' ),
				    <?php
						//if used in Admin Panel, set also 'admin-panel'
						if ( isset( $value['conditional']['admin-panel'] ) ) {
						//JS used in Admin Panel
							?>
							conditionalOption = jQuery( 'div[data-option="<?php echo $valId; ?>"]' ).addClass('hide'),
							<?php
						} else {
						//JS used in meta options
							?>
							conditionalOption = jQuery( 'div[data-option="<?php echo $valId; ?>"]' ).hide(),
							<?php
						} // /admin panel?
						?>
				    efectSpeed = 250;

				<?php
				//if used in Admin Panel, set also 'admin-panel'
				if ( isset( $value['conditional']['admin-panel'] ) ) {
				//JS used in Admin Panel
					?>
					//default set
					if ( <?php echo $operator; ?> jQuery.inArray( conditionalField.val(), valuesArray ) )
						conditionalOption.removeClass('hide');
					else
						conditionalOption.addClass('hide');

					//after value change
					conditionalField.change( function() {
						var conditionalValue = jQuery( this ).val();

						if ( <?php echo $operator; ?> jQuery.inArray( conditionalValue, valuesArray ) )
							conditionalOption.removeClass('hide');
						else
							conditionalOption.addClass('hide');
					} );
					<?php
				} else {
				//JS used in meta options
					?>
					<?php
					if (
						isset( $value['conditional']['custom'][2] ) &&
						( 'radio' == $value['conditional']['custom'][2] || 'checkbox' == $value['conditional']['custom'][2] )
						) {
						?>
						//default set
						if ( <?php echo $operator; ?> jQuery.inArray( jQuery( '<?php echo $element; ?>:checked' ).val(), valuesArray ) )
							conditionalOption.slideDown( efectSpeed );
						else
							conditionalOption.slideUp( efectSpeed );
						<?php
					}
					?>

					conditionalField.change( function() {
						var $this = jQuery( this ),
						    conditionalValue = $this.val();

						<?php
						if ( isset( $value['conditional']['custom'][2] ) && 'checkbox' == $value['conditional']['custom'][2] )
							$compare = '$this.is(":checked")';
						else
							$compare = $operator . " jQuery.inArray( conditionalValue, valuesArray )";
						?>

						if ( <?php echo $compare; ?> )
							conditionalOption.slideDown( efectSpeed );
						else
							conditionalOption.slideUp( efectSpeed );
					} );
					<?php
				} // /admin panel?
				?>
			});
			//--></script>
			<?php
			 //jQuery slideIn / slideOut animation doesn't properly work in IE7 so consider using fadeIn / hide
			endif;
		}
	} // /wm_conditional_show





/*
*****************************************************
*      3) FORM GENERATOR FUNCTIONS
*****************************************************
*/

	/*
	*****************************************************
	*      3.1) SECTIONS AND TABS
	*****************************************************
	*/
		/*
		* Available section icons (use section-id): contact, cta, design, general, home, langs, layout, links, media, pages, security, seo, slider, blog
		* Every section has to contain at least one subtab and a subsection.
		*/

		/*
		* SECTION OPEN
		*
		* "type" => "section-open"
		* "section-id" => "ID"
		* "title" => "TEXT" // just informative
		* "exclude" => "ARRAY" // array of page templates, where the section is not displayed
		* "onlyfor" => "ARRAY" // array of page templates, where the section is displayed
		*/
		if ( ! function_exists( 'wm_form_section_open' ) ) {
			function wm_form_section_open( $value, $isMeta = null, $pageTpl = null ) {
				if ( 'meta' == $isMeta ) {
					$id = 'wm-meta-' . $value['section-id'];
				} else {
					$id = 'set-' . $value['section-id'];
				}

				if ( $isMeta && isset( $value['onlyfor'] ) )
					$hide = ( in_array( $pageTpl, $value['onlyfor'] ) ) ? ( '' ) : ( ' hide' );
				elseif ( $isMeta && isset( $value['exclude'] ) )
					$hide = ( in_array( $pageTpl, $value['exclude'] ) ) ? ( ' hide' ) : ( '' );
				else
					$hide = '';
				?>

				<!-- SECTION -->
				<div id="<?php echo $id; ?>" class="tab-content<?php echo $hide; ?>">
				<?php
				if (
					$isMeta &&
					(
						( isset( $value['onlyfor'] ) && is_array( $value['onlyfor'] ) ) ||
						( isset( $value['exclude'] ) && is_array( $value['exclude'] ) )
					)
					) {
					$arrayForJS = ( isset( $value['onlyfor'] ) ) ? ( '"' . implode( '", "', $value['onlyfor'] ) . '"' ) : ( '"' . implode( '", "', $value['exclude'] ) . '"' );
					$addition   = ucfirst( str_replace( '-', '', $id ) );
					$condition  = 'jQuery.inArray( conditionalValue' . $addition . ', conditionArray' . $addition;
					if ( isset( $value['onlyfor'] ) )
						$condition  = '-1 != ' . $condition;
					else
						$condition  = '-1 === ' . $condition;
				?>
					<script><!--
						jQuery(function(){
							conditionArray<?php echo $addition; ?> = [ <?php echo $arrayForJS; ?> ];

							jQuery( 'select[name="page_template"]' ).change( function() {
								conditionalValue<?php echo $addition; ?> = jQuery( this ).val();

								if ( <?php echo $condition; ?> ) ) {
									jQuery( '#<?php echo $id; ?>' ).removeClass( 'hide' );
									jQuery( '.wm-wrap .tabs a[href="#<?php echo $id; ?>"]' ).parent().removeClass( 'hide' );
								} else {
									jQuery( '#<?php echo $id; ?>' ).addClass( 'hide' );
									jQuery( '.wm-wrap .tabs a[href="#<?php echo $id; ?>"]' ).parent().addClass( 'hide' );
								}

								firstTabActive = jQuery( '.wm-wrap .tabs li:not(.hide)' ).first().index();

								if ( jQuery().tabs )
									jQuery( '.wm-wrap.jquery-ui-tabs' ).tabs( { active: firstTabActive } );
							} );
						});
					//--></script>
				<?php
				}
			}
		} // /wm_form_section_open



		/*
		* SECTION CLOSE
		*
		* "type" => "section-close"
		*/
		if ( ! function_exists( 'wm_form_section_close' ) ) {
			function wm_form_section_close() {
				?>
				</div> <!-- /tab-content -->
				<!-- /SECTION -->

				<?php
			}
		} // /wm_form_section_close



		/*
		* SUB SECTION OPEN
		*
		* "type" => "sub-section-open"
		* "sub-section-id" => "ID-#"
		* "title" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_sub_section_open' ) ) {
			function wm_form_sub_section_open( $value ) {
				?>
				<!-- Sub section (tab content) -->
				<div id="set-<?php echo $value['sub-section-id']; ?>" class="tab-content sub">
				<?php
			}
		} // /wm_form_sub_section_open



		/*
		* SUB SECTION CLOSE
		*
		* "type" => "sub-section-close"
		*/
		if ( ! function_exists( 'wm_form_sub_section_close' ) ) {
			function wm_form_sub_section_close() {
				echo '</div> <!-- /tab-content sub -->';
			}
		} // /wm_form_sub_section_close



		/*
		* INSIDE WRAPPER OPEN
		*
		* "type" => "inside-wrapper-open"
		* "id" => "ID"
		* "class" => "CSSCLASS"
		*/
		if ( ! function_exists( 'wm_form_inside_wrapper_open' ) ) {
			function wm_form_inside_wrapper_open( $value ) {
				$valId = WM_THEME_SETTINGS_PREFIX . 'container-' . $value['id'];
				$class = ( isset( $value['class'] ) ) ? ( ' ' . $value['class'] ) : ( '' );
				?>
				<!-- CONTAINER -->
				<div class="option container<?php echo $class; ?>" data-option="<?php echo $valId; ?>">
				<?php
			}
		} // /wm_form_inside_wrapper_open



		/*
		* INSIDE WRAPPER CLOSE
		*
		* "type" => "inside-wrapper-close"
		* "id" => "ID" [must be the same as in inside-wrapper-open]
		*/
		if ( ! function_exists( 'wm_form_inside_wrapper_close' ) ) {
			function wm_form_inside_wrapper_close( $value ) {
				$valId = WM_THEME_SETTINGS_PREFIX . 'container-' . $value['id'];
				echo '</div> <!-- /option /container -->';
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_inside_wrapper_close



		/*
		* INSIDE TABS
		*
		* "type" => "inside-tabs"
		* "tabs" => "ARRAY" [one dimensional array of tabs titles]
		*
		* Has to be followed by the count(ARRAY("tabs")) of inside wrappers with "class"="inside-tab-content".
		*/
		if ( ! function_exists( 'wm_form_inside_tabs' ) ) {
			function wm_form_inside_tabs( $value ) {
				$tabs = '';
				if ( is_array( $value['tabs'] ) && ! empty( $value['tabs'] ) ) {
					foreach ( $value['tabs'] as $tab ) {
						$tabs .= '<li><a href="#">' . $tab . '</a></li>';
					}
				}
				if ( $tabs )
					echo '<ul class="inside-tabs">' . $tabs . '</ul>';
			}
		} // /wm_form_inside_tabs



		/*
		* SUB TABS
		*
		* "type" => "sub-tabs"
		* "parent-section-id" => "ID"
		* "list" => array( "TABTITLE", "TABTITLE" )
		*/
		if ( ! function_exists( 'wm_form_sub_tabs' ) ) {
			function wm_form_sub_tabs( $value ) {
				?>
				<!-- Sub tabs -->
				<ul class="tabs sub">
					<?php
					$parrentSection = strip_tags( $value['parent-section-id'] );
					$i = 0;
					if ( isset( $value['list'] ) && is_array( $value['list'] ) && ! empty( $value['list'] ) ) {
						foreach ( $value['list'] as $subTab ) {
							$i++;
							?>
							<li class="item-<?php echo $i; ?> <?php echo $parrentSection; ?>-<?php echo $i; ?>">
								<a href="#set-<?php echo $parrentSection; ?>-<?php echo $i; ?>"><?php echo $subTab; ?></a>
							</li>
							<?php
						}
					}
					?>
				</ul> <!-- /sub tabs -->
				<?php
			}
		} // /wm_form_sub_tabs






	/*
	*****************************************************
	*      3.2) BASIC FORM ELEMENTS
	*****************************************************
	*/
		/*
		* TEXT
		*
		* "type" => "text"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "TEXT"
		* "size" => "#"
		* "maxlength" => "#"
		* "class" => "TEXT"
		* "empty" => "BOOLEAN"
		*/
		if ( ! function_exists( 'wm_form_text' ) ) {
			function wm_form_text( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default   = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				$size      = ( isset( $value['size'] ) ) ? ( absint( $value['size'] ) ) : ( null );
				$maxlength = ( isset( $value['maxlength'] ) ) ? ( absint( $value['maxlength'] ) ) : ( null );
				$settings  = ( $maxlength > 0 ) ? ( 'size="' . $size . '" maxlength="' . $maxlength . '"' ) : ( '' );
				$class     = ( isset( $value['class'] ) ) ? ( ' class="' . esc_attr( $value['class'] ) . '"' ) : ( '' );
				?>
				<!-- Text input -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<?php if ( $default ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p>
					<input type="text" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php
					if ( isset( $value['validate'] ) && 'url' == $value['validate'] )
						$out = esc_url( $val );
					elseif ( isset( $value['validate'] ) && 'absint' == $value['validate'] )
						$out = absint( $val );
					else
						$out = esc_attr( $val );

					if ( $val || ( isset( $value['empty'] ) && $value['empty'] ) )
						echo esc_html( $out );
					else
						echo $default;
					?>" <?php echo $settings; echo $class; ?>/>
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_text



		/*
		* TEXTAREA
		*
		* "type" => "textarea"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "TEXT",
		* "cols" => #,
		* "rows" => #,
		* "class" => "TEXT"
		* "empty" => "BOOLEAN"
		* "editor" => "BOOLEAN"
		* "readonly" => "BOOLEAN"
		*/
		if ( ! function_exists( 'wm_form_textarea' ) ) {
			function wm_form_textarea( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$editor   = ( isset( $value['editor'] ) ) ? ( true ) : ( false );
				$default  = ( isset( $value['default'] ) ) ? ( $value['default'] ) : ( null );
				$cols     = ( isset( $value['cols'] ) ) ? ( absint( $value['cols'] ) ) : ( 60 );
				$rows     = ( isset( $value['rows'] ) ) ? ( absint( $value['rows'] ) ) : ( 8 );
				$class    = ( isset( $value['class'] ) ) ? ( ' class="' . esc_attr( $value['class'] ) . '"' ) : ( '' );
				$readonly = ( isset( $value['readonly'] ) ) ? ( ' readonly="readonly"' ) : ( '' );
				$settings = 'cols="' . $cols . '" rows="' . $rows . '"' . $class . $readonly;
				?>
				<!-- Textarea -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<?php
				if ( isset( $value['label'] ) ) {
					?>
					<p>
						<?php if ( isset( $default ) ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . esc_html( $default ) . '</span></a>'; ?>
						<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
					</p>
					<?php
				}

				if ( isset( $value['desc'] ) && $value['desc'] )
					echo '<p class="desc">' . $value['desc'] . '</p>';

				if ( $editor ) {
					if ( $val || ( isset( $value['empty'] ) && $value['empty'] ) && 1 < absint( get_option( WM_THEME_SETTINGS . '-installed' ) ) )
						$val = $val;
					else
						$val = $default;

					wp_editor( $val, $valId );
				} else {
					?>
					<p><textarea name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" <?php echo $settings ?>><?php
					if ( $val || ( isset( $value['empty'] ) && $value['empty'] ) && 1 < absint( get_option( WM_THEME_SETTINGS . '-installed' ) ) )
						echo esc_textarea( $val );
					else
						echo esc_textarea( $default );
					?></textarea></p>
					<?php
				}
				?>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_textarea



		/*
		* SELECT
		*
		* "type" => "select"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" => "optVal" )
		* "default" => "VAL"
		* "optgroups" => "BOOLEAN"
		* "icons" => "BOOLEAN"
		*/
		if ( ! function_exists( 'wm_form_select' ) ) {
			function wm_form_select( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default   = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				$optgroups = ( isset( $value['optgroups'] ) ) ? ( true ) : ( false );
				$icons     = ( isset( $value['icons'] ) ) ? ( ' icons-selector' ) : ( '' );
				$compare   = ( isset( $val ) ) ? ( $val ) : ( $default );
				?>
				<!-- Select -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p>
					<span class="select-wrapper<?php echo $icons; ?>">
						<?php if ( $icons ) echo '<i class="" title="' . __( 'Preview', 'clifden_domain_adm' ) . '"></i>'; ?>
						<select name="<?php echo $valId; ?>" id="<?php echo $valId; ?>">
							<?php
							if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
								foreach ( $value['options'] as $optId => $option ) {
									if ( $optgroups ) {
										if ( false === strpos( $optId, 'OPTGROUP' ) ) {
											?>
											<option<?php
											echo ' value="'. $optId . '"';
											if ( $compare == $optId )
												echo ' selected="selected"';
											?>><?php echo strip_tags( $option ); ?></option>
											<?php
										} elseif ( 'OPTGROUP' === substr( $optId, 1 ) ) {
											echo '<optgroup label="' . $option . '">';
										} elseif ( '/OPTGROUP' === substr( $optId, 1 ) ) {
											echo '</optgroup>';
										}
									} else {
										?>
										<option<?php
										echo ' value="'. $optId . '"';
										if ( $compare == $optId )
											echo ' selected="selected"';
										?>><?php echo strip_tags( $option ); ?></option>
										<?php
									}
								}
							}
							?>
						</select>
					</span>
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_select



		/*
		* RADIO
		*
		* "type" => "radio"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" => "optVal" )
		* "default" => "VAL"
		*/
		if ( ! function_exists( 'wm_form_radio' ) ) {
			function wm_form_radio( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				?>
				<!-- Radio buttons -->
				<div class="option radios" data-option="<?php echo $valId; ?>">
				<p>
					<label for="<?php echo $valId . '-1'; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php
				if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>';

				$i = 0;
				$checked = '';
				if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
					foreach ( $value['options'] as $optId => $option ) {
						$i++;
						if ( $val && $val == $optId )
							$checked = ' checked="checked"';
						elseif ( ! $val && $default == $optId )
							$checked = ' checked="checked"';
						else
							$checked = '';
						?>
						<p class="radio">
							<input type="radio" name="<?php echo $valId; ?>" id="<?php echo $valId . '-' . $i; ?>" value="<?php echo $optId; ?>"<?php echo $checked; ?> />
							<label for="<?php echo $valId . '-' . $i; ?>"><?php echo strip_tags( $option ); ?></label>
						</p>
						<?php
					}
				}
				?>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_radio



		/*
		* CHECKBOX
		*
		* "type" => "checkbox"
		* "id" => "ID"
		* "label" => "LABEL"
		* "value" => "VALUE"
		* "desc" => "TEXT"
		* "default" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_checkbox' ) ) {
			function wm_form_checkbox( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				if ( 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) && isset( $value['default'] ) && $value['default'] )
					$val = 'Default' . $value['default'];

				$setVal = ( isset( $value['value'] ) ) ? ( $value['value'] ) : ( 'true' );
				if ( $val )
					$checked = 'checked="checked"';
				else
					$checked = '';
				?>
				<!-- Checkbox -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p class="checkbox">
					<input type="checkbox" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php echo $setVal; ?>" <?php echo $checked; ?> />
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php
				if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>';
				?>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_checkbox



		/*
		* HIDDEN
		*
		* "type" => "hidden"
		* "id" => "ID"
		* "default" => "VAL"
		*/
		if ( ! function_exists( 'wm_form_hidden' ) ) {
			function wm_form_hidden( $value, $isMeta = null ) {
				$valId   = WM_THEME_SETTINGS_PREFIX . $value['id'];
				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				?>
				<input type="hidden" name="<?php echo $valId; ?>" value="<?php echo strip_tags( $default ); ?>" />
				<?php
			}
		} // /wm_form_hidden






	/*
	*****************************************************
	*      3.3) ADVANCED FORM ELEMENTS
	*****************************************************
	*/
		/*
		* SETTINGS EXPORTER
		*
		* "type" => "settingsExporter"
		* "id" => "settingsExporter"
		* "label-export" => "LABEL"
		* "desc-export" => "TEXT"
		* "label-import" => "LABEL"
		* "desc-import" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_settings_exporter' ) ) {
			function wm_form_settings_exporter( $value ) {
				$valId    = WM_THEME_SETTINGS_PREFIX . $value['id'];
				$cols     = 80;
				$rows     = 5;
				$settings = 'cols="' . $cols . '" rows="' . $rows . '"';
				?>
				<!-- Settings exporter -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p class="settings-exporter">
					<label for="<?php echo $valId; ?>-export"><?php echo strip_tags( $value['label-export'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc-export'] ) && $value['desc-export'] ) echo '<p class="desc">' . esc_attr( $value['desc-export'] ) . '</p>'; ?>
				<p><br />
					<input name="save-preset" type="submit" value="<?php _e( 'Create a file', 'clifden_domain_panel' ); ?>" class="btn submit" title="<?php printf( __( 'A new file will be created inside %s folder.', 'clifden_domain_panel' ), WM_PRESETS ); ?>" />
				</p>
				<p>
					<textarea name="<?php echo $valId; ?>-export" id="<?php echo $valId; ?>-export" onfocus="this.select();" <?php echo $settings ?> readonly="readonly"><?php
					if ( get_option( WM_THEME_SETTINGS ) ) {
						// htmlspecialchars - Convert special characters to HTML entities
						// gzdeflate - [param = compression level] Deflate a string, compress the given string using the DEFLATE data format
						// base64_encode - Encodes data with MIME base64
						// rtrim - Strip whitespace (or other characters) from the end of a string
						$encoded = rtrim( base64_encode( gzdeflate( htmlspecialchars( serialize( get_option( WM_THEME_SETTINGS ) ) ), 9 ) ) );
						echo esc_attr( $encoded );
					}
					?></textarea>
				</p>

				<!-- Settings importer -->
				<p class="settings-importer">
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label-import'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc-import'] ) && $value['desc-import'] ) echo '<p class="desc">' . esc_attr( $value['desc-import'] ) . '</p>'; ?>
				<?php
					//get preset files
					$presetFiles = array();

					if ( $dir = @opendir( WM_PRESETS ) ) {
						//this is the correct way to loop over the directory
						while ( false != ( $file = readdir( $dir ) ) ) {
							$presetFiles[] = $file;
						}
						closedir( $dir );
					}

					arsort( $presetFiles );

					//create output array
					$out = '';
					foreach ( $presetFiles as $file ) {
						if ( 7 < strlen( $file ) && 'txt' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
							$out .= '<option value="' . $file . '">' . str_replace( '.txt', '', $file ) . '</option>';
						}
					}
					if ( $out )
						echo '<p><br /><span class="select-wrapper"><select name="' . $valId . '-preset"><option value="">' . __( '- select preset file -', 'clifden_domain_panel' ) . '</option>' . $out . '</select></span></p>';
				?>
				<p>
					<textarea name="<?php echo $valId; ?>" id="<?php echo $valId; ?>"  <?php echo $settings ?>></textarea>
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_settings_exporter



		/**
		* SETTINGS EXPORTER - JSON, PRESETS
		*
		* @param type         ["settingsExporterJSON"]
		* @param id           ["settingsExporter"]
		* @param label-export ["LABEL"]
		* @param desc-export  ["TEXT"]
		* @param label-import ["LABEL"]
		* @param desc-import  ["TEXT"]
		*/
		if ( ! function_exists( 'wm_form_settings_exporter_JSON' ) ) {
			function wm_form_settings_exporter_JSON( $value ) {
				$valId    = WM_THEME_SETTINGS_PREFIX . $value['id'];
				$cols     = 80;
				$rows     = 5;
				$settings = 'cols="' . $cols . '" rows="' . $rows . '"';
				?>
				<!-- Settings exporter -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p class="settings-exporter">
					<label for="<?php echo $valId; ?>-export"><?php echo strip_tags( $value['label-export'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc-export'] ) && $value['desc-export'] ) echo '<p class="desc">' . $value['desc-export'] . '</p>'; ?>
				<p><br />
					<input name="save-preset" type="submit" value="<?php _e( 'Create a file', 'clifden_domain_panel' ); ?>" class="btn submit" title="<?php printf( __( 'A new file will be created inside %s folder.', 'clifden_domain_panel' ), WM_PRESETS ); ?>" />
				</p>
				<p>
					<textarea name="<?php echo $valId; ?>-export" id="<?php echo $valId; ?>-export" onfocus="this.select();" <?php echo $settings ?> readonly="readonly"><?php
					if ( get_option( WM_THEME_SETTINGS ) ) {
						$encoded = trim( htmlspecialchars( json_encode( get_option( WM_THEME_SETTINGS ) ) ) );
						echo esc_attr( $encoded );
					}
					?></textarea>
				</p>

				<div class="separator"></div>

				<!-- Settings importer -->
				<p class="settings-importer">
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label-import'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc-import'] ) && $value['desc-import'] ) echo '<p class="desc">' . $value['desc-import'] . '</p>'; ?>
				<?php
					//get preset files
					$presetFiles = array();

					if ( $dir = @opendir( WM_PRESETS ) ) {
						//this is the correct way to loop over the directory
						while ( false != ( $file = readdir( $dir ) ) ) {
							$presetFiles[] = $file;
						}
						closedir( $dir );
					}

					arsort( $presetFiles );

					//create output array
					$out = '';
					foreach ( $presetFiles as $file ) {
						if ( 7 < strlen( $file ) && 'json' == strtolower( pathinfo( $file, PATHINFO_EXTENSION ) ) ) {
							$out .= '<option value="' . $file . '">' . str_replace( '.json', '', $file ) . '</option>';
						}
					}
					if ( $out )
						echo '<p><br /><span class="select-wrapper"><select name="' . $valId . '-preset"><option value="">' . __( '- select preset file -', 'clifden_domain_panel' ) . '</option>' . $out . '</select></span></p>';
				?>
				<p>
					<textarea name="<?php echo $valId; ?>" id="<?php echo $valId; ?>"  <?php echo $settings ?>></textarea>
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_settings_exporter_JSON



		/*
		* SKINS
		*
		* "type" => "skins"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" )
		* "default" => "VAL"
		*/
		if ( ! function_exists( 'wm_form_skins' ) ) {
			function wm_form_skins( $value, $isMeta = null ) {
				global $skinAtts;

				$skinAttsArray = array_keys( $skinAtts );

				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				if ( $val )
					$setValue = $val;
				elseif ( $default )
					$setValue = $default;
				else
					$setValue = '';
				?>
				<!-- Layouts -->
				<div class="option" data-option="<?php echo $valId; ?>" id="skin-selector">
				<p>
					<label><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<div class="layout-boxes">
				<?php
				if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
					foreach ( $value['options'] as $thumbLayout ) {
						?>
						<div class="layout-box<?php if ( $thumbLayout['id'] == $setValue ) echo ' active'; ?>">
							<label for="<?php echo $valId . '-' . $thumbLayout['id']; ?>">
								<img src="<?php echo $thumbLayout['img']; ?>" alt="<?php echo $thumbLayout['name']; ?>" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>" />
								<span class="ie-bug tipsy" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>">&nbsp;</span>
							</label><br />
							<input type="radio" name="<?php echo $valId; ?>" id="<?php echo $valId . '-' . $thumbLayout['id']; ?>" value="<?php echo $thumbLayout['value']; ?>" <?php
							checked( $thumbLayout['value'], $setValue );

							$skinAttsOut = '';

							foreach ( $skinAttsArray as $key ) {
								//NOTE: "#" character has to be there due to color number values starting with 0 (otherwise it will be cut of)
								$skinAttsOut .= ' data-' . $key . '="#' . esc_html( str_replace( '__', ' ', wm_skin_meta( $thumbLayout['value'], $key ) ) ) . '"';
							}

							echo $skinAttsOut;
							?> />
						</div>
						<?php
					}
				}
				?>
				</div> <!-- /layout-boxes -->
				<script><!--
					jQuery(function(){
						jQuery( '#skin-selector input[type="radio"]' ).change( function() {
								var skinOptionsInputs = [<?php echo "'" . implode( "', '", $skinAttsArray ) . "'"; ?>];

								//loop through the array
								for( var i in skinOptionsInputs ) {
									var valueChange = jQuery( this ).data( skinOptionsInputs[i] );
									valueChange = valueChange.substr(1);
									jQuery( '#wm-design-' + skinOptionsInputs[i] ).val( valueChange );
								}
							} );
					});
				//--></script>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_skins



		/*
		* SKINS (JSON)
		*
		* "type" => "skins-json"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" )
		* "default" => "VAL"
		*/
		if ( ! function_exists( 'wm_form_skins_json' ) ) {
			function wm_form_skins_json( $value, $isMeta = null ) {
				$skinAttsArray = array();

				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				if ( $val )
					$setValue = $val;
				elseif ( $default )
					$setValue = $default;
				else
					$setValue = '';
				?>
				<!-- Layouts -->
				<div class="option" data-option="<?php echo $valId; ?>" id="skin-selector">
				<p>
					<label><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<div class="layout-boxes">
				<?php
				if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
					foreach ( $value['options'] as $thumbLayout ) {
						?>
						<div class="layout-box<?php if ( $thumbLayout['id'] == $setValue ) echo ' active'; ?>">
							<label for="<?php echo $valId . '-' . $thumbLayout['id']; ?>">
								<img src="<?php echo $thumbLayout['img']; ?>" alt="<?php echo $thumbLayout['name']; ?>" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>" />
								<span class="ie-bug tipsy" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>">&nbsp;</span>
							</label><br />
							<input type="radio" name="<?php echo $valId; ?>" id="<?php echo $valId . '-' . $thumbLayout['id']; ?>" value="<?php echo $thumbLayout['value']; ?>" <?php
							checked( $thumbLayout['value'], $setValue );

							$skinAttsOut  = '';
							$skinJSON = WM_SKINS . str_replace( '.css', '.json', $thumbLayout['value'] );
							if ( file_exists( $skinJSON ) ) {
								//We don't need to write to the file, so just open for reading.
								$fp = fopen( $skinJSON, 'r' );
								//Pull only the first 8kiB of the file in.
								$file_data = fread( $fp, filesize( $skinJSON ) );
								//PHP will close file handle, but we are good citizens.
								fclose( $fp );

								if ( $file_data ) {
									$file_data = str_replace( array( "\t", "\r", "\n", "\r\n" ), '', trim( $file_data ) );
									$file_data = preg_replace( '!/\*.*?\*/!s', '', $file_data ); //strip JSON comments (only /* */ type allowed)

									//get JSON data
									$file_data = json_decode( $file_data, true );
									if ( is_array( $file_data ) && isset( $file_data['options'] ) && is_array( $file_data['options'] ) ) {
										foreach ( $file_data['options'] as $option ) {
											$skinAttsArray[] = $option['option']; //for JavaScript below
											//NOTE: "#" character has to be there due to color number values starting with 0 (otherwise it will be cut of)
											$skinAttsOut .= ' data-' . $option['option'] . '="#' . esc_html( $option['value'] ) . '"';
										}
									}
								}
							}

							echo $skinAttsOut;
							?> />
						</div>
						<?php
					}
				}
				?>
				</div> <!-- /layout-boxes -->
				<script><!--
				jQuery(function(){
					<?php
					//initial applying the skin values after theme installation
					if ( 2 > intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) :
					?>
						var skinOptionsInputs = [<?php echo "'" . implode( "', '", $skinAttsArray ) . "'"; ?>];
						//loop through the array and apply the skin
						for ( var i in skinOptionsInputs ) {
							var valueChange  = jQuery( '#skin-selector input[value="default.css"]' ).data( skinOptionsInputs[i] ),
							    optionChange = jQuery( '[name="wm-' + skinOptionsInputs[i] + '"]' );

							if ( ( typeof valueChange != 'undefined' ) ) { //required for if there are different parameters per each skin
								valueChange = valueChange.substr(1);
								if ( ! optionChange.is( ':radio' ) )
									optionChange.val( valueChange );
								else
									jQuery( '[name="wm-' + skinOptionsInputs[i] + '"][value="' + valueChange + '"]' ).attr( 'checked', 'checked' );
							}
						}

					<?php
					endif;
					?>
					jQuery( '#skin-selector input[type="radio"]' ).change( function() {
							var skinOptionsInputs = [<?php echo "'" . implode( "', '", $skinAttsArray ) . "'"; ?>];

							//loop through the array
							for ( var i in skinOptionsInputs ) {
								var valueChange  = jQuery( this ).data( skinOptionsInputs[i] ),
								    optionChange = jQuery( '[name="wm-' + skinOptionsInputs[i] + '"]' );

								if ( ( typeof valueChange != 'undefined' ) ) { //required for if there are different parameters per each skin
									valueChange = valueChange.substr(1);
									if ( ! optionChange.is( ':radio' ) )
										optionChange.val( valueChange );
									else
										jQuery( '[name="wm-' + skinOptionsInputs[i] + '"][value="' + valueChange + '"]' ).attr( 'checked', 'checked' );
								}
							}
						} );
				});
				//--></script>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_skins_json



		/*
		* LAYOUTS
		*
		* "type" => "layouts"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" )
		* "default" => "VAL"
		*/
		if ( ! function_exists( 'wm_form_layouts' ) ) {
			function wm_form_layouts( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				if ( $val )
					$setValue = $val;
				elseif ( $default )
					$setValue = $default;
				else
					$setValue = '';
				?>
				<!-- Layouts -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<label><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<div class="layout-boxes">
				<?php
				if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
					foreach ( $value['options'] as $thumbLayout ) {
						?>
						<div class="layout-box<?php if ( $thumbLayout['id'] == $setValue ) echo ' active'; ?>">
							<label for="<?php echo $valId . '-' . $thumbLayout['id']; ?>">
								<img src="<?php echo $thumbLayout['img']; ?>" alt="<?php echo $thumbLayout['name']; ?>" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>" />
								<span class="ie-bug tipsy" title="<?php if ( isset( $thumbLayout['desc'] ) ) echo $thumbLayout['desc']; ?>">&nbsp;</span>
							</label><br />
							<input type="radio" name="<?php echo $valId; ?>" id="<?php echo $valId . '-' . $thumbLayout['id']; ?>" value="<?php if ( isset( $thumbLayout['value'] ) ) echo $thumbLayout['value']; else echo $thumbLayout['id']; ?>" <?php if ( isset( $thumbLayout['value'] ) ) checked( $thumbLayout['value'], $setValue ); else checked( $thumbLayout['id'], $setValue ); ?> />
						</div>
						<?php
					}
				}
				?>
				</div> <!-- /layout-boxes -->
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_layouts



		/*
		* PATTERNS
		*
		* "type" => "layouts"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "options" => ARRAY( "optID" )
		* "field" => "TEXT" //type of input (radio or checkbox) - if set, checkbox is used, if empty, radio is used
		* "default" => "VAL"
		* "repeat" => "no" //optional
		* "class" => "CSSCLASS"
		* "preview" => "BOOLEAN"
		* "hidden" => "BOOLEAN"
		*/
		if ( ! function_exists( 'wm_form_patterns' ) ) {
			function wm_form_patterns( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$bgColorOption = str_replace( 'pattern', 'color', $value['id'] );

				$bgColor = ( wm_option( $bgColorOption ) ) ? ( wm_option( $bgColorOption, 'color' ) ) : ( '' );
				$bgColor = ( $bgColor ) ? ( $bgColor ) : ( '#eee' );
				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				$field   = ( isset( $value['field'] ) ) ? ( 'checkbox' ) : ( 'radio' );
				$repeat  = ( isset( $value['repeat'] ) ) ? ( 'no-' ) : ( '' );
				$class   = ( isset( $value['class'] ) ) ? ( $value['class'] ) : ( '' );
				$preview = ( isset( $value['preview'] ) && $value['preview'] ) ? ( true ) : ( false );
				$hidden  = ( isset( $value['hidden'] ) ) ? ( ' just-images' ) : ( false );

				$previewText = '';

				$i = 0;
				if ( $val )
					$setValue = $val;
				elseif ( $default )
					$setValue = $default;
				else
					$setValue = '';
				?>
				<!-- Patterns -->
				<div class="option<?php echo $class; ?>" data-option="<?php echo $valId; ?>">
				<p>
					<label class="main-label"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<div class="pattern-boxes<?php echo $hidden; ?>">
				<?php
				if ( $preview && 'checkbox' != $field) {
					echo '<div class="pattern-preview"><div><span>' . __( 'Pattern preview', 'clifden_domain_adm' ) . '</span></div></div>';
					$previewText = ' - ' . __( 'Click the pattern for preview', 'clifden_domain_adm' );
				}
				if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
					foreach ( $value['options'] as $pattern ) {
						?>
						<div class="pattern-box<?php if ( $pattern['id'] == $setValue ) echo ' active'; ?>">
							<label for="<?php echo $valId . '-' . $pattern['id']; ?>" title="<?php echo $pattern['name'] . $previewText; ?>">
								<span<?php if ( ! $preview ) echo ' class="background-size"'; ?> style="background: <?php echo $bgColor; ?> url(<?php echo $pattern['img']; ?>) <?php echo $repeat; ?>repeat 50%"><?php echo $pattern['name']; ?></span>
								<?php if ( $pattern['img'] ) : ?><a href="<?php echo $pattern['img']; ?>" target="_blank" title="<?php _e( 'Open image in another window', 'clifden_domain_adm' ); ?>"><?php _e( 'Link to the image', 'clifden_domain_adm' ); ?></a><?php endif; ?>
							</label><br />
							<?php if ( ! $hidden ) { ?>
							<input type="<?php echo $field; ?>" name="<?php echo $valId; if ( 'checkbox' == $field ) echo '[' . $i . ']'; ?>" id="<?php echo $valId . '-' . $pattern['id']; ?>" value="<?php echo $pattern['id']; ?>" <?php
							if ( 'checkbox' == $field && isset( $val ) && is_array( $val ) && in_array( $pattern['id'], $val ) )
								echo ' checked="checked"';
							elseif ( 'radio' == $field )
								checked( $pattern['id'], $setValue );
							?> />
							<?php } else { ?>
							<input type="hidden" name="<?php echo $valId . '[' . $i . ']'; ?>" id="<?php echo $valId . '-' . $pattern['id']; ?>" value="<?php echo $pattern['id']; ?>" />
							<?php } ?>
						</div>
						<?php
						++$i;
					}
				}
				?>
				</div> <!-- /layout-boxes -->
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_patterns



		/*
		* COLOR
		*
		* "type"     => "color"
		* "id"       => "ID"
		* "label"    => "LABEL"
		* "desc"     => "TEXT"
		* "default"  => "######"
		* "onchange" => "TEXT" (CSS seletors to change background color for on color change)
		*/
		if ( ! function_exists( 'wm_form_color' ) ) {
			function wm_form_color( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				?>
				<!-- Color input -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<div class="color-wrapper"<?php if ( isset( $value['onchange'] ) && $value['onchange'] ) echo ' data-onchange="' . esc_attr( $value['onchange'] ) . '"'; ?>>
					<p>
						<?php if ( isset( $value['default'] ) ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
						<label data-for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
					</p>
					<p class="color-text">
						<span class="color-select">
							<span class="color-display" style="background-color: <?php
							if ( $val )
								echo '#' . esc_attr( $val );
							elseif ( $default )
								echo '#' . $default;
							else
								echo '#ffffff';
							?>"></span>
						</span> <!-- /color-select -->
						<input type="text" class="short" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php
						if ( $val )
							echo esc_html( esc_attr( $val ) );
						else
							echo $default;
						?>"<?php if ( ! ( $val || $default ) ) echo ' placeholder="' . __( 'Use theme styles', 'clifden_domain_adm' ) . '"'; ?> maxlength="6" />
					</p>
					<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				</div> <!-- /color-wrapper -->
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_color



		/*
		* IMAGE
		*
		* "type" => "image"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "URL"
		* "readonly" => "BOOLEAN" (do not use "validate" when using "readonly" as output is array( 'url', 'id' ) )
		* "imgsize" => "TEXT" (image size used in image preview)
		*
		* HELP: During image selection in WordPress admin (using Media Uploader) make sure the image "Link URL" field is set!
		*/
		if ( ! function_exists( 'wm_form_image' ) ) {
			function wm_form_image( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				if ( is_array( $val ) && ! isset( $val['url'] ) )
					$val = array(
							'url' => '',
							'id'  => ''
						);

				$default   = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				$readonly  = ( isset( $value['readonly'] ) && $value['readonly'] ) ? ( ' readonly="readonly"' ) : ( null );
				$imageSize = ( isset( $value['imgsize'] ) ) ? ( $value['imgsize'] ) : ( null );
				?>
				<!-- Image input -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<?php if ( isset( $value['default'] ) ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p id="<?php echo $valId; ?>-file" class="image-input-container">
					<span class="btn-add upload-image no-js"><?php _e( 'Upload an image', 'clifden_domain_adm' ) ?></span>
					<input type="text" name="<?php echo $valId; if ( $readonly ) echo '[url]'; ?>" id="<?php echo $valId; ?>" value="<?php
						if ( $readonly )
							$out = ( $val ) ? ( $val['url'] ) : ( $default );
						else
							$out = ( $val ) ? ( $val ) : ( $default );

						if ( 0 === strpos( trim( $out ), '.' ) )
							$out = esc_attr( trim( $out ) );
						else
							$out = esc_url( $out );

						echo $out;
					?>"<?php echo $readonly; ?> />
					<?php if ( $readonly ) { ?>
					<input type="hidden" name="<?php echo $valId; ?>[id]" id="<?php echo $valId; ?>-ID" value="<?php if ( isset( $val['url'] ) && $val['url'] && isset( $val['id'] ) ) echo $val['id']; ?>" />
					<?php } ?>
				</p>
				<div class="image-container <?php echo $valId; ?>-file<?php if ( ! $out ) echo ' hide'; ?>" title="<?php _e( 'Image preview', 'clifden_domain_adm' ); ?>">
					<a href="<?php echo $out; ?>" class="fancybox" title="<?php _e( 'Image full size preview', 'clifden_domain_adm' ); ?>">
						<img src="<?php
							if ( $readonly && isset( $val['id'] ) ) {
								$out = wp_get_attachment_image_src( $val['id'], $imageSize );
								$out = $out[0];
							}

							if ( 0 === strpos( $out, '.' ) )
								$out = esc_url( WM_ASSETS_THEME . 'css/' . $out );

							if ( $out )
								echo $out;
							else
								echo WM_ASSETS_ADMIN . 'img/icons/ico-warning.png';
						?>" alt="" <?php if ( ! $out ) echo ' title="' . __( 'Image does not exist', 'clifden_domain_adm' ) . '"' ?> />
					</a>
					<em><small><?php _e( 'Image preview', 'clifden_domain_adm' ); ?></small></em>
				</div>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_image



		/*
		* AUDIO
		*
		* "type" => "audio"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "URL"
		*
		* HELP: During audio selection in WordPress admin (using Media Uploader) make sure the "Link URL" field is set!
		*/
		if ( ! function_exists( 'wm_form_audio' ) ) {
			function wm_form_audio( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				?>
				<!-- Audio input -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<?php if ( isset( $value['default'] ) ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p id="<?php echo $valId; ?>-file" class="image-input-container">
					<span class="btn-add upload-audio no-js"><?php _e( 'Upload audio file', 'clifden_domain_adm' ) ?></span>
					<input type="text" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php
						$out = ( $val ) ? ( esc_url( $val ) ) : ( esc_url( $default ) );

						echo $out;
					?>" />
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_audio



		/*
		* VIDEO
		*
		* "type" => "video"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "URL"
		*
		* HELP: During video selection in WordPress admin (using Media Uploader) make sure the "Link URL" field is set!
		*/
		if ( ! function_exists( 'wm_form_video' ) ) {
			function wm_form_video( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );
				?>
				<!-- Audio input -->
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<?php if ( isset( $value['default'] ) ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p id="<?php echo $valId; ?>-file" class="image-input-container">
					<span class="btn-add upload-video no-js"><?php _e( 'Upload video file', 'clifden_domain_adm' ) ?></span>
					<input type="text" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php
						$out = ( $val ) ? ( esc_url( $val ) ) : ( esc_url( $default ) );

						echo $out;
					?>" />
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_video



		/**
		* ADDING ITEMS
		*
		* @param type         ["additems"]
		* @param id           [TEXT]
		* @param label        [TEXT]
		* @param desc         [TEXT]
		* @param default      [TEXT]
		* @param field        [TEXT (select, attributes, attributes-selectable, attributes-select-input or text)]
		* @param field-labels [ARRAY( "Field 1 title", "Field 2 title" )]
		* @param options      [ARRAY( "optID" => "optVal" )]
		* @param options-attr [ARRAY( "optID" => "optVal" ) - only for attributes-selectable and attributes-select-input]
		* @param options-val  [ARRAY( "optID" => "optVal" ) - only for attributes-selectable]
		*/
		if ( ! function_exists( 'wm_form_additems' ) ) {
			function wm_form_additems( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$field = ( isset( $value['field'] ) ) ? ( $value['field'] ) : ( null );

				if ( 'attributes' == $field )
					$default = ( isset( $value['default'] ) && is_array( $value['default'] ) && ! empty( $value['default'] ) ) ? ( $value['default'] ) : ( array( array( 'attr' => '', 'val' => '' ) ) );
				else
					$default = ( isset( $value['default'] ) ) ? ( esc_attr( $value['default'] ) ) : ( null );

				$fieldLabels = ( isset( $value['field-labels'] ) ) ? ( $value['field-labels'] ) : ( array( __( 'Attribute', 'clifden_domain_adm' ), __( 'Value', 'clifden_domain_adm' ) ) );
				?>
				<!-- Items creator -->
				<div class="option no-js" data-option="<?php echo $valId; ?>">
				<div class="<?php echo $valId; ?> add-items">
					<p><label><?php echo strip_tags( $value['label'] ); ?></label></p>
					<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
					<ul class="rows">
					<?php
					$i = 0;
					$btnClass = 'btn-remove';
					$btnText  = __( 'Remove item', 'clifden_domain_adm' );

					if ( is_array( $val ) && ! empty( $val ) ) {

						foreach ( $val as $row ) {
							?>
							<li>
								<a class="<?php echo $btnClass ?>" title="<?php echo $btnText; ?>"><?php echo $btnText; ?></a>

								<?php
								if ( 'select' == $field ) {
								//select
									?>
									<span class="select-wrapper">
										<select name="<?php echo $valId . '[' . $i . ']'; ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field">
											<?php
											$compareThisValue = ( isset( $row ) ) ? ( $row ) : ( $default );
											if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
												foreach ( $value['options'] as $optId => $option ) {
													?>
													<option<?php
													echo ' value="'. $optId . '"';
													if ( $compareThisValue == $optId )
														echo ' selected="selected"';
													?>><?php echo strip_tags( $option ); ?></option>
													<?php
												}
											}
											?>
										</select>
									</span>
									<?php
								} elseif ( 'attributes' == $field ) {
								//attributes
									?>
									<input type="text" name="<?php echo $valId . '[' . $i . '][attr]'; ?>" value="<?php echo esc_html( $row['attr'] ); ?>" id="<?php echo $valId; ?>" class="input-field short" placeholder="<?php echo $fieldLabels[0]; ?>" title="<?php echo $fieldLabels[0]; ?>" />
									<input type="text" name="<?php echo $valId . '[' . $i . '][val]'; ?>" value="<?php echo esc_html( $row['val'] ); ?>" id="<?php echo $valId; ?>" class="input-field" placeholder="<?php echo $fieldLabels[1]; ?>" title="<?php echo $fieldLabels[1]; ?>" />
									<?php
								} elseif ( 'attributes-selectable' == $field ) {
								//selectable attributes
									?>
									<span class="select-wrapper short">
										<select name="<?php echo $valId . '[' . $i . '][attr]'; ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field short">
											<?php
											$compareThisValue = ( isset( $row['attr'] ) ) ? ( $row['attr'] ) : ( $default );
											if ( isset( $value['options-attr'] ) && is_array( $value['options-attr'] ) && ! empty( $value['options-attr'] ) ) {
												foreach ( $value['options-attr'] as $optId => $option ) {
													?>
													<option<?php
													echo ' value="'. $optId . '"';
													if ( $compareThisValue == $optId )
														echo ' selected="selected"';
													?>><?php echo strip_tags( $option ); ?></option>
													<?php
												}
											}
											?>
										</select>
									</span>
									<?php if ( isset( $value['options-val'] ) && is_array( $value['options-val'] ) && ! empty( $value['options-val'] ) ) { ?>
										<span class="select-wrapper">
											<select name="<?php echo $valId . '[' . $i . '][val]'; ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field">
												<?php
												$compareThisValue = ( isset( $row['val'] ) ) ? ( $row['val'] ) : ( $default );
												foreach ( $value['options-val'] as $optId => $option ) {
													?>
													<option<?php
													echo ' value="'. $optId . '"';
													if ( $compareThisValue == $optId )
														echo ' selected="selected"';
													?>><?php echo strip_tags( $option ); ?></option>
													<?php
												}
												?>
											</select>
										</span>
									<?php } else { ?>
										<input type="text" name="<?php echo $valId . '[' . $i . '][val]'; ?>" value="<?php echo esc_html( $row['val'] ); ?>" id="<?php echo $valId; ?>" class="input-field" placeholder="<?php echo $fieldLabels[1]; ?>" title="<?php echo $fieldLabels[1]; ?>" />
									<?php
									}
								} else {
								//input
									?>
									<input type="text" name="<?php echo $valId . '[' . $i . ']'; ?>" value="<?php echo esc_html( $row ); ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field" />
									<?php
								} ?>

								<strong class="sort-handle">|||</strong>
							</li>
							<?php
							$i++;
						}

					} else {

						if ( 'attributes' !== $field )
							echo '<li><a class="' . $btnClass . '" title="' . $btnText . '">' . $btnText . '</a>';

						if ( 'select' == $field ) {
						//select
							?>
							<span class="select-wrapper">
								<select name="<?php echo $valId . '[' . $i . ']'; ?>" id="<?php echo $valId; ?>" class="input-field">
									<?php
									$compare = $default;
									if ( isset( $value['options'] ) && is_array( $value['options'] ) && ! empty( $value['options'] ) ) {
										foreach ( $value['options'] as $optId => $option ) {
											?>
											<option<?php
											echo ' value="'. $optId . '"';
											if ( $compare == $optId )
												echo ' selected="selected"';
											?>><?php echo strip_tags( $option ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</span>
							<?php
						} elseif ( 'attributes' == $field ) {
						//attributes
							foreach ( $default as $row ) {
								?>
								<li>
									<a class="<?php echo $btnClass ?>" title="<?php echo $btnText; ?>"><?php echo $btnText; ?></a>
									<input type="text" name="<?php echo $valId . '[' . $i . '][attr]'; ?>" value="<?php echo $default[$i]['attr']; ?>" class="input-field short" placeholder="<?php echo $fieldLabels[0]; ?>" title="<?php echo $fieldLabels[0]; ?>" />
									<input type="text" name="<?php echo $valId . '[' . $i . '][val]'; ?>" value="<?php echo $default[$i]['val']; ?>" class="input-field" placeholder="<?php echo $fieldLabels[1]; ?>" title="<?php echo $fieldLabels[1]; ?>" />
									<strong class="sort-handle">|||</strong>
								</li>
								<?php
								$i++;
							}
						} elseif ( 'attributes-selectable' == $field ) {
						//selectable attributes
							?>
							<span class="select-wrapper short">
								<select name="<?php echo $valId . '[' . $i . '][attr]'; ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field short">
									<?php
									$compare = $default;
									if ( isset( $value['options-attr'] ) && is_array( $value['options-attr'] ) && ! empty( $value['options-attr'] ) ) {
										foreach ( $value['options-attr'] as $optId => $option ) {
											?>
											<option<?php
											echo ' value="'. $optId . '"';
											if ( $compare == $optId )
												echo ' selected="selected"';
											?>><?php echo strip_tags( $option ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</span>
							<?php if ( isset( $value['options-val'] ) && is_array( $value['options-val'] ) && ! empty( $value['options-val'] ) ) { ?>
								<span class="select-wrapper">
									<select name="<?php echo $valId . '[' . $i . '][val]'; ?>" id="<?php echo $valId . '-' . $i; ?>" class="input-field">
										<?php
										$compare = $default;
										foreach ( $value['options-val'] as $optId => $option ) {
											?>
											<option<?php
											echo ' value="'. $optId . '"';
											if ( $compare == $optId )
												echo ' selected="selected"';
											?>><?php echo strip_tags( $option ); ?></option>
											<?php
										}
										?>
									</select>
								</span>
							<?php } else { ?>
								<input type="text" name="<?php echo $valId . '[' . $i . '][val]'; ?>" value="<?php echo $default[$i]['val']; ?>" class="input-field" placeholder="<?php echo $fieldLabels[1]; ?>" title="<?php echo $fieldLabels[1]; ?>" />
							<?php
							}
						} else {
						//input
							?>
							<input type="text" name="<?php echo $valId . '[' . $i . ']'; ?>" value="<?php echo strip_tags( $default ); ?>" id="<?php echo $valId; ?>" class="input-field" />
							<?php
						}

						if ( 'attributes' !== $field )
							echo '<strong class="sort-handle">|||</strong></li>';
					}

					?>
					</ul>
					<p>
						<a class="btn-add"><?php _e( 'Add an item', 'clifden_domain_adm' ) ?></a>
					</p>
				</div> <!-- /add-items -->
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_additems



		/*
		* NUMBER SLIDER
		*
		* "type" => "slider"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "#"
		* "min" => "#"
		* "max" => "#"
		* "step" => "#"
		* "zero" => "BOOLEAN"
		*/
		if ( ! function_exists( 'wm_form_slider' ) ) {
			function wm_form_slider( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default  = ( isset( $value['default'] ) ) ? ( intval( $value['default'] ) ) : ( null );
				$val      = ( isset( $value['validate'] ) && 'absint' === $value['validate'] ) ? ( absint( $val ) ) : ( intval( $val ) );
				$setValue = ( $val ) ? ( $val ) : ( $default );
				$setValue = ( isset( $value['zero'] ) && 0 === intval( $val ) && 2 === intval( get_option( WM_THEME_SETTINGS . '-installed' ) ) ) ? ( intval( $val ) ) : ( $setValue );
				?>
				<div class="option" data-option="<?php echo $valId; ?>">
				<p class="slide-number">
					<?php if ( isset( $default ) ) echo '<a data-default="' . $valId . '" class="btn btn-default default-slider" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p class="slide-number-wrapper no-js">
					<span id="<?php echo $valId; ?>-slider" class="number-slider">
						<span class="value-min hide"><?php echo $value['min']; ?></span>
						<span class="value-max hide"><?php echo $value['max']; ?></span>
						<span class="value-step hide"><?php echo $value['step']; ?></span>
					</span>
					<input type="text" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php echo esc_attr( $setValue ); ?>" size="5" maxlength="5" />
				</p>

				<script><!--
					jQuery(function(){

						jQuery( '#<?php echo $valId; ?>' ).attr( 'readonly', 'readonly' );
						jQuery( '#<?php echo $valId; ?>-slider' ).parent().removeClass( 'no-js' );

						if ( jQuery().slider ) {
							jQuery( '#<?php echo $valId; ?>-slider' ).slider({
								value: <?php echo $setValue; ?>,
								min: <?php echo $value['min']; ?>,
								max: <?php echo $value['max']; ?>,
								step: <?php echo $value['step']; ?>,
								slide: function( event, ui ) {
									jQuery( '#<?php echo $valId; ?>' ).val( ui.value );
								}
							});
						}

					});
				//--></script>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_slider



		/*
		* DATE PICKER
		*
		* "type" => "date"
		* "id" => "ID"
		* "label" => "LABEL"
		* "desc" => "TEXT"
		* "default" => "#"
		* "class" => "TEXT" //future/past
		*/
		if ( ! function_exists( 'wm_form_datepicker' ) ) {
			function wm_form_datepicker( $value, $isMeta = null ) {
				if ( 'meta' == $isMeta )
					$val = wm_meta_option( $value['id'] );
				else
					$val = wm_option( $value['id'] );
				$valId = WM_THEME_SETTINGS_PREFIX . $value['id'];

				$default  = ( isset( $value['default'] ) ) ? ( intval( $value['default'] ) ) : ( null );
				$class    = ( isset( $value['class'] ) && $value['class'] ) ? ( ' class="' . $value['class'] . '"' ) : ( null );
				$setValue = ( $val ) ? ( $val ) : ( $default );
				?>
				<div class="option" data-option="<?php echo $valId; ?>">
				<p>
					<?php if ( $default ) echo '<a data-default="' . $valId . '" class="btn btn-default" title="' . __( 'Use default value', 'clifden_domain_adm' ) . '">' . __( 'Default value', 'clifden_domain_adm' ) . '<span>' . $default . '</span></a>'; ?>
					<label for="<?php echo $valId; ?>"><?php echo strip_tags( $value['label'] ); ?></label>
				</p>
				<?php if ( isset( $value['desc'] ) && $value['desc'] ) echo '<p class="desc">' . $value['desc'] . '</p>'; ?>
				<p>
					<input type="text" data-type="date" name="<?php echo $valId; ?>" id="<?php echo $valId; ?>" value="<?php echo esc_attr( $setValue ); ?>"<?php echo $class; ?> />
				</p>
				</div> <!-- /option -->
				<?php
				wm_conditional_show( $value, $valId );
			}
		} // /wm_form_datepicker






	/*
	*****************************************************
	*      3.4) TEXT ELEMENTS
	*****************************************************
	*/
		/*
		* INTRO
		*
		* "type" => "intro"
		* "content" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_intro' ) ) {
			function wm_form_intro( $value ) {
				$text = ( isset( $value['content'] ) ) ? ( $value['content'] ) : ( null );
				if ( $text )
					echo '<h3 class="intro">' . $text . '</h3>';
			}
		} // /wm_form_intro



		/*
		* HEADING H3
		*
		* "type" => "heading3"
		* "content" => "TITLE"
		* "class" => "CSSCLASS"
		* "id" => "CSSID"
		*/
		if ( ! function_exists( 'wm_form_heading3' ) ) {
			function wm_form_heading3( $value ) {
				$id    = ( isset( $value['id'] ) ) ? ( ' id="' . $value['id'] . '"' ) : ( '' );
				$class = ( isset( $value['class'] ) ) ? ( ' class="' . $value['class'] . '"' ) : ( '' );
				?>
				<h3<?php echo $class . $id ?>><?php echo $value['content']; ?></h3>
				<?php
			}
		} // /wm_form_heading3



		/*
		* HEADING H4
		*
		* "type" => "heading4"
		* "content" => "TITLE"
		* "class" => "CSSCLASS"
		* "id" => "CSSID"
		*/
		if ( ! function_exists( 'wm_form_heading4' ) ) {
			function wm_form_heading4( $value ) {
				$id    = ( isset( $value['id'] ) ) ? ( ' id="' . $value['id'] . '"' ) : ( '' );
				$class = ( isset( $value['class'] ) ) ? ( ' class="' . $value['class'] . '"' ) : ( '' );
				?>
				<h4<?php echo $class . $id ?>><?php echo $value['content']; ?></h4>
				<?php
			}
		} // /wm_form_heading4



		/*
		* PARAGRAPH
		*
		* "type" => "paragraph"
		* "content" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_paragraph' ) ) {
			function wm_form_paragraph( $value ) {
				?>
				<p><?php echo $value['content']; ?></p>
				<?php
			}
		} // /wm_form_paragraph



		/*
		* UNSORTED LIST UL
		*
		* "type" => "ulist"
		* "label" => "TEXT"
		* "content" => ARRAY( "opt", "opt", "opt" )
		*/
		if ( ! function_exists( 'wm_form_ulist' ) ) {
			function wm_form_ulist( $value ) {
				if ( isset( $value['content'] ) && $value['content'] ) {
					$listItems = $value['content'];

					if ( isset( $value['label'] ) && $value['label'] )
						echo '<p><strong>' . strip_tags( $value['label'] ) . '</strong></p>'; ?>
					<ul class="list">
					<?php
					foreach( $listItems as $listItem ) {
						echo '<li>' . $listItem . '</li>';
					}
					?>
					</ul>
					<?php
				}
			}
		} // /wm_form_ulist



		/*
		* BOX
		*
		* "type" => "box"
		* "content" => "TEXT"
		* "capability" => user capabilities to restrict visibility
		*/
		if ( ! function_exists( 'wm_form_box' ) ) {
			function wm_form_box( $value ) {
				if ( ! isset( $value['capability'] ) || ( isset( $value['capability'] ) && current_user_can( $value['capability'] ) ) ) {
				?>
				<!-- Infobox -->
				<div class="box"><?php echo do_shortcode( $value['content'] ); ?></div>
				<?php
				}
			}
		} // /wm_form_box



		/*
		* INFO BOX
		*
		* "type" => "info"
		* "content" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_info' ) ) {
			function wm_form_info( $value ) {
				?>
				<!-- Infobox -->
				<p class="info"><?php echo $value['content']; ?></p>
				<?php
			}
		} // /wm_form_info



		/*
		* WARNING BOX
		*
		* "type" => "warning"
		* "content" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_warning' ) ) {
			function wm_form_warning( $value ) {
				?>
				<!-- Warning -->
				<p class="warning"><?php echo $value['content']; ?></p>
				<?php
			}
		} // /wm_form_warning



		/*
		* HELP BOX
		*
		* "type" => "help"
		* "topic" => "TEXT"
		* "content" => "TEXT"
		*/
		if ( ! function_exists( 'wm_form_help' ) ) {
			function wm_form_help( $value ) {
				?>
				<!-- Help box -->
				<p class="help">
					<strong class="question"><?php echo stripslashes( $value['topic'] ); ?></strong>
					<em class="answer"><?php echo stripslashes( $value['content'] ); ?></em>
				</p>
				<?php
			}
		} // /wm_form_help



		/*
		* VERTICAL SPACE
		*
		* "type" => "space"
		*/
		if ( ! function_exists( 'wm_form_br' ) ) {
			function wm_form_br() {
				echo '<br />';
			}
		} // /wm_form_br



		/*
		* HORIZONTAL LINE HR
		*
		* "type" => "hr"
		*/
		if ( ! function_exists( 'wm_form_hr' ) ) {
			function wm_form_hr() {
				echo '<div class="separator"></div>';
			}
		} // /wm_form_hr



		/*
		* HORIZONTAL LINE HR WITH TOP LINK
		*
		* "type" => "hrtop"
		*/
		if ( ! function_exists( 'wm_form_hrtop' ) ) {
			function wm_form_hrtop() {
				echo '<div class="separator top"><a href="#"><small>' . __( '&uarr; Top of the page', 'clifden_domain_adm' ) . '</small></a></div>';
			}
		} // /wm_form_hrtop

?>