<?php
/**
 * This is the default template for full post display of a clicked marker
 * in a Geo Mashup map. 
 *
 * @package GeoMashup
 */
?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
							
			<div class="scroll-area-test border-left border-dark p-3">

				<div class="mb-3">
					<a title="Kapat" onclick="frames['gm-map-1'].GeoMashup.deselectMarker()">✕</a>
				</div>

				<div class="mb-3">
					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
						<?php 
						$value = get_field( "place_also_known_as" );
						if( $value ) {
							echo '<p class="small">';
							echo $value;
							echo ' olarak da bilinir.</p>';
						} else {
							echo '';
						}
 						?>
					<ul class="pt-3 pb-3 list-unstyled small">

						<li><?php echo get_the_term_list( $post->ID, 'place_group', '<b>Grup:</b> ', ', ' ); ?></li>
						<li><?php echo get_the_term_list( $post->ID, 'place_type', '<b>Tür:</b> ', ', ' ); ?></li>
						<li><?php echo get_the_term_list( $post->ID, 'place_sub_type', '<b>Tema:</b> ', ', ' ); ?></li>
						<li><?php echo get_the_term_list( $post->ID, 'place_culture', '<b>Kültür:</b> ', ', ' ); ?></li>
						<li><?php echo get_the_term_list( $post->ID, 'place_century', '<b>Yüzyıl:</b> ', ', ' ); ?></li>
						<li>
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
									echo '<b>Konum:</b> ';
									echo  $terms;
								}
							?>
						</li>

						<!-- <li><b>Koordinat:</b> <?php if (function_exists('geo_mashup_map')) $coords = GeoMashup::post_coordinates(); if ($coords) { echo $coords['lat'] . ',' . $coords['lng']; } ?></small></li> -->
						<!-- See more: //https://gearside.com/easily-link-to-locations-and-directions-using-the-new-google-maps/ -->
					 	<?php if (function_exists('geo_mashup_map')) 
						$coords = GeoMashup::post_coordinates(); 
						if ($coords) { echo '<span class="googlemap"><a href="https://maps.google.com/maps/dir/?api=1&destination=' . $coords['lat'] . ',' . $coords['lng'] . '" target="_blank">Yol tarifi al ⤷</a>' . '</span>'; } 
						?>

					</ul>
				</div>
		
				<?php

					//$value = get_the_title();
					$value = get_field( "place_wikipedia" );

					if( $value ) {

					/*
						MediaWiki API
						https://www.mediawiki.org/wiki/API:Parsing_wikitext#Sample_code_2
					*/

					$endPoint = "https://tr.wikipedia.org/w/api.php";
					$params = [
						"action" => "parse",
						"page" => $value,
						"prop" => "text",
						"section" => "0",
						"redirects" => "yes",
						"disabletoc" => "yes",
						"disableeditsection" => "yes",
						"format" => "json"
					];

					$url = $endPoint . "?" . http_build_query( $params );

					$ch = curl_init( $url );
					curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
					$output = curl_exec( $ch );
					curl_close( $ch );

					$result = json_decode( $output, true );

					echo '<div class="pb-3 pt-3 mb-3 mt-3 border-bottom border-top">';

					// echo( $result["parse"]["text"]["*"] );
					// function.php bul ve değiştir

					print_processed_html($result["parse"]["text"]["*"]);

					echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
					echo $value;
					echo '">Vikipedi sayfasından oku</a> - ';

					echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
					echo $value;
					echo '#/editor/0">Düzenle</a>';

					echo '</div>';

					} else {
						echo '';
						//echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
						//echo the_title();
						//echo '">Vikipedi</a></p>';
					}

				?>

				<?php the_content(); ?>

				<?php $place_gallery_images = get_field( 'place_gallery' ); ?>
				
				<?php if ( $place_gallery_images ) :  ?>
					<div class="masonry-cols gallery pt-3 mb-3 mt-3">
						<?php foreach ( $place_gallery_images as $place_gallery_image ): ?>
								<figure class="figure item">
									<!-- <a href="<?php echo $place_gallery_image['url']; ?>" title="<?php echo $place_gallery_image['caption']; ?> <?php the_field( 'place_media_creator', $place_gallery_image['ID'] ); ?> <?php the_field( 'place_media_date', $place_gallery_image['ID'] ); ?>">
										<img class="figure-img img-fluid" src="<?php echo $place_gallery_image['sizes']['large']; ?>" alt="<?php echo $place_gallery_image['alt']; ?>" />
									</a> -->
								    <img class="figure-img img-fluid" src="<?php echo $place_gallery_image['sizes']['large']; ?>" alt="<?php echo $place_gallery_image['alt']; ?>" />
									<figcaption class="figure-caption"><?php echo $place_gallery_image['caption']; ?> <?php the_field( 'place_media_creator', $place_gallery_image['ID'] ); ?> <?php the_field( 'place_media_date', $place_gallery_image['ID'] ); ?></figcaption>
								</figure>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php $place_related = get_field( 'place_related' ); ?>
				<?php if ( $place_related ): ?>

					<div class="pb-3 pt-3 mb-3 mt-3">
						<p>İlgili Yerler</p>

						<ul class="list-unstyled">
							<?php foreach ( $place_related as $post ):  ?>
								<?php setup_postdata ( $post ); ?>
								<li>
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</li>
							<?php endforeach; ?>
						</ul>

					</div>

				<?php wp_reset_postdata(); ?>
				<?php endif; ?>

				<!-- <div class="pb-3 pt-3 mb-3 mt-3 border-bottom border-top">
					<?php //echo GeoMashup::nearby_list("limit=10"); ?>
				</div> -->

				<div class="entry-meta pb-3 mb-3 small">
					<b>Editör </b><?php the_author_posts_link(); ?>
					<br>
					<b>Son güncelleme </b><?php the_modified_author();?> - <?php the_modified_time( 'j F Y' ); ?>
					<br>
					<b><?php edit_post_link( __('Düzenle'), '', '', 0, 'iframe-popup' ); ?></b>   
				</div>

			</div>
			
	<?php endwhile; ?>

<?php else : ?>

	<h2 class="center">Not Found</h2>

<?php endif; ?>
