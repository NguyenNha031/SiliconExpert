<?php

function designtheme_setup()
{

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    register_nav_menus([
        'primary' => __('Primary Menu', 'design-theme'),
    ]);
}
add_action('after_setup_theme', 'designtheme_setup');
