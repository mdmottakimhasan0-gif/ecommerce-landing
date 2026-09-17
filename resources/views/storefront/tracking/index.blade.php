@extends('layouts.app')

@section('title', 'অর্ডার ট্র্যাকিং - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 space-y-8">

    <!-- Search Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm text-center max-w-xl mx-auto space-y-4">
        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mx-auto">
            📦
        </div>
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">আপনার অর্ডার ট্র্যাক করুন</h1>
            <p class="text-xs text-slate-500 mt-1">
                অর্ডারের বর্তমান অবস্থা জানতে আপনার মোবাইল নম্বর অথবা অর্ডার কোড লিখুন।
            </p>
        </div>

        <form action="{{ route('tracking.search') }}" method="POST" class="space-y-3">
            @csrf
            <div class="relative">
                <input type="text" name="query" value="{{ $query ?? request('query') }}" required 
                       placeholder="017XXXXXXXX অথবা DH-260917-XXXX" 
                       class="w-full pl-4 pr-12 py-3 text-sm border-2 border-slate-200 rounded-xl focus:border-emerald-500 focus:outline-none">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-colors">
                    খুঁজুন
                </button>
            </div>
            <p class="text-[11px] text-slate-400">অর্ডার করার সময় যে মোবাইল নম্বর দিয়েছিলেন সেটি ব্যবহার করুন।</p>
        </form>
    </div>

    <!-- Search Results -->
    @if(isset($orders))
        @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-8 text-center border border-slate-200 max-w-md mx-auto space-y-3">
            <span class="text-4xl block">🔍</span>
            <h3 class="text-base font-bold text-slate-800">কোনো অর্ডার পাওয়া যায়নি</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                "{{ $query }}" দিয়ে কোনো অর্ডার খুঁজে পাওয়া যায়নি। অনুগ্রহ করে সঠিক মোবাইল নম্বর বা অর্ডার কোড নিশ্চিত করুন।
            </p>
            <div class="pt-2">
                <a href="tel:{{ $settings['store_phone'] ?? '01712-345678' }}" class="text-xs font-bold text-emerald-600 hover:underline">
                    হেল্পলাইনে কল দিয়ে জানুন: {{ $settings['store_phone'] ?? '01712-345678' }}
                </a>
            </div>
        </div>
        @else
        <div class="space-y-6">
            <h2 class="text-lg font-bold text-slate-900">পাওয়া গেছে {{ $orders->count() }} টি অর্ডার</h2>
            
            @foreach($orders as $order)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-6">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-slate-100">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-500">অর্ডার কোড:</span>
                            <span class="text-sm font-black text-slate-900 font-mono">{{ $order->order_number }}</span>
                        </div>
                        <span class="text-[11px] text-slate-400">তারিখ: {{ $order->created_at->format('d M, Y - h:i A') }}</span>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if($order->status === 'delivered')
                        <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> ডেলিভারি সম্পন্ন (Delivered)
                        </span>
                        @elseif($order->status === 'shipped')
                        <span class="px-3.5 py-1.5 rounded-full bg-blue-100 text-blue-800 text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span> কুরিয়ারে হস্তান্তর হয়েছে (Shipped)
                        </span>
                        @elseif($order->status === 'processing')
                        <span class="px-3.5 py-1.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span> প্রসেসিং হচ্ছে (Processing)
                        </span>
                        @elseif($order->status === 'cancelled')
                        <span class="px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">
                            বাতিল করা হয়েছে (Cancelled)
                        </span>
                        @else
                        <span class="px-3.5 py-1.5 rounded-full bg-slate-100 text-slate-800 text-xs font-bold flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> অর্ডার নিশ্চিতকরণ অপেক্ষমাণ (Pending)
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Visual Step Progress Bar -->
                <div class="py-2">
                    <div class="grid grid-cols-4 gap-2 text-center text-[10px] sm:text-xs">
                        <div class="p-2.5 rounded-xl {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'bg-emerald-50 text-emerald-800 border-2 border-emerald-500 font-bold' : 'bg-slate-50 text-slate-400' }}">
                            <span class="block text-base sm:text-lg mb-0.5">✓</span>
                            <span>অর্ডার গৃহীত</span>
                        </div>
                        <div class="p-2.5 rounded-xl {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'bg-emerald-50 text-emerald-800 border-2 border-emerald-500 font-bold' : 'bg-slate-50 text-slate-400' }}">
                            <span class="block text-base sm:text-lg mb-0.5">📦</span>
                            <span>প্যাকিং সম্পন্ন</span>
                        </div>
                        <div class="p-2.5 rounded-xl {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-emerald-50 text-emerald-800 border-2 border-emerald-500 font-bold' : 'bg-slate-50 text-slate-400' }}">
                            <span class="block text-base sm:text-lg mb-0.5">🚚</span>
                            <span>ডেলিভারি ম্যানের কাছে</span>
                        </div>
                        <div class="p-2.5 rounded-xl {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-800 border-2 border-emerald-500 font-bold' : 'bg-slate-50 text-slate-400' }}">
                            <span class="block text-base sm:text-lg mb-0.5">🎉</span>
                            <span>ডেলিভার্ড</span>
                        </div>
                    </div>
                </div>

                @if($order->courier_name && $order->courier_consignment_id)
                <!-- Live Courier Tracking Info for Customer -->
                <div class="p-4 bg-emerald-50/70 border border-emerald-200 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-slate-700">কুরিয়ার ট্র্যাকিং:</span>
                            <span class="uppercase font-black text-emerald-800 px-2.5 py-0.5 bg-white rounded-md border border-emerald-300 shadow-2xs">{{ $order->courier_name }} Courier</span>
                            @if($order->courier_status)
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold border {{ $order->courier_status_badge_class }}">
                                {{ $order->courier_status_label }}
                            </span>
                            @endif
                        </div>
                        <div class="text-[11px] text-slate-500 mt-1">
                            ট্র্যাকিং কোড: <strong class="font-mono text-slate-900 bg-white px-2 py-0.5 rounded border border-slate-200 select-all">{{ $order->courier_tracking_code ?? $order->courier_consignment_id }}</strong>
                        </div>
                    </div>

                    @if($order->courier_tracking_link)
                    <a href="{{ $order->courier_tracking_link }}" target="_blank" rel="noopener noreferrer" 
                       class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center justify-center gap-1.5 shadow transition-all self-start sm:self-auto cursor-pointer">
                        <span>কুরিয়ার পোর্টালে সরাসরি ট্র্যাক করুন</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    @endif
                </div>
                @endif

                <!-- Customer Details & Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    <div>
                        <span class="text-slate-500 block">গ্রাহকের নাম:</span>
                        <strong class="text-slate-900 text-sm">{{ $order->customer_name }}</strong>
                        <span class="text-slate-500 block mt-2">ঠিকানা:</span>
                        <span class="text-slate-800">{{ $order->address }}</span>
                    </div>
                    <div class="space-y-1.5 md:border-l md:border-slate-200 md:pl-4">
                        <div class="flex justify-between">
                            <span class="text-slate-500">আইটেম সংখ্যা:</span>
                            <span class="font-bold text-slate-800">{{ $order->items->count() }} টি</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">ডেলিভারি এলাকা:</span>
                            <span class="font-bold text-slate-800">{{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটিতে' : 'ঢাকার বাইরে' }}</span>
                        </div>
                        <div class="flex justify-between text-sm pt-2 border-t border-slate-200 font-black">
                            <span class="text-slate-900">সর্বমোট প্রদেয় (COD):</span>
                            <span class="text-emerald-700">৳ {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="bg-slate-100 text-slate-600 font-bold border-y border-slate-200">
                            <tr>
                                <th class="py-2 px-3">পণ্য</th>
                                <th class="py-2 px-3 text-center">পরিমাণ</th>
                                <th class="py-2 px-3 text-right">মূল্য</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="py-2.5 px-3 flex items-center gap-2">
                                    @if($item->product && $item->product->thumbnail)
                                    <img src="{{ $item->product->thumbnail }}" class="w-8 h-8 object-cover rounded-lg border border-slate-200" alt="{{ $item->product_name }}">
                                    @endif
                                    <span class="font-semibold text-slate-800">{{ $item->product_name }}</span>
                                </td>
                                <td class="py-2.5 px-3 text-center font-bold text-slate-700">{{ $item->quantity }}</td>
                                <td class="py-2.5 px-3 text-right font-bold text-emerald-700">৳ {{ number_format($item->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    @endif

</div>
@endsection
