<?php
$left = get_field('left_panel');
$right = get_field('right_panel');

if (!$left || !$right)
    return;

$left_title = $left['left_title'] ?? '';
$left_desc = $left['left_desc'] ?? '';
$left_media = $left['left_media_type'] ?? 'image';
$left_img = $left['left_image'] ?? null;
$left_vid = $left['left_video'] ?? null;

$right_title = $right['right_title'] ?? '';
$right_desc = $right['right_desc'] ?? '';
$right_img = $right['right_image'] ?? null;


?>

<section class="split-hover-block bg-[#081427] py-[80px] px-5 flex justify-center">
    <div class="split-container relative w-full max-w-[1200px] flex gap-5 h-[500px]">

        <!-- LEFT PANEL -->
        <div
            class="split-panel left-panel is-collapsed relative overflow-hidden rounded-xl cursor-pointer flex-1 bg-[#1a335d]">
            <!-- TEXT -->
            <div class="panel-content relative z-20 p-10 text-white w-full">
                <?php if ($left_title): ?>
                    <h3 class="panel-title text-[28px] font-semibold mb-4"><?= esc_html($left_title); ?></h3>
                <?php endif; ?>

                <?php if ($left_desc): ?>
                    <div class="panel-desc text-base max-w-[500px] leading-[1.5]">
                        <?= wp_kses_post($left_desc); ?>
                    </div>
                <?php endif; ?>

                <div
                    class="panel-arrow absolute top-10 right-10 w-10 h-10 flex items-center justify-center rounded text-[#1a335d] bg-[#ffcc41]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17" />
                    </svg>
                </div>
            </div>

            <!-- MEDIA -->
            <div class="panel-media panel-media--left absolute inset-0 z-10 pointer-events-none">
                <?php if ($left_media === 'video' && $left_vid): ?>
                    <video
                        class="panel-media__el rounded-sm absolute w-[406px] object-cover h-[354px] left-[200px] bottom-[-50px]"
                        src="<?= esc_url($left_vid['url']); ?>" muted loop playsinline></video>
                <?php elseif ($left_img): ?>
                    <img class="panel-media__el rounded-sm absolute w-[406px] object-cover h-[354px] left-[200px] bottom-[-50px]"
                        src="<?= esc_url($left_img['url']); ?>" alt="">
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div
            class="split-panel right-panel is-expanded relative overflow-hidden rounded-xl cursor-pointer flex-1 bg-[#ffcc41]">
            <div class="panel-content relative z-20 p-10 text-[#081427] w-full">
                <?php if ($right_title): ?>
                    <h3 class="panel-title text-[28px] font-semibold mb-4"><?= esc_html($right_title); ?></h3>
                <?php endif; ?>

                <?php if ($right_desc): ?>
                    <div class="panel-desc text-base max-w-[500px] leading-[1.5]">
                        <?= wp_kses_post($right_desc); ?>
                    </div>
                <?php endif; ?>

                <div
                    class="panel-arrow absolute top-10 right-10 w-10 h-10 flex items-center justify-center rounded bg-[#1a335d] text-white">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17" />
                    </svg>
                </div>
            </div>

            <!-- MEDIA -->
            <?php if ($right_img): ?>
                <div class="panel-media panel-media--right absolute inset-0 z-10 pointer-events-none">
                    <img class=" panel-media__el panel-media--right-img" src="<?= esc_url($right_img['url']); ?>" alt="">
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>