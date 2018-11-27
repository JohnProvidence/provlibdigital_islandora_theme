<?php
/**
 * @file
 * Contains the theme's settings form.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function pld_form_system_theme_settings_alter(&$form, &$form_state) {
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  // Create the form using Forms API: http://api.drupal.org/api/7

  $form['pld_islandora_settings'] = array(
    '#type'         => 'fieldset',
    '#title'        => t('ProvLibDigital Islandora Settings'),
    '#collapsible'  => FALSE,
    '#collapsed'    => FALSE,
  );

  $form['pld_collections_description'] = array(
    '#type'         => 'fieldset',
    '#title'        => t('Collections Description'),
    '#collapsible'  => TRUE,
    '#collapsed'    => FALSE,
  );

  $form['pld_collections_description']['pld_collections_description_text'] = array(
    '#type'         => 'textarea',
    '#title'        => t('Description Text'),
    '#description'  => t('Provide text that describes the collections in the repository'),
    '#default_value'  => theme_get_setting('pld_collections_description_text'),
  );
 
  $form['pld_social_media_links'] = array(
   '#type'          => 'fieldset',
   '#title'         => t('Social Media Accounts'),
   '#collapsible'   => TRUE,
   '#collapsed'     => FALSE,
  );

  $form['pld_social_media_links']['pld_social_media_links_spc_twitter'] = array(
    '#type'         => 'textfield',
    '#title'        => t('Special Collections Twitter URL'),
    '#description'  => t('Enter the Special Collections Twitter URL to display a link'),
    '#default_value'  => theme_get_setting('pld_social_media_links_spc_twitter'),
  );

  $form['pld_social_media_links']['pld_social_media_links_rc_instagram'] = array(
    '#type'         => 'textfield',
    '#title'        => t('Rhode Island Collections Instagram URL'),
    '#description'  => t('Enter the Rhode Island Collections Instagram URL to display a link'),
    '#default_value'  => theme_get_setting('pld_social_media_links_rc_instagram'),
  );

  $form['terms_services'] = array(
    '#type'       => 'fieldset',
    '#title'      => t('Terms and Services Pages'),
    '#collapsible'  => TRUE,
    '#collapsed'    => FALSE,
  );

  $form['terms_services']['terms'] = array(
    '#type'       => 'textfield',
    '#title'      => t('Terms and Services Page'),
    '#description'  => t('Enter the URL for a page listing the terms and services for this site.'),
    '#default_value'  => theme_get_setting('terms'),
  );

  $form['terms_services']['legal_notices'] = array(
    '#type' => 'textfield',
    '#title'  => t('Legal Notices and Policies page'),
    '#description'  => t('Enter the URL for a page listing any legal notices and policies for this site.'),
    '#defaul_value' => theme_get_setting('legal_notices'),
  );

   
  // We don't need breadcrumbs to be configured on this site.
  unset($form['breadcrumb']);
  // 

  // We are editing the $form in place, so we don't need to return anything.
}
