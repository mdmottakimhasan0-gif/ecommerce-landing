@extends('admin.layout')

@section('title', 'ক্যাটাগরি ম্যানেজমেন্ট - এডমিন প্যানেল')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">ক্যাটাগরি ম্যানেজমেন্ট</h1>
            <p class="text-xs text-slate-500 mt-1">দোকানের সকল পণ্যের ক্যাটাগরি তৈরি ও পরিচালনা করুন</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left: Create Category Form (5 cols) -->
        <div class="lg:col-span-5">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">নতুন ক্যাটাগরি যোগ করুন</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">ক্যাটাগরির নাম <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="উদাঃ অর্গানিক ফুড" 
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">স্ল্যাগ (Slug)</label>
                        <input type="text" name="slug" placeholder="উদাঃ organic-food" 
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">কভার ইমেজ URL</label>
                        <input type="url" name="image" placeholder="https://..." 
                               class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">সংক্ষিপ্ত বিবরণ</label>
                        <textarea name="description" rows="2" placeholder="ক্যাটাগরির সংক্ষিপ্ত পরিচিতি" 
                                  class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition-colors">
                        ক্যাটাগরি সেভ করুন
                    </button>
                </form>
            </div>
        </div>

        <!-- Right: Category List (7 cols) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-50 text-slate-700 font-bold border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">ক্যাটাগরি</th>
                            <th class="py-3 px-3">স্ল্যাগ</th>
                            <th class="py-3 px-3 text-center">প্রোডাক্ট সংখ্যা</th>
                            <th class="py-3 px-4 text-right">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($categories as $cat)
                        <tr>
                            <td class="py-3 px-4 flex items-center gap-3">
                                @if($cat->image)
                                <img src="{{ $cat->image }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200" alt="">
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $cat->name }}</span>
                                    <span class="text-[11px] text-slate-400 line-clamp-1">{{ $cat->description }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-3 font-mono text-slate-600">{{ $cat->slug }}</td>
                            <td class="py-3 px-3 text-center">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-xs">
                                    {{ $cat->products_count }} টি
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline-block" onsubmit="return confirm('ক্যাটাগরি মুছে ফেলতে চান?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-bold">
                                        মুছুন
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
