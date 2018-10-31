<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: add documentation about file and available variables
 */

// Get Finding Aid from Parent Collection
if($parent_collections):
  foreach($parent_collections as $p) {
    if($p['FINDING_AID']):
     $fa_url = '/islandora/object/' . $p->id . '/datastream/FINDING_AID/view';
    endif;
  }
endif;

?>

<div class="islandora-basic-image-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="ImageObject">
  <div class="islandora-basic-image-content-wrapper clearfix">
    <?php if (isset($islandora_content)): ?>
      <div class="islandora-basic-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  </div>
   
   <div class="islandora-basic-image-description">
      <?php print $description; ?>
  </div>

  <div class="islandora-basic-image-download-btns__wrapper">
    <h4>Available Object Datastreams</h4>
    <div class="islandora-basic-image-download download-img btn OBJ">
      <a href="/islandora/object/<?php print $islandora_object->id; ?>/datastream/OBJ/view" download="<?php print $islandora_object->label.'_OBJ.jpg'; ?>">Download OBJ</a>
    </div>
   
      <div class="islandora-basic-image-download btn MODS">
        <a href="/islandora/object/<?php print $islandora_object->id; ?>/datastream/MODS/view" download="<?php print $islandora_object->label.'_MODS.xml'; ?>">Download MODS XML</a>
      </div>
      <div class="islandora-basic-image-download btn DC">
        <a href="/islandora/object/<?php print $islandora_object->id; ?>/datastream/DC/view" download="<?php print $islandora_object->label.'_DC.xml'; ?>">Download Dublin Core XML</a>
      </div>
  </div>
  
  <div class="islandora-basic-image-metadata">
    <?php if ($parent_collections): ?>
      <div class="in-collections-listing">
        <h2><?php print t('In collections'); ?></h2>
        <ul>
          <?php foreach ($parent_collections as $collection): ?>
            <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
            <?php if($collection['FINDING_AID'] != FALSE): ?>
            <li class="finding_aid_url"><?php print l( $collection->label . ' Finding Aid', $fa_url); 
              endif;
            ?>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php print $metadata; ?>
  </div>
</div>
