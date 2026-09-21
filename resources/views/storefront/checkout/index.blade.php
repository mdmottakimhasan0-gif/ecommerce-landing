@extends('layouts.app')

@section('title', 'ক্যাশ অন ডেলিভারি চেকআউট - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6 text-center">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">ক্যাশ অন ডেলিভারি চেকআউট</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            অর্ডার নিশ্চিত করতে আপনার সঠিক নাম, ঠিকানা ও মোবাইল নম্বর দিন। পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।
        </p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
        <strong class="block font-bold">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- Left Column: Customer Details (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">১</span>
                    <span>ডেলিভারি ও কাস্টমার তথ্য</span>
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার পূর্ণ নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="উদাঃ মোঃ রহিম ইসলাম" 
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="উদাঃ 017XXXXXXXX" pattern="^(?:\+?88)?01[3-9]\d{8}$"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">অর্ডার নিশ্চিত করতে এই নম্বরে এসএমএস বা ফোন করা হতে পারে।</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ডেলিভারির সম্পূর্ণ ঠিকানা <span class="text-rose-500">*</span></label>
                    <textarea name="address" rows="3" required placeholder="গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা উল্লেখ করুন" 
                              class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ডেলিভারি এলাকা নির্বাচন করুন <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center justify-between p-3.5 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition-all">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="inside_dhaka" {{ old('delivery_area', 'inside_dhaka') === 'inside_dhaka' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 delivery-area-radio">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">ঢাকা সিটির ভেতরে</span>
                                    <span class="text-[10px] text-slate-500">২৪-৪৮ ঘণ্টায় হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-sm font-black text-emerald-700">৳ {{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                        </label>

                        <label class="flex items-center justify-between p-3.5 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition-all">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="outside_dhaka" {{ old('delivery_area') === 'outside_dhaka' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 delivery-area-radio">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">ঢাকা সিটির বাইরে</span>
                                    <span class="text-[10px] text-slate-500">সারাদেশে হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-sm font-black text-emerald-700">৳ {{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">অর্ডার নোট / বিশেষ নির্দেশনা (ঐচ্ছিক)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="যেমন: শুক্রবারে ডেলিভারি দিলে ভালো হয়" 
                           class="w-full px-4 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Payment Method: Cash on Delivery, bKash, Nagad -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center justify-between border-b border-slate-100 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">২</span>
                        <span>পেমেন্ট পদ্ধতি</span>
                    </div>
                    <span class="text-xs text-slate-400 font-normal">ক্যাশ অন ডেলিভারি অথবা মোবাইল ব্যাংকিং</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Cash on Delivery (Default) -->
                    <label class="relative flex sm:flex-col items-center justify-between sm:justify-center p-3 sm:p-4 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/70 transition-all text-center group">
                        <div class="flex sm:flex-col items-center gap-2 sm:gap-1">
                            <input type="radio" name="payment_method" value="cash_on_delivery" checked class="checkout-payment-radio sr-only">
                            <span class="text-2xl group-hover:scale-110 transition-transform">🚚</span>
                            <div>
                                <span class="text-xs font-black text-slate-800 block">Cash on Delivery</span>
                                <span class="text-[10px] text-emerald-700 font-bold">হাতে পেয়ে দিন</span>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-emerald-700 bg-white px-2 py-0.5 rounded-full border border-emerald-300 sm:hidden">ডিফল্ট</span>
                    </label>

                    <!-- bKash -->
                    <label class="relative flex sm:flex-col items-center justify-between sm:justify-center p-3 sm:p-4 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-[#E2136E] has-[:checked]:border-[#E2136E] has-[:checked]:bg-pink-50/70 transition-all text-center group">
                        <div class="flex sm:flex-col items-center gap-2 sm:gap-1">
                            <input type="radio" name="payment_method" value="bkash" class="checkout-payment-radio sr-only">
                            <div class="w-7 h-7 group-hover:scale-110 transition-transform flex items-center justify-center">
                                <svg viewBox="0 0 100 100" class="w-full h-full" fill="none">
                                    <rect width="100" height="100" rx="20" fill="#E2136E"/>
                                    <path d="M72.2 46.8L51.8 19.3L34.1 36.5L47.5 49.3L27.6 62.4L51.8 77.2L55.4 57.5L72.2 46.8Z" fill="white"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-800 block">bKash</span>
                                <span class="text-[10px] text-pink-700 font-bold">বিকাশ পেমেন্ট</span>
                            </div>
                        </div>
                    </label>

                    <!-- Nagad -->
                    <label class="relative flex sm:flex-col items-center justify-between sm:justify-center p-3 sm:p-4 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-[#E31A22] has-[:checked]:border-[#E31A22] has-[:checked]:bg-red-50/70 transition-all text-center group">
                        <div class="flex sm:flex-col items-center gap-2 sm:gap-1">
                            <input type="radio" name="payment_method" value="nagad" class="checkout-payment-radio sr-only">
                            <div class="w-7 h-7 group-hover:scale-110 transition-transform flex items-center justify-center">
                                <svg viewBox="0 0 100 100" class="w-full h-full" fill="none">
                                    <rect width="100" height="100" rx="20" fill="#E31A22"/>
                                    <circle cx="50" cy="50" r="28" fill="#F8981D"/>
                                    <path d="M50 25C36.2 25 25 36.2 25 50C25 63.8 36.2 75 50 75C63.8 75 75 63.8 75 50" stroke="white" stroke-width="8" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-black text-slate-800 block">Nagad</span>
                                <span class="text-[10px] text-red-700 font-bold">নগদ পেমেন্ট</span>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- bKash Accordion (Full page checkout) -->
                <div id="checkoutBkashAccordion" class="hidden rounded-2xl border-2 border-[#E2136E]/40 bg-white overflow-hidden shadow-md">
                    <div class="bg-[#E2136E] text-white p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center p-1.5 shadow">
                                <svg viewBox="0 0 100 100" class="w-full h-full" fill="none">
                                    <path d="M72.2 46.8L51.8 19.3L34.1 36.5L47.5 49.3L27.6 62.4L51.8 77.2L55.4 57.5L72.2 46.8Z" fill="#E2136E"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs uppercase tracking-wider font-bold text-pink-200 block">{{ $settings['store_name'] ?? 'DemandHat BD' }}</span>
                                <h5 class="text-sm sm:text-base font-mono font-black">{{ $settings['bkash_number'] ?? '01734107157' }}-{{ $settings['bkash_type'] ?? 'Send Money / Cash In' }}</h5>
                            </div>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $settings['bkash_number'] ?? '01734107157' }}'); alert('বিকাশ নম্বর কপি করা হয়েছে!');"
                                class="px-3 py-1.5 rounded-xl bg-white text-[#E2136E] text-xs font-black hover:bg-pink-100 transition-colors shadow flex items-center gap-1 cursor-pointer">
                            <span>কপি নম্বর</span>
                        </button>
                    </div>
                    <div class="p-4 space-y-3 bg-pink-50/40">
                        <p class="text-xs text-pink-950 font-medium">
                            {{ $settings['bkash_instructions'] ?? 'উক্ত বিকাশ নম্বরে মোট টাকা Send Money করে নিচের ঘরে আপনার বিকাশ নম্বর ও Transaction ID দিন।' }}
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">আপনার বিকাশ নম্বর <span class="text-rose-500">*</span></label>
                                <input type="tel" id="checkoutBkashSender" placeholder="e.g. 01XXXXXXXXX"
                                       class="w-full px-3.5 py-2.5 text-xs font-mono border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E2136E] focus:outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Transaction ID (TrxID) <span class="text-rose-500">*</span></label>
                                <input type="text" id="checkoutBkashTrx" placeholder="e.g. 9J4K8L7M2"
                                       class="w-full px-3.5 py-2.5 text-xs font-mono uppercase font-bold border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E2136E] focus:outline-none bg-white">
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-400 text-center pt-1 border-t border-pink-100">
                            Confirm and Process, terms & conditions • © 2025 bKash
                        </div>
                    </div>
                </div>

                <!-- Nagad Accordion (Full page checkout) -->
                <div id="checkoutNagadAccordion" class="hidden rounded-2xl border-2 border-[#E31A22]/40 bg-white overflow-hidden shadow-md">
                    <div class="bg-[#E31A22] text-white p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center p-1.5 shadow">
                                <svg viewBox="0 0 100 100" class="w-full h-full" fill="none">
                                    <circle cx="50" cy="50" r="30" fill="#F8981D"/>
                                    <path d="M50 25C36.2 25 25 36.2 25 50C25 63.8 36.2 75 50 75C63.8 75 75 63.8 75 50" stroke="#E31A22" stroke-width="12" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs uppercase tracking-wider font-bold text-red-200 block">{{ $settings['store_name'] ?? 'DemandHat BD' }}</span>
                                <h5 class="text-sm sm:text-base font-mono font-black">{{ $settings['nagad_number'] ?? '01734107157' }}-{{ $settings['nagad_type'] ?? 'Send Money / Cash In' }}</h5>
                            </div>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $settings['nagad_number'] ?? '01734107157' }}'); alert('নগদ নম্বর কপি করা হয়েছে!');"
                                class="px-3 py-1.5 rounded-xl bg-white text-[#E31A22] text-xs font-black hover:bg-red-100 transition-colors shadow flex items-center gap-1 cursor-pointer">
                            <span>কপি নম্বর</span>
                        </button>
                    </div>
                    <div class="p-4 space-y-3 bg-red-50/40">
                        <p class="text-xs text-red-950 font-medium">
                            {{ $settings['nagad_instructions'] ?? 'উক্ত নগদ নম্বরে মোট টাকা Send Money করে নিচের ঘরে আপনার নগদ নম্বর ও Transaction ID দিন।' }}
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">আপনার নগদ নম্বর <span class="text-rose-500">*</span></label>
                                <input type="tel" id="checkoutNagadSender" placeholder="e.g. 01XXXXXXXXX"
                                       class="w-full px-3.5 py-2.5 text-xs font-mono border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E31A22] focus:outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Transaction ID (TrxID) <span class="text-rose-500">*</span></label>
                                <input type="text" id="checkoutNagadTrx" placeholder="e.g. 9J4K8L7M2"
                                       class="w-full px-3.5 py-2.5 text-xs font-mono uppercase font-bold border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#E31A22] focus:outline-none bg-white">
                            </div>
                        </div>
                        <div class="text-[11px] text-slate-400 text-center pt-1 border-t border-red-100">
                            Confirm and Process, terms & conditions • © 2025 Nagad
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs for full form sync -->
                <input type="hidden" name="payment_sender_number" id="finalPaymentSenderNumber" value="">
                <input type="hidden" name="transaction_id" id="finalPaymentTransactionId" value="">
            </div>
        </div>

        <!-- Right Column: Order Summary (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-5 sticky top-24">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">
                    আপনার অর্ডারের বিবরণ
                </h3>

                <!-- Order items container -->
                <div id="checkoutItemsList" class="space-y-3 max-h-64 overflow-y-auto">
                    @if($buyNowProduct)
                    <!-- Direct Buy Now Product Item -->
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                        <img src="{{ $buyNowProduct->thumbnail }}" alt="{{ $buyNowProduct->name }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate">{{ $buyNowProduct->name }}</h4>
                            <p class="text-xs font-black text-emerald-600 mt-0.5">৳ {{ number_format($buyNowProduct->sale_price) }}</p>
                            <span class="text-[11px] text-slate-500">পরিমাণ: {{ $buyNowQty }} টি</span>
                        </div>
                        <input type="hidden" name="items[0][product_id]" value="{{ $buyNowProduct->id }}">
                        <input type="hidden" name="items[0][quantity]" value="{{ $buyNowQty }}">
                    </div>
                    @else
                    <!-- Injected via JavaScript from CartStore -->
                    <p id="checkoutLoadingNotice" class="text-xs text-slate-500 text-center py-4">শপিং ব্যাগ লোড হচ্ছে...</p>
                    @endif
                </div>

                <!-- Special Offer Promo Badges -->
                <div class="p-3 bg-gradient-to-r from-amber-50 to-emerald-50 dark:from-amber-950/40 dark:to-emerald-950/40 rounded-2xl border border-amber-200/80 dark:border-amber-700/60 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-amber-900 dark:text-amber-300 flex items-center gap-1">
                            <span>🎉</span> <span>স্পেশাল অফার কুপন:</span>
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="applyCheckoutPromo('SAVE100')" class="px-2 py-1 bg-white dark:bg-slate-800 hover:bg-emerald-100 text-emerald-700 dark:text-emerald-400 font-mono font-black text-[11px] rounded-lg border border-emerald-300 dark:border-emerald-700 shadow-2xs transition-all cursor-pointer">SAVE100 (-৳100)</button>
                        <button type="button" onclick="applyCheckoutPromo('OFFER50')" class="px-2 py-1 bg-white dark:bg-slate-800 hover:bg-amber-100 text-amber-700 dark:text-amber-400 font-mono font-black text-[11px] rounded-lg border border-amber-300 dark:border-amber-700 shadow-2xs transition-all cursor-pointer">OFFER50 (-৳50)</button>
                        <button type="button" onclick="applyCheckoutPromo('DEMAND10')" class="px-2 py-1 bg-white dark:bg-slate-800 hover:bg-purple-100 text-purple-700 dark:text-purple-400 font-mono font-black text-[11px] rounded-lg border border-purple-300 dark:border-purple-700 shadow-2xs transition-all cursor-pointer">DEMAND10 (-10%)</button>
                        <button type="button" onclick="applyCheckoutPromo('FREESHIP')" class="px-2 py-1 bg-white dark:bg-slate-800 hover:bg-blue-100 text-blue-700 dark:text-blue-400 font-mono font-black text-[11px] rounded-lg border border-blue-300 dark:border-blue-700 shadow-2xs transition-all cursor-pointer">FREESHIP (ফ্রি ডেলিভারি)</button>
                    </div>
                </div>

                <!-- Promo Code / Voucher Box -->
                <div class="bg-slate-50 dark:bg-slate-800/80 p-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-slate-200">
                        <span class="flex items-center gap-1.5">
                            <span>🎟️</span>
                            <span>প্রোমো কোড / কুপন</span>
                        </span>
                        <span id="checkoutPromoStatus" class="text-[11px] font-bold hidden"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="text" id="checkoutPromoInput" placeholder="যেমন: SAVE100" 
                               class="flex-1 px-3.5 py-2 text-xs font-mono uppercase font-bold border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white dark:bg-slate-900 dark:text-white">
                        <button type="button" onclick="handleCheckoutPromoApply()" 
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-2xs transition-all cursor-pointer">
                            প্রয়োগ
                        </button>
                    </div>
                    <div id="checkoutPromoAppliedBadge" class="hidden flex items-center justify-between bg-emerald-100/70 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-700 px-3 py-1.5 rounded-xl text-xs">
                        <div class="flex items-center gap-1.5 text-emerald-800 dark:text-emerald-200">
                            <span>✓</span>
                            <strong id="checkoutPromoAppliedCode" class="font-mono font-black"></strong>
                            <span id="checkoutPromoAppliedDiscountText" class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400"></span>
                        </div>
                        <button type="button" onclick="removeCheckoutPromo()" class="text-rose-600 hover:text-rose-700 font-bold text-xs cursor-pointer">✕ সরান</button>
                    </div>
                </div>

                <input type="hidden" name="promo_code" id="finalPromoCode" value="">
                <input type="hidden" name="discount_amount" id="finalDiscountAmount" value="0">

                <!-- Price Calculations -->
                <div class="space-y-2.5 pt-4 border-t border-slate-100 text-xs sm:text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>পণ্যের সাবটোটাল:</span>
                        <span id="checkoutSubtotal" class="font-bold text-slate-900">
                            @if($buyNowProduct)
                            ৳ {{ number_format($buyNowProduct->sale_price * $buyNowQty) }}
                            @else
                            ৳ 0
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>ডেলিভারি চার্জ:</span>
                        <span id="checkoutDelivery" class="font-bold text-slate-900">৳ {{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                    </div>
                    <div id="checkoutDiscountRow" class="hidden flex justify-between text-emerald-700 font-bold">
                        <span>প্রোমো ছাড়:</span>
                        <span id="checkoutDiscountAmountDisplay">- ৳ 0</span>
                    </div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-slate-900 pt-3 border-t border-slate-200">
                        <span>সর্বমোট প্রদেয়:</span>
                        <span id="checkoutGrandTotal" class="text-emerald-700">
                            @if($buyNowProduct)
                            ৳ {{ number_format(($buyNowProduct->sale_price * $buyNowQty) + ($settings['delivery_inside_dhaka'] ?? 70)) }}
                            @else
                            ৳ 0
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitOrderBtn" class="w-full py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm sm:text-base rounded-2xl shadow-lg hover:shadow-emerald-500/25 transition-all flex items-center justify-center gap-2">
                    <span>অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি)</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

                <div class="text-center text-[11px] text-slate-400 space-y-1">
                    <p>🔒 আপনার সকল তথ্য সম্পূর্ণ সুরক্ষিত থাকবে।</p>
                    <p>পণ্য হাতে পেয়ে চেক করে নেওয়ার শতভাগ নিশ্চয়তা।</p>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isBuyNow = {{ $buyNowProduct ? 'true' : 'false' }};
    const buyNowPrice = {{ $buyNowProduct ? $buyNowProduct->sale_price : 0 }};
    const buyNowQty = {{ $buyNowQty }};
    const insideCharge = {{ $settings['delivery_inside_dhaka'] ?? 70 }};
    const outsideCharge = {{ $settings['delivery_outside_dhaka'] ?? 130 }};

    const checkoutItemsList = document.getElementById('checkoutItemsList');
    const checkoutSubtotal = document.getElementById('checkoutSubtotal');
    const checkoutDelivery = document.getElementById('checkoutDelivery');
    const checkoutGrandTotal = document.getElementById('checkoutGrandTotal');
    const form = document.getElementById('checkoutForm');

    let currentPromoCode = '';
    let currentDiscount = 0;
    let currentSubtotal = isBuyNow ? (buyNowPrice * buyNowQty) : 0;

    const getShippingFee = () => {
        const isOutside = document.querySelector('.delivery-area-radio[value="outside_dhaka"]:checked') !== null;
        return isOutside ? outsideCharge : insideCharge;
    };

    const updateTotals = (subtotal) => {
        currentSubtotal = subtotal;
        const shipping = getShippingFee();
        
        // Calculate promo discount
        let discount = 0;
        if (currentPromoCode === 'SAVE100') {
            discount = Math.min(100, subtotal);
        } else if (currentPromoCode === 'OFFER50') {
            discount = Math.min(50, subtotal);
        } else if (currentPromoCode === 'DEMAND10') {
            discount = Math.round(subtotal * 0.10);
        } else if (currentPromoCode === 'FREESHIP') {
            discount = shipping;
        }
        currentDiscount = discount;

        const grandTotal = Math.max(0, (subtotal + shipping) - discount);

        if (checkoutSubtotal) checkoutSubtotal.textContent = `৳ ${subtotal.toLocaleString('en-US')}`;
        if (checkoutDelivery) checkoutDelivery.textContent = `৳ ${shipping.toLocaleString('en-US')}`;
        
        const discRow = document.getElementById('checkoutDiscountRow');
        const discDisplay = document.getElementById('checkoutDiscountAmountDisplay');
        const finalPromo = document.getElementById('finalPromoCode');
        const finalDisc = document.getElementById('finalDiscountAmount');

        if (discRow && discDisplay) {
            if (discount > 0) {
                discRow.classList.remove('hidden');
                discDisplay.textContent = `- ৳ ${discount.toLocaleString('en-US')}`;
            } else {
                discRow.classList.add('hidden');
            }
        }

        if (finalPromo) finalPromo.value = currentPromoCode;
        if (finalDisc) finalDisc.value = currentDiscount;

        if (checkoutGrandTotal) checkoutGrandTotal.textContent = `৳ ${grandTotal.toLocaleString('en-US')}`;
    };

    window.applyCheckoutPromo = (code) => {
        const input = document.getElementById('checkoutPromoInput');
        if (input) input.value = code;
        window.handleCheckoutPromoApply();
    };

    window.handleCheckoutPromoApply = () => {
        const input = document.getElementById('checkoutPromoInput');
        const status = document.getElementById('checkoutPromoStatus');
        const badge = document.getElementById('checkoutPromoAppliedBadge');
        const codeEl = document.getElementById('checkoutPromoAppliedCode');
        const textEl = document.getElementById('checkoutPromoAppliedDiscountText');

        const code = input?.value.trim().toUpperCase();
        if (!code) {
            if (status) {
                status.textContent = 'কুপন কোড লিখুন';
                status.className = 'text-[11px] font-bold text-rose-500';
                status.classList.remove('hidden');
            }
            return;
        }

        const valid = {
            'SAVE100': '৳১০০ ছাড়',
            'OFFER50': '৳৫০ ছাড়',
            'DEMAND10': '১০% ছাড়',
            'FREESHIP': 'ফ্রি ডেলিভারি'
        };

        if (valid[code]) {
            currentPromoCode = code;
            if (badge) badge.classList.remove('hidden');
            if (codeEl) codeEl.textContent = code;
            if (textEl) textEl.textContent = `(${valid[code]})`;
            if (status) {
                status.textContent = 'সফলভাবে প্রয়োগ হয়েছে!';
                status.className = 'text-[11px] font-bold text-emerald-600';
                status.classList.remove('hidden');
            }
            updateTotals(currentSubtotal);
        } else {
            if (status) {
                status.textContent = 'অকার্যকর প্রোমো কোড!';
                status.className = 'text-[11px] font-bold text-rose-500';
                status.classList.remove('hidden');
            }
        }
    };

    window.removeCheckoutPromo = () => {
        currentPromoCode = '';
        currentDiscount = 0;
        const input = document.getElementById('checkoutPromoInput');
        const status = document.getElementById('checkoutPromoStatus');
        const badge = document.getElementById('checkoutPromoAppliedBadge');
        if (input) input.value = '';
        if (badge) badge.classList.add('hidden');
        if (status) status.classList.add('hidden');
        updateTotals(currentSubtotal);
    };

    if (isBuyNow) {
        document.querySelectorAll('.delivery-area-radio').forEach(r => {
            r.addEventListener('change', () => {
                updateTotals(buyNowPrice * buyNowQty);
            });
        });
    } else {
        // Load items from window.cartStore
        const cartItems = window.cartStore ? window.cartStore.items : [];
        if (cartItems.length === 0) {
            checkoutItemsList.innerHTML = `
                <div class="text-center py-6 text-slate-400 space-y-2">
                    <p class="text-xs">আপনার শপিং ব্যাগে কোনো পণ্য নেই।</p>
                    <a href="{{ route('products.index') }}" class="inline-block text-xs font-bold text-emerald-600 underline">পণ্য পছন্দ করতে ক্লিক করুন</a>
                </div>
            `;
            document.getElementById('submitOrderBtn').disabled = true;
            document.getElementById('submitOrderBtn').classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            checkoutItemsList.innerHTML = '';
            cartItems.forEach((item, index) => {
                const el = document.createElement('div');
                el.className = 'flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200';
                el.innerHTML = `
                    <img src="${item.thumbnail || 'https://via.placeholder.com/80'}" class="w-12 h-12 object-cover rounded-xl border border-slate-200" alt="${item.name}">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-slate-900 truncate">${item.name}</h4>
                        <p class="text-xs font-black text-emerald-600 mt-0.5">৳ ${(item.price * item.quantity).toLocaleString('en-US')}</p>
                        <span class="text-[10px] text-slate-500">পরিমাণ: ${item.quantity} টি</span>
                    </div>
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                `;
                checkoutItemsList.appendChild(el);
            });

            const sub = window.cartStore.getSubtotal();
            updateTotals(sub);

            document.querySelectorAll('.delivery-area-radio').forEach(r => {
                r.addEventListener('change', () => {
                    updateTotals(window.cartStore.getSubtotal());
                });
            });
        }
    }

    // Payment method accordion toggling
    const paymentRadios = document.querySelectorAll('.checkout-payment-radio');
    const bkashAccordion = document.getElementById('checkoutBkashAccordion');
    const nagadAccordion = document.getElementById('checkoutNagadAccordion');
    const submitBtn = document.getElementById('submitOrderBtn');
    const finalSender = document.getElementById('finalPaymentSenderNumber');
    const finalTrx = document.getElementById('finalPaymentTransactionId');

    const handlePaymentChange = () => {
        const selected = document.querySelector('.checkout-payment-radio:checked')?.value || 'cash_on_delivery';
        if (selected === 'bkash') {
            bkashAccordion?.classList.remove('hidden');
            nagadAccordion?.classList.add('hidden');
            if (submitBtn) submitBtn.querySelector('span').textContent = 'বিকাশ পেমেন্ট ও অর্ডার নিশ্চিত করুন 🌸';
        } else if (selected === 'nagad') {
            nagadAccordion?.classList.remove('hidden');
            bkashAccordion?.classList.add('hidden');
            if (submitBtn) submitBtn.querySelector('span').textContent = 'নগদ পেমেন্ট ও অর্ডার নিশ্চিত করুন 🔶';
        } else {
            bkashAccordion?.classList.add('hidden');
            nagadAccordion?.classList.add('hidden');
            if (submitBtn) submitBtn.querySelector('span').textContent = 'অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি)';
        }
    };

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', handlePaymentChange);
    });

    form.addEventListener('submit', (e) => {
        const selectedMethod = document.querySelector('.checkout-payment-radio:checked')?.value || 'cash_on_delivery';
        if (selectedMethod === 'bkash') {
            const sender = document.getElementById('checkoutBkashSender')?.value.trim();
            const trx = document.getElementById('checkoutBkashTrx')?.value.trim();
            if (!sender) {
                alert('অনুগ্রহ করে আপনার বিকাশ মোবাইল নম্বরটি লিখুন।');
                document.getElementById('checkoutBkashSender')?.focus();
                e.preventDefault();
                return;
            }
            if (!trx) {
                alert('অনুগ্রহ করে বিকাশের Transaction ID (TrxID) টি লিখুন।');
                document.getElementById('checkoutBkashTrx')?.focus();
                e.preventDefault();
                return;
            }
            finalSender.value = sender;
            finalTrx.value = trx;
        } else if (selectedMethod === 'nagad') {
            const sender = document.getElementById('checkoutNagadSender')?.value.trim();
            const trx = document.getElementById('checkoutNagadTrx')?.value.trim();
            if (!sender) {
                alert('অনুগ্রহ করে আপনার নগদ মোবাইল নম্বরটি লিখুন।');
                document.getElementById('checkoutNagadSender')?.focus();
                e.preventDefault();
                return;
            }
            if (!trx) {
                alert('অনুগ্রহ করে নগদের Transaction ID (TrxID) টি লিখুন।');
                document.getElementById('checkoutNagadTrx')?.focus();
                e.preventDefault();
                return;
            }
            finalSender.value = sender;
            finalTrx.value = trx;
        }

        // Clear local storage cart upon order submission
        if (!isBuyNow && window.cartStore) {
            window.cartStore.clear();
        }
    });
});
</script>
@endpush
