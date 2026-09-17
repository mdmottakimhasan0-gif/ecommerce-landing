@extends('admin.layout')

@section('title', 'টেমপ্লেট লাইব্রেরি - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">ল্যান্ডিং পেজ টেমপ্লেট লাইব্রেরি</h1>
            <p class="text-xs text-slate-500 mt-1">প্রি-মেড ও উচ্চ-কনভার্সন লেআউট দিয়ে যেকোনো পণ্যের জন্য দ্রুত ল্যান্ডিং পেজ তৈরি করুন।</p>
        </div>

        <button onclick="document.getElementById('newTemplateModal').classList.remove('hidden')" 
                class="px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-bold rounded-xl shadow transition-all flex items-center gap-2 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>নতুন টেমপ্লেট সেভ করুন</span>
        </button>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 text-xs overflow-x-auto">
        <button class="px-3 py-1.5 rounded-lg bg-slate-900 text-white font-bold" data-filter="all">সকল টেমপ্লেট (All)</button>
        <button class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50" data-filter="organic">🌿 অর্গানিক ও ফুড</button>
        <button class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50" data-filter="kitchen">🍳 হোম ও কিচেন</button>
        <button class="px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50" data-filter="gadgets">⚡ গ্যাজেট ও ইলেকট্রনিক্স</button>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $tmpl)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col group hover:border-emerald-500 transition-all" data-category="{{ $tmpl->category }}">
            <!-- Template Thumbnail & Preview -->
            <div class="aspect-video bg-slate-900 relative overflow-hidden">
                <img src="{{ $tmpl->thumbnail }}" alt="{{ $tmpl->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-90 group-hover:opacity-100">
                <div class="absolute top-3 left-3 px-2.5 py-1 bg-black/70 backdrop-blur-sm rounded-lg text-emerald-300 text-[10px] font-black uppercase tracking-wider border border-emerald-500/30">
                    {{ ucfirst($tmpl->category) }}
                </div>
            </div>

            <!-- Body -->
            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                <div>
                    <h3 class="font-black text-slate-900 text-sm group-hover:text-emerald-600 transition-colors">
                        {{ $tmpl->name }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">
                        {{ $tmpl->description ?? 'উচ্চ-কনভার্সন বিশিষ্ট প্রফেশনাল ডিজাইন, ক্যাশ অন ডেলিভারি ফর্ম ও ট্র্যাকিং রেডি।' }}
                    </p>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                    <form action="{{ route('admin.templates.destroy', $tmpl->id) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই টেমপ্লেটটি মুছে ফেলতে চান?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-semibold p-1">
                            মুছুন
                        </button>
                    </form>

                    <a href="{{ route('admin.landing-pages.create') }}?template_id={{ $tmpl->id }}" 
                       class="px-4 py-2 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5 shadow-sm">
                        <span>ব্যবহার করুন</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-2xl border border-slate-200 text-slate-500 text-xs">
            কোনো টেমপ্লেট পাওয়া যায়নি।
        </div>
        @endforelse
    </div>
</div>

<!-- Modal: Save New Template -->
<div id="newTemplateModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-slate-900 text-sm">নতুন টেমপ্লেট যুক্ত করুন</h3>
            <button onclick="document.getElementById('newTemplateModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-700">✕</button>
        </div>
        <form action="{{ route('admin.templates.store') }}" method="POST" class="p-5 space-y-4 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">টেমপ্লেটের নাম <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="যেমন: Organic Honey Mega Sales Page" class="w-full rounded-xl border-slate-300 p-2.5 text-xs">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">ক্যাটাগরি <span class="text-rose-500">*</span></label>
                <select name="category" required class="w-full rounded-xl border-slate-300 p-2.5 text-xs bg-slate-50">
                    <option value="organic">Organic Food & Grocery</option>
                    <option value="kitchen">Home & Kitchen</option>
                    <option value="gadgets">Electronics & Gadgets</option>
                    <option value="fashion">Fashion & Lifestyle</option>
                    <option value="general">General Physical Products</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">থাম্বনেইল ইমেজ ইউআরএল</label>
                <input type="url" name="thumbnail" placeholder="https://images.unsplash.com/photo-..." class="w-full rounded-xl border-slate-300 p-2.5 text-xs">
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-1">কনটেন্ট ব্লক (JSON)</label>
                <textarea name="content" rows="4" class="w-full font-mono text-[11px] rounded-xl border-slate-300 p-2.5" placeholder='[{"type":"product_hero","badge":"অফার"}]'>[{"type":"product_hero","badge":"🔥 বিশেষ অফার"},{"type":"product_price"},{"type":"order_form"}]</textarea>
            </div>
            <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('newTemplateModal').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl font-bold">বাতিল</button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow">সংরক্ষণ করুন</button>
            </div>
        </form>
    </div>
</div>
@endsection
