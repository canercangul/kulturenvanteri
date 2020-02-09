var galleries = jQuery(".gallery");
if (galleries.length) {
	galleries.each(function(){
		var current = jQuery(this);
		var gal_id = jQuery(this).attr('id');
		current.imagesLoaded( function() {
			current.masonry();
		});
	});
}