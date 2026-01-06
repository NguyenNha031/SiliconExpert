<?php
/**
 * Post Content CTA Block
 */

// Ưu tiên block, fallback option
$enable = get_field('cta_enable');
if ($enable === null) {
    $enable = get_field('post_cta_enable', 'option');
}
if (!$enable)
    return;

$subtitle = get_field('cta_subtitle') ?: get_field('post_cta_subtitle', 'option');
$title = get_field('cta_title') ?: get_field('post_cta_title', 'option');
$btn_text = get_field('cta_button_text') ?: get_field('post_cta_button_text', 'option');
$btn_link = get_field('cta_button_link') ?: get_field('post_cta_button_link', 'option');
$btn_url = $btn_link['url'] ?? '#';
$btn_target = $btn_link['target'] ?? '_self';
?>

<section class="my-24 post-cta-wrapper relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <div class="relative post-cta-item overflow-hidden rounded-2xl bg-gradient-to-br from-[#0B1F3B] to-[#07162B]
                   text-white px-10 py-12 flex flex-col lg:flex-row
                   items-start lg:items-center justify-between gap-8">

            <!-- LEFT -->
            <div>
                <?php if ($subtitle): ?>
                    <p class="text-sm uppercase tracking-wide text-white/70 mb-3">
                        <?= esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h3 class="text-2xl lg:text-3xl font-semibold max-w-xl">
                        <?= esc_html($title); ?>
                    </h3>
                <?php endif; ?>
            </div>

            <!-- CTA BUTTON -->
            <?php if ($btn_text && $btn_link): ?>
                <button href="<?= esc_url($btn_url); ?>" target="<?= esc_attr($btn_target); ?>" class="
                           btn-get-started">
                    <span class="btn-get-started__text">
                        <?= esc_html($btn_text); ?>
                    </span>
                    <span class="btn-get-started__icon">
                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                    </span>
                </button>
            <?php endif; ?>

        </div>
    </div>
</section>