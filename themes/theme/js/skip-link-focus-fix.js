( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
	
	
	
	/* BANNERS */
	
	function Site (){
		
	}
	
	var paragraphica = new Site();
	
	
	paragraphica.bannerScroll = function () {
        if (jQuery('.footer-cta').offset().top + jQuery('.footer-cta').height() >= jQuery('.footer-wrap').offset().top - 10) {
            jQuery('.footer-cta').css({
                'position': 'absolute',
                'top': '-110px',
				'height': '110px'
            });
        }
        if (window.matchMedia('(max-width: 768px)').matches) {
            jQuery('.footer-cta').css({
                'position': 'absolute',
                'top': '-110px',
				'height': '110px'
            });
        }

        if (jQuery(document).scrollTop() + window.innerHeight < jQuery('.footer-wrap').offset().top) {
            jQuery('.footer-cta').css({
                'position': 'fixed',
                'bottom': '0',
				'top': 'auto'
            });
        }
    };
	
	
	paragraphica.bannerClose = function (){
		jQuery('#banner-close').click(function () {
            jQuery('.sub_header-cta').css({
				'visibility': 'hidden',
				'opacity': '0'
			});
        });
		
		jQuery('#footer-banner-close').click(function () {
            jQuery('.footer-cta').css({
				'visibility': 'hidden',
				'opacity': '0'
			});
        });
	};
	
	paragraphica.isScrolledIntoView = function (){
        var docViewTop = jQuery(window).scrollTop(),
			inTop = false;
	
		if (docViewTop > 600){
			inTop = true;
		}

        return inTop;
	};
	
	
	paragraphica.init = function () {
		paragraphica.bannerClose();
		paragraphica.notNow();
		paragraphica.flashcard();
	};
	
	
	paragraphica.sidebarScroll = function () {
		
		var height = 0;
		
		if (jQuery('body').hasClass('home') === true){
			var height = 1350;
		} else {
			var height = 1200;
		}

		if (this.isScrolledIntoView()) {
			jQuery('.widget__cta').addClass('showed');
		}
		
		if (jQuery(window).scrollTop() > 1200 ) {
			jQuery('.widget__cta').addClass('affixW');
			if (document.querySelector('#main').getBoundingClientRect().bottom <= 670) {
				jQuery('.widget__cta').removeClass('affixW').addClass('diedW');
			}
		}
		
		if (document.querySelector('#main').getBoundingClientRect().bottom > 670) {
			jQuery('.widget__cta').removeClass('diedW').addClass('affixW');
			if (jQuery(window).scrollTop() < height) {
				jQuery('.widget__cta').removeClass('affixW');
				jQuery('.widget__cta').removeClass('diedW');
			}
		}

	};
	
	paragraphica.notNow = function (){
		jQuery('.cta__not').click(function(e){
			e.preventDefault();
			jQuery('.widget__cta').fadeOut(1000).remove();
		});
	};

    paragraphica.flashcard = function () {
        jQuery('.first-col').each(function () {
            if (jQuery(this).html() !== "") {
                jQuery('.first-col').addClass('not-empty');
                jQuery('.pgp-flex-item').addClass('width-33');
            }
        });
    };
	
	
	paragraphica.init();

	jQuery(window).scroll(
		function () {
			if (window.matchMedia("(min-width: 992px)").matches) {
			  paragraphica.sidebarScroll();
			}
			
			if (window.matchMedia("(max-width: 992px)").matches) {
			  paragraphica.bannerScroll();
			}
			
	
		}
	);

})();


