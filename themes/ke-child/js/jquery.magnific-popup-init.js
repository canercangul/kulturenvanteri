jQuery(document).ready(function($) {
	$('a[href*=".jpg"], a[href*=".jpeg"], a[href*=".png"], a[href*=".gif"], a[href*=".pdf"]').each(function(){

//single image popup
	if ($(this).parents('.gallery').length == 0) {
			$(this).magnificPopup({
			type:'image',
			showCloseBtn: false,
			mainClass: 'mfp-with-zoom',
			zoom: {enabled:true, duration:300}
		    });
		}
	});

//gallery popup
	$('.gallery').each(function() {
		$(this).magnificPopup({
			delegate: 'a',
			type: 'image',
			showCloseBtn: false,
			mainClass: 'mfp-with-zoom',
			gallery: {enabled:true},
			zoom: {enabled:true, duration:300}
		});
	}); 

//iframe
	$(document).ready(function() {
		$('.iframe-popup').magnificPopup({
			type: 'iframe',
			showCloseBtn: false
		});
	});
	
});

