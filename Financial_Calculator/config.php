<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get the plugin folder name dynamically.
$plugin_folder_name = basename( dirname( __DIR__ ) );

// Construct the plugin URL path.
$PPATH = plugin_dir_url( __DIR__ ) . $plugin_folder_name . '/';
