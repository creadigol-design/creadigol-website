<?php
/**
 * Holding page mode.
 *
 * Customise > Creadigol > Holding page > "Show the holding page". While on,
 * every visitor who is not logged in sees holding.php instead of the site,
 * so the studio can fill in content behind it. Logged-in users see the real
 * site. The old site's URLs still 301 to their new homes underneath.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

function creadigol_holding_settings(): array {
	return array(
		'holding_on'      => array( __( 'Show the holding page to visitors', 'creadigol' ), 'checkbox', '', __( 'Logged-in users always see the full site.', 'creadigol' ) ),
		'holding_video'   => array( __( 'Film (YouTube or Vimeo URL, or MP4)', 'creadigol' ), 'url', 'https://www.youtube.com/watch?v=ZkoNAp2z_qo', __( 'Shown as the centrepiece, with a link to watch it in full.', 'creadigol' ) ),
		'holding_poster'  => array( __( 'Poster image URL (optional)', 'creadigol' ), 'url', '', __( 'Shown behind the play button. Leave empty to use the YouTube thumbnail.', 'creadigol' ) ),
		'holding_line'    => array( __( 'Line (English)', 'creadigol' ), 'text', 'A new Creadigol is on its way.', '' ),
		'holding_line_cy' => array( __( 'Line (Cymraeg)', 'creadigol' ), 'text', 'Mae Creadigol newydd ar ei ffordd.', '' ),
		'holding_note'    => array( __( 'Note', 'creadigol' ), 'text', 'Branding and motion, from North Wales. The studio is open as usual.', '' ),
	);
}

/**
 * Register the section alongside the other Creadigol settings.
 */
function creadigol_holding_customize( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section( 'creadigol_holding', array( 'title' => __( 'Holding page', 'creadigol' ), 'panel' => 'creadigol', 'priority' => 1 ) );
	foreach ( creadigol_holding_settings() as $key => [ $label, $type, $default, $description ] ) {
		$sanitize = match ( $type ) {
			'checkbox' => fn( $v ) => $v ? '1' : '',
			'url'      => 'esc_url_raw',
			default    => 'sanitize_text_field',
		};
		$wp_customize->add_setting( 'creadigol_' . $key, array( 'default' => $default, 'sanitize_callback' => $sanitize ) );
		$wp_customize->add_control( 'creadigol_' . $key, array( 'label' => $label, 'description' => $description, 'section' => 'creadigol_holding', 'type' => $type ) );
	}
}
add_action( 'customize_register', 'creadigol_holding_customize', 20 );

function creadigol_holding_get( string $key ): string {
	return (string) get_theme_mod( 'creadigol_' . $key, creadigol_holding_settings()[ $key ][2] ?? '' );
}

/**
 * Serve the holding page to visitors while the mode is on.
 */
function creadigol_holding_redirect(): void {
	if ( ! creadigol_holding_get( 'holding_on' ) || is_user_logged_in() || is_customize_preview() ) {
		return;
	}
	if ( is_admin() || wp_doing_ajax() || defined( 'REST_REQUEST' ) || ( isset( $_SERVER['REQUEST_URI'] ) && str_contains( (string) $_SERVER['REQUEST_URI'], 'admin-post.php' ) ) ) {
		return;
	}
	// Let the old-URL redirects run first so links keep working after launch.
	if ( is_404() ) {
		creadigol_redirects();
	}
	status_header( 200 );
	nocache_headers();
	include CREADIGOL_DIR . '/holding.php';
	exit;
}
add_action( 'template_redirect', 'creadigol_holding_redirect', 20 );

/**
 * Holding-page embed markup for a YouTube, Vimeo or MP4 URL.
 */
function creadigol_holding_film( string $url ): string {
	if ( preg_match( '#(?:youtu\.be/|v=)([\w-]{11})#', $url, $m ) ) {
		return sprintf( '<iframe src="https://www.youtube-nocookie.com/embed/%1$s?rel=0&modestbranding=1&playsinline=1" title="%2$s" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>', esc_attr( $m[1] ), esc_attr__( 'Showreel', 'creadigol' ) );
	}
	if ( preg_match( '#vimeo\.com/(?:video/)?(\d+)#', $url, $m ) ) {
		return sprintf( '<iframe src="https://player.vimeo.com/video/%1$s?title=0&byline=0&portrait=0" title="%2$s" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen loading="lazy"></iframe>', esc_attr( $m[1] ), esc_attr__( 'Showreel', 'creadigol' ) );
	}
	if ( $url ) {
		return sprintf( '<video src="%s" controls playsinline preload="metadata"></video>', esc_url( $url ) );
	}
	return '';
}

/**
 * Poster image for a film: the Customizer poster, else the YouTube thumbnail.
 */
function creadigol_video_poster( string $url, string $custom = '' ): string {
	if ( $custom ) {
		return $custom;
	}
	if ( preg_match( '#(?:youtu\.be/|v=)([\w-]{11})#', $url, $m ) ) {
		return 'https://img.youtube.com/vi/' . $m[1] . '/maxresdefault.jpg';
	}
	return '';
}
