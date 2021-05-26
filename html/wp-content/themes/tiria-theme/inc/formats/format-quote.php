<?php
$positions = array(
	'date-special',
	'formaticon',
	);
wm_meta( $positions, 'date-special' );
?>

<div <?php post_class( 'article-content' ); ?>>
	<?php
	if ( is_single() && ! wm_option( 'blog-disable-featured-image' ) && ! wm_meta_option( 'disable-featured-image' ) )
		echo wm_thumb( array( 'size' => 'content-width' ) );

	$positions = array(
		'author',
		'cats',
		'comments',
		);
	wm_meta( $positions );

	$quote       = get_the_content();
	$quote       = preg_replace( '/<blockquote(.*?)>/i', '', $quote );
	$quote       = preg_replace( '/<\/blockquote>/i', '', $quote );

	$sourceName = trim( get_post_meta( get_the_ID(), '_format_quote_source_name', true ) );
	$sourceURL  = trim( get_post_meta( get_the_ID(), '_format_quote_source_url', true ) );
	if ( $sourceURL )
		$sourceName = '<a href="' . esc_url( $sourceURL ) . '" target="_blank">' . $sourceName . '</a>';

	$quoteSource = ( $sourceName ) ? ( $sourceName ) : ( trim( wm_meta_option( 'quoted-author' ) ) );
	if ( $quoteSource )
		$quoteSource = '<cite class="quote-source">&mdash; ' . $quoteSource . '</cite>';
	echo '<blockquote>' . apply_filters( 'wm_default_content_filters', $quote ) . $quoteSource . '</blockquote>';

	if ( is_single() )
		wm_end_post();
	?>
</div>