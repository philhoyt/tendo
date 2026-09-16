<?php
/**
 * Title: Post navigation
 * Slug: tendo/post-navigation
 * Categories: text, tendo
 * Block Types: core/post-navigation-link
 * Description: Previous and next post links above a wide rule.
 *
 * @package tendo
 */

?>
<!-- wp:group {"tagName":"nav","metadata":{"name":"Post Navigation"},"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"ariaLabel":"<?php esc_attr_e( 'Post navigation', 'tendo' ); ?>","layout":{"type":"default"}} -->
<nav class="wp-block-group alignwide" aria-label="<?php esc_attr_e( 'Post navigation', 'tendo' ); ?>" style="margin-top:var(--wp--preset--spacing--50);margin-bottom:var(--wp--preset--spacing--50)"><!-- wp:separator {"className":"is-style-wide"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:group {"metadata":{"name":"Links"},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group"><!-- wp:post-navigation-link {"type":"previous","showTitle":true,"arrow":"arrow"} /-->

<!-- wp:post-navigation-link {"showTitle":true,"arrow":"arrow"} /--></div>
<!-- /wp:group --></nav>
<!-- /wp:group -->
