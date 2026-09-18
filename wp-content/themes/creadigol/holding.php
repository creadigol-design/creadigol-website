<?php
/**
 * Holding page: logo, the showreel, one line in each language, contact.
 * Served by inc/holding.php while holding mode is on.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;
$film   = creadigol_holding_get( 'holding_video' );
$poster = creadigol_video_poster( $film, creadigol_holding_get( 'holding_poster' ) );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?php bloginfo( 'name' ); ?> — <?php esc_html_e( 'Coming soon', 'creadigol' ); ?></title>
<?php wp_head(); ?>
</head>
<body class="holding">
<?php wp_body_open(); ?>
<main class="holding__main">
	<a class="holding__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?>"><?php creadigol_logo( 'light' ); ?></a>

	<?php if ( $film ) : ?>
		<a class="holding__film poster" href="<?php echo esc_url( $film ); ?>" target="_blank" rel="noopener" data-showreel="<?php echo esc_url( $film ); ?>" aria-label="<?php esc_attr_e( 'Play the showreel', 'creadigol' ); ?>">
			<?php if ( $poster ) : ?><img class="poster__image" src="<?php echo esc_url( $poster ); ?>" alt=""><?php endif; ?>
			<span class="poster__play" aria-hidden="true"><svg width="88" height="88" viewBox="0 0 72 72" fill="none"><circle cx="36" cy="36" r="35" stroke="currentColor" stroke-width="1.5"/><path d="M29 24 L48 36 L29 48 Z" fill="currentColor"/></svg></span>
		</a>
	<?php endif; ?>

	<div class="holding__text">
		<h1 class="display holding__line"><?php echo esc_html( creadigol_holding_get( 'holding_line' ) ); ?></h1>
		<p class="display holding__line holding__line--cy" lang="cy"><?php echo esc_html( creadigol_holding_get( 'holding_line_cy' ) ); ?></p>
		<p class="holding__note"><?php echo esc_html( creadigol_holding_get( 'holding_note' ) ); ?></p>
		<div class="holding__actions">
			<?php if ( $film ) : ?>
				<a class="button" href="<?php echo esc_url( $film ); ?>" rel="noopener" target="_blank" data-showreel="<?php echo esc_url( $film ); ?>"><?php esc_html_e( 'Watch the showreel', 'creadigol' ); ?></a>
			<?php endif; ?>
			<?php if ( creadigol_get( 'email' ) ) : ?>
				<a class="holding__email" href="mailto:<?php echo esc_attr( creadigol_get( 'email' ) ); ?>"><?php echo esc_html( creadigol_get( 'email' ) ); ?></a>
			<?php endif; ?>
		</div>
	</div>

	<footer class="holding__footer">
		<span class="eyebrow eyebrow--dim"><?php echo esc_html( creadigol_get( 'footer_line' ) ); ?></span>
		<span class="eyebrow eyebrow--dim">
			<?php foreach ( array( 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'vimeo' => 'Vimeo' ) as $key => $label ) : ?>
				<?php if ( creadigol_get( $key ) ) : ?><a href="<?php echo esc_url( creadigol_get( $key ) ); ?>" rel="noopener"><?php echo esc_html( $label ); ?></a><?php endif; ?>
			<?php endforeach; ?>
		</span>
	</footer>
</main>
<dialog class="reel" id="reel"><button class="reel__close" type="button" aria-label="<?php esc_attr_e( 'Close', 'creadigol' ); ?>">×</button><div class="reel__frame"></div></dialog>
<?php wp_footer(); ?>
</body>
</html>
