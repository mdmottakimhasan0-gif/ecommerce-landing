@extends('layouts.app')

@section('title', 'My Orders - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Page Header & Customer Summary -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-black text-2xl shadow-md flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h1>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            {{ $user->isAdmin() ? 'Admin' : 'Customer' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1 flex flex-wrap items-center gap-3">
                        @if(!empty($user->phone))
                        <span class="flex items-center gap-1 font-mono">📱 {{ $user->phone }}</span>
                        @endif
                        @if(!empty($user->email) && !str_ends_with($user->email, '@customer.demandhat.com'))
                        <span class="flex items-center gap-1">✉️ {{ $user->email }}</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Stats Badges -->
            <div class="grid grid-cols-3 gap-3 sm:gap-4 text-center">
                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <span class="block text-lg sm:text-2xl font-black text-slate-900 font-mono">{{ $totalOrdersCount }}</span>
                    <span class="text-[11px] font-bold text-slate-500" data-i18n="total_orders">Total Orders</span>
                </div>
                <div class="p-3 sm:p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80">
                    <span class="block text-lg sm:text-2xl font-black text-amber-700 font-mono">{{ $pendingCount }}</span>
                    <span class="text-[11px] font-bold text-amber-700" data-i18n="in_progress">In Delivery</span>
                </div>
                <div class="p-3 sm:p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/80">
                    <span class="block text-lg sm:text-2xl font-black text-emerald-700 font-mono">{{ $deliveredCount }}</span>
                    <span class="text-[11px] font-bold text-emerald-700" data-i18n="completed_orders">Delivered</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs & Title -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>📦</span>
                <span data-i18n="order_history_title">My Orders</span>
            </h2>
            <p class="text-xs text-slate-500 mt-0.5" data-i18n="order_history_sub">Track your active orders and view purchase history</p>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 text-xs font-bold">
            <a href="{{ route('customer.orders') }}" 
               class="px-4 py-2 rounded-xl border transition-all cursor-pointer whitespace-nowrap {{ empty($status) ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                All ({{ $totalOrdersCount }})
            </a>
            <a href="{{ route('customer.orders', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-xl border transition-all cursor-pointer whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-600 text-white border-amber-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                Pending
            </a>
            <a href="{{ route('customer.orders', ['status' => 'delivered']) }}" 
               class="px-4 py-2 rounded-xl border transition-all cursor-pointer whitespace-nowrap {{ $status === 'delivered' ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50' }}">
                Delivered
            </a>
        </div>
    </div>

    <!-- Orders List -->
    @if($orders->count() > 0)
    <div class="space-y-6">
        @foreach($orders as $order)
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
            <!-- Order Header Card -->
            <div class="p-5 sm:p-6 bg-slate-50/70 border-b border-slate-200 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="text-base sm:text-lg font-black font-mono text-slate-900 tracking-tight">
                            #{{ $order->order_number }}
                        </span>
                        
                        <!-- Status Badge -->
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'processing' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'shipped' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'cancelled' => 'bg-rose-100 text-rose-800 border-rose-300',
                            ];
                            $badgeClass = $statusClasses[$order->status] ?? 'bg-slate-100 text-slate-800 border-slate-300';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold border uppercase tracking-wider {{ $badgeClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <p class="text-xs text-slate-500 mt-1">
                        <span>Placed on:</span>
                        <span class="font-semibold text-slate-700">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Direct Live Track Order Button -->
                    <form action="{{ route('tracking.search') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="query" value="{{ $order->order_number }}">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-emerald-600/30 transition-all cursor-pointer">
                            <span>📦</span>
                            <span>Track Order</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Items List -->
            <div class="p-5 sm:p-6 divide-y divide-slate-100">
                @foreach($order->items as $item)
                <div class="py-3.5 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                        @if($item->product && $item->product->thumbnail)
                        <img src="{{ asset($item->product->thumbnail) }}" alt="{{ $item->product_name }}" 
                             class="w-14 h-14 object-cover rounded-xl border border-slate-200 flex-shrink-0 bg-slate-50">
                        @else
                        <div class="w-14 h-14 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center text-xl flex-shrink-0 font-bold">
                            🛍️
                        </div>
                        @endif
                        <div class="min-w-0">
                            <h4 class="text-sm font-bold text-slate-900 truncate">
                                @if($item->product)
                                <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-emerald-600 transition-colors">
                                    {{ $item->product_name }}
                                </a>
                                @else
                                {{ $item->product_name }}
                                @endif
                            </h4>
                            <p class="text-xs text-slate-500 mt-0.5">
                                <span class="font-mono">৳ {{ number_format($item->price, 0) }}</span> × 
                                <span class="font-bold text-slate-700">{{ $item->quantity }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="text-right flex-shrink-0">
                        <span class="text-sm font-black font-mono text-slate-900">
                            ৳ {{ number_format($item->total, 0) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Footer & Address Summary -->
            <div class="p-5 sm:p-6 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs">
                <div class="space-y-1 text-slate-600 max-w-md">
                    <p><span class="font-bold text-slate-800">Delivery Address:</span> {{ $order->address }} ({{ $order->district }})</p>
                    <p><span class="font-bold text-slate-800">Payment:</span> Cash on Delivery ({{ ucfirst($order->payment_status) }})</p>
                    @if(!empty($order->courier_tracking_code))
                    <p class="pt-1">
                        <span class="font-bold text-slate-800">Courier:</span>
                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-mono font-bold">{{ $order->courier_name ?? 'Steadfast' }}: {{ $order->courier_tracking_code }}</span>
                    </p>
                    @endif
                </div>

                <div class="text-right sm:border-l sm:border-slate-200 sm:pl-6 space-y-1">
                    <div class="flex justify-between sm:justify-end gap-6 text-slate-500">
                        <span>Subtotal:</span>
                        <span class="font-mono font-bold text-slate-800">৳ {{ number_format($order->subtotal, 0) }}</span>
                    </div>
                    <div class="flex justify-between sm:justify-end gap-6 text-slate-500">
                        <span>Delivery:</span>
                        <span class="font-mono font-bold text-slate-800">৳ {{ number_format($order->delivery_charge, 0) }}</span>
                    </div>
                    <div class="flex justify-between sm:justify-end gap-6 text-sm pt-1 border-t border-slate-200">
                        <span class="font-bold text-slate-900">Total:</span>
                        <span class="font-black font-mono text-emerald-600 text-base">৳ {{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div class="pt-4">
            {{ $orders->links() }}
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 shadow-sm max-w-xl mx-auto space-y-4">
        <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-4xl shadow-inner">
            📦
        </div>
        <h3 class="text-xl font-black text-slate-900" data-i18n="no_orders_title">No Orders Placed Yet</h3>
        <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed" data-i18n="no_orders_desc">
            You haven't placed any orders yet. Browse our top categories and exclusive gadgets to start shopping today!
        </p>
        <div class="pt-2">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl text-xs shadow-lg hover:shadow-emerald-600/30 transition-all cursor-pointer">
                <span>🛍️</span>
                <span>Start Shopping</span>
            </a>
        </div>
    </div>
    @endif

</div>
@endsection
