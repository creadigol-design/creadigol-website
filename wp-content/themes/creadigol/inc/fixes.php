<?php
/**
 * One-off content fixes, run from Appearance > Creadigol setup. Each has a preview (nothing
 * saved) and an apply step, and each is safe to run more than once.
 *
 *  - Remove "real time" wording across case studies, journal posts, pages, Project details
 *    and Customizer texts, in English and Welsh ("amser real").
 *  - Archive journal posts about virtual production: they become Private, so the public
 *    cannot reach them, while they stay in wp-admin and nothing is deleted.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Rewrite "real time" wording in one piece of text. HTML tags and their attributes are left
 * alone, so links and file names that contain "real-time" keep working.
 *
 * Specific sentences are rewritten first so they still read well; then any remaining
 * "real-time" becomes "live" (Welsh: "amser real" becomes "byw", with the mutation the
 * phrase needs).
 */
function creadigol_realtime_rewrite( string $text ): string {
	if ( '' === $text || ! preg_match( '/real[\s\x{2011}\x{2013}-]*time|amser[\s-]*real/iu', $text ) ) {
		return $text;
	}
	$exact = array(
		// English, sentence by sentence.
		'so everything on screen could run in real time and react live'  => 'so everything on screen could react live',
		'so everything on screen ran in real time and reacted live'      => 'so everything on screen reacted live',
		'What real time actually changes'                                => 'What live rendering actually changes',
		'Real time is unforgiving'                                       => 'Live graphics are unforgiving',
		'Real-time tools put'                                            => 'Game-engine tools put',
		'and other real-time tools'                                      => 'and other game-engine tools',
		// Welsh.
		'redeg mewn amser real ac ymateb yn fyw'                         => 'ymateb yn fyw',
		'yn rhedeg mewn amser real ac yn ymateb yn fyw'                  => 'yn ymateb yn fyw',
		'Beth mae amser real yn ei newid'                                => 'Beth mae rendro byw yn ei newid',
		'Dyw amser real ddim yn maddau'                                  => 'Dyw graffeg fyw ddim yn maddau',
		'offer amser real eraill'                                        => 'offer injan gêm eraill',
		'Mae offer amser real yn rhoi'                                   => 'Mae offer injan gêm yn rhoi',
		'graffeg amser real'                                             => 'graffeg fyw',
		'Graffeg amser real'                                             => 'Graffeg fyw',
		'technoleg amser real'                                           => 'technoleg fyw',
		'darlledu amser real'                                            => 'darlledu byw',
		'rendro amser real'                                              => 'rendro byw',
		'Rendro amser real'                                              => 'Rendro byw',
		'trochol, amser real'                                            => 'trochol, byw',
		'mewn amser real'                                                => 'yn fyw',
		'amser real'                                                     => 'byw',
		'Amser real'                                                     => 'Byw',
	);
	$generic = array(
		'/\b(?:in|at) real[\s\x{2011}\x{2013}-]*time\b/iu' => static fn( $m ) => creadigol_match_case( 'live', $m[0] ),
		'/\breal[\s\x{2011}\x{2013}-]*time\b/iu'           => static fn( $m ) => creadigol_match_case( 'live', $m[0] ),
	);
	$parts = preg_split( '/(<[^>]*>)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	foreach ( $parts as $i => $part ) {
		if ( '' === $part || '<' === $part[0] ) {
			continue;
		}
		$part = str_replace( array_keys( $exact ), array_values( $exact ), $part );
		foreach ( $generic as $pattern => $callback ) {
			$part = (string) preg_replace_callback( $pattern, $callback, $part );
		}
		$parts[ $i ] = $part;
	}
	return implode( '', $parts );
}

/**
 * "live" in the capitalisation of the text it replaces: Real-time -> Live, REAL TIME -> LIVE.
 */
function creadigol_match_case( string $word, string $like ): string {
	$letters = preg_replace( '/[^a-z]/i', '', $like );
	if ( $letters === strtoupper( $letters ) ) {
		return strtoupper( $word );
	}
	if ( ctype_upper( $letters[0] ?? 'a' ) ) {
		return ucfirst( $word );
	}
	return $word;
}

/**
 * Short before/after lines for the log.
 */
function creadigol_fix_snippets( string $before, string $after, int $max = 3 ): array {
	$out  = array();
	$text = wp_strip_all_tags( $before );
	if ( preg_match_all( '/.{0,50}(?:real[\s\x{2011}\x{2013}-]*time|amser[\s-]*real).{0,50}/iu', $text, $m ) ) {
		foreach ( array_slice( $m[0], 0, $max ) as $snip ) {
			$snip  = preg_replace( '/\s+/', ' ', trim( $snip ) );
			$out[] = '      "…' . $snip . '…"  ->  "…' . creadigol_realtime_rewrite( $snip ) . '…"';
		}
	}
	return $out;
}

/**
 * Remove "real time" wording everywhere. $dry previews without saving.
 *
 * @return string[] Log lines.
 */
function creadigol_fix_realtime( bool $dry ): array {
	$log   = array( $dry ? 'Preview: nothing has been saved.' : 'Applying.' );
	$total = 0;
	$posts = get_posts(
		array(
			'post_type'      => array( 'work', 'post', 'page' ),
			'post_status'    => array( 'publish', 'private', 'draft', 'pending', 'future' ),
			'posts_per_page' => -1,
			'orderby'        => 'ID',
			'order'          => 'ASC',
		)
	);
	foreach ( $posts as $post ) {
		$changes = array();
		$update  = array();
		foreach ( array( 'post_title', 'post_content', 'post_excerpt' ) as $field ) {
			$new = creadigol_realtime_rewrite( (string) $post->$field );
			if ( $new !== $post->$field ) {
				$update[ $field ] = $new;
				$changes[]        = str_replace( 'post_', '', $field );
				$snips            = array_merge( $snips ?? array(), creadigol_fix_snippets( (string) $post->$field, $new ) );
			}
		}
		$meta_updates = array();
		if ( 'work' === $post->post_type ) {
			foreach ( get_post_meta( $post->ID ) as $key => $values ) {
				if ( ! str_starts_with( $key, '_creadigol_' ) || ! is_string( $values[0] ?? null ) ) {
					continue;
				}
				$new = creadigol_realtime_rewrite( $values[0] );
				if ( $new !== $values[0] ) {
					$meta_updates[ $key ] = $new;
					$changes[]            = 'Project details: ' . substr( $key, 11 );
					$snips                = array_merge( $snips ?? array(), creadigol_fix_snippets( $values[0], $new ) );
				}
			}
		}
		if ( ! $changes ) {
			continue;
		}
		++$total;
		$log[] = sprintf( '%s #%d "%s" (%s): %s', $dry ? '[preview]' : '[fixed]', $post->ID, $post->post_title, $post->post_type, implode( ', ', $changes ) );
		foreach ( array_slice( $snips ?? array(), 0, 4 ) as $line ) {
			$log[] = $line;
		}
		$snips = array();
		if ( ! $dry ) {
			if ( $update ) {
				$update['ID'] = $post->ID;
				wp_update_post( wp_slash( $update ) );
			}
			foreach ( $meta_updates as $key => $value ) {
				update_post_meta( $post->ID, $key, wp_slash( $value ) );
			}
		}
	}
	// Customizer texts.
	$mods = get_theme_mods();
	foreach ( is_array( $mods ) ? $mods : array() as $key => $value ) {
		if ( ! is_string( $value ) ) {
			continue;
		}
		$new = creadigol_realtime_rewrite( $value );
		if ( $new !== $value ) {
			++$total;
			$log[] = sprintf( '%s Customizer text "%s"', $dry ? '[preview]' : '[fixed]', $key );
			foreach ( creadigol_fix_snippets( $value, $new ) as $line ) {
				$log[] = $line;
			}
			if ( ! $dry ) {
				set_theme_mod( $key, $new );
			}
		}
	}
	$log[] = $total ? sprintf( '%d item%s %s.', $total, 1 === $total ? '' : 's', $dry ? 'would change' : 'changed' ) : 'No "real time" wording found.';
	if ( ! $dry && $total ) {
		$log[] = 'Note: web addresses (slugs) were left as they are so existing links keep working.';
	}
	return $log;
}

/**
 * Journal posts about virtual production, in every language, including the translations of
 * any post that matches.
 *
 * @return WP_Post[]
 */
function creadigol_vp_posts(): array {
	$pattern = '/virtual[\s-]*production|cynhyrchu rhithwir|rhith-?gynhyrchu/iu';
	$found   = array();
	$posts   = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => array( 'publish', 'future', 'pending' ),
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	foreach ( $posts as $post ) {
		if ( preg_match( $pattern, $post->post_title . ' ' . $post->post_content . ' ' . $post->post_excerpt ) ) {
			$found[ $post->ID ] = $post;
			// The same post in the other language.
			$trid = apply_filters( 'wpml_element_trid', null, $post->ID, 'post_post' );
			if ( $trid ) {
				foreach ( (array) apply_filters( 'wpml_get_element_translations', array(), $trid, 'post_post' ) as $tr ) {
					$tr_id = (int) ( $tr->element_id ?? 0 );
					$tr_p  = $tr_id ? get_post( $tr_id ) : null;
					if ( $tr_p && 'post' === $tr_p->post_type && in_array( $tr_p->post_status, array( 'publish', 'future', 'pending' ), true ) ) {
						$found[ $tr_id ] = $tr_p;
					}
				}
			}
		}
	}
	return array_values( $found );
}

/**
 * Archive (make Private) the journal posts about virtual production. $dry previews.
 *
 * @return string[] Log lines.
 */
function creadigol_archive_vp( bool $dry ): array {
	$log   = array( $dry ? 'Preview: nothing has been changed.' : 'Archiving.' );
	$posts = creadigol_vp_posts();
	foreach ( $posts as $post ) {
		$log[] = sprintf( '%s #%d "%s" (%s)', $dry ? '[preview]' : '[archived]', $post->ID, $post->post_title, get_permalink( $post ) );
		if ( ! $dry ) {
			wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'private' ) );
		}
	}
	$n     = count( $posts );
	$log[] = $n
		? sprintf( '%d post%s %s. Archived posts are Private: hidden from the public, still in Posts in wp-admin, nothing deleted.', $n, 1 === $n ? '' : 's', $dry ? 'would be archived' : 'archived' )
		: 'No public journal posts mention virtual production.';
	return $log;
}
