jQuery(document).ready(function($) {

// Debug
function log(log) { 
    $('#log').show()
    $('#log').html(log) 
}

// Fonction exécutée au redimensionnement
var device; 
$(window).resize(function(){
    if (window.matchMedia("(max-width:575px)").matches) { device = 'Phone' }
    if (window.matchMedia("(min-width:576px)").matches) { device = 'Phablet' }
    if (window.matchMedia("(min-width:768px)").matches) { device = 'Tablet' }
    if (window.matchMedia("(min-width:992px)").matches) { device = 'Small Desktop' }
    if (window.matchMedia("(min-width:1200px)").matches) { device = 'Large Desktop' }

$('.page-multiple-cover').css('height', $('.page-multiple-cover').parents('.page-cover').outerHeight())

})

// Match height

$(function() {
	options = {
		byRow: false
	}
	$('.match-height').matchHeight(options);
});

$(function() {
	byRow = {
		byRow: true
	}
	$('.match-height-by-row').matchHeight(byRow);
});



	// Home slider

	sliderSection = $('#home-slider-section, .slide-content')
	adminBar = $('#wpadminbar')
	if (adminBar.length > 0) {
		adminBarHeight = adminBar.outerHeight()
	} else {
		adminBarHeight = 0
	}
	adminBarHeight = adminBar.outerHeight()
	postInfo = $('#home-slider-section, .post-info')
	$(window).resize(function(){
		postInfoHeight = postInfo.outerHeight()
		if (window.matchMedia("(min-width:992px)").matches) {
			sliderSectionHeight = ($(window).outerHeight() - $('.site-header').outerHeight() - adminBarHeight );
			sliderSection.css({
				'height': sliderSectionHeight,
				'min-height': postInfoHeight
			})
		} else {
			sliderSectionHeight = $(window).outerWidth() / 3 * 2
			sliderSection.css({
				'height': sliderSectionHeight,
				'min-height': postInfoHeight
			})
		}
	})


  //Init the carousel
  initSlider();


  function initSlider() {
  time = 10000
	$('.home-posts-slider').owlCarousel({
	  items: 1,
	  loop: true,
	  autoplayTimeout: time,
	  animateOut: 'fadeOut',
	  animateIn: 'fadeIn',
	  autoplay: false,
	  nav: true,
	  navContainer: '#home-slider-nav>.container',
	  dotsContainer: '#home-slider-dots',
	  navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
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
	items: 1,
	margin: 15,
	loop: true,
	mouseDrag: true,
	toucheDrag: true,
	dots: false,
	nav: true,
	navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
	responsive : {
	    768 : {
	        items : 4,
	        autoWidth: false,
			mouseDrag: false,
			toucheDrag: false,
	    }
	},
	onTranslated: closeAllCollapse
});

function closeAllCollapse() {
	focusedElement = $('#home-examples-slider-section [aria-expanded=true]')
	// console.log()
	if (focusedElement.parents('.owl-item').hasClass('active') == false) {
		$('#home-examples-slider-section .details .collapse.in').collapse('hide')
	}
}


if ($('body').hasClass('page-template-template-page-examples')) {

	$(window).resize(function(){

		// Si le device est plus grand que 768px
		if (window.matchMedia("(min-width:768px)").matches) {

			exampleItem = $('#page-examples-list .example-item')
			exampleItem.parent().addClass('example-col')
			ExampleSection = $('#page-examples').html()

			// On rassemble les éléments par groupes de 4
			var divs = $(".example-col");
			if ($('.example-group').length == 0) {
				for(var i = 0; i < divs.length; i+=4) {
			  		divs.slice(i, i+4).wrapAll("<div class='example-group'></div>");
				}
			}

			// A la fin de chaque groupe, on insère l'élément qui recevra les détails
			$('.example-group').each(function() {
				if ($(this).find('.details-receiver').length == 0) {
					$(this).append('<div class="details-receiver"></div>')
				}
			})

			// On déplace chaque détail dans le receveur correspondant
			exampleItem.each(function() {
				exampleDetail = $(this).find('.example-detail')
				exampleDetail.appendTo($(this).parents('.example-group').find('.details-receiver'))
			})
				
		} else {

			$('.details-receiver').each(function(){

				i = 1

				$(this).find('.example-detail').each(function(){

					$(this).appendTo($(this).parents('.example-group').children('.example-col:nth-child(' + i + ')').children('.example-item'))

					console.log($(this).attr('id'))

					i++

				})

				$(this).remove()

			})

		}

	})

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



var profiles = $('.profile');

profiles.each(function(){
	profileGroup = $(this).attr('data-profile-group')
	if ( $(this).parent().hasClass('profile-group') == false ) {
		$('.profile[data-profile-group=' + profileGroup + ']').wrapAll('<div class="profile-group">');
	}

})

industryLink = $('.industry-link')

$(window).resize(function(){

	if (window.matchMedia("(min-width:992px)").matches) {
		$('.industry-detail').collapse('show')
		industryLink.attr('href', '')
	} else {
		$('.industry-detail').collapse('hide')
		industryLink.each(function(){
			industryLinkTarget = $(this).attr('data-href')
			$(this).attr('href', industryLinkTarget)
		})
	}

})



$(window).resize(function(){
	if (window.matchMedia("(max-width:991px)").matches) {
		$('.benefit-cycle').addClass('owl-carousel')
		$('.benefit-cycle').owlCarousel({
			items: 1,
			dots: true,
			autoHeight:true
		})
		i = 1
		$('.benefit-cycle .owl-dot').each(function(){
			$(this).html(i)
			i++
		})

	} else {
		$('.benefit-cycle').owlCarousel('destroy')
		$('.benefit-cycle').removeClass('owl-carousel')
		$('.benefit-step').each(function(){
			shadow = $(this).find('.benefit-step-shadow')
			graphic = $(this).find('.benefit-step-graphic')
			description = $(this).find('.benefit-step-description-container')
			shadow.css('height', graphic.outerHeight() + description.outerHeight())
			description.css('top', graphic.outerHeight())
		})
	}

})



$(window).resize(function(){

	if (window.matchMedia("(max-width:991px)").matches) {
		$('.profile-detail').collapse('hide')
		$('.profile-group-title').css('padding-top', 0)
	} else if (window.matchMedia("(min-width:992px)").matches) {
		$('.profile-detail').collapse('show')
		$('.profile-group-title').each(function(){
			groupTitleHeight = $(this).find('.typical-recruit').outerHeight()
			$(this).css('padding-top', ($(this).outerHeight() - groupTitleHeight) / 2 )
		})
	}


	collapseProfile = $('.profile-item [data-toggle=collapse]')
	collapseProfile.click(function(){
		if (window.matchMedia("(max-width:991px)").matches) {
			$('.collapse.in').collapse('hide')
			$('.collapse.in').css('height', 0)
		} else {
			$('.profile-detail').collapse('show')
		}
	})

})


$('.profile-item [data-toggle=collapse]').each(function(){
	$(this).hover(function(){
		$(this).parents('.profile').toggleClass('active-profile')
	})
	$(this).on( 'click', function(e){
		e.preventDefault();
	})
})

var i = 1
$('.profile-link').each(function(){
	$(this).addClass('profile-link-' + i)
	i++
})

$('.profile-group').each(function(){
	profileGroupName = $(this).find('.typical-recruit').first()
	if (profileGroupName.length > 0) {
		$(this).prepend('<div class="h5 profile-group-title"></div>')
		profileGroupTitleContainer = $(this).find('.profile-group-title')
		profileGroupName.appendTo(profileGroupTitleContainer)
	}
})


function updateCoverMaintainer() {
	$('#page-cover-maintainer').css({
		'height' : $('.page-cover').outerHeight()
	})
}

		updateCoverMaintainer()

if ($('body').hasClass('page-template-template-pageenfant') || $('body').hasClass('page-template-template-pagelocations') || $('body').hasClass('page-template-template-page-examples' || $('body').attr('id') == 'post-94') )  {


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
		
//		updateCoverMaintainer()
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
			//updateCoverMaintainer()
			c.addClass('affix')
			c.css({
				'top': h.position().top + hh,
				'opacity' : 0
			})
		}

		//log(cpb-s-hh)
	}

	$(window).on('scroll', parallax).scroll()

}

// Table of content */

$('.toc-item a').on('click', function() { // Au clic sur un élément
	var page = $(this).attr('href'); // Page cible
	var speed = 250; // Durée de l'animation (en ms)
	$('html, body').animate( { scrollTop: $(page).offset().top - 90 }, speed ); // Go
	return false;
});


});