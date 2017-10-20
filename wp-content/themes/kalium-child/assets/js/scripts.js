jQuery(document).ready(function($) {

// Debug
function log(log) { 
    $('#log').show()
    $('#log').html(log) 
}

$('#page-cover-maintainer').css({
    'height' : $('.page-cover').outerHeight()
})

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

if ($('body').hasClass('page-template-template-pageenfant')) {
	parallax();
}



});