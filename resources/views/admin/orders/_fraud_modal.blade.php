<!-- ========================================================================= -->
<!-- FRAUD DETECTION INTELLIGENCE POPUP MODAL                                  -->
<!-- ========================================================================= -->
<div id="fraudCheckerModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div id="fraudModalBackdrop" class="fixed inset-0 bg-slate-950/75 z-40 transition-opacity cursor-pointer"></div>

    <div class="relative z-50 min-h-screen flex items-center justify-center p-4">
        <div class="relative w-full max-w-xl bg-white rounded-3xl text-left shadow-2xl border border-slate-200 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            
            <!-- Modal Header -->
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-base font-black text-slate-900">Fraud Detection Intelligence</h3>
                            <span id="fraudSourceBadge" class="hidden text-[10px] font-black px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">Live BD Courier</span>
                        </div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-xs text-slate-400">Checking: <span id="fraudModalPhone" class="font-mono font-bold text-slate-700"></span></p>
                            <a id="fraudModalCallBtn" href="tel:" class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 rounded-lg text-[11px] font-bold border border-emerald-200 transition-colors" title="কল করুন">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>কল দিন</span>
                            </a>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="closeFraudChecker()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Loading Spinner State -->
            <div id="fraudModalLoading" class="py-16 flex flex-col items-center justify-center space-y-3">
                <svg class="animate-spin h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-xs font-bold text-slate-600">BD Courier ফ্রড ডেটা বিশ্লেষণ করা হচ্ছে...</span>
            </div>

            <!-- Content Area (Rendered via JS) -->
            <div id="fraudModalContent" class="p-6 space-y-5 hidden">
                
                <!-- Risk Card -->
                <div id="fraudRiskCard" class="p-5 rounded-2xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div id="fraudRiskIcon" class="w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0">
                            ⚠️
                        </div>
                        <div>
                            <h4 id="fraudRiskTitle" class="text-base font-black tracking-wide">AVERAGE</h4>
                            <p id="fraudRiskDesc" class="text-xs mt-0.5 leading-relaxed">Moderate Risk. Some cancellations found.</p>
                        </div>
                    </div>

                    <div class="sm:text-right border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-200/60">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">RECOMMENDATION</span>
                        <span id="fraudRecommendation" class="text-xs font-bold block mt-0.5">Confirm order before shipping.</span>
                    </div>
                </div>

                <!-- 3 Metric Cards -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                        <span class="block text-[10px] font-black text-slate-400 tracking-wider uppercase">TOTAL PARCELS</span>
                        <span id="fraudTotalParcels" class="text-2xl font-black text-slate-900 mt-1 block">0</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-center">
                        <span class="block text-[10px] font-black text-emerald-700 tracking-wider uppercase">SUCCESS</span>
                        <span id="fraudSuccessParcels" class="text-2xl font-black text-emerald-600 mt-1 block">0</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-rose-50/70 border border-rose-200 text-center">
                        <span class="block text-[10px] font-black text-rose-700 tracking-wider uppercase">CANCELLED</span>
                        <span id="fraudCancelledParcels" class="text-2xl font-black text-rose-600 mt-1 block">0</span>
                    </div>
                </div>

                <!-- Overall Ratio Progress Bar -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-700">Overall Success Ratio</span>
                        <span id="fraudSuccessRatioText" class="text-slate-900 font-mono">50%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden p-0.5 border border-slate-200">
                        <div id="fraudProgressBar" class="h-full rounded-full transition-all duration-500 bg-amber-400" style="width: 50%;"></div>
                    </div>
                </div>

                <!-- Courier History Breakdown -->
                <div class="space-y-3 pt-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-slate-800">Courier History Breakdown</h4>
                    <div id="courierHistoryList" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Injected by JS -->
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="button" onclick="closeFraudChecker()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors cursor-pointer">
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const backdrop = document.getElementById('fraudModalBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', closeFraudChecker);
        }
    });

    function closeFraudChecker() {
        const modal = document.getElementById('fraudCheckerModal');
        if (modal) modal.classList.add('hidden');
    }

    async function openFraudChecker(phone) {
        const modal = document.getElementById('fraudCheckerModal');
        const loading = document.getElementById('fraudModalLoading');
        const content = document.getElementById('fraudModalContent');
        if (!modal) return;

        document.getElementById('fraudModalPhone').textContent = phone;
        const callBtn = document.getElementById('fraudModalCallBtn');
        if (callBtn) {
            callBtn.href = 'tel:' + phone;
        }

        loading.classList.remove('hidden');
        content.classList.add('hidden');
        modal.classList.remove('hidden');

        try {
            const response = await fetch(`{{ route('admin.orders.fraudCheck') }}?phone=${encodeURIComponent(phone)}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (result.success && result.report) {
                renderFraudReport(result.report);
            } else {
                alert('ফ্রড ডেটা লোড করতে ব্যর্থ হয়েছে।');
                closeFraudChecker();
            }
        } catch (err) {
            console.error(err);
            alert('সার্ভার এরর। কিছুক্ষণ পর আবার চেষ্টা করুন।');
            closeFraudChecker();
        }
    }

    function renderFraudReport(rep) {
        document.getElementById('fraudModalLoading').classList.add('hidden');
        document.getElementById('fraudModalContent').classList.remove('hidden');

        // Source badge
        const srcBadge = document.getElementById('fraudSourceBadge');
        if (srcBadge) {
            if (rep.source === 'bd_courier_live') {
                srcBadge.textContent = 'Live BD Courier';
                srcBadge.className = 'text-[10px] font-black px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200';
                srcBadge.classList.remove('hidden');
            } else {
                srcBadge.textContent = 'Store Intelligence';
                srcBadge.className = 'text-[10px] font-black px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 border border-slate-200';
                srcBadge.classList.remove('hidden');
            }
        }

        // Total, success, cancelled
        document.getElementById('fraudTotalParcels').textContent = rep.total_parcels;
        document.getElementById('fraudSuccessParcels').textContent = rep.success_parcels;
        document.getElementById('fraudCancelledParcels').textContent = rep.cancelled_parcels;

        // Progress bar
        const ratio = rep.success_ratio;
        document.getElementById('fraudSuccessRatioText').textContent = ratio + '%';
        const pBar = document.getElementById('fraudProgressBar');
        pBar.style.width = ratio + '%';

        // Risk Card Styling
        const rCard = document.getElementById('fraudRiskCard');
        const rTitle = document.getElementById('fraudRiskTitle');
        const rDesc = document.getElementById('fraudRiskDesc');
        const rRec = document.getElementById('fraudRecommendation');
        const rIcon = document.getElementById('fraudRiskIcon');

        rTitle.textContent = rep.risk_title;
        rDesc.textContent = rep.risk_description;
        rRec.textContent = rep.recommendation;

        if (rep.risk_level === 'high') {
            rCard.className = 'p-5 rounded-2xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-rose-50/80 border-rose-200 text-rose-900';
            rRec.className = 'text-xs font-black block mt-0.5 text-rose-700';
            rIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0 bg-rose-200 text-rose-800';
            rIcon.textContent = '⛔';
            pBar.className = 'h-full rounded-full transition-all duration-500 bg-rose-500';
        } else if (rep.risk_level === 'average') {
            rCard.className = 'p-5 rounded-2xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-amber-50/80 border-amber-200 text-amber-900';
            rRec.className = 'text-xs font-black block mt-0.5 text-amber-800';
            rIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0 bg-amber-200 text-amber-800';
            rIcon.textContent = '⚠️';
            pBar.className = 'h-full rounded-full transition-all duration-500 bg-amber-400';
        } else {
            rCard.className = 'p-5 rounded-2xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-emerald-50/80 border-emerald-200 text-emerald-900';
            rRec.className = 'text-xs font-black block mt-0.5 text-emerald-700';
            rIcon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-xl flex-shrink-0 bg-emerald-200 text-emerald-800';
            rIcon.textContent = '✓';
            pBar.className = 'h-full rounded-full transition-all duration-500 bg-emerald-500';
        }

        // Courier Breakdown Cards
        const cList = document.getElementById('courierHistoryList');
        cList.innerHTML = '';

        if (rep.couriers && rep.couriers.length > 0) {
            rep.couriers.forEach(c => {
                const div = document.createElement('div');
                div.className = 'p-3.5 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between hover:bg-slate-100/70 transition-colors';

                const logoContent = (c.logo && typeof c.logo === 'string' && c.logo.startsWith('http'))
                    ? `<img src="${c.logo}" alt="${c.name}" class="w-6 h-6 object-contain" onerror="this.outerHTML='<span class=\\'text-xs font-black text-slate-700\\'>${c.name.substr(0, 2).toUpperCase()}</span>'" />`
                    : `<span class="text-xs font-black text-slate-700">${(c.logo || c.name.substr(0, 2)).toUpperCase()}</span>`;

                let ratioBadgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                if (c.total === 0) {
                    ratioBadgeClass = 'bg-slate-100 text-slate-400 border-slate-200';
                } else if (c.ratio < 50) {
                    ratioBadgeClass = 'bg-rose-100 text-rose-800 border-rose-200';
                } else if (c.ratio < 80) {
                    ratioBadgeClass = 'bg-amber-100 text-amber-800 border-amber-200';
                }

                const successCount = c.success !== undefined ? c.success : Math.max(0, c.total - c.cancel);

                div.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-1 shadow-xs flex-shrink-0 overflow-hidden">
                            ${logoContent}
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-slate-900">${c.name}</h5>
                            <span class="text-[11px] text-slate-500 font-medium">
                                ${c.total} Total • <span class="text-emerald-700 font-bold">${successCount} Success</span> • <span class="text-rose-600 font-bold">${c.cancel} Cancel</span>
                            </span>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 font-black text-xs rounded-lg border ${ratioBadgeClass}">${c.ratio}%</span>
                `;
                cList.appendChild(div);
            });
        }
    }
</script>
