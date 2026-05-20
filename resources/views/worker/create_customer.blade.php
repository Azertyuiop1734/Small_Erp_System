@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    :root {
        --primary: #2563EB;
        --primary-light: #3B82F6;
        --primary-glow: rgba(37, 99, 235, 0.15);
        --accent: #6366F1;
        --danger: #EF4444;
        --amber: #F59E0B;
        --success: #10B981;
        --surface: rgba(255,255,255,0.6);
        --surface-dark: rgba(15,23,42,0.7);
        --border: rgba(255,255,255,0.5);
        --border-dark: rgba(51,65,85,0.5);
    }

    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BACKGROUND CANVAS ===== */
    .create-page {
        min-height: 100vh;
        padding: 2.5rem 1rem;
        position: relative;
        overflow-x: hidden;
    }

    .create-page::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%, rgba(37,99,235,0.12) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99,102,241,0.10) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 60% 30%, rgba(16,185,129,0.06) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }

    .dark .create-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%, rgba(37,99,235,0.18) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(99,102,241,0.15) 0%, transparent 60%);
    }

    /* Floating orbs */
    .orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(70px);
        pointer-events: none;
        z-index: 0;
        animation: floatOrb 12s ease-in-out infinite;
    }
    .orb-1 { width:320px; height:320px; background:rgba(37,99,235,0.08); top:-80px; right:-80px; animation-delay:0s; }
    .orb-2 { width:250px; height:250px; background:rgba(99,102,241,0.07); bottom:10%; left:-60px; animation-delay:-5s; }
    .orb-3 { width:180px; height:180px; background:rgba(16,185,129,0.06); top:50%; right:5%; animation-delay:-9s; }

    .dark .orb-1 { background:rgba(37,99,235,0.15); }
    .dark .orb-2 { background:rgba(99,102,241,0.12); }

    @keyframes floatOrb {
        0%,100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-30px) scale(1.05); }
    }

    /* ===== LAYOUT ===== */
    .page-container {
        max-width: 860px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    /* ===== HEADER ===== */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        animation: slideDown 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }

    @keyframes slideDown {
        from { opacity:0; transform:translateY(-20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    .header-brand { display:flex; align-items:center; gap:1.2rem; }

    .header-icon-wrap {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 8px 32px rgba(37,99,235,0.35), 0 0 0 3px rgba(37,99,235,0.15);
        position: relative;
        flex-shrink: 0;
    }
    .header-icon-wrap::after {
        content:'';
        position:absolute; inset:-3px;
        border-radius:23px;
        background: linear-gradient(135deg, rgba(255,255,255,0.3), transparent);
        pointer-events:none;
    }
    .header-icon-wrap i { color:#fff; font-size:1.6rem; position:relative; z-index:1; }

    .header-title {
        font-size: 2rem;
        font-weight: 900;
        color: #1e293b;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }
    .dark .header-title { color: #f1f5f9; }

    .header-subtitle {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-top: 4px;
    }
    .dark .header-subtitle { color: #94a3b8; }

    /* ===== BACK BUTTON ===== */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.65rem 1.3rem;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(12px);
        color: #64748b;
        border-radius: 1rem;
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.7);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        flex-shrink: 0;
    }
    .dark .btn-back {
        background: rgba(15,23,42,0.55);
        border-color: rgba(51,65,85,0.5);
        color: #94a3b8;
    }
    .btn-back:hover {
        color: #2563EB;
        border-color: rgba(37,99,235,0.35);
        box-shadow: 0 4px 20px rgba(37,99,235,0.12);
        transform: translateY(-2px);
    }
    .dark .btn-back:hover { color: #60a5fa; }
    .btn-back i { transition: transform 0.25s ease; }
    .btn-back:hover i { transform: translateX(3px); }

    /* ===== FORM CARD ===== */
    .form-card {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255,255,255,0.6);
        border-radius: 2rem;
        box-shadow: 0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.8) inset;
        overflow: hidden;
        animation: slideUp 0.6s 0.15s cubic-bezier(0.34,1.56,0.64,1) both;
        position: relative;
    }
    .dark .form-card {
        background: rgba(15,23,42,0.55);
        border-color: rgba(51,65,85,0.45);
        box-shadow: 0 8px 40px rgba(0,0,0,0.3);
    }

    /* Subtle glow blob inside card (dark mode) */
    .form-card::before {
        content: '';
        position: absolute;
        top: -80px; left: -80px;
        width: 260px; height: 260px;
        background: rgba(37,99,235,0.06);
        border-radius: 50%;
        filter: blur(80px);
        pointer-events: none;
        display: none;
    }
    .dark .form-card::before { display: block; }

    @keyframes slideUp {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }

    /* ===== FORM HEADER STRIP ===== */
    .form-strip {
        background: linear-gradient(135deg, rgba(37,99,235,0.06) 0%, rgba(99,102,241,0.06) 100%);
        border-bottom: 1px solid rgba(37,99,235,0.08);
        padding: 1.2rem 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .dark .form-strip {
        background: linear-gradient(135deg, rgba(37,99,235,0.10) 0%, rgba(99,102,241,0.10) 100%);
        border-bottom-color: rgba(51,65,85,0.4);
    }
    .form-strip-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #2563EB;
        box-shadow: 0 0 8px rgba(37,99,235,0.5);
    }
    .form-strip-label {
        font-size: 0.72rem;
        font-weight: 900;
        color: #2563EB;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .dark .form-strip-label { color: #60a5fa; }

    /* ===== FORM BODY ===== */
    .form-body {
        padding: 2.2rem 2.5rem;
        position: relative;
        z-index: 1;
    }

    /* ===== FIELD GROUPS ===== */
    .fields-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .field-full { grid-column: 1 / -1; }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        animation: slideUp 0.5s ease both;
    }
    .field-group:nth-child(1) { animation-delay: 0.05s; }
    .field-group:nth-child(2) { animation-delay: 0.10s; }
    .field-group:nth-child(3) { animation-delay: 0.15s; }
    .field-group:nth-child(4) { animation-delay: 0.20s; }
    .field-group:nth-child(5) { animation-delay: 0.25s; }

    .field-label {
        font-size: 0.72rem;
        font-weight: 900;
        color: #2563EB;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .dark .field-label { color: #60a5fa; }
    .field-label i { font-size: 0.65rem; opacity: 0.8; }

    /* ===== INPUTS ===== */
    .field-input-wrap { position: relative; }

    .field-input {
        width: 100%;
        padding: 0.9rem 1.2rem;
        background: rgba(255,255,255,0.6);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(148,163,184,0.25);
        border-radius: 1rem;
        font-size: 0.95rem;
        font-family: 'Cairo', sans-serif;
        font-weight: 600;
        color: #1e293b;
        outline: none;
        transition: all 0.25s ease;
        direction: rtl;
        box-sizing: border-box;
    }
    .dark .field-input {
        background: rgba(15,23,42,0.55);
        border-color: rgba(51,65,85,0.5);
        color: #f1f5f9;
    }
    .field-input::placeholder { color: #94a3b8; font-weight: 500; }
    .field-input:focus {
        border-color: rgba(37,99,235,0.5);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12), 0 4px 16px rgba(37,99,235,0.08);
        background: rgba(255,255,255,0.85);
    }
    .dark .field-input:focus {
        background: rgba(15,23,42,0.85);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
    }

    /* suffix badge (DA / %) */
    .field-suffix {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.72rem;
        font-weight: 800;
        color: #94a3b8;
        background: rgba(148,163,184,0.1);
        padding: 2px 8px;
        border-radius: 6px;
        letter-spacing: 0.05em;
        pointer-events: none;
    }
    .dark .field-suffix { background: rgba(71,85,105,0.3); color: #64748b; }

    .field-input.has-suffix { padding-left: 3.5rem; }

    textarea.field-input { resize: none; }

    /* ===== DIVIDER ===== */
    .form-divider {
        border: none;
        border-top: 1px solid rgba(148,163,184,0.12);
        margin: 0.5rem 0 1.8rem;
    }
    .dark .form-divider { border-color: rgba(51,65,85,0.35); }

    /* ===== FOOTER ACTIONS ===== */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .form-footer-note {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 600;
    }
    .form-footer-note i { color: #2563EB; font-size: 0.75rem; }

    /* ===== SUBMIT BUTTON ===== */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.85rem 2.2rem;
        background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
        color: #fff;
        border-radius: 1rem;
        font-weight: 800;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 6px 24px rgba(37,99,235,0.35);
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        font-family: 'Cairo', sans-serif;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }
    .btn-submit::before {
        content:'';
        position:absolute;
        top:0; left:-100%;
        width:60%; height:100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .btn-submit:hover::before { left:150%; }
    .btn-submit:hover {
        transform: translateY(-2px) scale(1.03);
        box-shadow: 0 10px 32px rgba(37,99,235,0.5);
    }
    .btn-submit:active { transform: scale(0.97); }
    .btn-submit i { transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1); }
    .btn-submit:hover i { transform: rotate(15deg) scale(1.15); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 640px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .btn-back { align-self: stretch; justify-content: center; }
        .fields-grid { grid-template-columns: 1fr; }
        .field-full { grid-column: auto; }
        .form-body { padding: 1.5rem 1.2rem; }
        .header-title { font-size: 1.6rem; }
        .form-footer { flex-direction: column; align-items: stretch; }
        .btn-submit { justify-content: center; }
    }
</style>

{{-- Floating orbs --}}
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="create-page" dir="rtl">
<div class="page-container">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-brand">
            <div class="header-icon-wrap">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h1 class="header-title">إضافة زبون جديد</h1>
                <p class="header-subtitle">قم بتوسيع قاعدة عملائك وإدارة بياناتهم بسهولة</p>
            </div>
        </div>
        <a href="{{ route('customers.index') }}" class="btn-back">
            <span>العودة للقائمة</span>
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="form-card">

        {{-- Strip header --}}
        <div class="form-strip">
            <div class="form-strip-dot"></div>
            <span class="form-strip-label">بيانات الزبون</span>
        </div>

        {{-- Form body --}}
        <div class="form-body">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="fields-grid">

                    {{-- اسم الزبون --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-user"></i>
                            اسم الزبون الكامل
                        </label>
                        <div class="field-input-wrap">
                            <input type="text" name="name" required
                                   class="field-input"
                                   placeholder="مثال: محمد أحمد علي"
                                   value="{{ old('name') }}">
                        </div>
                    </div>

                    {{-- رقم الهاتف --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-phone-alt"></i>
                            رقم الهاتف
                        </label>
                        <div class="field-input-wrap">
                            <input type="text" name="phone" required
                                   class="field-input"
                                   placeholder="0XXXXXXXXX"
                                   value="{{ old('phone') }}"
                                   dir="ltr" style="text-align:right;">
                        </div>
                    </div>

                    {{-- الرصيد الافتتاحي --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-wallet"></i>
                            الرصيد الافتتاحي
                        </label>
                        <div class="field-input-wrap">
                            <input type="number" name="balance"
                                   value="{{ old('balance', '0.00') }}"
                                   step="0.01"
                                   class="field-input has-suffix">
                            <span class="field-suffix">DA</span>
                        </div>
                    </div>

                    {{-- نسبة الخصم --}}
                    <div class="field-group">
                        <label class="field-label">
                            <i class="fas fa-percentage"></i>
                            نسبة الخصم الممنوحة
                        </label>
                        <div class="field-input-wrap">
                            <input type="number" name="discount"
                                   value="{{ old('discount', '0.00') }}"
                                   step="0.01"
                                   class="field-input has-suffix">
                            <span class="field-suffix">%</span>
                        </div>
                    </div>

                    {{-- العنوان --}}
                    <div class="field-group field-full">
                        <label class="field-label">
                            <i class="fas fa-map-marker-alt"></i>
                            العنوان بالتفصيل
                        </label>
                        <div class="field-input-wrap">
                            <textarea name="address" rows="3"
                                      class="field-input"
                                      placeholder="المدينة، الحي، الشارع...">{{ old('address') }}</textarea>
                        </div>
                    </div>

                </div>

                <hr class="form-divider">

                <div class="form-footer">
                    <p class="form-footer-note">
                        <i class="fas fa-shield-alt"></i>
                        بيانات الزبون محمية ومشفرة في النظام
                    </p>
                    <button type="submit" class="btn-submit">
                        <span>حفظ بيانات الزبون</span>
                        <i class="fas fa-save"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
</div>

{{-- ===== CUSTOM ALERT SYSTEM (no external library) ===== --}}
<style>
    /* ── Overlay ── */
    .ca-overlay {
        position: fixed; inset: 0; z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
        background: rgba(2, 10, 28, 0.45);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        opacity: 0; pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .ca-overlay.ca-show { opacity: 1; pointer-events: all; }

    /* ── Card ── */
    .ca-card {
        width: 100%; max-width: 400px;
        background: rgba(255,255,255,0.72);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid rgba(255,255,255,0.65);
        border-radius: 2rem;
        overflow: hidden;
        box-shadow:
            0 2px 0 rgba(255,255,255,0.9) inset,
            0 32px 64px rgba(0,0,0,0.16),
            0 8px 24px rgba(0,0,0,0.08);
        transform: scale(0.82) translateY(28px);
        opacity: 0;
        transition: transform 0.42s cubic-bezier(0.34,1.56,0.64,1),
                    opacity  0.28s ease;
        direction: rtl;
    }
    .dark .ca-card {
        background: rgba(10,17,34,0.82);
        border-color: rgba(51,65,85,0.55);
        box-shadow: 0 32px 64px rgba(0,0,0,0.5);
    }
    .ca-overlay.ca-show .ca-card {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    /* ── Accent bar on top ── */
    .ca-bar {
        height: 4px;
        width: 100%;
    }
    .ca-bar.success { background: linear-gradient(90deg,#10B981,#059669); }
    .ca-bar.error   { background: linear-gradient(90deg,#EF4444,#DC2626); }

    /* ── Body ── */
    .ca-body {
        padding: 2rem 2rem 1.6rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0;
    }

    /* ── Icon ring ── */
    .ca-icon-ring {
        width: 72px; height: 72px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1.25rem;
        position: relative;
        flex-shrink: 0;
    }
    .ca-icon-ring.success {
        background: radial-gradient(circle at 35% 35%, rgba(16,185,129,0.22), rgba(16,185,129,0.06));
        border: 1.5px solid rgba(16,185,129,0.3);
        box-shadow: 0 0 0 8px rgba(16,185,129,0.07);
    }
    .ca-icon-ring.error {
        background: radial-gradient(circle at 35% 35%, rgba(239,68,68,0.2), rgba(239,68,68,0.05));
        border: 1.5px solid rgba(239,68,68,0.28);
        box-shadow: 0 0 0 8px rgba(239,68,68,0.06);
    }

    /* SVG check / X drawn via stroke-dasharray animation */
    .ca-icon-ring svg { width: 34px; height: 34px; overflow: visible; }

    .ca-check-circle { stroke: #10B981; stroke-width: 2.5; fill: none; stroke-dasharray: 166; stroke-dashoffset: 166; }
    .ca-check-mark   { stroke: #10B981; stroke-width: 3;   fill: none; stroke-linecap: round; stroke-linejoin: round;
                       stroke-dasharray: 48; stroke-dashoffset: 48; }
    .ca-error-circle { stroke: #EF4444; stroke-width: 2.5; fill: none; stroke-dasharray: 166; stroke-dashoffset: 166; }
    .ca-error-x1, .ca-error-x2 { stroke: #EF4444; stroke-width: 3; stroke-linecap: round;
                                  stroke-dasharray: 30; stroke-dashoffset: 30; }

    .ca-overlay.ca-show .ca-check-circle { animation: caStroke 0.55s 0.15s cubic-bezier(0.65,0,0.45,1) forwards; }
    .ca-overlay.ca-show .ca-check-mark   { animation: caStroke 0.38s 0.55s cubic-bezier(0.65,0,0.45,1) forwards; }
    .ca-overlay.ca-show .ca-error-circle { animation: caStroke 0.55s 0.15s cubic-bezier(0.65,0,0.45,1) forwards; }
    .ca-overlay.ca-show .ca-error-x1    { animation: caStroke 0.28s 0.55s ease forwards; }
    .ca-overlay.ca-show .ca-error-x2    { animation: caStroke 0.28s 0.72s ease forwards; }

    @keyframes caStroke {
        to { stroke-dashoffset: 0; }
    }

    /* ── Title ── */
    .ca-title {
        font-size: 1.2rem;
        font-weight: 900;
        color: #1e293b;
        letter-spacing: -0.025em;
        line-height: 1.25;
        margin-bottom: 0.45rem;
        font-family: 'Cairo', 'Tajawal', sans-serif;
    }
    .dark .ca-title { color: #f1f5f9; }

    /* ── Message ── */
    .ca-msg {
        font-size: 0.88rem;
        font-weight: 600;
        color: #64748b;
        line-height: 1.7;
        font-family: 'Cairo', 'Tajawal', sans-serif;
        margin-bottom: 0;
    }
    .dark .ca-msg { color: #94a3b8; }

    /* ── Progress bar (success auto-close) ── */
    .ca-progress-wrap {
        width: 100%;
        height: 3px;
        background: rgba(148,163,184,0.12);
        margin-top: 1.5rem;
        border-radius: 99px;
        overflow: hidden;
    }
    .ca-progress-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, #10B981, #059669);
        width: 100%;
        transform-origin: left;
    }
    .ca-progress-fill.running {
        animation: caProgress var(--ca-duration, 3.5s) linear forwards;
    }
    @keyframes caProgress {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }

    /* ── Footer / button ── */
    .ca-footer {
        padding: 0 2rem 1.8rem;
        display: flex;
        justify-content: center;
    }
    .ca-btn {
        font-family: 'Cairo', 'Tajawal', sans-serif;
        font-weight: 800;
        font-size: 0.9rem;
        padding: 0.65rem 2.2rem;
        border-radius: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        position: relative;
        overflow: hidden;
    }
    .ca-btn.success {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff;
        box-shadow: 0 5px 18px rgba(16,185,129,0.35);
    }
    .ca-btn.success:hover { transform: translateY(-2px) scale(1.04); box-shadow: 0 8px 26px rgba(16,185,129,0.5); }
    .ca-btn.error {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: #fff;
        box-shadow: 0 5px 18px rgba(239,68,68,0.32);
    }
    .ca-btn.error:hover { transform: translateY(-2px) scale(1.04); box-shadow: 0 8px 26px rgba(239,68,68,0.48); }
    .ca-btn:active { transform: scale(0.96); }

    /* shimmer on button */
    .ca-btn::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 55%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.22), transparent);
        transition: left 0.5s ease;
    }
    .ca-btn:hover::before { left: 160%; }
</style>

{{-- Alert HTML (hidden by default, shown via JS) --}}
<div class="ca-overlay" id="caOverlay" role="dialog" aria-modal="true">
    <div class="ca-card" id="caCard">
        <div class="ca-bar" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-icon-ring" id="caRing">
                {{-- SVG injected by JS --}}
            </div>
            <p class="ca-title" id="caTitle"></p>
            <p class="ca-msg"   id="caMsg"></p>
            <div class="ca-progress-wrap" id="caProgressWrap" style="display:none;">
                <div class="ca-progress-fill" id="caProgressFill"></div>
            </div>
        </div>
        <div class="ca-footer">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

<script>
    /* ── SVG templates ── */
    const CA_SVG = {
        success: `<svg viewBox="0 0 52 52"><circle class="ca-check-circle" cx="26" cy="26" r="25"/><path class="ca-check-mark" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
        error:   `<svg viewBox="0 0 52 52"><circle class="ca-error-circle" cx="26" cy="26" r="25"/><line class="ca-error-x1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-error-x2" x1="36" y1="16" x2="16" y2="36"/></svg>`
    };

    let caTimer = null;

    function caShow({ type, title, msg, btnText, autoClose }) {
        const overlay  = document.getElementById('caOverlay');
        const bar      = document.getElementById('caBar');
        const ring     = document.getElementById('caRing');
        const titleEl  = document.getElementById('caTitle');
        const msgEl    = document.getElementById('caMsg');
        const btn      = document.getElementById('caBtn');
        const progWrap = document.getElementById('caProgressWrap');
        const progFill = document.getElementById('caProgressFill');

        /* reset animation classes first */
        overlay.classList.remove('ca-show');

        bar.className    = `ca-bar ${type}`;
        ring.className   = `ca-icon-ring ${type}`;
        ring.innerHTML   = CA_SVG[type];
        titleEl.textContent = title;
        msgEl.textContent   = msg;
        btn.className    = `ca-btn ${type}`;
        btn.textContent  = btnText;

        if (autoClose) {
            progWrap.style.display = 'block';
            progFill.className = 'ca-progress-fill';
            progFill.style.setProperty('--ca-duration', autoClose / 1000 + 's');
            /* trigger reflow so animation restarts */
            void progFill.offsetWidth;
            progFill.classList.add('running');
            caTimer = setTimeout(caClose, autoClose);
        } else {
            progWrap.style.display = 'none';
        }

        requestAnimationFrame(() => overlay.classList.add('ca-show'));
    }

    function caClose() {
        clearTimeout(caTimer);
        const overlay = document.getElementById('caOverlay');
        overlay.classList.remove('ca-show');
    }

    /* close on backdrop click */
    document.getElementById('caOverlay').addEventListener('click', function(e) {
        if (e.target === this) caClose();
    });

    /* ── Fire from Blade ── */
    @if(session('success'))
    window.addEventListener('DOMContentLoaded', () => {
        caShow({
            type:      'success',
            title:     'تمّ بنجاح',
            msg:       '{{ session("success") }}',
            btnText:   'حسناً',
            autoClose: 3800
        });
    });
    @endif

    @if($errors->any())
    window.addEventListener('DOMContentLoaded', () => {
        caShow({
            type:    'error',
            title:   'تحقق من البيانات',
            msg:     '{{ $errors->first() }}',
            btnText: 'سأصحح الآن',
        });
    });
    @endif
</script>

@endsection