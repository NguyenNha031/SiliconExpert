<?php
/**
 * Single Post Template
 */

get_header();
?>

<style>
    .split-panel .panel-content>div {
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.35s ease, transform 0.35s ease;
        pointer-events: none;
    }

    .split-panel.is-expanded .panel-content>div {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
</style>

<main class="post-single">

    <?php if (have_posts()):
        while (have_posts()):
            the_post(); ?>

            <!-- POST HERO -->
            <section class="pt-32 pb-20 h-[500px] flex items-center">
                <div class="max-w-4xl mx-auto px-6">

                    <!-- META -->
                    <div class="flex items-center gap-4 text-sm text-[#1C3664]/70 mb-6">
                        <span>
                            <?php
                            $cats = get_the_category();
                            echo !empty($cats) ? esc_html($cats[0]->name) : 'Press Release';
                            ?>
                        </span>

                        <span class="flex items-center gap-1">
                            <i class="fa-regular fa-clock"></i>
                            <?php
                            $read_time = get_field('read_time');
                            echo $read_time ? esc_html($read_time) : '5 min read';
                            ?>
                        </span>
                    </div>

                    <!-- TITLE -->
                    <h1 class="text-[40px] leading-tight font-semibold text-[#0B1F3B]">
                        <?php the_title(); ?>
                    </h1>

                    <!-- DATE -->
                    <p class="mt-4 text-sm text-[#1C3664]/60">
                        <?php echo get_the_date('F j, Y'); ?>
                    </p>

                </div>
            </section>
            <!-- POST META BAR -->
            <section class="border-t border-[#1C3664]/10">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="flex items-center justify-between h-[64px] text-sm text-[#1C3664]">

                        <!-- LEFT: BREADCRUMB -->
                        <div class="flex items-center gap-2 text-[#1C3664]/70">
                            <a href="<?= esc_url(home_url('/resources')) ?>" class="hover:underline">
                                Resources
                            </a>

                            <span>›</span>

                            <?php
                            $cats = get_the_category();
                            if (!empty($cats)):
                                $cat = $cats[0];
                                ?>
                                <a href="<?= esc_url(get_category_link($cat)) ?>" class="hover:underline">
                                    <?= esc_html($cat->name) ?>
                                </a>
                            <?php endif; ?>

                            <span>›</span>

                            <span class="text-[#1C3664] font-medium truncate max-w-[280px]">
                                <?php the_title(); ?>
                            </span>
                        </div>

                        <!-- RIGHT: ACTIONS -->
                        <div class="flex items-center gap-6">

                            <button id="openShareModal"
                                class="flex items-center gap-2 text-[#1C3664]/70 hover:text-[#0B1F3B] transition-colors">
                                <span>Share</span>
                            </button>
                            <!-- Modal share -->
                            <div id="shareModal"
                                class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
                                <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl relative mx-4">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xl font-semibold text-[#0B1F3B]">Share Modal</h3>
                                        <button id="closeShareModal" class="text-gray-400 hover:text-gray-600">
                                            <i class="fa-solid fa-xmark text-xl"></i>
                                        </button>
                                    </div>

                                    <p class="text-sm text-gray-500 mb-4">Share this link via</p>

                                    <div class="flex gap-4 mb-8">
                                        <?php echo do_shortcode('[Sassy_Social_Share]'); ?>
                                    </div>

                                    <p class="text-sm text-gray-500 mb-2">Or copy link</p>
                                    <div class="flex items-center gap-2 border border-gray-200 rounded-lg p-2 bg-gray-50">
                                        <i class="fa-solid fa-link text-gray-400 ml-2"></i>
                                        <input type="text" readonly value="<?php the_permalink(); ?>" id="shareInput"
                                            class="bg-transparent border-none text-sm w-full focus:ring-0 text-gray-600">
                                        <button onclick="copyShareLink()"
                                            class="bg-[#6366f1] text-white px-4 py-1.5 rounded-md text-sm font-medium hover:bg-[#4f46e5] transition-colors">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="a2a_kit a2a_default_style flex items-center gap-4">
                                <a class="a2a_button_x"></a>
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_linkedin"></a>
                            </div>


                            <a href="<?= esc_url(get_permalink()) ?>" download
                                class="flex items-center gap-2 text-[#1C3664] hover:text-[#0B1F3B]">
                                Download
                                <i class="fa-solid fa-download text-[14px]"></i>
                            </a>

                        </div>
                    </div>
                </div>
            </section>
            <!-- POST FEATURED IMAGE -->
            <?php if (has_post_thumbnail()): ?>
                <section class="pb-16">
                    <div class="w-[100%]">
                        <div class="overflow-hidden ">
                            <?php the_post_thumbnail(
                                'large',
                                [
                                    'class' => 'w-full h-auto object-cover',
                                    'loading' => 'lazy'
                                ]
                            ); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- POST CONTENT -->
            <section class="pb-32">
                <div class="mx-auto max-w-[900px] px-6">
                    <article class="prose prose-lg post-content prose-slate max-w-none pb-[50px]">
                        <?php the_content(); ?>
                    </article>
                    <div class="flex items-center justify-between gap-6 border-t border-[#1C3664] py-[15px]">
                        <div class="flex items-center  gap-6">
                            <button id="openShareModal"
                                class="flex items-center gap-2 text-[#1C3664]/70 hover:text-[#0B1F3B] transition-colors">
                                <span>Share</span>
                            </button>
                            <div id="shareModal"
                                class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
                                <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl relative mx-4">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="text-xl font-semibold text-[#0B1F3B]">Share Modal</h3>
                                        <button id="closeShareModal" class="text-gray-400 hover:text-gray-600">
                                            <i class="fa-solid fa-xmark text-xl"></i>
                                        </button>
                                    </div>

                                    <p class="text-sm text-gray-500 mb-4">Share this link via</p>

                                    <div class="flex gap-4 mb-8">
                                        <?php echo do_shortcode('[Sassy_Social_Share]'); ?>
                                    </div>

                                    <p class="text-sm text-gray-500 mb-2">Or copy link</p>
                                    <div class="flex items-center gap-2 border border-gray-200 rounded-lg p-2 bg-gray-50">
                                        <i class="fa-solid fa-link text-gray-400 ml-2"></i>
                                        <input type="text" readonly value="<?php the_permalink(); ?>" id="shareInput"
                                            class="bg-transparent border-none text-sm w-full focus:ring-0 text-gray-600">
                                        <button onclick="copyShareLink()"
                                            class="bg-[#6366f1] text-white px-4 py-1.5 rounded-md text-sm font-medium hover:bg-[#4f46e5] transition-colors">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="a2a_kit a2a_default_style flex items-center gap-4">
                                <a class="a2a_button_x"></a>
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_linkedin"></a>
                            </div>
                        </div>

                        <a href="<?= esc_url(get_permalink()) ?>" download
                            class="flex items-center gap-2 text-[#1C3664] hover:text-[#0B1F3B]">
                            Download
                            <i class="fa-solid fa-download text-[14px]"></i>
                        </a>

                    </div>
                    <?php
                    $enable = get_field('post_cta_enable', 'option');
                    if ($enable):
                        $subtitle = get_field('post_cta_subtitle', 'option');
                        $title = get_field('post_cta_title', 'option');
                        $btn_text = get_field('post_cta_button_text', 'option');
                        $btn_link = get_field('post_cta_button_link', 'option');

                        $btn_url = $btn_link['url'] ?? '#';
                        $btn_target = $btn_link['target'] ?? '_self';
                        ?>
                        <section class="my-20">
                            <div class="max-w-7xl mx-auto ">

                                <div class="relative overflow-hidden rounded-xl
                                    bg-gradient-to-br from-[#0B1F3B] to-[#07162B]
                                    text-white p-[25px]
                                    flex flex-col lg:flex-row
                                    items-start lg:items-center justify-between gap-8">

                                    <div>
                                        <?php if ($subtitle): ?>
                                            <p class="text-sm uppercase tracking-wide text-white/70 mb-3">
                                                <?= esc_html($subtitle); ?>
                                            </p>
                                        <?php endif; ?>

                                        <?php if ($title): ?>
                                            <h3 class="text-[24px]  font-semibold max-w-xl">
                                                <?= esc_html($title); ?>
                                            </h3>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($btn_text && $btn_link): ?>
                                        <a href="<?= esc_url($btn_url); ?>" target="<?= esc_attr($btn_target); ?>"
                                            class="btn-get-started inline-flex items-center gap-4 bg-[#FCC937] text-[#0B1F3B]  py-4 rounded-lg font-medium hover:bg-[#f5c62f] transition-colors">

                                            <span class="btn-get-started__text pl-[15px]">
                                                <?= esc_html($btn_text); ?>
                                            </span>

                                            <span
                                                class="btn-get-started__icon w-[40px] h-[40px] bg-[#0B1F3B] text-white rounded-md flex items-center justify-center">
                                                <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                            </span>

                                        </a>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </section>
                    <?php endif; ?>

                </div>
            </section>

        <?php endwhile; endif; ?>

</main>
<?php
$related_posts = design_get_related_posts([
    'posts_per_page' => 3,
    'post__not_in' => [get_the_ID()],
]);
?>

<section class="py-20">
    <div class="max-w-7xl mx-auto px-6">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center gap-4">
                <span class="w-[2px] h-[24px] bg-[#FCC937]"></span>
                <?php
                $related_title = get_field('related_resources_title', 'option');
                ?>
                <h2 class="text-xl font-medium text-[#1C3664]">
                    <?= esc_html($related_title ?: 'Related resources'); ?>
                </h2>
            </div>


            <?php
            $secondary_enable = get_field('post_secondary_cta_enable', 'option');

            if ($secondary_enable):
                $secondary_text = get_field('post_secondary_cta_text', 'option');
                $secondary_link = get_field('post_secondary_cta_link', 'option');
                $secondary_url = $secondary_link['url'] ?? '#';
                $secondary_target = $secondary_link['target'] ?? '_self';
                ?>
                <?php if ($secondary_text && $secondary_link): ?>
                    <button href="<?= esc_url($secondary_url); ?>" target="<?= esc_attr($secondary_target); ?>" class="inline-flex items-center gap-3 px-5 py-2.5
                 btn-non-bg text-[#1c3664] ">
                        <span><?= esc_html($secondary_text); ?></span>
                    </button>
                <?php endif; ?>
            <?php endif; ?>

        </div>

        <!-- GRID -->
        <div class="sm:block lg:grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php foreach ($related_posts as $p): ?>
                <article class="sm:mb[15px]">
                    <a href="<?= get_permalink($p->ID); ?>" class="block overflow-hidden rounded-sm custom-cut-corner">
                        <?= get_the_post_thumbnail($p->ID, 'medium_large', [
                            'class' => 'w-full sm:h-[420px] lg:h-[220px]  object-cover'
                        ]); ?>
                    </a>

                    <h3 class="mt-4 text-[16px] font-medium text-[#1C3664]">
                        <?= esc_html(get_the_title($p->ID)); ?>
                    </h3>

                    <div class="mt-2 flex gap-4 text-sm text-[#1C3664]/70">
                        <span><?= get_the_date('F j, Y', $p->ID); ?></span>
                        <span><?= design_get_category($p->ID); ?></span>
                        <span><?= design_get_read_time($p->ID); ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php
$split_panel = design_get_split_hover_panel_data('option');

if ($split_panel):
    $left = $split_panel['left'];
    $right = $split_panel['right'];
    ?>
    <section class="split-hover-block bg-[#081427] py-[80px] px-5 flex justify-center">
        <div class="split-container relative w-full max-w-[1200px] flex gap-5 h-[500px]">

            <!-- LEFT PANEL -->
            <div
                class="split-panel left-panel is-collapsed relative overflow-hidden rounded-xl cursor-pointer flex-1 bg-[#1a335d]">
                <div class="panel-content relative z-20 p-10 text-white w-full">

                    <?php if ($left['title']): ?>
                        <h3 class="text-[28px] font-semibold mb-4"><?= esc_html($left['title']); ?></h3>
                    <?php endif; ?>

                    <?php if ($left['desc']): ?>
                        <div class="text-base max-w-[500px] leading-[1.5]">
                            <?= wp_kses_post($left['desc']); ?>
                        </div>
                    <?php endif; ?>

                    <div
                        class="absolute top-10 right-10 w-10 h-10 flex items-center justify-center rounded bg-[#ffcc41] text-[#1a335d]">
                        <i class="fa-solid fa-arrow-right -rotate-45"></i>
                    </div>
                </div>

                <!-- MEDIA -->
                <div class="panel-media panel-media--left absolute inset-0 z-10 pointer-events-none">

                    <?php if ($left['media_type'] === 'video' && $left['video']): ?>
                        <video class="absolute w-[406px] h-[354px] object-cover left-[200px] bottom-[-50px]"
                            src="<?= esc_url($left['video']['url']); ?>" muted loop playsinline></video>
                    <?php elseif ($left['image']): ?>
                        <img class="absolute w-[406px] h-[354px] object-cover left-[200px] bottom-[-50px]"
                            src="<?= esc_url($left['image']['url']); ?>" alt="">
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div
                class="split-panel right-panel is-expanded relative overflow-hidden rounded-xl cursor-pointer flex-1 bg-[#ffcc41]">
                <div class="panel-content relative z-20 p-10 text-[#081427] w-full">

                    <?php if ($right['title']): ?>
                        <h3 class="text-[28px] font-semibold mb-4"><?= esc_html($right['title']); ?></h3>
                    <?php endif; ?>

                    <?php if ($right['desc']): ?>
                        <div class="text-base max-w-[500px] leading-[1.5]">
                            <?= wp_kses_post($right['desc']); ?>
                        </div>
                    <?php endif; ?>

                    <div
                        class="absolute top-10 right-10 w-10 h-10 flex items-center justify-center rounded bg-[#1a335d] text-white">
                        <i class="fa-solid fa-arrow-right -rotate-45"></i>
                    </div>
                </div>

                <?php if ($right['image']): ?>
                    <div class="absolute inset-0 z-10 pointer-events-none">
                        <img class="panel-media__el panel-media--right-img" src="<?= esc_url($right['image']['url']); ?>"
                            alt="">
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
<?php endif; ?>

<script>
    const modal = document.getElementById('shareModal');
    const openBtn = document.getElementById('openShareModal');
    const closeBtn = document.getElementById('closeShareModal');

    openBtn.onclick = () => modal.classList.remove('hidden');

    closeBtn.onclick = () => modal.classList.add('hidden');
    window.onclick = (event) => {
        if (event.target == modal) modal.classList.add('hidden');
    }

    function copyShareLink() {
        const copyText = document.getElementById("shareInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        const btn = event.target;
        const originalText = btn.innerText;
        btn.innerText = "Copied!";
        setTimeout(() => { btn.innerText = originalText; }, 2000);
    }
</script>

<script>
    // Collapsed và expanded split-hover block
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".split-hover-block").forEach((block) => {
            const leftPanel = block.querySelector(".left-panel");
            const rightPanel = block.querySelector(".right-panel");
            if (!leftPanel || !rightPanel) return;

            const leftVideo = leftPanel.querySelector(".panel-media video");

            leftPanel.classList.add("is-collapsed");
            rightPanel.classList.add("is-expanded");

            leftPanel.addEventListener("mouseenter", () => {
                leftPanel.classList.add("is-expanded");
                leftPanel.classList.remove("is-collapsed");
                rightPanel.classList.add("is-collapsed");
                rightPanel.classList.remove("is-expanded");

                if (leftVideo) {
                    leftVideo.currentTime = 0;
                    leftVideo.play().catch(() => { });
                }
            });

            rightPanel.addEventListener("mouseenter", () => {
                rightPanel.classList.add("is-expanded");
                rightPanel.classList.remove("is-collapsed");
                leftPanel.classList.add("is-collapsed");
                leftPanel.classList.remove("is-expanded");

                if (leftVideo) {
                    leftVideo.pause();
                    leftVideo.currentTime = 0;
                }
            });
        });
    });

</script>
<?php get_footer(); ?>