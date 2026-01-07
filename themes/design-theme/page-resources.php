<?php
get_header();
?>


<main class="bg-[#1c3664] page-resources ">
    <?php
    while (have_posts()) {
        the_post();
        the_content();
    }
    ?>
    <section class="resources-filter py-6 bg-white">
        <div class="max-w-7xl mx-auto px-6 flex items-center justify-between gap-6">

            <div class="hidden lg:flex gap-6 items-center">

                <div class="topic-filter relative">
                    <button type="button" class="topic-toggle flex items-center gap-2 text-[#1C3664]">
                        Topic <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <div
                        class="topic-dropdown hidden absolute top-full mt-2 bg-white shadow-lg rounded-lg p-4 w-[280px] z-20 max-h-[260px] overflow-auto">
                        <?php foreach (get_categories() as $cat): ?>
                            <label class="flex items-center gap-3 py-2 cursor-pointer">
                                <input type="checkbox" class="topic-checkbox" value="<?= esc_attr($cat->slug); ?>" />
                                <span><?= esc_html($cat->name); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <button class="flex items-center gap-2 text-[#1C3664]">
                    Category <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <button class="flex items-center gap-2 text-[#1C3664]">
                    Type <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>
            </div>

            <div class="flex items-center gap-4 w-full lg:w-auto">

                <form method="get" class="w-full lg:w-[384px]">
                    <div class="relative">
                        <input type="search" name="s" placeholder="Search" value="<?= esc_attr(get_search_query()); ?>"
                            class="w-full px-4 py-3 pr-10 rounded-sm bg-[#f7f7f7]" />

                        <i class="fa-solid fa-magnifying-glass
                        absolute right-3 top-1/2 -translate-y-1/2
                        text-[#1C3664]/60 pointer-events-none"></i>
                    </div>
                </form>
                <button type="button" class="filter-toggle lg:hidden flex items-center justify-center
           w-10 h-10 rounded-md
           hover:bg-[#f2f4f8] transition" aria-label="Filter">

                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-flilter.png" alt="Filter"
                        class="w-5 h-5 object-contain" />
                </button>


            </div>

        </div>
    </section>


    <section class="mobile-inline-filter hidden lg:hidden bg-white ">
        <div class="topic-selected flex gap-2 flex-wrap bg-white pl-[25px]"></div>

        <div class="px-6 py-6 space-y-8">

            <!-- TOPIC -->
            <div>
                <h4 class="mb-3 font-medium text-[#1C3664]">Topic</h4>
                <div class="space-y-3 max-h-[200px] overflow-auto border rounded-md p-4">
                    <?php foreach (get_categories() as $cat): ?>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" class="topic-checkbox" value="<?= esc_attr($cat->slug); ?>">
                            <span><?= esc_html($cat->name); ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- CATEGORY -->
            <div>
                <h4 class="mb-3 font-medium text-[#1C3664]">Category</h4>
                <div class="space-y-3 border rounded-md p-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox"> Article
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox"> Product Updates
                    </label>
                </div>
            </div>

            <!-- TYPE -->
            <div>
                <h4 class="mb-3 font-medium text-[#1C3664]">Type</h4>
                <div class="space-y-3 max-h-[220px] overflow-auto border rounded-md p-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox"> Case Studies
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox"> Datasheets
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox"> eBooks
                    </label>
                </div>
            </div>

        </div>
    </section>



    <?php
    $paged = get_query_var('paged') ?: 1;
    $first_post = get_posts([
        'post_type' => 'post',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'fields' => 'ids',
    ]);

    $exclude_ids = !empty($first_post) ? $first_post : [];

    $args = [
        'post_type' => 'post',
        'posts_per_page' => 9,
        'paged' => $paged,
        'post__not_in' => $exclude_ids,
    ];


    if (!empty($_GET['topic'])) {
        $args['category_name'] = sanitize_text_field($_GET['topic']);
    }

    if (!empty($_GET['s'])) {
        $args['s'] = sanitize_text_field($_GET['s']);
    }

    $query = new WP_Query($args);
    $total_pages = $query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));
    ?>
    <div class="topic-selected lg:flex gap-2 flex-wrap bg-white hidden  pl-[115px]"></div>

    <div id="resources-ajax-wrapper">

        <section class="resources-grid py-12 bg-white">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()):
                        $query->the_post();

                        $video = get_field('featured_video', get_the_ID());
                        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                        ?>

                        <article class="group">
                            <div class="relative overflow-hidden custom-cut-corner">

                                <button class="btn-get-started btn-icon-only
                                    absolute top-3 right-3 z-20
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

                                <a href="<?php the_permalink(); ?>" class="block">
                                    <?php if ($video): ?>
                                        <video class="w-full h-[220px] object-cover" src="<?= esc_url($video['url']); ?>" muted loop
                                            playsinline data-hover-video>
                                        </video>


                                    <?php else: ?>
                                        <?php the_post_thumbnail('medium_large', [
                                            'class' => 'w-full h-[220px] object-cover transition-transform duration-500'
                                        ]); ?>
                                    <?php endif; ?>
                                </a>

                            </div>

                            <h3 class="mt-4 text-lg font-medium text-[#1C3664]">
                                <a href="<?php the_permalink(); ?>" class="">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <div class="mt-2 text-sm text-[#1C3664]/70 flex gap-4">
                                <span><?php echo get_the_date(); ?></span>
                                <span><?= design_get_category(get_the_ID()); ?></span>
                                <span><?= design_get_read_time(get_the_ID()); ?></span>
                            </div>
                        </article>

                    <?php endwhile; ?>

                <?php else: ?>
                    <p>No resources found.</p>
                <?php endif; ?>

            </div>
        </section>

        <?php wp_reset_postdata(); ?>

        <?php if ($total_pages > 1): ?>
            <section class="resources-pagination py-12 bg-white">
                <div
                    class="flex items-center justify-between gap-3 text-[#1C3664] w-[40%] lg:w-[20%] ml-[40px] lg:ml-[135px]">

                    <!-- PREV -->
                    <?php if ($current_page > 1): ?>
                        <a href="<?= esc_url(get_pagenum_link($current_page - 1)); ?>" data-page="<?= $current_page - 1; ?>"
                            class="pagination-arrow text-[35px] pb-[8px]">

                            ‹
                        </a>
                    <?php endif; ?>

                    <!-- PAGE NUMBERS -->
                    <?php
                    $range = 4;

                    $start = max(1, $current_page - 1);
                    $end = min($total_pages, $start + $range - 1);

                    if (($end - $start) < ($range - 1)) {
                        $start = max(1, $end - $range + 1);
                    }
                    ?>

                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <?php if ($i == $current_page): ?>
                            <span class="pagination-item is-active border rounded-sm px-[15px] py-[6px]">
                                <?= $i; ?>
                            </span>
                        <?php else: ?>
                            <a href="<?= esc_url(get_pagenum_link($i)); ?>" data-page="<?= $i; ?>" class="pagination-item">
                                <?= $i; ?>
                            </a>

                        <?php endif; ?>
                    <?php endfor; ?>


                    <!-- NEXT -->
                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?= esc_url(get_pagenum_link($current_page + 1)); ?>" data-page="<?= $current_page + 1; ?>"
                            class="pagination-arrow text-[35px] pb-[8px]">

                            ›
                        </a>
                    <?php endif; ?>

                </div>
            </section>
        <?php endif; ?>
    </div>

</main>
<?php get_footer(); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.querySelector('.filter-toggle');
        const filterBlock = document.querySelector('.mobile-inline-filter');

        if (!toggleBtn || !filterBlock) return;

        toggleBtn.addEventListener('click', () => {
            filterBlock.classList.toggle('hidden');
        });
    });
</script>