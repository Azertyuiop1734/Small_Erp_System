@extends('layouts.app')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-file-invoice-dollar me-2 text-primary"></i> All Sales Invoices</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Seller Name</th>
                        <th>Total</th>
                        <th>Paid Amount</th>
                        <th>Status / Remaining</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <form action="{{ route('sales.updatePayment', $sale->id) }}" method="POST">
                            @csrf
                            <td class="fw-bold text-muted">#{{ $sale->id }}</td>
                            <td>{{ $sale->user->name }}</td>
                            <td class="fw-bold text-dark">{{ number_format($sale->total_amount, 2) }} DA</td>
                            
                            <td style="width: 200px;">
                                <div class="input-group input-group-sm shadow-sm">
                                    <input type="number" step="0.01" name="paid_amount" 
                                           class="form-control border-primary-subtle" 
                                           value="{{ $sale->paid_amount }}" required>
                                    <button type="submit" class="btn btn-primary" title="Update Payment">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="fw-bold">
                                {{-- الشرط المطلوب هنا --}}
                                @if($sale->remaining_amount <= 0)
                                    <span class="badge bg-success rounded-pill px-3 shadow-sm">
                                        <i class="fas fa-check-circle me-1"></i> Paid
                                    </span>
                                @else
                                    <span class="text-danger">
                                        {{ number_format($sale->remaining_amount, 2) }} DA
                                    </span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection