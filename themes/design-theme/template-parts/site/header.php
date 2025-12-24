<?php
/**
 * Header – Mega Menu dynamic
 */

/* ===== GET MENU ITEMS ===== */
$locations = get_nav_menu_locations();
$menu_items = [];

if (isset($locations['primary'])) {
    $menu_items = wp_get_nav_menu_items($locations['primary']);
}
if (!is_array($menu_items)) {
    $menu_items = [];
}

/* ===== HELPERS ===== */
function menu_children($parent_id, $items)
{
    if (!is_array($items))
        return [];
    return array_values(array_filter($items, function ($item) use ($parent_id) {
        return (int) $item->menu_item_parent === (int) $parent_id;
    }));
}

function find_mega_item($class, $items)
{
    foreach ($items as $item) {
        if (!empty($item->classes) && in_array($class, $item->classes)) {
            return $item;
        }
    }
    return null;
}

/* ===== MEGA ROOTS ===== */
$mega_solutions = find_mega_item('mega-solutions', $menu_items);
$mega_partners = find_mega_item('mega-partners', $menu_items);
$mega_resources = find_mega_item('mega-resources', $menu_items);
$mega_company = find_mega_item('mega-company', $menu_items);
?>

<style>
    .header-nav li>a::after {
        content: "\f078";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        margin-left: 6px;
        display: inline-block;
        font-size: 14px;
        transition: transform 0.2s ease;
    }

    /* hover */
    .header-nav li:hover>a::after {
        transform: rotate(180deg);
    }

    /* khi mega đang mở (JS add class is-active) */
    .header-nav a.is-active::after {
        transform: rotate(180deg);
    }
</style>
<?php
// LOGO
$logo_icon = get_field('header_logo_icon', 'option');
$logo_text = get_field('header_logo_text', 'option');

// SEARCH
$search_enable = get_field('header_search_enable', 'option');

// CTA LOGIN
$login_enable = get_field('header_cta_login_enable', 'option');
$login_text = get_field('header_cta_login_text', 'option') ?: 'Login';
$login_link = get_field('header_cta_login_link', 'option');

// CTA GET STARTED
$get_started_enable = get_field('header_cta_primary_enable', 'option');
$get_started_text = get_field('header_cta_primary_text', 'option') ?: 'Get Started';
$get_started_link = get_field('header_cta_primary_link', 'option');
?>

<header class="header bg-transparent h-[100px] absolute w-full z-20 transition-colors">
    <div class="mx-auto max-w-7xl px-4 lg:px-0">
        <div class="flex h-[100px] items-center justify-between">

            <!-- LOGO -->
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


            <!-- MAIN NAV -->
            <nav class="header-nav hidden lg:flex w-[561px] text-[14px] font-medium text-white font-avenir pr-[35px]">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex justify-between items-center w-full',
                    'depth' => 1,
                    'fallback_cb' => false,
                    'walker' => new class extends Walker_Nav_Menu {
                    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                    {
                        if (!empty($item->classes)) {
                            foreach ($item->classes as $class) {
                                if (strpos($class, 'mega-') === 0 && !in_array('has-mega', $item->classes)) {
                                    $item->classes[] = 'has-mega';
                                    break;
                                }
                            }
                        }
                        parent::start_el($output, $item, $depth, $args, $id);
                    }
                    }
                ]);
                ?>
            </nav>

            <!-- MEGA: SOLUTIONS -->
            <?php if ($mega_solutions): ?>
                <div id="mega-solutions"
                    class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%] bg-[#1c3664] text-white hidden border-t border-black z-30">
                    <div class="max-w-7xl mx-auto px-10 py-6">
                        <div class="grid grid-cols-12 gap-10">

                            <?php
                            // Tách cột theo title
                            $solutions_col = null;
                            $products_col = null;
                            $services_col = null;

                            foreach (menu_children($mega_solutions->ID, $menu_items) as $col) {
                                $title = trim($col->title);

                                if ($title === 'Solutions')
                                    $solutions_col = $col;
                                if ($title === 'Products')
                                    $products_col = $col;
                                if ($title === 'Services')
                                    $services_col = $col;
                            }
                            ?>

                            <!-- LEFT: SOLUTIONS -->
                            <?php if ($solutions_col): ?>
                                <?php
                                $links = menu_children($solutions_col->ID, $menu_items);
                                $image_id = get_menu_item_image_id($solutions_col->ID);
                                ?>
                                <div class="col-span-4 bg-[#172e54] rounded-sm p-8 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-6">
                                            <?= esc_html($solutions_col->title) ?>
                                        </h3>

                                        <?php foreach ($links as $link): ?>
                                            <div class="mb-6 p-[5px] hover:bg-[#1B305B] ">
                                                <p class="font-medium">
                                                    <?= esc_html($link->title) ?>
                                                </p>
                                                <?php if ($link->description): ?>
                                                    <p class="text-sm text-white leading-snug">
                                                        <?= esc_html($link->description) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                    <?php if ($image_id): ?>
                                        <div class="">
                                            <?= wp_get_attachment_image(
                                                $image_id,
                                                'large',
                                                false,
                                                ['class' => 'w-full rounded-lg object-cover']
                                            ) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- RIGHT: PRODUCTS + SERVICES -->
                            <div class="col-span-8 flex flex-col gap-5">

                                <!-- PRODUCTS -->
                                <?php if ($products_col): ?>
                                    <?php $links = menu_children($products_col->ID, $menu_items); ?>
                                    <div class="bg-[#23457d] rounded-sm p-9">
                                        <h3 class="text-xl font-semibold mb-6">
                                            <?= esc_html($products_col->title) ?>
                                        </h3>

                                        <div class="grid grid-cols-2 gap-x-10 gap-y-6">
                                            <?php foreach ($links as $link): ?>
                                                <div class="p-[5px] hover:bg-[#172e54]">
                                                    <p class="font-medium">
                                                        <?= esc_html($link->title) ?>
                                                    </p>
                                                    <?php if ($link->description): ?>
                                                        <p class="text-sm text-white leading-snug">
                                                            <?= esc_html($link->description) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- SERVICES -->
                                <?php if ($services_col): ?>
                                    <?php $links = menu_children($services_col->ID, $menu_items); ?>
                                    <div class="bg-[#1b3563] rounded-sm p-9">
                                        <h3 class="text-xl font-semibold mb-6">
                                            <?= esc_html($services_col->title) ?>
                                        </h3>

                                        <div class="grid grid-cols-2 gap-x-10 gap-y-6  ">
                                            <?php foreach ($links as $link): ?>
                                                <div class="hover:bg-[#172e54] p-[5px]">
                                                    <p class="font-medium">
                                                        <?= esc_html($link->title) ?>
                                                    </p>
                                                    <?php if ($link->description): ?>
                                                        <p class="text-sm text-white leading-snug">
                                                            <?= esc_html($link->description) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>

                    </div>
                </div>
            <?php endif; ?>

            <!-- MEGA: PARTNERS -->
            <?php if ($mega_partners): ?>
                <div id="mega-partners" class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%]
               bg-[#1c3664] text-white hidden border-t border-black z-30">

                    <div class="max-w-7xl mx-auto px-10 py-10">
                        <div class="grid grid-cols-12 gap-10">

                            <?php
                            $list_col = null;
                            $cta_col = null;

                            foreach (menu_children($mega_partners->ID, $menu_items) as $child) {
                                $title = trim($child->title);

                                if ($title === 'Partner Integrations') {
                                    $list_col = $child;
                                }

                                if ($title === 'Become a Partner') {
                                    $cta_col = $child;
                                }
                            }
                            ?>

                            <!-- LEFT: PARTNER INTEGRATIONS -->
                            <?php if ($list_col): ?>
                                <?php
                                $items = menu_children($list_col->ID, $menu_items);
                                $image_id = get_menu_item_image_id($list_col->ID);
                                $see_all = null;

                                foreach ($items as $key => $item) {
                                    if (!empty($item->classes) && in_array('menu-see-all', $item->classes)) {
                                        $see_all = $item;
                                        unset($items[$key]);
                                        break;
                                    }
                                }


                                ?>

                                <div class="col-span-8 bg-[#172e54] rounded-sm p-9">
                                    <h3 class="text-xl font-semibold mb-6">
                                        <?= esc_html($list_col->title) ?>
                                    </h3>

                                    <div class="flex gap-[100px] items-start">

                                        <!-- IMAGE + CTA -->
                                        <div class="w-[285px] flex-shrink-0">

                                            <?php if ($image_id): ?>
                                                <?= wp_get_attachment_image(
                                                    $image_id,
                                                    'large',
                                                    false,
                                                    ['class' => 'rounded-lg w-full h-[200px] object-cover']
                                                ) ?>
                                            <?php endif; ?>

                                            <?php if ($see_all): ?>
                                                <a href="<?= esc_url($see_all->url) ?>"
                                                    class="inline-flex items-center gap-2 mt-6 text-white font-medium">
                                                    <?= esc_html($see_all->title) ?>
                                                    <i class="fa-solid fa-arrow-right rotate-[-45deg]"></i>
                                                </a>
                                            <?php endif; ?>

                                        </div>


                                        <!-- PARTNER LIST -->
                                        <div class="flex-1">
                                            <div class="flex flex-col gap-5">
                                                <?php foreach ($items as $item): ?>
                                                    <div class="p-[5px] hover:bg-[#1B305B] transition-colors cursor-pointer">
                                                        <p class="font-medium text-[15px] leading-[1.6]">
                                                            <?= esc_html($item->title) ?>
                                                        </p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- RIGHT: BECOME A PARTNER -->
                            <?php if ($cta_col): ?>
                                <?php $image_id = get_menu_item_image_id($cta_col->ID); ?>
                                <div class="col-span-4 bg-[#23457d] rounded-sm p-12 flex flex-col justify-between">

                                    <div class="hover:bg-[#172e54] p-[5px]">
                                        <h3 class="text-lg font-semibold mb-3">
                                            <?= esc_html($cta_col->title) ?>
                                        </h3>
                                        <p class="text-sm text-white">
                                            <?= esc_html($cta_col->description) ?>
                                        </p>
                                    </div>

                                    <?php if ($image_id): ?>
                                        <div class="mt-[50px]">
                                            <?= wp_get_attachment_image(
                                                $image_id,
                                                'large',
                                                false,
                                                ['class' => 'rounded-lg h-[200px] object-cover']
                                            ) ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- MEGA: RESOURCES -->
            <?php if ($mega_resources): ?>
                <div id="mega-resources" class="mega-menu absolute lg:left-[40px] top-[100px] w-[95%]
        bg-[#1c3664] text-white hidden border-t border-black z-30">

                    <div class="max-w-7xl mx-auto px-10 py-10">
                        <div class="grid grid-cols-12 gap-10">

                            <?php
                            $resources_main = null;
                            $knowledge_center = null;

                            foreach (menu_children($mega_resources->ID, $menu_items) as $child) {
                                $title = trim($child->title);
                                if ($title === 'Resources Main') {
                                    $resources_main = $child;
                                }
                                if ($title === 'Knowledge Center') {
                                    $knowledge_center = $child;
                                }
                            }
                            ?>

                            <!-- LEFT: RESOURCES MAIN -->
                            <?php if ($resources_main): ?>
                                <?php
                                $items = menu_children($resources_main->ID, $menu_items);
                                $image_id = get_menu_item_image_id($resources_main->ID);
                                $see_all = null;

                                foreach ($items as $key => $item) {
                                    if (!empty($item->classes) && in_array('menu-see-all', $item->classes)) {
                                        $see_all = $item;
                                        unset($items[$key]);
                                        break;
                                    }
                                }

                                ?>

                                <div class="col-span-8 bg-[#172e54] rounded-sm p-9">

                                    <h3 class="text-xl font-semibold mb-6">
                                        <?= esc_html($resources_main->title) ?>
                                    </h3>

                                    <div class="flex gap-[100px] items-start">

                                        <!-- IMAGE + DESCRIPTION -->
                                        <?php if ($image_id): ?>
                                            <div class="w-[260px] flex-shrink-0">
                                                <?= wp_get_attachment_image(
                                                    $image_id,
                                                    'large',
                                                    false,
                                                    ['class' => 'rounded-lg w-full object-cover mb-4']
                                                ) ?>

                                                <?php if (!empty($resources_main->description)): ?>
                                                    <p class="text-sm text-white leading-[1.6]">
                                                        <?= esc_html($resources_main->description) ?>
                                                    </p>
                                                <?php endif; ?>

                                                <?php if ($see_all): ?>
                                                    <a href="<?= esc_url($see_all->url) ?>"
                                                        class="inline-flex items-center gap-2 mt-6 text-white font-medium ">
                                                        <?= esc_html($see_all->title) ?>
                                                        <i class="fa-solid fa-arrow-right rotate-[-45deg]"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- RESOURCE LIST -->
                                        <div class="flex-1">
                                            <div class="flex flex-col gap-5 w-[80%]">
                                                <?php foreach ($items as $item): ?>
                                                    <div class="hover:bg-[#1c3664] transition-colors cursor-pointer p-[4px]">
                                                        <p class="font-medium text-[15px] leading-[1.6]">
                                                            <?= esc_html($item->title) ?>
                                                        </p>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- RIGHT: KNOWLEDGE CENTER -->
                            <?php if ($knowledge_center): ?>
                                <?php $items = menu_children($knowledge_center->ID, $menu_items); ?>
                                <div class="col-span-4 bg-[#23457d] rounded-sm p-9">

                                    <h3 class="text-xl font-semibold mb-6">
                                        <?= esc_html($knowledge_center->title) ?>
                                    </h3>

                                    <div class="flex flex-col gap-4 w-[80%]">
                                        <?php foreach ($items as $item): ?>
                                            <div class="hover:bg-[#1B305B] transition-colors cursor-pointer p-[5px]">
                                                <p class="font-medium text-[15px]">
                                                    <?= esc_html($item->title) ?>
                                                </p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- MEGA: COMPANY -->
            <?php if ($mega_company): ?>
                <div id="mega-company" class="mega-menu hidden absolute lg:left-[40px] top-[100px] w-[95%]
    bg-[#1c3664] text-white  border-t border-black z-30">

                    <div class="max-w-7xl mx-auto px-10 py-10">
                        <div class="grid grid-cols-12 gap-10">

                            <?php
                            $company_main = null;
                            $about_us = null;
                            $contact_us = null;

                            foreach (menu_children($mega_company->ID, $menu_items) as $child) {
                                $title = trim($child->title);

                                if ($title === 'Company Main')
                                    $company_main = $child;
                                if ($title === 'About Us')
                                    $about_us = $child;
                                if ($title === 'Contact Us')
                                    $contact_us = $child;
                            }

                            $careers = null;

                            if ($company_main) {
                                $children_lv3 = menu_children($company_main->ID, $menu_items);

                                foreach ($children_lv3 as $key => $lv3) {
                                    if (!empty($lv3->classes) && in_array('menu-cta', $lv3->classes)) {
                                        $careers = $lv3;
                                        unset($children_lv3[$key]);
                                        break;
                                    }
                                }
                            }

                            ?>

                            <!-- LEFT: COMPANY MAIN -->
                            <?php if ($company_main): ?>
                                <div class="col-span-4   h-[200px] rounded-sm p-9 flex flex-col justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold mb-4">
                                            <?= esc_html($company_main->title) ?>
                                        </h3>

                                        <?php if (!empty($company_main->description)): ?>
                                            <p class="text-sm text-white leading-[1.6]">
                                                <?= esc_html($company_main->description) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($careers): ?>
                                        <a href="<?= esc_url($careers->url) ?>"
                                            class="inline-flex items-center gap-2 mt-6 text-white font-medium ">
                                            <?= esc_html($careers->title) ?>
                                            <i class="fa-solid fa-arrow-right rotate-[-45deg]"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- CENTER: ABOUT US -->
                            <?php if ($about_us): ?>
                                <?php $about_img = get_menu_item_image_id($about_us->ID); ?>
                                <div class="col-span-4 bg-[#1B305B] rounded-sm p-9">
                                    <div class="hover:bg-[#1c3664] p-[5px] h-[auto] max-h-[100px]">
                                        <h3 class="text-lg font-semibold">
                                            <?= esc_html($about_us->title) ?>
                                        </h3>

                                        <?php if (!empty($about_us->description)): ?>
                                            <p class="text-sm text-white leading-[1.6]">
                                                <?= esc_html($about_us->description) ?>
                                            </p>
                                        <?php endif; ?>

                                    </div>


                                    <?php if ($about_img): ?>
                                        <?= wp_get_attachment_image(
                                            $about_img,
                                            'large',
                                            false,
                                            ['class' => 'rounded-lg w-full object-cover mt-[30px]']
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <!-- RIGHT: CONTACT US -->
                            <?php if ($contact_us): ?>
                                <?php $contact_img = get_menu_item_image_id($contact_us->ID); ?>
                                <div class="col-span-4 bg-[#23457d] rounded-sm p-9">
                                    <div class="p-[5px] hover:bg-[#1B305B] h-[auto] max-h-[100px]">
                                        <h3 class="text-lg font-semibold ">
                                            <?= esc_html($contact_us->title) ?>
                                        </h3>

                                        <?php if (!empty($contact_us->description)): ?>
                                            <p class="text-sm text-white leading-[1.6]">
                                                <?= esc_html($contact_us->description) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>


                                    <?php if ($contact_img): ?>
                                        <?= wp_get_attachment_image(
                                            $contact_img,
                                            'large',
                                            false,
                                            ['class' => 'rounded-lg w-full object-cover mt-[30px]']
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ACTIONS -->
            <div class="header-actions hidden lg:flex items-center gap-2 text-sm">

                <?php if ($search_enable): ?>
                    <a href="#" class="text-white text-[14px] js-header-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>
                <?php endif; ?>

                <!-- EN -->
                <a class="text-white text-[14px] px-[17px]">
                    EN <i class="fa-solid fa-chevron-down"></i>
                </a>

                <!-- LOGIN CTA -->
                <?php if ($login_enable): ?>
                    <?php
                    $login_url = '#';
                    $login_target = '_self';

                    if (is_array($login_link) && !empty($login_link['url'])) {
                        $login_url = $login_link['url'];
                        $login_target = $login_link['target'] ?: '_self';
                    }
                    ?>
                    <a href="<?= esc_url($login_url) ?>" target="<?= esc_attr($login_target) ?>"
                        class="btn-non-bg h-[48px]">
                        <?= esc_html($login_text) ?>
                    </a>
                <?php endif; ?>

                <!-- GET STARTED CTA -->
                <?php if ($get_started_enable): ?>
                    <?php
                    $get_started_url = '#';

                    if (is_array($get_started_link) && !empty($get_started_link['url'])) {
                        $get_started_url = $get_started_link['url'];
                    }
                    ?>
                    <button class="btn-get-started" onclick="window.location.href='<?= esc_url($get_started_url) ?>'">
                        <span class="btn-get-started__text">
                            <?= esc_html($get_started_text) ?>
                        </span>
                        <span class="btn-get-started__icon w-[40px] h-[40px]">
                            <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                        </span>
                    </button>
                <?php endif; ?>

            </div>



            <!-- RIGHT: MOBILE ACTIONS -->
            <div class="flex items-center gap-5 text-white lg:hidden"> <button class="mobile-search"> <i
                        class="fa-solid fa-magnifying-glass text-[18px]"></i> </button> <button
                    class="mobile-menu-toggle"> <i class="fa-solid fa-bars text-[20px]"></i> </button> </div>

        </div>
    </div>
</header>
<!-- SEARCH PANEL -->
<div id="header-search"
    class="absolute top-[100px] left-1/2 -translate-x-1/2 w-[92%] h-[225px] bg-[#1c3664] hidden z-[100] border-t border-solid flex items-center justify-center">
    <div class="lg:w-[550px] w-auto mx-auto px-4 py-10">
        <div class="relative max-w-[640px] mx-auto"> <input type="text" placeholder="Search term here"
                class="w-full h-[56px] bg-transparent border border-white/30 rounded-md px-5 pr-[64px] text-white placeholder-white/50 focus:outline-none focus:border-[#FFF]" />
            <button
                class="absolute right-2 top-1/2 -translate-y-1/2 w-[40px] h-[40px] bg-[#FCC937] rounded-md flex items-center justify-center text-[#1C3664]">
                <i class="fa-solid fa-magnifying-glass"></i> </button>
        </div>
    </div>
</div>