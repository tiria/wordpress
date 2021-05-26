<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Projects custom post
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
		add_action( 'init', 'wm_projects_cp_init' );
		//CP list table columns
		add_action( 'manage_posts_custom_column', 'wm_projects_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-wm_projects_columns', 'wm_projects_cp_columns' );
		//Return messages
		add_filter( 'post_updated_messages', 'wm_projects_cp_messages' );





/*
*****************************************************
*      2) CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'wm_projects_cp_init' ) ) {
		function wm_projects_cp_init() {
			global $cpMenuPosition;

			$role     = ( wm_option( 'general-role-projects' ) ) ? ( wm_option( 'general-role-projects' ) ) : ( 'post' );
			$slug     = ( wm_option( 'general-permalink-project' ) ) ? ( wm_option( 'general-permalink-project' ) ) : ( 'project' );
			$supports = array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'custom-fields', 'author' );

			if ( wm_option( 'general-projects-revisions' ) )
				$supports[] = 'revisions';

			$args = array(
				'query_var'           => 'projects',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['projects'],
				'menu_icon'           => WM_ASSETS_ADMIN . 'img/icons/ico-portfolio.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Projects', 'clifden_domain_adm' ),
					'singular_name'      => __( 'Project', 'clifden_domain_adm' ),
					'add_new'            => __( 'Add new project', 'clifden_domain_adm' ),
					'add_new_item'       => __( 'Add new project', 'clifden_domain_adm' ),
					'new_item'           => __( 'Add new project', 'clifden_domain_adm' ),
					'edit_item'          => __( 'Edit project', 'clifden_domain_adm' ),
					'view_item'          => __( 'View project', 'clifden_domain_adm' ),
					'search_items'       => __( 'Search projects', 'clifden_domain_adm' ),
					'not_found'          => __( 'No project found', 'clifden_domain_adm' ),
					'not_found_in_trash' => __( 'No project found in trash', 'clifden_domain_adm' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'wm_projects' , $args );
		}
	} // /wm_projects_cp_init





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
	if ( ! function_exists( 'wm_projects_cp_messages' ) ) {
		function wm_projects_cp_messages( $messages ) {
			global $post, $post_ID;

			$messages['wm_projects'] = array(
				0  => '', // Unused. Messages start at index 1.
				1  => sprintf(
					__( 'Project updated. <a href="%s">View project</a>', 'clifden_domain_adm' ),
					esc_url( get_permalink( $post_ID ) )
					),
				2  => __( 'Custom field updated.', 'clifden_domain_adm' ),
				3  => __( 'Custom field deleted.', 'clifden_domain_adm' ),
				4  => __( 'Project updated.', 'clifden_domain_adm' ),
				5  => ( isset( $_GET['revision'] ) ) ? ( sprintf(
					__( 'Project restored to revision from %s', 'clifden_domain_adm' ),
						wp_post_revision_title( (int) $_GET['revision'], false )
					) ) : ( false ),
				6  => sprintf(
					__( 'Project published. <a href="%s">View project</a>', 'clifden_domain_adm' ),
						esc_url( get_permalink($post_ID) )
					),
				7  => __( 'Project saved.', 'clifden_domain_adm' ),
				8  => sprintf(
					__( 'Project submitted. <a target="_blank" href="%s">Preview project</a>', 'clifden_domain_adm' ),
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) )
					),
				9  => sprintf(
					__( 'Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', 'clifden_domain_adm' ),
						get_the_date() . ', ' . get_the_time(),
						esc_url( get_permalink( $post_ID ) )
					),
				10 => sprintf(
					__( 'Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'clifden_domain_adm' ),
						esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) )
					),
				);

			return $messages;
		}
	} // /wm_projects_cp_messages





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
	if ( ! function_exists( 'wm_projects_cp_columns' ) ) {
		function wm_projects_cp_columns( $wm_projectsCols ) {
			$prefix = 'wm_projects-';

			$wm_projectsCols = array(
				//standard columns
				"cb"                 => '<input type="checkbox" />',
				$prefix . "thumb"    => __( 'Image', 'clifden_domain_adm' ),
				"title"              => __( 'Project', 'clifden_domain_adm' ),
				$prefix . "category" => __( 'Category', 'clifden_domain_adm' ),
				$prefix . "link"     => __( 'Custom link', 'clifden_domain_adm' ),
				"date"               => __( 'Date', 'clifden_domain_adm' ),
				"author"             => __( 'Created by', 'clifden_domain_adm' ),
				$prefix . "layout"   => __( 'Layout', 'clifden_domain_adm' )
			);

			return $wm_projectsCols;
		}
	} // /wm_projects_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'wm_projects_cp_custom_column' ) ) {
		function wm_projects_cp_custom_column( $wm_projectsCol ) {
			global $post;
			$prefix     = 'wm_projects-';
			$prefixMeta = 'project-';

			switch ( $wm_projectsCol ) {
				case $prefix . "type":

				break;
				case $prefix . "category":

					$terms = get_the_terms( $post->ID , 'project-category' );
					if ( $terms ) {
						foreach ( $terms as $term ) {
							$termName = ( isset( $term->name ) ) ? ( $term->name ) : ( null );
							echo '<strong>' . $termName . '</strong><br />';
						}
					}

				break;
				case $prefix . "thumb":

					$icon = '';
					$projectIcons = array(
							'static-project' => 'icon-picture',
							'flex-project'   => 'icon-play-circle',
							'video-project'  => 'icon-film',
							'audio-project'  => 'icon-music',
						);
					$icon = ( ! wm_meta_option( $prefixMeta . 'type' ) ) ? ( '<i class="icon icon-picture"></i>' ) :  ( '<i class="icon ' . $projectIcons[wm_meta_option( $prefixMeta . 'type' )] . '"></i>' );

					$size = explode( 'x', WM_ADMIN_LIST_THUMB );
					$image = ( has_post_thumbnail() ) ? ( get_the_post_thumbnail( null, 'widget' ) ) : ( '' );

					$hasThumb = ( $image ) ? ( ' has-thumb' ) : ( ' no-thumb' );

					echo '<span class="wm-image-container' . $hasThumb . '">';

					if ( get_edit_post_link() )
						edit_post_link( $image );
					else
						echo '<a href="' . get_permalink() . '">' . $image . '</a>';

					edit_post_link( $icon );

					echo '</span>';

				break;
				case $prefix . "link":

					$wm_projectsLink = esc_url( stripslashes( wm_meta_option( $prefixMeta . 'link' ) ) );
					echo '<a href="' . $wm_projectsLink . '" target="_blank">' . $wm_projectsLink . '</a>';

				break;
				case $prefix . "layout":

					$layout = ( 'plain' === wm_meta_option( $prefixMeta . 'single-layout' ) ) ? ( __( 'Post', 'clifden_domain_adm' ) ) : ( __( 'Project', 'clifden_domain_adm' ) );
					edit_post_link( $layout );

				break;
				default:
				break;
			}
		}
	} // /wm_projects_cp_custom_column

?>