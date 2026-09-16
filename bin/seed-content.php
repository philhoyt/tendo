<?php
/**
 * Seed a development site with content for visual testing. Run with WP-CLI
 * pointed at the site (for Local, use the environment from its site shell):
 *   wp eval-file bin/seed-content.php
 * Safe to re-run: it skips anything it already created (matched by slug).
 */
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/taxonomy.php';

function tendo_seed_image( $slug, $c1, $c2, $w = 1600, $h = 800 ) {
	$slug     = $slug . '-image'; // Keep attachment slugs distinct from post slugs.
	$existing = get_posts( array( 'post_type' => 'attachment', 'name' => $slug, 'posts_per_page' => 1, 'post_status' => 'inherit' ) );
	if ( $existing ) {
		return $existing[0]->ID;
	}
	$im = imagecreatetruecolor( $w, $h );
	for ( $y = 0; $y < $h; $y++ ) {
		$t = $y / $h;
		imageline( $im, 0, $y, $w, $y, imagecolorallocate( $im, (int) ( $c1[0] + ( $c2[0] - $c1[0] ) * $t ), (int) ( $c1[1] + ( $c2[1] - $c1[1] ) * $t ), (int) ( $c1[2] + ( $c2[2] - $c1[2] ) * $t ) ) );
	}
	$ink = imagecolorallocatealpha( $im, 0, 0, 0, 90 );
	for ( $i = 0; $i < 14; $i++ ) {
		imagefilledrectangle( $im, $i * 130, 0, $i * 130 + 40, $h, $ink );
	}
	imagefilledellipse( $im, (int) ( $w * 0.72 ), (int) ( $h / 2 ), (int) ( $h * 0.52 ), (int) ( $h * 0.52 ), imagecolorallocatealpha( $im, 255, 255, 255, 70 ) );
	$upload = wp_upload_dir();
	$path   = trailingslashit( $upload['path'] ) . $slug . '.png';
	imagepng( $im, $path );
	imagedestroy( $im );
	$id = wp_insert_attachment( array( 'post_mime_type' => 'image/png', 'post_title' => $slug, 'post_name' => $slug, 'post_status' => 'inherit' ), $path );
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $path ) );
	return $id;
}

function tendo_seed_post( $args, $image = null, $sticky = false ) {
	$type     = $args['post_type'] ?? 'post';
	$existing = get_posts( array( 'post_type' => $type, 'name' => $args['post_name'], 'posts_per_page' => 1, 'post_status' => 'any' ) );
	if ( $existing ) {
		WP_CLI::log( "skip {$type}: {$args['post_name']}" );
		return $existing[0]->ID;
	}
	$id = wp_insert_post( array_merge( array( 'post_status' => 'publish', 'post_author' => 1 ), $args ) );
	if ( $image ) {
		set_post_thumbnail( $id, $image );
	}
	if ( $sticky ) {
		stick_post( $id );
	}
	WP_CLI::log( "created {$type}: {$args['post_name']} (#{$id})" );
	return $id;
}

$notes  = wp_create_category( 'Notes' );
$design = wp_create_category( 'Design' );

$body = '<!-- wp:paragraph --><p>Vivamus dui risus, convallis eu pretium in, ultrices a urna. Sed velit dui, facilisis ac ipsum vel, auctor viverra nunc. Ut viverra sed diam id vestibulum. Nulla condimentum est lectus, eu ultrices lorem elementum in. Pellentesque quis euismod felis. Curabitur ultrices imperdiet tortor, quis interdum ante vestibulum quis.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">A second thought</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Ut tempus nec felis ut ultrices. Duis sit amet lacus vel nisl posuere gravida. Praesent nec sapien nec ante euismod tincidunt. <a href="#">A link inside the text</a> shows the secondary color.</p><!-- /wp:paragraph --><!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>Keep it simple, keep it readable.</p><!-- /wp:paragraph --><cite>Someone, somewhere</cite></blockquote><!-- /wp:quote --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Primary button</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Outline button</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- wp:separator {"className":"is-style-striped"} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-striped"/><!-- /wp:separator --><!-- wp:paragraph --><p>Last paragraph after a striped separator.</p><!-- /wp:paragraph -->';

$posts = array(
	array( 'Sleep important, says experts', 'sleep-important-says-experts', array( 137, 148, 153 ), array( 54, 69, 79 ), $notes, array( 'minimal', 'notes' ), 3 ),
	array( 'A slow morning in the workshop', 'a-slow-morning-in-the-workshop', array( 229, 228, 226 ), array( 137, 148, 153 ), $design, array( 'craft', 'notes' ), 6 ),
	array( 'What the monospace grid taught me about a very long title that wraps', 'what-the-monospace-grid-taught-me', array( 54, 69, 79 ), array( 0, 0, 0 ), $design, array( 'typography', 'minimal' ), 9 ),
	array( 'Three small tools worth keeping', 'three-small-tools-worth-keeping', array( 200, 200, 200 ), array( 100, 110, 115 ), $notes, array( 'tools' ), 12 ),
	array( 'A post without a featured image', 'a-post-without-a-featured-image', null, null, $notes, array(), 15 ),
	array( 'Older thoughts on quiet interfaces', 'older-thoughts-on-quiet-interfaces', array( 180, 190, 200 ), array( 60, 70, 80 ), $design, array( 'minimal' ), 40 ),
);
$first_id = 0;
foreach ( $posts as $i => $p ) {
	$image = $p[2] ? tendo_seed_image( $p[1], $p[2], $p[3] ) : null;
	$id    = tendo_seed_post(
		array(
			'post_title'    => $p[0],
			'post_name'     => $p[1],
			'post_content'  => $body,
			'post_excerpt'  => 0 === $i ? 'A hand-written excerpt: short, to the point, and shown instead of the automatic one.' : '',
			'post_date'     => gmdate( 'Y-m-d H:i:s', time() - $p[6] * 86400 ),
			'post_category' => array( $p[4] ),
			'tags_input'    => $p[5],
		),
		$image,
		1 === $i
	);
	if ( 0 === $i ) {
		$first_id = $id;
	}
}

if ( $first_id && 0 === (int) get_comments_number( $first_id ) ) {
	$parent = wp_insert_comment( array( 'comment_post_ID' => $first_id, 'comment_author' => 'Ada', 'comment_author_email' => 'ada@example.com', 'comment_content' => 'Lovely post. Thanks for writing it up.', 'comment_approved' => 1, 'comment_date' => gmdate( 'Y-m-d H:i:s', time() - 2 * 86400 ) ) );
	wp_insert_comment( array( 'comment_post_ID' => $first_id, 'comment_author' => 'Grace', 'comment_author_email' => 'grace@example.com', 'comment_content' => 'Agreed. A threaded reply so the nesting can be checked too.', 'comment_approved' => 1, 'comment_parent' => $parent, 'comment_date' => gmdate( 'Y-m-d H:i:s', time() - 86400 ) ) );
	wp_insert_comment( array( 'comment_post_ID' => $first_id, 'comment_author' => 'Linus', 'comment_author_email' => 'linus@example.com', 'comment_content' => 'Second top-level comment with a <a href="#">link</a> and a longer paragraph to see how the comment content wraps at the content width of the theme.', 'comment_approved' => 1 ) );
	WP_CLI::log( 'created 3 comments' );
}

// Pages.
tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'About', 'post_name' => 'about', 'post_content' => '<!-- wp:paragraph --><p>This is the about page. It has a featured image so the page header can be checked.</p><!-- /wp:paragraph -->' ), tendo_seed_image( 'about-header', array( 220, 226, 240 ), array( 80, 88, 108 ) ) );
tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'Contact', 'post_name' => 'contact', 'post_content' => '<!-- wp:paragraph --><p>Say hello.</p><!-- /wp:paragraph -->' ) );

$demo = '<!-- wp:pattern {"slug":"tendo/info-card"} /-->' .
	'<!-- wp:heading --><h2 class="wp-block-heading">Posts grid pattern</h2><!-- /wp:heading -->' .
	'<!-- wp:pattern {"slug":"tendo/query-grid"} /-->' .
	'<!-- wp:heading --><h2 class="wp-block-heading">Badge post terms</h2><!-- /wp:heading -->' .
	'<!-- wp:query {"queryId":30,"query":{"perPage":2,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false}} --><div class="wp-block-query"><!-- wp:post-template --><!-- wp:post-title {"level":3,"isLink":true} /--><!-- wp:post-terms {"term":"post_tag","className":"is-style-post-terms-badge"} /--><!-- /wp:post-template --></div><!-- /wp:query -->';
tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'Patterns', 'post_name' => 'patterns', 'post_content' => $demo ) );

tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'Links', 'post_name' => 'links', 'post_content' => '<!-- wp:pattern {"slug":"tendo/links-in-bio"} /-->', 'page_template' => 'page-no-title' ) );

$blocks = '<!-- wp:paragraph --><p>This page exercises the core blocks. Headings first.</p><!-- /wp:paragraph -->'
	. '<!-- wp:heading {"level":1} --><h1 class="wp-block-heading">Heading one</h1><!-- /wp:heading -->'
	. '<!-- wp:heading --><h2 class="wp-block-heading">Heading two</h2><!-- /wp:heading -->'
	. '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Heading three</h3><!-- /wp:heading -->'
	. '<!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Heading four</h4><!-- /wp:heading -->'
	. '<!-- wp:heading {"level":5} --><h5 class="wp-block-heading">Heading five</h5><!-- /wp:heading -->'
	. '<!-- wp:heading {"level":6} --><h6 class="wp-block-heading">Heading six</h6><!-- /wp:heading -->'
	. '<!-- wp:paragraph --><p>A paragraph with <strong>bold</strong>, <em>italic</em>, <code>inline code</code>, <a href="#">a link</a>, and <s>strikethrough</s>. Then a longer sentence so the measure and line height can be judged against the monospace body face, which runs wide at a hundred characters or so.</p><!-- /wp:paragraph -->'
	. '<!-- wp:paragraph {"dropCap":true} --><p class="has-drop-cap">Drop cap paragraph. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><!-- /wp:paragraph -->'
	. '<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>Unordered item one</li><!-- /wp:list-item --><!-- wp:list-item --><li>Unordered item two<!-- wp:list --><ul class="wp-block-list"><!-- wp:list-item --><li>Nested item</li><!-- /wp:list-item --></ul><!-- /wp:list --></li><!-- /wp:list-item --></ul><!-- /wp:list -->'
	. '<!-- wp:list {"ordered":true} --><ol class="wp-block-list"><!-- wp:list-item --><li>Ordered item one</li><!-- /wp:list-item --><!-- wp:list-item --><li>Ordered item two</li><!-- /wp:list-item --></ol><!-- /wp:list -->'
	. '<!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>A quote block, with a citation below.</p><!-- /wp:paragraph --><cite>Cited person</cite></blockquote><!-- /wp:quote -->'
	. '<!-- wp:pullquote --><figure class="wp-block-pullquote"><blockquote><p>A pull quote, set larger and ruled above and below.</p><cite>Cited person</cite></blockquote></figure><!-- /wp:pullquote -->'
	. "<!-- wp:code --><pre class=\"wp-block-code\"><code>function tendo() {\n\treturn 'code block';\n}</code></pre><!-- /wp:code -->"
	. "<!-- wp:preformatted --><pre class=\"wp-block-preformatted\">Preformatted text\n  keeps   its   spacing.</pre><!-- /wp:preformatted -->"
	. '<!-- wp:table --><figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr><th>Column A</th><th>Column B</th><th>Column C</th></tr></thead><tbody><tr><td>Cell</td><td>Cell</td><td>Cell</td></tr><tr><td>Cell</td><td>Cell</td><td>Cell</td></tr></tbody></table></figure><!-- /wp:table -->'
	. '<!-- wp:table {"className":"is-style-stripes"} --><figure class="wp-block-table is-style-stripes"><table><thead><tr><th>Striped</th><th>Table</th></tr></thead><tbody><tr><td>One</td><td>Two</td></tr><tr><td>Three</td><td>Four</td></tr><tr><td>Five</td><td>Six</td></tr></tbody></table></figure><!-- /wp:table -->'
	. '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Fill button</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Outline button</a></div><!-- /wp:button --></div><!-- /wp:buttons -->'
	. '<!-- wp:separator --><hr class="wp-block-separator has-alpha-channel-opacity"/><!-- /wp:separator -->'
	. '<!-- wp:separator {"className":"is-style-wide"} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-wide"/><!-- /wp:separator -->'
	. '<!-- wp:separator {"className":"is-style-dots"} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-dots"/><!-- /wp:separator -->'
	. '<!-- wp:separator {"className":"is-style-striped"} --><hr class="wp-block-separator has-alpha-channel-opacity is-style-striped"/><!-- /wp:separator -->'
	. '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Column one.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Column two.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Column three.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->'
	. '<!-- wp:group {"className":"is-style-section-contrast","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group is-style-section-contrast" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading --><h2 class="wp-block-heading">Contrast section style</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Text and <a href="#">links</a> inside the section style.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Inverted button</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->'
	. '<!-- wp:details --><details class="wp-block-details"><summary>A details block</summary><!-- wp:paragraph --><p>Hidden until opened.</p><!-- /wp:paragraph --></details><!-- /wp:details -->'
	. '<!-- wp:search {"label":"Search","buttonText":"Search"} /-->'
	. '<!-- wp:latest-posts {"displayPostDate":true} /-->'
	. '<!-- wp:calendar /-->';
tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'Block test', 'post_name' => 'block-test', 'post_content' => $blocks ) );

// A second block test page: media, widgets, and dynamic lists.
$img_a = tendo_seed_image( 'sleep-important-says-experts', array( 137, 148, 153 ), array( 54, 69, 79 ) );
$img_b = tendo_seed_image( 'a-slow-morning-in-the-workshop', array( 229, 228, 226 ), array( 137, 148, 153 ) );
$src_a = wp_get_attachment_image_url( $img_a, 'large' ); $src_b = wp_get_attachment_image_url( $img_b, 'large' );
$content = ''
	. '<!-- wp:paragraph --><p>More blocks: media, widgets, and dynamic lists.</p><!-- /wp:paragraph -->'
	. '<!-- wp:cover {"url":"' . esc_url( $src_a ) . '","id":' . $img_a . ',"dimRatio":50,"isDark":true,"align":"wide","layout":{"type":"constrained"}} --><div class="wp-block-cover alignwide is-dark"><img class="wp-block-cover__image-background wp-image-' . $img_a . '" alt="" src="' . esc_url( $src_a ) . '" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">Cover block</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Text and <a href="#">a link</a> over an image.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Outline on cover</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover -->'
	. '<!-- wp:image {"id":' . $img_a . ',"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="' . esc_url( $src_a ) . '" alt="" class="wp-image-' . $img_a . '"/><figcaption class="wp-element-caption">An image block with a caption.</figcaption></figure><!-- /wp:image -->'
	. '<!-- wp:gallery {"columns":2,"linkTo":"none"} --><figure class="wp-block-gallery has-nested-images columns-2 is-cropped"><!-- wp:image {"id":' . $img_a . ',"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="' . esc_url( $src_a ) . '" alt="" class="wp-image-' . $img_a . '"/><figcaption class="wp-element-caption">First</figcaption></figure><!-- /wp:image --><!-- wp:image {"id":' . $img_b . ',"sizeSlug":"large"} --><figure class="wp-block-image size-large"><img src="' . esc_url( $src_b ) . '" alt="" class="wp-image-' . $img_b . '"/><figcaption class="wp-element-caption">Second</figcaption></figure><!-- /wp:image --><figcaption class="blocks-gallery-caption wp-element-caption">A two-column gallery.</figcaption></figure><!-- /wp:gallery -->'
	. '<!-- wp:media-text {"mediaId":' . $img_b . ',"mediaType":"image"} --><div class="wp-block-media-text is-stacked-on-mobile"><figure class="wp-block-media-text__media"><img src="' . esc_url( $src_b ) . '" alt="" class="wp-image-' . $img_b . ' size-full"/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Media and text</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Content beside an image.</p><!-- /wp:paragraph --></div></div><!-- /wp:media-text -->'
	. "<!-- wp:verse --><pre class=\"wp-block-verse\">A verse block,\nline by line,\nkept as written.</pre><!-- /wp:verse -->"
	. '<!-- wp:quote {"className":"is-style-plain"} --><blockquote class="wp-block-quote is-style-plain"><!-- wp:paragraph --><p>A plain-style quote without the rule.</p><!-- /wp:paragraph --><cite>Cited</cite></blockquote><!-- /wp:quote -->'
	. '<!-- wp:group {"backgroundColor":"tertiary","layout":{"type":"constrained"}} --><div class="wp-block-group has-tertiary-background-color has-background"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Group with a background color</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Should get padding automatically.</p><!-- /wp:paragraph --></div><!-- /wp:group -->'
	. '<!-- wp:paragraph {"backgroundColor":"tertiary"} --><p class="has-tertiary-background-color has-background">A paragraph with a background.</p><!-- /wp:paragraph -->'
	. '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Widgets</h3><!-- /wp:heading -->'
	. '<!-- wp:columns --><div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Categories</h4><!-- /wp:heading --><!-- wp:categories {"showPostCounts":true} /--><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Archives</h4><!-- /wp:heading --><!-- wp:archives /--></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Tag cloud</h4><!-- /wp:heading --><!-- wp:tag-cloud /--><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Page list</h4><!-- /wp:heading --><!-- wp:page-list /--></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Latest comments</h4><!-- /wp:heading --><!-- wp:latest-comments {"commentsToShow":3} /--><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Log in</h4><!-- /wp:heading --><!-- wp:loginout /--></div><!-- /wp:column --></div><!-- /wp:columns -->'
	. '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Latest posts, grid with excerpts</h3><!-- /wp:heading -->'
	. '<!-- wp:latest-posts {"displayPostContent":true,"excerptLength":20,"displayAuthor":true,"displayPostDate":true,"postLayout":"grid","columns":2} /-->'
	. '<!-- wp:details --><details class="wp-block-details"><summary>First details</summary><!-- wp:paragraph --><p>One.</p><!-- /wp:paragraph --></details><!-- /wp:details -->'
	. '<!-- wp:details --><details class="wp-block-details"><summary>Second details, stacked</summary><!-- wp:paragraph --><p>Two.</p><!-- /wp:paragraph --></details><!-- /wp:details -->'
	. '<!-- wp:social-links --><ul class="wp-block-social-links"><!-- wp:social-link {"url":"#","service":"wordpress"} /--><!-- wp:social-link {"url":"#","service":"mastodon"} /--></ul><!-- /wp:social-links -->';
tendo_seed_post( array( 'post_type' => 'page', 'post_title' => 'Block test 2', 'post_name' => 'block-test-2', 'post_content' => $content ) );

// Site settings.
update_option( 'blogdescription', 'A clean and minimalist block theme' );
if ( ! get_option( 'permalink_structure' ) ) {
	update_option( 'permalink_structure', '/%postname%/' );
}
flush_rewrite_rules();
WP_CLI::success( 'Seed complete.' );
