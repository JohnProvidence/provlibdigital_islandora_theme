<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
$parent = islandora_get_parents_from_rels_ext($islandora_object);


?>

<div class="islandora islandora-basic-collection">
  <div class="islandora-basic-collection-grid clearfix">
  <?php foreach($associated_objects_array as $key => $value): ?>
    <dl class="islandora-basic-collection-object <?php print $value['class']; ?>">
        <dt class="islandora-basic-collection-thumb">
         <?php if(isset($value['medium_size_link'])): ?>
             <?php print $value['medium_size_link']; ?>
           <?php else: ?>
           	 <?php if (isset($value['thumb_link'])): ?>
                <?php print $value['thumb_link']; ?>
              <?php endif; ?>
           	<?php endif; ?>
         </dt>
        <dd class="islandora-basic-collection-caption">
        	<h4 class="title"><?php print filter_xss($value['title_link']); ?></h4>
        </dd>
    </dl>
  <?php endforeach; ?>
</div>
</div>