<?php

namespace FigoliQuinn\BetterCustomPostTypes;

if (!defined('ABSPATH')) exit;

require_once( ABSPATH . 'wp-content/plugins/wp-update-from-github/vendor/autoload.php' );
use FigoliQuinn\WPUpdateFromGithub\WPUpdateFromGithub;

class WPUpdater 
{

    public function __construct()
    {
        add_action( 'init', [ $this, 'register_github_updating' ] );
    }

    public function register_github_updating()
    {
        if ( ! is_plugin_active( 'wp-update-from-github/wp-update-from-github.php' ) ) {
            return;
        }

        new WPUpdateFromGithub( 'figoli-quinn/better-custom-post-types', __DIR__ . '/../better-custom-post-types.php', 'better-custom-post-types' );
    }
}