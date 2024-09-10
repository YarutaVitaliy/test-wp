<?php

// Include additional PHP files
require get_template_directory() . '/CPT.php';
require get_template_directory() . '/shortcodes.php';

// Enqueue styles and scripts
function album_theme_enqueue_assets() {
    // Enqueue theme styles
    wp_enqueue_style('album-theme-style', get_stylesheet_uri());

    // Enqueue jQuery and custom script
    wp_enqueue_script('jquery'); // Ensure jQuery is loaded
    wp_enqueue_script('custom-ajax-script', get_template_directory_uri() . '/js/custom-ajax.js', array('jquery'), null, true);

    // Pass ajax_url to script.js
    wp_localize_script('custom-ajax-script', 'myAjax', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'album_theme_enqueue_assets');

// Add theme support
function theme_setup() {
    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for menus
    add_theme_support('menus');

    // Register custom navigation menus
    register_nav_menus(array(
        'primary_menu' => __('Primary Menu', 'album-theme'),
        'footer_menu' => __('Footer Menu', 'album-theme'),
    ));
}
add_action('after_setup_theme', 'theme_setup');
