(function (win, doc, $, Drupal) {

	var $doc = $( doc ),
		$html = $( doc.documentElement ),
		$body = $( doc.body ),
		$htmlBody = $.fn.add.call($html,$body),
		$carousel = $(".slick-slider"),
		defaultSlick = {
			autoplay: true,
			autoplaySpeed: 5000,
			dots: true,
			infinite: true,
			speed: 500,
			fade: true,
			slide: 'article',
			cssEase: 'linear'
		},
		transitionEndSupport = function () {
			var prefixes = [
					"",
					"webkit",
					"o"
				],
			i = -1,
			l = prefixes.length,
			ret = false,
			vendor;

			while ((i += 1) < l) {
				vendor = prefixes[i];
				if (("on" + vendor + "transitionend") in window) {
					ret = new window.Boolean(true);
					ret.event = ((vendor) ? vendor + "T" : "t") + "ransitionEnd";
					break;
				}
			}

			return ret.event;
		},
		transitionEnd = transitionEndSupport(),
		smoothScroll = function($dest, clbk) {
			var to = $dest.offset().top - $header.outerHeight();
			if ( to > -1 ) {
				$htmlBody.animate({ scrollTop: to }, 400, function() {
					scrolling = false;
					if ( typeof clbk === "function" ) { clbk.call(); }
				});

				updateNav();
			} else if ( typeof clbk === "function" ) {
				clbk.call();
			}
		},
		debounce = function(func, wait, immediate) {
			var timeout;
			return function() {
				var context = this, args = arguments,
					later = function() {
						timeout = null;
						if (!immediate) func.apply(context, args);
					},
					callNow = immediate && !timeout;

				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow) func.apply(context, args);
			};
		};



	Drupal.behaviors.ronzoni = {
    	attach: function(context, settings) {

				var htmlClasses = [];

				htmlClasses[( transitionEnd ? 'transitionend' : 'no-transitionend')];
				htmlClasses.push( 'placeholder' in doc.createElement('input') ? 'placeholder' : 'no-placeholder');

				$html.addClass( htmlClasses.join(" ") );


				if ( $carousel ) {
					$carousel.slick(defaultSlick);

					$carousel.on("waybetter.outview", function() {
						$carousel.slickPause()
					}).on("waybetter.inview", function() {
						$carousel.slickPlay();
					});
				}

		}
	}

})(this, this.document, jQuery, Drupal);
