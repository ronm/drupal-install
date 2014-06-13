<?php

/**
 * @file
 * Default template for displaying a Slick carousel.
 * 
 * @todo, delete this file when deprecated.
 */
?>
<div class="<?php print $classes; ?>" <?php print $attributes; ?>>
  <?php foreach ($items as $index => $item): ?>
    <div class="<?php print $item_classes[$index]; ?>">
      <?php print render($item); ?>
    </div>
  <?php endforeach; ?>
</div>
