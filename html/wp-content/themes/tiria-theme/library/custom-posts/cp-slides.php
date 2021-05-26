<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Slides custom post
*
* CONTENT:
* - 1) Actions and filters
* - 2) Creating a custom post
* - 3) Admin messages
* - 4) Custom post list in admin
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'wm_slides_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'wm_slides_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_slides_columns', 'wm_slides_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_slides_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_slides_cp_init' ) ) {
		function wm_slides_cp_init() {
			global $cpMenuPosition;

			$role     = ( wm_option( 'general-role-slides' ) ) ? ( wm_option( 'general-role-slides' ) ) : ( 'page' );
			$slug     = ( wm_option( 'general-permalink-slide' ) ) ? ( wm_option( 'general-permalink-slide' ) ) : ( 'slide' );
			$supports = array( 'title', 'editor', 'thumbnail', 'author' );

			if ( wm_option( 'general-slides-revisions' ) )
				$supports[] = 'revisions';

			$args = array(
				'query_var'           => 'slides',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['slides'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/ico-slides.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Slides', 'clifden_domain_adm' ),
					'singular_name'      => __( 'Slide', 'clifden_domain_adm' ),
					'add_new'            => __( 'Add new slide', 'clifden_domain_adm' ),
					'add_new_item'       => __( 'Add new slide', 'clifden_domain_adm' ),
					'new_item'           => __( 'Add new slide', 'clifden_domain_adm' ),
					'edit_item'          => __( 'Edit slide', 'clifden_domain_adm' ),
					'view_item'          => __( 'View slide', 'clifden_domain_adm' ),
					'search_items'       => __( 'Search slides', 'clifden_domain_adm' ),
					'not_found'          => __( 'No slide found', 'clifden_domain_adm' ),
					'not_found_in_trash' => __( 'No slides found in trash', 'clifden_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_slides' , $args );
		}
	} // /wm_slides_cp_init





/*
*****************************************************
*      3) ADMIN MESSAGES
*****************************************************
*/
	/*
	* Custom post admin area messages
	*
	* $messages = ARRAY [array of messages]
	*/
	if ( ! function_exists( 'wm_slides_cp_messages' ) ) {
		function wm_slides_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_slides'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => __( 'Updated.', 'clifden_domain_adm' ),
				2  => __( 'Custom field updated.', 'clifden_domain_adm' ),
				3  => __( 'Custom field deleted.', 'clifden_domain_adm' ),
				4  => __( 'Updated.', 'clifden_domain_adm' ),
				5  => ( isset( $_GET['revision'] ) ) ? ( sprintf(
					__( 'Restored to revision from %s', 'clifden_domain_adm' ),
						wp_post_revision_title( (int) $_GET['revision'], false )
					) ) : ( false ),
				6  => __( 'Published.', 'clifden_domain_adm' ),
				7  => __( 'Saved.', 'clifden_domain_adm' ),
				8  => __( 'Submitted.', 'clifden_domain_adm' ),
				9  => sprintf(
					__( 'Scheduled for: <strong>%s</strong>.', 'clifden_domain_adm' ),
						get_the_date() . ', ' . get_the_time()
					),
				10 => __( 'Draft updated.', 'clifden_domain_adm' ),
				);

			return $messages;
		}
	} // /wm_slides_cp_messages





/*
*****************************************************
*      4) CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'wm_slides_cp_columns' ) ) {
		function wm_slides_cp_columns( $wm_slidesCols ) {
			$prefix = 'wm_slides-';

			$wm_slidesCols = array(
				//standard columns
				"cb"                        => '<input type="checkbox" />',
				$prefix . "thumb"           => __( 'Image', 'clifden_domain_adm' ),
				"title"                     => __( 'Slide title', 'clifden_domain_adm' ),
				$prefix . "group"           => __( 'Group', 'clifden_domain_adm' ),
				$prefix . "group-shortcode" => __( 'Group shortcode', 'clifden_domain_adm' ),
				$prefix . "link"            => __( 'Custom link', 'clifden_domain_adm' ),
				"date"                      => __( 'Date', 'clifden_domain_adm' ),
				"author"                    => __( 'Created by', 'clifden_domain_adm' )
			);

			return $wm_slidesCols;
		}
	} // /wm_slides_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_slides_cp_custom_column' ) ) {
		function wm_slides_cp_custom_column( $wm_slidesCol ) {
			global $post;
			$prefix     = 'wm_slides-';
			$prefixMeta = 'slide-';

			switch ( $wm_slidesCol ) {
				case $prefix . "group":

					$terms = get_the_terms( $post->ID , 'slide-category' );
					if ( $terms ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				case $prefix . "group-shortcode":

					$terms = get_the_terms( $post->ID , 'slide-category' );
					if ( $terms ) {
						foreach ( $terms as $term ) {
							echo '<input type="text" onfocus="this.select();" readonly="readonly" style="width:100%" value=\'[slideshow group="' . $term->slug . '" /]\' class="shortcode-in-list-table"><br />';
						}
					}

				break;
				case $prefix . "thumb":

					$size = explode( 'x', WM_ADMIN_LIST_THUMB );
					$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, 'widget' ) ) : ( '' );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					echo '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					echo '</span>';

				break;
				case $prefix . "link":

					$wm_slidesLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<a href="' . $wm_slidesLink . '" target="_blank">' . $wm_slidesLink . '</a>';

				break;
				default:
				break;
			}
		}
	} // /wm_slides_cp_custom_column

?>