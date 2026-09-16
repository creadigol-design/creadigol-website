<?php
/**
 * Fallback template (archives, search).
 *
 * @package Creadigol
 */

get_header();
?>
<section class="section page-head">
	<h1 class="display display--page"><?php echo is_search() ? esc_html__( 'Search', 'creadigol' ) : wp_kses_post( get_the_archive_title() ); ?></h1>
</section>
<section class="section">
	<?php if ( have_posts() ) : ?>
		<ul class="rows">
			<?php while ( have_posts() ) : the_post(); ?>
				<li><a class="row" href="<?php the_permalink(); ?>"><span class="eyebrow row__date"><?php echo esc_html( get_the_date( 'M Y' ) ); ?></span><span class="row__title"><?php the_title(); ?></span><span class="row__arrow" aria-hidden="true">→</span></a></li>
			<?php endwhile; ?>
		</ul>
		<?php the_posts_pagination( array( 'class' => 'pagination', 'prev_text' => '←', 'next_text' => '→' ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing found.', 'creadigol' ); ?></p>
	<?php endif; ?>
</section>
<?php get_footer(); ?>
