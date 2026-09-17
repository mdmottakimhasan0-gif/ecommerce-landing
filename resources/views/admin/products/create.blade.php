@extends('admin.layout')

@section('title', 'নতুন প্রোডাক্ট যোগ করুন - এডমিন প্যানেল')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">নতুন প্রোডাক্ট যোগ করুন</h1>
            <p class="text-xs text-slate-500 mt-1">প্রোডাক্টের বিবরণ ও মূল্য প্রদান করুন</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
            ← তালিকায় ফিরে যান
        </a>
    </div>

    @if($errors->any())
    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">প্রোডাক্টের নাম <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="উদাঃ সুন্দরবনের খাঁটি চাকের মধু" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ক্যাটাগরি <span class="text-rose-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="">ক্যাটাগরি নির্বাচন করুন</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">SKU কোড</label>
                <input type="text" name="sku" value="{{ old('sku') }}" placeholder="উদাঃ ORG-HNY-01" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">রেগুলার প্রাইজ (৳) <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price') }}" required placeholder="১২৫০" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">বিক্রয় মূল্য / অফার প্রাইজ (৳) <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" required placeholder="৮৯০" 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">স্টক পরিমাণ <span class="text-rose-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 50) }}" required 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">থাম্বনেইল ইমেজ URL <span class="text-rose-500">*</span></label>
                <input type="url" name="thumbnail" value="{{ old('thumbnail') }}" required placeholder="https://images.unsplash.com/..." 
                       class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">গ্যালারি ইমেজ URLs (প্রতি লাইনে ১টি লিঙ্ক)</label>
                <textarea name="gallery_input" rows="3" placeholder="https://image1.jpg&#10;https://image2.jpg" 
                          class="w-full px-4 py-2 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('gallery_input') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ (Short Description)</label>
                <textarea name="short_description" rows="2" placeholder="১-২ লাইনে পণ্যের আকর্ষনীয় বিবরণ" 
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('short_description') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">বিস্তারিত বিবরণ (Full Description)</label>
                <textarea name="description" rows="4" placeholder="পণ্যের সম্পূর্ণ গুণাগুণ ও ব্যবহারের নিয়ম" 
                          class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-700 mb-1">মূল বৈশিষ্ট্য ও বুলেটের তালিকা (প্রতি লাইনে ১টি)</label>
                <textarea name="features_input" rows="3" placeholder="১০০% খাঁটি ও ভেজালমুক্ত&#10;ল্যাব টেস্টে পরীক্ষিত&#10;ক্যাশ অন ডেলিভারি" 
                          class="w-full px-4 py-2 text-xs border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('features_input') }}</textarea>
            </div>

            <div class="md:col-span-2 flex flex-wrap items-center gap-6 pt-2 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>সক্রিয় প্রোডাক্ট (Active)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>ফিচার্ড প্রোডাক্ট (Featured)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                    <input type="checkbox" name="is_flash_deal" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>ফ্ল্যাশ সেল ডিসকাউন্টে যোগ করুন</span>
                </label>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition-colors">
                প্রোডাক্ট সংরক্ষণ করুন
            </button>
        </div>
    </form>

</div>
@endsection
