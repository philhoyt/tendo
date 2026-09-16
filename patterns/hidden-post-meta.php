<?php
/**
 * Title: Post meta
 * Slug: tendo/hidden-post-meta
 * Inserter: no
 *
 * @package tendo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:group {"metadata":{"name":"Post Meta"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"fontSize":"small","layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group has-small-font-size"><!-- wp:group {"metadata":{"name":"Author"},"style":{"spacing":{"blockGap":"0.5ch"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><?php echo esc_html_x( 'By:', 'Label before the post author name', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-author-name {"isLink":true} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Date"},"style":{"spacing":{"blockGap":"0.5ch"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph -->
<p><?php echo esc_html_x( 'Published:', 'Label before the post date', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"isLink":true} /--></div>
<!-- /wp:group -->

<!-- wp:post-terms {"term":"category","prefix":"<?php echo esc_attr_x( 'Category: ', 'Label before the post categories', 'tendo' ); ?>"} /-->

<!-- wp:post-terms {"term":"post_tag","prefix":"<?php echo esc_attr_x( 'Tags: ', 'Label before the post tags', 'tendo' ); ?>"} /--></div>
<!-- /wp:group -->
