<?php
return array(
	'title'      => __( 'Blog Single Column List', 'tendo' ),
	'categories' => array( 'tendo-query' ),
	'content'    => '<!-- wp:query {"queryId":9,"query":{"perPage":"9","pages":0,"offset":0,"postType":"post","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":true}} -->
	<div class="wp-block-query"><!-- wp:post-featured-image {"width":"100%","height":"320px"} /-->
	
	<!-- wp:post-title {"isLink":true} /-->
	
	<!-- wp:post-excerpt {"moreText":"\u003cstrong\u003eread more\u003c/strong\u003e"} /-->
	
	<!-- wp:spacer {"height":32} -->
	<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
	
	<!-- wp:group {"layout":{"type":"flex","allowOrientation":false}} -->
	<div class="wp-block-group"><!-- wp:paragraph -->
	<p>Published:</p>
	<!-- /wp:paragraph -->
	
	<!-- wp:post-date /--></div>
	<!-- /wp:group -->
	
	<!-- wp:group {"layout":{"type":"flex","allowOrientation":false}} -->
	<div class="wp-block-group"><!-- wp:paragraph -->
	<p>Category:</p>
	<!-- /wp:paragraph -->
	
	<!-- wp:post-terms {"term":"category"} /--></div>
	<!-- /wp:group -->
	
	<!-- wp:group {"layout":{"type":"flex","allowOrientation":false}} -->
	<div class="wp-block-group"><!-- wp:paragraph -->
	<p>Tags:</p>
	<!-- /wp:paragraph -->
	
	<!-- wp:post-terms {"term":"post_tag"} /--></div>
	<!-- /wp:group -->
	
	<!-- wp:spacer {"height":32} -->
	<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
	
	<!-- wp:separator {"className":"is-style-wide"} -->
	<hr class="wp-block-separator is-style-wide"/>
	<!-- /wp:separator -->
	
	<!-- wp:spacer {"height":32} -->
	<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
	
	<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"center"}} -->
	<!-- wp:query-pagination-previous /-->
	
	<!-- wp:query-pagination-numbers /-->
	
	<!-- wp:query-pagination-next /-->
	<!-- /wp:query-pagination --></div>
	<!-- /wp:query -->',
);
