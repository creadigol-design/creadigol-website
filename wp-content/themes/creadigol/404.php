<?php
/**
 * Not found.
 *
 * @package Creadigol
 */

get_header();
?>
<section class="section page-head">
	<?php creadigol_eyebrow( __( 'Not found', 'creadigol' ) ); ?>
	<h1 class="display display--page"><?php esc_html_e( 'That page has moved on.', 'creadigol' ); ?></h1>
	<p class="page-head__intro"><a class="arrow-link" href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>"><?php esc_html_e( 'See the work', 'creadigol' ); ?> <span aria-hidden="true">→</span></a></p>
</section>
<?php get_footer(); ?>
