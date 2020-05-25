<?php
/**
 * Partial template for content in test.php
 * Varsayılan
 * 
 * @package understrap
 */

?>

<!-- Selections -->
<div class="col-6 mt-6 text-light small fixed-top">

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
    <button class="btn btn-sm btn-circle btn-primary btn-visiblelist" data-toggle="modal"
        data-target="#button_visiblelist">Liste</button>
</div> -->

<!-- Modal Search -->
<div class="modal" id="button_filter" tabindex="-1" role="dialog" aria-labelledby="button_filterTitle" aria-hidden="true">
    <div class="modal-dialog modal-filter" role="document">
        <div class="modal-content">

            <div class="modal-body">

                <?php echo facetwp_display( 'facet', 'search' ); ?>
                <?php echo facetwp_display( 'selections' ); ?>
                <?php echo facetwp_display( 'counts' ); ?>
                <?php echo facetwp_display( 'facet', 'pagination' ); ?>

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
                                <?php echo facetwp_display( 'facet', 'gruplar' ); ?>
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
                                <?php echo facetwp_display( 'facet', 'turler' ); ?>
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
                                <?php echo facetwp_display( 'facet', 'kulturler' ); ?>
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
                                <?php echo facetwp_display( 'facet', 'yuzyillar' ); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <a class="card-header" id="headingSix" data-toggle="collapse" data-target="#collapseSix"
                            aria-expanded="false" aria-controls="collapseSix">
                            Konum
                        </a>
                        <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                            data-parent="#accordionFilter">
                            <div class="card-body">
                                <?php echo facetwp_display( 'facet', 'search_location' ); ?>
                                <?php echo facetwp_display( 'facet', 'konumlar' ); ?>
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

<!-- Map and Fullpost -->
<div class="row d-flex">
    <div class="flex-fill w-50 nopadding map-default"><?php echo facetwp_display( 'template', 'test' ); ?></div>
    <?php echo GeoMashup::full_post(); ?>
</div>

<script>

    (function ($) {
        $(document).on('facetwp-loaded', function () {
            if (FWP.build_query_string()) {
                $('.facetwp-template').show();
                // $('.btn-visiblelist').show();
                $('.facetwp-counts').show();
                $('.facetwp-pager').show();
            } else {
                $('.facetwp-template').show();
                // $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
            }
        });
    })(jQuery);

    (function ($) {
        $(document).on('facetwp-loaded', function () {
            if (0 === FWP.settings.pager.total_rows) {
                $('.facetwp-template').hide();
                // $('.btn-visiblelist').hide();
                $('.facetwp-counts').hide();
                $('.facetwp-pager').hide();
            }
        });
    })(jQuery);

    // (function ($) {
    //     $(window).on('load', function () {
    //         // $('#button_filter').modal('show'); // Auto open modal 
    //         // $( '.locate-me' ).trigger( 'click' ); // Auto locate me
    //     });
    // })(jQuery);

    // (function ($) {
    //     $(document).ready(function(){
    //         $(".btn-visiblelist").click(function(){
    //             $("#gm-post").hide();
    //         });
    //     });
    // })(jQuery);

    // (function ($) {
    //     $('.btn-visiblelist').live('click', function () {
	//         $('#gm-post').toggle();
    //     });
    // })(jQuery);

    (function($) {
        $(document).on('facetwp-refresh', function() {
            $('.facetwp-template').prepend('<div class="is-loading fixed-top-right text-light mt-6 mr-3 small">Yükleniyor</div>');
        });
        $(document).on('facetwp-loaded', function() {
            $('.facetwp-template .is-loading').remove();
        });
    })(jQuery);

</script>