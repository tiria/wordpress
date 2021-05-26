<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Custom taxonomies for custom posts
*
* CONTENT:
* - 1) Actions and filters
* - 2) Taxonomies function
*****************************************************
*/





/*
*****************************************************
*      1) ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering taxonomies
		add_action( 'init', 'wm_create_taxonomies', 0 );
		/*
		The init action occurs after the theme's functions file has been included, so if you're looking for terms directly in the functions file, you're doing so before they've actually been registered.
		*/





/*
*****************************************************
*      2) TAXONOMIES FUNCTION
*****************************************************
*/
	/*
	* Custom taxonomies registration
	*/
	if ( ! function_exists( 'wm_create_taxonomies' ) ) {
		function wm_create_taxonomies() {
			$slugProjectCategory = ( wm_option( 'general-permalink-project-category' ) ) ? ( wm_option( 'general-permalink-project-category' ) ) : ( 'project/category' );
			$slugStaffDepartment = ( wm_option( 'general-permalink-staff-department' ) ) ? ( wm_option( 'general-permalink-staff-department' ) ) : ( 'staff/department' );

			//Projects categories
			if ( 'disable' != wm_option( 'general-role-projects' ) )
				register_taxonomy( 'project-category', 'wm_projects', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'project-category',
					'rewrite'           => array( 'slug' => $slugProjectCategory ),
					'labels'            => array(
						'name'          => __( 'Project categories', 'clifden_domain_adm' ),
						'singular_name' => __( 'Project category', 'clifden_domain_adm' ),
						'search_items'  => __( 'Search categories', 'clifden_domain_adm' ),
						'all_items'     => __( 'All categories', 'clifden_domain_adm' ),
						'parent_item'   => __( 'Parent category', 'clifden_domain_adm' ),
						'edit_item'     => __( 'Edit category', 'clifden_domain_adm' ),
						'update_item'   => __( 'Update category', 'clifden_domain_adm' ),
						'add_new_item'  => __( 'Add new category', 'clifden_domain_adm' ),
						'new_item_name' => __( 'New category title', 'clifden_domain_adm' )
					)
				) );

			//Staff departments
			if ( 'disable' != wm_option( 'general-role-staff' ) )
				register_taxonomy( 'department', 'wm_staff', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'department',
					'rewrite'           => array( 'slug' => $slugStaffDepartment ),
					'labels'            => array(
						'name'          => __( 'Departments', 'clifden_domain_adm' ),
						'singular_name' => __( 'Department', 'clifden_domain_adm' ),
						'search_items'  => __( 'Search departments', 'clifden_domain_adm' ),
						'all_items'     => __( 'All departments', 'clifden_domain_adm' ),
						'parent_item'   => __( 'Parent department', 'clifden_domain_adm' ),
						'edit_item'     => __( 'Edit department', 'clifden_domain_adm' ),
						'update_item'   => __( 'Update department', 'clifden_domain_adm' ),
						'add_new_item'  => __( 'Add new department', 'clifden_domain_adm' ),
						'new_item_name' => __( 'New department title', 'clifden_domain_adm' )
					)
				) );

			//Price tables
			if ( 'disable' != wm_option( 'general-role-prices' ) )
				register_taxonomy( 'price-table', 'wm_price', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'price-table',
					'rewrite'           => array( 'slug' => 'price-table' ),
					'labels'            => array(
						'name'          => __( 'Price tables', 'clifden_domain_adm' ),
						'singular_name' => __( 'Price table', 'clifden_domain_adm' ),
						'search_items'  => __( 'Search price table', 'clifden_domain_adm' ),
						'all_items'     => __( 'All price tables', 'clifden_domain_adm' ),
						'parent_item'   => __( 'Parent price table', 'clifden_domain_adm' ),
						'edit_item'     => __( 'Edit price table', 'clifden_domain_adm' ),
						'update_item'   => __( 'Update price table', 'clifden_domain_adm' ),
						'add_new_item'  => __( 'Add new price table', 'clifden_domain_adm' ),
						'new_item_name' => __( 'New price table title', 'clifden_domain_adm' )
					)
				) );

			//FAQ categories
			if ( 'disable' != wm_option( 'general-role-faq' ) )
				register_taxonomy( 'faq-category', 'wm_faq', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'faq-category',
					'rewrite'           => array( 'slug' => 'faq-category' ),
					'labels'            => array(
						'name'          => __( 'FAQ categories', 'clifden_domain_adm' ),
						'singular_name' => __( 'FAQ category', 'clifden_domain_adm' ),
						'search_items'  => __( 'Search FAQ category', 'clifden_domain_adm' ),
						'all_items'     => __( 'All FAQ categories', 'clifden_domain_adm' ),
						'parent_item'   => __( 'Parent FAQ category', 'clifden_domain_adm' ),
						'edit_item'     => __( 'Edit FAQ category', 'clifden_domain_adm' ),
						'update_item'   => __( 'Update FAQ category', 'clifden_domain_adm' ),
						'add_new_item'  => __( 'Add new FAQ category', 'clifden_domain_adm' ),
						'new_item_name' => __( 'New FAQ category title', 'clifden_domain_adm' )
					)
				) );

			//Logos categories
			if ( 'disable' != wm_option( 'general-role-logos' ) )
				register_taxonomy( 'logos-category', 'wm_logos', array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'logos-category',
					'rewrite'           => array( 'slug' => 'logo-category' ),
					'labels'            => array(
						'name'          => __( 'Categories', 'clifden_domain_adm' ),
						'singular_name' => __( 'Category', 'clifden_domain_adm' ),
						'search_items'  => __( 'Search category', 'clifden_domain_adm' ),
						'all_items'     => __( 'All categories', 'clifden_domain_adm' ),
						'parent_item'   => __( 'Parent category', 'clifden_domain_adm' ),
						'edit_item'     => __( 'Edit category', 'clifden_domain_adm' ),
						'update_item'   => __( 'Update category', 'clifden_domain_adm' ),
						'add_new_item'  => __( 'Add new category', 'clifden_domain_adm' ),
						'new_item_name' => __( 'New category title', 'clifden_domain_adm' )
					)
				) );

			//Slides categories
			register_taxonomy( 'slide-category', 'wm_slides', array(
				'hierarchical'      => true,
				'show_in_nav_menus' => false,
				'show_ui'           => true,
				'query_var'         => 'slide-category',
				'rewrite'           => array( 'slug' => 'slide-group' ),
				'labels'            => array(
					'name'          => __( 'Slide groups', 'clifden_domain_adm' ),
					'singular_name' => __( 'Slide group', 'clifden_domain_adm' ),
					'search_items'  => __( 'Search groups', 'clifden_domain_adm' ),
					'all_items'     => __( 'All groups', 'clifden_domain_adm' ),
					'parent_item'   => __( 'Parent group', 'clifden_domain_adm' ),
					'edit_item'     => __( 'Edit group', 'clifden_domain_adm' ),
					'update_item'   => __( 'Update group', 'clifden_domain_adm' ),
					'add_new_item'  => __( 'Add new group', 'clifden_domain_adm' ),
					'new_item_name' => __( 'New group title', 'clifden_domain_adm' )
				)
			) );

			//Content module tags
			register_taxonomy( 'content-module-tag', 'wm_modules', array(
				'hierarchical'      => false,
				'show_in_nav_menus' => false,
				'show_ui'           => true,
				'query_var'         => 'cmtag',
				'rewrite'           => array( 'slug' => 'cmtag' ),
				'labels'            => array(
					'name'          => __( 'Tags', 'clifden_domain_adm' ),
					'singular_name' => __( 'Tag', 'clifden_domain_adm' ),
					'search_items'  => __( 'Search tags', 'clifden_domain_adm' ),
					'all_items'     => __( 'All tags', 'clifden_domain_adm' ),
					'edit_item'     => __( 'Edit tag', 'clifden_domain_adm' ),
					'update_item'   => __( 'Update tag', 'clifden_domain_adm' ),
					'add_new_item'  => __( 'Add new tag', 'clifden_domain_adm' ),
					'new_item_name' => __( 'New tag title', 'clifden_domain_adm' )
				)
			) );
		}
	} // /wm_create_taxonomies

?>