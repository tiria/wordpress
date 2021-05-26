<?php
wp_reset_query();

$thisPageId = null;

if ( have_posts() ) {
?>
	<?php wm_before_list(); ?>

	<section class="list-articles list-search">

		<?php
		$odd               = 'odd';
		$thumbPostFormats  = array( 'image', 'standard' );
		$noBodyPostFormats = array( 'link', 'status' );

		$order = 1;
		$page  = ( get_query_var( 'paged' ) ) ? ( get_query_var( 'paged' ) ) : ( 1 );

		if ( $page > 1 )
			$order = ( ( $page - 1 ) * get_query_var( 'posts_per_page' ) ) + 1;

		while ( have_posts() ) :
			the_post();

			$format  = ( get_post_format() ) ? ( get_post_format() ) : ( 'standard' );
			$sticky  = ( is_sticky() ) ? ( ' sticky-post' ) : ( '' );
			$classes = ( $format || $odd || $sticky ) ? ( ' class="' . $odd . $sticky . ' format-' . $format . '"' ) : ( '' );
			$countOK = true;
			$out     = '';

				//Post formats in list
				if ( 'page' === $post->post_type ) {
				//Page

					$allowed = ( wm_option( 'general-client-area' ) ) ? ( wm_restriction_page() ) : ( true );
					if ( $allowed ) {
					//display only unrestricted pages

						$titleWithImage = '';
						if ( has_post_thumbnail()) {
							$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
							$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
							$titleWithImage .= '</a>';
						}
						$titleWithImage .= '<a href="' . get_permalink() . '">';
						$titleWithImage .= get_the_title();
						$titleWithImage .= '</a>';

						$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>' . wm_more( 'nobtn', false );

					} else {
					//do not display count and "odd" class when access to the page is restricted

						$countOK = false;

					}

				} elseif ( 'link' === $format ) {
				//Link post

					$link      = ( wm_meta_option( 'link-url' ) ) ? ( wm_meta_option( 'link-url' ) ) : ( '#' );
					$newWindow = ( wm_meta_option( 'link-target' ) ) ? ( ' target="_blank"' ) : ( null );

					$titleWithImage = '';
					if ( has_post_thumbnail()) {
						$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
						$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
						$titleWithImage .= '</a>';
					}
					$titleWithImage .= '<a href="' . get_permalink() . '">';
					$titleWithImage .= get_the_title();
					$titleWithImage .= '</a>';

					$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>';
					$out .= '<div class="article-content">';
						$out .= wm_meta( array( 'date' ), null, 'footer', false );
						$out .= '<h3 class="mt0 link"><strong>' . __( 'Link:', 'clifden_domain' ) . '</strong> <a href="' . esc_url( $link ) . '"' . $newWindow . '>' . $link . '</a></h3>';
						$out .= '<p>' . strip_tags( get_the_excerpt() ) . '</p>';
					$out .= '</div>';

				} elseif ( 'quote' === $format ) {
				//Quote post

					$out .= '<div class="article-content">';
						$out .= wm_meta( array( 'date' ), null, 'footer', false );

						$quote       = get_the_content();
						$quote       = preg_replace( '/<blockquote(.*?)>/i', '', $quote );
						$quote       = preg_replace( '/<\/blockquote>/i', '', $quote );
						$quoteSource = ( wm_meta_option( 'quoted-author' ) ) ? ( '<cite class="quote-source">&mdash; ' . wm_meta_option( 'quoted-author' ) . '</cite>' ) : ( '' );

						$out .= '<blockquote>' . apply_filters( 'wm_default_content_filters', $quote ) . $quoteSource . '</blockquote>';
					$out .= '</div>';

				} elseif ( 'status' === $format ) {
				//Status post

					$out .= '<div class="article-content">';
						$out .= wm_meta( array( 'date' ), null, 'footer', false );
						$out .= '<div class="status">' . get_the_content() . '</div>';
					$out .= '</div>';

				} elseif ( 'video' === $format ) {
				//Video post

					$titleWithImage = '';
					if ( has_post_thumbnail()) {
						$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
						$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
						$titleWithImage .= '</a>';
					}
					$titleWithImage .= '<a href="' . get_permalink() . '">';
					$titleWithImage .= get_the_title();
					$titleWithImage .= '</a>';

					$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>';
					$out .= '<div class="article-content">';

						if ( wm_meta_option( 'video-url' ) ) {
							$imageSrc = array( '' );
							if ( has_post_thumbnail() )
								$imageSrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'ratio-169' );

							$out .= do_shortcode( '[video url="' . esc_url( wm_meta_option( 'video-url' ) ) . '" player_preview="' . $imageSrc[0] . '" /]' );
						}

						$out .= wm_meta( array( 'date' ), null, 'footer', false );

						if ( get_the_excerpt() )
							$out .= '<div class="excerpt"><p>' . strip_tags( apply_filters( 'convert_chars', get_the_excerpt() ) ) . '</p> ' . wm_more( 'nobtn', false ) . '</div>';

					$out .= '</div>';

				} elseif ( 'audio' === $format ) {
				//Audio post

					$titleWithImage = '';
					if ( has_post_thumbnail()) {
						$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
						$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
						$titleWithImage .= '</a>';
					}
					$titleWithImage .= '<a href="' . get_permalink() . '">';
					$titleWithImage .= get_the_title();
					$titleWithImage .= '</a>';

					$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>';
					$out .= '<div class="article-content">';

						$audioURL = wm_meta_option( 'audio-url' );
						$player   = '';

						if ( has_post_thumbnail() ) {
							$imageSrc  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'content-width' );
							$player    = ( $imageSrc ) ? ( ' album_art="' . esc_url( $imageSrc[0] ) . '"' ) : ( '' );
						}

						if ( $audioURL )
							$out .= do_shortcode( '[audio url="' . esc_url( $audioURL ) . '"' . $player . ']' );

						$out .= wm_meta( array( 'date' ), null, 'footer', false );

						if ( get_the_excerpt() )
							$out .= '<div class="excerpt"><p>' . strip_tags( apply_filters( 'convert_chars', get_the_excerpt() ) ) . '</p> ' . wm_more( 'nobtn', false ) . '</div>';

					$out .= '</div>';

				} else {
				//Other posts

					$titleWithImage = '';
					if ( has_post_thumbnail()) {
						$titleWithImage .= '<a href="' . get_permalink() . '" title="' . esc_attr( get_the_title() ) . '" class="alignright frame">';
						$titleWithImage .= get_the_post_thumbnail( null, 'widget' );
						$titleWithImage .= '</a>';
					}
					$titleWithImage .= '<a href="' . get_permalink() . '">';
					$titleWithImage .= get_the_title();
					$titleWithImage .= '</a>';

					$out .= '<h2 class="post-title">' . $titleWithImage . '</h2>';
					$out .= '<div class="article-content">';

						$out .= wm_meta( array( 'date' ), null, 'footer', false );

						if ( get_the_excerpt() )
							$out .= '<div class="excerpt"><p>' . strip_tags( apply_filters( 'convert_chars', get_the_excerpt() ) ) . '</p> ' . wm_more( 'nobtn', false ) . '</div>';

					$out .= '</div>';

				}

			//the actual output
			if ( $out && $countOK ) {
				echo '<article' . $classes . '><span class="numbering">' . $order . '</span>' . $out . '</article>';

				if ( 'odd' == $odd )
					$odd = '';
				else
					$odd = 'odd';

				$order++;
			}
		endwhile;
		?>

	</section> <!-- /list-articles -->

	<?php wm_after_list(); ?>

<?php
} else {
	wm_not_found();
}
wp_reset_query();
?>