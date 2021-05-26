<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Price tables custom post
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
		add_action( 'init', 'wm_price_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'wm_price_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_price_columns', 'wm_price_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_price_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_price_cp_init' ) ) {
		function wm_price_cp_init() {
			global $cpMenuPosition;

			$role = ( wm_option( 'general-role-pricing' ) ) ? ( wm_option( 'general-role-pricing' ) ) : ( 'page' );
			$slug = ( wm_option( 'general-permalink-price' ) ) ? ( wm_option( 'general-permalink-price' ) ) : ( 'price' );

			$args = array(
				'query_var'           => 'price',
				'capability_type'     => $role,
				'public'              => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['prices'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/ico-price.png',
				'supports'            => array( 'title', 'editor', 'author' ),
				'labels'              => array(
					'name'               => __( 'Prices', 'clifden_domain_adm' ),
					'singular_name'      => __( 'Price', 'clifden_domain_adm' ),
					'add_new'            => __( 'Add new price', 'clifden_domain_adm' ),
					'add_new_item'       => __( 'Add new price', 'clifden_domain_adm' ),
					'new_item'           => __( 'Add new price', 'clifden_domain_adm' ),
					'edit_item'          => __( 'Edit price', 'clifden_domain_adm' ),
					'view_item'          => __( 'View price', 'clifden_domain_adm' ),
					'search_items'       => __( 'Search price', 'clifden_domain_adm' ),
					'not_found'          => __( 'No price found', 'clifden_domain_adm' ),
					'not_found_in_trash' => __( 'No price found in trash', 'clifden_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_price' , $args );
		}
	} // /wm_price_cp_init





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
	if ( ! function_exists( 'wm_price_cp_messages' ) ) {
		function wm_price_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_price'] = array(
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
	} // /wm_price_cp_messages





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
	if ( ! function_exists( 'wm_price_cp_columns' ) ) {
		function wm_price_cp_columns( $wm_priceCols ) {
			$prefix = 'wm_price-';

			$wm_priceCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				"title"              => __( 'Price', 'clifden_domain_adm' ),
				$prefix . "cost"     => __( 'Cost', 'clifden_domain_adm' ),
				$prefix . "featured" => __( 'Featured', 'clifden_domain_adm' ),
				$prefix . "color"    => __( 'Color', 'clifden_domain_adm' ),
				$prefix . "table"    => __( 'Price table', 'clifden_domain_adm' ),
				"date"               => __( 'Date', 'clifden_domain_adm' ),
				"author"             => __( 'Created by', 'clifden_domain_adm' )
			);

			return $wm_priceCols;
		}
	} // /wm_price_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_price_cp_custom_column' ) ) {
		function wm_price_cp_custom_column( $wm_priceCol ) {
			global $post;
			$prefix     = 'wm_price-';
			$prefixMeta = 'price-';

			switch ( $wm_priceCol ) {
				case $prefix . "cost":

					echo '<span style="font-size: 1.4em">' . stripslashes( wm_meta_option( $prefixMeta . 'cost' ) ) . '</span>';

				break;
				case $prefix . "featured":

					$wm_priceFeatured = ( ' featured' === wm_meta_option( $prefixMeta . 'style' ) ) ? ( '<img src="' . WM_ASSETS_THEME . 'img/icons/yes-no/yes-black.png" alt="" />' ) : ( '' );

					echo $wm_priceFeatured;

				break;
				case $prefix . "color":

					$color = ( wm_meta_option( $prefixMeta . 'color' ) ) ? ( wm_meta_option( $prefixMeta . 'color', $post->ID, 'color' ) ) : ( '#eee' );

					edit_post_link( '<span class="color-display" style="background-color:' . $color . ';"></span>' );

				break;
				case $prefix . "table":

					$terms = get_the_terms( $post->ID , 'price-table' );
					if ( $terms ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				default:
				break;
			}
		}
	} // /wm_price_cp_custom_column

?>