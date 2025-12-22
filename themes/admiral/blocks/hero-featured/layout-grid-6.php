<?php
/**
 * Layout: Grid 6 bài dạng 3 cột (hỗ trợ pinned post)
 * Biến đầu vào: $grid6_posts (array Post objects)
 */

if (empty($grid6_posts) || !is_array($grid6_posts)) {
    return;
}

//Khởi tạo cấu hình block từ attributes
$catColor = $attributes['catTextColorGrid6'] ?? '#ff6666';
$catSize = $attributes['catFontSizeGrid6'] ?? 17;
$metaColor = $attributes['metaTextColorGrid6'] ?? '#adadad';
$metaSize = $attributes['metaFontSizeGrid6'] ?? 18;
$titleColor = $attributes['titleTextColorGrid6'] ?? '#5d5c5c';
$titleSize = $attributes['titleFontSizeGrid6'] ?? 18;
$limit_lines = !empty($attributes['limitTitleLinesGrid6']);
$line_clamp = intval($attributes['titleLineClampGrid6'] ?? 2);
$cardBg = $attributes['cardBgGrid6'] ?? 'rgba(49,45,45,0.06)';
$fallback_thumb = get_stylesheet_directory_uri() . "/fallback.jpg";
?>

<?php if (!empty($label)): ?>
    <div class="vnep-block-label" style="
        background: <?php echo esc_attr($attributes['labelBgColor']); ?>;
        color: <?php echo esc_attr($attributes['labelTextColor']); ?>;
        font-size: <?php echo intval($attributes['labelFontSize']); ?>px;
        font-weight: <?php echo esc_attr($attributes['labelFontWeightGrid6'] ?? '600'); ?>;
        text-align: center;
        padding: 6px 14px;
        display: inline-block;
        margin-top:25px;
    ">
        <?php echo esc_html($label); ?>
    </div>
<?php endif; ?>

<div class="vnep-grid-6">

    <?php foreach ($grid6_posts as $post):
        setup_postdata($post);

        //THUMB 
        $thumb = get_the_post_thumbnail_url($post->ID, 'medium_large');
        if (!$thumb)
            $thumb = get_first_image_in_content($post->ID);
        if (!$thumb)
            $thumb = $fallback_thumb;

        // META 
        $views = intval(get_post_meta($post->ID, 'wp2025_post_views', true));
        $cat = get_the_category($post->ID);
        $cat_name = $cat ? $cat[0]->name : "";
        ?>

        <div class="vnep-card" style="background: <?php echo esc_attr($cardBg); ?>;">
            <?php if ($is_pinned($post->ID)): ?>
                <span class="vnep-badge-pin card">📌 Ghim</span>
            <?php endif; ?>

            <a href="<?php echo get_permalink($post->ID); ?>" class="vnep-thumb-link">
                <img class="vnep-thumb" style="height:200px;" src="<?php echo esc_url($thumb); ?>" alt="">
            </a>

            <?php if ($show_category && $cat_name): ?>
                <div class="vnep-cat-small" style="
                    color: <?php echo esc_attr($catColor); ?>;
                    font-size: <?php echo intval($catSize); ?>px;
                    font-weight: <?php echo esc_attr($attributes['catFontWeightGrid6'] ?? '600'); ?>;
                ">
                    <?php echo esc_html($cat_name); ?>
                </div>
            <?php endif; ?>

            <?php if ($show_date || $show_views): ?>
                <div class="vnep-card-meta" style="
                    color: <?php echo esc_attr($metaColor); ?>;
                    font-size: <?php echo intval($metaSize); ?>px;
                    font-weight: <?php echo esc_attr($attributes['metaFontWeightGrid6'] ?? '400'); ?>;
                ">
                    <?php if ($show_date): ?>
                        <span><?php echo esc_html(get_the_date('j \T\há\n\g m, Y', $post)); ?></span>
                    <?php endif; ?>
                    <?php if ($show_views): ?>
                        <span>👁 <?php echo intval($views); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <h3 class="vnep-card-title">
                <a href="<?php echo get_permalink($post->ID); ?>" style="
                    color: <?php echo esc_attr($titleColor); ?>;
                    font-size: <?php echo intval($titleSize); ?>px;
                    font-weight: <?php echo esc_attr($attributes['titleFontWeightGrid6'] ?? '600'); ?>;
                    <?php if ($limit_lines): ?>
                        display:-webkit-box;
                        -webkit-line-clamp:<?php echo intval($line_clamp); ?>;
                        -webkit-box-orient:vertical;
                        overflow:hidden;
                    <?php endif; ?>
                ">
                    <?php echo esc_html(get_the_title($post->ID)); ?>
                </a>
            </h3>

        </div>

    <?php endforeach;
    wp_reset_postdata(); ?>

</div>