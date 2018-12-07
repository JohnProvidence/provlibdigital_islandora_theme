<?php

/**
 * @file
 * Render a bunch of objects in a list or grid view.
 */
?>
<div class="islandora-objects-list islandora-collections-wrapper">
  <?php $row_field = 0; ?>
  <?php foreach($objects as $object): ?>
    <?php $first = ($row_field == 0) ? 'first' : ''; ?>
    <div class="islandora-objects-list-item clearfix">
      <dl class="islandora-object <?php print $object['pid']['class']; ?>">
        <dt class="islandora-object-thumb">
          <?php print $object['pid']['thumb']; ?>
        </dt>
        <dd class="islandora-object-caption <?php print $object['pid']['class']?> <?php print $first; ?>">
          <strong>
            <?php print $object['pid']['link']; ?>
          </strong>
        </dd>
        <dd class="islandora-object-description">
          <?php print $object['pid']['description']; ?>
        </dd>
      </dl>
    </div>
    <?php $row_field++; ?>
  <?php endforeach; ?>
</div>