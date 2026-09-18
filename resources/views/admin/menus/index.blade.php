@extends('admin.layout')

@section('title', 'হেডার নেভিগেশন মেনু ও অ্যানাউন্সমেন্ট সেটিংস - ডিমান্ডহাট বিডি')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto pb-16">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <div class="flex items-center gap-2">
                <span class="p-2 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-md text-base">🧭</span>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">হেডার মেনু ও অ্যানাউন্সমেন্ট বার</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">ওয়েবসাইটের শীর্ষ অ্যানাউন্সমেন্ট বার চালু/বন্ধ, মেনু আইটেম যোগ/মুছে ফেলা এবং মেনু সেন্টারে বসানোর সেটিংস।</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" 
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all border border-slate-300 shadow-sm">
                <span>ওয়েবসাইটে দেখুন</span>
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm animate-fade-in">
        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.menus.update') }}" method="POST" id="menuSettingsForm" class="space-y-8">
        @csrf

        <!-- ============================================================= -->
        <!-- 1. TOP ANNOUNCEMENT BAR CONTROL (ON / OFF & TEXT)             -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-wrap gap-2">
                <div>
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">📢</span>
                        <span>টপ অ্যানাউন্সমেন্ট বার (অন / অফ টগল ও টেক্সট)</span>
                    </h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">চালু (ON) রাখলে পেজের শীর্ষে অ্যানিমেটেড নোটিশ বার আসবে, আর বন্ধ (OFF) করলে বারটি প্রদর্শিত হবে না।</p>
                </div>

                <label class="relative inline-flex items-center cursor-pointer select-none">
                    <input type="checkbox" name="announcement_active" value="1" id="announcementToggle"
                           {{ $announcementActive ? 'checked' : '' }} 
                           class="sr-only peer" onchange="toggleAnnouncementPreview(this.checked)">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                    <span id="toggleStatusLabel" class="ml-3 text-xs font-black {{ $announcementActive ? 'text-emerald-700' : 'text-slate-500' }}">
                        {{ $announcementActive ? 'চালু (ON)' : 'বন্ধ (OFF)' }}
                    </span>
                </label>
            </div>

            <!-- Announcement Input & Live Animated Preview -->
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">অ্যানাউন্সমেন্ট বার টেক্সট</label>
                    <input type="text" name="announcement_text" id="announcementInput"
                           value="{{ old('announcement_text', $announcementText) }}" 
                           placeholder="🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!" 
                           class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5"
                           oninput="updateAnnouncementPreview(this.value)">
                </div>

                <!-- Animated Preview Banner -->
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">লাইভ অ্যানিমেশন প্রিভিউ:</span>
                    <div id="announcementPreviewContainer" class="{{ $announcementActive ? '' : 'opacity-40 grayscale' }} transition-all">
                        <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white py-2 px-4 rounded-xl shadow-inner overflow-hidden text-center flex items-center justify-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping flex-shrink-0"></span>
                            <span id="announcementPreviewText" class="text-xs font-bold tracking-wide animate-pulse">
                                {{ $announcementText }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 2. MENU ALIGNMENT / POSITIONING (CENTER vs LEFT)             -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs font-bold">📐</span>
                    <span>নেভিগেশন মেনুর অবস্থান (Menu Alignment - সেন্টারে বসানোর অপশন)</span>
                </h3>
                <p class="text-[11px] text-slate-500 mt-0.5">মেনু আইটেমগুলো পেজের মাঝখানে (সেন্টারে) নাকি বামে সাজানো থাকবে তা নির্বাচন করুন।</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Center Aligned Option (Recommended) -->
                <label class="flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer transition-all hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/70">
                    <input type="radio" name="header_nav_alignment" value="center" 
                           {{ $alignment === 'center' ? 'checked' : '' }} 
                           class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"
                           onchange="updateLiveMockupAlignment('center')">
                    <div class="space-y-0.5">
                        <span class="text-xs font-black text-slate-900 flex items-center gap-1.5">
                            <span>মাঝখানে সারিবদ্ধ (Center-aligned)</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">রিকমেন্ডেড ⭐</span>
                        </span>
                        <p class="text-[11px] text-slate-500">সকল মেনু আইটেম বার-এর ঠিক সেন্টারে সুন্দরভাবে বিন্যস্ত থাকবে।</p>
                    </div>
                </label>

                <!-- Left Aligned Option -->
                <label class="flex items-center gap-3 p-4 border-2 rounded-2xl cursor-pointer transition-all hover:border-emerald-500 has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/70">
                    <input type="radio" name="header_nav_alignment" value="left" 
                           {{ $alignment === 'left' ? 'checked' : '' }} 
                           class="w-4 h-4 text-emerald-600 focus:ring-emerald-500"
                           onchange="updateLiveMockupAlignment('left')">
                    <div class="space-y-0.5">
                        <span class="text-xs font-black text-slate-900">বাম পাশে সারিবদ্ধ (Left-aligned)</span>
                        <p class="text-[11px] text-slate-500">মেনু আইটেমগুলো বাম প্রান্ত থেকে শুরু হবে।</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 3. NAVIGATION MENU ITEMS LIST & ADD/REMOVE MANAGER           -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3 flex-wrap gap-2">
                <div>
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">📋</span>
                        <span>মেনু আইটেম ম্যানেজার (Add / Remove / Reorder)</span>
                    </h3>
                    <p class="text-[11px] text-slate-500 mt-0.5">এখানে নতুন মেনু আইটেম যোগ করুন অথবা অপ্রয়োজনীয় মেনু ডিলিট (Remove) করুন।</p>
                </div>

                <button type="button" onclick="restoreDefaultMenuItems()" 
                        class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors border border-slate-300">
                    ↺ ডিফল্ট মেনু রিস্টোর করুন
                </button>
            </div>

            <!-- Quick Add Categories Shortcuts -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2">
                <span class="text-xs font-bold text-slate-700 block">⚡ দ্রুত ক্যাটাগরি মেনুতে যোগ করুন (১-ক্লিক শর্টকাট):</span>
                <div class="flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                    <button type="button" onclick="addCategoryToMenu('{{ $cat->name }}', '/products?category={{ $cat->slug }}')"
                            class="px-2.5 py-1 bg-white hover:bg-emerald-50 border border-slate-300 hover:border-emerald-500 rounded-lg text-xs text-slate-700 font-semibold transition-all flex items-center gap-1 shadow-2xs cursor-pointer">
                        <span>+</span>
                        <span>{{ $cat->name }}</span>
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Form to Add Custom Menu Item -->
            <div class="p-4 bg-emerald-50/50 rounded-xl border border-emerald-200/70 space-y-3">
                <span class="text-xs font-black text-emerald-900 block">➕ নতুন মেনু আইটেম যোগ করুন:</span>
                <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">ইমোজি/আইকন</label>
                        <input type="text" id="new_icon" placeholder="যেমন: 🌿" 
                               class="w-full text-xs rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white text-center">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">মেনু নাম (Title) <span class="text-rose-500">*</span></label>
                        <input type="text" id="new_title" placeholder="যেমন: হট ডিলস" 
                               class="w-full text-xs font-bold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white">
                    </div>
                    <div class="sm:col-span-4">
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">টার্গেট লিংক (URL) <span class="text-rose-500">*</span></label>
                        <input type="text" id="new_url" placeholder="যেমন: /products?flash=1" 
                               class="w-full text-xs font-mono rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 p-2.5 bg-white">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="button" onclick="addNewMenuItem()" 
                                class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow transition-all cursor-pointer">
                            + যোগ করুন
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table / Draggable List of Menu Items -->
            <div class="border border-slate-200 rounded-xl overflow-hidden shadow-2xs">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200 uppercase tracking-wider text-[10px]">
                            <th class="p-3 w-12 text-center">ক্রম</th>
                            <th class="p-3 w-20 text-center">আইকন</th>
                            <th class="p-3">মেনু নাম</th>
                            <th class="p-3">টার্গেট লিংক (URL)</th>
                            <th class="p-3 w-20 text-center">সক্রিয়</th>
                            <th class="p-3 w-24 text-center">মুছে ফেলুন</th>
                        </tr>
                    </thead>
                    <tbody id="menuItemsContainer" class="divide-y divide-slate-100">
                        @foreach($menuItems as $idx => $item)
                        <tr class="hover:bg-slate-50/70 transition-colors menu-item-row" data-index="{{ $idx }}">
                            <!-- Order Reordering Controls -->
                            <td class="p-2.5 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" onclick="moveItemUp(this)" title="উপরে নিন" class="p-1 text-slate-400 hover:text-slate-700 font-bold cursor-pointer">▲</button>
                                    <button type="button" onclick="moveItemDown(this)" title="নিচে নিন" class="p-1 text-slate-400 hover:text-slate-700 font-bold cursor-pointer">▼</button>
                                </div>
                            </td>

                            <!-- Icon Input -->
                            <td class="p-2.5 text-center">
                                <input type="text" name="menu_items[{{ $idx }}][icon]" value="{{ $item['icon'] ?? '' }}" 
                                       class="w-12 text-center text-xs p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                                       oninput="updateMockupPreview()">
                            </td>

                            <!-- Title Input -->
                            <td class="p-2.5">
                                <input type="text" name="menu_items[{{ $idx }}][title]" value="{{ $item['title'] ?? '' }}" required
                                       class="w-full text-xs font-bold p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                                       oninput="updateMockupPreview()">
                                <input type="hidden" name="menu_items[{{ $idx }}][id]" value="{{ $item['id'] ?? ('m_'.$idx) }}">
                            </td>

                            <!-- URL Input -->
                            <td class="p-2.5">
                                <input type="text" name="menu_items[{{ $idx }}][url]" value="{{ $item['url'] ?? '' }}" required
                                       class="w-full text-xs font-mono p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                                       oninput="updateMockupPreview()">
                            </td>

                            <!-- Active Toggle -->
                            <td class="p-2.5 text-center">
                                <input type="checkbox" name="menu_items[{{ $idx }}][is_active]" value="1" 
                                       {{ !empty($item['is_active']) ? 'checked' : '' }} 
                                       class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500"
                                       onchange="updateMockupPreview()">
                            </td>

                            <!-- Remove Button -->
                            <td class="p-2.5 text-center">
                                <button type="button" onclick="removeMenuItem(this)" 
                                        class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-xs transition-colors cursor-pointer"
                                        title="এই মেনুটি মুছে ফেলুন">
                                    🗑️ রিমুভ
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- 4. LIVE STOREFRONT NAVBAR PREVIEW                            -->
        <!-- ============================================================= -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
            <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                <span>👁️ লাইভ স্টোরফ্রন্ট প্রিভিউ (Navbar Mockup):</span>
            </span>

            <!-- Mockup container -->
            <div class="border border-slate-300 rounded-2xl overflow-hidden shadow-sm bg-slate-50">
                <nav class="bg-slate-100 border-t border-slate-200 px-4 py-2.5 overflow-x-auto whitespace-nowrap">
                    <div id="mockupNavItems" class="max-w-7xl mx-auto flex items-center gap-6 text-xs sm:text-sm font-medium text-slate-700 {{ $alignment === 'center' ? 'justify-center' : 'justify-start' }}">
                        <!-- Mockup Items Dynamically Rendered by JS -->
                    </div>
                </nav>
            </div>
        </div>

        <!-- Sticky Bottom Bar with Save Button -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-2xl flex items-center justify-between">
            <div class="flex items-center gap-2 text-xs text-slate-600 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>পরিবর্তন শেষে নিচের বাটনে ক্লিক করুন।</span>
            </div>

            <button type="submit" 
                    class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-sm rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all flex items-center gap-2 active:scale-95 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>মেনু ও বার পরিবর্তন সেভ করুন 💾</span>
            </button>
        </div>
    </form>
</div>

<script>
    // Live update announcement preview
    function toggleAnnouncementPreview(active) {
        const container = document.getElementById('announcementPreviewContainer');
        const label = document.getElementById('toggleStatusLabel');
        if (active) {
            container.classList.remove('opacity-40', 'grayscale');
            label.textContent = 'চালু (ON)';
            label.className = 'ml-3 text-xs font-black text-emerald-700';
        } else {
            container.classList.add('opacity-40', 'grayscale');
            label.textContent = 'বন্ধ (OFF)';
            label.className = 'ml-3 text-xs font-black text-slate-500';
        }
    }

    function updateAnnouncementPreview(text) {
        const preview = document.getElementById('announcementPreviewText');
        if (preview) preview.textContent = text || '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!';
    }

    function updateLiveMockupAlignment(align) {
        const mockup = document.getElementById('mockupNavItems');
        if (!mockup) return;
        mockup.classList.remove('justify-center', 'justify-start', 'justify-end');
        if (align === 'center') mockup.classList.add('justify-center');
        else mockup.classList.add('justify-start');
    }

    // Menu item row management
    let itemCounter = {{ count($menuItems) + 10 }};

    function reindexMenuRows() {
        const rows = document.querySelectorAll('.menu-item-row');
        rows.forEach((row, idx) => {
            row.setAttribute('data-index', idx);
            const iconIn = row.querySelector('input[name*="[icon]"]');
            const titleIn = row.querySelector('input[name*="[title]"]');
            const urlIn = row.querySelector('input[name*="[url]"]');
            const idIn = row.querySelector('input[name*="[id]"]');
            const activeIn = row.querySelector('input[name*="[is_active]"]');

            if (iconIn) iconIn.name = `menu_items[${idx}][icon]`;
            if (titleIn) titleIn.name = `menu_items[${idx}][title]`;
            if (urlIn) urlIn.name = `menu_items[${idx}][url]`;
            if (idIn) idIn.name = `menu_items[${idx}][id]`;
            if (activeIn) activeIn.name = `menu_items[${idx}][is_active]`;
        });
        updateMockupPreview();
    }

    function moveItemUp(btn) {
        const row = btn.closest('tr');
        if (row && row.previousElementSibling) {
            row.parentNode.insertBefore(row, row.previousElementSibling);
            reindexMenuRows();
        }
    }

    function moveItemDown(btn) {
        const row = btn.closest('tr');
        if (row && row.nextElementSibling) {
            row.parentNode.insertBefore(row.nextElementSibling, row);
            reindexMenuRows();
        }
    }

    function removeMenuItem(btn) {
        const row = btn.closest('tr');
        if (row) {
            row.remove();
            reindexMenuRows();
        }
    }

    function addRowToTable(icon, title, url) {
        itemCounter++;
        const tbody = document.getElementById('menuItemsContainer');
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50/70 transition-colors menu-item-row';
        tr.innerHTML = `
            <td class="p-2.5 text-center">
                <div class="flex items-center justify-center gap-1">
                    <button type="button" onclick="moveItemUp(this)" title="উপরে নিন" class="p-1 text-slate-400 hover:text-slate-700 font-bold cursor-pointer">▲</button>
                    <button type="button" onclick="moveItemDown(this)" title="নিচে নিন" class="p-1 text-slate-400 hover:text-slate-700 font-bold cursor-pointer">▼</button>
                </div>
            </td>
            <td class="p-2.5 text-center">
                <input type="text" name="menu_items[${itemCounter}][icon]" value="${icon || ''}" 
                       class="w-12 text-center text-xs p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                       oninput="updateMockupPreview()">
            </td>
            <td class="p-2.5">
                <input type="text" name="menu_items[${itemCounter}][title]" value="${title || ''}" required
                       class="w-full text-xs font-bold p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                       oninput="updateMockupPreview()">
                <input type="hidden" name="menu_items[${itemCounter}][id]" value="m_${Date.now()}">
            </td>
            <td class="p-2.5">
                <input type="text" name="menu_items[${itemCounter}][url]" value="${url || ''}" required
                       class="w-full text-xs font-mono p-1.5 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white"
                       oninput="updateMockupPreview()">
            </td>
            <td class="p-2.5 text-center">
                <input type="checkbox" name="menu_items[${itemCounter}][is_active]" value="1" checked 
                       class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500"
                       onchange="updateMockupPreview()">
            </td>
            <td class="p-2.5 text-center">
                <button type="button" onclick="removeMenuItem(this)" 
                        class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg font-bold text-xs transition-colors cursor-pointer">
                    🗑️ রিমুভ
                </button>
            </td>
        `;
        tbody.appendChild(tr);
        reindexMenuRows();
    }

    function addNewMenuItem() {
        const iconIn = document.getElementById('new_icon');
        const titleIn = document.getElementById('new_title');
        const urlIn = document.getElementById('new_url');

        if (!titleIn.value.trim() || !urlIn.value.trim()) {
            alert('মেনুর নাম এবং টার্গেট লিংক উভয়ই আবশ্যক!');
            return;
        }

        addRowToTable(iconIn.value.trim(), titleIn.value.trim(), urlIn.value.trim());

        iconIn.value = '';
        titleIn.value = '';
        urlIn.value = '';
    }

    function addCategoryToMenu(name, url) {
        let icon = '🏷️';
        if (name.includes('মধু') || name.includes('অর্গানিক')) icon = '🌿';
        else if (name.includes('কিচেন') || name.includes('রান্না')) icon = '🍳';
        else if (name.includes('গ্যাজেট') || name.includes('ইলেকট্রনিক্স')) icon = '⚡';
        addRowToTable(icon, name, url);
    }

    function restoreDefaultMenuItems() {
        if (!confirm('ডিফল্ট ৫টি মেনু আইটেম রিস্টোর করতে চান?')) return;
        const tbody = document.getElementById('menuItemsContainer');
        tbody.innerHTML = '';
        const defaults = [
            { icon: '', title: 'হোমপেজ', url: '/' },
            { icon: '', title: 'সব প্রোডাক্ট', url: '/products' },
            { icon: '🌿', title: 'অর্গানিক ফুড', url: '/products?category=organic-products' },
            { icon: '🍳', title: 'হোম ও কিচেন', url: '/products?category=home-kitchen' },
            { icon: '⚡', title: 'ইলেকট্রনিক্স ও গ্যাজেট', url: '/products?category=electronics-gadgets' },
        ];
        defaults.forEach(d => addRowToTable(d.icon, d.title, d.url));
    }

    function updateMockupPreview() {
        const mockup = document.getElementById('mockupNavItems');
        if (!mockup) return;
        mockup.innerHTML = '';

        const rows = document.querySelectorAll('.menu-item-row');
        rows.forEach(row => {
            const active = row.querySelector('input[name*="[is_active]"]')?.checked;
            if (!active) return;
            const icon = row.querySelector('input[name*="[icon]"]')?.value || '';
            const title = row.querySelector('input[name*="[title]"]')?.value || '';
            const url = row.querySelector('input[name*="[url]"]')?.value || '#';

            const a = document.createElement('a');
            a.href = url;
            a.className = 'hover:text-emerald-600 flex items-center gap-1 cursor-pointer transition-colors';
            a.innerHTML = `${icon ? `<span>${icon}</span>` : ''} <span>${title}</span>`;
            mockup.appendChild(a);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateMockupPreview();
    });
</script>
@endsection
