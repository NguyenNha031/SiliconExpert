<?php
/**
 * Content Block (no CTA)
 */
$eyebrow = get_field('eyebrow_text');
$heading = get_field('heading');
$desc = get_field('description');
$primary_cta_text = get_field('primary_cta_text') ?: 'Primary CTA';
$secondary_cta_text = get_field('secondary_cta_text') ?: 'Secondary CTA';
?>
<section class="content-block  min-h-[400px] lg:min-h-[708px] ">
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
    <div class="flex  gap-4 mt-10 absolute lg:bottom-[40%] ">
        <button class="btn-get-started w-[195px] h-[56px]">
            <span class="btn-get-started__text px-[30px]">
                <?php echo esc_html($primary_cta_text); ?>
            </span>
            <span class="btn-get-started__icon w-[48px] h-[48px]">
                <i class="fa-solid fa-arrow-right text-[18px] rotate-[-30deg]"></i>
            </span>
        </button>
        <button class="btn-non-bg h-[56px] w-[177px]">
            <span>
                <?php echo esc_html($secondary_cta_text); ?>
            </span>
        </button>

    </div>
</section>