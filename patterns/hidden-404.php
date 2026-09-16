<?php
/**
 * Title: 404
 * Slug: tendo/hidden-404
 * Inserter: no
 *
 * @package tendo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:group {"metadata":{"name":"Page not found"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"600px"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php echo esc_html_x( 'Error 404', 'Small label above the 404 page heading', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php echo esc_html_x( 'Page not found', '404 error page heading', 'tendo' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html_x( 'The page you are looking for doesn\'t exist, or it has been moved. Try searching for it instead.', '404 error page body text', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:pattern {"slug":"tendo/hidden-search"} /--></div>
<!-- /wp:group -->
