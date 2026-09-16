<?php
/**
 * Title: Posts list
 * Slug: tendo/template-query-loop
 * Categories: query, tendo
 * Block Types: core/query
 * Viewport width: 1280
 * Description: A single-column list of posts with featured image, title, excerpt, and meta, separated by wide rules.
 *
 * @package tendo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[]},"metadata":{"name":"Posts list"},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"default"}} -->
<!-- wp:group {"metadata":{"name":"Post"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"2/1"} /-->

<!-- wp:post-title {"isLink":true} /-->

<!-- wp:post-excerpt {"moreText":"<?php echo esc_attr_x( 'read more', 'Link text after the post excerpt', 'tendo' ); ?>"} /-->

<!-- wp:pattern {"slug":"tendo/hidden-post-meta"} /-->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"tendo/comments-cta"}},"name":"Comment count"},"className":"tendo-comment-count","fontSize":"small"} -->
<p class="tendo-comment-count has-small-font-size"><?php esc_html_e( 'Comments', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:pattern {"slug":"tendo/hidden-no-results"} /-->
<!-- /wp:query-no-results -->

<!-- wp:group {"metadata":{"name":"Pagination"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:query-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:query-pagination-previous {"label":"<?php echo esc_attr_x( 'Newer posts', 'Pagination link to more recent posts', 'tendo' ); ?>"} /-->

<!-- wp:query-pagination-next {"label":"<?php echo esc_attr_x( 'Older posts', 'Pagination link to less recent posts', 'tendo' ); ?>"} /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:group --></div>
<!-- /wp:query -->
