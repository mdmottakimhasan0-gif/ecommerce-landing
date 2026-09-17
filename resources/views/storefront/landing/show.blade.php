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

    @if(!empty($landingPage->custom_css))
    <style>
        {!! $landingPage->custom_css !!}
    </style>
    @endif
</head>
<body class="font-sans antialiased bg-slate-900 text-slate-100 min-h-screen selection:bg-emerald-500 selection:text-white pb-24 lg:pb-12">

    <!-- Top Urgency Announcement Header -->
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 text-white py-2.5 px-4 text-center text-xs sm:text-sm font-bold shadow-md">
        <div class="max-w-4xl mx-auto flex items-center justify-center gap-2">
            <span class="animate-ping w-2 h-2 rounded-full bg-amber-300"></span>
            <span>🔥 বিশেষ অফার! আর মাত্র <span class="text-amber-300 underline font-black">{{ $product->stock }} টি</span> স্টক বাকি আছে!</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 sm:py-10 space-y-8 sm:space-y-12">

        <!-- Brand / Offer Header -->
        <div class="text-center space-y-3">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs sm:text-sm font-bold">
                <span>🌿</span> {{ $product->category->name }} • স্পেশাল অফার
            </span>
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                {{ $product->name }}
            </h1>
            <p class="text-xs sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                {{ $product->short_description }}
            </p>
        </div>

        <!-- Product Hero Image & Pricing Highlight Card -->
        <div class="bg-slate-800/90 rounded-3xl p-5 sm:p-8 border border-slate-700/80 shadow-2xl space-y-6">
            <div class="relative rounded-2xl overflow-hidden aspect-video sm:aspect-[16/9] bg-slate-950 border border-slate-700">
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
            <div class="bg-gradient-to-r from-slate-900 to-slate-950 p-5 sm:p-6 rounded-2xl border border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-center sm:text-left">
                    <span class="text-xs text-slate-400 block mb-1">অফার প্রাইজ (সীমিত সময়ের জন্য):</span>
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl sm:text-4xl font-black text-emerald-400">
                            ৳ {{ number_format($product->sale_price) }}
                        </span>
                        @if($product->regular_price > $product->sale_price)
                        <span class="text-sm sm:text-base text-slate-500 line-through">
                            ৳ {{ number_format($product->regular_price) }}
                        </span>
                        @endif
                    </div>
                </div>

                <a href="#orderSection" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-black text-sm sm:text-base rounded-2xl shadow-xl hover:shadow-emerald-500/25 transition-all text-center animate-pulse-subtle flex items-center justify-center gap-2">
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
                    <span class="text-xl sm:text-2xl font-black text-white">04</span>
                    <span class="block text-[9px] text-rose-300 mt-0.5">ঘণ্টা</span>
                </div>
                <span class="text-xl font-bold text-rose-400">:</span>
                <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                    <span class="text-xl sm:text-2xl font-black text-white">28</span>
                    <span class="block text-[9px] text-rose-300 mt-0.5">মিনিট</span>
                </div>
                <span class="text-xl font-bold text-rose-400">:</span>
                <div class="bg-black/60 p-2.5 rounded-xl border border-rose-500/40 min-w-[54px]">
                    <span class="text-xl sm:text-2xl font-black text-white">45</span>
                    <span class="block text-[9px] text-rose-300 mt-0.5">সেকেন্ড</span>
                </div>
            </div>
        </div>

        <!-- Why Choose Us / Features -->
        <div class="bg-slate-800/90 rounded-3xl p-6 sm:p-8 border border-slate-700/80 space-y-6">
            <div class="text-center">
                <h3 class="text-lg sm:text-2xl font-black text-white">কেন আমাদের কাছ থেকে কিনবেন?</h3>
                <p class="text-xs text-slate-400 mt-1">আমরা নিশ্চিত করি শতভাগ খাঁটি মান ও বিশ্বস্ত সেবা</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                @if(!empty($product->features))
                    @foreach($product->features as $feat)
                    <div class="bg-slate-900/80 p-3.5 rounded-xl border border-slate-700/60 flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                        <span class="text-xs sm:text-sm text-slate-200 font-medium">{{ $feat }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="bg-slate-900/80 p-3.5 rounded-xl border border-slate-700/60 flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                        <span class="text-xs sm:text-sm text-slate-200">১০০% প্রাকৃতিক ও খাঁটি মানের নিশ্চয়তা</span>
                    </div>
                    <div class="bg-slate-900/80 p-3.5 rounded-xl border border-slate-700/60 flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold flex-shrink-0">✓</span>
                        <span class="text-xs sm:text-sm text-slate-200">কোনো প্রকার ক্ষতিকর কেমিক্যাল বা কৃত্রিম উপাদান মুক্ত</span>
                    </div>
                @endif
            </div>

            <!-- Guarantees Bar -->
            <div class="grid grid-cols-3 gap-2 pt-4 border-t border-slate-700/80 text-center text-xs">
                <div class="p-2">
                    <span class="text-2xl block mb-1">🛡️</span>
                    <span class="font-bold text-slate-200 block text-[11px] sm:text-xs">ক্যাশ অন ডেলিভারি</span>
                </div>
                <div class="p-2">
                    <span class="text-2xl block mb-1">🚚</span>
                    <span class="font-bold text-slate-200 block text-[11px] sm:text-xs">দ্রুততম হোম ডেলিভারি</span>
                </div>
                <div class="p-2">
                    <span class="text-2xl block mb-1">💯</span>
                    <span class="font-bold text-slate-200 block text-[11px] sm:text-xs">খাঁটি না হলে ফেরত</span>
                </div>
            </div>
        </div>

        <!-- Embedded High-Converting Cash on Delivery Order Form -->
        <div id="orderSection" class="bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-2xl border-4 border-emerald-500 space-y-6">
            <div class="text-center space-y-2 border-b border-slate-200 pb-5">
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 font-bold text-xs rounded-full uppercase tracking-wider">
                    ১-মিনিটে অর্ডার করুন
                </span>
                <h2 class="text-xl sm:text-3xl font-black text-slate-900">
                    অর্ডার করতে আপনার সঠিক তথ্য দিন
                </h2>
                <p class="text-xs text-slate-500">
                    পণ্য হাতে পেয়ে চেক করে ডেলিভারি ম্যানের কাছে মূল্য পরিশোধ করার সুবিধা (Cash On Delivery)
                </p>
            </div>

            @if($errors->any())
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('landing.order', $landingPage->slug) }}" method="POST" class="space-y-4">
                @csrf

                <!-- Product Summary Badge in Form -->
                <div class="flex items-center gap-3 p-3.5 bg-emerald-50/70 border border-emerald-200 rounded-2xl">
                    <img src="{{ $product->thumbnail }}" class="w-14 h-14 object-cover rounded-xl border border-emerald-200" alt="{{ $product->name }}">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $product->name }}</h4>
                        <span class="text-sm font-black text-emerald-700">৳ {{ number_format($product->sale_price) }}</span>
                    </div>

                    <!-- Quantity Adjuster -->
                    <div class="flex items-center border border-emerald-300 rounded-xl bg-white overflow-hidden text-xs">
                        <button type="button" id="lpMinus" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 font-bold text-emerald-800">-</button>
                        <input type="number" id="lpQty" name="quantity" value="1" min="1" max="20" class="w-8 text-center font-bold text-slate-800 border-x border-emerald-200 py-1" readonly>
                        <button type="button" id="lpPlus" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 font-bold text-emerald-800">+</button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার পূর্ণ নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="উদাঃ মোঃ আনিসুর রহমান" 
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সচল মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="017XXXXXXXX" pattern="^(?:\+?88)?01[3-9]\d{8}$"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <p class="text-[11px] text-slate-400 mt-1">অর্ডার নিশ্চিত করতে এই নম্বরে যোগাযোগ করা হবে।</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">সম্পূর্ণ ঠিকানা <span class="text-rose-500">*</span></label>
                    <textarea name="address" rows="2" required placeholder="গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা" 
                              class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('address') }}</textarea>
                </div>

                <!-- Delivery Area Radio Selector -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ডেলিভারি চার্জ নির্বাচন করুন <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-between p-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="delivery_area" value="inside_dhaka" checked class="text-emerald-600 focus:ring-emerald-500 lp-area-radio">
                                <span class="text-xs font-bold text-slate-800">ঢাকা সিটিতে</span>
                            </div>
                            <span class="text-xs font-bold text-emerald-700">৳{{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                        </label>
                        <label class="flex items-center justify-between p-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="delivery_area" value="outside_dhaka" class="text-emerald-600 focus:ring-emerald-500 lp-area-radio">
                                <span class="text-xs font-bold text-slate-800">ঢাকার বাইরে</span>
                            </div>
                            <span class="text-xs font-bold text-emerald-700">৳{{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                        </label>
                    </div>
                </div>

                <!-- Total summary -->
                <div class="bg-slate-100 p-4 rounded-2xl flex items-center justify-between">
                    <span class="text-xs sm:text-sm text-slate-600 font-bold">সর্বমোট প্রদেয় টাকা (COD):</span>
                    <span id="lpGrandTotal" class="text-xl sm:text-2xl font-black text-emerald-700">
                        ৳ {{ number_format($product->sale_price + ($settings['delivery_inside_dhaka'] ?? 70)) }}
                    </span>
                </div>

                <!-- Big CTA Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-base sm:text-lg rounded-2xl shadow-xl hover:shadow-emerald-500/25 transition-all text-center flex items-center justify-center gap-2 animate-pulse-subtle">
                    <span>অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি) 🛒</span>
                </button>

                <div class="text-center text-[11px] text-slate-400">
                    <span>🔒 অগ্রিম কোনো টাকা দিতে হবে না। প্রোডাক্ট চেক করে সম্পূর্ণ টাকা দিন।</span>
                </div>
            </form>
        </div>

        <!-- Footer hotline info -->
        <div class="text-center space-y-2 text-xs text-slate-400 pt-6 border-t border-slate-800">
            <p>যেকোনো প্রয়োজনে আমাদের কল করুন: <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="text-emerald-400 font-bold">{{ $settings['store_phone'] ?? '01712-345678' }}</a></p>
            <p>&copy; {{ date('Y') }} {{ $settings['store_name'] ?? 'DemandHat BD' }}. All Rights Reserved.</p>
        </div>

    </div>

    <!-- Mobile Fixed Bottom Sticky Order Bar -->
    <div class="lg:hidden fixed bottom-0 inset-x-0 bg-slate-900/95 backdrop-blur-md border-t border-slate-700 p-3 z-40 flex items-center justify-between gap-4 shadow-2xl">
        <div>
            <span class="text-[10px] text-slate-400 block leading-none">অফার প্রাইজ:</span>
            <span class="text-lg font-black text-emerald-400 leading-tight">৳ {{ number_format($product->sale_price) }}</span>
        </div>
        <a href="#orderSection" class="flex-1 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-black text-xs rounded-xl shadow-lg text-center">
            অর্ডার করুন 🛒
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const qtyInput = document.getElementById('lpQty');
            const minusBtn = document.getElementById('lpMinus');
            const plusBtn = document.getElementById('lpPlus');
            const grandTotalEl = document.getElementById('lpGrandTotal');
            const basePrice = {{ $product->sale_price }};
            const insideRate = {{ $settings['delivery_inside_dhaka'] ?? 70 }};
            const outsideRate = {{ $settings['delivery_outside_dhaka'] ?? 130 }};

            const recalc = () => {
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
        });
    </script>
</body>
</html>
