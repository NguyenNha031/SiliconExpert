<?php
/**
 * Insights & Resources Block
 */
$section_title = get_field('section_title');
$cta_label = get_field('secondary_cta_label');
$cta_link = get_field('secondary_cta_link');
$featured_media_type = get_field('featured_media_type');
$featured_image = get_field('featured_image');
$featured_video = get_field('featured_video');
$featured_title = get_field('featured_title');
$featured_meta = get_field('featured_meta');
$featured_link = get_field('featured_link');
$side_items = get_field('side_items');
?>
<section class="relative py-20">
    <div class="max-w-7xl  px-4 lg:px-0">
        <div class="flex items-center justify-between mb-14 lg:pl-[36px] pl-0">
            <div class="flex items-center gap-4">
                <span class="w-[2px] h-[24px] bg-[#FCC937]"></span>
                <?php if ($section_title): ?>
                    <h2 class="text-[24px] font-medium text-[#1C3664]">
                        <?php echo esc_html($section_title); ?>
                    </h2>
                <?php endif; ?>
            </div>
            <?php if ($cta_label && $cta_link): ?>
                <a href="<?php echo esc_url($cta_link['url']); ?>" class="btn-non-bg h-[48px] text-[#1C3664]">
                    <?php echo esc_html($cta_label); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-[110px] lg:ml-[95px] ml-[15px]">
            <div class="lg:col-span-8 lg:w-[836px] w-[406px] mb-[40px]">
                <?php if ($featured_link): ?>
                    <a href="<?php echo esc_url($featured_link['url']); ?>"
                        class="group relative block overflow-hidden rounded-sm lg:h-[420px] custom-cut-corner">
                        <?php if ($featured_media_type === 'video' && is_array($featured_video)): ?>
                            <video class="w-full h-full object-cover" muted loop playsinline preload="metadata"
                                data-hover-video>
                                <source src="<?php echo esc_url($featured_video['url']); ?>" type="video/mp4">
                            </video>
                        <?php elseif (is_array($featured_image)): ?>
                            <img src="<?php echo esc_url($featured_image['url']); ?>" class="w-full h-full object-cover" />
                        <?php endif; ?>
                        <span class="absolute top-4 right-4
                        opacity-0 scale-90
                        group-hover:opacity-100 group-hover:scale-100
                        transition-all duration-300
                        bg-[#FCC937]
                        w-[40px] h-[40px]
                        rounded-md
                        flex items-center justify-center">
                            <span class="btn-get-started__icon bg-transparent">
                                <i class="fa-solid fa-arrow-right rotate-[-30deg] text-[#1C3664]"></i>
                            </span>
                        </span>
                    </a>
                <?php endif; ?>
                <?php if ($featured_title): ?>
                    <h3 class="mt-6 text-[20px] font-medium text-[#1C3664]">
                        <?php echo esc_html($featured_title); ?>
                    </h3>
                <?php endif; ?>
                <?php
                $featured_meta = get_field('featured_meta');
                $has_featured_meta =
                    !empty($featured_meta['featured_date']) ||
                    !empty($featured_meta['featured_category']) ||
                    !empty($featured_meta['featured_read_time']);
                ?>
                <?php if ($has_featured_meta): ?>
                    <div class="mt-2 flex items-center gap-4 text-sm font-normal text-[#1C3664]/70">
                        <?php if (!empty($featured_meta['featured_date'])): ?>
                            <span>
                                <?php
                                $date_timestamp = strtotime(str_replace('/', '-', $featured_meta['featured_date']));
                                echo esc_html(date('F j, Y', $date_timestamp));
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($featured_meta['featured_category'])): ?>
                            <span><?php echo esc_html($featured_meta['featured_category']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($featured_meta['featured_read_time'])): ?>
                            <span><?php echo esc_html($featured_meta['featured_read_time']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="lg:col-span-4 flex flex-col gap-5 w-[406px]"> <?php if ($side_items): ?>
                    <?php foreach ($side_items as $item): ?>
                        <div class="side-item-wrapper mb-8"> <a href="<?php echo esc_url($item['link']['url']); ?>"
                                class="group relative block overflow-hidden rounded-sm h-[200px] custom-cut-corner">
                                <?php if ($item['media_type'] === 'video' && is_array($item['video'])): ?>
                                    <video class="w-full h-full object-cover" muted loop playsinline preload="metadata"
                                        data-hover-video>
                                        <source src="<?php echo esc_url($item['video']['url']); ?>" type="video/mp4">
                                    </video>
                                <?php elseif (is_array($item['image'])): ?>
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" class="w-full h-full object-cover" />
                                <?php endif; ?>
                                <span
                                    class="absolute top-4 right-4 opacity-0 scale-90 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300 bg-[#FCC937] w-[40px] h-[40px] rounded-md flex items-center justify-center">
                                    <span class="btn-get-started__icon bg-transparent">
                                        <i class="fa-solid fa-arrow-right rotate-[-30deg] text-[#1C3664]"></i>
                                    </span>
                                </span>
                            </a>
                            <?php if (!empty($item['title'])): ?>
                                <a href="<?php echo esc_url($item['link']['url']); ?>" class="block hover:text-blue-900">
                                    <h4 class="mt-4 text-[16px] font-medium text-[#1C3664]">
                                        <?php echo esc_html($item['title']); ?>
                                    </h4>
                                </a>
                            <?php endif; ?>
                            <?php
                            $item_meta = $item['meta'] ?? [];
                            $has_item_meta = !empty($item_meta['date']) || !empty($item_meta['category']) || !empty($item_meta['read_time']);
                            ?>
                            <?php if ($has_item_meta): ?>
                                <div class="mt-1 flex gap-4 text-sm text-[#1C3664]/70">
                                    <?php if (!empty($item_meta['date'])): ?>
                                        <span><?php echo esc_html(date_i18n('F j, Y', strtotime($item_meta['date']))); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($item_meta['category'])): ?>
                                        <span><?php echo esc_html($item_meta['category']); ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($item_meta['read_time'])): ?>
                                        <span><?php echo esc_html($item_meta['read_time']); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>