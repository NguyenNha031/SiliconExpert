<?php
$logo_icon = get_field('header_logo_icon', 'option');
$logo_text = get_field('header_logo_text', 'option');
$footer_cta_enable = get_field('footer_cta_enable', 'option');
$footer_cta_text = get_field('footer_cta_text', 'option') ?: 'Get Started';
$footer_cta_link = get_field('footer_cta_link', 'option');
$copyright_text = get_field('footer_copyright_text', 'option');
$privacy_text = get_field('footer_privacy_text', 'option') ?: 'Privacy Policy';
$middle_text = get_field('footer_middle_text', 'option');
$terms_text = get_field('footer_terms_text', 'option') ?: 'Terms of Use';
$privacy_link = get_field('footer_privacy_link', 'option');
$terms_link = get_field('footer_terms_link', 'option');
?>
<footer class="bg-[#1f3764] text-white sticky bottom-0 -z-[5]">
    <?php
    $logo_icon = get_field('header_logo_icon', 'option');
    $logo_text = get_field('header_logo_text', 'option');

    $locations = get_nav_menu_locations();
    $menu_items = isset($locations['primary'])
        ? wp_get_nav_menu_items($locations['primary'])
        : [];

    if (!is_array($menu_items)) {
        $menu_items = [];
    }

    if (!function_exists('menu_children')) {
        function menu_children($parent_id, $items)
        {
            return array_values(array_filter(
                $items,
                fn($i) => (int) $i->menu_item_parent === (int) $parent_id
            ));
        }
    }

    $level_1 = array_filter(
        $menu_items,
        fn($i) => (int) $i->menu_item_parent === 0
    );

    $solutions = null;
    $services = null;
    $products = null;
    $partner = null;
    $resources = null;
    $company_root = null;
    $become_partner_item = null;

    foreach ($level_1 as $item) {
        if (trim($item->title) === 'Company') {
            $company_root = $item;
            break;
        }
    }

    foreach ($level_1 as $root) {
        foreach (menu_children($root->ID, $menu_items) as $col) {
            $title = trim($col->title);

            if ($title === 'Solutions')
                $solutions = $col;
            if ($title === 'Services')
                $services = $col;
            if ($title === 'Products')
                $products = $col;
            if ($title === 'Partner Integrations')
                $partner = $col;
            if (in_array($title, ['Resources', 'Resources Main']))
                $resources = $col;
            if ($title === 'Become a Partner')
                $become_partner_item = $col;
        }
    }

    $partner_links = $partner
        ? menu_children($partner->ID, $menu_items)
        : [];

    if ($become_partner_item) {
        $partner_links[] = $become_partner_item;
    }

    $company_links = $company_root
        ? menu_children($company_root->ID, $menu_items)
        : [];

    ?>
    <!-- MAIN FOOTER -->
    <div class="max-w-7xl mx-auto px-6 pt-16 pb-16">
        <div class="grid grid-cols-12 gap-x-16 gap-y-14">

            <!-- LOGO -->
            <div class="col-span-12 lg:col-span-4">
                <?php if ($logo_icon || $logo_text): ?>
                    <div class="header-logo flex items-center gap-3 h-[36px]">
                        <?php if ($logo_icon): ?>
                            <img src="<?= esc_url($logo_icon['url']) ?>" alt="<?= esc_attr($logo_icon['alt'] ?: 'Logo Icon') ?>"
                                class="logo-icon h-[26px] w-auto object-contain cursor-pointer" />
                        <?php endif; ?>

                        <?php if ($logo_text): ?>
                            <img src="<?= esc_url($logo_text['url']) ?>" alt="<?= esc_attr($logo_text['alt'] ?: 'Logo Text') ?>"
                                class="logo-text h-[22px] w-auto object-contain hidden sm:block cursor-pointer" />
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>


            <!-- SOLUTIONS + SERVICES -->
            <div class="col-span-6 lg:col-span-2">
                <?php if ($solutions): ?>
                    <h4 class="text-[14px] font-semibold mb-4">
                        <?= esc_html($solutions->title); ?>
                    </h4>
                    <ul class="space-y-3 text-[14px] text-white/70 mb-8">
                        <?php foreach (menu_children($solutions->ID, $menu_items) as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ($services): ?>
                    <h4 class="text-[14px] font-semibold mb-4">
                        <?= esc_html($services->title); ?>
                    </h4>
                    <ul class="space-y-3 text-[14px] text-white/70">
                        <?php foreach (menu_children($services->ID, $menu_items) as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- PRODUCTS -->
            <div class="col-span-6 lg:col-span-2">
                <?php if ($products): ?>
                    <h4 class="text-[14px] font-semibold mb-6">
                        <?= esc_html($products->title); ?>
                    </h4>
                    <ul class="space-y-3 text-[14px] text-white/70">
                        <?php foreach (menu_children($products->ID, $menu_items) as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- PARTNERS + RESOURCES -->
            <div class="col-span-6 lg:col-span-2">
                <?php if ($partner): ?>
                    <div class="mb-8">
                        <h4 class="text-[14px] font-semibold mb-6">
                            <?= esc_html($partner->title); ?>
                        </h4>
                        <ul class="space-y-3 text-[14px] text-white/70">
                            <?php foreach ($partner_links as $item): ?>
                                <li>
                                    <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                        <?= esc_html($item->title); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($resources): ?>
                    <h4 class="text-[14px] font-semibold mb-6">
                        <?= esc_html($resources->title); ?>
                    </h4>
                    <ul class="space-y-3 text-[14px] text-white/70">
                        <?php foreach (menu_children($resources->ID, $menu_items) as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- COMPANY -->
            <div class="col-span-6 lg:col-span-2">
                <?php if ($company_root): ?>
                    <h4 class="text-[14px] font-semibold mb-6">
                        <?= esc_html($company_root->title); ?>
                    </h4>

                    <ul class="space-y-3 text-[14px] text-white/70">
                        <?php foreach ($company_links as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="hover:text-[#FCC937]">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <!-- CTA -->
                <?php if ($footer_cta_enable): ?>
                    <?php
                    $cta_url = '#';
                    if (is_array($footer_cta_link) && !empty($footer_cta_link['url'])) {
                        $cta_url = $footer_cta_link['url'];
                    }
                    ?>
                    <div class="mt-6">
                        <button class="btn-get-started" onclick="window.location.href='<?= esc_url($cta_url) ?>'">
                            <span class="btn-get-started__text">
                                <?= esc_html($footer_cta_text) ?>
                            </span>
                            <span class="btn-get-started__icon w-[40px] h-[40px]">
                                <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                            </span>
                        </button>
                    </div>
                <?php endif; ?>

            </div>


        </div>
    </div>
    <div class="border-t border-white/10 w-[80%]">
        <div class="max-w-7xl mx-auto px-6 py-5
        lg:flex flex-col lg:flex-row
        justify-between items-center
        pl-0
        text-[13px] text-white/60 ml-[30px] w-[80%]">

            <p>
                <?= esc_html($copyright_text ?: '© ' . date('Y') . ' SiliconExpert. All rights reserved.') ?>
            </p>

            <?php if (!empty($middle_text)): ?>
                <p class="lg:text-center">
                    <?= esc_html($middle_text) ?>
                </p>
            <?php endif; ?>

            <div class="flex gap-6">
                <?php if ($privacy_link && !empty($privacy_link['url'])): ?>
                    <a href="<?= esc_url($privacy_link['url']) ?>"
                        target="<?= esc_attr($privacy_link['target'] ?: '_self') ?>" class="hover:text-white">
                        <?= esc_html($privacy_text) ?>
                    </a>
                <?php endif; ?>

                <?php if ($terms_link && !empty($terms_link['url'])): ?>
                    <a href="<?= esc_url($terms_link['url']) ?>" target="<?= esc_attr($terms_link['target'] ?: '_self') ?>"
                        class="hover:text-white">
                        <?= esc_html($terms_text) ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

</footer>