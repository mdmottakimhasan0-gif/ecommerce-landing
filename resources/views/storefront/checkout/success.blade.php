@extends('layouts.app')

@section('title', 'অর্ডার সফল হয়েছে - ' . ($settings['store_name'] ?? 'DemandHat BD'))

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 space-y-8">
    <div id="celebrationSuccess"></div>

    <!-- Success Message Box -->
    <div class="bg-white p-6 sm:p-10 rounded-3xl border border-emerald-200 shadow-xl text-center space-y-4">
        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-3xl sm:text-4xl mx-auto shadow-inner animate-bounce">
            ✓
        </div>
        <div>
            <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                ক্যাশ অন ডেলিভারি অর্ডার গৃহীত
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900">
                ধন্যবাদ! আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে।
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                আমাদের প্রতিনিধি দ্রুত আপনার সাথে যোগাযোগ করে অর্ডারটি কনফার্ম করবে এবং পণ্যটি ডেলিভারিতে পাঠিয়ে দেবে।
            </p>
        </div>

        <!-- Order Number Badge -->
        <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 border border-slate-300 rounded-2xl">
            <span class="text-xs text-slate-600">অর্ডার নম্বর:</span>
            <span class="text-base font-black text-emerald-700 tracking-wider font-mono">{{ $order->order_number }}</span>
        </div>
    </div>

    <!-- Printable Invoice Details -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200">
            <h3 class="text-base font-bold text-slate-900">অর্ডারের সারসংক্ষেপ ও চালান</h3>
            <button onclick="window.print()" class="text-xs font-bold text-slate-600 hover:text-emerald-600 flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 hover:border-slate-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>চালান প্রিন্ট করুন</span>
            </button>
        </div>

        <!-- Customer details grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-200">
            <div>
                <span class="text-slate-500 block">গ্রাহকের নাম:</span>
                <strong class="text-slate-900 text-sm">{{ $order->customer_name }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block">মোবাইল নম্বর:</span>
                <strong class="text-slate-900 text-sm font-mono">{{ $order->phone }}</strong>
            </div>
            <div class="sm:col-span-2">
                <span class="text-slate-500 block">ডেলিভারি ঠিকানা:</span>
                <strong class="text-slate-900 leading-relaxed">{{ $order->address }}</strong>
                <span class="text-[11px] text-emerald-700 block mt-0.5 font-semibold">
                    ({{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটির ভেতরে' : 'ঢাকা সিটির বাইরে' }})
                </span>
            </div>
        </div>

        <!-- Ordered Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-100 text-slate-700 uppercase font-bold text-[11px] border-y border-slate-200">
                    <tr>
                        <th class="py-2.5 px-3">পণ্য</th>
                        <th class="py-2.5 px-3 text-center">পরিমাণ</th>
                        <th class="py-2.5 px-3 text-right">মূল্য</th>
                        <th class="py-2.5 px-3 text-right">মোট</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-3 px-3 flex items-center gap-3">
                            @if($item->product && $item->product->thumbnail)
                            <img src="{{ $item->product->thumbnail }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200" alt="{{ $item->product_name }}">
                            @endif
                            <span class="font-bold text-slate-800">{{ $item->product_name }}</span>
                        </td>
                        <td class="py-3 px-3 text-center font-bold text-slate-700">{{ $item->quantity }}</td>
                        <td class="py-3 px-3 text-right text-slate-600">৳ {{ number_format($item->price) }}</td>
                        <td class="py-3 px-3 text-right font-black text-slate-900">৳ {{ number_format($item->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-200 text-xs">
                    <tr>
                        <td colspan="3" class="pt-3 px-3 text-right text-slate-600">সাবটোটাল:</td>
                        <td class="pt-3 px-3 text-right font-bold text-slate-800">৳ {{ number_format($order->subtotal) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="py-1 px-3 text-right text-slate-600">ডেলিভারি চার্জ:</td>
                        <td class="py-1 px-3 text-right font-bold text-slate-800">৳ {{ number_format($order->delivery_charge) }}</td>
                    </tr>
                    <tr class="text-sm font-black">
                        <td colspan="3" class="pt-2 px-3 text-right text-slate-900">সর্বমোট প্রদেয় (COD):</td>
                        <td class="pt-2 px-3 text-right text-emerald-700 text-base">৳ {{ number_format($order->total) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Delivery Steps Progress -->
        <div class="pt-6 border-t border-slate-200 space-y-3">
            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">ডেলিভারি ট্র্যাকিং স্ট্যাটাস</h4>
            <div class="grid grid-cols-4 gap-2 text-center text-[10px] sm:text-xs">
                <div class="p-2 rounded-xl bg-emerald-100 text-emerald-800 font-bold border border-emerald-300">
                    <span class="block text-base">✓</span>
                    <span>অর্ডার গৃহীত</span>
                </div>
                <div class="p-2 rounded-xl bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                    <span class="block text-base">📦</span>
                    <span>প্রসেসিং</span>
                </div>
                <div class="p-2 rounded-xl bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                    <span class="block text-base">🚚</span>
                    <span>ডেলিভারিতে</span>
                </div>
                <div class="p-2 rounded-xl bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                    <span class="block text-base">🎉</span>
                    <span>ডেলিভার্ড</span>
                </div>
            </div>
        </div>

        <!-- Action Links -->
        <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <a href="{{ route('tracking.index') }}?query={{ $order->order_number }}" class="w-full sm:w-auto text-center px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-colors">
                📦 রিয়েলটাইম ট্র্যাক করুন
            </a>
            <a href="{{ route('home') }}" class="w-full sm:w-auto text-center px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition-colors">
                আরো শপিং করুন →
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Facebook Pixel & TikTok Purchase Event Firing
    if (window.fbq) {
        fbq('track', 'Purchase', {
            content_type: 'product',
            value: {{ $order->total }},
            currency: 'BDT'
        });
    }
    if (window.ttq) {
        ttq.track('CompletePayment', {
            value: {{ $order->total }},
            currency: 'BDT'
        });
    }
</script>
@endpush
@endsection
