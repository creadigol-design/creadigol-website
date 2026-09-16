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
		'headline'        => array( __( 'Headline', 'creadigol' ), 'text', 'Brands built to move.', '' ),
		'intro'           => array( __( 'Intro line', 'creadigol' ), 'textarea', 'Identities with motion at the core, from a sports-broadcast background. Designed in Welsh and English together.', '' ),
		'location_line'   => array( __( 'Location line (top right of hero)', 'creadigol' ), 'text', 'Bangor, North Wales · Branding & motion studio', '' ),
		'showreel_loop'   => array( __( 'Showreel loop (MP4/WebM URL)', 'creadigol' ), 'url', '', __( 'Muted, plays behind the headline. Keep it under 8 MB; 1920×1080.', 'creadigol' ) ),
		'showreel_poster' => array( __( 'Showreel poster image URL', 'creadigol' ), 'url', '', __( 'Shown before the loop plays and on slow connections.', 'creadigol' ) ),
		'showreel_full'   => array( __( 'Full showreel (Vimeo or YouTube URL)', 'creadigol' ), 'url', '', __( 'Opens when the play button is pressed.', 'creadigol' ) ),
		// Strip and statement.
		'clients'         => array( __( 'Client strip', 'creadigol' ), 'textarea', 'BBC Sport, Rondo Media, Cwmni Da, Nimble, Menai Track & Field, Codi’r To, Self Storage Booker', __( 'Comma separated. Scrolls under the hero.', 'creadigol' ) ),
		'statement_label' => array( __( 'Statement label', 'creadigol' ), 'text', 'How we work', '' ),
		'statement'       => array( __( 'Statement', 'creadigol' ), 'textarea', 'Motion isn’t a layer we add at the end. It’s the first question we ask.', '' ),
		// Services (three).
		'service_1_title' => array( __( 'Service 1 title', 'creadigol' ), 'text', 'Brand identity & strategy', '' ),
		'service_1_text'  => array( __( 'Service 1 text', 'creadigol' ), 'textarea', 'Positioning, naming, identity systems and guidelines, designed to move from day one.', '' ),
		'service_2_title' => array( __( 'Service 2 title', 'creadigol' ), 'text', 'Motion & animation', '' ),
		'service_2_text'  => array( __( 'Service 2 text', 'creadigol' ), 'textarea', 'Idents, title sequences, programme graphics, social and explainer animation.', '' ),
		'service_3_title' => array( __( 'Service 3 title', 'creadigol' ), 'text', 'Digital & web', '' ),
		'service_3_text'  => array( __( 'Service 3 text', 'creadigol' ), 'textarea', 'Fast, bilingual websites that carry the identity into every screen.', '' ),
		// Call to action.
		'cta'             => array( __( 'Call to action', 'creadigol' ), 'text', 'Got a brand that needs to move?', '' ),
		'cta_button'      => array( __( 'Button text', 'creadigol' ), 'text', 'Start a project', '' ),
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
		'footer_line'     => array( __( 'Footer line', 'creadigol' ), 'text', 'Branding & motion studio · Bangor, Gwynedd, Wales', '' ),
		// Redirects.
		'redirects'       => array( __( 'Redirects', 'creadigol' ), 'textarea', creadigol_default_redirects_text(), __( 'One per line: old path, a space, new path. Applied as 301s before a 404 is shown.', 'creadigol' ) ),
	);
}

/**
 * Welsh versions of the text settings. Used on the Welsh side when a
 * translation plugin has not supplied its own (WPML String Translation
 * overrides these through the theme_mods option filter).
 */
function creadigol_settings_cy(): array {
	return array(
		'headline'        => "Brandiau sy'n symud.",
		'intro'           => "Hunaniaethau â symud yn eu craidd, o gefndir darlledu chwaraeon. Wedi'u dylunio yn Gymraeg a Saesneg gyda'i gilydd.",
		'location_line'   => 'Bangor, Gogledd Cymru · Stiwdio brandio a graffeg symud',
		'statement_label' => "Sut rydyn ni'n gweithio",
		'statement'       => "Nid haen a ychwanegwn ar y diwedd yw symud. Dyna'r cwestiwn cyntaf a ofynnwn.",
		'service_1_title' => 'Hunaniaeth brand a strategaeth',
		'service_1_text'  => "Lleoli, enwi, systemau hunaniaeth a chanllawiau, wedi'u dylunio i symud o'r diwrnod cyntaf.",
		'service_2_title' => 'Graffeg symud ac animeiddio',
		'service_2_text'  => 'Idents, dilyniannau teitl, graffeg rhaglenni, animeiddio cymdeithasol ac esboniadol.',
		'service_3_title' => 'Digidol a gwe',
		'service_3_text'  => "Gwefannau cyflym, dwyieithog sy'n cario'r hunaniaeth i bob sgrin.",
		'cta'             => 'Oes gennych chi frand sydd angen symud?',
		'cta_button'      => 'Dechrau prosiect',
		'reply_time'      => 'Rydym yn ateb o fewn dau ddiwrnod gwaith, yn Gymraeg neu Saesneg.',
		'footer_line'     => 'Stiwdio brandio a graffeg symud · Bangor, Gwynedd, Cymru',
	);
}

/**
 * Read a setting with its default.
 */
function creadigol_get( string $key ): string {
	$defs  = creadigol_settings();
	$en    = $defs[ $key ][2] ?? '';
	$value = (string) get_theme_mod( 'creadigol_' . $key, $en );
	// Welsh side without a translation plugin (or with an untranslated string): use the Welsh default.
	if ( creadigol_is_cy() && $value === $en ) {
		$value = creadigol_settings_cy()[ $key ] ?? $value;
	}
	return $value;
}

/**
 * Is the current request the Welsh side of the site?
 */
function creadigol_is_cy(): bool {
	return str_starts_with( get_locale(), 'cy' );
}

/**
 * Register the panel.
 */
function creadigol_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_panel( 'creadigol', array( 'title' => __( 'Creadigol', 'creadigol' ), 'priority' => 10 ) );

	$sections = array(
		'hero'      => array( __( 'Home: hero and showreel', 'creadigol' ), array( 'headline', 'intro', 'location_line', 'showreel_loop', 'showreel_poster', 'showreel_full' ) ),
		'strip'     => array( __( 'Home: client strip and statement', 'creadigol' ), array( 'clients', 'statement_label', 'statement' ) ),
		'services'  => array( __( 'Services', 'creadigol' ), array( 'service_1_title', 'service_1_text', 'service_2_title', 'service_2_text', 'service_3_title', 'service_3_text' ) ),
		'cta'       => array( __( 'Calls to action', 'creadigol' ), array( 'cta', 'cta_button' ) ),
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
