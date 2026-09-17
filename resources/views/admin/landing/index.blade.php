@extends('admin.layout')

@section('title', 'ল্যান্ডিং পেজসমূহ - এডমিন প্যানেল')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900">প্রোডাক্ট ল্যান্ডিং পেজসমূহ</h1>
            <p class="text-xs text-slate-500 mt-1">
                যেকোনো প্রোডাক্টের জন্য আলাদা বিজ্ঞাপন/সেলস ল্যান্ডিং পেজ তৈরি ও পরিচালনা করুন।
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.landing-pages.create') }}" class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-1.5">
                <span>+ নতুন ল্যান্ডিং পেজ তৈরি করুন</span>
            </a>
        </div>
    </div>

    <!-- Landing Pages Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">পেজের নাম ও ইউআরএল</th>
                        <th class="py-3 px-3">সংযুক্ত প্রোডাক্ট</th>
                        <th class="py-3 px-3 text-center">ভিউ</th>
                        <th class="py-3 px-3 text-center">অর্ডার</th>
                        <th class="py-3 px-3 text-right">মোট সেলস</th>
                        <th class="py-3 px-3 text-center">কনভার্সন</th>
                        <th class="py-3 px-3 text-center">স্ট্যাটাস</th>
                        <th class="py-3 px-4 text-right">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($landingPages as $lp)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="py-3 px-4">
                            <span class="font-bold text-slate-900 text-sm block">{{ $lp->name }}</span>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <a href="{{ url('/' . $lp->slug) }}" target="_blank" class="text-emerald-600 font-mono text-[11px] font-semibold hover:underline flex items-center gap-1">
                                    <span>/{{ $lp->slug }}</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </div>
                        </td>
                        <td class="py-3 px-3">
                            @if($lp->product)
                            <div class="flex items-center gap-2">
                                <img src="{{ $lp->product->thumbnail }}" class="w-8 h-8 object-cover rounded-lg border border-slate-200" alt="">
                                <div>
                                    <span class="font-bold text-slate-800 block truncate max-w-xs">{{ $lp->product->name }}</span>
                                    <span class="text-[10px] text-emerald-600 font-bold">৳ {{ number_format($lp->product->sale_price) }}</span>
                                </div>
                            </div>
                            @endif
                        </td>
                        <td class="py-3 px-3 text-center font-bold text-slate-700">{{ number_format($lp->views_count) }}</td>
                        <td class="py-3 px-3 text-center font-black text-emerald-600">{{ number_format($lp->orders_count) }}</td>
                        <td class="py-3 px-3 text-right font-black text-slate-900">৳ {{ number_format($lp->revenue_total) }}</td>
                        <td class="py-3 px-3 text-center font-black text-purple-700">{{ $lp->conversion_rate }}%</td>
                        <td class="py-3 px-3 text-center">
                            <form action="{{ route('admin.landing-pages.togglePublish', $lp->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-black transition-colors {{ $lp->status === 'published' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    {{ $lp->status === 'published' ? '● লাইভ (Live)' : '○ ড্রাফট (Draft)' }}
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4 text-right whitespace-nowrap space-x-1">
                            <!-- Open Visual Builder Button -->
                            <a href="{{ route('admin.landing-pages.builder', $lp->id) }}" class="px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold transition-all shadow inline-block">
                                🎨 বিল্ডার খুলুন
                            </a>
                            <a href="{{ url('/' . $lp->slug) }}" target="_blank" class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold transition-colors inline-block">
                                ভিউ
                            </a>
                            <form action="{{ route('admin.landing-pages.destroy', $lp->id) }}" method="POST" class="inline-block" onsubmit="return confirm('আপনি কি নিশ্চিত এই ল্যান্ডিং পেজটি মুছে ফেলতে চান?')">
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
                        <td colspan="8" class="py-8 text-center text-slate-400 space-y-2">
                            <p>এখনো কোনো ল্যান্ডিং পেজ তৈরি করা হয়নি।</p>
                            <a href="{{ route('admin.landing-pages.create') }}" class="inline-block text-xs font-bold text-emerald-600 underline">
                                প্রথম ল্যান্ডিং পেজ তৈরি করতে এখানে ক্লিক করুন →
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $landingPages->links() }}
        </div>
    </div>

</div>
@endsection
