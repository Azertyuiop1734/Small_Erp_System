<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
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
    position: relative; 
}
html.dark body { background: #04080f; }

body::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.10) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(16,185,129,.07) 0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 35%, rgba(99,102,241,.06) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 15%, rgba(37,99,235,.16) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 80%, rgba(16,185,129,.11) 0%, transparent 60%);
}

/* ── Orbs ── */
.orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
.orb-1 { width:380px;height:380px; background:rgba(37,99,235,.07);   top:-100px; right:-100px; animation-delay:0s;  }
.orb-2 { width:280px;height:280px; background:rgba(16,185,129,.06);  bottom:5%;  left:-70px;  animation-delay:-5s; }
.orb-3 { width:200px;height:200px; background:rgba(99,102,241,.05);  top:45%;    right:5%;    animation-delay:-9s; }
html.dark .orb-1 { background:rgba(37,99,235,.14); }
html.dark .orb-2 { background:rgba(16,185,129,.11); }
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
    background:linear-gradient(135deg,rgba(16,185,129,.08) 0%,rgba(37,99,235,.06) 100%);
    border-bottom:1px solid rgba(16,185,129,.09);
    padding:.95rem 2rem; display:flex; align-items:center; gap:.7rem;
}
html.dark .card-strip { background:linear-gradient(135deg,rgba(16,185,129,.12) 0%,rgba(37,99,235,.09) 100%); border-bottom-color:rgba(51,65,85,.4); }
.strip-dot { width:8px;height:8px;border-radius:50%;background:#10B981;box-shadow:0 0 9px rgba(16,185,129,.7);flex-shrink:0; }
.strip-label { font-size:.71rem;font-weight:900;color:#10B981;text-transform:uppercase;letter-spacing:.1em; }
html.dark .strip-label { color:#34d399; }

/* ── Body ── */
.card-body { padding:2.2rem 2.2rem 2rem; }

/* ── Hero ── */
.card-hero { display:flex; flex-direction:column; align-items:center; text-align:center; margin-bottom:1.8rem; }

.hero-icon-wrap {
    width:70px; height:70px; margin-bottom:1rem;
    background:linear-gradient(135deg,#10B981 0%,#2563EB 100%);
    border-radius:22px;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 10px 32px rgba(16,185,129,.4), 0 0 0 3px rgba(16,185,129,.15);
    position:relative;
}
.hero-icon-wrap::after { content:'';position:absolute;inset:-3px;border-radius:25px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
.hero-icon-wrap i { color:#fff; font-size:1.75rem; position:relative; z-index:1; }

.card-title { font-size:1.45rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; margin-bottom:.4rem; }
html.dark .card-title { color:#f1f5f9; }

.card-subtitle {
    font-size:.85rem; font-weight:600; color:#64748b; margin-top:.2rem;
}
html.dark .card-subtitle { color:#94a3b8; }

.email-badge {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.3rem .9rem; border-radius:999px;
    background:rgba(37,99,235,.09); border:1px solid rgba(37,99,235,.18);
    font-size:.82rem; font-weight:800; color:#2563EB;
    margin-top:.5rem;
}
html.dark .email-badge { background:rgba(37,99,235,.16); color:#60a5fa; }
.email-badge i { font-size:.68rem; }

/* ── Form fields ── */
.field-group { margin-bottom:1.3rem; position:relative; }
.field-label {
    display:flex; align-items:center; gap:.4rem;
    font-size:.72rem; font-weight:900; color:#10B981;
    text-transform:uppercase; letter-spacing:.08em;
    margin-bottom:.5rem;
}
html.dark .field-label { color:#34d399; }

.field-input-wrap {
    position:relative;
    background:rgba(255,255,255,.62); backdrop-filter:blur(8px);
    border:1.5px solid rgba(148,163,184,.25); border-radius:1rem;
    transition:border-color .2s ease, box-shadow .2s ease, background .2s ease;
    overflow:hidden;
}
html.dark .field-input-wrap { background:rgba(15,23,42,.52); border-color:rgba(51,65,85,.48); }
.field-input-wrap:focus-within {
    border-color:rgba(37,99,235,.55);
    box-shadow:0 0 0 3px rgba(37,99,235,.14), 0 4px 14px rgba(37,99,235,.08);
    background:rgba(255,255,255,.92);
}
html.dark .field-input-wrap:focus-within { background:rgba(15,23,42,.9); }

.field-input-wrap.error {
    border-color:rgba(239,68,68,.5);
    box-shadow:0 0 0 3px rgba(239,68,68,.12);
    animation:shake .4s ease;
}

.field-icon {
    position:absolute; top:50%; right:1rem; transform:translateY(-50%);
    color:#94a3b8; font-size:.9rem; pointer-events:none;
    transition:color .2s;
}
.field-input-wrap:focus-within .field-icon { color:#2563EB; }

.field-input {
    width:100%; padding:.85rem 2.6rem .85rem 1rem;
    background:transparent; border:none; outline:none;
    font-size:.95rem; font-weight:700; color:#1e293b;
    font-family:'Cairo',sans-serif;
}
html.dark .field-input { color:#f1f5f9; }
.field-input::placeholder { color:#94a3b8; font-weight:600; }

.field-error {
    display:flex; align-items:center; gap:.38rem;
    font-size:.76rem; font-weight:700; color:#EF4444;
    margin-top:.4rem;
}

/* toggle password */
.toggle-pass {
    position:absolute; top:50%; left:1rem; transform:translateY(-50%);
    background:none; border:none; cursor:pointer;
    color:#94a3b8; font-size:.85rem;
    transition:color .2s;
}
.toggle-pass:hover { color:#2563EB; }

/* strength bar */
.strength-wrap { margin-top:.5rem; display:flex; align-items:center; gap:.5rem; }
.strength-bar { flex:1; height:4px; border-radius:999px; background:rgba(148,163,184,.2); overflow:hidden; }
.strength-fill { height:100%; width:0; border-radius:999px; transition:width .3s ease, background .3s ease; }
.strength-text { font-size:.65rem; font-weight:800; color:#94a3b8; min-width:45px; text-align:left; }

/* ── Buttons ── */
.btn-submit {
    width:100%; padding:.9rem;
    background:linear-gradient(135deg,#10B981 0%,#2563EB 100%);
    color:#fff; border-radius:.95rem; font-weight:800; font-size:.96rem;
    border:none; cursor:pointer;
    box-shadow:0 6px 24px rgba(16,185,129,.4);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
    font-family:'Cairo',sans-serif;
    display:flex; align-items:center; justify-content:center; gap:.6rem;
    position:relative; overflow:hidden; margin-top:.5rem;
}
.btn-submit::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s; }
.btn-submit:not(:disabled):hover::before { left:160%; }
.btn-submit:not(:disabled):hover { transform:translateY(-2px) scale(1.02); box-shadow:0 10px 32px rgba(16,185,129,.52); }
.btn-submit:active { transform:scale(.97); }
.btn-submit:disabled { opacity:.5; cursor:not-allowed; transform:none; background:linear-gradient(135deg,#94a3b8,#64748b); box-shadow:none; }

/* loading spin */
@keyframes spin { to{transform:rotate(360deg)} }
.spin { animation:spin .8s linear infinite; display:inline-block; }

/* ── Divider ── */
.divider { display:flex; align-items:center; gap:.8rem; margin:1.2rem 0; }
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

@keyframes shake {
    0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)}
}
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
            <span class="strip-label">أمان الحساب</span>
        </div>

        <div class="card-body">

            <!-- Hero -->
            <div class="card-hero">
                <div class="hero-icon-wrap">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="card-title">إعادة تعيين كلمة المرور</h1>
                <p class="card-subtitle">أنشئ كلمة مرور قوية لحماية حسابك</p>
                <span class="email-badge">
                    <i class="fas fa-envelope"></i>
                    {{ $email }}
                </span>
            </div>

            <!-- Reset Form -->
            <form action="{{ route('otp.reset.submit') }}" method="POST" id="resetForm">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Password -->
                <div class="field-group">
                    <label class="field-label">
                        <i class="fas fa-lock"></i>
                        كلمة المرور الجديدة
                    </label>
                    <div class="field-input-wrap @error('password') error @enderror">
                        <i class="field-icon fas fa-key"></i>
                        <input type="password" name="password" id="password" 
                               class="field-input" placeholder="أدخل كلمة المرور الجديدة" required>
                        <button type="button" class="toggle-pass" onclick="togglePass('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="strength-wrap" id="strengthWrap" style="display:none;">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText">ضعيفة</span>
                    </div>
                    @error('password')
                        <p class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="field-group">
                    <label class="field-label">
                        <i class="fas fa-check-double"></i>
                        تأكيد كلمة المرور
                    </label>
                    <div class="field-input-wrap @error('password_confirmation') error @enderror" id="confirmWrap">
                        <i class="field-icon fas fa-lock"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="field-input" placeholder="أعد إدخال كلمة المرور" required>
                        <button type="button" class="toggle-pass" onclick="togglePass('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="field-error" id="matchError" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i>كلمتا المرور غير متطابقتين
                    </p>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span id="btnText" style="display:inline-flex;align-items:center;gap:.55rem;">
                        <i class="fas fa-rotate"></i>
                        تحديث كلمة المرور
                    </span>
                    <span id="btnLoading" style="display:none;align-items:center;gap:.55rem;">
                        <i class="fas fa-circle-notch spin"></i>
                        جاري التحديث...
                    </span>
                </button>
            </form>

            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-text">أو</span>
                <div class="divider-line"></div>
            </div>

            <a href="{{ route('otp.send') }}" class="back-link">
                العودة لصفحة التحقق
                <i class="fas fa-arrow-left"></i>
            </a>

        </div>
    </div>

    <p class="page-footer">
        <i class="fas fa-shield-alt" style="color:#10B981;font-size:.7rem;"></i>
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

/* ── Toggle password visibility ── */
function togglePass(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

/* ── Password strength ── */
const passwordInput = document.getElementById('password');
const strengthWrap = document.getElementById('strengthWrap');
const strengthFill = document.getElementById('strengthFill');
const strengthText = document.getElementById('strengthText');

passwordInput.addEventListener('input', function() {
    const val = this.value;
    if (val.length === 0) {
        strengthWrap.style.display = 'none';
        return;
    }
    strengthWrap.style.display = 'flex';
    
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    
    const colors = ['#EF4444', '#F59E0B', '#3B82F6', '#10B981'];
    const labels = ['ضعيفة', 'متوسطة', 'جيدة', 'قوية'];
    const widths = ['25%', '50%', '75%', '100%'];
    
    strengthFill.style.width = widths[score] || '25%';
    strengthFill.style.background = colors[score] || colors[0];
    strengthText.textContent = labels[score] || labels[0];
    strengthText.style.color = colors[score] || colors[0];
});

/* ── Password match ── */
const confirmInput = document.getElementById('password_confirmation');
const confirmWrap = document.getElementById('confirmWrap');
const matchError = document.getElementById('matchError');

function checkMatch() {
    if (confirmInput.value && passwordInput.value !== confirmInput.value) {
        confirmWrap.classList.add('error');
        matchError.style.display = 'flex';
        return false;
    } else {
        confirmWrap.classList.remove('error');
        matchError.style.display = 'none';
        return true;
    }
}

confirmInput.addEventListener('input', checkMatch);
passwordInput.addEventListener('input', () => {
    if (confirmInput.value) checkMatch();
});

/* ── Form submit ── */
document.getElementById('resetForm').addEventListener('submit', function(e) {
    if (!checkMatch() || passwordInput.value.length < 6) {
        e.preventDefault();
        if (passwordInput.value.length < 6) {
            passwordInput.parentElement.classList.add('error');
            setTimeout(() => passwordInput.parentElement.classList.remove('error'), 600);
        }
        return;
    }
    document.getElementById('submitBtn').disabled = true;
    document.getElementById('btnText').style.display = 'none';
    document.getElementById('btnLoading').style.display = 'inline-flex';
});

/* shake on Laravel error */
@error('password')
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('password').parentElement.classList.add('error');
    setTimeout(() => document.getElementById('password').parentElement.classList.remove('error'), 600);
});
@enderror
</script>

</body>
</html>