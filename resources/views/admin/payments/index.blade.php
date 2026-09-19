@extends('admin.layout')

@section('title', 'পেমেন্ট গেটওয়ে ও লেনদেন হিস্ট্রি - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-16">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2.5">
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-700 text-xl">💳</span>
                <span>পেমেন্ট গেটওয়ে ও লেনদেন হিস্ট্রি</span>
            </h1>
            <p class="text-xs text-slate-500 mt-1">ক্যাশ অন ডেলিভারি, বিকাশ ও নগদ গেটওয়ে কনফিগার করুন এবং গ্রাহকের ট্রানজেকশন যাচাই করুন।</p>
        </div>

        <!-- Quick Stats Cards -->
        <div class="flex items-center gap-2 flex-wrap">
            <span class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-2xs">
                মোট ট্রানজেকশন: <strong class="text-emerald-700">{{ $stats['total_transactions'] ?? 0 }}</strong>
            </span>
            <span class="px-3 py-1.5 rounded-xl bg-pink-50 border border-pink-200 text-xs font-bold text-pink-700 shadow-2xs">
                বিকাশ: <strong>{{ $stats['bkash_count'] ?? 0 }}</strong>
            </span>
            <span class="px-3 py-1.5 rounded-xl bg-orange-50 border border-orange-200 text-xs font-bold text-orange-700 shadow-2xs">
                নগদ: <strong>{{ $stats['nagad_count'] ?? 0 }}</strong>
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Navigation Tabs -->
    <div class="border-b border-slate-200 flex items-center gap-2">
        <button type="button" id="tabSettingsBtn" onclick="switchTab('settings')"
                class="px-4 py-2.5 text-xs font-bold border-b-2 border-emerald-600 text-emerald-700 flex items-center gap-2 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>পেমেন্ট গেটওয়ে সেটিংস</span>
        </button>
        <button type="button" id="tabHistoryBtn" onclick="switchTab('history')"
                class="px-4 py-2.5 text-xs font-bold border-b-2 border-transparent text-slate-500 hover:text-slate-800 flex items-center gap-2 transition-all cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>লেনদেন / ট্রানজেকশন হিস্ট্রি ({{ $payments->total() }})</span>
        </button>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 1: PAYMENT GATEWAYS CONFIGURATION SETTINGS                            -->
    <!-- ========================================================================= -->
    <div id="tabSettingsContent" class="space-y-6">
        <form action="{{ route('admin.payments.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Cash on Delivery Gateway -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl">
                            🚚
                        </div>
                        <div>
                            <h3 class="text-sm font-black text-slate-900">ক্যাশ অন ডেলিভারি (Cash on Delivery)</h3>
                            <p class="text-xs text-slate-500 mt-0.5">পণ্য হাতে পাওয়ার পর নগদ টাকায় পেমেন্ট করার ব্যবস্থা।</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="cod_enabled" value="1" {{ ($settings['cod_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                        <span class="ml-2 text-xs font-bold text-slate-700">সক্রিয় রাখুন</span>
                    </label>
                </div>
                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 text-xs text-slate-600 flex items-center gap-2">
                    <span class="text-emerald-600 font-bold text-base">ℹ</span>
                    <span>ক্যাশ অন ডেলিভারি সকল চেকআউটে ডিফল্ট মেথড হিসেবে সিলেক্ট থাকবে।</span>
                </div>
            </div>

            <!-- 2. bKash Gateway -->
            <div class="bg-white rounded-3xl p-6 border-2 border-pink-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-pink-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#E2136E]/10 flex items-center justify-center p-1.5">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                                <rect width="100" height="100" rx="20" fill="#E2136E"/>
                                <path d="M72.2 46.8L51.8 19.3L34.1 36.5L47.5 49.3L27.6 62.4L51.8 77.2L55.4 57.5L72.2 46.8Z" fill="white"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-slate-900">বিকাশ পেমেন্ট (bKash)</h3>
                                <span class="px-2 py-0.5 rounded-full bg-pink-100 text-[#E2136E] text-[10px] font-black uppercase">Send Money / Payment</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">গ্রাহক আপনার বিকাশ নম্বরে টাকা পাঠিয়ে Transaction ID প্রদান করবেন।</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="bkash_enabled" value="1" {{ ($settings['bkash_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E2136E]"></div>
                        <span class="ml-2 text-xs font-bold text-slate-700">সক্রিয় রাখুন</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">বিকাশ মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="bkash_number" value="{{ $settings['bkash_number'] ?? '01734107157' }}" placeholder="যেমন: 01734107157"
                               class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 p-2.5 focus:border-[#E2136E] focus:ring-[#E2136E]">
                        <p class="text-[10px] text-slate-400 mt-1">এই নম্বরটি চেকআউট বিকাশ কার্ডের হেডার ও নির্দেশনা বক্সে প্রদর্শিত হবে।</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">অ্যাকাউন্টের ধরণ (Account Type)</label>
                        <select name="bkash_type" class="w-full text-xs font-bold rounded-xl border-slate-300 p-2.5 focus:border-[#E2136E] focus:ring-[#E2136E]">
                            <option value="Send Money / Cash In" {{ ($settings['bkash_type'] ?? '') === 'Send Money / Cash In' ? 'selected' : '' }}>Personal (Send Money / Cash In)</option>
                            <option value="Send Money" {{ ($settings['bkash_type'] ?? '') === 'Send Money' ? 'selected' : '' }}>Personal (Send Money)</option>
                            <option value="Merchant Payment" {{ ($settings['bkash_type'] ?? '') === 'Merchant Payment' ? 'selected' : '' }}>Merchant (Payment)</option>
                            <option value="Agent Cash In" {{ ($settings['bkash_type'] ?? '') === 'Agent Cash In' ? 'selected' : '' }}>Agent (Cash In)</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">হেডারে নম্বরের সাথে টাইপ শো করবে (যেমন: 017XXXXXXXX-Send Money / Cash In)।</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">বিকাশ বিশেষ নির্দেশনা (ঐচ্ছিক)</label>
                        <input type="text" name="bkash_instructions" value="{{ $settings['bkash_instructions'] ?? 'বিকাশ অ্যাপ বা *২৪৭# দিয়ে উক্ত নম্বরে Send Money করুন এবং নিচের ঘরে আপনার বিকাশ নম্বর ও TrxID লিখুন।' }}"
                               class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                    </div>
                </div>
            </div>

            <!-- 3. Nagad Gateway -->
            <div class="bg-white rounded-3xl p-6 border-2 border-red-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-red-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#E31A22]/10 flex items-center justify-center p-1.5">
                            <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                                <rect width="100" height="100" rx="20" fill="#E31A22"/>
                                <circle cx="50" cy="50" r="28" fill="#F8981D"/>
                                <path d="M50 25C36.2 25 25 36.2 25 50C25 63.8 36.2 75 50 75C63.8 75 75 63.8 75 50" stroke="white" stroke-width="8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-slate-900">নগদ পেমেন্ট (Nagad)</h3>
                                <span class="px-2 py-0.5 rounded-full bg-red-100 text-[#E31A22] text-[10px] font-black uppercase">Send Money / Payment</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">গ্রাহক আপনার নগদ নম্বরে টাকা পাঠিয়ে Transaction ID প্রদান করবেন।</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="nagad_enabled" value="1" {{ ($settings['nagad_enabled'] ?? '1') === '1' ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E31A22]"></div>
                        <span class="ml-2 text-xs font-bold text-slate-700">সক্রিয় রাখুন</span>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">নগদ মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                        <input type="text" name="nagad_number" value="{{ $settings['nagad_number'] ?? '01734107157' }}" placeholder="যেমন: 01734107157"
                               class="w-full text-xs font-mono font-bold rounded-xl border-slate-300 p-2.5 focus:border-[#E31A22] focus:ring-[#E31A22]">
                        <p class="text-[10px] text-slate-400 mt-1">এই নম্বরটি চেকআউট নগদ কার্ডের হেডার ও নির্দেশনা বক্সে প্রদর্শিত হবে।</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">অ্যাকাউন্টের ধরণ (Account Type)</label>
                        <select name="nagad_type" class="w-full text-xs font-bold rounded-xl border-slate-300 p-2.5 focus:border-[#E31A22] focus:ring-[#E31A22]">
                            <option value="Send Money / Cash In" {{ ($settings['nagad_type'] ?? '') === 'Send Money / Cash In' ? 'selected' : '' }}>Personal (Send Money / Cash In)</option>
                            <option value="Send Money" {{ ($settings['nagad_type'] ?? '') === 'Send Money' ? 'selected' : '' }}>Personal (Send Money)</option>
                            <option value="Merchant Payment" {{ ($settings['nagad_type'] ?? '') === 'Merchant Payment' ? 'selected' : '' }}>Merchant (Payment)</option>
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">হেডারে নম্বরের সাথে টাইপ শো করবে।</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">নগদ বিশেষ নির্দেশনা (ঐচ্ছিক)</label>
                        <input type="text" name="nagad_instructions" value="{{ $settings['nagad_instructions'] ?? 'নগদ অ্যাপ বা *১৬৭# দিয়ে উক্ত নম্বরে Send Money করুন এবং নিচের ঘরে আপনার নগদ নম্বর ও TrxID লিখুন।' }}"
                               class="w-full text-xs rounded-xl border-slate-300 p-2.5">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs rounded-2xl shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center gap-2 cursor-pointer active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>পেমেন্ট গেটওয়ে সেটিংস সংরক্ষণ করুন</span>
                </button>
            </div>
        </form>
    </div>

    <!-- ========================================================================= -->
    <!-- TAB 2: PAYMENT TRANSACTIONS HISTORY & VERIFICATION                        -->
    <!-- ========================================================================= -->
    <div id="tabHistoryContent" class="space-y-6 hidden">
        <!-- Search & Filters -->
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-sm">
            <form action="{{ route('admin.payments.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <input type="hidden" name="tab" value="history">

                <div class="sm:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="অর্ডার নম্বর, মোবাইল নম্বর, নাম বা Transaction ID দিয়ে খুঁজুন..."
                           class="w-full text-xs rounded-xl border-slate-300 p-2.5 focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <select name="method" class="w-full text-xs font-bold rounded-xl border-slate-300 p-2.5">
                        <option value="all">সব পেমেন্ট মেথড</option>
                        <option value="bkash" {{ request('method') === 'bkash' ? 'selected' : '' }}>বিকাশ (bKash)</option>
                        <option value="nagad" {{ request('method') === 'nagad' ? 'selected' : '' }}>নগদ (Nagad)</option>
                        <option value="cash_on_delivery" {{ request('method') === 'cash_on_delivery' ? 'selected' : '' }}>ক্যাশ অন ডেলিভারি (COD)</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <select name="status" class="flex-1 text-xs font-bold rounded-xl border-slate-300 p-2.5">
                        <option value="all">সব স্ট্যাটাস</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>পেন্ডিং (Pending)</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>পরিশোধিত (Paid)</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ব্যর্থ (Failed)</option>
                    </select>
                    <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-sm transition-all cursor-pointer">
                        ফিল্টার
                    </button>
                    @if(request()->hasAny(['search', 'method', 'status']))
                    <a href="{{ route('admin.payments.index', ['tab' => 'history']) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all" title="রিসেট">
                        ✕
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                            <th class="py-3.5 px-4">অর্ডার নং</th>
                            <th class="py-3.5 px-4">তারিখ ও সময়</th>
                            <th class="py-3.5 px-4">গ্রাহকের নাম ও ফোন</th>
                            <th class="py-3.5 px-4">পেমেন্ট মেথড</th>
                            <th class="py-3.5 px-4">মোট টাকা</th>
                            <th class="py-3.5 px-4">প্রেরক নম্বর</th>
                            <th class="py-3.5 px-4">Transaction ID (TrxID)</th>
                            <th class="py-3.5 px-4">পেমেন্ট স্ট্যাটাস</th>
                            <th class="py-3.5 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($payments as $p)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.orders.show', $p->id) }}" class="font-mono font-bold text-emerald-600 hover:underline">
                                    {{ $p->order_number }}
                                </a>
                            </td>
                            <td class="py-3 px-4 text-slate-500 whitespace-nowrap">
                                {{ $p->created_at->format('d M, Y') }}<br>
                                <span class="text-[10px] text-slate-400">{{ $p->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <strong class="text-slate-900 block">{{ $p->customer_name }}</strong>
                                <a href="tel:{{ $p->phone }}" class="text-slate-500 hover:text-emerald-600 font-mono text-[11px]">
                                    {{ $p->phone }}
                                </a>
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($p->payment_method === 'bkash')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-pink-100 text-[#E2136E] text-[11px] font-black border border-pink-200">
                                    <span>🌸</span> বিকাশ (bKash)
                                </span>
                                @elseif($p->payment_method === 'nagad')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-[#E31A22] text-[11px] font-black border border-red-200">
                                    <span>🔶</span> নগদ (Nagad)
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-bold border border-emerald-200">
                                    <span>🚚</span> Cash on Delivery
                                </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-black text-slate-900 whitespace-nowrap">
                                ৳ {{ number_format($p->total) }}
                            </td>
                            <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                {{ $p->payment_sender_number ?? '-' }}
                            </td>
                            <td class="py-3 px-4">
                                @if(!empty($p->transaction_id))
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 font-mono font-bold text-slate-900">
                                    <span>{{ $p->transaction_id }}</span>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $p->transaction_id }}'); alert('TrxID কপি করা হয়েছে: {{ $p->transaction_id }}');"
                                            class="text-slate-400 hover:text-emerald-600 cursor-pointer" title="কপি করুন">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                                @else
                                <span class="text-slate-400 italic text-[11px]">N/A</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @if($p->payment_status === 'paid')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-black">
                                    ✓ পরিশোধিত (Paid)
                                </span>
                                @elseif($p->payment_status === 'failed')
                                <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 text-[11px] font-bold">
                                    ✕ ব্যর্থ (Failed)
                                </span>
                                @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-[11px] font-bold">
                                    ⏳ পেন্ডিং (Pending)
                                </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right whitespace-nowrap">
                                <form action="{{ route('admin.payments.status', $p->id) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    @if($p->payment_status !== 'paid')
                                    <input type="hidden" name="payment_status" value="paid">
                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-[11px] font-bold shadow-2xs transition-all cursor-pointer">
                                        Mark Paid
                                    </button>
                                    @else
                                    <input type="hidden" name="payment_status" value="pending">
                                    <button type="submit" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[11px] font-bold transition-all cursor-pointer">
                                        Mark Pending
                                    </button>
                                    @endif
                                    <a href="{{ route('admin.orders.show', $p->id) }}" class="p-1 text-slate-400 hover:text-emerald-600" title="অর্ডার বিস্তারিত">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-8 text-center text-slate-400 text-xs">
                                কোনো লেনদেন বা ট্রানজেকশন রেকর্ড পাওয়া যায়নি।
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($payments->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $payments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchTab(tab) {
        const settingsContent = document.getElementById('tabSettingsContent');
        const historyContent = document.getElementById('tabHistoryContent');
        const settingsBtn = document.getElementById('tabSettingsBtn');
        const historyBtn = document.getElementById('tabHistoryBtn');

        if (tab === 'history') {
            settingsContent.classList.add('hidden');
            historyContent.classList.remove('hidden');

            historyBtn.classList.add('border-emerald-600', 'text-emerald-700');
            historyBtn.classList.remove('border-transparent', 'text-slate-500');

            settingsBtn.classList.remove('border-emerald-600', 'text-emerald-700');
            settingsBtn.classList.add('border-transparent', 'text-slate-500');
        } else {
            historyContent.classList.add('hidden');
            settingsContent.classList.remove('hidden');

            settingsBtn.classList.add('border-emerald-600', 'text-emerald-700');
            settingsBtn.classList.remove('border-transparent', 'text-slate-500');

            historyBtn.classList.remove('border-emerald-600', 'text-emerald-700');
            historyBtn.classList.add('border-transparent', 'text-slate-500');
        }
    }

    // Check URL param ?tab=history
    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'history') {
            switchTab('history');
        }
    });
</script>
@endpush
@endsection
