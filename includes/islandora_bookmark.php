<?php

/**
 * @file
 * Theme and preprocess functions.
 */

function pld_islandora_bookmark_fedora_repository_object_form_alter(array $form, array &$form_state, $pid) {
  global $user;
  module_load_include('inc', 'islandora_bookmark', 'includes/api');

  $containing_lists = islandora_bookmark_get_bookmarks_visible_to_user($pid, $user->uid);

  $form = array(
    '#prefix' => '<div id="islandora-bookmark">',
    '#suffix' => '</div>',
  );

  if (count($containing_lists) > 0) {
    $links = array();
    foreach ($containing_lists as $key => $value) {
      $bookmark_object = islandora_bookmark_get_bookmark_by_number($value);
      $links[] = l($bookmark_object->bookmarkName, 'islandora-bookmark/listid/' . $bookmark_object->getId());
    }

    $form['islandora_bookmark']['lists'] = array(
      '#type' => 'item',
      '#prefix' => '<h3>' . t('Bookmarked in') . ':</h3>',
      '#markup' => theme('item_list', array('items' => $links)),
    );
  }

  $lists = islandora_bookmark_get_user_owned_bookmarks();
  $owned_lists = array();
  foreach ($lists as $list) {
    $owned_lists[$list->getId()] = $list->bookmarkName;
  }

  if (count($owned_lists)) {
    $temp_options = array_diff_key($owned_lists, $containing_lists);
    if (count($temp_options)) {
      $options['default'] = t('- Select @type list -', array('@type' => variable_get('islandora_bookmark_type', 'bookmark')));
      foreach ($temp_options as $key => $value) {
        $options[$key] = $value;
      }
      if (user_access('use islandora_bookmark')) {
        if (!count($containing_lists)) {
          $form['islandora_bookmark']['title'] = array(
            '#markup' => '<h3>' . t('@type', array('@type' => ucwords(variable_get('islandora_bookmark_type', 'bookmark')))) . 's:</h3>',
          );
        }
        $form['islandora_bookmark']['add_bookmarks'] = array(
          '#type' => 'select',
          '#options' => $options,
        );
        $form['islandora_bookmark']['add_button'] = array(
          '#type' => 'submit',
          '#value' => t('Add to @type', array('@type' => variable_get('islandora_bookmark_type', 'bookmark'))),
          '#ajax' => array(
            'event' => 'click',
            'callback' => 'islandora_bookmark_add_pid',
            'wrapper' => 'islandora-bookmark',
            'method' => 'replace',
          ),
        );
      }
    }
  }
  $form_state['islandora_bookmark_pid'] = $pid;

  return $form;
}

/**
 * Implements hook_preprocess_theme().
 */
function pld_preprocess_islandora_bookmark_list_columns(array &$variables) {
  $variables['column_count'] = 3;
  $list_links = theme(
    'islandora_bookmark_list_links',
    array('bookmark_id' => $variables['bookmark_id'], 'current' => 'manage')
  );
  $variables['list_links'] = drupal_render($list_links);
  drupal_add_css(drupal_get_path('module', 'islandora_bookmark') . '/css/list-columns.css');

  module_load_include('inc', 'islandora_bookmark', 'includes/api');
  $pids = islandora_bookmark_list_pids_query($variables['bookmark_id']);
  $pid_count = 0;
  foreach ($pids as $pid) {
    // Drop the PIDs into baskets corresponding to columns.
    $column = $pid_count % $variables['column_count'] + 1;
    $pid_count++;
    $variables['objects'][$column][$pid] = array();
    // Build markup for objects.
    $object_markup = &$variables['objects'][$column][$pid];
    $object = islandora_object_load($pid);
    $object_markup['image'] = islandora_datastream_access(ISLANDORA_VIEW_OBJECTS, $object['TN']) ?
      theme(
        'image',
        array('path' => url("islandora/object/$pid/datastream/TN/view"))) :
      '';
    $display_label = isset($object->label) ? $object->label : $pid;
    $object_markup['label'] = l(
      t("<strong>@display_label</strong>", array('@display_label' => $display_label)),
      "islandora/object/$pid",
      array('html' => TRUE)
    );
  }
}

/**
 * Implements theme_hook().
 */
function pld_islandora_bookmark_list_links(array &$variables) {
  $links = array('#weight' => -1);
  $module_path = drupal_get_path('module', 'islandora_bookmark');
  if ($variables['current'] != '') {
    $links['manage'] = array(
      '#markup' => l(
        t('Admin'),
        "islandora-bookmark/listid/{$variables['bookmark_id']}/manage",
        array('attributes' => array('class' => array('list-links')))
      ),
    );
  }
  if ($variables['current'] != 'islandora_bookmark_list_columns') {
    $links['islandora_bookmark_list_columns'] = array(
      '#markup' => l(
        t('View'),
        "islandora-bookmark/listid/{$variables['bookmark_id']}/view",
        array('attributes' => array('class' => array('list-links')))
      ),
    );
  }
  // This is the RSS icon link.
  $links['bookmark_rss'] = array(
    '#markup' => t('<a href="@url" download class="rss-feed-download"><i class="fas fa-rss" title="Export list as RSS"></i></a>', array('@url' => url("islandora-bookmark/listid/{$variables['bookmark_id']}/rss"))),
    '#prefix' => '<div id="islandora-bookmark-rss-format">',
    '#suffix' => '</div>',
  );
  drupal_add_css($module_path . '/css/list-links.css');
  return $links;
}

/**
 * Prepares variables for islandora_bookmark_list_info templates.
 *
 * Default template: islandora-bookmark-list-info.tpl.php.
 *
 * @param array $variables
 *   An associative array containing:
 *   - bookmark: A Bookmark object for which to render info.
 *   We populate:
 *   - user: The owner's name.
 *   - name: The name of the list.
 *   - description: The "description" value associated with the list.
 *   - link: An absolute URL to the current path.
 */
function pld_preprocess_islandora_bookmark_list_info(array &$variables) {
  $variables['name'] = $variables['bookmark']->bookmarkName;
  $owner = user_load($variables['bookmark']->bookmarkOwner);
  $variables['user'] = $owner->name;
  $variables['description'] = $variables['bookmark']->bookmarkDescription;
  $variables['link'] = url(current_path(), array('absolute' => TRUE));
}

/**
 * Wrapper to display a view of a bookmark.
 *
 * @param string $list_id
 *   A string representing a bookmark object.
 *
 * @return string
 *   The HTML to be rendered for the list columns.
 */
function pld_view_bookmark($list_id) {
  return theme('islandora_bookmark_list_columns', array('bookmark_id' => $list_id));
}

?>