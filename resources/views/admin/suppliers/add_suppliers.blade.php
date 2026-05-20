@extends('layouts.app')

@section('title', 'إضافة مورد جديد')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

    /* ===== PAGE WRAPPER ===== */
    .supplier-page {
        min-height: 100vh;
        padding: 2.5rem 1rem;
        position: relative;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    /* Animated mesh background */
    .supplier-page::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 70% 50% at 15% 15%, rgba(37,99,235,0.10) 0%, transparent 60%),
            radial-gradient(ellipse 50% 60% at 85% 75%, rgba(99,102,241,0.09) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 40%, rgba(14,165,233,0.07) 0%, transparent 55%);
        pointer-events: none;
        z-index: 0;
    }
    .dark .supplier-page::before {
        background:
            radial-gradient(ellipse 70% 50% at 15% 15%, rgba(37,99,235,0.18) 0%, transparent 60%),
            radial-gradient(ellipse 50% 60% at 85% 75%, rgba(99,102,241,0.14) 0%, transparent 60%);
    }

    /* Floating orbs */
    .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        z-index: 0;
        animation: floatOrb 14s ease-in-out infinite;
    }
    .orb-a { width:280px; height:280px; background:rgba(37,99,235,0.07);  top:-60px; left:-60px;  animation-delay:0s; }
    .orb-b { width:200px; height:200px; background:rgba(99,102,241,0.08); bottom:15%; right:-40px; animation-delay:-6s; }
    .orb-c { width:160px; height:160px; background:rgba(14,165,233,0.06); top:45%; left:10%;     animation-delay:-11s; }
    .dark .orb-a { background:rgba(37,99,235,0.14); }
    .dark .orb-b { background:rgba(99,102,241,0.12); }

    @keyframes floatOrb {
        0%,100% { transform:translateY(0) scale(1); }
        50%      { transform:translateY(-28px) scale(1.06); }
    }

    /* ===== CARD ===== */
    .form-card {
        width: 100%;
        max-width: 820px;
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,0.55);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.7);
        border-radius: 2.2rem;
        box-shadow:
            0 4px 6px rgba(0,0,0,0.04),
            0 20px 60px rgba(0,0,0,0.08),
            0 1px 0 rgba(255,255,255,0.9) inset;
        overflow: hidden;
        animation: cardIn 0.65s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    .dark .form-card {
        background: rgba(15,23,42,0.60);
        border-color: rgba(51,65,85,0.45);
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
    }

    @keyframes cardIn {
        from { opacity:0; transform:translateY(30px) scale(0.97); }
        to   { opacity:1; transform:translateY(0)    scale(1); }
    }

    /* ===== CARD HEADER ===== */
    .card-header {
        padding: 2rem 2.2rem 1.8rem;
        background: linear-gradient(135deg,
            rgba(37,99,235,0.06) 0%,
            rgba(99,102,241,0.05) 60%,
            rgba(14,165,233,0.04) 100%);
        border-bottom: 1px solid rgba(148,163,184,0.10);
        display: flex;
        align-items: center;
        gap: 1.2rem;
        position: relative;
        overflow: hidden;
    }
    .dark .card-header {
        background: linear-gradient(135deg,
            rgba(37,99,235,0.12) 0%,
            rgba(99,102,241,0.10) 100%);
        border-bottom-color: rgba(51,65,85,0.4);
    }

    /* Decorative line */
    .card-header::after {
        content: '';
        position: absolute;
        bottom: 0; right: 0;
        width: 200px; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(37,99,235,0.3));
    }

    .header-icon {
        width: 58px; height: 58px;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 8px 24px rgba(37,99,235,0.35), 0 0 0 3px rgba(37,99,235,0.12);
        position: relative;
    }
    .header-icon::before {
        content: '';
        position: absolute; inset: 0;
        border-radius: inherit;
        background: linear-gradient(135deg, rgba(255,255,255,0.25), transparent);
    }
    .header-icon svg { color: #fff; width:26px; height:26px; position:relative; z-index:1; }

    .header-text-title {
        font-size: 1.35rem;
        font-weight: 900;
        color: #1e293b;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .dark .header-text-title { color: #f1f5f9; }

    .header-text-sub {
        font-size: 0.82rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }
    .dark .header-text-sub { color: #94a3b8; }

    /* Progress indicator */
    .header-steps {
        margin-right: auto;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .step-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: rgba(37,99,235,0.15);
    }
    .step-dot.active {
        background: #2563EB;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        width: 22px;
        border-radius: 4px;
    }

    /* ===== FORM BODY ===== */
    .form-body {
        padding: 2rem 2.2rem 2.2rem;
        direction: rtl;
    }

    .fields-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.4rem;
    }

    .field-full { grid-column: 1 / -1; }

    /* ===== FIELD GROUP ===== */
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        animation: fieldIn 0.5s ease both;
    }

    @keyframes fieldIn {
        from { opacity:0; transform:translateY(12px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .field-group:nth-child(1) { animation-delay:0.08s; }
    .field-group:nth-child(2) { animation-delay:0.13s; }
    .field-group:nth-child(3) { animation-delay:0.18s; }
    .field-group:nth-child(4) { animation-delay:0.23s; }
    .field-group:nth-child(5) { animation-delay:0.28s; }

    .field-label {
        font-size: 0.8rem;
        font-weight: 800;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .dark .field-label { color: #cbd5e1; }

    .field-label .label-icon {
        width: 22px; height: 22px;
        border-radius: 7px;
        background: rgba(37,99,235,0.08);
        display: flex; align-items:center; justify-content:center;
        color: #2563EB;
        font-size: 0.65rem;
        flex-shrink: 0;
    }
    .dark .field-label .label-icon { background: rgba(37,99,235,0.15); }

    .required-star {
        color: #EF4444;
        font-size: 0.85rem;
        line-height: 1;
    }

    /* ===== INPUTS ===== */
    .field-input,
    .field-textarea {
        width: 100%;
        background: rgba(255,255,255,0.65);
        border: 1.5px solid rgba(203,213,225,0.6);
        border-radius: 14px;
        padding: 0.8rem 1rem;
        font-size: 0.92rem;
        font-family: 'Cairo', sans-serif;
        color: #1e293b;
        transition: all 0.25s ease;
        outline: none;
        direction: rtl;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    .dark .field-input,
    .dark .field-textarea {
        background: rgba(30,41,59,0.6);
        border-color: rgba(71,85,105,0.45);
        color: #f1f5f9;
    }

    .field-input::placeholder,
    .field-textarea::placeholder { color: #94a3b8; }

    .field-input:hover,
    .field-textarea:hover {
        border-color: rgba(37,99,235,0.3);
        background: rgba(255,255,255,0.8);
    }
    .dark .field-input:hover,
    .dark .field-textarea:hover {
        border-color: rgba(37,99,235,0.4);
        background: rgba(30,41,59,0.8);
    }

    .field-input:focus,
    .field-textarea:focus {
        border-color: rgba(37,99,235,0.55);
        background: rgba(255,255,255,0.95);
        box-shadow:
            0 0 0 3px rgba(37,99,235,0.10),
            0 4px 20px rgba(37,99,235,0.08);
    }
    .dark .field-input:focus,
    .dark .field-textarea:focus {
        background: rgba(15,23,42,0.9);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.18);
    }

    /* phone LTR */
    .field-input[type="text"][name="phone"] { direction: ltr; text-align: right; }

    /* number */
    .field-input[type="number"] { direction: ltr; text-align: right; }

    .field-textarea { resize: vertical; min-height: 100px; }

    /* Input wrapper for icon */
    .input-wrap {
        position: relative;
    }
    .input-wrap .input-side-icon {
        position: absolute;
        right: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.8rem;
        pointer-events: none;
        transition: color 0.2s;
    }
    .input-wrap .field-input { padding-right: 2.4rem; }
    .input-wrap:focus-within .input-side-icon { color: #2563EB; }

    .input-suffix {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        background: rgba(148,163,184,0.12);
        padding: 2px 8px;
        border-radius: 6px;
        pointer-events: none;
    }
    .dark .input-suffix { color: #94a3b8; background: rgba(71,85,105,0.3); }
    .input-wrap .field-input[type="number"] { padding-left: 4rem; }

    /* ===== DIVIDER ===== */
    .form-divider {
        margin: 1.8rem 0 0;
        padding-top: 1.8rem;
        border-top: 1px solid rgba(148,163,184,0.12);
    }
    .dark .form-divider { border-top-color: rgba(51,65,85,0.4); }

    /* ===== BUTTONS ===== */
    .btn-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-submit {
        flex: 1;
        min-width: 160px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        padding: 0.85rem 1.6rem;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 800;
        font-family: 'Cairo', sans-serif;
        cursor: pointer;
        box-shadow: 0 6px 24px rgba(37,99,235,0.35);
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        position: relative;
        overflow: hidden;
    }
    .btn-submit::before {
        content:'';
        position:absolute;
        top:0; left:-100%;
        width:55%; height:100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
        transition: left 0.5s ease;
    }
    .btn-submit:hover::before { left:150%; }
    .btn-submit:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 30px rgba(37,99,235,0.5);
    }
    .btn-submit:active { transform: scale(0.97); }

    .btn-cancel {
        flex: 1;
        min-width: 140px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.4rem;
        background: rgba(248,250,252,0.7);
        color: #475569;
        border: 1.5px solid rgba(203,213,225,0.6);
        border-radius: 14px;
        font-size: 0.92rem;
        font-weight: 700;
        font-family: 'Cairo', sans-serif;
        text-decoration: none;
        cursor: pointer;
        backdrop-filter: blur(8px);
        transition: all 0.22s ease;
    }
    .dark .btn-cancel {
        background: rgba(30,41,59,0.6);
        color: #94a3b8;
        border-color: rgba(71,85,105,0.4);
    }
    .btn-cancel:hover {
        background: rgba(239,68,68,0.06);
        border-color: rgba(239,68,68,0.3);
        color: #EF4444;
        transform: translateY(-1px);
    }
    .dark .btn-cancel:hover { background: rgba(239,68,68,0.1); }

    /* ===== VALIDATION ERRORS ===== */
    .field-error {
        font-size: 0.75rem;
        color: #EF4444;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }
    .field-input.is-invalid { border-color: rgba(239,68,68,0.5) !important; }
    .field-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.12) !important; }

    /* ===== RESPONSIVE ===== */
    @media (max-width:640px) {
        .fields-grid { grid-template-columns: 1fr; }
        .field-full { grid-column: 1; }
        .form-body { padding: 1.4rem 1.2rem 1.6rem; }
        .card-header { padding: 1.5rem 1.2rem; }
        .btn-row { flex-direction: column; }
        .header-steps { display: none; }
    }
</style>

{{-- Orbs --}}
<div class="orb orb-a"></div>
<div class="orb orb-b"></div>
<div class="orb orb-c"></div>

<div class="supplier-page" dir="rtl">
<div class="form-card">

    {{-- HEADER --}}
    <div class="card-header">
        <div class="header-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        </div>
        <div>
            <div class="header-text-title">إضافة مورد جديد</div>
            <div class="header-text-sub">يرجى ملء كافة الحقول المطلوبة لإضافة مورد للنظام</div>
        </div>
        <div class="header-steps">
            <div class="step-dot active"></div>
            <div class="step-dot"></div>
            <div class="step-dot"></div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="form-body">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="fields-grid">

                {{-- اسم المورد --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="label-icon"><i class="fas fa-user"></i></span>
                        اسم المورد
                        <span class="required-star">*</span>
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-id-card input-side-icon"></i>
                        <input type="text" name="name" required
                               class="field-input @error('name') is-invalid @enderror"
                               placeholder="أدخل الاسم الكامل"
                               value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- اسم الشركة --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="label-icon"><i class="fas fa-building"></i></span>
                        اسم الشركة
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-briefcase input-side-icon"></i>
                        <input type="text" name="company_name"
                               class="field-input @error('company_name') is-invalid @enderror"
                               placeholder="شركة التوريد المحدودة"
                               value="{{ old('company_name') }}">
                    </div>
                    @error('company_name')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- رقم الهاتف --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="label-icon"><i class="fas fa-phone"></i></span>
                        رقم الهاتف
                    </label>
                    <div class="input-wrap">
                        <i class="fas fa-phone-alt input-side-icon"></i>
                        <input type="text" name="phone"
                               class="field-input @error('phone') is-invalid @enderror"
                               placeholder="0XXXXXXXXX"
                               value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- الرصيد الافتتاحي --}}
                <div class="field-group">
                    <label class="field-label">
                        <span class="label-icon"><i class="fas fa-coins"></i></span>
                        الرصيد الافتتاحي
                    </label>
                    <div class="input-wrap" style="position:relative;">
                        <i class="fas fa-wallet input-side-icon"></i>
                        <input type="number" step="0.01" name="balance"
                               class="field-input @error('balance') is-invalid @enderror"
                               value="{{ old('balance', 0) }}"
                               style="padding-right:2.4rem; padding-left:4.5rem;">
                        <span class="input-suffix">دينار</span>
                    </div>
                    @error('balance')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- العنوان --}}
                <div class="field-group field-full">
                    <label class="field-label">
                        <span class="label-icon"><i class="fas fa-map-marker-alt"></i></span>
                        العنوان بالتفصيل
                    </label>
                    <textarea name="address" rows="3"
                              class="field-textarea @error('address') is-invalid @enderror"
                              placeholder="المدينة، الشارع، المعالم القريبة...">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

            </div>{{-- end grid --}}

            {{-- ACTIONS --}}
            <div class="form-divider">
                <div class="btn-row">
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        حفظ بيانات المورد
                    </button>
                    <a href="{{ url()->previous() }}" class="btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        إلغاء العملية
                    </a>
                </div>
            </div>

        </form>
    </div>

</div>
</div>

@endsection

<script>
    function showAlert(icon, title, text, html = null) {
        // فحص الوضع في لحظة الضغط
        const isDark = document.documentElement.classList.contains('dark');

        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            html: html,
            confirmButtonText: 'حسناً',
            
            // إزالة الألوان الافتراضية للمكتبة تماماً
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            
            // تخصيص الكلاسات لتكون متطابقة مع تصميمك
            customClass: {
                popup: isDark 
                    ? 'rounded-[2rem] border border-white/10 shadow-2xl ring-1 ring-white/5' 
                    : 'rounded-[2rem] border border-gray-200 shadow-xl',
                title: 'font-black text-2xl pt-4',
                confirmButton: 'rounded-xl px-10 py-3 font-bold text-lg transition-transform hover:scale-105 active:scale-95'
            },

            // ضبط لون زر التأكيد
            confirmButtonColor: icon === 'error' ? '#ef4444' : '#3b82f6',
            
            // تحسينات تقنية لمنع التشويه
            buttonsStyling: true,
            heightAuto: false, // يمنع القفز المفاجئ للصفحة عند ظهور التنبيه
            
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            }
        });
    }

    // الانتظار لضمان أن DOM جاهز
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('success'))
            showAlert('success', 'تمت العملية!', "{{ session('success') }}");
        @endif
        @if(session('error'))
            showAlert('error', 'حدث خطأ!', "{{ session('error') }}");
        @endif
        @if($errors->any())
            showAlert('error', 'خطأ في البيانات!', null, '<div class="text-right text-sm leading-loose">{!! implode("<br>", $errors->all()) !!}</div>');
        @endif
    });
</script>