<?php

function designtheme_setup()
{

    // Hỗ trợ title
    add_theme_support('title-tag');

    // Hỗ trợ thumbnail
    add_theme_support('post-thumbnails');

    // 🔥 ĐĂNG KÝ MENU (QUAN TRỌNG)
    register_nav_menus([
        'primary' => __('Primary Menu', 'design-theme'),
    ]);
}

add_action('after_setup_theme', 'designtheme_setup');
