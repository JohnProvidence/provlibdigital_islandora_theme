<?php
/**
* overrides display of breadcrumbs
*/

function pld_breadcrumb($variables) {

$breadcrumb = $variables['breadcrumb'];
$fedora_substr = 'info:fedora/islandora:';

// remove 'Home'
if (is_array($breadcrumb)) {
    array_shift($breadcrumb);
 }
if (!empty($breadcrumb)) {
    $breadcrumb_separator = ' <span class="separator"> | </span>';
    $breadcrumb_str = implode($breadcrumb_separator, $breadcrumb);
    $breadcrumb_str .= $breadcrumb_separator;
    $breadcrumb_str = str_replace('<a href="/islandora">Islandora Repository</a>','<a href="/islandora/">Digital Collections</a>',$breadcrumb_str);

    $out = '<div class="breadcrumb">' . $breadcrumb_str . '</div>';
    return $out;
  }
  return '';

}



?>