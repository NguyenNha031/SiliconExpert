<footer class="bg-[#1f3764] text-white ">

    <!-- MAIN FOOTER -->
    <div class="max-w-7xl mx-auto px-6 py-20 ">

        <div class="grid grid-cols-12 gap-12">

            <!-- LOGO -->
            <div class="col-span-12 lg:col-span-3">
                <img src="<?= get_template_directory_uri(); ?>/assets/images/logo_text.png" alt="SiliconExpert"
                    class="h-[26px] mb-6">

                <p class="text-sm text-white/70 leading-relaxed">
                    SiliconExpert provides insight, analytics and intelligence to mitigate
                    electronic component risk.
                </p>
            </div>

            <!-- SOLUTIONS -->
            <div class="col-span-6 lg:col-span-2">
                <h4 class="font-semibold mb-5">Solutions</h4>
                <ul class="space-y-3 text-sm text-white/80">
                    <li><a href="#" class="hover:text-[#FCC937]">Engineering</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Supply Chain</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Compliance / Risk</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Industry Solutions</a></li>
                </ul>
            </div>

            <!-- PRODUCTS -->
            <div class="col-span-6 lg:col-span-2">
                <h4 class="font-semibold mb-5">Products</h4>
                <ul class="space-y-3 text-sm text-white/80">
                    <li><a href="#" class="hover:text-[#FCC937]">Part Search</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">BOM Manager</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">API</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Compliance Mgmt</a></li>
                </ul>
            </div>

            <!-- RESOURCES -->
            <div class="col-span-6 lg:col-span-2">
                <h4 class="font-semibold mb-5">Resources</h4>
                <ul class="space-y-3 text-sm text-white/80">
                    <li><a href="#" class="hover:text-[#FCC937]">Blogs</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Whitepapers</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">Webinars</a></li>
                    <li><a href="#" class="hover:text-[#FCC937]">FAQs</a></li>
                </ul>
            </div>

            <!-- CTA -->
            <div class="col-span-12 lg:col-span-3">
                <div class="bg-[#FCC937] text-[#1f3764] rounded-md p-6">
                    <h4 class="font-semibold text-lg mb-3">Get Started</h4>
                    <p class="text-sm mb-5">
                        Talk to an expert and see how SiliconExpert can help.
                    </p>

                    <a href="#" class="inline-flex items-center gap-2
                    bg-[#1f3764] text-white
                    px-5 py-3 rounded-md
                    text-sm font-medium">
                        Get Started
                        <i class="fa-solid fa-arrow-right rotate-[-30deg]"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6
                flex flex-col lg:flex-row
                justify-between items-center
                text-sm text-white/60 gap-4">

            <p>© <?= date('Y'); ?> SiliconExpert. All rights reserved.</p>

            <div class="flex gap-6">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Use</a>
            </div>

        </div>
    </div>

</footer>