<?php
/**
 * Sgorio rebrand case study: preview content in both languages. Draft for approval.
 * Media paths are relative to the preview folder; $prefix is '' (English) or '../' (Cymraeg).
 *
 * @package Creadigol
 */

return function ( string $lang, string $prefix, ?callable $resolver = null ): array {
	// Media paths: the preview resolves to images/sgorio/, the importer to {{media:file}} tokens.
	$img = $resolver ?: fn( string $f ) => $prefix . 'images/sgorio/' . $f;

	// Every helper writes block-editor markup (with block comments), so the same
	// content renders in the preview and opens cleanly in the WordPress editor.
	$h2    = fn( string $t ) => '<!-- wp:heading --><h2 class="wp-block-heading">' . $t . '</h2><!-- /wp:heading -->';
	$p     = fn( string $t ) => '<!-- wp:paragraph --><p>' . $t . '</p><!-- /wp:paragraph -->';
	$loop  = fn( string $file, string $poster, string $label ) => '<!-- wp:video {"align":"wide","autoplay":true,"loop":true,"muted":true,"playsInline":true} --><figure class="wp-block-video alignwide"><video autoplay loop muted playsinline poster="' . $img( $poster ) . '" src="' . $img( $file ) . '"></video></figure><!-- /wp:video -->';
	$film  = fn( string $file, string $poster ) => '<!-- wp:video {"align":"wide"} --><figure class="wp-block-video alignwide"><video controls poster="' . $img( $poster ) . '" src="' . $img( $file ) . '"></video></figure><!-- /wp:video -->';
	$image = fn( string $f, string $alt ) => '<!-- wp:image --><figure class="wp-block-image"><img src="' . $img( $f ) . '" alt="' . $alt . '"/></figure><!-- /wp:image -->';
	$col   = fn( string $inner ) => '<!-- wp:column --><div class="wp-block-column">' . $inner . '</div><!-- /wp:column -->';
	$cols  = fn( string $attrs, string $class, string $inner ) => '<!-- wp:columns ' . $attrs . ' --><div class="wp-block-columns ' . $class . '">' . $inner . '</div><!-- /wp:columns -->';
	$pair  = fn( string $a, string $alt_a, string $b, string $alt_b ) => $cols( '{"align":"wide"}', 'alignwide', $col( $image( $a, $alt_a ) ) . $col( $image( $b, $alt_b ) ) );
	$row   = fn( array $cards, int $n = 3 ) => $cols( '{"align":"wide","className":"social"}', 'alignwide social', implode( '', array_map( fn( $c ) => $col( $image( $c[0], $c[1] ) ), $cards ) ) . str_repeat( $col( '' ), max( 0, $n - count( $cards ) ) ) );
	$stats = fn( array $rows ) => $cols( '{"className":"stats"}', 'stats', implode( '', array_map( fn( $r ) => $col( '<!-- wp:heading {"level":3} --><h3 class="wp-block-heading">' . $r[0] . '</h3><!-- /wp:heading -->' . $p( $r[1] ) ), $rows ) ) );

	if ( 'cy' === $lang ) {
		return array(
			'title'        => 'Sgorio',
			'summary'      => "Hunaniaeth ar yr awyr wedi'i mireinio i raglen bêl-droed S4C, a system symud lawn i'w chario: o'r sylw cyntaf i'r awyr mewn chwe wythnos, yn barod at agoriad tymor 2026–27.",
			'deliverables' => 'Nod gair ac eicon, lliw a theipograffeg, canllawiau, teitlau, cardiau agor a chau, wipes, graffeg llawn-ffrâm a thempledi Premiere Pro, pecyn cymdeithasol',
			'quote'        => '',
			'quote_by'     => '',
			'credits'      => "Cyfarwyddo creadigol: Daniel Parry Evans\nDylunio a symud: Creadigol",
			'content'      =>
				$h2( 'Y briff' ) .
				$p( "Sgorio yw cartref pêl-droed yn Gymraeg ers 1988, ac mae ei gynulleidfa'n adnabod y marc. Gofynnodd Rondo Media inni ei fireinio, nid ei ailddyfeisio: hunaniaeth ar yr awyr a allai gario gemau byw, uchafbwyntiau a llif cymdeithasol dyddiol fel un peth, a phecyn y gallai'r tîm cynhyrchu ei redeg eu hunain o'r penwythnos agoriadol ymlaen." ) .
				$film( 'montage.mp4', 'montage.jpg' ) .
				$h2( 'Y syniad' ) .
				$p( "Sgorio. Wedi'i fireinio. Cadwodd y nod gair ei lythrennau isaf ond cafodd ei ail-dorri o amgylch un symudiad: gêm o ddwy hanner. Mae'r 'o' wedi'i hollti'n agor fel giât, ac ar yr awyr mae'r nod gair yn ymestyn ar led i fframio'r cynnwys, cyn cau eto. Aeth yr un hollt i'r eicon: S mewn cylch wedi'i hollti, yr un-dau y gall bathodyn, proffil ac ergyd sgrin i gyd ei rannu." ) .
				$pair( 'roundel.jpg', 'Eicon Sgorio', 'wordmark-square.jpg', 'Nod gair Sgorio' ) .
				$h2( 'Lliw a theip' ) .
				$p( "Un porffor beiddgar, wedi'i ddewis i sefyll yn erbyn gwyrdd y cae, i osgoi lliwiau'r clybiau, ac i eistedd wrth ochr coch y tîm cenedlaethol heb ymladd ag ef. Oren i'w ateb, ar gyfer tagiau, troedynnau a'r ail lais yn y golau. Siarcol yn hytrach na du, a gwyn. Y tu ôl i'r cyfan, golau: streipiau o borffor ac oren wedi'u tynnu ar draws y tywyllwch sy'n rhoi symudiad i'r brand hyd yn oed pan fo'n llonydd. Sztos, cryno ac estynedig, i'r penawdau a'r sgôr. Late Serif i'r eiliadau dynol." ) .
				$pair( 'bg-purple.jpg', 'Cefndir golau porffor', 'bg-orange.jpg', 'Cefndir golau oren' ) .
				$h2( 'Yn gymdeithasol' ) .
				$p( "Un teulu o dempledi i'r ffrwd, wedi'i dorri o'r un brethyn â graffeg y darlledu. Y cylch ar y chwith uchaf, tag mewn cromfachau i ddweud pa fath o bost, pennawd trwm cywasgedig, a throedyn mono i'r gystadleuaeth a'r dyddiad. Mae'r ffotograffiaeth yn eistedd yn y golau, wedi'i goleuo o'r cefn gan y streipen borffor, gyda'r oren wedi'i ddewis i'r tag a'r troedyn. Mae gemau, canlyniadau, tablau, newyddion, dyfyniadau a rhagolygon i gyd yn dod o'r un pecyn, mewn 1:1, 4:5 a 9:16." ) .
				$row( array( array( 'social-final-ampadu.jpg', 'Post newyddion' ), array( 'social-final-news.jpg', 'Post newyddion' ), array( 'instagram.jpg', 'Proffil Instagram Sgorio' ) ) ) .
				$p( "Rhoddodd rownd un dri llais ar y bwrdd. Dan arweiniad y brand ar gyfer yr eiliadau mawr, gyda'r nod gair yn agor i fframio llun. Adroddiadol ar gyfer sgôr, dyfyniad a newyddion. Mynegiannol ar gyfer y chwaraewyr, lle mae'r golau'n adleisio o amgylch y ffigwr ac yn gallu cymryd lliwiau tîm neu gynghrair. Mae'r pecyn terfynol yn cadw'r gorau o bob un." ) .
				$row( array( array( 'social-02.jpg', 'Tymor newydd' ), array( 'social-04.jpg', 'Post mynegiannol, eicon' ), array( 'social-07.jpg', 'Post dan arweiniad y brand' ), array( 'social-06.jpg', 'Dyfyniad' ) ), 4 ) .
				$row( array( array( 'social-01.jpg', 'Sgôr terfynol' ), array( 'social-03.jpg', 'Y nod gair yn fframio llun' ), array( 'social-05.jpg', 'Post mynegiannol, adleisiau' ), array( 'social-08.jpg', 'Tymor newydd' ) ), 4 ) .
				$h2( 'Y system ar waith' ) .
				$p( "Cloiwyd y cyfeiriad ar 18 Mehefin. Erbyn 3 Gorffennaf roedd y system gyfan wedi'i hadeiladu: teitlau'r tymor, cardiau agor a chau, teulu o wipes, sgôr terfynol, hysbysebion gemau, tablau a thrydydd isaf fel templedi Premiere Pro y mae golygyddion yn eu gollwng i mewn a theipio. Pecyn cymdeithasol mewn tri llais, dan arweiniad y brand, adroddiadol a mynegiannol, sy'n gallu cymryd lliwiau tîm neu gynghrair, mewn 1:1, 4:5 a 9:16, gyda chelf clawr a phroffil i bob platfform. Trosglwyddwyd ar 10 Gorffennaf. Yn fyw ar 31 Gorffennaf." ) .
				$loop( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg', 'Gôl y Mis' ) .
				$pair( 'match-status.jpg', 'Bar statws gêm', 'lower-third.jpg', 'Trydydd isaf ar yr awyr' ) .
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
			$h2( 'The ask' ) .
			$p( 'Sgorio has been the home of football in Welsh since 1988, and its audience knows the mark. Rondo Media asked us to refine it, not reinvent it: an on-air identity that could carry live matches, highlights and a daily social feed as one thing, and a kit the production team could run themselves from the opening weekend on.' ) .
			$film( 'montage.mp4', 'montage.jpg' ) .
			$h2( 'The idea' ) .
			$p( "Sgorio. Refined. The wordmark kept its lowercase but was recut around one move: a game of two halves. The split 'o' opens like a gate, and on air the wordmark stretches wide to frame the content, then closes again. The same split went into the icon: an S inside a broken ring, the one-two that a badge, a profile and a screen bug can all share." ) .
			$pair( 'roundel.jpg', 'The Sgorio icon', 'wordmark-square.jpg', 'The Sgorio wordmark' ) .
			$h2( 'Colour and type' ) .
			$p( "One bold purple, chosen to stand against the green of the pitch, to avoid the classic club colours, and to sit beside the national team's red without fighting it. An orange to answer it, for tags, footers and the second voice in the light. Charcoal rather than black, and white. Behind it all, light: streaks of purple and orange drawn across the dark that give the brand motion even when it is standing still. Sztos, compact and extended, for the headlines and the score. Late Serif for the human moments." ) .
			$pair( 'bg-purple.jpg', 'Purple light background', 'bg-orange.jpg', 'Orange light background' ) .
			$h2( 'Getting social' ) .
			$p( "One template family for the feed, cut from the same cloth as the broadcast graphics. The roundel top left, a bracketed tag for the type of post, a heavy condensed headline, and a mono footer for competition and date. Photography sits in the light, lit from behind by the purple streak, with the orange picked out for the tag and the footer. Fixtures, results, tables, news, quotes and previews all come from the one kit, in 1:1, 4:5 and 9:16." ) .
			$row( array( array( 'social-final-ampadu.jpg', 'News post' ), array( 'social-final-news.jpg', 'News post' ), array( 'instagram.jpg', 'Sgorio Instagram profile' ) ) ) .
			$p( 'Round one put three voices on the table. Brand-led for the big moments, with the wordmark opening to frame a picture. Reportage for scores, quotes and news. Expression-led for the players, where the light echoes around the figure and can take on team or league colours. The delivered kit keeps the best of each.' ) .
			$row( array( array( 'social-02.jpg', 'New season' ), array( 'social-04.jpg', 'Expression-led post, icon' ), array( 'social-07.jpg', 'Brand-led post' ), array( 'social-06.jpg', 'Quote post' ) ), 4 ) .
			$row( array( array( 'social-01.jpg', 'Final score' ), array( 'social-03.jpg', 'The wordmark framing a picture' ), array( 'social-05.jpg', 'Expression-led post, echoes' ), array( 'social-08.jpg', 'New season' ) ), 4 ) .
			$h2( 'The system in motion' ) .
			$p( 'The direction was locked on 18 June. By 3 July the whole system was built: season titles, intro and end cards, a family of wipes, final score, match trails, tables and lower thirds as Premiere Pro templates that editors drop in and type. A social pack in three voices, brand-led, reportage and expression-led, that can take on team or league colours, in 1:1, 4:5 and 9:16, with cover and profile art for every platform. Handed over on 10 July. Live on 31 July.' ) .
			$loop( 'goal-of-the-month.mp4', 'goal-of-the-month.jpg', 'Goal of the Month' ) .
			$pair( 'match-status.jpg', 'Match status bar', 'lower-third.jpg', 'Lower third on air' ) .
			$stats( array( array( '6', 'Weeks from first look to air' ), array( '3', 'Icon routes, one chosen' ), array( '10+', 'Premiere Pro templates' ), array( '12', 'Social templates' ) ) ),
	);
};
