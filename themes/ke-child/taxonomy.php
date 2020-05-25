<?php get_header(); ?>

<!-- Page title -->
<?php if ( is_tax() ) : ?>
    <?php the_archive_title( '<div class="col-12 d-block d-md-none mt-6 text-light small fixed-top">', '</div>' );?>
<?php endif; ?>

<!-- Modal Wiki -->
<div class="modal" id="button_wiki" tabindex="-1" role="dialog" aria-labelledby="button_wikiTitle" aria-hidden="true">
    <div class="modal-dialog modal-search" role="document">
        <div class="modal-content">
            <div class="modal-body">
               <?php

                  $value = get_the_archive_title();
                  //$value = get_field( "place_wikipedia" );

                  if( $value ) {

                  /*
                     MediaWiki API
                     https://www.mediawiki.org/wiki/API:Parsing_wikitext#Sample_code_2
                  */

                  $endPoint = "https://tr.wikipedia.org/w/api.php";
                  $params = [
                     "action" => "parse",
                     "page" => $value,
                     "prop" => "text",
                     "section" => "0",
                     "redirects" => "yes",
                     "disabletoc" => "yes",
                     "disableeditsection" => "yes",
                     "format" => "json"
                  ];

                  $url = $endPoint . "?" . http_build_query( $params );

                  $ch = curl_init( $url );
                  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                  $output = curl_exec( $ch );
                  curl_close( $ch );

                  $result = json_decode( $output, true );

                  echo '<div class="wiki-content">';

                  // echo( $result["parse"]["text"]["*"] );
                  // function.php bul ve değiştir

                  print_processed_html($result["parse"]["text"]["*"]);

                  echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
                  echo $value;
                  echo '">Vikipedi sayfasından oku</a> - ';

                  echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
                  echo $value;
                  echo '#/editor/0">Düzenle</a>';

                  echo '</div>';

                  } else {
                     echo '';
                     //echo '<a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
                     //echo the_title();
                     //echo '">Vikipedi</a></p>';
                  }

               ?>  
            </div>
        </div>
    </div>
</div>

<div class="wrapper" id="taxonomy-wrapper">
   <div class="container-fluid" id="content" tabindex="-1">
      <div class="row">
         <div class="col-12 col-lg-3 col-md-6 pt-3 pb-3 d-none d-md-block scroll-area bg-primary text-dark">

            <div class="accordion pb-3 mb-3 border-bottom border-dark" id="accordionFilter">
                  <div class="card bg-transparent">
                     <a class="card-header" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo"
                           aria-expanded="false" aria-controls="collapseTwo">
                           Grup
                     </a>
                     <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                           data-parent="#accordionFilter">
                           <div class="card-body">
                              <?php echo facetwp_display( 'facet', 'grup' ); ?>
                           </div>
                     </div>
                  </div>
                  <div class="card bg-transparent">
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
                  <div class="card bg-transparent">
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
                  <div class="card bg-transparent">
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
                  <div class="card bg-transparent">
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

            <div class="pb-3 mb-3"> 
               <?php echo facetwp_display( 'selections' ); ?>
            </div>

            <div class="mb-3"> 
               <?php understrap_pagination(); ?>
            </div>

            <div class="mb-3 border-bottom border-dark"> 
               <small><p><?php global $wp_query; echo $wp_query->found_posts; ?> sonuç arasından <?php global $wp_query; echo $wp_query->post_count; ?> nokta görüntüleniyor.</p></small>
            </div>

            <div class="pl-1 pr-1 pb-3 mb-3"> 
               <?php echo GeoMashup::visible_posts_list() ?>
            </div>

            <div class="facetwp-template">
            </div>

         </div>

         <div class="col-12 col-lg-9 col-md-6 nopadding map-default">
            <?php
            // This template code will work only in the WordPress Loop to include a map if the Geo Mashup plugin is active and the current post has a location.
            // https://snipplr.com/view/29558/conditional-geo-mashup-map-template-code
            $coordinates = GeoMashup::post_coordinates();
               if ( class_exists( 'GeoMashup' ) and ! empty( $coordinates ) ) {
                  echo GeoMashup::map();
               }
            ?>
         </div>
      </div>
   </div>
</div>

<script>
   (function($) {
      $(document).on('facetwp-refresh', function() {
         if (FWP.loaded) { // after the initial pageload
               //FWP.parse_facets(); // load the values
               FWP.set_hash(); // set the new URL
               location.reload();
               return false;
         }
      });
   })(jQuery);
</script>

<?php get_footer(); ?>
