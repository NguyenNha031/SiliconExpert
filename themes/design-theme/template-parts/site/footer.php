<footer class="bg-[#1f3764] text-white">

    <?php

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
            return array_filter(
                $items,
                fn($i) => (int) $i->menu_item_parent === (int) $parent_id
            );
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

    foreach ($level_1 as $root) {
        $cols = menu_children($root->ID, $menu_items);

        foreach ($cols as $col) {
            $title = $col->title;

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
            if ($title === 'Company')
                $company_root = $col;
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
    <div class="max-w-7xl mx-auto px-6 pt-24 pb-28">
        <div class="grid grid-cols-12 gap-x-16 gap-y-14">

            <!-- LOGO -->
            <div class="col-span-12 lg:col-span-4">
                <?php if (has_custom_logo()): ?>
                    <?= get_custom_logo(); ?>
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
                <h4 class="text-[14px] font-semibold mb-6">Company</h4>
                <ul class="space-y-3 text-[14px] text-white/70">
                    <?php if ($company_links): ?>
                        <?php foreach ($company_links as $item): ?>
                            <li>
                                <a href="<?= esc_url($item->url); ?>" class="">
                                    <?= esc_html($item->title); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a href="#" class="">About Us</a></li>
                        <li><a href="#" class="">Contact Us</a></li>
                        <li><a href="#" class="">Careers</a></li>
                    <?php endif; ?>
                </ul>
                <div class="col-span-6 lg:col-span-2"> <button class="btn-get-started"> <span
                            class="btn-get-started__text">Get Started</span> <span
                            class="btn-get-started__icon w-[40px] h-[40px]"> <i
                                class="fa-solid fa-arrow-right rotate-[-30deg]"></i> </span> </button> </div>
            </div>

        </div>
    </div>
</footer>