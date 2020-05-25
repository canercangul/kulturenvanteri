<?php
/**
 * Single post partial script template.
 *
 * @package understrap
 */

?>

<!-- Selections -->

<div class="col-6 pl-3 mt-6 text-light small fixed-top">

    <?php echo facetwp_display( 'selections' ); ?>
   
    <!-- <?php // Get total number of posts in post-type-name
	$count_posts = wp_count_posts('place');
	$total_posts = $count_posts->publish;
	echo 'Veritabanımızda toplam ' . $total_posts . ' adet nokta bulunuyor.';
    ?> -->

</div>

<!-- Buttons -->
<div class="mt-6 mr-3 fixed-right">
    <button type="button" class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#button_filter">Ara</button>
    <button type="button" class="btn btn-sm btn-circle btn-primary btn-visiblelist" data-toggle="modal" data-target="#button_visiblelist">Liste</button>
</div>

<!-- Modal Search -->
<div class="modal fade" id="button_filter" tabindex="-1" role="dialog" aria-labelledby="button_filterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal List -->
<div class="modal fade" id="button_visiblelist" tabindex="-1" role="dialog" aria-labelledby="button_visiblelistTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo GeoMashup::visible_posts_list() ?>
            </div>
        </div>
    </div>
</div> 

<!-- Map -->
<div class="row no-gutters">

    <div id ="map" class="col-12 scroll-area map-default">
        <?php echo facetwp_display( 'template', 'main' ); ?>
    </div>
    
</div>

<!--  - bir sorgu yok ise haritayı gösterme. - arama sonuçları sıfır ise haritayı gösterme - Sayfa açıldığında modal filter'ı aç -->
<script>

    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (FWP.build_query_string()) {
                $('.facetwp-template').show();
                $('.btn-visiblelist').show();
                $('.facetwp-counts').show();
                $('.facetwp-pager').show();
            }
            else {
                $('.facetwp-template').hide();
                $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
            }
         });
    })(jQuery);

    (function($) {
        $(document).on('facetwp-loaded', function() {
            if (0 === FWP.settings.pager.total_rows ) {
                $('.facetwp-template').hide();
                $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
            }
            });
    })(jQuery);

    (function($) {
        $(window).on('load',function(){
            $('#button_filter').modal('show'); // Auto open modal 
            // $( '.locate-me' ).trigger( 'click' ); // Auto locate me
        });
    })(jQuery);
    
</script>