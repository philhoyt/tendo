<?php
/**
 * Title: Info card
 * Slug: tendo/info-card
 * Categories: text, tendo
 * Keywords: info, card, bio, about, media, text
 * Block Types: core/media-text
 * Viewport width: 1280
 * Description: A dark, wide card with a heading, short text, an outline button, and an image on the right.
 *
 * @package tendo
 */

?>
<!-- wp:group {"metadata":{"name":"Info Card"},"align":"wide","style":{"spacing":{"blockGap":"0","padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}},"elements":{"link":{"color":{"text":"var:preset|color|base"}}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-base-color has-contrast-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:media-text {"align":"wide","mediaPosition":"right"} -->
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
