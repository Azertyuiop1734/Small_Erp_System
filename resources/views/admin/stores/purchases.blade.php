@extends('layouts.app')

@section('title', 'سجل فواتير المشتريات')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

    /* ===== BACKGROUND ===== */
    .index-page {
        min-height: 100vh;
        padding: 2.2rem 1rem 3rem;
        position: relative;
        overflow-x: hidden;
    }
    .index-page::before {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(16,185,129,0.09) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(37,99,235,0.08) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 35%, rgba(99,102,241,0.06) 0%, transparent 55%);
        pointer-events: none; z-index: 0;
    }
    .dark .index-page::before {
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(16,185,129,0.14) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(37,99,235,0.13) 0%, transparent 60%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:300px; height:300px; background:rgba(16,185,129,0.07);  top:-70px; right:-70px; animation-delay:0s; }
    .orb-2 { width:220px; height:220px; background:rgba(37,99,235,0.07);   bottom:12%; left:-50px; animation-delay:-5s; }
    .orb-3 { width:160px; height:160px; background:rgba(99,102,241,0.06);  top:40%; right:8%;     animation-delay:-9s; }
    .dark .orb-1 { background:rgba(16,185,129,0.13); }
    .dark .orb-2 { background:rgba(37,99,235,0.13); }
    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1);} 50%{transform:translateY(-28px) scale(1.06);} }

    /* ===== LAYOUT ===== */
    .page-wrap { max-width:1240px; margin:0 auto; position:relative; z-index:1; }

    /* ===== HEADER ===== */
    .page-header {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1.2rem; margin-bottom:1.8rem;
        animation: slideDown 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px);} to{opacity:1;transform:translateY(0);} }

    .header-left { display:flex; align-items:center; gap:1.1rem; }
    .header-icon {
        width:60px; height:60px;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(5,150,105,0.35), 0 0 0 3px rgba(5,150,105,0.12);
        flex-shrink:0; position:relative;
    }
    .header-icon::before { content:''; position:absolute; inset:0; border-radius:inherit; background:linear-gradient(135deg,rgba(255,255,255,0.22),transparent); }
    .header-icon svg { color:#fff; position:relative; z-index:1; width:1.6rem; height:1.6rem; }
    .header-title { font-size:1.9rem; font-weight:900; color:#1e293b; letter-spacing:-0.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:0.82rem; color:#64748b; font-weight:600; margin-top:3px; font-style:italic; }
    .dark .header-sub { color:#94a3b8; }

    .header-meta { display:flex; align-items:center; gap:0.5rem; flex-wrap:wrap; margin-top:0.55rem; }
    .header-actions { display:flex; align-items:center; gap:0.7rem; flex-wrap:wrap; }

    .count-chip {
        display:inline-flex; flex-direction:column; align-items:flex-end;
        padding:0.55rem 1rem; border-radius:14px;
        background:rgba(37,99,235,0.08); color:#2563EB;
        border:1px solid rgba(37,99,235,0.20);
        line-height:1.15;
    }
    .dark .count-chip { background:rgba(37,99,235,0.16); color:#93c5fd; border-color:rgba(37,99,235,0.30); }
    .count-chip .lbl { font-size:0.66rem; font-weight:800; letter-spacing:0.08em; opacity:0.85; }
    .count-chip .num { font-size:1.05rem; font-weight:900; letter-spacing:-0.02em; direction:ltr; }

    .theme-btn {
        width:46px; height:46px; border-radius:14px;
        background:rgba(255,255,255,0.6); backdrop-filter:blur(12px);
        border:1.5px solid rgba(203,213,225,0.55);
        color:#475569; display:inline-flex; align-items:center; justify-content:center;
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1); cursor:pointer;
    }
    .dark .theme-btn { background:rgba(15,23,42,0.6); color:#fbbf24; border-color:rgba(71,85,105,0.4); }
    .theme-btn:hover { transform:translateY(-2px) scale(1.05); border-color:rgba(5,150,105,0.4); }

    .btn-print {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.7rem 1.1rem; border-radius:14px;
        background:rgba(255,255,255,0.6); backdrop-filter:blur(12px);
        border:1.5px solid rgba(203,213,225,0.55);
        color:#475569; font-weight:800; font-size:0.82rem;
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1); cursor:pointer;
    }
    .dark .btn-print { background:rgba(15,23,42,0.6); color:#cbd5e1; border-color:rgba(71,85,105,0.4); }
    .btn-print:hover { transform:translateY(-2px); border-color:rgba(5,150,105,0.4); color:#059669; }
    .dark .btn-print:hover { color:#34d399; }

    .btn-add {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.7rem 1.2rem;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; border-radius:14px; font-weight:800; font-size:0.85rem;
        border:1px solid rgba(255,255,255,0.18);
        box-shadow:0 6px 18px rgba(5,150,105,0.32);
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        cursor:pointer; position:relative; overflow:hidden;
    }
    .btn-add::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); transition:left 0.6s; }
    .btn-add:hover::before { left:150%; }
    .btn-add:hover { transform:translateY(-2px); box-shadow:0 10px 26px rgba(5,150,105,0.45); color:#fff; }

    /* ===== TABLE CARD ===== */
    .table-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px) saturate(160%); -webkit-backdrop-filter:blur(24px) saturate(160%);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        overflow:hidden;
        animation:slideUp 0.6s 0.12s cubic-bezier(0.34,1.56,0.64,1) both;
        margin-bottom:1.6rem;
    }
    .dark .table-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    .card-banner {
        background:linear-gradient(135deg,rgba(5,150,105,0.08) 0%,rgba(37,99,235,0.07) 100%);
        border-bottom:1px solid rgba(5,150,105,0.12);
        padding:1.2rem 1.8rem;
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:0.8rem;
    }
    .dark .card-banner { background:linear-gradient(135deg,rgba(5,150,105,0.10),rgba(37,99,235,0.10)); border-bottom-color:rgba(51,65,85,0.45); }

    .banner-pill {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.4rem 0.9rem; border-radius:999px;
        background:rgba(5,150,105,0.10); color:#059669;
        font-size:0.72rem; font-weight:800; letter-spacing:0.05em;
        border:1px solid rgba(5,150,105,0.18);
    }
    .dark .banner-pill { background:rgba(5,150,105,0.16); color:#34d399; border-color:rgba(5,150,105,0.28); }
    .banner-pill .dot { width:6px; height:6px; border-radius:50%; background:#059669; box-shadow:0 0 0 3px rgba(5,150,105,0.18); animation:pulseDot 1.6s ease-in-out infinite; }
    .dark .banner-pill .dot { background:#34d399; }
    @keyframes pulseDot { 0%,100%{opacity:1;} 50%{opacity:0.45;} }

    .banner-step { font-size:0.75rem; color:#64748b; font-weight:700; }
    .dark .banner-step { color:#94a3b8; }

    /* ===== TABLE ===== */
    .table-body { padding:0.6rem 0.8rem 1rem; overflow-x:auto; }

    .styled-table { width:100%; border-collapse:separate; border-spacing:0 0.5rem; min-width:880px; }
    .styled-table thead th {
        background:transparent;
        color:#64748b;
        font-weight:900; font-size:0.66rem;
        letter-spacing:0.12em; text-transform:uppercase;
        padding:0.85rem 0.9rem;
        text-align:right;
        border-bottom:1px dashed rgba(148,163,184,0.28);
        white-space:nowrap;
    }
    .dark .styled-table thead th { color:#94a3b8; border-bottom-color:rgba(71,85,105,0.4); }
    .styled-table thead th.is-accent { color:#2563EB; }
    .dark .styled-table thead th.is-accent { color:#60a5fa; }

    .styled-table tbody tr.item-row {
        background:rgba(255,255,255,0.55); backdrop-filter:blur(10px);
        transition:all 0.25s ease;
        border:1px solid rgba(203,213,225,0.4);
    }
    .dark .styled-table tbody tr.item-row { background:rgba(15,23,42,0.45); border-color:rgba(51,65,85,0.4); }
    .styled-table tbody tr.item-row:hover {
        background:linear-gradient(90deg, rgba(5,150,105,0.06) 0%, rgba(37,99,235,0.06) 100%);
        border-color:rgba(5,150,105,0.25);
        transform:translateY(-1px);
        box-shadow:0 6px 18px rgba(15,23,42,0.06);
    }
    .styled-table tbody td {
        padding:0.95rem 0.9rem;
        color:#1e293b; font-size:0.88rem;
        vertical-align:middle;
    }
    .dark .styled-table tbody td { color:#e2e8f0; }
    .styled-table tbody td:first-child { border-radius:0 14px 14px 0; }
    .styled-table tbody td:last-child  { border-radius:14px 0 0 14px; }

    /* ===== Cell variants ===== */
    .invoice-num {
        font-family: 'Courier New', monospace;
        font-weight:900; color:#2563EB;
        background:rgba(37,99,235,0.08);
        padding:0.4rem 0.75rem; border-radius:10px;
        border:1px solid rgba(37,99,235,0.18);
        font-size:0.85rem; display:inline-block; direction:ltr;
    }
    .dark .invoice-num { color:#93c5fd; background:rgba(37,99,235,0.16); border-color:rgba(37,99,235,0.28); }

    .supplier-cell { display:flex; align-items:center; gap:0.7rem; }
    .supplier-icon {
        width:36px; height:36px; border-radius:10px;
        background:linear-gradient(135deg,rgba(5,150,105,0.14),rgba(37,99,235,0.14));
        color:#059669; display:flex; align-items:center; justify-content:center; flex-shrink:0;
        border:1px solid rgba(5,150,105,0.18);
    }
    .dark .supplier-icon { color:#34d399; border-color:rgba(5,150,105,0.28); }
    .supplier-name { font-weight:800; color:#1e293b; }
    .dark .supplier-name { color:#f1f5f9; }

    .warehouse-chip {
        display:inline-flex; align-items:center; gap:0.4rem;
        padding:0.35rem 0.75rem; border-radius:999px;
        background:rgba(99,102,241,0.10); color:#4f46e5;
        border:1px solid rgba(99,102,241,0.20);
        font-size:0.78rem; font-weight:800;
    }
    .dark .warehouse-chip { color:#a5b4fc; background:rgba(99,102,241,0.18); border-color:rgba(99,102,241,0.32); }

    .total-chip {
        display:inline-flex; align-items:baseline; gap:0.3rem;
        padding:0.45rem 0.8rem; border-radius:10px;
        background:rgba(5,150,105,0.08); color:#059669;
        border:1px solid rgba(5,150,105,0.18);
        font-family: 'Courier New', monospace;
        font-weight:900; font-size:0.92rem;
        font-variant-numeric: tabular-nums; direction:ltr;
    }
    .total-chip small { font-size:0.62rem; opacity:0.85; }
    .dark .total-chip { color:#34d399; background:rgba(5,150,105,0.16); border-color:rgba(5,150,105,0.30); }

    .date-chip {
        display:inline-flex; align-items:center; gap:0.4rem;
        font-family: 'Courier New', monospace;
        color:#64748b; font-size:0.85rem; font-weight:700;
        direction:ltr;
    }
    .dark .date-chip { color:#94a3b8; }

    .btn-details {
        display:inline-flex; align-items:center; gap:0.4rem;
        padding:0.55rem 1rem; border-radius:12px;
        background:rgba(37,99,235,0.08); color:#2563EB;
        border:1px solid rgba(37,99,235,0.22);
        font-size:0.78rem; font-weight:800;
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        position:relative; overflow:hidden;
    }
    .btn-details::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.32),transparent); transition:left 0.55s; }
    .btn-details:hover::before { left:150%; }
    .btn-details:hover {
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; border-color:transparent;
        transform:translateY(-2px); box-shadow:0 8px 18px rgba(37,99,235,0.32);
    }
    .dark .btn-details { color:#93c5fd; background:rgba(37,99,235,0.16); border-color:rgba(37,99,235,0.30); }

    /* ===== Empty state ===== */
    .empty-state {
        padding:3.5rem 1.5rem; text-align:center;
        display:flex; flex-direction:column; align-items:center; gap:1rem;
    }
    .empty-icon {
        width:90px; height:90px; border-radius:50%;
        background:linear-gradient(135deg,rgba(5,150,105,0.12),rgba(37,99,235,0.12));
        color:#059669;
        display:inline-flex; align-items:center; justify-content:center;
        border:1px solid rgba(5,150,105,0.18);
    }
    .dark .empty-icon { color:#34d399; border-color:rgba(5,150,105,0.28); }
    .empty-text { color:#64748b; font-weight:700; }
    .dark .empty-text { color:#94a3b8; }

    .footer-note {
        margin-top:1rem;
        text-align:center; font-size:0.75rem;
        color:#94a3b8;
        display:inline-flex; align-items:center; gap:0.4rem;
        width:100%; justify-content:center;
    }

    /* ===== Print ===== */
    @media print {
        #sidebar, #toggleSidebar, .nav-bar, .no-print, button,
        a[href*="create"], footer, .orb { display:none !important; }
        .index-page::before { display:none !important; }
        #main-content, main, .container, body {
            margin:0 !important; padding:0 !important;
            width:100% !important; background:white !important;
        }
        .table-card {
            background:white !important;
            backdrop-filter:none !important;
            border:1px solid #e2e8f0 !important;
            box-shadow:none !important;
            border-radius:0 !important;
        }
        .styled-table { border-collapse:collapse !important; border-spacing:0 !important; min-width:0 !important; }
        .styled-table thead th, .styled-table tbody td {
            border:1px solid #e2e8f0 !important;
            background:white !important;
            color:black !important;
            border-radius:0 !important;
        }
        .total-chip, .invoice-num, .warehouse-chip {
            background:transparent !important; border:none !important; color:#059669 !important;
        }
        th:last-child, td:last-child { display:none !important; }
    }

    /* ===== Responsive ===== */
    @media (max-width:640px) {
        .header-title { font-size:1.5rem; }
        .header-icon { width:52px; height:52px; }
        .card-banner { padding:1rem 1.2rem; }
    }
</style>

<div class="index-page" dir="rtl">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="page-wrap">

        {{-- ============== HEADER ============== --}}
        <div class="page-header no-print">
            <div class="header-left">
                <div class="header-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h2 class="header-title">سجل فواتير المشتريات</h2>
                    <p class="header-sub">Purchase Invoices History — Manage incoming inventory operations</p>
                    <div class="header-meta">
                        <span class="banner-pill"><span class="dot"></span> بيانات محدّثة لحظياً</span>
                    </div>
                </div>
            </div>

            <div class="header-actions">
                <button onclick="window.print()" type="button" class="btn-print">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    طباعة السجل
                </button>

                <a href="{{ route('purchases.create') }}" class="btn-add">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    إضافة فاتورة شراء
                </a>

                <div class="count-chip">
                    <span class="lbl">TOTAL INVOICES</span>
                    <span class="num">{{ count($purchases) }}</span>
                </div>
            </div>
        </div>

        {{-- ============== TABLE CARD ============== --}}
        <div class="table-card">
            <div class="card-banner no-print">
                <span class="banner-pill"><span class="dot"></span> قائمة الفواتير</span>
                <span class="banner-step">عرض كامل لجميع المشتريات الواردة</span>
            </div>

            <div class="table-body">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>رقم الفاتورة</th>
                            <th>المورد</th>
                            <th>المخزن المستلم</th>
                            <th class="is-accent text-center">القيمة الإجمالية</th>
                            <th class="text-center">تاريخ الشراء</th>
                            <th class="text-center no-print">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                        <tr class="item-row">
                            <td>
                                <span class="invoice-num">#{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="supplier-cell">
                                    <div class="supplier-icon no-print">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 4V4" />
                                        </svg>
                                    </div>
                                    <span class="supplier-name">{{ $purchase->supplier->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="warehouse-chip">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v13h18V7M3 7l9-4 9 4M3 7h18M9 21V11h6v10" />
                                    </svg>
                                    {{ $purchase->warehouse->name ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="total-chip">
                                    {{ number_format($purchase->total_amount, 2) }}
                                    <small>د.ج</small>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="date-chip">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="text-center no-print">
                                <a href="{{ route('purchases.show', $purchase->id) }}" class="btn-details">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    تفاصيل الفاتورة
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="empty-text">لا توجد فواتير مشتريات مسجلة حتى الآن</p>
                                    <a href="{{ route('purchases.create') }}" class="btn-add" style="margin-top:0.4rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        إضافة أول فاتورة
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer-note no-print">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            جميع الأوقات المعروضة حسب توقيت النظام الرسمي
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
    const isDark = document.documentElement.classList.contains('dark');
    Swal.fire({
        title: 'تمت العملية بنجاح!',
        text: "{{ session('success') }}",
        icon: 'success',
        timer: 3000,
        timerProgressBar: true,
        showConfirmButton: false,
        background: isDark ? '#0f172a' : '#ffffff',
        color: isDark ? '#f8fafc' : '#1e293b',
        customClass: {
            popup: 'rounded-3xl border border-emerald-100 dark:border-emerald-900/30 shadow-emerald-500/10'
        }
    });
@endif
</script>
@endpush
