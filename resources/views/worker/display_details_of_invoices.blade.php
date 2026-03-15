@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-header bg-primary text-white py-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Invoice Details #{{ $sale->id }}</h4>
                <span>Date: {{ $sale->created_at->format('d/m/Y') }}</span>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row mb-5">
                <div class="col-md-6">
                    <h6 class="text-muted text-uppercase small fw-bold">Seller Information</h6>
                    <div class="p-3 bg-light rounded-3 mt-2">
                        <p class="mb-1 fw-bold text-dark"><i class="fas fa-user-tie me-2"></i> {{ $sale->user->name }}</p>
                        <p class="mb-0 text-muted small"><i class="fas fa-envelope me-2"></i> {{ $sale->user->email }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted text-uppercase small fw-bold">Warehouse / Location</h6>
                    <div class="p-3 bg-light rounded-3 mt-2">
                        <p class="mb-1 fw-bold text-dark"><i class="fas fa-warehouse me-2"></i> {{ $sale->warehouse->name ?? 'Main Store' }}</p>
                        <p class="mb-0 text-muted small"><i class="fas fa-map-marker-alt me-2"></i> {{ $sale->warehouse->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <h6 class="text-muted text-uppercase small fw-bold mb-3">Products Sold</h6>
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
               <tbody>
    {{-- نستخدم saleItems بدلاً من items --}}
    @foreach($sale->saleItems as $item)
    <tr>
        {{-- عرض اسم المنتج من العلاقة --}}
        <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
        
        <td class="text-center">{{ $item->quantity }}</td>
        
        {{-- تأكد من اسم عمود السعر في جدول sale_items (قد يكون price أو unit_price) --}}
        <td class="text-end">{{ number_format($item->price, 2) }} DA</td>
        
        <td class="text-end fw-bold">{{ number_format($item->quantity * $item->price, 2) }} DA</td>
    </tr>
    @endforeach
</tbody>
<tfoot>
    <tr class="table-borderless">
        <td colspan="3" class="text-end fs-5 fw-bold">Total Amount:</td>
        {{-- استخدم total_amount كما هو موجود في الـ fillable الخاص بك --}}
        <td class="text-end fs-5 fw-bold text-primary">{{ number_format($sale->total_amount, 2) }} DA</td>
    </tr>
</tfoot>
              
            </table>
        </div>
        
        <div class="card-footer bg-white py-3 text-center">
            <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">
                <i class="fas fa-print me-1"></i> Print Invoice
            </button>
            <a href="{{ route('sales.index') }}" class="btn btn-link text-muted">Back to List</a>
        </div>
    </div>
</div>
<style>
    @media print {
    /* إخفاء العناصر غير الضرورية مثل أزرار التنقل والرجوع */
    .btn, .navbar, footer {
        display: none !important;
    }

    /* ضبط عرض الصفحة ليتناسب مع ورق الطابعة الحرارية */
    body {
        width: 80mm; /* أو 58mm حسب نوع طابعتك */
        margin: 0;
        padding: 0;
        font-size: 12px;
    }

    .container {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection