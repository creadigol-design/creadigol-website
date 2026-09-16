<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 *
 * Big "Let's talk", contact details from the Customizer, and the form.
 *
 * @package Creadigol
 */

get_header();
the_post();
?>
<section class="section contact">
	<div class="contact__intro">
		<?php creadigol_eyebrow( 'Cysylltu', 'Contact' ); ?>
		<h1 class="display display--page"><?php the_title(); ?></h1>
		<div class="contact__text"><?php the_content(); ?></div>
		<?php if ( creadigol_get( 'reply_time' ) ) : ?><p class="contact__text"><?php echo esc_html( creadigol_get( 'reply_time' ) ); ?></p><?php endif; ?>
		<dl class="details">
			<?php if ( creadigol_get( 'email' ) ) : ?><div><dt class="eyebrow">E-bost</dt><dd><a href="mailto:<?php echo esc_attr( creadigol_get( 'email' ) ); ?>"><?php echo esc_html( creadigol_get( 'email' ) ); ?></a></dd></div><?php endif; ?>
			<?php if ( creadigol_get( 'phone' ) ) : ?><div><dt class="eyebrow">Ffôn</dt><dd><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', creadigol_get( 'phone' ) ) ); ?>"><?php echo esc_html( creadigol_get( 'phone' ) ); ?></a></dd></div><?php endif; ?>
			<?php if ( creadigol_get( 'address' ) ) : ?><div><dt class="eyebrow">Stiwdio</dt><dd><?php echo nl2br( esc_html( creadigol_get( 'address' ) ) ); ?></dd></div><?php endif; ?>
		</dl>
	</div>
	<div class="contact__form"><?php creadigol_contact_form(); ?></div>
</section>
<?php get_footer(); ?>
