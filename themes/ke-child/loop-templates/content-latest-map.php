<?php 

/**
 * Son düzenlenen 12 postayı görüntüle
 * Try only if Geo Mashup plugin is active
 */

if ( class_exists( 'GeoMashup' ) ) {
        $map_arguments = array (
            'map_content' => 'global',
            'limit' => 12,
            //'zoom' => 14,
            'marker_select_center' => 'false',
            'marker_select_info_window' => 'true',
            'marker_select_highlight' => 'true',
            'enable_scroll_wheel_zoom' => 'false',
            'name' => 'gm-latest',
            'auto_info_open' => 'true',
            'orderby' => 'modified',
            'no_found_rows' => true // speed up query when we don't need pagination
        );
        echo GeoMashup::map( $map_arguments );
    }
?>
