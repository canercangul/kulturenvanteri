
GeoMashup.addAction( 'loadedMap', function ( properties, mxn ) {
	var leaflet_map = mxn.getMap();

// Add Scale	
	L.control.scale().addTo(leaflet_map);
} );

// MXN geo-mashup/js/geo-mashup-mxn.js

GeoMashup.openInfoWindow = function( marker ) {
	var request,
		cache,
		object_ids,
		i,
		object_element,
		point = marker.location;

	if ( this.open_window_marker && !this.opts.multiple_info_windows ) {
		this.open_window_marker.closeBubble();
	}
	object_ids = this.getOnObjectIDs( this.getObjectsAtLocation( point ) );
	cache = this.locationCache( point, 'info-window-' + object_ids.join( ',' ) );
	if ( cache.html ) {
		marker.setInfoBubble( cache.html );
		marker.openBubble();
	} else {
		// marker.setInfoBubble( '<div align="center"><img src="' + this.opts.url_path + '/images/busy_icon.gif" alt="Loading..." /></div>' );
		marker.openBubble();
		this.open_window_marker = marker;
		// Collect object ids
		// Do an AJAX query to get content for these objects
		request = {
			url: this.geo_query_url + '&object_name=' + this.opts.object_name + '&object_ids=' + object_ids.join( ',' )
		};
		/**
		 * A marker's info window content is being requested.
		 * @name GeoMashup#markerInfoWindowRequest
		 * @event
		 * @param {Marker} marker
		 * @param {AjaxRequestOptions} request Modifiable property: url
		 */
		this.doAction( 'markerInfoWindowRequest', marker, request );
		jQuery.get( request.url, function( content ) {
			var filter = {
				content: content
			};
			marker.closeBubble();
			/**
			 * A marker info window content is being loaded.
			 * @name GeoMashup#markerInfoWindowLoad
			 * @event
			 * @param {Marker} marker
			 * @param {ContentFilter} filter Modifiable property: content
			 */
			GeoMashup.doAction( 'markerInfoWindowLoad', marker, filter );
			cache.html = GeoMashup.parentizeLinksMarkup( filter.content );
			marker.setInfoBubble( cache.html );
			marker.openBubble();
		} );
	}
};

GeoMashup.addGlowMarker = function( marker ) {
	var point = marker.location,
		glow_options = {
			clickable: true,
			icon: this.opts.url_path + '/images/mm_36_glow.png',
			iconSize: [20, 20],
			iconAnchor: [0, 0]
		};

	if ( this.glow_marker ) {
		this.removeGlowMarker();
	}
	/**
	 * A highlight "glow" marker is being created.
	 * @name GeoMashup#glowMarkerIcon
	 * @event
	 * @param {GeoMashupOptions} properties Geo Mashup configuration data
	 * @param {Object} glow_options Modifiable <a href="http://mapstraction.github.com/mxn/build/latest/docs/symbols/mxn.Marker.html#addData">Mapstraction</a>
	 *   or <a href="http://code.google.com/apis/maps/documentation/javascript/v2/reference.html#GMarkerOptions">Google</a> marker options
	 */
	this.doAction( 'glowMarkerIcon', this.opts, glow_options );
	this.glow_marker = new mxn.Marker( point );
	this.glow_marker.addData( glow_options );
	this.glow_marker.click.addHandler( function() {
		GeoMashup.deselectMarker();
	} );
	this.map.addMarker( this.glow_marker );
};

GeoMashup.createMap = function( container, opts ) {
	var i,
		type_num,
		center_latlng,
		map_opts,
		map_types,
		request,
		url,
		objects,
		point,
		marker_opts,
		clusterer_opts,
		single_marker,
		ov,
		credit_div,
		initial_zoom = 1,
		controls = {},
		filter = {};

	this.container = container;
	this.base_color_icon = {};
	this.base_color_icon.image = opts.url_path + '/images/mm_36_black.png';
	this.base_color_icon.iconShadow = '';
	this.base_color_icon.iconSize = [20, 20];
	this.base_color_icon.shadowSize = [0, 0];
	this.base_color_icon.iconAnchor = [0, 0];
	this.base_color_icon.infoWindowAnchor = [15, 2];
	this.multiple_term_icon = this.clone( this.base_color_icon );
	this.multiple_term_icon.image = opts.url_path + '/images/mm_36_mixed.png';

	// Falsify options to make tests simpler
	this.forEach( opts, function( key, value ) {
		if ( 'false' === value || 'FALSE' === value ) {
			opts[key] = false;
		}
	} );

	// See if we have access to a parent frame
	this.have_parent_access = false;
	try {
		if ( typeof parent === 'object' ) {
			// Try access, throws an exception if prohibited
			parent.document.getElementById( 'bogus-test' );
			// Access worked
			this.have_parent_access = true;
		}
	} catch ( parent_exception ) {
	}

	// For now, siteurl is the home url
	opts.home_url = opts.siteurl;

	map_types = {
		'G_NORMAL_MAP': mxn.Mapstraction.ROAD,
		'G_SATELLITE_MAP': mxn.Mapstraction.SATELLITE,
		'G_HYBRID_MAP': mxn.Mapstraction.HYBRID,
		'G_PHYSICAL_MAP': mxn.Mapstraction.PHYSICAL
	};

	if ( typeof opts.map_type === 'string' ) {
		if ( map_types[opts.map_type] ) {
			opts.map_type = map_types[opts.map_type];
		} else {
			type_num = parseInt( opts.map_type, 10 );
			if ( isNaN( type_num ) || type_num > 2 ) {
				opts.map_type = map_types.G_NORMAL_MAP;
			} else {
				opts.map_type = type_num;
			}
		}
	} else if ( typeof opts.map_type === 'undefined' ) {
		opts.map_type = map_types.G_NORMAL_MAP;
	}
	this.map = new mxn.Mapstraction( this.container, opts.map_api );
	map_opts = {
		enableDragging: true
	};
	map_opts.enableScrollWheelZoom = (opts.enable_scroll_wheel_zoom ? true : false );

	if ( typeof this.map.enableGeoMashupExtras === 'function' ) {
		this.map.enableGeoMashupExtras();
	}
	/**
	 * The map options are being set.
	 * @name GeoMashup#mapOptions
	 * @event
	 * @param {GeoMashupOptions} properties Geo Mashup configuration data
	 * @param {Object} map_opts Modifiable <a href="http://mapstraction.github.com/mxn/build/latest/docs/symbols/mxn.Mapstraction.html#options">Mapstraction</a>
	 *   or <a href="http://code.google.com/apis/maps/documentation/javascript/v2/reference.html#GMapOptions">Google</a> map options
	 */
	this.doAction( 'mapOptions', opts, map_opts );
	this.map.setOptions( map_opts );
	this.map.setCenterAndZoom( new mxn.LatLonPoint( 0, 0 ), 0 );

	/**
	 * The map was created.
	 * @name GeoMashup#newMap
	 * @event
	 * @param {GeoMashupOptions} properties Geo Mashup configuration data
	 * @param {Map} map
	 */
	this.doAction( 'newMap', opts, this.map );

	// Create the loading spinner icon and show it
	this.spinner_div = document.createElement( 'div' );
	this.spinner_div.innerHTML = '<div id="gm-loading-icon" style="-moz-user-select: none; z-index: 100; position: absolute; left: ' + (jQuery( this.container ).width() / 2 ) + 'px; top: ' + (jQuery( this.container ).height() / 2 ) + 'px;">' + '<img style="border: 0px none ; margin: 0px; padding: 0px; width: 16px; height: 16px; -moz-user-select: none;" src="' + opts.url_path + '/images/busy_icon.gif"/></a></div>';
	this.showLoadingIcon();
	this.map.load.addHandler( function() {
		GeoMashup.hideLoadingIcon();
	} );

	if ( !opts.object_name ) {
		opts.object_name = 'post';
	}
	this.opts = opts;
	filter.url = opts.siteurl + (opts.siteurl.indexOf( '?' ) > 0 ? '&' : '?' ) + 'geo_mashup_content=geo-query&map_name=' + encodeURIComponent( opts.name );
	if ( opts.lang && filter.url.indexOf( 'lang=' ) === -1 ) {
		filter.url += '&lang=' + encodeURIComponent( opts.lang );
	}

	/**
	 * The base URL used for geo queries is being set.
	 * @name GeoMashup#geoQueryUrl
	 * @event
	 * @param {GeoMashupOptions} properties Geo Mashup configuration data
	 * @param {Object} filter Mofiable property: url
	 */
	this.doAction( 'geoQueryUrl', this.opts, filter );
	this.geo_query_url = filter.url;

	this.map.changeZoom.addHandler( function() {
		GeoMashup.adjustZoom();
		GeoMashup.adjustViewport();
	}, this );
	this.map.endPan.addHandler( function() {
		GeoMashup.adjustViewport();
	}, this );

	// No clustering available

	if ( opts.zoom !== 'auto' && typeof opts.zoom === 'string' ) {
		initial_zoom = parseInt( opts.zoom, 10 );
	} else {
		initial_zoom = opts.zoom;
	}

	if ( opts.load_kml ) {
		try {
			// Some servers (Google) don't like HTML entities in URLs
			opts.load_kml = jQuery( '<div/>' ).html( opts.load_kml ).text();
			if ( initial_zoom === 'auto' ) {
				this.map.addOverlay( opts.load_kml, true );
			} else {
				this.map.addOverlay( opts.load_kml );
			}
		} catch ( e ) {
			// Probably not implemented
		}
	}

	if ( this.term_manager ) {
		this.term_manager.load();
	}

	try {
		this.map.setMapType( opts.map_type );
	} catch ( map_type_ex ) {
		// Probably not implemented
	}
	if ( initial_zoom !== 'auto' ) {
		if ( opts.center_lat && opts.center_lng ) {
			// Use the center from options
			this.map.setCenterAndZoom( new mxn.LatLonPoint( parseFloat( opts.center_lat ), parseFloat( opts.center_lng ) ), initial_zoom );
		} else if ( opts.object_data && opts.object_data.objects[0] ) {
			center_latlng = new mxn.LatLonPoint( parseFloat( opts.object_data.objects[0].lat ), parseFloat( opts.object_data.objects[0].lng ) );
			this.map.setCenterAndZoom( center_latlng, initial_zoom );
		} else {
			// Center on the most recent located object
			url = this.geo_query_url + '&limit=1';
			if ( opts.map_cat ) {
				url += '&map_cat=' + opts.map_cat;
			}
			jQuery.getJSON( url, function( objects ) {
				if ( objects.length > 0 ) {
					center_latlng = new mxn.LatLonPoint( parseFloat( objects[0].lat ), parseFloat( objects[0].lng ) );
					this.map.setCenterAndZoom( center_latlng, initial_zoom );
				}
			} );
		}
	}

	this.location_bounds = null;

	if ( opts.map_content === 'single' ) {
		if ( opts.object_data && opts.object_data.objects.length && !opts.load_kml ) {
			marker_opts = {
				visible: true
			};
			if ( typeof customGeoMashupSinglePostIcon === 'function' ) {
				marker_opts = customGeoMashupSinglePostIcon( this.opts );
			}
			if ( !marker_opts.image ) {
				marker_opts = this.colorIcon( 'black' );
				marker_opts.icon = marker_opts.image;
			}
			/**
			 * A single map marker is being created with these options
			 * @name GeoMashup#singleMarkerOptions
			 * @event
			 * @param {GeoMashupOptions} properties Geo Mashup configuration data
			 * @param {Object} marker_opts Mofifiable Mapstraction or Google marker options
			 */
			this.doAction( 'singleMarkerOptions', this.opts, marker_opts );
			single_marker = new mxn.Marker( new mxn.LatLonPoint( parseFloat( opts.object_data.objects[0].lat ), parseFloat( opts.object_data.objects[0].lng ) ) );
			this.map.addMarkerWithData( single_marker, marker_opts );
			/**
			 * A single map marker was added to the map.
			 * @name GeoMashup#singleMarker
			 * @event
			 * @param {GeoMashupOptions} properties Geo Mashup configuration data
			 * @param {Marker} single_marker
			 */
			this.doAction( 'singleMarker', this.opts, single_marker );
		}
	} else if ( opts.object_data ) {
		this.addObjects( opts.object_data.objects, true );
	} else {
		// Request objects near visible range first
		this.requestObjects( true );

		// Request all objects
		this.requestObjects( false );
	}

	if ( 'GSmallZoomControl' === opts.map_control || 'GSmallZoomControl3D' === opts.map_control ) {
		controls.zoom = 'small';
	} else if ( 'GSmallMapControl' === opts.map_control ) {
		controls.zoom = 'small';
		controls.pan = true;
	} else if ( 'GLargeMapControl' === opts.map_control || 'GLargeMapControl3D' === opts.map_control ) {
		controls.zoom = 'large';
		controls.pan = true;
	}

	if ( opts.add_map_type_control ) {
		controls.map_type = true;
	}

	if ( opts.add_overview_control ) {
		controls.overview = true;
	}

	if ( opts.enable_street_view !== false ) {
		controls.street_view = true;
	}
	this.map.addControls( controls );

	if ( opts.add_map_type_control && typeof this.map.setMapTypes === 'function' ) {
		if ( typeof opts.add_map_type_control === 'string' ) {
			opts.add_map_type_control = opts.add_map_type_control.split( /\s*,\s*/ );
			if ( typeof map_types[opts.add_map_type_control[0]] === 'undefined' ) {
				// Convert the old boolean value to a default array
				opts.add_map_type_control = ['G_NORMAL_MAP', 'G_SATELLITE_MAP', 'G_PHYSICAL_MAP'];
			}
		}
		// Convert to mapstraction types
		opts.mxn_map_type_control = [];
		for ( i = 0; i < opts.add_map_type_control.length; i += 1 ) {
			opts.mxn_map_type_control.push( map_types[opts.add_map_type_control[i]] );
		}
		this.map.setMapTypes( opts.mxn_map_type_control );
	}

	this.map.load.addHandler( function() {
		GeoMashup.updateVisibleList();
	} );
	if ( typeof customizeGeoMashupMap === 'function' ) {
		customizeGeoMashupMap( this.opts, this.map );
	}
	if ( typeof customizeGeoMashup === 'function' ) {
		customizeGeoMashup( this );
	}
	this.hideLoadingIcon();
	/**
	 * The map has loaded.
	 * @name GeoMashup#loadedMap
	 * @event
	 * @param {GeoMashupOptions} properties Geo Mashup configuration data
	 * @param {Map} map
	 */
	this.doAction( 'loadedMap', this.opts, this.map );

};

// LEAFLET CORE geo-mashup/js/mxn/mxn.leaflet.core.js

mxn.register('leaflet', {

	Mapstraction: {
	
		applyOptions: function(){
			if (this.options.enableScrollWheelZoom) {
				this.maps[this.api].scrollWheelZoom.enable();
			} else {
				this.maps[this.api].scrollWheelZoom.disable();
			}
			return;
		},
	
		resizeTo: function(width, height){
			this.currentElement.style.width = width;
			this.currentElement.style.height = height;
			this.maps[this.api].invalidateSize();
		},
	
		addControls: function(args) {
			/* args = { 
			*     pan:      true,
			*     zoom:     'large' || 'small',
			*     overview: true,
			*     scale:    true,
			*     map_type: true,
			* }
			*/
	
			var map = this.maps[this.api];
	
			if ('zoom' in args || ('pan' in args && args.pan)) {
				if (args.pan || args.zoom || args.zoom == 'large' || args.zoom == 'small') {
					this.addSmallControls();
				}
			}
			else {
				if (this.controls.zoom !== null) {
					map.removeControl(this.controls.zoom);
					this.controls.zoom = null;
				}
			}
			
			if ('scale' in args && args.scale) {
				if (this.controls.scale === null) {
					this.controls.scale = new L.Control.Scale();
					map.addControl(this.controls.scale);
				}
			}
			else {
				if (this.controls.scale !== null) {
					map.removeControl(this.controls.scale);
					this.controls.scale = null;
				}
			}
	
			if ('map_type' in args && args.map_type) {
				this.addMapTypeControls();
			}
			else {
				if (this.controls.map_type !== null) {
					map.removeControl(this.controls.map_type);
					this.controls.map_type = null;
				}
			}
		},
		// ZOOM CONTROL POSITION
		addSmallControls: function() {
			var map = this.maps[this.api];
			
			if (this.controls.zoom === null) {
				this.controls.zoom = new L.Control.Zoom({position:'topleft'}); //Pozisyon değişebilir. Parantez içine ekle: {position: 'topright'}
				map.addControl(this.controls.zoom);
			}
		},
	
		addLargeControls: function() {
			return this.addSmallControls();
		},
		// MAP CONTROL POSITION
		addMapTypeControls: function() {
			var map = this.maps[this.api];
			
			if (this.controls.map_type === null) {
				// Layer control'de marker'lar görünmesin "this.features" silindi.
				// this.controls.map_type = new L.Control.Layers(this.layers, this.features);
				this.controls.map_type = new L.Control.Layers(this.layers, null, {position:'topleft', collapsed:false});
				map.addControl(this.controls.map_type,);
			}
		},	
	
		setCenterAndZoom: function(point, zoom) { 
			var map = this.maps[this.api];
			var pt = point.toProprietary(this.api);
			map.setView(pt, zoom); 
		},
		
		addMarker: function(marker, old) {
			var map = this.maps[this.api];
			var pin = marker.toProprietary(this.api);
			map.addLayer(pin);
			this.features.push(pin);
			return pin;
		},
	
		removeMarker: function(marker) {
			var map = this.maps[this.api];
			map.removeLayer(marker.proprietary_marker);
		},
		
		declutterMarkers: function(opts) {
			throw new Error('Mapstraction.declutterMarkers is not currently supported by provider ' + this.api);
		},
	
		addPolyline: function(polyline, old) {
			var map = this.maps[this.api];
			polyline = polyline.toProprietary(this.api);
			map.addLayer(polyline);
			this.features.push(polyline);
			return polyline;
		},
	
		removePolyline: function(polyline) {
			var map = this.maps[this.api];
			map.removeLayer(polyline.proprietary_polyline);
		},
	
		getCenter: function() {
			var map = this.maps[this.api];
			var pt = map.getCenter();
			return new mxn.LatLonPoint(pt.lat, pt.lng);
		},
	
		setCenter: function(point, options) {
			var map = this.maps[this.api];
			var pt = point.toProprietary(this.api);
			if (options && options.pan) { 
				map.panTo(pt); 
			}
			else { 
				map.setView(pt, map.getZoom(), true);
			}
		},
	
		setZoom: function(zoom) {
			var map = this.maps[this.api];
			map.setZoom(zoom);
		},
		
		getZoom: function() {
			var map = this.maps[this.api];
			return map.getZoom();
		},
	
		getZoomLevelForBoundingBox: function(bbox) {
			var map = this.maps[this.api];
			var bounds = new L.LatLngBounds(
				bbox.getSouthWest().toProprietary(this.api),
				bbox.getNorthEast().toProprietary(this.api));
			return map.getBoundsZoom(bounds);
		},
	
		setMapType: function(type) {
			switch(type) {
				case mxn.Mapstraction.ROAD:
					this.layers[this.road_tile.name].bringToFront();
					this.currentMapType = mxn.Mapstraction.ROAD;
					break;
	
				case mxn.Mapstraction.SATELLITE:
					this.layers[this.satellite_tile.name].bringToFront();
					this.currentMapType = mxn.Mapstraction.SATELLITE;
					break;
	
				case mxn.Mapstraction.HYBRID:
					break;
				
				case mxn.Mapstraction.PHYSICAL:
					break;
					
				default:
					this.layers[this.road_tile.name].bringToFront();
					this.currentMapType = mxn.Mapstraction.ROAD;
					break;
			}
		},
	
		getMapType: function() {
			return this.currentMapType;
		},
	
		getBounds: function () {
			var map = this.maps[this.api];
			var box = map.getBounds();
			var sw = box.getSouthWest();
			var ne = box.getNorthEast();
			return new mxn.BoundingBox(sw.lat, sw.lng, ne.lat, ne.lng);
		},
	
		setBounds: function(bounds){
			var map = this.maps[this.api];
			var sw = bounds.getSouthWest().toProprietary(this.api);
			var ne = bounds.getNorthEast().toProprietary(this.api);
			var newBounds = new L.LatLngBounds(sw, ne);
			map.fitBounds(newBounds); 
		},
	
		addImageOverlay: function(id, src, opacity, west, south, east, north) {
			var map = this.maps[this.api];
			var imageBounds = [[west, south], [east, north]];
			L.imageOverlay(src, imageBounds).addTo(map);
		},
	
		setImagePosition: function(id, oContext) {
			throw new Error('Mapstraction.setImagePosition is not currently supported by provider ' + this.api);
		},
	
		addTileLayer: function(tile_url, opacity, label, attribution, min_zoom, max_zoom, map_type, subdomains) {
			var map = this.maps[this.api];
			var z_index = this.tileLayers.length || 0;
			var options = {
				minZoom: min_zoom,
				maxZoom: max_zoom,
				name: label,
				attribution: attribution,
				opacity: opacity
			};
			if (typeof subdomains !== 'undefined') {
				options.subdomains = subdomains;
			}
			var url = mxn.util.sanitizeTileURL(tile_url);
			
			this.layers[label] = new L.TileLayer(url, options);
			if(z_index==0) {
				map.addLayer(this.layers[label]);
			}
			this.tileLayers.push([tile_url, this.layers[label], true, z_index]);
	
			if (this.controls.map_type !== null) {
				this.controls.map_type.addBaseLayer(this.layers[label], label);
			}
	
			return this.layers[label];
		},
	
		toggleTileLayer: function(tile_url) {
			var map = this.maps[this.api];
			for (var f = 0; f < this.tileLayers.length; f++) {
				var tileLayer = this.tileLayers[f];
				if (tileLayer[0] == tile_url) {
					if (tileLayer[2]) {
						tileLayer[2] = false;
						map.removeLayer(tileLayer[1]);
					}
					else {
						tileLayer[2] = true;
						map.addLayer(tileLayer[1]);
					}
				}
			}
		},
	
		getPixelRatio: function() {
			throw new Error('Mapstraction.getPixelRatio is not currently supported by provider ' + this.api);
		},
		
		mousePosition: function(element) {
			var map = this.maps[this.api];
			var locDisp = document.getElementById(element);
			if (locDisp !== null) {
				map.on("mousemove", function(e) {
					var loc = e.latlng.lat.toFixed(4) + '/' + e.latlng.lng.toFixed(4);
					locDisp.innerHTML = loc;
				});
				locDisp.innerHTML = '0.0000 / 0.0000';
			}
		},
	
		openBubble: function(point, content) {
			var map = this.maps[this.api];
			var newPoint = point.toProprietary(this.api);
			var marker = new L.Marker(newPoint);
			marker.bindPopup(content);
			map.addLayer(marker);
			marker.openPopup();
			this.openInfoBubble.fire( { 'marker': this } );		
		},
	
		closeBubble: function() {
			var map = this.maps[this.api];
			map.closePopup();
			this.closeInfoBubble.fire( { 'marker': this } );		
		}
	},
	
});