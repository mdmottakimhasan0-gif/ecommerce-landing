@extends('admin.layout')

@section('title', 'স্টোর ও মাল্টি-পিক্সেল ট্র্যাকিং সেটিংস - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">স্টোর ও মাল্টি-পিক্সেল ট্র্যাকিং সেটিংস</h1>
        <p class="text-xs text-slate-500 mt-1">Facebook Pixel, TikTok Pixel, Google Tag Manager (GTM) এবং ডেলিভারি চার্জ কনফিগার করুন।</p>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card 1: Multi-Pixel & Analytics Tracking (HIGH PRIORITY) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">📊</span>
                        <span>মাল্টি-পিক্সেল ও অ্যাড ট্র্যাকিং (Facebook, TikTok, GTM)</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">এখানে পিক্সেল আইডি বসালে পুরো ওয়েবসাইট এবং সকল ল্যান্ডিং পেজে স্বয়ংক্রিয়ভাবে ইভেন্ট ট্র্যাক হবে।</p>
                </div>
                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-black rounded-lg uppercase tracking-wider border border-indigo-200">
                    Active Tracking
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Facebook Pixel -->
                <div class="space-y-1.5 p-4 rounded-xl bg-blue-50/50 border border-blue-100">
                    <label class="block text-xs font-bold text-blue-900 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Facebook Pixel ID</span>
                    </label>
                    <input type="text" name="fb_pixel_id" value="{{ $settings['fb_pixel_id'] ?? '' }}" 
                           placeholder="যেমন: 123456789012345" 
                           class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500 p-2.5 bg-white">
                    <span class="text-[10px] text-blue-700/80 block">PageView, ViewContent, AddToCart, Purchase স্বয়ংক্রিয়ভাবে ট্র্যাক হবে।</span>
                </div>

                <!-- TikTok Pixel -->
                <div class="space-y-1.5 p-4 rounded-xl bg-rose-50/50 border border-rose-100">
                    <label class="block text-xs font-bold text-rose-900 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.24 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                        <span>TikTok Pixel ID</span>
                    </label>
                    <input type="text" name="tiktok_pixel_id" value="{{ $settings['tiktok_pixel_id'] ?? '' }}" 
                           placeholder="যেমন: C123456789ABC" 
                           class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-rose-500 focus:ring-rose-500 p-2.5 bg-white">
                    <span class="text-[10px] text-rose-700/80 block">TikTok Ads Conversion API ও ব্রাউজার ইভেন্ট সাপোর্টেড।</span>
                </div>

                <!-- Google Tag Manager -->
                <div class="space-y-1.5 p-4 rounded-xl bg-amber-50/50 border border-amber-100">
                    <label class="block text-xs font-bold text-amber-900 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        <span>Google Tag Manager (GTM)</span>
                    </label>
                    <input type="text" name="gtm_id" value="{{ $settings['gtm_id'] ?? '' }}" 
                           placeholder="যেমন: GTM-ABC1234" 
                           class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-2.5 bg-white">
                    <span class="text-[10px] text-amber-700/80 block">GTM কন্টেইনার আইডি বসালে হেড ট্যাগে স্ক্রিপ্ট ইনজেক্ট হবে।</span>
                </div>
            </div>

            <!-- Custom Head Scripts -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                    <span>কাস্টম হেড স্ক্রিপ্ট (&lt;head&gt; Scripts)</span>
                    <span class="text-[10px] font-normal text-slate-400 font-mono">(Google Analytics GA4, Hotjar, Microsoft Clarity ইত্যাদি)</span>
                </label>
                <textarea name="custom_head_scripts" rows="4" 
                          placeholder="<script>
  // আপনার কাস্টম ট্র্যাকিং বা ভেরিফিকেশন কোড এখানে পেস্ট করুন
</script>" 
                          class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-3 bg-slate-900 text-emerald-400 leading-relaxed">{{ $settings['custom_head_scripts'] ?? '' }}</textarea>
                <span class="text-[10px] text-slate-400 mt-1 block">এই কোডটি সরাসরি ওয়েবসাইটের প্রতিটি পেজের &lt;head&gt; ট্যাগের মধ্যে ইনজেক্ট হবে।</span>
            </div>
        </div>

        <!-- Card 2: Delivery Charges (Cash on Delivery) -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">🚚</span>
                    <span>ডেলিভারি চার্জ সেটিংস (বাংলাদেশ)</span>
                </h3>
                <p class="text-[11px] text-slate-400 mt-0.5">ক্যাশ অন ডেলিভারি চেকআউট ও ল্যান্ডিং পেজে স্বয়ংক্রিয় হিসাবের জন্য চার্জ নির্ধারণ করুন।</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ঢাকার ভেতরের ডেলিভারি চার্জ (টাকা) <span class="text-rose-500">*</span></label>
                    <div class="flex rounded-xl shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-300 bg-slate-100 text-slate-600 text-xs font-bold">৳</span>
                        <input type="number" name="delivery_inside_dhaka" value="{{ $settings['delivery_inside_dhaka'] ?? '70' }}" required min="0" 
                               class="flex-1 min-w-0 block w-full text-xs rounded-none rounded-r-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ঢাকার বাইরের ডেলিভারি চার্জ (টাকা) <span class="text-rose-500">*</span></label>
                    <div class="flex rounded-xl shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-300 bg-slate-100 text-slate-600 text-xs font-bold">৳</span>
                        <input type="number" name="delivery_outside_dhaka" value="{{ $settings['delivery_outside_dhaka'] ?? '130' }}" required min="0" 
                               class="flex-1 min-w-0 block w-full text-xs rounded-none rounded-r-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 font-bold">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Store & Contact Information -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">🏢</span>
                    <span>স্টোর ও যোগাযোগ সংক্রান্ত তথ্য</span>
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ওয়েবসাইটের নাম (Store Name)</label>
                    <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'DemandHat BD' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ট্যাগলাইন (Tagline)</label>
                    <input type="text" name="store_tagline" value="{{ $settings['store_tagline'] ?? 'প্রিমিয়াম কোয়ালিটি ও দ্রুততম ডেলিভারি' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">হটলাইন / কাস্টমার কেয়ার নম্বর</label>
                    <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '01700-000000' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">হোয়াটসঅ্যাপ নম্বর (WhatsApp Support)</label>
                    <input type="text" name="store_whatsapp" value="{{ $settings['store_whatsapp'] ?? '01700000000' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ইমেইল এড্রেস (Support Email)</label>
                    <input type="email" name="store_email" value="{{ $settings['store_email'] ?? 'support@demandhatbd.com' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">অফিস / শপ ঠিকানা (Office Address)</label>
                    <input type="text" name="store_address" value="{{ $settings['store_address'] ?? 'উত্তরা, ঢাকা - ১২৩০, বাংলাদেশ' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">টপ অ্যানাউন্সমেন্ট বার টেক্সট</label>
                    <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '🔥 সারাদেশে ক্যাশ অন ডেলিভারি সুবিধা | দ্রুততম সময়ে হোম ডেলিভারি!' }}" class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>সেটিংস ও পিক্সেল সংরক্ষণ করুন</span>
            </button>
        </div>
    </form>
</div>
@endsection
