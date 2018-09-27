; Run this from within sites/all directory:
; drush make --yes --no-core 

; Core version
core = 7.x

; API should always be 2
api = 2

; Islandora Modules for pld
; Defaults for all Islandora Modules
defaults[projects][type] = "module"
defaults[projects][download][type] = "git"
defaults[projects][download][overwrite] = TRUE
defaults[projects][subdir] = "islandora"

; Islandora Modules to download - pulled from project github repos
projects[islandora_mods_display][download][url] = "https://github.com/jyobb/islandora_mods_display"
projects[islandora_compound_batch][download][url] = "https://github.com/MarcusBarnes/islandora_compound_batch"
projects[islandora_datastream_crud][download][url] = "https://github.com/SFULibrary/islandora_datastream_crud"
projects[islandora_context][download][url] = "https://github.com/SFULibrary/islandora_context"
projects[islandora_web_annotations][download][url] = "https://github.com/digitalutsc/islandora_web_annotations"
projects[dgi_islandora_solr_views_field_filter][download][url] = "https://github.com/discoverygarden/dgi_islandora_solr_views_field_filter"