/**
 * @file
 */
(function ($, Drupal, window, document, undefined) {
  "use strict";

  Drupal.slickColorbox = Drupal.slickColorbox || {};
  var $window = $(window),
    resizeTimer;

  Drupal.behaviors.slickColorbox = {
    attach: function (context, settings) {
      if (!$.isFunction($.colorbox)) {
        return;
      }

      // Disable Colorbox for small screens, if so configured.
      if (settings.colorbox.mobiledetect && window.matchMedia) {
        var mq = window.matchMedia("(max-device-width: " + settings.colorbox.mobiledevicewidth + ")");
        if (mq.matches) {
          return;
        }
      }

      $('.slick__slide:not(.slick-cloned) .slick__colorbox', context).once('slick-colorbox', function () {
        var t = $(this),
          url = t.attr('href'),
          id = t.closest('.slick').attr('id'),
          $body = $('body'),
          media = t.data('media') || {},
          $slider = t.closest('.slick', context),
          isMedia = media.type !== 'image' ? true : false,
          curr = t.closest('.slick__slide:not(.slick-cloned)').index(),
          runtimeOptions = {
            iframe: isMedia,
            rel: media.rel || null,
            onOpen: function () {
              $body.addClass('colorbox-on colorbox-on--' + media.type);
              $body.data('mediaHeight', '');
            },
            onLoad: function () {
              if (media.type !== 'image') {
                $body.data('mediaHeight', media.height);
              }
              $slider.slickGoTo(curr);
            },
            onCleanup: function () {
              $body.removeClass('colorbox-on colorbox-on--' + media.type);
            },
            onComplete: function() {
              Drupal.slickColorbox.resize(context, Drupal.settings);
            },
            onClosed: function () {
              if ($('#' + id).length) {
                Drupal.slickColorbox.jumpScroll(id, 120);
              }
              $body.removeClass('colorbox-on colorbox-on--' + media.type);
              $body.data('mediaHeight', '');
              $slider.slickGoTo(curr);
              $slider.slickPause();
            }
          };

        // Force autoplay, if not provided which should not.
        if (isMedia) {
          if (media.scheme === 'soundcloud') {
            if (url.indexOf('auto_play') < 0 || url.indexOf('auto_play') === false) {
              url = url + '&amp;auto_play=true';
            }
          }
          else if (url.indexOf('autoplay') < 0 || url.indexOf('autoplay') === 0) {
            url = url + '&amp;autoplay=1';
          }
        }

        t.attr('href', url)
         .colorbox($.extend({}, settings.colorbox, runtimeOptions));
      });

      $window.bind('resize', function() {
        Drupal.slickColorbox.resize(context, Drupal.settings);
      });

      window.addEventListener("orientationchange", Drupal.slickColorbox.resize(context, Drupal.settings), false);

      $(context).bind('cbox_complete', function () {
        Drupal.attachBehaviors('#cboxLoadedContent');
      });
    }
  };

  Drupal.slickColorbox.jumpScroll = function (id, o) {
    if ($(id).length) {
      $('html, body').stop().animate({
          scrollTop: $(id).offset().top - o
      }, 800);
    }
  };

  Drupal.slickColorbox.resize = function (context, settings) {
    if (resizeTimer) {
      clearTimeout(resizeTimer);
    }

    var mW = settings.colorbox.maxWidth,
      mH = settings.colorbox.maxHeight,
      o = {
        width: '98%',
        height: '98%',
        maxWidth: mW.indexOf('px') > 0 ? parseInt(mW) : mW,
        maxHeight: mH.indexOf('px') > 0 ? parseInt(mH) : mH
      };

    resizeTimer = setTimeout(function () {
      if ($('#cboxOverlay').is(':visible')) {
        var $container = $('#cboxLoadedContent'),
        $content = $('> img, > iframe, > .node', $container);

        $.colorbox.resize({
          width: window.innerWidth > o.maxWidth ? o.maxWidth : o.width
        });

        $content.css({
          width: $container.innerWidth(),
          height: $('body').data('mediaHeight') !== 'undefined' ? $('body').data('mediaHeight')  : 'auto'
        });

        $container.height($content.height());

        $.colorbox.resize();
      }
    }, 0);
  };

}(jQuery, Drupal, this, this.document));