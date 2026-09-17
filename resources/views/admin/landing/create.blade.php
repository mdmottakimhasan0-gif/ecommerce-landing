@extends('admin.layout')

@section('title', 'নতুন ল্যান্ডিং পেজ তৈরি করুন - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Breadcrumb & Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <a href="{{ route('admin.landing-pages.index') }}" class="hover:text-emerald-600">ল্যান্ডিং পেজসমূহ</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">নতুন তৈরি</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">নতুন প্রোডাক্ট ল্যান্ডিং পেজ তৈরি করুন</h1>
            <p class="text-xs text-slate-500 mt-0.5">যেকোনো প্রোডাক্ট সিলেক্ট করে উচ্চ-কনভার্সন বিশিষ্ট ডেডিকেটেড সেলস পেজ তৈরি করুন।</p>
        </div>

        <a href="{{ route('admin.landing-pages.index') }}" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold rounded-xl transition-colors">
            ← ফিরে যান
        </a>
    </div>

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl text-xs space-y-1">
        <div class="font-bold flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span>অনুগ্রহ করে নিচের ত্রুটিগুলো সংশোধন করুন:</span>
        </div>
        <ul class="list-disc list-inside pl-2 space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.landing-pages.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card 1: Product Selection & Basic Info -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">1</span>
                    <span>টার্গেট প্রোডাক্ট ও মৌলিক তথ্য</span>
                </h3>
                <p class="text-[11px] text-slate-400 ml-8">যে প্রোডাক্টের জন্য ল্যান্ডিং পেজ তৈরি করতে চান তা নির্বাচন করুন।</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Select Product -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">টার্গেট প্রোডাক্ট নির্বাচন করুন <span class="text-rose-500">*</span></label>
                    <select name="product_id" id="productSelect" required class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-slate-50 font-medium">
                        <option value="">-- প্রোডাক্ট নির্বাচন করুন --</option>
                        @foreach($products as $prod)
                        <option value="{{ $prod->id }}" 
                                data-name="{{ $prod->name }}" 
                                data-slug="{{ $prod->slug }}" 
                                data-category="{{ $prod->category->slug ?? '' }}"
                                {{ old('product_id') == $prod->id ? 'selected' : '' }}>
                            {{ $prod->name }} — [{{ $prod->category->name ?? 'Uncategorized' }}] — ৳{{ number_format($prod->sale_price) }} (স্টক: {{ $prod->stock }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Page Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ল্যান্ডিং পেজের শিরোনাম/নাম <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="pageName" value="{{ old('name') }}" required 
                           placeholder="উদাঃ সুন্দরবনের খাঁটি মধু - স্পেশাল অফার" 
                           class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5">
                    <span class="text-[10px] text-slate-400 mt-1 block">এটি আপনার এডমিন ও এসইও টাইটেলে ব্যবহৃত হবে।</span>
                </div>

                <!-- URL Slug -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">ইউআরএল স্ল্যাগ (URL Slug) <span class="text-rose-500">*</span></label>
                    <div class="flex rounded-xl shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-300 bg-slate-100 text-slate-500 text-xs font-mono">
                            /
                        </span>
                        <input type="text" name="slug" id="pageSlug" value="{{ old('slug') }}" required 
                               placeholder="pure-honey-offer" 
                               class="flex-1 min-w-0 block w-full text-xs rounded-none rounded-r-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 font-mono">
                    </div>
                    <span class="text-[10px] text-slate-400 mt-1 block">লাইভ লিঙ্ক হবেঃ <strong class="text-emerald-700 font-mono" id="slugPreview">demandhatbd.com/your-slug</strong></span>
                </div>
            </div>
        </div>

        <!-- Card 2: Choose Template -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">2</span>
                    <span>স্টাটিং টেমপ্লেট নির্বাচন করুন (Starting Template)</span>
                </h3>
                <p class="text-[11px] text-slate-400 ml-8">আপনার পছন্দের ডিজাইন প্রি-সেট নির্বাচন করুন, যা পরবর্তীতে ভিজ্যুয়াল বিল্ডারে পরিবর্তন করতে পারবেন।</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Blank Canvas Option -->
                <label class="relative flex flex-col p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40">
                    <input type="radio" name="template_id" value="" {{ empty(old('template_id')) ? 'checked' : '' }} class="sr-only">
                    <div class="w-full aspect-video rounded-xl bg-slate-200 flex flex-col items-center justify-center text-slate-500 mb-3 border border-slate-300">
                        <svg class="w-8 h-8 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span class="text-[10px] font-bold">খালি ক্যানভাস</span>
                    </div>
                    <span class="text-xs font-black text-slate-900">ব্ল্যাঙ্ক ক্যানভাস (Blank)</span>
                    <span class="text-[10px] text-slate-500 mt-0.5">স্ক্র্যাচ থেকে উইজেট ড্র্যাগ করে পেজ সাজান।</span>
                </label>

                <!-- Templates from DB -->
                @foreach($templates as $tmpl)
                <label class="relative flex flex-col p-4 bg-slate-50 rounded-2xl border-2 border-slate-200 hover:border-emerald-500 cursor-pointer transition-all has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/40">
                    <input type="radio" name="template_id" value="{{ $tmpl->id }}" {{ old('template_id') == $tmpl->id ? 'checked' : '' }} class="sr-only">
                    <div class="w-full aspect-video rounded-xl bg-slate-900 overflow-hidden mb-3 border border-slate-700 relative">
                        <img src="{{ $tmpl->thumbnail }}" alt="{{ $tmpl->name }}" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                        <span class="absolute bottom-1 right-1 px-1.5 py-0.5 bg-black/70 text-emerald-300 text-[9px] font-bold rounded">
                            {{ ucfirst($tmpl->category) }}
                        </span>
                    </div>
                    <span class="text-xs font-black text-slate-900 truncate">{{ $tmpl->name }}</span>
                    <span class="text-[10px] text-slate-500 mt-0.5 line-clamp-2">{{ $tmpl->description ?? 'উচ্চ-কনভার্সন প্রি-মেড লেআউট' }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Card 3: Publishing Status -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">3</span>
                    <span>স্ট্যাটাস ও প্রকাশনা</span>
                </h3>
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-800">
                    <input type="radio" name="status" value="published" checked class="text-emerald-600 focus:ring-emerald-500">
                    <span>সরাসরি লাইভ পাবলিশ করুন (Published)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-600">
                    <input type="radio" name="status" value="draft" class="text-emerald-600 focus:ring-emerald-500">
                    <span>ড্রাফট হিসেবে সংরক্ষণ করুন (Draft)</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.landing-pages.index') }}" class="px-5 py-3 text-slate-600 hover:text-slate-800 text-xs font-bold">
                বাতিল করুন
            </a>
            <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs rounded-xl shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center gap-2">
                <span>ল্যান্ডিং পেজ তৈরি ও ভিজ্যুয়াল বিল্ডারে প্রবেশ করুন</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const prodSelect = document.getElementById('productSelect');
        const pageName = document.getElementById('pageName');
        const pageSlug = document.getElementById('pageSlug');
        const slugPreview = document.getElementById('slugPreview');

        prodSelect?.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (!opt || !opt.value) return;

            const name = opt.getAttribute('data-name');
            const slug = opt.getAttribute('data-slug');

            if (!pageName.value) {
                pageName.value = name + ' - স্পেশাল ধামাকা অফার';
            }
            if (!pageSlug.value) {
                pageSlug.value = slug + '-offer';
                updateSlugPreview();
            }
        });

        pageSlug?.addEventListener('input', updateSlugPreview);

        function updateSlugPreview() {
            const val = pageSlug.value.trim().toLowerCase().replace(/[^a-z0-9-_]/g, '-');
            slugPreview.textContent = 'demandhatbd.com/' + (val || 'your-slug');
        }
    });
</script>
@endpush
