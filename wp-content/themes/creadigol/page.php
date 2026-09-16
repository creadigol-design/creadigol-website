<?php
/**
 * Default page: Druk title, block content. The Studio page uses this template.
 *
 * @package Creadigol
 */

get_header();
the_post();
?>
<article class="page">
	<header class="section page-head">
		<?php if ( has_excerpt() ) : ?><p class="eyebrow"><?php echo esc_html( get_the_excerpt() ); ?></p><?php endif; ?>
		<h1 class="display display--page"><?php the_title(); ?></h1>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="film"><?php the_post_thumbnail( 'creadigol-wide', array( 'class' => 'film__media' ) ); ?></div>
	<?php endif; ?>
	<div class="section entry-content entry-content--page">
		<?php the_content(); ?>
	</div>
</article>
<?php get_template_part( 'template-parts/cta' ); ?>
<?php get_footer(); ?>
