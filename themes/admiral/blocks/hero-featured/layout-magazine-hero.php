<?php
/**
 * Layout Magazine Hero – Newspaper Style
 */

if (!function_exists('vnep_thumb')) {
    function vnep_thumb($id, $size = 'large')
    {
        $thumb = get_the_post_thumbnail_url($id, $size);
        if (!$thumb)
            $thumb = get_first_image_in_content($id);
        if (!$thumb)
            $thumb = get_stylesheet_directory_uri() . "/fallback.jpg";
        return $thumb;
    }
}

if (empty($mag_posts) || !is_array($mag_posts)) {
    return;
}

/* POST LIST */
$posts = array_slice($mag_posts, 0, 4);
while (count($posts) < 4) {
    $posts[] = null;
}

[$p1, $p2, $p3, $p4] = $posts;

$show_category = !empty($attributes['showCategory']);
$show_date = !empty($attributes['showDate']);
$show_views = !empty($attributes['showViews']);

$source_type = $attributes['sourceType'] ?? 'category';
$empty_text = $source_type === 'tag'
    ? 'Tag này chưa có đủ bài viết'
    : 'Chuyên mục này chưa có đủ bài viết';

$label = $attributes['label'] ?? '';
?>

<?php if (!empty($label)): ?>
    <div class="vnep-block-label hero-featured-label py-[6px] px-[14px] !mt-[25px]" style="
        background: <?php echo esc_attr($attributes['labelBgColor']); ?>;
        color: <?php echo esc_attr($attributes['labelTextColor']); ?>;
        font-size: <?php echo intval($attributes['labelFontSize']); ?>px;
        font-weight: <?php echo esc_attr($attributes['labelFontWeight'] ?? '600'); ?>;
    ">
        <?php echo esc_html($label); ?>
    </div>
<?php endif; ?>

<div class="vnep-magazine-hero">
    <div class="grid grid-cols-1 md:grid-cols-3">

        <!-- HERO LEFT  -->
        <?php if ($p1): ?>
            <?php
            $cat1 = get_the_category($p1->ID);
            $views1 = intval(get_post_meta($p1->ID, 'wp2025_post_views', true));
            ?>
            <a href="<?php echo get_permalink($p1->ID); ?>"
                class="relative col-span-2 !max-w-[75%] overflow-hidden h-[445px] group bg-cover bg-center"
                style="background-image:url('<?php echo esc_url(vnep_thumb($p1->ID)); ?>');">
                <?php if ($is_pinned($p1->ID)): ?>
                    <span class="vnep-badge-pin hero">📌 Ghim</span>
                <?php endif; ?>

                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/10"></div>

                <div class="absolute bottom-6 left-6 right-6">

                    <?php if ($show_category && $cat1): ?>
                        <span style="
                            color: <?php echo esc_attr($attributes['heroCatColor']); ?>;
                            font-size: <?php echo intval($attributes['heroCatSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroCatWeight']); ?>;
                        ">
                            <?php echo esc_html($cat1[0]->name); ?>
                        </span>
                    <?php endif; ?>

                    <h2 style="
                        color: <?php echo esc_attr($attributes['heroTitleColor']); ?>;
                        font-size: <?php echo intval($attributes['heroTitleSize']); ?>px;
                        font-weight: <?php echo esc_attr($attributes['heroTitleWeight']); ?>;
                        margin-top:6px;
                    ">
                        <?php echo esc_html(get_the_title($p1->ID)); ?>
                    </h2>

                    <?php if ($show_date || $show_views): ?>
                        <div style="
                            color: <?php echo esc_attr($attributes['heroMetaColor']); ?>;
                            font-size: <?php echo intval($attributes['heroMetaSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroMetaWeight']); ?>;
                            margin-top:6px;
                        ">
                            <?php if ($show_date): ?>
                                <span><?php echo esc_html(get_the_date('', $p1->ID)); ?></span>

                            <?php endif; ?>
                            <?php if ($show_views): ?>
                                <span>👁 <?php echo $views1; ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </a>
        <?php else: ?>
            <!-- HERO FALLBACK -->
            <div class="relative col-span-2 !max-w-[75%] h-[445px] overflow-hidden bg-cover bg-center"
                style="background-image:url('<?php echo esc_url(get_stylesheet_directory_uri() . '/fallback.jpg'); ?>');">
                <div class="absolute inset-0 bg-black/60"></div>
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                    <div class="text-xs uppercase tracking-wide opacity-80">Thông báo</div>
                    <div class="text-sm font-semibold mt-1"><?php echo esc_html($empty_text); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!--  RIGHT COLUMN  -->
        <div class="flex flex-col gap-[5px] relative right-[148px] w-[150%]">

            <!--  CARD 2 -->
            <?php if ($p2): ?>
                <?php
                $cat2 = get_the_category($p2->ID);
                $views2 = intval(get_post_meta($p2->ID, 'wp2025_post_views', true));
                ?>
                <a href="<?php echo get_permalink($p2->ID); ?>" class="relative overflow-hidden group block h-[220px]"
                    style="background-image:url('<?php echo esc_url(vnep_thumb($p2->ID, 'medium')); ?>');
                          background-size:cover;background-position:center;">
                    <?php if ($is_pinned($p2->ID)): ?>
                        <span class="vnep-badge-pin card">📌 Ghim</span>
                    <?php endif; ?>


                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/10"></div>

                    <div class="absolute bottom-4 left-4 right-4">

                        <?php if ($show_category && $cat2): ?>
                            <span style="
                                color: <?php echo esc_attr($attributes['heroGridCatColor']); ?>;
                                font-size: <?php echo intval($attributes['heroGridCatSize']); ?>px;
                                font-weight: <?php echo esc_attr($attributes['heroGridCatWeight']); ?>;
                            ">
                                <?php echo esc_html($cat2[0]->name); ?>
                            </span>
                        <?php endif; ?>

                        <h3 style="
                            color: <?php echo esc_attr($attributes['heroGridTitleColor']); ?>;
                            font-size: <?php echo intval($attributes['heroGridTitleSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroGridTitleWeight']); ?>;
                            margin-top:4px;
                        ">
                            <?php echo esc_html(get_the_title($p2->ID)); ?>
                        </h3>

                        <?php if ($show_date || $show_views): ?>
                            <div style="
                                color: <?php echo esc_attr($attributes['heroGridMetaColor']); ?>;
                                font-size: <?php echo intval($attributes['heroGridMetaSize']); ?>px;
                                font-weight: <?php echo esc_attr($attributes['heroGridMetaWeight']); ?>;
                                margin-top:4px;
                            ">
                                <?php if ($show_date): ?>
                                    <span><?php echo esc_html(get_the_date('', $p2)); ?></span>
                                <?php endif; ?>
                                <?php if ($show_views): ?>
                                    <span>👁 <?php echo $views2; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </a>
            <?php else: ?>
                <!-- CARD 2 FALLBACK -->
                <div class="relative h-[220px] overflow-hidden bg-cover bg-center"
                    style="background-image:url('<?php echo esc_url(get_stylesheet_directory_uri() . '/fallback.jpg'); ?>');">
                    <div class="absolute inset-0 bg-black/60"></div>
                    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-3">
                        <div class="text-xs uppercase tracking-wide opacity-80">Thông báo</div>
                        <div class="text-sm font-semibold mt-1"><?php echo esc_html($empty_text); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- CARD 3 + 4 -->
            <div class="flex gap-[5px]">
                <?php foreach ([$p3, $p4] as $p): ?>
                    <?php if ($p): ?>
                        <?php
                        $cat = get_the_category($p->ID);
                        $views = intval(get_post_meta($p->ID, 'wp2025_post_views', true));
                        ?>
                        <a href="<?php echo get_permalink($p->ID); ?>" class="relative overflow-hidden group flex-1 h-[220px]"
                            style="background-image:url('<?php echo esc_url(vnep_thumb($p->ID, 'medium')); ?>');
                      background-size:cover;background-position:center;">

                            <?php if ($is_pinned($p->ID)): ?>
                                <span class="vnep-badge-pin card">📌 Ghim</span>
                            <?php endif; ?>

                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/10"></div>

                            <div class="absolute bottom-4 left-4 right-4">

                                <?php if ($show_category && $cat): ?>
                                    <span style="
                            color: <?php echo esc_attr($attributes['heroGridCatColor']); ?>;
                            font-size: <?php echo intval($attributes['heroGridCatSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroGridCatWeight']); ?>;
                        ">
                                        <?php echo esc_html($cat[0]->name); ?>
                                    </span>
                                <?php endif; ?>

                                <h4 style="
                        color: <?php echo esc_attr($attributes['heroGridTitleColor']); ?>;
                        font-size: <?php echo intval($attributes['heroGridTitleSize']); ?>px;
                        font-weight: <?php echo esc_attr($attributes['heroGridTitleWeight']); ?>;
                        margin-top:4px;
                        display:-webkit-box;
                        -webkit-box-orient:vertical;
                        -webkit-line-clamp:3;
                        overflow:hidden;
                    ">
                                    <?php echo esc_html(get_the_title($p->ID)); ?>
                                </h4>

                                <?php if ($show_date || $show_views): ?>
                                    <div style="
                            color: <?php echo esc_attr($attributes['heroGridMetaColor']); ?>;
                            font-size: <?php echo intval($attributes['heroGridMetaSize']); ?>px;
                            font-weight: <?php echo esc_attr($attributes['heroGridMetaWeight']); ?>;
                            margin-top:4px;
                        ">
                                        <?php if ($show_date): ?>
                                            <span><?php echo esc_html(get_the_date('', $p->ID)); ?></span>
                                        <?php endif; ?>
                                        <?php if ($show_views): ?>
                                            <span>👁 <?php echo $views; ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </a>
                    <?php else: ?>
                        <!-- FALLBACK CARD -->
                        <div class="relative flex-1 h-[220px] overflow-hidden bg-cover bg-center"
                            style="background-image:url('<?php echo esc_url(get_stylesheet_directory_uri() . '/fallback.jpg'); ?>');">
                            <div class="absolute inset-0 bg-black/60"></div>
                            <div
                                class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-3">
                                <div class="text-xs uppercase tracking-wide opacity-80">Thông báo</div>
                                <div class="text-sm font-semibold mt-1"><?php echo esc_html($empty_text); ?></div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>


        </div>
    </div>
</div>