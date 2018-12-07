<?php

/**
 * @file
 * Render a bunch of objects in a list or grid view.
 */

?>
<div class="islandora-objects-grid islandora-collections-wrapper clearfix">
 <?php foreach($variables['objects'] as $object): ?>
   <div class="islandora-objects-grid-item <?php print $object['pid']['class']; ?>">
       <div class="islandora-object-thumb"><?php print $object['pid']['thumb']; ?></div>
       <div class="islandora-object-caption"><h4><?php print $object['pid']['link']; ?><h4></div>
   </div>
 <?php endforeach; ?>
</div>