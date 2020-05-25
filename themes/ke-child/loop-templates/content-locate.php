<?php
/**
 * Etrafımdakiler
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
<!-- <div class="mt-6 mr-3 fixed-right">
    <button class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#button_filter">Ara</button>
    <button class="btn btn-sm btn-circle btn-primary btn-visiblelist" data-toggle="modal" data-target="#button_visiblelist">Liste</button>
</div> -->

<!-- Modal Search -->
<div class="modal" id="button_filter" tabindex="-1" role="dialog" aria-labelledby="button_filterTitle" aria-hidden="true">
    <div class="modal-dialog modal-filter" role="document">
        <div class="modal-content">

            <div class="modal-body">

                <?php echo facetwp_display( 'facet', 'ara' ); ?>

                <?php echo facetwp_display( 'facet', 'pagination' ); ?>

                <div class="accordion" id="accordionFilter">

                    <div class="card">
                        <a class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Etrafta
                        </a>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'locate' ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <a class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree">
                            Tür
                        </a>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'tur' ); ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal List -->
<div class="modal" id="button_visiblelist" tabindex="-1" role="dialog" aria-labelledby="button_visiblelistTitle" aria-hidden="true">
    <div class="modal-dialog modal-list" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo GeoMashup::visible_posts_list() ?>
            </div>
        </div>
    </div>
</div>

<!-- Map -->
<div class="container-fluid" id="content" tabindex="-1">
    <div class="row">
        <div id="map" class="col-12 nopadding map-default">
            <?php echo facetwp_display( 'template', 'main' ); ?>
        </div>
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
                $('#button_filter').modal('show'); // Auto open modal
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
                $('#button_filter').modal('show'); // Auto open modal 
            }
            });
    })(jQuery);

    (function($) {
        $(window).on('load',function(){
            //$('#button_filter').modal('show'); // Auto open modal 
            $( '.locate-me' ).trigger( 'click' ); // Auto locate me
        });
    })(jQuery);
    
</script>