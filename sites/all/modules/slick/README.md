Drupal module for Slick
=======================

Drupal module for Ken Wheeler's Slick carousel.
See http://kenwheeler.github.io/slick.

* Fully responsive. Scales with its container.
* Uses CSS3 when available. Fully functional when not.
* Swipe enabled. Or disabled, if you prefer.
* Desktop mouse dragging.
* Fully accessible with arrow key navigation.
* Autoplay, pagers, arrows, etc...
* Works with Views and core and contrib fields: Image, Media or Field collection.
* Exportable via CTools.

## Requirements
- CTools, for exportable optionsets
- libraries
- jquery_update
- jqeasing, or use drush make to download the easing libraries, remove versions
  from the file name (jquery.easing.1.3.min.js to jquery.easing.min.js)

## Optional integration
Slick supports enhancements and more complex layouts.
- Colorbox
- Picture, to get truly responsive image using art direction technique.
- Media, including media_youtube, media_vimeo, and media_soundcloud.
- Field collection

See README.txt for slick_fields.module for more info on fields integration.

## Optionsets
To create your option sets, go to:
"admin/config/media/slick"

## Views and Fields
Slick works with Views and as field display formatters.
Slick Views is available as a style plugin included at slick_views.module.
Slick Fields is available as a display formatter included at slick_fields.module
which supports core and contrib fields: core Image, Media, Field collection.

See README.txt for slick_views.module for more info on Views integration.

## Programmatically

  <?php
    // Add items, may collect from field, FC or Views rows.
    $items = array();
    $items[] = array('#markup' => '<img src="https://drupal.org/files/One.gif" />');
    $items[] = array('#markup' => '<img src="https://drupal.org/files/Two.gif" />');
    $items[] = array('#markup' => '<img src="https://drupal.org/files/Three.gif" />');

    // Add custom JS settings, this is related to core Slick JS options.
    $options = array(
      'autoplay' => TRUE,
      'dots' => TRUE,
      'arrows' => FALSE,
    );

    // Or altenatively load an optionset name.
    $options['optionset'] = 'optionset_name';

    // Or provide supported Layout settings, see theme_slick.
    $settings = array(
      'skin' => 'skin_name', // Supported skin name.
      'media_switch' => 'iframe-switch', // Or, colorbox-switch.
      'has_pattern' => TRUE, // Provide overlay pattern per image.
      'has_arrow_down' => TRUE, // Shows arrow down on the main slide.
      'arrow_down_target' => '#main', // Valid CSS selector ID.
      'arrow_down_offset' => 120, // Offset from the #main.
    );

    print theme('slick', array('items' => $items, 'options' => $options, 'settings' => $settings));
  ?>

## Skins
Skins allow swappable layouts like next/prev links, split image and caption, etc.
Make sure to enable slick_fields.module and provide a dedicated slide layout
per field to get more control over caption placements. However a combination of
skins and options may lead to unpredictable layouts, get dirty yourself.
Use Wrapper class to have a custom context as needed.

Available skins:
---------------
- Full width
  Adds additional wrapper to wrap overlay audio/video and captions properly.
- Boxed
  Added a 0 60px margin to slick-list container and hide neighboring slides.
  An alternative to centerPadding which still reveals neighboring slides.
- Split
  Caption and image/media are split half, and placed side by side.
- Box carousel
  Added box-shadow to the carousel slides.
- Boxed split
  Caption and image/media are split half, and have edge margin 0 60px.
- Rounded
  This will round the main image display, reasonable for small carousels, maybe
  with a small caption below to make it nice.

## Read more

See the project page on drupal.org: http://drupal.org/project/slick.
