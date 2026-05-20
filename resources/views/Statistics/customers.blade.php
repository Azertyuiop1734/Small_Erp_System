@extends('layouts.app')

@section('title', 'تحليل سلوك ونشاط العملاء')

@section('content')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
* { font-family: 'Cairo', 'Tajawal', sans-serif; }

html { scroll-behavior: smooth; }

body {
    min-height: 100vh;
    background: #f1f5f9;
    transition: background .4s ease;
    position: relative;
    overflow-x: hidden;
}
html.dark body { background: #04080f; }

body::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(59,130,246,.10) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(16,185,129,.07) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 35%, rgba(244,63,94,.06) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(59,130,246,.16) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(16,185,129,.11) 0%, transparent 60%);
}

/* ── Orbs ── */
.orb { position: fixed; border-radius: 50%; filter: blur(72px); pointer-events: none; z-index: 0; animation: floatOrb 13s ease-in-out infinite; }
.orb-1 { width: 380px; height: 380px; background: rgba(59,130,246,.07); top: -100px; right: -100px; animation-delay: 0s; }
.orb-2 { width: 280px; height: 280px; background: rgba(16,185,129,.06); bottom: 5%; left: -70px; animation-delay: -5s; }
.orb-3 { width: 200px; height: 200px; background: rgba(244,63,94,.05); top: 45%; right: 5%; animation-delay: -9s; }
html.dark .orb-1 { background: rgba(59,130,246,.14); }
html.dark .orb-2 { background: rgba(16,185,129,.11); }
@keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

/* ── Dark toggle ── */
.dark-toggle {
    position: fixed; top: 1.3rem; left: 1.3rem; z-index: 1000;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.65); backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,.7); box-shadow: 0 3px 14px rgba(0,0,0,.09);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .28s cubic-bezier(.34,1.56,.64,1);
}
html.dark .dark-toggle { background: rgba(15,23,42,.7); border-color: rgba(51,65,85,.5); }
.dark-toggle:hover { transform: scale(1.12); box-shadow: 0 6px 22px rgba(59,130,246,.28); }
.dark-toggle i { font-size: 1rem; color: #64748b; transition: color .25s; }
html.dark .dark-toggle i { color: #60a5fa; }

/* ── Page wrapper ── */
.page-wrap {
    width: 100%; max-width: 1280px; margin: 0 auto;
    position: relative; z-index: 1;
    padding: 2rem 1rem 3rem;
    animation: pageIn .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes pageIn {
    from { opacity: 0; transform: translateY(28px) scale(.96); }
    to   { opacity: 1; transform: translateY(0)     scale(1);   }
}

/* ── Glass Card ── */
.glass-card {
    background: rgba(255,255,255,.56); backdrop-filter: blur(26px); -webkit-backdrop-filter: blur(26px);
    border: 1px solid rgba(255,255,255,.68); border-radius: 2.2rem;
    box-shadow: 0 2px 0 rgba(255,255,255,.92) inset, 0 32px 72px rgba(0,0,0,.10), 0 8px 24px rgba(0,0,0,.05);
    overflow: hidden; position: relative;
    margin-bottom: 1.5rem;
}
html.dark .glass-card { background: rgba(10,17,34,.72); border-color: rgba(51,65,85,.45); box-shadow: 0 32px 72px rgba(0,0,0,.45); }
.glass-card::before {
    content: ''; position: absolute; top: -80px; right: -80px;
    width: 280px; height: 280px; background: rgba(59,130,246,.05);
    border-radius: 50%; filter: blur(80px); pointer-events: none; display: none;
}
html.dark .glass-card::before { display: block; }

/* ── Strip ── */
.card-strip {
    background: linear-gradient(135deg, rgba(59,130,246,.08) 0%, rgba(16,185,129,.06) 100%);
    border-bottom: 1px solid rgba(59,130,246,.09);
    padding: .95rem 2rem; display: flex; align-items: center; gap: .7rem;
}
html.dark .card-strip { background: linear-gradient(135deg, rgba(59,130,246,.12) 0%, rgba(16,185,129,.09) 100%); border-bottom-color: rgba(51,65,85,.4); }
.strip-dot { width: 8px; height: 8px; border-radius: 50%; background: #3b82f6; box-shadow: 0 0 9px rgba(59,130,246,.7); flex-shrink: 0; animation: pulseDot 2s infinite; }
@keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(.85)} }
.strip-label { font-size: .71rem; font-weight: 900; color: #3b82f6; text-transform: uppercase; letter-spacing: .1em; }
html.dark .strip-label { color: #60a5fa; }

/* ── Header Body ── */
.header-body {
    padding: 1.8rem 2rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1.2rem;
}
.header-left { display: flex; align-items: center; gap: 1.1rem; }
.hero-icon-wrap {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 28px rgba(59,130,246,.35), 0 0 0 3px rgba(59,130,246,.12);
    position: relative; flex-shrink: 0;
}
.hero-icon-wrap::after { content:''; position: absolute; inset: -2px; border-radius: 20px; background: linear-gradient(135deg, rgba(255,255,255,.28), transparent); pointer-events: none; }
.hero-icon-wrap i { color: #fff; font-size: 1.4rem; position: relative; z-index: 1; }
.header-title { font-size: 1.5rem; font-weight: 900; color: #1e293b; letter-spacing: -.03em; line-height: 1.1; }
html.dark .header-title { color: #f1f5f9; }
.header-sub { font-size: .82rem; color: #64748b; font-weight: 600; margin-top: 4px; }
html.dark .header-sub { color: #94a3b8; }

.date-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1rem;
    background: rgba(59,130,246,.08); backdrop-filter: blur(8px);
    border: 1px solid rgba(59,130,246,.15); border-radius: 12px;
    font-size: .85rem; font-weight: 800; color: #2563eb;
}
html.dark .date-badge { background: rgba(59,130,246,.12); color: #60a5fa; }
.date-badge i { font-size: .75rem; }

/* ── Stats Grid ── */
.stats-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.2rem; margin-bottom: 1.6rem;
}

.stat-glass {
    background: rgba(255,255,255,.5); backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,.6); border-radius: 1.8rem;
    padding: 1.6rem;
    box-shadow: 0 4px 18px rgba(0,0,0,.05);
    transition: transform .25s ease, box-shadow .25s ease;
    position: relative; overflow: hidden;
}
html.dark .stat-glass { background: rgba(10,17,34,.6); border-color: rgba(51,65,85,.4); box-shadow: 0 4px 18px rgba(0,0,0,.22); }
.stat-glass:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 28px rgba(0,0,0,.09); }
html.dark .stat-glass:hover { box-shadow: 0 8px 28px rgba(0,0,0,.3); }
.stat-glass::before { content:''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px; border-radius: 2px; }

.stat-blue-bar::before { background: linear-gradient(to bottom, #3b82f6, #2563eb); }
.stat-emerald-bar::before { background: linear-gradient(to bottom, #10b981, #059669); }
.stat-rose-bar::before { background: linear-gradient(to bottom, #f43f5e, #e11d48); }

.stat-glass-label { font-size: .7rem; font-weight: 900; text-transform: uppercase; letter-spacing: .08em; margin-bottom: .6rem; }
.stat-blue-bar .stat-glass-label { color: #3b82f6; }
.stat-emerald-bar .stat-glass-label { color: #10b981; }
.stat-rose-bar .stat-glass-label { color: #f43f5e; }

.stat-glass-value { font-size: 2rem; font-weight: 900; color: #1e293b; line-height: 1; }
html.dark .stat-glass-value { color: #f1f5f9; }
.stat-glass-unit { font-size: .8rem; font-weight: 600; opacity: .6; margin-right: .3rem; }

.stat-glass-footer { margin-top: 1rem; display: flex; align-items: center; gap: .4rem; font-size: .72rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; }
.stat-glass-footer i { font-size: .7rem; }
.stat-blue-bar .stat-glass-footer i { color: #3b82f6; }
.stat-emerald-bar .stat-glass-footer i { color: #10b981; }
.stat-rose-bar .stat-glass-footer i { color: #f43f5e; }

/* ── Content Grid ── */
.content-grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
@media(min-width:1024px) { .content-grid { grid-template-columns: 1fr 2fr; } }

/* ── Chart Box ── */
.chart-box { padding: 1.5rem; }
.chart-title { font-size: 1.1rem; font-weight: 900; color: #1e293b; margin-bottom: 1.2rem; display: flex; align-items: center; gap: .6rem; }
html.dark .chart-title { color: #f1f5f9; }
.chart-title i { color: #3b82f6; }

/* ── Table Styles ── */
.table-overflow { overflow-x: auto; }
.table-overflow::-webkit-scrollbar { height: 5px; }
.table-overflow::-webkit-scrollbar-thumb { background: rgba(59,130,246,.2); border-radius: 10px; }

.glass-table { width: 100%; border-collapse: collapse; direction: rtl; }
.glass-table thead tr {
    background: linear-gradient(135deg, rgba(59,130,246,.06) 0%, rgba(16,185,129,.05) 100%);
    border-bottom: 1px solid rgba(59,130,246,.1);
}
html.dark .glass-table thead tr { background: linear-gradient(135deg, rgba(59,130,246,.10), rgba(16,185,129,.09)); border-bottom-color: rgba(51,65,85,.45); }

.glass-table th { padding: 1rem 1.5rem; font-size: .7rem; font-weight: 900; color: #3b82f6; text-transform: uppercase; letter-spacing: .08em; white-space: nowrap; text-align: right; }
html.dark .glass-table th { color: #60a5fa; }

.glass-table tbody tr {
    border-bottom: 1px solid rgba(148,163,184,.07);
    transition: all .22s ease;
    animation: rowIn .4s ease both;
}
@keyframes rowIn { from { opacity: 0; transform: translateX(8px); } to { opacity: 1; transform: translateX(0); } }
.glass-table tbody tr:nth-child(1){animation-delay:.04s} .glass-table tbody tr:nth-child(2){animation-delay:.08s}
.glass-table tbody tr:nth-child(3){animation-delay:.12s} .glass-table tbody tr:nth-child(4){animation-delay:.16s}
.glass-table tbody tr:nth-child(5){animation-delay:.20s} .glass-table tbody tr:nth-child(6){animation-delay:.24s}
.glass-table tbody tr:last-child { border-bottom: none; }
.glass-table tbody tr:hover { background: rgba(59,130,246,.03); }
html.dark .glass-table tbody tr:hover { background: rgba(59,130,246,.07); }

.glass-table td { padding: .95rem 1.5rem; vertical-align: middle; }

.cell-name { font-weight: 800; font-size: .92rem; color: #1e293b; transition: color .2s; }
html.dark .cell-name { color: #f1f5f9; }
.glass-table tr:hover .cell-name { color: #3b82f6; }
html.dark .glass-table tr:hover .cell-name { color: #60a5fa; }
.cell-sub { font-size: .72rem; color: #94a3b8; font-style: italic; margin-top: 2px; }

.badge-count {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .9rem; border-radius: 999px;
    font-size: .78rem; font-weight: 900;
    background: rgba(59,130,246,.08); color: #2563eb;
    border: 1px solid rgba(59,130,246,.18);
}
html.dark .badge-count { background: rgba(59,130,246,.15); color: #60a5fa; }

.btn-table {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1rem; border-radius: 11px;
    font-size: .78rem; font-weight: 800;
    background: rgba(255,255,255,.7); cursor: pointer; text-decoration: none;
    transition: all .22s cubic-bezier(.34,1.56,.64,1);
    backdrop-filter: blur(8px); border: 1px solid rgba(59,130,246,.2);
    color: #3b82f6;
}
html.dark .btn-table { background: rgba(30,41,59,.7); border-color: rgba(59,130,246,.3); color: #60a5fa; }
.btn-table:hover { transform: scale(1.05); box-shadow: 0 4px 14px rgba(59,130,246,.18); background: #3b82f6; color: #fff; }
html.dark .btn-table:hover { background: #3b82f6; color: #fff; }

/* ── Idle Section ── */
.idle-strip {
    background: linear-gradient(135deg, rgba(244,63,94,.08) 0%, rgba(245,158,11,.06) 100%);
    border-bottom: 1px solid rgba(244,63,94,.1);
}
html.dark .idle-strip { background: linear-gradient(135deg, rgba(244,63,94,.12) 0%, rgba(245,158,11,.09) 100%); border-bottom-color: rgba(51,65,85,.4); }
.idle-strip .strip-dot { background: #f43f5e; box-shadow: 0 0 9px rgba(244,63,94,.7); }
.idle-strip .strip-label { color: #f43f5e; }
html.dark .idle-strip .strip-label { color: #fb7185; }

.badge-rose {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .3rem .9rem; border-radius: 999px;
    font-size: .78rem; font-weight: 900;
    background: rgba(244,63,94,.08); color: #e11d48;
    border: 1px solid rgba(244,63,94,.18);
}
html.dark .badge-rose { background: rgba(244,63,94,.15); color: #fb7185; }

.btn-rose {
    display: inline-flex; align-items: center; gap: .3rem;
    padding: .5rem 1rem; border-radius: 11px;
    font-size: .72rem; font-weight: 800;
    background: rgba(255,255,255,.7); cursor: pointer;
    transition: all .22s cubic-bezier(.34,1.56,.64,1);
    backdrop-filter: blur(8px); border: 1px solid rgba(244,63,94,.2);
    color: #f43f5e;
}
html.dark .btn-rose { background: rgba(30,41,59,.7); border-color: rgba(244,63,94,.3); color: #fb7185; }
.btn-rose:hover { transform: scale(1.05); box-shadow: 0 4px 14px rgba(244,63,94,.18); background: #f43f5e; color: #fff; }
html.dark .btn-rose:hover { background: #f43f5e; color: #fff; }

/* ── Empty State ── */
.empty-state { padding: 4rem 2rem; text-align: center; }
.empty-icon-wrap {
    width: 72px; height: 72px; border-radius: 22px;
    background: linear-gradient(135deg, rgba(16,185,129,.08), rgba(5,150,105,.06));
    border: 1px solid rgba(16,185,129,.12);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.2rem;
}
.empty-icon-wrap i { font-size: 1.8rem; color: #10b981; }
.empty-title { font-size: 1.1rem; font-weight: 900; color: #1e293b; }
html.dark .empty-title { color: #f1f5f9; }
.empty-sub { font-size: .82rem; color: #94a3b8; margin-top: .35rem; font-weight: 500; }

/* ── Swal Glass ── */
.swal-glass-popup {
    border-radius: 2rem !important;
    backdrop-filter: blur(26px) !important;
    -webkit-backdrop-filter: blur(26px) !important;
    border: 1px solid rgba(255,255,255,.6) !important;
    box-shadow: 0 32px 72px rgba(0,0,0,.15) !important;
    padding: 2rem !important;
}
html.dark .swal-glass-popup {
    background: rgba(10,17,34,.85) !important;
    border-color: rgba(51,65,85,.45) !important;
    box-shadow: 0 32px 72px rgba(0,0,0,.45) !important;
}
.swal-glass-title { font-family: 'Cairo', sans-serif !important; font-weight: 900 !important; font-size: 1.4rem !important; color: #1e293b !important; letter-spacing: -.02em !important; }
html.dark .swal-glass-title { color: #f1f5f9 !important; }
.swal-glass-text { font-family: 'Cairo', sans-serif !important; font-weight: 600 !important; font-size: .95rem !important; color: #64748b !important; }
html.dark .swal-glass-text { color: #94a3b8 !important; }
.swal-glass-btn {
    font-family: 'Cairo', sans-serif !important; font-weight: 800 !important;
    border-radius: 1rem !important; padding: .7rem 1.8rem !important;
    transition: all .25s cubic-bezier(.34,1.56,.64,1) !important;
    border: none !important; font-size: .9rem !important;
}
.swal-glass-btn:hover { transform: translateY(-2px) scale(1.02) !important; }
.swal-glass-confirm {
    background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%) !important;
    color: #fff !important; box-shadow: 0 6px 24px rgba(59,130,246,.35) !important;
}
.swal-glass-confirm:hover { box-shadow: 0 10px 32px rgba(59,130,246,.45) !important; }
.swal-glass-cancel {
    background: rgba(148,163,184,.15) !important; color: #64748b !important;
    border: 1px solid rgba(148,163,184,.25) !important;
}
html.dark .swal-glass-cancel {
    background: rgba(51,65,85,.3) !important; color: #94a3b8 !important;
    border-color: rgba(51,65,85,.4) !important;
}

@media(max-width:640px) {
    .header-body { flex-direction: column; align-items: flex-start; }
    .header-title { font-size: 1.3rem; }
    .glass-table td, .glass-table th { padding: .8rem .9rem; }
    .stats-grid { grid-template-columns: 1fr; }
    .content-grid { grid-template-columns: 1fr; }
    .page-wrap { padding: 1.5rem .8rem; }
}
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>



<div class="page-wrap" dir="rtl">

    {{-- HEADER CARD --}}
    <div class="glass-card">
        <div class="card-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">تحليل البيانات</span>
        </div>
        <div class="header-body">
            <div class="header-left">
                <div class="hero-icon-wrap">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1 class="header-title">تحليل سلوك ونشاط العملاء</h1>
                    <p class="header-sub">متابعة تفاعل العملاء وتوزيعهم الجغرافي</p>
                </div>
            </div>
            <div class="date-badge">
                <i class="far fa-calendar-alt"></i>
                {{ now()->format('Y-m-d') }}
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-glass stat-blue-bar">
            <div class="stat-glass-label">العملاء الجدد</div>
            <div class="stat-glass-value">
                {{ $newCustomersCount }}
                <span class="stat-glass-unit">عميل جديد</span>
            </div>
            <div class="stat-glass-footer">
                <i class="fas fa-user-plus"></i>
                آخر 30 يوم
            </div>
        </div>
        <div class="stat-glass stat-emerald-bar">
            <div class="stat-glass-label">العملاء النشطون</div>
            <div class="stat-glass-value">
                {{ $topActiveCustomers->count() }}
                <span class="stat-glass-unit">تفاعل مرتفع</span>
            </div>
            <div class="stat-glass-footer">
                <i class="fas fa-check-double"></i>
                الأكثر طلباً
            </div>
        </div>
        <div class="stat-glass stat-rose-bar">
            <div class="stat-glass-label">عملاء خاملون</div>
            <div class="stat-glass-value">
                {{ $idleCustomers->count() }}
                <span class="stat-glass-unit">بحاجة للمتابعة</span>
            </div>
            <div class="stat-glass-footer">
                <i class="fas fa-clock"></i>
                لم يطلبوا منذ 3 أشهر
            </div>
        </div>
    </div>

    {{-- CHART + TABLE GRID --}}
    <div class="content-grid">
        {{-- Chart --}}
        <div class="glass-card" style="margin-bottom:0;">
            <div class="chart-box">
                <h3 class="chart-title">
                    <i class="fas fa-map-marked-alt"></i>
                    التوزيع الجغرافي
                </h3>
                <div style="position:relative; height:280px;">
                    <canvas id="locationChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Top Customers Table --}}
        <div class="glass-card" style="margin-bottom:0;">
            <div class="card-strip">
                <div class="strip-dot"></div>
                <span class="strip-label">الأكثر نشاطاً</span>
            </div>
            <div class="table-overflow">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>العميل</th>
                            <th style="text-align:center;">عدد الطلبات</th>
                            <th style="text-align:center;">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topActiveCustomers as $customer)
                        <tr>
                            <td>
                                <div class="cell-name">{{ $customer->name }}</div>
                                <div class="cell-sub">{{ $customer->address }}</div>
                            </td>
                            <td style="text-align:center;">
                                <span class="badge-count">
                                    {{ $customer->sales_count }} طلبية
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <button class="btn-table">
                                    <i class="fas fa-eye"></i>
                                    التفاصيل
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- IDLE CUSTOMERS --}}
    <div class="glass-card" style="margin-bottom:0;">
        <div class="card-strip idle-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">يتطلب متابعة</span>
        </div>
        <div class="table-overflow">
            <table class="glass-table">
                <thead>
                    <tr>
                        <th>اسم العميل</th>
                        <th>رقم الهاتف</th>
                        <th style="text-align:center;">آخر ظهور</th>
                        <th style="text-align:center;">الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($idleCustomers as $customer)
                    <tr>
                        <td>
                            <div class="cell-name">{{ $customer->name }}</div>
                        </td>
                        <td style="color:#64748b; font-size:.85rem;">{{ $customer->phone }}</td>
                        <td style="text-align:center;">
                            <span class="badge-rose">+90 يوم</span>
                        </td>
                        <td style="text-align:center;">
                            <button class="btn-rose">
                                <i class="fas fa-paper-plane"></i>
                                إرسال عرض ترويجي
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <p class="empty-title">سجل نظيف!</p>
                                <p class="empty-sub">لا يوجد عملاء خاملون حالياً</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* ── Dark mode ── */
function toggleDark() {
    const html = document.documentElement, icon = document.getElementById('darkIcon');
    if (html.classList.contains('dark')) {
        html.classList.remove('dark');
        localStorage.setItem('theme', 'light');
        icon.className = 'fas fa-moon';
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme', 'dark');
        icon.className = 'fas fa-sun';
    }
    // Refresh chart colors
    setTimeout(() => location.reload(), 150);
}
document.addEventListener('DOMContentLoaded', () => {
    if (document.documentElement.classList.contains('dark'))
        document.getElementById('darkIcon').className = 'fas fa-sun';
});

/* ── Chart.js ── */
const isDark = document.documentElement.classList.contains('dark');
const textColor = isDark ? '#94a3b8' : '#64748b';
const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

new Chart(document.getElementById('locationChart'), {
    type: 'polarArea',
    data: {
        labels: {!! json_encode($customerLocations->pluck('address')) !!},
        datasets: [{
            data: {!! json_encode($customerLocations->pluck('total')) !!},
            backgroundColor: [
                'rgba(59, 130, 246, 0.7)',
                'rgba(16, 185, 129, 0.7)',
                'rgba(245, 158, 11, 0.7)',
                'rgba(239, 68, 68, 0.7)',
                'rgba(139, 92, 246, 0.7)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            r: {
                grid: { color: gridColor },
                angleLines: { color: gridColor },
                ticks: { display: false, backdropColor: 'transparent' },
                pointLabels: { color: textColor, font: { family: 'Cairo', size: 11 } }
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: { color: textColor, usePointStyle: true, font: { family: 'Cairo', size: 11 } }
            }
        }
    }
});

/* ── Swal Glass Helper ── */
function swalGlass(config) {
    const isDark = document.documentElement.classList.contains('dark');
    return Swal.fire({
        icon: config.icon || 'info',
        title: config.title || '',
        text: config.text || '',
        showCancelButton: config.showCancelButton || false,
        confirmButtonText: config.confirmButtonText || 'موافق',
        cancelButtonText: config.cancelButtonText || 'إلغاء',
        timer: config.timer || null,
        background: isDark ? 'rgba(10,17,34,0.88)' : 'rgba(255,255,255,0.88)',
        color: isDark ? '#f1f5f9' : '#1e293b',
        backdrop: isDark ? 'rgba(0,0,0,0.55)' : 'rgba(0,0,0,0.25)',
        customClass: {
            popup: 'swal-glass-popup',
            title: 'swal-glass-title',
            htmlContainer: 'swal-glass-text',
            confirmButton: 'swal-glass-btn swal-glass-confirm',
            cancelButton: 'swal-glass-btn swal-glass-cancel'
        },
        buttonsStyling: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        ...config
    });
}

/* ── Session Alert ── */
@if(session('success'))
    swalGlass({
        icon: 'success',
        title: 'تمت العملية بنجاح!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true
    });
@endif
</script>

@endsection