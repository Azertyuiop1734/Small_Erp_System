@extends('layouts.app')

@section('title', 'لوحة تحكم الموظف')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BG ===== */
    .dash-page { min-height:100vh; padding:2rem 1rem 4rem; position:relative; overflow-x:hidden; }
    .dash-page::before {
        content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.08)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(16,185,129,.06) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(99,102,241,.05) 0%, transparent 50%);
    }
    .dark .dash-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.14) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(16,185,129,.10) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(99,102,241,.08) 0%, transparent 50%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:340px;height:340px; background:rgba(37,99,235,.07);   top:-90px;  right:-90px; animation-delay:0s;  }
    .orb-2 { width:260px;height:260px; background:rgba(16,185,129,.06);  bottom:10%; left:-60px;  animation-delay:-5s; }
    .orb-3 { width:190px;height:190px; background:rgba(99,102,241,.05);  top:40%;    right:3%;    animation-delay:-9s; }
    .dark .orb-1 { background:rgba(37,99,235,.13); }
    .dark .orb-2 { background:rgba(16,185,129,.10); }
    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

    /* ===== LAYOUT ===== */
    .page-container { max-width:1100px; margin:0 auto; position:relative; z-index:1; display:flex; flex-direction:column; gap:1.8rem; }

    /* ===== GLASS BASE ===== */
    .glass {
        background:rgba(255,255,255,.55); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem;
        box-shadow:0 4px 32px rgba(0,0,0,.07),0 1px 0 rgba(255,255,255,.85) inset;
        position:relative; overflow:hidden;
    }
    .dark .glass {
        background:rgba(10,17,34,.65); border-color:rgba(51,65,85,.45);
        box-shadow:0 4px 32px rgba(0,0,0,.35);
    }

    /* ===== WELCOME CARD ===== */
    .welcome-card {
        padding:1.8rem 2rem;
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1.4rem;
        animation:slideDown .6s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }

    .welcome-card::before { content:'';position:absolute;top:-70px;right:-70px;width:240px;height:240px;background:rgba(37,99,235,.05);border-radius:50%;filter:blur(70px);pointer-events:none;display:none; }
    .dark .welcome-card::before { display:block; }

    .wc-left { display:flex; align-items:center; gap:1.3rem; }

    /* avatar */
    .avatar-ring {
        width:72px; height:72px; flex-shrink:0;
        border-radius:22px; overflow:hidden;
        border:2.5px solid rgba(37,99,235,.25);
        box-shadow:0 6px 24px rgba(37,99,235,.25), 0 0 0 4px rgba(37,99,235,.08);
        position:relative;
    }
    .avatar-ring img { width:100%; height:100%; object-fit:cover; }

    .wc-greeting { font-size:1.7rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1.15; }
    .dark .wc-greeting { color:#f1f5f9; }
    .wc-sub { font-size:.84rem; color:#64748b; font-weight:600; margin-top:3px; display:flex; align-items:center; gap:.4rem; }
    .dark .wc-sub { color:#94a3b8; }
    .wc-sub-dot { width:6px;height:6px;border-radius:50%;background:#10B981;box-shadow:0 0 6px rgba(16,185,129,.6);animation:pulse 2s ease-in-out infinite;flex-shrink:0; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

    /* new invoice button */
    .btn-new {
        display:inline-flex; align-items:center; gap:.6rem;
        padding:.8rem 1.7rem;
        background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
        color:#fff; border-radius:1rem; font-weight:800; font-size:.92rem;
        text-decoration:none;
        box-shadow:0 6px 22px rgba(37,99,235,.38);
        transition:all .25s cubic-bezier(.34,1.56,.64,1);
        position:relative; overflow:hidden; flex-shrink:0;
    }
    .btn-new::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s; }
    .btn-new:hover::before { left:160%; }
    .btn-new:hover { transform:translateY(-2px) scale(1.03);box-shadow:0 10px 30px rgba(37,99,235,.52); }
    .btn-new:active { transform:scale(.97); }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display:grid; grid-template-columns:repeat(4,1fr); gap:1.1rem;
        animation:slideUp .6s .1s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }

    .stat-card {
        padding:1.5rem 1.4rem;
        display:flex; flex-direction:column; align-items:center; gap:.8rem; text-align:center;
        transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .25s ease;
        cursor:default;
    }
    .stat-card:hover { transform:translateY(-5px) scale(1.02); }
    .dark .stat-card:hover { box-shadow:0 18px 48px rgba(0,0,0,.45) !important; }

    /* icon box */
    .stat-icon {
        width:52px; height:52px; border-radius:15px; flex-shrink:0;
        display:flex; align-items:center; justify-content:center; font-size:1.25rem;
        position:relative;
    }
    .stat-icon::after { content:'';position:absolute;inset:0;border-radius:inherit;background:linear-gradient(135deg,rgba(255,255,255,.25),transparent);pointer-events:none; }
    .stat-icon.blue   { background:linear-gradient(135deg,#2563EB,#4F46E5); box-shadow:0 6px 18px rgba(37,99,235,.38); color:#fff; }
    .stat-icon.green  { background:linear-gradient(135deg,#10B981,#059669); box-shadow:0 6px 18px rgba(16,185,129,.35); color:#fff; }
    .stat-icon.amber  { background:linear-gradient(135deg,#F59E0B,#D97706); box-shadow:0 6px 18px rgba(245,158,11,.35); color:#fff; }
    .stat-icon.purple { background:linear-gradient(135deg,#8B5CF6,#EC4899); box-shadow:0 6px 18px rgba(139,92,246,.35); color:#fff; }

    .stat-label { font-size:.67rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8; }
    .stat-value { font-size:1.6rem;font-weight:900;color:#1e293b;letter-spacing:-.03em;line-height:1; }
    .dark .stat-value { color:#f1f5f9; }

    /* bottom accent line */
    .stat-card::after { content:'';position:absolute;bottom:0;left:0;right:0;height:3px;border-radius:0 0 2rem 2rem;transition:opacity .25s; opacity:.7; }
    .stat-card:hover::after { opacity:1; }
    .stat-card.blue::after   { background:linear-gradient(90deg,#2563EB,#4F46E5); }
    .stat-card.green::after  { background:linear-gradient(90deg,#10B981,#059669); }
    .stat-card.amber::after  { background:linear-gradient(90deg,#F59E0B,#D97706); }
    .stat-card.purple::after { background:linear-gradient(90deg,#8B5CF6,#EC4899); }

    /* ===== TABLE CARD ===== */
    .table-card {
        animation:slideUp .6s .2s cubic-bezier(.34,1.56,.64,1) both;
    }

    .table-strip {
        background:linear-gradient(135deg,rgba(37,99,235,.07) 0%,rgba(99,102,241,.05) 100%);
        border-bottom:1px solid rgba(37,99,235,.09);
        padding:1.1rem 2rem; display:flex; align-items:center; justify-content:space-between; gap:.7rem;
        flex-wrap:wrap;
    }
    .dark .table-strip { background:linear-gradient(135deg,rgba(37,99,235,.11) 0%,rgba(99,102,241,.08) 100%); border-bottom-color:rgba(51,65,85,.4); }

    .strip-left { display:flex;align-items:center;gap:.7rem; }
    .strip-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7);flex-shrink:0; }
    .strip-lbl { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
    .dark .strip-lbl { color:#60a5fa; }

    .btn-view-all {
        font-size:.78rem;font-weight:800;color:#2563EB;text-decoration:none;
        display:inline-flex;align-items:center;gap:.35rem;
        transition:gap .2s ease;
    }
    .dark .btn-view-all { color:#60a5fa; }
    .btn-view-all:hover { gap:.6rem; }
    .btn-view-all i { font-size:.68rem; }

    /* table */
    .tbl-scroll { overflow-x:auto; }
    table { width:100%;border-collapse:collapse;text-align:right; }
    thead tr { background:linear-gradient(135deg,rgba(37,99,235,.05),rgba(99,102,241,.04));border-bottom:1px solid rgba(148,163,184,.10); }
    .dark thead tr { background:rgba(15,23,42,.4);border-bottom-color:rgba(51,65,85,.3); }
    thead th { padding:.85rem 1.4rem;font-size:.67rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(148,163,184,.07);transition:background .15s ease; }
    .dark tbody tr { border-bottom-color:rgba(51,65,85,.18); }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(37,99,235,.035); }
    .dark tbody tr:hover { background:rgba(37,99,235,.07); }
    tbody td { padding:.95rem 1.4rem;font-size:.87rem;font-weight:600;color:#334155;white-space:nowrap; }
    .dark tbody td { color:#cbd5e1; }

    .td-inv { font-weight:900;color:#2563EB;font-size:.9rem; }
    .dark .td-inv { color:#60a5fa; }
    .td-customer { font-weight:800;color:#1e293b; }
    .dark .td-customer { color:#f1f5f9; }
    .td-time { font-size:.82rem;color:#64748b; }
    .dark .td-time { color:#94a3b8; }
    .td-amount { font-weight:900;color:#10B981;font-size:.9rem; }
    .dark .td-amount { color:#34d399; }

    /* status badges */
    .badge { display:inline-flex;align-items:center;gap:.35rem;padding:.3rem .85rem;border-radius:999px;font-size:.68rem;font-weight:900;text-transform:uppercase;letter-spacing:.04em;white-space:nowrap; }
    .badge.paid   { background:rgba(16,185,129,.12);color:#10B981;border:1px solid rgba(16,185,129,.22); }
    .badge.pending{ background:rgba(245,158,11,.10);color:#F59E0B;border:1px solid rgba(245,158,11,.22); }
    .dark .badge.paid    { background:rgba(16,185,129,.18); }
    .dark .badge.pending { background:rgba(245,158,11,.16); }

    /* empty state */
    .empty-state { padding:4rem 2rem;text-align:center; }
    .empty-icon { width:72px;height:72px;border-radius:50%;background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.1rem;font-size:1.8rem;color:#2563EB; }
    .dark .empty-icon { background:rgba(37,99,235,.14); }
    .empty-title { font-size:.95rem;font-weight:800;color:#64748b;margin-bottom:.3rem; }
    .dark .empty-title { color:#94a3b8; }
    .empty-sub { font-size:.82rem;font-weight:600;color:#94a3b8; }
    .empty-sub a { color:#2563EB;font-weight:800;text-decoration:none; }
    .dark .empty-sub a { color:#60a5fa; }

    /* ===== RESPONSIVE ===== */
    @media(max-width:900px){ .stats-grid { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:540px){
        .stats-grid { grid-template-columns:1fr 1fr; }
        .welcome-card { flex-direction:column; align-items:flex-start; }
        .btn-new { align-self:stretch; justify-content:center; }
    }
</style>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="dash-page" dir="rtl">
<div class="page-container">

    <!-- ── Welcome Card ── -->
    <div class="glass welcome-card">
        <div class="wc-left">
            <div class="avatar-ring">
                <img src="{{ auth()->user()->image
                    ? asset('storage/' . auth()->user()->image)
                    : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2563eb&color=fff&bold=true' }}"
                     alt="{{ auth()->user()->name }}">
            </div>
            <div>
                <h1 class="wc-greeting">أهلاً بك، {{ explode(' ', auth()->user()->name)[0] }}! 👋</h1>
                <p class="wc-sub">
                    <span class="wc-sub-dot"></span>
                    لديك عمل رائع لتقوم به اليوم في نظام ERP
                </p>
            </div>
        </div>
        <a href="{{ route('expenses.create') }}" class="btn-new">
            <i class="fas fa-plus-circle"></i>
            فاتورة جديدة
        </a>
    </div>

    <!-- ── Stats ── -->
    <div class="stats-grid">

        <div class="glass stat-card blue">
            <div class="stat-icon blue"><i class="fas fa-cash-register"></i></div>
            <p class="stat-label">مبيعاتك اليوم</p>
            <p class="stat-value">{{ $todaySales ?? 0 }}</p>
        </div>

        <div class="glass stat-card green">
            <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
            <p class="stat-label">فواتير مكتملة</p>
            <p class="stat-value">{{ $completedInvoices ?? 0 }}</p>
        </div>

        <div class="glass stat-card amber">
            <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
            <p class="stat-label">قيد الانتظار</p>
            <p class="stat-value">{{ $pendingOrders ?? 0 }}</p>
        </div>

        <div class="glass stat-card purple">
            <div class="stat-icon purple"><i class="fas fa-hand-holding-usd"></i></div>
            <p class="stat-label">إجمالي العمولات</p>
            <p class="stat-value">{{ $totalCommission ?? 0 }} <span style="font-size:.8rem;font-weight:700;opacity:.65">DA</span></p>
        </div>

    </div>

    <!-- ── Recent Sales Table ── -->
    <div class="glass table-card">

        <div class="table-strip">
            <div class="strip-left">
                <div class="strip-dot"></div>
                <span class="strip-lbl">عملياتك الأخيرة</span>
            </div>
            <a href="{{ route('sales.index') }}" class="btn-view-all">
                عرض الكل <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <div class="tbl-scroll">
            <table>
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th style="text-align:center">العميل</th>
                        <th style="text-align:center">الوقت</th>
                        <th style="text-align:center">المبلغ</th>
                        <th style="text-align:center">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSales as $sale)
                    <tr>
                        <td><span class="td-inv">#{{ $sale->id }}</span></td>
                        <td style="text-align:center"><span class="td-customer">{{ $sale->customer_name }}</span></td>
                        <td style="text-align:center"><span class="td-time">{{ $sale->created_at->diffForHumans() }}</span></td>
                        <td style="text-align:center"><span class="td-amount">{{ number_format($sale->total_amount, 2) }} DA</span></td>
                        <td style="text-align:center">
                            @if($sale->status == 'paid')
                                <span class="badge paid"><i class="fas fa-check" style="font-size:.55rem"></i> مكتمل</span>
                            @else
                                <span class="badge pending"><i class="fas fa-clock" style="font-size:.55rem"></i> معلّق</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-receipt"></i></div>
                            <p class="empty-title">لا توجد عمليات مسجّلة اليوم</p>
                            <p class="empty-sub">ابدأ الآن بإنشاء <a href="{{ route('sales.index') }}">فاتورة جديدة</a></p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>
</div>

@endsection