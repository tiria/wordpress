<?php if ( have_posts() ) : the_post(); ?>

<?php wm_before_post(); ?>

<div class="article-content">
	<?php wm_start_post(); ?>

	<?php the_content(); ?>

	<div class="sitemap">

		<?php
		$out = array();

		//20 latest blog posts
		echo '<div class="column col-12">';
		query_posts( array(
				'posts_per_page' => 20
			) );

		if ( have_posts() ) {
			$out  = '<h3>' . apply_filters( 'wmhook_sitemap_text_posts', __( 'Latest blog posts', 'clifden_domain' ) ) . '</h3>';
			$out .= '<ul>';
			while ( have_posts() ) :
				the_post();
				$out .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a></li>';
			endwhile;
			$out .= '</ul>';
			echo $out;
		}
		echo '</div>';

		the_widget( 'wm_projects_list', array(
				'title' => apply_filters( 'wmhook_sitemap_text_projects', __( 'Latest projects', 'clifden_domain' ) )
			), array(
				'before_widget' => '<div class="column col-12 last widget wm-projects-list">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
			) );
		?>

		<div class="divider"></div>

		<?php
		//Custom sitemap menu (instead of list of pages)
		$columns   = 2;
		$locations = get_nav_menu_locations();
		$menuObj   = wp_get_nav_menu_object( $locations['sitemap-links'] );
		$menuName  = ( $menuObj ) ? ( $menuObj->name ) : ( '' );
		$outMenu   = wp_nav_menu( array(
				'theme_location'  => 'sitemap-links',
				'menu'            => null,
				'container'       => null,
				'container_class' => null,
				'container_id'    => null,
				'menu_class'      => '',
				'menu_id'         => null,
				'echo'            => false,
				'fallback_cb'     => '',
				'before'          => null,
				'after'           => null,
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '<div class="column col-13"><h3>' . apply_filters( 'wmhook_sitemap_text_menu', $menuName ) . '</h3><ul>%3$s</ul></div>',
				'depth'           => 0,
				'walker'          => ( has_nav_menu( 'sitemap-links' ) ) ? ( new wm_widget_walker() ) : ( null )
			) );

		if ( $outMenu ) {
			$columns = 3;
			echo do_shortcode( $outMenu );
		}
		?>

		<div class="column col-1<?php echo $columns; ?>">
			<h3><?php echo apply_filters( 'wmhook_sitemap_text_categories', __( 'Blog categories', 'clifden_domain' ) ); ?></h3>
			<ul>
			<?php wp_list_categories( array(
				'orderby'      => 'name',
				'hierarchical' => false,
				'show_count'   => true,
				'title_li'     => null
				) ); ?>
			</ul>
		</div>

		<div class="column col-1<?php echo $columns; ?> last">
			<h3><?php echo apply_filters( 'wmhook_sitemap_text_archives', __( 'Monthly archives', 'clifden_domain' ) ); ?></h3>
			<ul>
			<?php wp_get_archives( 'type=monthly&show_post_count=1' ); ?>
			</ul>
		</div>

	</div> <!-- /sitemap -->

	<?php wm_end_post(); ?>
</div>

<?php wp_reset_query(); wm_after_post(); endif; ?>