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
    <?php if (isset($variables['obj_label'])): ?>
      <div class="islandora-basic-image-title">
        <h2><?php print $variables['obj_label']; ?></h2>
      </div>
    <?php endif; ?>

   
    <?php if (isset($islandora_content) && $variables['under_copyright'] == FALSE): ?>
      <div class="islandora-basic-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>

    <?php if($variables['under_copyright'] != FALSE): ?>
      <div class="copyright-restriction__message">
        <?php print $variables['copyright']; ?>
      </div>
    <?php endif; ?>
  </div>
   
   <div class="islandora-basic-image-description">
      <?php print $description; ?>
  </div>
   <div class="islandora-basic-image-metadata">
    <?php if ($parent_collections): ?>
      <div class="in-collections-listing">
        <h2><?php print t('In collections'); ?></h2>
        <ul>
          <?php foreach ($parent_collections as $collection): ?>
            <li class="collection-label"><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
            <?php if($collection['FINDING_AID'] != FALSE): ?>
            <li class="finding_aid_url"><i class="far fa-file" aria-hidden="true"></i><?php print l('Download Collection Finding Aid', $fa_url); 
              endif;
            ?>
          <?php endforeach; ?>
        </ul>
        <div class="islandora-basic-image-download-btns__wrapper">
          
          <?php if(isset($variables['mods_btn'])): ?>
          <?php print $variables['mods_btn']; ?>
          <?php endif; ?>

          <?php if(isset($variables['dc_btn'])): ?>
          <?php print $variables['dc_btn']; ?>
          <?php endif; ?>
          
          <?php if(isset($variables['img_btn'])): ?>
           <?php print $variables['img_btn']; ?>
          <?php endif; ?>
       
        </div>
      </div>
    <?php endif; ?>
    <?php print $metadata; ?>
  </div>
</div>
