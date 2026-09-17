@extends('admin.layout')

@section('title', 'অর্ডার বিবরণ #' . $order->order_number . ' - এডমিন প্যানেল')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-20">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-xl transition-colors flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>প্রিন্ট চালান</span>
            </button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-colors">
                ← সব অর্ডার
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Quick Status Update Card -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
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
        <!-- Customer Info with One-Click Call Button and Fraud Checker -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">গ্রাহকের তথ্য</h3>
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
                           class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all active:scale-95 cursor-pointer"
                           title="গ্রাহককে সরাসরি ফোন কল করুন">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>কল করুন</span>
                        </a>

                        <!-- BD Courier Fraud Checker Button -->
                        <button type="button" onclick="openFraudChecker('{{ $order->phone }}')" 
                                class="inline-flex items-center gap-1 px-3 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-xs font-bold shadow-sm transition-all active:scale-95 cursor-pointer"
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
                    <span class="text-slate-500 block">ডেলিভারি এলাকা:</span>
                    <strong class="text-slate-900">{{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটিতে' : 'ঢাকার বাইরে' }}</strong>
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
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">পেমেন্ট ও অর্ডারের উৎস</h3>
            <div class="text-xs space-y-3">
                <div>
                    <span class="text-slate-500 block">পেমেন্ট পদ্ধতি:</span>
                    <span class="inline-block px-2.5 py-1 bg-emerald-50 text-emerald-800 rounded-lg font-bold">
                        ক্যাশ অন ডেলিভারি (Cash on Delivery)
                    </span>
                </div>
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
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
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

<!-- Reusable Fraud Detection Intelligence Modal -->
@include('admin.orders._fraud_modal')

@push('scripts')
<script>

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
