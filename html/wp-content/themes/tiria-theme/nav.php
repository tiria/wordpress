<div class="navigation-wrap <?php echo wm_option( 'design-navigation-icons' ); ?>">
	<?php
	if ( ' nav-right' !== wm_option( 'layout-navigation-position' ) )
		echo '<div class="wrap-inner"><div class="twelve pane clearfix">';
	?>

		<nav id="nav-main" class="nav-main" role="navigation"><!-- NAVIGATION -->
			<?php echo apply_filters( 'wmhook_skip_link_content_html', '<a class="invisible" href="#main-title" title="' . __( 'Skip to content', 'clifden_domain' ) . '">' . __( 'Skip to content', 'clifden_domain' ) . '</a>' ); ?>

			<?php
			if ( ! function_exists( 'wm_menu_callback' ) ) {
				function wm_menu_callback() {
					if ( ! is_page_template( 'tpl-landing.php' ) )
						echo '<ul class="menu"><li><a href="' . home_url() . '/wp-admin/nav-menus.php"><span>SET A MENU</span></a></li></ul>';
				}
			} // /wm_menu_callback

			$menuLocationName = 'main-navigation';
			if ( is_page() && is_page_template( 'tpl-landing.php' ) )
				$menuLocationName = 'menu-landing-page-' . get_the_ID();

			//If no menu assigned, falls back to page list menu
			wp_nav_menu( array(
					'theme_location'  => $menuLocationName,
					'menu'            => null,
					'container'       => null,
					'container_class' => null,
					'container_id'    => null,
					'menu_class'      => 'menu',
					'menu_id'         => null,
					'echo'            => true,
					'fallback_cb'     => 'wm_menu_callback',
					'before'          => null,
					'after'           => null,
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
					'depth'           => 0,
					'walker'          => ( has_nav_menu( $menuLocationName ) ) ? ( new wm_main_walker() ) : ( null )
				) );
			?>
		</nav>

	<?php
	if ( ' nav-right' !== wm_option( 'layout-navigation-position' ) )
		echo '</div></div>';
	?>
</div> <!-- /wrap-inner -->