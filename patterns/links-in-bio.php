<?php
/**
 * Title: Links in bio
 * Slug: tendo/links-in-bio
 * Categories: buttons, tendo
 * Keywords: links, bio, social, buttons, profile
 * Block Types: core/buttons
 * Viewport width: 1280
 * Description: A centered profile with the site logo, title, tagline, a stack of full-width buttons, and social icons.
 *
 * @package tendo
 */

?>
<!-- wp:group {"metadata":{"name":"Links in Bio"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"400px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)"><!-- wp:site-logo {"width":96,"align":"center"} /-->

<!-- wp:site-title {"level":0,"textAlign":"center"} /-->

<!-- wp:site-tagline {"textAlign":"center"} /-->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:button {"width":100} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Listen to the playlist', 'tendo' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"width":100} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100"><a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Subscribe to the newsletter', 'tendo' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"width":100,"className":"is-style-outline"} -->
<div class="wp-block-button has-custom-width wp-block-button__width-100 is-style-outline"><a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Buy me a coffee', 'tendo' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:social-links {"className":"is-style-logos-only","style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
<ul class="wp-block-social-links is-style-logos-only" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:social-link {"url":"#","service":"instagram"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"spotify"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group -->
