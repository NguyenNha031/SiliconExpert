<?php
add_action('acf/init', function () {

    if (!function_exists('acf_register_block_type')) {
        return;
    }

    // ===== RANKED FEATURES =====
    acf_register_block_type([
        'name' => 'ranked-features',
        'title' => __('Ranked Features', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/ranked-features/render.php',
        'category' => 'theme',
        'icon' => 'chart-line',
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

    // ===== FEATURE CALLOUT =====
    acf_register_block_type([
        'name' => 'feature-callout',
        'title' => __('Feature Callout', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/feature-callout/render.php',
        'category' => 'theme',
        'icon' => 'slides',
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

    // ===== VIDEO BACKGROUND =====
    acf_register_block_type([
        'name' => 'video-background-wrapper',
        'title' => __('Video Background Wrapper', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/video-background-wrapper/render.php',
        'category' => 'theme',
        'icon' => 'format-video',
        'supports' => [
            'jsx' => true,
            'align' => ['wide', 'full'],
        ],
    ]);

    // ===== INSIGHTS =====
    acf_register_block_type([
        'name' => 'insights-resources',
        'title' => __('Insights & Resources', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/insights-resources/render.php',
        'category' => 'theme',
        'icon' => 'analytics',
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

    //  ===== LOGO SLIDER  =====
    acf_register_block_type([
        'name' => 'logo-slider',
        'title' => __('Logo Slider', 'design-theme'),
        'description' => __('Slider logo đối tác', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/logo-slider/render.php',
        'category' => 'theme',
        'icon' => 'images-alt2',
        'keywords' => ['logo', 'slider', 'partner'],
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

    // ===== TESTIMONIAL SLIDER =====
    acf_register_block_type([
        'name' => 'testimonial-slider',
        'title' => __('Testimonial Slider', 'design-theme'),
        'description' => __('Khối testimonial dạng slider có indicator', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/testimonial-slider/render.php',
        'category' => 'theme',
        'icon' => 'format-quote',
        'keywords' => ['testimonial', 'quote', 'slider'],
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

    // ===== SPLIT HOVER PANEL =====
    acf_register_block_type([
        'name' => 'split-hover-panel',
        'title' => __('Split Hover Panel', 'design-theme'),
        'description' => __('Block chia 2 panel, hover mở rộng', 'design-theme'),
        'render_template' => get_template_directory() . '/acf-blocks/split-hover-panel/render.php',
        'category' => 'theme',
        'icon' => 'columns',
        'keywords' => ['split', 'hover', 'panel', 'cta'],
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

});
