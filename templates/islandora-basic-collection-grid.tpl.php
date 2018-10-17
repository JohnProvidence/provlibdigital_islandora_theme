<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
//var_dump($associated_objects_array);
?>

<div class="islandora islandora-basic-collection">
  <div class="islandora-basic-collection-grid clearfix">
  <?php foreach($associated_objects_array as $key => $value): ?>
    <dl class="islandora-basic-collection-object <?php print $value['class']; ?>">
        <dt class="islandora-basic-collection-thumb"><a href="/islandora/object/<?php print $value['pid']; ?>">
              <img src="/islandora/object/<?php print $value['pid']; ?>/datastream/MEDIUM_SIZE/view" class="image-datastream" />
             </a></dt>
        <dd class="islandora-basic-collection-caption">
        	<span class="title"><?php print filter_xss($value['title_link']); ?></span>
        	<span class="pid">Collection PID: <?php print filter_xss($value['pid']); ?></span>
        </dd>
    </dl>
  <?php endforeach; ?>
</div>
</div>