<?php
/**
 * Single post partial script template.
 *
 * @package understrap
 */

?>

<div class="row no-gutters">

    <div class="col-lg-3 col-md-3 col-sm-6 col-12 p-3 pt-6 scroll-area">
        <?php the_content(); ?>
    </div>

    <div class="col-lg-3 col-md-3 col-6 p-2 pt-6 d-none d-sm-block scroll-area bg-primary">
        <?php echo GeoMashup::visible_posts_list() ?>
    </div>

    <div class="col-lg-6 col-md-6 col-12 scroll-area map-default">
        <?php echo facetwp_display( 'template', 'main' ); ?>
        <!-- <p class="text-left text-light pl-3 pt-6">Harita üzerinde görüntülemek istediğiniz terimleri seçin.</p> -->
    </div>
    
</div>

<!--  - bir sorgu yok ise haritayı gösterme. - arama sonuçları sıfır ise haritayı gösterme -->
<script>

    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (FWP.build_query_string()) {
                $('.facetwp-template').show();
            }
            else {
                $('.facetwp-template').hide();
            }
         });
    })(jQuery);

    (function($) {
    $(document).on('facetwp-loaded', function() {
        if (0 === FWP.settings.pager.total_rows ) {
            $('.facetwp-template').hide();
        }
        });
    })(jQuery);

</script>