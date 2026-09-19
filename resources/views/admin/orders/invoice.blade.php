<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>চালান #{{ $order->order_number }} - {{ $settings['store_name'] ?? 'DemandHat BD' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Hind Siliguri', 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm 12mm;
            }
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .invoice-paper {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10">

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print max-w-3xl mx-auto mb-6 px-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" 
               class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                ← অর্ডার বিবরণীতে ফিরুন
            </a>
            <a href="{{ route('admin.orders.sticker', $order->id) }}" 
               class="px-3.5 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-200 text-purple-700 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                <span>🏷️</span> পার্সেল স্টিকার দেখুন
            </a>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" 
                    class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-all shadow-md active:scale-95 flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>ইনভয়েস প্রিন্ট করুন</span>
            </button>
        </div>
    </div>

    <!-- Clean Printable Invoice Paper -->
    <div class="invoice-paper max-w-3xl mx-auto bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl space-y-6">

        <!-- Store & Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 pb-6 border-b-2 border-slate-800">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-emerald-400 font-black text-xl flex items-center justify-center">
                        D
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-slate-900">
                        {{ $settings['store_name'] ?? 'DemandHat BD' }}
                    </h1>
                </div>
                <p class="text-xs text-slate-500 font-medium">{{ $settings['store_tagline'] ?? 'সেরা মূল্যে প্রিমিয়াম কোয়ালিটি পণ্য' }}</p>
                <div class="text-xs text-slate-600 space-y-0.5 pt-1">
                    <div><strong>ঠিকানা:</strong> {{ $settings['store_address'] ?? 'ঢাকা, বাংলাদেশ' }}</div>
                    <div><strong>হটলাইন:</strong> {{ $settings['store_phone'] ?? '01712-345678' }} | {{ $settings['store_email'] ?? 'support@demandhatbd.com' }}</div>
                </div>
            </div>

            <div class="text-left sm:text-right space-y-1.5">
                <div class="inline-block px-3 py-1 bg-slate-900 text-white rounded-lg text-xs font-black tracking-wider uppercase">
                    INVOICE / ক্যাশ মেমো
                </div>
                <div class="font-mono text-base font-black text-slate-900">#{{ $order->order_number }}</div>
                <div class="text-xs text-slate-600">তারিখ: {{ $order->created_at->format('d M, Y - h:i A') }}</div>
                
                <div class="text-xs pt-1">
                    <span class="text-slate-500">পেমেন্ট: </span>
                    <strong class="text-slate-800">
                        @if($order->payment_method === 'bkash')
                            🌸 বিকাশ (bKash)
                        @elseif($order->payment_method === 'nagad')
                            🔶 নগদ (Nagad)
                        @else
                            🚚 ক্যাশ অন ডেলিভারি (COD)
                        @endif
                    </strong>
                </div>
                <div>
                    @if($order->payment_status === 'paid')
                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[11px] font-bold border border-emerald-300">
                        ✓ পরিশোধিত (PAID)
                    </span>
                    @else
                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-900 text-[11px] font-bold border border-amber-300">
                        ⏳ ক্যাশ অন ডেলিভারি (বকেয়া)
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Bill To Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs">
            <div class="space-y-1">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">বিল প্রাপকের তথ্য (Customer Details)</span>
                <div>নাম: <strong class="text-slate-900 text-sm">{{ $order->customer_name }}</strong></div>
                <div>ফোন নম্বর: <strong class="text-slate-900 text-sm font-mono">{{ $order->phone }}</strong></div>
            </div>
            <div class="space-y-1">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px] block">ডেলিভারি ঠিকানা ও এলাকা</span>
                <div>ঠিকানা: <span class="text-slate-800 font-medium">{{ $order->address }}</span></div>
                <div>এলাকা: <strong>{{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটি (Inside Dhaka)' : 'ঢাকার বাইরে (Outside Dhaka)' }}</strong></div>
                @if($order->notes)
                <div class="text-slate-600 italic">নোট: "{{ $order->notes }}"</div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div>
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-800 font-bold border-y-2 border-slate-300">
                        <th class="py-2.5 px-3 w-10 text-center">#</th>
                        <th class="py-2.5 px-3">পণ্যের বিবরণ</th>
                        <th class="py-2.5 px-3 text-center w-20">পরিমাণ</th>
                        <th class="py-2.5 px-3 text-right w-28">মূল্য (৳)</th>
                        <th class="py-2.5 px-3 text-right w-28">মোট টাকা (৳)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td class="py-3 px-3 text-center text-slate-500 font-mono">{{ $index + 1 }}</td>
                        <td class="py-3 px-3">
                            <span class="font-bold text-slate-900 text-sm block">{{ $item->product_name }}</span>
                            @if($item->product && $item->product->sku)
                            <span class="text-[10px] text-slate-400 font-mono">SKU: {{ $item->product->sku }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center font-bold text-slate-800 font-mono text-sm">{{ $item->quantity }}</td>
                        <td class="py-3 px-3 text-right text-slate-700 font-mono">৳ {{ number_format($item->price) }}</td>
                        <td class="py-3 px-3 text-right font-black text-slate-900 font-mono">৳ {{ number_format($item->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Financial Summary -->
        <div class="flex flex-col sm:flex-row justify-between items-start gap-6 pt-2">
            <div class="text-xs text-slate-500 max-w-sm space-y-1">
                <span class="font-bold text-slate-700 block">শর্তাবলী ও নির্দেশনা:</span>
                <p>১. পণ্য ডেলিভারি নেওয়ার সময় রাইডারের সামনে চেক করে বুঝে নিন।</p>
                <p>২. যেকোনো অভিযোগ বা প্রয়োজনে আমাদের হটলাইনে যোগাযোগ করুন।</p>
                <p class="font-semibold text-emerald-700 pt-1">ধন্যবাদ! আমাদের সাথে কেনাকাটা করার জন্য।</p>
            </div>

            <div class="w-full sm:w-64 space-y-2 text-xs">
                <div class="flex items-center justify-between text-slate-600">
                    <span>পণ্য সাবটোটাল:</span>
                    <span class="font-mono font-bold text-slate-800">৳ {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex items-center justify-between text-slate-600">
                    <span>ডেলিভারি চার্জ:</span>
                    <span class="font-mono font-bold text-slate-800">৳ {{ number_format($order->delivery_charge) }}</span>
                </div>
                
                <div class="pt-2 border-t-2 border-slate-300 flex items-center justify-between font-black text-sm text-slate-900">
                    <span>সর্বমোট প্রদেয় বিল:</span>
                    <span class="font-mono text-base text-slate-900">৳ {{ number_format($order->total) }}</span>
                </div>

                @if($order->payment_status === 'paid')
                <div class="p-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 font-bold flex items-center justify-between">
                    <span>পরিশোধিত টাকা:</span>
                    <span class="font-mono">৳ {{ number_format($order->total) }}</span>
                </div>
                <div class="flex items-center justify-between font-black text-slate-900">
                    <span>বকেয়া (COD):</span>
                    <span class="font-mono text-emerald-600">৳ 0.00</span>
                </div>
                @else
                <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-300 font-black text-slate-900 flex items-center justify-between">
                    <span>ক্যাশ অন ডেলিভারি (COD):</span>
                    <span class="font-mono text-base text-emerald-700">৳ {{ number_format($order->total) }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Signature Section -->
        <div class="pt-10 flex items-center justify-between text-xs text-slate-600 border-t border-slate-200">
            <div class="text-center">
                <div class="w-36 border-t border-dashed border-slate-400 mb-1"></div>
                <span>গ্রাহকের স্বাক্ষর</span>
            </div>
            <div class="text-center">
                <div class="w-36 border-t border-dashed border-slate-400 mb-1"></div>
                <span class="font-bold text-slate-800">অনুমোদিত স্বাক্ষর ও সিল</span>
            </div>
        </div>

    </div>

</body>
</html>
