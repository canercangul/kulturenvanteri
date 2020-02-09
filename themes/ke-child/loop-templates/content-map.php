<?php
/**
 * Single post partial script template.
 *
 * @package understrap
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

			<div class="row no-gutters">

				<div class="col-lg-3 col-12 p-3 pt-5">
				<?php the_content(); ?>
                </div>

                <div class="col-lg-9 col-12 fixed-map nopadding">
                <?php echo facetwp_display( 'template', 'main' ); ?>
                </div>
                
                <div class="col-lg-9 col-12 p-3 pt-5 fixed-mapglobal nopadding h-100 d-inline-block mapglobal">
                    <p class="text-left text-light" style="margin-left: 20px; margin-top:20px">Soldaki menüden harita üzerinde görüntülemek istediğiniz terimleri seçin.</p>
                </div>
                
            </div>
            
            <footer class="entry-footer">

<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->

<script>
    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (FWP.build_query_string()) {
                $('.facetwp-template').addClass('visible');
                $('.mapglobal').removeClass('visible');
            }
            else {
                $('.facetwp-template').removeClass('visible');
                $('.mapglobal').addClass('visible');
             }
         });
    })(jQuery);
</script>