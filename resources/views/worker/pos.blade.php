@extends('layouts.app')

@section('content')
<style>
/* ── POS Glass Theme ── */
.pos-glass-wrap {
    position: relative;
    overflow-x: hidden;
    min-height: calc(100vh - 80px);
}

.pos-glass-wrap::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 70% 50% at 10% 10%, rgba(37,99,235,.08) 0%, transparent 60%),
        radial-gradient(ellipse 50% 40% at 90% 80%, rgba(16,185,129,.06) 0%, transparent 60%);
}

/* Orbs */
.pos-orb { position: fixed; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; animation: floatOrbPos 14s ease-in-out infinite; }
.pos-orb-1 { width: 300px; height: 300px; background: rgba(37,99,235,.06); top: -80px; right: -60px; animation-delay: 0s; }
.pos-orb-2 { width: 220px; height: 220px; background: rgba(16,185,129,.05); bottom: 10%; left: -40px; animation-delay: -6s; }
@keyframes floatOrbPos { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-24px) scale(1.05)} }

/* Glass Cards */
.glass-card-pos {
    background: rgba(255,255,255,.55); backdrop-filter: blur(22px); -webkit-backdrop-filter: blur(22px);
    border: 1px solid rgba(255,255,255,.6); border-radius: 2rem;
    box-shadow: 0 2px 0 rgba(255,255,255,.9) inset, 0 24px 60px rgba(0,0,0,.08), 0 6px 20px rgba(0,0,0,.04);
    position: relative; z-index: 1;
    transition: all .3s ease;
}
html.dark .glass-card-pos {
    background: rgba(10,17,34,.65);
    border-color: rgba(51,65,85,.4);
    box-shadow: 0 24px 60px rgba(0,0,0,.35);
}

/* Header Strip */
.pos-strip {
    background: linear-gradient(135deg, rgba(37,99,235,.08) 0%, rgba(16,185,129,.06) 100%);
    border-bottom: 1px solid rgba(37,99,235,.08);
    padding: .9rem 1.5rem;
    display: flex; align-items: center; gap: .6rem;
    border-radius: 2rem 2rem 0 0;
}
html.dark .pos-strip { background: linear-gradient(135deg, rgba(37,99,235,.12) 0%, rgba(16,185,129,.09) 100%); border-bottom-color: rgba(51,65,85,.35); }

.pos-strip-dot { width: 8px; height: 8px; border-radius: 50%; background: #2563EB; box-shadow: 0 0 8px rgba(37,99,235,.6); flex-shrink: 0; animation: pulseDot 2s infinite; }
@keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(.85)} }

.pos-strip-label { font-size: .68rem; font-weight: 900; color: #2563EB; text-transform: uppercase; letter-spacing: .12em; }
html.dark .pos-strip-label { color: #60a5fa; }

/* Hero Icon */
.pos-hero-icon {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #2563EB 0%, #10B981 100%);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 24px rgba(37,99,235,.35), 0 0 0 2px rgba(37,99,235,.12);
    position: relative; flex-shrink: 0;
}
.pos-hero-icon::after { content:''; position: absolute; inset: -2px; border-radius: 20px; background: linear-gradient(135deg, rgba(255,255,255,.3), transparent); pointer-events: none; }
.pos-hero-icon i { color: #fff; font-size: 1.4rem; position: relative; z-index: 1; }

/* Clock Badge */
.pos-clock {
    background: rgba(37,99,235,.08); backdrop-filter: blur(8px);
    border: 1px solid rgba(37,99,235,.15);
    color: #2563EB; font-weight: 900; font-family: 'Cairo', monospace;
    padding: .6rem 1.2rem; border-radius: 1rem;
    font-size: 1rem; letter-spacing: .05em;
    box-shadow: 0 4px 12px rgba(37,99,235,.1);
}
html.dark .pos-clock { background: rgba(37,99,235,.15); border-color: rgba(37,99,235,.25); color: #60a5fa; }

/* Inputs */
.pos-input-wrap {
    position: relative;
    background: rgba(255,255,255,.6); backdrop-filter: blur(8px);
    border: 1.5px solid rgba(148,163,184,.2); border-radius: 1.2rem;
    transition: all .25s ease;
}
html.dark .pos-input-wrap { background: rgba(15,23,42,.45); border-color: rgba(51,65,85,.45); }
.pos-input-wrap:focus-within {
    border-color: rgba(37,99,235,.5);
    box-shadow: 0 0 0 3px rgba(37,99,235,.12), 0 4px 16px rgba(37,99,235,.08);
    background: rgba(255,255,255,.85);
}
html.dark .pos-input-wrap:focus-within { background: rgba(15,23,42,.7); }

.pos-input-icon {
    position: absolute; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 1.1rem;
    transition: color .2s, transform .2s;
}
.pos-input-wrap:focus-within .pos-input-icon { color: #2563EB; transform: translateY(-50%) scale(1.1); }

.pos-input {
    width: 100%; background: transparent; border: none; outline: none;
    font-family: 'Cairo', sans-serif; font-weight: 700;
    color: #1e293b;
}
html.dark .pos-input { color: #f1f5f9; }
.pos-input::placeholder { color: #94a3b8; font-weight: 600; }

/* Table */
.pos-table-wrap { max-height: 520px; overflow-y: auto; }
.pos-table-wrap::-webkit-scrollbar { width: 5px; }
.pos-table-wrap::-webkit-scrollbar-track { background: transparent; }
.pos-table-wrap::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }

.pos-table { width: 100%; border-collapse: separate; border-spacing: 0; }
.pos-table thead { position: sticky; top: 0; z-index: 10; }
.pos-table th {
    background: rgba(241,245,249,.85); backdrop-filter: blur(10px);
    font-size: .65rem; font-weight: 900; color: #64748b;
    text-transform: uppercase; letter-spacing: .1em;
    padding: 1rem 1.2rem;
    border-bottom: 1px solid rgba(148,163,184,.15);
}
html.dark .pos-table th { background: rgba(15,23,42,.75); color: #94a3b8; border-bottom-color: rgba(51,65,85,.35); }

.pos-table td { padding: 1rem 1.2rem; border-bottom: 1px solid rgba(148,163,184,.08); }
html.dark .pos-table td { border-bottom-color: rgba(51,65,85,.25); }
.pos-table tr:hover td { background: rgba(37,99,235,.03); }
html.dark .pos-table tr:hover td { background: rgba(37,99,235,.06); }

/* Qty Buttons */
.qty-btn {
    width: 32px; height: 32px;
    background: rgba(255,255,255,.7); backdrop-filter: blur(4px);
    border: 1px solid rgba(148,163,184,.2); border-radius: .6rem;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; font-weight: 900; font-size: 1rem;
    transition: all .2s ease; cursor: pointer;
}
html.dark .qty-btn { background: rgba(15,23,42,.5); border-color: rgba(51,65,85,.4); color: #94a3b8; }
.qty-btn:hover { background: #2563EB; color: #fff; border-color: #2563EB; transform: scale(1.08); box-shadow: 0 4px 12px rgba(37,99,235,.3); }

/* Summary Card */
.pos-summary {
    background: linear-gradient(135deg, rgba(37,99,235,.06) 0%, rgba(16,185,129,.04) 100%);
    border: 1px solid rgba(37,99,235,.1); border-radius: 1.5rem;
    padding: 1.5rem;
}
html.dark .pos-summary { background: linear-gradient(135deg, rgba(37,99,235,.1) 0%, rgba(16,185,129,.07) 100%); border-color: rgba(51,65,85,.35); }

.pos-summary-row { display: flex; justify-content: space-between; align-items: center; padding: .6rem 0; }
.pos-summary-label { font-size: .8rem; font-weight: 700; color: #64748b; }
html.dark .pos-summary-label { color: #94a3b8; }
.pos-summary-value { font-weight: 900; font-family: 'Cairo', monospace; color: #1e293b; }
html.dark .pos-summary-value { color: #f1f5f9; }

.pos-total-row {
    border-top: 1px solid rgba(148,163,184,.2);
    padding-top: 1rem; margin-top: .5rem;
}
.pos-total-value { font-size: 1.6rem; font-weight: 900; color: #2563EB; font-family: 'Cairo', monospace; letter-spacing: -.02em; }
html.dark .pos-total-value { color: #60a5fa; }

/* Buttons */
.btn-pos-primary {
    width: 100%; padding: .85rem;
    background: linear-gradient(135deg, #2563EB 0%, #10B981 100%);
    color: #fff; border-radius: 1rem; font-weight: 900; font-size: 1rem;
    border: none; cursor: pointer;
    box-shadow: 0 6px 24px rgba(37,99,235,.35);
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    font-family: 'Cairo', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: .6rem;
    position: relative; overflow: hidden;
}
.btn-pos-primary::before { content:''; position: absolute; top: 0; left: -100%; width: 55%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,.22), transparent); transition: left .5s; }
.btn-pos-primary:hover::before { left: 160%; }
.btn-pos-primary:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 10px 32px rgba(37,99,235,.45); }
.btn-pos-primary:active { transform: scale(.97); }

.btn-pos-danger {
    width: 100%; padding: .7rem;
    background: rgba(239,68,68,.08); border: 1px solid rgba(239,68,68,.2);
    color: #EF4444; border-radius: 1rem; font-weight: 800; font-size: .9rem;
    cursor: pointer; font-family: 'Cairo', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    transition: all .25s ease;
}
.btn-pos-danger:hover { background: rgba(239,68,68,.15); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(239,68,68,.2); }

/* Price Tier */
.price-tier-pos {
    padding: .75rem; border-radius: .85rem; font-weight: 800; font-size: .8rem;
    border: 2px solid transparent; cursor: pointer; transition: all .25s ease;
    font-family: 'Cairo', sans-serif; text-align: center;
}
.price-tier-pos.active {
    border-color: #2563EB;
    background: rgba(37,99,235,.08);
    color: #2563EB;
    box-shadow: 0 4px 16px rgba(37,99,235,.15);
}
html.dark .price-tier-pos.active { background: rgba(37,99,235,.15); color: #60a5fa; }
.price-tier-pos:not(.active) {
    background: rgba(148,163,184,.08);
    color: #94a3b8;
}
.price-tier-pos:not(.active):hover {
    background: rgba(37,99,235,.06);
    color: #64748b;
}

/* Select */
.pos-select {
    background: rgba(255,255,255,.6); backdrop-filter: blur(8px);
    border: 1.5px solid rgba(148,163,184,.2); border-radius: 1.2rem;
    padding: .85rem 1rem;
    font-family: 'Cairo', sans-serif; font-weight: 700; color: #1e293b;
    outline: none; cursor: pointer;
    transition: all .25s ease;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: left 1rem center;
    background-repeat: no-repeat;
    background-size: 1.3em 1.3em;
}
html.dark .pos-select { background: rgba(15,23,42,.45); border-color: rgba(51,65,85,.45); color: #f1f5f9; }
.pos-select:focus {
    border-color: rgba(37,99,235,.5);
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
}

/* Discount Input */
.pos-discount-input {
    width: 80px; background: transparent;
    border: none; border-bottom: 2px solid rgba(239,68,68,.25);
    text-align: center; font-weight: 900; font-family: 'Cairo', monospace;
    color: #EF4444; font-size: 1.1rem;
    outline: none; padding-bottom: .2rem;
    transition: border-color .2s;
}
.pos-discount-input:focus { border-bottom-color: #EF4444; }

/* Animations */
@keyframes pageInPos { from { opacity:0; transform:translateY(20px) scale(.98) } to { opacity:1; transform:translateY(0) scale(1) } }
.pos-animate { animation: pageInPos .6s cubic-bezier(.34,1.56,.64,1) both; }
.pos-delay-1 { animation-delay: .1s; }
.pos-delay-2 { animation-delay: .2s; }
.pos-delay-3 { animation-delay: .3s; }

/* Trash Icon */
.trash-btn { color: #94a3b8; transition: all .2s ease; cursor: pointer; background: none; border: none; padding: .4rem; }
.trash-btn:hover { color: #EF4444; transform: scale(1.15); }

/* Product Image */
.pos-prod-img { width: 44px; height: 44px; border-radius: .75rem; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,.1); border: 1px solid rgba(255,255,255,.5); }
html.dark .pos-prod-img { border-color: rgba(51,65,85,.4); }

/* Empty State */
.pos-empty { text-align: center; padding: 3rem 1rem; color: #94a3b8; }
.pos-empty i { font-size: 3rem; margin-bottom: 1rem; opacity: .5; }
.pos-empty p { font-weight: 700; font-size: .9rem; }

/* Scrollbar global */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
@keyframes pageInPos {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<div class=" py-6 px-4">
    <!-- Background Orbs -->
    <div class="pos-orb pos-orb-1"></div>
    <div class="pos-orb pos-orb-2"></div>

    <div class="max-w-[1600px] mx-auto relative z-10">
        
        <!-- Header Card -->
        <div class="glass-card-pos pos-animate mb-6">
            <div class="pos-strip">
                <div class="pos-strip-dot"></div>
                <span class="pos-strip-label">نظام نقاط البيع</span>
            </div>
            <div class="p-5 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <div class="pos-hero-icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">واجهة البيع السريع</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium mt-1">
                            المستودع: <span class="text-blue-600 dark:text-blue-400 font-bold">{{ Auth::user()->warehouse->name ?? 'غير محدد' }}</span>
                        </p>
                    </div>
                </div>
                <div id="clock" class="pos-clock">
                    00:00:00
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column -->
            <div class="lg:w-2/3 space-y-6">
                
                <!-- Barcode Input -->
                <div class="glass-card-pos p-4 pos-animate pos-delay-1">
                    <div class="pos-input-wrap flex items-center">
                        <div class="pos-input-icon right-5">
                            <i class="fas fa-barcode"></i>
                        </div>
                        <input type="text" id="barcode-input" autofocus
                            class="pos-input py-4 pr-14 pl-6 text-xl"
                            placeholder="امسح الباركود للبدء...">
                    </div>
                </div>

                <!-- Products Table -->
                <div class="glass-card-pos pos-animate pos-delay-2 overflow-hidden">
                    <div class="pos-table-wrap">
                        <table class="pos-table">
                            <thead>
                                <tr>
                                    <th class="rounded-tr-2xl">الصورة</th>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th class="text-center">الكمية</th>
                                    <th>الإجمالي</th>
                                    <th class="text-center rounded-tl-2xl">حذف</th>
                                </tr>
                            </thead>
                            <tbody id="cart-table-body">
                                <!-- Empty State -->
                                <tr id="empty-row">
                                    <td colspan="6" class="pos-empty">
                                        <i class="fas fa-cart-arrow-down"></i>
                                        <p>السلة فارغة. امسح الباركود لإضافة منتجات</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary -->
            <div class="lg:w-1/3 pos-animate pos-delay-3">
                <div class="glass-card-pos p-6 sticky top-6">
                    <h3 class="text-lg font-black text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-receipt text-blue-500"></i>
                        ملخص العملية
                    </h3>
                    
                    <div class="space-y-5">
                        <!-- Customer Select -->
                        <div>
                            <label class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest mr-2 mb-2 block">اختيار الزبون</label>
                            <select id="customer-select" class="pos-select w-full">
                                <option value="">زبون نقدي (عام)</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Tiers -->
                        <div class="grid grid-cols-2 gap-3">
                            <button class="price-tier-pos active" data-tier="retail">
                                <i class="fas fa-tag mb-1 block text-lg"></i>
                                سعر التجزئة
                            </button>
                            <button class="price-tier-pos" data-tier="wholesale">
                                <i class="fas fa-boxes-stacked mb-1 block text-lg"></i>
                                سعر الجملة
                            </button>
                        </div>

                        <!-- Totals -->
                        <div class="pos-summary space-y-3">
                            <div class="pos-summary-row">
                                <span class="pos-summary-label">المجموع الفرعي</span>
                                <span id="sub-total" class="pos-summary-value text-base">0.00 DA</span>
                            </div>
                            <div class="pos-summary-row">
                                <span class="pos-summary-label text-red-500">
                                    <i class="fas fa-percent text-xs ml-1"></i>
                                    خصم
                                </span>
                                <div class="flex items-center gap-2">
                                    <input type="number" id="discount-input" value="0" min="0" max="100"
                                        class="pos-discount-input">
                                    <span class="text-red-500 font-bold text-sm">%</span>
                                </div>
                            </div>
                            <div class="pos-total-row pos-summary-row">
                                <span class="text-lg font-black text-gray-800 dark:text-white">الإجمالي</span>
                                <span id="final-total" class="pos-total-value">0.00 DA</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-3 pt-2">
                            <button id="complete-sale" class="btn-pos-primary">
                                <span id="btnText">
                                    <i class="fas fa-check-double"></i>
                                    إتمام العملية (Alt+S)
                                </span>
                                <span id="btnLoading" style="display:none;">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                    جاري الحفظ...
                                </span>
                            </button>
                            <button id="cancel-sale" class="btn-pos-danger">
                                <i class="fas fa-trash-alt"></i>
                                إلغاء السلة بالكامل
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
/* ═══════════════════════════════════════
   POS SYSTEM - GLASS THEME
   ═══════════════════════════════════════ */

// ── State ──
let cartItems = [];
let isSubmitting = false;

// ── Clock ──
function updateClock() {
    const now = new Date();
    document.getElementById('clock').innerText = now.toLocaleTimeString('en-GB', {
        hour: '2-digit', minute: '2-digit', second: '2-digit'
    });
}
setInterval(updateClock, 1000);
updateClock();

// ── Swal Glass Theme Helper ──
function swalGlass(icon, title, text, options = {}) {
    const isDark = document.documentElement.classList.contains('dark');
    
    const defaults = {
        icon: icon,
        title: title,
        text: text,
        background: isDark ? 'rgba(10,17,34,0.88)' : 'rgba(255,255,255,0.88)',
        color: isDark ? '#f1f5f9' : '#1e293b',
        backdrop: isDark ? 'rgba(0,0,0,0.55)' : 'rgba(0,0,0,0.25)',
        customClass: {
            popup: '!rounded-[2rem] !backdrop-blur-[26px] !border !shadow-[0_32px_72px_rgba(0,0,0,0.15)] !p-8',
            title: '!font-[Cairo] !font-black !text-xl !tracking-tight !mb-3',
            htmlContainer: '!font-[Cairo] !font-semibold !text-sm',
            confirmButton: '!rounded-xl !font-[Cairo] !font-bold !px-6 !py-3 !text-white !border-0 !shadow-lg !transition-all !duration-300 hover:!-translate-y-0.5 hover:!scale-[1.02] active:!scale-95',
            cancelButton: '!rounded-xl !font-[Cairo] !font-bold !px-6 !py-3 !border !transition-all !duration-300 hover:!-translate-y-0.5',
            icon: '!border-0 !mb-4',
            timerProgressBar: '!rounded-full !h-1'
        },
        showConfirmButton: true,
        confirmButtonText: 'حسناً',
        buttonsStyling: false,
        allowOutsideClick: false,
        allowEscapeKey: false
    };

    // Merge with options
    const config = { ...defaults, ...options };

    // Set button colors based on type
    if (icon === 'success' || icon === 'info') {
        config.customClass.confirmButton += ' !bg-gradient-to-r !from-blue-600 !to-emerald-500 !shadow-blue-500/30';
    } else if (icon === 'error' || icon === 'warning') {
        config.customClass.confirmButton += ' !bg-gradient-to-r !from-red-500 !to-orange-500 !shadow-red-500/30';
    }

    // Dark mode popup border
    if (isDark) {
        config.customClass.popup += ' dark:!border-gray-700/50 dark:!shadow-[0_32px_72px_rgba(0,0,0,0.45)]';
    } else {
        config.customClass.popup += ' !border-white/60 !bg-white/80';
    }

    // Cancel button styling
    config.customClass.cancelButton += isDark 
        ? ' !bg-white/5 !text-gray-400 !border-white/10 hover:!bg-white/10' 
        : ' !bg-gray-50 !text-gray-500 !border-gray-200 hover:!bg-gray-100';

    return Swal.fire(config);
}

// ── Price Tier Switch ──
const priceButtons = document.querySelectorAll('.price-tier-pos');
priceButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        priceButtons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        updatePricesByTier(this.dataset.tier);
    });
});

function updatePricesByTier(tier) {
    if (cartItems.length === 0) return;
    cartItems = cartItems.map(item => {
        item.current_price = (tier === 'wholesale') ? item.wholesale_price : item.retail_price;
        return item;
    });
    renderCart();
}

// ── Render Cart ──
function renderCart() {
    const tbody = document.getElementById('cart-table-body');
    tbody.innerHTML = '';
    let subtotal = 0;

    if (cartItems.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="pos-empty">
                    <i class="fas fa-cart-arrow-down"></i>
                    <p>السلة فارغة. امسح الباركود لإضافة منتجات</p>
                </td>
            </tr>`;
        calculateTotals(0);
        return;
    }

    cartItems.forEach((item, index) => {
        const total = item.current_price * item.quantity;
        subtotal += total;

        const tr = document.createElement('tr');
        tr.style.cssText = `animation:pageInPos .4s ease both; animation-delay:${index * 0.05}s;`;
        tr.innerHTML = `
            <td><img src="${item.image || '/images/default.png'}" class="pos-prod-img" alt="${item.name}" onerror="this.src='/images/default.png'"></td>
            <td class="font-bold text-gray-700 dark:text-gray-200">${item.name}</td>
            <td class="font-mono text-gray-600 dark:text-gray-300">${parseFloat(item.current_price).toFixed(2)} DA</td>
            <td>
                <div class="flex items-center justify-center gap-2 mx-auto w-fit">
                    <button onclick="updateQty(${index}, -1)" class="qty-btn" aria-label="تقليل الكمية">−</button>
                    <span class="w-8 text-center font-bold text-gray-800 dark:text-white select-none">${item.quantity}</span>
                    <button onclick="updateQty(${index}, 1)" class="qty-btn" aria-label="زيادة الكمية">+</button>
                </div>
            </td>
            <td class="font-black text-blue-600 dark:text-blue-400 font-mono">${total.toFixed(2)} DA</td>
            <td class="text-center">
                <button onclick="removeItem(${index})" class="trash-btn" aria-label="حذف المنتج">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </td>`;
        tbody.appendChild(tr);
    });

    calculateTotals(subtotal);
}

// ── Calculate Totals ──
function calculateTotals(subtotal) {
    const discountPercent = parseFloat(document.getElementById('discount-input').value) || 0;
    const discountAmount = (subtotal * Math.min(discountPercent, 100)) / 100;
    const finalTotal = Math.max(subtotal - discountAmount, 0);

    document.getElementById('sub-total').innerText = subtotal.toFixed(2) + ' DA';
    document.getElementById('final-total').innerText = finalTotal.toFixed(2) + ' DA';
}

document.getElementById('discount-input').addEventListener('input', function() {
    let val = parseFloat(this.value) || 0;
    if (val < 0) { this.value = 0; val = 0; }
    if (val > 100) { this.value = 100; val = 100; }
    const subtotal = cartItems.reduce((acc, item) => acc + (item.current_price * item.quantity), 0);
    calculateTotals(subtotal);
});

// ── Cart Actions ──
window.updateQty = function(index, delta) {
    cartItems[index].quantity = Math.max(1, cartItems[index].quantity + delta);
    renderCart();
};

window.removeItem = function(index) {
    const itemName = cartItems[index].name;
    cartItems.splice(index, 1);
    renderCart();
    
    // Toast notification
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        background: document.documentElement.classList.contains('dark') ? 'rgba(10,17,34,0.9)' : 'rgba(255,255,255,0.9)',
        color: document.documentElement.classList.contains('dark') ? '#f1f5f9' : '#1e293b',
        customClass: {
            popup: '!rounded-2xl !backdrop-blur-xl !border !shadow-lg',
            title: '!font-[Cairo] !font-bold !text-sm'
        }
    });
    Toast.fire({
        icon: 'info',
        title: `تم حذف: ${itemName}`
    });
};

// ── Cancel Sale ──
document.getElementById('cancel-sale').addEventListener('click', function() {
    if (cartItems.length === 0) {
        swalGlass('info', 'السلة فارغة', 'لا يوجد منتجات للإلغاء', {
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });
        return;
    }

    swalGlass('warning', 'تأكيد الإلغاء', 'هل أنت متأكد من رغبتك في إفراغ السلة بالكامل؟', {
        showCancelButton: true,
        confirmButtonText: 'نعم، إفراغ',
        cancelButtonText: 'تراجع',
        confirmButtonColor: '#EF4444',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            cartItems = [];
            renderCart();
            document.getElementById('barcode-input').focus();
            
            swalGlass('success', 'تم الإفراغ', 'تم إفراغ السلة بنجاح', {
                showConfirmButton: false,
                timer: 1200,
                timerProgressBar: true
            });
        }
    });
});

// ── Complete Sale ──
document.getElementById('complete-sale').addEventListener('click', async function() {
    if (isSubmitting) return;
    
    if (cartItems.length === 0) {
        swalGlass('warning', 'السلة فارغة!', 'أضف منتجات قبل إتمام العملية', {
            timer: 2500,
            timerProgressBar: true
        });
        return;
    }

    // Loading state
    isSubmitting = true;
    const btn = this;
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    btn.disabled = true;

    const data = {
        customer_id: document.getElementById('customer-select').value,
        discount: document.getElementById('discount-input').value,
        price_type: document.querySelector('.price-tier-pos.active').dataset.tier,
        items: cartItems.map(item => ({
            id: item.id,
            quantity: item.quantity,
            price: item.current_price
        }))
    };

    try {
        const response = await fetch('{{ url("/pos/add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const res = await response.json();

        if (res.success) {
            await swalGlass('success', 'تم الحفظ بنجاح', 'تمت عملية البيع بنجاح', {
                confirmButtonText: 'طباعة الفاتورة',
                timer: 3000,
                timerProgressBar: true
            });
            
            window.open(`{{ url('/pos/print') }}/${res.sale_id}`, '_blank');
            setTimeout(() => location.reload(), 800);
        } else {
            throw new Error(res.message || 'خطأ غير معروف');
        }
    } catch (err) {
        swalGlass('error', 'خطأ في العملية', err.message, {
            confirmButtonText: 'حاول مرة أخرى'
        });
        
        btnText.style.display = 'inline-flex';
        btnLoading.style.display = 'none';
        btn.disabled = false;
        isSubmitting = false;
    }
});

// ── Keyboard Shortcuts ──
window.addEventListener('keydown', function(e) {
    // Alt+S: Complete sale
    if (e.altKey && (e.key === 's' || e.key === 'S')) {
        e.preventDefault();
        document.getElementById('complete-sale').click();
    }
    // Ctrl+B: Focus barcode
    if (e.ctrlKey && (e.key === 'b' || e.key === 'B')) {
        e.preventDefault();
        document.getElementById('barcode-input').focus();
    }
    // Escape: Cancel sale (if cart not empty)
    if (e.key === 'Escape' && cartItems.length > 0) {
        document.getElementById('cancel-sale').click();
    }
});

// ── Barcode Input ──
const barcodeInput = document.getElementById('barcode-input');
barcodeInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const code = this.value.trim();
        if (!code) return;
        
        // Here you would typically fetch product by barcode
        // For now, just clear and focus
        this.value = '';
        
        // Add your barcode fetch logic here:
        // fetchProductByBarcode(code);
    }
});

// ── Focus barcode on load ──
document.addEventListener('DOMContentLoaded', () => {
    barcodeInput.focus();
});

// ── Keep focus on barcode after any cart action ──
document.addEventListener('click', function(e) {
    if (!e.target.closest('.qty-btn') && !e.target.closest('.trash-btn') && !e.target.closest('button')) {
        return;
    }
    setTimeout(() => barcodeInput.focus(), 100);
});
</script>
@endsection