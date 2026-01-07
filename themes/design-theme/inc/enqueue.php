<?php
add_action('wp_enqueue_scripts', function () {
    if (is_admin()) {
        return;
    }

    $css_path = get_template_directory() . '/assets/css/output.css';
    $js_path = get_template_directory() . '/assets/js/main.js';

    wp_enqueue_style(
        'design-theme-tailwind',
        get_template_directory_uri() . '/assets/css/output.css',
        [],
        file_exists($css_path) ? filemtime($css_path) : null
    );

    wp_enqueue_script(
        'design-theme-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        file_exists($js_path) ? filemtime($js_path) : null,
        true
    );
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    wp_enqueue_script(
        'resources-ajax',
        get_template_directory_uri() . '/assets/js/resources-ajax.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('resources-ajax', 'RESOURCES_AJAX', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);


});
