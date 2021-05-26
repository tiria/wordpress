<?php
/*
*****************************************************
* TIRIA'S WORDPRESS THEME FRAMEWORK
* Created by Tiria - www.tiria.fr
* Based on Clifden by Webman - www.webmandesign.eu
*
* Display status posts
*****************************************************
*/

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/
add_action( 'widgets_init', 'reg_wm_status_content' );



/*
* Widget registration
*/
function reg_wm_status_content() {
	register_widget( 'wm_status_content' );
} // /reg_wm_status_content





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_status_content extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id         = 'wm-status';
		$name       = '<span>' . WM_THEME_NAME . ' ' . __( 'Status', 'clifden_domain_adm' ) . '</span>';;
		$widget_ops = array(
			'classname'   => 'wm-status',
			'description' => __( 'Displays status posts', 'clifden_domain_adm' )
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
		$title  = ( isset( $title ) ) ? ( $title ) : ( null );
		$date   = ( isset( $date ) ) ? ( $date ) : ( null );
		$count  = ( isset( $count ) ) ? ( $count ) : ( null );
		$speed  = ( isset( $speed ) ) ? ( $speed ) : ( null );
		$layout = ( isset( $layout ) ) ? ( $layout ) : ( null );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays status posts.', 'clifden_domain_adm' ) ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Display date:', 'clifden_domain_adm' ) ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>">
				<option value="" <?php selected( $date, '' ); ?>><?php _e( 'No', 'clifden_domain_adm' ); ?></option>
				<option value="1" <?php selected( $date, '1' ); ?>><?php _e( 'Yes', 'clifden_domain_adm' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Statuses count:', 'clifden_domain_adm' ) ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>">
				<?php
				for ( $i = 1; $i <= 15; $i++ ) {
					echo '<option value="' . $i . '" ' . selected( $count, $i, false ) . '>' . $i . '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'speed' ); ?>"><?php _e( 'Statuses speed:', 'clifden_domain_adm' ) ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'speed' ); ?>" name="<?php echo $this->get_field_name( 'speed' ); ?>">
				<option value="" <?php selected( $speed, '' ); ?>></option>
				<?php
				for ( $i = 1; $i <= 20; $i++ ) {
					echo '<option value="' . $i . '" ' . selected( $speed, $i, false ) . '>' . $i . '</option>';
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout:', 'clifden_domain_adm' ) ?></label><br />
			<select class="widefat" id="<?php echo $this->get_field_id( 'layout' ); ?>" name="<?php echo $this->get_field_name( 'layout' ); ?>">
				<option value="" <?php selected( $layout, '' ); ?>><?php _e( 'Normal', 'clifden_domain_adm' ); ?></option>
				<option value="large" <?php selected( $layout, 'large' ); ?>><?php _e( 'Large and centered', 'clifden_domain_adm' ); ?></option>
			</select>
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

		$instance['title']  = $new_instance['title'];
		$instance['date']   = $new_instance['date'];
		$instance['count']  = $new_instance['count'];
		$instance['speed']  = $new_instance['speed'];
		$instance['layout'] = $new_instance['layout'];

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

		echo do_shortcode( '[status count="' . $count . '" speed="' . $speed . '" layout="' . $layout . '" date="' . $date . '" /]' );

		echo $after_widget;
	} // /widget
} // /wm_status_content

?>