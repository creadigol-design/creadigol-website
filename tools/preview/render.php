<?php
/**
 * Static preview renderer: runs the theme's real templates against a tiny
 * WordPress stub with sample content, so layout and CSS can be checked
 * without a database. Usage: php tools/preview/render.php <template> > out.html
 * Templates: front-page, archive-work, single-work, page-contact, home, page
 */

define( 'ABSPATH', __DIR__ . '/' );
define( 'THEME', dirname( __DIR__, 2 ) . '/wp-content/themes/creadigol' );
$GLOBALS['preview_uri'] = 'file://' . THEME;

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
	1 => array( 'client' => 'Rondo Media for S4C', 'year' => '2024', 'summary' => "A new identity and ident system for one of S4C's longest-running dramas, built to move across broadcast, iPlayer and social.", 'featured' => '1', 'quote' => 'Creadigol proved to be invaluable partners as we undertook the challenging endeavour of rebranding our beloved and long-standing television series.', 'quote_by' => 'Alaw Llewelyn Roberts, Operational Producer, Rondo Media', 'credits' => "Creative direction: Daniel Parry Evans\nDesign & motion: Creadigol\nProducer (client): Alaw Llewelyn Roberts, Rondo Media" ),
	2 => array( 'client' => 'Rondo Media', 'year' => '2024', 'summary' => 'Titles, programme graphics and compositing for two series exploring car culture.', 'featured' => '1' ),
	3 => array( 'client' => 'Menai Track & Field', 'year' => '2024', 'summary' => 'A faster, clearer club website.', 'featured' => '1' ),
	4 => array( 'client' => "Codi'r To", 'year' => '2024', 'summary' => "A rebrand for the charity's tenth birthday.", 'featured' => '1' ),
	5 => array( 'client' => 'Eisteddfod', 'year' => '2023', 'summary' => "Wales' first Welsh-language esports tournament.", 'featured' => '1' ),
	6 => array( 'client' => 'Self Storage Booker', 'year' => '2023', 'summary' => 'Storage made simple.', 'featured' => '1' ),
);
$GLOBALS['sample_terms'] = array( 1 => array( 'Branding', 'Broadcast' ), 2 => array( 'Motion', 'Broadcast' ), 3 => array( 'Digital' ), 4 => array( 'Branding', 'Motion' ), 5 => array( 'Branding', 'Motion' ), 6 => array( 'Branding', 'Campaign' ) );
$GLOBALS['tones'] = array( 1 => '#1B1F24', 2 => '#2E3A45', 3 => '#5B6B7A', 4 => '#3D4A3A', 5 => '#8A93A0', 6 => '#C8CDC4' );
$GLOBALS['current'] = null;
$GLOBALS['loop'] = array();
$GLOBALS['template'] = $argv[1] ?? 'front-page';
$GLOBALS['wp_query'] = new WP_Query();

// ---- Stubs ----------------------------------------------------------------
function add_action() {} function add_filter() {} function remove_action() {} function register_post_type() {} function register_taxonomy() {} function register_post_meta() {} function register_block_pattern() {} function register_block_pattern_category() {} function add_theme_support() {} function add_editor_style() {} function register_nav_menus() {} function add_image_size() {} function load_theme_textdomain() {} function wp_enqueue_style() {} function wp_enqueue_script() {} function wp_enqueue_media() {} function taxonomy_exists() { return true; } function term_exists() { return true; } function wp_insert_term() {} function flush_rewrite_rules() {} function current_user_can() { return true; }
function get_template_directory() { return THEME; } function get_template_directory_uri() { return $GLOBALS['preview_uri']; }
function __( $s ) { return $s; } function _n( $a, $b, $n ) { return 1 === $n ? $a : $b; } function esc_html__( $s ) { return $s; } function esc_attr__( $s ) { return $s; } function esc_html_e( $s ) { echo $s; } function esc_attr_e( $s ) { echo $s; }
function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_attr( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_url( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES ); } function esc_url_raw( $s ) { return $s; } function esc_textarea( $s ) { return htmlspecialchars( $s ); } function sanitize_text_field( $s ) { return $s; } function sanitize_textarea_field( $s ) { return $s; } function sanitize_email( $s ) { return $s; } function sanitize_key( $s ) { return $s; } function wp_kses_post( $s ) { return $s; } function nl2br_wp( $s ) { return nl2br( $s ); }
function home_url( $p = '' ) { return 'https://creadigol.design' . $p; } function get_post_type_archive_link() { return home_url( '/work/' ); } function get_term_link( $t ) { return home_url( '/work/discipline/' . $t->slug . '/' ); } function get_privacy_policy_url() { return home_url( '/privacy-policy/' ); } function admin_url( $p ) { return home_url( '/wp-admin/' . $p ); }
function language_attributes() { echo 'lang="en-GB"'; } function bloginfo( $k ) { echo 'charset' === $k ? 'UTF-8' : 'Creadigol'; } function body_class() { echo 'class="' . ( 'front-page' === $GLOBALS['template'] ? 'is-home' : '' ) . '"'; } function wp_body_open() {}
function wp_head() { echo '<title>Creadigol preview</title><link rel="stylesheet" href="' . $GLOBALS['preview_uri'] . '/assets/css/main.css">'; }
function wp_footer() { echo '<script src="' . $GLOBALS['preview_uri'] . '/assets/js/main.js" defer></script>'; }
function get_header() { include THEME . '/header.php'; } function get_footer() { include THEME . '/footer.php'; }
function get_template_part( $slug ) { include THEME . '/' . $slug . '.php'; }
function has_nav_menu() { return false; } function wp_nav_menu() {}
function get_theme_mod( $k, $d = '' ) { return $d; }
function get_post_meta( $id, $key ) { return $GLOBALS['meta'][ $id ][ substr( $key, strlen( '_creadigol_' ) ) ] ?? ''; }
function get_posts( $args = array() ) { $type = $args['post_type'] ?? 'post'; $out = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => $p->post_type === $type ) ); if ( ! empty( $args['post__not_in'] ) ) { $out = array_values( array_filter( $out, fn( $p ) => ! in_array( $p->ID, $args['post__not_in'], true ) ) ); } if ( ! empty( $args['fields'] ) && 'ids' === $args['fields'] ) { return array_map( fn( $p ) => $p->ID, $out ); } $n = $args['posts_per_page'] ?? -1; return $n > 0 ? array_slice( $out, 0, $n ) : $out; }
function get_post( $id ) { return $GLOBALS['sample_posts'][ $id ] ?? $GLOBALS['current']; }
function get_the_title( $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return $p->post_title; } function the_title() { echo get_the_title(); }
function get_permalink( $p ) { $p = $p instanceof WP_Post ? $p : get_post( $p ); return home_url( ( 'work' === $p->post_type ? '/work/' : '/journal/' ) . sanitize_title( $p->post_title ) . '/' ); } function the_permalink() { echo get_permalink( get_the_ID() ); }
function sanitize_title( $s ) { return strtolower( trim( preg_replace( '/[^a-z0-9]+/i', '-', $s ), '-' ) ); }
function get_post_thumbnail_id( $id = null ) { return $id ?: get_the_ID(); } function has_post_thumbnail() { return false; }
function wp_get_attachment_image_url( $id ) { return ''; }
function wp_get_attachment_image( $id, $size, $icon, $attr ) { $tone = $GLOBALS['tones'][ $id ] ?? '#3A3A3A'; return '<div class="' . $attr['class'] . '" style="background:' . $tone . ' repeating-linear-gradient(135deg, rgba(255,255,255,.05) 0 2px, transparent 2px 14px);display:flex;align-items:flex-start;padding:16px;color:#F4F5F2;font:12px Supply,monospace;letter-spacing:.06em;text-transform:uppercase">[LOOP] ' . esc_html( $attr['alt'] ) . '</div>'; }
function get_the_terms( $id ) { return array_map( fn( $n ) => new WP_Term( crc32( $n ), $n, strtolower( $n ) ), $GLOBALS['sample_terms'][ $id ] ?? array() ); }
function wp_get_post_terms( $id, $tax = '', $args = array() ) { return array_map( 'strtolower', (array) ( $GLOBALS['sample_terms'][ $id ] ?? array() ) ); }
function get_terms() { return array_map( fn( $n ) => new WP_Term( crc32( $n ), $n, strtolower( $n ) ), array( 'Branding', 'Motion', 'Broadcast', 'Digital', 'Campaign' ) ); }
function wp_list_pluck( $list, $field ) { return array_map( fn( $i ) => is_object( $i ) ? $i->$field : $i[ $field ], $list ); }
function is_wp_error( $x ) { return $x instanceof WP_Error; } function get_locale() { return 'en_GB'; }
function get_the_excerpt( $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return $p->post_excerpt; } function has_excerpt() { return '' !== get_the_excerpt(); }
function get_the_date( $f, $p = null ) { $p = $p instanceof WP_Post ? $p : get_post( $p ?: get_the_ID() ); return date( $f, strtotime( $p->post_date ) ); }
function is_tax() { return false; } function is_search() { return false; } function get_queried_object() { return null; } function is_singular() { return true; } function is_front_page() { return 'front-page' === $GLOBALS['template']; }
function have_posts() { return count( $GLOBALS['loop'] ) > 0; } function the_post() { $GLOBALS['current'] = array_shift( $GLOBALS['loop'] ); } function get_the_ID() { return $GLOBALS['current']->ID ?? 0; }
function the_content() { echo $GLOBALS['current']->post_content; }
function wp_oembed_get() { return ''; } function single_post_title( $a, $b ) { return 'Journal'; }
function the_posts_pagination() {} function previous_post_link() {} function next_post_link() {} function get_the_archive_title() { return 'Archive'; }
function wp_nonce_field() { echo '<input type="hidden" name="nonce" value="x">'; }
function checked() { return ''; } function comments_open() { return false; } function get_option() { return ''; }

// ---- Load theme and render -------------------------------------------------
require THEME . '/inc/customizer.php';
require THEME . '/inc/template-tags.php';
require THEME . '/inc/meta.php';
require THEME . '/inc/redirects.php';
require THEME . '/inc/forms.php';
function creadigol_seed_disciplines() {}

$t = $GLOBALS['template'];
if ( 'archive-work' === $t ) { $GLOBALS['loop'] = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => 'work' === $p->post_type ) ); }
if ( 'single-work' === $t ) { $p = $GLOBALS['sample_posts'][1]; $p->post_content = '<h2 class="wp-block-heading">The ask</h2><p>Rondo Media asked us to revamp the branding for Rownd a Rownd: a programme with a loyal audience and decades of history, that needed to feel current without losing what viewers love.</p><figure class="wp-block-video alignwide"><div class="loop-empty" style="aspect-ratio:16/9"></div></figure><h2 class="wp-block-heading">The idea</h2><p>By transforming the title into the acronym RaR, the new logo became more concise and impactful, and the letterforms gave us a sense of dynamic motion that mirrored the show.</p><div class="wp-block-columns alignwide"><div class="wp-block-column"><figure class="wp-block-image"><div class="loop-empty" style="aspect-ratio:4/3;background:#C8CDC4"></div></figure></div><div class="wp-block-column"><figure class="wp-block-image"><div class="loop-empty" style="aspect-ratio:4/3;background:#E7E4D8"></div></figure></div></div>'; $GLOBALS['loop'] = array( $p ); }
if ( 'page-contact' === $t ) { $GLOBALS['loop'] = array( new WP_Post( 20, "Let's talk.", '', '<p>Tell us about the brand, the programme or the problem.</p>', '2026-01-01', 'page' ) ); }
if ( 'home' === $t ) { $GLOBALS['loop'] = array_values( array_filter( $GLOBALS['sample_posts'], fn( $p ) => 'post' === $p->post_type ) ); }
if ( 'page' === $t ) { $GLOBALS['loop'] = array( new WP_Post( 21, 'A motion-first studio from North Wales.', 'Y stiwdio / The studio', '<h2>What we believe</h2><p>Motion first. We decide how a brand moves before we decide how it looks.</p><h2>The team</h2><p>Creadigol was founded in 2022 by Daniel Parry Evans after years in sports broadcast with S4C and BBC Sport.</p>', '2026-01-01', 'page' ) ); }
include THEME . '/' . $t . '.php';
