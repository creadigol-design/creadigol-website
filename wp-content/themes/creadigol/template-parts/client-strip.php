<?php
/**
 * Lime client strip. Duplicated once so the marquee can loop seamlessly.
 *
 * @package Creadigol
 */
$clients = creadigol_clients();
if ( ! $clients ) {
	return;
}
?>
<div class="strip" aria-label="<?php esc_attr_e( 'Clients', 'creadigol' ); ?>">
	<div class="strip__track">
		<?php for ( $i = 0; $i < 2; $i++ ) : ?>
			<?php foreach ( $clients as $client ) : ?>
				<span class="strip__item" <?php echo $i ? 'aria-hidden="true"' : ''; ?>><?php echo esc_html( $client ); ?></span><span class="strip__sep" aria-hidden="true">//</span>
			<?php endforeach; ?>
		<?php endfor; ?>
	</div>
</div>
