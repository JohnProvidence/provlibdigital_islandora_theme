<?php

/**
 * @file
 * islandora-basic-collection.tpl.php
 *
 * @TODO: add documentation about file and available variables
 */

?>

<div class="islandora-basic-image-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="ImageObject">
  <div class="islandora-basic-image-content-wrapper clearfix">
    <!-- <?php if (isset($variables['obj_label'])): ?>
      <div class="islandora-basic-image-title">
        <h2><?php print $variables['obj_label']; ?></h2>
      </div>
    <?php endif; ?>--> <!-- Hiding the display of the object label, using page title as object label -->

    <?php if (isset($islandora_content) && $variables['under_copyright'] == NULL): ?>
      <div class="islandora-basic-image-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>

    <?php if($variables['under_copyright'] != NULL): ?>
      <div class="copyright-restriction__message">
        <?php print $variables['under_copyright']; ?>
      </div>
    <?php endif; ?>
  </div>

   <div class="islandora-basic-image-description">
      <?php print $variables['description']; ?>
  </div>

  <?php if($variables['parent_collection'] != NULL): ?>
    <div class="parent-collection-info__wrapper">
      <h3>In Collection: <a href="<?php print $variables['parent_url']; ?>"><?php print $variables['parent_collection']; ?></a></h3>
      <?php if($variables['collection_finding_aid_button'] != NULL) {
        print $variables['collection_finding_aid_button'];
      }  ?>
    </div>
<?php endif; ?>

  <div class="islandora-basic-image-download-btns__wrapper">
      <?php if(isset($variables['img_btn']) && $variables['under_copyright'] == NULL): ?>
          <?php print $variables['img_btn']; ?>
      <?php endif; ?>
          
      <?php if(isset($variables['mods_btn'])): ?>
          <?php print $variables['mods_btn']; ?>
      <?php endif; ?>

      <?php if(isset($variables['dc_btn'])): ?>
          <?php print $variables['dc_btn']; ?>
      <?php endif; ?>

      <?php if(isset($variables['marcxml_btn'])): ?>
            <?php print $variables['marcxml_btn']; ?>
      <?php endif; ?>
    </div>

   <div class="islandora-basic-image-metadata">
    <?php print $metadata; ?>
  </div>
</div>
