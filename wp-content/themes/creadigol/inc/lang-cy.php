<?php
/**
 * Welsh (Cymraeg) interface strings.
 *
 * Applied through the gettext filter whenever the site locale is Welsh, so
 * the Welsh side works with WPML or Polylang out of the box and without a
 * compiled .mo file. WPML String Translation can still override any string.
 * Edit the array to change wording; keys are the English source strings.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

function creadigol_cy_strings(): array {
	return array(
		// Navigation and structure.
		'Work'                   => 'Gwaith',
		'Studio'                 => 'Stiwdio',
		'Journal'                => 'Dyddiadur',
		'Contact'                => 'Cysylltu',
		'All work'               => 'Pob prosiect',
		'All notes'              => 'Pob nodyn',
		'Get in touch'           => 'Cysylltu â ni',
		'Start a project'        => 'Dechrau prosiect',
		'Skip to content'        => "Neidio i'r cynnwys",
		'Menu'                   => 'Dewislen',
		'Language'               => 'Iaith',
		'Primary'                => 'Prif ddewislen',
		'Site'                   => 'Gwefan',
		'Follow'                 => 'Dilyn',
		'Sister studio'          => 'Stiwdio chwaer',
		'virtual production'     => 'cynhyrchu rhithwir',
		'Privacy'                => 'Preifatrwydd',
		'Creadigol Design Ltd, registered in England and Wales, 14051334' => 'Creadigol Design Ltd, wedi ei gofrestru yng Nghymru a Lloegr, 14051334',
		'Clients'                => 'Cleientiaid',
		'Play the showreel'      => "Chwarae'r showreel",
		'Close'                  => 'Cau',
		// Work.
		'Filter by discipline'   => 'Hidlo yn ôl disgyblaeth',
		'All'                    => 'Popeth',
		'No case studies yet.'   => 'Dim astudiaethau achos eto.',
		'%d project across broadcast, sport, culture and the public sector. Built to move.' => "%d prosiect ar draws darlledu, chwaraeon, diwylliant a'r sector cyhoeddus. Wedi ei greu i symud.",
		'%d projects across broadcast, sport, culture and the public sector. Every one built to move.' => "%d prosiect ar draws darlledu, chwaraeon, diwylliant a'r sector cyhoeddus. Pob un wedi ei greu i symud.",
		'Client'                 => 'Cleient',
		'Year'                   => 'Blwyddyn',
		'Disciplines'            => 'Disgyblaethau',
		'Deliverables'           => 'Allbynnau',
		'Outcome'                => 'Canlyniad',
		'Credits'                => 'Credydau',
		'Next project'           => 'Prosiect nesaf',
		'The ask'                => 'Y briff',
		'The idea'               => 'Y syniad',
		'The system in motion'   => 'Y system ar waith',
		// Contact form.
		'Name'                   => 'Enw',
		'Email'                  => 'E-bost',
		'Phone'                  => 'Ffôn',
		'Organisation'           => 'Sefydliad',
		'What do you need?'      => 'Beth sydd ei angen arnoch?',
		'Brand identity'         => 'Hunaniaeth brand',
		'Motion'                 => 'Graffeg symud',
		'Broadcast graphics'     => 'Graffeg darlledu',
		'Website'                => 'Gwefan',
		'Not sure yet'           => 'Ddim yn siŵr eto',
		'Budget'                 => 'Cyllideb',
		'Select a range'         => 'Dewiswch ystod',
		'Under £5k'              => 'Llai na £5k',
		'The project'            => 'Y prosiect',
		'A few lines is plenty.' => 'Mae ychydig o linellau yn ddigon.',
		'Send'                   => 'Anfon',
		'Thanks, we have your message and will reply soon.' => 'Diolch, mae eich neges wedi ein cyrraedd ac fe atebwn yn fuan.',
		'Something was missing. Please check your name, email and message and try again.' => "Roedd rhywbeth ar goll. Gwiriwch eich enw, e-bost a'ch neges a cheisiwch eto.",
		// Journal and misc.
		'Nothing here yet.'      => 'Dim byd yma eto.',
		'Nothing found.'         => 'Heb ganfod dim.',
		'Search'                 => 'Chwilio',
		'Posts'                  => 'Postiadau',
		'Not found'              => 'Heb ei ganfod',
		'That page has moved on.' => "Mae'r dudalen honno wedi symud.",
		'See the work'           => 'Gweld y gwaith',
	);
}

/**
 * Translate theme strings on the Welsh side.
 */
function creadigol_gettext_cy( string $translation, string $text, string $domain ): string {
	if ( 'creadigol' !== $domain || $translation !== $text || ! creadigol_is_cy() ) {
		return $translation;
	}
	return creadigol_cy_strings()[ $text ] ?? $translation;
}
add_filter( 'gettext', 'creadigol_gettext_cy', 10, 3 );

function creadigol_ngettext_cy( string $translation, string $single, string $plural, int $number, string $domain ): string {
	if ( 'creadigol' !== $domain || ! creadigol_is_cy() ) {
		return $translation;
	}
	$map = creadigol_cy_strings();
	$src = 1 === $number ? $single : $plural;
	return $map[ $src ] ?? $translation;
}
add_filter( 'ngettext', 'creadigol_ngettext_cy', 10, 5 );
