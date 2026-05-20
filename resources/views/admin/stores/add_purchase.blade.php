@extends('layouts.app')

@section('title', 'اضافة فاتورة')

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

    .invoice-chip {
        display:inline-flex; flex-direction:column; align-items:flex-end;
        padding:0.55rem 1rem; border-radius:14px;
        background:rgba(37,99,235,0.08); color:#2563EB;
        border:1px solid rgba(37,99,235,0.20);
        line-height:1.15;
    }
    .dark .invoice-chip { background:rgba(37,99,235,0.16); color:#93c5fd; border-color:rgba(37,99,235,0.30); }
    .invoice-chip .lbl { font-size:0.66rem; font-weight:800; letter-spacing:0.08em; opacity:0.85; }
    .invoice-chip .num { font-size:1.05rem; font-weight:900; letter-spacing:-0.02em; direction:ltr; }

    .theme-btn {
        width:46px; height:46px; border-radius:14px;
        background:rgba(255,255,255,0.6); backdrop-filter:blur(12px);
        border:1.5px solid rgba(203,213,225,0.55);
        color:#475569; display:inline-flex; align-items:center; justify-content:center;
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1); cursor:pointer;
    }
    .dark .theme-btn { background:rgba(15,23,42,0.6); color:#fbbf24; border-color:rgba(71,85,105,0.4); }
    .theme-btn:hover { transform:translateY(-2px) scale(1.05); border-color:rgba(5,150,105,0.4); }

    /* ===== GLASS CARDS ===== */
    .glass-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px) saturate(160%); -webkit-backdrop-filter:blur(24px) saturate(160%);
        border:1px solid rgba(255,255,255,0.65); border-radius:1.5rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        animation:slideUp 0.6s 0.08s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .dark .glass-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    .table-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px) saturate(160%); -webkit-backdrop-filter:blur(24px) saturate(160%);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        overflow:hidden;
        animation:slideUp 0.6s 0.12s cubic-bezier(0.34,1.56,0.64,1) both;
        margin-bottom:1.6rem;
    }
    .dark .table-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }

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

    /* ===== TOP META FIELDS ===== */
    .meta-grid { display:grid; grid-template-columns:1fr; gap:1rem; margin-bottom:1.6rem; }
    @media (min-width:768px) { .meta-grid { grid-template-columns:repeat(3, 1fr); gap:1.2rem; } }

    .meta-card { padding:1.1rem 1.2rem; animation:slideUp 0.55s cubic-bezier(0.34,1.56,0.64,1) both; }
    .meta-card:nth-child(1) { animation-delay:0.05s; }
    .meta-card:nth-child(2) { animation-delay:0.10s; }
    .meta-card:nth-child(3) { animation-delay:0.15s; }

    .meta-label {
        display:flex; align-items:center; gap:0.55rem;
        font-size:0.78rem; font-weight:800; color:#475569; margin-bottom:0.7rem;
    }
    .dark .meta-label { color:#cbd5e1; }
    .meta-label .ico {
        width:30px; height:30px; border-radius:9px;
        display:inline-flex; align-items:center; justify-content:center;
        background:rgba(5,150,105,0.10); color:#059669;
        border:1px solid rgba(5,150,105,0.18);
    }
    .dark .meta-label .ico { background:rgba(5,150,105,0.18); color:#34d399; border-color:rgba(5,150,105,0.28); }

    .field-control {
        width:100%; padding:0.85rem 1rem;
        background:rgba(255,255,255,0.78);
        border:1.5px solid rgba(203,213,225,0.55);
        border-radius:14px;
        color:#1e293b; font-size:0.92rem; font-weight:600;
        outline:none;
        transition:all 0.22s ease;
    }
    .dark .field-control { background:rgba(15,23,42,0.6); border-color:rgba(71,85,105,0.45); color:#e2e8f0; }
    .field-control:focus {
        border-color:rgba(5,150,105,0.55);
        box-shadow:0 0 0 4px rgba(5,150,105,0.10);
        background:rgba(255,255,255,0.95);
    }
    .dark .field-control:focus { background:rgba(15,23,42,0.85); }

    /* ===== ITEMS TABLE ===== */
    .btn-add-item {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.65rem 1.1rem;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; border-radius:12px; font-weight:800; font-size:0.82rem;
        border:1px solid rgba(255,255,255,0.18);
        box-shadow:0 6px 18px rgba(5,150,105,0.28);
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        cursor:pointer; position:relative; overflow:hidden;
    }
    .btn-add-item::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); transition:left 0.6s; }
    .btn-add-item:hover::before { left:150%; }
    .btn-add-item:hover { transform:translateY(-2px); box-shadow:0 10px 26px rgba(5,150,105,0.40); }

    .table-body { padding:0.6rem 0.6rem 0.8rem; overflow-x:auto; }

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
    }
    .styled-table tbody td {
        padding:0.85rem 0.9rem;
        color:#1e293b; font-size:0.88rem;
        vertical-align:middle;
    }
    .dark .styled-table tbody td { color:#e2e8f0; }
    .styled-table tbody td:first-child { border-radius:0 14px 14px 0; }
    .styled-table tbody td:last-child  { border-radius:14px 0 0 14px; }

    .row-input {
        width:100%; padding:0.55rem 0.7rem;
        background:rgba(255,255,255,0.85);
        border:1.5px solid rgba(203,213,225,0.5);
        border-radius:10px;
        color:#1e293b; font-size:0.85rem; font-weight:600;
        outline:none; transition:all 0.2s ease;
    }
    .dark .row-input { background:rgba(15,23,42,0.55); border-color:rgba(71,85,105,0.45); color:#e2e8f0; }
    .row-input:focus { border-color:rgba(5,150,105,0.55); box-shadow:0 0 0 3px rgba(5,150,105,0.10); }
    .row-input.is-readonly {
        background:rgba(241,245,249,0.7); color:#64748b; border-style:dashed;
        border-color:rgba(148,163,184,0.35);
    }
    .dark .row-input.is-readonly { background:rgba(30,41,59,0.55); color:#94a3b8; border-color:rgba(71,85,105,0.5); }
    .row-input.is-qty {
        background:rgba(37,99,235,0.08);
        border-color:rgba(37,99,235,0.25);
        color:#1d4ed8; font-weight:800; text-align:center;
    }
    .dark .row-input.is-qty { background:rgba(37,99,235,0.16); color:#93c5fd; border-color:rgba(37,99,235,0.30); }

    .line-total {
        font-weight:900; color:#059669; font-size:0.95rem;
        background:rgba(5,150,105,0.08); padding:0.35rem 0.7rem; border-radius:10px;
        border:1px solid rgba(5,150,105,0.18);
        display:inline-flex; align-items:center; gap:0.35rem;
        font-variant-numeric: tabular-nums; direction:ltr;
    }
    .dark .line-total { color:#34d399; background:rgba(5,150,105,0.16); border-color:rgba(5,150,105,0.30); }

    .remove-row {
        width:34px; height:34px;
        display:inline-flex; align-items:center; justify-content:center;
        border-radius:10px;
        background:rgba(255,255,255,0.65); backdrop-filter:blur(10px);
        border:1px solid rgba(203,213,225,0.45);
        color:#f43f5e;
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        cursor:pointer;
    }
    .dark .remove-row { background:rgba(15,23,42,0.55); border-color:rgba(71,85,105,0.4); }
    .remove-row:hover { transform:translateY(-2px); background:rgba(244,63,94,0.10); border-color:rgba(244,63,94,0.35); box-shadow:0 6px 16px rgba(244,63,94,0.18); }

    /* ===== SUMMARY ===== */
    .summary-grid { display:grid; grid-template-columns:1fr; gap:1.2rem; align-items:stretch; }
    @media (min-width:768px) { .summary-grid { grid-template-columns:1fr 1fr; gap:1.5rem; } }

    .total-card {
        position:relative; overflow:hidden;
        padding:1.6rem 1.8rem;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        border-radius:1.6rem;
        color:#fff;
        box-shadow:0 14px 40px rgba(5,150,105,0.32);
        display:flex; flex-direction:column; justify-content:center; gap:0.6rem;
    }
    .total-card::before {
        content:''; position:absolute; inset:0;
        background:radial-gradient(circle at 90% 10%, rgba(255,255,255,0.18), transparent 50%);
        pointer-events:none;
    }
    .total-card .head { display:flex; align-items:center; justify-content:space-between; opacity:0.92; position:relative; z-index:1; }
    .total-card .head .label { font-size:0.95rem; font-weight:700; letter-spacing:-0.01em; }
    .total-card .head svg { width:1.4rem; height:1.4rem; }
    .total-card .amount-row { display:flex; align-items:baseline; gap:0.5rem; position:relative; z-index:1; }
    .total-card .amount { font-size:3rem; font-weight:900; letter-spacing:-0.04em; line-height:1; font-variant-numeric: tabular-nums; }
    .total-card .currency { font-size:1rem; font-weight:700; opacity:0.85; }

    .pay-card { padding:1.4rem 1.4rem; display:flex; flex-direction:column; gap:1rem; }
    .pay-label {
        display:flex; align-items:center; gap:0.5rem;
        font-size:0.8rem; font-weight:800; color:#475569; margin-bottom:0.5rem;
    }
    .dark .pay-label { color:#cbd5e1; }
    .pay-input {
        width:100%; padding:1rem 1.1rem;
        background:rgba(255,255,255,0.85);
        border:2px solid rgba(203,213,225,0.55);
        border-radius:16px;
        font-size:1.4rem; font-weight:900; color:#059669;
        outline:none; transition:all 0.22s ease;
        font-variant-numeric: tabular-nums; direction:ltr; text-align:left;
    }
    .dark .pay-input { background:rgba(15,23,42,0.55); border-color:rgba(71,85,105,0.45); color:#34d399; }
    .pay-input:focus { border-color:rgba(5,150,105,0.6); box-shadow:0 0 0 5px rgba(5,150,105,0.12); }

    .remaining-row {
        display:flex; align-items:center; justify-content:space-between;
        padding:0.95rem 1.1rem;
        background:rgba(244,63,94,0.07);
        border:1px solid rgba(244,63,94,0.20);
        border-radius:16px;
    }
    .dark .remaining-row { background:rgba(244,63,94,0.12); border-color:rgba(244,63,94,0.30); }
    .remaining-row .lbl { font-weight:800; color:#be123c; font-size:0.9rem; }
    .dark .remaining-row .lbl { color:#fb7185; }
    .remaining-row .val { font-weight:900; color:#e11d48; font-size:1.4rem; font-variant-numeric: tabular-nums; direction:ltr; }
    .dark .remaining-row .val { color:#fb7185; }

    /* ===== SUBMIT ===== */
    .btn-submit {
        margin-top:1.6rem; width:100%;
        padding:1.1rem 1.4rem;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; font-size:1.05rem; font-weight:900; letter-spacing:-0.01em;
        border:1px solid rgba(255,255,255,0.18);
        border-radius:18px;
        box-shadow:0 10px 32px rgba(5,150,105,0.36);
        display:flex; align-items:center; justify-content:center; gap:0.6rem;
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        cursor:pointer; position:relative; overflow:hidden;
    }
    .btn-submit::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.22),transparent); transition:left 0.7s; }
    .btn-submit:hover::before { left:150%; }
    .btn-submit:hover { transform:translateY(-3px); box-shadow:0 16px 40px rgba(5,150,105,0.50); }

    /* ===== RESPONSIVE ===== */
    @media (max-width:640px) {
        .header-title { font-size:1.5rem; }
        .total-card .amount { font-size:2.4rem; }
        .card-banner { padding:1rem 1.2rem; }
    }
</style>

<div class="index-page" dir="rtl">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="page-wrap">

        {{-- ============== HEADER ============== --}}
        <div class="page-header">
            <div class="header-left">
                <div class="header-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="header-title">إضافة فاتورة مشتريات</h2>
                    <p class="header-sub">Fill box quantities to update inventory</p>
                    <div class="header-meta">
                        <span class="banner-pill"><span class="dot"></span> فاتورة جديدة</span>
                    </div>
                </div>
            </div>

            <div class="header-actions">
                <button id="theme-toggle" type="button" class="theme-btn" aria-label="Toggle theme">
                    <svg id="theme-toggle-light-icon" class="hidden" width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden" width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                </button>

                <div class="invoice-chip">
                    <span class="lbl">INVOICE NO.</span>
                    <span class="num">#INV-{{ date('His') }}</span>
                </div>
            </div>
        </div>

        {{-- ============== FORM ============== --}}
        <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
            @csrf

            {{-- Top meta fields --}}
            <div class="meta-grid">
                <div class="glass-card meta-card">
                    <label class="meta-label">
                        <span class="ico">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </span>
                        المورد
                    </label>
                    <select name="supplier_id" class="field-control">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="glass-card meta-card">
                    <label class="meta-label">
                        <span class="ico">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4M3 7v10l9 4 9-4V7M3 7l9 4m0 0l9-4m-9 4v10"/></svg>
                        </span>
                        المخزن المستلم
                    </label>
                    <select name="warehouse_id" class="field-control">
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="glass-card meta-card">
                    <label class="meta-label">
                        <span class="ico">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                        تاريخ الشراء
                    </label>
                    <input type="date" name="purchase_date" class="field-control" dir="ltr" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            {{-- Items table --}}
            <div class="table-card">
                <div class="card-banner">
                    <div style="display:flex; align-items:center; gap:0.7rem; flex-wrap:wrap;">
                        <span class="banner-pill"><span class="dot"></span> قائمة الأصناف</span>
                        <span class="banner-step">قم بمسح الباركود ثم أدخل الكميات والأسعار</span>
                    </div>
                    <button type="button" id="add-item" class="btn-add-item">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        إضافة صنف جديد
                    </button>
                </div>

                <div class="table-body">
                    <table class="styled-table" id="products_table">
                        <thead>
                            <tr>
                                <th>الباركود</th>
                                <th>اسم المنتج</th>
                                <th>الصناديق</th>
                                <th>وحدة/صندوق</th>
                                <th class="is-accent">الكمية الكلية</th>
                                <th>سعر الوحدة</th>
                                <th style="text-align:center;">الإجمالي</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="items-container">
                            <tr class="item-row">
                                <td>
                                    <input type="text" name="items[0][barcode]" class="row-input barcode-input" placeholder="باركود" dir="ltr">
                                    <input type="hidden" name="items[0][product_id]" class="product-id">
                                </td>
                                <td>
                                    <input type="text" name="items[0][product_name]" class="row-input is-readonly product-name" readonly placeholder="اسم المنتج">
                                </td>
                                <td>
                                    <input type="number" name="items[0][boxes_count]" class="row-input boxes-count" required min="1" value="1" style="max-width:90px;">
                                </td>
                                <td>
                                    <input type="number" name="items[0][units_per_box]" class="row-input units-per-box" required min="1" value="1" style="max-width:90px;">
                                </td>
                                <td>
                                    <input type="number" name="items[0][quantity]" class="row-input is-qty qty" readonly value="1" style="max-width:90px;">
                                </td>
                                <td>
                                    <input type="number" name="items[0][price]" step="0.01" class="row-input price" required style="max-width:110px;" dir="ltr">
                                </td>
                                <td style="text-align:center;">
                                    <span class="line-total">0.00</span>
                                </td>
                                <td style="text-align:center;">
                                    <button type="button" class="remove-row" aria-label="حذف">
                                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary section --}}
            <div class="summary-grid">
                <div class="total-card">
                    <div class="head">
                        <span class="label">المبلغ الإجمالي المستحق</span>
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="amount-row" dir="ltr">
                        <span class="amount" id="grand-total-display">0.00</span>
                        <span class="currency">ريال</span>
                    </div>
                    <input type="hidden" name="total_amount" id="grand-total-input">
                </div>

                <div class="glass-card pay-card">
                    <div>
                        <label class="pay-label">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color:#059669;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m0-8a3 3 0 013 3M9 12a3 3 0 013-3"/></svg>
                            المبلغ المدفوع (الآن)
                        </label>
                        <input type="number" name="paid_amount" id="paid_amount" class="pay-input" value="0" dir="ltr">
                    </div>
                    <div class="remaining-row">
                        <span class="lbl">المبلغ المتبقي</span>
                        <span class="val" id="remaining-amount-display">0.00</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                حفظ الفاتورة وتحديث المخزون
            </button>
        </form>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCount = 1;

    const isDarkMode = () => document.documentElement.classList.contains('dark');

    // --- 1. Theme toggle ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        themeToggleDarkIcon.classList.remove('hidden');
    }

    themeToggleBtn.addEventListener('click', function() {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    });

    // --- 2. Add new item row ---
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
            input.value = input.classList.contains('qty') || input.classList.contains('boxes-count') || input.classList.contains('units-per-box') ? 1 : '';
        });

        newRow.querySelector('.line-total').textContent = '0.00';
        container.appendChild(newRow);
        newRow.querySelector('.barcode-input').focus();
        rowCount++;
    });

    // --- 3. Barcode lookup + calculations ---
    document.addEventListener('input', function(e) {
        const row = e.target.closest('.item-row');

        if (e.target.classList.contains('barcode-input') && e.target.value.trim().length >= 8) {
            fetch(`{{ url('purchases/get-product') }}/${e.target.value.trim()}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.product) {
                        row.querySelector('.product-id').value = data.product.id;
                        row.querySelector('.product-name').value = data.product.name;
                        row.querySelector('.price').value = data.product.last_purchase_price || 0;
                        calculateTotals();
                        row.querySelector('.boxes-count').focus();
                    }
                });
        }

        if (row && (e.target.classList.contains('boxes-count') || e.target.classList.contains('units-per-box'))) {
            const boxes = parseFloat(row.querySelector('.boxes-count').value) || 0;
            const units = parseFloat(row.querySelector('.units-per-box').value) || 0;
            row.querySelector('.qty').value = boxes * units;
        }

        if (e.target.classList.contains('qty') || e.target.classList.contains('price') ||
            e.target.classList.contains('boxes-count') || e.target.id === 'paid_amount') {
            calculateTotals();
        }
    });

    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const lineTotal = qty * price;
            row.querySelector('.line-total').textContent = lineTotal.toFixed(2);
            grandTotal += lineTotal;
        });

        document.getElementById('grand-total-display').textContent = grandTotal.toFixed(2);
        document.getElementById('grand-total-input').value = grandTotal.toFixed(2);
        const paid = parseFloat(document.getElementById('paid_amount').value) || 0;
        const remaining = grandTotal - paid;
        document.getElementById('remaining-amount-display').textContent = remaining.toFixed(2);
    }

    // --- 4. Remove row ---
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            if (document.querySelectorAll('.item-row').length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'عذراً',
                    text: 'يجب وجود صنف واحد على الأقل.',
                    background: isDarkMode() ? '#0f172a' : '#ffffff',
                    color: isDarkMode() ? '#f8fafc' : '#1e293b',
                    confirmButtonColor: '#ef4444',
                    customClass: { popup: 'rounded-3xl' }
                });
            }
        }
    });

    // --- 5. Submit confirmation ---
    const purchaseForm = document.getElementById('purchase-form');
    purchaseForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const isDark = isDarkMode();

        Swal.fire({
            title: 'تأكيد حفظ الفاتورة',
            text: "هل راجعت كافة الكميات والأسعار؟ سيتم تحديث المخزون فوراً.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'نعم، حفظ الآن',
            cancelButtonText: 'مراجعة مرة أخرى',
            confirmButtonColor: '#059669',
            cancelButtonColor: isDark ? '#334155' : '#94a3b8',
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            customClass: {
                popup: 'rounded-3xl shadow-2xl',
                confirmButton: 'rounded-xl px-6 py-3 font-bold',
                cancelButton: 'rounded-xl px-6 py-3 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'جاري معالجة البيانات',
                    html: 'يرجى الانتظار لحظة...',
                    allowOutsideClick: false,
                    background: isDark ? '#0f172a' : '#ffffff',
                    color: isDark ? '#f8fafc' : '#1e293b',
                    didOpen: () => { Swal.showLoading(); }
                });
                purchaseForm.submit();
            }
        });
    });
});
</script>
@endpush
