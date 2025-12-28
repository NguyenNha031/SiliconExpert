<?php
/**
 * Video Background Wrapper Block
 */
?>

<section class="relative overflow-hidden min-h-[720px]">

    <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
        <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/video-bg.mp4" type="video/mp4">
    </video>
    <div class="relative z-10
        px-4 sm:px-8 lg:px-[95px]
        sm:mt-[110px]  lg:mt-[160px]">
        <?php if (is_admin()): ?>
            <InnerBlocks />
        <?php else: ?>
            <?php echo $content; ?>
        <?php endif; ?>
    </div>
</section>