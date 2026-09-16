<?php
/**
 * Project details meta box for the Work post type.
 *
 * Fields (all under the _creadigol_ prefix):
 *  client, year, title_cy, summary, summary_cy, hero_video (attachment URL or Vimeo/YouTube URL),
 *  tile_video (attachment URL, short muted loop), featured (1/0), quote, quote_by, credits (one "Role: Name" per line).
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Field definitions: key => [label, type, help].
 */
function creadigol_work_fields(): array {
	return array(
		'client'     => array( __( 'Client', 'creadigol' ), 'text', __( 'For example "Rondo Media for S4C".', 'creadigol' ) ),
		'year'       => array( __( 'Year', 'creadigol' ), 'number', '' ),
		'title_cy'   => array( __( 'Title (Cymraeg)', 'creadigol' ), 'text', __( 'Leave empty if the title is the same in both languages.', 'creadigol' ) ),
		'summary'    => array( __( 'Summary (English)', 'creadigol' ), 'textarea', __( 'One sentence under the title, and the tile description.', 'creadigol' ) ),
		'summary_cy' => array( __( 'Crynodeb (Cymraeg)', 'creadigol' ), 'textarea', '' ),
		'hero_video' => array( __( 'Hero film', 'creadigol' ), 'media', __( 'An MP4 or WebM from the media library, or a Vimeo or YouTube URL. Falls back to the tile image.', 'creadigol' ) ),
		'tile_video' => array( __( 'Tile loop', 'creadigol' ), 'media', __( 'A short muted MP4 or WebM (under 3 MB, 4:5 or 16:9) that plays on hover in the work grid. Falls back to the tile image.', 'creadigol' ) ),
		'featured'   => array( __( 'Show on the home page', 'creadigol' ), 'checkbox', __( 'The home page shows the six most recent featured projects; the first two are large.', 'creadigol' ) ),
		'quote'      => array( __( 'Client quote', 'creadigol' ), 'textarea', __( 'Shown in the Outcome section. Leave empty to hide.', 'creadigol' ) ),
		'quote_by'   => array( __( 'Quote by', 'creadigol' ), 'text', __( 'Name, role, organisation.', 'creadigol' ) ),
		'credits'    => array( __( 'Credits', 'creadigol' ), 'textarea', __( 'One per line, as "Role: Name". For example "Creative direction: Daniel Parry Evans".', 'creadigol' ) ),
	);
}

/**
 * Read a field.
 */
function creadigol_work_meta( string $key, ?int $post_id = null ): string {
	$post_id = $post_id ?: get_the_ID();
	return (string) get_post_meta( $post_id, '_creadigol_' . $key, true );
}

/**
 * Register meta so it is available over REST and to WPML.
 */
function creadigol_register_work_meta(): void {
	foreach ( creadigol_work_fields() as $key => $def ) {
		register_post_meta(
			'work',
			'_creadigol_' . $key,
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_text_field',
				'auth_callback'     => fn() => current_user_can( 'edit_posts' ),
			)
		);
	}
}
add_action( 'init', 'creadigol_register_work_meta' );

/**
 * Add the meta box.
 */
function creadigol_add_meta_boxes(): void {
	add_meta_box( 'creadigol-project', __( 'Project details', 'creadigol' ), 'creadigol_render_meta_box', 'work', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'creadigol_add_meta_boxes' );

/**
 * Render the meta box.
 */
function creadigol_render_meta_box( WP_Post $post ): void {
	wp_nonce_field( 'creadigol_save_work', 'creadigol_work_nonce' );
	echo '<div class="creadigol-fields">';
	foreach ( creadigol_work_fields() as $key => [ $label, $type, $help ] ) {
		$id    = 'creadigol_' . $key;
		$value = creadigol_work_meta( $key, $post->ID );
		echo '<div class="creadigol-field creadigol-field--' . esc_attr( $type ) . '">';
		if ( 'checkbox' === $type ) {
			printf(
				'<label><input type="checkbox" id="%1$s" name="%1$s" value="1" %2$s> %3$s</label>',
				esc_attr( $id ),
				checked( $value, '1', false ),
				esc_html( $label )
			);
		} else {
			printf( '<label for="%s">%s</label>', esc_attr( $id ), esc_html( $label ) );
			if ( 'textarea' === $type ) {
				printf( '<textarea id="%1$s" name="%1$s" rows="3">%2$s</textarea>', esc_attr( $id ), esc_textarea( $value ) );
			} elseif ( 'media' === $type ) {
				printf(
					'<div class="creadigol-media"><input type="url" id="%1$s" name="%1$s" value="%2$s" placeholder="https://"> <button type="button" class="button creadigol-pick" data-target="%1$s">%3$s</button></div>',
					esc_attr( $id ),
					esc_attr( $value ),
					esc_html__( 'Choose from media library', 'creadigol' )
				);
			} else {
				printf( '<input type="%3$s" id="%1$s" name="%1$s" value="%2$s">', esc_attr( $id ), esc_attr( $value ), esc_attr( $type ) );
			}
		}
		if ( $help ) {
			printf( '<p class="description">%s</p>', esc_html( $help ) );
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Save the meta box.
 */
function creadigol_save_work_meta( int $post_id ): void {
	if ( ! isset( $_POST['creadigol_work_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['creadigol_work_nonce'] ) ), 'creadigol_save_work' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( creadigol_work_fields() as $key => [ , $type ] ) {
		$name = 'creadigol_' . $key;
		if ( 'checkbox' === $type ) {
			$value = isset( $_POST[ $name ] ) ? '1' : '';
		} elseif ( ! isset( $_POST[ $name ] ) ) {
			continue;
		} elseif ( 'textarea' === $type ) {
			$value = sanitize_textarea_field( wp_unslash( $_POST[ $name ] ) );
		} elseif ( 'media' === $type ) {
			$value = esc_url_raw( wp_unslash( $_POST[ $name ] ) );
		} else {
			$value = sanitize_text_field( wp_unslash( $_POST[ $name ] ) );
		}
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_creadigol_' . $key );
		} else {
			update_post_meta( $post_id, '_creadigol_' . $key, $value );
		}
	}
}
add_action( 'save_post_work', 'creadigol_save_work_meta' );

/**
 * Admin list columns: client and year.
 */
function creadigol_work_columns( array $columns ): array {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['creadigol_client'] = __( 'Client', 'creadigol' );
			$new['creadigol_year']   = __( 'Year', 'creadigol' );
		}
	}
	return $new;
}
add_filter( 'manage_work_posts_columns', 'creadigol_work_columns' );

function creadigol_work_column_content( string $column, int $post_id ): void {
	if ( 'creadigol_client' === $column ) {
		echo esc_html( creadigol_work_meta( 'client', $post_id ) );
	}
	if ( 'creadigol_year' === $column ) {
		echo esc_html( creadigol_work_meta( 'year', $post_id ) );
	}
}
add_action( 'manage_work_posts_custom_column', 'creadigol_work_column_content', 10, 2 );
