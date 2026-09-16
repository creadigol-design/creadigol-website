<?php
/**
 * Case study: hero, meta row, block content, quote, credits, next project.
 *
 * @package Creadigol
 */

get_header();
the_post();
$id     = get_the_ID();
$terms  = get_the_terms( $id, 'discipline' );
$tags   = $terms && ! is_wp_error( $terms ) ? wp_list_pluck( $terms, 'name' ) : array();
$client = creadigol_work_meta( 'client' );
$year   = creadigol_work_meta( 'year' );
$quote  = creadigol_work_meta( 'quote' );
$creds  = creadigol_credits( $id );
$next   = creadigol_next_work( $id );
?>
<article class="case">
	<header class="section case__head">
		<p class="eyebrow case__meta">
			<?php echo esc_html( implode( ' · ', array_filter( array_merge( array( $client, $year ), $tags ) ) ) ); ?>
		</p>
		<h1 class="display display--page"><?php echo esc_html( creadigol_work_title( $id ) ); ?></h1>
		<?php if ( creadigol_work_summary( $id ) ) : ?>
			<p class="case__summary"><?php echo esc_html( creadigol_work_summary( $id ) ); ?></p>
		<?php endif; ?>
	</header>

	<?php creadigol_hero_film( $id ); ?>

	<dl class="section case__facts">
		<?php if ( $client ) : ?><div><dt class="eyebrow"><?php esc_html_e( 'Client', 'creadigol' ); ?></dt><dd><?php echo esc_html( $client ); ?></dd></div><?php endif; ?>
		<?php if ( $year ) : ?><div><dt class="eyebrow"><?php esc_html_e( 'Year', 'creadigol' ); ?></dt><dd><?php echo esc_html( $year ); ?></dd></div><?php endif; ?>
		<?php if ( $tags ) : ?><div><dt class="eyebrow"><?php esc_html_e( 'Disciplines', 'creadigol' ); ?></dt><dd><?php echo esc_html( implode( ' · ', $tags ) ); ?></dd></div><?php endif; ?>
		<?php if ( has_excerpt() ) : ?><div><dt class="eyebrow"><?php esc_html_e( 'Deliverables', 'creadigol' ); ?></dt><dd><?php echo esc_html( get_the_excerpt() ); ?></dd></div><?php endif; ?>
	</dl>

	<div class="section case__body entry-content">
		<?php the_content(); ?>
	</div>

	<?php if ( $quote ) : ?>
		<section class="section case__quote">
			<?php creadigol_eyebrow( __( 'Outcome', 'creadigol' ) ); ?>
			<blockquote>
				<p class="display case__quote-text">“<?php echo esc_html( $quote ); ?>”</p>
				<?php if ( creadigol_work_meta( 'quote_by' ) ) : ?><cite class="eyebrow"><?php echo esc_html( creadigol_work_meta( 'quote_by' ) ); ?></cite><?php endif; ?>
			</blockquote>
		</section>
	<?php endif; ?>

	<?php if ( $creds ) : ?>
		<section class="section case__credits">
			<?php creadigol_eyebrow( __( 'Credits', 'creadigol' ) ); ?>
			<dl class="credits">
				<?php foreach ( $creds as [ $role, $name ] ) : ?>
					<div><dt class="eyebrow"><?php echo esc_html( $role ); ?></dt><dd><?php echo esc_html( $name ); ?></dd></div>
				<?php endforeach; ?>
			</dl>
		</section>
	<?php endif; ?>

	<?php if ( $next ) : ?>
		<section class="section case__next">
			<?php creadigol_eyebrow( __( 'Next project', 'creadigol' ) ); ?>
			<a class="next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
				<div class="next__text">
					<span class="eyebrow"><?php echo esc_html( creadigol_work_meta( 'client', $next->ID ) ); ?></span>
					<span class="display next__title"><?php echo esc_html( creadigol_work_title( $next->ID ) ); ?></span>
					<span class="next__arrow" aria-hidden="true">→</span>
				</div>
				<?php creadigol_loop( creadigol_work_meta( 'tile_video', $next->ID ), get_post_thumbnail_id( $next->ID ), 'creadigol-wide', creadigol_work_title( $next->ID ), 'next__media' ); ?>
			</a>
		</section>
	<?php endif; ?>
</article>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php get_footer(); ?>
