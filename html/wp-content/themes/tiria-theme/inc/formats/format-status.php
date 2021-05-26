<?php
$positions = array(
	'date-special',
	'formaticon',
	);
wm_meta( $positions, 'date-special' );
?>

<?php
if ( get_the_content() ) {
	echo '<div class="' . esc_attr( implode( ' ', get_post_class( 'article-content' ) ) ) . '">';
		if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
			echo wm_thumb( array( 'size' => 'content-width' ) );
		$positions = array(
			'author',
			'cats',
			'comments',
			);
		wm_meta( $positions );
		echo '<div class="status">' . apply_filters( 'wm_default_content_filters', get_the_content() ) . '</div>';
	echo '</div>';
} else {
	echo do_shortcode( '[box color="red" icon="warning"]' . __( 'Please place the status into the post content area', 'clifden_domain' ) . '[/box]' );
}

?>