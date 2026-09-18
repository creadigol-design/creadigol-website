<?php
/**
 * WP-CLI: migrate the old site's project posts into the Work post type.
 *
 *   wp creadigol migrate-work --categories=branding,motion,digital,content,ui,web,temp --dry-run
 *   wp creadigol migrate-work --categories=branding,motion,digital,content,ui,web,temp
 *   wp creadigol seed-disciplines
 *   wp creadigol first-run
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

class Creadigol_CLI {

	/**
	 * Convert posts in the given categories to Work case studies.
	 *
	 * ## OPTIONS
	 *
	 * [--categories=<slugs>]
	 * : Comma-separated category slugs whose posts are projects. Default: branding,motion,digital,content,ui,web,temp
	 *
	 * [--dry-run]
	 * : Report without changing anything.
	 */
	public function migrate_work( array $args, array $assoc ): void {
		$slugs = array_map( 'trim', explode( ',', $assoc['categories'] ?? 'branding,motion,digital,content,ui,web,temp' ) );
		$dry   = isset( $assoc['dry-run'] );
		$log   = creadigol_migrate_work( $slugs, $dry );
		$last  = array_pop( $log );
		foreach ( $log as $line ) {
			WP_CLI::log( $line );
		}
		WP_CLI::success( $last );
	}

	/**
	 * Create pages, menus, reading settings and disciplines (same as activation).
	 */
	public function first_run(): void {
		foreach ( creadigol_first_run() as $line ) {
			WP_CLI::log( $line );
		}
		WP_CLI::success( 'First-run setup complete.' );
	}

	/**
	 * Create the default discipline terms.
	 */
	public function seed_disciplines(): void {
		creadigol_seed_disciplines();
		WP_CLI::success( 'Disciplines seeded.' );
	}
}
WP_CLI::add_command( 'creadigol', 'Creadigol_CLI' );
