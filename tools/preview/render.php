<?php
/**
 * Static preview renderer: runs the theme's real templates against a tiny
 * WordPress stub with sample content, so layout and CSS can be checked
 * without a database. Usage: php tools/preview/render.php <template> > out.html
 * Templates: front-page, archive-work, single-work, page-contact, home, page
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'THEME', dirname( __DIR__, 2 ) . '/wp-content/themes/creadigol' );
$GLOBALS['static'] = (bool) getenv( 'PREVIEW_STATIC' );
$GLOBALS['lang'] = getenv( 'PREVIEW_LANG' ) ?: 'en';
$GLOBALS['page'] = getenv( 'PREVIEW_PAGE' ) ?: 'index';
$GLOBALS['prefix'] = 'cy' === $GLOBALS['lang'] ? '../' : '';
$GLOBALS['preview_uri'] = $GLOBALS['static'] ? rtrim( $GLOBALS['prefix'], '/' ) ?: '.' : 'file://' . THEME;
$GLOBALS['images'] = array( 1 => 'images/rar-endboard.jpg', 2 => 'images/pen-petrol.jpg', 3 => 'images/menai.jpg', 4 => 'images/codir-to.jpg', 5 => 'images/eisteddfod.png', 6 => 'images/self-storage-booker.jpg', 21 => 'images/studio.jpg', 99 => 'images/rar-endboard.jpg' );

// ---- Sample content -------------------------------------------------------
class WP_Post { public function __construct( public int $ID, public string $post_title, public string $post_excerpt = '', public string $post_content = '', public string $post_date = '2025-06-01', public string $post_type = 'work', public int $menu_order = 0 ) {} }
class WP_Term { public function __construct( public int $term_id, public string $name, public string $slug ) {} }
class WP_Query { public int $found_posts = 6; }
class WP_Block_Editor_Context {}
class WP_Customize_Manager {}
class WP_Error {}

$GLOBALS['sample_posts'] = array(
	1 => new WP_Post( 1, 'Rownd a Rownd', 'Identity, idents, end boards, social toolkit, guidelines', '', '2025-03-01' ),
	2 => new WP_Post( 2, 'Pen Petrol S1–2', 'Titles, programme graphics, compositing', '', '2024-11-01' ),
	3 => new WP_Post( 3, 'Menai Track & Field', 'Website, identity refresh', '', '2024-06-01' ),
	4 => new WP_Post( 4, "Codi'r To", 'Identity, motion toolkit', '', '2024-02-01' ),
	5 => new WP_Post( 5, 'Eisteddfod esports', 'Identity, 3D ident, broadcast package', '', '2023-10-01' ),
	6 => new WP_Post( 6, 'Self Storage Booker', 'Identity, campaign', '', '2023-05-01' ),
	11 => new WP_Post( 11, 'Creadigol Design is now Creadigol', 'Why the name changed, and what stays the same.', '', '2026-09-20', 'post' ),
	12 => new WP_Post( 12, "Behind the scenes: vedrí's first virtual production shoot at Aria Studios", '', '', '2025-06-10', 'post' ),
	13 => new WP_Post( 13, 'Finalist, UK StartUp Awards 2025: Creative StartUp of the Year, Wales', '', '', '2025-04-02', 'post' ),
);
$GLOBALS['meta'] = array(
	1 => array( 'client' => 'Rondo Media for S4C', 'year' => '2024', 'summary_cy' => "Hunaniaeth newydd a system o idents ar gyfer un o ddramâu hynaf S4C, wedi ei chreu i symud ar draws darlledu, iPlayer a'r cyfryngau cymdeithasol.", 'summary' => "A new identity and ident system for one of S4C's longest-running dramas, built to move across broadcast, iPlayer and social.", 'featured' => '1', 'quote' => ( getenv( 'PREVIEW_LANG' ) === 'cy' ? 'Bu Creadigol yn bartneriaid amhrisiadwy wrth inni ymgymryd â\'r dasg heriol o ailfrandio ein cyfres deledu annwyl a hirhoedlog.' : 'Creadigol proved to be invaluable partners as we undertook the challenging endeavour of rebranding our beloved and long-standing television series.' ), 'quote_by' => 'Alaw Llewelyn Roberts, Operational Producer, Rondo Media', 'credits' => "Creative direction: Daniel Parry Evans\nDesign & motion: Creadigol\nProducer (client): Alaw Llewelyn Roberts, Rondo Media" ),
	2 => array( 'client' => 'Rondo Media', 'year' => '2024', 'summary' => 'Titles, programme graphics and compositing for two series exploring car culture.', 'summary_cy' => 'Teitlau, graffeg rhaglen a chyfansoddi ar gyfer dwy gyfres am ddiwylliant ceir.', 'featured' => '1' ),
	3 => array( 'client' => 'Menai Track & Field', 'year' => '2024', 'summary' => 'A faster, clearer club website.', 'title_cy' => 'Menai Track & Field', 'summary_cy' => 'Gwefan clwb gyflymach a chliriach.', 'featured' => '1' ),
	4 => array( 'client' => "Codi'r To", 'year' => '2024', 'summary' => "A rebrand for the charity's tenth birthday.", 'featured' => '1' ),
	5 => array( 'client' => 'Eisteddfod', 'year' => '2023', 'summary' => "Wales' first Welsh-language esports tournament.", 'title_cy' => 'E-chwaraeon yr Eisteddfod', 'summary_cy' => 'Twrnamaint e-chwaraeon Cymraeg cyntaf Cymru.', 'featured' => '1' ),
	6 => array( 'client' => 'Self Storage Booker', 'year' => '2023', 'summary' => 'Storage made simple.', 'featured' => '1' ),
);
$GLOBALS['sample_terms'] = array( 1 => array( 'Branding', 'Broadcast' ), 2 => array( 'Motion', 'Broadcast' ), 3 => array( 'Digital' ), 4 => array( 'Branding', 'Motion' ), 5 => array( 'Branding', 'Motion' ), 6 => array( 'Branding', 'Campaign' ) );
$GLOBALS['tones'] = array( 1 => '#1B1F24', 2 => '#2E3A45', 3 => '#5B6B7A', 4 => '#3D4A3A', 5 => '#8A93A0', 6 => '#C8CDC4' );
$GLOBALS['current'] = null;
$GLOBALS['loop'] = array();
$GLOBALS['template'] = $argv[1] ?? 'front-page';
$GLOBALS['wp_query'] = new WP_Query();

// ---- Stubs ----------------------------------------------------------------
function add_action() {} function add_filter() {} function apply_filters( $tag, $value ) { if ( 'creadigol_language_urls' === $tag && $GLOBALS['static'] ) { $pg = $GLOBALS['page'] . '.html'; return array( 'en' => ( 'cy' === $GLOBALS['lang'] ? '../' : '' ) . $pg, 'cy' => ( 'cy' === $GLOBALS['lang'] ? '' : 'cy/' ) . $pg ); } return $value; } function remove_action() {} function register_post_type() {} function register_taxonomy() {} function register_post_meta() {} function register_block_pattern() {} function register_block_pattern_category() {} function add_theme_support() {} function add_editor_style() {} function register_nav_menus() {} function add_image_size() {} function load_theme_textdomain() {} function wp_enqueue_style() {} function wp_enqueue_script() {} function wp_enqueue_media() {} function taxonomy_exists() { return true; } function term_exists() { return true; } function wp_insert_term() {} function flush_rewrite_rules() {} function current_user_can() { return true; }
function get_template_directory() { return THEME; } function get_template_directory_uri() { return $GLOBALS['preview_uri']; }
function __( $s ) { return 'cy' === $GLOBALS['lang'] && function_exists( 'creadigol_cy_strings' ) ? ( creadigol_cy_strings()[ $s ] ?? $s ) : $s; } function _n( $a, $b, $n ) { return __( 1 === $n ? $a : $b ); } function esc_html__( $s ) { return __( $s ); } function esc_attr__( $s ) { return __( $s ); } function esc_html_e( $s ) { echo __( $s ); } function esc_attr_e( $s ) { echo __( $s ); }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_attr( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_url( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_url_raw( $s ) { return $s; } function esc_textarea( $s ) { return htmlspecialchars( $s ); } function sanitize_text_field( $s ) { return $s; } function sanitize_textarea_field( $s ) { return $s; } function sanitize_email( $s ) { return $s; } function sanitize_key( $s ) { return $s; } function wp_kses_post( $s ) { return $s; } function nl2br_wp( $s ) { return nl2br( $s ); }
function home_url( $p = '' ) { if ( $GLOBALS['static'] ) { $map = array( '/' => 'index.html', '' => 'index.html', '/work/' => 'work.html', '/studio/' => 'studio.html', '/journal/' => 'journal.html', '/contact/' => 'contact.html', '/privacy-policy/' => '#' ); return $map[ $p ] ?? '#'; } return 'https://creadigol.design' . $p; } function get_post_type_archive_link() { return home_url( '/work/' ); } function get_term_link( $t ) { return $GLOBALS['static'] ? '#' . $t->slug : home_url( '/work/discipline/' . $t->slug . '/' ); } function get_privacy_policy_url() { return home_url( '/privacy-policy/' ); } function admin_url( $p ) { return $GLOBALS['static'] ? '#' : home_url( '/wp-admin/' . $p ); }
function language_attributes() { echo 'cy' === $GLOBALS['lang'] ? 'lang="cy"' : 'lang="en-GB"'; } function bloginfo( $k ) { echo get_bloginfo( $k ); } function get_bloginfo( $k = '' ) { return 'charset' === $k ? 'UTF-8' : 'Creadigol'; } function body_class() { echo 'class="' . ( 'front-page' === $GLOBALS['template'] ? 'is-home' : '' ) . '"'; } function wp_body_open() {}
function wp_head() { echo '<title>Creadigol preview</title><link rel="stylesheet" href="' . $GLOBALS['preview_uri'] . '/assets/css/main.css">'; }
function wp_footer() { echo '<script src="' . $GLOBALS['preview_uri'] . '/assets/js/main.js" defer></script>'; }
function get_header() { include THEME . '/header.php'; } function get_footer() { include THEME . '/footer.php'; }
function get_template_part( $slug ) { include THEME . '/' . $slug . '.php'; }
function has_nav_menu() { return false; } function wp_nav_menu() {}
function get_theme_mod( $k, $d = '' ) { if ( $GLOBALS['static'] ) { if ( 'creadigol_showreel_poster' === $k ) { return $GLOBALS['prefix'] . 'images/studio.jpg'; } if ( 'creadigol_showreel_full' === $k ) { return 'https://youtu.be/XcKihCuV9po'; } if ( 'creadigol_vedri_url' === $k ) { return '#'; } } return $d; }
function get_post_meta( $id, $key ) { return $GLOBALS['meta'][ $id ][ substr( $key, strlen( '_creadigol_' ) ) ] ?? ''; }
function get_posts( $args = array() ) { $type = $args['post_type'] ?? 'post'; $out = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => $p->post_type === $type ) ); if ( ! empty( $args['post__not_in'] ) ) { $out = array_values( array_filter( $out, fn( $p ) => ! in_array( $p->ID, $args['post__not_in'], true ) ) ); } if ( ! empty( $args['fields'] ) && 'ids' === $args['fields'] ) { return array_map( fn( $p ) => $p->ID, $out ); } $n = $args['posts_per_page'] ?? -1; return $n > 0 ? array_slice( $out, 0, $n ) : $out; }
function get_post( $id ) { return $GLOBALS['sample_posts'][ $id ] ?? $GLOBALS['current']; }
function get_the_title( $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return $p->post_title; } function the_title() { echo get_the_title(); }
function get_permalink( $p ) { $p = $p instanceof WP_Post ? $p : get_post( $p ); if ( $GLOBALS['static'] ) { return 'work' === $p->post_type ? 'case-study.html' : 'journal.html'; } return home_url( ( 'work' === $p->post_type ? '/work/' : '/journal/' ) . sanitize_title( $p->post_title ) . '/' ); } function the_permalink() { echo get_permalink( get_the_ID() ); }
function sanitize_title( $s ) { return strtolower( trim( preg_replace( '/[^a-z0-9]+/i', '-', $s ), '-' ) ); }
function get_post_thumbnail_id( $id = null ) { $id = $id ?: get_the_ID(); return ( $GLOBALS['static'] && 1 === $id && 'single-work' === $GLOBALS['template'] && ! empty( $GLOBALS['hero_pass'] ) ) ? 99 : $id; } function has_post_thumbnail() { return $GLOBALS['static'] && isset( $GLOBALS['images'][ get_the_ID() ] ); }
function wp_get_attachment_image_url( $id ) { return $GLOBALS['static'] && isset( $GLOBALS['images'][ $id ] ) ? $GLOBALS['prefix'] . $GLOBALS['images'][ $id ] : ''; }
function wp_get_attachment_image( $id, $size, $icon, $attr ) { if ( $GLOBALS['static'] && isset( $GLOBALS['images'][ $id ] ) ) { return '<img class="' . $attr['class'] . '" src="' . $GLOBALS['prefix'] . $GLOBALS['images'][ $id ] . '" alt="' . esc_attr( $attr['alt'] ?? '' ) . '" loading="lazy">'; } $tone = $GLOBALS['tones'][ $id ] ?? '#3A3A3A'; return '<div class="' . $attr['class'] . '" style="background:' . $tone . ' repeating-linear-gradient(135deg, rgba(255,255,255,.05) 0 2px, transparent 2px 14px);display:flex;align-items:flex-start;padding:16px;color:#F4F5F2;font:12px Supply,monospace;letter-spacing:.06em;text-transform:uppercase">[LOOP] ' . esc_html( $attr['alt'] ) . '</div>'; }
function get_the_terms( $id ) { return array_map( fn( $n ) => new WP_Term( crc32( $n ), $n, strtolower( $n ) ), $GLOBALS['sample_terms'][ $id ] ?? array() ); }
function wp_get_post_terms( $id, $tax = '', $args = array() ) { return array_map( 'strtolower', (array) ( $GLOBALS['sample_terms'][ $id ] ?? array() ) ); }
function get_terms() { return array_map( fn( $n ) => new WP_Term( crc32( $n ), $n, strtolower( $n ) ), array( 'Branding', 'Motion', 'Broadcast', 'Digital', 'Campaign' ) ); }
function wp_list_pluck( $list, $field ) { return array_map( fn( $i ) => is_object( $i ) ? $i->$field : $i[ $field ], $list ); }
function is_wp_error( $x ) { return $x instanceof WP_Error; } function get_locale() { return 'cy' === $GLOBALS['lang'] ? 'cy' : 'en_GB'; }
function get_the_excerpt( $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return $p->post_excerpt; } function has_excerpt() { return '' !== get_the_excerpt(); }
function get_the_date( $f, $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return date( $f, strtotime( $p->post_date ) ); }
function is_tax() { return false; } function is_search() { return false; } function get_queried_object() { return null; } function is_singular() { return true; } function is_front_page() { return 'front-page' === $GLOBALS['template']; }
function have_posts() { return count( $GLOBALS['loop'] ) > 0; } function the_post() { $GLOBALS['current'] = array_shift( $GLOBALS['loop'] ); } function get_the_ID() { return $GLOBALS['current']->ID ?? 0; }
function the_content() { echo $GLOBALS['current']->post_content; }
function wp_oembed_get() { return ''; } function single_post_title( $a, $b ) { return 'Journal'; }
function the_posts_pagination() {} function previous_post_link() {} function next_post_link() {} function get_the_archive_title() { return 'Archive'; }
function wp_nonce_field() { echo '<input type="hidden" name="nonce" value="x">'; }
function checked() { return ''; } function the_post_thumbnail( $size, $attr = array() ) { echo wp_get_attachment_image( get_the_ID(), $size, false, array( 'class' => $attr['class'] ?? '', 'alt' => get_the_title() ) ); } function comments_open() { return false; } function get_option() { return ''; }

// ---- Load theme and render -------------------------------------------------
require THEME . '/inc/customizer.php';
require THEME . '/inc/lang-cy.php';
require THEME . '/inc/holding.php';
function is_user_logged_in() { return false; } function is_customize_preview() { return false; } function wp_doing_ajax() { return false; } function status_header() {} function nocache_headers() {} function has_custom_logo() { return false; }
if ( ! defined( 'CREADIGOL_DIR' ) ) { define( 'CREADIGOL_DIR', THEME ); }
require THEME . '/inc/template-tags.php';
require THEME . '/inc/meta.php';
require THEME . '/inc/redirects.php';
require THEME . '/inc/forms.php';
function creadigol_seed_disciplines() {}
// In the case study, the hero film uses the end-board image; tiles keep their own.
if ( 'single-work' === $GLOBALS['template'] ) { $GLOBALS['hero_pass'] = true; }

$t = $GLOBALS['template'];
if ( 'archive-work' === $t ) { $GLOBALS['loop'] = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => 'work' === $p->post_type ) ); }
if ( 'single-work' === $t ) { $p = $GLOBALS['sample_posts'][1]; $p->post_content = 'cy' === $GLOBALS['lang'] ? '<h2 class="wp-block-heading">Y briff</h2><p>Gofynnodd Rondo Media inni adnewyddu brand Rownd a Rownd: rhaglen â chynulleidfa deyrngar a degawdau o hanes, a oedd angen teimlo\'n gyfoes heb golli\'r hyn y mae gwylwyr yn ei garu.</p><figure class="wp-block-video alignwide"><div class="loop-empty" style="aspect-ratio:16/9;display:flex;align-items:flex-start;padding:16px;color:#F4F5F2;font:12px Supply,monospace;letter-spacing:.06em;text-transform:uppercase">[Fideo: y system idents ar waith]</div></figure><h2 class="wp-block-heading">Y syniad</h2><p>Trwy droi\'r teitl yn acronym RaR, daeth y logo\'n fwy cryno a thrawiadol, a rhoddodd y llythrennau ymdeimlad o symudiad dynamig a adlewyrchai\'r rhaglen.</p><div class="wp-block-columns alignwide"><div class="wp-block-column"><figure class="wp-block-image"><img src="../images/rar-feed.png" alt=""></figure></div><div class="wp-block-column"><figure class="wp-block-image"><img src="../images/rar-post.png" alt=""></figure></div></div>' : '<h2 class="wp-block-heading">The ask</h2><p>Rondo Media asked us to revamp the branding for Rownd a Rownd: a programme with a loyal audience and decades of history, that needed to feel current without losing what viewers love.</p><figure class="wp-block-video alignwide"><div class="loop-empty" style="aspect-ratio:16/9;display:flex;align-items:flex-start;padding:16px;color:#F4F5F2;font:12px Supply,monospace;letter-spacing:.06em;text-transform:uppercase">[Video: ident system in motion]</div></figure><h2 class="wp-block-heading">The idea</h2><p>By transforming the title into the acronym RaR, the new logo became more concise and impactful, and the letterforms gave us a sense of dynamic motion that mirrored the show.</p><div class="wp-block-columns alignwide"><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $GLOBALS['prefix'] . 'images/rar-feed.png" alt="Rownd a Rownd Instagram profile"></figure></div><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $GLOBALS['prefix'] . 'images/rar-post.png" alt="Rownd a Rownd social post"></figure></div></div>'; $GLOBALS['loop'] = array( $p ); }
if ( 'page-contact' === $t ) { $GLOBALS['loop'] = array( 'cy' === $GLOBALS['lang'] ? new WP_Post( 20, 'Gadewch i ni siarad.', '', '<p>Dywedwch wrthym am y brand, y rhaglen neu\'r broblem.</p>', '2026-01-01', 'page' ) : new WP_Post( 20, "Let's talk.", '', '<p>Tell us about the brand, the programme or the problem.</p>', '2026-01-01', 'page' ) ); }
if ( 'home' === $t ) { $GLOBALS['loop'] = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => 'post' === $p->post_type ) ); }
if ( 'page' === $t ) { $GLOBALS['loop'] = array( 'cy' === $GLOBALS['lang'] ? new WP_Post( 21, 'Stiwdio symud-yn-gyntaf o Ogledd Cymru.', 'Y stiwdio', '<h2>Beth rydym yn ei gredu</h2><p>Symud yn gyntaf. Rydym yn penderfynu sut mae brand yn symud cyn penderfynu sut mae\'n edrych.</p><h2>Y tîm</h2><p>Sefydlwyd Creadigol yn 2022 gan Daniel Parry Evans ar ôl blynyddoedd mewn darlledu chwaraeon gyda S4C a BBC Sport.</p>', '2026-01-01', 'page' ) : new WP_Post( 21, 'A motion-first studio from North Wales.', 'The studio', '<h2>What we believe</h2><p>Motion first. We decide how a brand moves before we decide how it looks.</p><h2>The team</h2><p>Creadigol was founded in 2022 by Daniel Parry Evans after years in sports broadcast with S4C and BBC Sport.</p>', '2026-01-01', 'page' ) ); }
ob_start();
include THEME . '/' . $t . '.php';
$html = ob_get_clean();
if ( $GLOBALS['static'] && in_array( $t, array( 'front-page', 'holding' ), true ) && 'cy' !== $GLOBALS['lang'] ) {
	// The artifact host wraps the main page in its own skeleton, so strip ours and keep title, stylesheet and body content.
	$html = preg_replace( '#^.*?<head>#s', '', $html );
	$html = str_replace( array( '</head>', '</body>', '</html>' ), '', $html );
	$html = preg_replace( '#<body([^>]*)>#', '', $html );
	$html = str_replace( '<meta charset="UTF-8">', '', $html );
	$html = preg_replace( '#<meta name="viewport"[^>]*>#', '', $html );
	$html = str_replace( '<title>Creadigol preview</title>', '<title>Creadigol Theme Preview</title>', $html );
	$html = preg_replace( '#<title>[^<]*Coming soon</title>#', '<title>Creadigol Holding Page</title>', $html );
	if ( 'holding' === $t ) {
		// Embedded players cannot load in the static preview; show the reel's poster linked to YouTube instead.
		$html = preg_replace( '#<iframe[^>]*></iframe>#', '<a href="https://www.youtube.com/watch?v=ZkoNAp2z_qo" target="_blank" rel="noopener" style="position:relative;display:block;height:100%"><img src="images/showreel-poster.jpg" alt="Showreel" style="width:100%;height:100%;object-fit:cover;display:block"><span style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#F4F5F2"><svg width="88" height="88" viewBox="0 0 72 72" fill="none" aria-hidden="true"><circle cx="36" cy="36" r="35" stroke="currentColor" stroke-width="1.5"/><path d="M29 24 L48 36 L29 48 Z" fill="currentColor"/></svg></span></a>', $html );
		$html .= '<script>document.body.classList.add("holding");</script>';
	}
	$html .= '<script>document.body.classList.add("is-home");</script>';
}
echo $html;
