<?php
/**
 * Ranked Features Block
 */

$items = get_field('ranked_items');

if (empty($items))
    return;
?>
<section class="relative pb-[20px] ">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        <?php foreach ($items as $item): ?>
            <div class="relative text-white h-[188px] w-[298px]">
                <h3 class="text-[40px] font-semibold leading-tight
                           text-[#8ab4ff]
                           drop-shadow-[0_0_12px_rgba(138,180,255,0.7)]">
                    Ranked
                    <span class="block">
                        #<?php echo intval($item['rank_number']); ?>
                    </span>
                </h3>
                <p class="mt-4 text-[14px] leading-[1.6] text-white/80 w-[130%] lg:w-[250px]">
                    <?php echo esc_html($item['description']); ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</section>