<div class="gallery entry-content skip-lazy" id="ms-container">
    <?php
        $args = array( 'post_type' => 'attachment', 'posts_per_page'   => 24, 'post_mime_type' => 'image' ); 
        $attachments = get_posts( $args );
        if ( $attachments ) {
            foreach ( $attachments as $post ) {
                setup_postdata( $post );

                $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
                $imageThumb = wp_get_attachment_image_src( $post->ID, 'medium' );
                $imageCap = wp_get_attachment_caption( $post->ID );
                $imageCreator = get_post_meta( $post->ID, 'place_media_creator', true );
                $imageDate = get_post_meta( $post->ID, 'place_media_date', true );

                // https://wordpress.stackexchange.com/questions/44067/find-the-post-an-attachment-is-attached-to
                // Ana sayfada imajların eklendiği yere link ver.
                // Get the parent post ID
                $parent_id = $post->post_parent;
                // Get the parent post Title
                $parent_title = get_the_title( $parent_id );
                // Get the parent post permalink
                $parent_permalink = get_permalink( $parent_id );
                
                echo '<div class="ms-item nopadding col-2 "><a title="';
                echo $imageCap;
                echo ' ';
                echo $imageCreator;
                echo ' '; 
                echo $imageDate;  
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

<script type="text/javascript">
    jQuery(window).load(function () {
        var container = document.querySelector('#ms-container');
        var msnry = new Masonry(container, {
            itemSelector: '.ms-item',
            columnWidth: '.ms-item',
        });
    });
</script>