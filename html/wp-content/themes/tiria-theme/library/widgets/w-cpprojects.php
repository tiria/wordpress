<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* List portfolio projects
*****************************************************
*/

/**
 * @since    1.0
 * @version  3.0
 */

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_projects_list' );



/*
* Widget registration
*/
function reg_wm_projects_list() {
	register_widget( 'wm_projects_list' );
} // /reg_wm_contact_info





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_projects_list extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id = 'wm-projects-list';
		$name = '<span>' . WM_THEME_NAME . ' ' . __( 'Projects', 'clifden_domain_adm' ) . '</span>';
		$widget_ops = array(
			'classname'   => 'wm-projects-list',
			'description' => __( 'Displays a list of portfolio projects', 'clifden_domain_adm' )
			);
		$control_ops = array();

		//$this->WP_Widget( $id, $name, $widget_ops, $control_ops );
		parent::__construct( $id, $name, $widget_ops, $control_ops );
	} // /__construct



	/*
	*****************************************************
	*      widget options form in admin
	*****************************************************
	*/
	function form( $instance ) {
		extract( $instance );
		$title    = ( isset( $title ) ) ? ( $title ) : ( null );
		$type     = ( isset( $type ) ) ? ( $type ) : ( null );
		$category = ( isset( $category ) ) ? ( $category ) : ( null );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 6 );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays list of projects from all or specific categories.', 'clifden_domain_adm' ); ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'clifden_domain_adm' ); ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'List type:', 'clifden_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
				<?php
				$options = array(
					'rand' => __( 'Random items', 'clifden_domain_adm' ),
					'date' => __( 'Recent items', 'clifden_domain_adm' )
					);
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" '; selected( $type, $optId ); ?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Projects source (category):', 'clifden_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>[]" id="<?php echo $this->get_field_id( 'category' ); ?>" multiple="multiple">
				<?php
				$options = wm_tax_array( array(
						'allCountPost' => 'wm_projects',
						'allText'      => __( 'All projects', 'clifden_domain_adm' ),
						'parentsOnly'  => true,
						'return'       => 'term_id',
						'tax'          => 'project-category',
					) );
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" ';
					if ( is_array( $category ) && in_array( $optId, $category ) )
						echo 'selected="selected"';
					elseif ( ! is_array( $category ) )
						selected( $category, $optId );
					?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
			<small><?php _e( 'Hold down [CTRL] key for multiselection', 'clifden_domain_adm' ) ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Projects count:', 'clifden_domain_adm' ); ?></label><br />
			<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $count; ?>" size="5" maxlength="2" />
		</p>
		<?php
	} // /form



	/*
	*****************************************************
	*      process and save the widget options
	*****************************************************
	*/
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']    = $new_instance['title'];
		$instance['type']     = $new_instance['type'];
		$instance['category'] = $new_instance['category'];
		$count                = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 6 );
		$instance['count']    = $count;

		return $instance;
	} // /update



	/*
	*****************************************************
	*      output the widget content
	*****************************************************
	*/
	/**
	 * @since    1.0
	 * @version  3.0
	 */
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$type     = ( isset( $type ) ) ? ( $type ) : ( 'rand' );
		$count    = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 12 );
		$category = ( isset( $category ) ) ? ( $category ) : ( array() );
		$category = array_filter( $category, 'wm_remove_zero_negative_array' );

		if ( isset( $category ) && is_array( $category ) )
			$category = $category;
		else
			$category = array();

		echo $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title )
			echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;

		wp_reset_query();

		$queryArgs = array(
			'post_type'           => 'wm_projects',
			'ignore_sticky_posts' => 1,
			'posts_per_page'      => $count,
			'orderby'             => $type,
			);
		if ( ! empty( $category ) )
			$queryArgs['tax_query'] = array( array(
				'taxonomy' => 'project-category',
				'field'    => 'id',
				'terms'    => $category
			) );

		$projects = new WP_Query( $queryArgs );
		if ( $projects->have_posts() ) :
			//HTML to display output
			?>
			<div class="portfolio-content">
				<?php
				$imgSize = apply_filters( 'wmhook_widget_' . 'projects' . '_image_size', 'widget' );
				$out     = '';

				while ( $projects->have_posts() ) : $projects->the_post();
					$out_single = apply_filters( 'wmhook_widget_' . 'projects' . '_single_item_custom_output', '', get_the_id() );

					if ( ! $out_single ) {
						$out_single .= '<article title="' . esc_attr( strip_tags( get_the_title() ) ) . '" class="frame">';

							//link setup
								$link       = ( wm_meta_option( 'project-link-list' ) ) ? ( wm_meta_option( 'project-link' ) ) : ( get_permalink() );
								$link_atts  = ( 'target-blank' == wm_meta_option( 'project-link-list' ) ) ? ( ' target="_blank"' ) : ( '' );
								$link_atts .= ( trim( wm_meta_option( 'project-rel-text' ) ) ) ? ( ' rel="' . trim( wm_meta_option( 'project-rel-text' ) ) . '" data-rel="' . trim( wm_meta_option( 'project-rel-text' ) ) . '"' ) : ( ' data-rel=""' );

							//image
								$image = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), $imgSize ) ) : ( array( WM_ASSETS_THEME . 'img/placeholder/widget.png' ) );

								$out_single .= '<div class="image-container"><a href="' . esc_url( $link ) . '"' . $link_atts . '><img src="' . esc_url( $image[0] ) . '" alt="' . esc_attr( get_the_title() ) . '" title="' . esc_attr( get_the_title() ) . '" /></a></div>';

						$out_single .= '</article>';
					}

					$out .= apply_filters( 'wmhook_widget_' . 'projects' . '_single_item_output', $out_single, get_the_id() );
				endwhile;

				echo $out;
				?>
			</div>
		<?php
		endif;
		wp_reset_query();

		echo $after_widget;
	} // /widget
} // /wm_projects_list

?>