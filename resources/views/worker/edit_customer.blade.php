<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل بيانات الزبون</title>
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
    padding: 2rem 1rem;
    background: #f1f5f9;
    transition: background 0.4s ease;
    position: relative; overflow-x: hidden;
}
html.dark body { background: #04080f; }

/* ── Ambient gradients ── */
body::before {
    content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(245,158,11,.10) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(217,119,6,.08)  0%, transparent 60%),
        radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(251,191,36,.06) 0%, transparent 50%);
}
html.dark body::before {
    background:
        radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(245,158,11,.15) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(217,119,6,.12)  0%, transparent 60%);
}

/* ── Floating orbs ── */
.orb {
    position: fixed; border-radius: 50%;
    filter: blur(72px); pointer-events: none; z-index: 0;
    animation: floatOrb 13s ease-in-out infinite;
}
.orb-1 { width:340px;height:340px; background:rgba(245,158,11,.08);  top:-90px;  right:-90px; animation-delay:0s;  }
.orb-2 { width:260px;height:260px; background:rgba(217,119,6,.07);   bottom:8%;  left:-60px;  animation-delay:-5s; }
.orb-3 { width:190px;height:190px; background:rgba(251,191,36,.05);  top:45%;    right:3%;    animation-delay:-9s; }
html.dark .orb-1 { background:rgba(245,158,11,.14); }
html.dark .orb-2 { background:rgba(217,119,6,.12);  }

@keyframes floatOrb {
    0%,100% { transform:translateY(0)     scale(1);    }
    50%      { transform:translateY(-28px) scale(1.06); }
}

/* ── Dark toggle ── */
.dark-toggle {
    position: fixed; top: 1.3rem; left: 1.3rem; z-index: 1000;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.65); backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,.7);
    box-shadow: 0 3px 14px rgba(0,0,0,.09);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .28s cubic-bezier(.34,1.56,.64,1);
}
html.dark .dark-toggle { background: rgba(15,23,42,.7); border-color: rgba(51,65,85,.5); }
.dark-toggle:hover { transform: scale(1.12); box-shadow: 0 6px 22px rgba(245,158,11,.28); }
.dark-toggle i { font-size: 1rem; color: #64748b; transition: color .25s ease; }
html.dark .dark-toggle i { color: #FBBF24; }

/* ── Page wrapper ── */
.page-wrap {
    width: 100%; max-width: 820px;
    position: relative; z-index: 1;
    animation: pageIn .7s cubic-bezier(.34,1.56,.64,1) both;
}
@keyframes pageIn {
    from { opacity:0; transform:translateY(28px) scale(.97); }
    to   { opacity:1; transform:translateY(0)     scale(1);   }
}

/* ── Glass card ── */
.glass-card {
    background: rgba(255,255,255,.55);
    backdrop-filter: blur(26px); -webkit-backdrop-filter: blur(26px);
    border: 1px solid rgba(255,255,255,.68); border-radius: 2.2rem;
    box-shadow:
        0 2px 0 rgba(255,255,255,.92) inset,
        0 32px 72px rgba(0,0,0,.10),
        0 8px 24px rgba(0,0,0,.06);
    overflow: hidden; position: relative;
}
html.dark .glass-card {
    background: rgba(10,17,34,.72);
    border-color: rgba(51,65,85,.45);
    box-shadow: 0 32px 72px rgba(0,0,0,.45);
}
.glass-card::before {
    content: ''; position: absolute; top:-80px; right:-80px;
    width:280px; height:280px; background:rgba(245,158,11,.06);
    border-radius:50%; filter:blur(80px); pointer-events:none; display:none;
}
html.dark .glass-card::before { display:block; }

/* ── Card strip ── */
.card-strip {
    background: linear-gradient(135deg,rgba(245,158,11,.08) 0%,rgba(217,119,6,.06) 100%);
    border-bottom: 1px solid rgba(245,158,11,.10);
    padding: 1rem 2rem;
    display: flex; align-items: center; gap: .7rem;
}
html.dark .card-strip {
    background: linear-gradient(135deg,rgba(245,158,11,.12) 0%,rgba(217,119,6,.09) 100%);
    border-bottom-color: rgba(51,65,85,.4);
}
.strip-dot { width:8px;height:8px;border-radius:50%;background:#F59E0B;box-shadow:0 0 9px rgba(245,158,11,.7);flex-shrink:0; }
.strip-label { font-size:.71rem;font-weight:900;color:#F59E0B;text-transform:uppercase;letter-spacing:.1em; }
html.dark .strip-label { color:#FBBF24; }

.strip-back {
    margin-right: auto;
    display: inline-flex; align-items: center; gap: .45rem;
    font-size: .78rem; font-weight: 700; color: #94a3b8;
    text-decoration: none; transition: color .2s ease;
}
.strip-back:hover { color: #F59E0B; }
html.dark .strip-back:hover { color: #FBBF24; }
.strip-back i { transition: transform .2s ease; font-size:.7rem; }
.strip-back:hover i { transform: translateX(3px); }

/* ── Card body ── */
.card-body { padding: 2.4rem 2.6rem 2.2rem; position: relative; z-index: 1; }

/* ── Title block ── */
.title-block { display:flex;align-items:center;gap:1.2rem;margin-bottom:2.2rem; }
.title-icon {
    width:60px;height:60px;flex-shrink:0;
    background:linear-gradient(135deg,#F59E0B 0%,#D97706 100%);
    border-radius:18px;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 8px 28px rgba(245,158,11,.38),0 0 0 3px rgba(245,158,11,.14);
    position:relative;
}
.title-icon::after {
    content:'';position:absolute;inset:-3px;border-radius:21px;
    background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none;
}
.title-icon i { color:#fff;font-size:1.5rem;position:relative;z-index:1; }
.title-text h1 { font-size:1.7rem;font-weight:900;color:#1e293b;letter-spacing:-.03em;line-height:1.15; }
html.dark .title-text h1 { color:#f1f5f9; }
.title-text p { font-size:.85rem;font-weight:600;color:#64748b;margin-top:3px; }
html.dark .title-text p { color:#94a3b8; }
.title-text p span { color:#F59E0B;font-weight:900; }
html.dark .title-text p span { color:#FBBF24; }

/* ── Fields grid ── */
.fields-grid { display:grid;grid-template-columns:repeat(2,1fr);gap:1.4rem;margin-bottom:1.4rem; }
.field-full { grid-column:1/-1; }

.field-group { display:flex;flex-direction:column;gap:.48rem;animation:fieldIn .45s ease both; }
.field-group:nth-child(1){animation-delay:.06s}
.field-group:nth-child(2){animation-delay:.11s}
.field-group:nth-child(3){animation-delay:.16s}
.field-group:nth-child(4){animation-delay:.21s}
.field-group:nth-child(5){animation-delay:.26s}

@keyframes fieldIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

.field-label { font-size:.71rem;font-weight:900;color:#F59E0B;text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:.38rem; }
html.dark .field-label { color:#FBBF24; }
.field-label i { font-size:.63rem;opacity:.85; }

/* ── Inputs ── */
.field-wrap { position:relative; }
.field-input {
    width:100%;padding:.88rem 1.15rem;
    background:rgba(255,255,255,.62);backdrop-filter:blur(8px);
    border:1px solid rgba(148,163,184,.22);border-radius:.95rem;
    font-size:.94rem;font-family:'Cairo',sans-serif;font-weight:600;color:#1e293b;
    outline:none;direction:rtl;
    transition:border-color .22s ease,box-shadow .22s ease,background .22s ease;
}
html.dark .field-input { background:rgba(15,23,42,.52);border-color:rgba(51,65,85,.48);color:#f1f5f9; }
.field-input::placeholder { color:#94a3b8;font-weight:500; }
.field-input:focus {
    border-color:rgba(245,158,11,.55);
    box-shadow:0 0 0 3px rgba(245,158,11,.13),0 4px 14px rgba(245,158,11,.07);
    background:rgba(255,255,255,.88);
}
html.dark .field-input:focus { background:rgba(15,23,42,.88);box-shadow:0 0 0 3px rgba(245,158,11,.20); }
textarea.field-input { resize:none; }
.field-input.has-suffix { padding-left:3.4rem; }

.field-suffix {
    position:absolute;left:1rem;top:50%;transform:translateY(-50%);
    font-size:.7rem;font-weight:800;color:#94a3b8;
    background:rgba(148,163,184,.1);padding:2px 7px;border-radius:6px;
    letter-spacing:.05em;pointer-events:none;
}
html.dark .field-suffix { background:rgba(71,85,105,.28);color:#64748b; }

/* ── Divider ── */
.form-divider { border:none;border-top:1px solid rgba(148,163,184,.12);margin:.4rem 0 1.7rem; }
html.dark .form-divider { border-color:rgba(51,65,85,.32); }

/* ── Footer ── */
.form-footer { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }

.last-update {
    display:inline-flex;align-items:center;gap:.42rem;
    font-size:.77rem;font-weight:600;color:#94a3b8;
    background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.16);
    padding:.38rem .9rem;border-radius:999px;
}
html.dark .last-update { background:rgba(245,158,11,.10);border-color:rgba(245,158,11,.22); }
.last-update i { color:#F59E0B;font-size:.68rem; }

/* ── Submit ── */
.btn-submit {
    display:inline-flex;align-items:center;gap:.65rem;
    padding:.82rem 2.1rem;
    background:linear-gradient(135deg,#F59E0B 0%,#D97706 100%);
    color:#fff;border-radius:.95rem;font-weight:800;font-size:.93rem;
    border:none;cursor:pointer;
    box-shadow:0 6px 22px rgba(245,158,11,.38);
    transition:all .25s cubic-bezier(.34,1.56,.64,1);
    font-family:'Cairo',sans-serif;position:relative;overflow:hidden;flex-shrink:0;
}
.btn-submit::before {
    content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);
    transition:left .5s ease;
}
.btn-submit:hover::before { left:160%; }
.btn-submit:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 10px 30px rgba(245,158,11,.55); }
.btn-submit:active { transform:scale(.96); }
.btn-submit i { transition:transform .35s cubic-bezier(.34,1.56,.64,1); }
.btn-submit:hover i { transform:rotate(180deg) scale(1.15); }

/* ── Custom Alert ── */
.ca-overlay {
    position:fixed;inset:0;z-index:9999;
    display:flex;align-items:center;justify-content:center;padding:1rem;
    background:rgba(2,10,28,.42);
    backdrop-filter:blur(10px);-webkit-backdrop-filter:blur(10px);
    opacity:0;pointer-events:none;transition:opacity .3s ease;
}
.ca-overlay.ca-show { opacity:1;pointer-events:all; }
.ca-card {
    width:100%;max-width:400px;
    background:rgba(255,255,255,.72);
    backdrop-filter:blur(28px);-webkit-backdrop-filter:blur(28px);
    border:1px solid rgba(255,255,255,.65);border-radius:2rem;overflow:hidden;
    box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.16);
    transform:scale(.82) translateY(28px);opacity:0;
    transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
    direction:rtl;
}
html.dark .ca-card { background:rgba(10,17,34,.82);border-color:rgba(51,65,85,.55); }
.ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0);opacity:1; }
.ca-bar { height:4px;width:100%; }
.ca-bar.success { background:linear-gradient(90deg,#F59E0B,#D97706); }
.ca-bar.error   { background:linear-gradient(90deg,#EF4444,#DC2626); }
.ca-body { padding:2rem 2rem 1.5rem;display:flex;flex-direction:column;align-items:center;text-align:center; }
.ca-icon-ring { width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;flex-shrink:0; }
.ca-icon-ring.success { background:radial-gradient(circle at 35% 35%,rgba(245,158,11,.22),rgba(245,158,11,.06));border:1.5px solid rgba(245,158,11,.3);box-shadow:0 0 0 8px rgba(245,158,11,.07); }
.ca-icon-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.20),rgba(239,68,68,.05));border:1.5px solid rgba(239,68,68,.28);box-shadow:0 0 0 8px rgba(239,68,68,.06); }
.ca-icon-ring svg { width:34px;height:34px;overflow:visible; }
.ca-check-circle { stroke:#F59E0B;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
.ca-check-mark   { stroke:#F59E0B;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48; }
.ca-error-circle { stroke:#EF4444;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
.ca-error-x1,.ca-error-x2 { stroke:#EF4444;stroke-width:3;stroke-linecap:round;stroke-dasharray:30;stroke-dashoffset:30; }
.ca-overlay.ca-show .ca-check-circle { animation:caStroke .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
.ca-overlay.ca-show .ca-check-mark   { animation:caStroke .38s .55s cubic-bezier(.65,0,.45,1) forwards; }
.ca-overlay.ca-show .ca-error-circle { animation:caStroke .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
.ca-overlay.ca-show .ca-error-x1     { animation:caStroke .28s .55s ease forwards; }
.ca-overlay.ca-show .ca-error-x2     { animation:caStroke .28s .72s ease forwards; }
@keyframes caStroke { to { stroke-dashoffset:0; } }
.ca-title { font-size:1.18rem;font-weight:900;color:#1e293b;letter-spacing:-.025em;line-height:1.25;margin-bottom:.42rem; }
html.dark .ca-title { color:#f1f5f9; }
.ca-msg   { font-size:.87rem;font-weight:600;color:#64748b;line-height:1.7; }
html.dark .ca-msg { color:#94a3b8; }
.ca-progress-wrap { width:100%;height:3px;background:rgba(148,163,184,.12);margin-top:1.4rem;border-radius:99px;overflow:hidden; }
.ca-progress-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#F59E0B,#D97706);transform-origin:left; }
.ca-progress-fill.running { animation:caProgress var(--ca-dur,3.8s) linear forwards; }
@keyframes caProgress { from{transform:scaleX(1)} to{transform:scaleX(0)} }
.ca-footer { padding:0 2rem 1.8rem;display:flex;justify-content:center; }
.ca-btn {
    font-family:'Cairo','Tajawal',sans-serif;font-weight:800;font-size:.9rem;
    padding:.65rem 2.2rem;border-radius:.9rem;border:none;cursor:pointer;
    transition:all .25s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden;
}
.ca-btn.success { background:linear-gradient(135deg,#F59E0B,#D97706);color:#fff;box-shadow:0 5px 18px rgba(245,158,11,.38); }
.ca-btn.success:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(245,158,11,.55); }
.ca-btn.error   { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;box-shadow:0 5px 18px rgba(239,68,68,.32); }
.ca-btn.error:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(239,68,68,.48); }
.ca-btn:active { transform:scale(.96); }
.ca-btn::before {
    content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);
    transition:left .5s ease;
}
.ca-btn:hover::before { left:160%; }

/* ── Responsive ── */
@media(max-width:600px){
    .fields-grid { grid-template-columns:1fr; }
    .field-full  { grid-column:auto; }
    .card-body   { padding:1.6rem 1.3rem; }
    .form-footer { flex-direction:column;align-items:stretch; }
    .btn-submit  { justify-content:center; }
    .title-text h1 { font-size:1.4rem; }
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

<!-- Page -->
<div class="page-wrap">
    <div class="glass-card">

        <!-- Strip -->
        <div class="card-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">تعديل البيانات</span>
            <a href="{{ route('customers.index') }}" class="strip-back">
                إلغاء والعودة
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Title -->
            <div class="title-block">
                <div class="title-icon">
                    <i class="fas fa-user-pen"></i>
                </div>
                <div class="title-text">
                    <h1>تعديل بيانات الزبون</h1>
                    <p>الزبون الحالي: <span>{{ $customer->name }}</span></p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="fields-grid">

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-user"></i> الاسم الكامل</label>
                        <div class="field-wrap">
                            <input type="text" name="name" required class="field-input"
                                   value="{{ old('name', $customer->name) }}">
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-phone-alt"></i> رقم الهاتف</label>
                        <div class="field-wrap">
                            <input type="text" name="phone" required class="field-input"
                                   value="{{ old('phone', $customer->phone) }}"
                                   dir="ltr" style="text-align:right;">
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-wallet"></i> الرصيد الحالي</label>
                        <div class="field-wrap">
                            <input type="number" name="balance" step="0.01"
                                   class="field-input has-suffix"
                                   value="{{ old('balance', $customer->balance) }}">
                            <span class="field-suffix">DA</span>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-percentage"></i> نسبة الخصم</label>
                        <div class="field-wrap">
                            <input type="number" name="discount" step="0.01"
                                   class="field-input has-suffix"
                                   value="{{ old('discount', $customer->discount) }}">
                            <span class="field-suffix">%</span>
                        </div>
                    </div>

                    <div class="field-group field-full">
                        <label class="field-label"><i class="fas fa-map-marker-alt"></i> العنوان الكامل</label>
                        <div class="field-wrap">
                            <textarea name="address" rows="3" class="field-input">{{ old('address', $customer->address) }}</textarea>
                        </div>
                    </div>

                </div>

                <hr class="form-divider">

                <div class="form-footer">
                    <span class="last-update">
                        <i class="fas fa-history"></i>
                        آخر تحديث: {{ $customer->updated_at->diffForHumans() }}
                    </span>
                    <button type="submit" class="btn-submit">
                        <span>تحديث البيانات</span>
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Custom Alert -->
<div class="ca-overlay" id="caOverlay">
    <div class="ca-card">
        <div class="ca-bar" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-icon-ring" id="caRing"></div>
            <p class="ca-title" id="caTitle"></p>
            <p class="ca-msg"   id="caMsg"></p>
            <div class="ca-progress-wrap" id="caProgressWrap" style="display:none">
                <div class="ca-progress-fill" id="caProgressFill"></div>
            </div>
        </div>
        <div class="ca-footer">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

<script>
/* Dark mode */
function toggleDark(){
    const html = document.documentElement;
    const icon = document.getElementById('darkIcon');
    if(html.classList.contains('dark')){
        html.classList.remove('dark');
        localStorage.setItem('theme','light');
        icon.className='fas fa-moon';
    } else {
        html.classList.add('dark');
        localStorage.setItem('theme','dark');
        icon.className='fas fa-sun';
    }
}
document.addEventListener('DOMContentLoaded',()=>{
    if(document.documentElement.classList.contains('dark'))
        document.getElementById('darkIcon').className='fas fa-sun';
});

/* Custom Alert */
const CA_SVG = {
    success:`<svg viewBox="0 0 52 52"><circle class="ca-check-circle" cx="26" cy="26" r="25"/><path class="ca-check-mark" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
    error:  `<svg viewBox="0 0 52 52"><circle class="ca-error-circle" cx="26" cy="26" r="25"/><line class="ca-error-x1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-error-x2" x1="36" y1="16" x2="16" y2="36"/></svg>`
};
let caTimer=null;

function caShow({type,title,msg,btnText,autoClose}){
    const o=document.getElementById('caOverlay'),bar=document.getElementById('caBar'),
          rng=document.getElementById('caRing'),t=document.getElementById('caTitle'),
          m=document.getElementById('caMsg'),btn=document.getElementById('caBtn'),
          pw=document.getElementById('caProgressWrap'),pf=document.getElementById('caProgressFill');
    o.classList.remove('ca-show');
    bar.className=`ca-bar ${type}`;rng.className=`ca-icon-ring ${type}`;
    rng.innerHTML=CA_SVG[type];t.textContent=title;m.textContent=msg;
    btn.className=`ca-btn ${type}`;btn.textContent=btnText;
    if(autoClose){
        pw.style.display='block';pf.className='ca-progress-fill';
        pf.style.setProperty('--ca-dur',autoClose/1000+'s');
        void pf.offsetWidth;pf.classList.add('running');
        caTimer=setTimeout(caClose,autoClose);
    } else { pw.style.display='none'; }
    requestAnimationFrame(()=>o.classList.add('ca-show'));
}
function caClose(){ clearTimeout(caTimer);document.getElementById('caOverlay').classList.remove('ca-show'); }
document.getElementById('caOverlay').addEventListener('click',function(e){ if(e.target===this)caClose(); });

@if(session('update_success'))
document.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'success',title:'تم التحديث!',msg:'{{ session("update_success") }}',btnText:'حسناً',autoClose:3800});
});
@endif

@if($errors->any())
document.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'error',title:'تحقق من البيانات',msg:'{{ $errors->first() }}',btnText:'سأصحح الآن'});
});
@endif
</script>

</body>
</html>