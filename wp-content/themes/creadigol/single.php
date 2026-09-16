<?php
/**
 * Journal post.
 *
 * @package Creadigol
 */

get_header();
the_post();
?>
<article class="post">
	<header class="section page-head page-head--narrow">
		<p class="eyebrow"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></p>
		<h1 class="display display--post"><?php the_title(); ?></h1>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="film"><?php the_post_thumbnail( 'creadigol-wide', array( 'class' => 'film__media' ) ); ?></div>
	<?php endif; ?>
	<div class="section entry-content entry-content--narrow"><?php the_content(); ?></div>
	<nav class="section post-nav" aria-label="<?php esc_attr_e( 'Posts', 'creadigol' ); ?>">
		<?php previous_post_link( '%link', '← %title' ); ?>
		<?php next_post_link( '%link', '%title →' ); ?>
	</nav>
</article>
<?php get_template_part( 'template-parts/cta' ); ?>
<?php get_footer(); ?>
