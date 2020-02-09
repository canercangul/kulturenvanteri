<?php
/**
 * Single post partial script template.
 *
 * @package understrap
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<div class="row">

			<div class="col-lg-6 col-md-6 col-sm-12 col-12">

				<div class="pb-3 mb-3 border-bottom">
					<h3 class="pt-5"><?php the_title(); ?></h3>
					<ul class="list-unstyled">
					<li><small><?php echo get_the_term_list( $post->ID, 'place_group', '<b>Grup:</b> ', ', ' ); ?></small></li>
					<li><small><?php echo get_the_term_list( $post->ID, 'place_type', '<b>Tür:</b> ', ', ' ); ?></small></li>
					<li><small><?php echo get_the_term_list( $post->ID, 'place_sub_type', '<b>Alt Tür:</b> ', ', ' ); ?></small></li>
					<li><small><?php echo get_the_term_list( $post->ID, 'place_culture', '<b>Kültür:</b> ', ', ' ); ?></small></li>
					<li><small><?php echo get_the_term_list( $post->ID, 'place_city', '<b>Bulunduğu İl:</b> ', ', ' ); ?></small></li>
					<li><small><b>Koordinat:</b> <?php if (function_exists('geo_mashup_map')) $coords = GeoMashup::post_coordinates(); if ($coords) { echo $coords['lat'] . ',' . $coords['lng']; } ?></small></li>
					</ul>
				</div>

				<div class="pb-3 mb-3 border-bottom">
					<?php the_content(); ?>
				</div>

				<?php $posts = get_field('related_places'); if( $posts ): ?>
				<div class="pb-3 mb-3 border-bottom">
					<p>İlgili Eserler</p>
					<ul class="list-unstyled">
						<?php foreach( $posts as $post): ?>
						<?php setup_postdata($post); ?>
						<li>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php wp_reset_postdata(); ?>
				<?php endif; ?>

				<div class="pb-3 mb-3 border-bottom">
					<?php echo GeoMashup::nearby_list("limit=10"); ?>
				</div>

				<div class="entry-meta pb-3 mb-3">
					<small><b>Editör </b><?php the_author_posts_link(); ?><b> Son güncelleme </b><?php the_modified_time( 'j F Y' ); ?><b><?php edit_post_link(__(' — Düzenle'), ''); ?></b></small>    
				</div>

			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-12 fixed-map nopadding">
				<?php echo GeoMashup::map('map_content=single');?>
			</div>

		</div>
</article><!-- #post-## -->