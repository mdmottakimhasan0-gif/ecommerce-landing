@extends('admin.layout')

@section('title', 'প্রোডাক্ট ম্যানেজমেন্ট - এডমিন প্যানেল')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">প্রোডাক্ট ম্যানেজমেন্ট</h1>
            <p class="text-xs text-slate-500 mt-1">সব পণ্য যোগ, এডিট এবং প্রতি পণ্যের জন্য ল্যান্ডিং পেজ তৈরি করুন</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                <span>+ নতুন প্রোডাক্ট যোগ করুন</span>
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">প্রোডাক্ট</th>
                        <th class="py-3 px-3">ক্যাটাগরি</th>
                        <th class="py-3 px-3">রেগুলার প্রাইজ</th>
                        <th class="py-3 px-3">সেল প্রাইজ</th>
                        <th class="py-3 px-3 text-center">স্টক</th>
                        <th class="py-3 px-3 text-center">ল্যান্ডিং পেজ</th>
                        <th class="py-3 px-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4 flex items-center gap-3">
                            <img src="{{ $product->thumbnail }}" class="w-12 h-12 object-cover rounded-xl border border-slate-200 flex-shrink-0" alt="{{ $product->name }}">
                            <div class="min-w-0">
                                <span class="font-bold text-slate-900 block truncate max-w-xs">{{ $product->name }}</span>
                                <span class="text-[11px] text-slate-400">SKU: {{ $product->sku ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-3">
                            <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-[11px] font-semibold">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-slate-500 line-through">
                            ৳ {{ number_format($product->regular_price) }}
                        </td>
                        <td class="py-3 px-3 font-black text-emerald-700 text-sm">
                            ৳ {{ number_format($product->sale_price) }}
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($product->stock > 10)
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">{{ $product->stock }} টি</span>
                            @else
                            <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[10px] font-bold">মাত্র {{ $product->stock }} টি</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center">
                            @if($product->landingPages->isNotEmpty())
                            <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-800 text-[10px] font-bold">
                                {{ $product->landingPages->count() }} টি পেজ
                            </span>
                            @else
                            <span class="text-slate-400 text-[10px]">নেই</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right space-x-1 whitespace-nowrap">
                            <!-- Direct Shortcut to Create Landing Page for THIS product -->
                            <a href="{{ route('admin.landing-pages.create') }}?product_id={{ $product->id }}" 
                               class="px-2.5 py-1.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg text-xs font-bold transition-all inline-block shadow-sm">
                                🚀 Landing Page
                            </a>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 rounded-lg text-xs font-bold transition-colors inline-block">
                                এডিট
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিত এই প্রোডাক্টটি মুছে ফেলতে চান?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg text-xs font-bold transition-colors">
                                    মুছুন
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">কোনো প্রোডাক্ট যোগ করা হয়নি।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection
