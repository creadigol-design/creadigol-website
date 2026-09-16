<?php
/**
 * Closing call to action on charcoal.
 *
 * @package Creadigol
 */
?>
<section class="cta">
	<?php creadigol_eyebrow( __( 'Get in touch', 'creadigol' ), 'eyebrow--dim' ); ?>
	<h2 class="display cta__title"><?php echo esc_html( creadigol_get( 'cta' ) ); ?></h2>
	<div class="cta__actions">
		<a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( creadigol_get( 'cta_button' ) ); ?></a>
		<?php if ( creadigol_get( 'email' ) ) : ?>
			<a class="cta__email" href="mailto:<?php echo esc_attr( creadigol_get( 'email' ) ); ?>"><?php echo esc_html( creadigol_get( 'email' ) ); ?></a>
		<?php endif; ?>
	</div>
</section>
