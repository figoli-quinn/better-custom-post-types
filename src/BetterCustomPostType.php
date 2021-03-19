<?php

namespace FigoliQuinn\BetterCustomPostTypes;

use WP_Post;

if (!defined('ABSPATH')) exit;

class BetterCustomPostType 
{
    protected $id;
    protected $wp_post;
    protected $wp_meta = [];
    protected $slug;
    protected $name;
    protected $plural_name;
    protected $supports            = ['title', 'thumbnail', 'editor'];
    protected $public              = true;
    protected $publicly_queryable  = true;
    protected $exclude_from_search = false;
    protected $menu_position       = 5;
    protected $show_in_menu        = '';
    protected $has_archive         = true;

    public function __construct()
    {
        $this->plural_name = $this->plural_name ?? $this->pluralize( $this->name );

        if ( ! empty( $this->id ) && is_plugin_active( 'ewp-query/wp-query.php' ) ) {
            $this->load_post();
        }

        $this->register_wp_hooks();
    }

    public function custom_admin_column_headers( array $columns ) : array 
    {
        return $columns;
    }

    public function custom_admin_column_value( string $column, int $post_id ): void 
    {
        return;
    }

    public function save_post( int $post_id ): void 
    {
        return;
    }

    public static function query()
    {
        if ( ! is_plugin_active( 'ewp-query/wp-query.php' ) ) {
            return;
        }

        $cpt = new self;
        return new \FigoliQuinn\EWPQuery\EWP_Query( $cpt->slug );
    }

    public function post(): WP_Post
    {
        return $this->wp_post;
    }

    public function meta(): array 
    {
        return $this->wp_meta;
    }

    public function register_cpt(): void
    {
        if ( ! empty( $this->id ) ) {
            return;
        }

        register_post_type( $this->slug, [
            'labels'              => $this->generate_labels(),
            'description'         => "Holds {$this->plural_name}",
            'public'              => $this->public,
            'publicly_queryable'  => $this->publicly_queryable,
            'exclude_from_search' => $this->exclude_from_search,
            'menu_position'       => $this->menu_position,
            'supports'            => $this->supports,
            'has_archive'         => $this->has_archive,
            'show_in_menu'        => $this->show_in_menu,
        ]);
    }

    protected function register_wp_hooks(): void
    {
        add_action( 'init', [ $this, 'register_cpt'] );
        add_action( 'manage_edit-' . $this->slug . '_columns', [ $this, 'custom_admin_column_headers' ] );
        add_action( 'manage_' . $this->slug . '_posts_custom_column', [ $this, 'custom_admin_column_value' ], 10, 2 );
        add_action( 'save_post', [ $this, 'save_post' ], 10, 1 );
    }

    protected function pluralize( string $text ): string
    {
        return "{$text}s";
    }

    protected function generate_labels(): array
    {
        return [
            'name'               => _x( $this->name, 'post type general name' ),
            'singular_name'      => _x( $this->name, 'post type singular name' ),
            'add_new'            => _x( 'Add New', 'post type add' ),
            'add_new_item'       => __( "Add New {$this->name}" ),
            'edit_item'          => __( "Edit {$this->name}" ),
            'new_item'           => __( "New {$this->name}" ),
            'all_items'          => __( "All {$this->plural_name}" ),
            'view_item'          => __( "View {$this->name}" ),
            'search_items'       => __( "Search {$this->plural_name}" ),
            'not_found'          => __( "No {$this->plural_name} found" ),
            'not_found_in_trash' => __( "No {$this->plural_name} found in the Trash" ),
            'parent_item_colon'  => '',
            'menu_name'          => $this->plural_name,
        ];
    }

    protected function load_post(): void
    {
        $post = (new \FigoliQuinn\EWPQuery\EWP_Query($this->slug))->first();

        if ( ! empty( $post ) ) {
            $this->post = $post;
        }
    }
}