<?php
class bundlesPostType
{

    // Constructor to initialize hooks
    public function __construct()
    {
        add_action('init', array($this, 'registerBundlesPostType'));
        add_action('init', array($this, 'registerBundleCategoriesTaxonomy'));
    }

    // Method to register the Bundles custom post type
    public function registerBundlesPostType()
    {
        $labels = array(
            'name' => _x('Bundles', 'Post Type General Name', 'text_domain'),
            'singular_name' => _x('Bundle', 'Post Type Singular Name', 'text_domain'),
            'menu_name' => __('Bundles', 'text_domain'),
            'name_admin_bar' => __('Bundle', 'text_domain'),
            'archives' => __('Bundle Archives', 'text_domain'),
            'attributes' => __('Bundle Attributes', 'text_domain'),
            'parent_item_colon' => __('Parent Bundle:', 'text_domain'),
            'all_items' => __('All Bundles', 'text_domain'),
            'add_new_item' => __('Add New Bundle', 'text_domain'),
            'add_new' => __('Add New', 'text_domain'),
            'new_item' => __('New Bundle', 'text_domain'),
            'edit_item' => __('Edit Bundle', 'text_domain'),
            'update_item' => __('Update Bundle', 'text_domain'),
            'view_item' => __('View Bundle', 'text_domain'),
            'view_items' => __('View Bundles', 'text_domain'),
            'search_items' => __('Search Bundle', 'text_domain'),
            'not_found' => __('Not found', 'text_domain'),
            'not_found_in_trash' => __('Not found in Trash', 'text_domain'),
            'featured_image' => __('Featured Image', 'text_domain'),
            'set_featured_image' => __('Set featured image', 'text_domain'),
            'remove_featured_image' => __('Remove featured image', 'text_domain'),
            'use_featured_image' => __('Use as featured image', 'text_domain'),
            'insert_into_item' => __('Insert into Bundle', 'text_domain'),
            'uploaded_to_this_item' => __('Uploaded to this Bundle', 'text_domain'),
            'items_list' => __('Bundles list', 'text_domain'),
            'items_list_navigation' => __('Bundles list navigation', 'text_domain'),
            'filter_items_list' => __('Filter Bundles list', 'text_domain'),
        );

        $args = array(
            'label' => __('Bundle', 'text_domain'),
            'description' => __('Post Type Description', 'text_domain'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('bundle_cat'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-list-view',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );

        register_post_type('bundles', $args);
    }

    // Method to register the Bundle Categories custom taxonomy
    public function registerBundleCategoriesTaxonomy()
    {
        $labels = array(
            'name' => _x('Bundle Categories', 'Taxonomy General Name', 'text_domain'),
            'singular_name' => _x('Bundle Category', 'Taxonomy Singular Name', 'text_domain'),
            'menu_name' => __('Bundle Category', 'text_domain'),
            'all_items' => __('All Bundle Categories', 'text_domain'),
            'parent_item' => __('Parent Bundle Category', 'text_domain'),
            'parent_item_colon' => __('Parent Bundle Category:', 'text_domain'),
            'new_item_name' => __('New Bundle Category Name', 'text_domain'),
            'add_new_item' => __('Add New Bundle Category', 'text_domain'),
            'edit_item' => __('Edit Bundle Category', 'text_domain'),
            'update_item' => __('Update Bundle Category', 'text_domain'),
            'view_item' => __('View Bundle Category', 'text_domain'),
            'separate_items_with_commas' => __('Separate Bundle Categories with commas', 'text_domain'),
            'add_or_remove_items' => __('Add or remove Bundle Categories', 'text_domain'),
            'choose_from_most_used' => __('Choose from the most used', 'text_domain'),
            'popular_items' => __('Popular Bundle Categories', 'text_domain'),
            'search_items' => __('Search Bundle Categories', 'text_domain'),
            'not_found' => __('Not Found', 'text_domain'),
            'no_terms' => __('No items', 'text_domain'),
            'items_list' => __('Bundle Categories list', 'text_domain'),
            'items_list_navigation' => __('Bundle Categories list navigation', 'text_domain'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        );

        register_taxonomy('bundle_cat', array('bundles'), $args);
    }
}

// Instantiate the class to register hooks
new bundlesPostType();
