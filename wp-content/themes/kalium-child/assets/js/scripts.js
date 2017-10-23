jQuery(document).ready(function($) {

// Debug
function log(log) { 
    $('#log').show()
    $('#log').html(log) 
}

// Fonction exécutée au redimensionnement
$(window).resize(function(){
    if(window.matchMedia("(max-width:767px)").matches) {  }
    if (window.matchMedia("(min-width:768px)").matches) {  }
    if (window.matchMedia("(min-width:992px)").matches) {  }
    if (window.matchMedia("(min-width:1200px)").matches) {  }


/*$('.page-multiple-cover').css({
	'height' : $(this).parent('.page-cover').outerHeight()
})*/

$('.page-multiple-cover').css('height', $('.page-multiple-cover').parents('.page-cover').outerHeight())

})


// Home slider

sliderSection = $('#home-slider-section, .slide-content')
sliderSectionHeight = $(window).outerHeight() - $('.site-header').outerHeight() * 2
sliderSection.css('height', sliderSectionHeight)

  //Init the carousel
  initSlider();


  function initSlider() {
  time = 10000
    $('.owl-carousel').owlCarousel({
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


$('#page-cover-maintainer').css({
    'height' : $('.page-cover').outerHeight()
})

if ($('body').hasClass('page-template-template-pageenfant')) {

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
	$('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
	return false;
});


});