@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="fas fa-user-clock text-danger me-2"></i> Debtors & Late Payers</h3>

    {{-- بطاقات الإحصائيات --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-danger border-5">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase">Total Outstanding Debt</h6>
                    <h2 class="fw-bold text-danger">{{ number_format($totalMarketDebt, 2) }} DA</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-warning border-5">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase">Debtor Customers</h6>
                    <h2 class="fw-bold text-warning">{{ $debtorCustomersCount }} Customers</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm border-start border-primary border-5">
                <div class="card-body">
                    <h6 class="text-muted small text-uppercase">Avg. Debt per Customer</h6>
                    <h2 class="fw-bold text-primary">{{ number_format($averageDebtPerCustomer, 2) }} DA</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول العملاء المتأخرين --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-list text-muted me-2"></i> Debtors List</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th class="text-center">Pending Invoices</th>
                        <th class="text-end">Total Debt</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $customer->name }}</div>
                            <small class="text-muted">{{ $customer->address }}</small>
                        </td>
                        <td>{{ $customer->phone }}</td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark rounded-pill px-3">
                                {{ $customer->pending_invoices }} Invoices
                            </span>
                        </td>
                        <td class="text-end fw-bold text-danger">
                            {{ number_format($customer->total_debt, 2) }} DA
                        </td>
                        <td class="text-center">
                            <a href="{{ route('customers.history', $customer->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-eye me-1"></i> Statement
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <p>Great! There are no late payers at the moment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection