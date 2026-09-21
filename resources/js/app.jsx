import confetti from 'canvas-confetti';
import './theme-manager.js';

// =========================================================================
// BANGLA & ENGLISH MULTILINGUAL TRANSLATION ENGINE
// =========================================================================
export const translations = {
    bn: {
        helpline: 'হেল্পলাইন:',
        announcement: '🔥 সারাদেশে ক্যাশ অন ডেলিভারি | ৪৮ ঘণ্টার মধ্যে নিশ্চিত হোম ডেলিভারি!',
        track_order: 'অর্ডার ট্র্যাক করুন',
        admin_panel: 'এডমিন প্যানেল',
        search_placeholder: 'মধু, ঘি, কিচেন চপার, ট্রিমার বা পণ্য খুঁজুন...',
        whatsapp_order: 'WhatsApp অর্ডার',
        cart: 'কার্ট',
        shopping_bag: 'শপিং ব্যাগ',
        empty_cart: 'আপনার শপিং ব্যাগ বর্তমানে খালি রয়েছে।',
        start_shopping: 'শপিং শুরু করুন →',
        subtotal: 'মোট সাবটোটাল:',
        shipping_calc_note: 'ডেলিভারি চার্জ চেকআউট পেজে এলাকা অনুযায়ী হিসাব করা হবে।',
        checkout_proceed: 'অর্ডার সম্পন্ন করতে এগিয়ে যান (ক্যাশ অন ডেলিভারি)',
        cart_remove: 'মুছুন',
        quick_order_title: 'দ্রুত ক্যাশ অন ডেলিভারি অর্ডার',
        quick_order_subtitle: 'তথ্য পূরণ করুন, ডেলিভারি ম্যানের হাতে পণ্য পেয়ে টাকা দিন।',
        name_label: 'আপনার নাম',
        name_placeholder: 'সম্পূর্ণ নাম লিখুন',
        phone_label: 'মোবাইল নম্বর',
        phone_placeholder: 'যেমন: 017XXXXXXXX',
        phone_hint: '১১ ডিজিটের সঠিক মোবাইল নম্বর দিন।',
        address_label: 'সম্পূর্ণ ঠিকানা',
        address_placeholder: 'গ্রাম/রোড নম্বর, বাড়ি/ফ্ল্যাট নম্বর, থানা, জেলা',
        delivery_area_label: 'ডেলিভারি এলাকা',
        inside_dhaka: 'ঢাকা সিটিতে',
        outside_dhaka: 'ঢাকার বাইরে',
        total_payable: 'মোট প্রদেয় টাকা:',
        confirm_order: 'অর্ডার নিশ্চিত করুন (Cash on Delivery)',
        order_processing: 'অর্ডার তৈরি হচ্ছে...',
        order_now: 'অর্ডার করুন',
        add_to_cart_short: '+ কার্ট',
        btn_order_now: '⚡ অর্ডার করুন',
        btn_add_to_cart: '+ কার্টে নিন',
        cod_feature: 'ক্যাশ অন ডেলিভারি',
        cod_desc: 'পণ্য হাতে পেয়ে টাকা পরিশোধ',
        fast_delivery_feature: 'দ্রুততম ডেলিভারি',
        fast_delivery_desc: '২৪-৪৮ ঘণ্টার হোম ডেলিভারি',
        pure_feature: '১০০% খাঁটি পণ্য',
        pure_desc: 'ল্যাব টেস্টে বিশুদ্ধ প্রমাণিত',
        return_feature: '৭ দিনের রিটার্ন',
        return_desc: 'সমস্যা হলে নিশ্চিত রিপ্লেসমেন্ট',
        special_categories: 'আমাদের স্পেশাল ক্যাটাগরি',
        special_categories_desc: 'আপনার প্রয়োজনীয় পণ্য সহজে খুঁজে নিন',
        all_categories: 'সব ক্যাটাগরি →',
        flash_sale_title: 'সীমিত সময়ের ফ্ল্যাশ সেল',
        flash_sale_badge: '🔥 ফ্ল্যাশ সেল',
        trending_title: 'ট্রেন্ডিং ও জনপ্রিয় পণ্যসমূহ',
        trending_desc: 'সবচেয়ে বেশি অর্ডার করা প্রিমিয়াম পণ্যসমূহ',
        view_all: 'সবগুলো দেখুন →',
        reviews_badge: 'সম্মানিত গ্রাহকদের মতামত',
        reviews_title: 'আমাদের সন্তুষ্ট গ্রাহকদের রিভিউ',
        reviews_desc: 'হাজারো পরিবারের আস্থার প্রতীক DemandHat BD',
        added_to_cart: 'কার্টে যোগ করা হয়েছে!',
        verified_buyer: 'ভেরিফায়েড বায়ার',
        order_failed: 'অর্ডার প্রক্রিয়া করতে সমস্যা হয়েছে। তথ্য সঠিক কিনা যাচাই করুন।',
        server_error: 'সার্ভারের সাথে যোগাযোগ করা যাচ্ছে না। কিছুক্ষণ পর আবার চেষ্টা করুন।'
    },
    en: {
        helpline: 'Helpline:',
        announcement: '🔥 Cash on Delivery Nationwide | Guaranteed Home Delivery within 48 Hours!',
        track_order: 'Track Order',
        admin_panel: 'Admin Panel',
        search_placeholder: 'Search honey, ghee, chopper, trimmer or products...',
        whatsapp_order: 'WhatsApp Order',
        cart: 'Cart',
        shopping_bag: 'Shopping Bag',
        empty_cart: 'Your shopping bag is currently empty.',
        start_shopping: 'Start Shopping →',
        subtotal: 'Subtotal:',
        shipping_calc_note: 'Delivery charge will be calculated at checkout based on location.',
        checkout_proceed: 'Proceed to Checkout (Cash on Delivery)',
        cart_remove: 'Remove',
        quick_order_title: 'Quick Cash on Delivery Order',
        quick_order_subtitle: 'Fill in details, pay cash upon receiving product from delivery man.',
        name_label: 'Your Name',
        name_placeholder: 'Enter full name',
        phone_label: 'Phone Number',
        phone_placeholder: 'e.g. 017XXXXXXXX',
        phone_hint: 'Enter a valid 11-digit mobile number.',
        address_label: 'Delivery Address',
        address_placeholder: 'House/Flat No, Road, Thana, District',
        delivery_area_label: 'Delivery Area',
        inside_dhaka: 'Inside Dhaka City',
        outside_dhaka: 'Outside Dhaka',
        total_payable: 'Total Payable:',
        confirm_order: 'Confirm Order (Cash on Delivery)',
        order_processing: 'Processing Order...',
        order_now: 'Order Now',
        add_to_cart_short: '+ Cart',
        btn_order_now: '⚡ Order Now',
        btn_add_to_cart: '+ Add to Cart',
        cod_feature: 'Cash on Delivery',
        cod_desc: 'Pay cash upon delivery',
        fast_delivery_feature: 'Fastest Delivery',
        fast_delivery_desc: '24-48 hours home delivery',
        pure_feature: '100% Pure Product',
        pure_desc: 'Lab tested & guaranteed purity',
        return_feature: '7 Days Return',
        return_desc: 'Guaranteed hassle-free replacement',
        special_categories: 'Our Special Categories',
        special_categories_desc: 'Easily explore your desired categories',
        all_categories: 'All Categories →',
        flash_sale_title: 'Limited-Time Flash Sale',
        flash_sale_badge: '🔥 Flash Sale',
        trending_title: 'Trending & Popular Products',
        trending_desc: 'Top-selling premium quality items',
        view_all: 'View All →',
        reviews_badge: 'Customer Feedback',
        reviews_title: 'Reviews from Our Satisfied Customers',
        reviews_desc: 'Trusted by thousands of happy families in Bangladesh',
        added_to_cart: 'added to cart successfully!',
        verified_buyer: 'Verified Buyer',
        order_failed: 'Could not process order. Please verify your details.',
        server_error: 'Unable to connect to server. Please try again shortly.'
    }
};

window.currentLanguage = localStorage.getItem('demandhat_lang') || 'bn';

window.setLanguage = function(lang) {
    if (!translations[lang]) lang = 'bn';
    window.currentLanguage = lang;
    localStorage.setItem('demandhat_lang', lang);
    const dict = translations[lang];

    // Update text elements
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (dict[key]) {
            el.textContent = dict[key];
        }
    });

    // Update placeholders
    document.querySelectorAll('[data-i18n-placeholder]').forEach(el => {
        const key = el.getAttribute('data-i18n-placeholder');
        if (dict[key]) {
            el.placeholder = dict[key];
        }
    });

    // Update Switcher Button active classes
    const bnBtn = document.getElementById('langBnBtn');
    const enBtn = document.getElementById('langEnBtn');
    if (bnBtn && enBtn) {
        if (lang === 'en') {
            enBtn.className = 'px-2 py-0.5 rounded-md bg-emerald-600 text-white shadow transition-all cursor-pointer font-bold';
            bnBtn.className = 'px-2 py-0.5 rounded-md text-slate-300 hover:text-white transition-all cursor-pointer font-normal';
        } else {
            bnBtn.className = 'px-2 py-0.5 rounded-md bg-emerald-600 text-white shadow transition-all cursor-pointer font-bold';
            enBtn.className = 'px-2 py-0.5 rounded-md text-slate-300 hover:text-white transition-all cursor-pointer font-normal';
        }
    }
};

// =========================================================================
// GLOBAL CART STORE MANAGER
// =========================================================================
class CartStore {
    constructor() {
        this.storageKey = 'demandhat_cart_v1';
        this.items = this.load();
        this.listeners = [];
    }

    load() {
        try {
            const data = localStorage.getItem(this.storageKey);
            return data ? JSON.parse(data) : [];
        } catch (e) {
            return [];
        }
    }

    save() {
        try {
            localStorage.setItem(this.storageKey, JSON.stringify(this.items));
            this.notify();
        } catch (e) {
            console.error('Failed to save cart', e);
        }
    }

    subscribe(listener) {
        this.listeners.push(listener);
        listener(this.items);
    }

    notify() {
        this.listeners.forEach(fn => fn(this.items));
    }

    addItem(product, quantity = 1) {
        const existing = this.items.find(i => i.id === product.id);
        if (existing) {
            existing.quantity += quantity;
        } else {
            this.items.push({
                id: product.id,
                name: product.name,
                slug: product.slug,
                price: parseFloat(product.price),
                thumbnail: product.thumbnail,
                quantity: quantity
            });
        }
        this.save();
        const dict = translations[window.currentLanguage] || translations.bn;
        this.showToast(`"${product.name}" ${dict.added_to_cart || 'কার্টে যোগ করা হয়েছে!'}`);
        
        // Facebook Pixel AddToCart Event
        if (window.fbq) {
            window.fbq('track', 'AddToCart', {
                content_ids: [product.id],
                content_name: product.name,
                content_type: 'product',
                value: product.price,
                currency: 'BDT'
            });
        }
    }

    updateQuantity(productId, quantity) {
        if (quantity <= 0) {
            this.removeItem(productId);
            return;
        }
        const item = this.items.find(i => i.id === productId);
        if (item) {
            item.quantity = quantity;
            this.save();
        }
    }

    removeItem(productId) {
        this.items = this.items.filter(i => i.id !== productId);
        this.save();
    }

    clear() {
        this.items = [];
        this.save();
    }

    getCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    }

    getSubtotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-5 left-5 z-50 bg-slate-900 text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-2.5 text-sm font-semibold border border-emerald-500/50 animate-bounce';
        toast.innerHTML = `<span class="text-emerald-400 font-black">✓</span> <span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
}

window.cartStore = new CartStore();

// =========================================================================
// DOM INITIALIZER & EVENT BINDINGS
// =========================================================================
document.addEventListener('DOMContentLoaded', () => {
    // 0. Initialize Multilingual Text
    window.setLanguage(window.currentLanguage);

    // 1. Badge & Cart Drawer updates
    const countBadge = document.getElementById('cartCountBadge');
    const drawerCount = document.getElementById('cartDrawerCount');
    const drawerSubtotal = document.getElementById('cartDrawerSubtotal');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const emptyCartState = document.getElementById('emptyCartState');
    const cartFooter = document.getElementById('cartFooter');
    const cartDrawer = document.getElementById('cartDrawer');
    const cartDrawerBtn = document.getElementById('cartDrawerBtn');
    const closeCartBtn = document.getElementById('closeCartBtn');
    const cartBackdrop = document.getElementById('cartBackdrop');

    const updateCartUI = (items) => {
        const count = window.cartStore.getCount();
        const subtotal = window.cartStore.getSubtotal();
        const dict = translations[window.currentLanguage] || translations.bn;

        if (countBadge) countBadge.textContent = count;
        if (drawerCount) drawerCount.textContent = count;
        if (drawerSubtotal) drawerSubtotal.textContent = `৳ ${subtotal.toLocaleString('en-US')}`;

        if (!cartItemsContainer) return;

        if (items.length === 0) {
            if (emptyCartState) emptyCartState.classList.remove('hidden');
            if (cartFooter) cartFooter.classList.add('hidden');
            const rows = cartItemsContainer.querySelectorAll('.cart-item-row');
            rows.forEach(r => r.remove());
        } else {
            if (emptyCartState) emptyCartState.classList.add('hidden');
            if (cartFooter) cartFooter.classList.remove('hidden');

            const rows = cartItemsContainer.querySelectorAll('.cart-item-row');
            rows.forEach(r => r.remove());

            items.forEach(item => {
                const itemEl = document.createElement('div');
                itemEl.className = 'cart-item-row flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200';
                itemEl.innerHTML = `
                    <img src="${item.thumbnail || 'https://via.placeholder.com/80'}" class="w-14 h-14 object-cover rounded-xl border border-slate-200" alt="${item.name}">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-xs font-bold text-slate-800 truncate">${item.name}</h4>
                        <p class="text-xs font-black text-emerald-600 mt-0.5">৳ ${(item.price * item.quantity).toLocaleString('en-US')}</p>
                        <div class="flex items-center gap-2 mt-1.5">
                            <div class="flex items-center border border-slate-300 rounded-lg bg-white text-xs">
                                <button type="button" class="px-2 py-0.5 hover:bg-slate-100 font-bold cart-item-minus cursor-pointer" data-id="${item.id}">-</button>
                                <span class="px-2 font-bold text-slate-700">${item.quantity}</span>
                                <button type="button" class="px-2 py-0.5 hover:bg-slate-100 font-bold cart-item-plus cursor-pointer" data-id="${item.id}">+</button>
                            </div>
                            <button type="button" class="text-[11px] text-rose-500 hover:underline cart-item-remove ml-auto cursor-pointer" data-id="${item.id}">${dict.cart_remove || 'মুছুন'}</button>
                        </div>
                    </div>
                `;
                cartItemsContainer.appendChild(itemEl);
            });

            // Bind item row events
            cartItemsContainer.querySelectorAll('.cart-item-minus').forEach(b => {
                b.onclick = () => {
                    const id = parseInt(b.dataset.id);
                    const itm = window.cartStore.items.find(i => i.id === id);
                    if (itm) window.cartStore.updateQuantity(id, itm.quantity - 1);
                };
            });
            cartItemsContainer.querySelectorAll('.cart-item-plus').forEach(b => {
                b.onclick = () => {
                    const id = parseInt(b.dataset.id);
                    const itm = window.cartStore.items.find(i => i.id === id);
                    if (itm) window.cartStore.updateQuantity(id, itm.quantity + 1);
                };
            });
            cartItemsContainer.querySelectorAll('.cart-item-remove').forEach(b => {
                b.onclick = () => {
                    const id = parseInt(b.dataset.id);
                    window.cartStore.removeItem(id);
                };
            });
        }
    };

    window.cartStore.subscribe(updateCartUI);

    const openCart = () => cartDrawer && cartDrawer.classList.remove('hidden');
    const closeCart = () => cartDrawer && cartDrawer.classList.add('hidden');

    if (cartDrawerBtn) cartDrawerBtn.addEventListener('click', openCart);
    if (closeCartBtn) closeCartBtn.addEventListener('click', closeCart);
    if (cartBackdrop) cartBackdrop.addEventListener('click', closeCart);

    // 2. Add to Cart buttons
    document.querySelectorAll('.btn-add-to-cart').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const product = {
                id: parseInt(btn.dataset.id),
                name: btn.dataset.name,
                slug: btn.dataset.slug,
                price: parseFloat(btn.dataset.price),
                thumbnail: btn.dataset.thumbnail
            };
            const qtyInput = document.getElementById('productQty');
            const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
            window.cartStore.addItem(product, qty);
        });
    });

    // 3. Quick Buy / Order Now Modal (Crystal sharp, no blur, high z-index)
    const quickModal = document.getElementById('quickOrderModal');
    const quickBackdrop = document.getElementById('quickOrderBackdrop');
    const closeQuickModalBtn = document.getElementById('closeQuickModalBtn');
    const modalProductName = document.getElementById('modalProductName');
    const modalProductThumb = document.getElementById('modalProductThumb');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalProductId = document.getElementById('modalProductId');
    const modalQtyInput = document.getElementById('modalQtyInput');
    const modalQtyMinus = document.getElementById('modalQtyMinus');
    const modalQtyPlus = document.getElementById('modalQtyPlus');
    const modalGrandTotal = document.getElementById('modalGrandTotal');
    const quickOrderForm = document.getElementById('quickOrderForm');
    const quickOrderError = document.getElementById('quickOrderError');
    const modalSubmitBtn = document.getElementById('modalSubmitBtn');

    let currentModalPrice = 0;
    let currentPromoCode = '';
    let currentDiscount = 0;

    const recalcModalTotal = () => {
        const qty = parseInt(modalQtyInput.value) || 1;
        const subtotal = currentModalPrice * qty;
        const isOutside = quickOrderForm.querySelector('input[name="delivery_area"]:checked')?.value === 'outside_dhaka';
        const deliveryFee = isOutside ? (window.DemandHat?.deliveryOutside || 130) : (window.DemandHat?.deliveryInside || 70);

        // Calculate promo discount
        let discount = 0;
        if (currentPromoCode === 'SAVE100') {
            discount = Math.min(100, subtotal);
        } else if (currentPromoCode === 'OFFER50') {
            discount = Math.min(50, subtotal);
        } else if (currentPromoCode === 'DEMAND10') {
            discount = Math.round(subtotal * 0.10);
        } else if (currentPromoCode === 'FREESHIP') {
            discount = deliveryFee;
        }
        currentDiscount = discount;

        const grandTotal = Math.max(0, (subtotal + deliveryFee) - discount);

        const modalSubtotal = document.getElementById('modalSubtotal');
        const modalDeliveryFee = document.getElementById('modalDeliveryFee');
        const modalDiscountRow = document.getElementById('modalDiscountRow');
        const modalDiscountAmount = document.getElementById('modalDiscountAmount');

        if (modalSubtotal) modalSubtotal.textContent = `৳ ${subtotal.toLocaleString('en-US')}`;
        if (modalDeliveryFee) modalDeliveryFee.textContent = `৳ ${deliveryFee.toLocaleString('en-US')}`;

        if (modalDiscountRow && modalDiscountAmount) {
            if (discount > 0) {
                modalDiscountRow.classList.remove('hidden');
                modalDiscountAmount.textContent = `- ৳ ${discount.toLocaleString('en-US')}`;
            } else {
                modalDiscountRow.classList.add('hidden');
            }
        }

        if (modalGrandTotal) {
            modalGrandTotal.textContent = `৳ ${grandTotal.toLocaleString('en-US')}`;
        }
    };

    const applyQuickPromoCode = (code) => {
        const promoInput = document.getElementById('quickPromoInput');
        if (promoInput) promoInput.value = code;
        handleQuickPromoApply();
    };

    const handleQuickPromoApply = () => {
        const promoInput = document.getElementById('quickPromoInput');
        const statusEl = document.getElementById('quickPromoStatus');
        const badgeEl = document.getElementById('quickPromoAppliedBadge');
        const codeEl = document.getElementById('quickPromoAppliedCode');
        const discTextEl = document.getElementById('quickPromoAppliedDiscountText');

        const code = promoInput?.value.trim().toUpperCase();
        if (!code) {
            if (statusEl) {
                statusEl.textContent = 'কুপন কোড লিখুন';
                statusEl.className = 'text-[11px] font-bold text-rose-500';
                statusEl.classList.remove('hidden');
            }
            return;
        }

        const validCodes = {
            'SAVE100': '৳১০০ ছাড়',
            'OFFER50': '৳৫০ ছাড়',
            'DEMAND10': '১০% ছাড়',
            'FREESHIP': 'ফ্রি ডেলিভারি'
        };

        if (validCodes[code]) {
            currentPromoCode = code;
            if (badgeEl) badgeEl.classList.remove('hidden');
            if (codeEl) codeEl.textContent = code;
            if (discTextEl) discTextEl.textContent = `(${validCodes[code]})`;
            if (statusEl) {
                statusEl.textContent = 'সফলভাবে প্রয়োগ হয়েছে!';
                statusEl.className = 'text-[11px] font-bold text-emerald-600 dark:text-emerald-400';
                statusEl.classList.remove('hidden');
            }
            recalcModalTotal();
        } else {
            if (statusEl) {
                statusEl.textContent = 'অকার্যকর প্রোমো কোড!';
                statusEl.className = 'text-[11px] font-bold text-rose-500';
                statusEl.classList.remove('hidden');
            }
        }
    };

    const removeQuickPromoCode = () => {
        currentPromoCode = '';
        currentDiscount = 0;
        const promoInput = document.getElementById('quickPromoInput');
        const statusEl = document.getElementById('quickPromoStatus');
        const badgeEl = document.getElementById('quickPromoAppliedBadge');
        if (promoInput) promoInput.value = '';
        if (badgeEl) badgeEl.classList.add('hidden');
        if (statusEl) statusEl.classList.add('hidden');
        recalcModalTotal();
    };

    window.applyQuickPromoCode = applyQuickPromoCode;
    window.handleQuickPromoApply = handleQuickPromoApply;
    window.removeQuickPromoCode = removeQuickPromoCode;

    // Mobile theme cycle helper
    window.cycleStorefrontTheme = () => {
        const current = window.DemandHatTheme?.getTheme() || 'system';
        const next = current === 'system' ? 'light' : (current === 'light' ? 'dark' : 'system');
        window.DemandHatTheme?.setTheme(next);
        const mobileIcon = document.getElementById('mobileThemeIcon');
        if (mobileIcon) {
            mobileIcon.textContent = next === 'dark' ? '🌙' : (next === 'light' ? '☀️' : '💻');
        }
    };

    const openQuickModal = (data) => {
        if (!quickModal) return;
        currentModalPrice = parseFloat(data.price);
        if (modalProductId) modalProductId.value = data.id;
        if (modalProductName) modalProductName.textContent = data.name;
        if (modalProductThumb) modalProductThumb.src = data.thumbnail || 'https://via.placeholder.com/100';
        if (modalProductPrice) modalProductPrice.textContent = `৳ ${currentModalPrice.toLocaleString('en-US')}`;
        if (modalQtyInput) modalQtyInput.value = data.quantity || 1;
        
        removeQuickPromoCode();
        recalcModalTotal();
        quickModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        // Reset payment selection to Cash on Delivery default
        const codRadio = quickOrderForm?.querySelector('.quick-payment-radio[value="cash_on_delivery"]');
        if (codRadio) codRadio.checked = true;
        if (quickBkashAccordion) quickBkashAccordion.classList.add('hidden');
        if (quickNagadAccordion) quickNagadAccordion.classList.add('hidden');
        const dict = translations[window.currentLanguage] || translations.bn;
        if (modalSubmitBtn) modalSubmitBtn.querySelector('span').textContent = dict.confirm_order || 'অর্ডার নিশ্চিত করুন (Cash on Delivery)';
        const bSender = document.getElementById('quickBkashSender');
        const bTrx = document.getElementById('quickBkashTrx');
        const nSender = document.getElementById('quickNagadSender');
        const nTrx = document.getElementById('quickNagadTrx');
        if (bSender) bSender.value = '';
        if (bTrx) bTrx.value = '';
        if (nSender) nSender.value = '';
        if (nTrx) nTrx.value = '';

        // Trigger InitiateCheckout event
        if (window.fbq) {
            window.fbq('track', 'InitiateCheckout', {
                content_ids: [data.id],
                content_name: data.name,
                currency: 'BDT',
                value: currentModalPrice
            });
        }
    };

    const closeQuickModal = () => {
        if (quickModal) quickModal.classList.add('hidden');
        if (quickOrderError) quickOrderError.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    if (closeQuickModalBtn) closeQuickModalBtn.addEventListener('click', closeQuickModal);
    if (quickBackdrop) quickBackdrop.addEventListener('click', closeQuickModal);

    if (modalQtyMinus) {
        modalQtyMinus.onclick = () => {
            let val = parseInt(modalQtyInput.value) || 1;
            if (val > 1) {
                modalQtyInput.value = val - 1;
                recalcModalTotal();
            }
        };
    }
    if (modalQtyPlus) {
        modalQtyPlus.onclick = () => {
            let val = parseInt(modalQtyInput.value) || 1;
            if (val < 20) {
                modalQtyInput.value = val + 1;
                recalcModalTotal();
            }
        };
    }

    // Quick payment method radio toggling
    const quickBkashAccordion = document.getElementById('quickBkashAccordion');
    const quickNagadAccordion = document.getElementById('quickNagadAccordion');

    const handleQuickPaymentChange = () => {
        const dict = translations[window.currentLanguage] || translations.bn;
        const selected = quickOrderForm?.querySelector('.quick-payment-radio:checked')?.value || 'cash_on_delivery';
        if (selected === 'bkash') {
            quickBkashAccordion?.classList.remove('hidden');
            quickNagadAccordion?.classList.add('hidden');
            if (modalSubmitBtn) modalSubmitBtn.querySelector('span').textContent = 'বিকাশ পেমেন্ট ও অর্ডার নিশ্চিত করুন 🌸';
        } else if (selected === 'nagad') {
            quickNagadAccordion?.classList.remove('hidden');
            quickBkashAccordion?.classList.add('hidden');
            if (modalSubmitBtn) modalSubmitBtn.querySelector('span').textContent = 'নগদ পেমেন্ট ও অর্ডার নিশ্চিত করুন 🔶';
        } else {
            quickBkashAccordion?.classList.add('hidden');
            quickNagadAccordion?.classList.add('hidden');
            if (modalSubmitBtn) modalSubmitBtn.querySelector('span').textContent = dict.confirm_order || 'অর্ডার নিশ্চিত করুন (Cash on Delivery)';
        }
    };

    if (quickOrderForm) {
        quickOrderForm.querySelectorAll('.quick-payment-radio').forEach(r => {
            r.addEventListener('change', handleQuickPaymentChange);
        });

        quickOrderForm.querySelectorAll('input[name="delivery_area"]').forEach(radio => {
            radio.addEventListener('change', recalcModalTotal);
        });

        quickOrderForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const dict = translations[window.currentLanguage] || translations.bn;
            if (quickOrderError) quickOrderError.classList.add('hidden');

            const formData = new FormData(quickOrderForm);
            const paymentMethod = formData.get('payment_method') || 'cash_on_delivery';
            let senderNumber = '';
            let trxId = '';

            if (paymentMethod === 'bkash') {
                senderNumber = formData.get('bkash_sender')?.trim();
                trxId = formData.get('bkash_trx')?.trim();
                if (!senderNumber) {
                    quickOrderError.textContent = 'অনুগ্রহ করে আপনার বিকাশ মোবাইল নম্বরটি লিখুন।';
                    quickOrderError.classList.remove('hidden');
                    document.getElementById('quickBkashSender')?.focus();
                    return;
                }
                if (!trxId) {
                    quickOrderError.textContent = 'অনুগ্রহ করে বিকাশের Transaction ID (TrxID) টি লিখুন।';
                    quickOrderError.classList.remove('hidden');
                    document.getElementById('quickBkashTrx')?.focus();
                    return;
                }
            } else if (paymentMethod === 'nagad') {
                senderNumber = formData.get('nagad_sender')?.trim();
                trxId = formData.get('nagad_trx')?.trim();
                if (!senderNumber) {
                    quickOrderError.textContent = 'অনুগ্রহ করে আপনার নগদ মোবাইল নম্বরটি লিখুন।';
                    quickOrderError.classList.remove('hidden');
                    document.getElementById('quickNagadSender')?.focus();
                    return;
                }
                if (!trxId) {
                    quickOrderError.textContent = 'অনুগ্রহ করে নগদের Transaction ID (TrxID) টি লিখুন।';
                    quickOrderError.classList.remove('hidden');
                    document.getElementById('quickNagadTrx')?.focus();
                    return;
                }
            }

            modalSubmitBtn.disabled = true;
            modalSubmitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 text-white mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>${dict.order_processing || 'অর্ডার তৈরি হচ্ছে...'}</span>
            `;

            const payload = {
                customer_name: formData.get('customer_name'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                delivery_area: formData.get('delivery_area'),
                payment_method: paymentMethod,
                payment_sender_number: senderNumber || null,
                transaction_id: trxId || null,
                promo_code: currentPromoCode || null,
                discount_amount: currentDiscount || 0,
                items: [
                    {
                        product_id: parseInt(formData.get('product_id')),
                        quantity: parseInt(formData.get('quantity'))
                    }
                ]
            };

            try {
                const response = await fetch(window.DemandHat?.checkoutUrl || '/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.DemandHat?.csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Trigger FB Purchase event
                    if (window.fbq) {
                        window.fbq('track', 'Purchase', {
                            currency: 'BDT',
                            value: currentModalPrice * parseInt(formData.get('quantity'))
                        });
                    }
                    window.location.href = data.redirect_url;
                } else {
                    quickOrderError.textContent = data.message || dict.order_failed;
                    quickOrderError.classList.remove('hidden');
                    modalSubmitBtn.disabled = false;
                    handleQuickPaymentChange();
                }
            } catch (err) {
                quickOrderError.textContent = dict.server_error;
                quickOrderError.classList.remove('hidden');
                modalSubmitBtn.disabled = false;
                handleQuickPaymentChange();
            }
        });
    }

    // Expose openQuickModal globally
    window.openQuickModal = openQuickModal;

    // Attach quick buy button clicks across the site
    document.querySelectorAll('.btn-quick-buy').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const qtyInput = document.getElementById('productQty');
            const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : (parseInt(btn.dataset.quantity) || 1);
            const product = {
                id: parseInt(btn.dataset.id),
                name: btn.dataset.name,
                price: parseFloat(btn.dataset.price),
                thumbnail: btn.dataset.thumbnail,
                quantity: qty
            };
            openQuickModal(product);
        });
    });

    // 4. Confetti trigger for order success page
    if (document.getElementById('celebrationSuccess')) {
        confetti({
            particleCount: 120,
            spread: 80,
            origin: { y: 0.6 }
        });
    }

    // 5. Flash Deals Urgency Countdown Timer
    const countdownEl = document.getElementById('flashDealsCountdown');
    if (countdownEl) {
        let hours = 11, minutes = 45, seconds = 30;
        setInterval(() => {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) hours--;
                }
            }
            const pad = (n) => String(n).padStart(2, '0');
            const hEl = document.getElementById('cdHours');
            const mEl = document.getElementById('cdMinutes');
            const sEl = document.getElementById('cdSeconds');
            if (hEl) hEl.textContent = pad(hours);
            if (mEl) mEl.textContent = pad(minutes);
            if (sEl) sEl.textContent = pad(seconds);
        }, 1000);
    }
});
