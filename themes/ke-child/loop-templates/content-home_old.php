<?php
/**
 * Home / Anasayfa
 *
 * @package understrap
 */

?>
	
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<div class="container-fluid">

		<div class="row d-flex" style="min-height:calc(100vh - 56px);">

			<div class="col-12 col-md-6 pt-3 pb-3 entry-content flex-fill" id="modal-ready">
					<?php the_content(); ?>
					<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
			
			<!-- Random Image -->
		
			<?php
				$args = array( 'post_type' => 'attachment', 'posts_per_page'   => 1, 'post_mime_type' => 'image', 'orderby' => 'rand' ); 
				
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'place_media_tag',
						'terms' => array( 'featured' ),
						'field' => 'slug',
					),
				);

				$attachments = get_posts( $args );
				if ( $attachments ) {
					foreach ( $attachments as $post ) {
						setup_postdata( $post );

						$imageThumb = wp_get_attachment_image_src( $post->ID, 'full' );
						$imageCap = wp_get_attachment_caption( $post->ID );

						echo '<div class="flex-fill d-none d-md-block border-left col-12 col-md-6 nopadding bg-dark" style="background-size:cover;background-image:url('; 
						echo $imageThumb[0]; 
						echo ');"/> ';
						echo '<p class="p-3 text-light small">';
						echo $imageCap;

						$imageCreator = get_field( "place_media_creator" );
							if( $imageCreator ) {
								echo '<i> ';
								echo the_field( 'place_media_creator', $place_gallery_image['ID'] );
								echo ' </i>';
							} else {
								echo '';
							}
						
						$imageDate = get_field( "place_media_date" );
							if( $imageDate ) {
								echo ' - ';
								echo the_field( 'place_media_date', $place_gallery_image['ID'] );
							} else {
								echo '';
							}

						echo '</p>';
						echo '</div>';

					}
					wp_reset_postdata();
				}

			?>

		</div>

		<div class="row">

			<div class="col-12 col-md-6 pt-2 bg-dark latest-images">
				<div class="gallery entry-content" id="ms-container">
					<?php
						$args = array( 'post_type' => 'attachment', 'posts_per_page'   => 25, 'post_mime_type' => 'image' ); 
						$attachments = get_posts( $args );
						if ( $attachments ) {
							foreach ( $attachments as $post ) {
								setup_postdata( $post );
								$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
								$imageThumb = wp_get_attachment_image_src( $post->ID, 'medium' );
								$imageCap = wp_get_attachment_caption( $post->ID );
								
								echo '<div class="ms-item nopadding col-3 col-lg-2 col-md-3 col-sm-3 col-xs-3"><a title="';
								echo $imageCap; 
								echo '" href="'; 
								echo $thumbnail_url[0]; 
								echo '"><img src="'; 
								echo $imageThumb[0]; 
								echo '"/></a></div>'; 					
							}
							wp_reset_postdata();
						}
					?>
				</div>
			</div>

			<div class="col-12 col-md-6 pt-3 pb-3">
				<ul class="list-group list-group-flush">
					<?php
					// Show recently modified posts
					$recently_updated_posts = new WP_Query( array(
						'post_type'      => 'place',
						'posts_per_page' => 12,
						'orderby'        => 'modified',
						'no_found_rows'  => true, // speed up query when we don't need pagination
					) );
					if ( $recently_updated_posts->have_posts() ) :
						while( $recently_updated_posts->have_posts() ) : $recently_updated_posts->the_post(); ?>
							<li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-transparent"><a href="<?php the_permalink(); ?>" title="<?php esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a><small class="text-muted"><?php the_modified_date(); ?> - <?php //the_modified_author(); ?></small></li>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</ul>
			</div>

		</div>

	</div>

</article><!-- #post-## -->

<script type="text/javascript">
	jQuery(window).load(function () {
		var container = document.querySelector('#ms-container');
		var msnry = new Masonry(container, {
			itemSelector: '.ms-item',
			columnWidth: '.ms-item',
		});
	});
</script>