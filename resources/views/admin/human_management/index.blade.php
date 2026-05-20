@extends('layouts.app')

@section('title', 'إدارة الموظفين')

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
    .header-icon svg { color:#fff; width:26px; height:26px; position:relative; z-index:1; }
    .header-title { font-size:1.9rem; font-weight:900; color:#1e293b; letter-spacing:-0.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:0.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .header-sub { color:#94a3b8; }

    .btn-add {
        display:inline-flex; align-items:center; gap:0.55rem;
        padding:0.75rem 1.6rem;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; border-radius:14px; font-weight:800; font-size:0.92rem;
        text-decoration:none;
        box-shadow:0 6px 22px rgba(5,150,105,0.32);
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        border:1px solid rgba(255,255,255,0.18);
        position:relative; overflow:hidden; flex-shrink:0;
    }
    .btn-add::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); transition:left 0.5s; }
    .btn-add:hover::before { left:150%; }
    .btn-add:hover { transform:translateY(-2px) scale(1.03); box-shadow:0 10px 30px rgba(5,150,105,0.45); }
    .btn-add:active { transform:scale(0.97); }

    /* ===== STATS ===== */
    .stats-row {
        display:grid; grid-template-columns:repeat(auto-fit,minmax(170px,1fr));
        gap:1rem; margin-bottom:1.6rem;
        animation:slideUp 0.55s 0.08s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    .stat-card {
        background:rgba(255,255,255,0.55); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
        border:1px solid rgba(255,255,255,0.7); border-radius:1.3rem;
        padding:1.1rem 1.3rem; display:flex; align-items:center; gap:0.9rem;
        box-shadow:0 4px 18px rgba(0,0,0,0.05);
        transition:transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dark .stat-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.45); box-shadow:0 4px 18px rgba(0,0,0,0.22); }
    .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,0.09); }
    .dark .stat-card:hover { box-shadow:0 8px 28px rgba(0,0,0,0.3); }

    .stat-icon { width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .si-green  { background:rgba(5,150,105,0.11); color:#059669; }
    .si-blue   { background:rgba(37,99,235,0.10);  color:#2563EB; }
    .si-amber  { background:rgba(245,158,11,0.10); color:#F59E0B; }
    .si-purple { background:rgba(139,92,246,0.10); color:#8b5cf6; }

    .stat-val  { font-size:1.5rem; font-weight:900; color:#1e293b; line-height:1; }
    .dark .stat-val { color:#f1f5f9; }
    .stat-lbl  { font-size:0.76rem; color:#64748b; font-weight:600; margin-top:2px; }
    .dark .stat-lbl { color:#94a3b8; }

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
    .table-overflow::-webkit-scrollbar-thumb { background:rgba(5,150,105,0.2); border-radius:10px; }

    table { width:100%; border-collapse:collapse; direction:rtl; }

    thead tr {
        background:linear-gradient(135deg,rgba(5,150,105,0.06) 0%,rgba(37,99,235,0.05) 100%);
        border-bottom:1px solid rgba(5,150,105,0.1);
    }
    .dark thead tr { background:linear-gradient(135deg,rgba(5,150,105,0.10),rgba(37,99,235,0.09)); border-bottom-color:rgba(51,65,85,0.45); }

    th { padding:1rem 1.3rem; font-size:0.70rem; font-weight:900; color:#059669; text-transform:uppercase; letter-spacing:0.08em; white-space:nowrap; }
    .dark th { color:#34d399; }

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
    tbody tr:hover { background:rgba(5,150,105,0.03); }
    .dark tbody tr:hover { background:rgba(5,150,105,0.07); }

    td { padding:0.95rem 1.3rem; vertical-align:middle; }

    /* Worker Cell */
    .worker-cell { display:flex; align-items:center; gap:0.9rem; }
    .worker-avatar-wrap { position:relative; flex-shrink:0; }
    .worker-avatar {
        width:44px; height:44px; border-radius:14px; object-fit:cover;
        border:2px solid #fff; box-shadow:0 4px 12px rgba(0,0,0,0.1);
        transition:transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
    }
    tr:hover .worker-avatar { transform:scale(1.1); }
    .online-dot {
        position:absolute; bottom:-2px; left:-2px;
        width:14px; height:14px; background:#10b981;
        border:2.5px solid #fff; border-radius:50%;
    }
    .dark .online-dot { border-color:#0f172a; }

    .worker-name { font-weight:800; font-size:0.92rem; color:#1e293b; transition:color 0.2s; }
    .dark .worker-name { color:#f1f5f9; }
    tr:hover .worker-name { color:#059669; }
    .dark tr:hover .worker-name { color:#34d399; }
    .worker-email { font-size:0.72rem; color:#64748b; font-family:'Tajawal',monospace; margin-top:2px; }
    .dark .worker-email { color:#94a3b8; }

    /* Badge */
    .badge {
        display:inline-flex; align-items:center; gap:0.4rem;
        padding:0.35rem 0.9rem; border-radius:10px;
        font-size:0.78rem; font-weight:800; white-space:nowrap;
    }
    .badge-blue { background:rgba(37,99,235,0.08); color:#2563EB; border:1px solid rgba(37,99,235,0.15); }
    .dark .badge-blue { background:rgba(37,99,235,0.12); color:#60a5fa; }
    .badge-gray { background:rgba(100,116,139,0.06); color:#64748b; border:1px solid rgba(100,116,139,0.12); }
    .dark .badge-gray { background:rgba(100,116,139,0.1); color:#94a3b8; }

    /* Salary */
    .salary-val { font-size:1rem; font-weight:900; color:#059669; }
    .dark .salary-val { color:#34d399; }
    .salary-meta { font-size:0.7rem; color:#94a3b8; margin-top:3px; font-weight:600; }

    /* Actions */
    .actions-wrap { display:flex; align-items:center; justify-content:center; gap:0.4rem; }
    .btn-action {
        width:36px; height:36px; border-radius:11px;
        display:flex; align-items:center; justify-content:center;
        font-size:0.82rem; border:1px solid rgba(148,163,184,0.15);
        background:rgba(255,255,255,0.7); cursor:pointer; text-decoration:none;
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        backdrop-filter:blur(8px); position:relative; overflow:hidden;
    }
    .dark .btn-action { background:rgba(30,41,59,0.7); border-color:rgba(71,85,105,0.3); }
    .btn-action::after { content:''; position:absolute; inset:0; opacity:0; transition:opacity 0.2s; border-radius:inherit; }
    .btn-action:hover::after { opacity:1; }
    .btn-action:hover { transform:scale(1.12) translateY(-2px); }
    .btn-action:active { transform:scale(0.95); }

    .btn-purple { color:#8b5cf6; }
    .btn-purple::after { background:rgba(139,92,246,0.12); }
    .btn-purple:hover { border-color:rgba(139,92,246,0.35); box-shadow:0 4px 14px rgba(139,92,246,0.18); }

    .btn-edit { color:#F59E0B; }
    .btn-edit::after  { background:rgba(245,158,11,0.12); }
    .btn-edit:hover   { border-color:rgba(245,158,11,0.38); box-shadow:0 4px 14px rgba(245,158,11,0.2); }

    .btn-del  { color:#EF4444; }
    .btn-del::after   { background:rgba(239,68,68,0.10); }
    .btn-del:hover    { border-color:rgba(239,68,68,0.35); box-shadow:0 4px 14px rgba(239,68,68,0.18); }

    [data-tip] { position:relative; }
    [data-tip]::before {
        content:attr(data-tip); position:absolute;
        bottom:calc(100% + 7px); left:50%; transform:translateX(-50%) translateY(4px);
        background:#1e293b; color:#fff; font-size:0.68rem; font-weight:700;
        padding:3px 9px; border-radius:6px; white-space:nowrap;
        pointer-events:none; opacity:0; transition:opacity 0.2s, transform 0.2s;
    }
    [data-tip]:hover::before { opacity:1; transform:translateX(-50%) translateY(0); }

    /* Empty state */
    .empty-state { padding:4.5rem 2rem; text-align:center; }
    .empty-icon-wrap {
        width:80px; height:80px; border-radius:24px;
        background:linear-gradient(135deg,rgba(5,150,105,0.08),rgba(37,99,235,0.06));
        border:1px solid rgba(5,150,105,0.12);
        display:flex; align-items:center; justify-content:center;
        margin:0 auto 1.3rem;
    }
    .empty-icon-wrap svg { width:36px; height:36px; color:#94a3b8; }
    .empty-title { font-size:1.1rem; font-weight:900; color:#64748b; }
    .dark .empty-title { color:#475569; }
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
        .btn-add { align-self:stretch; justify-content:center; }
        .header-title { font-size:1.5rem; }
        td,th { padding:0.8rem 0.9rem; }
        .stats-row { grid-template-columns:1fr 1fr; }
    }
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="index-page" dir="rtl">
<div class="page-wrap">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="header-title">إدارة الموظفين</h1>
                <p class="header-sub">إدارة ومتابعة جميع الموظفين المسجلين في النظام</p>
            </div>
        </div>
        <a href="{{ route('users.create') }}" class="btn-add">
            <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            إضافة موظف جديد
        </a>
    </div>

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon si-green"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-val">{{ $workers->count() }}</div>
                <div class="stat-lbl">إجمالي الموظفين</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-blue"><i class="fas fa-warehouse"></i></div>
            <div>
                <div class="stat-val">{{ $workers->pluck('warehouse_id')->unique()->count() }}</div>
                <div class="stat-lbl">المستودعات النشطة</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-amber"><i class="fas fa-coins"></i></div>
            <div>
                <div class="stat-val">{{ number_format($workers->sum('salary'), 0) }}</div>
                <div class="stat-lbl">إجمالي الرواتب</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon si-purple"><i class="fas fa-user-check"></i></div>
            <div>
                <div class="stat-val">{{ $workers->where('status', 'active')->count() }}</div>
                <div class="stat-lbl">موظفين نشطين</div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-overflow">
            <table>
                <thead>
                    <tr>
                        <th>الموظف</th>
                        <th>المستودع</th>
                        <th>التفاصيل</th>
                        <th>البيانات المالية</th>
                        <th style="text-align:center;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workers as $worker)
                    <tr>
                        <td>
                            <div class="worker-cell">
                                <div class="worker-avatar-wrap">
                                    <img src="{{ $worker->image ? asset('storage/' . $worker->image) : 'https://ui-avatars.com/api/?name='.urlencode($worker->name).'&background=random' }}" 
                                         class="worker-avatar" alt="{{ $worker->name }}">
                                    <div class="online-dot"></div>
                                </div>
                                <div>
                                    <div class="worker-name">{{ $worker->name }}</div>
                                    <div class="worker-email">{{ $worker->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="badge badge-blue">
                                <i class="fas fa-warehouse" style="font-size:0.65rem;"></i>
                                {{ $worker->warehouse->name ?? 'غير محدد' }}
                            </span>
                        </td>

                        <td>
                            <div style="display:flex; flex-wrap:wrap; gap:0.35rem; max-width:220px;">
                                @php $detailsArray = explode(';', $worker->details); @endphp
                                @foreach($detailsArray as $detail)
                                    @if(trim($detail))
                                    <span class="badge badge-gray" style="font-size:0.7rem; padding:0.2rem 0.6rem;">{{ trim($detail) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </td>

                        <td>
                            <div class="salary-val">${{ number_format($worker->salary, 2) }}</div>
                            <div class="salary-meta">التعيين: {{ $worker->hire_date }}</div>
                        </td>

                        <td>
                            <div class="actions-wrap">
                                <a href="{{ route('users.sales', $worker->id) }}" class="btn-action btn-purple" data-tip="المبيعات">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                <a href="{{ route('users.edit', $worker->id) }}" class="btn-action btn-edit" data-tip="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy', $worker->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="btn-action btn-del" data-tip="حذف">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="empty-title">لا يوجد موظفين حالياً</p>
                                <p class="empty-sub">أضف أول موظف من زر "إضافة موظف جديد" أعلاه</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if(method_exists($workers, 'hasPages') && $workers->hasPages())
    <div class="pagination-wrap">{{ $workers->links() }}</div>
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

    function confirmDelete(button) {
        const form = button.closest('.delete-form');
        showStyledAlert({
            icon: 'warning',
            title: 'هل أنت متأكد؟',
            text: 'لن تتمكن من التراجع عن حذف هذا الموظف نهائياً!',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف الآن',
            cancelButtonText: 'تراجع'
        }).then((result) => {
            if (result.isConfirmed && form) {
                form.submit();
            }
        });
    }

    @if(session('success'))
        showStyledAlert({
            icon: 'success',
            title: 'تمت العملية!',
            text: "{{ session('success') }}"
        });
    @endif
</script>
@endpush