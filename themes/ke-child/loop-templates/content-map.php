<?php
/**
 * Single post partial script template.
 *
 * @package understrap
 */

?>

<!-- Selections -->

<div class="selections-area font-weight-light d-none d-md-block col-3 mt-6 pt-3 ml-3 text-light small fixed-top border">

    <?php echo facetwp_display( 'selections' ); ?>
    <?php echo facetwp_display( 'counts' ); ?>
    <?php echo facetwp_display( 'facet', 'pagination' ); ?>

    <!-- <?php // Get total number of posts in post-type-name
	$count_posts = wp_count_posts('place');
	$total_posts = $count_posts->publish;
	echo 'Veritabanımızda toplam ' . $total_posts . ' adet nokta bulunuyor.';
    ?> -->

</div>

<!-- Buttons -->
<!-- <div class="mt-6 mr-3 fixed-right">
    <button class="btn btn-sm btn-circle btn-primary" data-toggle="modal" data-target="#button_filter">Ara</button>
    <button class="btn btn-sm btn-circle btn-primary btn-visiblelist" data-toggle="modal"
        data-target="#button_visiblelist">Liste</button>
</div> -->

<!-- Modal Search -->
<div class="modal" id="button_filter" tabindex="-1" role="dialog" aria-labelledby="button_filterTitle" aria-hidden="true">
    <div class="modal-dialog modal-filter" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <?php echo facetwp_display( 'facet', 'ara' ); ?>

                <!-- <?php echo facetwp_display( 'selections' ); ?>
                <?php echo facetwp_display( 'counts' ); ?>
                <?php echo facetwp_display( 'facet', 'pagination' ); ?> -->

                <div class="accordion" id="accordionFilter">
                    <div class="card">
                        <a class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="false" aria-controls="collapseOne">
                            Etrafta
                        </a>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'locate' ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo">
                            Grup
                        </a>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'grup' ); ?>
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
                    <div class="card">
                        <a class="card-header" id="headingFour" data-toggle="collapse" data-target="#collapseFour"
                            aria-expanded="false" aria-controls="collapseFour">
                            Kültür
                        </a>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'kultur' ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a class="card-header" id="headingFive" data-toggle="collapse" data-target="#collapseFive"
                            aria-expanded="false" aria-controls="collapseFive">
                            Yüzyıl
                        </a>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'yuzyil' ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a class="card-header" id="headingSix" data-toggle="collapse" data-target="#collapseSix"
                            aria-expanded="false" aria-controls="collapseSix">
                            Bölge
                        </a>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'konum_ara' ); ?>
                                <?php echo facetwp_display( 'facet', 'konum' ); ?>
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
    (function ($) {
        $(document).on('facetwp-loaded', function () {
            if (FWP.build_query_string()) {
                $('.selections-area').show();
                $('.facetwp-template').show();
                $('.btn-visiblelist').show();
                $('.facetwp-counts').show();
                $('.facetwp-pager').show();
            } else {
                $('.selections-area').attr('style', 'display:none !important');
                $('.facetwp-template').hide();
                $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
                $('#button_filter').modal('show');
            }
        });
    })(jQuery);

    (function ($) {
        $(document).on('facetwp-loaded', function () {
            if (0 === FWP.settings.pager.total_rows) {
                $('.facetwp-template').hide();
                $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
                $('#button_filter').modal('show');
            }
        });
    })(jQuery);

    (function ($) {
        $(document).on('facetwp-refresh', function () {
            $('.facetwp-template').prepend(
                '<div class="is-loading fixed-top-right text-light mt-6 mr-3 small">Yükleniyor</div>');
        });
        $(document).on('facetwp-loaded', function () {
            $('.facetwp-template .is-loading').remove();
        });
    })(jQuery);
    
</script>