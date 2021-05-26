<?php
get_header();

$sidebarLayout   = ( wm_meta_option( 'layout' ) ) ? ( wm_meta_option( 'layout' ) ) : ( 'none' );
$overrideSidebar = ( wm_meta_option( 'sidebar' ) && -1 != wm_meta_option( 'sidebar' ) ) ? ( wm_meta_option( 'sidebar' ) ) : ( WM_SIDEBAR_FALLBACK );

if ( is_active_sidebar( $overrideSidebar ) && 'none' != $sidebarLayout ) {
	$sidebarPanes = ( wm_option( 'layout-sidebar-width' ) ) ? ( esc_attr( wm_option( 'layout-sidebar-width' ) ) ) : ( WM_SIDEBAR_WIDTH );

	if ( ' four pane' === $sidebarPanes )
		$mainPanes = ' eight pane';
	elseif ( ' three pane' === $sidebarPanes )
		$mainPanes = ' nine pane';
	else
		$mainPanes = ' seven pane';

	if ( 'left' == $sidebarLayout )
		$mainPanes = ' sidebar-left margin-right' . $mainPanes;
} else {
	$mainPanes    = ' twelve pane';
	$sidebarPanes = '';
}
?>
<div class="wrap-inner">

<article class="main<?php echo $mainPanes; ?>">

	<?php //wm_start_main_content(); ?>

	<?php wm_before_post(); ?>

	<?php wm_start_post(); ?>

	<?php
	if ( 'plain' === wm_meta_option( 'project-single-layout' ) )
		get_template_part( 'inc/loop/loop', 'project-post' );
	else
		get_template_part( 'inc/loop/loop', 'project' );
	?>

	<?php
	wm_before_bottom_meta();

	//Related projects
	if ( ! wm_option( 'layout-no-related-projects' ) && ! wm_meta_option( 'project-no-related' ) ) {

		$cats    = array();
		$count   = ( ! wm_meta_option( 'layout' ) || 'none' === wm_meta_option( 'layout' ) ) ? ( 4 ) : ( 3 );
		$sorting = 'rand';
		$terms   = get_the_terms( $post->ID , 'project-category' );

		if ( ! is_wp_error( $terms ) && $terms ) {
			foreach( $terms as $term ) {
				$cats[] = $term->term_id;
			}
		}

		wp_reset_query();
		$queryArray = array(
			'post_type'      => 'wm_projects',
			'posts_per_page' => $count,
			'orderby'        => $sorting,
			'post__not_in'   => array( get_the_ID() )
			);
		if ( ! empty( $cats ) )
			$queryArray['tax_query'] = array( array(
					'taxonomy' => 'project-category',
					'field'    => 'id',
					'terms'    => $cats
				) );

		$related = new WP_Query( $queryArray );

		if ( $related->have_posts() ) :
		//HTML to display output
		$columnSize = $count;
		$i = 0;
		?>
		<div class="related-projects wrap-projects-shortcode">
			<h3><?php
			$relatedTitle = ( wm_option( 'layout-related-projects-title' ) ) ? ( apply_filters( 'wmhook_single_project_text_related', strip_tags( wm_option( 'layout-related-projects-title' ) ) ) ) : ( apply_filters( 'wmhook_single_project_text_related', __( 'Related projects', 'clifden_domain' ) ) );
			echo $relatedTitle;
			?></h3>

			<?php while ( $related->have_posts() ) : $related->the_post();	?>
				<article class="column col-1<?php
					echo $columnSize;
					if ( ++$i === $columnSize )
						echo ' last';
				?> no-margin">
					<?php
					$projectIcons = array(
							'static-project' => 'icon-picture',
							'flex-project'   => 'icon-play-circle',
							'video-project'  => 'icon-film',
							'audio-project'  => 'icon-music',
						);

					$out     = '';
					$link    = ( wm_meta_option( 'project-link-list' ) ) ? ( esc_url( wm_meta_option( 'project-link' ) ) ) : ( get_permalink() );
					$imgSize = ( wm_option( 'general-projects-image-ratio' ) ) ? ( 'mobile-' . wm_option( 'general-projects-image-ratio' ) ) : ( 'mobile-ratio-169' );
					$icon    = ( ! wm_meta_option( 'project-type' ) ) ? ( 'icon-picture' ) : ( $projectIcons[wm_meta_option( 'project-type' )] );

					if ( has_excerpt() )
						$excerptText = wp_trim_words( get_the_excerpt(), 12, '&hellip;' );
					else
						$excerptText = '';

					$projectOutput = array(
							'thumb'    => wm_thumb( array(
									'class'        => 'post-thumb',
									'size'         => $imgSize,
									'list'         => true,
									'link'         => true,
									'placeholder'  => true,
								) ),
							'type'     => '<a class="project-icon" href="' . $link . '"><i class="' . $icon . '" title="' . get_the_title() . '"></i></a>',
							'title'    => '<h3 class="project-title text-element"><a href="' . $link . '">' . get_the_title() . '</a></h3>',
							'excerpt'  => ( $excerptText ) ? ( '<div class="project-excerpt text-element">' . strip_tags( strip_shortcodes( $excerptText ) ) . '</div>' ) : ( '' ),
						);

					$out .= $projectOutput['thumb'];
					$out .= '<div class="text">';
						$out .= $projectOutput['type'];
						$out .= $projectOutput['title'];
						$out .= $projectOutput['excerpt'];
					$out .= '</div>';
					echo $out;
					?>
				</article>
			<?php endwhile; ?>
		<!-- /related-projects --></div>
		<?php
		endif;

		wp_reset_query();

	} //related projects enabled
	?>

</article> <!-- /main -->

<?php
if ( 'none' != $sidebarLayout ) {
	$class = 'sidebar clearfix sidebar-' . $sidebarLayout . $sidebarPanes;

	wm_sidebar( $overrideSidebar, $class );
}
?>

</div> <!-- /wrap-inner -->
<?php get_footer(); ?>