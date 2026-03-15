@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-dark: #0f172a;
        --accent-blue: #3b82f6;
    }
    .main-container { background-color: #f1f5f9; min-height: 100vh; padding: 2rem 0; }
    .customer-card { border: none; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); overflow: hidden; }
    .card-header-custom { background: white; border-bottom: 1px solid #e2e8f0; padding: 1.5rem; }
    .table thead th { 
        background-color: #f8fafc; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 0.05em; 
        color: #64748b; 
        border-top: none;
    }
    .avatar-circle {
        width: 38px; height: 38px; 
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600; font-size: 0.9rem;
    }
    .badge-discount { background-color: #dcfce7; color: #166534; font-weight: 600; padding: 0.5em 1em; border-radius: 6px; }
    .btn-action { border-radius: 8px; width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; }
</style>

<div class="main-container">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Customer Management</h2>
                <p class="text-muted mb-0">Overview of all registered clients and their details.</p>
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                <i class="fas fa-plus-circle me-2"></i>New Customer
            </a>
        </div>

        <div class="card customer-card">
            <div class="card-header-custom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2 text-primary"></i>Customer List</h5>
                <span class="badge bg-light text-dark border">{{ $customers->count() }} Total</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Client Name</th>
                                <th>Contact Info</th>
                                <th>Discount</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                            <small class="text-muted">UID: #{{ $customer->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark small"><i class="fas fa-phone me-2 text-muted"></i>{{ $customer->phone ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    <span class="badge-discount small">
                                        {{ $customer->discount }}% OFF
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('customers.history', $customer->id) }}" class="btn btn-action btn-outline-primary" title="History">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-action btn-outline-warning mx-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                  
                                </td>
                                <td class="text-end pe-4">
    <button type="button" class="btn btn-action btn-outline-danger delete-btn" data-id="{{ $customer->id }}">
        <i class="fas fa-trash"></i>
    </button>

    <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('update_success'))
        Swal.fire({
            title: 'Updated!',
            text: "{{ session('update_success') }}",
            icon: 'success',
            confirmButtonColor: '#3085d6'
        });
    @elseif(session('success'))
        Swal.fire({
            title: 'Created!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const customerId = this.getAttribute('data-id');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Danger Red
                cancelButtonColor: '#64748b',  // Muted Grey
                confirmButtonText: 'Yes, delete it!',
                background: '#ffffff',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the hidden form
                    document.getElementById('delete-form-' + customerId).submit();
                }
            });
        });
    });

    // Show success message after deletion
    @if(session('success'))
        Swal.fire({
            title: 'Deleted!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>
@endsection