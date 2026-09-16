<?php
/**
 * Title: Info card
 * Slug: tendo/info-card
 * Categories: text, tendo
 * Keywords: info, card, bio, about, media, text
 * Block Types: core/media-text
 * Viewport width: 1280
 * Description: A wide card in the Contrast section style with a heading, short text, an outline button, and an image on the right.
 *
 * @package tendo
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- wp:group {"metadata":{"name":"Info Card"},"align":"wide","className":"is-style-section-contrast","style":{"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide is-style-section-contrast" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:media-text {"align":"wide","mediaPosition":"right"} -->
<div class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile"><div class="wp-block-media-text__content"><!-- wp:heading {"style":{"spacing":{"margin":{"top":"0"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0"><?php esc_html_e( 'A short introduction', 'tendo' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Use this card to introduce yourself, a project, or a service. Keep it to a sentence or two, then point people to where they can learn more.', 'tendo' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Learn more', 'tendo' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div><figure class="wp-block-media-text__media"></figure></div>
<!-- /wp:media-text --></div>
<!-- /wp:group -->
