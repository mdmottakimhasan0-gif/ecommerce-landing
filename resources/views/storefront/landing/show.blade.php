<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $landingPage->seo_title ?? $product->name . ' - বিশেষ অফার' }}</title>
    <meta name="description" content="{{ $landingPage->seo_description ?? $product->short_description }}">

    <meta property="og:title" content="{{ $landingPage->seo_title ?? $product->name }}">
    <meta property="og:description" content="{{ $landingPage->seo_description ?? $product->short_description }}">
    <meta property="og:image" content="{{ $landingPage->og_image ?? $product->thumbnail }}">
    <meta property="og:type" content="product">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Multi-Pixel Tracking Integration (Page-specific or Global) -->
    @php
        $fbPixel = $landingPage->fb_pixel_id ?: ($settings['fb_pixel_id'] ?? null);
        $ttPixel = $landingPage->tiktok_pixel_id ?: ($settings['tiktok_pixel_id'] ?? null);
        $gtmId = $landingPage->gtm_id ?: ($settings['gtm_id'] ?? null);
    @endphp

    @if(!empty($fbPixel))
    <!-- Facebook Pixel -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $fbPixel }}');
        fbq('track', 'PageView');
        fbq('track', 'ViewContent', {
            content_name: '{{ addslashes($product->name) }}',
            content_ids: ['{{ $product->id }}'],
            content_type: 'product',
            value: {{ $product->sale_price }},
            currency: 'BDT'
        });
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $fbPixel }}&ev=PageView&noscript=1"/></noscript>
    @endif

    @if(!empty($ttPixel))
    <!-- TikTok Pixel -->
    <script>
        !function (w, d, t) {
          w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,s=d.createElement("script"),s.type="text/javascript",s.async=!0,s.src=i+"?sdkid="+e+"&lib="+t;var a=d.getElementsByTagName("script")[0];a.parentNode.insertBefore(s,a)};
          ttq.load('{{ $ttPixel }}');
          ttq.page();
        }(window, document, 'ttq');
    </script>
    @endif

    @if(!empty($gtmId))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $gtmId }}');</script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        :root {
            --lp-bg: {{ $pageTheme['bg'] ?? '#0f172a' }};
            --lp-card: {{ $pageTheme['card'] ?? '#1e293b' }};
            --lp-primary: {{ $pageTheme['primary'] ?? '#10b981' }};
            --lp-text: {{ $pageTheme['text'] ?? '#f8fafc' }};
            --lp-muted: {{ $pageTheme['muted'] ?? '#94a3b8' }};
        }
        body.lp-themed {
            background-color: var(--lp-bg) !important;
            color: var(--lp-text) !important;
        }
        .lp-card {
            background-color: var(--lp-card) !important;
            color: var(--lp-text) !important;
            border-color: rgba(255, 255, 255, 0.12);
        }
        .lp-primary-btn {
            background-color: var(--lp-primary) !important;
            color: #ffffff !important;
        }
        .lp-primary-text {
            color: var(--lp-primary) !important;
        }
        .lp-primary-border {
            border-color: var(--lp-primary) !important;
        }
        .lp-muted-text {
            color: var(--lp-muted) !important;
        }
        .lp-badge {
            background-color: rgba(16, 185, 129, 0.15);
            color: var(--lp-primary) !important;
            border-color: var(--lp-primary) !important;
        }
    </style>

    @if(!empty($landingPage->custom_css))
    <style>
        {!! $landingPage->custom_css !!}
    </style>
    @endif
</head>
<body class="font-sans antialiased lp-themed min-h-screen selection:bg-emerald-500 selection:text-white pb-24 lg:pb-12">

    <!-- Top Urgency Announcement Header -->
    <div class="lp-primary-btn py-2.5 px-4 text-center text-xs sm:text-sm font-bold shadow-md">
        <div class="max-w-4xl mx-auto flex items-center justify-center gap-2">
            <span class="animate-ping w-2 h-2 rounded-full bg-amber-300"></span>
            <span>🔥 বিশেষ অফার! আর মাত্র <span class="text-amber-300 underline font-black">{{ $product->stock }} টি</span> স্টক বাকি আছে!</span>
        </div>
    </div>

    @php
        $hasOrderFormBlock = false;
        if (!empty($contentBlocks)) {
            foreach ($contentBlocks as $chk) {
                if (($chk['type'] ?? '') === 'order_form') {
                    $hasOrderFormBlock = true;
                    break;
                }
            }
        }
    @endphp

    <!-- Main Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 sm:py-10 space-y-8 sm:space-y-12">

        @if(!empty($contentBlocks) && count($contentBlocks) > 0)
            {{-- Dynamic Blocks Rendering --}}
            @foreach($contentBlocks as $b)
                @php $bType = $b['type'] ?? ''; @endphp

                @if($bType === 'product_hero')
                    <div class="lp-card rounded-3xl p-5 sm:p-8 border shadow-2xl space-y-6">
                        <div class="text-center space-y-3">
                            @if(!empty($b['badge']))
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs sm:text-sm font-bold lp-badge border">
                                <span>🌿</span> {{ $b['badge'] }}
                            </span>
                            @endif
                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight">
                                {{ $b['title'] ?? $product->name }}
                            </h1>
                            @if(!empty($b['shortDesc']))
                            <p class="text-xs sm:text-base lp-muted-text max-w-2xl mx-auto leading-relaxed">
                                {{ $b['shortDesc'] }}
                            </p>
                            @endif
                        </div>

                        <div class="relative rounded-2xl overflow-hidden aspect-video sm:aspect-[16/9] bg-black/40 border border-white/10 shadow-inner">
                            <img src="{{ $b['imageUrl'] ?? $product->thumbnail }}" alt="{{ $b['title'] ?? $product->name }}" class="w-full h-full object-cover">
                            @if(!empty($b['discountText']))
                            <div class="absolute top-4 left-4 bg-rose-600 text-white font-black text-xs sm:text-sm px-3.5 py-1.5 rounded-xl shadow-lg">
                                {{ $b['discountText'] }}
                            </div>
                            @elseif($product->discount_percentage > 0)
                            <div class="absolute top-4 left-4 bg-rose-600 text-white font-black text-xs sm:text-sm px-3.5 py-1.5 rounded-xl shadow-lg">
                                -{{ $product->discount_percentage }}% ছাড়
                            </div>
                            @endif
                            <div class="absolute bottom-4 right-4 bg-black/75 backdrop-blur-sm text-amber-400 text-xs font-bold px-3 py-1 rounded-lg border border-amber-400/30">
                                ✓ ১০০% আসল ও খাঁটি পণ্যের নিশ্চয়তা
                            </div>
                        </div>
                    </div>

                @elseif($bType === 'product_price')
                    <div class="lp-card p-5 sm:p-6 rounded-2xl border flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
                        <div class="text-center sm:text-left">
                            <span class="text-xs lp-muted-text block mb-1">অফার প্রাইজ (সীমিত সময়ের জন্য):</span>
                            <div class="flex items-baseline gap-3">
                                <span class="text-3xl sm:text-4xl font-black lp-primary-text">
                                    ৳ {{ number_format($b['salePrice'] ?? $product->sale_price) }}
                                </span>
                                @if(($b['regularPrice'] ?? $product->regular_price) > ($b['salePrice'] ?? $product->sale_price))
                                <span class="text-sm sm:text-base lp-muted-text line-through opacity-70">
                                    ৳ {{ number_format($b['regularPrice'] ?? $product->regular_price) }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <a href="#orderSection" class="w-full sm:w-auto px-8 py-4 lp-primary-btn font-black text-sm sm:text-base rounded-2xl shadow-xl transition-all text-center flex items-center justify-center gap-2 hover:opacity-90 active:scale-95">
                            <span>{{ $b['ctaText'] ?? 'এখনই অর্ডার করুন 🛒' }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                        </a>
                    </div>

                @elseif($bType === 'urgency')
                    <div class="bg-gradient-to-r from-rose-900/80 via-slate-900 to-rose-900/80 p-5 sm:p-6 rounded-3xl border border-rose-700/50 text-center space-y-3 shadow-xl">
                        <h3 class="text-sm sm:text-base font-black text-rose-300">
                            {{ $b['title'] ?? '⏰ বিশেষ অফারটি শেষ হতে বাকি আছে:' }}
                        </h3>
                        <div class="flex items-center justify-center gap-2 font-mono">
                            <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                                <span class="text-xl sm:text-2xl font-black text-white countdown-hours">{{ $b['hours'] ?? '04' }}</span>
                                <span class="block text-[9px] text-rose-300 mt-0.5">ঘণ্টা</span>
                            </div>
                            <span class="text-xl font-bold text-rose-400">:</span>
                            <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                                <span class="text-xl sm:text-2xl font-black text-white countdown-minutes">{{ $b['minutes'] ?? '28' }}</span>
                                <span class="block text-[9px] text-rose-300 mt-0.5">মিনিট</span>
                            </div>
                            <span class="text-xl font-bold text-rose-400">:</span>
                            <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                                <span class="text-xl sm:text-2xl font-black text-white countdown-seconds">{{ $b['seconds'] ?? '45' }}</span>
                                <span class="block text-[9px] text-rose-300 mt-0.5">সেকেন্ড</span>
                            </div>
                        </div>
                    </div>

                @elseif($bType === 'features')
                    <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-6 shadow-xl">
                        <div class="text-center">
                            <h3 class="text-lg sm:text-2xl font-black">{{ $b['title'] ?? 'কেন আমাদের কাছ থেকে কিনবেন?' }}</h3>
                            @if(!empty($b['subtitle']))
                            <p class="text-xs lp-muted-text mt-1">{{ $b['subtitle'] }}</p>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @foreach($b['items'] ?? [] as $feat)
                            <div class="bg-black/20 p-3.5 rounded-xl border border-white/10 flex items-center gap-3">
                                <span class="w-6 h-6 rounded-full lp-badge border flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                                <span class="text-xs sm:text-sm font-medium">{{ $feat }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                {{-- MULTIPLE IMAGE GALLERY GRID --}}
                @elseif($bType === 'gallery')
                    <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-6 shadow-xl">
                        <div class="text-center">
                            <h3 class="text-lg sm:text-2xl font-black">{{ $b['title'] ?? 'আমাদের প্রডাক্ট গ্যালারি' }}</h3>
                            @if(!empty($b['subtitle']))
                            <p class="text-xs lp-muted-text mt-1">{{ $b['subtitle'] }}</p>
                            @endif
                        </div>

                        @php
                            $cols = (int)($b['columns'] ?? 3);
                            $colClass = $cols === 2 ? 'grid-cols-1 sm:grid-cols-2' : ($cols === 4 ? 'grid-cols-2 sm:grid-cols-4' : 'grid-cols-2 sm:grid-cols-3');
                        @endphp
                        <div class="grid {{ $colClass }} gap-3 sm:gap-4">
                            @foreach($b['images'] ?? [] as $imgItem)
                                @php
                                    $imgUrl = is_array($imgItem) ? ($imgItem['url'] ?? '') : $imgItem;
                                    $caption = is_array($imgItem) ? ($imgItem['caption'] ?? '') : '';
                                @endphp
                                @if(!empty($imgUrl))
                                <div class="group relative rounded-2xl overflow-hidden border border-white/10 bg-black/40 aspect-square cursor-pointer hover:border-emerald-400 transition-all shadow-md"
                                     onclick="openStorefrontLightbox('{{ $imgUrl }}', '{{ addslashes($caption) }}')">
                                    <img src="{{ $imgUrl }}" alt="{{ $caption }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if(!empty($caption))
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent p-2.5 text-center">
                                        <span class="text-[11px] sm:text-xs font-semibold text-white drop-shadow">{{ $caption }}</span>
                                    </div>
                                    @endif
                                    <div class="absolute top-2 right-2 w-7 h-7 rounded-full bg-black/60 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                {{-- CAROUSEL / SLIDER WIDGET --}}
                @elseif($bType === 'carousel')
                    <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-6 shadow-xl storefront-carousel-container" 
                         id="carousel-{{ $b['id'] ?? 'c1' }}"
                         data-autoplay="{{ !empty($b['autoplay']) ? 'true' : 'false' }}"
                         data-interval="{{ $b['interval'] ?? 4 }}">
                        <div class="text-center">
                            <h3 class="text-lg sm:text-2xl font-black">{{ $b['title'] ?? 'এক্সক্লুসিভ ফটো ও হাইলাইটস' }}</h3>
                            @if(!empty($b['subtitle']))
                            <p class="text-xs lp-muted-text mt-1">{{ $b['subtitle'] }}</p>
                            @endif
                        </div>

                        @php
                            $aspectRatio = $b['aspectRatio'] ?? '16/9';
                            $aspectClass = $aspectRatio === '1/1' ? 'aspect-square' : ($aspectRatio === '4/3' ? 'aspect-[4/3]' : 'aspect-video sm:aspect-[16/9]');
                            $slides = $b['slides'] ?? [];
                        @endphp

                        <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-black/60 shadow-lg storefront-carousel {{ $aspectClass }}" data-active-index="0">
                            <div class="carousel-track w-full h-full relative">
                                @foreach($slides as $idx => $slide)
                                <div class="carousel-slide absolute inset-0 transition-opacity duration-700 {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}" data-slide-index="{{ $idx }}">
                                    <img src="{{ $slide['image'] ?? '' }}" alt="{{ $slide['title'] ?? '' }}" class="w-full h-full object-cover">
                                    @if(!empty($slide['title']) || !empty($slide['subtitle']))
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent p-5 sm:p-6 text-white text-center sm:text-left">
                                        @if(!empty($slide['title']))
                                        <h4 class="text-base sm:text-xl font-black drop-shadow">{{ $slide['title'] }}</h4>
                                        @endif
                                        @if(!empty($slide['subtitle']))
                                        <p class="text-xs sm:text-sm text-slate-200 mt-1 drop-shadow">{{ $slide['subtitle'] }}</p>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>

                            @if(count($slides) > 1)
                            <button type="button" class="carousel-prev absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center transition-all shadow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button type="button" class="carousel-next absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center transition-all shadow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>

                            <div class="carousel-dots absolute bottom-3 inset-x-0 z-20 flex items-center justify-center gap-2">
                                @foreach($slides as $idx => $slide)
                                <button type="button" class="carousel-dot w-2.5 h-2.5 rounded-full transition-all {{ $idx === 0 ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80' }}" data-dot-index="{{ $idx }}"></button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                {{-- CUSTOMER REVIEWS WITH AVATARS & PHOTO PROOFS --}}
                @elseif($bType === 'reviews')
                    <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-6 shadow-xl">
                        <div class="text-center space-y-1">
                            <h3 class="text-lg sm:text-2xl font-black">{{ $b['title'] ?? 'গ্রাহকদের মতামত ও বাস্তব অভিজ্ঞতা' }}</h3>
                            @if(!empty($b['subtitle']))
                            <p class="text-xs lp-muted-text">{{ $b['subtitle'] }}</p>
                            @endif
                            @if(!empty($b['ratingSummary']))
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400/15 text-amber-400 border border-amber-400/30 text-xs font-bold mt-2">
                                <span>⭐</span> {{ $b['ratingSummary'] }}
                            </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($b['items'] ?? [] as $rev)
                            <div class="bg-black/20 p-4 sm:p-5 rounded-2xl border border-white/10 space-y-3 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2.5">
                                            @if(!empty($rev['avatar']))
                                            <img src="{{ $rev['avatar'] }}" alt="{{ $rev['name'] ?? '' }}" class="w-10 h-10 rounded-full object-cover border border-white/20">
                                            @else
                                            <div class="w-10 h-10 rounded-full lp-badge border flex items-center justify-center font-black text-sm">
                                                {{ mb_substr($rev['name'] ?? 'গ্রা', 0, 1) }}
                                            </div>
                                            @endif
                                            <div>
                                                <h4 class="text-xs sm:text-sm font-bold">{{ $rev['name'] ?? 'সম্মানিত গ্রাহক' }}</h4>
                                                <span class="text-[10px] lp-muted-text block">{{ $rev['location'] ?? 'ঢাকা' }} • {{ $rev['date'] ?? 'সম্প্রতি' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-amber-400 text-xs">
                                            @for($s = 1; $s <= 5; $s++)
                                                <span>{{ $s <= ($rev['rating'] ?? 5) ? '★' : '☆' }}</span>
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-xs sm:text-sm leading-relaxed lp-muted-text">
                                        "{{ $rev['comment'] ?? '' }}"
                                    </p>
                                </div>

                                @if(!empty($rev['photoProof']))
                                <div class="pt-3 border-t border-white/10">
                                    <span class="text-[10px] lp-muted-text block mb-1.5 font-semibold">📸 গ্রাহকের পাঠানো ছবি:</span>
                                    <div class="w-24 h-24 rounded-xl overflow-hidden border border-white/20 bg-black/40 cursor-pointer hover:opacity-90"
                                         onclick="openStorefrontLightbox('{{ $rev['photoProof'] }}', '{{ addslashes($rev['name'] ?? 'গ্রাহকের রিভিউ ছবি') }}')">
                                        <img src="{{ $rev['photoProof'] }}" alt="Review proof" class="w-full h-full object-cover">
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($bType === 'guarantees')
                    <div class="lp-card rounded-3xl p-5 sm:p-6 border shadow-xl">
                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="p-2">
                                <span class="text-2xl block mb-1">🛡️</span>
                                <span class="font-bold block text-[11px] sm:text-xs">ক্যাশ অন ডেলিভারি</span>
                            </div>
                            <div class="p-2">
                                <span class="text-2xl block mb-1">🚚</span>
                                <span class="font-bold block text-[11px] sm:text-xs">দ্রুততম হোম ডেলিভারি</span>
                            </div>
                            <div class="p-2">
                                <span class="text-2xl block mb-1">💯</span>
                                <span class="font-bold block text-[11px] sm:text-xs">খাঁটি না হলে ফেরত</span>
                            </div>
                        </div>
                    </div>

                @elseif($bType === 'heading')
                    <div class="text-{{ $b['align'] ?? 'center' }} my-4">
                        <{{ $b['tag'] ?? 'h2' }} class="text-2xl sm:text-3xl font-black">
                            {{ $b['text'] ?? '' }}
                        </{{ $b['tag'] ?? 'h2' }}>
                    </div>

                @elseif($bType === 'text')
                    <div class="prose max-w-none text-xs sm:text-base leading-relaxed lp-muted-text">
                        {!! nl2br(e($b['content'] ?? '')) !!}
                    </div>

                @elseif($bType === 'image')
                    @if(!empty($b['url']))
                    <div class="rounded-2xl overflow-hidden border border-white/10 shadow-lg cursor-pointer" onclick="openStorefrontLightbox('{{ $b['url'] }}', '{{ addslashes($b['caption'] ?? '') }}')">
                        <img src="{{ $b['url'] }}" alt="{{ $b['caption'] ?? '' }}" class="w-full h-auto object-cover">
                        @if(!empty($b['caption']))
                        <p class="text-xs text-center lp-muted-text p-2 bg-black/40">{{ $b['caption'] }}</p>
                        @endif
                    </div>
                    @endif

                @elseif($bType === 'video')
                    @if(!empty($b['embedUrl']))
                    <div class="aspect-video rounded-2xl overflow-hidden border border-white/10 shadow-lg">
                        <iframe src="{{ $b['embedUrl'] }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                    </div>
                    @endif

                @elseif($bType === 'button')
                    <div class="text-center my-4">
                        <a href="{{ $b['url'] ?? '#orderSection' }}" class="inline-flex items-center justify-center px-8 py-4 lp-primary-btn font-black text-sm sm:text-base rounded-2xl shadow-xl hover:opacity-90 active:scale-95 transition-all">
                            {{ $b['text'] ?? 'অর্ডার করুন' }}
                        </a>
                    </div>

                @elseif($bType === 'divider')
                    <hr class="border-t border-white/10 my-6">

                @elseif($bType === 'faq')
                    <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-4 shadow-xl">
                        <h3 class="text-lg sm:text-2xl font-black text-center">{{ $b['title'] ?? 'সাধারণ জিজ্ঞাসা (FAQ)' }}</h3>
                        <div class="space-y-3">
                            @foreach($b['items'] ?? [] as $faq)
                            <div class="bg-black/20 p-4 rounded-xl border border-white/10">
                                <h4 class="text-xs sm:text-sm font-bold mb-1">❓ {{ $faq['q'] ?? '' }}</h4>
                                <p class="text-xs lp-muted-text">{{ $faq['a'] ?? '' }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                @elseif($bType === 'order_form')
                    @include('storefront.landing._order_form_block', ['block' => $b])
                @endif
            @endforeach

            {{-- If order form was not explicitly added as a block, render it at the bottom --}}
            @if(!$hasOrderFormBlock)
                @include('storefront.landing._order_form_block', ['block' => []])
            @endif

        @else
            {{-- Default Classic Layout Fallback (when no blocks saved) --}}
            <!-- Brand / Offer Header -->
            <div class="text-center space-y-3">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full lp-badge border text-xs sm:text-sm font-bold">
                    <span>🌿</span> {{ $product->category->name }} • স্পেশাল অফার
                </span>
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight">
                    {{ $product->name }}
                </h1>
                <p class="text-xs sm:text-base lp-muted-text max-w-2xl mx-auto leading-relaxed">
                    {{ $product->short_description }}
                </p>
            </div>

            <!-- Product Hero Image & Pricing Highlight Card -->
            <div class="lp-card rounded-3xl p-5 sm:p-8 border shadow-2xl space-y-6">
                <div class="relative rounded-2xl overflow-hidden aspect-video sm:aspect-[16/9] bg-black/40 border border-white/10">
                    <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @if($product->discount_percentage > 0)
                    <div class="absolute top-4 left-4 bg-rose-600 text-white font-black text-xs sm:text-sm px-3.5 py-1.5 rounded-xl shadow-lg">
                        -{{ $product->discount_percentage }}% ছাড়
                    </div>
                    @endif
                    <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur-sm text-amber-400 text-xs font-bold px-3 py-1 rounded-lg border border-amber-400/30">
                        ✓ ১০০% আসল ও খাঁটি পণ্যের নিশ্চয়তা
                    </div>
                </div>

                <!-- Pricing Box -->
                <div class="lp-card p-5 sm:p-6 rounded-2xl border flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-center sm:text-left">
                        <span class="text-xs lp-muted-text block mb-1">অফার প্রাইজ (সীমিত সময়ের জন্য):</span>
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl sm:text-4xl font-black lp-primary-text">
                                ৳ {{ number_format($product->sale_price) }}
                            </span>
                            @if($product->regular_price > $product->sale_price)
                            <span class="text-sm sm:text-base lp-muted-text line-through opacity-70">
                                ৳ {{ number_format($product->regular_price) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <a href="#orderSection" class="w-full sm:w-auto px-8 py-4 lp-primary-btn font-black text-sm sm:text-base rounded-2xl shadow-xl transition-all text-center flex items-center justify-center gap-2 hover:opacity-90 active:scale-95">
                        <span>এখনই অর্ডার করুন 🛒</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    </a>
                </div>
            </div>

            <!-- Urgency Countdown Timer -->
            <div class="bg-gradient-to-r from-rose-900/80 via-slate-900 to-rose-900/80 p-5 sm:p-6 rounded-3xl border border-rose-700/50 text-center space-y-3">
                <h3 class="text-sm sm:text-base font-black text-rose-300">
                    ⏰ বিশেষ অফারটি শেষ হতে বাকি আছে:
                </h3>
                <div class="flex items-center justify-center gap-2 font-mono">
                    <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                        <span class="text-xl sm:text-2xl font-black text-white countdown-hours">04</span>
                        <span class="block text-[9px] text-rose-300 mt-0.5">ঘণ্টা</span>
                    </div>
                    <span class="text-xl font-bold text-rose-400">:</span>
                    <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                        <span class="text-xl sm:text-2xl font-black text-white countdown-minutes">28</span>
                        <span class="block text-[9px] text-rose-300 mt-0.5">মিনিট</span>
                    </div>
                    <span class="text-xl font-bold text-rose-400">:</span>
                    <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                        <span class="text-xl sm:text-2xl font-black text-white countdown-seconds">45</span>
                        <span class="block text-[9px] text-rose-300 mt-0.5">সেকেন্ড</span>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us / Features -->
            <div class="lp-card rounded-3xl p-6 sm:p-8 border space-y-6">
                <div class="text-center">
                    <h3 class="text-lg sm:text-2xl font-black">কেন আমাদের কাছ থেকে কিনবেন?</h3>
                    <p class="text-xs lp-muted-text mt-1">আমরা নিশ্চিত করি শতভাগ খাঁটি মান ও বিশ্বস্ত সেবা</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    @if(!empty($product->features))
                        @foreach($product->features as $feat)
                        <div class="bg-black/20 p-3.5 rounded-xl border border-white/10 flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full lp-badge border flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                            <span class="text-xs sm:text-sm font-medium">{{ $feat }}</span>
                        </div>
                        @endforeach
                    @else
                        <div class="bg-black/20 p-3.5 rounded-xl border border-white/10 flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full lp-badge border flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                            <span class="text-xs sm:text-sm font-medium">১০০% প্রাকৃতিক ও খাঁটি মানের নিশ্চয়তা</span>
                        </div>
                        <div class="bg-black/20 p-3.5 rounded-xl border border-white/10 flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full lp-badge border flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                            <span class="text-xs sm:text-sm font-medium">কোনো প্রকার ক্ষতিকর কেমিক্যাল বা কৃত্রিম উপাদান মুক্ত</span>
                        </div>
                    @endif
                </div>

                <!-- Guarantees Bar -->
                <div class="grid grid-cols-3 gap-2 pt-4 border-t border-white/10 text-center text-xs">
                    <div class="p-2">
                        <span class="text-2xl block mb-1">🛡️</span>
                        <span class="font-bold block text-[11px] sm:text-xs">ক্যাশ অন ডেলিভারি</span>
                    </div>
                    <div class="p-2">
                        <span class="text-2xl block mb-1">🚚</span>
                        <span class="font-bold block text-[11px] sm:text-xs">দ্রুততম হোম ডেলিভারি</span>
                    </div>
                    <div class="p-2">
                        <span class="text-2xl block mb-1">💯</span>
                        <span class="font-bold block text-[11px] sm:text-xs">খাঁটি না হলে ফেরত</span>
                    </div>
                </div>
            </div>

            <!-- Embedded Cash on Delivery Order Form -->
            @include('storefront.landing._order_form_block', ['block' => []])
        @endif

        <!-- Footer hotline info -->
        <div class="text-center space-y-2 text-xs lp-muted-text pt-6 border-t border-white/10">
            <p>যেকোনো প্রয়োজনে আমাদের কল করুন: <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="lp-primary-text font-bold">{{ $settings['store_phone'] ?? '01712-345678' }}</a></p>
            <p>&copy; {{ date('Y') }} {{ $settings['store_name'] ?? 'DemandHat BD' }}. All Rights Reserved.</p>
        </div>

    </div>

    <!-- Mobile Fixed Bottom Sticky Order Bar -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 lp-card border-t p-3 z-40 flex items-center justify-between gap-4 shadow-2xl backdrop-blur-md">
        <div>
            <span class="text-[10px] lp-muted-text block leading-none">অফার প্রাইজ:</span>
            <span class="text-lg font-black lp-primary-text leading-tight">৳ {{ number_format($product->sale_price) }}</span>
        </div>
        <a href="#orderSection" class="flex-1 py-3 lp-primary-btn font-black text-xs rounded-xl shadow-lg text-center active:scale-95 transition-all">
            অর্ডার করুন 🛒
        </a>
    </div>

    <!-- Storefront Lightbox Modal -->
    <div id="storefrontLightbox" class="fixed inset-0 z-50 bg-black/90 hidden items-center justify-center p-4 backdrop-blur-sm" onclick="closeStorefrontLightbox()">
        <div class="relative max-w-4xl max-h-[90vh] flex flex-col items-center" onclick="event.stopPropagation()">
            <button type="button" onclick="closeStorefrontLightbox()" class="absolute -top-12 right-0 w-9 h-9 rounded-full bg-white/20 hover:bg-white/40 text-white flex items-center justify-center font-black text-lg">
                ✕
            </button>
            <img id="storefrontLightboxImg" src="" class="max-w-full max-h-[80vh] rounded-2xl object-contain border border-white/20 shadow-2xl">
            <p id="storefrontLightboxCaption" class="text-xs sm:text-sm text-white/90 text-center mt-3 font-semibold"></p>
        </div>
    </div>

    <script>
        // Lightbox helpers
        function openStorefrontLightbox(url, caption = '') {
            const modal = document.getElementById('storefrontLightbox');
            const img = document.getElementById('storefrontLightboxImg');
            const cap = document.getElementById('storefrontLightboxCaption');
            if (!modal || !img) return;
            img.src = url;
            cap.textContent = caption || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeStorefrontLightbox() {
            const modal = document.getElementById('storefrontLightbox');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeStorefrontLightbox();
        });

        document.addEventListener('DOMContentLoaded', () => {
            // COD Order Form dynamic calculations
            const qtyInput = document.getElementById('lpQty');
            const minusBtn = document.getElementById('lpMinus');
            const plusBtn = document.getElementById('lpPlus');
            const grandTotalEl = document.getElementById('lpGrandTotal');
            const basePrice = {{ $product->sale_price }};
            const insideRate = {{ $settings['delivery_inside_dhaka'] ?? 70 }};
            const outsideRate = {{ $settings['delivery_outside_dhaka'] ?? 130 }};

            const recalc = () => {
                if (!qtyInput) return;
                const qty = parseInt(qtyInput.value) || 1;
                const isOutside = document.querySelector('.lp-area-radio[value="outside_dhaka"]:checked') !== null;
                const shipping = isOutside ? outsideRate : insideRate;
                const total = (basePrice * qty) + shipping;
                if (grandTotalEl) {
                    grandTotalEl.textContent = `৳ ${total.toLocaleString('en-US')}`;
                }
            };

            minusBtn?.addEventListener('click', () => {
                let v = parseInt(qtyInput.value) || 1;
                if (v > 1) {
                    qtyInput.value = v - 1;
                    recalc();
                }
            });

            plusBtn?.addEventListener('click', () => {
                let v = parseInt(qtyInput.value) || 1;
                if (v < 20) {
                    qtyInput.value = v + 1;
                    recalc();
                }
            });

            document.querySelectorAll('.lp-area-radio').forEach(r => {
                r.addEventListener('change', recalc);
            });

            // Carousel Init for all carousels on page
            document.querySelectorAll('.storefront-carousel-container').forEach(container => {
                const carousel = container.querySelector('.storefront-carousel');
                if (!carousel) return;

                const slides = carousel.querySelectorAll('.carousel-slide');
                const dots = carousel.querySelectorAll('.carousel-dot');
                const prevBtn = carousel.querySelector('.carousel-prev');
                const nextBtn = carousel.querySelector('.carousel-next');
                const isAutoplay = container.dataset.autoplay === 'true';
                const intervalSec = parseFloat(container.dataset.interval) || 4;
                let activeIdx = 0;
                let timer = null;

                const showSlide = (idx) => {
                    if (slides.length <= 1) return;
                    activeIdx = (idx + slides.length) % slides.length;
                    slides.forEach((sl, i) => {
                        if (i === activeIdx) {
                            sl.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                            sl.classList.add('opacity-100', 'z-10');
                        } else {
                            sl.classList.remove('opacity-100', 'z-10');
                            sl.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                        }
                    });

                    dots.forEach((dot, i) => {
                        if (i === activeIdx) {
                            dot.classList.add('bg-white', 'w-6');
                            dot.classList.remove('bg-white/50');
                        } else {
                            dot.classList.remove('bg-white', 'w-6');
                            dot.classList.add('bg-white/50');
                        }
                    });
                };

                const startTimer = () => {
                    if (!isAutoplay || slides.length <= 1) return;
                    stopTimer();
                    timer = setInterval(() => {
                        showSlide(activeIdx + 1);
                    }, intervalSec * 1000);
                };

                const stopTimer = () => {
                    if (timer) {
                        clearInterval(timer);
                        timer = null;
                    }
                };

                prevBtn?.addEventListener('click', () => {
                    showSlide(activeIdx - 1);
                    startTimer();
                });

                nextBtn?.addEventListener('click', () => {
                    showSlide(activeIdx + 1);
                    startTimer();
                });

                dots.forEach((dot, i) => {
                    dot.addEventListener('click', () => {
                        showSlide(i);
                        startTimer();
                    });
                });

                carousel.addEventListener('mouseenter', stopTimer);
                carousel.addEventListener('mouseleave', startTimer);

                startTimer();
            });
        });
    </script>
</body>
</html>
