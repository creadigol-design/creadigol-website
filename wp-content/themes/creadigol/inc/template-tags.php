<?php
/**
 * Template tags used across the theme.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Small mono label above a section.
 */
function creadigol_eyebrow( string $text, string $class = '' ): void {
	printf( '<p class="eyebrow %s">%s</p>', esc_attr( $class ), esc_html( $text ) );
}

/**
 * Is a URL a Vimeo or YouTube link?
 */
function creadigol_is_embed_url( string $url ): bool {
	return (bool) preg_match( '#(vimeo\.com|youtube\.com|youtu\.be)#i', $url );
}

/**
 * A muted looping video element with a poster, or the fallback image.
 * The script plays it on hover/focus (desktop) or when in view (touch).
 */
function creadigol_loop( string $video_url, int $poster_id, string $size, string $alt = '', string $class = '' ): void {
	$poster = $poster_id ? wp_get_attachment_image_url( $poster_id, $size ) : '';
	if ( $video_url && ! creadigol_is_embed_url( $video_url ) ) {
		printf(
			'<video class="loop %s" muted playsinline loop preload="none" %s data-src="%s" aria-label="%s"></video>',
			esc_attr( $class ),
			$poster ? 'poster="' . esc_url( $poster ) . '"' : '',
			esc_url( $video_url ),
			esc_attr( $alt )
		);
		return;
	}
	if ( $poster_id ) {
		echo wp_get_attachment_image( $poster_id, $size, false, array( 'class' => 'loop-image ' . $class, 'alt' => $alt, 'loading' => 'lazy' ) );
		return;
	}
	printf( '<div class="loop-empty %s" role="img" aria-label="%s"></div>', esc_attr( $class ), esc_attr( $alt ) );
}

/**
 * The lower-third caption used on every work tile.
 */
function creadigol_lower_third( int $post_id ): void {
	$client = creadigol_work_meta( 'client', $post_id );
	$terms  = get_the_terms( $post_id, 'discipline' );
	$tags   = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'name' ) : array();
	$meta   = implode( ' · ', array_filter( array_merge( array( $client ), array_slice( $tags, 0, 2 ) ) ) );
	echo '<span class="lower-third">';
	echo '<span class="lower-third__bar" aria-hidden="true"></span>';
	echo '<span class="lower-third__box">';
	if ( $meta ) {
		echo '<span class="lower-third__meta">' . esc_html( $meta ) . '</span>';
	}
	echo '<span class="lower-third__title">' . esc_html( creadigol_work_title( $post_id ) ) . '</span>';
	echo '</span></span>';
}

/**
 * Title in the current language: Welsh title when the site language is cy
 * and one is set, otherwise the post title. WPML and Polylang set the locale.
 */
function creadigol_work_title( int $post_id ): string {
	$cy = creadigol_work_meta( 'title_cy', $post_id );
	if ( $cy && creadigol_is_cy() ) {
		return $cy;
	}
	return get_the_title( $post_id );
}

/**
 * Summary in the current language.
 */
function creadigol_work_summary( int $post_id ): string {
	$cy = creadigol_work_meta( 'summary_cy', $post_id );
	if ( $cy && creadigol_is_cy() ) {
		return $cy;
	}
	$en = creadigol_work_meta( 'summary', $post_id );
	return $en ?: get_the_excerpt( $post_id );
}

/**
 * A work tile: loop or image with a lower-third caption. $ratio is "wide" (16:9) or "tall" (4:5).
 */
function creadigol_tile( int $post_id, string $ratio = 'tall' ): void {
	$size = 'wide' === $ratio ? 'creadigol-wide' : 'creadigol-tile';
	printf( '<a class="tile tile--%s" href="%s">', esc_attr( $ratio ), esc_url( get_permalink( $post_id ) ) );
	creadigol_loop( creadigol_work_meta( 'tile_video', $post_id ), get_post_thumbnail_id( $post_id ), $size, creadigol_work_title( $post_id ), 'tile__media' );
	creadigol_lower_third( $post_id );
	echo '</a>';
}

/**
 * Language tabs: English | Cymraeg. URLs come from WPML or Polylang when
 * present; otherwise from the creadigol_language_urls filter (used by the
 * static preview), otherwise only the current language shows.
 */
function creadigol_language_switcher(): void {
	$current = creadigol_is_cy() ? 'cy' : 'en';
	$langs   = array();

	if ( function_exists( 'icl_get_languages' ) ) {
		foreach ( icl_get_languages( 'skip_missing=0' ) as $lang ) {
			$langs[ $lang['language_code'] ] = $lang['url'];
		}
	} elseif ( function_exists( 'pll_the_languages' ) ) {
		foreach ( pll_the_languages( array( 'raw' => 1 ) ) as $lang ) {
			$langs[ $lang['slug'] ] = $lang['url'];
		}
	}
	$langs = apply_filters( 'creadigol_language_urls', $langs );

	echo '<nav class="lang" aria-label="' . esc_attr__( 'Language', 'creadigol' ) . '">';
	foreach ( array( 'en' => 'English', 'cy' => 'Cymraeg' ) as $code => $label ) {
		$is_current = $code === $current;
		if ( $is_current ) {
			printf( '<span class="lang__item is-current" aria-current="true" lang="%s">%s</span>', esc_attr( $code ), esc_html( $label ) );
		} elseif ( isset( $langs[ $code ] ) ) {
			printf( '<a class="lang__item" href="%s" hreflang="%s" lang="%s">%s</a>', esc_url( $langs[ $code ] ), esc_attr( $code ), esc_attr( $code ), esc_html( $label ) );
		}
	}
	echo '</nav>';
}

/**
 * Split the client strip setting into names.
 */
function creadigol_clients(): array {
	return array_values( array_filter( array_map( 'trim', explode( ',', creadigol_get( 'clients' ) ) ) ) );
}

/**
 * Credits as [role, name] pairs.
 */
function creadigol_credits( int $post_id ): array {
	$out = array();
	foreach ( preg_split( '/\r\n|\r|\n/', creadigol_work_meta( 'credits', $post_id ) ) as $line ) {
		if ( str_contains( $line, ':' ) ) {
			[ $role, $name ] = array_map( 'trim', explode( ':', $line, 2 ) );
			$out[]           = array( $role, $name );
		}
	}
	return $out;
}

/**
 * Next case study, wrapping to the first.
 */
function creadigol_next_work( int $post_id ): ?WP_Post {
	$ids = get_posts(
		array(
			'post_type'      => 'work',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		)
	);
	$i = array_search( $post_id, $ids, true );
	if ( false === $i || count( $ids ) < 2 ) {
		return null;
	}
	return get_post( $ids[ ( $i + 1 ) % count( $ids ) ] );
}

/**
 * Hero film markup for a case study: self-hosted video, an embed, or the tile image.
 */
function creadigol_hero_film( int $post_id ): void {
	$url = creadigol_work_meta( 'hero_video', $post_id );
	echo '<div class="film">';
	if ( $url && creadigol_is_embed_url( $url ) ) {
		echo wp_oembed_get( $url ) ?: '';
	} else {
		creadigol_loop( $url, get_post_thumbnail_id( $post_id ), 'creadigol-wide', creadigol_work_title( $post_id ), 'film__media' );
	}
	echo '</div>';
}

/**
 * The logo. Order of preference: the SVG files in assets/img/ (logo-light.svg
 * for dark backgrounds, logo-dark.svg for light ones), then a custom logo set
 * in the Customizer, then the site name set in Druk.
 */
function creadigol_logo( string $variant = 'light' ): void {
	$file = CREADIGOL_DIR . '/assets/img/logo-' . ( 'dark' === $variant ? 'dark' : 'light' ) . '.svg';
	if ( file_exists( $file ) ) {
		$svg = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( $svg && str_contains( $svg, '<svg' ) ) {
			$svg = preg_replace( '/<\?xml[^>]*\?>|<!DOCTYPE[^>]*>/i', '', $svg );
			$svg = preg_replace( '/<svg\b/', '<svg class="logo logo--' . esc_attr( $variant ) . '" role="img" aria-label="' . esc_attr( get_bloginfo( 'name' ) ) . '"', $svg, 1 );
			echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput -- theme asset.
			return;
		}
	}
	if ( has_custom_logo() ) {
		echo wp_get_attachment_image( get_theme_mod( 'custom_logo' ), 'full', false, array( 'class' => 'logo logo--image', 'alt' => get_bloginfo( 'name' ) ) );
		return;
	}
	echo '<span class="wordmark__tally" aria-hidden="true"></span>' . esc_html( get_bloginfo( 'name' ) );
}
