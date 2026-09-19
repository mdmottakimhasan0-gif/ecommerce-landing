@extends('admin.layout')

@section('title', 'অর্ডার বিবরণ #' . $order->order_number . ' - এডমিন প্যানেল')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-black text-slate-900 font-mono">{{ $order->order_number }}</h1>
                @if($order->status === 'delivered')
                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">ডেলিভার্ড</span>
                @elseif($order->status === 'shipped')
                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">কুরিয়ারে</span>
                @elseif($order->status === 'processing')
                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">প্রসেসিং</span>
                @elseif($order->status === 'cancelled')
                <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">বাতিল</span>
                @else
                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 text-xs font-bold">অপেক্ষমাণ</span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">অর্ডার তৈরির তারিখ: {{ $order->created_at->format('d M, Y - h:i A') }}</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <!-- 1. Dedicated Print Invoice (No headers, clean cash memo) -->
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" 
               class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer"
               title="ক্লিন ইনভয়েস / ক্যাশ মেমো প্রিন্ট করুন">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>ইনভয়েস প্রিন্ট</span>
            </a>

            <!-- 2. Dedicated Print Courier Sticker (Standard thermal 4x6 parcel label) -->
            <a href="{{ route('admin.orders.sticker', $order->id) }}" target="_blank" 
               class="px-3.5 py-2 bg-purple-600 hover:bg-purple-700 active:scale-95 text-white text-xs font-bold rounded-xl transition-all shadow-xs flex items-center gap-1.5 cursor-pointer"
               title="কুরিয়ার পার্সেল ডেলিভারি স্টিকার প্রিন্ট করুন">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                <span>ডেলিভারি স্টিকার</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="px-3.5 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-colors">
                ← সব অর্ডার
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm no-print">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Quick Status Update Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
        <div>
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">ডেলিভারি স্ট্যাটাস পরিবর্তন করুন</h3>
            <p class="text-xs text-slate-500 mt-0.5">কুরিয়ারে দেওয়া হলে বা ডেলিভারি সম্পন্ন হলে স্ট্যাটাস পরিবর্তন করুন</p>
        </div>

        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <select name="status" class="text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>অপেক্ষমাণ (Pending)</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>প্রসেসিং (Processing)</option>
                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>কুরিয়ারে হস্তান্তর (Shipped)</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>ডেলিভারি সম্পন্ন (Delivered)</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>অর্ডার বাতিল (Cancelled)</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition-colors cursor-pointer active:scale-95">
                আপডেট
            </button>
        </form>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Customer Info with One-Click Call Button, Fraud Checker, and Edit Info/Area Button -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
                    <span>👤</span> গ্রাহকের তথ্য
                </h3>
                <button type="button" onclick="openCustomerEditModal()" 
                        class="no-print inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-lg text-xs font-bold transition-all cursor-pointer active:scale-95 shadow-2xs"
                        title="গ্রাহকের নাম, ফোন, ঠিকানা ও ডেলিভারি এলাকা পরিবর্তন করুন">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>তথ্য ও এলাকা এডিট</span>
                </button>
            </div>
            <div class="text-xs space-y-2.5">
                <div>
                    <span class="text-slate-500 block">নাম:</span>
                    <strong class="text-slate-900 text-sm">{{ $order->customer_name }}</strong>
                </div>

                <!-- Phone with Call & Fraud Checker Action Buttons -->
                <div>
                    <span class="text-slate-500 block mb-1">মোবাইল নম্বর:</span>
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="tel:{{ $order->phone }}" class="text-emerald-700 text-sm font-mono font-black hover:underline mr-1">
                            {{ $order->phone }}
                        </a>

                        <!-- Direct Call Button -->
                        <a href="tel:{{ $order->phone }}" 
                           class="no-print inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all active:scale-95 cursor-pointer"
                           title="গ্রাহককে সরাসরি ফোন কল করুন">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>কল করুন</span>
                        </a>

                        <!-- BD Courier Fraud Checker Button -->
                        <button type="button" onclick="openFraudChecker('{{ $order->phone }}')" 
                                class="no-print inline-flex items-center gap-1 px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all active:scale-95 cursor-pointer"
                                title="বিডি কুরিয়ার ফ্রড ইন্টেলিজেন্স ও ডেলিভারি হিস্ট্রি চেক করুন">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>ফ্রড চেকার</span>
                        </button>
                    </div>
                </div>

                <div>
                    <span class="text-slate-500 block">ডেলিভারি ঠিকানা:</span>
                    <span class="text-slate-800 leading-relaxed block">{{ $order->address }}</span>
                </div>
                <div>
                    <span class="text-slate-500 block">ডেলিভারি এলাকা ও চার্জ:</span>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        @if($order->delivery_area === 'inside_dhaka')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            ঢাকা সিটি (চার্জ: ৳{{ number_format($order->delivery_charge) }})
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            ঢাকার বাইরে (চার্জ: ৳{{ number_format($order->delivery_charge) }})
                        </span>
                        @endif

                        <button type="button" onclick="openCustomerEditModal()" 
                                class="no-print inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 underline cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            <span>এলাকা পরিবর্তন</span>
                        </button>
                    </div>
                </div>
                @if($order->notes)
                <div class="pt-2 border-t border-slate-100">
                    <span class="text-slate-500 block">গ্রাহকের নোট:</span>
                    <p class="text-slate-700 italic bg-slate-50 p-2 rounded-lg mt-0.5">"{{ $order->notes }}"</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Order Source & Payment Info -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                <h3 class="text-sm font-bold text-slate-900">পেমেন্ট ও অর্ডারের উৎস</h3>
                @if($order->payment_status === 'paid')
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase">
                    ✓ Paid
                </span>
                @else
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-black uppercase">
                    ⏳ Payment Pending
                </span>
                @endif
            </div>

            <div class="text-xs space-y-3">
                <div>
                    <span class="text-slate-500 block mb-1">পেমেন্ট পদ্ধতি:</span>
                    @if($order->payment_method === 'bkash')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-pink-50 text-[#E2136E] border border-pink-200 rounded-xl font-black text-xs">
                        <span>🌸</span> বিকাশ পেমেন্ট (bKash)
                    </span>
                    @elseif($order->payment_method === 'nagad')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-[#E31A22] border border-red-200 rounded-xl font-black text-xs">
                        <span>🔶</span> নগদ পেমেন্ট (Nagad)
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-xl font-bold text-xs">
                        <span>🚚</span> ক্যাশ অন ডেলিভারি (Cash on Delivery)
                    </span>
                    @endif
                </div>

                @if($order->payment_sender_number || $order->transaction_id)
                <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                    @if($order->payment_sender_number)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">গ্রাহকের প্রেরক নম্বর:</span>
                        <a href="tel:{{ $order->payment_sender_number }}" class="font-mono font-bold text-slate-900 hover:text-emerald-600">
                            {{ $order->payment_sender_number }}
                        </a>
                    </div>
                    @endif

                    @if($order->transaction_id)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Transaction ID (TrxID):</span>
                        <div class="inline-flex items-center gap-1 bg-white px-2 py-1 rounded-lg border border-slate-300 font-mono font-black text-slate-900 text-xs">
                            <span>{{ $order->transaction_id }}</span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $order->transaction_id }}'); alert('TrxID কপি করা হয়েছে: {{ $order->transaction_id }}');" 
                                    class="text-slate-400 hover:text-emerald-600 cursor-pointer ml-1" title="কপি করুন">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-slate-500">পেমেন্ট ভেরিফিকেশন:</span>
                        <form action="{{ route('admin.payments.status', $order->id) }}" method="POST">
                            @csrf
                            @if($order->payment_status !== 'paid')
                            <input type="hidden" name="payment_status" value="paid">
                            <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all cursor-pointer">
                                Mark as Paid ✓
                            </button>
                            @else
                            <input type="hidden" name="payment_status" value="pending">
                            <button type="submit" class="px-3 py-1 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold transition-all cursor-pointer">
                                Revert to Pending
                            </button>
                            @endif
                        </form>
                    </div>
                </div>
                @endif

                <div>
                    <span class="text-slate-500 block">অর্ডারের উৎস (Source):</span>
                    @if($order->landingPage)
                    <div class="mt-1 p-2.5 bg-purple-50 rounded-xl border border-purple-200">
                        <span class="text-purple-900 font-bold block text-xs">🚀 ল্যান্ডিং পেজ: {{ $order->landingPage->name }}</span>
                        <a href="{{ url('/' . $order->landingPage->slug) }}" target="_blank" class="text-purple-600 hover:underline text-[11px] block mt-0.5">
                            ইউআরএল: /{{ $order->landingPage->slug }} ↗
                        </a>
                    </div>
                    @else
                    <span class="text-slate-700 font-medium">সাধারণ অনলাইন স্টোর</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- COURIER PARCEL BOOKING SECTION (Steadfast, Pathao, RedX, Carrybee)         -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4 no-print">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                    <span>📦</span> কুরিয়ার পার্সেল বুকিং (Courier Parcel Booking)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Steadfast, Pathao, RedX বা Carrybee এ এক ক্লিকে পার্সেল সাবমিট ও কনসাইনমেন্ট তৈরি করুন</p>
            </div>
            
            @if($order->courier_consignment_id)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                পার্সেল বুকড ({{ ucfirst($order->courier_name) }})
            </span>
            @endif
        </div>

        @if($order->courier_consignment_id)
        <!-- Booked Consignment Snapshot -->
        <div class="p-4 bg-emerald-50/70 border border-emerald-200 rounded-2xl space-y-3">
            <!-- Top Row: Courier Header, Status Badge & Compact Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-2.5 border-b border-emerald-200/70">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-slate-600 text-xs">কুরিয়ার:</span>
                    <span class="uppercase font-black text-emerald-800 text-xs px-2.5 py-0.5 bg-white rounded-lg border border-emerald-300 shadow-2xs">
                        {{ $order->courier_name }} Courier
                    </span>
                    
                    <!-- Live Status Badge -->
                    <span id="orderCourierStatusBadge" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold border shadow-2xs {{ $order->courier_status_badge_class }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                        <span id="orderCourierStatusText">{{ $order->courier_status_label }}</span>
                    </span>
                </div>

                <!-- Compact Action Buttons (Small, Clean, Non-overlapping) -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <!-- Sync Live Status Button (Small) -->
                    <button type="button" 
                            id="btnSyncCourier"
                            onclick="syncLiveCourierStatus({{ $order->id }})" 
                            class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white rounded-lg text-[11px] font-bold shadow-xs transition-all flex items-center gap-1 cursor-pointer"
                            title="Steadfast থেকে লাইভ স্ট্যাটাস আপডেট করুন">
                        <svg id="syncIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span id="syncText">লাইভ আপডেট</span>
                    </button>

                    @if($order->courier_tracking_link)
                    <!-- Direct Tracking Link Button (Small) -->
                    <a href="{{ $order->courier_tracking_link }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="px-2.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white rounded-lg text-[11px] font-bold shadow-xs transition-all flex items-center gap-1 cursor-pointer"
                       title="Steadfast অফিসিয়াল ট্র্যাকিং পেজ দেখুন">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>ট্র্যাকিং দেখুন ↗</span>
                    </a>
                    @endif

                    <!-- Courier Settings Button (Small) -->
                    <a href="{{ route('admin.couriers.index') }}" 
                       class="px-2.5 py-1.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 rounded-lg text-[11px] font-bold transition-colors shadow-2xs flex items-center gap-1">
                        <span>সেটিংস ⚙️</span>
                    </a>
                </div>
            </div>

            <!-- Bottom Row: 4 Clean Metrics (Consignment, Tracking, Booking time, Synced time) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2 text-xs pt-1">
                <div class="bg-white/80 p-2 rounded-xl border border-emerald-200/80">
                    <span class="text-[10px] text-slate-400 block">কনসাইনমেন্ট আইডি:</span>
                    <strong class="font-mono text-slate-900 text-xs select-all block truncate">{{ $order->courier_consignment_id }}</strong>
                </div>
                <div class="bg-white/80 p-2 rounded-xl border border-emerald-200/80">
                    <span class="text-[10px] text-slate-400 block">ট্র্যাকিং কোড:</span>
                    <strong class="font-mono text-slate-900 text-xs select-all block truncate">{{ $order->courier_tracking_code }}</strong>
                </div>
                <div class="bg-white/80 p-2 rounded-xl border border-emerald-200/80">
                    <span class="text-[10px] text-slate-400 block">📅 বুকিং সময়:</span>
                    <span class="text-slate-700 text-[11px] font-medium block truncate">
                        {{ $order->courier_booked_at ? $order->courier_booked_at->format('d M, Y - h:i A') : '-' }}
                    </span>
                </div>
                <div class="bg-white/80 p-2 rounded-xl border border-emerald-200/80">
                    <span class="text-[10px] text-slate-400 block">🔄 সর্বশেষ সিঙ্ক:</span>
                    <span id="orderCourierSyncedAt" class="text-slate-700 text-[11px] font-bold block truncate">
                        {{ $order->courier_last_synced_at ? $order->courier_last_synced_at->diffForHumans() : 'এখনও সিঙ্ক হয়নি' }}
                    </span>
                </div>
            </div>
        </div>
        @else
        <!-- Parcel Booking Form -->
        <form action="{{ route('admin.orders.bookCourier', $order->id) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">কুরিয়ার নির্বাচন করুন <span class="text-rose-500">*</span></label>
                    <select name="courier" required class="w-full text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                        <option value="steadfast">Steadfast Courier (অটোমেটেড)</option>
                        <option value="pathao">Pathao Courier</option>
                        <option value="redx">RedX Courier</option>
                        <option value="carrybee">Carrybee Courier</option>
                        <option value="paperfly">Paperfly Courier</option>
                        <option value="parceldex">Parceldex Courier</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ক্যাশ অন ডেলিভারি (COD) টাকা</label>
                    <input type="number" name="cod_amount" value="{{ (int)$order->total }}" required 
                           class="w-full text-xs font-bold bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ডেলিভারি নোট / পণ্যের বিবরণ</label>
                    <input type="text" name="note" value="Order #{{ $order->order_number }} - DemandHat BD" 
                           class="w-full text-xs bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between text-xs gap-3">
                <div class="text-slate-600 space-y-0.5">
                    <div>প্রাপক: <strong>{{ $order->customer_name }}</strong> ({{ $order->phone }})</div>
                    <div class="text-[11px] text-slate-500 truncate max-w-lg">ঠিকানা: {{ $order->address }}</div>
                </div>
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-1.5 cursor-pointer active:scale-95 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span>কুরিয়ারে পার্সেল বুক করুন</span>
                </button>
            </div>
        </form>
        @endif
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 space-y-4">
        <h3 class="text-sm font-bold text-slate-900">অর্ডারকৃত পণ্যসমূহ</h3>
        <table class="w-full text-xs text-left">
            <thead class="bg-slate-50 text-slate-700 font-bold border-y border-slate-200">
                <tr>
                    <th class="py-2.5 px-3">পণ্য</th>
                    <th class="py-2.5 px-3 text-center">পরিমাণ</th>
                    <th class="py-2.5 px-3 text-right">ইউনিট মূল্য</th>
                    <th class="py-2.5 px-3 text-right">মোট টাকা</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                <tr>
                    <td class="py-3 px-3 flex items-center gap-3">
                        @if($item->product && $item->product->thumbnail)
                        <img src="{{ $item->product->thumbnail }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200" alt="">
                        @endif
                        <span class="font-bold text-slate-900">{{ $item->product_name }}</span>
                    </td>
                    <td class="py-3 px-3 text-center font-bold text-slate-700">{{ $item->quantity }}</td>
                    <td class="py-3 px-3 text-right text-slate-600">৳ {{ number_format($item->price) }}</td>
                    <td class="py-3 px-3 text-right font-black text-slate-900">৳ {{ number_format($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-slate-200">
                <tr>
                    <td colspan="3" class="pt-3 px-3 text-right text-slate-600">সাবটোটাল:</td>
                    <td class="pt-3 px-3 text-right font-bold text-slate-800">৳ {{ number_format($order->subtotal) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="py-1 px-3 text-right text-slate-600">ডেলিভারি চার্জ:</td>
                    <td class="py-1 px-3 text-right font-bold text-slate-800">৳ {{ number_format($order->delivery_charge) }}</td>
                </tr>
                <tr class="text-sm font-black">
                    <td colspan="3" class="pt-2 px-3 text-right text-slate-900">সর্বমোট প্রদেয়:</td>
                    <td class="pt-2 px-3 text-right text-emerald-700 text-base">৳ {{ number_format($order->total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</div>

<!-- Customer Info & Delivery Area Edit Modal -->
<div id="customerEditModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop with blur -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" onclick="closeCustomerEditModal()"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-100 z-10">
            
            <!-- Modal Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="p-2 bg-emerald-500/20 text-emerald-400 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-sm font-black tracking-wide" id="modal-title">গ্রাহকের তথ্য ও ডেলিভারি এলাকা এডিট</h3>
                        <p class="text-[11px] text-slate-300">এলাকা পরিবর্তনের সাথে সাথে ডেলিভারি চার্জ ও মোট মূল্য স্বয়ংক্রিয়ভাবে হিসাব হবে</p>
                    </div>
                </div>
                <button type="button" onclick="closeCustomerEditModal()" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-slate-700/50 cursor-pointer transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Form -->
            <form action="{{ route('admin.orders.updateDetails', $order->id) }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="status" value="{{ $order->status }}">
                <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                <input type="hidden" name="subtotal" id="modal_subtotal" value="{{ $order->subtotal }}">

                <!-- Customer Name -->
                <div>
                    <label for="edit_customer_name" class="block text-xs font-bold text-slate-700 mb-1">
                        গ্রাহকের নাম <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="customer_name" id="edit_customer_name" value="{{ $order->customer_name }}" required
                           class="w-full text-xs font-medium bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white transition-all">
                </div>

                <!-- Customer Phone -->
                <div>
                    <label for="edit_phone" class="block text-xs font-bold text-slate-700 mb-1">
                        মোবাইল নম্বর <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="phone" id="edit_phone" value="{{ $order->phone }}" required
                           class="w-full text-xs font-mono font-bold bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white transition-all">
                </div>

                <!-- Customer Address -->
                <div>
                    <label for="edit_address" class="block text-xs font-bold text-slate-700 mb-1">
                        সম্পূর্ণ ডেলিভারি ঠিকানা <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="address" id="edit_address" rows="2" required
                              class="w-full text-xs font-medium bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white transition-all leading-relaxed">{{ $order->address }}</textarea>
                </div>

                <!-- Delivery Area Selection (Matches user's screenshot) -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-bold text-slate-700">
                            ডেলিভারি এলাকা <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[11px] text-emerald-600 font-bold">সিলেক্ট করলে চার্জ অটো সেট হবে</span>
                    </div>

                    @php
                        $insideDhakaFee = (float)($settings['delivery_inside_dhaka'] ?? 70);
                        $outsideDhakaFee = (float)($settings['delivery_outside_dhaka'] ?? 130);
                        $currentArea = $order->delivery_area ?: 'inside_dhaka';
                    @endphp

                    <div class="grid grid-cols-2 gap-3">
                        <!-- Inside Dhaka -->
                        <label id="areaCardInside" 
                               class="relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all {{ $currentArea === 'inside_dhaka' ? 'border-emerald-500 bg-emerald-50/60 shadow-xs ring-1 ring-emerald-500/30' : 'border-slate-200 bg-slate-50/60 hover:border-slate-300' }}">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="inside_dhaka" 
                                       {{ $currentArea === 'inside_dhaka' ? 'checked' : '' }}
                                       onchange="onDeliveryAreaSelect('inside_dhaka', {{ $insideDhakaFee }})"
                                       class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                <div>
                                    <div class="text-xs font-black text-slate-900">Inside Dhaka City</div>
                                    <div class="text-[10px] text-slate-500">ঢাকা সিটিতে</div>
                                </div>
                            </div>
                            <span class="text-xs font-black px-2 py-0.5 rounded-lg bg-emerald-100 text-emerald-800">৳{{ number_format($insideDhakaFee) }}</span>
                        </label>

                        <!-- Outside Dhaka -->
                        <label id="areaCardOutside" 
                               class="relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all {{ $currentArea === 'outside_dhaka' ? 'border-emerald-500 bg-emerald-50/60 shadow-xs ring-1 ring-emerald-500/30' : 'border-slate-200 bg-slate-50/60 hover:border-slate-300' }}">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="outside_dhaka" 
                                       {{ $currentArea === 'outside_dhaka' ? 'checked' : '' }}
                                       onchange="onDeliveryAreaSelect('outside_dhaka', {{ $outsideDhakaFee }})"
                                       class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                                <div>
                                    <div class="text-xs font-black text-slate-900">Outside Dhaka</div>
                                    <div class="text-[10px] text-slate-500">ঢাকার বাইরে সারাদেশে</div>
                                </div>
                            </div>
                            <span class="text-xs font-black px-2 py-0.5 rounded-lg bg-blue-100 text-blue-800">৳{{ number_format($outsideDhakaFee) }}</span>
                        </label>
                    </div>
                </div>

                <!-- Delivery Charge Editable Input -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="edit_delivery_charge" class="text-xs font-bold text-slate-700">
                            ডেলিভারি চার্জ (টাকা) <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[10px] text-slate-400">প্রয়োজনে কাস্টম ডেলিভারি চার্জ লিখতে পারেন</span>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3.5 top-2.5 text-slate-400 font-bold text-xs">৳</span>
                        <input type="number" name="delivery_charge" id="edit_delivery_charge" 
                               value="{{ (int)$order->delivery_charge }}" 
                               oninput="updateModalTotals()"
                               step="1" min="0" required
                               class="w-full pl-8 pr-3 text-xs font-mono font-bold bg-slate-50 border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Optional Order Notes -->
                <div>
                    <label for="edit_notes" class="block text-xs font-bold text-slate-700 mb-1">অর্ডার নোট (ঐচ্ছিক)</label>
                    <input type="text" name="notes" id="edit_notes" value="{{ $order->notes }}" 
                           placeholder="যেমন: দ্রুত ডেলিভারি দিতে হবে"
                           class="w-full text-xs bg-slate-50 border border-slate-300 rounded-xl p-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:bg-white transition-all">
                </div>

                <!-- Real-time Bill Calculation Breakdown -->
                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-2xl space-y-2 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span>পণ্য সাবটোটাল:</span>
                        <span class="font-mono font-bold text-slate-800">৳ {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>ডেলিভারি চার্জ:</span>
                        <span class="font-mono font-bold text-slate-800" id="modalCalcChargeText">(+) ৳ {{ number_format($order->delivery_charge) }}</span>
                    </div>
                    <div class="pt-2 border-t border-slate-200 flex items-center justify-between font-black text-sm">
                        <span class="text-slate-900">সর্বমোট প্রদেয় বিল (Total):</span>
                        <span class="text-emerald-700 font-mono text-base" id="modalCalcTotalText">৳ {{ number_format($order->total) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                    <button type="button" onclick="closeCustomerEditModal()" 
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all cursor-pointer">
                        বাতিল
                    </button>
                    <button type="submit" 
                            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>আপডেট সংরক্ষণ করুন</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reusable Fraud Detection Intelligence Modal -->
@include('admin.orders._fraud_modal')

@push('scripts')
<script>
    // Customer Info & Delivery Area Modal Functions
    function openCustomerEditModal() {
        const modal = document.getElementById('customerEditModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            updateModalTotals();
        }
    }

    function closeCustomerEditModal() {
        const modal = document.getElementById('customerEditModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function onDeliveryAreaSelect(area, fee) {
        const chargeInput = document.getElementById('edit_delivery_charge');
        if (chargeInput) {
            chargeInput.value = fee;
        }

        const cardInside = document.getElementById('areaCardInside');
        const cardOutside = document.getElementById('areaCardOutside');

        if (area === 'inside_dhaka') {
            if (cardInside) {
                cardInside.className = 'relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all border-emerald-500 bg-emerald-50/60 shadow-xs ring-1 ring-emerald-500/30';
            }
            if (cardOutside) {
                cardOutside.className = 'relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all border-slate-200 bg-slate-50/60 hover:border-slate-300';
            }
        } else {
            if (cardOutside) {
                cardOutside.className = 'relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all border-emerald-500 bg-emerald-50/60 shadow-xs ring-1 ring-emerald-500/30';
            }
            if (cardInside) {
                cardInside.className = 'relative flex items-center justify-between p-3 rounded-2xl border-2 cursor-pointer transition-all border-slate-200 bg-slate-50/60 hover:border-slate-300';
            }
        }

        updateModalTotals();
    }

    function updateModalTotals() {
        const subtotal = parseFloat(document.getElementById('modal_subtotal')?.value || 0);
        const charge = parseFloat(document.getElementById('edit_delivery_charge')?.value || 0);
        const total = subtotal + charge;

        const chargeText = document.getElementById('modalCalcChargeText');
        const totalText = document.getElementById('modalCalcTotalText');

        if (chargeText) {
            chargeText.textContent = `(+) ৳ ${charge.toLocaleString('en-US')}`;
        }
        if (totalText) {
            totalText.textContent = `৳ ${total.toLocaleString('en-US')}`;
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCustomerEditModal();
        }
    });

    async function syncLiveCourierStatus(orderId) {
        const btn = document.getElementById('btnSyncCourier');
        const icon = document.getElementById('syncIcon');
        const text = document.getElementById('syncText');
        const badge = document.getElementById('orderCourierStatusBadge');
        const badgeText = document.getElementById('orderCourierStatusText');
        const syncedAt = document.getElementById('orderCourierSyncedAt');

        if (!btn) return;
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        if (icon) icon.classList.add('animate-spin');
        if (text) text.textContent = 'সিঙ্ক হচ্ছে...';

        try {
            const res = await fetch(`/admin/orders/${orderId}/sync-courier-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            const data = await res.json();

            if (data.success) {
                if (badgeText) badgeText.textContent = data.courier_status_label;
                if (badge && data.courier_status_badge_class) {
                    badge.className = `inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border shadow-xs ${data.courier_status_badge_class}`;
                }
                if (syncedAt) syncedAt.textContent = 'এইমাত্র';
                alert(data.message || 'কুরিয়ার লাইভ স্ট্যাটাস সফলভাবে সিঙ্ক হয়েছে!');
            } else {
                alert(data.message || 'স্ট্যাটাস সিঙ্ক করতে সমস্যা হয়েছে');
            }
        } catch (err) {
            console.error('Courier sync error:', err);
            alert('কুরিয়ার সার্ভারের সাথে যোগাযোগ করা সম্ভব হয়নি');
        } finally {
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
            if (icon) icon.classList.remove('animate-spin');
            if (text) text.textContent = 'লাইভ স্ট্যাটাস আপডেট';
        }
    }
</script>
@endpush
@endsection
