<?php
/**
*****************************************************
* WEBMAN WORDPRESS THEME FRAMEWORK
* Created by WebMan - Oliver Juhás
*
* WordPress Custom Meta Box Generator Class
*
* @version 1.2
*****************************************************
*/

/**
* USAGE:
*
* require_once( 'PATH_TO/meta-box-generator.php' );
*
* $config = array(
* 		'context'            => 'normal',                 //where the meta box appear: normal (default), advanced, side
* 		'fields'             => array(),                  //meta fields setup array
* 		'id'                 => 'demo_meta_box',          //meta box id, unique per meta box
* 		'pages'              => array( 'post', 'page' ),  //post types
* 		'priority'           => 'high',                   //order of meta box: high (default), low
* 		'tabs'               => true,                     //tabbed meta box interface?
* 		'title'              => 'Custom Meta Box',        //meta box title
* 		'visual-wrapper'     => false,                    //wrap the meta form around visual editor?
* 		'visual-wrapper-add' => array(),                  //array of form fields displayed immediately after visual editor on 1st tab
* 	);
*
* $my_meta = new WM_Meta_Box( $config );
*
* $my_meta->Finish();
*/

if ( ! class_exists( 'WM_Meta_Box') && is_admin() ) {
	class WM_Meta_Box {

		/**
		* Holds meta box object
		*
		* @since   1.0
		* @var     object
		* @access  protected
		*/
		protected $_meta_box;

		/**
		* Holds meta box fields setup array
		*
		* @since   1.0
		* @var     array
		* @access  protected
		*/
		protected $_fields;



		/**
		* Constructor
		*
		* @version  1.1
		* @since    1.0
		* @access   public
		* @param    array $meta_box
		*/
		public function __construct( $meta_box ) {
			//if we are not in admin area exit.
			if ( ! is_admin() )
				return;

			//assign meta box values to local variables and add it's missed values.
			$this->_meta_box = $meta_box;
			$this->_fields   = $this->_meta_box['fields'];

			//add missing setup values
			$this->add_missed_values();

			//add metaboxes
			if ( $this->_meta_box['visual-wrapper'] ) {
				add_action( 'edit_form_after_title', array( $this, 'metabox_start' ), 1000 );
				add_action( 'edit_form_after_editor', array( $this, 'metabox_end' ), 1 );
			} else {
				add_action( 'add_meta_boxes', array( $this, 'add' ) );
			}
			add_action( 'save_post', array( $this, 'save' ) );

			//load assets (JS and CSS)
			add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		} // /__construct



		/**
		* Load all JS and CSS
		*
		* @since   1.0
		* @access  public
		*/
		public function load_assets() {
			//only load styles and js when needed
			if ( $this->is_edit_page() ) {
				//styles
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_style( 'fancybox' );
				wp_enqueue_style( 'wm-options-panel-white-label' );
				if ( ! wm_option( 'branding-panel-logo' ) && ! wm_option( 'branding-panel-no-logo' ) )
					wp_enqueue_style( 'wm-options-panel-branded' );
				wp_enqueue_style( 'color-picker' );

				//scripts
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'jquery-ui-slider' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'fancybox' );
				wp_enqueue_script( 'wm-options-panel' );
				wp_enqueue_script( 'color-picker' );
			}
		} // /load_assets



		/**
		* Add meta box on admin edit pages
		*
		* @version  1.2
		* @since    1.0
		* @access   public
		*/
		public function add( $postType ) {
			if ( ! $postType ) global $postType;

			if ( in_array( $postType, $this->_meta_box['pages'] ) )
				add_meta_box(
						$this->_meta_box['id'],      //$id
						$this->_meta_box['title'],   //$title
						array( $this, 'show' ),      //$callback
						$postType,                   //$post_type
						$this->_meta_box['context'], //$context
						$this->_meta_box['priority'] //$priority
						//$callback_args
					);
		} // /add



		/**
		* Callback function to display meta box
		*
		* @version  1.2
		* @since    1.0
		* @access   public
		*/
		public function show( $post ) {
			if ( ! $post ) global $post;

			$pageTpl    = null;
			$tabbed     = ( $this->_meta_box['tabs'] ) ? ( ' jquery-ui-tabs' ) : ( '' );
			$metaFields = $this->_fields;

			if ( 'page' == $post->post_type ) {
				$pageTpl = get_post_meta( $post->ID, '_wp_page_template', true );
				if ( $post->ID == get_option( 'page_for_posts' ) )
					$pageTpl = 'blog-page';
			}

			wp_nonce_field( 'wm-' . $post->post_type . '-metabox-nonce', $post->post_type . '-metabox-nonce' );

			//display meta box form HTML
			$out = '<div class="wm-wrap meta' . $tabbed . '">';

				//tabs
				if ( $tabbed ) {
					$out .= '<ul class="tabs no-js">';
					$i = 0;
					foreach ( $metaFields as $tab ) {
						if ( 'section-open' == $tab['type'] ) {
							++$i;
							$out .= '<li class="item-' . $i . ' ' . $tab['section-id'] . '"><a href="#wm-meta-' . $tab['section-id'] . '">' . $tab['title'] . '</a></li>';
						}
					}
					$out .= '</ul> <!-- /tabs -->';
				}

				echo $out;

				//Content
				wm_render_form( $metaFields, 'meta', $pageTpl );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'clifden_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'clifden_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		} // /show



		/**
		* Opening the meta box wrapping visual editor
		*
		* @version  1.2
		* @since    1.1
		* @access   public
		*/
		public function metabox_start( $post ) {
			if ( ! $post ) global $post;

			if ( ! in_array( $post->post_type, $this->_meta_box['pages'] ) ) {
				return;
			}

			$pageTpl    = null;
			$tabbed     = ( $this->_meta_box['tabs'] ) ? ( ' jquery-ui-tabs' ) : ( '' );
			$metaFields = $this->_fields;

			if ( 'page' == $post->post_type ) {
				$pageTpl = get_post_meta( $post->ID, '_wp_page_template', true );
				if ( $post->ID == get_option( 'page_for_posts' ) )
					$pageTpl = 'blog-page';
			}

			wp_nonce_field( 'wm-' . $post->post_type . '-metabox-nonce', $post->post_type . '-metabox-nonce' );

			//display meta box form HTML
			$out = '<div class="wm-wrap meta meta-special' . $tabbed . '">';

				//tabs
				if ( $tabbed ) {
					$out .= '<ul class="tabs no-js">';
					$out .= '<li class="item-0 visual-editor"><a href="#wm-meta-visual-editor">' . __( 'Content', 'clifden_domain_adm' ) . '</a></li>';
					$i = 0;
					foreach ( $metaFields as $tab ) {
						if ( 'section-open' == $tab['type'] ) {
							$hideThis = null;
							if ( 'page' == $post->post_type && isset( $tab['exclude'] ) && in_array( $pageTpl, $tab['exclude'] ) ) {
								$hideThis = ' hide';
							}
							$out .= '<li class="item-' . ++$i . $hideThis . ' ' . $tab['section-id'] . '"><a href="#wm-meta-' . $tab['section-id'] . '">' . $tab['title'] . '</a></li>';
						}
					}
					$out .= '</ul> <!-- /tabs -->';
				}

			echo $out;

			$editorTabContent = array(
				array(
					"type" => "section-open",
					"section-id" => "visual-editor",
					"exclude" => array( 'page-template/redirect.php', 'tpl-redirect.php' )
				)
			);

			//Content
			wm_render_form( $editorTabContent, 'meta', $pageTpl );
		} // /metabox_start



		/**
		* Closing the meta box wrapping visual editor
		*
		* @version  1.2
		* @since    1.1
		* @access   public
		*/
		public function metabox_end( $post ) {
			if ( ! $post ) global $post;

			if ( ! in_array( $post->post_type, $this->_meta_box['pages'] ) ) {
				return;
			}

			$pageTpl    = null;
			$metaFields = $this->_fields;

			if ( 'page' == $post->post_type ) {
				$pageTpl = get_post_meta( $post->ID, '_wp_page_template', true );
				if ( $post->ID == get_option( 'page_for_posts' ) )
					$pageTpl = 'blog-page';
			}

			$metaFields = array_merge(
				$this->_meta_box['visual-wrapper-add'],
				array(
					array(
						"type" => "section-close"
					)
				),
				$metaFields
			);

			//Content
			wm_render_form( $metaFields, 'meta', $pageTpl );

			echo '<div class="modal-box"><a class="button-primary" data-action="stay">' . __( 'Wait, I need to save my changes first!', 'clifden_domain_adm' ) . '</a><a class="button" data-action="leave">' . __( 'OK, leave without saving...', 'clifden_domain_adm' ) . '</a></div></div> <!-- /wm-wrap -->';
		} // /metabox_end



		/**
		* Save meta box data
		*
		* @version  1.2
		* @since    1.0
		* @param    $post_id [ABSINT]
		* @access   public
		*/
		public function save( $post_id ) {
			global $post, $post_type;
			if ( ! $post_id ) {
				$post_id = $post->ID;
			}

			$post_type_object = get_post_type_object( $post_type );

			if (
				empty( $_POST )
				|| ! is_object( $post )
				|| ( ! in_array( $post_type, $this->_meta_box['pages'] ) )                                           //check post type
				|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )                                 //check revision
				|| ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                                                 //check autosave
				|| ( ! check_admin_referer( 'wm-' . $post_type . '-metabox-nonce', $post_type . '-metabox-nonce' ) ) //check nonce - security
				|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) )                             //check permission
				)
				return $post_id;

			//save each meta field separately
			$fields = $this->_fields;
			if ( isset( $this->_meta_box['visual-wrapper-add'] ) && ! empty( $this->_meta_box['visual-wrapper-add'] ) ) {
				$fields = array_merge( $this->_meta_box['visual-wrapper-add'], $fields );
			}
			wm_save_meta( $post_id, $fields );
		} // /save



		/**
		* Add missed values for meta box.
		*
		* @version  1.1
		* @since    1.0
		* @access   public
		*/
		public function add_missed_values() {
			/*
			'context'  => 'normal',                 //where the meta box appear: normal (default), advanced, side
			'fields'   => array(),                  //meta fields setup array
			'id'       => 'demo_meta_box',          //meta box id, unique per meta box
			'pages'    => array( 'post', 'page' ),  //post types
			'priority' => 'high',                   //order of meta box: high (default), low
			'tabs'     => true,                     //tabbed meta box interface?
			'title'    => 'Custom Meta Box',        //meta box title
			*/

			// Default values for meta box
			$this->_meta_box = array_merge( array(
						'context'            => 'normal',
						'pages'              => array( 'post' ),
						'priority'           => 'high',
						'tabs'               => true,
						'visual-wrapper'     => false,
						'visual-wrapper-add' => array()
					), (array) $this->_meta_box );
		} // /add_missed_values



		/**
		* Check if current page is edit page.
		*
		* @since   1.0
		* @access  public
		*/
		public function is_edit_page() {
			global $current_screen;

			return in_array( $current_screen->id, (array) $this->_meta_box['pages'] );
		} // /is_edit_page


		/**
		* Finish declaration of meta box
		*
		* @since   1.0
		* @access  public
		*/
		public function Finish() {
			$this->add_missed_values();
		}

	}
} // /WM_Meta_Box

?>