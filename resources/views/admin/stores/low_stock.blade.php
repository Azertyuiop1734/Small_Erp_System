@extends('layouts.app')

@section('content')
<style>
    /* التنسيق العام المتوافق مع تيم النظام */
    body { background-color: #0f172a; color: #94a3b8; }
    
    .glass-card { 
        background: rgba(30, 41, 59, 0.7); 
        border: 1px solid rgba(255, 255, 255, 0.05); 
        border-radius: 15px;
    }

    .gradient-header { 
        background: linear-gradient(90deg, #2563eb, #0891b2); 
        color: white !important;
    }

    /* تنسيق الجدول ليطابق صفحة المخازن */
    .table {
        border-collapse: separate;
        border-spacing: 0;
        background: transparent !important;
        color: #94a3b8 !important;
        width: 100% !important;
        border-radius: 12px;
        overflow: hidden;
    }

    /* الحواف الدائرية لرأس الجدول */
    .table thead tr th:first-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    .table thead tr th:last-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }

    .gradient-header th {
        background: transparent !important;
        border: none !important;
        padding: 12px;
        vertical-align: middle;
    }

    .table tbody td {
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        color: #cbd5e1 !important;
        vertical-align: middle;
        padding: 15px 10px;
    }

    .table-hover tbody tr:hover td {
        background: rgba(255, 255, 255, 0.03) !important;
        color: #fff !important;
    }

    /* تنسيق البادجات الخاصة بالحالات */
    .status-badge {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .badge-critical { background: rgba(220, 38, 38, 0.2); border: 1px solid #dc2626; color: #fca5a5; }
    .badge-low { background: rgba(245, 158, 11, 0.2); border: 1px solid #f59e0b; color: #fcd34d; }

    .btn-print {
        background: linear-gradient(90deg, #2563eb, #0891b2);
        border: none;
        color: white;
        transition: opacity 0.3s;
        padding: 12px 30px; 
        border-radius: 12px; 
        font-size: 1.1rem; 
        font-weight: bold;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .btn-print:hover { 
        opacity: 0.9;
        color: white;
        transform: translateY(-2px); 
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        color: white; 
        }
</style>
<div>
     <button onclick="window.print()" class="btn btn-print shadow-sm">
         <i class="fas fa-print me-2"></i> 
         <span>طباعة التقرير</span>
     </button>
</div>

<div class="container py-5" dir="rtl">
    <div class="glass-card p-4 shadow-lg">
        <div class="d-flex justify-content-between align-items-center mb-1" dir="ltr">
            <div class="text-end">
                <h2 class="text-white mr-0 fw-bold">
                    تنبيهات نقص المخزون
                    <i class="fas fa-exclamation-triangle text-warning text-yellow-400 ms-2"></i>
                </h2>
            </div>
        </div>
        

        <div class="text-end mb-4" dir="ltr">
            <p class="text-muted small">عرض المنتجات التي وصل رصيدها إلى 10 وحدات أو أقل</p>
        </div>

        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="gradient-header">
                    <tr>
                        <th><i class="fas fa-info-circle me-1"></i> الحالة</th>
                        <th><i class="fas fa-cubes me-1"></i> الكمية المتبقية</th>
                        <th><i class="fas fa-tag me-1"></i> سعر الوحدة</th>
                        <th><i class="fas fa-warehouse me-1"></i> المستودع</th>
                        <th><i class="fas fa-box-open me-1"></i> المنتج</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStockProducts as $item)
                    <tr>
                        <td>
                            @if($item->quantity == 0)
                                <span class="status-badge badge-critical">نفذ المخزون</span>
                            @elseif($item->quantity <= 5)
                                <span class="status-badge badge-critical">مستوى حرج</span>
                            @else
                                <span class="status-badge badge-low">مخزون منخفض</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold {{ $item->quantity <= 5 ? 'text-danger' : 'text-warning' }}">
                                {{ $item->quantity }}
                            </span>
                        </td>
                        <td>${{ number_format($item->product->selling_price, 2) }}</td>
                        <td>
                            <span class="opacity-75"><i class="fas fa-map-marker-alt fs-small me-1"></i> {{ $item->warehouse->name }}</span>
                        </td>
                        <td class="text-end">
                            <div class="fw-bold text-white">{{ $item->product->name }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">باركود: {{ $item->product->barcode }}</small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <div class="mb-3">
                                   <i class="fas fa-check-circle fa-3x mb-3 text-success opacity-50 d-block"></i>
                                </div>
                                <span class="text-white">المخزون مكتمل، لا توجد تنبيهات حالياً.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection