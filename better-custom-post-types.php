<?php 
/*
  Plugin Name: Better Custom Post Types
  Author: Figoli Quinn & Associates
  Description: Helper for registering custom post types.
  Version: 1.0
*/

use FigoliQuinn\BetterCustomPostTypes\WPUpdater;

if ( !defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/vendor/autoload.php';

if ( is_plugin_active( 'wp-update-from-github/wp-update-from-github.php' ) ) {
    // Allow updating from github repository.
    new WPUpdater;
}