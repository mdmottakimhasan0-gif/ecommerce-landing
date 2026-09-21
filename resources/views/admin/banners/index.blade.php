@extends('admin.layout')

@section('title', 'হোমপেজ ব্যানার ম্যানেজমেন্ট - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto pb-12">

    <!-- Top Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <div class="flex items-center gap-2">
                <span class="p-2 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-md text-base">🖼️</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">হোমপেজ ব্যানার ম্যানেজমেন্ট</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">হোমপেজের ৩টি মূল ব্যানার, ছবি, অফার টেক্সট ও অ্যাকশন বাটন সহজে পরিবর্তন ও নতুন ছবি আপলোড করুন।</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all border border-slate-300 shadow-sm">
                <span>ওয়েবসাইটে দেখুন</span>
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm animate-fade-in">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-bold space-y-1">
        <div class="flex items-center gap-2 text-rose-900 font-black">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>কিছু ত্রুটি পাওয়া গেছে:</span>
        </div>
        <ul class="list-disc list-inside text-rose-700 pl-2">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Recommended Dimensions Information Banner Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Banner 1 Dimension Spec -->
        <div class="bg-emerald-900/10 border-2 border-emerald-500/40 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
            <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0 shadow">১</span>
            <div>
                <h4 class="text-xs font-black text-emerald-950 uppercase tracking-wide">ব্যানার ১: প্রধান হিরো ব্যানার (বামে)</h4>
                <div class="mt-1 flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                    <span>📐 সাইজ:</span>
                    <span class="px-2 py-0.5 rounded-md bg-emerald-600 text-white text-[11px] font-mono font-black">৮০০ × ৫০০ px</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">16:10 / 8:5 অ্যাসপেক্ট রেশিও। সর্বোচ্চ 2MB (WebP, PNG, JPG)।</p>
            </div>
        </div>

        <!-- Banner 2 Dimension Spec -->
        <div class="bg-amber-900/10 border-2 border-amber-500/40 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
            <span class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0 shadow">২</span>
            <div>
                <h4 class="text-xs font-black text-amber-950 uppercase tracking-wide">ব্যানার ২: টপ প্রোমো ব্যানার (ডানে)</h4>
                <div class="mt-1 flex items-center gap-1.5 text-xs font-bold text-amber-700">
                    <span>📐 সাইজ:</span>
                    <span class="px-2 py-0.5 rounded-md bg-amber-600 text-white text-[11px] font-mono font-black">৪০০ × ২৪০ px</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">5:3 অ্যাসপেক্ট রেশিও। সর্বোচ্চ 2MB (WebP, PNG, JPG)।</p>
            </div>
        </div>

        <!-- Banner 3 Dimension Spec -->
        <div class="bg-blue-900/10 border-2 border-blue-500/40 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
            <span class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0 shadow">৩</span>
            <div>
                <h4 class="text-xs font-black text-blue-950 uppercase tracking-wide">ব্যানার ৩: বটম প্রোমো ব্যানার (ডানে)</h4>
                <div class="mt-1 flex items-center gap-1.5 text-xs font-bold text-blue-700">
                    <span>📐 সাইজ:</span>
                    <span class="px-2 py-0.5 rounded-md bg-blue-600 text-white text-[11px] font-mono font-black">৪০০ × ২৪০ px</span>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">5:3 অ্যাসপেক্ট রেশিও। সর্বোচ্চ 2MB (WebP, PNG, JPG)।</p>
            </div>
        </div>
    </div>

    <!-- Main Edit Form -->
    <form action="{{ route('admin.banners.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- ============================================================= -->
        <!-- BANNER 1: MAIN HERO BANNER (Left Large 2/3)                  -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 bg-gradient-to-r from-slate-900 to-slate-800 text-white flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-base shadow">১</span>
                    <div>
                        <h3 class="font-black text-sm sm:text-base text-white flex items-center gap-2">
                            <span>প্রধান হিরো ব্যানার (বাম পাশ - বড় সাইজ)</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] font-bold">
                                📐 রিকমেন্ডেড সাইজ: ৮০০ × ৫০০ px
                            </span>
                        </h3>
                        <p class="text-[11px] text-slate-300">হোমপেজে ভিজিটরদের প্রথম নজরে আসার মূল ব্যানার</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700">
                        <input type="checkbox" name="banner1_show_text" value="1" {{ !empty($banners['banner1']['show_text']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                        <span class="text-xs font-bold text-slate-200">ছবির ওপর টেক্সট দেখান</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-slate-800/80 px-3 py-1.5 rounded-xl border border-slate-700">
                        <input type="checkbox" name="banner1_is_active" value="1" {{ !empty($banners['banner1']['is_active']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                        <span class="text-xs font-bold text-slate-200">ব্যানার প্রদর্শন করুন</span>
                    </label>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Text Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">টপ ব্যাজ টেক্সট (Badge Text)</label>
                        <input type="text" name="banner1_badge" id="b1_in_badge" 
                               value="{{ old('banner1_badge', $banners['banner1']['badge'] ?? '') }}" 
                               placeholder="যেমন: 🌿 প্রিমিয়াম অর্গানিক ও লাইফস্টাইল কালেকশন" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ব্যাকগ্রাউন্ড গ্রেডিয়েন্ট থিম (Gradient Preset)</label>
                        <select name="banner1_bg_gradient" id="b1_in_gradient" class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white">
                            @php $b1Grad = old('banner1_bg_gradient', $banners['banner1']['bg_gradient'] ?? 'from-emerald-900 via-teal-900 to-slate-900'); @endphp
                            <option value="from-emerald-900 via-teal-900 to-slate-900" {{ $b1Grad == 'from-emerald-900 via-teal-900 to-slate-900' ? 'selected' : '' }}>🌿 অর্গানিক এমারেল্ড ও ডার্ক টিল (ডিফল্ট)</option>
                            <option value="from-slate-900 via-slate-800 to-zinc-950" {{ $b1Grad == 'from-slate-900 via-slate-800 to-zinc-950' ? 'selected' : '' }}>🖤 মিডনাইট ব্ল্যাক ও লাক্সারি স্লেট</option>
                            <option value="from-amber-950 via-amber-900 to-slate-900" {{ $b1Grad == 'from-amber-950 via-amber-900 to-slate-900' ? 'selected' : '' }}>🍯 প্রিমিয়াম হানি অ্যাম্বার</option>
                            <option value="from-blue-950 via-indigo-900 to-slate-900" {{ $b1Grad == 'from-blue-950 via-indigo-900 to-slate-900' ? 'selected' : '' }}>💎 রয়্যাল ব্লু ও ডিপ ইন্ডিগো</option>
                            <option value="from-rose-950 via-rose-900 to-slate-900" {{ $b1Grad == 'from-rose-950 via-rose-900 to-slate-900' ? 'selected' : '' }}>🔥 ক্রিসমন হট ডিল রেড</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">মূল হেডলাইন / শিরোনাম (Headline - টেক্সট ওভারলে সক্রিয় থাকলে)</label>
                        <input type="text" name="banner1_title" id="b1_in_title"
                               value="{{ old('banner1_title', $banners['banner1']['title'] ?? '') }}" 
                               placeholder="যেমন: প্রকৃতির খাঁটি স্বাদ ও আধুনিক গ্যাজেটের সেরা সমাহার!" 
                               class="w-full text-sm font-bold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">সাবটাইটেল / সংক্ষিপ্ত বিবরণ (Description)</label>
                        <textarea name="banner1_subtitle" id="b1_in_subtitle" rows="2" 
                                  placeholder="যেমন: সুন্দরবনের প্রাকৃতিক চাকের মধু, কাঠের ঘানি ভাঙা খাঁটি সরিষার তেল..." 
                                  class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5">{{ old('banner1_subtitle', $banners['banner1']['subtitle'] ?? '') }}</textarea>
                    </div>

                    <!-- Button 1 -->
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                        <span class="text-xs font-bold text-emerald-800 block">বাটন ১ (Primary CTA Button)</span>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">বাটন টেক্সট</label>
                            <input type="text" name="banner1_btn1_text" id="b1_in_btn1_text" 
                                   value="{{ old('banner1_btn1_text', $banners['banner1']['btn1_text'] ?? 'সব পণ্য দেখুন 🛒') }}" 
                                   placeholder="সব পণ্য দেখুন 🛒" 
                                   class="w-full text-xs rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">বাটন লিংক (URL / Route)</label>
                            <input type="text" name="banner1_btn1_link" id="b1_in_btn1_link" 
                                   value="{{ old('banner1_btn1_link', $banners['banner1']['btn1_link'] ?? '/products') }}" 
                                   placeholder="/products" 
                                   class="w-full text-xs font-mono rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white">
                        </div>
                    </div>

                    <!-- Button 2 -->
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                        <span class="text-xs font-bold text-slate-800 block">বাটন ২ (Secondary Button - ঐচ্ছিক)</span>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">বাটন টেক্সট</label>
                            <input type="text" name="banner1_btn2_text" id="b1_in_btn2_text" 
                                   value="{{ old('banner1_btn2_text', $banners['banner1']['btn2_text'] ?? 'খাঁটি অর্গানিক ফুড →') }}" 
                                   placeholder="খাঁটি অর্গানিক ফুড →" 
                                   class="w-full text-xs rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white">
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 mb-1">বাটন লিংক (URL / Route)</label>
                            <input type="text" name="banner1_btn2_link" id="b1_in_btn2_link" 
                                   value="{{ old('banner1_btn2_link', $banners['banner1']['btn2_link'] ?? '/products?category=organic-products') }}" 
                                   placeholder="/products?category=organic-products" 
                                   class="w-full text-xs font-mono rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2 bg-white">
                        </div>
                    </div>
                </div>

                <!-- Banner 1 Image Upload Box -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span>📸 ব্যানার ১ ছবি আপলোড বা পরিবর্তন (Image Upload)</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-mono text-[10px] font-bold">রিকমেন্ডেড: ৮০০ × ৫০০ px</span>
                        </span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                        <!-- File Upload Input -->
                        <div class="md:col-span-2 space-y-3">
                            <div class="border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-4 text-center cursor-pointer transition-colors bg-slate-50/50 relative group">
                                <input type="file" name="banner1_file" id="b1_file" accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="previewBannerFile(this, 'b1_preview_img')">
                                <div class="space-y-1 pointer-events-none">
                                    <svg class="mx-auto h-8 w-8 text-slate-400 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs font-bold text-slate-700">কম্পিউটার বা মোবাইল থেকে ছবি সিলেক্ট করুন</p>
                                    <p class="text-[11px] text-slate-500">অনুমোদিত ফরম্যাট: WebP, PNG, JPG (সর্বোচ্চ 2MB)</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">অথবা সরাসরি ইমেজ লিংক (Image URL):</label>
                                <input type="url" name="banner1_image_url" id="b1_url" 
                                       value="{{ old('banner1_image_url', $banners['banner1']['image'] ?? '') }}" 
                                       placeholder="https://images.unsplash.com/..." 
                                       class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white"
                                       oninput="previewBannerUrl(this.value, 'b1_preview_img')">
                            </div>
                        </div>

                        <!-- Image Preview Box -->
                        <div class="bg-slate-900 rounded-2xl p-2.5 border border-slate-800 text-center space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">বর্তমান ছবির প্রিভিউ</span>
                            <div class="aspect-[16/10] rounded-xl overflow-hidden bg-slate-950 border border-slate-800 relative flex items-center justify-center">
                                <img id="b1_preview_img" 
                                     src="{{ $banners['banner1']['image'] ?: 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80' }}" 
                                     alt="Banner 1" 
                                     class="w-full h-full object-cover">
                            </div>
                            <span class="text-[10px] text-emerald-400 font-mono font-bold block">অনুপাত: ১৬:১০ (৮০০x৫০০)</span>
                        </div>
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- BANNER 1: MULTI-SLIDE CAROUSEL MANAGER (Multiple Offers/Slides) -->
                <!-- ============================================================= -->
                <div class="pt-6 border-t-2 border-dashed border-slate-200">
                    <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                        <div>
                            <h4 class="text-sm font-black text-slate-900 flex items-center gap-2">
                                <span>🎡 প্রধান ব্যানারে একাধিক স্লাইড ও অফার (Auto Slider)</span>
                                <span class="px-2 py-0.5 rounded-full bg-cyan-100 text-cyan-800 text-[10px] font-bold">Multi-Slide Carousel</span>
                            </h4>
                            <p class="text-xs text-slate-500">হোমপেজে পর্যায়ক্রমে স্বয়ংক্রিয়ভাবে পরিবর্তিত হওয়া স্লাইডগুলো সেট করুন।</p>
                        </div>
                        <button type="button" onclick="addBanner1Slide()" 
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm cursor-pointer">
                            <span>+ নতুন স্লাইড যোগ করুন</span>
                        </button>
                    </div>

                    @php
                        $b1Slides = $banners['banner1']['slides'] ?? [];
                        if (empty($b1Slides) && !empty($banners['banner1']['image'])) {
                            $b1Slides = [$banners['banner1']];
                        }
                    @endphp

                    <div id="banner1SlidesContainer" class="space-y-4">
                        @foreach($b1Slides as $sIdx => $slide)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-4 slide-card relative" data-slide-index="{{ $sIdx }}">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-2.5">
                                <span class="text-xs font-black text-slate-800 flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-xs">{{ $loop->iteration }}</span>
                                    <span>স্লাইড #{{ $loop->iteration }}</span>
                                </span>
                                <div class="flex items-center gap-3">
                                    <label class="flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                                        <input type="checkbox" name="banner1_slides[{{ $sIdx }}][show_text]" value="1" {{ !empty($slide['show_text']) ? 'checked' : '' }} class="rounded text-emerald-600">
                                        <span>টেক্সট দেখান</span>
                                    </label>
                                    <button type="button" onclick="this.closest('.slide-card').remove()" class="text-rose-600 hover:text-rose-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                                        <span>✕ মুছুন</span>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">টপ ব্যাজ (Badge)</label>
                                    <input type="text" name="banner1_slides[{{ $sIdx }}][badge]" value="{{ $slide['badge'] ?? '' }}" placeholder="যেমন: 🌿 স্পেশাল অফার" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">হেডলাইন (Title)</label>
                                    <input type="text" name="banner1_slides[{{ $sIdx }}][title]" value="{{ $slide['title'] ?? '' }}" placeholder="স্লাইড শিরোনাম" class="w-full text-xs font-bold rounded-lg border-slate-300 p-2 bg-white">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">সাবটাইটেল (Description)</label>
                                    <input type="text" name="banner1_slides[{{ $sIdx }}][subtitle]" value="{{ $slide['subtitle'] ?? '' }}" placeholder="সংক্ষিপ্ত বিবরণ" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">বাটন টেক্সট</label>
                                    <input type="text" name="banner1_slides[{{ $sIdx }}][btn1_text]" value="{{ $slide['btn1_text'] ?? 'অর্ডার করুন 🛒' }}" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-slate-600 mb-1">বাটন লিংক</label>
                                    <input type="text" name="banner1_slides[{{ $sIdx }}][btn1_link]" value="{{ $slide['btn1_link'] ?? '/products' }}" class="w-full text-xs font-mono rounded-lg border-slate-300 p-2 bg-white">
                                </div>
                                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="block text-[11px] font-bold text-slate-700">স্লাইড ছবি (Image Upload or URL)</label>
                                        <input type="file" name="banner1_slide_file_{{ $sIdx }}" accept="image/*" class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" onchange="previewBannerFile(this, 'b1_slide_preview_{{ $sIdx }}')">
                                        <input type="url" name="banner1_slides[{{ $sIdx }}][image_url]" value="{{ $slide['image'] ?? '' }}" placeholder="অথবা সরাসরি ইমেজ লিংক (https://...)" class="w-full text-xs font-mono rounded-lg border-slate-300 p-2 bg-white" oninput="previewBannerUrl(this.value, 'b1_slide_preview_{{ $sIdx }}')">
                                    </div>
                                    <div class="aspect-[16/10] max-h-24 rounded-xl overflow-hidden bg-slate-900 border border-slate-800 flex items-center justify-center">
                                        <img id="b1_slide_preview_{{ $sIdx }}" src="{{ $slide['image'] ?? 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80' }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- BANNER 2: TOP RIGHT PROMO BANNER                             -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 bg-gradient-to-r from-amber-900 to-orange-950 text-white flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-black text-base shadow">২</span>
                    <div>
                        <h3 class="font-black text-sm sm:text-base text-white flex items-center gap-2">
                            <span>উপরের প্রোমো ব্যানার (ডান পাশ - ছোট সাইজ)</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 text-[10px] font-bold">
                                📐 রিকমেন্ডেড সাইজ: ৪০০ × ২৪০ px
                            </span>
                        </h3>
                        <p class="text-[11px] text-amber-200/90">কিচেন টুলস বা স্পেশাল কালেকশনের জন্য নির্ধারিত কার্ড</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-black/40 px-3 py-1.5 rounded-xl border border-amber-700/50">
                        <input type="checkbox" name="banner2_show_text" value="1" {{ !empty($banners['banner2']['show_text']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500">
                        <span class="text-xs font-bold text-slate-200">ছবির ওপর টেক্সট দেখান</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-black/40 px-3 py-1.5 rounded-xl border border-amber-700/50">
                        <input type="checkbox" name="banner2_is_active" value="1" {{ !empty($banners['banner2']['is_active']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-amber-600 rounded focus:ring-amber-500">
                        <span class="text-xs font-bold text-slate-200">ব্যানার প্রদর্শন করুন</span>
                    </label>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ক্যাটাগরি ব্যাজ টেক্সট</label>
                        <input type="text" name="banner2_badge" 
                               value="{{ old('banner2_badge', $banners['banner2']['badge'] ?? '') }}" 
                               placeholder="স্মার্ট হোম ও কিচেন" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ব্যাকগ্রাউন্ড গ্রেডিয়েন্ট থিম</label>
                        <select name="banner2_bg_gradient" class="w-full text-xs rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5 bg-white">
                            @php $b2Grad = old('banner2_bg_gradient', $banners['banner2']['bg_gradient'] ?? 'from-amber-700 to-orange-900'); @endphp
                            <option value="from-amber-700 to-orange-900" {{ $b2Grad == 'from-amber-700 to-orange-900' ? 'selected' : '' }}>🔥 ওয়ার্ম অ্যাম্বার ও অরেঞ্জ (ডিফল্ট)</option>
                            <option value="from-emerald-800 to-teal-950" {{ $b2Grad == 'from-emerald-800 to-teal-950' ? 'selected' : '' }}>🌿 এমারেল্ড গ্রিন</option>
                            <option value="from-slate-900 to-zinc-900" {{ $b2Grad == 'from-slate-900 to-zinc-900' ? 'selected' : '' }}>🖤 ডার্ক স্লেট</option>
                            <option value="from-rose-800 to-red-950" {{ $b2Grad == 'from-rose-800 to-red-950' ? 'selected' : '' }}>🌹 ক্রিসমন রেড</option>
                            <option value="from-blue-800 to-indigo-950" {{ $b2Grad == 'from-blue-800 to-indigo-950' ? 'selected' : '' }}>💎 রয়্যাল ব্লু</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">ব্যানার টাইটেল / পণ্য নাম (টেক্সট ওভারলে সক্রিয় থাকলে)</label>
                        <input type="text" name="banner2_title" 
                               value="{{ old('banner2_title', $banners['banner2']['title'] ?? '') }}" 
                               placeholder="মাল্টিফাংশন ভেজিটেবল চপার ও কাটার" 
                               class="w-full text-sm font-bold rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">সাবটাইটেল / অফার মূল্য বিবরণ</label>
                        <input type="text" name="banner2_subtitle" 
                               value="{{ old('banner2_subtitle', $banners['banner2']['subtitle'] ?? '') }}" 
                               placeholder="রান্নার সময় বাঁচান নিমেষেই! মাত্র ৳ ৭৯০" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">অ্যাকশন লিংক টেক্সট</label>
                            <input type="text" name="banner2_link_text" 
                                   value="{{ old('banner2_link_text', $banners['banner2']['link_text'] ?? 'অর্ডার করুন এখনই →') }}" 
                                   placeholder="অর্ডার করুন এখনই →" 
                                   class="w-full text-xs rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">টার্গেট লিংক (URL)</label>
                            <input type="text" name="banner2_link_url" 
                                   value="{{ old('banner2_link_url', $banners['banner2']['link_url'] ?? '/products?category=home-kitchen') }}" 
                                   placeholder="/products?category=home-kitchen" 
                                   class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5">
                        </div>
                    </div>
                </div>

                <!-- Banner 2 Image Upload -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span>📸 ব্যানার ২ ছবি আপলোড (Image Upload)</span>
                            <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-mono text-[10px] font-bold">রিকমেন্ডেড: ৪০০ × ২৪০ px</span>
                        </span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                        <div class="md:col-span-2 space-y-3">
                            <div class="border-2 border-dashed border-slate-300 hover:border-amber-500 rounded-2xl p-4 text-center cursor-pointer transition-colors bg-slate-50/50 relative group">
                                <input type="file" name="banner2_file" id="b2_file" accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="previewBannerFile(this, 'b2_preview_img')">
                                <div class="space-y-1 pointer-events-none">
                                    <svg class="mx-auto h-7 w-7 text-slate-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs font-bold text-slate-700">ব্যানার ২ এর ছবি আপলোড করুন</p>
                                    <p class="text-[10px] text-slate-500">অনুমোদিত: WebP, PNG, JPG (সর্বোচ্চ 2MB)</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">অথবা ইমেজ লিংক (URL):</label>
                                <input type="url" name="banner2_image_url" 
                                       value="{{ old('banner2_image_url', $banners['banner2']['image'] ?? '') }}" 
                                       placeholder="https://..." 
                                       class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5 bg-white"
                                       oninput="previewBannerUrl(this.value, 'b2_preview_img')">
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div class="bg-slate-900 rounded-2xl p-2.5 border border-slate-800 text-center space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">ছবি প্রিভিউ</span>
                            <div class="aspect-[5/3] rounded-xl overflow-hidden bg-slate-950 border border-slate-800 relative flex items-center justify-center">
                                <img id="b2_preview_img" 
                                     src="{{ $banners['banner2']['image'] ?: 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&auto=format&fit=crop&q=80' }}" 
                                     alt="Banner 2" 
                                     class="w-full h-full object-cover">
                            </div>
                            <span class="text-[10px] text-amber-400 font-mono font-bold block">অনুপাত: ৫:৩ (৪০০x২৪০)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- BANNER 3: BOTTOM RIGHT PROMO BANNER                          -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 bg-gradient-to-r from-blue-950 to-indigo-950 text-white flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-base shadow">৩</span>
                    <div>
                        <h3 class="font-black text-sm sm:text-base text-white flex items-center gap-2">
                            <span>নিচের প্রোমো ব্যানার (ডান পাশ - ছোট সাইজ)</span>
                            <span class="px-2.5 py-0.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-bold">
                                📐 রিকমেন্ডেড সাইজ: ৪০০ × ২৪০ px
                            </span>
                        </h3>
                        <p class="text-[11px] text-blue-200/90">গ্যাজেট, ট্রিমার বা টেক কালেকশনের জন্য নির্ধারিত কার্ড</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-black/40 px-3 py-1.5 rounded-xl border border-blue-700/50">
                        <input type="checkbox" name="banner3_show_text" value="1" {{ !empty($banners['banner3']['show_text']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-xs font-bold text-slate-200">ছবির ওপর টেক্সট দেখান</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none bg-black/40 px-3 py-1.5 rounded-xl border border-blue-700/50">
                        <input type="checkbox" name="banner3_is_active" value="1" {{ !empty($banners['banner3']['is_active']) ? 'checked' : '' }} 
                               class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-xs font-bold text-slate-200">ব্যানার প্রদর্শন করুন</span>
                    </label>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">অফার ব্যাজ টেক্সট</label>
                        <input type="text" name="banner3_badge" 
                               value="{{ old('banner3_badge', $banners['banner3']['badge'] ?? '') }}" 
                               placeholder="মেগা টেক ডিসকাউন্ট" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ব্যাকগ্রাউন্ড গ্রেডিয়েন্ট থিম</label>
                        <select name="banner3_bg_gradient" class="w-full text-xs rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white">
                            @php $b3Grad = old('banner3_bg_gradient', $banners['banner3']['bg_gradient'] ?? 'from-blue-900 to-indigo-950'); @endphp
                            <option value="from-blue-900 to-indigo-950" {{ $b3Grad == 'from-blue-900 to-indigo-950' ? 'selected' : '' }}>💎 রয়্যাল ব্লু ও ডিপ ইন্ডিগো (ডিফল্ট)</option>
                            <option value="from-slate-900 to-zinc-900" {{ $b3Grad == 'from-slate-900 to-zinc-900' ? 'selected' : '' }}>🖤 ডার্ক স্লেট ও গ্রাফাইট</option>
                            <option value="from-purple-900 to-fuchsia-950" {{ $b3Grad == 'from-purple-900 to-fuchsia-950' ? 'selected' : '' }}>💜 ভাইব্রেন্ট পার্পল ও ফিউশিয়া</option>
                            <option value="from-rose-900 to-slate-950" {{ $b3Grad == 'from-rose-900 to-slate-950' ? 'selected' : '' }}>🔥 হট ডিল রেড</option>
                            <option value="from-emerald-900 to-teal-950" {{ $b3Grad == 'from-emerald-900 to-teal-950' ? 'selected' : '' }}>🌿 ডিপ টিল ও এমারেল্ড</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1">ব্যানার টাইটেল / পণ্য নাম (টেক্সট ওভারলে সক্রিয় থাকলে)</label>
                        <input type="text" name="banner3_title" 
                               value="{{ old('banner3_title', $banners['banner3']['title'] ?? '') }}" 
                               placeholder="T9 ভিন্টেজ হেয়ার ট্রিমার ও স্মার্ট ওয়াচ" 
                               class="w-full text-sm font-bold rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">সাবটাইটেল / ওয়ারেন্টি বিবরণ</label>
                        <input type="text" name="banner3_subtitle" 
                               value="{{ old('banner3_subtitle', $banners['banner3']['subtitle'] ?? '') }}" 
                               placeholder="১ বছরের রিপ্লেসমেন্ট গ্যারান্টি সহ!" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">অ্যাকশন লিংক টেক্সট</label>
                            <input type="text" name="banner3_link_text" 
                                   value="{{ old('banner3_link_text', $banners['banner3']['link_text'] ?? 'অফার দেখুন →') }}" 
                                   placeholder="অফার দেখুন →" 
                                   class="w-full text-xs rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">টার্গেট লিংক (URL)</label>
                            <input type="text" name="banner3_link_url" 
                                   value="{{ old('banner3_link_url', $banners['banner3']['link_url'] ?? '/products?category=electronics-gadgets') }}" 
                                   placeholder="/products?category=electronics-gadgets" 
                                   class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5">
                        </div>
                    </div>
                </div>

                <!-- Banner 3 Image Upload -->
                <div class="pt-4 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-800 mb-2 flex items-center justify-between">
                        <span class="flex items-center gap-1.5">
                            <span>📸 ব্যানার ৩ ছবি আপলোড (Image Upload)</span>
                            <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-mono text-[10px] font-bold">রিকমেন্ডেড: ৪০০ × ২৪০ px</span>
                        </span>
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 items-start">
                        <div class="md:col-span-2 space-y-3">
                            <div class="border-2 border-dashed border-slate-300 hover:border-blue-500 rounded-2xl p-4 text-center cursor-pointer transition-colors bg-slate-50/50 relative group">
                                <input type="file" name="banner3_file" id="b3_file" accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="previewBannerFile(this, 'b3_preview_img')">
                                <div class="space-y-1 pointer-events-none">
                                    <svg class="mx-auto h-7 w-7 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <p class="text-xs font-bold text-slate-700">ব্যানার ৩ এর ছবি আপলোড করুন</p>
                                    <p class="text-[10px] text-slate-500">অনুমোদিত: WebP, PNG, JPG (সর্বোচ্চ 2MB)</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-semibold text-slate-600 mb-1">অথবা ইমেজ লিংক (URL):</label>
                                <input type="url" name="banner3_image_url" 
                                       value="{{ old('banner3_image_url', $banners['banner3']['image'] ?? '') }}" 
                                       placeholder="https://..." 
                                       class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white"
                                       oninput="previewBannerUrl(this.value, 'b3_preview_img')">
                            </div>
                        </div>

                        <!-- Image Preview -->
                        <div class="bg-slate-900 rounded-2xl p-2.5 border border-slate-800 text-center space-y-1.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">ছবি প্রিভিউ</span>
                            <div class="aspect-[5/3] rounded-xl overflow-hidden bg-slate-950 border border-slate-800 relative flex items-center justify-center">
                                <img id="b3_preview_img" 
                                     src="{{ $banners['banner3']['image'] ?: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&auto=format&fit=crop&q=80' }}" 
                                     alt="Banner 3" 
                                     class="w-full h-full object-cover">
                            </div>
                            <span class="text-[10px] text-blue-400 font-mono font-bold block">অনুপাত: ৫:৩ (৪০০x২৪০)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Bar with Save Button -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-2xl flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>ছবি ও টেক্সট পরিবর্তন শেষে নিচের বাটনে ক্লিক করুন।</span>
            </div>

            <button type="submit" 
                    class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>ব্যানার পরিবর্তন সেভ করুন 💾</span>
            </button>
        </div>
    </form>

</div>

<script>
    function previewBannerFile(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetImgId);
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewBannerUrl(url, targetImgId) {
        if (url && url.trim().length > 5) {
            const img = document.getElementById(targetImgId);
            if (img) img.src = url.trim();
        }
    }

    let slideCounter = document.querySelectorAll('#banner1SlidesContainer .slide-card').length;

    function addBanner1Slide() {
        const container = document.getElementById('banner1SlidesContainer');
        const sIdx = slideCounter++;
        const count = container.children.length + 1;
        
        const html = `
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-4 slide-card relative animate-fade-in" data-slide-index="${sIdx}">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2.5">
                    <span class="text-xs font-black text-slate-800 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-xs">${count}</span>
                        <span>নতুন স্লাইড #${count}</span>
                    </span>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-1.5 text-xs text-slate-700 cursor-pointer">
                            <input type="checkbox" name="banner1_slides[${sIdx}][show_text]" value="1" class="rounded text-emerald-600">
                            <span>টেক্সট দেখান</span>
                        </label>
                        <button type="button" onclick="this.closest('.slide-card').remove()" class="text-rose-600 hover:text-rose-700 text-xs font-bold flex items-center gap-1 cursor-pointer">
                            <span>✕ মুছুন</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">টপ ব্যাজ (Badge)</label>
                        <input type="text" name="banner1_slides[${sIdx}][badge]" value="🔥 স্পেশাল অফার" placeholder="যেমন: 🌿 স্পেশাল অফার" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">হেডলাইন (Title)</label>
                        <input type="text" name="banner1_slides[${sIdx}][title]" value="" placeholder="স্লাইড শিরোনাম" class="w-full text-xs font-bold rounded-lg border-slate-300 p-2 bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">সাবটাইটেল (Description)</label>
                        <input type="text" name="banner1_slides[${sIdx}][subtitle]" value="" placeholder="সংক্ষিপ্ত বিবরণ" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">বাটন টেক্সট</label>
                        <input type="text" name="banner1_slides[${sIdx}][btn1_text]" value="অর্ডার করুন 🛒" class="w-full text-xs rounded-lg border-slate-300 p-2 bg-white">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">বাটন লিংক</label>
                        <input type="text" name="banner1_slides[${sIdx}][btn1_link]" value="/products" class="w-full text-xs font-mono rounded-lg border-slate-300 p-2 bg-white">
                    </div>
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[11px] font-bold text-slate-700">স্লাইড ছবি (Image Upload or URL)</label>
                            <input type="file" name="banner1_slide_file_${sIdx}" accept="image/*" class="w-full text-xs file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" onchange="previewBannerFile(this, 'b1_slide_preview_${sIdx}')">
                            <input type="url" name="banner1_slides[${sIdx}][image_url]" value="" placeholder="অথবা সরাসরি ইমেজ লিংক (https://...)" class="w-full text-xs font-mono rounded-lg border-slate-300 p-2 bg-white" oninput="previewBannerUrl(this.value, 'b1_slide_preview_${sIdx}')">
                        </div>
                        <div class="aspect-[16/10] max-h-24 rounded-xl overflow-hidden bg-slate-900 border border-slate-800 flex items-center justify-center">
                            <img id="b1_slide_preview_${sIdx}" src="https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800&auto=format&fit=crop&q=80" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }
</script>
@endsection
