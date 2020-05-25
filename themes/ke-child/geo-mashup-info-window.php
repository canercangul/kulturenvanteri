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
				<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
				<!-- <?php the_field('geo_address'); ?> -->
				<?php echo get_the_term_list( $post->ID, 'place_type', '', ', ' ); ?>
				<br>
				<?php						
					// https://developer.wordpress.org/reference/functions/wp_list_categories/#Display_Terms_in_a_custom_taxonomy						
					$taxonomy = 'place_location';
					// Get the term IDs assigned to post.
					$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
					// Separator between links.
					$separator = ', ';
					if ( ! empty( $post_terms ) && ! is_wp_error( $post_terms ) ) {
						$term_ids = implode( ',' , $post_terms );
						$terms = wp_list_categories( array(
							'title_li' => '',
							'style'    => 'none',
							'echo'     => false,
							'taxonomy' => $taxonomy,
							'include'  => $term_ids
						) );
						$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
						// Display post categories.
						echo  $terms;
					}
				?>
				<hr>	
				<!-- See more: //https://gearside.com/easily-link-to-locations-and-directions-using-the-new-google-maps/ -->
				<?php if (function_exists('geo_mashup_map')) 
				$coords = GeoMashup::post_coordinates(); 
				if ($coords) { echo '<div><a href="http://maps.google.com/maps/dir/?api=1&destination=' . $coords['lat'] . ',' . $coords['lng'] . '" target="_blank">Yol tarifi al ⤷</a>' . '</div>'; } ?>
				<div class="fixed-bottom-left"><?php edit_post_link(__('Düzenle'), ''); ?></div>
			</div>

		<?php if ($wp_query->post_count == 1) : ?>
		<?php endif; ?>
		<?php endwhile; ?>
		
	<?php else : ?>
	<p class="center">İçerik yok</p>
	<?php endif; ?>

</div>
