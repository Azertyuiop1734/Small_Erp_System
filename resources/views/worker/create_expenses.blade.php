@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BACKGROUND ===== */
    .exp-page {
        min-height: 100vh;
        padding: 2.5rem 1rem;
        display: flex; align-items: flex-start; justify-content: center;
        position: relative; overflow-x: hidden;
    }
    .exp-page::before {
        content: ''; position: fixed; inset: 0; pointer-events: none; z-index: 0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%,  rgba(239,68,68,.09)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%,  rgba(217,70,239,.07) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 60% 30%,  rgba(251,113,133,.05)0%, transparent 50%);
    }
    .dark .exp-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%,  rgba(239,68,68,.14)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%,  rgba(217,70,239,.11) 0%, transparent 60%);
    }

    /* Orbs */
    .exp-orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:eOrb 13s ease-in-out infinite; }
    .exp-orb-1 { width:320px;height:320px; background:rgba(239,68,68,.07);   top:-80px;  right:-80px; animation-delay:0s;  }
    .exp-orb-2 { width:240px;height:240px; background:rgba(217,70,239,.06);  bottom:10%; left:-60px;  animation-delay:-5s; }
    .exp-orb-3 { width:180px;height:180px; background:rgba(251,113,133,.05); top:45%;    right:4%;    animation-delay:-9s; }
    .dark .exp-orb-1 { background:rgba(239,68,68,.13); }
    .dark .exp-orb-2 { background:rgba(217,70,239,.11); }
    @keyframes eOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

    /* ===== WRAPPER ===== */
    .exp-wrap { width:100%; max-width:640px; position:relative; z-index:1; animation:expIn .7s cubic-bezier(.34,1.56,.64,1) both; }
    @keyframes expIn { from{opacity:0;transform:translateY(24px) scale(.97)} to{opacity:1;transform:translateY(0) scale(1)} }

    /* ===== HEADER ===== */
    .exp-header { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1.2rem; margin-bottom:1.8rem; }

    .exp-brand { display:flex; align-items:center; gap:1.1rem; }

    .exp-icon-wrap {
        width:60px; height:60px; flex-shrink:0;
        background:linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(239,68,68,.38),0 0 0 3px rgba(239,68,68,.15);
        position:relative;
    }
    .exp-icon-wrap::after { content:'';position:absolute;inset:-3px;border-radius:21px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
    .exp-icon-wrap i { color:#fff; font-size:1.4rem; position:relative; z-index:1; }

    .exp-title { font-size:1.75rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1.1; }
    .dark .exp-title { color:#f1f5f9; }
    .exp-subtitle { font-size:.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .exp-subtitle { color:#94a3b8; }

    .btn-back {
        display:inline-flex; align-items:center; gap:.55rem;
        padding:.6rem 1.2rem;
        background:rgba(255,255,255,.6); backdrop-filter:blur(12px);
        color:#64748b; border-radius:.95rem; font-weight:700; font-size:.85rem;
        text-decoration:none; border:1px solid rgba(255,255,255,.7);
        box-shadow:0 2px 12px rgba(0,0,0,.04);
        transition:all .25s cubic-bezier(.34,1.56,.64,1); flex-shrink:0;
    }
    .dark .btn-back { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.5); color:#94a3b8; }
    .btn-back:hover { color:#EF4444; border-color:rgba(239,68,68,.35); box-shadow:0 4px 20px rgba(239,68,68,.15); transform:translateY(-2px); }
    .dark .btn-back:hover { color:#f87171; }
    .btn-back i { transition:transform .22s ease; font-size:.75rem; }
    .btn-back:hover i { transform:translateX(3px); }

    /* ===== FORM CARD ===== */
    .exp-card {
        background:rgba(255,255,255,.55); backdrop-filter:blur(26px); -webkit-backdrop-filter:blur(26px);
        border:1px solid rgba(255,255,255,.68); border-radius:2rem;
        box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 72px rgba(0,0,0,.08),0 8px 24px rgba(0,0,0,.05);
        overflow:hidden; position:relative;
    }
    .dark .exp-card { background:rgba(10,17,34,.72); border-color:rgba(51,65,85,.45); box-shadow:0 32px 72px rgba(0,0,0,.4); }
    .exp-card::before { content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(239,68,68,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
    .dark .exp-card::before { display:block; }

    /* strip */
    .exp-strip {
        background:linear-gradient(135deg,rgba(239,68,68,.07) 0%,rgba(220,38,38,.05) 100%);
        border-bottom:1px solid rgba(239,68,68,.09);
        padding:.95rem 2rem; display:flex; align-items:center; gap:.7rem;
    }
    .dark .exp-strip { background:linear-gradient(135deg,rgba(239,68,68,.11) 0%,rgba(220,38,38,.08) 100%); border-bottom-color:rgba(51,65,85,.4); }
    .exp-dot { width:8px;height:8px;border-radius:50%;background:#EF4444;box-shadow:0 0 9px rgba(239,68,68,.7);flex-shrink:0; }
    .exp-strip-label { font-size:.71rem;font-weight:900;color:#EF4444;text-transform:uppercase;letter-spacing:.1em; }
    .dark .exp-strip-label { color:#f87171; }

    /* body */
    .exp-body { padding:2.2rem 2.4rem; position:relative; z-index:1; }

    /* ===== FIELDS ===== */
    .field-group { display:flex;flex-direction:column;gap:.46rem;animation:fIn .45s ease both; }
    .field-group:nth-child(1){animation-delay:.05s}
    .field-group:nth-child(2){animation-delay:.10s}
    .field-group:nth-child(3){animation-delay:.15s}
    .field-group:nth-child(4){animation-delay:.20s}
    @keyframes fIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

    .fields-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1.3rem; }

    .field-label { font-size:.71rem;font-weight:900;color:#EF4444;text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:.38rem; }
    .dark .field-label { color:#f87171; }
    .field-label i { font-size:.62rem;opacity:.85; }

    .field-wrap { position:relative; }
    .field-input {
        width:100%; padding:.88rem 1.15rem;
        background:rgba(255,255,255,.62); backdrop-filter:blur(8px);
        border:1px solid rgba(148,163,184,.22); border-radius:.95rem;
        font-size:.93rem; font-family:'Cairo',sans-serif; font-weight:600; color:#1e293b;
        outline:none; direction:rtl;
        transition:border-color .22s ease,box-shadow .22s ease,background .22s ease;
        box-sizing:border-box;
    }
    .dark .field-input { background:rgba(15,23,42,.52); border-color:rgba(51,65,85,.48); color:#f1f5f9; }
    .field-input::placeholder { color:#94a3b8; font-weight:500; }
    .field-input:focus {
        border-color:rgba(239,68,68,.5);
        box-shadow:0 0 0 3px rgba(239,68,68,.12),0 4px 14px rgba(239,68,68,.07);
        background:rgba(255,255,255,.88);
    }
    .dark .field-input:focus { background:rgba(15,23,42,.88); box-shadow:0 0 0 3px rgba(239,68,68,.20); }
    textarea.field-input { resize:none; }

    /* date input */
    input[type="date"].field-input { cursor:pointer; }
    input[type="date"].field-input::-webkit-calendar-picker-indicator { opacity:.5; cursor:pointer; }

    /* suffix */
    .field-suffix {
        position:absolute; left:1rem; top:50%; transform:translateY(-50%);
        font-size:.7rem; font-weight:800; color:#94a3b8;
        background:rgba(148,163,184,.1); padding:2px 7px; border-radius:6px;
        letter-spacing:.05em; pointer-events:none;
    }
    .dark .field-suffix { background:rgba(71,85,105,.28); color:#64748b; }
    .field-input.has-suffix { padding-left:3.4rem; }

    /* ===== DIVIDER ===== */
    .form-divider { border:none; border-top:1px solid rgba(148,163,184,.12); margin:.3rem 0 1.6rem; }
    .dark .form-divider { border-color:rgba(51,65,85,.32); }

    /* ===== FOOTER ===== */
    .form-footer { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; }

    .footer-note { display:flex;align-items:center;gap:.4rem;font-size:.75rem;font-weight:600;color:#94a3b8; }
    .footer-note i { color:#EF4444; font-size:.72rem; }

    /* ===== SUBMIT BUTTON ===== */
    .btn-submit {
        display:inline-flex; align-items:center; gap:.65rem;
        padding:.82rem 2.1rem;
        background:linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
        color:#fff; border-radius:.95rem; font-weight:800; font-size:.92rem;
        border:none; cursor:pointer;
        box-shadow:0 6px 22px rgba(239,68,68,.38);
        transition:all .25s cubic-bezier(.34,1.56,.64,1);
        font-family:'Cairo',sans-serif; position:relative; overflow:hidden; flex-shrink:0;
    }
    .btn-submit::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .btn-submit:hover::before { left:160%; }
    .btn-submit:hover { transform:translateY(-2px) scale(1.04); box-shadow:0 10px 30px rgba(239,68,68,.52); }
    .btn-submit:active { transform:scale(.96); }
    .btn-submit i { transition:transform .3s cubic-bezier(.34,1.56,.64,1); }
    .btn-submit:hover i { transform:rotate(15deg) scale(1.15); }

    /* ===== CUSTOM ALERT ===== */
    .ca-overlay {
        position:fixed; inset:0; z-index:9999;
        display:flex; align-items:center; justify-content:center; padding:1rem;
        background:rgba(2,10,28,.42);
        backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
        opacity:0; pointer-events:none; transition:opacity .3s ease;
    }
    .ca-overlay.ca-show { opacity:1; pointer-events:all; }
    .ca-card {
        width:100%; max-width:400px;
        background:rgba(255,255,255,.72); backdrop-filter:blur(28px); -webkit-backdrop-filter:blur(28px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem; overflow:hidden;
        box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.16);
        transform:scale(.82) translateY(28px); opacity:0;
        transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
        direction:rtl;
    }
    .dark .ca-card { background:rgba(10,17,34,.82); border-color:rgba(51,65,85,.55); }
    .ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0); opacity:1; }
    .ca-bar { height:4px; width:100%; }
    .ca-bar.success { background:linear-gradient(90deg,#EF4444,#DC2626); }
    .ca-bar.error   { background:linear-gradient(90deg,#f97316,#ea580c); }
    .ca-body { padding:2rem 2rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; }
    .ca-icon-ring { width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;flex-shrink:0; }
    .ca-icon-ring.success { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.22),rgba(239,68,68,.06));border:1.5px solid rgba(239,68,68,.3);box-shadow:0 0 0 8px rgba(239,68,68,.07); }
    .ca-icon-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(249,115,22,.20),rgba(249,115,22,.05));border:1.5px solid rgba(249,115,22,.28);box-shadow:0 0 0 8px rgba(249,115,22,.06); }
    .ca-icon-ring svg { width:34px;height:34px;overflow:visible; }
    .ca-check-circle { stroke:#EF4444;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-check-mark   { stroke:#EF4444;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48; }
    .ca-error-circle { stroke:#f97316;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-error-x1,.ca-error-x2 { stroke:#f97316;stroke-width:3;stroke-linecap:round;stroke-dasharray:30;stroke-dashoffset:30; }
    .ca-overlay.ca-show .ca-check-circle { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-check-mark   { animation:caS .38s .55s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-error-circle { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-error-x1     { animation:caS .28s .55s ease forwards; }
    .ca-overlay.ca-show .ca-error-x2     { animation:caS .28s .72s ease forwards; }
    @keyframes caS { to { stroke-dashoffset:0; } }
    .ca-title { font-size:1.18rem;font-weight:900;color:#1e293b;letter-spacing:-.025em;line-height:1.25;margin-bottom:.42rem; }
    .dark .ca-title { color:#f1f5f9; }
    .ca-msg { font-size:.87rem;font-weight:600;color:#64748b;line-height:1.7; }
    .dark .ca-msg { color:#94a3b8; }
    .ca-progress-wrap { width:100%;height:3px;background:rgba(148,163,184,.12);margin-top:1.4rem;border-radius:99px;overflow:hidden; }
    .ca-progress-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#EF4444,#DC2626);transform-origin:left; }
    .ca-progress-fill.running { animation:caP var(--ca-dur,3.8s) linear forwards; }
    @keyframes caP { from{transform:scaleX(1)} to{transform:scaleX(0)} }
    .ca-footer { padding:0 2rem 1.8rem; display:flex; justify-content:center; }
    .ca-btn { font-family:'Cairo','Tajawal',sans-serif;font-weight:800;font-size:.9rem;padding:.65rem 2.2rem;border-radius:.9rem;border:none;cursor:pointer;transition:all .25s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden; }
    .ca-btn.success { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;box-shadow:0 5px 18px rgba(239,68,68,.38); }
    .ca-btn.success:hover { transform:translateY(-2px) scale(1.04); box-shadow:0 8px 26px rgba(239,68,68,.55); }
    .ca-btn.error   { background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;box-shadow:0 5px 18px rgba(249,115,22,.32); }
    .ca-btn.error:hover { transform:translateY(-2px) scale(1.04); }
    .ca-btn:active { transform:scale(.96); }
    .ca-btn::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .ca-btn:hover::before { left:160%; }

    /* ===== RESPONSIVE ===== */
    @media(max-width:560px){
        .fields-grid { grid-template-columns:1fr; }
        .exp-body { padding:1.6rem 1.2rem; }
        .exp-header { flex-direction:column; align-items:flex-start; }
        .btn-back { align-self:stretch; justify-content:center; }
        .form-footer { flex-direction:column; align-items:stretch; }
        .btn-submit { justify-content:center; }
    }
</style>

<!-- Orbs -->
<div class="exp-orb exp-orb-1"></div>
<div class="exp-orb exp-orb-2"></div>
<div class="exp-orb exp-orb-3"></div>

<div class="exp-page" dir="rtl">
<div class="exp-wrap">

    <!-- Header -->
    <div class="exp-header">
        <div class="exp-brand">
            <div class="exp-icon-wrap">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <h1 class="exp-title">إضافة مصاريف جديدة</h1>
                <p class="exp-subtitle">سجّل مصروفات الشركة بدقة لتتبع ميزانيتك</p>
            </div>
        </div>
        <a href="{{ route('expenses.index') }}" class="btn-back">
            العودة للقائمة
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <!-- Card -->
    <div class="exp-card">
        <div class="exp-strip">
            <div class="exp-dot"></div>
            <span class="exp-strip-label">بيانات المصروف</span>
        </div>

        <div class="exp-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf

                <!-- عنوان المصروف -->
                <div class="field-group" style="margin-bottom:1.4rem">
                    <label class="field-label"><i class="fas fa-tag"></i> عنوان المصروف</label>
                    <div class="field-wrap">
                        <input type="text" name="title" required
                               class="field-input"
                               placeholder="مثال: فاتورة الكهرباء، أدوات مكتبية"
                               value="{{ old('title') }}">
                    </div>
                </div>

                <!-- المبلغ + التاريخ -->
                <div class="fields-grid" style="margin-bottom:1.4rem">
                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-coins"></i> المبلغ</label>
                        <div class="field-wrap">
                            <input type="number" step="0.01" name="amount" required
                                   class="field-input has-suffix"
                                   placeholder="0.00"
                                   value="{{ old('amount') }}">
                            <span class="field-suffix">DA</span>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label"><i class="fas fa-calendar-alt"></i> التاريخ</label>
                        <div class="field-wrap">
                            <input type="date" name="expense_date" required
                                   class="field-input"
                                   value="{{ old('expense_date', date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>

                <!-- الوصف -->
                <div class="field-group" style="margin-bottom:0">
                    <label class="field-label"><i class="fas fa-align-right"></i> الوصف (اختياري)</label>
                    <div class="field-wrap">
                        <textarea name="description" rows="4"
                                  class="field-input"
                                  placeholder="أضف تفاصيل إضافية هنا...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <hr class="form-divider" style="margin-top:1.8rem">

                <div class="form-footer">
                    <p class="footer-note">
                        <i class="fas fa-shield-alt"></i>
                        البيانات محفوظة بأمان في النظام
                    </p>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check"></i>
                        <span>حفظ المصروفات</span>
                    </button>
                </div>

            </form>
        </div>
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
const CA_SVG = {
    success:`<svg viewBox="0 0 52 52"><circle class="ca-check-circle" cx="26" cy="26" r="25"/><path class="ca-check-mark" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
    error:  `<svg viewBox="0 0 52 52"><circle class="ca-error-circle" cx="26" cy="26" r="25"/><line class="ca-error-x1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-error-x2" x1="36" y1="16" x2="16" y2="36"/></svg>`
};
let caTimer = null;

function caShow({type,title,msg,btnText,autoClose}){
    const o=document.getElementById('caOverlay'),
          bar=document.getElementById('caBar'),
          rng=document.getElementById('caRing'),
          t=document.getElementById('caTitle'),
          m=document.getElementById('caMsg'),
          btn=document.getElementById('caBtn'),
          pw=document.getElementById('caProgressWrap'),
          pf=document.getElementById('caProgressFill');
    o.classList.remove('ca-show');
    bar.className=`ca-bar ${type}`; rng.className=`ca-icon-ring ${type}`;
    rng.innerHTML=CA_SVG[type]; t.textContent=title; m.textContent=msg;
    btn.className=`ca-btn ${type}`; btn.textContent=btnText;
    if(autoClose){
        pw.style.display='block'; pf.className='ca-progress-fill';
        pf.style.setProperty('--ca-dur',autoClose/1000+'s');
        void pf.offsetWidth; pf.classList.add('running');
        caTimer=setTimeout(caClose,autoClose);
    } else { pw.style.display='none'; }
    requestAnimationFrame(()=>o.classList.add('ca-show'));
}
function caClose(){ clearTimeout(caTimer); document.getElementById('caOverlay').classList.remove('ca-show'); }
document.getElementById('caOverlay').addEventListener('click',function(e){ if(e.target===this)caClose(); });

@if(session('success'))
window.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'success',title:'تم الحفظ!',msg:'{{ session("success") }}',btnText:'حسناً',autoClose:3800});
});
@endif

@if($errors->any())
window.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'error',title:'تحقق من البيانات',msg:'{{ $errors->first() }}',btnText:'سأصحح الآن'});
});
@endif
</script>

@endsection