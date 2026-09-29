<?php
/**
 * Build the bundled Sgorio case study: import/sgorio/case.json plus its media.
 *
 *   php tools/build-case-study.php <media source folder>
 *
 * The content comes from tools/preview/sgorio.php (the approved preview copy), with media
 * paths written as {{media:file}} tokens that the theme's importer resolves on the site.
 */

$src = rtrim( $argv[1] ?? '', '/' );
$dst = __DIR__ . '/../wp-content/themes/creadigol/import/sgorio';
if ( ! $src || ! is_dir( $src ) ) {
	fwrite( STDERR, "Usage: php tools/build-case-study.php <folder containing the web-sized media>\n" );
	exit( 1 );
}

$make  = include __DIR__ . '/preview/sgorio.php';
$token = fn( string $f ) => '{{media:' . $f . '}}';
$en    = $make( 'en', '', $token );
$cy    = $make( 'cy', '', $token );

$case = array(
	'slug'        => 'sgorio',
	'title'       => 'Sgorio',
	'date'        => '2026-07-31 12:00:00',
	'excerpt'     => $en['deliverables'],
	'disciplines' => array( 'Branding', 'Motion', 'Broadcast' ),
	'thumbnail'   => 'wordmark-square.jpg',
	'content'     => $en['content'],
	'meta'        => array(
		'client'     => 'Rondo Media for S4C',
		'year'       => '2026',
		'title_cy'   => '',
		'summary'    => $en['summary'],
		'summary_cy' => $cy['summary'],
		'hero_video' => $token( 'motion-system.mp4' ),
		'tile_video' => $token( 'motion-system.mp4' ),
		'featured'   => '1',
		'quote'      => $en['quote'],
		'quote_by'   => $en['quote_by'],
		'credits'    => $en['credits'],
		'content_cy' => $cy['content'],
	),
);

// Every file referenced anywhere, once, thumbnail first.
$all = $case['thumbnail'] . ' ' . $case['content'] . ' ' . implode( ' ', $case['meta'] );
preg_match_all( '/\{\{media:([^}]+)\}\}/', $all, $m );
$case['media'] = array_values( array_unique( array_merge( array( $case['thumbnail'] ), $m[1] ) ) );

if ( ! is_dir( $dst ) ) {
	mkdir( $dst, 0755, true );
}
foreach ( glob( $dst . '/*' ) as $old ) {
	unlink( $old );
}
$bytes = 0;
foreach ( $case['media'] as $file ) {
	if ( ! file_exists( "$src/$file" ) ) {
		fwrite( STDERR, "Missing media: $file\n" );
		exit( 1 );
	}
	copy( "$src/$file", "$dst/$file" );
	$bytes += filesize( "$dst/$file" );
}
file_put_contents( "$dst/case.json", json_encode( $case, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) );
printf( "Wrote import/sgorio/case.json with %d media files (%.1f MB).\n", count( $case['media'] ), $bytes / 1048576 );
