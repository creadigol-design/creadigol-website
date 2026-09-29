<?php
/**
 * Case studies bundled with the theme, imported from wp-admin in one click.
 *
 * Each folder in import/ holds a case.json and its media. Appearance > Creadigol setup
 * lists them with an Import button. Importing is idempotent: it finds the Work post by
 * slug and updates it, and reuses media it has already uploaded (tracked by the
 * _creadigol_import meta on each attachment), so pressing the button twice is safe.
 *
 * case.json:
 *   slug, title, date, excerpt, disciplines[], thumbnail, content, meta{}, media[]
 * Media files are referenced in content and meta as {{media:filename}} tokens, replaced
 * with the uploaded attachment URLs on import.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * The importable case studies shipped with the theme.
 */
function creadigol_imports(): array {
	$out = array();
	foreach ( glob( CREADIGOL_DIR . '/import/*/case.json' ) ?: array() as $file ) {
		$data = json_decode( (string) file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( ! is_array( $data ) || empty( $data['slug'] ) ) {
			continue;
		}
		$data['dir']      = dirname( $file );
		$data['existing'] = creadigol_find_work( $data['slug'] );
		$out[ $data['slug'] ] = $data;
	}
	return $out;
}

/**
 * A Work post by slug, in any status except trash.
 */
function creadigol_find_work( string $slug ): ?WP_Post {
	$found = get_posts(
		array(
			'post_type'      => 'work',
			'name'           => $slug,
			'post_status'    => array( 'publish', 'draft', 'private', 'pending', 'future' ),
			'posts_per_page' => 1,
		)
	);
	return $found[0] ?? null;
}

/**
 * An attachment this importer uploaded before, by its import key.
 */
function creadigol_find_import_attachment( string $key ): int {
	$found = get_posts(
		array(
			'post_type'      => 'attachment',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_creadigol_import', // phpcs:ignore WordPress.DB.SlowDBQuery
			'meta_value'     => $key, // phpcs:ignore WordPress.DB.SlowDBQuery
		)
	);
	return (int) ( $found[0] ?? 0 );
}

/**
 * Import (or re-import) one bundled case study.
 *
 * @return string[] Log lines.
 */
function creadigol_import_case_study( string $slug ): array {
	$imports = creadigol_imports();
	if ( ! isset( $imports[ $slug ] ) ) {
		return array( sprintf( 'No bundled case study called "%s".', $slug ) );
	}
	$case = $imports[ $slug ];
	$log  = array();

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	creadigol_seed_disciplines();
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}

	// 1. The post shell, so media can be attached to it.
	$postarr = array(
		'post_type'    => 'work',
		'post_title'   => $case['title'],
		'post_name'    => $case['slug'],
		'post_status'  => 'publish',
		'post_excerpt' => $case['excerpt'] ?? '',
		'post_content' => '',
	);
	if ( ! empty( $case['date'] ) ) {
		$postarr['post_date']     = $case['date'];
		$postarr['post_date_gmt'] = get_gmt_from_date( $case['date'] );
	}
	if ( $case['existing'] ) {
		$postarr['ID'] = $case['existing']->ID;
		$post_id       = wp_update_post( $postarr, true );
		$log[]         = sprintf( 'Updated "%s" (post %d).', $case['title'], $postarr['ID'] );
	} else {
		$post_id = wp_insert_post( $postarr, true );
		$log[]   = sprintf( 'Created "%s".', $case['title'] );
	}
	if ( is_wp_error( $post_id ) ) {
		$log[] = 'Could not save the post: ' . $post_id->get_error_message();
		return $log;
	}

	// 2. Media: upload once, reuse after.
	$ids  = array();
	$urls = array();
	foreach ( (array) ( $case['media'] ?? array() ) as $file ) {
		$path = $case['dir'] . '/' . $file;
		$key  = $slug . '/' . $file;
		if ( ! file_exists( $path ) ) {
			$log[] = sprintf( 'Missing in the theme folder, skipped: %s', $file );
			continue;
		}
		$att = creadigol_find_import_attachment( $key );
		if ( ! $att ) {
			$tmp = wp_tempnam( $file );
			if ( ! $tmp || ! copy( $path, $tmp ) ) {
				$log[] = sprintf( 'Could not stage %s for upload.', $file );
				continue;
			}
			$att = media_handle_sideload( array( 'name' => $file, 'tmp_name' => $tmp ), $post_id );
			if ( is_wp_error( $att ) ) {
				$log[] = sprintf( 'Upload failed for %s: %s', $file, $att->get_error_message() );
				@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
				continue;
			}
			update_post_meta( $att, '_creadigol_import', $key );
			$log[] = sprintf( 'Uploaded %s.', $file );
		} else {
			$log[] = sprintf( 'Reused %s from the media library.', $file );
		}
		$ids[ $file ]  = (int) $att;
		$urls[ $file ] = wp_get_attachment_url( $att );
	}

	$replace = static function ( string $text ) use ( $urls ): string {
		return (string) preg_replace_callback( '/\{\{media:([^}]+)\}\}/', fn( $m ) => $urls[ $m[1] ] ?? '', $text );
	};

	// 3. Content, meta, disciplines, tile image.
	wp_update_post( array( 'ID' => $post_id, 'post_content' => $replace( (string) $case['content'] ) ) );

	foreach ( (array) ( $case['meta'] ?? array() ) as $k => $v ) {
		$v = $replace( (string) $v );
		if ( '' === $v ) {
			delete_post_meta( $post_id, '_creadigol_' . $k );
		} else {
			update_post_meta( $post_id, '_creadigol_' . $k, $v );
		}
	}
	if ( ! empty( $case['disciplines'] ) ) {
		wp_set_object_terms( $post_id, (array) $case['disciplines'], 'discipline' );
	}
	if ( ! empty( $case['thumbnail'] ) && isset( $ids[ $case['thumbnail'] ] ) ) {
		set_post_thumbnail( $post_id, $ids[ $case['thumbnail'] ] );
	}

	$log[] = 'Done. ' . get_permalink( $post_id );
	return $log;
}
