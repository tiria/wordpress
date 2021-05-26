<?php if ( have_posts() ) : the_post(); ?>

<?php wm_before_post(); ?>

<?php wm_start_post(); ?>

<?php
echo '<div class="article-content">';
	the_content();
echo '</div>';
?>

<?php
if ( ! wm_option( 'social-share-no-projects' ) && ! wm_meta_option( 'project-no-share' ) )
	wm_meta( array( 'sharing' ), 'project-sharing' );
?>

<?php wm_end_post(); ?>

<?php wp_reset_query(); wm_after_post(); endif; ?>

<?php comments_template( null, true ); ?>