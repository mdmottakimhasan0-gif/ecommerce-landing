@extends('layouts.app')

@section('title', ($settings['store_name'] ?? 'DemandHat BD') . ' - সেরা অনলাইন শপিং')

@section('content')
<div class="space-y-12 sm:space-y-16 pb-16">

    <!-- Hero Promotional Banner Section -->
    @php
        $defaultBanners = \App\Http\Controllers\Admin\BannerController::getDefaultBanners();
        $storedBannersRaw = $settings['home_banners'] ?? null;
        $homeBanners = $defaultBanners;
        if (!empty($storedBannersRaw)) {
            $decodedBanners = json_decode($storedBannersRaw, true);
            if (is_array($decodedBanners)) {
                $homeBanners['banner1'] = array_merge($defaultBanners['banner1'], $decodedBanners['banner1'] ?? []);
                $homeBanners['banner2'] = array_merge($defaultBanners['banner2'], $decodedBanners['banner2'] ?? []);
                $homeBanners['banner3'] = array_merge($defaultBanners['banner3'], $decodedBanners['banner3'] ?? []);
            }
        }
        $b1 = $homeBanners['banner1'];
        $b2 = $homeBanners['banner2'];
        $b3 = $homeBanners['banner3'];
    @endphp

    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 pt-4 sm:pt-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
            <!-- Main Hero Carousel / Banner 1 (Left 2/3) -->
            @php
                if (isset($decodedBanners['banner1']) && !isset($decodedBanners['banner1']['slides'])) {
                    $b1Slides = [$b1];
                } else {
                    $b1Slides = $b1['slides'] ?? [$b1];
                }
                $hasMultipleSlides = count($b1Slides) > 1;
            @endphp
            @if(!empty($b1['is_active']))
            <div id="heroBannerCarousel" class="lg:col-span-2 relative rounded-2xl overflow-hidden shadow-lg border border-slate-200/80 bg-slate-900 min-h-[260px] sm:min-h-[360px] lg:min-h-[420px] flex items-center group select-none">
                <!-- Slides Track -->
                <div class="absolute inset-0 w-full h-full overflow-hidden" id="heroSlidesTrack">
                    @foreach($b1Slides as $sIndex => $slide)
                        @php
                            $slideHasImg = !empty($slide['image']);
                            $slideShowTxt = !empty($slide['show_text']) || (!$slideHasImg && !empty($slide['title']));
                        @endphp
                        <div class="hero-slide absolute inset-0 w-full h-full transition-all duration-700 ease-in-out {{ $sIndex === 0 ? 'opacity-100 scale-100 z-10' : 'opacity-0 scale-95 pointer-events-none z-0' }}" data-slide-idx="{{ $sIndex }}">
                            @if($slideHasImg)
                                <!-- Full Slide Image -->
                                <a href="{{ $slide['btn1_link'] ?? route('products.index') }}" class="absolute inset-0 w-full h-full block z-0" title="{{ $slide['title'] ?? 'Banner' }}">
                                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] ?? 'Banner' }}" class="w-full h-full object-cover object-center group-hover:scale-[1.01] transition-transform duration-700">
                                </a>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-r {{ $slide['bg_gradient'] ?? 'from-emerald-950 via-teal-900 to-slate-950' }}"></div>
                            @endif

                            @if($slideShowTxt)
                            <div class="relative z-10 max-w-xl p-6 sm:p-10 space-y-4 {{ $slideHasImg ? 'bg-slate-950/40 backdrop-blur-[2px] rounded-2xl m-4 sm:m-6 border border-white/10' : '' }}">
                                @if(!empty($slide['badge']))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/30 text-emerald-300 border border-emerald-400/30 text-xs font-bold uppercase tracking-wider">
                                    {{ $slide['badge'] }}
                                </span>
                                @endif

                                @if(!empty($slide['title']))
                                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-white drop-shadow-md">
                                    {{ $slide['title'] }}
                                </h2>
                                @endif

                                @if(!empty($slide['subtitle']))
                                <p class="text-xs sm:text-sm text-slate-200 leading-relaxed max-w-md drop-shadow">
                                    {{ $slide['subtitle'] }}
                                </p>
                                @endif

                                <div class="pt-2 flex flex-wrap items-center gap-3">
                                    @if(!empty($slide['btn1_text']))
                                    <a href="{{ $slide['btn1_link'] ?? route('products.index') }}" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all">
                                        {{ $slide['btn1_text'] }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($hasMultipleSlides)
                <!-- Controls: Prev / Next Arrows -->
                <button type="button" id="heroPrevBtn" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/75 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-xs border border-white/20 cursor-pointer shadow-lg" title="আগের স্লাইড">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" id="heroNextBtn" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/40 hover:bg-black/75 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-xs border border-white/20 cursor-pointer shadow-lg" title="পরের স্লাইড">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Dots Pagination Indicator -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 bg-black/40 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/10" id="heroDotsContainer">
                    @foreach($b1Slides as $dotIdx => $s)
                    <button type="button" class="hero-dot w-2.5 h-2.5 rounded-full transition-all cursor-pointer {{ $dotIdx === 0 ? 'bg-emerald-400 w-6' : 'bg-white/50 hover:bg-white' }}" data-dot-idx="{{ $dotIdx }}" title="Slide {{ $dotIdx + 1 }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            <!-- Side Promotional Promo Cards (Right 1/3) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4 lg:gap-6">
                <!-- Promo Banner 2: Kitchen Tools / Top -->
                @php
                    $b2HasImage = !empty($b2['image']);
                    $b2ShowText = !empty($b2['show_text']) || (!$b2HasImage && !empty($b2['title']));
                @endphp
                @if(!empty($b2['is_active']))
                <div class="relative rounded-2xl overflow-hidden shadow-md border border-slate-200/80 bg-slate-900 min-h-[160px] sm:min-h-[195px] flex flex-col justify-between group">
                    @if($b2HasImage)
                        <!-- Full Banner 2 Image -->
                        <a href="{{ $b2['link_url'] ?? route('products.index') }}" class="absolute inset-0 w-full h-full block z-0" title="{{ $b2['title'] ?? 'Banner 2' }}">
                            <img src="{{ $b2['image'] }}" alt="{{ $b2['title'] ?? 'Banner 2' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br {{ $b2['bg_gradient'] ?? 'from-amber-700 to-orange-900' }}"></div>
                    @endif

                    @if($b2ShowText)
                    <div class="relative z-10 p-6 flex flex-col justify-between h-full {{ $b2HasImage ? 'bg-slate-950/40 backdrop-blur-[2px]' : '' }}">
                        <div>
                            @if(!empty($b2['badge']))
                            <span class="text-[10px] font-bold tracking-wider uppercase px-2 py-0.5 rounded bg-black/40 text-amber-200" data-i18n="b2_badge">{{ $b2['badge'] }}</span>
                            @endif
                            @if(!empty($b2['title']))
                            <h3 class="text-base sm:text-lg font-black mt-1 leading-snug text-white drop-shadow" data-i18n="b2_title">{{ $b2['title'] }}</h3>
                            @endif
                            @if(!empty($b2['subtitle']))
                            <p class="text-xs text-amber-100/90 mt-1 drop-shadow" data-i18n="b2_subtitle">{{ $b2['subtitle'] }}</p>
                            @endif
                        </div>
                        <div class="pt-2">
                            <a href="{{ $b2['link_url'] ?? route('products.index', ['category' => 'home-kitchen']) }}" class="text-xs font-bold text-white hover:text-amber-200 flex items-center gap-1 group-hover:translate-x-1 transition-transform drop-shadow">
                                <span data-i18n="b2_link">{{ $b2['link_text'] ?? 'অর্ডার করুন এখনই →' }}</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Promo Banner 3: Electronics Gadgets / Bottom -->
                @php
                    $b3HasImage = !empty($b3['image']);
                    $b3ShowText = !empty($b3['show_text']) || (!$b3HasImage && !empty($b3['title']));
                @endphp
                @if(!empty($b3['is_active']))
                <div class="relative rounded-2xl overflow-hidden shadow-md border border-slate-200/80 bg-slate-900 min-h-[160px] sm:min-h-[195px] flex flex-col justify-between group">
                    @if($b3HasImage)
                        <!-- Full Banner 3 Image -->
                        <a href="{{ $b3['link_url'] ?? route('products.index') }}" class="absolute inset-0 w-full h-full block z-0" title="{{ $b3['title'] ?? 'Banner 3' }}">
                            <img src="{{ $b3['image'] }}" alt="{{ $b3['title'] ?? 'Banner 3' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </a>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br {{ $b3['bg_gradient'] ?? 'from-blue-900 to-indigo-950' }}"></div>
                    @endif

                    @if($b3ShowText)
                    <div class="relative z-10 p-6 flex flex-col justify-between h-full {{ $b3HasImage ? 'bg-slate-950/40 backdrop-blur-[2px]' : '' }}">
                        <div>
                            @if(!empty($b3['badge']))
                            <span class="text-[10px] font-bold tracking-wider uppercase px-2 py-0.5 rounded bg-black/40 text-blue-200" data-i18n="b3_badge">{{ $b3['badge'] }}</span>
                            @endif
                            @if(!empty($b3['title']))
                            <h3 class="text-base sm:text-lg font-black mt-1 leading-snug text-white drop-shadow" data-i18n="b3_title">{{ $b3['title'] }}</h3>
                            @endif
                            @if(!empty($b3['subtitle']))
                            <p class="text-xs text-blue-100/90 mt-1 drop-shadow" data-i18n="b3_subtitle">{{ $b3['subtitle'] }}</p>
                            @endif
                        </div>
                        <div class="pt-2">
                            <a href="{{ $b3['link_url'] ?? route('products.index', ['category' => 'electronics-gadgets']) }}" class="text-xs font-bold text-white hover:text-blue-200 flex items-center gap-1 group-hover:translate-x-1 transition-transform drop-shadow">
                                <span data-i18n="b3_link">{{ $b3['link_text'] ?? 'অফার দেখুন →' }}</span>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Trust Features Bar -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80">
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl flex-shrink-0">
                    💵
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900" data-i18n="cod_feature">ক্যাশ অন ডেলিভারি</h4>
                    <p class="text-[11px] text-slate-500" data-i18n="cod_desc">পণ্য হাতে পেয়ে টাকা পরিশোধ</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl flex-shrink-0">
                    🚚
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900" data-i18n="fast_delivery_feature">দ্রুততম ডেলিভারি</h4>
                    <p class="text-[11px] text-slate-500" data-i18n="fast_delivery_desc">২৪-৪৮ ঘণ্টার হোম ডেলিভারি</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl flex-shrink-0">
                    🌿
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900" data-i18n="pure_feature">১০০% খাঁটি পণ্য</h4>
                    <p class="text-[11px] text-slate-500" data-i18n="pure_desc">ল্যাব টেস্টে বিশুদ্ধ প্রমাণিত</p>
                </div>
            </div>
            <div class="flex items-center gap-3 p-2">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-xl flex-shrink-0">
                    🔄
                </div>
                <div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900" data-i18n="return_feature">৭ দিনের রিটার্ন</h4>
                    <p class="text-[11px] text-slate-500" data-i18n="return_desc">সমস্যা হলে নিশ্চিত রিপ্লেসমেন্ট</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Showcase Carousel -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                    <span>🗂️</span> <span data-i18n="special_categories">আমাদের স্পেশাল ক্যাটাগরি</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5" data-i18n="special_categories_desc">আপনার প্রয়োজনীয় পণ্য সহজে খুঁজে নিন</p>
            </div>
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Carousel Nav Arrows -->
                <button type="button" id="catPrevBtn" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs cursor-pointer" title="পূর্ববর্তী">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" id="catNextBtn" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 flex items-center justify-center transition-colors shadow-2xs cursor-pointer" title="পরবর্তী">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <a href="{{ route('products.index') }}" class="ml-1 text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 cursor-pointer whitespace-nowrap" data-i18n="all_categories">
                    সব ক্যাটাগরি →
                </a>
            </div>
        </div>

        <!-- Carousel Container / Track -->
        <div class="relative group/carousel max-w-full overflow-hidden">
            <div id="categoryCarouselTrack" 
                 class="flex gap-4 sm:gap-6 overflow-x-auto scroll-smooth py-2 px-1 snap-x snap-mandatory no-scrollbar"
                 style="scrollbar-width: none; -ms-overflow-style: none;">
                @foreach($categories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" 
                   class="group relative bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex items-center gap-4 overflow-hidden snap-start flex-shrink-0 w-[270px] sm:w-[320px] md:w-[340px]">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                        <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate">
                            {{ $cat->name }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $cat->description }}</p>
                        <span class="inline-block mt-2 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">
                            {{ $cat->products_count }} টি পণ্য উপলব্ধ
                        </span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Flash Deals Section with Countdown Urgency Timer -->
    @if($flashDeals->isNotEmpty())
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-rose-600 via-rose-700 to-amber-700 rounded-3xl p-4 sm:p-8 text-white shadow-xl overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-rose-500/60">
                <div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-wider bg-black/20 px-3 py-1 rounded-full text-rose-200 mb-1">
                        ⚡ হট ডিসকাউন্ট অফার
                    </span>
                    <h2 class="text-xl sm:text-3xl font-black">আজকের মেগা ফ্ল্যাশ সেল (Flash Deals)</h2>
                    <p class="text-xs text-rose-100/90 mt-0.5">সীমিত সময়ের জন্য বিশাল মূল্যছাড়! স্টক ফুরিয়ে যাওয়ার আগেই অর্ডার করুন।</p>
                </div>

                <!-- Live Countdown Timer -->
                <div id="flashDealsCountdown" class="flex items-center gap-2 self-start md:self-auto bg-black/30 p-2 sm:p-3 rounded-2xl border border-white/20 backdrop-blur-sm">
                    <span class="text-xs font-bold text-rose-200 mr-1">অফার শেষ হতে:</span>
                    <div class="text-center">
                        <span id="cdHours" class="bg-white text-rose-700 font-black text-sm sm:text-base px-2 py-1 rounded-lg">11</span>
                        <span class="block text-[9px] uppercase tracking-wider text-rose-200 mt-0.5">ঘণ্টা</span>
                    </div>
                    <span class="font-bold">:</span>
                    <div class="text-center">
                        <span id="cdMinutes" class="bg-white text-rose-700 font-black text-sm sm:text-base px-2 py-1 rounded-lg">45</span>
                        <span class="block text-[9px] uppercase tracking-wider text-rose-200 mt-0.5">মিনিট</span>
                    </div>
                    <span class="font-bold">:</span>
                    <div class="text-center">
                        <span id="cdSeconds" class="bg-white text-rose-700 font-black text-sm sm:text-base px-2 py-1 rounded-lg">30</span>
                        <span class="block text-[9px] uppercase tracking-wider text-rose-200 mt-0.5">সেকেন্ড</span>
                    </div>
                </div>
            </div>

            <!-- Flash Deal Products Slider / Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-6">
                @foreach($flashDeals as $product)
                <div class="bg-white rounded-2xl p-4 text-slate-900 shadow-md hover:shadow-xl transition-all flex flex-col justify-between group">
                    <div class="relative rounded-xl overflow-hidden bg-slate-100 aspect-square mb-3">
                        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                            <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        @if($product->discount_percentage > 0)
                        <span class="absolute top-2 left-2 bg-rose-600 text-white font-black text-xs px-2 py-1 rounded-md shadow pointer-events-none">
                            -{{ $product->discount_percentage }}% ছাড়
                        </span>
                        @endif
                        <span class="absolute top-2 right-2 bg-amber-400 text-slate-950 font-bold text-[10px] px-2 py-0.5 rounded shadow pointer-events-none">
                            🔥 ফ্ল্যাশ সেল
                        </span>
                    </div>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-emerald-600 font-semibold uppercase tracking-wider">{{ $product->category->name }}</span>
                            <a href="{{ route('products.show', $product->slug) }}" class="block text-sm font-bold text-slate-900 hover:text-emerald-600 transition-colors line-clamp-2 mt-0.5 leading-snug">
                                {{ $product->name }}
                            </a>
                        </div>

                        <div class="mt-3 pt-3 border-t border-slate-100">
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-lg sm:text-xl font-black text-emerald-700">৳ {{ number_format($product->sale_price) }}</span>
                                @if($product->regular_price > $product->sale_price)
                                <span class="text-xs text-slate-400 line-through">৳ {{ number_format($product->regular_price) }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                                <button type="button" 
                                        class="btn-quick-buy w-full py-2 px-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-[11px] sm:text-xs font-bold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer truncate"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->sale_price }}"
                                        data-thumbnail="{{ $product->thumbnail }}">
                                    <span data-i18n="btn_order_now">⚡ অর্ডার করুন</span>
                                </button>
                                <button type="button" 
                                        class="btn-add-to-cart w-full py-2 px-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] sm:text-xs font-bold rounded-lg transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer truncate"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-slug="{{ $product->slug }}"
                                        data-price="{{ $product->sale_price }}"
                                        data-thumbnail="{{ $product->thumbnail }}">
                                    <span data-i18n="btn_add_to_cart">+ কার্টে নিন</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Featured Products Showcase -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg sm:text-2xl font-black text-slate-900 flex items-center gap-2">
                    <span>⭐</span> <span data-i18n="trending_title">ট্রেন্ডিং ও জনপ্রিয় পণ্যসমূহ</span>
                </h2>
                <p class="text-xs text-slate-500 mt-0.5" data-i18n="trending_desc">সবচেয়ে বেশি অর্ডার করা প্রিমিয়াম পণ্যসমূহ</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 cursor-pointer" data-i18n="view_all">
                সবগুলো দেখুন ({{ $allProducts->total() }}) →
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-2xl p-3 sm:p-4 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
                <div class="relative rounded-xl overflow-hidden bg-slate-100 aspect-square mb-2 sm:mb-3">
                    <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
                        <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </a>
                    @if($product->discount_percentage > 0)
                    <span class="absolute top-2 left-2 bg-rose-600 text-white font-black text-[10px] sm:text-xs px-2 py-0.5 rounded shadow pointer-events-none">
                        -{{ $product->discount_percentage }}%
                    </span>
                    @endif
                    @if($product->landingPages()->where('status', 'published')->exists())
                    <a href="{{ url('/' . $product->landingPages()->where('status', 'published')->first()->slug) }}" 
                       class="absolute bottom-2 left-2 bg-emerald-600/95 hover:bg-emerald-700 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md flex items-center gap-1 backdrop-blur-sm cursor-pointer z-10">
                        <span>🚀 স্পেশাল অফার পেজ</span>
                    </a>
                    @endif
                </div>

                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <span class="text-[10px] sm:text-xs text-emerald-600 font-semibold">{{ $product->category->name }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="block text-xs sm:text-sm font-bold text-slate-900 hover:text-emerald-600 transition-colors line-clamp-2 mt-0.5 leading-snug">
                            {{ $product->name }}
                        </a>
                    </div>

                    <div class="mt-2.5 pt-2.5 border-t border-slate-100">
                        <div class="flex items-baseline gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                            <span class="text-base sm:text-lg font-black text-emerald-700">৳ {{ number_format($product->sale_price) }}</span>
                            @if($product->regular_price > $product->sale_price)
                            <span class="text-[11px] sm:text-xs text-slate-400 line-through">৳ {{ number_format($product->regular_price) }}</span>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 sm:gap-2">
                            <button type="button" 
                                    class="btn-quick-buy w-full py-1.5 sm:py-2 px-1 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] sm:text-xs font-bold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer truncate"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->sale_price }}"
                                    data-thumbnail="{{ $product->thumbnail }}">
                                <span data-i18n="order_now">অর্ডার করুন</span>
                            </button>
                            <button type="button" 
                                    class="btn-add-to-cart w-full py-1.5 sm:py-2 px-1 bg-slate-100 hover:bg-slate-200 text-slate-800 text-[11px] sm:text-xs font-bold rounded-lg transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer truncate"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}"
                                    data-slug="{{ $product->slug }}"
                                    data-price="{{ $product->sale_price }}"
                                    data-thumbnail="{{ $product->thumbnail }}">
                                <span data-i18n="add_to_cart_short">+ কার্ট</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Customer Reviews & Social Proof -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">
            <div class="text-center max-w-xl mx-auto mb-8">
                <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider bg-emerald-50 px-3 py-1 rounded-full" data-i18n="reviews_badge">সম্মানিত গ্রাহকদের মতামত</span>
                <h2 class="text-xl sm:text-3xl font-black text-slate-900 mt-2" data-i18n="reviews_title">আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ</h2>
                <p class="text-xs text-slate-500 mt-1" data-i18n="reviews_desc">হাজারো পরিবারের আস্থার প্রতীক DemandHat BD</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Review 1 -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-slate-700 leading-relaxed">
                        "সুন্দরবনের চাকের মধুটা সত্যি অসাধারণ! গন্ধ এবং স্বাদেই বোঝা যায় খাঁটি জিনিস। ঢাকার ভেতর মাত্র ২৪ ঘণ্টায় ক্যাশ অন ডেলিভারিতে পেয়েছি।"
                    </p>
                    <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">ম</div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">মাহমুদুল হাসান</h4>
                            <span class="text-[10px] text-slate-400">উত্তরা, ঢাকা • ভেরিফায়েড বায়ার</span>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-slate-700 leading-relaxed">
                        "মাল্টিফাংশন চপারটি কেনার পর রান্নাঘরের পেঁয়াজ আর সবজি কাটা অনেক সহজ হয়ে গেছে। স্টিলের ব্লেডগুলো ভীষণ ধারালো। প্রোডাক্ট কোয়ালিটি নিয়ে কোনো সন্দেহ নেই।"
                    </p>
                    <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-teal-600 text-white font-bold text-xs flex items-center justify-center">র</div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">রোকেয়া আক্তার</h4>
                            <span class="text-[10px] text-slate-400">ধানমন্ডি, ঢাকা • ভেরিফায়েড বায়ার</span>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
                    <div class="flex items-center gap-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-xs text-slate-700 leading-relaxed">
                        "T9 মেটাল ট্রিমারটি দেখতে যেমন প্রিমিয়াম কাজও করে নিখুঁত। ব্যাটারি ব্যাকআপ দারুণ। সবচেয়ে ভালো লেগেছে ডেলিভারি ম্যানের সামনে চেক করে নেওয়ার সিস্টেম।"
                    </p>
                    <div class="flex items-center gap-3 pt-2 border-t border-slate-200">
                        <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">ত</div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">তানভীর আহমেদ</h4>
                            <span class="text-[10px] text-slate-400">চট্টগ্রাম সদর • ভেরিফায়েড বায়ার</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Hotline & Fast Order CTA Banner -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-emerald-800 via-slate-900 to-teal-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-emerald-700/50">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-xl sm:text-2xl font-black">যেকোনো প্রশ্ন বা ফোনে সরাসরি অর্ডার করতে চান?</h3>
                <p class="text-xs sm:text-sm text-slate-300">আমাদের কাস্টমার কেয়ার টিম সপ্তাহের ৭ দিনই আপনার সেবায় প্রস্তুত।</p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm rounded-xl shadow-lg flex items-center gap-2 hover:scale-105 transition-all">
                    <span>📞 কল করুন: {{ $settings['store_phone'] ?? '01712-345678' }}</span>
                </a>
                @if(!empty($settings['store_whatsapp']))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['store_whatsapp']) }}" target="_blank" class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-xl border border-white/20 flex items-center gap-2 transition-colors">
                    <span>💬 WhatsApp মেসেজ</span>
                </a>
                @endif
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const track = document.getElementById('categoryCarouselTrack');
        const prevBtn = document.getElementById('catPrevBtn');
        const nextBtn = document.getElementById('catNextBtn');
        
        if (track && prevBtn && nextBtn) {
            const scrollStep = 320;
            let autoScrollInterval = null;

            function slideNext() {
                if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 10) {
                    track.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: scrollStep, behavior: 'smooth' });
                }
            }

            function slidePrev() {
                if (track.scrollLeft <= 10) {
                    track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
                } else {
                    track.scrollBy({ left: -scrollStep, behavior: 'smooth' });
                }
            }

            nextBtn.addEventListener('click', () => {
                slideNext();
                resetAutoScroll();
            });

            prevBtn.addEventListener('click', () => {
                slidePrev();
                resetAutoScroll();
            });

            function startAutoScroll() {
                if (!autoScrollInterval) {
                    autoScrollInterval = setInterval(slideNext, 3500);
                }
            }

            function stopAutoScroll() {
                if (autoScrollInterval) {
                    clearInterval(autoScrollInterval);
                    autoScrollInterval = null;
                }
            }

            function resetAutoScroll() {
                stopAutoScroll();
                startAutoScroll();
            }

            // Pause on hover or touch
            track.addEventListener('mouseenter', stopAutoScroll);
            track.addEventListener('mouseleave', startAutoScroll);
            track.addEventListener('touchstart', stopAutoScroll, { passive: true });
            track.addEventListener('touchend', startAutoScroll);

            startAutoScroll();
        }

        // Hero Banner Multi-Slide Carousel Controller
        const heroCarousel = document.getElementById('heroBannerCarousel');
        if (heroCarousel) {
            const slides = heroCarousel.querySelectorAll('.hero-slide');
            const dots = heroCarousel.querySelectorAll('.hero-dot');
            const prevBtn = document.getElementById('heroPrevBtn');
            const nextBtn = document.getElementById('heroNextBtn');
            let currentIdx = 0;
            let timer = null;

            function showHeroSlide(index) {
                if (index < 0) index = slides.length - 1;
                if (index >= slides.length) index = 0;
                currentIdx = index;

                slides.forEach((s, idx) => {
                    if (idx === currentIdx) {
                        s.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                        s.classList.add('opacity-100', 'scale-100', 'z-10');
                    } else {
                        s.classList.remove('opacity-100', 'scale-100', 'z-10');
                        s.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                    }
                });

                dots.forEach((d, idx) => {
                    if (idx === currentIdx) {
                        d.className = 'hero-dot w-6 h-2.5 rounded-full bg-emerald-400 transition-all cursor-pointer';
                    } else {
                        d.className = 'hero-dot w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white transition-all cursor-pointer';
                    }
                });
            }

            function startTimer() {
                if (!timer && slides.length > 1) {
                    timer = setInterval(() => {
                        showHeroSlide(currentIdx + 1);
                    }, 5000);
                }
            }

            function stopTimer() {
                if (timer) {
                    clearInterval(timer);
                    timer = null;
                }
            }

            function resetTimer() {
                stopTimer();
                startTimer();
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showHeroSlide(currentIdx - 1);
                    resetTimer();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showHeroSlide(currentIdx + 1);
                    resetTimer();
                });
            }

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const idx = parseInt(dot.getAttribute('data-dot-idx'));
                    showHeroSlide(idx);
                    resetTimer();
                });
            });

            heroCarousel.addEventListener('mouseenter', stopTimer);
            heroCarousel.addEventListener('mouseleave', startTimer);
            heroCarousel.addEventListener('touchstart', stopTimer, { passive: true });
            heroCarousel.addEventListener('touchend', startTimer);

            startTimer();
        }
    });
</script>
@endpush
