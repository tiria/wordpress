<?php
/*
*****************************************************
* WEBMAN'S WORDPRESS THEME FRAMEWORK
* Created by WebMan - www.webmandesign.eu
*
* List of posts
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
add_action( 'widgets_init', 'reg_wm_post_list' );



/*
* Widget registration
*/
function reg_wm_post_list() {
	register_widget( 'wm_post_list' );
} // /reg_wm_contact_info





/*
*****************************************************
*      WIDGET CLASS
*****************************************************
*/
class wm_post_list extends WP_Widget {
	/*
	*****************************************************
	*      widget constructor
	*****************************************************
	*/
	function __construct() {
		$id = 'wm-post-list';
		$name = '<span>' . WM_THEME_NAME . ' ' . __( 'Posts', 'clifden_domain_adm' ) . '</span>';;
		$widget_ops = array(
			'classname'   => 'wm-post-list',
			'description' => __( 'Displays a list of recent, popular, random or upcoming posts with thumbnail images', 'clifden_domain_adm' )
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
	public function form( $instance ) {
		extract( $instance );
		$title         = ( isset( $title ) ) ? ( $title ) : ( null );
		$type          = ( isset( $type ) ) ? ( $type ) : ( null );
		$excerptLength = ( isset( $excerptLength ) ) ? ( absint( $excerptLength ) ) : ( 10 );
		$category      = ( isset( $category ) ) ? ( $category ) : ( null );
		$count         = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 5 );
		$date          = ( isset( $date ) ) ? ( $date ) : ( null );

		//HTML to display widget settings form
		?>
		<p class="wm-desc"><?php _e( 'Displays advanced posts list. You can set multiple post categories, just press [CTRL] key and click the category names.', 'clifden_domain_adm' ) ?></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'clifden_domain_adm' ) ?></label><br />
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'List type:', 'clifden_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>" id="<?php echo $this->get_field_id( 'type' ); ?>">
				<?php
				$options = array(
					'date,DESC,publish'          => __( 'Recent posts', 'clifden_domain_adm' ),
					'comment_count,DESC,publish' => __( 'Popular posts', 'clifden_domain_adm' ),
					'rand,DESC,publish'          => __( 'Random posts', 'clifden_domain_adm' ),
					'date,DESC,future'           => __( 'Upcoming posts', 'clifden_domain_adm' )
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
			<label for="<?php echo $this->get_field_id( 'excerptLength' ); ?>"><?php _e( 'Excerpt length in:', 'clifden_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'excerptLength' ); ?>" id="<?php echo $this->get_field_id( 'excerptLength' ); ?>">
				<?php
				$options = array(
					0  => 0,
					5  => 5,
					10 => 10,
					15 => 15,
					20 => 20,
					25 => 25,
					30 => 30,
					35 => 35,
					40 => 40
					);
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" '; selected( $excerptLength, $optId ); ?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Posts source (category):', 'clifden_domain_adm' ); ?></label><br />
			<select class="widefat" name="<?php echo $this->get_field_name( 'category' ); ?>[]" id="<?php echo $this->get_field_id( 'category' ); ?>" multiple="multiple">
				<?php
				$options = wm_tax_array( array( 'return' => 'term_id' ) );
				foreach ( $options as $optId => $option ) {
					?>
					<option <?php echo 'value="'. $optId . '" ';
					if ( is_array( $category ) && in_array( $optId, $category ) ) {
						echo 'selected="selected"';
					} elseif ( ! is_array( $category ) ) {
						selected( $category, $optId );
					}
					?>><?php echo $option; ?></option>
					<?php
				}
				?>
			</select>
			<small><?php _e( 'Hold down [CTRL] key for multiselection', 'clifden_domain_adm' ) ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Posts count:', 'clifden_domain_adm' ) ?></label><br />
			<input class="text-center" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo $count; ?>" size="5" maxlength="2" />
		</p>

		<p>
			<input id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" type="checkbox" <?php checked( $date, 'on' ); ?>/>
			<label for="<?php echo $this->get_field_id( 'date' ); ?>"><?php _e( 'Disable publish date', 'clifden_domain_adm' ); ?></label>
		</p>
		<?php
	} // /form



	/*
	*****************************************************
	*      process and save the widget options
	*****************************************************
	*/
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']         = $new_instance['title'];
		$instance['type']          = $new_instance['type'];
		$instance['excerptLength'] = absint( $new_instance['excerptLength'] );
		$instance['category']      = $new_instance['category'];
		$count                     = ( 0 < absint( $new_instance['count'] ) ) ? ( absint( $new_instance['count'] ) ) : ( 5 );
		$instance['count']         = $count;
		$instance['date']          = $new_instance['date'];

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
	public function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		$type          = ( isset( $type ) ) ? ( explode( ',', $type ) ) : ( array( 'date', 'DESC', 'publish' ) );
		$excerptLength = ( isset( $excerptLength ) ) ? ( absint( $excerptLength ) ) : ( 10 );
		$count         = ( isset( $count ) && 0 < absint( $count ) ) ? ( absint( $count ) ) : ( 5 );

		if ( isset( $category ) && is_array( $category ) )
			$category = implode( ',', $category );
		elseif ( isset( $category ) )
			$category = $category;
		else
			$category = 0;

		$class = '';
		if ( isset( $date ) )
			$class .= ' no-date';
		if ( 0 === $excerptLength )
			$class .= ' no-excerpt';

		echo $before_widget;

		//if the title is not filled, no title will be displayed
		if ( isset( $title ) && '' != $title && ' ' != $title )
			echo $before_title . apply_filters( 'widget_title', $title ) . $after_title;

		wp_reset_query();

		$posts = new WP_Query( array(
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => 1,
			'orderby'             => $type[0],
			'order'               => $type[1],
			'post_status'         => $type[2],
			'cat'                 => $category,
			) );

		if ( $posts->have_posts() ) :
			//HTML to display output
			?>
			<ul class="<?php echo $class; ?>">
				<?php
				$imgSize = apply_filters( 'wmhook_widget_' . 'posts' . '_image_size', 'widget' );
				$out     = '';

				while ( $posts->have_posts() ) : $posts->the_post();
					$out_single = apply_filters( 'wmhook_widget_' . 'posts' . '_single_item_custom_output', '', get_the_id() );

					if ( ! $out_single ) {
						$out_single .= '<li>';

						//image
						$format   = ( get_post_format() ) ? ( get_post_format() ) : ( 'pencil' );
						$thumb    = ( has_post_thumbnail() ) ? ( wp_get_attachment_image_src( get_post_thumbnail_id(), $imgSize ) ) : ( array( '' ) );
						$image    = ( $thumb[0] ) ? ( $thumb[0] ) : ( WM_ASSETS_THEME . 'img/icons/formats/black/icon-' . $format . '.png' );
						$imgClass = ( $thumb[0] ) ? ( '' ) : ( ' class="icon-format"' );

						$out_single .= '<div class="image-container"><a href="' . get_permalink() . '"><img src="' . esc_url( $image ) . '"' . $imgClass . ' alt="' . get_the_title() . '" title="' . get_the_title() . '" /></a></div>';

						//title
						$out_single .= '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';

						//date
						if ( ! isset( $date ) ) {
							$out_single .= '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="date">' . esc_html( get_the_date() ) . '</time>';
						}

						//excerpt
						if ( isset( $excerptLength ) && $excerptLength ) {
							$excerptText = ( in_array( $format, array( 'quote', 'status' ) ) ) ? ( get_the_content() ) : ( get_the_excerpt() );
							$excerptText = preg_replace( '|\[(.+?)\]|s', '', $excerptText ); //remove shortcodes from excerpt
							$excerptText = wp_trim_words( strip_tags( $excerptText ), $excerptLength, '&hellip;' );

							if ( $excerptText ) {
								$out_single .= '<div class="excerpt">' . $excerptText . '</div>';
							}
						}

						$out_single .= '</li>';
					}

					$out .= apply_filters( 'wmhook_widget_' . 'posts' . '_single_item_output', $out_single, get_the_id() );
				endwhile;

				echo $out;
				?>
			</ul>
			<?php
		endif;
		wp_reset_query();

		echo $after_widget;
	} // /widget

} // /wm_post_list

?>