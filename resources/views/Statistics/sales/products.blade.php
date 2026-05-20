@extends('layouts.app')

@section('title', 'تحليل أداء المنتجات')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

    /* ===== BACKGROUND ===== */
    .products-page {
        min-height: 100vh;
        padding: 2.2rem 1rem 3rem;
        position: relative;
        overflow-x: hidden;
    }
    .products-page::before {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(59,130,246,0.09) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(16,185,129,0.08) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 35%, rgba(249,115,22,0.06) 0%, transparent 55%);
        pointer-events: none; z-index: 0;
    }
    .dark .products-page::before {
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(59,130,246,0.14) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(16,185,129,0.13) 0%, transparent 60%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:300px; height:300px; background:rgba(59,130,246,0.07);  top:-70px; right:-70px; animation-delay:0s; }
    .orb-2 { width:220px; height:220px; background:rgba(16,185,129,0.07);   bottom:12%; left:-50px; animation-delay:-5s; }
    .orb-3 { width:160px; height:160px; background:rgba(249,115,22,0.06);  top:40%; right:8%;     animation-delay:-9s; }
    .dark .orb-1 { background:rgba(59,130,246,0.13); }
    .dark .orb-2 { background:rgba(16,185,129,0.13); }

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
        background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(59,130,246,0.35), 0 0 0 3px rgba(59,130,246,0.12);
        flex-shrink:0; position:relative;
    }
    .header-icon::before { content:''; position:absolute; inset:0; border-radius:inherit; background:linear-gradient(135deg,rgba(255,255,255,0.22),transparent); }
    .header-icon svg { color:#fff; width:26px; height:26px; position:relative; z-index:1; }
    .header-title { font-size:1.9rem; font-weight:900; color:#1e293b; letter-spacing:-0.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:0.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .header-sub { color:#94a3b8; }

    .date-badge {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.6rem 1.2rem;
        background:rgba(255,255,255,0.6); backdrop-filter:blur(8px);
        border:1px solid rgba(203,213,225,0.5); border-radius:12px;
        font-size:0.85rem; font-weight:800; color:#64748b;
        box-shadow:0 4px 14px rgba(0,0,0,0.04);
    }
    .dark .date-badge { background:rgba(30,41,59,0.5); border-color:rgba(71,85,105,0.3); color:#94a3b8; }
    .date-badge i { color:#3b82f6; font-size:0.8rem; }

    /* ===== ALERT ===== */
    .alert-rose {
        background:rgba(244,63,94,0.06); backdrop-filter:blur(16px);
        border:1px solid rgba(244,63,94,0.15); border-right:4px solid #f43f5e;
        border-radius:1.3rem; padding:1.2rem 1.5rem;
        display:flex; align-items:center; justify-content:space-between;
        box-shadow:0 4px 18px rgba(244,63,94,0.08);
        animation:slideUp 0.55s 0.1s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .dark .alert-rose { background:rgba(244,63,94,0.08); border-color:rgba(244,63,94,0.2); }
    .alert-icon { width:44px; height:44px; border-radius:12px; background:rgba(244,63,94,0.1); display:flex; align-items:center; justify-content:center; color:#f43f5e; font-size:1.1rem; }
    .alert-title { font-weight:800; font-size:0.95rem; color:#be123c; }
    .dark .alert-title { color:#fb7185; }
    .alert-text { font-size:0.8rem; color:#f43f5e; opacity:0.8; margin-top:2px; }
    .dark .alert-text { color:#fb7185; }
    .alert-btn { font-size:0.75rem; font-weight:900; color:#be123c; text-decoration:underline; text-underline-offset:3px; background:none; border:none; cursor:pointer; text-transform:uppercase; letter-spacing:0.05em; }
    .dark .alert-btn { color:#fb7185; }

    /* ===== CHARTS GRID ===== */
    .charts-grid {
        display:grid; grid-template-columns:1fr; gap:1.5rem; margin-bottom:1.5rem;
        animation:slideUp 0.6s 0.15s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @media(min-width:1024px){ .charts-grid { grid-template-columns:1fr 1fr; } }

    .chart-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        padding:1.8rem;
        transition:transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dark .chart-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }
    .chart-card:hover { transform:translateY(-3px); box-shadow:0 12px 48px rgba(0,0,0,0.1); }

    .chart-header { display:flex; align-items:center; gap:0.6rem; margin-bottom:1.5rem; }
    .chart-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:0.9rem; }
    .chart-icon.orange { background:rgba(249,115,22,0.1); color:#f97316; }
    .chart-icon.emerald { background:rgba(16,185,129,0.1); color:#10b981; }
    .chart-title { font-size:1rem; font-weight:900; color:#1e293b; }
    .dark .chart-title { color:#f1f5f9; }

    /* ===== TABLES GRID ===== */
    .tables-grid {
        display:grid; grid-template-columns:1fr; gap:1.5rem;
        animation:slideUp 0.6s 0.2s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @media(min-width:1024px){ .tables-grid { grid-template-columns:1fr 1fr; } }

    .table-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        overflow:hidden;
        transition:transform 0.25s ease;
    }
    .dark .table-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }
    .table-card:hover { transform:translateY(-3px); }

    .table-header {
        padding:1.2rem 1.5rem;
        border-bottom:1px solid rgba(148,163,184,0.1);
        display:flex; align-items:center; gap:0.6rem;
    }
    .table-header.blue { background:linear-gradient(135deg,rgba(59,130,246,0.06),rgba(37,99,235,0.04)); }
    .table-header.rose { background:linear-gradient(135deg,rgba(244,63,94,0.06),rgba(225,29,72,0.04)); }

    .table-header-icon { width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:0.8rem; }
    .table-header-icon.blue { background:rgba(59,130,246,0.1); color:#3b82f6; }
    .table-header-icon.rose { background:rgba(244,63,94,0.1); color:#f43f5e; }

    .table-header-title { font-size:0.95rem; font-weight:900; }
    .table-header-title.blue { color:#1e40af; }
    .table-header-title.rose { color:#be123c; }
    .dark .table-header-title.blue { color:#60a5fa; }
    .dark .table-header-title.rose { color:#fb7185; }

    .table-overflow { overflow-x:auto; }
    .table-overflow::-webkit-scrollbar { height:5px; }
    .table-overflow::-webkit-scrollbar-thumb { background:rgba(59,130,246,0.2); border-radius:10px; }

    table { width:100%; border-collapse:collapse; direction:rtl; }

    thead tr { border-bottom:1px solid rgba(148,163,184,0.1); }
    th { padding:0.8rem 1.3rem; font-size:0.65rem; font-weight:900; color:#94a3b8; text-transform:uppercase; letter-spacing:0.08em; white-space:nowrap; }

    tbody tr {
        border-bottom:1px solid rgba(148,163,184,0.05);
        transition:all 0.22s ease;
        animation:rowIn 0.4s ease both;
    }
    @keyframes rowIn { from{opacity:0;transform:translateX(8px);} to{opacity:1;transform:translateX(0);} }

    tbody tr:nth-child(1){animation-delay:.04s} tbody tr:nth-child(2){animation-delay:.08s}
    tbody tr:nth-child(3){animation-delay:.12s} tbody tr:nth-child(4){animation-delay:.16s}
    tbody tr:nth-child(5){animation-delay:.20s}

    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(59,130,246,0.02); }
    .dark tbody tr:hover { background:rgba(59,130,246,0.05); }

    td { padding:0.8rem 1.3rem; vertical-align:middle; }

    .product-name { font-size:0.85rem; font-weight:800; color:#1e293b; }
    .dark .product-name { color:#f1f5f9; }

    .stock-badge {
        display:inline-flex; align-items:center; justify-content:center;
        padding:0.25rem 0.8rem; border-radius:8px;
        font-size:0.75rem; font-weight:900; font-family:'Tajawal',monospace;
        background:rgba(100,116,139,0.08); color:#64748b;
    }
    .dark .stock-badge { background:rgba(100,116,139,0.15); color:#94a3b8; }

    .stock-danger { color:#e11d48; background:rgba(244,63,94,0.08); }
    .dark .stock-danger { color:#fb7185; background:rgba(244,63,94,0.12); }

    .min-stock { font-size:0.7rem; color:#94a3b8; font-style:italic; }

    @media(max-width:640px) {
        .page-header { flex-direction:column; align-items:flex-start; }
        .header-title { font-size:1.5rem; }
        td,th { padding:0.7rem 1rem; }
    }
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="products-page" dir="rtl">
<div class="page-wrap">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <h1 class="header-title">تحليل أداء المنتجات</h1>
                <p class="header-sub">مراقبة المخزون والمبيعات وحركة المنتجات</p>
            </div>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i>
            {{ now()->format('Y-m-d') }}
        </div>
    </div>

    {{-- LOW STOCK ALERT --}}
    @if($lowStockProducts->count() > 0)
    <div class="alert-rose">
        <div class="flex items-center gap-4">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div>
                <div class="alert-title">تنبيه المخزون المنخفض!</div>
                <div class="alert-text">يوجد {{ $lowStockProducts->count() }} منتجات وصلت للحد الأدنى.</div>
            </div>
        </div>
<a href="{{ route('products.index') }}" class="alert-btn">مراجعة الآن</a>
    </div>
    @endif

    {{-- CHARTS --}}
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-icon orange">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="chart-title">أكثر 5 منتجات مبيعاً</div>
            </div>
            <div style="position:relative; height:280px;">
                <canvas id="topSellingChart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <div class="chart-icon emerald">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div class="chart-title">العوائد حسب المنتج</div>
            </div>
            <div style="position:relative; height:280px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    {{-- TABLES --}}
    <div class="tables-grid">
        
        {{-- Stagnant Products --}}
        <div class="table-card">
            <div class="table-header blue">
                <div class="table-header-icon blue">
                    <i class="fas fa-snowflake"></i>
                </div>
                <div class="table-header-title blue">منتجات راكدة (لم تبع مؤخراً)</div>
            </div>
            <div class="table-overflow">
                <table>
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th style="text-align:center;">المخزون الحالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stagnantProducts as $product)
                        <tr>
                            <td>
                                <div class="product-name">{{ $product->name }}</div>
                            </td>
                            <td style="text-align:center;">
                                <span class="stock-badge">{{ $product->current_stock }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Low Stock Products --}}
        <div class="table-card">
            <div class="table-header rose">
                <div class="table-header-icon rose">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="table-header-title rose">منتجات تحتاج لإعادة طلب</div>
            </div>
            <div class="table-overflow">
                <table>
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th style="text-align:center;">المتاح</th>
                            <th style="text-align:center;">الحد الأدنى</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td>
                                <div class="product-name">{{ $product->name }}</div>
                            </td>
                            <td style="text-align:center;">
                                <span class="stock-badge stock-danger">{{ $product->current_stock }}</span>
                            </td>
                            <td style="text-align:center;">
                                <span class="min-stock">{{ $product->minimum_stock }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';

    // 1. Top Selling Chart
    new Chart(document.getElementById('topSellingChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topSellingProducts->pluck('name')) !!},
            datasets: [{
                label: 'الكمية المباعة',
                data: {!! json_encode($topSellingProducts->pluck('total_qty')) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 10,
                barThickness: 20
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Cairo' } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Cairo' } } }
            }
        }
    });

    // 2. Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($productSalesData->pluck('name')) !!},
            datasets: [{
                label: 'العوائد (د.ج)',
                data: {!! json_encode($productSalesData->pluck('total_revenue')) !!},
                backgroundColor: '#10b981',
                borderRadius: 10,
                barThickness: 25
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { family: 'Cairo' } } },
                x: { grid: { display: false }, ticks: { color: textColor, font: { family: 'Cairo' } } }
            }
        }
    });
</script>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    function showStyledAlert(config) {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            icon: config.icon || 'info',
            title: config.title || '',
            text: config.text || '',
            html: config.html || null,
            showConfirmButton: config.showConfirmButton !== undefined ? config.showConfirmButton : true,
            showCancelButton: config.showCancelButton || false,
            confirmButtonText: config.confirmButtonText || 'موافق',
            cancelButtonText: config.cancelButtonText || 'إلغاء',
            timer: config.timer || null,
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            confirmButtonColor: config.icon === 'warning' || config.icon === 'error' ? '#ef4444' : '#10b981',
            cancelButtonColor: isDark ? '#334155' : '#94a3b8',
            customClass: {
                popup: 'rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-white/5 backdrop-blur-xl',
                title: 'text-2xl font-black pt-4',
                htmlContainer: 'text-right font-medium',
                confirmButton: 'rounded-2xl px-8 py-3 font-bold mx-3 shadow-lg shadow-emerald-500/20 transition-all hover:scale-105',
                cancelButton: 'rounded-2xl px-8 py-3 font-bold mx-3 shadow-lg transition-all hover:scale-105'
            },
            buttonsStyling: false,
            showClass: { popup: 'animate__animated animate__zoomIn animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOut animate__faster' }
        });
    }

    @if(session('success'))
        showStyledAlert({
            icon: 'success',
            title: 'تمت العملية بنجاح!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    @endif
</script>
@endpush