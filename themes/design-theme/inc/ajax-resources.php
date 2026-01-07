<?php
add_action('wp_ajax_load_resources', 'design_ajax_load_resources');
add_action('wp_ajax_nopriv_load_resources', 'design_ajax_load_resources');

function design_ajax_load_resources()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
    $topics = isset($_POST['topics']) ? (array) $_POST['topics'] : [];

    $first_post = get_posts([
        'post_type' => 'post',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
        'fields' => 'ids',
    ]);

    $args = [
        'post_type' => 'post',
        'posts_per_page' => 9,
        'paged' => $paged,
        'post__not_in' => $first_post ?: [],
    ];

    if (!empty($topics)) {
        $args['category_name'] = implode(
            ',',
            array_map('sanitize_text_field', $topics)
        );
    }

    if ($search) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $total_pages = $query->max_num_pages;
    $current_page = $paged;

    ob_start();
    ?>

    <section class="resources-grid py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10">

            <?php if ($query->have_posts()): ?>
                <?php while ($query->have_posts()):
                    $query->the_post(); ?>
                    <?php $video = get_field('featured_video', get_the_ID()); ?>

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
                                    <video class="w-full h-[220px] object-cover" muted loop playsinline>
                                        <source src="<?= esc_url($video['url']); ?>" type="video/mp4">
                                    </video>
                                <?php else: ?>
                                    <?php the_post_thumbnail('medium_large', [
                                        'class' => 'w-full h-[220px] object-cover'
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

    <?php if ($total_pages > 1): ?>
        <section class="resources-pagination py-16 bg-white">
            <div class="flex items-center justify-between gap-3 text-[#1C3664] w-[20%] ml-[135px]">

                <?php if ($current_page > 1): ?>
                    <a href="#" data-page="<?= $current_page - 1 ?>" class="pagination-arrow text-[35px] pb-[8px]">‹</a>
                <?php endif; ?>

                <?php
                $range = 4;
                $start = max(1, $current_page - 1);
                $end = min($total_pages, $start + $range - 1);
                ?>

                <?php for ($i = $start; $i <= $end; $i++): ?>
                    <?php if ($i == $current_page): ?>
                        <span class="pagination-item is-active border rounded-sm px-[15px] py-[6px]">
                            <?= $i ?>
                        </span>
                    <?php else: ?>
                        <a href="#" data-page="<?= $i ?>" class="pagination-item"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="#" data-page="<?= $current_page + 1 ?>" class="pagination-arrow text-[35px] pb-[8px]">›</a>
                <?php endif; ?>

            </div>
        </section>
    <?php endif; ?>

    <?php
    wp_reset_postdata();
    wp_send_json_success(ob_get_clean());
}
