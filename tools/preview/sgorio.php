<?php
/**
 * Sgorio rebrand case study: preview content in both languages. Draft for approval.
 * Media paths are relative to the preview folder; $prefix is '' (English) or '../' (Cymraeg).
 *
 * @package Creadigol
 */

return function ( string $lang, string $prefix ): array {
	$img = fn( string $f ) => $prefix . 'images/sgorio/' . $f;

	$video = fn( string $file, string $poster ) => '<figure class="wp-block-video alignwide"><video class="loop" muted playsinline loop preload="none" poster="' . $img( $poster ) . '" data-src="' . $img( $file ) . '" aria-label="Sgorio"></video></figure>';
	$pair  = fn( string $a, string $alt_a, string $b, string $alt_b ) => '<div class="wp-block-columns alignwide"><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $img( $a ) . '" alt="' . $alt_a . '"></figure></div><div class="wp-block-column"><figure class="wp-block-image"><img src="' . $img( $b ) . '" alt="' . $alt_b . '"></figure></div></div>';
	$stats = fn( array $rows ) => '<div class="wp-block-columns stats">' . implode( '', array_map( fn( $r ) => '<div class="wp-block-column"><h3 class="wp-block-heading">' . $r[0] . '</h3><p>' . $r[1] . '</p></div>', $rows ) ) . '</div>';

	if ( 'cy' === $lang ) {
		return array(
			'title'        => 'Sgorio',
			'summary'      => "Hunaniaeth a phecyn symud newydd i raglen bêl-droed S4C, yn barod at dymor 2026–27: un marc, un iaith o olau, pob sgrin o ddarlledu i TikTok.",
			'deliverables' => 'Hunaniaeth, canllawiau, teitlau, cardiau agor a chau, wipes, trydydd isaf a mogrts, pecyn cymdeithasol',
			'quote'        => '',
			'quote_by'     => '',
			'content'      =>
				'<h2 class="wp-block-heading">Y briff</h2>' .
				"<p>Sgorio yw cartref pêl-droed yn Gymraeg ers 1988. Gofynnodd Rondo Media inni roi hunaniaeth iddo sy'n addas i dymor 2026–27: un a allai gario gemau byw, uchafbwyntiau ac allbwn cymdeithasol dyddiol heb chwalu, a phecyn y gallai'r tîm cynhyrchu ei redeg eu hunain, wythnos ar ôl wythnos.</p>" .
				$video( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg' ) .
				'<h2 class="wp-block-heading">Y syniad</h2>' .
				"<p>Mae Sgorio'n symud. Felly hefyd ei farc. Mae'r S newydd yn eistedd mewn cylch wedi'i hollti: pêl, bathodyn a dot darlledu mewn un siâp, ac mae'r hollt yn rhedeg ymlaen i lythrennau'r nod gair. O'i gwmpas, golau. Mae un system o streipiau porffor, wedi'u tynnu ar draws du, yn rhoi symudiad i'r brand hyd yn oed pan mae'n llonydd, ac mae'r un golau'n cario drwy'r teitlau, y wipes a phob post cymdeithasol.</p>" .
				$pair( 'roundel.jpg', 'Eicon Sgorio', 'cover-twitter.jpg', 'Nod gair Sgorio ar y cefndir golau' ) .
				'<h2 class="wp-block-heading">Y system ar waith</h2>' .
				"<p>Fe adeiladon ni'r hunaniaeth fel pecyn gwaith, nid set o luniau. Teitlau'r tymor, cardiau agor a chau, a theulu o wipes ar gyfer darlledu a fertigol. Trydydd isaf, tablau, Gôl ac Arbediad y Mis a hysbysebion gemau fel templedi Premiere Pro, fel bod golygyddion yn eu gollwng i mewn a theipio. Templedi cymdeithasol ar gyfer gemau, canlyniadau, tablau, dyfyniadau, newyddion a rhagolygon, mewn 1:1, 4:5 a 9:16, gyda chelf clawr a phroffil i bob platfform. Y cyfan ar un set o gefndiroedd, a'r cyfan wedi'i ysgrifennu mewn canllaw y gall y tîm ei roi i unrhyw un.</p>" .
				$video( 'lower-third.mp4', 'lower-third.jpg' ) .
				$pair( 'background.jpg', 'System gefndir Sgorio', 'bg-vertical.jpg', 'Cefndir fertigol 9:16' ) .
				$stats( array( array( '1', 'Marc, pob maint' ), array( '15', 'Cefndir llonydd, tair cymhareb' ), array( '10+', 'Templed Premiere Pro' ), array( '12', 'Templed cymdeithasol' ) ) ),
		);
	}

	return array(
		'title'        => 'Sgorio',
		'summary'      => "A new identity and motion toolkit for S4C's football programme, ready for the 2026–27 season: one mark, one language of light, every screen from broadcast to TikTok.",
		'deliverables' => 'Identity, guidelines, titles, intro and end cards, wipes, lower thirds and mogrts, social toolkit',
		'quote'        => '',
		'quote_by'     => '',
		'content'      =>
			'<h2 class="wp-block-heading">The ask</h2>' .
			'<p>Sgorio has been the home of football in Welsh since 1988. Rondo Media asked us to give it an identity fit for the 2026–27 season: one that could carry live matches, highlights and a daily social output without splintering, and a toolkit the production team could run themselves, week in, week out.</p>' .
			$video( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg' ) .
			'<h2 class="wp-block-heading">The idea</h2>' .
			"<p>Sgorio moves. So does its mark. The new S sits inside a split ring: a ball, a badge and a broadcast dot in one shape, and the split runs on into the wordmark's letterforms. Around it, light. A single purple streak system, drawn across black, gives the brand motion even when it is standing still, and the same light carries through the titles, the wipes and every social post.</p>" .
			$pair( 'roundel.jpg', 'The Sgorio icon', 'cover-twitter.jpg', 'The Sgorio wordmark on the light background' ) .
			'<h2 class="wp-block-heading">The system in motion</h2>' .
			'<p>We built the identity as a working kit, not a set of pictures. Season titles, intro and end cards, and a family of wipes for broadcast and vertical. Lower thirds, tables, Goal and Save of the Month and match trails as Premiere Pro templates, so editors drop them in and type. Social templates for fixtures, results, tables, quotes, news and previews, in 1:1, 4:5 and 9:16, with cover and profile art for every platform. All of it on one set of backgrounds, and all of it written up in a guideline the team can hand to anyone.</p>' .
			$video( 'lower-third.mp4', 'lower-third.jpg' ) .
			$pair( 'background.jpg', 'The Sgorio background system', 'bg-vertical.jpg', '9:16 vertical background' ) .
			$stats( array( array( '1', 'Mark, every size' ), array( '15', 'Still backgrounds, three ratios' ), array( '10+', 'Premiere Pro templates' ), array( '12', 'Social templates' ) ) ),
	);
};
