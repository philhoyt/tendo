<?php
/**
 * Title: Comments
 * Slug: tendo/comments
 * Categories: text, tendo
 * Block Types: core/comments
 * Description: Comment list with avatars, pagination, and the comment form.
 *
 * @package tendo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:comments {"className":"wp-block-comments-query-loop","style":{"spacing":{"margin":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}}} -->
<div class="wp-block-comments wp-block-comments-query-loop" style="margin-top:var(--wp--preset--spacing--50);margin-bottom:var(--wp--preset--spacing--50)"><!-- wp:comments-title {"level":2} /-->

<!-- wp:comment-template -->
<!-- wp:group {"metadata":{"name":"Comment"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"0","bottom":"var:preset|spacing|40"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:avatar {"size":40} /-->

<!-- wp:group {"metadata":{"name":"Comment Body"},"style":{"spacing":{"blockGap":"var:preset|spacing|20"},"layout":{"selfStretch":"fill","flexSize":null}},"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:group {"metadata":{"name":"Author and Date"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:comment-author-name /-->

<!-- wp:comment-date /--></div>
<!-- /wp:group -->

<!-- wp:comment-content /-->

<!-- wp:group {"metadata":{"name":"Comment Actions"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:comment-reply-link /-->

<!-- wp:comment-edit-link /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:comment-template -->

<!-- wp:comments-pagination {"paginationArrow":"arrow","layout":{"type":"flex","justifyContent":"space-between"}} -->
<!-- wp:comments-pagination-previous /-->

<!-- wp:comments-pagination-numbers /-->

<!-- wp:comments-pagination-next /-->
<!-- /wp:comments-pagination -->

<!-- wp:post-comments-form {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} /--></div>
<!-- /wp:comments -->
