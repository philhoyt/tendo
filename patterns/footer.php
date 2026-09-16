<?php
/**
 * Title: Footer
 * Slug: tendo/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Viewport width: 1280
 * Description: Social links on the left and a WordPress credit on the right.
 *
 * @package tendo
 */

?>
<!-- wp:group {"metadata":{"name":"Footer"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:group {"metadata":{"name":"Footer Row"},"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:social-links {"className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links is-style-logos-only"><!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"feed"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php printf( /* translators: 1: opening anchor tag, 2: closing anchor tag. */ esc_html__( 'Proudly powered by %1$sWordPress%2$s.', 'tendo' ), '<a href="https://wordpress.org/" rel="nofollow">', '</a>' ); // phpcs:ignore WordPress.WP.CapitalPDangit.MisspelledInText -- The lowercase form is the URL. ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
