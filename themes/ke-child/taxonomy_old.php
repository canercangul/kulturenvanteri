<?php get_header(); ?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
?>

<?php echo GeoMashup::map('add_map_type_control=true'); ?>

<div class="wrapper" id="archive-wrapper">
	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
        <div class="row">
            <div class="col-12">
                <header class="page-header">
                    <?php
                    
                    the_archive_title( '<h2 class="page-title">', '</h2>' );

                    // case type image
                    // echo '<div class="row">';
                    // echo '<div class="col-6"><a href="' . $actor_web . '" target="_blank">' . '<img src="' . $actor_image['sizes']['thumbnail'] . '" class="rounded-circle" alt="' . $actor_image['alt'] .'"></a></div>';
                    the_archive_description( '<div class="col-6">', '</div>' );
                    // echo '</div>';

					?>
					<p><?php global $wp_query; echo $wp_query->post_count; ?> adet sonuç görüntüleniyor</p>
                </header>
            </div>  
        </div>  	
	</div><!-- Container end -->
</div><!-- Wrapper end -->

<?php get_footer(); ?>
