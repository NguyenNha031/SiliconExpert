<?php
/**
 * Testimonial Slider Block
 */

$slides = get_field('slides');

if (empty($slides)) {
    if (is_admin()) {
        echo '<p style="padding:16px;border:1px dashed #ccc;">Add testimonial slides</p>';
    }
    return;
}

$total = count($slides);
?>

<section class="testimonial-slider
    testimonial-gradient
    relative overflow-hidden
    bg-[#11213F]
    text-white
    h-[600px]
    flex items-center">

    <div class="max-w-[75%] mx-auto px-4 lg:px-0 relative w-full h-full">

        <?php foreach ($slides as $index => $slide):
            $is_active = $index === 0;
            ?>
            <div class="testimonial-slide
                       transition-opacity duration-700 ease-in-out
                       <?php echo $is_active ? 'opacity-100 z-10 is-active' : 'opacity-0 z-0'; ?>
                       lg:absolute lg:inset-0
                       flex items-center" data-slide="<?php echo $index; ?>">

                <div class="flex items-center justify-between w-full">

                    <!-- LEFT CONTENT -->
                    <div class="max-w-[728px]">

                        <?php if (!empty($slide['company_logo'])): ?>
                            <img src="<?php echo esc_url($slide['company_logo']['url']); ?>" alt=""
                                class="h-[28px] mb-8 opacity-90" />
                        <?php endif; ?>

                        <?php if (!empty($slide['quote'])): ?>
                            <blockquote class="text-[34px] lg:text-[32px] leading-[1.35] font-medium">
                                “<?php echo esc_html($slide['quote']); ?>”
                            </blockquote>
                        <?php endif; ?>

                    </div>

                    <!-- RIGHT AUTHOR -->
                    <div class="flex flex-col lg:text-left shrink-0">

                        <?php if (!empty($slide['author_avatar'])): ?>
                            <img src="<?php echo esc_url($slide['author_avatar']['url']); ?>" alt=""
                                class="w-[191px] h-[191px] rounded-sm object-cover mb-6" />
                        <?php endif; ?>

                        <?php if (!empty($slide['author_name'])): ?>
                            <p class="font-semibold text-lg">
                                <?php echo esc_html($slide['author_name']); ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($slide['author_title'])): ?>
                            <p class="text-white/70 text-sm mt-1">
                                <?php echo esc_html($slide['author_title']); ?>
                            </p>
                        <?php endif; ?>

                    </div>

                </div>

            </div>
        <?php endforeach; ?>

        <!-- INDICATOR + ARROWS -->
        <div class="absolute bottom-[100px] left-0 right-0 flex items-center justify-between text-sm text-white/70">

            <!-- LEFT: INDICATOR -->
            <div class="flex justify-between w-[728px] ">
                <div>
                    <span class="w-[2px] h-[24px] block relative top-[12px] bg-[#FCC937]"></span>

                    <div class="relative w-[72px] h-[2px] bg-white/30 overflow-hidden ml-4">
                        <span class="absolute left-0 top-0 h-full w-1/2 bg-white"></span>
                    </div>
                </div>

                <div class="flex items-center gap-6">

                    <button type="button" class="ts-prev w-[36px] h-[36px] flex items-center justify-center 
                    hover:border-white transition" aria-label="Previous testimonial">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    <button type="button" class="ts-next w-[36px] h-[36px] flex items-center justify-center 
                    hover:border-white transition hover:cusor" aria-label="Next testimonial">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                </div>
            </div>


        </div>

    </div>

</section>