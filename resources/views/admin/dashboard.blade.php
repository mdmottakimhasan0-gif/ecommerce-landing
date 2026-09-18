@extends('admin.layout')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900" data-bn="ব্যবসা সারসংক্ষেপ ও ড্যাশবোর্ড" data-en="Business Overview & Dashboard">Business Overview & Dashboard</h1>
            <p class="text-xs text-slate-500 mt-1" data-bn="আজকের অর্ডার, মোট রাজস্ব এবং ল্যান্ডিং পেজ কনভার্সন মেট্রিক্স" data-en="Today's orders, total revenue and landing page conversion metrics">Today's orders, total revenue and landing page conversion metrics</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.landing-pages.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-1.5">
                <span data-bn="🚀 নতুন ল্যান্ডিং পেজ তৈরি করুন" data-en="🚀 Create Landing Page">🚀 Create Landing Page</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Metric 1: Total Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span data-bn="মোট সেলস / রাজস্ব" data-en="Total Sales / Revenue">Total Sales / Revenue</span>
                <span class="p-1.5 bg-emerald-50 text-emerald-600 rounded-lg">৳</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-slate-900">
                ৳ {{ number_format($totalRevenue) }}
            </div>
            <p class="text-[11px] text-emerald-600 font-semibold" data-bn="সফল ও অপেক্ষমাণ অর্ডার মিলিয়ে" data-en="Including delivered & pending orders">Including delivered & pending orders</p>
        </div>

        <!-- Metric 2: Total Orders -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span data-bn="মোট অর্ডার সংখ্যা" data-en="Total Orders">Total Orders</span>
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">📦</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-slate-900">
                {{ $totalOrders }}
            </div>
            <p class="text-[11px] text-slate-500">
                <span data-bn="পেন্ডিং" data-en="Pending">Pending</span>: <strong class="text-amber-600">{{ $pendingOrders }}</strong> | 
                <span data-bn="ডেলিভার্ড" data-en="Delivered">Delivered</span>: <strong class="text-emerald-600">{{ $deliveredOrders }}</strong>
            </p>
        </div>

        <!-- Metric 3: Landing Page Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span data-bn="ল্যান্ডিং পেজ সেলস" data-en="Landing Page Sales">Landing Page Sales</span>
                <span class="p-1.5 bg-purple-50 text-purple-600 rounded-lg">🚀</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-purple-700">
                ৳ {{ number_format($landingPageRevenue) }}
            </div>
            <p class="text-[11px] text-purple-600 font-semibold">
                {{ $landingPageOrders }} <span data-bn="টি অর্ডার ল্যান্ডিং পেজ থেকে" data-en="orders from landing pages">orders from landing pages</span>
            </p>
        </div>

        <!-- Metric 4: Conversion Rate -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                <span data-bn="গড় কনভার্সন রেট" data-en="Avg Conversion Rate">Avg Conversion Rate</span>
                <span class="p-1.5 bg-amber-50 text-amber-600 rounded-lg">📈</span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-emerald-600">
                {{ $avgConversionRate }}%
            </div>
            <p class="text-[11px] text-slate-500">
                <span data-bn="মোট ভিজিটর" data-en="Total Visitors">Total Visitors</span>: {{ number_format($totalLandingPageViews) }}
            </p>
        </div>
    </div>

    <!-- Active Landing Pages Quick Showcase -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span>🚀</span> <span data-bn="সক্রিয় ল্যান্ডিং পেজসমূহ" data-en="Top Landing Pages">Top Landing Pages</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5" data-bn="বিজ্ঞাপন এবং ফেসবুক ক্যাম্পেইনের জন্য প্রস্তুত কাস্টম সেলস পেজ" data-en="Custom sales pages prepared for advertising and campaigns">Custom sales pages prepared for advertising and campaigns</p>
            </div>
            <a href="{{ route('admin.landing-pages.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                <span data-bn="সবগুলো দেখুন" data-en="View All">View All</span> ({{ $totalLandingPages }}) →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3" data-bn="পেজের নাম" data-en="Page Name">Page Name</th>
                        <th class="py-2.5 px-3" data-bn="সংযুক্ত প্রোডাক্ট" data-en="Linked Product">Linked Product</th>
                        <th class="py-2.5 px-3 text-center" data-bn="ভিউ" data-en="Views">Views</th>
                        <th class="py-2.5 px-3 text-center" data-bn="অর্ডার" data-en="Orders">Orders</th>
                        <th class="py-2.5 px-3 text-center" data-bn="কনভার্সন" data-en="Conversion">Conversion</th>
                        <th class="py-2.5 px-3 text-center" data-bn="স্ট্যাটাস" data-en="Status">Status</th>
                        <th class="py-2.5 px-3 text-right" data-bn="অ্যাকশন" data-en="Action">Action</th>
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
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold" data-bn="পাবলিশড" data-en="Published">Published</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold" data-bn="ড্রাফট" data-en="Draft">Draft</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right space-x-1">
                            <a href="{{ route('admin.landing-pages.builder', $lp->id) }}" class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-colors inline-block">
                                🎨 <span data-bn="বিল্ডার" data-en="Builder">Builder</span>
                            </a>
                            <a href="{{ url('/' . $lp->slug) }}" target="_blank" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-colors inline-block">
                                👁️ <span data-bn="লাইভ" data-en="Live">Live</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-6 text-center text-slate-400" data-bn="এখনো কোনো ল্যান্ডিং পেজ তৈরি করা হয়নি।" data-en="No landing pages created yet.">No landing pages created yet.</td>
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
                    <span>📦</span> <span data-bn="সাম্প্রতিক অর্ডারসমূহ" data-en="Recent Orders">Recent Orders</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5" data-bn="কাস্টমারদের দেওয়া সর্বশেষ ক্যাশ অন ডেলিভারি অর্ডার" data-en="Latest cash on delivery orders placed by customers">Latest cash on delivery orders placed by customers</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                <span data-bn="সব অর্ডার দেখুন" data-en="View All Orders">View All Orders</span> →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-bold border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3" data-bn="অর্ডার আইডি" data-en="Order ID">Order ID</th>
                        <th class="py-2.5 px-3" data-bn="গ্রাহক ও মোবাইল" data-en="Customer & Phone">Customer & Phone</th>
                        <th class="py-2.5 px-3" data-bn="এলাকা" data-en="Area">Area</th>
                        <th class="py-2.5 px-3 text-right" data-bn="মোট টাকা" data-en="Total Amount">Total Amount</th>
                        <th class="py-2.5 px-3 text-center" data-bn="স্ট্যাটাস" data-en="Status">Status</th>
                        <th class="py-2.5 px-3 text-right" data-bn="অ্যাকশন" data-en="Action">Action</th>
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
                            <span class="text-slate-700" data-bn="{{ $ord->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটি' : 'ঢাকার বাইরে' }}" data-en="{{ $ord->delivery_area === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}">
                                {{ $ord->delivery_area === 'inside_dhaka' ? 'Inside Dhaka' : 'Outside Dhaka' }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-right font-black text-emerald-700">
                            ৳ {{ number_format($ord->total) }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($ord->status === 'delivered')
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold" data-bn="ডেলিভার্ড" data-en="Delivered">Delivered</span>
                            @elseif($ord->status === 'shipped')
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold" data-bn="কুরিয়ারে" data-en="Shipped">Shipped</span>
                            @elseif($ord->status === 'processing')
                            <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold" data-bn="প্রসেসিং" data-en="Processing">Processing</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[10px] font-bold" data-bn="পেন্ডিং" data-en="Pending">Pending</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-right">
                            <a href="{{ route('admin.orders.show', $ord->id) }}" class="text-xs font-bold text-emerald-600 hover:underline">
                                <span data-bn="বিস্তারিত দেখুন" data-en="View Details">View Details</span> →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-400" data-bn="এখনো কোনো অর্ডার আসেনি।" data-en="No orders received yet.">No orders received yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
