<?php

// Register Custom Post Type and Taxonomy
function album_custom_post_type_and_taxonomy() {
    // Labels for Custom Post Type "Album"
    $album_labels = [
        'name' => __('Albums', 'album-theme'),
        'singular_name' => __('Album', 'album-theme'),
        'add_new' => __('Add New Album', 'album-theme'),
        'all_items' => __('All Albums', 'album-theme'),
        'edit_item' => __('Edit Album', 'album-theme'),
        'new_item' => __('New Album', 'album-theme'),
        'view_item' => __('View Album', 'album-theme'),
    ];

    // Arguments for Custom Post Type "Album"
    $album_args = [
        'labels' => $album_labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'albums'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ];

    // Register Custom Post Type "Album"
    register_post_type('album', $album_args);

    // Labels for Custom Taxonomy "Singles"
    $singles_labels = [
        'name' => __('Singles', 'album-theme'),
        'singular_name' => __('Single', 'album-theme'),
        'search_items' => __('Search Singles', 'album-theme'),
        'all_items' => __('All Singles', 'album-theme'),
        'parent_item' => __('Parent Single', 'album-theme'),
        'parent_item_colon' => __('Parent Single:', 'album-theme'),
        'edit_item' => __('Edit Single', 'album-theme'),
        'update_item' => __('Update Single', 'album-theme'),
        'add_new_item' => __('Add New Single', 'album-theme'),
        'new_item_name' => __('New Single Name', 'album-theme'),
        'menu_name' => __('Singles', 'album-theme'),
    ];

    // Arguments for Custom Taxonomy "Singles"
    $singles_args = [
        'hierarchical' => true,
        'labels' => $singles_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'singles'],
    ];

    // Register Custom Taxonomy "Singles"
    register_taxonomy('singles', ['album'], $singles_args);
}

add_action('init', 'album_custom_post_type_and_taxonomy');
