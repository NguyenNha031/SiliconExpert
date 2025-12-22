<?php
/**
 * Layout Hero + Grid 3 (hỗ trợ pinned post)
 */

if (empty($hero_posts) || !is_array($hero_posts)) {
    return;
}

/*  HERO POST  */
$hero_post = $hero_posts[0] ?? null;
if (!$hero_post)
    return;

setup_postdata($hero_post);

//  HERO THUMB
$thumb = get_the_post_thumbnail_url($hero_post->ID, 'large');
if (!$thumb)
    $thumb = get_first_image_in_content($hero_post->ID);
if (!$thumb)
    $thumb = get_stylesheet_directory_uri() . "/fallback.jpg";

//HERO META
$category = get_the_category($hero_post->ID);
$cat_name = $category ? $category[0]->name : "";
$time_ago = human_time_diff(get_the_time('U', $hero_post->ID), current_time('timestamp')) . " trước";
$post_views = intval(get_post_meta($hero_post->ID, 'wp2025_post_views', true));

/*  STYLE VARS  */
$heroCatColor = $attributes['heroCatColor'] ?? '#ff5d5d';
$heroCatSize = $attributes['heroCatSize'] ?? 34;
$heroTitleColor = $attributes['heroTitleColor'] ?? '#f3f3f3';
$heroTitleSize = $attributes['heroTitleSize'] ?? 28;
$heroMetaColor = $attributes['heroMetaColor'] ?? '#adadad';
$heroMetaSize = $attributes['heroMetaSize'] ?? 18;

$gridCatColor = $attributes['heroGridCatColor'] ?? '#ff6666';
$gridCatSize = $attributes['heroGridCatSize'] ?? 17;
$gridMetaColor = $attributes['heroGridMetaColor'] ?? '#adadad';
$gridMetaSize = $attributes['heroGridMetaSize'] ?? 18;
$gridTitleColor = $attributes['heroGridTitleColor'] ?? '#5d5c5c';
$gridTitleSize = $attributes['heroGridTitleSize'] ?? 18;

$show_category = !empty($attributes['showCategory']);
$show_date = !empty($attributes['showDate']);
$show_views = !empty($attributes['showViews']);

$limit_grid_title = !empty($attributes['limitGridTitleLines']);
$grid_title_lines = intval($attributes['gridTitleLineClamp'] ?? 2);

$gridBg = $attributes['heroGridCardBg'] ?? 'rgba(49,45,45,0.06)';
$fallback_thumb = get_stylesheet_directory_uri() . '/fallback.jpg';

/* GRID POSTS  */
// Lấy 3 bài tiếp theo sau HERO
$real_posts = array_slice($hero_posts, 1, 3);
$missing = 3 - count($real_posts);

// Thông báo thiếu bài
$source_type = $attributes['sourceType'] ?? 'category';
$empty_message = $source_type === 'tag'
    ? 'Tag này chưa có đủ bài viết'
    : 'Chuyên mục này chưa có đủ bài viết';
?>

<?php if (!empty($label)): ?>
    <div class="vnep-block-label py-1.5 px-3.5 inline-block mb-4" style="
        background: <?php echo esc_attr($attributes['labelBgColor']); ?>;
        color: <?php echo esc_attr($attributes['labelTextColor']); ?>;
        font-size: <?php echo intval($attributes['labelFontSize']); ?>px;
        font-weight: <?php echo esc_attr($attributes['labelFontWeight'] ?? '600'); ?>;
    ">
        <?php echo esc_html($label); ?>
    </div>
<?php endif; ?>

<div class="vnep-hero-grid">

    <!--  HERO -->
    <a href="<?php echo get_permalink($hero_post->ID); ?>" class="vnep-hero"
        style="background-image:url('<?php echo esc_url($thumb); ?>');">
        <?php if ($is_pinned($hero_post->ID)): ?>
            <span class="vnep-badge-pin hero">📌 Ghim</span>
        <?php endif; ?>

        <div class="vnep-hero-content">

            <?php if ($show_category && $cat_name): ?>
                <span class="vnep-cat" style="
                    color: <?php echo esc_attr($heroCatColor); ?>;
                    font-size: <?php echo intval($heroCatSize); ?>px;
                    font-weight: <?php echo esc_attr($attributes['heroCatWeight'] ?? '600'); ?>;
                ">
                    <?php echo esc_html($cat_name); ?>
                </span>
            <?php endif; ?>

            <h2 class="vnep-hero-title" style="
                color: <?php echo esc_attr($heroTitleColor); ?>;
                font-size: <?php echo intval($heroTitleSize); ?>px;
                font-weight: <?php echo esc_attr($attributes['heroTitleWeight'] ?? '700'); ?>;
            ">
                <?php echo esc_html(get_the_title($hero_post->ID)); ?>
            </h2>

            <?php if ($show_date || $show_views): ?>
                <div class="vnep-hero-meta" style="
                    color: <?php echo esc_attr($heroMetaColor); ?>;
                    font-size: <?php echo intval($heroMetaSize); ?>px;
                    font-weight: <?php echo esc_attr($attributes['heroMetaWeight'] ?? '400'); ?>;
                ">
                    <?php if ($show_date): ?>
                        <span><?php echo esc_html($time_ago); ?></span>
                    <?php endif; ?>
                    <?php if ($show_views): ?>
                        <span>👁 <?php echo intval($post_views); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </a>

    <!-- GRID 3 -->
    <div class="vnep-list">

        <?php foreach ($real_posts as $post):
            setup_postdata($post);

            $thumb = get_the_post_thumbnail_url($post->ID, 'medium');
            if (!$thumb)
                $thumb = get_first_image_in_content($post->ID);
            if (!$thumb)
                $thumb = $fallback_thumb;

            $category = get_the_category($post->ID);
            $cat_name = $category ? $category[0]->name : "";
            $views = intval(get_post_meta($post->ID, 'wp2025_post_views', true));
            ?>

            <a href="<?php echo get_permalink($post->ID); ?>" class="vnep-card"
                style="background: <?php echo esc_attr($gridBg); ?>;">
                <?php if ($is_pinned($post->ID)): ?>
                    <span class="vnep-badge-pin card">📌 Ghim</span>
                <?php endif; ?>

                <img class="vnep-thumb" style="height:200px" src="<?php echo esc_url($thumb); ?>" alt="">

                <div class="vnep-card-info">

                    <?php if ($show_category && $cat_name): ?>
                        <span class="vnep-cat-small" style="
                            color: <?php echo esc_attr($gridCatColor); ?>;
                            font-size: <?php echo intval($gridCatSize); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroGridCatWeight'] ?? '600'); ?>;
                        ">
                            <?php echo esc_html($cat_name); ?>
                        </span>
                    <?php endif; ?>

                    <?php if ($show_date || $show_views): ?>
                        <div class="vnep-card-meta" style="
                            color: <?php echo esc_attr($gridMetaColor); ?>;
                            font-size: <?php echo intval($gridMetaSize); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroGridMetaWeight'] ?? '400'); ?>;
                            margin-top:4px;
                        ">
                            <?php if ($show_date): ?>
                                <span><?php echo esc_html(get_the_date('', $post)); ?></span>
                            <?php endif; ?>
                            <?php if ($show_views): ?>
                                <span>👁 <?php echo intval($views); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <h3 class="vnep-card-title" style="
                        color: <?php echo esc_attr($gridTitleColor); ?>;
                        font-size: <?php echo intval($gridTitleSize); ?>px;
                        font-weight: <?php echo esc_attr($attributes['heroGridTitleWeight'] ?? '600'); ?>;
                        <?php if ($limit_grid_title): ?>
                            display:-webkit-box;
                            -webkit-line-clamp:<?php echo intval($grid_title_lines); ?>;
                            -webkit-box-orient:vertical;
                            overflow:hidden;
                        <?php endif; ?>
                    ">
                        <?php echo esc_html(get_the_title($post->ID)); ?>
                    </h3>

                </div>
            </a>

        <?php endforeach;
        wp_reset_postdata(); ?>

        <!--FALLBACK CARD -->
        <?php for ($i = 0; $i < $missing; $i++): ?>
            <div class="vnep-card vnep-card-empty"
                style="background: <?php echo esc_attr($gridBg); ?>; pointer-events:none;">
                <img class="vnep-thumb" style="height:200px" src="<?php echo esc_url($fallback_thumb); ?>" alt="">
                <div class="vnep-card-info">
                    <span style="color:#999;font-size:14px;font-weight:600;">Thông báo</span>
                    <h3
                        style="color:#666;font-size:<?php echo intval($gridTitleSize); ?>px;font-weight:500;margin-top:6px;">
                        <?php echo esc_html($empty_message); ?>
                    </h3>
                </div>
            </div>
        <?php endfor; ?>

    </div>

</div>
<?php
wp_reset_postdata();
?>