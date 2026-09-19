<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডেলিভারি স্টিকার #{{ $order->order_number }} - {{ $settings['store_name'] ?? 'DemandHat BD' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Libre+Barcode+128&family=Poppins:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    <style>
        body {
            font-family: 'Hind Siliguri', 'Poppins', sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .barcode-font {
            font-family: 'Libre Barcode 128', cursive;
            font-size: 48px;
            line-height: 1;
            letter-spacing: 2px;
        }

        /* 4" x 6" standard parcel shipping label dimensions (100mm x 150mm) */
        .parcel-label {
            width: 105mm;
            min-height: 148mm;
            box-sizing: border-box;
            background: #ffffff;
        }

        @media print {
            @page {
                size: 105mm 150mm;
                margin: 0;
            }
            body {
                background-color: #ffffff !important;
                color: #000000 !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .parcel-label {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 4mm !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10">

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print max-w-md mx-auto mb-6 px-4 flex items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" 
               class="px-3.5 py-2 rounded-xl bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                ← অর্ডার বিবরণী
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" 
               class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-800 text-xs font-bold transition-all shadow-xs flex items-center gap-1.5">
                <span>📄</span> ইনভয়েস দেখুন
            </a>
        </div>

        <button onclick="window.print()" 
                class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition-all shadow-md active:scale-95 flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>স্টিকার প্রিন্ট</span>
        </button>
    </div>

    <!-- 4" x 6" / Thermal Standard Courier Parcel Label -->
    <div class="parcel-label mx-auto p-4 sm:p-5 border-2 border-slate-900 rounded-2xl shadow-xl space-y-3">

        <!-- Header: Merchant & Courier Info -->
        <div class="flex items-center justify-between pb-2.5 border-b-2 border-slate-900">
            <div>
                <div class="flex items-center gap-1.5">
                    <div class="w-6 h-6 rounded-lg bg-slate-900 text-white font-black text-xs flex items-center justify-center">D</div>
                    <strong class="text-sm font-black tracking-tight text-slate-900">{{ $settings['store_name'] ?? 'DemandHat BD' }}</strong>
                </div>
                <div class="text-[10px] text-slate-600 font-bold">হেল্পলাইন: {{ $settings['store_phone'] ?? '01712-345678' }}</div>
            </div>

            <div class="text-right">
                <span class="inline-block px-2 py-0.5 bg-slate-900 text-white text-[10px] font-black rounded uppercase tracking-wider">
                    {{ strtoupper($order->courier_name ?: 'PARCEL') }}
                </span>
                <div class="text-[9px] text-slate-500 font-mono mt-0.5">{{ $order->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <!-- Barcode & Tracking Section -->
        <div class="text-center py-1 bg-slate-50 border border-slate-300 rounded-xl space-y-0.5">
            <div class="barcode-font text-slate-900 select-none overflow-hidden h-12 leading-none">
                *{{ $order->order_number }}*
            </div>
            <div class="font-mono font-black text-xs tracking-wider text-slate-900">
                {{ $order->order_number }}
            </div>
            @if($order->courier_consignment_id)
            <div class="text-[10px] text-slate-600 font-mono font-bold">
                CID: {{ $order->courier_consignment_id }}
                @if($order->courier_tracking_code) | TRK: {{ $order->courier_tracking_code }} @endif
            </div>
            @endif
        </div>

        <!-- PROMINENT CASH ON DELIVERY (COD) BOX -->
        @if($order->payment_status === 'paid')
        <div class="p-2.5 bg-emerald-100 border-2 border-emerald-600 text-emerald-950 rounded-xl text-center">
            <div class="text-xs font-black uppercase tracking-wider">✓ PAID ORDER (পরিশোধিত)</div>
            <div class="text-lg font-black font-mono">DO NOT COLLECT CASH (৳ 0)</div>
        </div>
        @else
        <div class="p-2.5 bg-slate-950 text-white rounded-xl text-center shadow-xs">
            <div class="text-[11px] font-bold tracking-widest text-amber-300 uppercase">
                ক্যাশ অন ডেলিভারি (COD AMOUNT)
            </div>
            <div class="text-2xl font-black font-mono tracking-tight text-white mt-0.5">
                ৳ {{ number_format($order->total) }}
            </div>
        </div>
        @endif

        <!-- RECIPIENT DETAILS (প্রাপক) -->
        <div class="p-3 bg-slate-50 border-2 border-slate-300 rounded-xl space-y-1.5 text-xs">
            <div class="flex items-center justify-between border-b border-slate-200 pb-1">
                <span class="font-black text-slate-900 uppercase tracking-wide text-[11px]">প্রাপক (RECIPIENT):</span>
                <span class="px-2 py-0.5 rounded text-[10px] font-black {{ $order->delivery_area === 'inside_dhaka' ? 'bg-emerald-200 text-emerald-950' : 'bg-blue-200 text-blue-950' }}">
                    {{ $order->delivery_area === 'inside_dhaka' ? 'ঢাকা সিটি' : 'ঢাকার বাইরে' }}
                </span>
            </div>

            <div>
                <span class="text-slate-500 text-[11px] block">নাম:</span>
                <div class="font-black text-slate-900 text-sm">{{ $order->customer_name }}</div>
            </div>

            <div>
                <span class="text-slate-500 text-[11px] block">মোবাইল নম্বর:</span>
                <div class="font-black text-slate-900 text-base font-mono tracking-wide">{{ $order->phone }}</div>
            </div>

            <div>
                <span class="text-slate-500 text-[11px] block">ডেলিভারি ঠিকানা:</span>
                <div class="font-bold text-slate-800 leading-snug">{{ $order->address }}</div>
            </div>

            @if($order->notes)
            <div class="p-1.5 bg-amber-50 border border-amber-200 rounded text-[11px] text-amber-900 font-medium">
                <strong>নোট:</strong> {{ $order->notes }}
            </div>
            @endif
        </div>

        <!-- PACKAGE CONTENTS (পণ্য বিবরণী) -->
        <div class="p-2.5 bg-white border border-slate-300 rounded-xl text-[11px] space-y-1">
            <div class="flex items-center justify-between font-bold text-slate-700 border-b border-slate-100 pb-0.5">
                <span>পণ্য বিবরণ (Contents)</span>
                <span>মোট: {{ $order->items->sum('quantity') }} পিস</span>
            </div>
            <div class="space-y-0.5 pt-0.5">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between text-slate-800">
                    <span class="truncate max-w-[200px] font-medium">• {{ $item->product_name }}</span>
                    <span class="font-mono font-bold">x{{ $item->quantity }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- RETURN ADDRESS (প্রেরক) -->
        <div class="pt-2 border-t border-dashed border-slate-400 text-[10px] text-slate-600 flex items-start justify-between gap-2">
            <div>
                <strong>প্রেরক (Return To):</strong>
                <div>{{ $settings['store_name'] ?? 'DemandHat BD' }}</div>
                <div>{{ $settings['store_address'] ?? 'ঢাকা, বাংলাদেশ' }}</div>
            </div>
            <div class="text-right">
                <div>হটলাইন: <strong>{{ $settings['store_phone'] ?? '01712-345678' }}</strong></div>
                <div class="text-[9px] text-slate-400">DemandHat Logistics</div>
            </div>
        </div>

    </div>

</body>
</html>
