<!-- Embedded High-Converting Cash on Delivery Order Form -->
<div id="orderSection" class="lp-card rounded-3xl p-6 sm:p-10 shadow-2xl border-4 lp-primary-border space-y-6">
    <div class="text-center space-y-2 border-b border-white/10 pb-5">
        <span class="inline-block px-3 py-1 lp-badge font-bold text-xs rounded-full uppercase tracking-wider border">
            ১-মিনিটে অর্ডার করুন
        </span>
        <h2 class="text-xl sm:text-3xl font-black">
            {{ $block['title'] ?? 'অর্ডার করতে আপনার সঠিক তথ্য দিন' }}
        </h2>
        <p class="text-xs lp-muted-text">
            {{ $block['subtitle'] ?? 'পণ্য হাতে পেয়ে চেক করে ডেলিভারি ম্যানের কাছে মূল্য পরিশোধ করার সুবিধা (Cash On Delivery)' }}
        </p>
    </div>

    @if($errors->any())
    <div class="p-3.5 bg-rose-500/20 border border-rose-500/40 text-rose-200 text-xs rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('landing.order', $landingPage->slug) }}" method="POST" class="space-y-4">
        @csrf

        <!-- Product Summary Badge in Form -->
        <div class="flex items-center gap-3 p-3.5 bg-black/20 border border-white/10 rounded-2xl">
            <img src="{{ $product->thumbnail }}" class="w-14 h-14 object-cover rounded-xl border border-white/10" alt="{{ $product->name }}">
            <div class="flex-1 min-w-0">
                <h4 class="text-xs sm:text-sm font-bold truncate">{{ $product->name }}</h4>
                <span class="text-sm font-black lp-primary-text">৳ {{ number_format($product->sale_price) }}</span>
            </div>

            <!-- Quantity Adjuster -->
            <div class="flex items-center border border-white/20 rounded-xl overflow-hidden text-xs bg-black/40">
                <button type="button" id="lpMinus" class="px-2.5 py-1.5 hover:bg-white/10 font-bold">-</button>
                <input type="number" id="lpQty" name="quantity" value="1" min="1" max="20" class="w-9 text-center font-bold bg-transparent border-x border-white/20 py-1 text-inherit focus:outline-none" readonly>
                <button type="button" id="lpPlus" class="px-2.5 py-1.5 hover:bg-white/10 font-bold">+</button>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold mb-1">আপনার পূর্ণ নাম <span class="text-rose-400">*</span></label>
            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required placeholder="উদাঃ মোঃ আনিসুর রহমান" 
                   class="w-full px-4 py-2.5 text-sm bg-black/20 border border-white/20 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-inherit placeholder:text-gray-400">
        </div>

        <div>
            <label class="block text-xs font-bold mb-1">সচল মোবাইল নম্বর <span class="text-rose-400">*</span></label>
            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="017XXXXXXXX" pattern="^(?:\+?88)?01[3-9]\d{8}$"
                   class="w-full px-4 py-2.5 text-sm bg-black/20 border border-white/20 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-inherit placeholder:text-gray-400">
            <p class="text-[11px] lp-muted-text mt-1">অর্ডার নিশ্চিত করতে এই নম্বরে যোগাযোগ করা হবে।</p>
        </div>

        <div>
            <label class="block text-xs font-bold mb-1">সম্পূর্ণ ঠিকানা <span class="text-rose-400">*</span></label>
            <textarea name="address" rows="2" required placeholder="গ্রাম/রোড, বাসা/ফ্ল্যাট নং, থানা এবং জেলা" 
                      class="w-full px-4 py-2.5 text-sm bg-black/20 border border-white/20 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none text-inherit placeholder:text-gray-400">{{ old('address') }}</textarea>
        </div>

        <!-- Delivery Area Radio Selector -->
        <div>
            <label class="block text-xs font-bold mb-1.5">ডেলিভারি চার্জ নির্বাচন করুন <span class="text-rose-400">*</span></label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center justify-between p-3 border-2 border-white/10 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10">
                    <div class="flex items-center gap-2">
                        <input type="radio" name="delivery_area" value="inside_dhaka" checked class="text-emerald-600 focus:ring-emerald-500 lp-area-radio">
                        <span class="text-xs font-bold">ঢাকা সিটিতে</span>
                    </div>
                    <span class="text-xs font-bold lp-primary-text">৳{{ $settings['delivery_inside_dhaka'] ?? 70 }}</span>
                </label>
                <label class="flex items-center justify-between p-3 border-2 border-white/10 rounded-xl cursor-pointer hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/10">
                    <div class="flex items-center gap-2">
                        <input type="radio" name="delivery_area" value="outside_dhaka" class="text-emerald-600 focus:ring-emerald-500 lp-area-radio">
                        <span class="text-xs font-bold">ঢাকার বাইরে</span>
                    </div>
                    <span class="text-xs font-bold lp-primary-text">৳{{ $settings['delivery_outside_dhaka'] ?? 130 }}</span>
                </label>
            </div>
        </div>

        <!-- Total summary -->
        <div class="bg-black/30 p-4 rounded-2xl flex items-center justify-between border border-white/10">
            <span class="text-xs sm:text-sm lp-muted-text font-bold">সর্বমোট প্রদেয় টাকা (COD):</span>
            <span id="lpGrandTotal" class="text-xl sm:text-2xl font-black lp-primary-text">
                ৳ {{ number_format($product->sale_price + ($settings['delivery_inside_dhaka'] ?? 70)) }}
            </span>
        </div>

        <!-- Big CTA Submit Button -->
        <button type="submit" class="w-full py-4 lp-primary-btn font-black text-base sm:text-lg rounded-2xl shadow-xl transition-all text-center flex items-center justify-center gap-2 active:scale-98">
            <span>{{ $block['buttonText'] ?? 'অর্ডার নিশ্চিত করুন (ক্যাশ অন ডেলিভারি) 🛒' }}</span>
        </button>

        <div class="text-center text-[11px] lp-muted-text">
            <span>{{ $block['guarantee'] ?? '🔒 অগ্রিম কোনো টাকা দিতে হবে না। প্রোডাক্ট চেক করে সম্পূর্ণ টাকা দিন।' }}</span>
        </div>
    </form>
</div>
