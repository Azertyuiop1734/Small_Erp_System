<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التحقق من الرمز - OTP</title>
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

body {
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem 1rem;
    background: #f1f5f9;
    transition: background .4s ease;
    position: relative; overflow: hidden;
}
html.dark body { background: #04080f; }

body::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.10) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(245,158,11,.07) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 35%, rgba(99,102,241,.06) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.16) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(245,158,11,.11) 0%, transparent 60%);
}

/* ── Orbs ── */
.orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
.orb-1 { width:380px;height:380px; background:rgba(37,99,235,.07);   top:-100px; right:-100px; animation-delay:0s;  }
.orb-2 { width:280px;height:280px; background:rgba(245,158,11,.06);  bottom:5%;  left:-70px;  animation-delay:-5s; }
.orb-3 { width:200px;height:200px; background:rgba(99,102,241,.05);  top:45%;    right:5%;    animation-delay:-9s; }
html.dark .orb-1 { background:rgba(37,99,235,.14); }
html.dark .orb-2 { background:rgba(245,158,11,.11); }
@keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

/* ── Dark toggle ── */
.dark-toggle {
    position:fixed; top:1.3rem; left:1.3rem; z-index:1000;
    width:44px; height:44px; border-radius:50%;
    background:rgba(255,255,255,.65); backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.7); box-shadow:0 3px 14px rgba(0,0,0,.09);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:all .28s cubic-bezier(.34,1.56,.64,1);
}
html.dark .dark-toggle { background:rgba(15,23,42,.7); border-color:rgba(51,65,85,.5); }
.dark-toggle:hover { transform:scale(1.12); box-shadow:0 6px 22px rgba(37,99,235,.28); }
.dark-toggle i { font-size:1rem; color:#64748b; transition:color .25s; }
html.dark .dark-toggle i { color:#60a5fa; }

/* ── Page wrapper ── */
.page-wrap {
    width:100%; max-width:460px;
    position:relative; z-index:1;
    animation:pageIn .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes pageIn {
    from { opacity:0; transform:translateY(28px) scale(.96); }
    to   { opacity:1; transform:translateY(0)     scale(1);   }
}

/* ── Glass card ── */
.glass-card {
    background:rgba(255,255,255,.56); backdrop-filter:blur(26px); -webkit-backdrop-filter:blur(26px);
    border:1px solid rgba(255,255,255,.68); border-radius:2.2rem;
    box-shadow:0 2px 0 rgba(255,255,255,.92) inset, 0 32px 72px rgba(0,0,0,.10), 0 8px 24px rgba(0,0,0,.05);
    overflow:hidden; position:relative;
}
html.dark .glass-card { background:rgba(10,17,34,.72); border-color:rgba(51,65,85,.45); box-shadow:0 32px 72px rgba(0,0,0,.45); }
.glass-card::before { content:'';position:absolute;top:-80px;right:-80px;width:280px;height:280px;background:rgba(37,99,235,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
html.dark .glass-card::before { display:block; }

/* ── Strip ── */
.card-strip {
    background:linear-gradient(135deg,rgba(37,99,235,.08) 0%,rgba(99,102,241,.06) 100%);
    border-bottom:1px solid rgba(37,99,235,.09);
    padding:.95rem 2rem; display:flex; align-items:center; gap:.7rem;
}
html.dark .card-strip { background:linear-gradient(135deg,rgba(37,99,235,.12) 0%,rgba(99,102,241,.09) 100%); border-bottom-color:rgba(51,65,85,.4); }
.strip-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7);flex-shrink:0; }
.strip-label { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
html.dark .strip-label { color:#60a5fa; }

/* ── Body ── */
.card-body { padding:2.2rem 2.2rem 2rem; }

/* ── Hero ── */
.card-hero { display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom:1.8rem; }

.hero-icon-wrap {
    width:70px; height:70px; margin-bottom:1rem;
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
    border-radius:22px;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 10px 32px rgba(37,99,235,.4), 0 0 0 3px rgba(37,99,235,.15);
    position:relative;
}
.hero-icon-wrap::after { content:'';position:absolute;inset:-3px;border-radius:25px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
.hero-icon-wrap i { color:#fff; font-size:1.75rem; position:relative; z-index:1; }

.card-title { font-size:1.45rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; margin-bottom:.4rem; }
html.dark .card-title { color:#f1f5f9; }

.email-badge {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.3rem .9rem; border-radius:999px;
    background:rgba(37,99,235,.09); border:1px solid rgba(37,99,235,.18);
    font-size:.82rem; font-weight:800; color:#2563EB;
    margin-top:.3rem;
}
html.dark .email-badge { background:rgba(37,99,235,.16); color:#60a5fa; }
.email-badge i { font-size:.68rem; }

/* ── OTP inputs ── */
.otp-label { font-size:.71rem; font-weight:900; color:#2563EB; text-transform:uppercase; letter-spacing:.1em; text-align:center; margin-bottom:.9rem; }
html.dark .otp-label { color:#60a5fa; }

.otp-row {
    display:flex; align-items:center; justify-content:center; gap:.65rem;
    margin-bottom:1rem; direction:ltr;
}

.otp-box {
    width:52px; height:58px;
    background:rgba(255,255,255,.62); backdrop-filter:blur(8px);
    border:1.5px solid rgba(148,163,184,.25); border-radius:1rem;
    text-align:center; font-size:1.6rem; font-weight:900; color:#1e293b;
    outline:none; caret-color:#2563EB;
    transition:border-color .2s ease, box-shadow .2s ease, background .2s ease, transform .2s cubic-bezier(.34,1.56,.64,1);
}
html.dark .otp-box { background:rgba(15,23,42,.52); border-color:rgba(51,65,85,.48); color:#f1f5f9; }
.otp-box:focus {
    border-color:rgba(37,99,235,.55);
    box-shadow:0 0 0 3px rgba(37,99,235,.14), 0 4px 14px rgba(37,99,235,.08);
    background:rgba(255,255,255,.92); transform:scale(1.06);
}
html.dark .otp-box:focus { background:rgba(15,23,42,.9); }
.otp-box.filled { border-color:rgba(37,99,235,.45); background:rgba(37,99,235,.05); }
html.dark .otp-box.filled { background:rgba(37,99,235,.12); }
.otp-box.error-box { border-color:rgba(239,68,68,.5); box-shadow:0 0 0 3px rgba(239,68,68,.12); animation:shake .4s ease; }
@keyframes shake {
    0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)}
}

/* hidden real input */
#otpHidden { position:absolute; opacity:0; pointer-events:none; }

/* error */
.field-error { display:flex; align-items:center; justify-content:center; gap:.38rem; font-size:.76rem; font-weight:700; color:#EF4444; margin-top:.3rem; }

/* ── Timer ── */
.timer-wrap {
    display:flex; flex-direction:column; align-items:center; gap:.4rem; margin:1.4rem 0 1.2rem;
}
.timer-ring-outer {
    position:relative; width:72px; height:72px;
}
.timer-ring-outer svg { transform:rotate(-90deg); }
.timer-track { fill:none; stroke:rgba(148,163,184,.18); stroke-width:4; }
.timer-fill  { fill:none; stroke-width:4; stroke-linecap:round; transition:stroke-dashoffset .9s linear, stroke .5s ease; }
.timer-text-wrap { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }
.timer-text { font-size:.9rem; font-weight:900; letter-spacing:-.02em; }
.timer-sub { font-size:.7rem; font-weight:700; color:#94a3b8; }
html.dark .timer-sub { color:#64748b; }

/* ── Buttons ── */
.btn-verify {
    width:100%; padding:.9rem;
    background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
    color:#fff; border-radius:.95rem; font-weight:800; font-size:.96rem;
    border:none; cursor:pointer;
    box-shadow:0 6px 24px rgba(37,99,235,.4);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
    font-family:'Cairo',sans-serif;
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    position:relative; overflow:hidden; margin-bottom:1rem;
}
.btn-verify::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s; }
.btn-verify:not(:disabled):hover::before { left:160%; }
.btn-verify:not(:disabled):hover { transform:translateY(-2px) scale(1.02); box-shadow:0 10px 32px rgba(37,99,235,.52); }
.btn-verify:active { transform:scale(.97); }
.btn-verify:disabled { opacity:.5; cursor:not-allowed; transform:none; background:linear-gradient(135deg,#94a3b8,#64748b); box-shadow:none; }

.btn-resend {
    width:100%; padding:.78rem;
    background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.22);
    color:#F59E0B; border-radius:.95rem; font-weight:800; font-size:.9rem;
    cursor:pointer; font-family:'Cairo',sans-serif;
    display:none; align-items:center; justify-content:center; gap:.55rem;
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
    animation:fadeIn .4s ease;
}
.btn-resend.visible { display:flex; }
html.dark .btn-resend { background:rgba(245,158,11,.13); border-color:rgba(245,158,11,.28); }
.btn-resend:hover { background:rgba(245,158,11,.15); transform:translateY(-2px); box-shadow:0 6px 20px rgba(245,158,11,.25); }
@keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* loading spin */
@keyframes spin { to{transform:rotate(360deg)} }
.spin { animation:spin .8s linear infinite; display:inline-block; }

/* ── Divider ── */
.divider { display:flex; align-items:center; gap:.8rem; margin:.9rem 0; }
.divider-line { flex:1; height:1px; background:rgba(148,163,184,.18); }
html.dark .divider-line { background:rgba(51,65,85,.4); }
.divider-text { font-size:.72rem; font-weight:700; color:#94a3b8; }

/* ── Back link ── */
.back-link {
    display:flex; align-items:center; justify-content:center; gap:.5rem;
    font-size:.84rem; font-weight:700; color:#64748b; text-decoration:none;
    transition:color .22s;
}
html.dark .back-link { color:#94a3b8; }
.back-link:hover { color:#2563EB; }
html.dark .back-link:hover { color:#60a5fa; }
.back-link i { font-size:.72rem; transition:transform .22s; }
.back-link:hover i { transform:translateX(3px); }

/* ── Footer ── */
.page-footer { text-align:center; margin-top:1.2rem; font-size:.73rem; color:#94a3b8; font-weight:600; }
</style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<button class="dark-toggle" onclick="toggleDark()" aria-label="تبديل الوضع">
    <i id="darkIcon" class="fas fa-moon"></i>
</button>

<div class="page-wrap">
    <div class="glass-card">

        <!-- Strip -->
        <div class="card-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">التحقق من الهوية</span>
        </div>

        <div class="card-body">

            <!-- Hero -->
            <div class="card-hero">
                <div class="hero-icon-wrap">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h1 class="card-title">التحقق من الرمز</h1>
                <span class="email-badge">
                    <i class="fas fa-envelope"></i>
                    {{ $email }}
                </span>
            </div>

            <!-- OTP Form -->
            <form action="{{ route('otp.verify.submit') }}" method="POST" id="otpForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="otp" id="otpHidden">

                <p class="otp-label">أدخل الرمز المكوّن من 6 أرقام</p>

                <!-- 6 visual boxes -->
                <div class="otp-row" id="otpRow">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                    <input class="otp-box" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]">
                </div>

                @error('otp')
                    <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror

                <!-- Timer -->
                <div class="timer-wrap">
                    <div class="timer-ring-outer">
                        <svg width="72" height="72" viewBox="0 0 72 72">
                            <circle class="timer-track" cx="36" cy="36" r="30"/>
                            <circle class="timer-fill" id="timerArc" cx="36" cy="36" r="30"
                                    stroke-dasharray="188.5" stroke-dashoffset="0" stroke="#2563EB"/>
                        </svg>
                        <div class="timer-text-wrap">
                            <span class="timer-text" id="timerText" style="color:#2563EB">01:00</span>
                        </div>
                    </div>
                    <span class="timer-sub" id="timerSub">ينتهي الرمز خلال</span>
                </div>

                <button type="submit" class="btn-verify" id="verifyBtn">
                    <span id="btnText" style="display:inline-flex;align-items:center;gap:.55rem;">
                        <i class="fas fa-check-circle"></i>
                        تحقق الآن
                    </span>
                    <span id="btnLoading" style="display:none;align-items:center;gap:.55rem;">
                        <i class="fas fa-circle-notch spin"></i>
                        جاري التحقق...
                    </span>
                </button>

            </form>

            <!-- Resend form -->
            <form action="{{ route('otp.send') }}" method="POST" id="resendForm" style="display:none">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="btn-resend visible" id="resendBtn">
                    <i class="fas fa-rotate-right"></i>
                    إعادة إرسال الرمز
                </button>
            </form>

            <div class="divider" style="margin-top:1.1rem">
                <div class="divider-line"></div>
                <span class="divider-text">أو</span>
                <div class="divider-line"></div>
            </div>

            <a href="{{ route('otp.send') }}" class="back-link">
                تغيير البريد الإلكتروني
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
/* ── Dark mode ── */
function toggleDark() {
    const html = document.documentElement, icon = document.getElementById('darkIcon');
    if (html.classList.contains('dark')) {
        html.classList.remove('dark'); localStorage.setItem('theme','light'); icon.className='fas fa-moon';
    } else {
        html.classList.add('dark'); localStorage.setItem('theme','dark'); icon.className='fas fa-sun';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    if (document.documentElement.classList.contains('dark'))
        document.getElementById('darkIcon').className = 'fas fa-sun';
});

/* ── OTP boxes logic ── */
const boxes     = Array.from(document.querySelectorAll('.otp-box'));
const otpHidden = document.getElementById('otpHidden');
const verifyBtn = document.getElementById('verifyBtn');

boxes.forEach((box, idx) => {
    /* only digits */
    box.addEventListener('keydown', e => {
        if (!/[0-9]/.test(e.key) && !['Backspace','Delete','Tab','ArrowLeft','ArrowRight'].includes(e.key))
            e.preventDefault();
    });

    box.addEventListener('input', e => {
        const val = e.target.value.replace(/\D/g,'');
        box.value = val ? val[val.length-1] : '';
        box.classList.toggle('filled', !!box.value);
        syncHidden();
        if (box.value && idx < 5) boxes[idx+1].focus();
    });

    box.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !box.value && idx > 0) {
            boxes[idx-1].value = '';
            boxes[idx-1].classList.remove('filled');
            boxes[idx-1].focus();
            syncHidden();
        }
    });

    /* paste support */
    box.addEventListener('paste', e => {
        e.preventDefault();
        const data = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g,'').slice(0,6);
        data.split('').forEach((ch, i) => {
            if (boxes[i]) { boxes[i].value = ch; boxes[i].classList.add('filled'); }
        });
        syncHidden();
        const next = Math.min(data.length, 5);
        boxes[next].focus();
    });
});

function syncHidden() {
    otpHidden.value = boxes.map(b => b.value).join('');
}

/* ── Timer ── */
const TOTAL   = 60;
let remaining = TOTAL;
const arc     = document.getElementById('timerArc');
const txt     = document.getElementById('timerText');
const sub     = document.getElementById('timerSub');
const CIRCUM  = 2 * Math.PI * 30; /* r=30 → 188.5 */

function updateTimer() {
    const ratio  = remaining / TOTAL;
    const offset = CIRCUM * (1 - ratio);
    arc.style.strokeDashoffset = offset;

    /* colour shift: blue → amber → red */
    let color;
    if (remaining > 30)      color = '#2563EB';
    else if (remaining > 10) color = '#F59E0B';
    else                     color = '#EF4444';
    arc.style.stroke  = color;
    txt.style.color   = color;

    const m = Math.floor(remaining / 60);
    const s = remaining % 60;
    txt.textContent = `${m < 10 ? '0':''}${m}:${s < 10 ? '0':''}${s}`;
}

updateTimer();

const countdown = setInterval(() => {
    remaining--;
    updateTimer();

    if (remaining <= 0) {
        clearInterval(countdown);
        verifyBtn.disabled = true;
        txt.textContent = 'انتهى';
        sub.textContent = 'انتهت الصلاحية';
        arc.style.stroke = '#EF4444';
        txt.style.color  = '#EF4444';
        /* show resend */
        document.getElementById('resendForm').style.display = 'block';
    }
}, 1000);

/* ── Form submit ── */
document.getElementById('otpForm').addEventListener('submit', function (e) {
    const code = boxes.map(b => b.value).join('');
    if (code.length < 6) {
        e.preventDefault();
        boxes.forEach(b => b.classList.add('error-box'));
        setTimeout(() => boxes.forEach(b => b.classList.remove('error-box')), 600);
        boxes[0].focus();
        return;
    }
    verifyBtn.disabled = true;
    document.getElementById('btnText').style.display    = 'none';
    document.getElementById('btnLoading').style.display = 'inline-flex';
});

/* shake on Laravel error */
@error('otp')
document.addEventListener('DOMContentLoaded', () => {
    boxes.forEach(b => b.classList.add('error-box'));
    setTimeout(() => boxes.forEach(b => b.classList.remove('error-box')), 600);
});
@enderror
</script>

</body>
</html>