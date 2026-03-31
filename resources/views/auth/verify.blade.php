@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow text-center">
                <div class="card-header bg-warning text-dark">التحقق من الرمز</div>
                <div class="card-body">
                    <p>تم إرسال رمز التحقق إلى: <strong>{{ $email }}</strong></p>
                    
                    <form action="{{ route('otp.verify.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        
                        <div class="mb-3">
                            <input type="text" name="otp" maxlength="6" class="form-control text-center fs-4 @error('otp') is-invalid @enderror" placeholder="000000" required>
                            @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div id="timer-container" class="mb-3">
                            <span class="text-muted">تنتهي صلاحية الرمز خلال: </span>
                            <span id="timer" class="fw-bold text-danger">01:00</span>
                        </div>

                        <button type="submit" id="verifyBtn" class="btn btn-success w-100">تحقق الآن</button>
                    </form>

                    <form id="resend-form" action="{{ route('otp.send') }}" method="POST" class="mt-3" style="display: none;">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <p class="small text-muted">لم يصلك الرمز؟</p>
                        <button type="submit" class="btn btn-link">إعادة إرسال الرمز</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let seconds = 60;
    const timerDisplay = document.getElementById('timer');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendForm = document.getElementById('resend-form');

    const countdown = setInterval(() => {
        seconds--;
        let min = Math.floor(seconds / 60);
        let sec = seconds % 60;
        timerDisplay.innerText = `${min < 10 ? '0' : ''}${min}:${sec < 10 ? '0' : ''}${sec}`;

        if (seconds <= 0) {
            clearInterval(countdown);
            verifyBtn.disabled = true; // تعطيل زر التحقق
            resendForm.style.display = 'block'; // إظهار خيار إعادة الإرسال
            timerDisplay.innerText = "انتهت الصلاحية";
        }
    }, 1000);
</script>
@endsection