<?php

/**
 * @file
 *
 * Default theme implementation for the Slick media template.
 *
 * The Slick media support core image, vimeo, youtube and soundcloud.
 * If iframe switcher is enabled, audio/video iframe whill be hidden below image
 * overlay, and only visible when toggled.
 *
 * Variables available:
 *  $id - The file entity ID (fid).
 *  $url - The full url including query options for the iframes.
 *  $alternative_content - Text to display for browsers that don't support
 *  iframes.
 *  $settings - An array containing cherry-picked settings.
 */
?>
<div<?php print $attributes; ?>>
  <?php if (in_array($settings['type'], array('video', 'audio'))): ?>
    <?php if ($settings['media_switch'] != 'colorbox-switch'): ?>
      <iframe<?php print $content_attributes; ?> allowfullscreen><?php print $alternative_content; ?></iframe>
    <?php endif; ?>
    <?php if ($settings['media_switch'] == 'iframe-switch'): ?>
      <i class="media-icon media-icon--close"></i>
      <i class="media-icon media-icon--play"></i>
      <i class="media-icon media-icon--spinner"></i>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!empty($item)): ?>
    <?php print render($item_prefix); ?>
    <?php print render($item); ?>
    <?php print render($item_suffix); ?>
  <?php endif; ?>
</div>
