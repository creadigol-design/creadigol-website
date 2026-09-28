<?php
/**
 * Sgorio rebrand case study: preview content in both languages. Draft for approval.
 * Media paths are relative to the preview folder; $prefix is '' (English) or '../' (Cymraeg).
 *
 * @package Creadigol
 */

return function ( string $lang, string $prefix ): array {
	$img = fn( string $f ) => $prefix . 'images/sgorio/' . $f;

	$loop  = fn( string $file, string $poster, string $label ) => '<figure class="wp-block-video alignwide"><video class="loop" muted playsinline loop preload="none" poster="' . $img( $poster ) . '" data-src="' . $img( $file ) . '" aria-label="' . $label . '"></video></figure>';
	$film  = fn( string $file, string $poster ) => '<figure class="wp-block-video alignwide"><video controls playsinline preload="metadata" poster="' . $img( $poster ) . '" src="' . $img( $file ) . '"></video></figure>';
	$pair  = fn( string $a, string $alt_a, string $b, string $alt_b ) => '<div class="wp-block-columns alignwide"><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $img( $a ) . '" alt="' . $alt_a . '"></figure></div><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $img( $b ) . '" alt="' . $alt_b . '"></figure></div></div>';
	$row   = fn( array $cards ) => '<div class="wp-block-columns alignwide social">' . implode( '', array_map( fn( $c ) => '<div class="wp-block-column"><figure class="wp-block-image"><img src="' . $img( $c[0] ) . '" alt="' . $c[1] . '"></figure></div>', $cards ) ) . str_repeat( '<div class="wp-block-column"></div>', max( 0, 3 - count( $cards ) ) ) . '</div>';
	$stats = fn( array $rows ) => '<div class="wp-block-columns stats">' . implode( '', array_map( fn( $r ) => '<div class="wp-block-column"><h3 class="wp-block-heading">' . $r[0] . '</h3><p>' . $r[1] . '</p></div>', $rows ) ) . '</div>';

	if ( 'cy' === $lang ) {
		return array(
			'title'        => 'Sgorio',
			'summary'      => "Hunaniaeth ar yr awyr wedi'i mireinio i raglen bêl-droed S4C, a system symud lawn i'w chario: o'r sylw cyntaf i'r awyr mewn chwe wythnos, yn barod at agoriad tymor 2026–27.",
			'deliverables' => 'Nod gair ac eicon, lliw a theipograffeg, canllawiau, teitlau, cardiau agor a chau, wipes, graffeg llawn-ffrâm a thempledi Premiere Pro, pecyn cymdeithasol',
			'quote'        => '',
			'quote_by'     => '',
			'credits'      => "Cyfarwyddo creadigol: Daniel Parry Evans\nDylunio a symud: Creadigol",
			'content'      =>
				'<h2 class="wp-block-heading">Y briff</h2>' .
				"<p>Sgorio yw cartref pêl-droed yn Gymraeg ers 1988, ac mae ei gynulleidfa'n adnabod y marc. Gofynnodd Rondo Media inni ei fireinio, nid ei ailddyfeisio: hunaniaeth ar yr awyr a allai gario gemau byw, uchafbwyntiau a llif cymdeithasol dyddiol fel un peth, a phecyn y gallai'r tîm cynhyrchu ei redeg eu hunain o'r penwythnos agoriadol ymlaen.</p>" .
				$film( 'montage.mp4', 'montage.jpg' ) .
				'<h2 class="wp-block-heading">Y syniad</h2>' .
				"<p>Sgorio. Wedi'i fireinio. Cadwodd y nod gair ei lythrennau isaf ond cafodd ei ail-dorri o amgylch un symudiad: gêm o ddwy hanner. Mae'r 'o' wedi'i hollti'n agor fel giât, ac ar yr awyr mae'r nod gair yn ymestyn ar led i fframio'r cynnwys, cyn cau eto. Aeth yr un hollt i'r eicon: S mewn cylch wedi'i hollti, yr un-dau y gall bathodyn, proffil ac ergyd sgrin i gyd ei rannu.</p>" .
				$pair( 'roundel.jpg', 'Eicon Sgorio', 'wordmark-square.jpg', 'Nod gair Sgorio' ) .
				'<h2 class="wp-block-heading">Lliw a theip</h2>' .
				"<p>Un porffor beiddgar, wedi'i ddewis i sefyll yn erbyn gwyrdd y cae, i osgoi lliwiau'r clybiau, ac i eistedd yn brin wrth ochr coch y tîm cenedlaethol. Y tu ôl iddo, golau: system o streipiau porffor ar ddu sy'n rhoi symudiad i'r brand hyd yn oed pan fo'n llonydd. Wyneb pennawd cryno i'r sgôr, serif i'r eiliadau dynol, a mono i'r data.</p>" .
				$pair( 'background-square.jpg', 'System golau Sgorio', 'background-square-b.jpg', 'Cefndir cymdeithasol' ) .
				'<h2 class="wp-block-heading">Yn gymdeithasol</h2>' .
				"<p>Un teulu o dempledi i'r ffrwd, wedi'i dorri o'r un brethyn â graffeg y darlledu. Y cylch ar y chwith uchaf, tag mewn cromfachau i ddweud pa fath o bost, pennawd trwm cywasgedig, a throedyn mono i'r gystadleuaeth a'r dyddiad. Mae'r ffotograffiaeth yn eistedd yn y golau, wedi'i goleuo o'r cefn gan y streipen borffor, gyda lliw acen i'r tag a'r troedyn. Mae gemau, canlyniadau, tablau, newyddion, dyfyniadau a rhagolygon i gyd yn dod o'r un pecyn, mewn 1:1, 4:5 a 9:16.</p>" .
				$row( array( array( 'social-final-news.jpg', 'Post newyddion' ) ) ) .
				'<h2 class="wp-block-heading">Y system ar waith</h2>' .
				"<p>Cloiwyd y cyfeiriad ar 18 Mehefin. Erbyn 3 Gorffennaf roedd y system gyfan wedi'i hadeiladu: teitlau'r tymor, cardiau agor a chau, teulu o wipes, sgôr terfynol, hysbysebion gemau, tablau a thrydydd isaf fel templedi Premiere Pro y mae golygyddion yn eu gollwng i mewn a theipio. Pecyn cymdeithasol mewn tri llais, dan arweiniad y brand, adroddiadol a mynegiannol, sy'n gallu cymryd lliwiau tîm neu gynghrair, mewn 1:1, 4:5 a 9:16, gyda chelf clawr a phroffil i bob platfform. Trosglwyddwyd ar 10 Gorffennaf. Yn fyw ar 31 Gorffennaf.</p>" .
				$loop( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg', 'Gôl y Mis' ) .
				$pair( 'lower-third.jpg', 'Trydydd isaf ar yr awyr', 'montage.jpg', 'Sgôr terfynol' ) .
				$stats( array( array( '6', 'Wythnos o sylw cyntaf i awyr' ), array( '3', 'Llwybr eicon, un wedi ei ddewis' ), array( '10+', 'Templed Premiere Pro' ), array( '12', 'Templed cymdeithasol' ) ) ),
		);
	}

	return array(
		'title'        => 'Sgorio',
		'summary'      => "A refined on-air identity for S4C's football programme, and a full motion system to carry it: from first look to air in six weeks, ready for the 2026–27 season opener.",
		'deliverables' => 'Wordmark and icon, colour and type, guidelines, titles, intro and end cards, wipes, full-frame graphics and Premiere Pro templates, social pack',
		'quote'        => '',
		'quote_by'     => '',
		'credits'      => "Creative direction: Daniel Parry Evans\nDesign and motion: Creadigol",
		'content'      =>
			'<h2 class="wp-block-heading">The ask</h2>' .
			'<p>Sgorio has been the home of football in Welsh since 1988, and its audience knows the mark. Rondo Media asked us to refine it, not reinvent it: an on-air identity that could carry live matches, highlights and a daily social feed as one thing, and a kit the production team could run themselves from the opening weekend on.</p>' .
			$film( 'montage.mp4', 'montage.jpg' ) .
			'<h2 class="wp-block-heading">The idea</h2>' .
			"<p>Sgorio. Refined. The wordmark kept its lowercase but was recut around one move: a game of two halves. The split 'o' opens like a gate, and on air the wordmark stretches wide to frame the content, then closes again. The same split went into the icon: an S inside a broken ring, the one-two that a badge, a profile and a screen bug can all share.</p>" .
			$pair( 'roundel.jpg', 'The Sgorio icon', 'wordmark-square.jpg', 'The Sgorio wordmark' ) .
			'<h2 class="wp-block-heading">Colour and type</h2>' .
			"<p>One bold purple, chosen to stand against the green of the pitch, to avoid the classic club colours, and to sit sparingly beside the national team's red. Behind it, light: a system of purple streaks on black that gives the brand motion even when it is standing still. A condensed headline face for the score, a serif for the human moments, and a mono for the data.</p>" .
			$pair( 'background-square.jpg', 'The Sgorio light system', 'background-square-b.jpg', 'Social background' ) .
			'<h2 class="wp-block-heading">Getting social</h2>' .
			"<p>One template family for the feed, cut from the same cloth as the broadcast graphics. The roundel top left, a bracketed tag for the type of post, a heavy condensed headline, and a mono footer for competition and date. Photography sits in the light, lit from behind by the purple streak, with an accent colour picked out for the tag and the footer. Fixtures, results, tables, news, quotes and previews all come from the one kit, in 1:1, 4:5 and 9:16.</p>" .
			$row( array( array( 'social-final-news.jpg', 'News post' ) ) ) .
			'<h2 class="wp-block-heading">The system in motion</h2>' .
			'<p>The direction was locked on 18 June. By 3 July the whole system was built: season titles, intro and end cards, a family of wipes, final score, match trails, tables and lower thirds as Premiere Pro templates that editors drop in and type. A social pack in three voices, brand-led, reportage and expression-led, that can take on team or league colours, in 1:1, 4:5 and 9:16, with cover and profile art for every platform. Handed over on 10 July. Live on 31 July.</p>' .
			$loop( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg', 'Goal of the Month' ) .
			$pair( 'lower-third.jpg', 'Lower third on air', 'montage.jpg', 'Final score' ) .
			$stats( array( array( '6', 'Weeks from first look to air' ), array( '3', 'Icon routes, one chosen' ), array( '10+', 'Premiere Pro templates' ), array( '12', 'Social templates' ) ) ),
	);
};
