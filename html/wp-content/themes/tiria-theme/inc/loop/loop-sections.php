<?php if ( have_posts() ) : the_post(); ?>

<?php the_content() ?>

<?php wp_reset_query(); endif; ?>

<?php comments_template( null, true ); ?>