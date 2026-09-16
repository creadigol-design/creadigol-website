<?php
/**
 * Home: reel behind a bilingual headline, client strip, six featured projects,
 * statement, services, journal, call to action.
 *
 * @package Creadigol
 */

get_header();

$loop   = creadigol_get( 'showreel_loop' );
$poster = creadigol_get( 'showreel_poster' );
$full   = creadigol_get( 'showreel_full' );
?>
<section class="hero">
	<?php if ( $loop ) : ?>
		<video class="hero__video loop" muted playsinline loop autoplay preload="metadata" <?php echo $poster ? 'poster="' . esc_url( $poster ) . '"' : ''; ?> data-src="<?php echo esc_url( $loop ); ?>" data-autoplay></video>
	<?php elseif ( $poster ) : ?>
		<img class="hero__video" src="<?php echo esc_url( $poster ); ?>" alt="">
	<?php endif; ?>
	<p class="hero__loc eyebrow eyebrow--lime"><?php echo esc_html( creadigol_get( 'location_line' ) ); ?></p>
	<div class="hero__grid">
		<h1 class="display hero__title"><?php echo esc_html( creadigol_get( 'headline' ) ); ?></h1>
		<div class="hero__right">
			<p class="hero__intro"><?php echo esc_html( creadigol_get( 'intro' ) ); ?></p>
			<?php if ( $full ) : ?>
				<button class="play" type="button" data-showreel="<?php echo esc_url( $full ); ?>" aria-label="<?php esc_attr_e( 'Play the showreel', 'creadigol' ); ?>">
					<svg width="72" height="72" viewBox="0 0 72 72" fill="none" aria-hidden="true"><circle cx="36" cy="36" r="35" stroke="currentColor" stroke-width="1.5"/><path d="M29 24 L48 36 L29 48 Z" fill="currentColor"/></svg>
				</button>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php get_template_part( 'template-parts/client-strip' ); ?>

<?php
$featured = get_posts(
	array(
		'post_type'      => 'work',
		'posts_per_page' => 6,
		'meta_key'       => '_creadigol_featured',
		'meta_value'     => '1',
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	)
);
if ( count( $featured ) < 6 ) {
	// Top up with the most recent case studies so the grid is never half empty.
	$more     = get_posts( array( 'post_type' => 'work', 'posts_per_page' => 6, 'post__not_in' => wp_list_pluck( $featured, 'ID' ), 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ) ) );
	$featured = array_slice( array_merge( $featured, $more ), 0, 6 );
}
if ( $featured ) :
	?>
	<section class="section work-home">
		<div class="section__head">
			<h2 class="display display--section"><?php esc_html_e( 'Work', 'creadigol' ); ?></h2>
			<a class="arrow-link eyebrow" href="<?php echo esc_url( get_post_type_archive_link( 'work' ) ); ?>"><?php esc_html_e( 'All work', 'creadigol' ); ?> <span aria-hidden="true">→</span></a>
		</div>
		<div class="work-home__large">
			<?php foreach ( array_slice( $featured, 0, 2 ) as $p ) : ?>
				<?php creadigol_tile( $p->ID, 'wide' ); ?>
			<?php endforeach; ?>
		</div>
		<?php if ( count( $featured ) > 2 ) : ?>
			<div class="work-home__small">
				<?php foreach ( array_slice( $featured, 2, 4 ) as $p ) : ?>
					<?php creadigol_tile( $p->ID, 'wide' ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>

<section class="statement">
	<p class="eyebrow eyebrow--ink"><?php echo esc_html( creadigol_get( 'statement_label' ) ); ?></p>
	<p class="display statement__text"><?php echo esc_html( creadigol_get( 'statement' ) ); ?></p>
</section>

<section class="section services">
	<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
		<div class="service">
			<h3 class="display service__title"><?php echo esc_html( creadigol_get( "service_{$i}_title" ) ); ?></h3>
			<p class="service__text"><?php echo esc_html( creadigol_get( "service_{$i}_text" ) ); ?></p>
		</div>
	<?php endfor; ?>
</section>

<?php
$posts = get_posts( array( 'posts_per_page' => 3 ) );
if ( $posts ) :
	?>
	<section class="section journal-home">
		<div class="section__head">
			<?php creadigol_eyebrow( __( 'Journal', 'creadigol' ) ); ?>
			<a class="arrow-link eyebrow" href="<?php echo esc_url( home_url( '/journal/' ) ); ?>"><?php esc_html_e( 'All notes', 'creadigol' ); ?> <span aria-hidden="true">→</span></a>
		</div>
		<ul class="rows">
			<?php foreach ( $posts as $p ) : ?>
				<li><a class="row" href="<?php echo esc_url( get_permalink( $p ) ); ?>"><span class="eyebrow row__date"><?php echo esc_html( get_the_date( 'M Y', $p ) ); ?></span><span class="row__title"><?php echo esc_html( get_the_title( $p ) ); ?></span><span class="row__arrow" aria-hidden="true">→</span></a></li>
			<?php endforeach; ?>
		</ul>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/cta' ); ?>

<dialog class="reel" id="reel"><button class="reel__close" type="button" aria-label="<?php esc_attr_e( 'Close', 'creadigol' ); ?>">×</button><div class="reel__frame"></div></dialog>

<?php get_footer(); ?>
