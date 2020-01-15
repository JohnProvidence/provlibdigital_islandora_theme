#! /bin/bash

#
# Installer script for Islandora modules unique to ProvLib Digital. Based off of installer scripts from ISLE isle_drupal_build_tools
#

cd /var/www/html/ || exit

echo "Installing Islandora Modules specific to ProvLibDigital"
drush make --no-core /var/www/html/pld_install_helper/pld-drush_make/pld.islandora.make 
echo "SetEnvIf X-Forwarded-Proto https HTTPS=on" | tee -a /tmp/drupal_install/.htaccess

echo "Enabling PLD Islandora Modules"

drush -y -u 1 en islandora_mods_display
echo "Islandora Mods Display module has been enabled."
drush -y -u 1 en islandora_compound_batch
echo "Islandora Compound Batch module has been enabled."
drush -y -u 1 en islandora_datastream_crud
echo "Islandora Datastream Crud module has been enabled."
drush -y -u 1 en islandora_web_annotations
echo "Islandora Web Annotations Module has been enabled."
drush -y -u 1 en dgi_islandora_solr_views_field_filter
echo "Islandora Solr Views Field Filter has been enabled."

echo "All done with modules. Adding ProvLibDigital Theme."

cd /var/www/html/sites/all/themes






