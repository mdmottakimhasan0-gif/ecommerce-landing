<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>@yield('title', 'এডমিন প্যানেল - DemandHat BD')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900 min-h-screen flex selection:bg-emerald-500 selection:text-white">

    <!-- Sidebar Navigation (Sticky at top, full screen height, stays in place when page scrolls) -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col border-r border-slate-800 sticky top-0 h-screen">
        <!-- Brand Header -->
        <div class="p-4 border-b border-slate-800 flex items-center justify-between flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-black text-lg shadow">
                    D
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-white block leading-none">DEMAND<span class="text-emerald-400">HAT</span></span>
                    <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider">এডমিন প্যানেল</span>
                </div>
            </a>
        </div>

        <!-- Navigation Links (Compact, fits cleanly) -->
        <nav class="flex-1 p-3 space-y-1 text-xs font-semibold overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>ড্যাশবোর্ড</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">ই-কমার্স ম্যানেজমেন্ট</div>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span>প্রোডাক্টস (Products)</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                <span>ক্যাটাগরি (Categories)</span>
            </a>

            <a href="{{ route('admin.banners.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>হোম ব্যানার (Hero Banners)</span>
            </a>

            <a href="{{ route('admin.menus.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.menus.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <span>হেডার মেনু ও বার (Navbar)</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>অর্ডারসমূহ (Orders)</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400">ল্যান্ডিং পেজ ইঞ্জিন</div>

            <a href="{{ route('admin.landing-pages.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.landing-pages.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <div class="flex-1 flex items-center justify-between">
                    <span>ল্যান্ডিং পেজসমূহ</span>
                    <span class="bg-amber-400 text-slate-950 text-[9px] font-black px-1.5 py-0.2 rounded uppercase">বিল্ডার</span>
                </div>
            </a>

            <a href="{{ route('admin.templates.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.templates.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                <span>টেমপ্লেট লাইব্রেরি</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400">কনফিগারেশন</div>

            <a href="{{ route('admin.couriers.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.couriers.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                <span>কুরিয়ার ও শিপিং</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>পিক্সেল ও সেটিংস (Pixel/GTM)</span>
            </a>
        </nav>

        <!-- Sidebar Footer (Pinned to the bottom via mt-auto) -->
        <div class="p-3 border-t border-slate-800 space-y-1.5 flex-shrink-0 mt-auto">
            <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-colors">
                <span>ওয়েবসাইট দেখুন</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-1 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-lg text-xs font-semibold transition-colors">
                    <span>লগআউট</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Content Container -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Admin Header -->
        <header class="bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-xs font-black tracking-wide text-slate-700 uppercase" data-bn="ম্যানেজমেন্ট কনসোল" data-en="Management Console">ম্যানেজমেন্ট কনসোল</span>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                @yield('top_actions')

                <div class="flex items-center gap-2 text-xs font-bold text-slate-700 pl-2 border-l border-slate-200">
                    <span class="w-7 h-7 rounded-full bg-slate-200 text-slate-800 flex items-center justify-center font-black text-xs">A</span>
                    <span class="hidden sm:inline">Super Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-6 sm:p-8 max-w-7xl w-full mx-auto space-y-6">
            @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl text-xs font-bold flex items-center justify-between">
                <span>✓ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-black">✕</button>
            </div>
            @endif

            @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-300 text-rose-800 rounded-2xl text-xs font-bold flex items-center justify-between">
                <span>✕ {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-black">✕</button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Global Admin Scripts (Bilingual Engine) -->
    <script>
        function setLanguage(lang) {
            localStorage.setItem('admin_orders_lang', lang);

            const btnBn = document.getElementById('btnLangBn');
            const btnEn = document.getElementById('btnLangEn');

            if (btnBn && btnEn) {
                if (lang === 'en') {
                    btnEn.className = 'px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer bg-slate-900 text-white shadow-xs';
                    btnBn.className = 'px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer text-slate-600 hover:text-slate-900';
                } else {
                    btnBn.className = 'px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer bg-slate-900 text-white shadow-xs';
                    btnEn.className = 'px-2.5 py-1 rounded-lg transition-all flex items-center gap-1 cursor-pointer text-slate-600 hover:text-slate-900';
                }
            }

            // Translate textContent for elements with data-bn and data-en
            document.querySelectorAll('[data-bn][data-en]').forEach(el => {
                el.textContent = (lang === 'en') ? el.getAttribute('data-en') : el.getAttribute('data-bn');
            });

            // Translate placeholders
            document.querySelectorAll('[data-placeholder-bn][data-placeholder-en]').forEach(el => {
                el.placeholder = (lang === 'en') ? el.getAttribute('data-placeholder-en') : el.getAttribute('data-placeholder-bn');
            });

            // Translate titles / tooltips
            document.querySelectorAll('[data-title-bn][data-title-en]').forEach(el => {
                el.title = (lang === 'en') ? el.getAttribute('data-title-en') : el.getAttribute('data-title-bn');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('admin_orders_lang') || 'bn';
            setLanguage(savedLang);
        });
    </script>

    @stack('scripts')
</body>
</html>
