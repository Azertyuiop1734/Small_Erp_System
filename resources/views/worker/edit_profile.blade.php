@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-user-edit me-2"></i> Edit My Profile</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('images/default-user.png') }}" class="rounded-circle img-thumbnail mb-2" style="width: 120px; height: 120px; object-fit: cover;">
                            <input type="file" name="image" class="form-control form-control-sm mt-2">
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number</label>
                                <input type="text" name="phone" class="form-control" placeholder="06XXXXXXXX">
                            </div>

                            @php
                                // استخراج القيم القديمة لعرضها في الـ Inputs
                                $detailsArray = [];
                                if($user->details) {
                                    $parts = explode(';', $user->details);
                                    foreach($parts as $part) {
                                        $item = explode(':', $part);
                                        if(count($item) == 2) $detailsArray[trim($item[0])] = trim($item[1]);
                                    }
                                }
                            @endphp

                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Age</label>
                                <input type="number" name="age" class="form-control" value="{{ $detailsArray['Age'] ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ ($detailsArray['Gender'] ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ ($detailsArray['Gender'] ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Job Title</label>
                                <input type="text" name="job" class="form-control" value="{{ $detailsArray['Job'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                            <a href="{{ route('profile') }}" class="btn btn-light rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection