<?php
/**
 * @file
 * Template file to style output.
 */

?>
<div class="islandora-object-title">
    <h2><?php print $object->label; ?></h2>
</div>

<?php if(isset($viewer)): ?>
  <div id="book-viewer">
    <?php print $viewer; ?>
  </div>
<?php endif; ?>

<?php print $description; ?>

<?php if($variables['parent_collection'] != NULL): ?>
    <div class="parent-collection-info__wrapper">
      <h3>In Collection: <a href="<?php print $variables['parent_url']; ?>"><?php print $variables['parent_collection']; ?></a></h3>
      <?php if($variables['collection_finding_aid_button'] != NULL) {
        print $variables['collection_finding_aid_button'];
      }  ?>
    </div>
<?php endif; ?>

<div class="islandora-basic-image-download-btns__wrapper">
          
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

<?php if($display_metadata === 1): ?>
  <div class="islandora-book-metadata">
   <?php print $metadata; ?>
  </div>
<?php endif; ?>