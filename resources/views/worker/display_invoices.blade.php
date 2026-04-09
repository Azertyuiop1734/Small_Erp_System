@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> All Sales Invoices</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Seller Name</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td class="fw-bold">#{{ $sale->id }}</td>
                        <td>{{ $sale->user->name }}</td>
                        <td class="text-success fw-bold">{{ number_format($sale->total_amount, 2) }} DA</td>
                        <td class="text-muted small">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                <i class="fas fa-eye me-1"></i> Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection