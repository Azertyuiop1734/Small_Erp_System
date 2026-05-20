@extends('layouts.app')

@section('title', 'قائمة المنتجات والمخزون')
@section('page_icon_url', asset('imgs/browseproductsimg.png'))

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
            radial-gradient(ellipse 40% 40% at 55% 35%, rgba(245,158,11,0.06) 0%, transparent 55%);
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
    .orb-3 { width:160px; height:160px; background:rgba(245,158,11,0.06);  top:40%; right:8%;     animation-delay:-9s; }
    .dark .orb-1 { background:rgba(59,130,246,0.13); }
    .dark .orb-2 { background:rgba(16,185,129,0.13); }

    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1);} 50%{transform:translateY(-28px) scale(1.06);} }

    /* ===== LAYOUT ===== */
    .page-wrap { max-width:1240px; margin:0 auto; position:relative; z-index:1; }

    /* ===== STATS ===== */
    .stats-row {
        display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:1rem; margin-bottom:1.8rem;
        animation:slideUp 0.55s 0.08s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    .stat-card {
        background:rgba(255,255,255,0.55); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
        border:1px solid rgba(255,255,255,0.7); border-radius:1.3rem;
        padding:1.3rem 1.5rem; display:flex; align-items:center; gap:1rem;
        box-shadow:0 4px 18px rgba(0,0,0,0.05);
        transition:transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dark .stat-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.45); box-shadow:0 4px 18px rgba(0,0,0,0.22); }
    .stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(0,0,0,0.09); }
    .dark .stat-card:hover { box-shadow:0 8px 28px rgba(0,0,0,0.3); }

    .stat-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .stat-icon.blue   { background:rgba(59,130,246,0.11); color:#3b82f6; }
    .stat-icon.green  { background:rgba(16,185,129,0.11); color:#10b981; }
    .stat-icon.amber  { background:rgba(245,158,11,0.11); color:#f59e0b; }
    .stat-icon.rose   { background:rgba(244,63,94,0.11); color:#f43f5e; }

    .stat-val  { font-size:1.6rem; font-weight:900; color:#1e293b; line-height:1; }
    .dark .stat-val { color:#f1f5f9; }
    .stat-lbl  { font-size:0.78rem; color:#64748b; font-weight:600; margin-top:4px; }
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

    .table-header {
        padding:1.5rem 2rem;
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1rem;
        border-bottom:1px solid rgba(148,163,184,0.1);
        background:linear-gradient(135deg,rgba(59,130,246,0.04),rgba(37,99,235,0.02));
    }
    .dark .table-header { background:linear-gradient(135deg,rgba(59,130,246,0.06),rgba(37,99,235,0.04)); }

    .table-title { font-size:1.1rem; font-weight:900; color:#1e293b; }
    .dark .table-title { color:#f1f5f9; }
    .table-sub { font-size:0.82rem; color:#64748b; margin-top:3px; }
    .dark .table-sub { color:#94a3b8; }

    .btn-add {
        display:inline-flex; align-items:center; gap:0.55rem;
        padding:0.75rem 1.6rem;
        background:linear-gradient(135deg,#3b82f6 0%,#2563eb 100%);
        color:#fff; border-radius:14px; font-weight:800; font-size:0.9rem;
        text-decoration:none;
        box-shadow:0 6px 22px rgba(59,130,246,0.32);
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        border:1px solid rgba(255,255,255,0.18);
        position:relative; overflow:hidden; flex-shrink:0;
    }
    .btn-add::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); transition:left 0.5s; }
    .btn-add:hover::before { left:150%; }
    .btn-add:hover { transform:translateY(-2px) scale(1.03); box-shadow:0 10px 30px rgba(59,130,246,0.45); }
    .btn-add:active { transform:scale(0.97); }

    .table-overflow { overflow-x:auto; }
    .table-overflow::-webkit-scrollbar { height:5px; }
    .table-overflow::-webkit-scrollbar-thumb { background:rgba(59,130,246,0.2); border-radius:10px; }

    table { width:100%; border-collapse:collapse; direction:rtl; }

    thead tr {
        background:linear-gradient(135deg,rgba(59,130,246,0.06) 0%,rgba(37,99,235,0.05) 100%);
        border-bottom:1px solid rgba(59,130,246,0.1);
    }
    .dark thead tr { background:linear-gradient(135deg,rgba(59,130,246,0.10),rgba(37,99,235,0.09)); border-bottom-color:rgba(51,65,85,0.45); }

    th { padding:1rem 1.5rem; font-size:0.70rem; font-weight:900; color:#3b82f6; text-transform:uppercase; letter-spacing:0.08em; white-space:nowrap; }
    .dark th { color:#60a5fa; }

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
    tbody tr:hover { background:rgba(59,130,246,0.03); }
    .dark tbody tr:hover { background:rgba(59,130,246,0.07); }

    td { padding:0.95rem 1.5rem; vertical-align:middle; }

    /* Product Cell */
    .product-cell { display:flex; align-items:center; gap:1rem; }
    .product-avatar {
        width:48px; height:48px; border-radius:14px;
        background:linear-gradient(135deg,#3b82f6,#4f46e5);
        display:flex; align-items:center; justify-content:center;
        color:#fff; flex-shrink:0;
        box-shadow:0 4px 12px rgba(59,130,246,0.28);
    }
    .product-avatar svg { width:22px; height:22px; }
    .product-name { font-weight:800; font-size:0.92rem; color:#1e293b; }
    .dark .product-name { color:#f1f5f9; }
    .product-id { font-size:0.7rem; color:#94a3b8; font-family:'Tajawal',monospace; margin-top:2px; }

    /* Warehouse Badge */
    .warehouse-badge {
        display:inline-flex; align-items:center; justify-content:center;
        padding:0.3rem 0.9rem; border-radius:8px;
        font-size:0.78rem; font-weight:800;
        background:rgba(100,116,139,0.08); color:#64748b;
    }
    .dark .warehouse-badge { background:rgba(100,116,139,0.15); color:#94a3b8; }

    /* Quantity */
    .quantity-val { font-weight:900; font-size:0.95rem; font-family:'Tajawal',monospace; }
    .quantity-normal { color:#1e293b; }
    .dark .quantity-normal { color:#f1f5f9; }
    .quantity-danger { color:#f43f5e; }

    /* Price */
    .price-val { font-weight:900; font-size:0.95rem; color:#3b82f6; font-family:'Tajawal',monospace; }
    .dark .price-val { color:#60a5fa; }
    .price-unit { font-size:0.75rem; font-weight:600; opacity:0.7; margin-right:2px; }

    /* Actions */
    .actions-wrap { display:flex; align-items:center; justify-content:flex-end; gap:0.4rem; opacity:0; transform:translateX(10px); transition:all 0.25s ease; }
    tr:hover .actions-wrap { opacity:1; transform:translateX(0); }

    .btn-action {
        width:38px; height:38px; border-radius:11px;
        display:flex; align-items:center; justify-content:center;
        font-size:0.85rem; border:1px solid rgba(148,163,184,0.15);
        background:rgba(255,255,255,0.7); cursor:pointer; text-decoration:none;
        transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
        backdrop-filter:blur(8px); position:relative; overflow:hidden;
    }
    .dark .btn-action { background:rgba(30,41,59,0.7); border-color:rgba(71,85,105,0.3); }
    .btn-action::after { content:''; position:absolute; inset:0; opacity:0; transition:opacity 0.2s; border-radius:inherit; }
    .btn-action:hover::after { opacity:1; }
    .btn-action:hover { transform:scale(1.12) translateY(-2px); }
    .btn-action:active { transform:scale(0.95); }

    .btn-edit { color:#f59e0b; }
    .btn-edit::after  { background:rgba(245,158,11,0.13); }
    .btn-edit:hover   { border-color:rgba(245,158,11,0.38); box-shadow:0 4px 14px rgba(245,158,11,0.22); }

    .btn-del  { color:#f43f5e; }
    .btn-del::after   { background:rgba(244,63,94,0.10); }
    .btn-del:hover    { border-color:rgba(244,63,94,0.35); box-shadow:0 4px 14px rgba(244,63,94,0.2); }

    @media(max-width:640px) {
        .stats-row { grid-template-columns:1fr 1fr; }
        .table-header { flex-direction:column; align-items:flex-start; }
        .btn-add { align-self:stretch; justify-content:center; }
        td,th { padding:0.8rem 1rem; }
        .actions-wrap { opacity:1; transform:none; }
    }
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="products-page" dir="rtl">
<div class="page-wrap">

    {{-- STATS --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $stats['total_products'] }}</div>
                <div class="stat-lbl">إجمالي المنتجات</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $stats['warehouses'] }}</div>
                <div class="stat-lbl">المستودعات</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $stats['low_stock'] }}</div>
                <div class="stat-lbl">مخزون منخفض</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rose">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <div class="stat-val">{{ $stats['out_of_stock'] }}</div>
                <div class="stat-lbl">نفذت الكمية</div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="table-card">
        <div class="table-header">
            <div>
                <div class="table-title">جدول المنتجات</div>
                <div class="table-sub">يمكنك إدارة وتعديل كافة المنتجات المسجلة في النظام</div>
            </div>
            <a href="{{ route('products.create') }}" class="btn-add">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة منتج جديد
            </a>
        </div>

        <div class="table-overflow">
            <table>
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th style="text-align:center;">المستودع</th>
                        <th style="text-align:center;">الكمية</th>
                        <th style="text-align:center;">سعر البيع</th>
                        <th style="text-align:left;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            <div class="product-cell">
                                <div class="product-avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="product-name">{{ $product->name }}</div>
                                    <div class="product-id">#PRD-{{ $product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align:center;">
                            <span class="warehouse-badge">{{ $product->store->name ?? 'غير محدد' }}</span>
                        </td>
                        <td style="text-align:center;">
                            <span class="quantity-val {{ $product->quantity <= 5 ? 'quantity-danger' : 'quantity-normal' }}">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <span class="price-val">
                                {{ number_format($product->selling_price, 2) }}
                                <span class="price-unit">د.ج</span>
                            </span>
                        </td>
                        <td style="text-align:left;">
                            <div class="actions-wrap">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn-action btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('products.delete', $product->id) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-action btn-del btn-delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fireStyledAlert = (config) => {
            const isDark = document.documentElement.classList.contains('dark');
            return Swal.fire({
                ...config,
                background: isDark ? '#0f172a' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                confirmButtonColor: config.icon === 'warning' ? '#ef4444' : '#3b82f6',
                cancelButtonColor: isDark ? '#334155' : '#94a3b8',
                customClass: {
                    popup: 'rounded-[2.5rem] shadow-2xl border border-gray-100 dark:border-white/5 backdrop-blur-xl',
                    title: 'text-2xl font-black pt-4',
                    htmlContainer: 'text-right font-medium',
                    confirmButton: 'rounded-2xl px-8 py-3 font-bold mx-3 shadow-lg shadow-blue-500/20 transition-all hover:scale-105',
                    cancelButton: 'rounded-2xl px-8 py-3 font-bold mx-3 shadow-lg transition-all hover:scale-105'
                },
                buttonsStyling: false,
                showClass: { popup: 'animate__animated animate__zoomIn animate__faster' },
                hideClass: { popup: 'animate__animated animate__fadeOut animate__faster' }
            });
        };

        // Event Delegation for delete buttons
        document.body.addEventListener('click', function(e) {
            const button = e.target.closest('.btn-delete');
            if (button) {
                e.preventDefault();
                const form = button.closest('form');
                
                fireStyledAlert({
                    title: 'تأكيد الحذف',
                    text: "هل أنت متأكد من حذف هذا المنتج نهائياً؟",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم، احذف',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });

        @if(session('success'))
            fireStyledAlert({
                icon: 'success',
                title: 'تمت العملية بنجاح',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            });
        @endif
    });
</script>
@endpush