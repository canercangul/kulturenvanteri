<?php
/**
 * info window 
 * 
 * @package GeoMashup
 */

// A potentially heavy-handed way to remove shortcode-like content
add_filter( 'the_excerpt', array( 'GeoMashupQuery', 'strip_brackets' ) );

?>
<div class="locationinfo post-location-info">
<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<div class="popup-content">
			<h2><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<p class="meta"><?php the_field('geo_address'); ?></p></br>
			<p class="meta"><?php echo get_the_term_list( $post->ID, 'place_type', '', ', ' ); ?></p>
			<?php if ($wp_query->post_count == 1) : ?>
		    <?php endif; ?>
        </div>

	<?php endwhile; ?>
	
<?php else : ?>

<p class="center">Nothing Found</p>

<?php endif; ?>

</div>
