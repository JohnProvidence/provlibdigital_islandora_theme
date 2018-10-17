<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
$parent = islandora_get_parents_from_rels_ext($islandora_object);

var_dump($associated_objects_array['object']);
?>

<div class="islandora islandora-basic-collection">
  <div class="islandora-basic-collection-grid clearfix">
  <?php foreach($associated_objects_array as $key => $value): ?>
    <dl class="islandora-basic-collection-object <?php print $value['class']; ?>">
        <dt class="islandora-basic-collection-thumb">
        <?php if(!empty($parent)): ?>
        	<a href="/islandora/object/<?php print $value['pid']; ?>">
              <img src="/islandora/object/<?php print $value['pid']; ?>/datastream/MEDIUM_SIZE/view" class="image-datastream" />
             </a>
            
            <?php else: ?>
         
           	 <?php if (isset($value['thumb_link'])): ?>
                <?php print $value['thumb_link']; ?>
              <?php endif; ?>

           	<?php endif; ?>
         </dt>
        <dd class="islandora-basic-collection-caption">
        	<h4 class="title"><?php print filter_xss($value['title_link']); ?></h4>
        	<span class="pid">Collection PID: <?php print filter_xss($value['pid']); ?></span>
        </dd>
    </dl>
  <?php endforeach; ?>
</div>
</div>