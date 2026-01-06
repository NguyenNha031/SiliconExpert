<?php
/**
 * Insights & Resources Block
 */

/* ===== SECTION STATIC FIELDS (ACF) ===== */
$section_title = get_field('section_title');
$cta_label = get_field('secondary_cta_label');
$cta_link = get_field('secondary_cta_link');

/* ===== HELPERS ===== */
function get_read_time_or_default($post_id)
{
    $read_time = get_field('read_time', $post_id);
    return $read_time ? esc_html($read_time) : '5 min read';
}

function get_post_category_or_default($post_id)
{
    $cats = get_the_category($post_id);
    return (!empty($cats)) ? esc_html($cats[0]->name) : 'Press Release';
}

/* ===== GET 3 LATEST POSTS (FORCE post_type=post) ===== */
$latest_posts = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'ignore_sticky_posts' => true,
    'no_found_rows' => true,
]);

$posts = [];
if ($latest_posts->have_posts()) {
    while ($latest_posts->have_posts()) {
        $latest_posts->the_post();
        $posts[] = get_post();
    }
    wp_reset_postdata();
}
?>

<section class="relative py-20 bg-white">
    <div class="max-w-7xl px-4 lg:px-0">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-14 lg:pl-[36px] lg:w-[108%]">
            <div class="flex items-center gap-4">
                <span class="w-[2px] h-[24px] bg-[#FCC937]"></span>
                <?php if ($section_title): ?>
                    <h2 class="text-[24px] font-medium text-[#1C3664]">
                        <?php echo esc_html($section_title); ?>
                    </h2>
                <?php endif; ?>
            </div>

            <?php if ($cta_label && $cta_link): ?>
                <a href="<?php echo esc_url($cta_link['url']); ?>" class="btn-non-bg h-[48px] text-[#1C3664]">
                    <?php echo esc_html($cta_label); ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-[110px] lg:ml-[95px] sm:ml-[150px] lg:ml-[15px] ">

            <!-- FEATURED (LEFT) -->
            <div class="lg:col-span-8 lg:w-[836px] sm:w-[80%] lg:w-[406px] mb-[40px]">
                <?php if (!empty($posts[0])): ?>
                    <?php
                    $p = $posts[0];
                    setup_postdata($p);
                    $video = get_field('featured_video', $p->ID);
                    $video_url = is_array($video) ? $video['url'] : $video;
                    $thumb = get_the_post_thumbnail_url($p->ID, 'large');

                    ?>

                    <a href="<?php echo esc_url(get_permalink($p->ID)); ?>"
                        class="group relative block overflow-hidden rounded-sm lg:h-[420px] custom-cut-corner">

                        <?php if ($video_url): ?>
                            <video class="w-full h-full object-cover transition-transform duration-500 "
                                src="<?= esc_url($video_url); ?>" muted loop playsinline data-hover-video>
                            </video>
                        <?php elseif (has_post_thumbnail($p->ID)): ?>
                            <?php echo get_the_post_thumbnail($p->ID, 'large', [
                                'class' => 'w-full h-full object-cover transition-transform duration-500 '
                            ]); ?>
                        <?php endif; ?>


                        <!-- BUTTON OVERLAY -->
                        <button class="btn-get-started btn-icon-only
               absolute top-4 right-4 z-20
               opacity-0 translate-y-2 
               pointer-events-none
               transition-all duration-300 ease-out
               group-hover:opacity-100
               group-hover:translate-y-0
               group-hover:pointer-events-auto">
                            <span class="btn-get-started__icon">
                                <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                            </span>
                        </button>
                    </a>


                    <h3 class="mt-6 text-[20px] font-medium text-[#1C3664]">
                        <?php echo esc_html(get_the_title($p->ID)); ?>
                    </h3>

                    <div class="mt-2 flex items-center gap-4 text-sm text-[#1C3664]/70">
                        <span><?php echo esc_html(get_the_date('F j, Y', $p->ID)); ?></span>
                        <span><?php echo get_post_category_or_default($p->ID); ?></span>
                        <span><?php echo get_read_time_or_default($p->ID); ?></span>
                    </div>

                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>

            <!-- SIDE (RIGHT) -->
            <div class="lg:col-span-4 flex flex-col gap-5 sm:w-[80%] lg:w-[406px]">
                <?php for ($i = 1; $i <= 2; $i++): ?>
                    <?php if (!empty($posts[$i])): ?>
                        <?php
                        $p = $posts[$i];
                        setup_postdata($p);
                        $video = get_field('featured_video', $p->ID);
                        $video_url = is_array($video) ? $video['url'] : $video;
                        $thumb = get_the_post_thumbnail_url($p->ID, 'large');

                        ?>

                        <div class="side-item-wrapper mb-8">
                            <a href="<?php echo esc_url(get_permalink($p->ID)); ?>"
                                class="group relative block overflow-hidden rounded-sm sm:h-[420px] lg:h-[200px] custom-cut-corner">

                                <?php if ($video_url): ?>
                                    <video class="w-full h-full object-cover transition-transform duration-500 "
                                        src="<?= esc_url($video_url); ?>" muted loop playsinline data-hover-video>
                                    </video>
                                <?php elseif (has_post_thumbnail($p->ID)): ?>
                                    <?php echo get_the_post_thumbnail($p->ID, 'medium', [
                                        'class' => 'w-full h-full object-cover transition-transform duration-500 '
                                    ]); ?>
                                <?php endif; ?>


                                <!-- BUTTON OVERLAY -->
                                <button class="btn-get-started btn-icon-only
                                absolute top-4 right-4 z-20
                                opacity-0 translate-y-2 
                                pointer-events-none
                                transition-all duration-300 ease-out
                                group-hover:opacity-100
                                group-hover:translate-y-0
                                group-hover:pointer-events-auto">
                                    <span class="btn-get-started__icon">
                                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                    </span>
                                </button>
                            </a>


                            <a href="<?php echo esc_url(get_permalink($p->ID)); ?>">
                                <h4 class="mt-4 text-[16px] font-medium text-[#1C3664]">
                                    <?php echo esc_html(get_the_title($p->ID)); ?>
                                </h4>
                            </a>

                            <div class="mt-1 flex gap-4 text-sm text-[#1C3664]/70">
                                <span><?php echo esc_html(get_the_date('F j, Y', $p->ID)); ?></span>
                                <span><?php echo get_post_category_or_default($p->ID); ?></span>
                                <span><?php echo get_read_time_or_default($p->ID); ?></span>
                            </div>
                        </div>

                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

        </div>
    </div>
</section>