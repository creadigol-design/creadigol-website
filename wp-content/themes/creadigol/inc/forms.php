<?php
/**
 * Contact form: no plugin, nonce, honeypot, wp_mail to the Customizer email.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

function creadigol_handle_contact(): void {
	if ( ! isset( $_POST['creadigol_contact_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['creadigol_contact_nonce'] ) ), 'creadigol_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', wp_get_referer() ?: home_url( '/contact/' ) ) );
		exit;
	}
	// Honeypot: real people leave "website" empty.
	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '1', wp_get_referer() ?: home_url( '/' ) ) );
		exit;
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['email'] ?? '' ) );
	$org     = sanitize_text_field( wp_unslash( $_POST['organisation'] ?? '' ) );
	$needs   = array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['needs'] ?? array() ) );
	$budget  = sanitize_text_field( wp_unslash( $_POST['budget'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'sent', 'missing', wp_get_referer() ?: home_url( '/contact/' ) ) );
		exit;
	}

	$to      = creadigol_get( 'email' ) ?: get_option( 'admin_email' );
	$subject = sprintf( '[%s] %s', get_bloginfo( 'name' ), $org ? "$name, $org" : $name );
	$body    = implode(
		"\n",
		array(
			"Name: $name",
			"Email: $email",
			'Organisation: ' . ( $org ?: '—' ),
			'Needs: ' . ( $needs ? implode( ', ', $needs ) : '—' ),
			'Budget: ' . ( $budget ?: '—' ),
			'',
			$message,
		)
	);
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	wp_mail( $to, $subject, $body, $headers );
	wp_safe_redirect( add_query_arg( 'sent', '1', wp_get_referer() ?: home_url( '/contact/' ) ) );
	exit;
}
add_action( 'admin_post_nopriv_creadigol_contact', 'creadigol_handle_contact' );
add_action( 'admin_post_creadigol_contact', 'creadigol_handle_contact' );

/**
 * Render the form (used by page-contact.php).
 */
function creadigol_contact_form(): void {
	$sent  = isset( $_GET['sent'] ) ? sanitize_key( wp_unslash( $_GET['sent'] ) ) : '';
	$needs = array(
		__( 'Brand identity', 'creadigol' ),
		__( 'Motion', 'creadigol' ),
		__( 'Broadcast graphics', 'creadigol' ),
		__( 'Website', 'creadigol' ),
		__( 'Not sure yet', 'creadigol' ),
	);
	?>
	<form class="form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="creadigol_contact">
		<?php wp_nonce_field( 'creadigol_contact', 'creadigol_contact_nonce' ); ?>
		<p class="form__hp"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>

		<?php if ( '1' === $sent ) : ?>
			<p class="form__notice" role="status"><?php esc_html_e( 'Diolch. Thanks, we have your message and will reply soon.', 'creadigol' ); ?></p>
		<?php elseif ( $sent ) : ?>
			<p class="form__notice form__notice--error" role="alert"><?php esc_html_e( 'Something was missing. Please check your name, email and message and try again.', 'creadigol' ); ?></p>
		<?php endif; ?>

		<div class="form__row form__row--2">
			<label class="field"><span class="field__label"><?php esc_html_e( 'Enw / Name', 'creadigol' ); ?></span><input type="text" name="name" required autocomplete="name"></label>
			<label class="field"><span class="field__label"><?php esc_html_e( 'E-bost / Email', 'creadigol' ); ?></span><input type="email" name="email" required autocomplete="email"></label>
		</div>
		<label class="field"><span class="field__label"><?php esc_html_e( 'Sefydliad / Organisation', 'creadigol' ); ?></span><input type="text" name="organisation" autocomplete="organization"></label>
		<fieldset class="field">
			<legend class="field__label"><?php esc_html_e( 'Beth sydd ei angen arnoch? / What do you need?', 'creadigol' ); ?></legend>
			<div class="chips">
				<?php foreach ( $needs as $need ) : ?>
					<label class="chip"><input type="checkbox" name="needs[]" value="<?php echo esc_attr( $need ); ?>"><span><?php echo esc_html( $need ); ?></span></label>
				<?php endforeach; ?>
			</div>
		</fieldset>
		<label class="field"><span class="field__label"><?php esc_html_e( 'Cyllideb / Budget', 'creadigol' ); ?></span>
			<select name="budget">
				<option value=""><?php esc_html_e( 'Select a range', 'creadigol' ); ?></option>
				<option>Under £5k</option><option>£5k–£15k</option><option>£15k–£40k</option><option>£40k+</option><option><?php esc_html_e( 'Not sure yet', 'creadigol' ); ?></option>
			</select>
		</label>
		<label class="field"><span class="field__label"><?php esc_html_e( 'Y prosiect / The project', 'creadigol' ); ?></span><textarea name="message" rows="5" required placeholder="<?php esc_attr_e( 'A few lines is plenty.', 'creadigol' ); ?>"></textarea></label>
		<button class="button" type="submit"><?php esc_html_e( 'Anfon / Send', 'creadigol' ); ?></button>
	</form>
	<?php
}
