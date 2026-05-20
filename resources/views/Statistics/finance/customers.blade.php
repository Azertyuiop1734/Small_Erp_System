@extends('layouts.app')

@section('title', 'العملاء المديونين')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

    /* ===== BACKGROUND ===== */
    .customers-page {
        min-height: 100vh;
        padding: 2.2rem 1rem 3rem;
        position: relative;
        overflow-x: hidden;
    }
    .customers-page::before {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(244,63,94,0.09) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(245,158,11,0.08) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 35%, rgba(59,130,246,0.06) 0%, transparent 55%);
        pointer-events: none; z-index: 0;
    }
    .dark .customers-page::before {
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(244,63,94,0.14) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(245,158,11,0.13) 0%, transparent 60%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:300px; height:300px; background:rgba(244,63,94,0.07);  top:-70px; right:-70px; animation-delay:0s; }
    .orb-2 { width:220px; height:220px; background:rgba(245,158,11,0.07);   bottom:12%; left:-50px; animation-delay:-5s; }
    .orb-3 { width:160px; height:160px; background:rgba(59,130,246,0.06);  top:40%; right:8%;     animation-delay:-9s; }
    .dark .orb-1 { background:rgba(244,63,94,0.13); }
    .dark .orb-2 { background:rgba(245,158,11,0.13); }

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
        background:linear-gradient(135deg,#f43f5e 0%,#e11d48 100%);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(244,63,94,0.35), 0 0 0 3px rgba(244,63,94,0.12);
        flex-shrink:0; position:relative;
    }
    .header-icon::before { content:''; position:absolute; inset:0; border-radius:inherit; background:linear-gradient(135deg,rgba(255,255,255,0.22),transparent); }
    .header-icon svg { color:#fff; width:26px; height:26px; position:relative; z-index:1; }
    .header-title { font-size:1.9rem; font-weight:900; color:#1e293b; letter-spacing:-0.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:0.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .header-sub { color:#94a3b8; }

    /* Status Badge */
    .status-badge {
        display:inline-flex; align-items:center; gap:0.5rem;
        padding:0.5rem 1rem;
        background:rgba(244,63,94,0.08); backdrop-filter:blur(8px);
        border:1px solid rgba(244,63,94,0.2); border-radius:12px;
        font-size:0.85rem; font-weight:800; color:#e11d48;
    }
    .dark .status-badge { background:rgba(244,63,94,0.12); color:#fb7185; }
    .status-dot { position:relative; width:8px; height:8px; }
    .status-dot::before { content:''; position:absolute; inset:0; border-radius:50%; background:#f43f5e; animation:ping 1.5s cubic-bezier(0,0,0.2,1) infinite; }
    .status-dot::after { content:''; position:absolute; inset:0; border-radius:50%; background:#f43f5e; }
    @keyframes ping { 75%,100%{transform:scale(2);opacity:0;} }

    /* ===== STATS ===== */
    .stats-row {
        display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
        gap:1rem; margin-bottom:1.6rem;
        animation:slideUp 0.55s 0.08s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    .stat-card {
        background:rgba(255,255,255,0.55); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
        border:1px solid rgba(255,255,255,0.7); border-radius:1.5rem;
        padding:1.5rem;
        box-shadow:0 4px 18px rgba(0,0,0,0.05);
        transition:transform 0.25s ease, box-shadow 0.25s ease;
        position:relative; overflow:hidden;
    }
    .dark .stat-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.45); box-shadow:0 4px 18px rgba(0,0,0,0.22); }
    .stat-card:hover { transform:translateY(-3px) scale(1.02); box-shadow:0 8px 28px rgba(0,0,0,0.09); }
    .dark .stat-card:hover { box-shadow:0 8px 28px rgba(0,0,0,0.3); }

    .stat-card::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; border-radius:2px; }
    .stat-rose::before { background:linear-gradient(to bottom,#f43f5e,#e11d48); }
    .stat-amber::before { background:linear-gradient(to bottom,#f59e0b,#d97706); }
    .stat-blue::before { background:linear-gradient(to bottom,#3b82f6,#2563eb); }

    .stat-label { font-size:0.7rem; font-weight:900; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:0.5rem; }
    .stat-rose .stat-label { color:#f43f5e; }
    .stat-amber .stat-label { color:#f59e0b; }
    .stat-blue .stat-label { color:#3b82f6; }

    .stat-value { font-size:1.8rem; font-weight:900; color:#1e293b; line-height:1; }
    .dark .stat-value { color:#f1f5f9; }
    .stat-unit { font-size:0.75rem; font-weight:600; opacity:0.6; margin-right:0.25rem; }

    .stat-footer { margin-top:1rem; display:flex; align-items:center; gap:0.4rem; font-size:0.7rem; font-weight:700; text-transform:uppercase; color:#94a3b8; }
    .stat-footer i { font-size:0.7rem; }
    .stat-rose .stat-footer i { color:#f43f5e; }
    .stat-amber .stat-footer i { color:#f59e0b; }
    .stat-blue .stat-footer i { color:#3b82f6; }

    /* ===== TABLE CARD ===== */
    .table-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        overflow:hidden;
        animation:slideUp 0.6s 0.18s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .dark .table-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }

    .table-overflow { overflow-x:auto; }
    .table-overflow::-webkit-scrollbar { height:5px; }
    .table-overflow::-webkit-scrollbar-thumb { background:rgba(244,63,94,0.2); border-radius:10px; }

    table { width:100%; border-collapse:collapse; direction:rtl; }

    thead tr {
        background:linear-gradient(135deg,rgba(244,63,94,0.06) 0%,rgba(245,158,11,0.05) 100%);
        border-bottom:1px solid rgba(244,63,94,0.1);
    }
    .dark thead tr { background:linear-gradient(135deg,rgba(244,63,94,0.10),rgba(245,158,11,0.09)); border-bottom-color:rgba(51,65,85,0.45); }

    th { padding:1rem 1.3rem; font-size:0.70rem; font-weight:900; color:#f43f5e; text-transform:uppercase; letter-spacing:0.08em; white-space:nowrap; }
    .dark th { color:#fb7185; }

    tbody tr {
        border-bottom:1px solid rgba(148,163,184,0.07);
        transition:all 0.22s ease;
        animation:rowIn 0.4s ease both;
    }
    @keyframes rowIn { from{opacity:0;transform:translateX(8px);} to{opacity:1;transform:translateX(0);} }

    tbody tr:nth-child(1){animation-delay:.04s} tbody tr:nth-child(2){animation-delay:.08s}
    tbody tr:nth-child(3){animation-delay:.12s} tbody tr:nth-child(4){animation-delay:.16s}
    tbody tr:nth-child(5){animation-delay:.20s} tbody tr:nth-child(6){animation-delay:.24s}
    tbody tr:nth-child(7){animation-delay:.28s} tbody tr:nth-child(8){animation-delay:.32s}

    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(244,63,94,0.03); }
    .dark tbody tr:hover { background:rgba(244,63,94,0.07); }

    td { padding:0.95rem 1.3rem; vertical-align:middle; }

    /* Customer Cell */
    .customer-cell { display:flex; align-items:center; gap:0.9rem; }
    .customer-avatar {
        width:44px; height:44px; border-radius:14px;
        background:linear-gradient(135deg,#f1f5f9,#e2e8f0);
        display:flex; align-items:center; justify-content:center;
        font-weight:900; font-size:1.1rem; color:#64748b;
        flex-shrink:0;
    }
    .dark .customer-avatar { background:linear-gradient(135deg,#334155,#1e293b); color:#94a3b8; }
    .customer-name { font-weight:800; font-size:0.92rem; color:#1e293b; transition:color 0.2s; }
    .dark .customer-name { color:#f1f5f9; }
    tr:hover .customer-name { color:#f43f5e; }
    .dark tr:hover .customer-name { color:#fb7185; }
    .customer-address { font-size:0.72rem; color:#94a3b8; font-style:italic; margin-top:2px; }

    /* Phone */
    .phone-text { font-size:0.85rem; font-weight:600; color:#64748b; }
    .dark .phone-text { color:#94a3b8; }
    .phone-text i { font-size:0.65rem; opacity:0.5; margin-left:0.3rem; }

    /* Invoices Badge */
    .invoices-badge {
        display:inline-flex; align-items:center; gap:0.3rem;
        padding:0.3rem 0.9rem; border-radius:999px;
        font-size:0.78rem; font-weight:900;
        background:rgba(245,158,11,0.08); color:#d97706;
        border:1px solid rgba(245,158,11,0.2);
    }
    .dark .invoices-badge { background:rgba(245,158,11,0.12); color:#fbbf24; }

    /* Debt Amount */
    .debt-amount { font-size:1rem; font-weight:900; color:#e11d48; font-family:'Tajawal',monospace; }
    .dark .debt-amount { color:#fb7185; }
    .debt-unit { font-size:0.7rem; font-weight:600; opacity:0.6; margin-right:0.25rem; }

    /* Actions */
    .actions-wrap { display:flex; align-items:center; justify-content:center; }
    .btn-action {
        display:inline-flex; align-items:center; gap:0.4rem;
        padding:0.5rem 1rem; border-radius:11px;
        font-size:0.78rem; font-weight:800;
        background:rgba(255,255,255,0.7); cursor:pointer; text-decoration:none;
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        backdrop-filter:blur(8px); border:1px solid rgba(59,130,246,0.2);
        color:#3b82f6;
    }
    .dark .btn-action { background:rgba(30,41,59,0.7); border-color:rgba(59,130,246,0.3); color:#60a5fa; }
    .btn-action:hover { transform:scale(1.05); box-shadow:0 4px 14px rgba(59,130,246,0.18); background:#3b82f6; color:#fff; }
    .dark .btn-action:hover { background:#3b82f6; color:#fff; }
    .btn-action i { font-size:0.7rem; }

    /* Empty state */
    .empty-state { padding:4.5rem 2rem; text-align:center; }
    .empty-icon-wrap {
        width:80px; height:80px; border-radius:24px;
        background:linear-gradient(135deg,rgba(16,185,129,0.08),rgba(5,150,105,0.06));
        border:1px solid rgba(16,185,129,0.12);
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 1.3rem;
    }
    .empty-icon-wrap svg { width:36px; height:36px; color:#10b981; }
    .empty-title { font-size:1.1rem; font-weight:900; color:#1e293b; }
    .dark .empty-title { color:#f1f5f9; }
    .empty-sub { font-size:0.82rem; color:#94a3b8; margin-top:0.35rem; font-weight:500; }

    /* Pagination */
    .pagination-wrap {
        margin-top:1.2rem; background:rgba(255,255,255,0.4); backdrop-filter:blur(12px);
        border:1px solid rgba(255,255,255,0.5); border-radius:1.2rem;
        padding:0.8rem 1.2rem;
        animation:slideUp 0.55s 0.28s both;
    }
    .dark .pagination-wrap { background:rgba(15,23,42,0.4); border-color:rgba(51,65,85,0.4); }

    @media(max-width:640px) {
        .page-header { flex-direction:column; align-items:flex-start; }
        .header-title { font-size:1.5rem; }
        td,th { padding:0.8rem 0.9rem; }
        .stats-row { grid-template-columns:1fr; }
    }
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="customers-page" dir="rtl">
<div class="page-wrap">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 class="header-title">العملاء المديونين</h1>
                <p class="header-sub">متابعة ومتابعة ديون السوق المستحقة</p>
            </div>
        </div>
        <div class="status-badge">
            <span class="status-dot"></span>
            يتطلب إجراءً
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card stat-rose">
            <div class="stat-label">إجمالي ديون السوق</div>
            <div class="stat-value">
                {{ number_format($totalMarketDebt, 2) }}
                <span class="stat-unit">د.ج</span>
            </div>
            <div class="stat-footer">
                <i class="fas fa-exclamation-triangle"></i>
                أولوية عالية
            </div>
        </div>
        <div class="stat-card stat-amber">
            <div class="stat-label">العملاء المديونين</div>
            <div class="stat-value">
                {{ $debtorCustomersCount }}
                <span class="stat-unit">عميل</span>
            </div>
            <div class="stat-footer">
                <i class="fas fa-users"></i>
                مديونين نشطين
            </div>
        </div>
        <div class="stat-card stat-blue">
            <div class="stat-label">متوسط الدين للعميل</div>
            <div class="stat-value">
                {{ number_format($averageDebtPerCustomer, 2) }}
                <span class="stat-unit">د.ج</span>
            </div>
            <div class="stat-footer">
                <i class="fas fa-calculator"></i>
                النسبة المحسوبة
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-overflow">
            <table>
                <thead>
                    <tr>
                        <th>اسم العميل</th>
                        <th>معلومات الاتصال</th>
                        <th style="text-align:center;">الفواتير المتأخرة</th>
                        <th style="text-align:center;">المبلغ المستحق</th>
                        <th style="text-align:center;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($debtorCustomers as $customer)
                    <tr>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">{{ mb_substr($customer->name, 0, 1) }}</div>
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                    <div class="customer-address">{{ $customer->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="phone-text">
                                <i class="fas fa-phone-alt"></i>
                                {{ $customer->phone }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <span class="invoices-badge">
                                {{ $customer->pending_invoices }} فاتورة
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <span class="debt-amount">
                                {{ number_format($customer->total_debt, 2) }}
                                <span class="debt-unit">د.ج</span>
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <div class="actions-wrap">
                                <a href="{{ route('customers.history', $customer->id) }}" class="btn-action">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    كشف الحساب
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="empty-title">سجل نظيف!</p>
                                <p class="empty-sub">لا توجد ديون مستحقة في الوقت الحالي</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if(method_exists($debtorCustomers, 'hasPages') && $debtorCustomers->hasPages())
    <div class="pagination-wrap">{{ $debtorCustomers->links() }}</div>
    @endif

</div>
</div>

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