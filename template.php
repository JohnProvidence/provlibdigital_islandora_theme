<?php
/**
 * Override or insert variables into the page templates.
 *
 * @param array $variables
 *   Variables to pass to the theme template.
 * @param string $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function pld_preprocess_page(&$variables, $hook) {
  $variables['library_name'] = t('Providence Public Library');
  $variables['dc'] = t('Digital Collections');
}

require('includes/islandora_collections.php');
require('includes/islandora_solr_search.php');
require('includes/islandora_basic_image.php');
require('includes/islandora_compound.php');
require('includes/islandora_bookmark.php');
require('includes/islandora_book.php');
require('includes/islandora_breadcrumb.php');

?>