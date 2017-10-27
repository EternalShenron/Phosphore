jQuery(document).ready(function($) {

// Debug
function log(log) { 
    $('#log').show()
    $('#log').html(log) 
}

// Fonction exécutée au redimensionnement
var device; 
$(window).resize(function(){
    if (window.matchMedia("(max-width:576px)").matches) { device = 'Phone' }
    if (window.matchMedia("(min-width:576px)").matches) { device = 'Phablet' }
    if (window.matchMedia("(min-width:768px)").matches) { device = 'Tablet' }
    if (window.matchMedia("(min-width:992px)").matches) { device = 'Small Desktop' }
    if (window.matchMedia("(min-width:1200px)").matches) { device = 'Large Desktop' }

$('.page-multiple-cover').css('height', $('.page-multiple-cover').parents('.page-cover').outerHeight())

})


// Home slider

sliderSection = $('#home-slider-section, .slide-content')
sliderSectionHeight = ($(window).outerHeight() - $('.site-header').outerHeight()) / 100 * 80;
sliderSection.css('height', sliderSectionHeight)

  //Init the carousel
  initSlider();


  function initSlider() {
  time = 10000
    $('.home-posts-slider').owlCarousel({
      items: 1,
      loop: true,
      autoplayTimeout: time,
      animateOut: 'fadeOut',
      autoplay: true,
      onInitialized: startProgressBar,
      onTranslate: resetProgressBar,
      onTranslated: startProgressBar
    });
  }

  function startProgressBar() {
    // apply keyframe animation 
    $('.slide-progress').css({
      'width': '100%',
      'transition': 'width ' + time + 'ms'
    });
  }

  function resetProgressBar() {
    $('.slide-progress').css({
      'width': 0,
      'transition': 'width 0s'
    });
  }

// Slider examples

$('#examples-slider').owlCarousel({
	margin: 15,
	loop: true,
	mouseDrag: false,
	toucheDrag: false,
	responsive : {
	    // breakpoint from 0 up
	    0 : {
	        items : 1
	    },
	    768 : {
	        items : 3
	    }
	},
	dots: false,
	nav: true
});






	if ($('body').hasClass('page-template-template-page-examples')) {

		if (window.matchMedia("(min-width:768px)").matches) {

			exampleItem = $('#page-examples-list .example-item')
			exampleItem.parent().addClass('example-col')
			ExampleSection = $('#page-examples').html()

				var divs = $(".example-col");
				for(var i = 0; i < divs.length; i+=3) {
				  divs.slice(i, i+3).wrapAll("<div class='example-group'></div>");
				}

				$('.example-group').each(function(){
					$(this).append('<div class="details-receiver"></div>')
				})

				exampleItem.each(function() {
					exampleDetail = $(this).find('.example-detail')
					exampleDetail.appendTo($(this).parents('.example-group').find('.details-receiver'))
				})
				
		}

	}
















if ($('body').hasClass('page-template-template-pagehome')) {

	$('.example-item .example-detail').each(function() {
		detailsContainer = $('.details .container')
		$(this).appendTo(detailsContainer)
	})

}

collapseButtons = $('.example-item [data-toggle=collapse]')
collapseButtons.click(function(){
	controledID = ($(this).attr('aria-controls'))
	$('.collapse.in').collapse('hide')
})




// Sticky second header

$('#page-cover-maintainer').css({
    'height' : $('.page-cover').outerHeight()
})



if ($('body').hasClass('page-template-template-pageenfant') || $('body').hasClass('page-template-template-pagelocations') || $('body').hasClass('page-template-template-page-examples') )  {

	$(window).on('scroll', parallax).scroll()


	function parallax(){
		var s = $(window).scrollTop();
		var h = $(window).outerHeight();
		var h = $('.site-header')
		var hh = h.outerHeight()
		var c =  $('.page-cover');
		var ch = $('#page-cover-maintainer').outerHeight();
		var cpt = c.position().top;
		var cpb = cpt + ch;
		var ptg = $('.page-title-group')
		
	//log(s)

		function pbg(e, t) {
			$(e).css({
				'background-attachment': 'fixed',
				'background-position': 'center ' + -(s*t) + 'px'	
			});
		}
		
		function ptxt(e, t) {
			$(e).css({
				'position': 'relative',
				'top': (s*t) + 'px'	
			});
		}
		
		function otxt(e, o) {
			$(e).css({
				'opacity': 1
			});
		}

		if(cpb-s-hh >= 0) {
		
		//backgrounds
		pbg('.page-cover', .8);
		
		//texts
		ptxt('.page-title-group', .4);

		otxt('.page-title-group > *', 1)

		c.removeClass('affix')
		c.css({
			'top': 0
		})
		} else {
			c.addClass('affix')
			c.css({
				'top': h.position().top + hh,
				'opacity' : 0
			})
		}

		// log(cpb-s-hh)
		
	}

	parallax();
}

// Table of content */

$('.toc-item a').on('click', function() { // Au clic sur un élément
	var page = $(this).attr('href'); // Page cible
	var speed = 250; // Durée de l'animation (en ms)
	$('html, body').animate( { scrollTop: $(page).offset().top - 500 }, speed ); // Go
	return false;
});


});