<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(app()->environment('production'))
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <title>@yield('title', 'Admin Panel - DemandHat BD')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" rel="stylesheet">

    <script>
        // Immediately set theme to avoid FOUC
        (function() {
            const theme = localStorage.getItem('theme_preference') || localStorage.getItem('admin_theme') || 'system';
            const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <style>
        @media print {
            aside,
            header.admin-top-header,
            .admin-top-header,
            .no-print,
            nav,
            button,
            form,
            .modal,
            [role="dialog"],
            #adminLangToggleBtn,
            #adminThemeToggleBtn,
            #adminThemeMenu {
                display: none !important;
            }

            body, main, .max-w-7xl, .max-w-4xl {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-slate-100 dark:bg-[#0b1120] text-slate-900 dark:text-slate-100 h-screen overflow-hidden flex flex-col md:flex-row selection:bg-emerald-500 selection:text-white transition-colors duration-200">

    <!-- Mobile Header (Visible on md:hidden) -->
    <div class="md:hidden bg-slate-900 text-white p-3 border-b border-slate-800 flex items-center justify-between flex-shrink-0 z-30">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-black text-sm shadow">D</div>
            <div>
                <span class="text-sm font-black tracking-tight text-white block leading-none">DEMAND<span class="text-emerald-400">HAT</span></span>
                <span class="text-[9px] text-emerald-400 font-bold uppercase tracking-wider" data-bn="এডমিন প্যানেল" data-en="Admin Panel">Admin Panel</span>
            </div>
        </a>
        <button type="button" onclick="toggleAdminMobileSidebar(true)" class="p-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white cursor-pointer" title="Toggle Navigation">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <!-- Backdrop for Mobile Sidebar -->
    <div id="adminSidebarBackdrop" onclick="toggleAdminMobileSidebar(false)" class="fixed inset-0 bg-black/60 z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar Navigation (Desktop: Fixed 100% height, Mobile: Off-canvas drawer) -->
    <aside id="adminSidebar" class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 fixed inset-y-0 left-0 z-50 transform -translate-x-full md:relative md:translate-x-0 md:flex flex-col border-r border-slate-800 h-full transition-transform duration-200">
        <!-- Brand Header -->
        <div class="p-4 border-b border-slate-800 flex items-center justify-between flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-black text-lg shadow">
                    D
                </div>
                <div>
                    <span class="text-lg font-black tracking-tight text-white block leading-none">DEMAND<span class="text-emerald-400">HAT</span></span>
                    <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider" data-bn="এডমিন প্যানেল" data-en="Admin Panel">Admin Panel</span>
                </div>
            </a>
            <button type="button" onclick="toggleAdminMobileSidebar(false)" class="md:hidden text-slate-400 hover:text-white p-1">
                ✕
            </button>
        </div>

        <!-- Navigation Links (Independent inner scroll if links exceed viewport) -->
        <nav class="flex-1 p-3 space-y-1 text-xs font-semibold overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span data-bn="ড্যাশবোর্ড" data-en="Dashboard">Dashboard</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400" data-bn="ই-কমার্স ম্যানেজমেন্ট" data-en="eCommerce Management">eCommerce Management</div>

            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span data-bn="প্রোডাক্টস" data-en="Products">Products</span>
            </a>

            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                <span data-bn="ক্যাটাগরি" data-en="Categories">Categories</span>
            </a>

            <a href="{{ route('admin.banners.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.banners.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span data-bn="হোম ব্যানার" data-en="Hero Banners">Hero Banners</span>
            </a>

            <a href="{{ route('admin.menus.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.menus.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <span data-bn="হেডার মেনু ও বার" data-en="Header & Navbar">Header & Navbar</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span data-bn="অর্ডারসমূহ" data-en="Orders">Orders</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400" data-bn="ল্যান্ডিং পেজ ইঞ্জিন" data-en="Landing Page Engine">Landing Page Engine</div>

            <a href="{{ route('admin.landing-pages.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.landing-pages.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <div class="flex-1 flex items-center justify-between">
                    <span data-bn="ল্যান্ডিং পেজসমূহ" data-en="Landing Pages">Landing Pages</span>
                    <span class="bg-amber-400 text-slate-950 text-[9px] font-black px-1.5 py-0.2 rounded uppercase" data-bn="বিল্ডার" data-en="Builder">Builder</span>
                </div>
            </a>

            <a href="{{ route('admin.templates.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.templates.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                <span data-bn="টেমপ্লেট লাইব্রেরি" data-en="Template Library">Template Library</span>
            </a>

            <div class="pt-2 pb-0.5 px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400" data-bn="কনফিগারেশন" data-en="Configuration">Configuration</div>

            <a href="{{ route('admin.couriers.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.couriers.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                <span data-bn="কুরিয়ার ও শিপিং" data-en="Courier & Shipping">Courier & Shipping</span>
            </a>

            <a href="{{ route('admin.payments.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.payments.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                <span data-bn="পেমেন্ট ও হিস্ট্রি" data-en="Payments & History">Payments & History</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-600 text-white shadow' : 'hover:bg-slate-800 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span data-bn="পিক্সেল ও সেটিংস" data-en="Pixel & Settings">Pixel & Settings</span>
            </a>
        </nav>

        <!-- Sidebar Footer (Pinned to the bottom via mt-auto) -->
        <div class="p-3 border-t border-slate-800 space-y-1.5 flex-shrink-0 mt-auto">
            <a href="{{ route('home') }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-white rounded-xl text-xs font-bold transition-colors">
                <span data-bn="ওয়েবসাইট দেখুন" data-en="View Website">View Website</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-1 text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 rounded-lg text-xs font-semibold transition-colors cursor-pointer">
                    <span data-bn="লগআউট" data-en="Logout">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Admin Content Container (Independently scrollable) -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto">
        <!-- Top Admin Header -->
        <header class="admin-top-header bg-white dark:bg-[#111827] border-b border-slate-200 dark:border-slate-800 px-4 sm:px-6 py-3 flex items-center justify-between transition-colors flex-shrink-0 sticky top-0 z-30 shadow-xs">
            <div class="flex items-center gap-2.5">
                <button type="button" onclick="toggleAdminMobileSidebar(true)" class="md:hidden p-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-slate-900 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-xs font-black tracking-wide text-slate-700 dark:text-slate-300 uppercase" data-bn="ম্যানেজমেন্ট কনসোল" data-en="Management Console">Management Console</span>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap">
                @yield('top_actions')

                <!-- Global Language Switcher (EN ↔ BN) -->
                <div class="flex items-center gap-1">
                    <button type="button" id="adminLangToggleBtn" onclick="toggleAdminLang()" class="px-2.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs" title="Switch Language">
                        <span id="adminLangIcon">🇧🇩</span>
                        <span id="adminLangLabel">বাংলা</span>
                    </button>
                    <button type="button" id="btnLangBn" onclick="setAdminLanguage('bn')" class="hidden"></button>
                    <button type="button" id="btnLangEn" onclick="setAdminLanguage('en')" class="hidden"></button>
                </div>

                <!-- Global 3-Mode Theme Selector (Light, Dark, System) -->
                <div class="relative" id="adminThemeDropdownWrapper">
                    <button type="button" id="adminThemeToggleBtn" onclick="toggleAdminThemeMenu()" class="px-2.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-xs" title="Theme (Light / Dark / System)">
                        <span id="adminThemeIcon">💻</span>
                        <span id="adminThemeLabel">System</span>
                        <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div id="adminThemeMenu" class="hidden absolute right-0 mt-1.5 w-32 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg p-1 z-50 text-xs font-bold space-y-0.5">
                        <button type="button" onclick="selectAdminThemeMode('light')" class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-left cursor-pointer">
                            <span>☀️</span> <span data-bn="লাইট মোড" data-en="Light">Light</span>
                        </button>
                        <button type="button" onclick="selectAdminThemeMode('dark')" class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-left cursor-pointer">
                            <span>🌙</span> <span data-bn="ডার্ক মোড" data-en="Dark">Dark</span>
                        </button>
                        <button type="button" onclick="selectAdminThemeMode('system')" class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-left cursor-pointer">
                            <span>💻</span> <span data-bn="সিস্টেম মোড" data-en="System">System</span>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-xs font-bold text-slate-700 dark:text-slate-200 pl-2 border-l border-slate-200 dark:border-slate-700">
                    <span class="w-7 h-7 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 flex items-center justify-center font-black text-xs">A</span>
                    <span class="hidden sm:inline">Super Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">
            @if(session('success'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-300 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-2xl text-xs font-bold flex items-center justify-between">
                <span>✓ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-black">✕</button>
            </div>
            @endif

            @if(session('error'))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-800 text-rose-800 dark:text-rose-200 rounded-2xl text-xs font-bold flex items-center justify-between">
                <span>✕ {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-black">✕</button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Global Admin Scripts (Theme, Mobile Sidebar & Complete Bilingual Translation Engine) -->
    <script>
        // Mobile Sidebar Toggle
        function toggleAdminMobileSidebar(open) {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            if (open) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Theme Dropdown Toggle
        function toggleAdminThemeMenu() {
            const menu = document.getElementById('adminThemeMenu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('adminThemeDropdownWrapper');
            const menu = document.getElementById('adminThemeMenu');
            if (wrapper && menu && !wrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Select Theme Mode
        function selectAdminThemeMode(mode) {
            if (window.ThemeManager) {
                window.ThemeManager.set(mode);
            } else {
                localStorage.setItem('theme_preference', mode);
                const isDark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
                document.documentElement.classList.toggle('dark', isDark);
            }
            updateAdminThemeMenuLabel(mode);
            const menu = document.getElementById('adminThemeMenu');
            if (menu) menu.classList.add('hidden');
        }

        function updateAdminThemeMenuLabel(theme) {
            const icon = document.getElementById('adminThemeIcon');
            const label = document.getElementById('adminThemeLabel');
            if (icon) {
                icon.textContent = theme === 'system' ? '💻' : (theme === 'dark' ? '🌙' : '☀️');
            }
            if (label) {
                const lang = localStorage.getItem('admin_lang') || 'en';
                if (theme === 'system') {
                    label.textContent = lang === 'bn' ? 'সিস্টেম' : 'System';
                } else if (theme === 'dark') {
                    label.textContent = lang === 'bn' ? 'ডার্ক' : 'Dark';
                } else {
                    label.textContent = lang === 'bn' ? 'লাইট' : 'Light';
                }
            }
        }

        // =========================================================================
        // COMPREHENSIVE ADMIN BILINGUAL ENGINE (BN ↔ EN)
        // =========================================================================
        const adminPhraseMap = {
            // Navigation & Header
            'হেডার মেনু ও অ্যানাউন্সমেন্ট বার': 'Header Menu & Announcement Bar',
            'ওয়েবসাইটের শীর্ষ অ্যানাউন্সমেন্ট বার চালু/বন্ধ, মেনু আইটেম যোগ/মুছে ফেলা এবং মেনু সেন্টারে বসানোর সেটিংস।': 'Settings for top announcement bar on/off, adding/removing menu items and centering navbar.',
            'টপ অ্যানাউন্সমেন্ট বার (অন / অফ টগল ও টেক্সট)': 'Top Announcement Bar (On/Off Toggle & Text)',
            'চালু (ON) রাখলে পেজের শীর্ষে অ্যানিমেটেড নোটিশ বার আসবে, আর বন্ধ (OFF) করলে বারটি প্রদর্শিত হবে না।': 'When turned ON, animated notice bar appears at page top; when OFF, it is hidden.',
            'অ্যানাউন্সমেন্ট বার টেক্সট': 'Announcement Bar Text',
            'লাইভ অ্যানিমেশন প্রিভিউ:': 'Live Animation Preview:',
            'চালু (ON)': 'Enabled (ON)',
            'বন্ধ (OFF)': 'Disabled (OFF)',
            'মেনু অবস্থান ও অ্যালাইনমেন্ট (Navbar Alignment)': 'Navbar Alignment & Positioning',
            'মাঝখানে সারিবদ্ধ (Center-aligned)': 'Center-aligned',
            'রিকমেন্ডেড ⭐': 'Recommended ⭐',
            'বাম পাশে সারিবদ্ধ (Left-aligned)': 'Left-aligned',
            'সকল মেনু আইটেম বার-এর ঠিক সেন্টারে সুন্দরভাবে বিন্যস্ত থাকবে।': 'All menu items will be neatly positioned in the center of the bar.',
            'মেনু আইটেমগুলো বাম প্রান্ত থেকে শুরু হবে।': 'Menu items will align starting from the left edge.',
            'মেনু আইটেম ম্যানেজার (Add / Remove / Reorder)': 'Menu Items Manager (Add / Remove / Reorder)',
            'এখানে নতুন মেনু আইটেম যোগ করুন অথবা অপ্রয়োজনীয় মেনু ডিলিট (Remove) করুন।': 'Add new menu items or delete unnecessary items here.',
            'ডিফল্ট মেনু রিস্টোর করুন': 'Restore Default Menu',
            'দ্রুত ক্যাটাগরি মেনুতে যোগ করুন (১-ক্লিক শর্টকাট):': 'Quick Add Category to Menu (1-Click Shortcut):',
            '+ অর্গানিক ফুড (Organic)': '+ Organic Food (Organic)',
            '+ ইলেকট্রনিক্স ও গ্যাজেট (Electronics)': '+ Electronics & Gadgets',
            '+ হোম ও কিচেন (Home & Kitchen)': '+ Home & Kitchen',
            'নতুন মেনু আইটেম যোগ করুন:': 'Add New Menu Item:',
            'ইমোজি/আইকন': 'Emoji/Icon',
            'যেমন: 🌿': 'e.g.: 🌿',
            'মেনু নাম (Title) *': 'Menu Name (Title) *',
            'যেমন: হট ডিলস': 'e.g.: Hot Deals',
            'টার্গেট লিংক (URL) *': 'Target Link (URL) *',
            '+ যোগ করুন': '+ Add Item',
            'যোগ করুন': 'Add',
            'ক্রম': 'SL',
            'আইকন': 'Icon',
            'মেনু নাম': 'Menu Name',
            'টার্গেট লিংক': 'Target Link',
            'সক্রিয়': 'Active',
            'মুছে ফেলুন': 'Delete',
            'রিমুভ': 'Remove',
            'সেটিংস সংরক্ষণ করুন (Save)': 'Save Settings',
            'ওয়েবসাইটে দেখুন': 'View on Website',
            'হোমপেজ': 'Home',
            'সব প্রোডাক্ট': 'All Products',
            'অর্গানিক ফুড': 'Organic Food',
            'ইলেকট্রনিক্স ও গ্যাজেট': 'Electronics & Gadgets',
            'হোম ও কিচেন': 'Home & Kitchen',

            // Sidebar & Common
            'ড্যাশবোর্ড': 'Dashboard',
            'ই-কমার্স ম্যানেজমেন্ট': 'eCommerce Management',
            'প্রোডাক্টস': 'Products',
            'ক্যাটাগরি': 'Categories',
            'হোম ব্যানার': 'Hero Banners',
            'হেডার মেনু ও বার': 'Header & Navbar',
            'অর্ডারসমূহ': 'Orders',
            'ল্যান্ডিং পেজ ইঞ্জিন': 'Landing Page Engine',
            'ল্যান্ডিং পেজসমূহ': 'Landing Pages',
            'বিল্ডার': 'Builder',
            'টেমপ্লেট লাইব্রেরি': 'Template Library',
            'কনফিগারেশন': 'Configuration',
            'কুরিয়ার ও শিপিং': 'Courier & Shipping',
            'পেমেন্ট ও হিস্ট্রি': 'Payments & History',
            'পিক্সেল ও সেটিংস': 'Pixel & Settings',
            'ওয়েবসাইট দেখুন': 'View Website',
            'লগআউট': 'Logout',
            'ম্যানেজমেন্ট কনসোল': 'Management Console',
            'সুপার এডমিন': 'Super Admin',

            // Dashboard Metrics
            'মোট সেলস / রাজস্ব': 'Total Sales / Revenue',
            'মোট অর্ডার সংখ্যা': 'Total Orders',
            'ল্যান্ডিং পেজ সেলস': 'Landing Page Sales',
            'গড় কনভার্সন রেট': 'Avg Conversion Rate',
            'সক্রিয় ল্যান্ডিং পেজসমূহ': 'Active Landing Pages',
            'সাম্প্রতিক অর্ডারসমূহ': 'Recent Orders',
            'নতুন ল্যান্ডিং পেজ তৈরি করুন': 'Create Landing Page',
            'সবগুলো দেখুন': 'View All',
            'সব অর্ডার দেখুন': 'View All Orders',
            'বিস্তারিত দেখুন': 'View Details',
            'পেজের নাম': 'Page Name',
            'সংযুক্ত প্রোডাক্ট': 'Linked Product',
            'ভিউ': 'Views',
            'কনভার্সন': 'Conversion',
            'স্ট্যাটাস': 'Status',
            'অ্যাকশন': 'Action',
            'অর্ডার আইডি': 'Order ID',
            'গ্রাহক ও মোবাইল': 'Customer & Phone',
            'এলাকা': 'Area',
            'মোট টাকা': 'Total Amount',
            'পেন্ডিং': 'Pending',
            'প্রসেসিং': 'Processing',
            'কুরিয়ারে': 'In Courier',
            'ডেলিভার্ড': 'Delivered',
            'বাতিল': 'Cancelled',
            'পাবলিশড': 'Published',
            'ড্রাফট': 'Draft',
            'লাইভ': 'Live',

            // Products & Orders Management
            'নতুন প্রোডাক্ট যোগ করুন': 'Add New Product',
            'সব প্রোডাক্টসমূহ': 'All Products',
            'প্রোডাক্ট নাম': 'Product Name',
            'নিয়মিত মূল্য': 'Regular Price',
            'অফার মূল্য': 'Sale Price',
            'স্টক': 'Stock',
            'ছবি': 'Image',
            'এডিট': 'Edit',
            'ডিলিট': 'Delete',
            'পরিবর্তন করুন': 'Change',
            'ইনভয়েস': 'Invoice',
            'স্টিকার': 'Sticker',
            'ফ্রড চেক': 'Fraud Check',
            'কুরিয়ারে বুক করুন': 'Book Courier',
            'কুরিয়ার স্ট্যাটাস': 'Courier Status',
            'কুরিয়ার ট্র্যাকিং কোড': 'Tracking Code'
        };

        const sortedAdminPhraseKeys = Object.keys(adminPhraseMap).sort((a, b) => b.length - a.length);

        function translateAdminDom(lang) {
            const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
            let node;
            while ((node = walker.nextNode())) {
                const parent = node.parentElement;
                if (!parent || ['SCRIPT', 'STYLE', 'CODE', 'PRE'].includes(parent.tagName) || parent.hasAttribute('data-bn')) continue;

                if (lang === 'en') {
                    if (node._origBnText === undefined) {
                        node._origBnText = node.nodeValue;
                    }
                    const text = node.nodeValue;
                    if (!text || !text.trim()) continue;
                    const trimmed = text.trim();
                    if (adminPhraseMap[trimmed]) {
                        node.nodeValue = text.replace(trimmed, adminPhraseMap[trimmed]);
                        continue;
                    }
                    let updated = text;
                    let matched = false;
                    for (let i = 0; i < sortedAdminPhraseKeys.length; i++) {
                        const key = sortedAdminPhraseKeys[i];
                        if (updated.includes(key)) {
                            updated = updated.split(key).join(adminPhraseMap[key]);
                            matched = true;
                        }
                    }
                    if (matched) {
                        node.nodeValue = updated;
                    }
                } else {
                    if (node._origBnText !== undefined) {
                        node.nodeValue = node._origBnText;
                    }
                }
            }
        }

        // Apply Language
        function setAdminLanguage(lang) {
            localStorage.setItem('admin_lang', lang);

            // Update Header Toggle Button
            const langIcon = document.getElementById('adminLangIcon');
            const langLabel = document.getElementById('adminLangLabel');
            if (langIcon && langLabel) {
                if (lang === 'bn') {
                    langIcon.textContent = '🇺🇸';
                    langLabel.textContent = 'English';
                } else {
                    langIcon.textContent = '🇧🇩';
                    langLabel.textContent = 'বাংলা';
                }
            }

            // Translate elements with explicit data-bn / data-en
            document.querySelectorAll('[data-bn][data-en]').forEach(el => {
                el.textContent = (lang === 'en') ? el.getAttribute('data-en') : el.getAttribute('data-bn');
            });

            // Translate placeholders
            document.querySelectorAll('[data-placeholder-bn][data-placeholder-en]').forEach(el => {
                el.placeholder = (lang === 'en') ? el.getAttribute('data-placeholder-en') : el.getAttribute('data-placeholder-bn');
            });

            // Translate titles
            document.querySelectorAll('[data-title-bn][data-title-en]').forEach(el => {
                el.title = (lang === 'en') ? el.getAttribute('data-title-en') : el.getAttribute('data-title-bn');
            });

            // TreeWalker full body translation
            translateAdminDom(lang);

            // Update theme label for current language
            const curTheme = localStorage.getItem('theme_preference') || 'system';
            updateAdminThemeMenuLabel(curTheme);
        }

        function toggleAdminLang() {
            const current = localStorage.getItem('admin_lang') || 'en';
            const next = current === 'en' ? 'bn' : 'en';
            setAdminLanguage(next);
        }

        // Initialize on DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme_preference') || 'system';
            updateAdminThemeMenuLabel(savedTheme);

            const savedLang = localStorage.getItem('admin_lang') || 'en';
            setAdminLanguage(savedLang);
        });
    </script>

    @stack('scripts')
</body>
</html>
