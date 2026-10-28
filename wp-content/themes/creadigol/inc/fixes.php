<?php
/**
 * One-off content fixes, run from Appearance > Creadigol setup. Each has a preview (nothing
 * saved) and an apply step, and each is safe to run more than once.
 *
 *  - Remove "real time" wording across case studies, journal posts, pages, Project details
 *    and Customizer texts, in English and Welsh ("amser real").
 *  - Archive everything about virtual production: journal posts and pages become Private, so
 *    the public cannot reach them while they stay in wp-admin; the Studio page loses only the
 *    blocks that mention it; nothing is deleted.
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
 * Words that mark something as being about virtual production, in English and Welsh,
 * including the vedri studio name.
 */
function creadigol_vp_pattern(): string {
	return '/virtual[\s-]*production|cynhyrchu rhithwir|rhith-?gynhyrchu|vedr[ií]/iu';
}

/**
 * Everything public that mentions virtual production, sorted into what to archive (journal
 * posts and pages, with their other-language copies) and what to edit instead (pages that
 * must stay up: the front page, the posts page and the Studio page, where only the blocks
 * that mention it are removed).
 *
 * @return array{archive: WP_Post[], edit: WP_Post[]}
 */
function creadigol_vp_content(): array {
	$pattern = creadigol_vp_pattern();
	$keep    = array_filter( array( (int) get_option( 'page_on_front' ), (int) get_option( 'page_for_posts' ) ) );
	foreach ( get_posts( array( 'post_type' => 'page', 'name' => 'studio', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ) ) as $id ) {
		$keep[] = (int) $id;
	}
	$keep_trids = array();
	foreach ( $keep as $id ) {
		$trid = apply_filters( 'wpml_element_trid', null, $id, 'post_page' );
		if ( $trid ) {
			$keep_trids[] = (int) $trid;
		}
	}
	$is_kept = static function ( WP_Post $p ) use ( $keep, $keep_trids ): bool {
		if ( in_array( $p->ID, $keep, true ) ) {
			return true;
		}
		$trid = apply_filters( 'wpml_element_trid', null, $p->ID, 'post_' . $p->post_type );
		return $trid && in_array( (int) $trid, $keep_trids, true );
	};

	$out   = array( 'archive' => array(), 'edit' => array() );
	$posts = get_posts(
		array(
			'post_type'      => array( 'post', 'page' ),
			'post_status'    => array( 'publish', 'future', 'pending' ),
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
	$add = static function ( WP_Post $p ) use ( &$out, $is_kept ): void {
		$out[ $is_kept( $p ) ? 'edit' : 'archive' ][ $p->ID ] = $p;
	};
	foreach ( $posts as $post ) {
		if ( ! preg_match( $pattern, $post->post_title . ' ' . $post->post_content . ' ' . $post->post_excerpt ) ) {
			continue;
		}
		$add( $post );
		// The same post or page in the other language.
		$trid = apply_filters( 'wpml_element_trid', null, $post->ID, 'post_' . $post->post_type );
		if ( $trid ) {
			foreach ( (array) apply_filters( 'wpml_get_element_translations', array(), $trid, 'post_' . $post->post_type ) as $tr ) {
				$tr_p = ! empty( $tr->element_id ) ? get_post( (int) $tr->element_id ) : null;
				if ( $tr_p && in_array( $tr_p->post_status, array( 'publish', 'future', 'pending' ), true ) ) {
					$add( $tr_p );
				}
			}
		}
	}
	return array( 'archive' => array_values( $out['archive'] ), 'edit' => array_values( $out['edit'] ) );
}

/**
 * Remove the blocks (or, in classic content, the headings, paragraphs and list items) that
 * mention virtual production. Blocks that only contain other blocks are kept unless every
 * child goes.
 *
 * @return array{0: string, 1: string[]} New content and the text of what was removed.
 */
function creadigol_vp_strip( string $content ): array {
	$pattern = creadigol_vp_pattern();
	$removed = array();
	if ( function_exists( 'has_blocks' ) && has_blocks( $content ) ) {
		$filter = static function ( array $blocks ) use ( &$filter, &$removed, $pattern ): array {
			$kept = array();
			foreach ( $blocks as $block ) {
				if ( ! empty( $block['innerBlocks'] ) ) {
					$before               = count( $block['innerBlocks'] );
					$block['innerBlocks'] = $filter( $block['innerBlocks'] );
					if ( $block['innerBlocks'] || ! $before ) {
						// Keep innerContent slots in step with the surviving children.
						$slots                 = array_filter( $block['innerContent'], static fn( $c ) => null !== $c );
						$nulls                 = array_fill( 0, count( $block['innerBlocks'] ), null );
						$block['innerContent'] = array_merge( array_slice( $slots, 0, 1 ), $nulls, array_slice( $slots, 1 ) );
						$kept[]                = $block;
					} elseif ( $before ) {
						$removed[] = wp_strip_all_tags( serialize_block( $block ) );
					}
					continue;
				}
				$text = wp_strip_all_tags( (string) ( $block['innerHTML'] ?? '' ) );
				if ( '' !== trim( $text ) && preg_match( $pattern, $text ) ) {
					$removed[] = trim( preg_replace( '/\s+/', ' ', $text ) );
					continue;
				}
				$kept[] = $block;
			}
			return $kept;
		};
		$blocks = $filter( parse_blocks( $content ) );
		return array( serialize_blocks( $blocks ), $removed );
	}
	$new = (string) preg_replace_callback(
		'/<(h[1-6]|p|li)\b[^>]*>.*?<\/\1>\s*/isu',
		static function ( $m ) use ( &$removed, $pattern ) {
			$text = wp_strip_all_tags( $m[0] );
			if ( preg_match( $pattern, $text ) ) {
				$removed[] = trim( preg_replace( '/\s+/', ' ', $text ) );
				return '';
			}
			return $m[0];
		},
		$content
	);
	// Plain-text content (a translation editor's output, say) gets its paragraphs from line
	// breaks rather than tags, so also drop any line that mentions it.
	$lines = preg_split( '/\R/', $new ) ?: array();
	foreach ( $lines as $i => $line ) {
		$text = wp_strip_all_tags( $line );
		if ( '' !== trim( $text ) && preg_match( $pattern, $text ) ) {
			$removed[] = trim( preg_replace( '/\s+/', ' ', $text ) );
			unset( $lines[ $i ] );
		}
	}
	$new = implode( "\n", $lines );
	return array( $new, $removed );
}

/**
 * Archive everything about virtual production. Journal posts and pages become Private
 * (hidden from the public, still in wp-admin, nothing deleted); pages that must stay up lose
 * only the blocks that mention it (recoverable from the page's revisions); the old
 * /virtual-production/ redirect points at /studio/. $dry previews.
 *
 * @return string[] Log lines.
 */
function creadigol_archive_vp( bool $dry ): array {
	$log     = array( $dry ? 'Preview: nothing has been changed.' : 'Archiving.' );
	$content = creadigol_vp_content();
	foreach ( $content['archive'] as $post ) {
		$log[] = sprintf( '%s #%d "%s" (%s) %s', $dry ? '[preview: archive]' : '[archived]', $post->ID, $post->post_title, $post->post_type, get_permalink( $post ) );
		if ( ! $dry ) {
			wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'private' ) );
		}
	}
	foreach ( $content['edit'] as $post ) {
		[ $new, $removed ] = creadigol_vp_strip( (string) $post->post_content );
		if ( ! $removed ) {
			$log[] = sprintf( '[check] #%d "%s": mentions virtual production outside its blocks (title or excerpt). Edit it by hand.', $post->ID, $post->post_title );
			continue;
		}
		$log[] = sprintf( '%s #%d "%s" (%s): %d block%s removed, page stays published', $dry ? '[preview: edit]' : '[edited]', $post->ID, $post->post_title, $post->post_type, count( $removed ), 1 === count( $removed ) ? '' : 's' );
		foreach ( $removed as $text ) {
			$log[] = '      - "' . mb_strimwidth( $text, 0, 110, '…' ) . '"';
		}
		if ( ! $dry ) {
			wp_update_post( wp_slash( array( 'ID' => $post->ID, 'post_content' => $new ) ) );
		}
	}
	// Customizer texts: the old redirect target, and anything else to edit by hand.
	$mods = get_theme_mods();
	foreach ( is_array( $mods ) ? $mods : array() as $key => $value ) {
		if ( ! is_string( $value ) ) {
			continue;
		}
		if ( 'creadigol_redirects' === $key && str_contains( $value, '/studio/#vedri' ) ) {
			$log[] = ( $dry ? '[preview: edit]' : '[edited]' ) . ' Redirect for /virtual-production/ now points at /studio/.';
			if ( ! $dry ) {
				set_theme_mod( $key, str_replace( '/studio/#vedri', '/studio/', $value ) );
			}
		} elseif ( 'creadigol_vedri_url' !== $key && preg_match( creadigol_vp_pattern(), $value ) ) {
			$log[] = sprintf( '[check] Customizer text "%s" mentions virtual production. Edit it by hand in Customise > Creadigol.', $key );
		}
	}
	$n     = count( $content['archive'] );
	$log[] = sprintf(
		'%d item%s %s, %d page%s %s. Archived items are Private: hidden from the public and search engines, still in wp-admin, nothing deleted. Removed blocks are in the page\'s revisions.',
		$n,
		1 === $n ? '' : 's',
		$dry ? 'would be archived' : 'archived',
		count( $content['edit'] ),
		1 === count( $content['edit'] ) ? '' : 's',
		$dry ? 'would be edited' : 'edited'
	);
	return $log;
}

/**
 * Menu items that point at archived (non-public) posts or pages are not shown.
 */
function creadigol_hide_unpublished_menu_items( array $items ): array {
	return array_values(
		array_filter(
			$items,
			static fn( $item ) => 'post_type' !== $item->type || 'publish' === get_post_status( (int) $item->object_id )
		)
	);
}
add_filter( 'wp_nav_menu_objects', 'creadigol_hide_unpublished_menu_items', 5 );
