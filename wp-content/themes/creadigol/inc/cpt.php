<?php
/**
 * Work post type and Discipline taxonomy.
 *
 * A case study is a Work post: title, hero, tile, project details (meta box),
 * body written with a small set of blocks, credits and quote (meta box).
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register post type and taxonomy.
 */
function creadigol_register_work(): void {
	register_post_type(
		'work',
		array(
			'labels'        => array(
				'name'               => __( 'Work', 'creadigol' ),
				'singular_name'      => __( 'Case study', 'creadigol' ),
				'add_new'            => __( 'Add case study', 'creadigol' ),
				'add_new_item'       => __( 'Add case study', 'creadigol' ),
				'edit_item'          => __( 'Edit case study', 'creadigol' ),
				'new_item'           => __( 'New case study', 'creadigol' ),
				'view_item'          => __( 'View case study', 'creadigol' ),
				'search_items'       => __( 'Search work', 'creadigol' ),
				'not_found'          => __( 'No case studies yet.', 'creadigol' ),
				'all_items'          => __( 'All work', 'creadigol' ),
				'menu_name'          => __( 'Work', 'creadigol' ),
				'featured_image'     => __( 'Tile image (4:5, shown on the work grid when no loop is set)', 'creadigol' ),
				'set_featured_image' => __( 'Set tile image', 'creadigol' ),
			),
			'public'        => true,
			'has_archive'   => 'work',
			'rewrite'       => array( 'slug' => 'work', 'with_front' => false ),
			'menu_position' => 5,
			'menu_icon'     => 'dashicons-video-alt3',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ),
			'show_in_rest'  => true,
			'template'      => creadigol_work_block_template(),
		)
	);

	register_taxonomy(
		'discipline',
		'work',
		array(
			'labels'            => array(
				'name'          => __( 'Disciplines', 'creadigol' ),
				'singular_name' => __( 'Discipline', 'creadigol' ),
				'search_items'  => __( 'Search disciplines', 'creadigol' ),
				'all_items'     => __( 'All disciplines', 'creadigol' ),
				'edit_item'     => __( 'Edit discipline', 'creadigol' ),
				'add_new_item'  => __( 'Add discipline', 'creadigol' ),
			),
			'public'            => true,
			'hierarchical'      => false,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'work/discipline', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'creadigol_register_work' );

/**
 * The starting block layout for a new case study. Six block types only,
 * matching the case-study template in the plan: text, video, image,
 * image pair, quote, stats. Editors can add or remove blocks.
 */
function creadigol_work_block_template(): array {
	return array(
		array( 'core/heading', array( 'level' => 2, 'content' => __( 'The ask', 'creadigol' ) ) ),
		array( 'core/paragraph', array( 'placeholder' => __( 'What the client asked for, and the context: audience, history, constraints. Two or three sentences.', 'creadigol' ) ) ),
		array( 'core/video', array() ),
		array( 'core/heading', array( 'level' => 2, 'content' => __( 'The idea', 'creadigol' ) ) ),
		array( 'core/paragraph', array( 'placeholder' => __( 'The one idea the identity is built on, and how it behaves in motion.', 'creadigol' ) ) ),
		array(
			'core/columns',
			array(),
			array(
				array( 'core/column', array(), array( array( 'core/image', array() ) ) ),
				array( 'core/column', array(), array( array( 'core/image', array() ) ) ),
			),
		),
		array( 'core/heading', array( 'level' => 2, 'content' => __( 'The system in motion', 'creadigol' ) ) ),
		array( 'core/video', array() ),
	);
}

/**
 * Default disciplines. Idempotent.
 */
function creadigol_seed_disciplines(): void {
	if ( ! taxonomy_exists( 'discipline' ) ) {
		creadigol_register_work();
	}
	foreach ( array( 'Branding', 'Motion', 'Broadcast', 'Digital', 'Campaign' ) as $term ) {
		if ( ! term_exists( $term, 'discipline' ) ) {
			wp_insert_term( $term, 'discipline' );
		}
	}
}

/**
 * Work archive: order by the "order" meta, then date. Show all disciplines
 * on the archive and let the front end filter without reloading.
 */
function creadigol_work_query( WP_Query $query ): void {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( 'work' ) || $query->is_tax( 'discipline' ) ) {
		$query->set( 'posts_per_page', 60 );
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'DESC' ) );
	}
}
add_action( 'pre_get_posts', 'creadigol_work_query' );
