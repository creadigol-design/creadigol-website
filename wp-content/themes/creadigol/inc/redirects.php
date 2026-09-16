<?php
/**
 * 301 redirects from the old site's URLs.
 *
 * Two mechanisms:
 * 1. The map in the Customizer (Creadigol > Redirects), one "old new" pair per line.
 * 2. Any request for a root-level slug that matches a Work post redirects to /work/<slug>/,
 *    which covers project pages that were posts on the old site.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Known old URLs and where they go. Editors can extend this in the Customizer.
 */
function creadigol_default_redirects_text(): string {
	return implode(
		"\n",
		array(
			'/rar-rebrand-rondo-media/ /work/rownd-a-rownd/',
			'/pen-petrol-rondo-media/ /work/pen-petrol/',
			'/menaitrackandfieldwebsite/ /work/menai-track-and-field/',
			'/codir-to/ /work/codir-to/',
			'/esteddfod/ /work/eisteddfod-esports/',
			'/self-storage-booker/ /work/self-storage-booker/',
			'/branding-design-services/ /studio/',
			'/virtual-production/ /studio/#vedri',
			'/rnd/ /journal/',
			'/what-is-brand-up/ /journal/',
			'/latest/ /journal/',
			'/contact-us/ /contact/',
			'/category/temp/ /work/',
		)
	);
}

/**
 * Parse the map into [old => new].
 */
function creadigol_redirect_map(): array {
	$map = array();
	foreach ( preg_split( '/\r\n|\r|\n/', creadigol_get( 'redirects' ) ) as $line ) {
		$parts = preg_split( '/\s+/', trim( $line ) );
		if ( count( $parts ) >= 2 && str_starts_with( $parts[0], '/' ) ) {
			$map[ trailingslashit( strtolower( $parts[0] ) ) ] = $parts[1];
		}
	}
	return $map;
}

function creadigol_redirects(): void {
	if ( ! is_404() ) {
		return;
	}
	$path = trailingslashit( strtolower( wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH ) ?: '/' ) );
	$home = trailingslashit( wp_parse_url( home_url( '/' ), PHP_URL_PATH ) ?: '/' );
	if ( '/' !== $home && str_starts_with( $path, $home ) ) {
		$path = '/' . ltrim( substr( $path, strlen( $home ) ), '/' );
	}

	$map = creadigol_redirect_map();
	if ( isset( $map[ $path ] ) ) {
		wp_safe_redirect( home_url( $map[ $path ] ), 301 );
		exit;
	}

	// Old flat project URL -> new /work/ URL when a case study with that slug exists.
	$slug = trim( $path, '/' );
	if ( $slug && ! str_contains( $slug, '/' ) ) {
		$work = get_page_by_path( $slug, OBJECT, 'work' );
		if ( $work ) {
			wp_safe_redirect( get_permalink( $work ), 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'creadigol_redirects' );
