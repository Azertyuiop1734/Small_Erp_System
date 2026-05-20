<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        if (localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
* { font-family: 'Cairo', 'Tajawal', sans-serif; }
html { scroll-behavior: smooth; }

/* ── Body ── */
body {
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem 1rem;
    background: #f1f5f9;
    transition: background .4s ease;
    position: relative; overflow: hidden;
}
html.dark body { background: #04080f; }

/* ── Ambient gradients ── */
body::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.10)  0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(99,102,241,.08) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 35%, rgba(59,130,246,.06) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.16) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(99,102,241,.13) 0%, transparent 60%);
}

/* ── Floating orbs ── */
.orb { position: fixed; border-radius: 50%; filter: blur(72px); pointer-events: none; z-index: 0; animation: floatOrb 13s ease-in-out infinite; }
.orb-1 { width:380px; height:380px; background:rgba(37,99,235,.07);   top:-100px; right:-100px; animation-delay:0s;  }
.orb-2 { width:280px; height:280px; background:rgba(99,102,241,.06);  bottom:5%;  left:-70px;  animation-delay:-5s; }
.orb-3 { width:200px; height:200px; background:rgba(59,130,246,.05);  top:45%;    right:5%;    animation-delay:-9s; }
html.dark .orb-1 { background:rgba(37,99,235,.14); }
html.dark .orb-2 { background:rgba(99,102,241,.12); }
@keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

/* ── Dark toggle ── */
.dark-toggle {
    position: fixed; top: 1.3rem; left: 1.3rem; z-index: 1000;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.65); backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,.7); box-shadow: 0 3px 14px rgba(0,0,0,.09);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .28s cubic-bezier(.34,1.56,.64,1);
}
html.dark .dark-toggle { background: rgba(15,23,42,.7); border-color: rgba(51,65,85,.5); }
.dark-toggle:hover { transform: scale(1.12); box-shadow: 0 6px 22px rgba(37,99,235,.28); }
.dark-toggle i { font-size: 1rem; color: #64748b; transition: color .25s; }
html.dark .dark-toggle i { color: #60a5fa; }

/* ── Page wrapper ── */
.page-wrap {
    width: 100%; max-width: 440px;
    position: relative; z-index: 1;
    animation: pageIn .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes pageIn {
    from { opacity:0; transform: translateY(28px) scale(.96); }
    to   { opacity:1; transform: translateY(0)     scale(1);   }
}

/* ── Glass card ── */
.glass-card {
    background: rgba(255,255,255,.56); backdrop-filter: blur(26px); -webkit-backdrop-filter: blur(26px);
    border: 1px solid rgba(255,255,255,.68); border-radius: 2.2rem;
    box-shadow: 0 2px 0 rgba(255,255,255,.92) inset, 0 32px 72px rgba(0,0,0,.10), 0 8px 24px rgba(0,0,0,.05);
    overflow: hidden; position: relative;
}
html.dark .glass-card { background: rgba(10,17,34,.72); border-color: rgba(51,65,85,.45); box-shadow: 0 32px 72px rgba(0,0,0,.45); }
.glass-card::before {
    content: ''; position: absolute; top:-80px; right:-80px;
    width:280px; height:280px; background:rgba(37,99,235,.05);
    border-radius:50%; filter:blur(80px); pointer-events:none; display:none;
}
html.dark .glass-card::before { display:block; }

/* ── Card strip ── */
.card-strip {
    background: linear-gradient(135deg,rgba(37,99,235,.08) 0%,rgba(99,102,241,.06) 100%);
    border-bottom: 1px solid rgba(37,99,235,.09);
    padding: .95rem 2rem; display: flex; align-items: center; gap: .7rem;
}
html.dark .card-strip { background:linear-gradient(135deg,rgba(37,99,235,.12) 0%,rgba(99,102,241,.09) 100%); border-bottom-color:rgba(51,65,85,.4); }
.strip-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7);flex-shrink:0; }
.strip-label { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
html.dark .strip-label { color:#60a5fa; }

/* ── Card body ── */
.card-body { padding: 2.4rem 2.2rem 2.2rem; }

/* ── Icon + title ── */
.card-hero { display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom:2rem; }

.hero-icon-wrap {
    width: 72px; height: 72px; margin-bottom: 1.1rem;
    background: linear-gradient(135deg, #2563EB 0%, #4F46E5 100%);
    border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 10px 32px rgba(37,99,235,.4), 0 0 0 3px rgba(37,99,235,.15);
    position: relative;
}
.hero-icon-wrap::after { content:'';position:absolute;inset:-3px;border-radius:25px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
.hero-icon-wrap i { color:#fff; font-size:1.8rem; position:relative; z-index:1; }

.card-title { font-size:1.5rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1.15; margin-bottom:.45rem; }
html.dark .card-title { color:#f1f5f9; }
.card-sub { font-size:.85rem; font-weight:600; color:#64748b; line-height:1.6; max-width:320px; }
html.dark .card-sub { color:#94a3b8; }

/* ── Form ── */
.field-group { display:flex; flex-direction:column; gap:.45rem; margin-bottom:1.5rem; }
.field-label { font-size:.71rem; font-weight:900; color:#2563EB; text-transform:uppercase; letter-spacing:.08em; display:flex; align-items:center; gap:.38rem; }
html.dark .field-label { color:#60a5fa; }

.field-wrap { position:relative; }
.field-input {
    width:100%; padding:.9rem 2.8rem .9rem 1.15rem;
    background:rgba(255,255,255,.62); backdrop-filter:blur(8px);
    border:1px solid rgba(148,163,184,.22); border-radius:.95rem;
    font-size:.94rem; font-family:'Cairo',sans-serif; font-weight:600; color:#1e293b;
    outline:none; direction:rtl; box-sizing:border-box;
    transition:border-color .22s ease,box-shadow .22s ease,background .22s ease;
}
html.dark .field-input { background:rgba(15,23,42,.52); border-color:rgba(51,65,85,.48); color:#f1f5f9; }
.field-input::placeholder { color:#94a3b8; font-weight:500; }
.field-input:focus {
    border-color:rgba(37,99,235,.5);
    box-shadow:0 0 0 3px rgba(37,99,235,.12), 0 4px 14px rgba(37,99,235,.07);
    background:rgba(255,255,255,.9);
}
html.dark .field-input:focus { background:rgba(15,23,42,.9); box-shadow:0 0 0 3px rgba(37,99,235,.22); }

.field-icon { position:absolute; right:.9rem; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:.95rem; pointer-events:none; transition:color .22s; }
.field-group:focus-within .field-icon { color:#2563EB; }

/* error message */
.field-error { font-size:.76rem; font-weight:700; color:#EF4444; display:flex; align-items:center; gap:.35rem; }
.field-error i { font-size:.65rem; }

/* ── Submit button ── */
.btn-submit {
    width:100%; padding:.9rem;
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
    color:#fff; border-radius:.95rem; font-weight:800; font-size:.96rem;
    border:none; cursor:pointer;
    box-shadow:0 6px 24px rgba(37,99,235,.4);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
    font-family:'Cairo',sans-serif;
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    position:relative; overflow:hidden;
}
.btn-submit::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
.btn-submit:hover::before { left:160%; }
.btn-submit:hover { transform:translateY(-2px) scale(1.02); box-shadow:0 10px 32px rgba(37,99,235,.52); }
.btn-submit:active { transform:scale(.97); }
.btn-submit:disabled { opacity:.65; cursor:not-allowed; transform:none; }
.btn-submit i { transition:transform .3s cubic-bezier(.34,1.56,.64,1); }
.btn-submit:hover i { transform:translateX(-4px); }

/* loading spinner */
@keyframes spin { to{transform:rotate(360deg)} }
.spin { animation:spin .8s linear infinite; display:inline-block; }

/* ── Divider ── */
.divider { display:flex; align-items:center; gap:.8rem; margin:1.4rem 0; }
.divider-line { flex:1; height:1px; background:rgba(148,163,184,.18); }
html.dark .divider-line { background:rgba(51,65,85,.4); }
.divider-text { font-size:.72rem; font-weight:700; color:#94a3b8; white-space:nowrap; }

/* ── Back link ── */
.back-link {
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    font-size:.85rem; font-weight:700; color:#64748b; text-decoration:none;
    transition:color .22s ease;
}
html.dark .back-link { color:#94a3b8; }
.back-link:hover { color:#2563EB; }
html.dark .back-link:hover { color:#60a5fa; }
.back-link i { font-size:.75rem; transition:transform .22s; }
.back-link:hover i { transform:translateX(3px); }

/* ── Footer ── */
.page-footer { text-align:center; margin-top:1.3rem; font-size:.73rem; color:#94a3b8; font-weight:600; }

/* ── Responsive ── */
@media(max-width:480px){
    .card-body { padding:1.8rem 1.4rem 1.6rem; }
    .card-title { font-size:1.3rem; }
}
</style>
</head>
<body>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- Dark toggle -->
<button class="dark-toggle" onclick="toggleDark()" aria-label="تبديل الوضع">
    <i id="darkIcon" class="fas fa-moon"></i>
</button>

<div class="page-wrap">
    <div class="glass-card">

        <!-- Strip -->
        <div class="card-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">استعادة الحساب</span>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Hero -->
            <div class="card-hero">
                <div class="hero-icon-wrap">
                    <i class="fas fa-lock-open"></i>
                </div>
                <h1 class="card-title">استعادة كلمة المرور</h1>
                <p class="card-sub">أدخل بريدك الإلكتروني وسنرسل لك رمز التحقق (OTP) لإعادة تعيين كلمة المرور.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('otp.send') }}" method="POST" id="otpForm">
                @csrf

                <div class="field-group">
                    <label class="field-label"><i class="fas fa-envelope"></i> البريد الإلكتروني</label>
                    <div class="field-wrap">
                        <input type="email" name="email" required
                               class="field-input"
                               placeholder="example@company.com"
                               value="{{ old('email') }}"
                               dir="ltr" style="text-align:right;">
                        <i class="field-icon fas fa-envelope"></i>
                    </div>
                    @error('email')
                        <span class="field-error">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span id="btnText" style="display:inline-flex;align-items:center;gap:.55rem;">
                        <i class="fas fa-paper-plane"></i>
                        إرسال رمز التحقق
                    </span>
                    <span id="btnLoading" style="display:none;align-items:center;gap:.55rem;">
                        <i class="fas fa-circle-notch spin"></i>
                        جاري الإرسال...
                    </span>
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">أو</span>
                <div class="divider-line"></div>
            </div>

            <a href="{{ route('login') }}" class="back-link">
                تذكرت كلمة المرور؟ تسجيل الدخول
                <i class="fas fa-arrow-left"></i>
            </a>

        </div>
    </div>

    <p class="page-footer">
        <i class="fas fa-shield-alt" style="color:#2563EB;font-size:.7rem;"></i>
        بياناتك محمية ومشفرة بالكامل
    </p>
</div>

<script>
/* Dark mode */
function toggleDark() {
    const html = document.documentElement;
    const icon = document.getElementById('darkIcon');
    if (html.classList.contains('dark')) {
        html.classList.remove('dark'); localStorage.setItem('theme','light');
        icon.className = 'fas fa-moon';
    } else {
        html.classList.add('dark'); localStorage.setItem('theme','dark');
        icon.className = 'fas fa-sun';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    if (document.documentElement.classList.contains('dark'))
        document.getElementById('darkIcon').className = 'fas fa-sun';
});

/* Submit loading */
document.getElementById('otpForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    document.getElementById('btnText').style.display    = 'none';
    document.getElementById('btnLoading').style.display = 'inline-flex';
});
</script>

</body>
</html>