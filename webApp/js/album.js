
jQuery('img.svg').each(function() {
	var $img = jQuery(this);
	var imgID = $img.attr('id');
	var imgClass = $img.attr('class');
	var imgURL = $img.attr('src');

	jQuery.get(imgURL, function(data) {
		// Get the SVG tag, ignore the rest
		var $svg = jQuery(data).find('svg');

		// Add replaced image's ID to the new SVG
		if (typeof imgID !== 'undefined') {
			$svg = $svg.attr('id', imgID);
		}
		// Add replaced image's classes to the new SVG
		if (typeof imgClass !== 'undefined') {
			$svg = $svg.attr('class', imgClass + ' replaced-svg');
		}

		// Remove any invalid XML tags as per
		// http://validator.w3.org
		$svg = $svg.removeAttr('xmlns:a');

		// Replace image with new SVG
		$img.replaceWith($svg);

	}, 'xml');

});

function zipFiles() {
	var zip = new JSZip();
	var imgCounter = 0;
	var imgsArr = document.getElementsByClassName("imgSrc");
	var fileURLs = [ imgsArr.length ];
	var album_title = document.getElementById("album-title").innerHTML;
	
	for (var i = 0; i < imgsArr.length; i++) {
		fileURLs[i] = $(imgsArr[i]).attr("src");
	}

	for (var i = 0; i < fileURLs.length; i++) {
		JSZipUtils.getBinaryContent(fileURLs[i], function(err, data) {
			if (err) {
				alert("Problem happened when downloading img: " + fileURLs[i]);
				console.error("Problem happened when downloading img: "
						+ fileURLs[i]);
			} else {
				zip.file("picture" + (imgCounter + 1) + ".jpg", data, {
					binary : true
				});
				imgCounter++;
				if (imgCounter == imgsArr.length) {
					var content = zip.generate({
						type : "blob"
					});
					saveAs(content, album_title + ".zip");
				}
			}
		});
	}
}


function toggleMobileDropdown() {
	
	 $("#mobile-logout").animate({
	        height: 'toggle',
	 	}, {
	     duration: 200,         
	    });			
}

function scrollUp(){
	
	$('html, body').animate({scrollTop: $("#scrollUp").offset().top - 2 * $(window).height()}, 1000);	
	
}

function scrollDown(){

	$('html, body').animate({scrollTop: $("#scrollDown").offset().top + $(window).height()}, 1000);
	
}

function activateScrollTo(){
	
	// acivate animated scrollTo 
	$('.page-scroll a ').on('click', function(e) { // smooth
		// scrolling
		var anchor = $(this);
		$('html, body').stop().animate({
			scrollTop : $(anchor.attr('href')).offset().top
		}, 1000);
		e.preventDefault();
	});	
	
}

var $grid = $('#grid').masonry({		  
});
	
var setSidescroll = false;
var grid_hasbeen_init = false;
var gallery_hasbeen_init = false;


function set_side_scroll(){
	
	if(setSidescroll){					
		refresh_sidescroll_spy();				
	}
	
	var DOM_IMG_ELEMS_ARRAY = document.getElementsByClassName('imgSrc');
	var NUMBER_OF_DOM_IMG_ELEMS = DOM_IMG_ELEMS_ARRAY.length;	
	
	if (!setSidescroll && $(window).width() > 767 && window.pageYOffset > 8 * $(window).height()) {
		
		setSidescroll = true;
		
		activateScrollTo();
																					
		DOM_IMG_ELEMS_ARRAY[Math.round(NUMBER_OF_DOM_IMG_ELEMS / 4)].setAttribute("id", "secondDot");
		DOM_IMG_ELEMS_ARRAY[Math.round(NUMBER_OF_DOM_IMG_ELEMS / 2)].setAttribute("id", "thirdDot");
		DOM_IMG_ELEMS_ARRAY[Math.round(3 * NUMBER_OF_DOM_IMG_ELEMS / 4)].setAttribute("id", "fourthDot");							
		
		
		$("#scrollUp").addClass("hidden");
		$("#scrollDown").addClass("hidden");
		$("#scrollTop").removeClass("hidden");
		$("#scrollToSecondDot").removeClass("hidden");
		$("#scrollToThirdDot").removeClass("hidden");
		$("#scrollToFourthDot").removeClass("hidden");
		$("#scrollToFifthDot").removeClass("hidden");																					
						
	}
	else{		
		if(!setSidescroll && NUMBER_OF_DOM_IMG_ELEMS > 15){
			
			activateScrollTo();
			
			$("#scrollUp").removeClass("hidden");
			$("#scrollDown").removeClass("hidden");
		}
	}	
}



function refreshScrollspy(elem) {
    $('[data-spy="scroll"]').each(function() {
        $(elem).scrollspy('refresh');
    });
}
$(function() {
    refreshScrollspy();
});


function refresh_sidescroll_spy(){	
	
	//refresh bootstrap scrollspy after pageload	
	var elem = document.getElementById("secondDot");				
	refreshScrollspy(elem);
	elem = document.getElementById("thirdDot");				
	refreshScrollspy(elem);
	elem = document.getElementById("fourthDot");				
	refreshScrollspy(elem);
	elem = document.getElementById("fifthDot");				
	refreshScrollspy(elem);	
}


function init_non_mobile_view(){
	
	if (!gallery_hasbeen_init && $(window).width() > 767) {	
		$('.popup-gallery').magnificPopup({
	        delegate: 'a',
	        type: 'image',
	        tLoading: 'Loading image #%curr%...',
	        mainClass: 'mfp-img-mobile',
	        closeOnContentClick: false,
	        closeOnBgClick:false,
	        enableEscapeKey:true,
	        showCloseBtn:true,
	        gallery: {
	          enabled: true,	            
	          navigateByImgClick: true,
	          preload: [0,1] // Will preload 0 before current, and 1 after the current image
	        },
	        image: {
	          tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',	            
	          titleSrc: function(item) {
	            
	            return item.el.attr('title');
	          }
	        },
	        
	        callbacks: {	        		        	  
	        	imageLoadComplete: function() {
	        	    // fires when image in current popup finished loading	          	    
	        	    console.log('Image loaded');
	        	    document.getElementById("mfp-download").setAttribute('href', this.currItem.src);
	        	  }
	      }
	        
	      });
		
		new AnimOnScroll( document.getElementById( 'grid' ), {
			minDuration : 0.4,
			maxDuration : 0.7,
			viewportFactor : 0.2
		} );		
	
		
		$('.gallery-item').magnificPopup({
			  type: 'image',
			  gallery:{
			  enabled:true
			  }
		});
		
		grid_hasbeen_init = true;
	}
}

window.onload = function(e){ 
	$('#stat').fadeOut();
	$('#preloader').delay(350).fadeOut(
			'slow'); 
};

$( window ).scroll(function() {
	 if($(window).width() > 767){
		 $grid.masonry('layout');
	 }		
	 set_side_scroll();						
});


$( window ).resize(function() {		  
	init_non_mobile_view();		  
});


jQuery(document).ready(function(){ 
	
	init_non_mobile_view();
	
	$("img").unveil(700, function() {		
	});			
				
});
