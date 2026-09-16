<?php
/**
 * Closing call to action, bilingual, on charcoal.
 *
 * @package Creadigol
 */
?>
<section class="cta">
	<?php creadigol_eyebrow( 'Cysylltu', 'Get in touch', 'eyebrow--dim' ); ?>
	<div class="cta__pair">
		<h2 class="display cta__cy" lang="cy"><?php echo esc_html( creadigol_get( 'cta_cy' ) ); ?></h2>
		<h2 class="display cta__en" lang="en"><?php echo esc_html( creadigol_get( 'cta_en' ) ); ?></h2>
	</div>
	<div class="cta__actions">
		<a class="button" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php echo esc_html( creadigol_get( 'cta_button' ) ); ?></a>
		<?php if ( creadigol_get( 'email' ) ) : ?>
			<a class="cta__email" href="mailto:<?php echo esc_attr( creadigol_get( 'email' ) ); ?>"><?php echo esc_html( creadigol_get( 'email' ) ); ?></a>
		<?php endif; ?>
	</div>
</section>
