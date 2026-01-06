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
        text-white
        h-[600px]
        flex items-center
        bg-cover bg-center bg-no-repeat"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/bg-testimonial.jpg');">


    <div class="max-w-[75%] mx-auto px-4 lg:px-0 relative w-full h-full">

        <?php foreach ($slides as $index => $slide):
            $is_active = $index === 0;
            ?>
            <div class="testimonial-slide
    absolute inset-0
    items-center
    transition-opacity duration-700 ease-in-out
    <?php echo $is_active ? 'opacity-100 z-10 is-active' : 'opacity-0 z-0 pointer-events-none'; ?>
    flex  
">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between w-full gap-8 text-left">



                    <!-- LEFT CONTENT -->
                    <div class="max-w-[728px] order-3 lg:order-1">

                        <?php if (!empty($slide['company_logo'])): ?>
                            <img src="<?php echo esc_url($slide['company_logo']['url']); ?>" alt=""
                                class="h-[24px] mb-6 opacity-90 block mt-6" />
                        <?php endif; ?>

                        <?php if (!empty($slide['quote'])): ?>
                            <blockquote class="mt-8 text-[20px] leading-[1.5] lg:text-[32px] lg:mt-0">

                                “<?php echo esc_html($slide['quote']); ?>”
                            </blockquote>
                        <?php endif; ?>

                        <?php if (!empty($slide['company_logo'])): ?>
                            <img src="<?php echo esc_url($slide['company_logo']['url']); ?>" alt=""
                                class="h-[28px] mt-8 opacity-90 hidden lg:block" />
                        <?php endif; ?>

                    </div>


                    <!-- RIGHT AUTHOR -->
                    <div class="flex flex-row lg:flex-col items-center lg:items-start gap-4 shrink-0 order-1 lg:order-2">



                        <?php if (!empty($slide['author_avatar'])): ?>
                            <img src="<?php echo esc_url($slide['author_avatar']['url']); ?>" alt="" class="w-[96px] h-[96px] lg:w-[191px] lg:h-[191px]
            rounded-sm object-cover mb-4" />
                        <?php endif; ?>
                        <div class="pb-[70px]">
                            <?php if (!empty($slide['author_name'])): ?>
                                <p class="font-semibold text-base lg:text-lg">
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

            </div>
        <?php endforeach; ?>

        <!-- INDICATOR + ARROWS -->
        <div
            class="absolute bottom-[100px] left-0 right-0 flex items-center justify-between text-sm text-white z-20 pointer-events-auto">

            <!-- LEFT: INDICATOR -->
            <div class="flex justify-between w-[728px] ">
                <div>
                    <span class="w-[2px] h-[24px] block relative top-[12px] bg-[#FCC937]"></span>

                    <div class="relative w-[72px] h-[2px] bg-white/30 overflow-hidden ml-4">
                        <span class="absolute left-0 top-0 h-full w-1/2 bg-white ts-progress__bar"></span>
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