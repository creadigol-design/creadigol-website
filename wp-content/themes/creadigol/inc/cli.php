<?php
/**
 * WP-CLI: migrate the old site's project posts into the Work post type.
 *
 *   wp creadigol migrate-work --categories=branding,motion,digital,content,ui,web,temp --dry-run
 *   wp creadigol migrate-work --categories=branding,motion,digital,content,ui,web,temp
 *   wp creadigol seed-disciplines
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
		$map   = array( 'branding' => 'Branding', 'motion' => 'Motion', 'digital' => 'Digital', 'web' => 'Digital', 'ui' => 'Digital', 'content' => 'Campaign' );

		creadigol_seed_disciplines();

		$posts = get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'tax_query'      => array( array( 'taxonomy' => 'category', 'field' => 'slug', 'terms' => $slugs ) ),
			)
		);
		WP_CLI::log( sprintf( 'Found %d posts in categories: %s', count( $posts ), implode( ', ', $slugs ) ) );

		foreach ( $posts as $post ) {
			$cats  = wp_get_post_categories( $post->ID, array( 'fields' => 'slugs' ) );
			$terms = array_values( array_unique( array_filter( array_map( fn( $c ) => $map[ $c ] ?? null, $cats ) ) ) );
			WP_CLI::log( sprintf( '%s "%s" -> work, disciplines: %s', $dry ? '[dry]' : '[move]', $post->post_title, implode( ', ', $terms ) ?: 'none' ) );
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
		WP_CLI::success( $dry ? 'Dry run complete.' : 'Migration complete. Now fill in Project details on each case study.' );
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
