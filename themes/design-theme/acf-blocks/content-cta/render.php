<?php
/**
 * Content + CTA Block
 */

$eyebrow = get_field('eyebrow_text');
$heading = get_field('heading');
$desc = get_field('description');

$primary_enable = get_field('primary_cta_enable');
$primary_text = get_field('primary_cta_text') ?: 'Primary CTA';
$primary_link = get_field('primary_cta_link');

$secondary_enable = get_field('secondary_cta_enable');
$secondary_text = get_field('secondary_cta_text') ?: 'Secondary CTA';
$secondary_link = get_field('secondary_cta_link');
?>

<section class="content-block mt-[100px]  min-h-[400px] lg:min-h-[708px] ">
    <?php if ($eyebrow): ?>
        <div class="content-eyebrow
            font-ibm
            text-[16px] sm:text-[18px] lg:text-[20px]
            font-medium
            leading-[1.5]
            tracking-normal
            mb-3
            text-[#FCC937]
        ">
            <?php echo esc_html($eyebrow); ?>
        </div>
    <?php endif; ?>
    <?php if ($heading): ?>
        <div class="max-w-full lg:max-w-[654px]">
            <h1 class="content-heading
                font-ibm
                text-[36px] sm:text-[44px] lg:text-[64px]
                font-medium
                leading-[1.15]
                tracking-normal
                text-white
            ">
                <?php echo nl2br(esc_html($heading)); ?>
            </h1>
        </div>
    <?php endif; ?>
    <?php if ($desc): ?>
        <p class="content-desc
            mt-6 lg:mt-8
            max-w-full lg:max-w-[560px]
            font-ibm
            text-[16px] sm:text-[18px] lg:text-[20px]
            font-normal
            leading-[1.5]
            tracking-normal
            text-white
        ">
            <?php echo esc_html($desc); ?>
        </p>
    <?php endif; ?>
    <div class="flex gap-4 mt-10 absolute lg:bottom-[40%]">

        <!-- PRIMARY CTA -->
        <?php if ($primary_enable): ?>
            <?php
            $primary_url = '#';
            $primary_target = '_self';

            if (is_array($primary_link) && !empty($primary_link['url'])) {
                $primary_url = $primary_link['url'];
                $primary_target = $primary_link['target'] ?: '_self';
            }
            ?>
            <a href="<?= esc_url($primary_url) ?>" target="<?= esc_attr($primary_target) ?>"
                class="btn-get-started w-[195px] h-[56px]">

                <span class="btn-get-started__text w-[150px] px-[19px]">
                    <?= esc_html($primary_text) ?>
                </span>

                <span class="btn-get-started__icon w-[48px] h-[48px]">
                    <i class="fa-solid fa-arrow-right text-[18px] rotate-[-30deg]"></i>
                </span>
            </a>
        <?php endif; ?>


        <!-- SECONDARY CTA -->
        <?php if ($secondary_enable): ?>
            <?php
            $secondary_url = '#';
            $secondary_target = '_self';

            if (is_array($secondary_link) && !empty($secondary_link['url'])) {
                $secondary_url = $secondary_link['url'];
                $secondary_target = $secondary_link['target'] ?: '_self';
            }
            ?>
            <a href="<?= esc_url($secondary_url) ?>" target="<?= esc_attr($secondary_target) ?>"
                class="btn-non-bg h-[56px] w-[177px] flex items-center justify-center">
                <?= esc_html($secondary_text) ?>
            </a>
        <?php endif; ?>

    </div>

</section>