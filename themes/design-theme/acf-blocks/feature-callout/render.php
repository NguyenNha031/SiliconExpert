<?php
$slides = get_field('slides');
$subhead = get_field('subhead') ?: 'Subhead scroll animated module';
$cta_text = !empty($slide['cta_text']) ? $slide['cta_text'] : 'Secondary CTA';
if (!$slides)
    return;
?>
<section class="feature-callout relative py-15 lg:py-32 lg:h-[870px] h-[auto] overflow-hidden">
    <div class="pl-[15px] lg:pl-[95px] mx-auto relative">
        <div class="flex items-center gap-4   relative lg:right-[50px]">
            <span class="w-[2px] h-[24px] bg-[#FCC937]"></span>
            <span class="text-white text-[20px]">
                <?php echo esc_html($subhead); ?>
            </span>
            <div class="absolute right-10 lg:flex items-center gap-4 text-white/60 text-sm hidden ">
                <div class="fc-progress relative w-[72px] h-[2px] bg-white/30 overflow-hidden">
                    <span
                        class="fc-progress__bar absolute left-0 top-0 h-full w-1/3 bg-white transition-transform duration-500"></span>
                </div>
                <div>
                    <span id="fc-current">1</span> /
                    <span><?php echo count($slides); ?></span>
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:block relative">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="feature-slide transition-opacity duration-700 ease-in-out
            relative opacity-100 z-10 mb-20 last:mb-0 
            lg:absolute lg:inset-0 lg:mb-0 
            <?php echo $index === 0 ? 'lg:opacity-100 lg:z-10' : 'lg:opacity-0 lg:z-0'; ?>"
                    data-slide="<?php echo $index; ?>">
                    <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-20 items-center">
                        <div
                            class="lg:max-w-[520px] max-w-[490px] text-white lg:pl-[0] pl-[15px] mt-[100px] min-h-[420px]  fc-left-content">
                            <?php if (!empty($slide['logo'])): ?>
                                <div class="mb-6">
                                    <img src="<?php echo esc_url($slide['logo']['url']); ?>"
                                        alt="<?php echo esc_attr($slide['logo']['alt'] ?? ''); ?>"
                                        class="w-[34px] h-[34px] object-contain" />
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($slide['headline'])): ?>
                                <h2 class="text-[32px] leading-[1.15] font-medium mb-6">
                                    <?php echo esc_html($slide['headline']); ?>
                                </h2>
                            <?php endif; ?>
                            <?php if (!empty($slide['description'])): ?>
                                <p class="text-white text-[16px] leading-[1.7] mb-10">
                                    <?php echo esc_html($slide['description']); ?>
                                </p>
                            <?php endif; ?>
                            <button class="btn-non-bg h-[48px]">
                                <?php echo esc_html($cta_text); ?>
                            </button>
                        </div>
                        <div class="relative bottom-0 lg:bottom-[-100px] ml-[75px] lg:ml-[0]">
                            <?php if (!empty($slide['image'])): ?>
                                <div class="relative inline-block">
                                    <div
                                        class="absolute top-0 left-[203px] w-[64px] h-[2px] bg-gradient-to-r from-[#2E7BFF] to-transparent z-20 shadow-[0_0_8px_#2E7BFF]">
                                    </div>

                                    <div
                                        class="p-[1.5px] rounded-[15px] bg-gradient-to-b from-[#2E7BFF]/60 via-[#2E7BFF]/20 to-white/10 shadow-2xl border border-white/5">
                                        <div class="rounded-[14px] p-5 bg-[#0e1a32]">
                                            <img src="<?php echo esc_url($slide['image']['url']); ?>" alt=""
                                                class="block lg:w-[852px] lg:h-[520px] w-[511px] h-[324px] rounded-[10px] max-w-none bg-white shadow-lg" />
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>