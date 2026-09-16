<?php
/**
 * Work index: heading, discipline filters, 3-column grid of 4:5 tiles.
 * Also used for discipline archives via taxonomy-discipline.php.
 *
 * @package Creadigol
 */

get_header();

$current = is_tax( 'discipline' ) ? get_queried_object() : null;
$terms   = get_terms( array( 'taxonomy' => 'discipline', 'hide_empty' => true ) );
$count   = (int) $wp_query->found_posts;
?>
<section class="section page-head">
	<?php creadigol_eyebrow( __( 'Work', 'creadigol' ) ); ?>
	<div class="page-head__row">
		<h1 class="display display--page"><?php echo $current ? esc_html( $current->name ) : esc_html__( 'Work', 'creadigol' ); ?></h1>
		<p class="page-head__intro">
			<?php
			/* translators: %d: number of projects */
			printf( esc_html( _n( '%d project across broadcast, sport, culture and the public sector. Built to move.', '%d projects across broadcast, sport, culture and the public sector. Every one built to move.', $count, 'creadigol' ) ), $count );
			?>
		</p>
	</div>
	<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
		<div class="filters" role="group" aria-label="<?php esc_attr_e( 'Filter by discipline', 'creadigol' ); ?>">
			<a class="chip <?php echo $current ? '' : 'is-active'; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>" data-filter="*"><?php esc_html_e( 'All', 'creadigol' ); ?></a>
			<?php foreach ( $terms as $term ) : ?>
				<a class="chip <?php echo $current && $current->term_id === $term->term_id ? 'is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>" data-filter="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>

<section class="section work-grid" data-work-grid>
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			$slugs = wp_get_post_terms( get_the_ID(), 'discipline', array( 'fields' => 'slugs' ) );
			?>
			<div class="work-grid__item" data-disciplines="<?php echo esc_attr( implode( ' ', is_wp_error( $slugs ) ? array() : $slugs ) ); ?>">
				<?php creadigol_tile( get_the_ID(), 'tall' ); ?>
				<?php if ( creadigol_work_meta( 'year' ) ) : ?>
					<span class="eyebrow work-grid__year"><?php echo esc_html( creadigol_work_meta( 'year' ) ); ?></span>
				<?php endif; ?>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'No case studies yet.', 'creadigol' ); ?></p>
	<?php endif; ?>
</section>

<?php get_template_part( 'template-parts/cta' ); ?>
<?php get_footer(); ?>
