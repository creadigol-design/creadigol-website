<?php
/**
 * Site settings in the Customizer (Appearance > Customise > Creadigol).
 *
 * Everything an editor might change without touching a template: the two
 * headlines, showreel, client strip, statement, services, contact details,
 * social links, sister studio, and the redirect map.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setting definitions: key => [label, type, default, description].
 */
function creadigol_settings(): array {
	return array(
		// Hero.
		'headline_cy'     => array( __( 'Headline (Cymraeg)', 'creadigol' ), 'text', "Brandiau sy'n symud.", '' ),
		'headline_en'     => array( __( 'Headline (English)', 'creadigol' ), 'text', 'Brands built to move.', '' ),
		'intro'           => array( __( 'Intro line', 'creadigol' ), 'textarea', 'Identities with motion at the core, from a sports-broadcast background. Designed in Welsh and English together.', '' ),
		'location_line'   => array( __( 'Location line (top right of hero)', 'creadigol' ), 'text', 'Bangor, Gogledd Cymru · Stiwdio brandio a graffeg symud', '' ),
		'showreel_loop'   => array( __( 'Showreel loop (MP4/WebM URL)', 'creadigol' ), 'url', '', __( 'Muted, plays behind the headline. Keep it under 8 MB; 1920×1080.', 'creadigol' ) ),
		'showreel_poster' => array( __( 'Showreel poster image URL', 'creadigol' ), 'url', '', __( 'Shown before the loop plays and on slow connections.', 'creadigol' ) ),
		'showreel_full'   => array( __( 'Full showreel (Vimeo or YouTube URL)', 'creadigol' ), 'url', '', __( 'Opens when the play button is pressed.', 'creadigol' ) ),
		// Strip and statement.
		'clients'         => array( __( 'Client strip', 'creadigol' ), 'textarea', 'BBC Sport, Rondo Media, Cwmni Da, Nimble, Menai Track & Field, Codi’r To, Self Storage Booker', __( 'Comma separated. Scrolls under the hero.', 'creadigol' ) ),
		'statement_label' => array( __( 'Statement label', 'creadigol' ), 'text', 'Sut rydyn ni’n gweithio / How we work', '' ),
		'statement'       => array( __( 'Statement', 'creadigol' ), 'textarea', 'Motion isn’t a layer we add at the end. It’s the first question we ask.', '' ),
		// Services (three).
		'service_1_cy'    => array( __( 'Service 1 label (Cymraeg)', 'creadigol' ), 'text', 'Hunaniaeth brand a strategaeth', '' ),
		'service_1_en'    => array( __( 'Service 1 title', 'creadigol' ), 'text', 'Brand identity & strategy', '' ),
		'service_1_text'  => array( __( 'Service 1 text', 'creadigol' ), 'textarea', 'Positioning, naming, identity systems and guidelines, designed to move from day one.', '' ),
		'service_2_cy'    => array( __( 'Service 2 label (Cymraeg)', 'creadigol' ), 'text', 'Graffeg symud ac animeiddio', '' ),
		'service_2_en'    => array( __( 'Service 2 title', 'creadigol' ), 'text', 'Motion & animation', '' ),
		'service_2_text'  => array( __( 'Service 2 text', 'creadigol' ), 'textarea', 'Idents, title sequences, programme graphics, social and explainer animation.', '' ),
		'service_3_cy'    => array( __( 'Service 3 label (Cymraeg)', 'creadigol' ), 'text', 'Digidol a gwe', '' ),
		'service_3_en'    => array( __( 'Service 3 title', 'creadigol' ), 'text', 'Digital & web', '' ),
		'service_3_text'  => array( __( 'Service 3 text', 'creadigol' ), 'textarea', 'Fast, bilingual websites that carry the identity into every screen.', '' ),
		// Call to action.
		'cta_cy'          => array( __( 'Call to action (Cymraeg)', 'creadigol' ), 'text', 'Oes gennych chi frand sydd angen symud?', '' ),
		'cta_en'          => array( __( 'Call to action (English)', 'creadigol' ), 'text', 'Got a brand that needs to move?', '' ),
		'cta_button'      => array( __( 'Button text', 'creadigol' ), 'text', 'Start a project / Dechrau prosiect', '' ),
		'header_button'   => array( __( 'Header button text', 'creadigol' ), 'text', 'Start a project', '' ),
		// Contact.
		'email'           => array( __( 'Email', 'creadigol' ), 'email', 'info@creadigol.design', __( 'Shown on the site and used as the contact form recipient.', 'creadigol' ) ),
		'phone'           => array( __( 'Phone', 'creadigol' ), 'text', '', '' ),
		'address'         => array( __( 'Address', 'creadigol' ), 'textarea', 'Bangor, Gwynedd', '' ),
		'reply_time'      => array( __( 'Reply promise', 'creadigol' ), 'text', 'We reply within two working days, in Welsh or English.', '' ),
		// Social and sister studio.
		'instagram'       => array( __( 'Instagram URL', 'creadigol' ), 'url', 'https://www.instagram.com/creadigol.design/', '' ),
		'linkedin'        => array( __( 'LinkedIn URL', 'creadigol' ), 'url', 'https://uk.linkedin.com/company/creadigol-design', '' ),
		'vimeo'           => array( __( 'Vimeo URL', 'creadigol' ), 'url', '', '' ),
		'vedri_url'       => array( __( 'Sister studio URL (vedrí)', 'creadigol' ), 'url', '', '' ),
		'footer_line'     => array( __( 'Footer line', 'creadigol' ), 'text', 'Branding & motion studio · Bangor, Gwynedd, Cymru', '' ),
		// Redirects.
		'redirects'       => array( __( 'Redirects', 'creadigol' ), 'textarea', creadigol_default_redirects_text(), __( 'One per line: old path, a space, new path. Applied as 301s before a 404 is shown.', 'creadigol' ) ),
	);
}

/**
 * Read a setting with its default.
 */
function creadigol_get( string $key ): string {
	$defs = creadigol_settings();
	return (string) get_theme_mod( 'creadigol_' . $key, $defs[ $key ][2] ?? '' );
}

/**
 * Register the panel.
 */
function creadigol_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_panel( 'creadigol', array( 'title' => __( 'Creadigol', 'creadigol' ), 'priority' => 10 ) );

	$sections = array(
		'hero'      => array( __( 'Home: hero and showreel', 'creadigol' ), array( 'headline_cy', 'headline_en', 'intro', 'location_line', 'showreel_loop', 'showreel_poster', 'showreel_full' ) ),
		'strip'     => array( __( 'Home: client strip and statement', 'creadigol' ), array( 'clients', 'statement_label', 'statement' ) ),
		'services'  => array( __( 'Services', 'creadigol' ), array( 'service_1_cy', 'service_1_en', 'service_1_text', 'service_2_cy', 'service_2_en', 'service_2_text', 'service_3_cy', 'service_3_en', 'service_3_text' ) ),
		'cta'       => array( __( 'Calls to action', 'creadigol' ), array( 'cta_cy', 'cta_en', 'cta_button', 'header_button' ) ),
		'contact'   => array( __( 'Contact details', 'creadigol' ), array( 'email', 'phone', 'address', 'reply_time' ) ),
		'social'    => array( __( 'Social and sister studio', 'creadigol' ), array( 'instagram', 'linkedin', 'vimeo', 'vedri_url', 'footer_line' ) ),
		'redirects' => array( __( 'Redirects from the old site', 'creadigol' ), array( 'redirects' ) ),
	);

	$defs = creadigol_settings();
	foreach ( $sections as $slug => [ $title, $keys ] ) {
		$wp_customize->add_section( 'creadigol_' . $slug, array( 'title' => $title, 'panel' => 'creadigol' ) );
		foreach ( $keys as $key ) {
			[ $label, $type, $default, $description ] = $defs[ $key ];
			$sanitize = match ( $type ) {
				'url'      => 'esc_url_raw',
				'email'    => 'sanitize_email',
				'textarea' => 'sanitize_textarea_field',
				default    => 'sanitize_text_field',
			};
			$wp_customize->add_setting( 'creadigol_' . $key, array( 'default' => $default, 'sanitize_callback' => $sanitize, 'transport' => 'refresh' ) );
			$wp_customize->add_control(
				'creadigol_' . $key,
				array(
					'label'       => $label,
					'description' => $description,
					'section'     => 'creadigol_' . $slug,
					'type'        => $type,
				)
			);
		}
	}
}
add_action( 'customize_register', 'creadigol_customize_register' );
