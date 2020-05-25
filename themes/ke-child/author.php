<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="wrapper" id="author-wrapper">
	<div class="container-fluid" id="content" tabindex="-1">
		<div class="row" id="modal-ready">
			
			<div class="col-12 col-lg-6 col-md-6 pt-5 pb-4 d-none d-md-block scroll-area text-dark">		
				<main class="site-main" id="main">
				
					<?php $curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );?>
					
					<div class="mb-5"> 

						<h4><?php echo esc_html( $curauth->display_name ); ?></h4>
						<h5><?php echo esc_html( $curauth->user_url ); ?></h5>
					
					</div>

					<div class="mb-3 mt-3"> 
						<?php understrap_pagination(); ?>
					</div>

					<div class="mb-3 mt-3 pb-3 border-bottom border-dark small"> 
						<span><?php global $wp_query; echo $wp_query->found_posts; ?> sonuç arasından <?php global $wp_query; echo $wp_query->post_count; ?> nokta görüntüleniyor.</span>
					</div>

					<ul class="list-unstyled mb-3">
						<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							<li>
								<a href="#gm-map-1" onclick="window.frames['gm-map-1'].GeoMashup.clickMarker('<?php the_ID(); ?>');" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								<small>

									<?php 
									$terms_as_text = get_the_term_list( $post->ID,'place_type', '—', ', '); 
									if (!empty($terms_as_text)) echo '', strip_tags($terms_as_text) ,''; 
									?>

									<?php 
									$terms_as_text = get_the_term_list( $post->ID,'place_culture', '—', ', '); 
									if (!empty($terms_as_text)) echo '', strip_tags($terms_as_text) ,''; 
									?>

									<?php edit_post_link( __('Düzenle'), '', '', 0, 'iframe-popup font-weight-bold' ); ?>
								</small>
							</li>
						<?php endwhile; else: ?>
							<p><?php _e('    '); ?></p>
						<?php endif; ?>
					</ul>

				</main><!-- .page-main -->
			</div>

			<div class="col-12 col-lg-6 col-md-6 fixed-right map-default nopadding">
				<?php
				// This template code will work only in the WordPress Loop to include a map if the Geo Mashup plugin is active and the current post has a location.
				// https://snipplr.com/view/29558/conditional-geo-mashup-map-template-code
				$coordinates = GeoMashup::post_coordinates();
					if ( class_exists( 'GeoMashup' ) and ! empty( $coordinates ) ) {
						echo GeoMashup::map();
					}
				?>
			</div>

		</div> <!-- .row -->		
	</div><!-- Container end -->
</div><!-- Wrapper end -->

<?php get_footer(); ?>