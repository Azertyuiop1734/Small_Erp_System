@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><i class="fas fa-user-clock text-primary"></i> Purchase History: {{ $customer->name }}</h4>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body text-center">
                    <p class="mb-1 small">Total Purchases</p>
                    <h3 class="mb-0">{{ number_format($stats['total_spent'], 2) }} DA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body text-center">
                    <p class="mb-1 small">Total Paid</p>
                    <h3 class="mb-0">{{ number_format($stats['total_paid'], 2) }} DA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger text-white">
                <div class="card-body text-center">
                    <p class="mb-1 small">Remaining Debt</p>
                    <h3 class="mb-0">{{ number_format($stats['total_debt'], 2) }} DA</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice No.</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="fw-bold">{{ $sale->invoice_number }}</td>
                            <td>{{ $sale->sale_date }}</td>
                            <td>{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="text-success">{{ number_format($sale->paid_amount, 2) }}</td>
                            <td class="text-danger fw-bold">{{ number_format($sale->remaining_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $sale->status == 'paid' ? 'success' : 'warning' }}">
                                    {{ $sale->status == 'paid' ? 'Paid' : 'Debt' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('sales.details', $sale->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i> View Items
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No purchase history found for this customer.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection