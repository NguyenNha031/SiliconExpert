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
    <section class="resources-filter py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6 flex flex-wrap gap-4 items-center justify-between">

            <!-- LEFT FILTERS -->
            <div class="flex gap-4">
                <select name="topic" class="  py-2 ">
                    <option value="">Topic</option>
                    <?php
                    $cats = get_categories();
                    foreach ($cats as $cat) {
                        echo '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
                    }
                    ?>
                </select>

                <select name="type" class="  py-2 ">
                    <option value="">Type</option>
                    <option value="whitepaper">Whitepaper</option>
                    <option value="infographic">Infographic</option>
                    <option value="report">Report</option>
                </select>
            </div>

            <!-- SEARCH -->
            <form method="get">
                <input type="search" name="s" placeholder="Search" value="<?= esc_attr(get_search_query()); ?>"
                    class=" px-4 py-2  w-[240px]" />
            </form>

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


    // FILTER CATEGORY
    if (!empty($_GET['topic'])) {
        $args['category_name'] = sanitize_text_field($_GET['topic']);
    }

    // SEARCH
    if (!empty($_GET['s'])) {
        $args['s'] = sanitize_text_field($_GET['s']);
    }

    $query = new WP_Query($args);
    $total_pages = $query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));
    ?>

    <section class="resources-grid py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

            <?php if ($query->have_posts()): ?>
                <?php while ($query->have_posts()):
                    $query->the_post();

                    $video = get_field('featured_video', get_the_ID());
                    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
                    ?>

                    <article class="group">
                        <div class="relative overflow-hidden custom-cut-corner">

                            <!-- BUTTON OVERLAY -->
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
                            <?php the_title(); ?>
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
        <section class="resources-pagination py-16 bg-white">
            <div class="flex items-center justify-between gap-3 text-[#1C3664] w-[20%] ml-[135px]">

                <!-- PREV -->
                <?php if ($current_page > 1): ?>
                    <a href="<?= esc_url(get_pagenum_link($current_page - 1)); ?>"
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
                        <a href="<?= esc_url(get_pagenum_link($i)); ?>" class="pagination-item">
                            <?= $i; ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>


                <!-- NEXT -->
                <?php if ($current_page < $total_pages): ?>
                    <a href="<?= esc_url(get_pagenum_link($current_page + 1)); ?>"
                        class="pagination-arrow text-[35px] pb-[8px]">
                        ›
                    </a>
                <?php endif; ?>

            </div>
        </section>
    <?php endif; ?>


</main>
<?php get_footer(); ?>