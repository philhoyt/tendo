<?php
/**
 * Block bindings.
 *
 * @package tendo
 */

namespace Tendo\BlockBindings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns the comment count for the current post as a link to its comments.
 *
 * Nothing is returned when there are no comments, so the bound paragraph
 * renders empty (and is hidden by the theme stylesheet).
 *
 * @since 2.0.0
 * @param array     $source_args    Block binding source arguments (unused).
 * @param \WP_Block $block_instance The block being rendered.
 * @return string Link markup, or an empty string.
 */
function comments_cta( $source_args, $block_instance ) {
	unset( $source_args );

	$post_id = isset( $block_instance->context['postId'] ) ? (int) $block_instance->context['postId'] : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$count = (int) get_comments_number( $post_id );

	if ( 0 === $count ) {
		return '';
	}

	$text = sprintf(
		/* translators: %s: number of comments. */
		_n( '%s comment', '%s comments', $count, 'tendo' ),
		number_format_i18n( $count )
	);

	return '<a href="' . esc_url( get_comments_link( $post_id ) ) . '">' . esc_html( $text ) . '</a>';
}

/**
 * Registers the comment count binding source.
 *
 * Bind a paragraph's content to `tendo/comments-cta` inside a Query Loop or
 * single post template to show it.
 *
 * @since 2.0.0
 * @return void
 */
function register_sources() {
	register_block_bindings_source(
		'tendo/comments-cta',
		array(
			'label'              => _x( 'Comment count', 'Block bindings source label', 'tendo' ),
			'get_value_callback' => __NAMESPACE__ . '\\comments_cta',
			'uses_context'       => array( 'postId' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_sources' );
