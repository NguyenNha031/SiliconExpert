<?php
/**
 * Post Content CTA Block
 */

$enable = get_field('cta_enable');
if (!$enable)
    return;

$subtitle = get_field('cta_subtitle') ?: 'Subscribe';
$title = get_field('cta_title') ?: 'Get the latest insights, right to your inbox.';

$btn_text = get_field('cta_button_text');
$btn_link = get_field('cta_button_link');

$btn_url = $btn_link['url'] ?? '#';
$btn_target = $btn_link['target'] ?? '_self';
?>

<section class="my-24">
    <div class="max-w-7xl mx-auto px-6">

        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#0B1F3B] to-[#07162B]
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
                <a href="<?= esc_url($btn_url); ?>" target="<?= esc_attr($btn_target); ?>" class="inline-flex items-center gap-4 bg-[#FCC937] text-[#0B1F3B]
                          px-6 py-4 rounded-lg font-medium
                          hover:bg-[#f5c62f] transition-colors">

                    <?= esc_html($btn_text); ?>

                    <span class="w-10 h-10 bg-[#0B1F3B] text-white rounded-md
                               flex items-center justify-center">
                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                    </span>
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>