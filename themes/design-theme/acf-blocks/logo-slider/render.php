<?php
/**
 * Logo Slider Block
 */
$label = get_field('label');
$logo_data = get_field('logo_image');

$logo_url = '';
if ($logo_data) {

    $logo_url = is_array($logo_data) ? $logo_data['url'] : $logo_data;
}

if (!$logo_url) {
    if (is_admin()) {
        echo '<p style="color:red; padding: 20px; border: 1px dashed red;">Vui lòng chọn ảnh cho Logo Slider.</p>';
    }
    return;
}
?>

<section class="pt-25  wp-block-group h-[400px] logo-slider-block bg-[#11213F]">
    <?php if ($label): ?>
        <div class="flex items-center gap-4 mb-30 lg:pl-[36px] pl-[15px]">
            <span class="w-[2px] h-[24px] bg-[#FCC937]"></span>
            <span class="text-[20px] text-white">
                <?php echo esc_html($label); ?>
            </span>
        </div>
    <?php endif; ?>

    <div class="relative overflow-hidden">
        <div class="logo-marquee relative z-10">
            <div class="logo-marquee__track flex items-center gap-10" data-logo-track>
                <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" class="max-h-[60px] w-auto object-contain">
            </div>
        </div>

        <div
            class="pointer-events-none absolute left-0 top-0 h-full w-[200px] bg-gradient-to-r from-[#11213F] to-transparent z-10">
        </div>
        <div
            class="pointer-events-none absolute right-0 top-0 h-full w-[200px] bg-gradient-to-l from-[#11213F] to-transparent z-10">
        </div>
    </div>
</section>