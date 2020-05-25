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

            echo '</p></div>';

        }
        wp_reset_postdata();
    }

?>