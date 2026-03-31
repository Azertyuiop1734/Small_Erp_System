@extends('layouts.app') @section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">استعادة كلمة المرور</div>
                <div class="card-body">
                    <p class="text-muted">أدخل بريدك الإلكتروني لنرسل لك رمز التحقق (OTP).</p>
                    <form action="{{ route('otp.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">إرسال الرمز</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection