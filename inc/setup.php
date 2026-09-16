<?php
/**
 * Theme setup.
 *
 * @package tendo
 */

namespace Tendo\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Block themes receive post thumbnails, responsive embeds, editor styles, and
 * HTML5 support automatically, so only the extras are declared here.
 *
 * @since 2.0.0
 * @return void
 */
function setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'tendo', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\setup' );

/**
 * Registers the "Tendo" block pattern category.
 *
 * Patterns that carry the theme's look are tagged with this category in
 * addition to the core category they belong to, so they can be found together.
 *
 * @since 2.0.0
 * @return void
 */
function register_pattern_category() {
	register_block_pattern_category(
		'tendo',
		array(
			'label'       => _x( 'Tendo', 'Block pattern category', 'tendo' ),
			'description' => __( 'Patterns designed for the Tendo theme.', 'tendo' ),
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\\register_pattern_category' );

/**
 * Enqueue the front-end stylesheet.
 *
 * Loads the compiled stylesheet with the version recorded by the build.
 * Falls back to the theme version if the asset file doesn't exist.
 *
 * @since 2.0.0
 * @return void
 */
function enqueue_styles() {
	$style_asset_path = get_template_directory() . '/dist/css/style.asset.php';
	$style_asset      = array(
		'version' => wp_get_theme( get_template() )->get( 'Version' ),
	);

	if ( file_exists( $style_asset_path ) ) {
		$style_asset = require $style_asset_path;
	}

	wp_enqueue_style(
		'tendo-style',
		get_template_directory_uri() . '/dist/css/style.css',
		array(),
		$style_asset['version']
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_styles' );

/**
 * Load the editor stylesheet in the block editors.
 *
 * @since 2.0.0
 * @return void
 */
function add_editor_styles() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'dist/css/editor.css' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\add_editor_styles' );
