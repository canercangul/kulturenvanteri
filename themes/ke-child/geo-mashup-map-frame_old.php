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
		<script type="text/javascript" src="https://api.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.2.0/leaflet-omnivore.min.js"></script>
		<style type="text/css">
			v\:* { behavior:url(#default#VML); }
			#geo-mashup {
				width:100%;
				height:100%;
			}
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
