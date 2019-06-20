<?php

/**
 * @file
 * This is the template file for the pdf object
 *
 * @TODO: Add documentation about this file and the available variables
 */
?>

<div class="islandora-pdf-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="Article">

  <div class="social-sharing-buttons">
    <div class="social-title">Share This Object:</div>
    <?php print $variables['facebook_button']; ?>
    <?php print $variables['twitter_button']; ?>
  </div>

  <div class="islandora-pdf-content-wrapper clearfix">
    <?php if (isset($islandora_content)): ?>
      <div class="islandora-pdf-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="islandora-basic-image-description">
     <?php print $variables['item_description']; ?>
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
     <?php if(isset($variables['pdf_btn'])): ?>
       <?php print $variables['pdf_btn']; ?>
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

  <div class="islandora-pdf-metadata">
    <?php print $metadata; ?>
  </div>
</div>
