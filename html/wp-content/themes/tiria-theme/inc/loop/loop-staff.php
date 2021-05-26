<?php if ( have_posts() ) : the_post(); ?>
<div class="article-content">
	<?php
	$terms = get_the_terms( $post->ID , 'department' );
	if ( $terms ) {
		$outTerms = $separator = '';
		foreach ( $terms as $term ) {
			$outTerms .= $separator . $term->name;
			$separator = ', ';
		}
		$terms = $outTerms;
	} else {
		$terms = false;
	}

	$out = '<li class="name icon-user" title="' . __( 'Name', 'clifden_domain_adm' ) . '"><strong>' . __( 'Name', 'clifden_domain_adm' ) . ': </strong>' . get_the_title() . '</li>';
	if ( wm_meta_option( 'staff-position' ) )
		$out .= '<li class="position icon-flag" title="' . __( 'Position', 'clifden_domain_adm' ) . '"><strong>' . __( 'Position', 'clifden_domain_adm' ) . ': </strong>' . wm_meta_option( 'staff-position' ) . '</li>';
	if ( $terms )
		$out .= '<li class="department icon-briefcase" title="' . __( 'Department', 'clifden_domain_adm' ) . '"><strong>' . __( 'Department', 'clifden_domain_adm' ) . ': </strong>' . $terms . '</li>';
	if ( wm_meta_option( 'staff-phone' ) )
		$out .= '<li class="phone icon-phone" title="' . __( 'Phone', 'clifden_domain_adm' ) . '"><strong>' . __( 'Phone', 'clifden_domain_adm' ) . ': </strong>' . wm_meta_option( 'staff-phone' ) . '</li>';
	if ( wm_meta_option( 'staff-email' ) )
		$out .= '<li class="email icon-envelope-alt" title="' . __( 'Email', 'clifden_domain_adm' ) . '"><strong>' . __( 'Email', 'clifden_domain_adm' ) . ': </strong><a href="#" data-address="' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '" class="email-nospam">' . wm_nospam( wm_meta_option( 'staff-email' ) ) . '</a></li>';
	if ( wm_meta_option( 'staff-phone' ) )
		$out .= '<li class="linkedin icon-linkedin" title="' . __( 'LinkedIn', 'clifden_domain_adm' ) . '"><strong>' . __( 'LinkedIn', 'clifden_domain_adm' ) . ': </strong><a href="' . esc_url( wm_meta_option( 'staff-linkedin' ) ) . '" target="_blank">' . get_the_title() . '</a></li>';
	if ( wm_meta_option( 'staff-skype' ) )
		$out .= '<li class="skype icon-headphones" title="' . __( 'Skype', 'clifden_domain_adm' ) . '"><strong>' . __( 'Skype', 'clifden_domain_adm' ) . ': </strong><a href="skype:' . sanitize_title( wm_meta_option( 'staff-skype' ) ) . '?call">' . wm_meta_option( 'staff-skype' ) . '</a></li>';
	if ( is_array( wm_meta_option( 'staff-custom-contacts' ) ) ) {
		foreach ( wm_meta_option( 'staff-custom-contacts' ) as $contact ) {
			$out .= '<li class="' . $contact['attr'] . '">' . strip_tags( trim( $contact['val'] ), '<a><img><strong><span><small><em><b><i>' ) . '</li>';
		}
	}

	if ( $out )
		echo '<div class="staff-card alignleft">' . wm_thumb( array( 'size' => 'mobile' ) ) . '<ul>' . $out . '</ul></div>';
	?>

	<?php
	if ( is_single() ) {
		the_content();
	} else {
		echo wm_content_or_excerpt( $post );
	}
	?>
</div>
<?php wp_reset_query(); wm_after_post(); endif; ?>