<?php
/**
 * Footer: four columns on charcoal.
 *
 * @package Creadigol
 */
?>
</main>
<footer class="site-footer">
	<div class="site-footer__grid">
		<div>
			<span class="wordmark wordmark--footer"><?php creadigol_logo( 'light' ); ?></span>
			<p class="site-footer__line"><?php echo esc_html( creadigol_get( 'footer_line' ) ); ?></p>
		</div>
		<div>
			<p class="eyebrow eyebrow--dim"><?php esc_html_e( 'Site', 'creadigol' ); ?></p>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'site-footer__list', 'depth' => 1 ) );
			} else {
				echo '<ul class="site-footer__list">';
				foreach ( array( 'work' => __( 'Work', 'creadigol' ), 'studio' => __( 'Studio', 'creadigol' ), 'journal' => __( 'Journal', 'creadigol' ), 'contact' => __( 'Contact', 'creadigol' ) ) as $slug => $label ) {
					printf( '<li><a href="%s">%s</a></li>', esc_url( home_url( '/' . $slug . '/' ) ), esc_html( $label ) );
				}
				echo '</ul>';
			}
			?>
		</div>
		<div>
			<p class="eyebrow eyebrow--dim"><?php esc_html_e( 'Follow', 'creadigol' ); ?></p>
			<ul class="site-footer__list">
				<?php foreach ( array( 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'vimeo' => 'Vimeo' ) as $key => $label ) : ?>
					<?php if ( creadigol_get( $key ) ) : ?>
						<li><a href="<?php echo esc_url( creadigol_get( $key ) ); ?>" rel="noopener"><?php echo esc_html( $label ); ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<div>
			<p class="eyebrow eyebrow--dim"><?php esc_html_e( 'Sister studio', 'creadigol' ); ?></p>
			<?php if ( creadigol_get( 'vedri_url' ) ) : ?>
				<a class="arrow-link" href="<?php echo esc_url( creadigol_get( 'vedri_url' ) ); ?>" rel="noopener">vedrí — <?php esc_html_e( 'virtual production', 'creadigol' ); ?> <span aria-hidden="true">→</span></a>
			<?php else : ?>
				<p class="site-footer__line">vedrí — <?php esc_html_e( 'virtual production', 'creadigol' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<div class="site-footer__legal">
		<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
		<span><?php esc_html_e( 'Creadigol Design Ltd, registered in England and Wales, 14051334', 'creadigol' ); ?> · <a href="<?php echo esc_url( get_privacy_policy_url() ?: home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'creadigol' ); ?></a></span>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
