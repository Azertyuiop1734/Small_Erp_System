<!DOCTYPE html>
<html lang="ar" dir="rtl" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات المورد | {{ $supplier->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
           (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
        * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

        /* ===== BODY ===== */
        body {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1rem;
            position: relative; overflow-x: hidden;
            background: #f0f7ff;
            transition: background 0.4s;
        }
        .dark body { background: #020617; }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 70% 55% at 12% 12%, rgba(37,99,235,0.10) 0%, transparent 60%),
                radial-gradient(ellipse 55% 50% at 88% 82%, rgba(99,102,241,0.09) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 55% 40%, rgba(16,185,129,0.06) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }

        /* Orbs */
        .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
        .orb-1 { width:320px; height:320px; background:rgba(37,99,235,0.08);  top:-80px; right:-80px;  animation-delay:0s; }
        .orb-2 { width:220px; height:220px; background:rgba(99,102,241,0.07); bottom:10%; left:-50px; animation-delay:-5s; }
        .orb-3 { width:160px; height:160px; background:rgba(16,185,129,0.06); top:45%; right:6%;     animation-delay:-9s; }

        @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1);} 50%{transform:translateY(-28px) scale(1.06);} }

        /* ===== THEME TOGGLE ===== */
        .theme-btn {
            position: fixed; top:1.2rem; left:1.2rem; z-index:999;
            width:44px; height:44px; border-radius:14px;
            background:rgba(255,255,255,0.7); backdrop-filter:blur(12px);
            border:1px solid rgba(203,213,225,0.5);
            display:flex; align-items:center; justify-content:center;
            color:#64748b; cursor:pointer;
            box-shadow:0 4px 16px rgba(0,0,0,0.08);
            transition:all 0.25s ease;
        }
        .dark .theme-btn { background:rgba(15,23,42,0.7); border-color:rgba(71,85,105,0.4); color:#94a3b8; }
        .theme-btn:hover { transform:scale(1.08); box-shadow:0 6px 20px rgba(0,0,0,0.12); }

        /* ===== WRAPPER ===== */
        .page-wrap { width:100%; max-width:760px; position:relative; z-index:1; }

        /* ===== BACK LINK ===== */
        .back-link {
            display:inline-flex; align-items:center; gap:0.5rem;
            font-size:0.85rem; font-weight:700; color:#64748b;
            text-decoration:none; margin-bottom:1.4rem;
            padding:0.45rem 1rem;
            background:rgba(255,255,255,0.55); backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,0.6); border-radius:10px;
            transition:all 0.22s ease;
        }
        .dark .back-link { background:rgba(15,23,42,0.55); border-color:rgba(71,85,105,0.4); color:#94a3b8; }
        .back-link:hover { color:#2563EB; transform:translateX(3px); background:rgba(255,255,255,0.8); }
        .dark .back-link:hover { color:#60a5fa; background:rgba(15,23,42,0.8); }
        .back-link i { transition:transform 0.22s; }
        .back-link:hover i { transform:translateX(-3px); }

        /* ===== MAIN CARD ===== */
        .edit-card {
            background:rgba(255,255,255,0.58); backdrop-filter:blur(28px); -webkit-backdrop-filter:blur(28px);
            border:1px solid rgba(255,255,255,0.72); border-radius:2.2rem;
            box-shadow:0 8px 48px rgba(0,0,0,0.09), 0 1px 0 rgba(255,255,255,0.9) inset;
            overflow:hidden;
            animation:cardIn 0.65s cubic-bezier(0.34,1.56,0.64,1) both;
        }
        .dark .edit-card { background:rgba(15,23,42,0.62); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 48px rgba(0,0,0,0.38); }

        @keyframes cardIn { from{opacity:0;transform:translateY(28px) scale(0.97);} to{opacity:1;transform:translateY(0) scale(1);} }

        /* ===== CARD HEADER ===== */
        .card-header {
            padding: 2rem 2.4rem 1.8rem;
            text-align: center;
            position: relative; overflow: hidden;
            background: linear-gradient(135deg, rgba(37,99,235,0.05) 0%, rgba(99,102,241,0.04) 100%);
            border-bottom: 1px solid rgba(148,163,184,0.1);
        }
        .dark .card-header {
            background:linear-gradient(135deg, rgba(37,99,235,0.10) 0%, rgba(99,102,241,0.08) 100%);
            border-bottom-color:rgba(51,65,85,0.4);
        }

        /* Animated ring decorations */
        .card-header::before, .card-header::after {
            content:''; position:absolute; border-radius:50%;
            background:transparent; border:1px solid rgba(37,99,235,0.08);
            pointer-events:none;
        }
        .card-header::before { width:200px; height:200px; top:-80px; left:-60px; }
        .card-header::after  { width:140px; height:140px; bottom:-50px; right:-30px; border-color:rgba(99,102,241,0.07); }

        .header-avatar-wrap {
            position: relative; display:inline-block; margin-bottom:1rem;
        }
        .header-avatar {
            width:72px; height:72px;
            background:linear-gradient(135deg, #2563EB 0%, #6366F1 100%);
            border-radius:22px; margin:0 auto;
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 10px 32px rgba(37,99,235,0.38), 0 0 0 4px rgba(37,99,235,0.12);
            position:relative;
        }
        .header-avatar::before { content:''; position:absolute; inset:0; border-radius:inherit; background:linear-gradient(135deg,rgba(255,255,255,0.24),transparent); }
        .header-avatar i { color:#fff; font-size:1.7rem; position:relative; z-index:1; }

        /* Pulse ring */
        .pulse-ring {
            position:absolute; inset:-6px; border-radius:28px;
            border:2px solid rgba(37,99,235,0.2);
            animation:pulseRing 2.5s ease-in-out infinite;
        }
        @keyframes pulseRing { 0%,100%{transform:scale(1);opacity:0.5;} 50%{transform:scale(1.07);opacity:0;} }

        .header-title { font-size:1.4rem; font-weight:900; color:#1e293b; letter-spacing:-0.02em; }
        .dark .header-title { color:#f1f5f9; }
        .header-sub { font-size:0.84rem; color:#64748b; font-weight:600; margin-top:5px; }
        .dark .header-sub { color:#94a3b8; }
        .header-name-badge {
            display:inline-block; color:#2563EB; font-weight:900;
            background:rgba(37,99,235,0.08); padding:1px 10px; border-radius:8px;
            margin-right:2px;
        }
        .dark .header-name-badge { color:#60a5fa; background:rgba(37,99,235,0.15); }

        /* ===== FORM BODY ===== */
        .form-body { padding:2rem 2.4rem 2.4rem; direction:rtl; }

        .fields-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.4rem; }
        .field-full { grid-column:1 / -1; }

        /* ===== FIELD GROUP ===== */
        .field-group { display:flex; flex-direction:column; gap:0.48rem; animation:fieldIn 0.45s ease both; }
        @keyframes fieldIn { from{opacity:0;transform:translateY(10px);} to{opacity:1;transform:translateY(0);} }
        .field-group:nth-child(1){animation-delay:.07s}
        .field-group:nth-child(2){animation-delay:.12s}
        .field-group:nth-child(3){animation-delay:.17s}
        .field-group:nth-child(4){animation-delay:.22s}
        .field-group:nth-child(5){animation-delay:.27s}

        .field-label {
            font-size:0.78rem; font-weight:800; color:#374151;
            display:flex; align-items:center; gap:0.45rem;
        }
        .dark .field-label { color:#cbd5e1; }
        .label-icon {
            width:22px; height:22px; border-radius:7px;
            background:rgba(37,99,235,0.08); display:flex; align-items:center; justify-content:center;
            color:#2563EB; font-size:0.62rem; flex-shrink:0;
        }
        .dark .label-icon { background:rgba(37,99,235,0.15); }
        .req { color:#EF4444; font-size:0.85rem; }

        /* ===== INPUTS ===== */
        .input-wrap { position:relative; }
        .field-input, .field-textarea {
            width:100%;
            background:rgba(255,255,255,0.68); backdrop-filter:blur(10px);
            border:1.5px solid rgba(203,213,225,0.55); border-radius:14px;
            padding:0.8rem 2.5rem 0.8rem 1rem;
            font-size:0.91rem; font-family:'Cairo',sans-serif; color:#1e293b;
            transition:all 0.22s ease; outline:none; direction:rtl;
        }
        .dark .field-input, .dark .field-textarea {
            background:rgba(30,41,59,0.65); border-color:rgba(71,85,105,0.4); color:#f1f5f9;
        }
        .field-input::placeholder, .field-textarea::placeholder { color:#94a3b8; }
        .field-input:hover, .field-textarea:hover { border-color:rgba(37,99,235,0.3); }
        .field-input:focus, .field-textarea:focus {
            border-color:rgba(37,99,235,0.5);
            background:rgba(255,255,255,0.92);
            box-shadow:0 0 0 3px rgba(37,99,235,0.10), 0 4px 18px rgba(37,99,235,0.07);
        }
        .dark .field-input:focus, .dark .field-textarea:focus {
            background:rgba(15,23,42,0.9); box-shadow:0 0 0 3px rgba(37,99,235,0.18);
        }
        .field-textarea { resize:vertical; min-height:95px; padding-right:1rem; }
        .field-input[name="phone"] { direction:ltr; text-align:right; }
        .field-input[name="balance"] { direction:ltr; text-align:right; padding-left:4.5rem; }

        .input-icon {
            position:absolute; right:0.85rem; top:50%; transform:translateY(-50%);
            color:#94a3b8; font-size:0.78rem; pointer-events:none; transition:color 0.2s;
        }
        .input-wrap:focus-within .input-icon { color:#2563EB; }

        .input-suffix {
            position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
            font-size:0.72rem; font-weight:800; color:#64748b;
            background:rgba(148,163,184,0.12); padding:2px 7px; border-radius:6px; pointer-events:none;
        }
        .dark .input-suffix { color:#94a3b8; background:rgba(71,85,105,0.3); }

        /* Change indicator */
        .changed-badge {
            display:none; position:absolute; top:-7px; left:-7px;
            width:14px; height:14px; border-radius:50%;
            background:#F59E0B; border:2px solid white;
            animation:popIn 0.3s cubic-bezier(0.34,1.56,0.64,1);
        }
        .dark .changed-badge { border-color:#0f172a; }
        @keyframes popIn { from{transform:scale(0);} to{transform:scale(1);} }

        /* ===== DIVIDER ===== */
        .form-divider { margin:1.8rem 0 0; padding-top:1.8rem; border-top:1px solid rgba(148,163,184,0.12); }
        .dark .form-divider { border-top-color:rgba(51,65,85,0.4); }

        /* ===== BUTTONS ===== */
        .btn-row { display:flex; gap:1rem; flex-wrap:wrap; }

        .btn-save {
            flex:2; min-width:180px;
            display:inline-flex; align-items:center; justify-content:center; gap:0.6rem;
            padding:0.9rem 1.8rem;
            background:linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
            color:#fff; border:none; border-radius:14px;
            font-size:0.95rem; font-weight:800; font-family:'Cairo',sans-serif;
            cursor:pointer; box-shadow:0 6px 24px rgba(37,99,235,0.35);
            transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);
            position:relative; overflow:hidden;
        }
        .btn-save::before {
            content:''; position:absolute; top:0; left:-100%;
            width:55%; height:100%;
            background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent);
            transition:left 0.5s;
        }
        .btn-save:hover::before { left:150%; }
        .btn-save:hover { transform:translateY(-2px) scale(1.02); box-shadow:0 10px 30px rgba(37,99,235,0.5); }
        .btn-save:active { transform:scale(0.97); }

        .btn-cancel {
            flex:1; min-width:130px;
            display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
            padding:0.9rem 1.4rem;
            background:rgba(248,250,252,0.7); color:#475569;
            border:1.5px solid rgba(203,213,225,0.6); border-radius:14px;
            font-size:0.9rem; font-weight:700; font-family:'Cairo',sans-serif;
            text-decoration:none; backdrop-filter:blur(8px);
            transition:all 0.22s ease;
        }
        .dark .btn-cancel { background:rgba(30,41,59,0.65); color:#94a3b8; border-color:rgba(71,85,105,0.4); }
        .btn-cancel:hover { background:rgba(239,68,68,0.06); border-color:rgba(239,68,68,0.3); color:#EF4444; transform:translateY(-1px); }
        .dark .btn-cancel:hover { background:rgba(239,68,68,0.10); }

        /* ===== LAST UPDATED STRIP ===== */
        .info-strip {
            display:flex; align-items:center; justify-content:center; gap:0.5rem;
            padding:0.7rem 1.4rem;
            background:rgba(37,99,235,0.04); border-top:1px solid rgba(37,99,235,0.07);
            font-size:0.75rem; color:#94a3b8; font-weight:600;
        }
        .dark .info-strip { background:rgba(37,99,235,0.07); border-top-color:rgba(51,65,85,0.35); }

        @media(max-width:640px) {
            .fields-grid { grid-template-columns:1fr; }
            .field-full { grid-column:1; }
            .form-body { padding:1.4rem 1.2rem 1.6rem; }
            .card-header { padding:1.6rem 1.2rem 1.4rem; }
            .btn-row { flex-direction:column; }
            .back-link { margin-right:0; }
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-[#020617] transition-colors duration-300">

{{-- Orbs --}}
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

{{-- Theme Toggle --}}
<button id="theme-toggle" class="theme-btn" type="button" title="تبديل الوضع">
    <svg id="icon-light" class="hidden" style="width:20px;height:20px;" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/>
    </svg>
    <svg id="icon-dark" class="hidden" style="width:20px;height:20px;" fill="currentColor" viewBox="0 0 20 20">
        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
    </svg>
</button>

<div class="page-wrap">

    {{-- BACK --}}
    <a href="{{ route('suppliers.index') }}" class="back-link">
        <i class="fas fa-arrow-right"></i>
        العودة لقائمة الموردين
    </a>

    {{-- EDIT CARD --}}
    <div class="edit-card">

        {{-- HEADER --}}
        <div class="card-header">
            <div class="header-avatar-wrap">
                <div class="header-avatar">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="pulse-ring"></div>
            </div>
            <div class="header-title">تعديل بيانات المورد</div>
            <div class="header-sub">
                تحديث معلومات المورد:
                <span class="header-name-badge">{{ $supplier->name }}</span>
            </div>
        </div>

        {{-- FORM --}}
        <div class="form-body">
            <form id="editSupplierForm" action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="fields-grid">

                    {{-- اسم المورد --}}
                    <div class="field-group">
                        <label class="field-label">
                            <span class="label-icon"><i class="fas fa-user"></i></span>
                            اسم المورد <span class="req">*</span>
                        </label>
                        <div class="input-wrap">
                            <i class="fas fa-id-card input-icon"></i>
                            <input type="text" name="name" required
                                   class="field-input" value="{{ $supplier->name }}"
                                   placeholder="اسم المورد الكامل"
                                   data-original="{{ $supplier->name }}">
                            <span class="changed-badge" title="تم التعديل"></span>
                        </div>
                        @error('name')
                            <div style="font-size:0.74rem;color:#EF4444;font-weight:700;display:flex;align-items:center;gap:4px;margin-top:2px;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- اسم الشركة --}}
                    <div class="field-group">
                        <label class="field-label">
                            <span class="label-icon"><i class="fas fa-building"></i></span>
                            اسم الشركة
                        </label>
                        <div class="input-wrap">
                            <i class="fas fa-briefcase input-icon"></i>
                            <input type="text" name="company_name"
                                   class="field-input" value="{{ $supplier->company_name }}"
                                   placeholder="شركة التوريد المحدودة"
                                   data-original="{{ $supplier->company_name }}">
                            <span class="changed-badge" title="تم التعديل"></span>
                        </div>
                    </div>

                    {{-- رقم الهاتف --}}
                    <div class="field-group">
                        <label class="field-label">
                            <span class="label-icon"><i class="fas fa-phone"></i></span>
                            رقم الهاتف
                        </label>
                        <div class="input-wrap">
                            <i class="fas fa-phone-alt input-icon"></i>
                            <input type="text" name="phone"
                                   class="field-input" value="{{ $supplier->phone }}"
                                   placeholder="0XXXXXXXXX"
                                   data-original="{{ $supplier->phone }}">
                            <span class="changed-badge" title="تم التعديل"></span>
                        </div>
                    </div>

                    {{-- الدين --}}
                    <div class="field-group">
                        <label class="field-label">
                            <span class="label-icon"><i class="fas fa-coins"></i></span>
                            الدين الحالي
                        </label>
                        <div class="input-wrap">
                            <i class="fas fa-wallet input-icon"></i>
                            <input type="number" step="0.01" name="balance"
                                   class="field-input" value="{{ $supplier->balance }}"
                                   data-original="{{ $supplier->balance }}">
                            <span class="input-suffix">د.ج</span>
                            <span class="changed-badge" title="تم التعديل"></span>
                        </div>
                    </div>

                    {{-- العنوان --}}
                    <div class="field-group field-full">
                        <label class="field-label">
                            <span class="label-icon"><i class="fas fa-map-marker-alt"></i></span>
                            العنوان الكامل
                        </label>
                        <textarea name="address" rows="3"
                                  class="field-textarea"
                                  data-original="{{ $supplier->address }}"
                                  placeholder="المدينة، الشارع، المعالم القريبة...">{{ $supplier->address }}</textarea>
                    </div>

                </div>{{-- end grid --}}

                <div class="form-divider">
                    <div class="btn-row">
                        <button type="button" onclick="confirmUpdate()" class="btn-save">
                            <i class="fas fa-check-circle"></i>
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('suppliers.index') }}" class="btn-cancel">
                            <i class="fas fa-times"></i>
                            إلغاء
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- INFO STRIP --}}
        <div class="info-strip">
            <i class="fas fa-clock" style="font-size:0.7rem;"></i>
            آخر تحديث: {{ \Carbon\Carbon::parse($supplier->created_at)->format('Y-m-d') }}
        </div>

    </div>
</div>

<script>
    /* ===== THEME TOGGLE ===== */
    const themeBtn = document.getElementById('theme-toggle');
    const iconLight = document.getElementById('icon-light');
    const iconDark  = document.getElementById('icon-dark');

    function syncIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        iconLight.classList.toggle('hidden', !isDark);
        iconDark.classList.toggle('hidden', isDark);
    }

    themeBtn.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        syncIcons();
    });
    syncIcons();

    /* ===== CHANGE INDICATOR ===== */
    document.querySelectorAll('[data-original]').forEach(el => {
        const badge = el.closest('.input-wrap')?.querySelector('.changed-badge');
        if (!badge) return;
        el.addEventListener('input', () => {
            const changed = el.value !== el.dataset.original;
            badge.style.display = changed ? 'block' : 'none';
        });
    });

    /* ===== SWEETALERT ===== */
    function showStyledAlert(config) {
        const isDark = document.documentElement.classList.contains('dark');
        return Swal.fire({
            ...config,
            background: isDark ? '#0f172a' : '#ffffff',
            color: isDark ? '#f8fafc' : '#1e293b',
            confirmButtonColor: config.icon === 'warning' || config.icon === 'error' ? '#e11d48' : '#2563eb',
            cancelButtonColor: isDark ? '#334155' : '#94a3b8',
            customClass: {
                popup: 'rounded-[2rem] shadow-2xl',
                confirmButton: 'rounded-xl px-8 py-3 font-bold',
                cancelButton: 'rounded-xl px-8 py-3 font-bold'
            },
            showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
            hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' }
        });
    }

    function confirmUpdate() {
        showStyledAlert({
            icon: 'question',
            title: 'تأكيد التعديلات',
            text: 'سيتم استبدال البيانات القديمة بالبيانات الجديدة للمورد.',
            showCancelButton: true,
            confirmButtonText: 'نعم، حفظ التعديلات',
            cancelButtonText: 'تراجع'
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('editSupplierForm').submit();
            }
        });
    }

    @if($errors->any())
        showStyledAlert({
            icon: 'error',
            title: 'خطأ في البيانات',
            html: '<div class="text-right text-sm leading-loose">{!! implode("<br>", $errors->all()) !!}</div>'
        });
    @endif
</script>
</body>
</html>