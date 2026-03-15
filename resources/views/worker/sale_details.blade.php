@extends('layouts.app')

@section('content')
<div class="container py-4 main-invoice-container">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h4><i class="fas fa-file-invoice text-info me-2"></i> Invoice Details No: <span class="text-primary">{{ $sale->invoice_number }}</span></h4>
        <div class="actions">
            <button onclick="window.print()" class="btn btn-dark btn-sm me-2">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('customers.history', $sale->customer_id) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 invoice-card">
        <div class="card-body bg-light rounded print-bg-white">
            <div class="print-only text-center mb-3">
                <h4 class="fw-bold">INVOICE</h4>
                <p class="mb-0">#{{ $sale->invoice_number }}</p>
                <hr>
            </div>

            <div class="row g-3">
                <div class="col-md-3 col-12 print-full-width">
                    <p class="mb-1 text-muted small">Customer Name</p>
                    <p class="fw-bold text-dark mb-0">{{ $sale->customer->name ?? 'General Customer' }}</p>
                </div>
                <div class="col-md-3 col-6 print-full-width">
                    <p class="mb-1 text-muted small">Seller</p>
                    <p class="fw-bold text-primary mb-0 print-text-black">
                        {{ $sale->user->name ?? 'Not Defined' }}
                    </p>
                </div>
                <div class="col-md-3 col-6 print-full-width">
                    <p class="mb-1 text-muted small">Date</p>
                    <p class="mb-0 fw-bold">{{ $sale->sale_date }}</p>
                </div>
                <div class="col-md-3 text-md-end col-12 print-full-width">
                    <p class="mb-1 text-muted small no-print">Status</p>
                    <span class="badge bg-{{ $sale->status == 'paid' ? 'success' : 'warning' }} print-text-black print-badge-border">
                        {{ $sale->status == 'paid' ? 'Paid' : 'Debt' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white p-3 no-print">
            <h6 class="mb-0"><i class="fas fa-box-open me-2"></i> Sold Products List</h6>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 print-table">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50%">Item</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sale->saleItems as $item)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark print-small-text">
                                {{ $item->product->name ?? 'Deleted Product' }}
                            </div>
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end fw-bold">{{ number_format($item->quantity * $item->price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 offset-md-6 col-12">
            <div class="list-group shadow-sm print-no-shadow">
                <div class="list-group-item d-flex justify-content-between align-items-center border-bottom-dashed">
                    <span class="fw-bold">Total:</span>
                    <span class="fw-bold">{{ number_format($sale->total_amount, 2) }} DA</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Paid:</span>
                    <span class="text-success fw-bold print-text-black">{{ number_format($sale->paid_amount, 2) }} DA</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center bg-light print-bg-white">
                    <span class="fw-bold">Balance:</span>
                    <span class="text-danger fw-bold print-text-black">{{ number_format($sale->remaining_amount, 2) }} DA</span>
                </div>
            </div>
        </div>
    </div>

    <div class="print-only text-center mt-4">
        <p class="small">*** Thank You For Shopping ***</p>
    </div>
</div>

<style>
/* إخفاء عناصر الطباعة في الشاشة العادية */
.print-only { display: none; }

@media print {
    /* إخفاء عناصر Bootstrap غير الضرورية */
    .no-print, .btn, .navbar, footer, .card-header, .actions {
        display: none !important;
    }

    .print-only { display: block !important; }

    /* ضبط الصفحة الحرارية */
    @page {
        margin: 0;
        size: 80mm auto; /* التحديد التلقائي للطول حسب المحتوى */
    }

    body {
        background-color: white !important;
        color: black !important;
        width: 80mm;
        margin: 0;
        padding: 5mm;
        font-family: Arial, sans-serif;
    }

    .main-invoice-container {
        max-width: 100% !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* إلغاء نظام الأعمدة في الطباعة */
    .row { display: block !important; }
    .col-md-3, .col-md-6, .offset-md-6 { 
        width: 100% !important; 
        margin: 0 !important; 
        padding: 0 !important;
    }

    .card { border: none !important; }
    .print-bg-white { background-color: white !important; }
    .print-no-shadow { box-shadow: none !important; }

    /* تنسيق الجدول للحراري */
    .print-table {
        width: 100% !important;
        font-size: 11px !important;
        border-top: 1px dashed #000;
    }
    .print-table th, .print-table td {
        border-bottom: 1px dashed #000 !important;
        padding: 4px 0 !important;
        color: black !important;
    }

    .print-small-text { font-size: 11px !important; }
    .print-text-black { color: black !important; }
    
    .list-group-item {
        border: none !important;
        padding: 5px 0 !important;
        font-size: 12px;
    }
    .border-bottom-dashed {
        border-bottom: 1px dashed black !important;
    }
    
    /* منع الـ Badge من التلون بالخلفية */
    .badge {
        color: black !important;
        border: 1px solid black !important;
        background: transparent !important;
        padding: 2px 5px !important;
    }
}
</style>
@endsection