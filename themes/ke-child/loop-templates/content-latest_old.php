<?php
/**
 * Latest images
 * 
 * 
 * @package understrap
 */

?>

<div class="row">
    <div class="col-12 pt-3 pb-3 latest-images bg-dark">
        <div class="entry-content" id="ms-container">
            <?php
            $args = array( 'post_type' => 'attachment', 'posts_per_page'   => 18, 'post_mime_type' => 'image' ); 
            $attachments = get_posts( $args );
            if ( $attachments ) {
                foreach ( $attachments as $post ) {
                    setup_postdata( $post );
                    $thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', true );
                    $imageThumb = wp_get_attachment_image_src( $post->ID, 'medium' );
                    $imageCap = wp_get_attachment_caption( $post->ID );
                    
                    echo '<div class="ms-item nopadding col-3 col-lg-1 col-md-3 col-sm-3 col-xs-3">';
                    
                    echo '<a title="'; echo $imageCap; echo '" href="'; echo $thumbnail_url[0]; echo '"> '; 
                    echo '<img src="'; echo $imageThumb[0]; echo '" loading="lazy" /> '; 
                    echo '</a>';
                    
                    echo '</div>';
                }
                wp_reset_postdata();
            }
            ?>

        </div>
    </div>
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