@extends('admin.layout')

@section('title', 'কুরিয়ার ও শিপিং গেটওয়ে সেটিংস - এডমিন প্যানেল')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-20">

    <!-- Page Title & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 flex items-center gap-2.5">
                <span>🚚</span> কুরিয়ার ও শিপিং ম্যানেজমেন্ট (Courier & Shipping)
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                স্বয়ংক্রিয় পার্সেল বুকিং, বিডি কুরিয়ার ফ্রড ডিটেকশন ও মাল্টি-কুরিয়ার ট্র্যাকিং কনফিগারেশন
            </p>
        </div>

        <div>
            <button type="submit" form="courierSettingsForm" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center gap-2 cursor-pointer active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>সেটিংস সংরক্ষণ করুন</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Test Result Notification Banner -->
    <div id="testResultBanner" class="hidden p-4 rounded-2xl text-xs font-bold flex items-center justify-between shadow-sm transition-all">
        <span id="testResultText"></span>
        <button type="button" onclick="document.getElementById('testResultBanner').classList.add('hidden')" class="text-slate-500 hover:text-slate-800 cursor-pointer">✕</button>
    </div>

    <form id="courierSettingsForm" action="{{ route('admin.couriers.update') }}" method="POST" class="space-y-8">
        @csrf

        <!-- ========================================================================= -->
        <!-- SECTION 1: BD COURIER API (FRAUD DETECTION INTELLIGENCE)                  -->
        <!-- (Exactly matching User's Screenshot 3)                                    -->
        <!-- ========================================================================= -->
        <div class="bg-gradient-to-br from-blue-50/70 via-indigo-50/40 to-white rounded-3xl p-6 sm:p-7 border border-blue-200/90 shadow-sm relative overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-5 border-b border-blue-100">
                <div class="flex items-start gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white font-black text-lg flex items-center justify-center shadow-md flex-shrink-0">
                        BD
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h2 class="text-base sm:text-lg font-black text-slate-900">
                                BD Courier API (ফ্রড ডিটেকশন ও ডেলিভারি রেশিও)
                            </h2>
                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                লাইভ ভেরিফাইড
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            বাংলাদেশের শীর্ষ কুরিয়ারসমূহের (Pathao, Steadfast, RedX ইত্যাদি) সমন্বিত ডেলিভারি ও রিটার্ন ডাটা
                        </p>
                    </div>
                </div>

                <!-- Test Connection Button -->
                <button type="button" onclick="testConnection('bd_courier')" 
                        class="self-start md:self-auto px-4 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-xl text-xs font-bold flex items-center gap-1.5 shadow-sm transition-all hover:border-blue-400 cursor-pointer active:scale-95">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>API কানেকশন টেস্ট করুন</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-5">
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-bold text-slate-700">BD Courier API Key</label>
                        <a href="https://bdcourier.com" target="_blank" class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-0.5">
                            <span>API Key সংগ্রহ করুন</span>
                            <span>↗</span>
                        </a>
                    </div>
                    <input type="text" name="bd_courier_api_key" 
                           value="{{ $settings['bd_courier_api_key'] ?? 'BjhOqJfXtDIhvS2QS4KVIm0OmWw8y6F' }}" 
                           placeholder="যেমন: BjhOqJfXtDIhvS2QS4KVIm0OmWw8y6F"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all shadow-sm">
                    <p class="text-[11px] text-slate-500 mt-1">অর্ডার টেবিলে গ্রাহকের ডেলিভারি রেশিও এবং ফ্রড অ্যানালিটিক্স স্বয়ংক্রিয়ভাবে দেখানোর জন্য ব্যবহৃত হবে।</p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-bold text-slate-700">API Endpoint URL</label>
                        <span class="text-[10px] text-slate-400 font-mono">POST</span>
                    </div>
                    <input type="url" name="bd_courier_endpoint" 
                           value="{{ $settings['bd_courier_endpoint'] ?? 'https://api.bdcourier.com/courier-check' }}" 
                           placeholder="https://api.bdcourier.com/courier-check"
                           class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-mono focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all shadow-sm">
                    <p class="text-[11px] text-slate-500 mt-1">ডিফল্ট: https://api.bdcourier.com/courier-check</p>
                </div>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- SECTION 2: COURIER BOOKING GATEWAYS GRID (Exactly matching Screenshot 2)  -->
        <!-- ========================================================================= -->
        <div class="space-y-4">
            <div>
                <h2 class="text-base sm:text-lg font-black text-slate-900 flex items-center gap-2">
                    <span>📦</span> বাংলাদেশি কুরিয়ার বুকিং গেটওয়েসমূহ (Courier Booking Gateways)
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">অর্ডার কনসোল থেকে এক ক্লিকে সরাসরি সংশ্লিষ্ট কুরিয়ার পোর্টালে পার্সেল বুক করার জন্য এপিআই কী সেট করুন</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                
                <!-- CARD 1: Steadfast Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    SF
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Steadfast Courier</h3>
                                    <p class="text-[11px] text-slate-400">অটোমেটেড পার্সেল বুকিং</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="steadfast_active" value="1" {{ ($settings['steadfast_active'] ?? '1') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">API Key</label>
                                <input type="text" name="steadfast_api_key" value="{{ $settings['steadfast_api_key'] ?? '' }}" placeholder="Steadfast API Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Secret Key</label>
                                <input type="password" name="steadfast_secret_key" value="{{ $settings['steadfast_secret_key'] ?? '' }}" placeholder="Steadfast Secret Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">API Base URL</label>
                                <input type="text" name="steadfast_endpoint" value="{{ $settings['steadfast_endpoint'] ?? 'https://portal.packzy.com/api/v1' }}" placeholder="https://portal.packzy.com/api/v1"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-[11px] focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-slate-50">
                                <span class="text-[10px] text-slate-400">Steadfast অফিসিয়াল লাইভ এপিআই গেটওয়ে</span>
                            </div>

                            <div class="p-3 bg-emerald-50/80 rounded-2xl border border-emerald-200 text-xs space-y-1.5">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-emerald-950 text-[11px]">Webhook URL (লাইভ স্ট্যাটাস অটোপডেট):</span>
                                    <span class="text-[9px] bg-emerald-200 text-emerald-900 px-1.5 py-0.2 rounded font-bold">Auto</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <input type="text" id="sfWebhookUrl" readonly value="{{ url('/api/webhooks/courier/steadfast') }}" 
                                           class="w-full px-2 py-1 bg-white border border-emerald-300 rounded-lg text-[11px] font-mono text-slate-700 select-all">
                                    <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('sfWebhookUrl').value); alert('Steadfast Webhook URL কপি হয়েছে! আপনার Steadfast মার্চেন্ট পোর্টালে Webhook সেকশনে পেস্ট করুন।');" 
                                            class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold cursor-pointer shrink-0 shadow-sm transition-all active:scale-95">
                                        কপি
                                    </button>
                                </div>
                                <p class="text-[10px] text-emerald-800 leading-tight">Steadfast পোর্টালে এই Webhook URL টি দিলে পার্সেল ডেলিভারি বা রিটার্ন হলে সাথে সাথে ওয়েবসাইটে লাইভ স্ট্যাটাস আপডেট হবে।</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[10px] text-slate-400 font-medium">Packzy / Steadfast v1 API</span>
                        <button type="button" onclick="testConnection('steadfast')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            ব্যালেন্স ও কানেকশন টেস্ট
                        </button>
                    </div>
                </div>

                <!-- CARD 2: Pathao Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-rose-600 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    PT
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Pathao Courier</h3>
                                    <p class="text-[11px] text-slate-400">পাঠাও মার্চেন্ট ডেলিভারি</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="pathao_active" value="1" {{ ($settings['pathao_active'] ?? '1') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Client ID</label>
                                    <input type="text" name="pathao_client_id" value="{{ $settings['pathao_client_id'] ?? '' }}" placeholder="Client ID"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Client Secret</label>
                                    <input type="password" name="pathao_client_secret" value="{{ $settings['pathao_client_secret'] ?? '' }}" placeholder="Client Secret"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Username / Email</label>
                                    <input type="text" name="pathao_username" value="{{ $settings['pathao_username'] ?? '' }}" placeholder="Email"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Password</label>
                                    <input type="password" name="pathao_password" value="{{ $settings['pathao_password'] ?? '' }}" placeholder="Password"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 text-[11px] font-medium">
                            <input type="checkbox" name="pathao_sandbox" value="1" {{ ($settings['pathao_sandbox'] ?? '') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5 text-rose-600 rounded">
                            <span>Sandbox মোড</span>
                        </label>
                        <button type="button" onclick="testConnection('pathao')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            টেস্ট করুন
                        </button>
                    </div>
                </div>

                <!-- CARD 3: RedX Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-700 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    RX
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">RedX Courier</h3>
                                    <p class="text-[11px] text-slate-400">রেডএক্স পার্সেল ডেলিভারি</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="redx_active" value="1" {{ ($settings['redx_active'] ?? '') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">API Token / Access Token</label>
                                <input type="text" name="redx_api_token" value="{{ $settings['redx_api_token'] ?? '' }}" placeholder="RedX Access Token"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-red-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 text-[11px] font-medium">
                            <input type="checkbox" name="redx_sandbox" value="1" {{ ($settings['redx_sandbox'] ?? '') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5 text-red-600 rounded">
                            <span>Sandbox মোড</span>
                        </label>
                        <button type="button" onclick="testConnection('redx')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            টেস্ট করুন
                        </button>
                    </div>
                </div>

                <!-- CARD 4: Carrybee Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    CB
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Carrybee Courier</h3>
                                    <p class="text-[11px] text-slate-400">ক্যারিবি ডেলিভারি</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="carrybee_active" value="1" {{ ($settings['carrybee_active'] ?? '') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Client ID</label>
                                <input type="text" name="carrybee_client_id" value="{{ $settings['carrybee_client_id'] ?? '' }}" placeholder="Carrybee Client ID"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Secret Key</label>
                                <input type="password" name="carrybee_secret_key" value="{{ $settings['carrybee_secret_key'] ?? '' }}" placeholder="Carrybee Secret Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-amber-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 text-[11px] font-medium">
                            <input type="checkbox" name="carrybee_sandbox" value="1" {{ ($settings['carrybee_sandbox'] ?? '') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5 text-amber-500 rounded">
                            <span>Sandbox মোড</span>
                        </label>
                        <button type="button" onclick="testConnection('carrybee')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            টেস্ট করুন
                        </button>
                    </div>
                </div>

                <!-- CARD 5: Paperfly Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    PF
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Paperfly Courier</h3>
                                    <p class="text-[11px] text-slate-400">পেপারফ্লাই ডোরস্টেপ ডেলিভারি</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="paperfly_active" value="1" {{ ($settings['paperfly_active'] ?? '') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Username</label>
                                <input type="text" name="paperfly_username" value="{{ $settings['paperfly_username'] ?? '' }}" placeholder="Paperfly Username"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Paperfly Key</label>
                                <input type="password" name="paperfly_key" value="{{ $settings['paperfly_key'] ?? '' }}" placeholder="Paperfly Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 text-[11px] font-medium">
                            <input type="checkbox" name="paperfly_sandbox" value="1" {{ ($settings['paperfly_sandbox'] ?? '') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5 text-blue-600 rounded">
                            <span>Sandbox মোড</span>
                        </label>
                        <button type="button" onclick="testConnection('paperfly')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            টেস্ট করুন
                        </button>
                    </div>
                </div>

                <!-- CARD 6: Parceldex Courier -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-cyan-700 text-white font-black text-xs flex items-center justify-center shadow-sm">
                                    PD
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Parceldex Courier</h3>
                                    <p class="text-[11px] text-slate-400">পার্সেলডেক্স লজিস্টিকস</p>
                                </div>
                            </div>
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="parceldex_active" value="1" {{ ($settings['parceldex_active'] ?? '') === '1' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                                <span>সক্রিয়</span>
                            </label>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">API Key</label>
                                <input type="text" name="parceldex_api_key" value="{{ $settings['parceldex_api_key'] ?? '' }}" placeholder="Parceldex API Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-cyan-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Secret Key</label>
                                <input type="password" name="parceldex_secret_key" value="{{ $settings['parceldex_secret_key'] ?? '' }}" placeholder="Parceldex Secret Key"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl font-mono text-xs focus:ring-2 focus:ring-cyan-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <label class="flex items-center gap-1.5 cursor-pointer text-slate-600 text-[11px] font-medium">
                            <input type="checkbox" name="parceldex_sandbox" value="1" {{ ($settings['parceldex_sandbox'] ?? '') === '1' ? 'checked' : '' }} class="w-3.5 h-3.5 text-cyan-700 rounded">
                            <span>Sandbox মোড</span>
                        </label>
                        <button type="button" onclick="testConnection('parceldex')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg transition-colors cursor-pointer text-xs">
                            টেস্ট করুন
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Submit Button Bottom -->
        <div class="pt-4 flex justify-end">
            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>💾 সমস্ত কুরিয়ার ও শিপিং সেটিংস সংরক্ষণ করুন</span>
            </button>
        </div>
    </form>

</div>

@push('scripts')
<script>
    async function testConnection(gateway) {
        const banner = document.getElementById('testResultBanner');
        const text = document.getElementById('testResultText');
        banner.className = 'p-4 rounded-2xl text-xs font-bold flex items-center justify-between shadow-sm bg-blue-50 border border-blue-200 text-blue-800';
        text.innerHTML = `<span>⏳ ${gateway.toUpperCase()} কানেকশন পরীক্ষা করা হচ্ছে...</span>`;
        banner.classList.remove('hidden');

        try {
            const response = await fetch("{{ route('admin.couriers.test') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ gateway: gateway })
            });

            const data = await response.json();

            if (data.success) {
                banner.className = 'p-4 rounded-2xl text-xs font-bold flex items-center justify-between shadow-sm bg-emerald-50 border border-emerald-200 text-emerald-800';
                text.textContent = data.message;
            } else {
                banner.className = 'p-4 rounded-2xl text-xs font-bold flex items-center justify-between shadow-sm bg-rose-50 border border-rose-200 text-rose-800';
                text.textContent = data.message;
            }
        } catch (err) {
            banner.className = 'p-4 rounded-2xl text-xs font-bold flex items-center justify-between shadow-sm bg-rose-50 border border-rose-200 text-rose-800';
            text.textContent = 'কানেকশন পরীক্ষা করতে ব্যর্থ হয়েছে। নেটওয়ার্ক চেক করুন।';
        }
    }
</script>
@endpush
@endsection
