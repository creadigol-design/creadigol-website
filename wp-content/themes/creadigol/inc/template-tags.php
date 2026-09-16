<?php
/**
 * Template tags used across the theme.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Bilingual eyebrow: "Gwaith / Work".
 */
function creadigol_eyebrow( string $cy, string $en, string $class = '' ): void {
	printf(
		'<p class="eyebrow %s"><span lang="cy">%s</span><span class="eyebrow__sep" aria-hidden="true">/</span><span lang="en">%s</span></p>',
		esc_attr( $class ),
		esc_html( $cy ),
		esc_html( $en )
	);
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
	if ( $cy && str_starts_with( get_locale(), 'cy' ) ) {
		return $cy;
	}
	return get_the_title( $post_id );
}

/**
 * Summary in the current language.
 */
function creadigol_work_summary( int $post_id ): string {
	$cy = creadigol_work_meta( 'summary_cy', $post_id );
	if ( $cy && str_starts_with( get_locale(), 'cy' ) ) {
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
 * Language switcher. Uses WPML or Polylang when present, otherwise shows the
 * current language only.
 */
function creadigol_language_switcher(): void {
	$current = str_starts_with( get_locale(), 'cy' ) ? 'cy' : 'en';
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

	echo '<div class="lang" aria-label="' . esc_attr__( 'Language', 'creadigol' ) . '">';
	foreach ( array( 'cy' => 'CY', 'en' => 'EN' ) as $code => $label ) {
		$is_current = $code === $current;
		if ( isset( $langs[ $code ] ) && ! $is_current ) {
			printf( '<a class="lang__item" href="%s" hreflang="%s">%s</a>', esc_url( $langs[ $code ] ), esc_attr( $code ), esc_html( $label ) );
		} elseif ( $is_current || isset( $langs[ $code ] ) ) {
			printf( '<span class="lang__item %s" aria-current="%s">%s</span>', $is_current ? 'is-current' : '', $is_current ? 'true' : 'false', esc_html( $label ) );
		}
	}
	echo '</div>';
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
