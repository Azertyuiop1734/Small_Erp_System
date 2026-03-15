@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: white;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <div class="bg-primary text-white rounded-3 p-2 me-3">
                        <i class="fas fa-file-alt fa-lg"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Submit Work Report</h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-secondary">REPORT TITLE</label>
                                <input type="text" name="title" class="form-control rounded-3 py-2" placeholder="e.g. Daily Progress, Maintenance Feedback" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">DATE</label>
                                <input type="date" name="report_date" class="form-control rounded-3 py-2" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">DETAILED DESCRIPTION</label>
                                <textarea name="description" rows="8" class="form-control rounded-3" placeholder="Write your report details here..." required></textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-light px-4 rounded-pill">Clear</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm fw-bold">
                                <i class="fas fa-paper-plane me-2"></i>Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert for feedback --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#0d6efd',
            confirmButtonText: 'Great'
        });
    @endif
</script>
@endsection