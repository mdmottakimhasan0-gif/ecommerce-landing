@extends('admin.layout')

@section('title', 'অর্ডার ম্যানেজমেন্ট - এডমিন প্যানেল')

@section('top_actions')
    <!-- Language Switcher Toggle (Persistent in localStorage) -->
    <div class="inline-flex items-center p-0.5 bg-slate-100 border border-slate-200 rounded-xl shadow-2xs text-xs font-bold">
        <button type="button" onclick="setLanguage('bn')" id="btnLangBn" class="px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer bg-slate-900 text-white shadow-xs">
            <span>🇧🇩</span>
            <span>বাংলা</span>
        </button>
        <button type="button" onclick="setLanguage('en')" id="btnLangEn" class="px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer text-slate-600 hover:text-slate-900">
            <span>🇬🇧</span>
            <span>English</span>
        </button>
    </div>

    <!-- Batch Courier Sync Button -->
    <form action="{{ route('admin.orders.syncAllCouriers') }}" method="POST" onsubmit="return confirm('সকল সক্রিয় কুরিয়ার পার্সেলের লাইভ স্ট্যাটাস আপডেট করতে চান?')">
        @csrf
        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white rounded-xl text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer" 
                title="Steadfast সহ সক্রিয় কুরিয়ারের লাইভ স্ট্যাটাস একসাথে সিঙ্ক করুন">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <span data-bn="কুরিয়ার স্ট্যাটাস সিঙ্ক 🔄" data-en="Sync Couriers 🔄">কুরিয়ার স্ট্যাটাস সিঙ্ক 🔄</span>
        </button>
    </form>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Header and Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900" data-bn="অর্ডার ম্যানেজমেন্ট" data-en="Order Management">
                অর্ডার ম্যানেজমেন্ট
            </h1>
            <p class="text-xs text-slate-500 mt-1" data-bn="ক্যাশ অন ডেলিভারির সকল অর্ডার পরিচালনা ও কুরিয়ার স্ট্যাটাস আপডেট করুন" data-en="Manage cash on delivery orders and live courier statuses">
                ক্যাশ অন ডেলিভারির সকল অর্ডার পরিচালনা ও কুরিয়ার স্ট্যাটাস আপডেট করুন
            </p>
        </div>

        <div>
            <!-- Search Form -->
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" 
                       data-placeholder-bn="অর্ডার আইডি, নাম বা ফোন..." 
                       data-placeholder-en="Order ID, name or phone..."
                       placeholder="অর্ডার আইডি, নাম বা ফোন..." 
                       class="px-3.5 py-2 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none w-56 sm:w-64">
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold cursor-pointer transition-colors shadow-xs" data-bn="সার্চ" data-en="Search">
                    সার্চ
                </button>
            </form>
        </div>
    </div>

    <!-- Flash Alerts -->
    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
        <span class="text-base">⚠️</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap bg-white p-2 rounded-2xl border border-slate-200 shadow-sm text-xs font-bold">
        <a href="{{ route('admin.orders.index') }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ !request('status') ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
            <span data-bn="সব অর্ডার" data-en="All Orders">সব অর্ডার</span> ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ request('status') === 'pending' ? 'bg-slate-800 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
            <span data-bn="অপেক্ষমাণ" data-en="Pending">অপেক্ষমাণ</span> ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ request('status') === 'processing' ? 'bg-amber-600 text-white' : 'text-amber-700 hover:bg-amber-50' }}">
            <span data-bn="প্রসেসিং" data-en="Processing">প্রসেসিং</span> ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ request('status') === 'shipped' ? 'bg-blue-600 text-white' : 'text-blue-700 hover:bg-blue-50' }}">
            <span data-bn="কুরিয়ারে" data-en="Shipped">কুরিয়ারে</span> ({{ $statusCounts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ request('status') === 'delivered' ? 'bg-emerald-600 text-white' : 'text-emerald-700 hover:bg-emerald-50' }}">
            <span data-bn="ডেলিভার্ড" data-en="Delivered">ডেলিভার্ড</span> ({{ $statusCounts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
           class="px-3.5 py-1.5 rounded-xl transition-colors {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white' : 'text-rose-700 hover:bg-rose-50' }}">
            <span data-bn="বাতিল" data-en="Cancelled">বাতিল</span> ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4" data-bn="অর্ডার কোড" data-en="Order Code">অর্ডার কোড</th>
                        <th class="py-3 px-3" data-bn="গ্রাহকের নাম ও ফোন" data-en="Customer & Phone">গ্রাহকের নাম ও ফোন</th>
                        <th class="py-3 px-3" data-bn="ডেলিভারি এলাকা" data-en="Delivery Area">ডেলিভারি এলাকা</th>
                        <th class="py-3 px-3 text-right" data-bn="মোট টাকা" data-en="Total">মোট টাকা</th>
                        <th class="py-3 px-3 text-center" data-bn="উৎস (Source)" data-en="Source">উৎস (Source)</th>
                        <th class="py-3 px-4 text-center uppercase tracking-wider font-black text-slate-700 whitespace-nowrap" data-bn="ORDER STATUS ⇅" data-en="ORDER STATUS ⇅">ORDER STATUS ⇅</th>
                        <th class="py-3 px-4 text-center" data-bn="অ্যাকশন" data-en="Action">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr id="order-row-{{ $order->id }}" class="hover:bg-slate-50/80 transition-colors">
                        <!-- Order Code & Date -->
                        <td class="py-3 px-4">
                            <span class="font-mono font-bold text-slate-900 block">{{ $order->order_number }}</span>
                            <span class="text-[10px] text-slate-400">{{ $order->created_at->format('d M, Y h:i A') }}</span>
                        </td>

                        <!-- Customer Name & Phone -->
                        <td class="py-3 px-3">
                            <strong class="text-slate-900 block order-customer-name">{{ $order->customer_name }}</strong>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <a href="tel:{{ $order->phone }}" class="text-emerald-600 font-mono font-bold hover:underline order-customer-phone">{{ $order->phone }}</a>
                                <a href="tel:{{ $order->phone }}" class="p-1 bg-emerald-100 hover:bg-emerald-200 text-emerald-800 rounded-md transition-colors" title="সরাসরি কল দিন">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </a>
                            </div>
                        </td>

                        <!-- Delivery Area & Address -->
                        <td class="py-3 px-3">
                            <span class="text-slate-700 font-medium block order-delivery-area" 
                                  data-bn="{{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটিতে' : 'ঢাকার বাইরে' }}" 
                                  data-en="{{ $order->delivery_area === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}">
                                {{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটিতে' : 'ঢাকার বাইরে' }}
                            </span>
                            <span class="text-[10px] text-slate-400 line-clamp-1 max-w-[160px] order-address">{{ $order->address }}</span>
                        </td>

                        <!-- Total -->
                        <td class="py-3 px-3 text-right font-black text-slate-900 text-sm">
                            <span class="order-total-text">৳ {{ number_format($order->total) }}</span>
                        </td>

                        <!-- Source -->
                        <td class="py-3 px-3 text-center">
                            @if($order->landingPage)
                            <a href="{{ url('/' . $order->landingPage->slug) }}" target="_blank" class="inline-block px-2 py-0.5 rounded-md bg-purple-100 text-purple-800 text-[10px] font-bold hover:underline" title="{{ $order->landingPage->name }}">
                                🚀 LP: /{{ $order->landingPage->slug }}
                            </a>
                            @else
                            <span class="inline-block px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-semibold" data-bn="সাধারণ শপ" data-en="General Shop">
                                সাধারণ শপ
                            </span>
                            @endif
                        </td>

                        <!-- ORDER STATUS (Clean Minimalist Pill Matching User Screenshot) -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="order-status-badge-container inline-block">
                                @if($order->status === 'delivered')
                                <span class="px-3.5 py-1.5 rounded-full bg-[#dcfce7] text-[#15803d] text-xs font-bold inline-block status-badge shadow-2xs" data-bn="Delivered" data-en="Delivered">Delivered</span>
                                @elseif($order->status === 'shipped')
                                <span class="px-3.5 py-1.5 rounded-full bg-[#e0e7ff] text-[#4338ca] text-xs font-bold inline-block status-badge shadow-2xs" data-bn="Shipped" data-en="Shipped">Shipped</span>
                                @elseif($order->status === 'processing')
                                <span class="px-3.5 py-1.5 rounded-full bg-[#fef3c7] text-[#b45309] text-xs font-bold inline-block status-badge shadow-2xs" data-bn="Processing" data-en="Processing">Processing</span>
                                @elseif($order->status === 'cancelled')
                                <span class="px-3.5 py-1.5 rounded-full bg-[#ffe4e6] text-[#be123c] text-xs font-bold inline-block status-badge shadow-2xs" data-bn="Cancelled" data-en="Cancelled">Cancelled</span>
                                @else
                                <span class="px-3.5 py-1.5 rounded-full bg-[#fef9c3] text-[#854d0e] text-xs font-bold inline-block status-badge shadow-2xs" data-bn="Pending" data-en="Pending">Pending</span>
                                @endif
                            </div>
                        </td>

                        <!-- Action Icons (Exactly matching User Screenshot 2) -->
                        <td class="py-3 px-4 text-center whitespace-nowrap">
                            <div class="inline-flex items-center gap-1.5 p-1 bg-slate-50/80 hover:bg-slate-100 rounded-xl border border-slate-200/80 transition-all">
                                <!-- 1. Fraud Checker (Red Shield) -->
                                <button type="button" 
                                        onclick="openFraudChecker('{{ $order->phone }}')" 
                                        data-title-bn="ফ্রড চেকার (Fraud Intelligence)"
                                        data-title-en="Fraud Intelligence Checker"
                                        title="ফ্রড চেকার (Fraud Intelligence)"
                                        class="w-7 h-7 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 flex items-center justify-center transition-colors cursor-pointer active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3s7 3 7 9-7 9-7 9-7-3-7-9 7-9 7-9z"/>
                                    </svg>
                                </button>

                                <!-- 2. Courier Shipping (Blue Truck) -->
                                <a href="{{ route('admin.orders.show', $order->id) }}#courierBookingSection" 
                                   data-title-bn="কুরিয়ার ও শিপিং ম্যানেজমেন্ট"
                                   data-title-en="Courier & Shipping Details"
                                   title="কুরিয়ার ও শিপিং ম্যানেজমেন্ট"
                                   class="w-7 h-7 rounded-lg text-blue-500 hover:text-blue-700 hover:bg-blue-50 flex items-center justify-center transition-colors active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8h3l3 4v4h-2m0 0a2 2 0 01-4 0"/>
                                    </svg>
                                </a>

                                <!-- 3. View Details (Green Eye) -->
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   data-title-bn="অর্ডার চালান ও সম্পূর্ণ বিবরণ দেখুন"
                                   data-title-en="View Order Invoice & Details"
                                   title="অর্ডার চালান ও সম্পূর্ণ বিবরণ দেখুন"
                                   class="w-7 h-7 rounded-lg text-emerald-600 hover:text-emerald-800 hover:bg-emerald-50 flex items-center justify-center transition-colors active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- 4. Edit Order (Blue Pencil) -->
                                <button type="button" 
                                        onclick="openEditOrderModal({{ json_encode([
                                            'id' => $order->id,
                                            'order_number' => $order->order_number,
                                            'customer_name' => $order->customer_name,
                                            'email' => $order->email ?? '',
                                            'phone' => $order->phone,
                                            'address' => $order->address,
                                            'status' => $order->status,
                                            'payment_status' => $order->payment_status,
                                            'subtotal' => (float) $order->subtotal,
                                            'delivery_charge' => (float) $order->delivery_charge,
                                            'total' => (float) $order->total,
                                        ]) }})" 
                                        data-title-bn="অর্ডার এডিট করুন"
                                        data-title-en="Edit Order"
                                        title="অর্ডার এডিট করুন"
                                        class="w-7 h-7 rounded-lg text-blue-600 hover:text-blue-800 hover:bg-blue-50 flex items-center justify-center transition-colors cursor-pointer active:scale-90">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400" data-bn="কোনো অর্ডার পাওয়া যায়নি।" data-en="No orders found.">
                            কোনো অর্ডার পাওয়া যায়নি।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    </div>

</div>

<!-- ========================================================================= -->
<!-- EDIT ORDER MODAL (Matching Screenshot 3 & 4)                              -->
<!-- ========================================================================= -->
<div id="editOrderModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div id="editOrderBackdrop" class="fixed inset-0 bg-slate-950/70 z-40 transition-opacity cursor-pointer"></div>

    <div class="relative z-50 min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl bg-white rounded-3xl text-left shadow-2xl border border-slate-200 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h3 id="editOrderModalTitle" class="text-base font-black text-slate-900">
                    Edit Order #132
                </h3>
                <button type="button" onclick="closeEditOrderModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Edit Form -->
            <form id="editOrderForm" onsubmit="submitEditOrder(event)" class="p-6 space-y-6">
                @csrf
                <input type="hidden" id="editOrderId" name="order_id">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- LEFT COLUMN: CUSTOMER INFORMATION -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-blue-600 uppercase tracking-wider">
                            CUSTOMER INFORMATION
                        </h4>

                        <!-- Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Name</label>
                            <input type="text" id="editCustomerName" name="customer_name" required 
                                   class="w-full text-xs font-semibold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all">
                        </div>

                        <!-- Email & Phone -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                                <input type="email" id="editCustomerEmail" name="email" placeholder="customer@example.com"
                                       class="w-full text-xs px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Phone</label>
                                <input type="text" id="editCustomerPhone" name="phone" required 
                                       class="w-full text-xs font-mono font-bold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Address</label>
                            <textarea id="editCustomerAddress" name="address" rows="3" required 
                                      class="w-full text-xs px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all resize-none"></textarea>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: STATUS & FINANCIALS -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-purple-600 uppercase tracking-wider">
                            STATUS & FINANCIALS
                        </h4>

                        <!-- Order Status & Payment Status (Dropdowns as in Screenshot 3 & 4) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Order Status</label>
                                <select id="editOrderStatus" name="status" required 
                                        class="w-full text-xs font-bold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all cursor-pointer">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="shipped">Shipped</option>
                                    <option value="delivered">Delivered</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Payment Status</label>
                                <select id="editPaymentStatus" name="payment_status" required 
                                        class="w-full text-xs font-bold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all cursor-pointer">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <!-- Subtotal & Delivery Fee -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Subtotal</label>
                                <input type="number" step="0.01" id="editSubtotal" name="subtotal" required oninput="calculateEditGrandTotal()" 
                                       class="w-full text-xs font-mono font-bold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Delivery Fee</label>
                                <input type="number" step="0.01" id="editDeliveryFee" name="delivery_charge" required oninput="calculateEditGrandTotal()" 
                                       class="w-full text-xs font-mono font-bold px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none transition-all">
                            </div>
                        </div>

                        <!-- Grand Total Card (Matching Screenshot 3) -->
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">
                                GRAND TOTAL
                            </span>
                            <span id="editGrandTotalDisplay" class="text-2xl font-black text-blue-600 block mt-0.5">
                                ৳0.00
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditOrderModal()" 
                            class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                        Cancel
                    </button>
                    <button type="submit" id="btnUpdateOrderSubmit" 
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold text-xs rounded-xl shadow-md transition-all cursor-pointer flex items-center gap-1.5">
                        <span id="updateOrderBtnText">Update Order</span>
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
    // =========================================================================
    // 1. EDIT ORDER POPUP MODAL (Screenshot 3 & 4)
    // =========================================================================
    const editModal = document.getElementById('editOrderModal');
    const editBackdrop = document.getElementById('editOrderBackdrop');

    if (editBackdrop) {
        editBackdrop.addEventListener('click', closeEditOrderModal);
    }

    function closeEditOrderModal() {
        if (editModal) editModal.classList.add('hidden');
    }

    let currentEditingOrder = null;

    function openEditOrderModal(order) {
        currentEditingOrder = order;

        document.getElementById('editOrderId').value = order.id;
        document.getElementById('editOrderModalTitle').textContent = `Edit Order #${order.id} (${order.order_number})`;

        // Populate fields
        document.getElementById('editCustomerName').value = order.customer_name || '';
        document.getElementById('editCustomerEmail').value = order.email || '';
        document.getElementById('editCustomerPhone').value = order.phone || '';
        document.getElementById('editCustomerAddress').value = order.address || '';

        document.getElementById('editOrderStatus').value = order.status || 'pending';
        document.getElementById('editPaymentStatus').value = order.payment_status || 'pending';

        document.getElementById('editSubtotal').value = parseFloat(order.subtotal || 0).toFixed(2);
        document.getElementById('editDeliveryFee').value = parseFloat(order.delivery_charge || 0).toFixed(2);

        calculateEditGrandTotal();

        editModal.classList.remove('hidden');
    }

    function calculateEditGrandTotal() {
        const subtotal = parseFloat(document.getElementById('editSubtotal').value) || 0;
        const fee = parseFloat(document.getElementById('editDeliveryFee').value) || 0;
        const grandTotal = subtotal + fee;

        document.getElementById('editGrandTotalDisplay').textContent = `৳${grandTotal.toFixed(2)}`;
    }

    async function submitEditOrder(event) {
        event.preventDefault();

        const btn = document.getElementById('btnUpdateOrderSubmit');
        const btnText = document.getElementById('updateOrderBtnText');
        const orderId = document.getElementById('editOrderId').value;

        btn.disabled = true;
        btnText.textContent = 'Updating...';

        const payload = {
            customer_name: document.getElementById('editCustomerName').value,
            email: document.getElementById('editCustomerEmail').value,
            phone: document.getElementById('editCustomerPhone').value,
            address: document.getElementById('editCustomerAddress').value,
            status: document.getElementById('editOrderStatus').value,
            payment_status: document.getElementById('editPaymentStatus').value,
            subtotal: parseFloat(document.getElementById('editSubtotal').value) || 0,
            delivery_charge: parseFloat(document.getElementById('editDeliveryFee').value) || 0,
        };

        try {
            const response = await fetch(`/admin/orders/${orderId}/update-details`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success) {
                // Update table row in real-time
                const row = document.getElementById(`order-row-${orderId}`);
                if (row) {
                    const nameEl = row.querySelector('.order-customer-name');
                    if (nameEl) nameEl.textContent = payload.customer_name;

                    const phoneEl = row.querySelector('.order-customer-phone');
                    if (phoneEl) {
                        phoneEl.textContent = payload.phone;
                        phoneEl.href = `tel:${payload.phone}`;
                    }

                    const addrEl = row.querySelector('.order-address');
                    if (addrEl) addrEl.textContent = payload.address;

                    const totalEl = row.querySelector('.order-total-text');
                    if (totalEl) totalEl.textContent = `৳ ${(payload.subtotal + payload.delivery_charge).toLocaleString('en-US', {minimumFractionDigits: 0})}`;

                    // Update Status Badge
                    const badgeContainer = row.querySelector('.order-status-badge-container');
                    if (badgeContainer) {
                        const statusLabels = {
                            pending: { bn: 'Pending', en: 'Pending', class: 'bg-[#fef9c3] text-[#854d0e]' },
                            processing: { bn: 'Processing', en: 'Processing', class: 'bg-[#fef3c7] text-[#b45309]' },
                            shipped: { bn: 'Shipped', en: 'Shipped', class: 'bg-[#e0e7ff] text-[#4338ca]' },
                            delivered: { bn: 'Delivered', en: 'Delivered', class: 'bg-[#dcfce7] text-[#15803d]' },
                            cancelled: { bn: 'Cancelled', en: 'Cancelled', class: 'bg-[#ffe4e6] text-[#be123c]' },
                        };
                        const info = statusLabels[payload.status] || statusLabels.pending;
                        const currentLang = localStorage.getItem('admin_orders_lang') || 'en';
                        const text = (currentLang === 'bn') ? info.bn : info.en;
                        badgeContainer.innerHTML = `<span class="px-3.5 py-1.5 rounded-full ${info.class} text-xs font-bold inline-block status-badge shadow-2xs" data-bn="${info.bn}" data-en="${info.en}">${text}</span>`;
                    }
                }

                closeEditOrderModal();
                alert(result.message || 'Order updated successfully!');
            } else {
                alert(result.message || 'Failed to update order');
            }
        } catch (err) {
            console.error('Update order error:', err);
            alert('Failed to communicate with server');
        } finally {
            btn.disabled = false;
            btnText.textContent = 'Update Order';
        }
    }
</script>
@endpush
@endsection
