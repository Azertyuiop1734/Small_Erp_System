@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    :root {
        --primary: #2563EB;
        --primary-light: #3B82F6;
        --primary-glow: rgba(37, 99, 235, 0.15);
        --accent: #6366F1;
        --danger: #EF4444;
        --amber: #F59E0B;
        --success: #10B981;
        --surface: rgba(255,255,255,0.6);
        --surface-dark: rgba(15,23,42,0.7);
        --border: rgba(255,255,255,0.5);
        --border-dark: rgba(51,65,85,0.5);
    }

    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BACKGROUND CANVAS ===== */
    .customers-page {
        min-height: 100vh;
        padding: 2.5rem 1rem;
        position: relative;
        overflow-x: hidden;
    }

    .customers-page::before {
        content: '';
        position: fixed;
        inset: 0;
        background: 
            radial-gradient(ellipse 80% 60% at 20% 10%, rgba(37,99,235,0.12) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99,102,241,0.10) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 60% 30%, rgba(16,185,129,0.06) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .dark .customers-page::before {
        background: 
            radial-gradient(ellipse 80% 60% at 20% 10%, rgba(37,99,235,0.18) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99,102,241,0.15) 0%, transparent 60%);
    }

    /* Floating orbs */
    .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
        z-index: 0;
        animation: floatOrb 12s ease-in-out infinite;
    }
    .orb-1 { width:320px; height:320px; background:rgba(37,99,235,0.08); top:-80px; right:-80px; animation-delay:0s; }
    .orb-2 { width:250px; height:250px; background:rgba(99,102,241,0.07); bottom:10%; left:-60px; animation-delay:-5s; }
    .orb-3 { width:180px; height:180px; background:rgba(16,185,129,0.06); top:50%; right:5%; animation-delay:-9s; }

    .dark .orb-1 { background:rgba(37,99,235,0.15); }
    .dark .orb-2 { background:rgba(99,102,241,0.12); }

    @keyframes floatOrb {
        0%,100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-30px) scale(1.05); }
    }

    /* ===== LAYOUT ===== */
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        animation: slideDown 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes slideDown {
        from { opacity:0; transform:translateY(-20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .header-brand { display:flex; align-items:center; gap:1.2rem; }

    .header-icon-wrap {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 32px rgba(37,99,235,0.35), 0 0 0 3px rgba(37,99,235,0.15);
        position: relative;
        flex-shrink: 0;
    }
    .header-icon-wrap::after {
        content:'';
        position:absolute; inset:-3px;
        border-radius:23px;
        background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent);
        pointer-events:none;
    }
    .header-icon-wrap i { color:#fff; font-size:1.6rem; position:relative; z-index:1; }

    .header-title {
        font-size: 2rem;
        font-weight: 900;
        color: #1e293b;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }
    .dark .header-title { color: #f1f5f9; }

    .header-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }
    .dark .header-subtitle { color: #94a3b8; }

    /* ===== ADD BUTTON ===== */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1.75rem;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        color: #fff;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 0.95rem;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(37,99,235,0.35);
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        border: 1px solid rgba(255,255,255,0.2);
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .btn-add::before {
        content:'';
        position:absolute;
        top:0; left:-100%;
        width:60%; height:100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-add:hover::before { left:150%; }
    .btn-add:hover { transform:translateY(-2px) scale(1.03); box-shadow:0 10px 32px rgba(37,99,235,0.5); }
    .btn-add:active { transform:scale(0.97); }

    /* ===== STATS ROW ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
        animation: slideUp 0.6s 0.1s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes slideUp {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .stat-card {
        background: rgba(255,255,255,0.55);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.7);
        border-radius: 1.2rem;
        padding: 1.1rem 1.4rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dark .stat-card {
        background: rgba(15,23,42,0.55);
        border-color: rgba(51,65,85,0.5);
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 30px rgba(0,0,0,0.08); }
    .dark .stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.3); }

    .stat-icon {
        width:44px; height:44px;
        border-radius:12px;
        display:flex; align-items:center; justify-content:center;
        font-size:1.1rem;
        flex-shrink:0;
    }
    .stat-icon.blue  { background:rgba(37,99,235,0.12);  color:#2563EB; }
    .stat-icon.green { background:rgba(16,185,129,0.12); color:#10B981; }
    .stat-icon.amber { background:rgba(245,158,11,0.12); color:#F59E0B; }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1;
    }
    .dark .stat-value { color: #f1f5f9; }
    .stat-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 2px;
    }
    .dark .stat-label { color: #94a3b8; }

    /* ===== SEARCH BAR ===== */
    .search-wrap {
        position: relative;
        margin-bottom: 1.5rem;
        animation: slideUp 0.6s 0.15s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .search-wrap i {
        position: absolute;
        right: 1.1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.95rem;
    }
    .search-input {
        width: 100%;
        padding: 0.85rem 2.8rem 0.85rem 1.2rem;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.7);
        border-radius: 1.1rem;
        font-size: 0.95rem;
        font-family: 'Cairo', sans-serif;
        color: #1e293b;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.25s ease;
        outline: none;
        direction: rtl;
    }
    .dark .search-input {
        background: rgba(15,23,42,0.6);
        border-color: rgba(51,65,85,0.5);
        color: #f1f5f9;
    }
    .search-input::placeholder { color: #94a3b8; }
    .search-input:focus {
        border-color: rgba(37,99,235,0.5);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12), 0 4px 20px rgba(37,99,235,0.1);
        background: rgba(255,255,255,0.85);
    }
    .dark .search-input:focus { background: rgba(15,23,42,0.85); }

    /* ===== MAIN CARD ===== */
    .table-card {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.6);
        border-radius: 2rem;
        box-shadow: 0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.8) inset;
        overflow: hidden;
        animation: slideUp 0.6s 0.2s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .dark .table-card {
        background: rgba(15,23,42,0.55);
        border-color: rgba(51,65,85,0.45);
        box-shadow: 0 8px 40px rgba(0,0,0,0.3);
    }

    .table-overflow { overflow-x: auto; }

    /* ===== TABLE ===== */
    table { width:100%; border-collapse:collapse; direction:rtl; }

    thead tr {
        background: linear-gradient(135deg, rgba(37,99,235,0.06) 0%, rgba(99,102,241,0.06) 100%);
        border-bottom: 1px solid rgba(37,99,235,0.1);
    }
    .dark thead tr {
        background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(99,102,241,0.1) 100%);
        border-bottom-color: rgba(51,65,85,0.5);
    }

    th {
        padding: 1.1rem 1.4rem;
        font-size: 0.72rem;
        font-weight: 900;
        color: #2563EB;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        white-space: nowrap;
    }
    .dark th { color: #60a5fa; }

    /* ===== ROW ===== */
    tbody tr {
        border-bottom: 1px solid rgba(148,163,184,0.08);
        transition: all 0.25s ease;
        animation: rowIn 0.4s ease both;
    }

    @keyframes rowIn {
        from { opacity:0; transform:translateX(10px); }
        to   { opacity:1; transform:translateX(0); }
    }

    tbody tr:nth-child(1)  { animation-delay: 0.05s; }
    tbody tr:nth-child(2)  { animation-delay: 0.10s; }
    tbody tr:nth-child(3)  { animation-delay: 0.15s; }
    tbody tr:nth-child(4)  { animation-delay: 0.20s; }
    tbody tr:nth-child(5)  { animation-delay: 0.25s; }
    tbody tr:nth-child(6)  { animation-delay: 0.30s; }
    tbody tr:nth-child(7)  { animation-delay: 0.35s; }
    tbody tr:nth-child(8)  { animation-delay: 0.40s; }

    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover {
        background: rgba(37,99,235,0.04);
    }
    .dark tbody tr:hover { background: rgba(37,99,235,0.08); }

    td { padding: 1rem 1.4rem; vertical-align: middle; }

    /* ===== AVATAR ===== */
    .customer-avatar {
        width: 46px; height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #2563EB, #6366F1);
        display: flex; align-items: center; justify-content: center;
        color: #fff;
        font-weight: 900;
        font-size: 1.1rem;
        box-shadow: 0 4px 14px rgba(37,99,235,0.3);
        flex-shrink: 0;
        transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
    }
    tr:hover .customer-avatar { transform: scale(1.08) rotate(-3deg); }

    .customer-name {
        font-weight: 800;
        font-size: 0.95rem;
        color: #1e293b;
        transition: color 0.2s;
        line-height: 1.2;
    }
    .dark .customer-name { color: #f1f5f9; }
    tr:hover .customer-name { color: #2563EB; }
    .dark tr:hover .customer-name { color: #60a5fa; }

    .customer-date {
        font-size: 0.72rem;
        color: #94a3b8;
        font-weight: 600;
        margin-top: 3px;
    }

    /* ===== PHONE ===== */
    .phone-wrap {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.9rem;
        background: rgba(37,99,235,0.07);
        border-radius: 8px;
        color: #334155;
        font-weight: 700;
        font-size: 0.88rem;
        direction: ltr;
        letter-spacing: 0.02em;
    }
    .dark .phone-wrap { background:rgba(37,99,235,0.12); color:#cbd5e1; }
    .phone-wrap i { color:#2563EB; font-size:0.75rem; }

    /* ===== DISCOUNT BADGE ===== */
    .discount-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.3rem 0.8rem;
        background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(249,115,22,0.10));
        border: 1px solid rgba(245,158,11,0.3);
        border-radius: 8px;
        color: #b45309;
        font-weight: 900;
        font-size: 0.8rem;
        white-space: nowrap;
    }
    .dark .discount-badge { color: #fbbf24; background:rgba(245,158,11,0.15); border-color:rgba(245,158,11,0.25); }
    .discount-badge .pct { font-size: 0.65rem; opacity: 0.75; }

    /* ===== ACTION BUTTONS ===== */
    .actions-wrap { display:flex; align-items:center; justify-content:center; gap:0.5rem; }

    .btn-action {
        width: 38px; height: 38px;
        border-radius: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
        border: 1px solid rgba(148,163,184,0.15);
        background: rgba(255,255,255,0.7);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        backdrop-filter: blur(8px);
        position: relative;
        overflow: hidden;
    }
    .dark .btn-action { background:rgba(30,41,59,0.7); border-color:rgba(71,85,105,0.3); }

    .btn-action::after {
        content:'';
        position:absolute;
        inset:0;
        opacity:0;
        transition:opacity 0.2s;
        border-radius:inherit;
    }
    .btn-action:hover::after { opacity:1; }
    .btn-action:hover { transform:scale(1.12) translateY(-2px); }
    .btn-action:active { transform:scale(0.95); }

    .btn-edit   { color: #F59E0B; }
    .btn-edit::after  { background:linear-gradient(135deg,rgba(245,158,11,0.15),rgba(249,115,22,0.15)); }
    .btn-edit:hover   { border-color:rgba(245,158,11,0.4); box-shadow:0 4px 16px rgba(245,158,11,0.25); }

    .btn-hist   { color: #2563EB; }
    .btn-hist::after  { background:rgba(37,99,235,0.12); }
    .btn-hist:hover   { border-color:rgba(37,99,235,0.35); box-shadow:0 4px 16px rgba(37,99,235,0.2); }

    .btn-del    { color: #EF4444; }
    .btn-del::after   { background:rgba(239,68,68,0.1); }
    .btn-del:hover    { border-color:rgba(239,68,68,0.35); box-shadow:0 4px 16px rgba(239,68,68,0.2); }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        padding: 5rem 2rem;
        text-align: center;
    }
    .empty-icon-wrap {
        width: 90px; height: 90px;
        border-radius: 28px;
        background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(99,102,241,0.08));
        border: 1px solid rgba(37,99,235,0.12);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }
    .empty-icon-wrap i { font-size: 2.5rem; color: #94a3b8; }
    .empty-title { font-size: 1.2rem; font-weight: 900; color: #64748b; }
    .dark .empty-title { color: #475569; }
    .empty-sub { font-size: 0.85rem; color: #94a3b8; margin-top: 0.4rem; font-weight: 500; }

    /* ===== PAGINATION ===== */
    .pagination-wrap {
        margin-top: 1.25rem;
        background: rgba(255,255,255,0.4);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.5);
        border-radius: 1.2rem;
        padding: 0.85rem 1.2rem;
        animation: slideUp 0.6s 0.3s both;
    }
    .dark .pagination-wrap {
        background: rgba(15,23,42,0.4);
        border-color: rgba(51,65,85,0.4);
    }

    /* ===== CONFIRM MODAL ===== */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.45);
        backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        z-index: 9999;
        opacity: 0; pointer-events: none;
        transition: opacity 0.25s ease;
    }
    .modal-overlay.show { opacity:1; pointer-events:all; }

    .modal-box {
        background: #fff;
        border-radius: 1.8rem;
        padding: 2.2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.8);
        text-align: center;
        transform: scale(0.85) translateY(20px);
        transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
        direction: rtl;
    }
    .dark .modal-box { background:#1e293b; border-color:rgba(51,65,85,0.5); }
    .modal-overlay.show .modal-box { transform: scale(1) translateY(0); }

    .modal-danger-icon {
        width:70px; height:70px;
        background: linear-gradient(135deg, rgba(239,68,68,0.1), rgba(239,68,68,0.05));
        border: 2px solid rgba(239,68,68,0.2);
        border-radius: 20px;
        display: flex; align-items:center; justify-content:center;
        margin: 0 auto 1.2rem;
    }
    .modal-danger-icon i { font-size:1.8rem; color:#EF4444; }

    .modal-title { font-size:1.2rem; font-weight:900; color:#1e293b; margin-bottom:0.5rem; }
    .dark .modal-title { color:#f1f5f9; }
    .modal-text  { font-size:0.88rem; color:#64748b; font-weight:500; margin-bottom:1.8rem; line-height:1.6; }
    .dark .modal-text  { color:#94a3b8; }

    .modal-btns { display:flex; gap:0.8rem; justify-content:center; }

    .btn-modal {
        flex:1; padding:0.75rem 1.2rem;
        border-radius:12px;
        font-weight:800;
        font-size:0.9rem;
        cursor:pointer;
        border:none;
        transition: all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        font-family:'Cairo',sans-serif;
    }
    .btn-modal:hover { transform:scale(1.04); }
    .btn-cancel { background:rgba(148,163,184,0.12); color:#64748b; }
    .dark .btn-cancel { background:rgba(71,85,105,0.3); color:#94a3b8; }
    .btn-cancel:hover { background:rgba(148,163,184,0.2); }
    .btn-confirm { background:linear-gradient(135deg,#EF4444,#DC2626); color:#fff; box-shadow:0 4px 16px rgba(239,68,68,0.3); }
    .btn-confirm:hover { box-shadow:0 6px 24px rgba(239,68,68,0.45); }

    /* ===== TOOLTIP ===== */
    [data-tip] { position:relative; }
    [data-tip]::before {
        content: attr(data-tip);
        position: absolute;
        bottom: calc(100% + 8px);
        left: 50%; transform: translateX(-50%);
        background: #1e293b;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 7px;
        white-space: nowrap;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease, transform 0.2s ease;
        transform: translateX(-50%) translateY(4px);
    }
    [data-tip]:hover::before { opacity:1; transform:translateX(-50%) translateY(0); }

    /* ===== SCROLL BAR ===== */
    .table-overflow::-webkit-scrollbar { height: 5px; }
    .table-overflow::-webkit-scrollbar-track { background:transparent; }
    .table-overflow::-webkit-scrollbar-thumb { background:rgba(37,99,235,0.2); border-radius:10px; }

    /* ===== RESPONSIVE ===== */
    @media (max-width:640px) {
        .page-header { flex-direction:column; align-items:flex-start; }
        .btn-add { align-self:stretch; justify-content:center; }
        .header-title { font-size:1.6rem; }
        td, th { padding:0.85rem 1rem; }
    }
</style>

{{-- Floating orbs --}}
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="customers-page" dir="rtl">
<div class="page-container">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-brand">
            <div class="header-icon-wrap">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <h1 class="header-title">قائمة العملاء</h1>
                <p class="header-subtitle">إدارة وتتبع بيانات عملائك في مكان واحد</p>
            </div>
        </div>
        <a href="{{ route('customers.create') }}" class="btn-add">
            <i class="fas fa-plus-circle"></i>
            <span>إضافة زبون جديد</span>
        </a>
    </div>

    {{-- STATS ROW --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-value">{{  $customers->count() }}</div>
                <div class="stat-label">إجمالي العملاء</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="stat-value">{{ $customers->where('discount', '>', 0)->count() }}</div>
                <div class="stat-label">لديهم خصم</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fas fa-percentage"></i></div>
            <div>
                <div class="stat-value">{{ $customers->count() > 0 ? round($customers->avg('discount'), 1) : 0 }}%</div>
                <div class="stat-label">متوسط الخصم</div>
            </div>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" class="search-input" placeholder="ابحث عن زبون باسمه أو رقم هاتفه..." id="customerSearch">
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-overflow">
            <table>
                <thead>
                    <tr>
                        <th>المعلومات الشخصية</th>
                        <th>رقم الهاتف</th>
                        <th>الخصم</th>
                        <th style="text-align:center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="customersTableBody">
                    @forelse($customers as $customer)
                    <tr data-name="{{ strtolower($customer->name) }}" data-phone="{{ $customer->phone }}">
                        {{-- AVATAR + NAME --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:0.85rem;">
                                <div class="customer-avatar">{{ mb_substr($customer->name, 0, 1) }}</div>
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-date">
                                        <i class="fas fa-calendar-alt" style="font-size:0.65rem; color:#94a3b8; margin-left:3px;"></i>
                                        {{ $customer->created_at->format('Y/m/d') }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- PHONE --}}
                        <td>
                            <span class="phone-wrap">
                                <i class="fas fa-phone-alt"></i>
                                {{ $customer->phone }}
                            </span>
                        </td>

                        {{-- DISCOUNT --}}
                        <td>
                            @if($customer->discount > 0)
                            <span class="discount-badge">
                                <i class="fas fa-tag" style="font-size:0.7rem;"></i>
                                {{ $customer->discount }}<span class="pct">%</span>
                                &nbsp;OFF
                            </span>
                            @else
                            <span style="font-size:0.8rem; color:#94a3b8; font-weight:600;">—</span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td>
                            <div class="actions-wrap">
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                   class="btn-action btn-edit"
                                   data-tip="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('customers.history', $customer->id) }}"
                                   class="btn-action btn-hist"
                                   data-tip="سجل العمليات">
                                    <i class="fas fa-history"></i>
                                </a>
                                <button type="button"
                                        onclick="openModal('{{ $customer->id }}', '{{ $customer->name }}')"
                                        class="btn-action btn-del"
                                        data-tip="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <p class="empty-title">لا يوجد زبائن حالياً</p>
                                <p class="empty-sub">أضف أول زبون من الزر أعلاه</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if(method_exists($customers, 'hasPages') && $customers->hasPages())
    <div class="pagination-wrap">
        {{ $customers->links() }}
    </div>
    @endif

</div>
</div>

{{-- CONFIRM MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-danger-icon">
            <i class="fas fa-trash-alt"></i>
        </div>
        <div class="modal-title">تأكيد الحذف</div>
        <p class="modal-text" id="modalText">هل أنت متأكد من حذف هذا الزبون نهائياً؟<br>لا يمكن التراجع عن هذا الإجراء.</p>
        <div class="modal-btns">
            <button class="btn-modal btn-cancel" onclick="closeModal()">إلغاء</button>
            <button class="btn-modal btn-confirm" id="confirmDeleteBtn">حذف نهائياً</button>
        </div>
    </div>
</div>

{{-- HIDDEN DELETE FORM --}}
<form id="delete-form" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>

<script>
    /* === MODAL === */
    let pendingDeleteId = null;

    function openModal(id, name) {
        pendingDeleteId = id;
        document.getElementById('modalText').innerHTML =
            `هل أنت متأكد من حذف <strong>${name}</strong> نهائياً؟<br><span style="color:#94a3b8;font-size:0.82rem;">لا يمكن التراجع عن هذا الإجراء.</span>`;
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.remove('show');
        pendingDeleteId = null;
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
        if (!pendingDeleteId) return;
        const form = document.getElementById('delete-form');
        form.action = '/customers/' + pendingDeleteId;
        form.submit();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    /* === LIVE SEARCH === */
    document.getElementById('customerSearch').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        document.querySelectorAll('#customersTableBody tr[data-name]').forEach(row => {
            const name  = row.dataset.name || '';
            const phone = row.dataset.phone || '';
            row.style.display = (!q || name.includes(q) || phone.includes(q)) ? '' : 'none';
        });
    });
</script>

@endsection