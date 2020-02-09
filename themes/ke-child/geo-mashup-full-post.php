<?php
/**
 * This is the default template for full post display of a clicked marker
 * in a Geo Mashup map. 
 *
 * Don't modify this file! It will be overwritten by upgrades.
 *
 * Instead, copy this file to "full-post.php" in your geo-mashup-custom directory,
 * or "geo-mashup-full-post.php" in your theme directory. Those files will
 * take precedence over this one.
 *
 * @package GeoMashup
 */
?>
<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
							
			<div class="row no-gutters">
			
            	<div class="col-lg-10 col-md-12 col-sm-12 col-12">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<h4><?php the_field('language'); ?></h4>
							<small><?php echo strip_tags(get_the_term_list( $post->ID, 'script_found', ' ',', ')); ?></small>
							<ul class="list-unstyled">	
								<li><small><?php echo get_the_term_list( $post->ID, 'script_type', '<b>Yazı Sistemi:</b> ', ', ' ); ?></small></li>
								<li><small><?php echo get_the_term_list( $post->ID, 'script_century', '<b>Tarihlendirme:</b> ', ', ' ); ?></small></li>
								<li><small><?php echo get_the_term_list( $post->ID, 'script_current', '<b>Sergilendiği yer:</b> ', ', ' ); ?></small></li>
							</ul>
							</br>
			    </div>

				<div class="col-lg-2 col-md-12 col-sm-12 col-12">
				                <?php if (has_post_thumbnail()) : ?>
											<?php if ( has_post_thumbnail() ) : ?>
													<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
													    <?php the_post_thumbnail( 'medium' ); ?>
													</a>
											<?php endif; ?>
								<?php else : ?>
								<?php endif; ?>
				</div>
				
			</div>
			</br>
			
	<?php endwhile; ?>

<?php else : ?>

	<h2 class="center">Not Found</h2>
	<p class="center">Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>
