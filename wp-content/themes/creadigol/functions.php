<?php
/**
 * Creadigol theme bootstrap.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

define( 'CREADIGOL_VERSION', '1.0.0' );
define( 'CREADIGOL_DIR', get_template_directory() );
define( 'CREADIGOL_URI', get_template_directory_uri() );

require CREADIGOL_DIR . '/inc/cpt.php';
require CREADIGOL_DIR . '/inc/meta.php';
require CREADIGOL_DIR . '/inc/customizer.php';
require CREADIGOL_DIR . '/inc/template-tags.php';
require CREADIGOL_DIR . '/inc/performance.php';
require CREADIGOL_DIR . '/inc/redirects.php';
require CREADIGOL_DIR . '/inc/forms.php';
require CREADIGOL_DIR . '/inc/patterns.php';
require CREADIGOL_DIR . '/inc/lang-cy.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require CREADIGOL_DIR . '/inc/cli.php';
}

/**
 * Theme supports, menus, image sizes.
 */
function creadigol_setup(): void {
	load_theme_textdomain( 'creadigol', CREADIGOL_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 400, 'flex-width' => true, 'flex-height' => true ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary (header)', 'creadigol' ),
			'footer'  => __( 'Footer', 'creadigol' ),
		)
	);

	// Tiles are 4:5 on the work index, 16:9 on the home page and case study hero.
	add_image_size( 'creadigol-tile', 1080, 1350, true );
	add_image_size( 'creadigol-wide', 1920, 1080, true );
	add_image_size( 'creadigol-wide-small', 960, 540, true );

	// Palette exposed to the block editor so case study content stays on brand.
	add_theme_support(
		'editor-color-palette',
		array(
			array( 'name' => __( 'Lime', 'creadigol' ), 'slug' => 'lime', 'color' => '#D1DF5F' ),
			array( 'name' => __( 'Charcoal', 'creadigol' ), 'slug' => 'charcoal', 'color' => '#2E2E2E' ),
			array( 'name' => __( 'Paper', 'creadigol' ), 'slug' => 'paper', 'color' => '#F4F5F2' ),
			array( 'name' => __( 'Grey', 'creadigol' ), 'slug' => 'grey', 'color' => '#DADADA' ),
		)
	);
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'disable-custom-gradients' );
}
add_action( 'after_setup_theme', 'creadigol_setup' );

/**
 * Front-end assets: one stylesheet, one script, two self-hosted fonts.
 */
function creadigol_assets(): void {
	wp_enqueue_style( 'creadigol-main', CREADIGOL_URI . '/assets/css/main.css', array(), CREADIGOL_VERSION );
	wp_enqueue_script( 'creadigol-main', CREADIGOL_URI . '/assets/js/main.js', array(), CREADIGOL_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'creadigol_assets' );

/**
 * Preload the two brand fonts when the files are present.
 */
function creadigol_preload_fonts(): void {
	foreach ( array( 'Druk-Web-Bold.woff2', 'Supply-Regular.woff2' ) as $file ) {
		if ( file_exists( CREADIGOL_DIR . '/assets/fonts/' . $file ) ) {
			printf(
				'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
				esc_url( CREADIGOL_URI . '/assets/fonts/' . $file )
			);
		}
	}
}
add_action( 'wp_head', 'creadigol_preload_fonts', 2 );

/**
 * Admin assets for the project details meta box (media picker).
 */
function creadigol_admin_assets( string $hook ): void {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'work' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'creadigol-admin', CREADIGOL_URI . '/assets/js/admin.js', array( 'jquery' ), CREADIGOL_VERSION, true );
	wp_enqueue_style( 'creadigol-admin', CREADIGOL_URI . '/assets/css/admin.css', array(), CREADIGOL_VERSION );
}
add_action( 'admin_enqueue_scripts', 'creadigol_admin_assets' );

/**
 * Body classes used by the stylesheet.
 */
function creadigol_body_class( array $classes ): array {
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	if ( is_singular( 'work' ) ) {
		$classes[] = 'is-case-study';
	}
	return $classes;
}
add_filter( 'body_class', 'creadigol_body_class' );

/**
 * Excerpt length for journal cards.
 */
add_filter( 'excerpt_length', fn() => 28 );
add_filter( 'excerpt_more', fn() => '…' );

/**
 * Create the default discipline terms when the theme is activated.
 */
function creadigol_activate(): void {
	creadigol_seed_disciplines();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'creadigol_activate' );
