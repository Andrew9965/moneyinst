$(document).ready(function(){


	//placeholder
	$('input, textarea').placeholder();

	//phone masked
	$('input[type="tel"]').mask("+7 (999) 999-99-99",{placeholder:"+7 (___) ___-__-__"});
	
	//popup block
	$('.js-popup-wrap .js-btn-toggle').on('click touchstart', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active')
		} else {
			$('.js-popup-wrap:not(.no-close) .js-btn-toggle').removeClass('active');
			$(this).addClass('active');
		}
		return false;
	})
	$(document).on('click touchstart', function(event) {
		$(this).parents('.js-popup-wrap').children('.js-btn-toggle').removeClass('active');
	})
	$(document).click(function(event) {
	    if ($(event.target).closest(".js-popup-block").length) return;
	    $('.js-popup-wrap:not(.no-close) .js-btn-toggle').removeClass('active');
	    event.stopPropagation();
	});


	
	//tabs
	$('.tabs-nav').each(function() {
		$('#tab'+$(this).find('.active').attr('data-tab')).addClass('active');
	})
	$('.tabs-nav a').on('click', function() {
		if ($(this).hasClass('active')) {} else {
			$('.tab-block').removeClass('active');
			$(this).parents('.tabs-nav').find('.active').removeClass('active');
			$(this).addClass('active');
			$('.tabs-nav').each(function() {
				$('#tab'+$(this).find('.active').attr('data-tab')).addClass('active');
			})
		}
		return false;
	})


	//side menu
	$('.side-menu-wrap li.open ul').show(0);
	$('.side-menu-wrap .menu-block>ul>li>a').on('click', function() {
		if ($(this).parent().hasClass('open')) {
			$(this).parent().removeClass('open').children('ul').slideUp(200);
		} else {
			$(this).parent().addClass('open').children('ul').slideDown(200);
		}
		return false;
	})


	//fixed header
	$(window).scroll(function(){
		var windowTop = $(window).scrollTop();
		if (windowTop>0){
			$('.wrap').addClass('fixed');
		}
		else {
			$('.wrap').removeClass('fixed');
		}
	});


	//scroll content on anchot
	/*$('a[href="#"]').on("click", function(e){
		var anchor = $(this);
		$('html, body').stop().animate({
			scrollTop: $(anchor.attr('href')).offset().top-80}, 1000);
			e.preventDefault();
		return false;
	});*/

    jQuery.each( [ "put", "delete" ], function( i, method ) {
        jQuery[ method ] = function( url, data, callback, type ) {
            if ( jQuery.isFunction( data ) ) {
                type = type || callback;
                callback = data;
                data = undefined;
            }

            return jQuery.ajax({
                url: url,
                type: method,
                dataType: type,
                data: data,
                success: callback
            });
        };
    });

	
});