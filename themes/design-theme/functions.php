<?php
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/views.php';
require_once get_template_directory() . '/inc/acf.php';
require_once get_template_directory() . '/inc/related-posts.php';
require_once get_template_directory() . '/inc/split-hover-panel.php';
require_once get_template_directory() . '/inc/ajax-resources.php';


add_filter('show_admin_bar', '__return_false');
add_action('acf/init', function () {

    acf_register_block_type([
        'name' => 'content-cta',
        'title' => 'Content + CTA',
        'description' => 'Khối nội dung giới thiệu kèm nút CTA',
        'render_template' => get_template_directory() . '/acf-blocks/content-cta/render.php',
        'category' => 'theme',
        'icon' => 'megaphone',
        'keywords' => ['content', 'cta'],
        'supports' => [
            'align' => ['wide', 'full'],
        ],
    ]);

});
add_action('wp_footer', function () {
    if (is_single()) {
        ?>
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <?php
    }
});


