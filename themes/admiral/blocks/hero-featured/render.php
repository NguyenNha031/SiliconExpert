<?php
if (!empty($attributes['hideBlock'])) {
    return;
}
//Khởi tạo cấu hình block từ attributes
$label = $attributes['label'] ?? '';
$sort_by = $attributes['sortBy'] ?? 'date_desc';
$show_category = $attributes['showCategory'] ?? true;
$show_date = $attributes['showDate'] ?? true;
$show_views = $attributes['showViews'] ?? true;
$excerpt_length = $attributes['excerptLength'] ?? 25;
$source = $attributes['sourceType'] ?? 'category';
$selected_categories = $attributes['selectedCategories'] ?? [];
$selected_tags = $attributes['selectedTags'] ?? [];
$layout = $attributes['layoutType'] ?? 'slider';

// GHIM NHIỀU BÀI VIẾT (PINNED POSTS)
$pinned_posts = isset($attributes['pinnedPosts'])
    ? array_map('intval', $attributes['pinnedPosts'])
    : [];
$max_pinned = 6;
$pinned_posts = array_slice($pinned_posts, 0, $max_pinned);

// Lấy object bài ghim theo đúng thứ tự
$pinned_objects = [];
if (!empty($pinned_posts)) {
    $pinned_objects = get_posts([
        'post_type' => 'post',
        'post__in' => $pinned_posts,
        'orderby' => 'post__in',
    ]);
}

// Hàm kiểm tra bài có được ghim không
$is_pinned = function ($post_id) use ($pinned_posts) {
    return in_array(intval($post_id), $pinned_posts, true);
};

//   TÍNH SỐ BÀI CẦN QUERY THÊM
if ($layout === 'hero-grid') {
    $posts_to_show = 4;
} elseif ($layout === 'grid-6') {
    $posts_to_show = max(0, 6 - count($pinned_posts));
} else { // slider
    $max_posts = $attributes['postsToShow'] ?? 5;
    $posts_to_show = max(0, $max_posts - count($pinned_posts));
}

//   TẠO QUERY ARGUMENTS
$args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_to_show,
    'post__not_in' => $pinned_posts,
];
//   FILTERING THEO CATEGORY
if ($source === 'category' && !empty($selected_categories)) {
    $args['category__in'] = array_map('intval', $selected_categories);
}
//   FILTERING THEO TAG
if ($source === 'tag' && !empty($selected_tags)) {
    $args['tax_query'][] = [
        'taxonomy' => 'post_tag',
        'field' => 'term_id',
        'terms' => array_map('intval', $selected_tags),
        'operator' => 'IN',
    ];
}

//   SORTING
switch ($sort_by) {
    case 'date_asc':
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
        break;
    case 'views_desc':
        $args['meta_key'] = 'wp2025_post_views';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        break;
    case 'views_asc':
        $args['meta_key'] = 'wp2025_post_views';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        break;
    case 'title_asc':
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
        break;
    case 'title_desc':
        $args['orderby'] = 'title';
        $args['order'] = 'DESC';
        break;
    case 'date_desc':
    default:
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        break;
}
$query = new WP_Query($args);
// Nếu không có bài viết nào
if (!$query->have_posts()) {
    echo "<p class='hero-empty'>Chưa có bài viết phù hợp.</p>";
    return;
}
// Gộp bài ghim + bài thường
$posts = array_merge($pinned_objects, $query->posts);

wp_reset_postdata();

// Render theo layout
switch ($layout) {
    case 'hero-grid':
        $hero_posts = $posts;
        include __DIR__ . '/layout-hero-grid.php';
        return;
    case 'grid-6':
        $grid6_posts = $posts;
        include __DIR__ . '/layout-grid-6.php';
        return;
    case 'magazine-hero':
        $mag_posts = $posts;
        include __DIR__ . '/layout-magazine-hero.php';
        return;
}

?>
<!-- Label  -->
<div class="hero-slider-label vnep-block-label" style="
        margin-top: 10px;
        background: <?php echo esc_attr($attributes['labelBgColor'] ?? '#d33'); ?>;
        color: <?php echo esc_attr($attributes['labelTextColor'] ?? '#fff'); ?>;
        font-size: <?php echo intval($attributes['labelFontSize'] ?? 16); ?>px;
        font-weight: <?php echo esc_attr($attributes['labelFontWeight'] ?? '600'); ?>;
     ">
    <?php echo esc_html($label); ?>
</div>
<!-- Slider -->
<div class="hero-slider swiper-container" data-autoplay="<?php echo !empty($attributes['autoplay']) ? '1' : '0'; ?>">
    <div class="swiper-wrapper">

        <?php foreach ($posts as $p):
            setup_postdata($p);
            // Lấy ảnh bài viết: thumbnail → ảnh trong content → fallback
            $thumb = get_the_post_thumbnail_url($p->ID, 'large');
            if (!$thumb)
                $thumb = get_first_image_in_content($p->ID);
            if (!$thumb)
                $thumb = get_stylesheet_directory_uri() . "/fallback.jpg";

            // Lấy danh mục chính
            $cat = get_the_category($p->ID);
            $cat_name = $cat ? $cat[0]->name : "";

            // Lấy lượt xem bài viết
            $views = get_post_meta($p->ID, 'wp2025_post_views', true);
            $views = $views ? intval($views) : 0;
            ?>
            <!-- Một slide tương ứng với một bài viết -->
            <div class="swiper-slide hero-featured-block">
                <!-- Hiển thị badge nếu là bài ghim -->
                <?php if ($is_pinned($p->ID)): ?>
                    <span class="vnep-badge-pin slider">📌 Ghim</span>
                <?php endif; ?>

                <!-- Ảnh nền bài viết -->
                <a href="<?php echo get_permalink($p->ID); ?>" class="hero-image-link">
                    <div class="hero-image" style="background-image: url('<?php echo esc_url($thumb); ?>');">
                    </div>
                </a>
                <!-- Hiển thị danh mục nếu bật -->
                <?php if ($show_category && $cat_name): ?>
                    <div class="hero-category-right" style="
                        background: <?php echo esc_attr($attributes['catBgColor']); ?>;
                        color: <?php echo esc_attr($attributes['catTextColor']); ?>;
                        font-size: <?php echo intval($attributes['catFontSize']); ?>px;
                        font-weight: <?php echo esc_attr($attributes['catFontWeight']); ?>;
                    ">
                        <?php echo esc_html($cat_name); ?>
                    </div>
                <?php endif; ?>
                <!-- Nội dung bài viết -->
                <div class="hero-content">

                    <h2 class="hero-title" style="
                        color: <?php echo esc_attr($attributes['titleColor']); ?>;
                        font-size: <?php echo intval($attributes['titleFontSize']); ?>px;
                        font-weight: <?php echo esc_attr($attributes['titleFontWeight']); ?>;
                    ">
                        <?php echo esc_html(get_the_title($p->ID)); ?>
                    </h2>

                    <p class="hero-excerpt" style="
                        color: <?php echo esc_attr($attributes['excerptColor']); ?>;
                        font-size: <?php echo intval($attributes['excerptFontSize']); ?>px;
                        font-weight: <?php echo esc_attr($attributes['excerptFontWeight']); ?>;
                    ">
                        <?php echo wp_trim_words($p->post_content, $excerpt_length); ?>
                    </p>

                    <?php if ($show_date || $show_views): ?>
                        <div class="hero-meta" style="
                            color: <?php echo esc_attr($attributes['sliderMetaColor']); ?>;
                            font-size: <?php echo intval($attributes['sliderMetaSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['sliderMetaWeight']); ?>;
                        ">
                            <?php if ($show_date): ?>
                                <span>
                                    <?php echo get_the_time('j \T\há\n\g n, Y', $p->ID); ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($show_views): ?>
                                <span>👁 <?php echo $views; ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <div class="swiper-pagination"></div>
</div>

<?php wp_reset_postdata(); ?>