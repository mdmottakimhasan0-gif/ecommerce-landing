<!DOCTYPE html>
<html lang="bn" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $landingPage->name }} - এলিমেন্টর স্টাইল পেজ বিল্ডার</title>

    <!-- Google Fonts -->
    <!-- Google Fonts: Anek Bangla & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        /* Custom Elementor-style builder UI enhancements */
        body { font-family: 'Anek Bangla', 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .font-mono-code { font-family: 'JetBrains Mono', monospace; }
        
        /* Device preview frames */
        .preview-wide { width: 100%; max-width: 100%; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .preview-desktop { width: 100%; max-width: 1080px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .preview-tablet { width: 768px; max-width: 100%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); border-radius: 24px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .preview-mobile { width: 390px; max-width: 100%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); border-radius: 36px; border: 8px solid #1e293b; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #18191c; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #4b5563; }

        /* Elementor Block Hover Outline & Action Bar */
        .builder-block { position: relative; transition: outline 0.15s ease-in-out; outline: 1px dashed transparent; }
        .builder-block:hover { outline: 2px solid #06b6d4; }
        .builder-block.active-selected { outline: 2px solid #8b5cf6 !important; }
        
        .builder-block .block-toolbar {
            display: none;
            position: absolute;
            top: -14px;
            right: 12px;
            z-index: 40;
        }
        .builder-block:hover > .block-toolbar,
        .builder-block.active-selected > .block-toolbar {
            display: flex;
        }

        /* Pulse subtle for order button */
        @keyframes pulse-subtle {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .animate-pulse-subtle { animation: pulse-subtle 2s infinite ease-in-out; }
    </style>
</head>
<body class="bg-[#0f1013] text-slate-100 h-full flex flex-col overflow-hidden selection:bg-fuchsia-600 selection:text-white">

    <!-- ========================================================================= -->
    <!-- TOP HEADER BAR (Directly matching User's Elementor Screenshot)            -->
    <!-- ========================================================================= -->
    <header class="h-14 bg-[#18191c] border-b border-[#2b2d35] flex items-center justify-between px-3 z-30 flex-shrink-0 select-none">
        
        <!-- Left Group: Navigation & Sidebar Toggles -->
        <div class="flex items-center gap-2">
            <!-- Back to Admin -->
            <a href="{{ route('admin.landing-pages.index') }}" title="এডমিন প্যানেলে ফিরে যান" 
               class="w-8 h-8 rounded-lg bg-[#252730] hover:bg-[#2e313d] flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>

            <div class="h-5 w-[1px] bg-[#2b2d35] mx-1"></div>

            <!-- Add Elements (+) Button -->
            <button id="btnToggleElements" title="উইজেট প্যানেল" 
                    class="w-8 h-8 rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white flex items-center justify-center font-bold text-base shadow transition-colors cursor-pointer">
                <span>+</span>
            </button>

            <!-- Toggle Sidebar (Expand / Collapse) -->
            <button id="btnToggleSidebar" title="সাইডবার লুকান / দেখান" 
                    class="w-8 h-8 rounded-lg bg-[#252730] hover:bg-[#2e313d] flex items-center justify-center text-slate-300 hover:text-white transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
            </button>

            <!-- Templates / Presets (Sparkles) -->
            <button id="btnOpenTemplates" title="প্রি-বিল্ট টেমপ্লেট লাইব্রেরি" 
                    class="w-8 h-8 rounded-lg bg-[#252730] hover:bg-[#2e313d] flex items-center justify-center text-amber-400 hover:text-amber-300 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </button>

            <!-- Settings / Pixel / SEO (Sliders) -->
            <button id="btnOpenSettings" title="পেজ সেটিংস, পিক্সেল ও এসইও" 
                    class="w-8 h-8 rounded-lg bg-[#252730] hover:bg-[#2e313d] flex items-center justify-center text-slate-300 hover:text-white transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            </button>
        </div>

        <!-- Center Group: Brand, Page Title, Main/ThankYou Tabs, Live URL Slug -->
        <div class="flex items-center gap-2.5">
            <!-- Brand -->
            <span class="text-xs font-black uppercase tracking-wider text-slate-400 hidden xl:inline-block">Elementor</span>

            <!-- Page Title -->
            <span class="font-bold text-white text-xs sm:text-sm max-w-[140px] sm:max-w-xs truncate" title="{{ $landingPage->name }}">
                {{ $landingPage->name }}
            </span>

            <!-- Page Tabs: Main vs Thank You -->
            <div class="flex items-center bg-[#252730] p-0.5 rounded-lg border border-[#2e313d] text-[11px] font-bold">
                <button id="tabMainPage" class="px-2.5 py-1 rounded-md bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white shadow flex items-center gap-1">
                    <span>🚀 Main</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </button>
                <button id="tabThankYou" class="px-2.5 py-1 rounded-md text-slate-400 hover:text-white flex items-center gap-1 transition-colors">
                    <span>🎉 Thank You</span>
                </button>
            </div>

            <!-- Live Slug Badge -->
            <a href="/{{ $landingPage->slug }}" target="_blank" title="লাইভ পেজ দেখুন" 
               class="hidden md:flex items-center gap-1.5 px-2.5 py-1 bg-[#252730] hover:bg-[#2e313d] border border-[#2e313d] rounded-lg text-emerald-400 hover:text-emerald-300 text-[11px] font-mono transition-colors">
                <span>/{{ $landingPage->slug }}</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <!-- Right Group: Responsive Switcher & Actions -->
        <div class="flex items-center gap-2">
            <!-- Device View Switchers & Full Width Toggle -->
            <div class="hidden lg:flex items-center bg-[#252730] p-0.5 rounded-lg border border-[#2e313d]">
                <button id="btnViewWide" title="ফুল উইডথ ভিউ (Full Width)" 
                        class="p-1.5 rounded text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                </button>
                <button id="btnViewDesktop" title="ডেস্কটপ ভিউ (1080px)" 
                        class="p-1.5 rounded text-cyan-400 bg-[#18191c] shadow cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </button>
                <button id="btnViewTablet" title="ট্যাবলেট ভিউ (768px)" 
                        class="p-1.5 rounded text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </button>
                <button id="btnViewMobile" title="মোবাইল ভিউ (390px)" 
                        class="p-1.5 rounded text-slate-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </button>
            </div>

            <!-- Canvas Zoom Scale -->
            <div class="hidden xl:flex items-center bg-[#252730] px-2 py-1 rounded-lg border border-[#2e313d] text-xs text-slate-300 gap-1.5 select-none">
                <button id="btnZoomOut" title="ছোট করুন (Zoom Out)" class="hover:text-white px-1 font-bold cursor-pointer text-sm">-</button>
                <span id="zoomPercent" class="text-[11px] font-mono w-9 text-center font-bold text-cyan-400">100%</span>
                <button id="btnZoomIn" title="বড় করুন (Zoom In)" class="hover:text-white px-1 font-bold cursor-pointer text-sm">+</button>
                <button id="btnZoomReset" title="রিসেট করুন (Reset 100%)" class="text-[10px] text-slate-400 hover:text-white ml-0.5 cursor-pointer">↺</button>
            </div>

            <!-- History Button (⏱️ ইতিহাস) -->
            <button id="btnHistory" title="রিভিশন ও পরিবর্তনের ইতিহাস" 
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-[#252730] hover:bg-[#2e313d] text-slate-300 hover:text-white rounded-lg text-xs font-bold transition-colors">
                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="hidden sm:inline">ইতিহাস</span>
            </button>

            <!-- Custom CSS Button (<> CSS) -->
            <button id="btnOpenCss" title="কাস্টম সিএসএস এডিটর" 
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-[#252730] hover:bg-[#2e313d] text-slate-300 hover:text-white rounded-lg text-xs font-mono font-bold transition-colors">
                <span class="text-cyan-400">&lt;&gt;</span>
                <span class="hidden sm:inline">CSS</span>
            </button>

            <!-- Live Preview (👁️ Live) -->
            <a href="/{{ $landingPage->slug }}" target="_blank" title="লাইভ পেজ প্রিভিউ" 
               class="flex items-center gap-1.5 px-3 py-1.5 bg-[#252730] hover:bg-[#2e313d] text-slate-300 hover:text-white rounded-lg text-xs font-bold transition-colors">
                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span class="hidden sm:inline">Live</span>
            </a>

            <!-- Save & Publish Button -->
            <button id="btnPublish" 
                    class="px-4 py-1.5 bg-gradient-to-r from-fuchsia-600 via-purple-600 to-pink-600 hover:from-fuchsia-500 hover:to-pink-500 text-white font-black text-xs rounded-lg shadow-lg shadow-fuchsia-600/30 flex items-center gap-1.5 transition-all active:scale-95">
                <span id="btnPublishText">Publish</span>
                <svg id="btnPublishSpinner" class="w-3.5 h-3.5 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </button>
        </div>
    </header>

    <!-- ========================================================================= -->
    <!-- MAIN WORKSPACE: LEFT SIDEBAR + LIVE CANVAS                                 -->
    <!-- ========================================================================= -->
    <div class="flex-1 flex overflow-hidden relative">

        <!-- --------------------------------------------------------------------- -->
        <!-- LEFT DARK SIDEBAR (Elements & Widgets Panel)                           -->
        <!-- --------------------------------------------------------------------- -->
        <aside id="builderSidebar" class="w-72 bg-[#18191c] border-r border-[#2b2d35] flex flex-col flex-shrink-0 z-20 transition-all duration-200">
            
            <!-- Panel 1: Widget Catalog (Default) -->
            <div id="panelElements" class="flex-1 flex flex-col overflow-hidden">
                <!-- Elements Header -->
                <div class="p-3 border-b border-[#2b2d35] flex items-center justify-between">
                    <span class="text-xs font-black uppercase tracking-wider text-slate-300">Elements</span>
                    <span class="text-[10px] text-cyan-400 font-bold bg-cyan-950/60 px-2 py-0.5 rounded border border-cyan-800/50 truncate max-w-[120px]">
                        {{ $product->category->name ?? 'Landing' }}
                    </span>
                </div>

                <!-- Search Widget Input -->
                <div class="p-3 border-b border-[#2b2d35]">
                    <div class="relative">
                        <svg class="w-3.5 h-3.5 text-slate-500 absolute left-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="widgetSearch" placeholder="Search Widget..." 
                               class="w-full pl-8 pr-3 py-2 bg-[#252730] border border-[#2e313d] focus:border-cyan-500 focus:ring-0 text-slate-200 placeholder-slate-500 text-xs rounded-lg">
                    </div>
                </div>

                <!-- Scrollable Accordion Categories -->
                <div class="flex-1 overflow-y-auto p-3 space-y-4 text-xs select-none">
                    
                    <!-- ACCORDION 1: LAYOUT -->
                    <div class="accordion-group">
                        <button class="accordion-header w-full flex items-center justify-between text-slate-400 hover:text-white font-bold py-1 mb-2 text-[11px] tracking-wider uppercase">
                            <span class="flex items-center gap-1.5">
                                <span class="text-[10px]">▼</span>
                                <span>LAYOUT</span>
                            </span>
                        </button>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Container -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('container')">
                                <div class="w-8 h-8 rounded-lg border border-slate-500/50 mb-1.5 flex items-center justify-center group-hover:border-cyan-400 transition-colors">
                                    <div class="w-5 h-5 border border-dashed border-slate-400 group-hover:border-cyan-400 rounded"></div>
                                </div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Container</span>
                            </div>

                            <!-- 2 Columns -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('2columns')">
                                <div class="w-8 h-8 rounded-lg border border-slate-500/50 mb-1.5 flex items-center justify-center gap-0.5 group-hover:border-cyan-400 transition-colors">
                                    <div class="w-2.5 h-5 border border-slate-400 group-hover:border-cyan-400 rounded-sm"></div>
                                    <div class="w-2.5 h-5 border border-slate-400 group-hover:border-cyan-400 rounded-sm"></div>
                                </div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">2 Columns</span>
                            </div>

                            <!-- 3 Columns -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('3columns')">
                                <div class="w-8 h-8 rounded-lg border border-slate-500/50 mb-1.5 flex items-center justify-center gap-0.5 group-hover:border-cyan-400 transition-colors">
                                    <div class="w-1.5 h-5 border border-slate-400 rounded-sm"></div>
                                    <div class="w-1.5 h-5 border border-slate-400 rounded-sm"></div>
                                    <div class="w-1.5 h-5 border border-slate-400 rounded-sm"></div>
                                </div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">3 Columns</span>
                            </div>

                            <!-- 4 Columns -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('4columns')">
                                <div class="w-8 h-8 rounded-lg border border-slate-500/50 mb-1.5 flex items-center justify-center gap-0.5 group-hover:border-cyan-400 transition-colors">
                                    <div class="w-1 h-5 border border-slate-400 rounded-sm"></div>
                                    <div class="w-1 h-5 border border-slate-400 rounded-sm"></div>
                                    <div class="w-1 h-5 border border-slate-400 rounded-sm"></div>
                                    <div class="w-1 h-5 border border-slate-400 rounded-sm"></div>
                                </div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">4 Columns</span>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION 2: BASIC -->
                    <div class="accordion-group">
                        <button class="accordion-header w-full flex items-center justify-between text-slate-400 hover:text-white font-bold py-1 mb-2 text-[11px] tracking-wider uppercase">
                            <span class="flex items-center gap-1.5">
                                <span class="text-[10px]">▼</span>
                                <span>BASIC</span>
                            </span>
                        </button>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Heading -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('heading')">
                                <span class="text-xl font-black text-slate-300 group-hover:text-cyan-400 mb-1 font-serif">T</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Heading</span>
                            </div>

                            <!-- Image -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('image')">
                                <svg class="w-6 h-6 text-slate-300 group-hover:text-cyan-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Image</span>
                            </div>

                            <!-- Text Editor -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('text')">
                                <svg class="w-6 h-6 text-slate-300 group-hover:text-cyan-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/></svg>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Text Editor</span>
                            </div>

                            <!-- Video -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('video')">
                                <svg class="w-6 h-6 text-slate-300 group-hover:text-cyan-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Video</span>
                            </div>

                            <!-- Button -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('button')">
                                <div class="px-2 py-1 rounded bg-slate-600 text-[10px] font-black group-hover:bg-cyan-600 text-white mb-1.5">CLICK</div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Button</span>
                            </div>

                            <!-- Divider / Spacer -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('divider')">
                                <div class="w-8 border-b-2 border-slate-400 group-hover:border-cyan-400 mb-2"></div>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Divider</span>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION 3: PRODUCT DYNAMIC -->
                    <div class="accordion-group">
                        <button class="accordion-header w-full flex items-center justify-between text-slate-400 hover:text-white font-bold py-1 mb-2 text-[11px] tracking-wider uppercase">
                            <span class="flex items-center gap-1.5">
                                <span class="text-[10px]">▼</span>
                                <span>PRODUCT (DYNAMIC)</span>
                            </span>
                        </button>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- Product Hero / Title -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-emerald-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('product_hero')">
                                <span class="text-xs font-black text-emerald-400 mb-1">🏷️ Title</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Product Hero</span>
                            </div>

                            <!-- Dynamic Price Box -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-emerald-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('product_price')">
                                <span class="text-xs font-black text-emerald-400 mb-1">৳ Price</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Pricing Box</span>
                            </div>

                            <!-- Product Features -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-emerald-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('features')">
                                <span class="text-xs font-black text-emerald-400 mb-1">✨ Bullet</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Features List</span>
                            </div>

                            <!-- Product Gallery -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-emerald-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('gallery')">
                                <span class="text-xs font-black text-emerald-400 mb-1">🖼️ Gallery</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Gallery Grid</span>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION 4: SALES & CONVERSION -->
                    <div class="accordion-group">
                        <button class="accordion-header w-full flex items-center justify-between text-slate-400 hover:text-white font-bold py-1 mb-2 text-[11px] tracking-wider uppercase">
                            <span class="flex items-center gap-1.5">
                                <span class="text-[10px]">▼</span>
                                <span>SALES & CONVERSION</span>
                            </span>
                        </button>
                        <div class="grid grid-cols-2 gap-2">
                            <!-- COD Order Form -->
                            <div class="widget-card bg-emerald-950/40 hover:bg-emerald-900/50 hover:border-emerald-500 border border-emerald-800/60 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group col-span-2"
                                 onclick="addWidgetToCanvas('order_form')">
                                <div class="flex items-center gap-1.5 text-emerald-400 font-black text-xs mb-0.5">
                                    <span>🛒</span>
                                    <span>১-ক্লিক ক্যাশ অন ডেলিভারি ফর্ম</span>
                                </div>
                                <span class="text-[10px] text-emerald-300/80">Embedded Fast COD Form</span>
                            </div>

                            <!-- Urgency Countdown Timer -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-rose-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('urgency')">
                                <span class="text-xs font-black text-rose-400 mb-1">⏰ Timer</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Urgency Timer</span>
                            </div>

                            <!-- Trust Badges & Guarantees -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-amber-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('guarantees')">
                                <span class="text-xs font-black text-amber-400 mb-1">🛡️ Trust</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Trust Badges</span>
                            </div>

                            <!-- Customer Reviews -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-amber-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('reviews')">
                                <span class="text-xs font-black text-amber-400 mb-1">⭐ Reviews</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">Testimonials</span>
                            </div>

                            <!-- FAQ Accordion -->
                            <div class="widget-card bg-[#252730] hover:bg-[#2e313d] hover:border-cyan-500/50 border border-[#2e313d] rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition-all group"
                                 onclick="addWidgetToCanvas('faq')">
                                <span class="text-xs font-black text-cyan-400 mb-1">❓ FAQ</span>
                                <span class="text-[11px] font-bold text-slate-300 group-hover:text-white">FAQ Accordion</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Panel 2: Block Properties Inspector (Shown when a block is selected) -->
            <div id="panelInspector" class="hidden flex-1 flex flex-col overflow-hidden bg-[#18191c]">
                <div class="p-3 border-b border-[#2b2d35] flex items-center justify-between">
                    <button onclick="closeInspector()" class="text-xs text-slate-400 hover:text-white flex items-center gap-1 font-bold">
                        <span>← উইজেট সমূহ</span>
                    </button>
                    <span id="inspectorBlockType" class="text-[11px] font-black text-cyan-400 uppercase">Block Edit</span>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-4 text-xs" id="inspectorFields">
                    <!-- Injected dynamically via JS based on selected block type -->
                </div>
            </div>
        </aside>

        <!-- --------------------------------------------------------------------- -->
        <!-- CENTER: LIVE BUILDER CANVAS (Full Unrestricted Scrolling)               -->
        <!-- --------------------------------------------------------------------- -->
        <main class="flex-1 bg-[#0b0c0e] overflow-y-scroll overflow-x-hidden p-3 sm:p-6 lg:p-8 min-h-0 w-full" id="canvasScrollArea">
            
            <div class="w-full flex justify-center pb-48 pt-2" id="canvasInnerWrapper">
                <!-- Active Canvas Wrapper (supports wide/desktop/tablet/mobile toggling & zoom) -->
                <div id="canvasViewport" class="preview-desktop bg-slate-900 border border-slate-800 text-slate-100 rounded-3xl shadow-2xl overflow-visible min-h-[850px] flex flex-col transition-transform origin-top duration-200">
                    
                    <!-- Dynamic Content Blocks Container -->
                    <div id="blocksContainer" class="p-4 sm:p-8 space-y-8 flex-1">
                        <!-- Blocks will be rendered here by JS init -->
                    </div>

                    <!-- Add Section Placeholder at Bottom -->
                    <div class="m-6 mb-12 p-6 border-2 border-dashed border-slate-700 hover:border-cyan-500 rounded-2xl flex flex-col items-center justify-center text-center cursor-pointer transition-colors group"
                         onclick="openWidgetDrawer()">
                        <div class="w-10 h-10 rounded-full bg-[#1e2026] group-hover:bg-cyan-600 text-slate-300 group-hover:text-white flex items-center justify-center font-black text-lg mb-2 transition-colors">
                            +
                        </div>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-cyan-400">নতুন সেকশন বা উইজেট যোগ করুন</span>
                        <span class="text-[10px] text-slate-600 mt-0.5">বামপাশের প্যানেল থেকে উইজেটে ক্লিক করুন</span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ========================================================================= -->
    <!-- MODALS: SETTINGS (SEO/PIXELS), CUSTOM CSS, HISTORY, TEMPLATES              -->
    <!-- ========================================================================= -->

    <!-- Modal 1: Page Settings & Multi-Pixel Modal -->
    <div id="modalSettings" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#18191c] border border-[#2b2d35] rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-[#2b2d35] flex items-center justify-between">
                <h3 class="text-sm font-black text-white flex items-center gap-2">
                    <span>⚙️ পেজ সেটিংস, এসইও ও মাল্টি-পিক্সেল ট্র্যাকিং</span>
                </h3>
                <button onclick="closeModal('modalSettings')" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>
            <div class="p-5 space-y-4 max-h-[75vh] overflow-y-auto text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">এসইও টাইটেল (SEO Title)</label>
                    <input type="text" id="settingSeoTitle" value="{{ $landingPage->seo_title }}" class="w-full p-2.5 bg-[#252730] border border-[#2e313d] rounded-xl text-slate-200 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block font-bold text-slate-300 mb-1">এসইও মেটা ডেসক্রিপশন</label>
                    <textarea id="settingSeoDesc" rows="2" class="w-full p-2.5 bg-[#252730] border border-[#2e313d] rounded-xl text-slate-200 focus:border-cyan-500">{{ $landingPage->seo_description }}</textarea>
                </div>

                <div class="pt-3 border-t border-[#2b2d35] space-y-3">
                    <h4 class="font-black text-cyan-400 text-xs uppercase tracking-wider">মাল্টি-পিক্সেল ওভাররাইড (Multi-Pixel Override)</h4>
                    <p class="text-[11px] text-slate-400">এই ল্যান্ডিং পেজের জন্য নির্দিষ্ট পিক্সেল আইডি বসাতে পারেন। ফাঁকা রাখলে গ্লোবাল স্টোর পিক্সেল কাজ করবে।</p>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1">ফেসবুক পিক্সেল আইডি (Facebook Pixel ID)</label>
                        <input type="text" id="settingFbPixel" value="{{ $landingPage->fb_pixel_id }}" placeholder="যেমন: 123456789012345" class="w-full p-2.5 bg-[#252730] border border-[#2e313d] rounded-xl text-slate-200 font-mono focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">টিকটক পিক্সেল আইডি (TikTok Pixel ID)</label>
                        <input type="text" id="settingTtPixel" value="{{ $landingPage->tiktok_pixel_id }}" placeholder="যেমন: C123456789ABC" class="w-full p-2.5 bg-[#252730] border border-[#2e313d] rounded-xl text-slate-200 font-mono focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">গুগল ট্যাগ ম্যানেজার আইডি (GTM Container ID)</label>
                        <input type="text" id="settingGtmId" value="{{ $landingPage->gtm_id }}" placeholder="যেমন: GTM-XXXXXX" class="w-full p-2.5 bg-[#252730] border border-[#2e313d] rounded-xl text-slate-200 font-mono focus:border-cyan-500">
                    </div>
                </div>
            </div>
            <div class="p-4 border-t border-[#2b2d35] flex justify-end gap-2 bg-[#141518]">
                <button onclick="closeModal('modalSettings')" class="px-4 py-2 bg-[#252730] hover:bg-[#2e313d] text-slate-300 text-xs font-bold rounded-xl">বাতিল</button>
                <button onclick="applySettings()" class="px-5 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-bold rounded-xl shadow">প্রয়োগ করুন</button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Custom CSS Modal -->
    <div id="modalCss" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#18191c] border border-[#2b2d35] rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-[#2b2d35] flex items-center justify-between">
                <h3 class="text-sm font-black text-white flex items-center gap-2">
                    <span class="text-cyan-400 font-mono">&lt;&gt;</span>
                    <span>কাস্টম সিএসএস এডিটর (Custom CSS)</span>
                </h3>
                <button onclick="closeModal('modalCss')" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>
            <div class="p-4 space-y-3">
                <p class="text-[11px] text-slate-400">আপনার যেকোনো কাস্টম সিএসএস কোড এখানে লিখুন। এটি রিয়েলটাইমে পেজে কার্যকর হবে।</p>
                <textarea id="customCssInput" rows="12" 
                          class="w-full p-3 bg-[#0f1013] border border-[#2e313d] rounded-xl text-cyan-300 font-mono text-xs focus:border-cyan-500 focus:ring-0 leading-relaxed"
                          placeholder="/* Example: */
.builder-hero-title { color: #f59e0b; }
.order-box { border-color: #10b981 !important; }">{{ $landingPage->custom_css }}</textarea>
            </div>
            <div class="p-4 border-t border-[#2b2d35] flex justify-end gap-2 bg-[#141518]">
                <button onclick="closeModal('modalCss')" class="px-4 py-2 bg-[#252730] hover:bg-[#2e313d] text-slate-300 text-xs font-bold rounded-xl">বাতিল</button>
                <button onclick="applyCustomCss()" class="px-5 py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-bold rounded-xl shadow">সিএসএস প্রয়োগ করুন</button>
            </div>
        </div>
    </div>

    <!-- Modal 3: History & Revisions Modal -->
    <div id="modalHistory" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#18191c] border border-[#2b2d35] rounded-2xl w-full max-w-md overflow-hidden shadow-2xl">
            <div class="p-4 border-b border-[#2b2d35] flex items-center justify-between">
                <h3 class="text-sm font-black text-white flex items-center gap-2">
                    <span>⏱️ পেজ পরিবর্তনের ইতিহাস (Revisions)</span>
                </h3>
                <button onclick="closeModal('modalHistory')" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>
            <div class="p-4 space-y-2 max-h-72 overflow-y-auto text-xs">
                @forelse($landingPage->versions()->latest()->take(10)->get() as $ver)
                <div class="p-3 bg-[#252730] border border-[#2e313d] rounded-xl flex items-center justify-between">
                    <div>
                        <span class="font-bold text-white block">ভার্সন #{{ $ver->version_number }}</span>
                        <span class="text-[10px] text-slate-400">{{ $ver->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="px-2 py-1 bg-cyan-950 text-cyan-400 text-[10px] font-bold rounded">সেভড</span>
                </div>
                @empty
                <div class="text-center py-6 text-slate-500 text-xs">
                    কোনো পূর্ববর্তী রিভিশন পাওয়া যায়নি।
                </div>
                @endforelse
            </div>
            <div class="p-4 border-t border-[#2b2d35] flex justify-end bg-[#141518]">
                <button onclick="closeModal('modalHistory')" class="px-4 py-2 bg-[#252730] hover:bg-[#2e313d] text-slate-300 text-xs font-bold rounded-xl">বন্ধ করুন</button>
            </div>
        </div>
    </div>

    <!-- Live Injected Dynamic CSS Container -->
    <style id="liveInjectedCss">
        {!! $landingPage->custom_css !!}
    </style>

    <!-- ========================================================================= -->
    <!-- JAVASCRIPT: BUILDER CORE ENGINE                                           -->
    <!-- ========================================================================= -->
    <script>
        // Product Dynamic Data from Server
        const PRODUCT = {
            id: {{ $product->id }},
            name: @json($product->name),
            category: @json($product->category->name ?? 'জেনারেল'),
            salePrice: {{ (int)$product->sale_price }},
            regularPrice: {{ (int)$product->regular_price }},
            discountPct: {{ (int)$product->discount_percentage }},
            stock: {{ (int)$product->stock }},
            thumbnail: @json($product->thumbnail),
            shortDesc: @json($product->short_description ?? ''),
            features: @json($product->features ?? []),
        };

        // Current Page State
        let currentPage = 'main'; // 'main' or 'thankyou'
        let blocks = @json($contentBlocks);
        let customCss = @json($landingPage->custom_css ?? '');
        let seoTitle = @json($landingPage->seo_title ?? '');
        let seoDesc = @json($landingPage->seo_description ?? '');
        let fbPixel = @json($landingPage->fb_pixel_id ?? '');
        let ttPixel = @json($landingPage->tiktok_pixel_id ?? '');
        let gtmId = @json($landingPage->gtm_id ?? '');
        let selectedBlockId = null;

        // If blocks are empty, initialize default high-converting landing structure
        if (!blocks || !blocks.length) {
            blocks = [
                {
                    id: 'b_' + Date.now() + '_hero',
                    type: 'product_hero',
                    badge: '🔥 বিশেষ অফার!',
                    title: PRODUCT.name,
                    subtitle: PRODUCT.shortDesc || '১০০% আসল ও খাঁটি পণ্যের নিশ্চয়তা। সারা দেশে ক্যাশ অন ডেলিভারি!',
                    cta_text: 'এখনই অর্ডার করুন 🛒'
                },
                {
                    id: 'b_' + Date.now() + '_price',
                    type: 'product_price',
                    heading: 'অফার প্রাইজ (সীমিত সময়ের জন্য)'
                },
                {
                    id: 'b_' + Date.now() + '_urgency',
                    type: 'urgency',
                    text: '⏰ বিশেষ অফারটি শেষ হতে বাকি আছে:',
                    hours: '04',
                    minutes: '30',
                    seconds: '00'
                },
                {
                    id: 'b_' + Date.now() + '_features',
                    type: 'features',
                    title: 'কেন আমাদের কাছ থেকে কিনবেন?',
                    items: PRODUCT.features.length ? PRODUCT.features : [
                        '১০০% খাঁটি ও গুণগত মান নিশ্চিত',
                        'ক্যাশ অন ডেলিভারিতে চেক করে মূল্য পরিশোধ',
                        'দ্রুততম হোম ডেলিভারি সুবিধা'
                    ]
                },
                {
                    id: 'b_' + Date.now() + '_order',
                    type: 'order_form',
                    title: 'অর্ডার করতে আপনার সঠিক তথ্য দিন',
                    subtitle: 'পণ্য হাতে পেয়ে চেক করে ডেলিভারি ম্যানের কাছে মূল্য পরিশোধ করুন'
                }
            ];
        }

        // DOM Elements
        const blocksContainer = document.getElementById('blocksContainer');
        const panelElements = document.getElementById('panelElements');
        const panelInspector = document.getElementById('panelInspector');
        const inspectorFields = document.getElementById('inspectorFields');
        const inspectorBlockType = document.getElementById('inspectorBlockType');

        // Initial Render
        renderBlocks();

        // -------------------------------------------------------------------------
        // RENDER BLOCKS IN LIVE CANVAS
        // -------------------------------------------------------------------------
        function renderBlocks() {
            blocksContainer.innerHTML = '';

            blocks.forEach((block, index) => {
                const blockEl = document.createElement('div');
                blockEl.className = `builder-block rounded-2xl ${selectedBlockId === block.id ? 'active-selected' : ''}`;
                blockEl.setAttribute('data-id', block.id);
                blockEl.onclick = (e) => {
                    e.stopPropagation();
                    selectBlock(block.id);
                };

                // Block Toolbar (Move up, move down, duplicate, delete)
                const toolbar = document.createElement('div');
                toolbar.className = 'block-toolbar items-center gap-1 bg-[#18191c] border border-cyan-500/80 rounded-lg p-1 shadow-xl';
                toolbar.innerHTML = `
                    <span class="text-[9px] font-black text-cyan-400 px-1.5 uppercase">${block.type.replace('_', ' ')}</span>
                    <button onclick="moveBlock(${index}, -1, event)" title="উপরে তুলুন" class="p-1 hover:bg-[#252730] text-slate-300 hover:text-white rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                    </button>
                    <button onclick="moveBlock(${index}, 1, event)" title="নিচে নামান" class="p-1 hover:bg-[#252730] text-slate-300 hover:text-white rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <button onclick="duplicateBlock(${index}, event)" title="ডুপ্লিকেট করুন" class="p-1 hover:bg-[#252730] text-slate-300 hover:text-white rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                    <button onclick="deleteBlock(${index}, event)" title="মুছে ফেলুন" class="p-1 hover:bg-rose-900/60 text-rose-400 hover:text-rose-300 rounded">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                `;
                blockEl.appendChild(toolbar);

                // Block Content View
                const contentEl = document.createElement('div');
                contentEl.innerHTML = generateBlockHtml(block);
                blockEl.appendChild(contentEl);

                blocksContainer.appendChild(blockEl);
            });
        }

        // -------------------------------------------------------------------------
        // HTML GENERATOR FOR EACH WIDGET BLOCK
        // -------------------------------------------------------------------------
        function generateBlockHtml(b) {
            switch(b.type) {
                case 'product_hero':
                    return `
                        <div class="text-center space-y-4 py-4">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold">
                                <span>🌿</span> ${escapeHtml(b.badge || 'স্পেশাল অফার!')}
                            </span>
                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                                ${escapeHtml(b.title || PRODUCT.name)}
                            </h1>
                            <p class="text-xs sm:text-base text-slate-300 max-w-2xl mx-auto leading-relaxed">
                                ${escapeHtml(b.subtitle || PRODUCT.shortDesc)}
                            </p>
                            <div class="relative rounded-2xl overflow-hidden aspect-video max-w-2xl mx-auto bg-slate-950 border border-slate-700 shadow-xl mt-4">
                                <img src="${b.image || PRODUCT.thumbnail}" class="w-full h-full object-cover">
                                ${PRODUCT.discountPct > 0 ? `<div class="absolute top-4 left-4 bg-rose-600 text-white font-black text-xs px-3 py-1 rounded-xl shadow">-` + PRODUCT.discountPct + `% ছাড়</div>` : ''}
                            </div>
                        </div>
                    `;

                case 'product_price':
                    return `
                        <div class="bg-gradient-to-r from-slate-900 to-slate-950 p-6 rounded-2xl border border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
                            <div class="text-center sm:text-left">
                                <span class="text-xs text-slate-400 block mb-1">${escapeHtml(b.heading || 'অফার প্রাইজ (সীমিত সময়ের জন্য)')}:</span>
                                <div class="flex items-baseline gap-3">
                                    <span class="text-3xl sm:text-4xl font-black text-emerald-400">
                                        ৳ ${numberFormat(PRODUCT.salePrice)}
                                    </span>
                                    ${PRODUCT.regularPrice > PRODUCT.salePrice ? `
                                        <span class="text-base text-slate-500 line-through">
                                            ৳ ${numberFormat(PRODUCT.regularPrice)}
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            <a href="#orderFormPreview" class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-black text-sm rounded-xl shadow-xl animate-pulse-subtle flex items-center justify-center gap-2">
                                <span>এখনই অর্ডার করুন 🛒</span>
                            </a>
                        </div>
                    `;

                case 'urgency':
                    return `
                        <div class="bg-gradient-to-r from-rose-950/80 via-slate-900 to-rose-950/80 p-5 rounded-2xl border border-rose-800/50 text-center space-y-3 shadow-lg">
                            <h3 class="text-sm font-black text-rose-300">${escapeHtml(b.text || '⏰ অফারটি শেষ হতে বাকি আছে:')}</h3>
                            <div class="flex items-center justify-center gap-2 font-mono">
                                <div class="bg-black/70 p-2.5 rounded-xl border border-rose-500/40 min-w-[50px]">
                                    <span class="text-xl font-black text-white">${escapeHtml(b.hours || '04')}</span>
                                    <span class="block text-[9px] text-rose-300">ঘণ্টা</span>
                                </div>
                                <span class="text-xl font-bold text-rose-400">:</span>
                                <div class="bg-black/70 p-2.5 rounded-xl border border-rose-500/40 min-w-[50px]">
                                    <span class="text-xl font-black text-white">${escapeHtml(b.minutes || '30')}</span>
                                    <span class="block text-[9px] text-rose-300">মিনিট</span>
                                </div>
                                <span class="text-xl font-bold text-rose-400">:</span>
                                <div class="bg-black/70 p-2.5 rounded-xl border border-rose-500/40 min-w-[50px]">
                                    <span class="text-xl font-black text-white">${escapeHtml(b.seconds || '00')}</span>
                                    <span class="block text-[9px] text-rose-300">সেকেন্ড</span>
                                </div>
                            </div>
                        </div>
                    `;

                case 'features':
                    const items = b.items || ['১০০% আসল ও খাঁটি', 'ক্যাশ অন ডেলিভারি', 'দ্রুততম ডেলিভারি'];
                    return `
                        <div class="bg-slate-800/80 p-6 rounded-2xl border border-slate-700 space-y-4">
                            <h3 class="text-lg font-black text-white text-center">${escapeHtml(b.title || 'কেন আমাদের পণ্যটি কিনবেন?')}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                ${items.map(it => `
                                    <div class="bg-slate-900/80 p-3 rounded-xl border border-slate-700/60 flex items-center gap-2.5">
                                        <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold">✓</span>
                                        <span class="text-xs text-slate-200 font-medium">${escapeHtml(it)}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;

                case 'order_form':
                    return `
                        <div id="orderFormPreview" class="bg-white text-slate-900 rounded-2xl p-6 shadow-2xl border-4 border-emerald-500 space-y-5">
                            <div class="text-center space-y-1 border-b border-slate-200 pb-3">
                                <span class="inline-block px-3 py-0.5 bg-emerald-100 text-emerald-800 font-bold text-[11px] rounded-full">১-মিনিটে অর্ডার করুন</span>
                                <h2 class="text-xl font-black text-slate-900">${escapeHtml(b.title || 'অর্ডার করতে আপনার সঠিক তথ্য দিন')}</h2>
                                <p class="text-xs text-slate-500">${escapeHtml(b.subtitle || 'পণ্য হাতে পেয়ে চেক করে মূল্য পরিশোধ করুন (ক্যাশ অন ডেলিভারি)')}</p>
                            </div>
                            <!-- Mock Product Row -->
                            <div class="flex items-center gap-3 p-3 bg-emerald-50/80 border border-emerald-200 rounded-xl">
                                <img src="${PRODUCT.thumbnail}" class="w-12 h-12 object-cover rounded-lg border border-emerald-300">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs font-bold text-slate-900 truncate">${PRODUCT.name}</h4>
                                    <span class="text-sm font-black text-emerald-700">৳ ${numberFormat(PRODUCT.salePrice)}</span>
                                </div>
                                <span class="text-xs font-bold px-2 py-1 bg-white border border-emerald-300 rounded-lg">পরিমাণ: ১</span>
                            </div>
                            <!-- Mock Form Fields -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">আপনার নাম</label>
                                    <input type="text" placeholder="যেমন: মোঃ করিম" disabled class="w-full p-2 bg-slate-50 border border-slate-300 rounded-lg cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">মোবাইল নম্বর</label>
                                    <input type="text" placeholder="০১৭xxxxxxxx" disabled class="w-full p-2 bg-slate-50 border border-slate-300 rounded-lg cursor-not-allowed">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block font-bold text-slate-700 mb-1">সম্পূর্ণ ঠিকানা</label>
                                    <input type="text" placeholder="বাসা/রোড নং, এলাকা, থানা ও জেলা" disabled class="w-full p-2 bg-slate-50 border border-slate-300 rounded-lg cursor-not-allowed">
                                </div>
                            </div>
                            <button disabled class="w-full py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-sm rounded-xl shadow-lg cursor-not-allowed flex items-center justify-center gap-2">
                                <span>অর্ডার কনফার্ম করুন ৳ ${numberFormat(PRODUCT.salePrice + 70)} (ক্যাশ অন ডেলিভারি)</span>
                            </button>
                        </div>
                    `;

                case 'heading':
                    return `
                        <div class="text-center py-2">
                            <h2 class="text-2xl sm:text-3xl font-black text-white">${escapeHtml(b.text || 'আপনার আকর্ষণীয় হেডলাইন লিখুন')}</h2>
                        </div>
                    `;

                case 'text':
                    return `
                        <div class="text-slate-300 text-xs sm:text-sm leading-relaxed p-2">
                            ${escapeHtml(b.text || 'এখানে আপনার বিস্তারিত বিবরণ, পণ্যের ব্যবহার বিধি অথবা অফার সম্পর্কিত নিয়মাবলী লিখুন।')}
                        </div>
                    `;

                case 'image':
                    return `
                        <div class="rounded-xl overflow-hidden max-w-xl mx-auto border border-slate-700 shadow-md">
                            <img src="${b.url || PRODUCT.thumbnail}" class="w-full h-auto object-cover">
                        </div>
                    `;

                case 'video':
                    return `
                        <div class="aspect-video max-w-xl mx-auto rounded-xl overflow-hidden bg-black border border-slate-700 flex items-center justify-center">
                            <span class="text-xs text-slate-400 font-mono">▶ Video Embed (${escapeHtml(b.video_url || 'YouTube / MP4')})</span>
                        </div>
                    `;

                case 'button':
                    return `
                        <div class="text-center py-3">
                            <a href="#orderFormPreview" class="inline-block px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black text-xs rounded-xl shadow-lg">
                                ${escapeHtml(b.text || 'এখনই কিনুন')}
                            </a>
                        </div>
                    `;

                case 'divider':
                    return `
                        <div class="py-3 flex items-center justify-center">
                            <div class="w-24 h-1 bg-gradient-to-r from-transparent via-cyan-500 to-transparent rounded"></div>
                        </div>
                    `;

                case 'guarantees':
                    return `
                        <div class="grid grid-cols-3 gap-3 p-4 bg-slate-800/80 rounded-2xl border border-slate-700 text-center text-xs">
                            <div class="p-2">
                                <span class="text-2xl block mb-1">🛡️</span>
                                <span class="font-bold text-slate-200">ক্যাশ অন ডেলিভারি</span>
                            </div>
                            <div class="p-2">
                                <span class="text-2xl block mb-1">🚚</span>
                                <span class="font-bold text-slate-200">দ্রুততম হোম ডেলিভারি</span>
                            </div>
                            <div class="p-2">
                                <span class="text-2xl block mb-1">💯</span>
                                <span class="font-bold text-slate-200">১০০% খাঁটি ও আসল</span>
                            </div>
                        </div>
                    `;

                case 'reviews':
                    return `
                        <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700 space-y-4">
                            <h3 class="text-sm font-black text-white text-center">⭐ কাস্টমারদের মূল্যবান রিভিউ</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <div class="bg-slate-900/90 p-3.5 rounded-xl border border-slate-700/80 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-emerald-400">কামাল হোসেন (ঢাকা)</span>
                                        <span class="text-amber-400 text-xs">★★★★★</span>
                                    </div>
                                    <p class="text-slate-300 text-[11px]">পণ্য হাতে পেয়ে চেক করে টাকা দিয়েছি। মান খুবই ভালো এবং ডেলিভারি ছিল দ্রুত।</p>
                                </div>
                                <div class="bg-slate-900/90 p-3.5 rounded-xl border border-slate-700/80 space-y-1.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-emerald-400">তানিয়া আহমেদ (চট্টগ্রাম)</span>
                                        <span class="text-amber-400 text-xs">★★★★★</span>
                                    </div>
                                    <p class="text-slate-300 text-[11px]">১০০% আসল প্রোডাক্ট! প্যাকেজিং অনেক সুন্দর ছিল। ধন্যবাদ ডিমান্ডহাট বিডি কে।</p>
                                </div>
                            </div>
                        </div>
                    `;

                case 'faq':
                    return `
                        <div class="bg-slate-800/80 p-5 rounded-2xl border border-slate-700 space-y-3">
                            <h3 class="text-sm font-black text-white text-center">❓ সচরাচর জিজ্ঞাসিত প্রশ্ন (FAQ)</h3>
                            <div class="space-y-2 text-xs">
                                <div class="p-3 bg-slate-900 rounded-xl border border-slate-700">
                                    <div class="font-bold text-slate-200">কীভাবে পণ্য অর্ডার করব?</div>
                                    <div class="text-[11px] text-slate-400 mt-1">উপরের ফর্মে আপনার নাম, মোবাইল নম্বর এবং সম্পূর্ণ ঠিকানা দিয়ে "অর্ডার কনফার্ম করুন" বাটনে ক্লিক করলেই অর্ডার কনফার্ম হবে।</div>
                                </div>
                                <div class="p-3 bg-slate-900 rounded-xl border border-slate-700">
                                    <div class="font-bold text-slate-200">ডেলিভারি চার্জ কত এবং কতদিনে পাব?</div>
                                    <div class="text-[11px] text-slate-400 mt-1">ঢাকার ভেতর ডেলিভারি চার্জ ৭০ টাকা (২৪-৪৮ ঘণ্টার মধ্যে), ঢাকার বাইরে ১৩০ টাকা (২-৩ দিনের মধ্যে)।</div>
                                </div>
                            </div>
                        </div>
                    `;

                default:
                    return `
                        <div class="p-4 bg-slate-800 rounded-xl border border-slate-700 text-xs text-slate-400">
                            ${escapeHtml(b.type)} - কন্টেন্ট সেকশন
                        </div>
                    `;
            }
        }

        // -------------------------------------------------------------------------
        // ADD WIDGET TO CANVAS
        // -------------------------------------------------------------------------
        function addWidgetToCanvas(type) {
            let newBlock = {
                id: 'b_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5),
                type: type
            };

            // Set default data by type
            switch(type) {
                case 'heading':
                    newBlock.text = 'আপনার নতুন আকর্ষনীয় হেডলাইন';
                    break;
                case 'text':
                    newBlock.text = 'এখানে আপনার প্রোডাক্টের প্রয়োজনীয় বর্ণনা বা বিশেষ অফার বার্তা লিখুন।';
                    break;
                case 'image':
                    newBlock.url = PRODUCT.thumbnail;
                    break;
                case 'video':
                    newBlock.video_url = 'https://youtube.com/watch?v=example';
                    break;
                case 'button':
                    newBlock.text = 'অর্ডার করতে ক্লিক করুন';
                    break;
                case 'urgency':
                    newBlock.text = '⏰ বিশেষ অফারটি শেষ হতে বাকি আছে:';
                    newBlock.hours = '05';
                    newBlock.minutes = '00';
                    newBlock.seconds = '00';
                    break;
                case 'features':
                    newBlock.title = 'পণ্যের বিশেষ বৈশিষ্ট্যসমূহ';
                    newBlock.items = ['১০০% অরিজিনাল কোয়ালিটি', 'ক্যাশ অন ডেলিভারি', 'দ্রুততম সময়ে ডেলিভারি'];
                    break;
                case 'product_hero':
                    newBlock.badge = '🔥 হট ডিল!';
                    newBlock.title = PRODUCT.name;
                    newBlock.subtitle = PRODUCT.shortDesc;
                    newBlock.image = PRODUCT.thumbnail;
                    break;
                case 'product_price':
                    newBlock.heading = 'অফার প্রাইজ (সীমিত সময়ের জন্য)';
                    break;
                case 'order_form':
                    newBlock.title = 'অর্ডার করতে আপনার সঠিক তথ্য দিন';
                    newBlock.subtitle = 'ডেলিভারি ম্যানের কাছে পণ্য পেয়ে মূল্য পরিশোধ করুন';
                    break;
            }

            blocks.push(newBlock);
            renderBlocks();
            selectBlock(newBlock.id);

            // Scroll down to newly added block
            setTimeout(() => {
                const el = document.querySelector(`[data-id="${newBlock.id}"]`);
                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 50);
        }

        // -------------------------------------------------------------------------
        // SELECT BLOCK & OPEN INSPECTOR PANEL
        // -------------------------------------------------------------------------
        function selectBlock(blockId) {
            selectedBlockId = blockId;
            const block = blocks.find(b => b.id === blockId);
            if (!block) return;

            // Highlight in canvas
            document.querySelectorAll('.builder-block').forEach(el => {
                el.classList.toggle('active-selected', el.getAttribute('data-id') === blockId);
            });

            // Switch left sidebar to inspector
            panelElements.classList.add('hidden');
            panelInspector.classList.remove('hidden');
            inspectorBlockType.textContent = block.type.replace('_', ' ');

            // Build inspector form fields based on block
            buildInspectorFields(block);
        }

        function closeInspector() {
            selectedBlockId = null;
            panelInspector.classList.add('hidden');
            panelElements.classList.remove('hidden');
            document.querySelectorAll('.builder-block').forEach(el => el.classList.remove('active-selected'));
        }

        function buildInspectorFields(block) {
            inspectorFields.innerHTML = '';

            const createInput = (label, key, val, type = 'text') => {
                const div = document.createElement('div');
                div.className = 'space-y-1';
                div.innerHTML = `
                    <label class="block font-bold text-slate-300 text-[11px]">${label}</label>
                    <input type="${type}" value="${escapeHtml(val || '')}" 
                           class="w-full p-2 bg-[#252730] border border-[#2e313d] rounded-lg text-slate-200 text-xs focus:border-cyan-500 focus:ring-0">
                `;
                const inp = div.querySelector('input');
                inp.addEventListener('input', (e) => {
                    block[key] = e.target.value;
                    renderBlocks();
                });
                return div;
            };

            const createTextarea = (label, key, val) => {
                const div = document.createElement('div');
                div.className = 'space-y-1';
                div.innerHTML = `
                    <label class="block font-bold text-slate-300 text-[11px]">${label}</label>
                    <textarea rows="3" class="w-full p-2 bg-[#252730] border border-[#2e313d] rounded-lg text-slate-200 text-xs focus:border-cyan-500 focus:ring-0">${escapeHtml(val || '')}</textarea>
                `;
                const area = div.querySelector('textarea');
                area.addEventListener('input', (e) => {
                    block[key] = e.target.value;
                    renderBlocks();
                });
                return div;
            };

            if (block.type === 'heading') {
                inspectorFields.appendChild(createInput('হেডলাইন টেক্সট', 'text', block.text));
            } else if (block.type === 'text') {
                inspectorFields.appendChild(createTextarea('টেক্সট কনটেন্ট', 'text', block.text));
            } else if (block.type === 'image') {
                inspectorFields.appendChild(createInput('ছবির ইউআরএল (Image URL)', 'url', block.url));
            } else if (block.type === 'button') {
                inspectorFields.appendChild(createInput('বাটন টেক্সট', 'text', block.text));
            } else if (block.type === 'urgency') {
                inspectorFields.appendChild(createInput('টাইমার শিরোনাম', 'text', block.text));
                inspectorFields.appendChild(createInput('ঘণ্টা (Hours)', 'hours', block.hours));
                inspectorFields.appendChild(createInput('মিনিট (Minutes)', 'minutes', block.minutes));
                inspectorFields.appendChild(createInput('সেকেন্ড (Seconds)', 'seconds', block.seconds));
            } else if (block.type === 'product_hero') {
                inspectorFields.appendChild(createInput('ব্যাজ টেক্সট', 'badge', block.badge));
                inspectorFields.appendChild(createInput('টাইটেল', 'title', block.title));
                inspectorFields.appendChild(createTextarea('সাবটাইটেল', 'subtitle', block.subtitle));
                inspectorFields.appendChild(createInput('ছবির ইউআরএল', 'image', block.image));
            } else if (block.type === 'order_form') {
                inspectorFields.appendChild(createInput('ফর্ম শিরোনাম', 'title', block.title));
                inspectorFields.appendChild(createTextarea('সাবটাইটেল', 'subtitle', block.subtitle));
            } else if (block.type === 'features') {
                inspectorFields.appendChild(createInput('সেকশন শিরোনাম', 'title', block.title));
                const itemsDiv = document.createElement('div');
                itemsDiv.className = 'space-y-1.5 pt-2 border-t border-[#2b2d35]';
                itemsDiv.innerHTML = `<label class="block font-bold text-slate-300 text-[11px]">বৈশিষ্ট্য তালিকা (কমা দিয়ে আলাদা করুন):</label>`;
                const itemsInp = document.createElement('textarea');
                itemsInp.rows = 4;
                itemsInp.className = 'w-full p-2 bg-[#252730] border border-[#2e313d] rounded-lg text-slate-200 text-xs focus:border-cyan-500 focus:ring-0';
                itemsInp.value = (block.items || []).join('\n');
                itemsInp.addEventListener('input', (e) => {
                    block.items = e.target.value.split('\n').filter(Boolean);
                    renderBlocks();
                });
                itemsDiv.appendChild(itemsInp);
                inspectorFields.appendChild(itemsDiv);
            }
        }

        // -------------------------------------------------------------------------
        // BLOCK ORDERING & DELETION
        // -------------------------------------------------------------------------
        function moveBlock(index, dir, e) {
            e.stopPropagation();
            const newIndex = index + dir;
            if (newIndex < 0 || newIndex >= blocks.length) return;

            const temp = blocks[index];
            blocks[index] = blocks[newIndex];
            blocks[newIndex] = temp;

            renderBlocks();
        }

        function duplicateBlock(index, e) {
            e.stopPropagation();
            const cloned = JSON.parse(JSON.stringify(blocks[index]));
            cloned.id = 'b_' + Date.now() + '_' + Math.random().toString(36).substr(2, 5);
            blocks.splice(index + 1, 0, cloned);
            renderBlocks();
            selectBlock(cloned.id);
        }

        function deleteBlock(index, e) {
            e.stopPropagation();
            if (confirm('আপনি কি নিশ্চিত যে এই ব্লকটি মুছে ফেলতে চান?')) {
                blocks.splice(index, 1);
                if (selectedBlockId) closeInspector();
                renderBlocks();
            }
        }

        // -------------------------------------------------------------------------
        // SIDEBAR COLLAPSE / EXPAND TOGGLE
        // -------------------------------------------------------------------------
        const btnToggleSidebar = document.getElementById('btnToggleSidebar');
        const btnToggleElements = document.getElementById('btnToggleElements');
        const builderSidebar = document.getElementById('builderSidebar');

        if (btnToggleSidebar) {
            btnToggleSidebar.addEventListener('click', () => {
                builderSidebar.classList.toggle('hidden');
            });
        }
        if (btnToggleElements) {
            btnToggleElements.addEventListener('click', () => {
                if (builderSidebar.classList.contains('hidden')) {
                    builderSidebar.classList.remove('hidden');
                }
                closeInspector();
            });
        }

        // -------------------------------------------------------------------------
        // RESPONSIVE PREVIEW & FULL-WIDTH SWITCHER
        // -------------------------------------------------------------------------
        const canvasViewport = document.getElementById('canvasViewport');
        const btnWide = document.getElementById('btnViewWide');
        const btnDesktop = document.getElementById('btnViewDesktop');
        const btnTablet = document.getElementById('btnViewTablet');
        const btnMobile = document.getElementById('btnViewMobile');

        if (btnWide) btnWide.addEventListener('click', () => setViewportMode('wide'));
        if (btnDesktop) btnDesktop.addEventListener('click', () => setViewportMode('desktop'));
        if (btnTablet) btnTablet.addEventListener('click', () => setViewportMode('tablet'));
        if (btnMobile) btnMobile.addEventListener('click', () => setViewportMode('mobile'));

        function setViewportMode(mode) {
            canvasViewport.classList.remove('preview-wide', 'preview-desktop', 'preview-tablet', 'preview-mobile');
            [btnWide, btnDesktop, btnTablet, btnMobile].filter(Boolean).forEach(btn => {
                btn.classList.remove('text-cyan-400', 'bg-[#18191c]', 'shadow');
                btn.classList.add('text-slate-400');
            });

            if (mode === 'wide') {
                canvasViewport.classList.add('preview-wide');
                if (btnWide) {
                    btnWide.classList.add('text-cyan-400', 'bg-[#18191c]', 'shadow');
                    btnWide.classList.remove('text-slate-400');
                }
            } else if (mode === 'desktop') {
                canvasViewport.classList.add('preview-desktop');
                if (btnDesktop) {
                    btnDesktop.classList.add('text-cyan-400', 'bg-[#18191c]', 'shadow');
                    btnDesktop.classList.remove('text-slate-400');
                }
            } else if (mode === 'tablet') {
                canvasViewport.classList.add('preview-tablet');
                if (btnTablet) {
                    btnTablet.classList.add('text-cyan-400', 'bg-[#18191c]', 'shadow');
                    btnTablet.classList.remove('text-slate-400');
                }
            } else if (mode === 'mobile') {
                canvasViewport.classList.add('preview-mobile');
                if (btnMobile) {
                    btnMobile.classList.add('text-cyan-400', 'bg-[#18191c]', 'shadow');
                    btnMobile.classList.remove('text-slate-400');
                }
            }
        }

        // -------------------------------------------------------------------------
        // CANVAS ZOOM ENGINE
        // -------------------------------------------------------------------------
        let currentZoom = 100;
        const zoomPercent = document.getElementById('zoomPercent');
        const btnZoomIn = document.getElementById('btnZoomIn');
        const btnZoomOut = document.getElementById('btnZoomOut');
        const btnZoomReset = document.getElementById('btnZoomReset');

        function updateZoom(newZoom) {
            currentZoom = Math.min(130, Math.max(50, newZoom));
            if (zoomPercent) zoomPercent.textContent = currentZoom + '%';
            if (canvasViewport) {
                if (currentZoom === 100) {
                    canvasViewport.style.transform = 'none';
                } else {
                    canvasViewport.style.transform = `scale(${currentZoom / 100})`;
                }
            }
        }

        if (btnZoomIn) btnZoomIn.addEventListener('click', () => updateZoom(currentZoom + 10));
        if (btnZoomOut) btnZoomOut.addEventListener('click', () => updateZoom(currentZoom - 10));
        if (btnZoomReset) btnZoomReset.addEventListener('click', () => updateZoom(100));

        // -------------------------------------------------------------------------
        // MODAL TOGGLES
        // -------------------------------------------------------------------------
        document.getElementById('btnOpenSettings').addEventListener('click', () => openModal('modalSettings'));
        document.getElementById('btnOpenCss').addEventListener('click', () => openModal('modalCss'));
        document.getElementById('btnHistory').addEventListener('click', () => openModal('modalHistory'));

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        // Apply Custom CSS
        function applyCustomCss() {
            customCss = document.getElementById('customCssInput').value;
            document.getElementById('liveInjectedCss').innerHTML = customCss;
            closeModal('modalCss');
            showToast('কাস্টম সিএসএস কার্যকর করা হয়েছে!');
        }

        // Apply Page Settings
        function applySettings() {
            seoTitle = document.getElementById('settingSeoTitle').value;
            seoDesc = document.getElementById('settingSeoDesc').value;
            fbPixel = document.getElementById('settingFbPixel').value;
            ttPixel = document.getElementById('settingTtPixel').value;
            gtmId = document.getElementById('settingGtmId').value;
            closeModal('modalSettings');
            showToast('পেজ সেটিংস প্রয়োগ করা হয়েছে!');
        }

        // -------------------------------------------------------------------------
        // SAVE & PUBLISH AJAX DISPATCHER
        // -------------------------------------------------------------------------
        const btnPublish = document.getElementById('btnPublish');
        const btnPublishText = document.getElementById('btnPublishText');
        const btnPublishSpinner = document.getElementById('btnPublishSpinner');

        btnPublish.addEventListener('click', async () => {
            btnPublish.disabled = true;
            btnPublishText.textContent = 'Saving...';
            btnPublishSpinner.classList.remove('hidden');

            try {
                const response = await fetch("{{ route('admin.landing-pages.builder.save', $landingPage->id) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: blocks,
                        custom_css: customCss,
                        seo_title: seoTitle,
                        seo_description: seoDesc,
                        fb_pixel_id: fbPixel,
                        tiktok_pixel_id: ttPixel,
                        gtm_id: gtmId
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast('🎉 ' + data.message);
                } else {
                    alert('ত্রুটিঃ ' + (data.message || 'সেভ করা সম্ভব হয়নি।'));
                }
            } catch (err) {
                console.error(err);
                alert('সার্ভারে যোগাযোগ করতে ব্যর্থ হয়েছে।');
            } finally {
                btnPublish.disabled = false;
                btnPublishText.textContent = 'Publish';
                btnPublishSpinner.classList.add('hidden');
            }
        });

        // -------------------------------------------------------------------------
        // SEARCH WIDGETS IN SIDEBAR
        // -------------------------------------------------------------------------
        document.getElementById('widgetSearch').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase().trim();
            document.querySelectorAll('.widget-card').forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = (!term || text.includes(term)) ? 'flex' : 'none';
            });
        });

        // Utility: Toast notification
        function showToast(msg) {
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-6 right-6 bg-emerald-600 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-2xl z-50 flex items-center gap-2 border border-emerald-400/50 transition-all duration-300';
            toast.innerHTML = `<span>✓</span><span>${msg}</span>`;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Utility: Helpers
        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>"']/g, m => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m]);
        }

        function numberFormat(num) {
            return new Intl.NumberFormat('en-IN').format(num);
        }

        function openWidgetDrawer() {
            closeInspector();
            document.getElementById('builderSidebar').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
