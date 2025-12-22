<?php
$menu_items = wp_get_nav_menu_items('Silicon_Menu');

function get_children_by_title($parent_title, $items)
{
    $parent_id = null;
    $children = [];

    foreach ($items as $item) {
        if ($item->title === $parent_title) {
            $parent_id = $item->ID;
            break;
        }
    }

    if (!$parent_id)
        return [];

    foreach ($items as $item) {
        if ((int) $item->menu_item_parent === (int) $parent_id) {
            $children[] = $item;
        }
    }

    return $children;
}

$solutions = get_children_by_title('Solutions', $menu_items);
$products = get_children_by_title('Products', $menu_items);
$services = get_children_by_title('Services', $menu_items);
function get_menu_level_2($parent_title, $items)
{
    $parent_id = null;
    $level2 = [];

    foreach ($items as $item) {
        if ($item->title === $parent_title) {
            $parent_id = $item->ID;
            break;
        }
    }

    if (!$parent_id)
        return [];

    foreach ($items as $item) {
        if ((int) $item->menu_item_parent === (int) $parent_id) {
            $level2[] = $item;
        }
    }

    return $level2;
}
$partners = get_menu_level_2('Partner Integrations', $menu_items);
$resources_main = get_menu_level_2('Resources Main', $menu_items);
$resources_knowledge = get_menu_level_2('Knowledge Center', $menu_items);
$company_links = get_menu_level_2('Company Links', $menu_items);

?>

<style>
    .header-nav ul li a::after {
        content: "\f078" !important;
        font-family: "Font Awesome 6 Free" !important;
        font-weight: 900 !important;
        margin-left: 6px !important;
        display: inline-block !important;
        font-size: 14px !important;
        transition: transform 0.1s ease !important;
    }

    .header-nav ul li a::after {
        transform: rotate(0deg);
        transition: transform 0.2s ease;
    }

    /* hover bình thường */
    .header-nav ul li:hover>a::after {
        transform: rotate(180deg);
    }

    /* 🔥 CHỈ menu đang mở mega */
    .header-nav ul li a.is-active::after {
        transform: rotate(180deg);
    }
</style>
<header class="header bg-transparent h-[100px] absolute w-full z-20 transition-colors ">
    <div class="mx-auto max-w-7xl px-4 lg:px-0">
        <div class="flex h-[100px] items-center justify-between">

            <!-- LEFT: LOGO -->
            <div class="header-logo flex items-center gap-3 h-[36px]">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_menu.png"
                    alt="SiliconExpert Icon" class="logo-icon h-[26px] w-auto object-contain cursor-pointer" />

                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_text.png" alt="SiliconExpert"
                    class="logo-text h-[22px] w-auto object-contain hidden sm:block cursor-pointer" />
            </div>

            <nav class="header-nav hidden lg:flex justify-between items-center
                    w-[561px]
                    text-[14px] font-medium leading-none tracking-normal
                    text-white text-center
                    font-avenir pr-[35px]">

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex justify-between items-center w-full',
                    'fallback_cb' => false,
                    'depth' => 1, // chỉ menu cấp 1 (chuẩn cho mega menu)
                ]);
                ?>

            </nav>

            <!-- MEGA MENU : SOLUTIONS -->
            <div id="mega-solutions"
                class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%] bg-[#1c3664] text-white rounded-sm hidden  border-t border-solid border-black z-30">

                <div class="max-w-7xl mx-auto px-10 py-6">

                    <div class="grid grid-cols-12 gap-10">

                        <!-- LEFT: SOLUTIONS -->
                        <div class="col-span-4 bg-[#172e54] rounded-sm p-9">
                            <h3 class="text-xl font-semibold mb-6">Solutions</h3>

                            <ul class="space-y-6 pl-[10px]">
                                <?php foreach ($solutions as $item): ?>
                                    <li>
                                        <a href="<?= esc_url($item->url) ?>" class="block group p-[5px] hover:bg-[#23457d]">
                                            <p class="font-medium"><?= esc_html($item->title) ?></p>
                                            <p class="text-sm text-white/70">
                                                Lorem ipsum dolor sit amet consectetur.
                                            </p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="mt-[50px]">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-header-menu.png"
                                    class="rounded-sm w-full" />
                            </div>
                        </div>

                        <!-- RIGHT: PRODUCTS + SERVICES -->
                        <div class="col-span-8 flex flex-col gap-8">

                            <!-- PRODUCTS -->
                            <div class="bg-[#23457d] rounded-sm p-8">
                                <h3 class="text-xl font-semibold mb-6">Products</h3>

                                <div class="grid grid-cols-2 gap-x-10 gap-y-5 pl-[10px]">
                                    <?php foreach ($products as $item): ?>
                                        <a href="<?= esc_url($item->url) ?>" class="block p-[5px] hover:bg-[#172e54]">
                                            <p class="font-medium"><?= esc_html($item->title) ?></p>
                                            <p class="text-sm text-white/70">
                                                Lorem ipsum dolor sit amet consectetur.
                                            </p>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- SERVICES (NẰM DƯỚI PRODUCTS, CÙNG CỘT PHẢI) -->
                            <div>
                                <h3 class="text-xl font-semibold mb-6">Services</h3>

                                <div class="grid grid-cols-2 gap-10 pl-[10px]">
                                    <?php foreach ($services as $item): ?>
                                        <a href="<?= esc_url($item->url) ?>" class="block group p-[5px] hover:bg-[#172e54]">
                                            <p class="font-medium">
                                                <?= esc_html($item->title) ?>
                                            </p>
                                            <p class="text-sm text-white/70">
                                                See how SiliconExpert supports resilience. See how SiliconExpert supports
                                                resilience.
                                            </p>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- MEGA MENU : PARTNER INTEGRATIONS -->
            <div id="mega-partners" class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%]
                bg-[#1c3664] text-white rounded-sm hidden
                border-t border-black z-30">

                <div class="max-w-7xl mx-auto px-10 py-8">

                    <!-- GRID CHA -->
                    <div class="grid grid-cols-12 gap-10">

                        <!-- LEFT + CENTER (2/3) -->
                        <div class="col-span-8 bg-[#172e54] rounded-sm p-9">

                            <!-- GRID CON -->
                            <div class="grid grid-cols-12 gap-10 items-center">

                                <!-- LEFT -->
                                <div class="col-span-6">
                                    <h3 class="text-xl font-semibold mb-6">
                                        Partner Integrations
                                    </h3>

                                    <img src="<?= get_template_directory_uri() ?>/assets/images/img-header-menu.png"
                                        class="rounded-sm w-full mb-6" />

                                    <a href="#" class="inline-flex items-center gap-2 text-sm font-medium ">
                                        See all Partners
                                        <span class="btn-get-started__icon  bg-transparent pl-[0]">
                                            <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                        </span>
                                    </a>
                                </div>

                                <!-- CENTER -->
                                <div class="col-span-6 flex flex-col gap-6 pl-6">
                                    <?php foreach ($partners as $item): ?>
                                        <a href="<?= esc_url($item->url) ?>"
                                            class="text-[16px] font-medium  transition p-[5px] hover:bg-[#1c3664]">
                                            <?= esc_html($item->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT (1/3) -->
                        <div class="col-span-4 bg-[#23457d] rounded-sm p-9 w-[400px]">
                            <h3 class="text-lg font-semibold mb-2">Become a Partner</h3>
                            <p class="text-sm text-white/80 mb-6">
                                Lorem ipsum dolor sit amet consectetur.
                            </p>

                            <img src="<?= get_template_directory_uri() ?>/assets/images/img-header-menu.png"
                                class="rounded-sm w-full " />
                        </div>

                    </div>

                </div>

            </div>

            <!-- MEGA MENU : RESOURCES -->
            <div id="mega-resources" class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%]
            bg-[#1c3664] text-white rounded-sm hidden
            border-t border-black z-30">

                <div class="max-w-7xl mx-auto px-10 py-8">

                    <div class="grid grid-cols-12 gap-10">

                        <!-- LEFT + CENTER (2/3) -->
                        <div class="col-span-8 bg-[#172e54] rounded-sm p-9">

                            <div class="grid grid-cols-12 gap-10 items-start">

                                <!-- LEFT FEATURE -->
                                <div class="col-span-6">
                                    <h3 class="text-xl font-semibold mb-6">Resources</h3>

                                    <img src="<?= get_template_directory_uri() ?>/assets/images/img-header-menu.png"
                                        class="rounded-sm w-full mb-6" />

                                    <p class="text-sm text-white/80 mb-4">
                                        Feature resource article title here with option to show multiple lines
                                    </p>

                                    <a href="#" class="inline-flex items-center gap-2 text-sm font-medium">
                                        See all Resources
                                        <span class="btn-get-started__icon bg-transparent pl-0">
                                            <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                        </span>
                                    </a>
                                </div>

                                <!-- CENTER LIST -->
                                <div class="col-span-6 flex flex-col gap-4 pl-6">
                                    <?php foreach ($resources_main as $item): ?>
                                        <a href="<?= esc_url($item->url) ?>" class="text-[16px] font-medium p-[5px]
                                      hover:bg-[#1c3664] transition">
                                            <?= esc_html($item->title) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT (1/3) -->
                        <div class="col-span-4 bg-[#23457d] rounded-sm p-9">
                            <h3 class="text-lg font-semibold mb-4">Knowledge Center</h3>

                            <div class="flex flex-col gap-4 pl-[5px]">
                                <?php foreach ($resources_knowledge as $item): ?>
                                    <a href="<?= esc_url($item->url) ?>"
                                        class="text-[15px]  font-medium hover:bg-[#1c3664] transition p-[5px]">
                                        <?= esc_html($item->title) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- MEGA MENU : COMPANY -->
            <div id="mega-company" class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%]
            bg-[#1c3664] text-white rounded-sm hidden
            border-t border-black z-30">

                <div class="max-w-7xl mx-auto px-10 py-8">

                    <div class="grid grid-cols-12 gap-10">

                        <!-- LEFT : COMPANY INTRO -->
                        <div class="col-span-4  rounded-sm p-9">
                            <h3 class="text-xl font-semibold mb-4">Company</h3>

                            <p class="text-sm text-white/80 leading-relaxed mb-6">
                                Lorem ipsum dolor sit amet consectetur. Risus eget purus maecenas
                                eleifend at non augue. Lorem ipsum dolor sit amet consectetur. Risus eget purus maecenas
                                eleifend at non augue.
                            </p>

                            <a href="#" class="inline-flex items-center gap-2 text-sm font-medium">
                                Careers
                                <span class="btn-get-started__icon bg-transparent pl-0">
                                    <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                </span>
                            </a>
                        </div>

                        <!-- CENTER : ABOUT US -->
                        <div class="col-span-4 bg-[#172e54] rounded-sm p-9">
                            <div class="hover:bg-[#1c3664] p-[5px] mb-3">
                                <h3 class="text-lg font-semibold mb-2">About Us</h3>

                                <!-- 🔥 LOREM TEXT -->
                                <p class="text-sm text-white/80 mb-4 leading-relaxed">
                                    Lorem ipsum dolor sit amet consectetur.
                                </p>
                            </div>


                            <img src="<?= get_template_directory_uri() ?>/assets/images/img-header-menu.png"
                                class="rounded-sm w-full mb-4" />

                            <?php foreach ($company_links as $item): ?>
                                <?php if ($item->title === 'About Us'): ?>
                                    <a href="<?= esc_url($item->url) ?>"
                                        class="inline-flex items-center gap-2 text-sm font-medium hover:text-[#FCC937] transition">
                                        <?= esc_html($item->title) ?>
                                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>


                        <!-- RIGHT : CONTACT US -->
                        <div class="col-span-4 bg-[#23457d] rounded-sm p-9">
                            <div class="hover:bg-[#1c3664] p-[5px] mb-3">
                                <h3 class="text-lg font-semibold mb-2">Contact Us</h3>

                                <!-- 🔥 LOREM TEXT -->
                                <p class="text-sm text-white/80 mb-4 leading-relaxed">
                                    Lorem ipsum dolor sit amet consectetur.
                                </p>
                            </div>


                            <img src="<?= get_template_directory_uri() ?>/assets/images/img-header-menu.png"
                                class="rounded-sm w-full mb-4" />

                            <?php foreach ($company_links as $item): ?>
                                <?php if ($item->title === 'Contact Us'): ?>
                                    <a href="<?= esc_url($item->url) ?>"
                                        class="inline-flex items-center gap-2 text-sm font-medium hover:text-[#FCC937] transition">
                                        <?= esc_html($item->title) ?>
                                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>


                    </div>
                </div>
            </div>


            <!-- RIGHT: DESKTOP ACTIONS -->
            <div class="header-actions hidden lg:flex items-center gap-2 text-sm">
                <a href="#" class="text-white text-[14px]">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>

                <a class="text-white text-[14px] px-[17px]">
                    EN <i class="fa-solid fa-chevron-down"></i>
                </a>

                <button class="btn-non-bg h-[48px]">Login</button>

                <i class="fa-solid fa-arrow-up-right"></i>

                <button class="btn-get-started">
                    <span class="btn-get-started__text">Get Started</span>
                    <span class="btn-get-started__icon w-[40px] h-[40px]">
                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                    </span>
                </button>
            </div>

            <!-- RIGHT: MOBILE ACTIONS -->
            <div class="flex items-center gap-5 text-white lg:hidden">
                <button class="mobile-search">
                    <i class="fa-solid fa-magnifying-glass text-[18px]"></i>
                </button>

                <button class="mobile-menu-toggle">
                    <i class="fa-solid fa-bars text-[20px]"></i>
                </button>
            </div>

        </div>
    </div>
</header>
<!-- SEARCH PANEL -->
<div id="header-search" class="absolute top-[100px] left-1/2 -translate-x-1/2
            w-[92%]
            h-[225px]
            bg-[#1c3664]
            hidden
            z-[100]
            border-t border-solid
            flex items-center justify-center">

    <div class="lg:w-[550px] w-auto mx-auto px-4 py-10">

        <div class="relative max-w-[640px] mx-auto">

            <input type="text" placeholder="Search term here" class="w-full h-[56px]
                       bg-transparent
                       border border-white/30
                       rounded-md
                       px-5 pr-[64px]
                       text-white
                       placeholder-white/50
                       focus:outline-none
                       focus:border-[#FFF]" />

            <button class="absolute right-2 top-1/2 -translate-y-1/2
                       w-[40px] h-[40px]
                       bg-[#FCC937]
                       rounded-md
                       flex items-center justify-center
                       text-[#1C3664]">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

        </div>

    </div>
</div>