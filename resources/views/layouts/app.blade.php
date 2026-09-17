<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($settings['store_name'] ?? 'DemandHat BD') . ' - ' . ($settings['store_tagline'] ?? 'সেরা অনলাইন শপ'))</title>
    <meta name="description" content="@yield('meta_description', 'DemandHat BD - খাঁটি অর্গানিক ফুড, হোম ও কিচেন গ্যাজেট এবং ট্রেন্ডিং ইলেকট্রনিক্স পণ্যের বিশ্বস্ত অনলাইন শপ। সারাদেশে ক্যাশ অন ডেলিভারি।')">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="@yield('title', $settings['store_name'] ?? 'DemandHat BD')">
    <meta property="og:description" content="@yield('meta_description', 'সেরা মূল্যে প্রিমিয়াম পণ্য অর্ডার করুন ক্যাশ অন ডেলিভারিতে')">
    <meta property="og:image" content="@yield('og_image', 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80')">
    <meta property="og:type" content="website">

    <!-- Modern Typography: Anek Bangla & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Multi-Pixel Tracking Integration -->
    @if(!empty($settings['fb_pixel_id']))
    <!-- Meta / Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $settings['fb_pixel_id'] }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $settings['fb_pixel_id'] }}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
    @endif

    @if(!empty($settings['tiktok_pixel_id']))
    <!-- TikTok Pixel Code -->
    <script>
        !function (w, d, t) {
          w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,s=d.createElement("script"),s.type="text/javascript",s.async=!0,s.src=i+"?sdkid="+e+"&lib="+t;var a=d.getElementsByTagName("script")[0];a.parentNode.insertBefore(s,a)};
          ttq.load('{{ $settings['tiktok_pixel_id'] }}');
          ttq.page();
        }(window, document, 'ttq');
    </script>
    <!-- End TikTok Pixel Code -->
    @endif

    @if(!empty($settings['gtm_id']))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $settings['gtm_id'] }}');</script>
    <!-- End Google Tag Manager -->
    @endif

    <!-- Custom Head Script Injection -->
    {!! $settings['custom_head_scripts'] ?? '' !!}

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col selection:bg-emerald-500 selection:text-white">
    @if(!empty($settings['gtm_id']))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['gtm_id'] }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    <!-- Top Announcement Bar with Language Switcher -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white text-xs sm:text-sm py-2 px-4 shadow-sm border-b border-emerald-900/40">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
            <span class="hidden md:inline-flex items-center gap-1 text-xs">
                <span>📞 <span data-i18n="helpline">হেল্পলাইন:</span></span>
                <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="font-bold underline hover:text-emerald-300">{{ $settings['store_phone'] ?? '01712-345678' }}</a>
            </span>

            <div class="mx-auto md:mx-0 flex items-center gap-2 text-center text-xs">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span data-i18n="announcement">{{ $settings['announcement_text'] ?? '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!' }}</span>
            </div>

            <div class="flex items-center gap-3 text-xs flex-shrink-0">
                <!-- Bangla / English Language Switcher -->
                <div class="flex items-center bg-black/30 rounded-lg p-0.5 border border-white/20 text-[11px] font-bold">
                    <button type="button" id="langBnBtn" class="px-2 py-0.5 rounded-md bg-emerald-600 text-white shadow transition-all cursor-pointer" onclick="window.setLanguage('bn')">
                        🇧🇩 বাংলা
                    </button>
                    <button type="button" id="langEnBtn" class="px-2 py-0.5 rounded-md text-slate-300 hover:text-white transition-all cursor-pointer" onclick="window.setLanguage('en')">
                        🇬🇧 English
                    </button>
                </div>

                <a href="{{ route('tracking.index') }}" class="hidden lg:flex hover:underline items-center gap-1 text-emerald-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span data-i18n="track_order">অর্ডার ট্র্যাক করুন</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="hidden md:inline hover:underline text-emerald-200 text-xs" data-i18n="admin_panel">এডমিন প্যানেল</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
            <div class="flex items-center justify-between gap-4">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                        D
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 block leading-tight">
                            DEMAND<span class="text-emerald-600">HAT</span>
                        </span>
                        <span class="text-[10px] text-slate-500 tracking-wider uppercase font-semibold hidden sm:block">Smart eCommerce BD</span>
                    </div>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg mx-6">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="মধু, ঘি, কিচেন চপার, ট্রিমার বা পণ্য খুঁজুন..." data-i18n-placeholder="search_placeholder"
                               class="w-full pl-4 pr-12 py-2.5 bg-slate-100 border border-slate-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full flex items-center justify-center transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Phone Hotline, Track Order, Cart Trigger -->
                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- WhatsApp hotline button -->
                    @if(!empty($settings['store_whatsapp']))
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['store_whatsapp']) }}?text=Hello%2C%20I%20want%20to%20order%20from%20DemandHat" target="_blank"
                       class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-xs font-semibold hover:bg-emerald-100 transition-colors">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span data-i18n="whatsapp_order">WhatsApp অর্ডার</span>
                    </a>
                    @endif

                    <a href="{{ route('tracking.index') }}" class="md:hidden text-slate-700 hover:text-emerald-600 p-2" title="অর্ডার ট্র্যাক করুন">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </a>

                    <!-- Cart Drawer Trigger Button -->
                    <button id="cartDrawerBtn" type="button" class="relative flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-3.5 py-2 rounded-xl text-sm font-semibold shadow-sm hover:shadow-md transition-all cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="hidden sm:inline" data-i18n="cart">কার্ট</span>
                        <span id="cartCountBadge" class="bg-amber-400 text-slate-950 text-xs font-bold px-1.5 py-0.5 rounded-full min-w-[20px] text-center">0</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="mt-3 md:hidden">
                <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="মধু, চপার বা গ্যাজেট খুঁজুন..." data-i18n-placeholder="search_placeholder"
                           class="w-full pl-4 pr-10 py-2 bg-slate-100 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-500 hover:text-emerald-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Category Menu Bar -->
        <nav class="bg-slate-100/90 border-t border-slate-200/80 px-4 sm:px-6 lg:px-8 overflow-x-auto whitespace-nowrap">
            <div class="max-w-7xl mx-auto flex items-center gap-6 py-2 text-xs sm:text-sm font-medium text-slate-700">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : '' }}" data-i18n="nav_home">হোমপেজ</a>
                <a href="{{ route('products.index') }}" class="hover:text-emerald-600 {{ request()->routeIs('products.index') && !request('category') ? 'text-emerald-600 font-bold' : '' }}" data-i18n="nav_products">সব প্রোডাক্ট</a>
                <a href="{{ route('products.index', ['category' => 'organic-products']) }}" class="flex items-center gap-1 hover:text-emerald-600 {{ request('category') === 'organic-products' ? 'text-emerald-600 font-bold' : '' }}">
                    <span>🌿</span> <span data-i18n="nav_organic">অর্গানিক ফুড</span>
                </a>
                <a href="{{ route('products.index', ['category' => 'home-kitchen']) }}" class="flex items-center gap-1 hover:text-emerald-600 {{ request('category') === 'home-kitchen' ? 'text-emerald-600 font-bold' : '' }}">
                    <span>🍳</span> <span data-i18n="nav_kitchen">হোম ও কিচেন</span>
                </a>
                <a href="{{ route('products.index', ['category' => 'electronics-gadgets']) }}" class="flex items-center gap-1 hover:text-emerald-600 {{ request('category') === 'electronics-gadgets' ? 'text-emerald-600 font-bold' : '' }}">
                    <span>⚡</span> <span data-i18n="nav_electronics">ইলেকট্রনিক্স ও গ্যাজেট</span>
                </a>
                <a href="{{ route('tracking.index') }}" class="hover:text-emerald-600 ml-auto flex items-center gap-1 text-slate-600">
                    <span>📦</span> <span data-i18n="track_order">অর্ডার ট্র্যাকিং</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Global Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-12 pb-8 border-t border-slate-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
                <!-- Brand Info -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-black text-lg">D</div>
                        <span class="text-xl font-black tracking-tight text-white">DEMAND<span class="text-emerald-400">HAT</span></span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        {{ $settings['store_tagline'] ?? 'সেরা মূল্যে ১০০% জেনুইন ও প্রিমিয়াম কোয়ালিটি পণ্য' }}। আপনার আস্থাই আমাদের অনুপ্রেরণা।
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <p>📍 {{ $settings['store_address'] ?? 'Mirpur-10, Dhaka-1216' }}</p>
                        <p>📞 হটলাইন: <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="text-emerald-400 font-bold">{{ $settings['store_phone'] ?? '01712-345678' }}</a></p>
                        <p>✉️ ইমেইল: {{ $settings['store_email'] ?? 'support@demandhatbd.com' }}</p>
                    </div>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">জনপ্রিয় ক্যাটাগরি</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('products.index', ['category' => 'organic-products']) }}" class="hover:text-white transition-colors">সুন্দরবনের খাঁটি মধু</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'organic-products']) }}" class="hover:text-white transition-colors">ঘানি ভাঙা সরিষার তেল</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'home-kitchen']) }}" class="hover:text-white transition-colors">ভেজিটেবল চপার ও কাটার</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-white transition-colors">T9 ভিন্টেজ হেয়ার ট্রিমার</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-white transition-colors">স্মার্ট ওয়াচ ও ব্লুটুথ কলিং</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">গ্রাহক সেবা</h3>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('tracking.index') }}" class="hover:text-white transition-colors">অর্ডার ট্র্যাকিং</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-white transition-colors">ক্যাশ অন ডেলিভারি চেকআউট</a></li>
                        <li><span class="text-slate-400">ডেলিভারি: ঢাকা সিটিতে ৳{{ $settings['delivery_inside_dhaka'] ?? 70 }} | ঢাকার বাইরে ৳{{ $settings['delivery_outside_dhaka'] ?? 130 }}</span></li>
                        <li><span class="text-slate-400">রিটার্ন পলিসি: পণ্য চেক করে মূল্য পরিশোধ</span></li>
                    </ul>
                </div>

                <!-- Assurance & Payment -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-emerald-500 pl-2">আমাদের অঙ্গীকার</h3>
                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-300 mb-4">
                        <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/60 flex items-center gap-2">
                            <span class="text-emerald-400 text-base">🛡️</span>
                            <span>১০০% ক্যাশ অন ডেলিভারি</span>
                        </div>
                        <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/60 flex items-center gap-2">
                            <span class="text-emerald-400 text-base">⚡</span>
                            <span>দ্রুততম হোম ডেলিভারি</span>
                        </div>
                        <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/60 flex items-center gap-2">
                            <span class="text-emerald-400 text-base">🔄</span>
                            <span>৭ দিনের রিপ্লেসমেন্ট</span>
                        </div>
                        <div class="bg-slate-800/80 p-2.5 rounded-lg border border-slate-700/60 flex items-center gap-2">
                            <span class="text-emerald-400 text-base">💯</span>
                            <span>খাঁটি মানের নিশ্চয়তা</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} DemandHat BD. সর্বস্বত্ব সংরক্ষিত।</p>
                <div class="flex items-center gap-4">
                    <span>ক্যাশ অন ডেলিভারি</span>
                    <span>•</span>
                    <span>bKash</span>
                    <span>•</span>
                    <span>Nagad</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Slide-over Cart Drawer Component -->
    <div id="cartDrawer" class="fixed inset-0 z-50 overflow-hidden hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div id="cartBackdrop" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div class="w-screen max-w-md bg-white shadow-2xl flex flex-col">
                <div class="p-4 sm:p-6 bg-slate-900 text-white flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <h2 class="text-base sm:text-lg font-bold"><span data-i18n="shopping_bag">শপিং ব্যাগ</span> (<span id="cartDrawerCount">0</span>)</h2>
                    </div>
                    <button id="closeCartBtn" class="text-slate-400 hover:text-white p-1 cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div id="cartItemsContainer" class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4">
                    <!-- Dynamic Cart Items injected via JavaScript -->
                    <div id="emptyCartState" class="text-center py-16 text-slate-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <p class="text-sm font-medium" data-i18n="empty_cart">আপনার শপিং ব্যাগ বর্তমানে খালি রয়েছে।</p>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block text-xs font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg hover:bg-emerald-100 cursor-pointer" data-i18n="start_shopping">শপিং শুরু করুন →</a>
                    </div>
                </div>

                <div id="cartFooter" class="p-4 sm:p-6 border-t border-slate-200 bg-slate-50 space-y-3 hidden">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600 font-bold" data-i18n="subtotal">মোট সাবটোটাল:</span>
                        <span id="cartDrawerSubtotal" class="font-bold text-slate-900 text-lg">৳ 0</span>
                    </div>
                    <p class="text-xs text-slate-500" data-i18n="shipping_calc_note">ডেলিভারি চার্জ চেকআউট পেজে এলাকা অনুযায়ী হিসাব করা হবে।</p>
                    <a href="{{ route('checkout.index') }}" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-center text-sm flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition-all cursor-pointer">
                        <span data-i18n="checkout_proceed">অর্ডার সম্পন্ন করতে এগিয়ে যান (ক্যাশ অন ডেলিভারি)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Buy Modal Component (Completely Crystal Sharp & Interactive) -->
    <div id="quickOrderModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Separate Backdrop (No backdrop-filter on card, pure dark mask) -->
        <div id="quickOrderBackdrop" class="fixed inset-0 bg-slate-950/75 z-40 transition-opacity cursor-pointer"></div>
        
        <!-- Centered Dialog Wrapper (Pointer events on wrapper disabled, re-enabled on modal card) -->
        <div class="relative z-50 min-h-screen flex items-center justify-center p-3 sm:p-6 pointer-events-none">
            <!-- Modal Card -->
            <div class="relative w-full max-w-lg bg-white rounded-3xl text-left shadow-2xl border border-slate-200 pointer-events-auto overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-4 sm:p-5 text-white flex items-center justify-between">
                    <div>
                        <h3 class="text-base sm:text-lg font-bold flex items-center gap-1.5">
                            <span>⚡</span> <span data-i18n="quick_order_title">দ্রুত ক্যাশ অন ডেলিভারি অর্ডার</span>
                        </h3>
                        <p class="text-xs text-emerald-100 mt-0.5" data-i18n="quick_order_subtitle">তথ্য পূরণ করুন, ডেলিভারি ম্যানের হাতে পণ্য পেয়ে টাকা দিন।</p>
                    </div>
                    <button type="button" id="closeQuickModalBtn" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form id="quickOrderForm" class="p-5 sm:p-6 space-y-4">
                    @csrf
                    <!-- Product details snapshot -->
                    <div id="modalProductSummary" class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                        <img id="modalProductThumb" src="" alt="Product" class="w-14 h-14 object-cover rounded-xl border border-slate-200 shadow-sm">
                        <div class="flex-1 min-w-0">
                            <h4 id="modalProductName" class="text-xs sm:text-sm font-bold text-slate-900 truncate"></h4>
                            <div class="flex items-center gap-2 mt-1">
                                <span id="modalProductPrice" class="text-sm font-black text-emerald-700">৳0</span>
                                <div class="flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white text-xs">
                                    <button type="button" id="modalQtyMinus" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors cursor-pointer">-</button>
                                    <input type="number" id="modalQtyInput" name="quantity" value="1" min="1" max="20" class="w-9 text-center font-bold text-slate-800 border-x border-slate-200 text-xs py-1" readonly>
                                    <button type="button" id="modalQtyPlus" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition-colors cursor-pointer">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="modalProductId" name="product_id" value="">

                    <!-- Customer details inputs -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1"><span data-i18n="name_label">আপনার নাম</span> <span class="text-rose-500">*</span></label>
                        <input type="text" name="customer_name" required placeholder="সম্পূর্ণ নাম লিখুন" data-i18n-placeholder="name_placeholder"
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1"><span data-i18n="phone_label">মোবাইল নম্বর</span> <span class="text-rose-500">*</span></label>
                        <input type="tel" name="phone" required placeholder="যেমন: 017XXXXXXXX" data-i18n-placeholder="phone_placeholder"
                               pattern="^(?:\+?88)?01[3-9]\d{8}$"
                               class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-all font-medium">
                        <p class="text-[11px] text-slate-500 mt-0.5" data-i18n="phone_hint">১১ ডিজিটের সঠিক মোবাইল নম্বর দিন।</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1"><span data-i18n="address_label">সম্পূর্ণ ঠিকানা</span> <span class="text-rose-500">*</span></label>
                        <textarea name="address" rows="2" required placeholder="গ্রাম/রোড নম্বর, বাড়ি/ফ্ল্যাট নম্বর, থানা, জেলা" data-i18n-placeholder="address_placeholder"
                                  class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:outline-none transition-all"></textarea>
                    </div>

                    <!-- Delivery Area Selector -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5"><span data-i18n="delivery_area_label">ডেলিভারি এলাকা</span> <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-3 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/70 transition-all">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_area" value="inside_dhaka" checked class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-800" data-i18n="inside_dhaka">ঢাকা সিটিতে</span>
                                </div>
                                <span class="text-xs font-black text-emerald-700">৳{{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                            </label>
                            <label class="flex items-center justify-between p-3 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/70 transition-all">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_area" value="outside_dhaka" class="text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-800" data-i18n="outside_dhaka">ঢাকার বাইরে</span>
                                </div>
                                <span class="text-xs font-black text-emerald-700">৳{{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Total summary -->
                    <div class="bg-slate-100 p-3.5 rounded-2xl flex items-center justify-between text-sm">
                        <span class="text-slate-600 font-bold" data-i18n="total_payable">মোট প্রদেয় টাকা:</span>
                        <span id="modalGrandTotal" class="text-xl font-black text-emerald-700">৳0</span>
                    </div>

                    <div id="quickOrderError" class="text-xs text-rose-600 bg-rose-50 p-2.5 rounded-xl border border-rose-200 hidden"></div>

                    <!-- Submit Button -->
                    <button type="submit" id="modalSubmitBtn" class="w-full py-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-800 text-white font-black rounded-2xl text-sm shadow-xl hover:shadow-emerald-600/30 active:scale-98 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span data-i18n="confirm_order">অর্ডার নিশ্চিত করুন (Cash on Delivery)</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Shortcut -->
    @if(!empty($settings['store_whatsapp']))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['store_whatsapp']) }}?text=Hello%2C%20I%20want%20to%20order" target="_blank"
       class="fixed bottom-5 right-5 z-40 bg-emerald-500 hover:bg-emerald-600 text-white p-3.5 rounded-full shadow-2xl hover:scale-110 transition-transform flex items-center justify-center group"
       title="WhatsApp-এ যোগাযোগ করুন">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
    </a>
    @endif

    <script>
        // Store configurations accessible to JS
        window.DemandHat = {
            deliveryInside: {{ $settings['delivery_inside_dhaka'] ?? 70 }},
            deliveryOutside: {{ $settings['delivery_outside_dhaka'] ?? 130 }},
            checkoutUrl: "{{ route('checkout.store') }}",
            csrfToken: "{{ csrf_token() }}",
            fbPixelId: "{{ $settings['fb_pixel_id'] ?? '' }}"
        };
    </script>
    @stack('scripts')
</body>
</html>
