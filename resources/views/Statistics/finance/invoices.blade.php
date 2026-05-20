@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BG ===== */
    .fin-page { min-height:100vh; padding:2rem 1rem 4rem; position:relative; overflow-x:hidden; }
    .fin-page::before {
        content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(59,130,246,.09) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(168,85,247,.07) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(245,158,11,.06)  0%, transparent 50%);
    }
    .dark .fin-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(59,130,246,.14) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(168,85,247,.11) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(245,158,11,.09)  0%, transparent 50%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:340px;height:340px; background:rgba(59,130,246,.07);  top:-90px;  right:-90px; animation-delay:0s;  }
    .orb-2 { width:260px;height:260px; background:rgba(168,85,247,.06);  bottom:10%; left:-60px;  animation-delay:-5s; }
    .orb-3 { width:200px;height:200px; background:rgba(245,158,11,.05);  top:40%;    right:3%;    animation-delay:-9s; }
    .dark .orb-1 { background:rgba(59,130,246,.13); }
    .dark .orb-2 { background:rgba(168,85,247,.11); }
    .dark .orb-3 { background:rgba(245,158,11,.09); }
    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

    /* ===== LAYOUT ===== */
    .page-container { max-width:1100px; margin:0 auto; position:relative; z-index:1; }

    /* ===== GLASS ===== */
    .glass {
        background:rgba(255,255,255,.55); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem;
        box-shadow:0 4px 32px rgba(0,0,0,.07),0 1px 0 rgba(255,255,255,.85) inset;
    }
    .dark .glass {
        background:rgba(10,17,34,.65); border-color:rgba(51,65,85,.45);
        box-shadow:0 4px 32px rgba(0,0,0,.35);
    }

    /* ===== TOP HEADER CARD ===== */
    .top-card {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1.2rem;
        padding:1.4rem 2rem; margin-bottom:1.8rem;
        animation:slideDown .6s cubic-bezier(.34,1.56,.64,1) both;
        position:relative; overflow:hidden;
    }
    .top-card::before { content:'';position:absolute;top:-70px;right:-70px;width:240px;height:240px;background:rgba(59,130,246,.05);border-radius:50%;filter:blur(70px);pointer-events:none;display:none; }
    .dark .top-card::before { display:block; }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }

    .top-brand { display:flex; align-items:center; gap:1.1rem; }
    .top-icon {
        width:58px; height:58px; flex-shrink:0;
        background:linear-gradient(135deg,#3B82F6 0%,#2563EB 100%);
        border-radius:17px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(59,130,246,.38),0 0 0 3px rgba(59,130,246,.15);
        position:relative;
    }
    .top-icon::after { content:'';position:absolute;inset:-3px;border-radius:20px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
    .top-icon i { color:#fff;font-size:1.4rem;position:relative;z-index:1; }
    .top-title { font-size:1.6rem;font-weight:900;color:#1e293b;letter-spacing:-.03em;line-height:1.1; }
    .dark .top-title { color:#f1f5f9; }
    .top-sub { font-size:.82rem;color:#64748b;font-weight:600;margin-top:3px; }
    .dark .top-sub { color:#94a3b8; }
    .top-sub span { color:#3B82F6;font-weight:900; }
    .dark .top-sub span { color:#60a5fa; }

    .btn-print {
        display:inline-flex; align-items:center; gap:.6rem;
        padding:.7rem 1.5rem;
        background:rgba(255,255,255,.6); backdrop-filter:blur(12px);
        color:#64748b; border-radius:1rem; font-weight:700; font-size:.87rem;
        border:1px solid rgba(255,255,255,.7); box-shadow:0 2px 12px rgba(0,0,0,.05);
        cursor:pointer; transition:all .25s cubic-bezier(.34,1.56,.64,1); flex-shrink:0;
    }
    .dark .btn-print { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.5); color:#94a3b8; }
    .btn-print:hover { color:#3B82F6; border-color:rgba(59,130,246,.35); box-shadow:0 4px 20px rgba(59,130,246,.18); transform:translateY(-2px); }
    .btn-print i { transition:transform .25s ease; }
    .btn-print:hover i { transform:scale(1.15); }

    /* ===== STATS GRID ===== */
    .stats-grid {
        display:grid; grid-template-columns:repeat(4,1fr); gap:1.2rem;
        margin-bottom:1.8rem;
        animation:slideUp .6s .1s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

    .stat-card {
        padding:1.5rem 1.6rem; position:relative; overflow:hidden;
        transition:transform .28s cubic-bezier(.34,1.56,.64,1),box-shadow .25s ease;
        cursor:default;
    }
    .stat-card:hover { transform:translateY(-5px) scale(1.02); }
    .dark .stat-card:hover { box-shadow:0 18px 48px rgba(0,0,0,.45) !important; }

    .stat-card::after { content:'';position:absolute;bottom:0;left:0;right:0;height:3px;border-radius:0 0 2rem 2rem; }
    .stat-card.blue::after   { background:linear-gradient(90deg,#3B82F6,#2563EB); }
    .stat-card.purple::after { background:linear-gradient(90deg,#A855F7,#9333EA); }
    .stat-card.amber::after  { background:linear-gradient(90deg,#F59E0B,#D97706); }
    .stat-card.green::after  { background:linear-gradient(90deg,#10B981,#059669); }

    .stat-bg-icon {
        position:absolute; bottom:-12px; left:-8px;
        font-size:5.5rem; opacity:.04; transition:transform .35s ease; pointer-events:none;
    }
    .stat-card:hover .stat-bg-icon { transform:scale(1.18) rotate(-6deg); }

    .stat-top { display:flex; align-items:flex-start; justify-content:space-between; position:relative; z-index:1; }
    .stat-label { font-size:.68rem;font-weight:900;text-transform:uppercase;letter-spacing:.09em;margin-bottom:.4rem; }
    .stat-value { font-size:1.75rem;font-weight:900;color:#1e293b;letter-spacing:-.03em;line-height:1; }
    .dark .stat-value { color:#f1f5f9; }

    .stat-icon-box { width:46px;height:46px;border-radius:13px;display:flex;align-items:center;justify-content:center;font-size:1.15rem;flex-shrink:0; }

    .stat-card.blue   .stat-label    { color:#3B82F6; }
    .stat-card.purple .stat-label    { color:#A855F7; }
    .stat-card.amber  .stat-label    { color:#F59E0B; }
    .stat-card.green  .stat-label    { color:#10B981; }
    .stat-card.blue   .stat-icon-box { background:rgba(59,130,246,.12);  color:#3B82F6; }
    .stat-card.purple .stat-icon-box { background:rgba(168,85,247,.12);  color:#A855F7; }
    .stat-card.amber  .stat-icon-box { background:rgba(245,158,11,.12);  color:#F59E0B; }
    .stat-card.green  .stat-icon-box { background:rgba(16,185,129,.12);  color:#10B981; }
    .dark .stat-card.blue   .stat-icon-box { background:rgba(59,130,246,.2);  }
    .dark .stat-card.purple .stat-icon-box { background:rgba(168,85,247,.2);  }
    .dark .stat-card.amber  .stat-icon-box { background:rgba(245,158,11,.2);  }
    .dark .stat-card.green  .stat-icon-box { background:rgba(16,185,129,.2);  }

    /* ===== CHARTS GRID ===== */
    .charts-grid {
        display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;
        animation:slideUp .6s .2s cubic-bezier(.34,1.56,.64,1) both;
    }

    .chart-card {
        padding:0; overflow:hidden; position:relative;
    }
    .chart-card::before { content:'';position:absolute;top:-80px;right:-80px;width:280px;height:280px;background:rgba(59,130,246,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
    .dark .chart-card::before { display:block; }

    .chart-strip {
        border-bottom:1px solid rgba(59,130,246,.09);
        padding:1rem 2rem; display:flex; align-items:center; gap:.7rem;
    }
    .chart-card.bar-card .chart-strip {
        background:linear-gradient(135deg,rgba(59,130,246,.07) 0%,rgba(37,99,235,.05) 100%);
    }
    .chart-card.pie-card .chart-strip {
        background:linear-gradient(135deg,rgba(168,85,247,.07) 0%,rgba(147,51,234,.05) 100%);
        border-bottom-color:rgba(168,85,247,.09);
    }
    .dark .chart-strip { border-bottom-color:rgba(51,65,85,.4); }
    .dark .chart-card.bar-card .chart-strip { background:linear-gradient(135deg,rgba(59,130,246,.11) 0%,rgba(37,99,235,.08) 100%); }
    .dark .chart-card.pie-card .chart-strip { background:linear-gradient(135deg,rgba(168,85,247,.11) 0%,rgba(147,51,234,.08) 100%); }

    .strip-dot { width:8px;height:8px;border-radius:50%;flex-shrink:0; }
    .bar-card .strip-dot { background:#3B82F6;box-shadow:0 0 9px rgba(59,130,246,.7); }
    .pie-card .strip-dot { background:#A855F7;box-shadow:0 0 9px rgba(168,85,247,.7); }
    .strip-label { font-size:.71rem;font-weight:900;text-transform:uppercase;letter-spacing:.1em; }
    .bar-card .strip-label { color:#3B82F6; }
    .pie-card .strip-label { color:#A855F7; }
    .dark .bar-card .strip-label { color:#60a5fa; }
    .dark .pie-card .strip-label { color:#c084fc; }
    .strip-year { margin-right:auto;font-size:.72rem;font-weight:800;color:#64748b;background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.15);padding:.22rem .75rem;border-radius:999px; }
    .dark .strip-year { background:rgba(99,102,241,.14);color:#94a3b8; }

    .chart-body { padding:1.5rem 2rem 2rem; }
    .chart-wrap { position:relative; height:320px; }

    /* ===== CUSTOM ALERT ===== */
    .ca-overlay { position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(2,10,28,.42);backdrop-filter:blur(10px);opacity:0;pointer-events:none;transition:opacity .3s ease; }
    .ca-overlay.ca-show { opacity:1;pointer-events:all; }
    .ca-card { width:100%;max-width:400px;background:rgba(255,255,255,.72);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.65);border-radius:2rem;overflow:hidden;box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.16);transform:scale(.82) translateY(28px);opacity:0;transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;direction:rtl; }
    .dark .ca-card { background:rgba(10,17,34,.82);border-color:rgba(51,65,85,.55); }
    .ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0);opacity:1; }
    .ca-bar { height:4px; }
    .ca-bar.success { background:linear-gradient(90deg,#3B82F6,#2563EB); }
    .ca-bar.error   { background:linear-gradient(90deg,#EF4444,#DC2626); }
    .ca-body { padding:2rem 2rem 1.5rem;display:flex;flex-direction:column;align-items:center;text-align:center; }
    .ca-ring { width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;flex-shrink:0; }
    .ca-ring.success { background:radial-gradient(circle at 35% 35%,rgba(59,130,246,.22),rgba(59,130,246,.06));border:1.5px solid rgba(59,130,246,.3);box-shadow:0 0 0 8px rgba(59,130,246,.07); }
    .ca-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.20),rgba(239,68,68,.05));border:1.5px solid rgba(239,68,68,.28);box-shadow:0 0 0 8px rgba(239,68,68,.06); }
    .ca-ring svg { width:34px;height:34px;overflow:visible; }
    .ca-cc { stroke:#3B82F6;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-cm { stroke:#3B82F6;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48; }
    .ca-ec { stroke:#EF4444;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-ex1,.ca-ex2 { stroke:#EF4444;stroke-width:3;stroke-linecap:round;stroke-dasharray:30;stroke-dashoffset:30; }
    .ca-overlay.ca-show .ca-cc  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-cm  { animation:caS .38s .55s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ec  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ex1 { animation:caS .28s .55s ease forwards; }
    .ca-overlay.ca-show .ca-ex2 { animation:caS .28s .72s ease forwards; }
    @keyframes caS { to{stroke-dashoffset:0} }
    .ca-title { font-size:1.18rem;font-weight:900;color:#1e293b;letter-spacing:-.025em;line-height:1.25;margin-bottom:.42rem; }
    .dark .ca-title { color:#f1f5f9; }
    .ca-msg { font-size:.87rem;font-weight:600;color:#64748b;line-height:1.7; }
    .dark .ca-msg { color:#94a3b8; }
    .ca-prog-wrap { width:100%;height:3px;background:rgba(148,163,184,.12);margin-top:1.4rem;border-radius:99px;overflow:hidden; }
    .ca-prog-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#3B82F6,#2563EB);transform-origin:left; }
    .ca-prog-fill.run { animation:caP var(--ca-dur,3.8s) linear forwards; }
    @keyframes caP { from{transform:scaleX(1)} to{transform:scaleX(0)} }
    .ca-footer-btn { padding:0 2rem 1.8rem;display:flex;justify-content:center; }
    .ca-btn { font-family:'Cairo',sans-serif;font-weight:800;font-size:.9rem;padding:.65rem 2.2rem;border-radius:.9rem;border:none;cursor:pointer;transition:all .25s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden; }
    .ca-btn.success { background:linear-gradient(135deg,#3B82F6,#2563EB);color:#fff;box-shadow:0 5px 18px rgba(59,130,246,.38); }
    .ca-btn.success:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(59,130,246,.55); }
    .ca-btn.error   { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;box-shadow:0 5px 18px rgba(239,68,68,.32); }
    .ca-btn:active { transform:scale(.96); }
    .ca-btn::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .ca-btn:hover::before { left:160%; }

    /* ===== RESPONSIVE ===== */
    @media(max-width:1024px){
        .stats-grid { grid-template-columns:repeat(2,1fr); }
        .charts-grid { grid-template-columns:1fr; }
    }
    @media(max-width:640px){
        .stats-grid { grid-template-columns:1fr; }
        .top-card { flex-direction:column; align-items:flex-start; }
        .btn-print { align-self:stretch; justify-content:center; }
        .chart-body { padding:1rem 1rem 1.5rem; }
    }
</style>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="fin-page" dir="rtl">
<div class="page-container">

    <!-- ── Top header ── -->
    <div class="glass top-card">
        <div class="top-brand">
            <div class="top-icon"><i class="fas fa-file-invoice"></i></div>
            <div>
                <h1 class="top-title">تحليلات الفواتير</h1>
                <p class="top-sub">إحصائيات السنة <span>{{ \Carbon\Carbon::now()->year }}</span></p>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i>
            طباعة التقرير
        </button>
    </div>

    <!-- ── Stats ── -->
    <div class="stats-grid">

        <!-- Total Invoices -->
        <div class="glass stat-card blue">
            <div class="stat-top">
                <div>
                    <p class="stat-label">إجمالي الفواتير</p>
                    <p class="stat-value">{{ number_format($totalInvoicesCount) }}</p>
                </div>
                <div class="stat-icon-box"><i class="fas fa-boxes"></i></div>
            </div>
            <div class="stat-bg-icon" style="color:#3B82F6"><i class="fas fa-boxes"></i></div>
        </div>

        <!-- Total Items -->
        <div class="glass stat-card purple">
            <div class="stat-top">
                <div>
                    <p class="stat-label">إجمالي الأصناف</p>
                    <p class="stat-value">{{ number_format($totalInvoicesCount) }}</p>
                </div>
                <div class="stat-icon-box"><i class="fas fa-tags"></i></div>
            </div>
            <div class="stat-bg-icon" style="color:#A855F7"><i class="fas fa-tags"></i></div>
        </div>

        <!-- Highest Invoice -->
        <div class="glass stat-card amber">
            <div class="stat-top">
                <div>
                    <p class="stat-label">أعلى فاتورة</p>
                    <p class="stat-value" style="font-size:1.4rem">{{ number_format($highestInvoiceAmount, 2) }}</p>
                </div>
                <div class="stat-icon-box"><i class="fas fa-crown"></i></div>
            </div>
            <div class="stat-bg-icon" style="color:#F59E0B"><i class="fas fa-crown"></i></div>
        </div>

        <!-- Average Value -->
        <div class="glass stat-card green">
            <div class="stat-top">
                <div>
                    <p class="stat-label">متوسط القيمة</p>
                    <p class="stat-value" style="font-size:1.4rem">{{ number_format($averageInvoiceValue, 2) }}</p>
                </div>
                <div class="stat-icon-box"><i class="fas fa-divide"></i></div>
            </div>
            <div class="stat-bg-icon" style="color:#10B981"><i class="fas fa-divide"></i></div>
        </div>

    </div>

    <!-- ── Charts ── -->
    <div class="charts-grid">

        <!-- Monthly Distribution (Bar) -->
        <div class="glass chart-card bar-card">
            <div class="chart-strip">
                <div class="strip-dot"></div>
                <span class="strip-label">التوزيع الشهري</span>
                <span class="strip-year">{{ \Carbon\Carbon::now()->year }}</span>
            </div>
            <div class="chart-body">
                <div class="chart-wrap">
                    <canvas id="monthlyInvoicesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- By Supplier (Doughnut) -->
        <div class="glass chart-card pie-card">
            <div class="chart-strip">
                <div class="strip-dot"></div>
                <span class="strip-label">حسب المورد</span>
                <span class="strip-year">{{ \Carbon\Carbon::now()->year }}</span>
            </div>
            <div class="chart-body">
                <div class="chart-wrap">
                    <canvas id="supplierInvoicesChart"></canvas>
                </div>
            </div>
        </div>

    </div>

</div>
</div>

<!-- Custom Alert -->
<div class="ca-overlay" id="caOverlay">
    <div class="ca-card">
        <div class="ca-bar" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-ring" id="caRing"></div>
            <p class="ca-title" id="caTitle"></p>
            <p class="ca-msg"   id="caMsg"></p>
            <div class="ca-prog-wrap" id="caPW" style="display:none">
                <div class="ca-prog-fill" id="caPF"></div>
            </div>
        </div>
        <div class="ca-footer-btn">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const isDark = () => document.documentElement.classList.contains('dark');
const gridColor = () => isDark() ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.05)';
const tickColor = () => isDark() ? '#64748b' : '#94a3b8';
const tooltipBg    = () => isDark() ? 'rgba(10,17,34,.95)' : 'rgba(255,255,255,.95)';
const tooltipTitle = () => isDark() ? '#f1f5f9' : '#1e293b';
const tooltipBody  = () => isDark() ? '#94a3b8'  : '#64748b';
const tooltipBorder= () => isDark() ? 'rgba(51,65,85,.5)' : 'rgba(255,255,255,.8)';

/* ── 1. Monthly Bar Chart ── */
new Chart(document.getElementById('monthlyInvoicesChart'), {
    type: 'bar',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'عدد الفواتير',
            data: @json($monthlyInvoicesData),
            backgroundColor: 'rgba(59,130,246,.75)',
            hoverBackgroundColor: '#3B82F6',
            borderRadius: 10,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: tooltipBg(),
                titleColor: tooltipTitle(),
                bodyColor: tooltipBody(),
                borderColor: tooltipBorder(),
                borderWidth: 1,
                titleFont: { family:'Cairo', size:13, weight:'900' },
                bodyFont:  { family:'Cairo', size:12, weight:'600' },
                padding: 14, cornerRadius: 14,
                callbacks: {
                    label: ctx => ' عدد الفواتير: ' + ctx.parsed.y.toLocaleString()
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: gridColor() },
                border: { display: false },
                ticks: {
                    color: tickColor(),
                    font: { family:'Cairo', size:11, weight:'700' }
                }
            },
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: {
                    color: tickColor(),
                    font: { family:'Cairo', size:11, weight:'700' }
                }
            }
        },
        animation: { duration:900, easing:'easeInOutQuart' }
    }
});

/* ── 2. Supplier Doughnut Chart ── */
new Chart(document.getElementById('supplierInvoicesChart'), {
    type: 'doughnut',
    data: {
        labels: @json($supplierNames),
        datasets: [{
            data: @json($supplierInvoicesData),
            backgroundColor: [
                '#3B82F6','#A855F7','#F59E0B',
                '#10B981','#EF4444','#6366F1',
                '#06B6D4','#F97316'
            ],
            borderWidth: 0,
            hoverOffset: 16
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '72%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 18,
                    font: { family:'Cairo', size:11, weight:'700' },
                    color: tickColor()
                }
            },
            tooltip: {
                backgroundColor: tooltipBg(),
                titleColor: tooltipTitle(),
                bodyColor: tooltipBody(),
                borderColor: tooltipBorder(),
                borderWidth: 1,
                titleFont: { family:'Cairo', size:13, weight:'900' },
                bodyFont:  { family:'Cairo', size:12, weight:'600' },
                padding: 14, cornerRadius: 14,
                callbacks: {
                    label: ctx => ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString()
                }
            }
        },
        animation: { duration:900, easing:'easeInOutQuart' }
    }
});

/* ── Custom Alert ── */
const CA_SVG = {
    success:`<svg viewBox="0 0 52 52"><circle class="ca-cc" cx="26" cy="26" r="25"/><path class="ca-cm" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
    error:  `<svg viewBox="0 0 52 52"><circle class="ca-ec" cx="26" cy="26" r="25"/><line class="ca-ex1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-ex2" x1="36" y1="16" x2="16" y2="36"/></svg>`
};
let caTimer = null;
function caShow({type,title,msg,btnText,autoClose}){
    const o=document.getElementById('caOverlay'), bar=document.getElementById('caBar'),
          rng=document.getElementById('caRing'),   t=document.getElementById('caTitle'),
          m=document.getElementById('caMsg'),       btn=document.getElementById('caBtn'),
          pw=document.getElementById('caPW'),       pf=document.getElementById('caPF');
    o.classList.remove('ca-show');
    bar.className=`ca-bar ${type}`; rng.className=`ca-ring ${type}`;
    rng.innerHTML=CA_SVG[type]; t.textContent=title; m.textContent=msg;
    btn.className=`ca-btn ${type}`; btn.textContent=btnText;
    if(autoClose){
        pw.style.display='block'; pf.className='ca-prog-fill';
        pf.style.setProperty('--ca-dur', autoClose/1000+'s');
        void pf.offsetWidth; pf.classList.add('run');
        caTimer = setTimeout(caClose, autoClose);
    } else {
        pw.style.display='none';
    }
    requestAnimationFrame(() => o.classList.add('ca-show'));
}
function caClose(){ clearTimeout(caTimer); document.getElementById('caOverlay').classList.remove('ca-show'); }
document.getElementById('caOverlay').addEventListener('click', function(e){ if(e.target===this) caClose(); });

@if(session('success'))
window.addEventListener('DOMContentLoaded', () => {
    caShow({type:'success', title:'تم بنجاح!', msg:'{{ session("success") }}', btnText:'حسناً', autoClose:3800});
});
@endif
@if($errors->any())
window.addEventListener('DOMContentLoaded', () => {
    caShow({type:'error', title:'خطأ', msg:'{{ $errors->first() }}', btnText:'حسناً'});
});
@endif
</script>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

</script>
@endpush