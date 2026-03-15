@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alerts</h2>
            <p class="text-muted">Products with 10 units or less remaining in stock.</p>
        </div>
        <button onclick="window.print()" class="btn btn-outline-dark">
            <i class="fas fa-print me-2"></i>Print Report
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Product Details</th>
                            <th class="py-3">Warehouse</th>
                            <th class="py-3">Unit Price</th>
                            <th class="py-3 text-center">Current Stock</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->product->name }}</div>
                                <small class="text-muted">Barcode: {{ $item->product->barcode }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary-soft text-dark border">
                                    <i class="fas fa-warehouse me-1 text-primary"></i> {{ $item->warehouse->name }}
                                </span>
                            </td>
                            <td>${{ number_format($item->product->selling_price, 2) }}</td>
                            <td class="text-center">
                                <span class="fw-bold fs-5 {{ $item->quantity <= 5 ? 'text-danger' : 'text-warning' }}">
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            <td>
                                @if($item->quantity == 0)
                                    <span class="badge bg-danger px-3 py-2">Out of Stock</span>
                                @elseif($item->quantity <= 5)
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2">Critical</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2">Low Stock</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <p>All products are well-stocked. No alerts at the moment.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-secondary-soft { background-color: #f8fafc; }
    .table thead th { font-size: 0.8rem; color: #64748b; }
</style>
@endsection