<?php
/**
 * Block patterns for case study bodies: the six block types the design allows.
 *
 * @package Creadigol
 */

defined( 'ABSPATH' ) || exit;

function creadigol_patterns(): void {
	register_block_pattern_category( 'creadigol', array( 'label' => __( 'Creadigol case study', 'creadigol' ) ) );

	register_block_pattern(
		'creadigol/text-section',
		array(
			'title'      => __( 'Text section (label + paragraphs)', 'creadigol' ),
			'categories' => array( 'creadigol' ),
			'content'    => '<!-- wp:heading {"level":2} --><h2 class="wp-block-heading">The idea</h2><!-- /wp:heading --><!-- wp:paragraph --><p>The one idea the identity is built on, and how it behaves in motion.</p><!-- /wp:paragraph -->',
		)
	);
	register_block_pattern(
		'creadigol/image-pair',
		array(
			'title'      => __( 'Image pair', 'creadigol' ),
			'categories' => array( 'creadigol' ),
			'content'    => '<!-- wp:columns {"align":"wide"} --><div class="wp-block-columns alignwide"><!-- wp:column --><div class="wp-block-column"><!-- wp:image --><figure class="wp-block-image"><img alt=""/></figure><!-- /wp:image --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:image --><figure class="wp-block-image"><img alt=""/></figure><!-- /wp:image --></div><!-- /wp:column --></div><!-- /wp:columns -->',
		)
	);
	register_block_pattern(
		'creadigol/full-bleed-video',
		array(
			'title'      => __( 'Full-bleed video', 'creadigol' ),
			'categories' => array( 'creadigol' ),
			'content'    => '<!-- wp:video {"align":"wide"} --><figure class="wp-block-video alignwide"></figure><!-- /wp:video -->',
		)
	);
	register_block_pattern(
		'creadigol/stat-row',
		array(
			'title'      => __( 'Stat row (three numbers)', 'creadigol' ),
			'categories' => array( 'creadigol' ),
			'content'    => '<!-- wp:columns {"className":"stats"} --><div class="wp-block-columns stats"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">12</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Idents delivered</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">2</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Languages, designed together</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">6</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Weeks from brief to air</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
		)
	);
	register_block_pattern(
		'creadigol/quote',
		array(
			'title'      => __( 'Quote', 'creadigol' ),
			'categories' => array( 'creadigol' ),
			'content'    => '<!-- wp:quote --><blockquote class="wp-block-quote"><!-- wp:paragraph --><p>“What the client said.”</p><!-- /wp:paragraph --><cite>Name, role, organisation</cite></blockquote><!-- /wp:quote -->',
		)
	);
}
add_action( 'init', 'creadigol_patterns' );

/**
 * Limit the editor to the blocks the design uses. Editors of Work posts see
 * only these; pages and posts get the same list plus lists and embeds.
 */
function creadigol_allowed_blocks( $allowed, WP_Block_Editor_Context $context ) {
	$base = array( 'core/paragraph', 'core/heading', 'core/image', 'core/video', 'core/columns', 'core/column', 'core/quote', 'core/embed', 'core/separator', 'core/spacer', 'core/list', 'core/list-item', 'core/buttons', 'core/button', 'core/group' );
	if ( $context->post && 'work' === $context->post->post_type ) {
		return $base;
	}
	return array_merge( $base, array( 'core/table', 'core/gallery', 'core/html', 'core/shortcode', 'core/media-text', 'core/details' ) );
}
add_filter( 'allowed_block_types_all', 'creadigol_allowed_blocks', 10, 2 );
