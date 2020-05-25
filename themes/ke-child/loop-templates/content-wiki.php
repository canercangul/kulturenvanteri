<?php
/**
 * Wiki template.
 *
 * @package understrap
 */

?>
<div class="entry-content pt-6 p-3">

<h4><?php the_field( 'wikipedia' ); ?></h4>

        <?php
			
            $value = get_field( "place_wikipedia" );

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

            //echo( $result["parse"]["text"]["*"] );

            //bul ve değiştir
            print_processed_html($result["parse"]["text"]["*"]);

            echo '<p><a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
            echo $value;
            echo '">Wikipedia</a></p>';

            echo '<p><a target="_blank" class="iframe-popup small" href="https://tr.m.wikipedia.org/wiki/';
            echo $value;
            echo '#/editor/0">Düzenle</a></p>';

            } else {
                echo '';
            }

        ?>

        <?php the_content(); ?>

    <?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

</div><!-- .entry-content -->