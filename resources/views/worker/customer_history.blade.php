<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل عمليات الزبون - {{ $customer->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
* { font-family: 'Cairo', 'Tajawal', sans-serif; }
html { scroll-behavior: smooth; }

body {
    min-height: 100vh;
    padding: 2.5rem 1rem 4rem;
    background: #f1f5f9;
    transition: background .4s ease;
    position: relative; overflow-x: hidden;
}
html.dark body { background: #04080f; }

/* ── Ambient gradients ── */
body::before {
    content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.09)  0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(99,102,241,.07) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(59,130,246,.05) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.15)  0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(99,102,241,.12) 0%, transparent 60%);
}

/* ── Orbs ── */
.orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
.orb-1 { width:340px;height:340px; background:rgba(37,99,235,.07);   top:-90px;  right:-90px; animation-delay:0s;  }
.orb-2 { width:260px;height:260px; background:rgba(99,102,241,.06);  bottom:8%;  left:-60px;  animation-delay:-5s; }
.orb-3 { width:190px;height:190px; background:rgba(59,130,246,.05);  top:40%;    right:3%;    animation-delay:-9s; }
html.dark .orb-1 { background:rgba(37,99,235,.13); }
html.dark .orb-2 { background:rgba(99,102,241,.11); }
@keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

/* ── Dark toggle ── */
.dark-toggle {
    position:fixed; top:1.3rem; left:1.3rem; z-index:1000;
    width:44px; height:44px; border-radius:50%;
    background:rgba(255,255,255,.65); backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.7); box-shadow:0 3px 14px rgba(0,0,0,.09);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .28s cubic-bezier(.34,1.56,.64,1);
}
html.dark .dark-toggle { background:rgba(15,23,42,.7); border-color:rgba(51,65,85,.5); }
.dark-toggle:hover { transform:scale(1.12); box-shadow:0 6px 22px rgba(37,99,235,.28); }
.dark-toggle i { font-size:1rem; color:#64748b; transition:color .25s; }
html.dark .dark-toggle i { color:#60a5fa; }

/* ── Page container ── */
.page-container { max-width:1080px; margin:0 auto; position:relative; z-index:1; }

/* ── Page header ── */
.page-header {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:1.5rem; margin-bottom:2rem;
    animation:slideDown .6s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes slideDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }

.header-brand { display:flex; align-items:center; gap:1.2rem; }
.header-icon-wrap {
    width:64px; height:64px; flex-shrink:0;
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
    border-radius:20px; display:flex; align-items:center; justify-content:center;
    box-shadow:0 8px 32px rgba(37,99,235,.38),0 0 0 3px rgba(37,99,235,.15);
    position:relative;
}
.header-icon-wrap::after { content:'';position:absolute;inset:-3px;border-radius:23px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
.header-icon-wrap i { color:#fff; font-size:1.6rem; position:relative; z-index:1; }

.header-title { font-size:2rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1.1; }
html.dark .header-title { color:#f1f5f9; }
.header-subtitle { font-size:.85rem; color:#64748b; font-weight:600; margin-top:4px; }
html.dark .header-subtitle { color:#94a3b8; }
.header-subtitle span { color:#2563EB; font-weight:900; }
html.dark .header-subtitle span { color:#60a5fa; }

.btn-back {
    display:inline-flex; align-items:center; gap:.6rem;
    padding:.65rem 1.3rem;
    background:rgba(255,255,255,.6); backdrop-filter:blur(12px);
    color:#64748b; border-radius:1rem; font-weight:700; font-size:.88rem;
    text-decoration:none; border:1px solid rgba(255,255,255,.7);
    box-shadow:0 2px 12px rgba(0,0,0,.04);
    transition:all .25s cubic-bezier(.34,1.56,.64,1); flex-shrink:0;
}
html.dark .btn-back { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.5); color:#94a3b8; }
.btn-back:hover { color:#2563EB; border-color:rgba(37,99,235,.35); box-shadow:0 4px 20px rgba(37,99,235,.14); transform:translateY(-2px); }
html.dark .btn-back:hover { color:#60a5fa; }
.btn-back i { transition:transform .25s ease; font-size:.78rem; }
.btn-back:hover i { transform:translateX(3px); }

/* ── Stats row ── */
.stats-row {
    display:grid; grid-template-columns:repeat(3,1fr); gap:1.2rem;
    margin-bottom:1.8rem;
    animation:slideUp .6s .1s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

.stat-card {
    background:rgba(255,255,255,.55); backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px);
    border:1px solid rgba(255,255,255,.65); border-radius:1.6rem;
    padding:1.4rem 1.6rem;
    box-shadow:0 4px 20px rgba(0,0,0,.06),0 1px 0 rgba(255,255,255,.8) inset;
    display:flex; align-items:center; gap:1.1rem;
    transition:transform .25s cubic-bezier(.34,1.56,.64,1),box-shadow .25s ease;
    position:relative; overflow:hidden;
}
html.dark .stat-card { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.45); box-shadow:0 4px 20px rgba(0,0,0,.25); }
.stat-card:hover { transform:translateY(-4px) scale(1.02); box-shadow:0 12px 36px rgba(0,0,0,.10); }
html.dark .stat-card:hover { box-shadow:0 12px 36px rgba(0,0,0,.4); }

.stat-icon {
    width:50px; height:50px; border-radius:14px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1.2rem;
}
.stat-icon.blue   { background:rgba(37,99,235,.12);  color:#2563EB; }
.stat-icon.green  { background:rgba(16,185,129,.12); color:#10B981; }
.stat-icon.red    { background:rgba(239,68,68,.10);  color:#EF4444; }
html.dark .stat-icon.blue  { background:rgba(37,99,235,.2);  }
html.dark .stat-icon.green { background:rgba(16,185,129,.2); }
html.dark .stat-icon.red   { background:rgba(239,68,68,.18); }

.stat-info { flex:1; min-width:0; }
.stat-label { font-size:.68rem; font-weight:900; text-transform:uppercase; letter-spacing:.08em; color:#94a3b8; margin-bottom:.25rem; }
.stat-value { font-size:1.35rem; font-weight:900; letter-spacing:-.02em; line-height:1; }
.stat-value.blue  { color:#2563EB; }
.stat-value.green { color:#10B981; }
.stat-value.red   { color:#EF4444; }
html.dark .stat-value.blue  { color:#60a5fa; }
html.dark .stat-value.green { color:#34d399; }
html.dark .stat-value.red   { color:#f87171; }
.stat-value span { font-size:.7rem; font-weight:700; opacity:.7; margin-right:.25rem; }

/* ── Table card ── */
.table-card {
    background:rgba(255,255,255,.55); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
    border:1px solid rgba(255,255,255,.65); border-radius:2rem;
    box-shadow:0 8px 40px rgba(0,0,0,.08),0 1px 0 rgba(255,255,255,.8) inset;
    overflow:hidden;
    animation:slideUp .6s .2s cubic-bezier(.34,1.56,.64,1) both;
    position:relative;
}
html.dark .table-card { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.45); box-shadow:0 8px 40px rgba(0,0,0,.3); }
.table-card::before { content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(37,99,235,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
html.dark .table-card::before { display:block; }

/* strip */
.table-strip {
    background:linear-gradient(135deg,rgba(37,99,235,.07) 0%,rgba(99,102,241,.06) 100%);
    border-bottom:1px solid rgba(37,99,235,.09);
    padding:1rem 1.8rem; display:flex; align-items:center; gap:.7rem;
}
html.dark .table-strip { background:linear-gradient(135deg,rgba(37,99,235,.11) 0%,rgba(99,102,241,.09) 100%); border-bottom-color:rgba(51,65,85,.4); }
.strip-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7);flex-shrink:0; }
.strip-label { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
html.dark .strip-label { color:#60a5fa; }
.strip-count {
    margin-right:auto;
    font-size:.72rem; font-weight:800; color:#64748b;
    background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.15);
    padding:.22rem .75rem; border-radius:999px;
}
html.dark .strip-count { background:rgba(37,99,235,.14); color:#94a3b8; }

/* table */
.table-scroll { overflow-x:auto; }

table { width:100%; border-collapse:collapse; text-align:right; }

thead tr {
    background:linear-gradient(135deg,rgba(37,99,235,.06) 0%,rgba(99,102,241,.05) 100%);
    border-bottom:1px solid rgba(148,163,184,.12);
}
html.dark thead tr { background:rgba(15,23,42,.4); border-bottom-color:rgba(51,65,85,.35); }

thead th {
    padding:.9rem 1.3rem; font-size:.68rem; font-weight:900;
    text-transform:uppercase; letter-spacing:.07em; color:#94a3b8;
    white-space:nowrap;
}

tbody tr {
    border-bottom:1px solid rgba(148,163,184,.07);
    transition:background .18s ease;
}
html.dark tbody tr { border-bottom-color:rgba(51,65,85,.2); }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:rgba(37,99,235,.04); }
html.dark tbody tr:hover { background:rgba(37,99,235,.07); }

tbody td {
    padding:.95rem 1.3rem; font-size:.88rem; font-weight:600; color:#334155;
    white-space:nowrap;
}
html.dark tbody td { color:#cbd5e1; }

/* invoice # */
.inv-num { font-weight:900; color:#1e293b; font-size:.9rem; }
html.dark .inv-num { color:#f1f5f9; }

/* date */
.date-cell { color:#64748b; font-size:.83rem; }
html.dark .date-cell { color:#94a3b8; }

/* amounts */
.amt-total { font-weight:900; color:#1e293b; }
html.dark .amt-total { color:#e2e8f0; }
.amt-paid  { font-weight:800; color:#10B981; }
html.dark .amt-paid  { color:#34d399; }
.amt-rest  { font-weight:800; color:#EF4444; }
html.dark .amt-rest  { color:#f87171; }

/* status badge */
.badge {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.3rem .85rem; border-radius:999px;
    font-size:.68rem; font-weight:900; text-transform:uppercase; letter-spacing:.05em;
    white-space:nowrap;
}
.badge.paid { background:rgba(16,185,129,.12); color:#10B981; border:1px solid rgba(16,185,129,.22); }
.badge.debt { background:rgba(245,158,11,.10); color:#F59E0B; border:1px solid rgba(245,158,11,.22); }
html.dark .badge.paid { background:rgba(16,185,129,.18); }
html.dark .badge.debt { background:rgba(245,158,11,.16); }

/* action button */
.btn-details {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.42rem 1rem; border-radius:.7rem;
    background:linear-gradient(135deg,#2563EB,#4F46E5); color:#fff;
    font-size:.75rem; font-weight:800; text-decoration:none;
    box-shadow:0 4px 14px rgba(37,99,235,.3);
    transition:all .22s cubic-bezier(.34,1.56,.64,1);
    border:none; cursor:pointer;
}
.btn-details:hover { transform:translateY(-2px) scale(1.05); box-shadow:0 7px 22px rgba(37,99,235,.45); }
.btn-details:active { transform:scale(.96); }

/* empty state */
.empty-state { padding:4rem 2rem; text-align:center; }
.empty-icon {
    width:72px; height:72px; border-radius:50%;
    background:rgba(37,99,235,.08); border:1px solid rgba(37,99,235,.15);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 1.2rem; font-size:1.8rem; color:#2563EB;
}
html.dark .empty-icon { background:rgba(37,99,235,.14); }
.empty-state p { font-size:.9rem; font-weight:700; color:#94a3b8; }

/* pagination */
.pagination-wrap {
    padding:1.2rem 1.8rem;
    border-top:1px solid rgba(148,163,184,.1);
    display:flex; justify-content:center;
}
html.dark .pagination-wrap { border-top-color:rgba(51,65,85,.3); }

/* ── Responsive ── */
@media(max-width:768px){
    .stats-row { grid-template-columns:1fr; }
    .page-header { flex-direction:column; align-items:flex-start; }
    .btn-back { align-self:stretch; justify-content:center; }
    .header-title { font-size:1.6rem; }
}
@media(max-width:500px){
    body { padding:1.5rem .5rem 3rem; }
}
</style>
</head>
<body>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- Dark toggle -->
<button class="dark-toggle" onclick="toggleDark()" aria-label="تبديل الوضع">
    <i id="darkIcon" class="fas fa-moon"></i>
</button>

<div class="page-container">

    <!-- Header -->
    <div class="page-header">
        <div class="header-brand">
            <div class="header-icon-wrap">
                <i class="fas fa-history"></i>
            </div>
            <div>
                <h1 class="header-title">سجل عمليات الزبون</h1>
                <p class="header-subtitle">الاسم: <span>{{ $customer->name }}</span></p>
            </div>
        </div>
        <a href="{{ route('customers.index') }}" class="btn-back">
            العودة للقائمة
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-shopping-bag"></i></div>
            <div class="stat-info">
                <p class="stat-label">إجمالي المشتريات</p>
                <p class="stat-value blue"><span>DA</span>{{ number_format($stats['total_spent'], 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <p class="stat-label">إجمالي المدفوع</p>
                <p class="stat-value green"><span>DA</span>{{ number_format($stats['total_paid'], 2) }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="fas fa-exclamation-circle"></i></div>
            <div class="stat-info">
                <p class="stat-label">إجمالي الديون</p>
                <p class="stat-value red"><span>DA</span>{{ number_format($stats['total_debt'], 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Table card -->
    <div class="table-card">
        <div class="table-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">الفواتير</span>
            <span class="strip-count">{{ $sales->count() }} فاتورة</span>
        </div>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>التاريخ</th>
                        <th>المبلغ الإجمالي</th>
                        <th>المدفوع</th>
                        <th>المتبقي</th>
                        <th>الحالة</th>
                        <th style="text-align:center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td><span class="inv-num">#{{ $sale->invoice_number }}</span></td>
                        <td><span class="date-cell">{{ $sale->sale_date }}</span></td>
                        <td><span class="amt-total">{{ number_format($sale->total_amount, 2) }}</span></td>
                        <td><span class="amt-paid">{{ number_format($sale->paid_amount, 2) }}</span></td>
                        <td><span class="amt-rest">{{ number_format($sale->remaining_amount, 2) }}</span></td>
                        <td>
                            @if($sale->status == 'paid')
                                <span class="badge paid"><i class="fas fa-check" style="font-size:.6rem"></i> مدفوع</span>
                            @else
                                <span class="badge debt"><i class="fas fa-clock" style="font-size:.6rem"></i> دين</span>
                            @endif
                        </td>
                        <td style="text-align:center">
                            <a href="{{ route('sales.details', $sale->id) }}" class="btn-details">
                                <i class="fas fa-eye"></i> التفاصيل
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                                <p>لا يوجد سجل مشتريات لهذا الزبون حالياً</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
function toggleDark(){
    const html=document.documentElement, icon=document.getElementById('darkIcon');
    if(html.classList.contains('dark')){
        html.classList.remove('dark'); localStorage.setItem('theme','light'); icon.className='fas fa-moon';
    } else {
        html.classList.add('dark'); localStorage.setItem('theme','dark'); icon.className='fas fa-sun';
    }
}
document.addEventListener('DOMContentLoaded',()=>{
    if(document.documentElement.classList.contains('dark'))
        document.getElementById('darkIcon').className='fas fa-sun';
});
</script>
</body>
</html>