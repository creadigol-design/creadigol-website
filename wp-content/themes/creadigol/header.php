<?php
/**
 * Header: charcoal bar, wordmark with lime tally, bilingual menu, language switch, button.
 *
 * @package Creadigol
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip" href="#main"><?php esc_html_e( 'Skip to content', 'creadigol' ); ?></a>
<header class="site-header">
	<a class="wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<span class="wordmark__tally" aria-hidden="true"></span><?php bloginfo( 'name' ); ?>
	</a>
	<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'Primary', 'creadigol' ); ?>">
		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav__list', 'depth' => 1 ) );
		} else {
			// Fallback until a menu is assigned. Labels are bilingual by design.
			echo '<ul class="nav__list">';
			foreach ( array( 'work' => 'Gwaith / Work', 'studio' => 'Stiwdio / Studio', 'journal' => 'Dyddiadur / Journal', 'contact' => 'Cysylltu / Contact' ) as $slug => $label ) {
				printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' . $slug . '/' ) ), esc_html( $label ) );
			}
			echo '</ul>';
		}
		?>
	</nav>
	<div class="site-header__tools">
		<?php creadigol_language_switcher(); ?>
		<a class="button button--small" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( creadigol_get( 'header_button' ) ); ?></a>
		<button class="nav-toggle" type="button" aria-controls="nav" aria-expanded="false"><span class="sr-only"><?php esc_html_e( 'Menu', 'creadigol' ); ?></span><span aria-hidden="true"></span></button>
	</div>
</header>
<main id="main" class="site-main">
