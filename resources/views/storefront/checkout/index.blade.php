@extends('layouts.app')

@section('title', 'ক্যাশ অন ডেলিভারি চেকআউট - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6 text-center">
        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">ক্যাশ অন ডেলিভারি চেকআউট</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            অর্ডার নিশ্চিত করতে আপনার সঠিক নাম, ঠিকানা ও মোবাইল নম্বর দিন। পণ্য হাতে পেয়ে মূল্য পরিশোধ করুন।
        </p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
        <strong class="block font-bold">অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</strong>
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- Left Column: Customer Details (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">১</span>
                    <span>ডেলিভারি ও কাস্টমার তথ্য</span>
                </h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">আপনার পূর্ণ নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="উদাঃ মোঃ রহিম ইসলাম" 
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">মোবাইল নম্বর <span class="text-rose-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="উদাঃ 017XXXXXXXX" pattern="^(?:\+?88)?01[3-9]\d{8}$"
                           class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <p class="text-[11px] text-slate-500 mt-1">অর্ডার নিশ্চিত করতে এই নম্বরে এসএমএস বা ফোন করা হতে পারে।</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">ডেলিভারির সম্পূর্ণ ঠিকানা <span class="text-rose-500">*</span></label>
                    <textarea name="address" rows="3" required placeholder="গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা উল্লেখ করুন" 
                              class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('address') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ডেলিভারি এলাকা নির্বাচন করুন <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center justify-between p-3.5 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition-all">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="inside_dhaka" {{ old('delivery_area', 'inside_dhaka') === 'inside_dhaka' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 delivery-area-radio">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">ঢাকা সিটির ভেতরে</span>
                                    <span class="text-[10px] text-slate-500">২৪-৪৮ ঘণ্টায় হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-sm font-black text-emerald-700">৳ {{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                        </label>

                        <label class="flex items-center justify-between p-3.5 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/50 transition-all">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="delivery_area" value="outside_dhaka" {{ old('delivery_area') === 'outside_dhaka' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500 delivery-area-radio">
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">ঢাকা সিটির বাইরে</span>
                                    <span class="text-[10px] text-slate-500">সারাদেশে হোম ডেলিভারি</span>
                                </div>
                            </div>
                            <span class="text-sm font-black text-emerald-700">৳ {{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">অর্ডার নোট / বিশেষ নির্দেশনা (ঐচ্ছিক)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="যেমন: শুক্রবারে ডেলিভারি দিলে ভালো হয়" 
                           class="w-full px-4 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>
            </div>

            <!-- Payment Method: Cash on Delivery -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black">২</span>
                    <span>পেমেন্ট পদ্ধতি</span>
                </h3>
                <div class="p-4 rounded-2xl border-2 border-emerald-500 bg-emerald-50/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">💵</span>
                        <div>
                            <span class="text-xs sm:text-sm font-bold text-slate-900 block">ক্যাশ অন ডেলিভারি (Cash on Delivery)</span>
                            <span class="text-[11px] text-slate-600">পণ্য রিসিভ করার পর চেক করে ডেলিভারি ম্যানকে সম্পূর্ণ টাকা দিন।</span>
                        </div>
                    </div>
                    <span class="text-xs font-black text-emerald-700 bg-white px-2.5 py-1 rounded-full border border-emerald-300">ডিফল্ট</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-5 sticky top-24">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">
                    আপনার অর্ডারের বিবরণ
                </h3>

                <!-- Order items container -->
                <div id="checkoutItemsList" class="space-y-3 max-h-64 overflow-y-auto">
                    @if($buyNowProduct)
                    <!-- Direct Buy Now Product Item -->
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                        <img src="{{ $buyNowProduct->thumbnail }}" alt="{{ $buyNowProduct->name }}" class="w-14 h-14 object-cover rounded-xl border border-slate-200">
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-900 truncate">{{ $buyNowProduct->name }}</h4>
                            <p class="text-xs font-black text-emerald-600 mt-0.5">৳ {{ number_format($buyNowProduct->sale_price) }}</p>
                            <span class="text-[11px] text-slate-500">পরিমাণ: {{ $buyNowQty }} টি</span>
                        </div>
                        <input type="hidden" name="items[0][product_id]" value="{{ $buyNowProduct->id }}">
                        <input type="hidden" name="items[0][quantity]" value="{{ $buyNowQty }}">
                    </div>
                    @else
                    <!-- Injected via JavaScript from CartStore -->
                    <p id="checkoutLoadingNotice" class="text-xs text-slate-500 text-center py-4">শপিং ব্যাগ লোড হচ্ছে...</p>
                    @endif
                </div>

                <!-- Price Calculations -->
                <div class="space-y-2.5 pt-4 border-t border-slate-100 text-xs sm:text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>পণ্যের সাবটোটাল:</span>
                        <span id="checkoutSubtotal" class="font-bold text-slate-900">
                            @if($buyNowProduct)
                            ৳ {{ number_format($buyNowProduct->sale_price * $buyNowQty) }}
                            @else
                            ৳ 0
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>ডেলিভারি চার্জ:</span>
                        <span id="checkoutDelivery" class="font-bold text-slate-900">৳ {{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                    </div>
                    <div class="flex justify-between text-base sm:text-lg font-black text-slate-900 pt-3 border-t border-slate-200">
                        <span>সর্বমোট প্রদেয়:</span>
                        <span id="checkoutGrandTotal" class="text-emerald-700">
                            @if($buyNowProduct)
                            ৳ {{ number_format(($buyNowProduct->sale_price * $buyNowQty) + ($settings['delivery_inside_dhaka'] ?? 70)) }}
                            @else
                            ৳ 0
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitOrderBtn" class="w-full py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm sm:text-base rounded-2xl shadow-lg hover:shadow-emerald-500/25 transition-all flex items-center justify-center gap-2">
                    <span>অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি)</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

                <div class="text-center text-[11px] text-slate-400 space-y-1">
                    <p>🔒 আপনার সকল তথ্য সম্পূর্ণ সুরক্ষিত থাকবে।</p>
                    <p>পণ্য হাতে পেয়ে চেক করে নেওয়ার শতভাগ নিশ্চয়তা।</p>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isBuyNow = {{ $buyNowProduct ? 'true' : 'false' }};
    const buyNowPrice = {{ $buyNowProduct ? $buyNowProduct->sale_price : 0 }};
    const buyNowQty = {{ $buyNowQty }};
    const insideCharge = {{ $settings['delivery_inside_dhaka'] ?? 70 }};
    const outsideCharge = {{ $settings['delivery_outside_dhaka'] ?? 130 }};

    const checkoutItemsList = document.getElementById('checkoutItemsList');
    const checkoutSubtotal = document.getElementById('checkoutSubtotal');
    const checkoutDelivery = document.getElementById('checkoutDelivery');
    const checkoutGrandTotal = document.getElementById('checkoutGrandTotal');
    const form = document.getElementById('checkoutForm');

    const getShippingFee = () => {
        const isOutside = document.querySelector('.delivery-area-radio[value="outside_dhaka"]:checked') !== null;
        return isOutside ? outsideCharge : insideCharge;
    };

    const updateTotals = (subtotal) => {
        const shipping = getShippingFee();
        const total = subtotal + shipping;
        if (checkoutSubtotal) checkoutSubtotal.textContent = `৳ ${subtotal.toLocaleString('en-US')}`;
        if (checkoutDelivery) checkoutDelivery.textContent = `৳ ${shipping.toLocaleString('en-US')}`;
        if (checkoutGrandTotal) checkoutGrandTotal.textContent = `৳ ${total.toLocaleString('en-US')}`;
    };

    if (isBuyNow) {
        document.querySelectorAll('.delivery-area-radio').forEach(r => {
            r.addEventListener('change', () => {
                updateTotals(buyNowPrice * buyNowQty);
            });
        });
    } else {
        // Load items from window.cartStore
        const cartItems = window.cartStore ? window.cartStore.items : [];
        if (cartItems.length === 0) {
            checkoutItemsList.innerHTML = `
                <div class="text-center py-6 text-slate-400 space-y-2">
                    <p class="text-xs">আপনার শপিং ব্যাগে কোনো পণ্য নেই।</p>
                    <a href="{{ route('products.index') }}" class="inline-block text-xs font-bold text-emerald-600 underline">পণ্য পছন্দ করতে ক্লিক করুন</a>
                </div>
            `;
            document.getElementById('submitOrderBtn').disabled = true;
            document.getElementById('submitOrderBtn').classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            checkoutItemsList.innerHTML = '';
            cartItems.forEach((item, index) => {
                const el = document.createElement('div');
                el.className = 'flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200';
                el.innerHTML = `
                    <img src="${item.thumbnail || 'https://via.placeholder.com/80'}" class="w-12 h-12 object-cover rounded-xl border border-slate-200" alt="${item.name}">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-slate-900 truncate">${item.name}</h4>
                        <p class="text-xs font-black text-emerald-600 mt-0.5">৳ ${(item.price * item.quantity).toLocaleString('en-US')}</p>
                        <span class="text-[10px] text-slate-500">পরিমাণ: ${item.quantity} টি</span>
                    </div>
                    <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                `;
                checkoutItemsList.appendChild(el);
            });

            const sub = window.cartStore.getSubtotal();
            updateTotals(sub);

            document.querySelectorAll('.delivery-area-radio').forEach(r => {
                r.addEventListener('change', () => {
                    updateTotals(window.cartStore.getSubtotal());
                });
            });
        }
    }

    form.addEventListener('submit', () => {
        // Clear local storage cart upon order submission
        if (!isBuyNow && window.cartStore) {
            window.cartStore.clear();
        }
    });
});
</script>
@endpush
