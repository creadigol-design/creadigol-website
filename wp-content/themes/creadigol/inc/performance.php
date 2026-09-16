<?php
/**
 * Keep the front end light: one stylesheet, one script, no emoji or oEmbed
 * scripts, no jQuery unless a plugin asks for it, block CSS only where blocks render.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

function creadigol_trim_head(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'creadigol_trim_head' );

/**
 * Only load block library CSS on pages that render block content.
 */
function creadigol_block_styles(): void {
	if ( is_admin() ) {
		return;
	}
	if ( ! is_singular() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'global-styles' );
		wp_dequeue_style( 'classic-theme-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'creadigol_block_styles', 100 );

/**
 * Do not ship jQuery to visitors unless another script depends on it.
 */
function creadigol_no_jquery(): void {
	if ( is_admin() ) {
		return;
	}
	global $wp_scripts;
	$needs_jquery = false;
	foreach ( $wp_scripts->queue as $handle ) {
		$deps = $wp_scripts->registered[ $handle ]->deps ?? array();
		if ( in_array( 'jquery', $deps, true ) || in_array( 'jquery-core', $deps, true ) ) {
			$needs_jquery = true;
			break;
		}
	}
	if ( ! $needs_jquery ) {
		wp_dequeue_script( 'jquery' );
	}
}
add_action( 'wp_enqueue_scripts', 'creadigol_no_jquery', 200 );

/**
 * Lazy-load and size images; serve WebP where the server supports it.
 */
add_filter( 'wp_lazy_loading_enabled', '__return_true' );
add_filter( 'big_image_size_threshold', fn() => 2560 );
add_filter( 'image_editor_output_format', fn( $formats ) => array_merge( $formats, array( 'image/jpeg' => 'image/webp' ) ) );

/**
 * Allow MP4 and WebM uploads for loops (some hosts disable video mime types).
 */
add_filter(
	'upload_mimes',
	function ( array $mimes ): array {
		$mimes['mp4']  = 'video/mp4';
		$mimes['webm'] = 'video/webm';
		return $mimes;
	}
);
