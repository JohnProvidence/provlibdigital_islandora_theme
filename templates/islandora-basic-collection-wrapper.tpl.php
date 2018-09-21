<?php

/**
 * @file
 * islandora-basic-collection-wrapper.tpl.php
 * This is a modified version of the islandora solution pack collections - basic collection template.
 * This is applied to all objects that have the basic collection content model applied to them
 *
 * @TODO: needs documentation about file and variables
 */
?>

<div class="islandora-basic-collection-wrapper">
   <span class="islandora-basic-collection-display-switch">
      <ul class="links inline">
        <?php foreach ($view_links as $link): ?>
          <li>
            <a <?php print drupal_attributes($link['attributes']) ?>><?php print filter_xss($link['title']) ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </span>
  <div class="islandora-basic-collection__collection-info">
  <?php 
    if(!empty($dc_array['dc:title']['value'])): ?>
  <h2><?php print $dc_array['dc:title']['value']; ?></h2>
  <?php
    endif;
  ?>
  <?php if (!$display_metadata && !empty($dc_array['dc:description']['value'])): ?>
    <p><?php print nl2br($dc_array['dc:description']['value']); ?></p>
  </div>
  <?php endif; ?>
  <div class="islandora-basic-collection clearfix">
   
    <?php print $collection_pager; ?>
    <?php print $collection_content; ?>
    <?php print $collection_pager; ?>
  </div>
  
  <?php if ($display_metadata): ?>
    <div class="islandora-collection-metadata">
      <?php print $description; ?>
      <?php if ($parent_collections): ?>
        <div>
          <h2><?php print t('In collections'); ?></h2>
          <ul>
            <?php foreach ($parent_collections as $collection): ?>
              <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php print $metadata; ?>
    </div>
  <?php endif; ?>
</div>
