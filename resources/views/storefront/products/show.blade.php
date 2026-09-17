@extends('layouts.app')

@section('title', $product->name . ' - ' . ($settings['store_name'] ?? 'DemandHat BD'))
@section('meta_description', $product->short_description ?? $product->name)
@section('og_image', $product->thumbnail)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-10">

    <!-- Breadcrumb -->
    <nav class="text-xs text-slate-500 flex items-center gap-2 overflow-x-auto whitespace-nowrap">
        <a href="{{ route('home') }}" class="hover:text-emerald-600">হোমপেজ</a>
        <span>/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-emerald-600">
            {{ $product->category->name }}
        </a>
        <span>/</span>
        <span class="text-slate-900 font-semibold truncate">{{ $product->name }}</span>
    </nav>

    <!-- Prominent Landing Page banner if available -->
    @if($landingPage = $product->landingPages()->where('status', 'published')->first())
    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-4 rounded-2xl text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3 text-center sm:text-left">
            <span class="text-3xl animate-bounce">🔥</span>
            <div>
                <h3 class="text-sm sm:text-base font-black">এই পণ্যের বিশেষ সেলস ল্যান্ডিং পেজ ও অফার দেখুন!</h3>
                <p class="text-xs text-emerald-100">ল্যাব টেস্ট ভিডিও, আনবক্সিং এবং এক্সক্লুসিভ গিফট অফার উপভোগ করুন।</p>
            </div>
        </div>
        <a href="{{ url('/' . $landingPage->slug) }}" class="px-5 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs rounded-xl shadow transition-transform hover:scale-105 whitespace-nowrap">
            স্পেশাল অফার পেজে যান 🚀
        </a>
    </div>
    @endif

    <!-- Main Product Showcase Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Left Column: Image Gallery -->
        <div class="space-y-4">
            <div class="relative rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-sm aspect-square">
                <img id="mainImage" src="{{ $product->thumbnail }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-all duration-300">
                @if($product->discount_percentage > 0)
                <span class="absolute top-3 left-3 bg-rose-600 text-white font-black text-xs px-3 py-1 rounded-lg shadow">
                    -{{ $product->discount_percentage }}% মূল্যছাড়
                </span>
                @endif
            </div>

            <!-- Gallery Thumbnails -->
            @if(!empty($product->gallery) && count($product->gallery) > 1)
            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                @foreach($product->gallery as $idx => $img)
                <button type="button" onclick="document.getElementById('mainImage').src='{{ $img }}'" 
                        class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border-2 border-slate-200 hover:border-emerald-500 focus:border-emerald-600 flex-shrink-0 transition-colors">
                    <img src="{{ $img }}" alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif

            <!-- Trust Points Badges -->
            <div class="grid grid-cols-3 gap-2 pt-2">
                <div class="bg-emerald-50 text-emerald-800 p-3 rounded-xl border border-emerald-200/60 text-center">
                    <span class="block text-lg">🛡️</span>
                    <span class="text-[11px] font-bold block mt-0.5">ক্যাশ অন ডেলিভারি</span>
                </div>
                <div class="bg-teal-50 text-teal-800 p-3 rounded-xl border border-teal-200/60 text-center">
                    <span class="block text-lg">⚡</span>
                    <span class="text-[11px] font-bold block mt-0.5">৪৮ ঘণ্টায় ডেলিভারি</span>
                </div>
                <div class="bg-amber-50 text-amber-800 p-3 rounded-xl border border-amber-200/60 text-center">
                    <span class="block text-lg">🔄</span>
                    <span class="text-[11px] font-bold block mt-0.5">চেক করে মূল্য পরিশোধ</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Product Info & Direct Fast Order Box -->
        <div class="space-y-6">
            <div>
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    {{ $product->category->name }}
                </span>
                <h1 class="text-xl sm:text-3xl font-black text-slate-900 leading-snug">
                    {{ $product->name }}
                </h1>
                <div class="flex items-center gap-4 mt-2 text-xs text-slate-500">
                    <span>SKU: <strong class="text-slate-700">{{ $product->sku ?? 'N/A' }}</strong></span>
                    <span>•</span>
                    <span class="text-emerald-600 font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        স্টক উপলব্ধ ({{ $product->stock }} টি বাকি)
                    </span>
                </div>
            </div>

            <!-- Pricing Block -->
            <div class="p-4 bg-slate-100/90 rounded-2xl flex items-baseline gap-3 border border-slate-200">
                <span class="text-2xl sm:text-4xl font-black text-emerald-700">
                    ৳ {{ number_format($product->sale_price) }}
                </span>
                @if($product->regular_price > $product->sale_price)
                <span class="text-sm sm:text-base text-slate-400 line-through">
                    ৳ {{ number_format($product->regular_price) }}
                </span>
                <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-200">
                    আপনি পাচ্ছেন ৳ {{ number_format($product->regular_price - $product->sale_price) }} সাশ্রয়!
                </span>
                @endif
            </div>

            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                {{ $product->short_description }}
            </p>

            <!-- Quantity Selector & Cart Trigger -->
            <div class="flex items-center gap-4 pt-2">
                <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden bg-white shadow-sm">
                    <button type="button" id="qtyMinus" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 font-bold text-slate-700">-</button>
                    <input type="number" id="productQty" value="1" min="1" max="20" class="w-12 text-center font-bold text-sm text-slate-800 border-x border-slate-200 py-2" readonly>
                    <button type="button" id="qtyPlus" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 font-bold text-slate-700">+</button>
                </div>
                <button type="button" 
                        class="btn-add-to-cart flex-1 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow-md transition-all duration-200 hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-slug="{{ $product->slug }}"
                        data-price="{{ $product->sale_price }}"
                        data-thumbnail="{{ $product->thumbnail }}">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span data-i18n="btn_add_to_cart">কার্টে যোগ করুন</span>
                </button>
            </div>

            <!-- Embedded Direct Cash-on-Delivery Fast Order Box -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border-2 border-emerald-500 shadow-xl space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm sm:text-base font-black text-slate-900 flex items-center gap-1.5">
                            <span>⚡</span> সরাসরি ক্যাশ অন ডেলিভারিতে অর্ডার করুন
                        </h3>
                        <p class="text-[11px] text-slate-500">নিচের তথ্যগুলো দিন, অগ্রিম কোনো টাকা দিতে হবে না।</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                        ১-ক্লিকে অর্ডার
                    </span>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                    <input type="hidden" id="formItemQty" name="items[0][quantity]" value="1">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">আপনার সম্পূর্ণ নাম <span class="text-rose-500">*</span></label>
                        <input type="text" name="customer_name" required placeholder="নাম লিখুন" 
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">সচল মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                        <input type="tel" name="phone" required placeholder="017XXXXXXXX" pattern="^(?:\+?88)?01[3-9]\d{8}$"
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ডেলিভারি ঠিকানা <span class="text-rose-500">*</span></label>
                        <textarea name="address" rows="2" required placeholder="থানা, জেলা এবং বিস্তারিত বাসার ঠিকানা লিখুন" 
                                  class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ডেলিভারি এলাকা <span class="text-rose-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center justify-between p-2.5 border border-slate-300 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_area" value="inside_dhaka" checked class="text-emerald-600 focus:ring-emerald-500 direct-area-radio">
                                    <span class="text-xs font-semibold text-slate-800">ঢাকা সিটি</span>
                                </div>
                                <span class="text-xs font-bold text-emerald-600">৳{{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                            </label>
                            <label class="flex items-center justify-between p-2.5 border border-slate-300 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50">
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="delivery_area" value="outside_dhaka" class="text-emerald-600 focus:ring-emerald-500 direct-area-radio">
                                    <span class="text-xs font-semibold text-slate-800">ঢাকার বাইরে</span>
                                </div>
                                <span class="text-xs font-bold text-emerald-600">৳{{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                            </label>
                        </div>
                    </div>

                    <!-- Direct Box Total -->
                    <div class="bg-slate-100 p-3 rounded-xl flex items-center justify-between text-sm">
                        <span class="text-slate-600 font-medium">সর্বমোট প্রদেয় টাকা:</span>
                        <span id="directBoxTotal" class="text-xl font-black text-emerald-700">
                            ৳ {{ number_format($product->sale_price + ($settings['delivery_inside_dhaka'] ?? 70)) }}
                        </span>
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all duration-200 hover:scale-[1.02] active:scale-95 text-center flex items-center justify-center gap-2 cursor-pointer">
                        <span data-i18n="confirm_order">অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি) 🛒</span>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Product Description & Feature Tabs -->
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="text-lg sm:text-xl font-black text-slate-900">পণ্যের বিস্তারিত বিবরণ ও বৈশিষ্ট্য</h3>
        </div>

        <div class="prose max-w-none text-xs sm:text-sm text-slate-700 leading-relaxed space-y-4">
            <p>{{ $product->description }}</p>

            @if(!empty($product->features) && count($product->features) > 0)
            <div class="pt-4">
                <h4 class="text-sm font-bold text-slate-900 mb-2">মূল বৈশিষ্ট্যসমূহ:</h4>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 list-none p-0">
                    @foreach($product->features as $feat)
                    <li class="flex items-center gap-2 p-2 rounded-lg bg-slate-50 border border-slate-200 text-xs">
                        <span class="text-emerald-600 font-bold">✓</span>
                        <span>{{ $feat }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
    <section class="space-y-4">
        <h3 class="text-lg sm:text-xl font-black text-slate-900">সম্পর্কিত পণ্যসমূহ</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($relatedProducts as $rel)
            <div class="bg-white rounded-2xl p-3 sm:p-4 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div class="relative rounded-xl overflow-hidden bg-slate-100 aspect-square mb-2">
                    <img src="{{ $rel->thumbnail }}" alt="{{ $rel->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-bold text-slate-900 hover:text-emerald-600 line-clamp-2">
                        {{ $rel->name }}
                    </a>
                    <span class="block text-sm font-black text-emerald-700 mt-1">৳ {{ number_format($rel->sale_price) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const qtyInput = document.getElementById('productQty');
    const formItemQty = document.getElementById('formItemQty');
    const directBoxTotal = document.getElementById('directBoxTotal');
    const basePrice = {{ $product->sale_price }};
    const insideRate = {{ $settings['delivery_inside_dhaka'] ?? 70 }};
    const outsideRate = {{ $settings['delivery_outside_dhaka'] ?? 130 }};

    const updateDirectTotal = () => {
        const qty = parseInt(qtyInput.value) || 1;
        if (formItemQty) formItemQty.value = qty;
        const isOutside = document.querySelector('.direct-area-radio[value="outside_dhaka"]:checked') !== null;
        const shipping = isOutside ? outsideRate : insideRate;
        const total = (basePrice * qty) + shipping;
        if (directBoxTotal) {
            directBoxTotal.textContent = `৳ ${total.toLocaleString('en-US')}`;
        }
    };

    document.getElementById('qtyMinus')?.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v > 1) {
            qtyInput.value = v - 1;
            updateDirectTotal();
        }
    });

    document.getElementById('qtyPlus')?.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v < 20) {
            qtyInput.value = v + 1;
            updateDirectTotal();
        }
    });

    document.querySelectorAll('.direct-area-radio').forEach(r => {
        r.addEventListener('change', updateDirectTotal);
    });
});
</script>
@endpush
