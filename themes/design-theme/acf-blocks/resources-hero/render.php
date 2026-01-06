<?php
$page_title = get_field('page_title') ?: 'Resources';
$page_desc = get_field('page_desc');
$featured_label = get_field('featured_label') ?: 'Featured Resource';

// LẤY BÀI VIẾT MỚI NHẤT
$query = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post_status' => 'publish',
]);

if (!$query->have_posts())
    return;

$query->the_post();

$post_id = get_the_ID();
$thumb = get_the_post_thumbnail_url($post_id, 'full');
$video = get_field('featured_video', $post_id);
$video_url = is_array($video) ? $video['url'] : $video;
$cats = get_the_category($post_id);
$cat = !empty($cats) ? $cats[0]->name : 'Resources';
$read = get_field('read_time', $post_id) ?: '1 min read';
?>
<section class="bg-[#1c3664] text-white pt-[160px] pb-[100px]">
    <div class="flex justify-between max-w-7xl mx-auto px-6 items-center pb-[50px]">
        <h1 class="text-[48px] font-semibold mb-6">
            <?= esc_html($page_title); ?>
        </h1>
        <div class="w-[57%]">
            <?php if ($page_desc): ?>
                <p class="text-white/80 max-w-[80%] mb-12">
                    <?= esc_html($page_desc); ?>
                </p>
            <?php endif; ?>
        </div>

    </div>
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-12 gap-12 relative">

        <!-- LEFT -->
        <div class="col-span-5 h-[150px]">


            <span class="text-[#FCC937] text-sm font-medium uppercase  block">
                <?= esc_html($featured_label); ?>
            </span>
            <div class="absolute bottom-0 w-[36%]">
                <a href="<?= esc_url(get_permalink()); ?>" class="block group">
                    <h2 class="text-[28px] font-semibold leading-snug no-underline">
                        <?php the_title(); ?>
                    </h2>
                </a>

                <div class="flex items-center gap-4 text-sm text-white/70 mt-4">
                    <span>
                        <?php echo get_the_date('F j, Y'); ?>
                    </span>
                    <span>
                        <?= esc_html($cat); ?>
                    </span>
                    <span>
                        <?= esc_html($read); ?>
                    </span>
                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="col-span-7">
            <?php if ($thumb): ?>
                <div class="relative group w-full h-[420px] overflow-hidden">

                    <button class="btn-get-started btn-icon-only
        absolute top-4 right-4 z-20
        opacity-0 translate-y-2 scale-90
        pointer-events-none
        transition-all duration-300 ease-out
        group-hover:opacity-100
        group-hover:translate-y-0
        group-hover:pointer-events-auto">
                        <span class="btn-get-started__icon">
                            <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                        </span>
                    </button>

                    <a href="<?= esc_url(get_permalink()); ?>" class="block w-full h-full">

                        <?php if ($video_url): ?>
                            <video class="w-full h-full object-cover custom-cut-corner transition-transform duration-500"
                                src="<?= esc_url($video_url); ?>" muted loop playsinline data-hover-video>
                            </video>
                        <?php elseif ($thumb): ?>
                            <img src="<?= esc_url($thumb); ?>"
                                class="w-full h-full object-cover custom-cut-corner transition-transform duration-500">
                        <?php endif; ?>

                    </a>
                </div>

            <?php endif; ?>
        </div>


    </div>
</section>

<?php wp_reset_postdata(); ?>