@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        @php
            /* المنطق البرمجي لتقسيم حقل details:
               يحول النص من "Age: 24; Gender: Female" إلى مصفوفة مرتبة
            */
            $detailsArray = [];
            if($user->details) {
                $parts = explode(';', $user->details);
                foreach($parts as $part) {
                    $item = explode(':', $part);
                    if(count($item) == 2) {
                        $detailsArray[trim($item[0])] = trim($item[1]);
                    }
                }
            }
        @endphp

        <div class="col-md-4 mb-4">
            <div class="card shadow border-0 text-center p-4 h-100 shadow-sm transition-hover">
                <div class="position-relative d-inline-block mb-3">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" class="rounded-circle shadow-sm border border-4 border-white" style="width: 160px; height: 160px; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/default-user.png') }}" class="rounded-circle shadow-sm border border-4 border-white" style="width: 160px; height: 160px;">
                    @endif
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-3" title="Active Account"></span>
                </div>
                
                <h3 class="fw-bold mb-1 text-dark">{{ $user->name }}</h3>
                <p class="text-primary fw-semibold mb-3">{{ $user->role->name ?? 'Employee' }}</p>
                
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge rounded-pill bg-{{ $user->status == 'active' ? 'success' : 'danger' }} px-4 py-2">
                        <i class="fas fa-check-circle small me-1"></i> {{ ucfirst($user->status) }}
                    </span>
                </div>

                <div class="border-top pt-4 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Warehouse:</span>
                        <span class="fw-bold small">{{ $user->warehouse->name ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Hire Date:</span>
                        <span class="fw-bold small">{{ $user->hire_date ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow border-0 h-100 shadow-sm">
                <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-id-card text-primary me-2"></i> EMPLOYEE INFORMATION
                    </h5>
                   <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
    <i class="fas fa-edit me-1"></i> Edit Profile
</a>
                </div>

                <div class="card-body px-4">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                <div class="icon-circle bg-white shadow-sm rounded p-3 me-3 text-primary">
                                    <i class="fas fa-envelope fa-lg"></i>
                                </div>
                                <div>
                                    <label class="text-muted small d-block mb-0">Email Address</label>
                                    <span class="fw-bold text-dark">{{ $user->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex align-items-center p-3 bg-light rounded-4">
                                <div class="icon-circle bg-white shadow-sm rounded p-3 me-3 text-success">
                                    <i class="fas fa-wallet fa-lg"></i>
                                </div>
                                <div>
                                    <label class="text-muted small d-block mb-0">Monthly Salary</label>
                                    <span class="fw-bold text-dark fs-5">{{ number_format($user->salary, 2) }} DA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-muted fw-bold mb-4 text-uppercase small"><i class="fas fa-th-large me-1"></i> Additional Details</h6>
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-3 text-center">
                            <div class="p-3 rounded-4 bg-light-soft border h-100">
                                <i class="fas fa-birthday-cake text-warning mb-2 fa-lg d-block"></i>
                                <small class="text-muted d-block">Age</small>
                                <span class="fw-bold text-dark">{{ $detailsArray['Age'] ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 text-center">
                            <div class="p-3 rounded-4 bg-light-soft border h-100">
                                <i class="fas fa-venus-mars text-info mb-2 fa-lg d-block"></i>
                                <small class="text-muted d-block">Gender</small>
                                <span class="fw-bold text-dark">{{ $detailsArray['Gender'] ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 text-center">
                            <div class="p-3 rounded-4 bg-light-soft border h-100">
                                <i class="fas fa-user-tag text-secondary mb-2 fa-lg d-block"></i>
                                <small class="text-muted d-block">Job</small>
                                <span class="fw-bold text-dark">{{ $detailsArray['Job'] ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3 text-center">
                            <div class="p-3 rounded-4 bg-light-soft border h-100">
                                <i class="fas fa-phone-alt text-success mb-2 fa-lg d-block"></i>
                                <small class="text-muted d-block">Phone</small>
                                <span class="fw-bold text-dark small">{{ $detailsArray['Phone'] ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 p-4 rounded-4 bg-light border-start border-4 border-primary">
                        <label class="fw-bold text-dark small d-block mb-1">About Employee</label>
                        <p class="text-muted mb-0">
                            This is a verified account for <strong>{{ $user->name }}</strong>, currently working at <strong>{{ $user->warehouse->name ?? 'Main Store' }}</strong>. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-soft { background-color: #f8fafc; }
    .rounded-4 { border-radius: 1rem !important; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .transition-hover:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .icon-circle {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endsection