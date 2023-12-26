<?php
$plugin_folder_name = reset(explode('/', str_replace(WP_PLUGIN_DIR . '/', '', __DIR__)));;

$PPATH=plugin_dir_url($plugin_folder_name).$plugin_folder_name.'/';
