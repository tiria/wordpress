<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Display a Content Module custom post
*****************************************************
*/

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_cpmodules_content' );



/*
* Widget registration
*/
function reg_wm_cpmodules_content() {
	register_widget( 'wm_cpmodules_content' );
} // /reg_wm_cpmodules_content





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_cpmodules_content extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id         = 'wm-content-module';
		$name       = '<span>' . WM_THEME_NAME . ' ' . __( 'Content Module', 'clifden_domain_adm' ) . '</span>';;
		$widget_ops = array(
			'classname'   => 'wm-content-module',
			'description' => __( 'Displays content of the specific Content Module post', 'clifden_domain_adm' )
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
		$title       = ( isset( $title ) ) ? ( $title ) : ( null );
		$moduleTitle = ( isset( $moduleTitle ) ) ? ( $moduleTitle ) : ( null );
		$thumb       = ( isset( $thumb ) ) ? ( $thumb ) : ( null );
		$layout      = ( isset( $layout ) ) ? ( $layout ) : ( null );
		$moduleID    = ( isset( $moduleID ) ) ? ( $moduleID ) : ( null );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays content of the specific Content Module custom post. Please choose the Content Module and set other options.', 'clifden_domain_adm' ) ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<?php
			$contentModules = new WP_Query( array(
				'post_type'      => 'wm_modules',
				'order'          => 'ASC',
				'orderby'        => 'title',
				'posts_per_page' => -1
				) );
			if ( $contentModules->have_posts() ) {
				?>
				<label for="<?php echo $this->get_field_id( 'moduleID' ); ?>"><?php _e( 'Content Module to display:', 'clifden_domain_adm' ) ?></label><br />
				<select class="widefat" id="<?php echo $this->get_field_id( 'moduleID' ); ?>" name="<?php echo $this->get_field_name( 'moduleID' ); ?>">
					<option value="" <?php selected( $moduleID, '' ); ?>><?php _e( '- Select Content Module -', 'clifden_domain_adm' ); ?></option>
				<?php
				while ( $contentModules->have_posts() ) {
					$contentModules->the_post();
					$infomoduleID = get_the_ID();

					$terms = get_the_terms( $infomoduleID , 'content-module-tag' );
					$tags  = '';
					if ( $terms ) {
						$moduleTags = array();
						foreach ( $terms as $term ) {
							if ( isset( $term->name ) )
								$moduleTags[] = $term->name;
						}
						$tags .= sprintf( __( ' (tags: %s)', 'clifden_domain_adm' ), implode( ', ', $moduleTags ) );
					}
					?>
					<option<?php echo ' value="'. $infomoduleID . '" '; selected( $moduleID, $infomoduleID ); ?>><?php the_title(); echo $tags; ?></option>
					<?php
				} ?>
				</select>
				<?php
			} else {
				_e( 'There are no Content Modules to choose from. Please add a new Content Module first.', 'clifden_domain_adm' );
			};
			?>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'moduleTitle' ); ?>" name="<?php echo $this->get_field_name( 'moduleTitle' ); ?>" type="checkbox" <?php checked( $moduleTitle, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'moduleTitle' ); ?>"><?php _e( 'Disable Content Module title', 'clifden_domain_adm' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'thumb' ); ?>" name="<?php echo $this->get_field_name( 'thumb' ); ?>" type="checkbox" <?php checked( $thumb, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'thumb' ); ?>"><?php _e( 'Disable featured image', 'clifden_domain_adm' ); ?></label>
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'layout' ); ?>" value="center" name="<?php echo $this->get_field_name( 'layout' ); ?>" type="checkbox" <?php checked( $layout, 'center' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Use centered text layout', 'clifden_domain_adm' ); ?></label>
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

		$instance['title']       = $new_instance['title'];
		$instance['moduleID']    = absint( $new_instance['moduleID'] );
		$instance['moduleTitle'] = $new_instance['moduleTitle'];
		$instance['thumb']       = $new_instance['thumb'];
		$instance['layout']      = $new_instance['layout'];

		return $instance;
	} // /update



	/*
	*****************************************************
	*      output the widget content
	*****************************************************
	*/
	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		echo $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title )
			echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;

		echo do_shortcode( '[content_module id="' . $moduleID . '" no_thumb="' . $thumb . '" no_title="' . $moduleTitle . '" layout="' . $layout . '" widget="0"]' );

		echo $after_widget;
	} // /widget
} // /wm_cpmodules_content

?>