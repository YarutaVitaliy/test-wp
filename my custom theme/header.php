<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(' | ', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="container">
        <div class="site-title">
            <h1><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
            <p><?php bloginfo('description'); ?></p>
        </div>
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary_menu', // Make sure this matches the registered location
                'container' => false, // To avoid wrapping the menu in a <div> or <nav> tag
                'menu_class' => 'primary-menu', // Class for the <ul> tag
                'fallback_cb' => false, // Avoid showing fallback if no menu is assigned
            ));
            ?>
        </nav>
    </div>

</header>
