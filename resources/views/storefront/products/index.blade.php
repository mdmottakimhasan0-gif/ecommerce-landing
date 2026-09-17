@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->name . ' - ' : '') . 'সব পণ্যসমূহ - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-6">

    <!-- Header & Category Filter Pills -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900">
                    {{ $currentCategory ? $currentCategory->name : 'সব প্রিমিয়াম পণ্যসমূহ' }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">
                    মোট {{ $products->total() }} টি পণ্য পাওয়া গেছে
                    @if(request('search'))
                    — অনুসন্ধান ফলাফল: "<span class="font-bold text-slate-800">{{ request('search') }}</span>"
                    @endif
                </p>
            </div>

            <!-- Sorting & Search Form -->
            <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-3">
                @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <label for="sort" class="text-xs font-semibold text-slate-600 whitespace-nowrap">সর্ট করুন:</label>
                <select name="sort" id="sort" onchange="this.form.submit()" class="text-xs font-semibold bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>নতুন পণ্য (Latest)</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>দাম: কম থেকে বেশি</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>দাম: বেশি থেকে কম</option>
                </select>
            </form>
        </div>

        <!-- Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap pt-2 border-t border-slate-100">
            <a href="{{ route('products.index', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" 
               class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors {{ !request('category') ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                সবগুলো (All)
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('products.index', array_filter(['category' => $cat->slug, 'search' => request('search'), 'sort' => request('sort')])) }}" 
               class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-colors {{ request('category') === $cat->slug ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ $cat->name }} ({{ $cat->products_count }})
            </a>
            @endforeach
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->isEmpty())
    <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 max-w-md mx-auto space-y-3">
        <span class="text-4xl block">🔍</span>
        <h3 class="text-base font-bold text-slate-800">কোনো পণ্য পাওয়া যায়নি</h3>
        <p class="text-xs text-slate-500">অন্য কোনো কি-ওয়ার্ড দিয়ে খুঁজুন অথবা সব ক্যাটাগরি ব্রাউজ করুন।</p>
        <a href="{{ route('products.index') }}" class="inline-block mt-2 text-xs font-bold text-emerald-600 bg-emerald-50 px-4 py-2 rounded-lg hover:bg-emerald-100">
            সব পণ্য দেখুন →
        </a>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-2xl p-3 sm:p-4 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col justify-between group">
            <div class="relative rounded-xl overflow-hidden bg-slate-100 aspect-square mb-2 sm:mb-3">
                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @if($product->discount_percentage > 0)
                <span class="absolute top-2 left-2 bg-rose-600 text-white font-black text-[10px] sm:text-xs px-2 py-0.5 rounded shadow">
                    -{{ $product->discount_percentage }}%
                </span>
                @endif
                @if($product->landingPages()->where('status', 'published')->exists())
                <a href="{{ url('/' . $product->landingPages()->where('status', 'published')->first()->slug) }}" 
                   class="absolute bottom-2 left-2 bg-emerald-600/95 hover:bg-emerald-700 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md flex items-center gap-1 backdrop-blur-sm">
                    <span>🚀 স্পেশাল অফার</span>
                </a>
                @endif
            </div>

            <div class="flex-1 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] sm:text-xs text-emerald-600 font-semibold">{{ $product->category->name }}</span>
                    <a href="{{ route('products.show', $product->slug) }}" class="block text-xs sm:text-sm font-bold text-slate-900 hover:text-emerald-600 transition-colors line-clamp-2 mt-0.5 leading-snug">
                        {{ $product->name }}
                    </a>
                </div>

                <div class="mt-2.5 pt-2.5 border-t border-slate-100">
                    <div class="flex items-baseline gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                        <span class="text-base sm:text-lg font-black text-emerald-700">৳ {{ number_format($product->sale_price) }}</span>
                        @if($product->regular_price > $product->sale_price)
                        <span class="text-[11px] sm:text-xs text-slate-400 line-through">৳ {{ number_format($product->regular_price) }}</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 sm:gap-2">
                        <button type="button" 
                                class="btn-quick-buy w-full py-1.5 sm:py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg shadow-sm hover:shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->sale_price }}"
                                data-thumbnail="{{ $product->thumbnail }}">
                            <span data-i18n="order_now">অর্ডার করুন</span>
                        </button>
                        <button type="button" 
                                class="btn-add-to-cart w-full py-1.5 sm:py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold rounded-lg transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center cursor-pointer"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-slug="{{ $product->slug }}"
                                data-price="{{ $product->sale_price }}"
                                data-thumbnail="{{ $product->thumbnail }}">
                            <span data-i18n="add_to_cart_short">+ কার্ট</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pt-6">
        {{ $products->links() }}
    </div>
    @endif

</div>
@endsection
