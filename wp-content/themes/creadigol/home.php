<?php
/**
 * Journal index (the posts page).
 *
 * @package Creadigol
 */

get_header();
?>
<section class="section page-head">
	<?php creadigol_eyebrow( __( 'Journal', 'creadigol' ) ); ?>
	<h1 class="display display--page"><?php echo esc_html( single_post_title( '', false ) ?: __( 'Journal', 'creadigol' ) ); ?></h1>
</section>
<section class="section">
	<?php if ( have_posts() ) : ?>
		<ul class="rows rows--journal">
			<?php while ( have_posts() ) : the_post(); ?>
				<li><a class="row" href="<?php the_permalink(); ?>"><span class="eyebrow row__date"><?php echo esc_html( get_the_date( 'M Y' ) ); ?></span><span class="row__title"><?php the_title(); ?><span class="row__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></span></span><span class="row__arrow" aria-hidden="true">→</span></a></li>
			<?php endwhile; ?>
		</ul>
		<?php the_posts_pagination( array( 'class' => 'pagination', 'prev_text' => '←', 'next_text' => '→' ) ); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing here yet.', 'creadigol' ); ?></p>
	<?php endif; ?>
</section>
<?php get_template_part( 'template-parts/cta' ); ?>
<?php get_footer(); ?>
