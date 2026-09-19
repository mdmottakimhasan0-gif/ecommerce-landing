<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', ($settings['store_name'] ?? 'DemandHat BD') . ' - ' . ($settings['store_tagline'] ?? 'সেরা অনলাইন শপ'))</title>
    <meta name="description" content="@yield('meta_description', 'DemandHat BD - খাঁটি অর্গানিক ফুড, হোম ও কিচেন গ্যাজেট এবং ট্রেন্ডিং ইলেকট্রনিক্স পণ্যের বিশ্বস্ত অনলাইন শপ। সারাদেশে ক্যাশ অন ডেলিভারি।')">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="@yield('title', $settings['store_name'] ?? 'DemandHat BD')">
    <meta property="og:description" content="@yield('meta_description', 'সেরা মূল্যে প্রিমিয়াম পণ্য অর্ডার করুন ক্যাশ অন ডেলিভারিতে')">
    <meta property="og:image" content="@yield('og_image', 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80')">
    <meta property="og:type" content="website">

    <!-- Modern Typography: Poppins & Hind Siliguri -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">

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
<body class="font-sans antialiased bg-slate-50 text-slate-900 min-h-screen flex flex-col selection:bg-emerald-500 selection:text-white max-w-full overflow-x-hidden">
    @if(!empty($settings['gtm_id']))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $settings['gtm_id'] }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    <!-- Top Announcement Bar (Controlled by Admin on/off toggle and animated text) -->
    @if(($settings['announcement_active'] ?? '1') === '1' && !empty($settings['announcement_text'] ?? ''))
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white text-xs sm:text-sm py-2 px-4 shadow-sm border-b border-emerald-900/40 overflow-hidden">
        <div class="max-w-7xl mx-auto flex items-center justify-center text-center">
            <div class="inline-flex items-center gap-2 font-medium">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping flex-shrink-0"></span>
                <span class="animate-pulse" data-i18n="announcement">{{ $settings['announcement_text'] }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Navigation Header -->
    <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-2.5 sm:py-3">
            <div class="flex items-center justify-between gap-2 sm:gap-4">
                
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 flex-shrink-0 group">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-bold text-lg sm:text-xl shadow-md group-hover:scale-105 transition-transform flex-shrink-0">
                        D
                    </div>
                    <div>
                        <span class="text-lg sm:text-2xl font-black tracking-tight text-slate-900 block leading-tight">
                            DEMAND<span class="text-emerald-600">HAT</span>
                        </span>
                        <span class="text-[10px] text-slate-500 tracking-wider uppercase font-semibold hidden sm:block">Smart eCommerce BD</span>
                    </div>
                </a>

                <!-- Search Bar with Compact BN/EN Switcher Button -->
                <div class="hidden md:flex flex-1 max-w-xl mx-4 items-center gap-2">
                    <form action="{{ route('products.index') }}" method="GET" class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="মধু, ঘি, কিচেন চপার, ট্রিমার বা পণ্য খুঁজুন..." data-i18n-placeholder="search_placeholder"
                               class="w-full pl-4 pr-12 py-2.5 bg-slate-100 border border-slate-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 w-9 h-9 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full flex items-center justify-center transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>

                    <!-- Compact Language Switch Button (BN / EN) -->
                    <button type="button" id="headerLangBtn" onclick="toggleLanguage()"
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 border border-slate-300 rounded-full text-xs font-bold text-slate-700 shadow-2xs transition-all cursor-pointer flex-shrink-0"
                            title="ভাষা পরিবর্তন করুন (Switch Language)">
                        <span id="headerLangFlag">🇧🇩</span>
                        <span id="headerLangText">বাংলা</span>
                    </button>
                </div>

                <!-- Right Actions: Track Order Button, User Profile Icon, Cart Trigger -->
                <div class="flex items-center gap-1.5 sm:gap-3 flex-shrink-0">

                    <!-- Track Order Button -->
                    <a href="{{ route('tracking.index') }}" 
                       class="w-9 h-9 sm:w-auto sm:px-3.5 sm:py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 rounded-xl text-xs sm:text-sm font-bold transition-all shadow-2xs flex items-center justify-center gap-1.5 flex-shrink-0"
                       title="অর্ডার ট্র্যাক করুন">
                        <span class="text-sm">📦</span>
                        <span class="hidden sm:inline" data-i18n="track_order">অর্ডার ট্র্যাক করুন</span>
                    </a>

                    <!-- User Account / Login Button (Customer or Admin) -->
                    <div class="relative flex-shrink-0" id="userAuthContainer">
                        @auth
                            <button type="button" id="userMenuBtn" onclick="toggleUserDropdown()"
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shadow-md transition-all cursor-pointer border-2 border-emerald-400/50 flex-shrink-0"
                                    title="{{ Auth::user()->name }}">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200 py-2 z-50 text-xs font-semibold">
                                <div class="px-4 py-2.5 border-b border-slate-100">
                                    <span class="block text-slate-900 font-bold text-sm truncate">{{ Auth::user()->name }}</span>
                                    <span class="block text-slate-500 text-[11px] truncate">
                                        @if(!empty(Auth::user()->phone))
                                            {{ Auth::user()->phone }}
                                        @else
                                            {{ Auth::user()->email }}
                                        @endif
                                    </span>
                                    @if(Auth::user()->isAdmin())
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded font-bold text-[10px]">Admin</span>
                                    @else
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-700 rounded font-bold text-[10px]">Customer</span>
                                    @endif
                                </div>

                                @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-emerald-700 font-bold">
                                    <span>🛠️</span> <span>Admin Dashboard</span>
                                </a>
                                @endif

                                <a href="{{ route('customer.orders') }}" class="flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 font-bold">
                                    <span>📦</span> <span>My Orders</span>
                                </a>

                                <button type="button" onclick="document.getElementById('cartDrawerBtn')?.click(); toggleUserDropdown();" 
                                        class="w-full text-left flex items-center gap-2.5 px-4 py-2 hover:bg-slate-50 text-slate-700 cursor-pointer">
                                    <span>🛒</span> <span>My Cart</span>
                                </button>

                                <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-100 mt-1">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center gap-2.5 px-4 py-2 hover:bg-rose-50 text-rose-600 transition-colors cursor-pointer">
                                        <span>🚪</span> <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <!-- Guest User Icon Button -> Opens Login Modal -->
                            <button type="button" onclick="openGlobalLoginModal()"
                                    class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white flex items-center justify-center shadow-md transition-all cursor-pointer border-2 border-emerald-400/50 flex-shrink-0"
                                    title="Sign In / Register">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </button>
                        @endauth
                    </div>

                    <!-- Cart Drawer Trigger Button (Mobile Compact Icon Button + Absolute Badge) -->
                    <button id="cartDrawerBtn" type="button" 
                            class="relative w-9 h-9 sm:w-auto sm:px-3.5 sm:py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:shadow-md transition-all cursor-pointer flex items-center justify-center gap-2 flex-shrink-0"
                            title="Shopping Cart">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="hidden sm:inline" data-i18n="cart">কার্ট</span>
                        <span id="cartCountBadge" class="absolute -top-1.5 -right-1.5 sm:static bg-amber-400 text-slate-950 text-[10px] sm:text-xs font-black min-w-[18px] h-[18px] sm:min-w-[20px] sm:h-auto px-1 sm:px-1.5 py-0 sm:py-0.5 rounded-full flex items-center justify-center shadow-sm text-center">0</span>
                    </button>
                </div>
            </div>

            <!-- Mobile Search Bar -->
            <div class="mt-2.5 md:hidden flex items-center gap-2">
                <form action="{{ route('products.index') }}" method="GET" class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="মধু, চপার বা গ্যাজেট খুঁজুন..." data-i18n-placeholder="search_placeholder"
                           class="w-full pl-3.5 pr-9 py-2 bg-slate-100 border border-slate-200 rounded-lg text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-500 hover:text-emerald-600 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <!-- Mobile Language Switcher Button -->
                <button type="button" onclick="toggleLanguage()" class="px-2.5 py-2 bg-slate-100 border border-slate-200 rounded-lg text-xs font-bold text-slate-700 flex-shrink-0 cursor-pointer" title="Switch Language">
                    <span id="headerLangFlagMobile">🇧🇩</span>
                </button>
            </div>
        </div>

        <!-- Category Navigation Menu Bar (Dynamic with Center or Left Alignment) -->
        @php
            $storedNavRaw = $settings['header_nav_menu'] ?? null;
            $navAlignment = $settings['header_nav_alignment'] ?? 'center';
            $headerNavItems = \App\Http\Controllers\Admin\MenuController::getDefaultMenuItems();
            if (!empty($storedNavRaw)) {
                $decodedNav = json_decode($storedNavRaw, true);
                if (is_array($decodedNav)) {
                    $headerNavItems = $decodedNav;
                }
            }
            $alignClass = $navAlignment === 'center' ? 'justify-center' : ($navAlignment === 'right' ? 'justify-end' : 'justify-start');
        @endphp

        <nav class="bg-slate-100/90 border-t border-slate-200/80 px-3 sm:px-6 lg:px-8 overflow-x-auto whitespace-nowrap">
            <div class="max-w-7xl mx-auto flex items-center gap-4 sm:gap-6 py-2 sm:py-2.5 text-xs sm:text-sm font-medium text-slate-700 justify-start sm:{{ $alignClass }}">
                @foreach($headerNavItems as $navItem)
                    @if(!empty($navItem['is_active']))
                    <a href="{{ $navItem['url'] ?? '#' }}" 
                       class="hover:text-emerald-600 flex items-center gap-1.5 transition-colors flex-shrink-0 {{ request()->fullUrlIs(url($navItem['url'] ?? '#')) || request()->is(ltrim($navItem['url'] ?? '#', '/')) ? 'text-emerald-600 font-bold' : '' }}">
                        @if(!empty($navItem['icon']))
                            <span>{{ $navItem['icon'] }}</span>
                        @endif
                        <span>{{ $navItem['title'] ?? '' }}</span>
                    </a>
                    @endif
                @endforeach
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

    <!-- Global Unified Auth Modal (Customer / Admin - Sign In & Register) -->
    <div id="globalLoginModal" class="fixed inset-0 z-50 overflow-y-auto {{ ($errors->any() || session('error')) && !Auth::check() ? '' : 'hidden' }}" aria-labelledby="login-modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Modal Backdrop -->
            <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-xs transition-opacity" onclick="closeGlobalLoginModal()"></div>

            <div class="relative inline-block w-full max-w-md p-6 sm:p-8 my-8 text-left align-middle bg-white rounded-3xl shadow-2xl transform transition-all border border-slate-100 z-10">
                <!-- Close Button -->
                <button type="button" onclick="closeGlobalLoginModal()" 
                        class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Modal Header -->
                <div class="text-center mb-5">
                    <div class="w-14 h-14 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shadow-inner mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight" id="login-modal-title">Sign In</h3>
                </div>

                <!-- Auth Mode Switcher Tabs -->
                <div class="flex items-center bg-slate-100 p-1 rounded-2xl mb-5 border border-slate-200/80">
                    <button type="button" id="authTabLoginBtn" onclick="switchAuthTab('login')"
                            class="flex-1 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer bg-white text-slate-900 shadow-sm">
                        Sign In
                    </button>
                    <button type="button" id="authTabRegisterBtn" onclick="switchAuthTab('register')"
                            class="flex-1 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer text-slate-500 hover:text-slate-900">
                        Register
                    </button>
                </div>

                @if($errors->any() && !Auth::check())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl font-medium">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(session('error') && !Auth::check())
                <div class="mb-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl font-medium">
                    {{ session('error') }}
                </div>
                @endif

                <!-- 1. Sign In Form -->
                <form id="authLoginForm" action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email or Phone Number <span class="text-rose-500">*</span></label>
                        <input type="text" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="e.g. 017XXXXXXXX or email@domain.com"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-xs font-bold text-slate-700">Password <span class="text-rose-500">*</span></label>
                        </div>
                        <input type="password" name="password" required
                               placeholder="••••••••"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                            <span>Remember Me</span>
                        </label>
                    </div>

                    <button type="submit" 
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow-md hover:shadow-emerald-600/30 transition-all cursor-pointer">
                        Sign In
                    </button>

                    <div class="text-center pt-2">
                        <button type="button" onclick="switchAuthTab('register')" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold hover:underline cursor-pointer">
                            Don't have an account? Register now →
                        </button>
                    </div>
                </form>

                <!-- 2. Customer Registration Form -->
                <form id="authRegisterForm" action="{{ route('register') }}" method="POST" class="space-y-3.5 hidden">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Full Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="e.g. John Doe"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number <span class="text-rose-500">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                               placeholder="017XXXXXXXX"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Address (Optional)</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="your@email.com"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password" required placeholder="Min 6 chars"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Confirm Password <span class="text-rose-500">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="Confirm password"
                                   class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm shadow-md hover:shadow-emerald-600/30 transition-all cursor-pointer mt-1">
                        Create Account
                    </button>

                    <div class="text-center pt-2">
                        <button type="button" onclick="switchAuthTab('login')" class="text-xs text-emerald-600 hover:text-emerald-700 font-bold hover:underline cursor-pointer">
                            Already have an account? Sign in →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store configurations accessible to JS
        window.DemandHat = {
            deliveryInside: {{ $settings['delivery_inside_dhaka'] ?? 70 }},
            deliveryOutside: {{ $settings['delivery_outside_dhaka'] ?? 130 }},
            checkoutUrl: "{{ route('checkout.store') }}",
            csrfToken: "{{ csrf_token() }}",
            fbPixelId: "{{ $settings['fb_pixel_id'] ?? '' }}"
        };

        // User Dropdown toggle
        function toggleUserDropdown() {
            const menu = document.getElementById('userDropdownMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Global Login Modal open/close
        function openGlobalLoginModal() {
            const modal = document.getElementById('globalLoginModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeGlobalLoginModal() {
            const modal = document.getElementById('globalLoginModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function switchAuthTab(tab) {
            const loginForm = document.getElementById('authLoginForm');
            const regForm = document.getElementById('authRegisterForm');
            const loginBtn = document.getElementById('authTabLoginBtn');
            const regBtn = document.getElementById('authTabRegisterBtn');
            const titleEl = document.getElementById('login-modal-title');

            if (tab === 'register') {
                loginForm?.classList.add('hidden');
                regForm?.classList.remove('hidden');
                loginBtn?.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                loginBtn?.classList.add('text-slate-500');
                regBtn?.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                regBtn?.classList.remove('text-slate-500');
                if (titleEl) titleEl.textContent = 'Create Account';
            } else {
                regForm?.classList.add('hidden');
                loginForm?.classList.remove('hidden');
                regBtn?.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
                regBtn?.classList.add('text-slate-500');
                loginBtn?.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
                loginBtn?.classList.remove('text-slate-500');
                if (titleEl) titleEl.textContent = 'Sign In';
            }
        }

        @if(($errors->has('name') || $errors->has('phone') || $errors->has('password_confirmation')) && !Auth::check())
            document.addEventListener('DOMContentLoaded', () => switchAuthTab('register'));
        @endif

        // Close dropdown / modal on outside click or ESC
        document.addEventListener('click', function(e) {
            const userContainer = document.getElementById('userAuthContainer');
            const userDropdown = document.getElementById('userDropdownMenu');
            if (userContainer && userDropdown && !userContainer.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGlobalLoginModal();
                const userDropdown = document.getElementById('userDropdownMenu');
                if (userDropdown) userDropdown.classList.add('hidden');
            }
        });

        // Comprehensive Bilingual Translation System
        const i18nDictionary = {
            bn: {
                flag: '🇧🇩',
                text: 'বাংলা',
                announcement: "{{ $settings['announcement_text'] ?? '⚡ রমজান স্পেশাল ক্যাশ অন ডেলিভারি অফার! সারা দেশে দ্রুততম হোম ডেলিভারি' }}",
                search_placeholder: 'মধু, ঘি, কিচেন চপার, ট্রিমার বা পণ্য খুঁজুন...',
                track_order: 'অর্ডার ট্র্যাক করুন',
                cart: 'কার্ট',
                shopping_bag: 'শপিং ব্যাগ',
                empty_cart: 'আপনার শপিং ব্যাগ বর্তমানে খালি রয়েছে।',
                start_shopping: 'শপিং শুরু করুন →',
                subtotal: 'মোট সাবটোটাল:',
                shipping_calc_note: 'ডেলিভারি চার্জ চেকআউট পেজে এলাকা অনুযায়ী হিসাব করা হবে।',
                checkout_proceed: 'অর্ডার সম্পন্ন করতে এগিয়ে যান (ক্যাশ অন ডেলিভারি)',
                quick_order_title: 'দ্রুত ক্যাশ অন ডেলিভারি অর্ডার',
                quick_order_subtitle: 'তথ্য পূরণ করুন, ডেলিভারি ম্যানের হাতে পণ্য পেয়ে টাকা দিন।',
                name_label: 'আপনার নাম',
                name_placeholder: 'সম্পূর্ণ নাম লিখুন',
                phone_label: 'মোবাইল নম্বর',
                phone_placeholder: 'যেমন: 017XXXXXXXX',
                phone_hint: '১১ ডিজিটের সঠিক মোবাইল নম্বর দিন।',
                address_label: 'সম্পূর্ণ ঠিকানা',
                address_placeholder: 'গ্রাম/রোড নম্বর, বাড়ি/ফ্ল্যাট নম্বর, থানা, জেলা',
                delivery_area_label: 'ডেলিভারি এলাকা',
                inside_dhaka: 'ঢাকা সিটিতে',
                outside_dhaka: 'ঢাকার বাইরে',
                total_payable: 'মোট প্রদেয় টাকা:',
                confirm_order: 'অর্ডার নিশ্চিত করুন (Cash on Delivery)',
                b1_badge: '🌿 প্রিমিয়াম অর্গানিক ও লাইফস্টাইল কালেকশন',
                b1_title: 'প্রকৃতির খাঁটি স্বাদ ও আধুনিক গ্যাজেটের সেরা সমাহার!',
                b1_subtitle: 'সুন্দরবনের প্রাকৃতিক চাকের মধু, কাঠের ঘানি ভাঙা খাঁটি সরিষার তেল, স্মার্ট কিচেন চপার এবং ট্রেন্ডিং ইলেকট্রনিক্স গ্যাজেটস।',
                b1_btn1: 'সব পণ্য দেখুন 🛒',
                b1_btn2: 'খাঁটি অর্গানিক ফুড →',
                b2_badge: 'স্মার্ট হোম ও কিচেন',
                b2_title: 'মাল্টিফাংশন ভেজিটেবল চপার ও কাটার',
                b2_subtitle: 'রান্নার সময় বাঁচান নিমেষেই! মাত্র ৳ ৭৯০',
                b2_link: 'অর্ডার করুন এখনই →',
                b3_badge: 'মেগা টেক ডিসকাউন্ট',
                b3_title: 'T9 ভিন্টেজ হেয়ার ট্রিমার ও স্মার্ট ওয়াচ',
                b3_subtitle: '১ বছরের রিপ্লেসমেন্ট গ্যারান্টিসহ',
                b3_link: 'অফার দেখুন →',
                cod_feature: 'ক্যাশ অন ডেলিভারি',
                cod_desc: 'পণ্য হাতে পেয়ে টাকা পরিশোধ',
                fast_delivery_feature: 'দ্রুততম ডেলিভারি',
                fast_delivery_desc: '২৪-৪৮ ঘণ্টার হোম ডেলিভারি',
                pure_feature: '১০০% খাঁটি পণ্য',
                pure_desc: 'ল্যাব টেস্টে বিশুদ্ধ প্রমাণিত',
                return_feature: '৭ দিনের রিটার্ন',
                return_desc: 'সমস্যা হলে নিশ্চিত রিপ্লেসমেন্ট',
                special_categories: 'আমাদের স্পেশাল ক্যাটাগরি',
                special_categories_desc: 'আপনার প্রয়োজনীয় পণ্য সহজে খুঁজে নিন',
                all_categories: 'সব ক্যাটাগরি →',
                btn_order_now: '⚡ অর্ডার করুন',
                btn_add_to_cart: '+ কার্টে নিন',
                trending_title: 'ট্রেন্ডিং ও জনপ্রিয় পণ্যসমূহ',
                trending_desc: 'সবচেয়ে বেশি অর্ডার করা প্রিমিয়াম পণ্যসমূহ',
                view_all: 'সবগুলো দেখুন →',
                order_now: 'অর্ডার করুন',
                add_to_cart_short: '+ কার্ট',
                reviews_badge: 'সম্মানিত গ্রাহকদের মতামত',
                reviews_title: 'আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ',
                reviews_desc: 'হাজারো পরিবারের আস্থার প্রতীক DemandHat BD'
            },
            en: {
                flag: '🇺🇸',
                text: 'English',
                announcement: '⚡ Special Cash on Delivery offer! Express home delivery nationwide',
                search_placeholder: 'Search honey, ghee, kitchen chopper, trimmer...',
                track_order: 'Track Order',
                cart: 'Cart',
                shopping_bag: 'Shopping Bag',
                empty_cart: 'Your shopping bag is currently empty.',
                start_shopping: 'Start Shopping →',
                subtotal: 'Subtotal:',
                shipping_calc_note: 'Delivery fee will be calculated at checkout based on area.',
                checkout_proceed: 'Proceed to Checkout (Cash on Delivery)',
                quick_order_title: 'Quick Cash on Delivery Order',
                quick_order_subtitle: 'Fill in details, pay cash upon product delivery.',
                name_label: 'Your Name',
                name_placeholder: 'Enter full name',
                phone_label: 'Mobile Number',
                phone_placeholder: 'e.g. 017XXXXXXXX',
                phone_hint: 'Provide an 11-digit active phone number.',
                address_label: 'Full Address',
                address_placeholder: 'Village/Road, House/Flat, Police Station, District',
                delivery_area_label: 'Delivery Area',
                inside_dhaka: 'Inside Dhaka',
                outside_dhaka: 'Outside Dhaka',
                total_payable: 'Total Payable:',
                confirm_order: 'Confirm Order (Cash on Delivery)',
                b1_badge: '🌿 Premium Organic & Lifestyle Collection',
                b1_title: 'Pure Taste of Nature & Modern Gadgets!',
                b1_subtitle: 'Sundarbans raw honey, cold-pressed mustard oil, smart kitchen chopper and trending gadgets.',
                b1_btn1: 'View All Products 🛒',
                b1_btn2: 'Pure Organic Food →',
                b2_badge: 'Smart Home & Kitchen',
                b2_title: 'Multifunctional Vegetable Chopper & Cutter',
                b2_subtitle: 'Save cooking time instantly! Only ৳790',
                b2_link: 'Order Now →',
                b3_badge: 'Mega Tech Discount',
                b3_title: 'T9 Vintage Hair Trimmer & Smart Watch',
                b3_subtitle: 'With 1 Year Replacement Guarantee',
                b3_link: 'View Offer →',
                cod_feature: 'Cash on Delivery',
                cod_desc: 'Pay after receiving product',
                fast_delivery_feature: 'Express Delivery',
                fast_delivery_desc: '24-48 Hours Home Delivery',
                pure_feature: '100% Pure Products',
                pure_desc: 'Lab Tested & Verified Pure',
                return_feature: '7 Days Return',
                return_desc: 'Guaranteed replacement on issues',
                special_categories: 'Our Special Categories',
                special_categories_desc: 'Easily find the products you need',
                all_categories: 'All Categories →',
                btn_order_now: '⚡ Order Now',
                btn_add_to_cart: '+ Add to Cart',
                trending_title: 'Trending & Popular Products',
                trending_desc: 'Most ordered premium products',
                view_all: 'View All →',
                order_now: 'Order Now',
                add_to_cart_short: '+ Cart',
                reviews_badge: 'Customer Reviews',
                reviews_title: 'Reviews from Satisfied Customers',
                reviews_desc: 'DemandHat BD - Trusted by thousands of families'
            }
        };

        // Complete Comprehensive Phrase Translation Map for All Dynamic & Static Storefront Content
        const phraseTranslations = {
            // Announcement & Top Bar
            "🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি | ১০০% ক্যাশব্যাক গ্যারান্টি!": "🔥 Nationwide Cash on Delivery | 48hr Home Delivery | 100% Cashback Guarantee!",
            "দেশজুড়ে ৪৮ ঘণ্টায় ক্যাশ অন ডেলিভারি! প্রতিটি পণ্যে থাকছে ১০০% রিটার্ন গ্যারান্টি।": "Nationwide Cash on Delivery in 48 hours! 100% return guarantee on every product.",
            "রমজান স্পেশাল ক্যাশ অন ডেলিভারি অফার! সারা দেশে দ্রুততম হোম ডেলিভারি": "Special Cash on Delivery Offer! Fastest nationwide home delivery",
            "সেরা মূল্যে ১০০% জেনুইন ও প্রিমিয়াম কোয়ালিটি পণ্য": "100% Genuine & Premium Quality Products at Best Price",
            "সেরা অনলাইন শপ": "Best Online Shop",
            "সেরা অনলাইন শপিং": "Best Online Shopping",
            "আপনার আস্থাই আমাদের অনুপ্রেরণা।": "Your trust is our greatest inspiration.",

            // Header & Navbar
            "হোমপেজ": "Home",
            "সব প্রোডাক্ট": "All Products",
            "সব পণ্যসমূহ": "All Products",
            "সব প্রিমিয়াম পণ্যসমূহ": "All Premium Products",
            "অর্গানিক ফুড": "Organic Food",
            "🌿 অর্গানিক ফুড": "🌿 Organic Food",
            "হোম ও কিচেন": "Home & Kitchen",
            "🍳 হোম ও কিচেন": "🍳 Home & Kitchen",
            "হোম ও কিচেন (Home & Kitchen)": "Home & Kitchen",
            "ইলেকট্রনিক্স ও গ্যাজেট": "Electronics & Gadgets",
            "⚡ ইলেকট্রনিক্স ও গ্যাজেট": "⚡ Electronics & Gadgets",
            "ইলেকট্রনিক্স ও গ্যাজেট (Electronics)": "Electronics & Gadgets",
            "অর্ডার ট্র্যাক করুন": "Track Order",
            "📦 অর্ডার ট্র্যাক করুন": "📦 Track Order",
            "কার্ট": "Cart",
            "বাংলা": "English",
            "এডমিন ড্যাশবোর্ড": "Admin Dashboard",
            "আমার অর্ডারসমূহ": "My Orders",
            "লগআউট": "Logout",
            "এডমিন (Admin)": "Admin",
            "কাস্টমার (Customer)": "Customer",

            // Hero Banners
            "🌿 প্রিমিয়াম অর্গানিক ও লাইফস্টাইল কালেকশন": "🌿 Premium Organic & Lifestyle Collection",
            "প্রিমিয়াম অর্গানিক ও লাইফস্টাইল কালেকশন": "Premium Organic & Lifestyle Collection",
            "প্রকৃতির খাঁটি স্বাদ ও আধুনিক গ্যাজেটের সেরা সমাহার!": "Pure Taste of Nature & Modern Gadgets!",
            "সুন্দরবনের প্রাকৃতিক চাকের মধু, কাঠের ঘানি ভাঙা খাঁটি সরিষার তেল, স্মার্ট কিচেন চপার এবং ট্রেন্ডিং ইলেকট্রনিক্স গ্যাজেটস।": "Sundarbans raw honey, cold-pressed mustard oil, smart kitchen chopper and trending gadgets.",
            "সব পণ্য দেখুন 🛒": "View All Products 🛒",
            "সব পণ্য দেখুন →": "View All Products →",
            "খাঁটি অর্গানিক ফুড →": "Pure Organic Food →",
            "স্মার্ট হোম ও কিচেন": "Smart Home & Kitchen",
            "মাল্টিফাংশন ভেজিটেবল চপার ও কাটার": "Multifunction Vegetable Chopper & Cutter",
            "রান্নার সময় বাঁচান নিমেষেই! মাত্র ৳ ৭৯০": "Save cooking time instantly! Only ৳790",
            "রান্নার সময় বাঁচান নিমেষেই! মাত্র ৳ 790": "Save cooking time instantly! Only ৳790",
            "অর্ডার করুন এখনই →": "Order Now →",
            "মেগা টেক ডিসকাউন্ট": "Mega Tech Discount",
            "T9 ভিন্টেজ হেয়ার ট্রিমার ও স্মার্ট ওয়াচ": "T9 Vintage Hair Trimmer & Smart Watch",
            "১ বছরের রিপ্লেসমেন্ট গ্যারান্টি সহ!": "With 1 Year Replacement Guarantee!",
            "১ বছরের রিপ্লেসমেন্ট গ্যারান্টিসহ": "With 1 Year Replacement Guarantee",
            "1 বছরের রিপ্লেসমেন্ট গ্যারান্টি সহ!": "With 1 Year Replacement Guarantee!",
            "1 বছরের রিপ্লেসমেন্ট গ্যারান্টিসহ": "With 1 Year Replacement Guarantee",
            "অফার দেখুন →": "View Offer →",

            // Trust Features Bar
            "ক্যাশ অন ডেলিভারি": "Cash on Delivery",
            "পণ্য হাতে পেয়ে টাকা পরিশোধ": "Pay after receiving product",
            "দ্রুততম ডেলিভারি": "Fastest Delivery",
            "২৪-৪৮ ঘণ্টার হোম ডেলিভারি": "24-48 Hours Home Delivery",
            "24-48 ঘণ্টার হোম ডেলিভারি": "24-48 Hours Home Delivery",
            "৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি": "Guaranteed 48hr Home Delivery",
            "৪৮ ঘণ্টায় ডেলিভারি": "48-Hour Delivery",
            "১০০% খাঁটি পণ্য": "100% Pure Products",
            "100% খাঁটি পণ্য": "100% Pure Products",
            "ল্যাব টেস্টে বিশুদ্ধ প্রমাণিত": "Lab Tested & Verified Pure",
            "৭ দিনের রিটার্ন": "7 Days Return",
            "7 দিনের রিটার্ন": "7 Days Return",
            "৭ দিনের রিপ্লেসমেন্ট": "7-Day Replacement",
            "7 দিনের রিপ্লেসমেন্ট": "7-Day Replacement",
            "সমস্যা হলে নিশ্চিত রিপ্লেসমেন্ট": "Guaranteed replacement on issues",
            "খাঁটি মানের নিশ্চয়তা": "Guaranteed Pure Quality",
            "চেক করে মূল্য পরিশোধ": "Check before payment",
            "পণ্য চেক করার পর মূল্য পরিশোধের সুযোগ": "Inspect product before paying",
            "দ্রুততম হোম ডেলিভারি": "Fastest Home Delivery",

            // Categories
            "আমাদের স্পেশাল ক্যাটাগরি": "Our Special Categories",
            "আপনার প্রয়োজনীয় পণ্য সহজে খুঁজে নিন": "Easily find the products you need",
            "সব ক্যাটাগরি →": "All Categories →",
            "টি পণ্য উপলব্ধ": " Products Available",
            "সুন্দরবনের খাঁটি মধু ও অর্গানিক ফুড": "Sundarbans Pure Honey & Organic Food",
            "স্মার্ট হোম ও কিচেন এক্সেসরিজ": "Smart Home & Kitchen Accessories",
            "ট্রেন্ডিং ইলেকট্রনিক্স ও লাইফস্টাইল গ্যাজেটস": "Trending Electronics & Lifestyle Gadgets",
            "১০০% প্রিমিয়াম ও খাঁটি স্বাস্থ্যসম্মত খাদ্যসামগ্রী": "100% premium and healthy pure foods",
            "রান্নাঘরের কাজ সহজ করার আধুনিক সামগ্রী": "Modern accessories to simplify kitchen tasks",
            "দৈনন্দিন জীবনের প্রয়োজনীয় স্মার্ট গ্যাজেট": "Essential smart gadgets for daily life",

            // Flash Deals & Products
            "⚡ হট ডিসকাউন্ট অফার": "⚡ Hot Discount Offer",
            "আজকের মেগা ফ্ল্যাশ সেল (Flash Deals)": "Today's Mega Flash Deals",
            "আজকের মেগা ফ্ল্যাশ সেল": "Today's Mega Flash Deals",
            "সীমিত সময়ের জন্য বিশাল মূল্যছাড়! স্টক ফুরিয়ে যাওয়ার আগেই অর্ডার করুন।": "Limited-time huge discounts! Order before stock runs out.",
            "অফার শেষ হতে:": "Offer ends in:",
            "ঘণ্টা": "Hours",
            "মিনিট": "Mins",
            "সেকেন্ড": "Secs",
            "🔥 ফ্ল্যাশ সেল": "🔥 Flash Sale",
            "ছাড়": "OFF",
            "মূল্যছাড়": "Discount",
            "স্টক শেষ": "Out of Stock",
            "স্টক উপলব্ধ": "In Stock",
            "টি বাকি": " left",
            "টি পণ্য পাওয়া গেছে": " products found",
            "মোট": "Total",
            "অনুসন্ধান ফলাফল:": "Search result:",
            "সর্ট করুন:": "Sort by:",
            "নতুন পণ্য (Latest)": "New Arrivals (Latest)",
            "দাম: কম থেকে বেশি": "Price: Low to High",
            "দাম: বেশি থেকে কম": "Price: High to Low",
            "সবগুলো (All)": "All",
            "সবগুলো": "All",
            "কোনো পণ্য পাওয়া যায়নি": "No products found",
            "অন্য কোনো কি-ওয়ার্ড দিয়ে খুঁজুন অথবা সব ক্যাটাগরি ব্রাউজ করুন।": "Search with different keywords or browse all categories.",
            "ট্রেন্ডিং ও জনপ্রিয় পণ্যসমূহ": "Trending & Popular Products",
            "সবচেয়ে বেশি অর্ডার করা প্রিমিয়াম পণ্যসমূহ": "Most ordered premium products",
            "সবগুলো দেখুন": "View All",
            "জনপ্রিয় সেরা পণ্যসমূহ": "Popular Best Products",
            "আমাদের সর্বাধিক বিক্রিত এবং গ্রাহকপ্রিয় আইটেমগুলো": "Our best-selling and customer-favorite items",
            "সবগুলো পণ্য ব্রাউজ করুন": "Browse All Products",
            "⚡ অর্ডার করুন": "⚡ Order Now",
            "অর্ডার করুন": "Order Now",
            "+ কার্টে নিন": "+ Add to Cart",
            "+ কার্ট": "+ Cart",
            "🚀 স্পেশাল অফার পেজ": "🚀 Special Offer Page",
            "🚀 স্পেশাল অফার": "🚀 Special Offer",
            "স্পেশাল অফার পেজে যান 🚀": "Go to Special Offer Page 🚀",
            "এই পণ্যের বিশেষ সেলস ল্যান্ডিং পেজ ও অফার দেখুন!": "View special sales landing page & offers for this product!",
            "ল্যাব টেস্ট ভিডিও, আনবক্সিং এবং এক্সক্লুসিভ গিফট অফার উপভোগ করুন।": "Enjoy lab test videos, unboxing, and exclusive gift offers.",
            "ল্যান্ডিং পেজ দেখুন →": "View Landing Page →",
            "অর্ডার করতে আপনার তথ্য দিন": "Enter details to place order",
            "সরাসরি অর্ডার (Cash on Delivery)": "Direct Order (Cash on Delivery)",

            // Product Names
            "১২-ইন-১ মাল্টিফাংশন প্রিমিয়াম ভেজিটেবল ও ফ্রুট কাটার চপার": "12-in-1 Multifunction Premium Vegetable & Fruit Cutter Chopper",
            "রিচার্জেবল পোর্টেবল ইউএসবি জুসার ও স্মুদি ব্লেন্ডার": "Rechargeable Portable USB Juicer & Smoothie Blender",
            "T9 প্রফেশনাল ভিন্টেজ মেটাল হেয়ার ও বিয়ার্ড ট্রিমার": "T9 Professional Vintage Metal Hair & Beard Trimmer",
            "Ultra 8 Series ওয়াটারপ্রুফ স্মার্ট ওয়াচ (ব্লুটুথ কলিং সহ)": "Ultra 8 Series Waterproof Smart Watch (with Bluetooth Calling)",
            "সুন্দরবনের প্রাকৃতিক চাকের মধু": "Sundarbans Raw Honey",
            "কাঠের ঘানিতে ভাঙা খাঁটি সরিষার তেল": "Cold-Pressed Mustard Oil",
            "মাল্টিফাংশন ড্রাম ভেজিটেবল স্লাইসার": "Multifunction Drum Vegetable Slicer",
            "T9 ভিন্টেজ কর্ডলেস হেয়ার ট্রিমার": "T9 Vintage Cordless Hair Trimmer",
            "আল্ট্রা-স্লিক ব্লুটুথ স্মার্টওয়াচ": "Ultra-Sleek Bluetooth Smartwatch",
            "খাঁটি গাওয়া ঘি": "Pure Cow Ghee",
            "স্পেশাল ড্রাই ফ্রুটস কম্বো": "Special Dry Fruits Combo",
            "স্মার্ট ইলেকট্রিক হটপট": "Smart Electric Hotpot",

            // Customer Reviews
            "সম্মানিত গ্রাহকদের মতামত": "Valued Customer Feedback",
            "আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ": "Reviews from Satisfied Customers",
            "হাজারো পরিবারের আস্থার প্রতীক DemandHat BD": "DemandHat BD - Trusted by thousands of families",
            "উত্তরা, ঢাকা • ভেরিফায়েড বায়ার": "Uttara, Dhaka • Verified Buyer",
            "ধানমন্ডি, ঢাকা • ভেরিফায়েড বায়ার": "Dhanmondi, Dhaka • Verified Buyer",
            "চট্টগ্রাম সদর • ভেরিফায়েড বায়ার": "Chattogram Sadar • Verified Buyer",
            "মাহমুদুল হাসান": "Mahmudul Hasan",
            "রোকেয়া আক্তার": "Rokeya Akhter",
            "তানভীর আহমেদ": "Tanvir Ahmed",
            "সুন্দরবনের চাকের মধুটা সত্যি অসাধারণ! গন্ধ এবং স্বাদেই বোঝা যায় খাঁটি জিনিস। ঢাকার ভেতর মাত্র ২৪ ঘণ্টায় ক্যাশ অন ডেলিভারিতে পেয়েছি।": "The Sundarbans raw honey is truly amazing! You can tell it is pure from the aroma and taste. Delivered in Dhaka in just 24 hours.",
            "মাল্টিফাংশন চপারটি কেনার পর রান্নাঘরের পেঁয়াজ আর সবজি কাটা অনেক সহজ হয়ে গেছে। স্টিলের ব্লেডগুলো ভীষণ ধারালো। প্রোডাক্ট কোয়ালিটি নিয়ে কোনো সন্দেহ নেই।": "Kitchen onion and vegetable chopping became so effortless after buying this multifunctional chopper. Very sharp steel blades.",
            "T9 মেটাল ট্রিমারটি দেখতে যেমন প্রিমিয়াম কাজও করে নিখুঁত। ব্যাটারি ব্যাকআপ দারুণ। সবচেয়ে ভালো লেগেছে ডেলিভারি ম্যানের সামনে চেক করে নেওয়ার সিস্টেম।": "The T9 metal trimmer looks premium and performs flawlessly. Excellent battery backup. Loved the inspect-before-paying policy.",

            // Hotline & Footer
            "যেকোনো প্রশ্ন বা ফোনে সরাসরি অর্ডার করতে চান?": "Have questions or want to order by phone?",
            "আমাদের কাস্টমার কেয়ার টিম সপ্তাহের ৭ দিনই আপনার সেবায় প্রস্তুত।": "Our customer care team is ready to serve you 7 days a week.",
            "কল করুন:": "Call Us:",
            "কল করুন": "Call Us",
            "WhatsApp মেসেজ": "WhatsApp Message",
            "জনপ্রিয় ক্যাটাগরি": "Popular Categories",
            "সুন্দরবনের খাঁটি মধু": "Sundarbans Raw Honey",
            "ঘানি ভাঙা সরিষার তেল": "Cold-Pressed Mustard Oil",
            "ভেজিটেবল চপার ও কাটার": "Vegetable Chopper & Cutter",
            "T9 ভিন্টেজ হেয়ার ট্রিমার": "T9 Vintage Hair Trimmer",
            "স্মার্ট ওয়াচ ও ব্লুটুথ কলিং": "Smart Watch & Bluetooth Calling",
            "গ্রাহক সেবা": "Customer Service",
            "অর্ডার ট্র্যাকিং": "Order Tracking",
            "ক্যাশ অন ডেলিভারি চেকআউট": "Cash on Delivery Checkout",
            "রিটার্ন পলিসি: পণ্য চেক করে মূল্য পরিশোধ": "Return Policy: Inspect product before payment",
            "আমাদের অঙ্গীকার": "Our Guarantees",
            "১০০% ক্যাশ অন ডেলিভারি": "100% Cash on Delivery",
            "100% ক্যাশ অন ডেলিভারি": "100% Cash on Delivery",
            "সর্বস্বত্ব সংরক্ষিত।": "All rights reserved.",
            "হটলাইন:": "Hotline:",
            "ইমেইল:": "Email:",
            "ডেলিভারি: ঢাকা সিটিতে ৳": "Delivery: Inside Dhaka ৳",
            "ঢাকার বাইরে ৳": "Outside Dhaka ৳",

            // Cart Drawer
            "শপিং ব্যাগ": "Shopping Bag",
            "আপনার শপিং ব্যাগ বর্তমানে খালি রয়েছে।": "Your shopping bag is currently empty.",
            "শপিং শুরু করুন →": "Start Shopping →",
            "মোট সাবটোটাল:": "Subtotal:",
            "ডেলিভারি চার্জ চেকআউট পেজে এলাকা অনুযায়ী হিসাব করা হবে।": "Delivery charge calculated at checkout.",
            "অর্ডার সম্পন্ন করতে এগিয়ে যান (ক্যাশ অন ডেলিভারি)": "Proceed to Checkout (Cash on Delivery)",

            // Quick Order & Checkout
            "দ্রুত ক্যাশ অন ডেলিভারি অর্ডার": "Quick Cash on Delivery Order",
            "তথ্য পূরণ করুন, ডেলিভারি ম্যানের হাতে পণ্য পেয়ে টাকা দিন।": "Fill in details, pay cash upon delivery.",
            "আপনার নাম": "Your Name",
            "আপনার পূর্ণ নাম": "Your Full Name",
            "সম্পূর্ণ নাম লিখুন": "Enter full name",
            "মোবাইল নম্বর": "Mobile Number",
            "১১ ডিজিটের সঠিক মোবাইল নম্বর দিন।": "Provide an 11-digit valid mobile number.",
            "সম্পূর্ণ ঠিকানা": "Full Address",
            "ডেলিভারির সম্পূর্ণ ঠিকানা": "Full Delivery Address",
            "গ্রাম/রোড নম্বর, বাড়ি/ফ্ল্যাট নম্বর, থানা, জেলা": "Village/Road, House/Flat No, Thana, District",
            "গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা উল্লেখ করুন": "Village/Road, House/Flat No, Thana and District",
            "ডেলিভারি এলাকা": "Delivery Area",
            "ডেলিভারি এলাকা নির্বাচন করুন": "Select Delivery Area",
            "ঢাকা সিটিতে": "Inside Dhaka",
            "ঢাকার বাইরে": "Outside Dhaka",
            "মোট প্রদেয় টাকা:": "Total Payable:",
            "অর্ডার নিশ্চিত করুন (Cash on Delivery)": "Confirm Order (Cash on Delivery)",
            "অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:": "Please correct the following errors:",
            "ডেলিভারি ও কাস্টমার তথ্য": "Delivery & Customer Information",
            "অর্ডার নিশ্চিত করতে এই নম্বরে এসএমএস বা ফোন করা হতে পারে।": "We may call or SMS this number to confirm your order.",
            "ডেলিভারি চার্জ:": "Delivery Charge:",
            "সর্বমোট:": "Total:",

            // Tracking Page
            "আপনার অর্ডার ট্র্যাক করুন": "Track Your Order",
            "অর্ডারের বর্তমান অবস্থা জানতে আপনার মোবাইল নম্বর অথবা অর্ডার কোড লিখুন।": "Enter your mobile number or order code to check current status.",
            "খুঁজুন": "Search",
            "অর্ডার করার সময় যে মোবাইল নম্বর দিয়েছিলেন সেটি ব্যবহার করুন।": "Use the phone number provided during checkout.",
            "কোনো অর্ডার পাওয়া যায়নি": "No orders found",
            "দিয়ে কোনো অর্ডার খুঁজে পাওয়া যায়নি। অনুগ্রহ করে সঠিক মোবাইল নম্বর বা অর্ডার কোড নিশ্চিত করুন।": "could not be found. Please ensure correct mobile number or order code.",
            "হেল্পলাইনে কল দিয়ে জানুন:": "Call Helpline to enquire:",
            "পাওয়া গেছে": "Found",
            "টি অর্ডার": " orders",
            "অর্ডার কোড:": "Order Code:",
            "অর্ডারের তারিখ:": "Order Date:",
            "স্ট্যাটাস:": "Status:",
            "পেন্ডিং": "Pending",
            "নিশ্চিত": "Confirmed",
            "প্রসেসিং": "Processing",
            "কুরিয়ারে হস্তান্তরিত": "Handed to Courier",
            "ডেলিভার্ড": "Delivered",
            "বাতিল": "Cancelled",
            "রিটার্নড": "Returned",
            "কাস্টমার নাম:": "Customer Name:",
            "ফোন নম্বর:": "Phone Number:",
            "ডেলিভারি ঠিকানা:": "Delivery Address:",
            "অর্ডার আইটেম:": "Order Items:",
            "পরিমাণ:": "Quantity:",
            "কুরিয়ার ট্র্যাকিং:": "Courier Tracking:",
            "কুরিয়ার স্ট্যাটাস:": "Courier Status:",
            "ট্র্যাকিং আইডি:": "Tracking ID:",
            "কনসাইনমেন্ট আইডি:": "Consignment ID:",

            // Auth & Account
            "Sign In": "লগইন",
            "Register": "রেজিস্ট্রেশন",
            "Create Account": "অ্যাকাউন্ট তৈরি করুন",
            "My Orders": "আমার অর্ডারসমূহ",
            "My Cart": "আমার কার্ট",
            "Logout": "লগআউট",
            "Admin Dashboard": "এডমিন ড্যাশবোর্ড",
            "Track Order": "অর্ডার ট্র্যাক করুন",
            "Email or Phone Number": "ইমেইল বা ফোন নম্বর",
            "Password": "পাসওয়ার্ড",
            "Remember Me": "আমাকে মনে রাখুন",
        };

        const placeholderMap = {
            "মধু, ঘি, কিচেন চপার, ট্রিমার বা পণ্য খুঁজুন...": "Search honey, ghee, chopper, trimmer or products...",
            "মধু, চপার বা গ্যাজেট খুঁজুন...": "Search honey, chopper or gadgets...",
            "সম্পূর্ণ নাম লিখুন": "Enter full name",
            "যেমন: 017XXXXXXXX": "e.g. 017XXXXXXXX",
            "গ্রাম/রোড নম্বর, বাড়ি/ফ্ল্যাট নম্বর, থানা, জেলা": "Village/Road, House/Flat No, Thana, District",
            "গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা উল্লেখ করুন": "Village/Road, House/Flat No, Thana and District",
            "017XXXXXXXX অথবা DH-260917-XXXX": "017XXXXXXXX or DH-260917-XXXX",
            "আপনার ইমেইল বা ফোন নম্বর দিন": "Enter your email or phone number",
            "আপনার পাসওয়ার্ড দিন": "Enter your password",
            "উদাঃ মোঃ রহিম ইসলাম": "e.g. John Doe",
            "উদাঃ 017XXXXXXXX": "e.g. 017XXXXXXXX"
        };

        // Sort keys by length descending to replace compound phrases first
        const sortedPhraseKeys = Object.keys(phraseTranslations).sort((a, b) => b.length - a.length);

        const bnDigits = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        const enDigits = ['0','1','2','3','4','5','6','7','8','9'];

        function toEnDigits(str) {
            return str.replace(/[০-৯]/g, d => enDigits[bnDigits.indexOf(d)]);
        }

        // TreeWalker DOM text translator
        function translateDomTextNodes(root = document.body, lang = 'en') {
            const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null, false);
            let node;
            while ((node = walker.nextNode())) {
                const parent = node.parentElement;
                if (!parent || ['SCRIPT', 'STYLE', 'CODE', 'PRE'].includes(parent.tagName)) continue;

                if (lang === 'en') {
                    if (node._originalBnText === undefined) {
                        node._originalBnText = node.nodeValue;
                    }
                    const text = node.nodeValue;
                    if (!text || !text.trim()) continue;

                    const trimmed = text.trim();
                    if (phraseTranslations[trimmed]) {
                        node.nodeValue = text.replace(trimmed, phraseTranslations[trimmed]);
                        continue;
                    }

                    // Check normalized whitespace match
                    const normalized = trimmed.replace(/\s+/g, ' ');
                    if (phraseTranslations[normalized]) {
                        node.nodeValue = text.replace(trimmed, phraseTranslations[normalized]);
                        continue;
                    }

                    // Subphrase matches (longest keys first)
                    let updated = text;
                    let matched = false;
                    for (let i = 0; i < sortedPhraseKeys.length; i++) {
                        const bnKey = sortedPhraseKeys[i];
                        if (updated.includes(bnKey)) {
                            updated = updated.split(bnKey).join(phraseTranslations[bnKey]);
                            matched = true;
                        }
                    }

                    if (matched) {
                        node.nodeValue = toEnDigits(updated);
                    }
                } else {
                    // Restore original Bengali
                    if (node._originalBnText !== undefined) {
                        node.nodeValue = node._originalBnText;
                    }
                }
            }
        }

        let currentLang = localStorage.getItem('demandhat_lang') || 'en';

        function applyLanguage(lang) {
            currentLang = lang;
            localStorage.setItem('demandhat_lang', lang);
            const data = i18nDictionary[lang] || i18nDictionary['bn'];

            // 1. Update Header Buttons (Desktop & Mobile)
            const flagEl = document.getElementById('headerLangFlag');
            const textEl = document.getElementById('headerLangText');
            const flagMobileEl = document.getElementById('headerLangFlagMobile');
            if (flagEl) flagEl.textContent = data.flag;
            if (textEl) textEl.textContent = data.text;
            if (flagMobileEl) flagMobileEl.textContent = data.flag;

            // 2. Update data-i18n elements
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (data[key]) {
                    el.textContent = data[key];
                }
            });

            // 3. Update input & textarea placeholders
            document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(el => {
                if (lang === 'en') {
                    if (!el.dataset.origPlaceholder) el.dataset.origPlaceholder = el.placeholder;
                    const orig = el.dataset.origPlaceholder.trim();
                    if (placeholderMap[orig]) {
                        el.placeholder = placeholderMap[orig];
                    } else if (phraseTranslations[orig]) {
                        el.placeholder = phraseTranslations[orig];
                    }
                } else {
                    if (el.dataset.origPlaceholder) {
                        el.placeholder = el.dataset.origPlaceholder;
                    }
                }
            });

            // 4. Update select dropdown options
            document.querySelectorAll('select option').forEach(opt => {
                if (lang === 'en') {
                    if (!opt.dataset.origText) opt.dataset.origText = opt.text;
                    const trimmed = opt.dataset.origText.trim();
                    if (phraseTranslations[trimmed]) {
                        opt.text = phraseTranslations[trimmed];
                    }
                } else {
                    if (opt.dataset.origText) {
                        opt.text = opt.dataset.origText;
                    }
                }
            });

            // 5. Update all text nodes on the page
            translateDomTextNodes(document.body, lang);
        }

        function toggleLanguage() {
            const nextLang = currentLang === 'bn' ? 'en' : 'bn';
            applyLanguage(nextLang);
        }

        window.setLanguage = applyLanguage;
        window.toggleLanguage = toggleLanguage;

        // MutationObserver to translate dynamically added content when in English mode
        const langMutationObserver = new MutationObserver(mutations => {
            if (currentLang === 'en') {
                mutations.forEach(m => {
                    m.addedNodes.forEach(node => {
                        if (node.nodeType === Node.ELEMENT_NODE) {
                            translateDomTextNodes(node, 'en');
                        }
                    });
                });
            }
        });

        // Run on DOM load if saved language is English
        document.addEventListener('DOMContentLoaded', () => {
            langMutationObserver.observe(document.body, { childList: true, subtree: true });
            if (currentLang === 'en') {
                applyLanguage('en');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
