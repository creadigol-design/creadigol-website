<?php
/**
 * First-run setup and the old-project migration, runnable from wp-admin.
 *
 * Activation creates the pages, reading settings, menus and disciplines the theme expects,
 * switches the holding page on and, on a fresh site, sets pretty permalinks. Everything is
 * idempotent: it only creates what is missing, so re-running is safe.
 *
 * Appearance > Creadigol setup lets you re-run it and migrate the old site's project posts
 * into Work case studies without WP-CLI.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Find a page by slug, in any status except trash.
 */
function creadigol_find_page( string $slug ): ?WP_Post {
	$found = get_posts(
		array(
			'post_type'      => 'page',
			'name'           => $slug,
			'post_status'    => array( 'publish', 'draft', 'private', 'pending' ),
			'posts_per_page' => 1,
		)
	);
	return $found[0] ?? null;
}

/**
 * Create a page if it does not exist. Returns the page ID either way.
 */
function creadigol_ensure_page( string $title, string $slug, string $template = '', string $content = '' ): int {
	$page = creadigol_find_page( $slug );
	if ( $page ) {
		if ( $template && get_page_template_slug( $page->ID ) !== $template ) {
			update_post_meta( $page->ID, '_wp_page_template', $template );
		}
		return (int) $page->ID;
	}
	$id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_status'  => 'publish',
			'post_content' => $content,
		)
	);
	if ( $id && $template ) {
		update_post_meta( $id, '_wp_page_template', $template );
	}
	return (int) $id;
}

/**
 * Create a menu for a location if that location has nothing assigned.
 *
 * @param array $items Each item: array( label, url ) or array( label, page_id ).
 */
function creadigol_ensure_menu( string $location, string $name, array $items ): string {
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locations[ $location ] ) && wp_get_nav_menu_object( $locations[ $location ] ) ) {
		return sprintf( 'Menu "%s" already assigned.', $location );
	}
	$menu = wp_get_nav_menu_object( $name );
	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( $name );
		if ( is_wp_error( $menu_id ) ) {
			return sprintf( 'Could not create menu "%s": %s', $name, $menu_id->get_error_message() );
		}
		foreach ( $items as $i => [ $label, $target ] ) {
			$args = array( 'menu-item-title' => $label, 'menu-item-status' => 'publish', 'menu-item-position' => $i + 1 );
			if ( is_int( $target ) ) {
				$args['menu-item-type']      = 'post_type';
				$args['menu-item-object']    = 'page';
				$args['menu-item-object-id'] = $target;
			} else {
				$args['menu-item-type'] = 'custom';
				$args['menu-item-url']  = $target;
			}
			wp_update_nav_menu_item( $menu_id, 0, $args );
		}
	} else {
		$menu_id = (int) $menu->term_id;
	}
	$locations[ $location ] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
	return sprintf( 'Menu "%s" created and assigned to %s.', $name, $location );
}

/**
 * Everything the README's "first-run setup" describes, done in one go.
 *
 * @return string[] Log lines.
 */
function creadigol_first_run(): array {
	$log = array();

	creadigol_seed_disciplines();
	$log[] = 'Disciplines: Branding, Motion, Broadcast, Digital, Campaign.';

	$home    = creadigol_ensure_page( 'Home', 'home' );
	$studio  = creadigol_ensure_page( 'Studio', 'studio', '', creadigol_studio_starter_content() );
	$contact = creadigol_ensure_page( 'Contact', 'contact', 'page-contact.php' );
	$journal = creadigol_ensure_page( 'Journal', 'journal' );
	$log[]   = 'Pages: Home, Studio, Contact, Journal.';

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home );
	update_option( 'page_for_posts', $journal );
	$log[] = 'Reading: static front page = Home, posts page = Journal.';

	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		$log[] = 'Permalinks set to /%postname%/.';
	}

	$work  = home_url( '/work/' );
	$log[] = creadigol_ensure_menu(
		'primary',
		'Primary',
		array( array( 'Work', $work ), array( 'Studio', $studio ), array( 'Journal', $journal ), array( 'Contact', $contact ) )
	);
	$log[] = creadigol_ensure_menu(
		'footer',
		'Footer',
		array( array( 'Work', $work ), array( 'Studio', $studio ), array( 'Journal', $journal ), array( 'Contact', $contact ) )
	);

	if ( false !== stripos( (string) get_option( 'blogname' ), 'Creadigol Design' ) ) {
		update_option( 'blogname', 'Creadigol' );
		$log[] = 'Site title changed to "Creadigol".';
	}

	if ( ! get_option( 'creadigol_setup_done' ) ) {
		set_theme_mod( 'creadigol_holding_on', '1' );
		update_option( 'creadigol_setup_done', time() );
		$log[] = 'Holding page switched ON. Visitors see the holding page; you see the full site while logged in.';
	}

	flush_rewrite_rules();
	$log[] = 'Permalinks flushed.';

	return $log;
}

/**
 * A short starter for the Studio page so it is not blank on day one.
 */
function creadigol_studio_starter_content(): string {
	return "<!-- wp:paragraph -->\n<p>Creadigol is a branding and motion studio in Bangor, North Wales. We build identities with motion at the core, from a sports-broadcast background, designed in Welsh and English together.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Replace this with the studio story: who we are, how we work, who we have worked with.</p>\n<!-- /wp:paragraph -->";
}

/**
 * Convert posts in the given categories to Work case studies.
 *
 * @return string[] Log lines.
 */
function creadigol_migrate_work( array $slugs, bool $dry ): array {
	$map = array( 'branding' => 'Branding', 'motion' => 'Motion', 'digital' => 'Digital', 'web' => 'Digital', 'ui' => 'Digital', 'content' => 'Campaign' );
	$log = array();

	creadigol_seed_disciplines();

	$posts = get_posts(
		array(
			'post_type'      => 'post',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'tax_query'      => array( array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => $slugs ) ),
		)
	);
	$log[] = sprintf( 'Found %d posts in categories: %s', count( $posts ), implode( ', ', $slugs ) );

	foreach ( $posts as $post ) {
		$cats  = wp_get_post_categories( $post->ID, array( 'fields' => 'slugs' ) );
		$terms = array_values( array_unique( array_filter( array_map( fn( $c ) => $map[ $c ] ?? null, $cats ) ) ) );
		$log[] = sprintf( '%s "%s" -> work, disciplines: %s', $dry ? '[dry]' : '[move]', $post->post_title, implode( ', ', $terms ) ?: 'none' );
		if ( $dry ) {
			continue;
		}
		wp_update_post( array( 'ID' => $post->ID, 'post_type' => 'work' ) );
		wp_set_object_terms( $post->ID, $terms, 'discipline' );
		wp_set_object_terms( $post->ID, array(), 'category' );
		if ( $post->post_excerpt && ! creadigol_work_meta( 'summary', $post->ID ) ) {
			update_post_meta( $post->ID, '_creadigol_summary', sanitize_text_field( $post->post_excerpt ) );
		}
	}
	if ( ! $dry ) {
		flush_rewrite_rules();
	}
	$log[] = $dry ? 'Dry run complete. Nothing changed.' : 'Migration complete. Now fill in Project details on each case study.';
	return $log;
}

/**
 * Run the first-run setup on activation.
 */
function creadigol_activate(): void {
	creadigol_first_run();
	set_transient( 'creadigol_activated', 1, 300 );
}
add_action( 'after_switch_theme', 'creadigol_activate' );

/**
 * Appearance > Creadigol setup.
 */
function creadigol_setup_menu(): void {
	add_theme_page( __( 'Creadigol setup', 'creadigol' ), __( 'Creadigol setup', 'creadigol' ), 'manage_options', 'creadigol-setup', 'creadigol_setup_page' );
}
add_action( 'admin_menu', 'creadigol_setup_menu' );

function creadigol_setup_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$log = array();
	if ( isset( $_POST['creadigol_action'] ) && check_admin_referer( 'creadigol_setup' ) ) {
		$action = sanitize_key( wp_unslash( $_POST['creadigol_action'] ) );
		$slugs  = array_filter( array_map( 'sanitize_title', array_map( 'trim', explode( ',', sanitize_text_field( wp_unslash( $_POST['creadigol_categories'] ?? '' ) ) ) ) ) );
		if ( 'first_run' === $action ) {
			$log = creadigol_first_run();
		} elseif ( 'migrate_dry' === $action ) {
			$log = creadigol_migrate_work( $slugs, true );
		} elseif ( 'migrate' === $action ) {
			$log = creadigol_migrate_work( $slugs, false );
		}
	}
	$holding = creadigol_holding_get( 'holding_on' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Creadigol setup', 'creadigol' ); ?></h1>

		<?php if ( $log ) : ?>
			<div class="notice notice-success"><pre style="white-space:pre-wrap;margin:12px 0"><?php echo esc_html( implode( "\n", $log ) ); ?></pre></div>
		<?php endif; ?>

		<p>
			<?php if ( $holding ) : ?>
				<strong><?php esc_html_e( 'Holding page is ON.', 'creadigol' ); ?></strong>
				<?php esc_html_e( 'Visitors see the holding page and the showreel. You see the full site while logged in.', 'creadigol' ); ?>
			<?php else : ?>
				<strong><?php esc_html_e( 'Holding page is OFF.', 'creadigol' ); ?></strong>
				<?php esc_html_e( 'The full site is live to visitors.', 'creadigol' ); ?>
			<?php endif; ?>
			<a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=creadigol_holding' ) ); ?>"><?php esc_html_e( 'Change in the Customiser', 'creadigol' ); ?></a>
		</p>

		<h2><?php esc_html_e( '1. First-run setup', 'creadigol' ); ?></h2>
		<p><?php esc_html_e( 'Runs automatically on activation. Creates the Home, Studio, Contact and Journal pages, sets the front page, builds the two menus and seeds the disciplines. Safe to run again: it only adds what is missing.', 'creadigol' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'creadigol_setup' ); ?>
			<input type="hidden" name="creadigol_action" value="first_run">
			<?php submit_button( __( 'Run first-run setup', 'creadigol' ), 'secondary', 'submit', false ); ?>
		</form>

		<h2><?php esc_html_e( '2. Migrate the old projects', 'creadigol' ); ?></h2>
		<p><?php esc_html_e( 'Turns the old site\'s project posts into Work case studies, mapping their categories to disciplines. Do a dry run first: it lists what would move without changing anything.', 'creadigol' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'creadigol_setup' ); ?>
			<p>
				<label for="creadigol_categories"><?php esc_html_e( 'Category slugs', 'creadigol' ); ?></label><br>
				<input type="text" class="regular-text" id="creadigol_categories" name="creadigol_categories" value="branding,motion,digital,content,ui,web,temp">
			</p>
			<p>
				<button type="submit" class="button button-secondary" name="creadigol_action" value="migrate_dry"><?php esc_html_e( 'Dry run', 'creadigol' ); ?></button>
				<button type="submit" class="button button-primary" name="creadigol_action" value="migrate"><?php esc_html_e( 'Migrate now', 'creadigol' ); ?></button>
			</p>
		</form>

		<h2><?php esc_html_e( '3. Fill it in', 'creadigol' ); ?></h2>
		<ul style="list-style:disc;padding-left:20px">
			<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=creadigol' ) ); ?>"><?php esc_html_e( 'Customise > Creadigol', 'creadigol' ); ?></a>: <?php esc_html_e( 'headline, showreel loop and link, client strip, services, contact details.', 'creadigol' ); ?></li>
			<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=work' ) ); ?>"><?php esc_html_e( 'Work', 'creadigol' ); ?></a>: <?php esc_html_e( 'open each case study, fill in Project details, add a tile image and loop, tick up to six as featured.', 'creadigol' ); ?></li>
			<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=creadigol_holding' ) ); ?>"><?php esc_html_e( 'Holding page', 'creadigol' ); ?></a>: <?php esc_html_e( 'untick "Show the holding page" when you are ready to launch.', 'creadigol' ); ?></li>
		</ul>
	</div>
	<?php
}

/**
 * One notice after activation pointing at the setup page.
 */
function creadigol_activation_notice(): void {
	if ( ! get_transient( 'creadigol_activated' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	delete_transient( 'creadigol_activated' );
	printf(
		'<div class="notice notice-success is-dismissible"><p><strong>%s</strong> %s <a href="%s">%s</a></p></div>',
		esc_html__( 'Creadigol is active.', 'creadigol' ),
		esc_html__( 'Pages, menus and the holding page are set up. Visitors now see the holding page; you see the full site while logged in.', 'creadigol' ),
		esc_url( admin_url( 'themes.php?page=creadigol-setup' ) ),
		esc_html__( 'Open Creadigol setup', 'creadigol' )
	);
}
add_action( 'admin_notices', 'creadigol_activation_notice' );
