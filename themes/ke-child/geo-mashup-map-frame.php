<?php
/**
 * This is the default template for map frames.
 *
 *
 * For styling of map elements, see map-style-default.dev.css.
 *
 * Map properties include height, width, and name (see the style tag for example).
 * 
 * Individual registered scripts can be added with code like
 *
 * <code>GeoMashupRenderMap::enqueue_script( 'colorbox' );</code>
 *
 * Or include all queued resources by replacing
 *
 * <code>GeoMashupRenderMap::head();</code>
 *
 * with
 *
 * <code>wp_head();</code>
 *
 * @package GeoMashup
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Map</title>
		<?php GeoMashupRenderMap::head(); ?>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css"/>
		<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>

		<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
  		<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
		<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script> -->

		<!-- <script src="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js"></script>
		<link rel="stylesheet" href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" /> -->

		<style type="text/css">
		
			v\:* { behavior:url(#default#VML); }
			#geo-mashup {
				width:100%;
				height:100%;
			}
			
			.leaflet-popup-content-wrapper {border-radius: 1px !important;}
			.leaflet-container {background:transparent;font: .8rem 'Inter', sans-serif; line-height: 1.5; text-decoration: none;}
			.leaflet-container a {color: black;text-decoration: none;}
			.leaflet-container a:hover {color: #8a7f61;text-decoration: none;}
			.leaflet-popup-content {margin: 5px 5px;}
			.leaflet-control-layers-expanded span:hover{color:#8a7f61;}
			.leaflet-control-layers-selector{display:none;}
			.leaflet-bar {box-shadow: 0 1px 5px rgba(0,0,0,0.65);border-radius: 0px;}
			.leaflet-bar a, .leaflet-bar a:hover {background-color:black; color:white; border-bottom: 0px;}
			.leaflet-bar a:last-child {border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;}
			.leaflet-bar a:first-child {border-top-left-radius: 0px;border-top-right-radius: 0px;}
			.leaflet-touch .leaflet-bar a:last-child {border-bottom-left-radius: 0px;border-bottom-right-radius: 0px;}
			.leaflet-touch .leaflet-bar a:first-child {border-top-left-radius: 0px;border-top-right-radius: 0px;}
			.leaflet-touch .leaflet-control-layers, .leaflet-touch .leaflet-bar {border:0px;}
			.leaflet-container .leaflet-control-attribution {background: rgba(255, 255, 255, 0.0);}
			.leaflet-control-layers-expanded {padding: 9px 12px 6px 10px;color: #fff;background:#000;}
			.leaflet-control-layers {border-radius: 0px;}
			.leaflet-popup-content p {margin: 0;}
			.leaflet-container a.leaflet-popup-close-button {display: none;}
			.leaflet-control-scale-line{padding:0 8px;color:black;}
			.leaflet-control-scale-line{color:black;border:2px solid black; border-top:none;line-height:1.1;padding:2px 5px 1px;font-size:11px;white-space:nowrap;overflow:hidden;-moz-box-sizing:content-box;box-sizing:content-box; background:none;}
			.leaflet-control-scale-line:not(:first-child){border-top:2px solid black;border-bottom:none;margin-top:-2px;}
			.leaflet-control-scale-line:not(:first-child):not(:last-child){border-bottom:2px solid black;}
		</style>
			
	</head>
	<body>
	<div id="geo-mashup" class="<?php echo GeoMashupRenderMap::map_property( 'name' ); ?>">
		<noscript>
			<p><?php _e( 'This map requires JavaScript. You may have to enable it in your browser\'s settings.', 'GeoMashup' ); ?></p>
		</noscript>
	</div>
		<?php echo GeoMashupRenderMap::map_script( 'geo-mashup' ); ?>
	</body>
</html>
