@extends('admin.layout')

@section('title', 'ড্যাশবোর্ড - এডমিন প্যানেল')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">ব্যবসা সারসংক্ষেপ ও ড্যাশবোর্ড</h1>
            <p class="text-xs text-slate-500 mt-1">আজকের অর্ডার, মোট রাজস্ব এবং ল্যান্ডিং পেজ কনভার্সন মেট্রিক্স</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.landing-pages.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-1.5">
                <span>🚀 নতুন ল্যান্ডিং পেজ তৈরি করুন</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Metric 1: Total Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span>মোট সেলস / রাজস্ব</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">৳</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-slate-900">
                ৳ {{ number_format($totalRevenue) }}
            </div>
            <p class="text-[11px] text-emerald-600 font-semibold">সফল ও অপেক্ষমাণ অর্ডার মিলিয়ে</p>
        </div>

        <!-- Metric 2: Total Orders -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span>মোট অর্ডার সংখ্যা</span>
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">📦</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-slate-900">
                {{ $totalOrders }} টি
            </div>
            <p class="text-[11px] text-slate-500">পেন্ডিং: <strong class="text-amber-600">{{ $pendingOrders }} টি</strong> | ডেলিভার্ড: <strong class="text-emerald-600">{{ $deliveredOrders }} টি</strong></p>
        </div>

        <!-- Metric 3: Landing Page Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span>ল্যান্ডিং পেজ সেলস</span>
                <span class="p-1.5 bg-purple-50 text-purple-600 rounded-lg">🚀</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-purple-700">
                ৳ {{ number_format($landingPageRevenue) }}
            </div>
            <p class="text-[11px] text-purple-600 font-semibold">ল্যান্ডিং পেজ থেকে মোট {{ $landingPageOrders }} টি অর্ডার</p>
        </div>

        <!-- Metric 4: Conversion Rate -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span>গড় কনভার্সন রেট</span>
                <span class="p-1.5 bg-amber-50 text-amber-600 rounded-lg">📈</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-emerald-600">
                {{ $avgConversionRate }}%
            </div>
            <p class="text-[11px] text-slate-500">মোট ভিজিটর: {{ number_format($totalLandingPageViews) }} জন</p>
        </div>
    </div>

    <!-- Active Landing Pages Quick Showcase -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>🚀</span> সক্রিয় ল্যান্ডিং পেজসমূহ (Top Landing Pages)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">বিজ্ঞাপন এবং ফেসবুক ক্যাম্পেইনের জন্য প্রস্তুত কাস্টম সেলস পেজ</p>
            </div>
            <a href="{{ route('admin.landing-pages.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                সবগুলো দেখুন ({{ $totalLandingPages }}) →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">পেজের নাম</th>
                        <th class="py-2.5 px-3">সংযুক্ত প্রোডাক্ট</th>
                        <th class="py-2.5 px-3 text-center">ভিউ</th>
                        <th class="py-2.5 px-3 text-center">অর্ডার</th>
                        <th class="py-2.5 px-3 text-center">কনভার্সন</th>
                        <th class="py-2.5 px-3 text-center">স্ট্যাটাস</th>
                        <th class="py-2.5 px-3 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($topLandingPages as $lp)
                    <tr>
                        <td class="py-3 px-3">
                            <span class="font-bold text-slate-900 block">{{ $lp->name }}</span>
                            <span class="text-[10px] text-emerald-600 font-mono">/{{ $lp->slug }}</span>
                        </td>
                        <td class="py-3 px-3">
                            @if($lp->product)
                            <div class="flex items-center gap-2">
                                <img src="{{ $lp->product->thumbnail }}" class="w-7 h-7 object-cover rounded border border-slate-200" alt="">
                                <span class="truncate max-w-xs">{{ $lp->product->name }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center font-semibold text-slate-700">{{ number_format($lp->views_count) }}</td>
                        <td class="py-3 px-3 text-center font-bold text-emerald-600">{{ number_format($lp->orders_count) }}</td>
                        <td class="py-3 px-3 text-center font-black text-slate-800">{{ $lp->conversion_rate }}%</td>
                        <td class="py-3 px-3 text-center">
                            @if($lp->status === 'published')
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">পাবলিশড</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">ড্রাফট</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right space-x-1">
                            <a href="{{ route('admin.landing-pages.builder', $lp->id) }}" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors inline-block">
                                🎨 বিল্ডার
                            </a>
                            <a href="{{ url('/' . $lp->slug) }}" target="_blank" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-colors inline-block">
                                👁️ লাইভ
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400">এখনো কোনো ল্যান্ডিং পেজ তৈরি করা হয়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>📦</span> সাম্প্রতিক অর্ডারসমূহ (Recent Orders)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">কাস্টমারদের দেওয়া সর্বশেষ ক্যাশ অন ডেলিভারি অর্ডার</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                সব অর্ডার দেখুন →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">অর্ডার আইডি</th>
                        <th class="py-2.5 px-3">গ্রাহক ও মোবাইল</th>
                        <th class="py-2.5 px-3">এলাকা</th>
                        <th class="py-2.5 px-3 text-right">মোট টাকা</th>
                        <th class="py-2.5 px-3 text-center">স্ট্যাটাস</th>
                        <th class="py-2.5 px-3 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $ord)
                    <tr>
                        <td class="py-3 px-3">
                            <span class="font-mono font-bold text-slate-900">{{ $ord->order_number }}</span>
                            <span class="block text-[10px] text-slate-400">{{ $ord->created_at->diffForHumans() }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <strong class="text-slate-900 block">{{ $ord->customer_name }}</strong>
                            <span class="text-slate-500 font-mono">{{ $ord->phone }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="text-slate-700">{{ $ord->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটি' : 'ঢাকার বাইরে' }}</span>
                        </td>
                        <td class="py-3 px-3 text-right font-black text-emerald-700">
                            ৳ {{ number_format($ord->total) }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($ord->status === 'delivered')
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">ডেলিভার্ড</span>
                            @elseif($ord->status === 'shipped')
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold">কুরিয়ারে</span>
                            @elseif($ord->status === 'processing')
                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">প্রসেসিং</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[10px] font-bold">পেন্ডিং</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right">
                            <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-xs font-bold text-emerald-600 hover:underline">
                                বিস্তারিত দেখুন →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-400">এখনো কোনো অর্ডার আসেনি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
