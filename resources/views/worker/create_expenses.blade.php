@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-wallet me-2"></i>Add Company Expense</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">EXPENSE TITLE</label>
                                <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. Electricity Bill, Stationery" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">AMOUNT ($)</label>
                                <input type="number" step="0.01" name="amount" class="form-control rounded-3" placeholder="0.00" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">DATE</label>
                                <input type="date" name="expense_date" class="form-control rounded-3" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold text-muted">DESCRIPTION (OPTIONAL)</label>
                                <textarea name="description" rows="3" class="form-control rounded-3" placeholder="Provide more details..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('expenses.index') }}" class="btn btn-light px-4 rounded-pill">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm">
                                <i class="fas fa-check me-2"></i>Save Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection