<?php

/**
 * @file
 * This is the template file for the object page for media
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file
 * - $islandora_dublin_core: The DC datastream object
 * - $dc_array: The DC datastream object values as a sanitized array. This
 *   includes label, value and class name.
 * - $islandora_object_label: The sanitized object label.
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 *
 * @see template_preprocess_islandora_video()
 * @see theme_islandora_video()
 */
 //var_dump($variables['description']);
?>

<div class="islandora-remote-media-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="MediaObject">

  <div class="social-sharing-buttons">
    <div class="social-title">Share This Object:</div>
    <?php print $variables['facebook_button']; ?>
    <?php print $variables['twitter_button']; ?>
  </div>

  <div class="islandora-remote-media-content-wrapper clearfix">
    <?php if ($islandora_content): ?>
      <div class="islandora-remote-media-content">
        <?php print $islandora_content; ?>
      </div>
    <?php endif; ?>
    <div class="islandora-basic-image-description">
       <?php print $variables['description']; ?>
   </div>
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

  <div class="islandora-remote-media-metadata">
    <?php print $metadata; ?>
  </div>
</div>
