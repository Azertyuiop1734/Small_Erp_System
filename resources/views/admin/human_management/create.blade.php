@extends('layouts.app')

@section('title', 'إضافة موظف جديد')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');

    * { font-family: 'Cairo', 'Tajawal', sans-serif; box-sizing: border-box; }

    /* ===== BACKGROUND ===== */
    .create-page {
        min-height: 100vh;
        padding: 2.2rem 1rem 3rem;
        position: relative;
        overflow-x: hidden;
    }
    .create-page::before {
        content: '';
        position: fixed; inset: 0;
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(16,185,129,0.09) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(37,99,235,0.08) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 35%, rgba(99,102,241,0.06) 0%, transparent 55%);
        pointer-events: none; z-index: 0;
    }
    .dark .create-page::before {
        background:
            radial-gradient(ellipse 75% 55% at 10% 10%, rgba(16,185,129,0.14) 0%, transparent 60%),
            radial-gradient(ellipse 55% 50% at 88% 80%, rgba(37,99,235,0.13) 0%, transparent 60%);
    }

    .orb { position:fixed; border-radius:50%; filter:blur(80px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:300px; height:300px; background:rgba(16,185,129,0.07);  top:-70px; right:-70px; animation-delay:0s; }
    .orb-2 { width:220px; height:220px; background:rgba(37,99,235,0.07);   bottom:12%; left:-50px; animation-delay:-5s; }
    .orb-3 { width:160px; height:160px; background:rgba(99,102,241,0.06);  top:40%; right:8%;     animation-delay:-9s; }
    .dark .orb-1 { background:rgba(16,185,129,0.13); }
    .dark .orb-2 { background:rgba(37,99,235,0.13); }

    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1);} 50%{transform:translateY(-28px) scale(1.06);} }

    /* ===== LAYOUT ===== */
    .page-wrap { max-width:1240px; margin:0 auto; position:relative; z-index:1; }

    /* ===== HEADER ===== */
    .page-header {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1.2rem; margin-bottom:1.8rem;
        animation: slideDown 0.6s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px);} to{opacity:1;transform:translateY(0);} }

    .header-left { display:flex; align-items:center; gap:1.1rem; }
    .header-icon {
        width:60px; height:60px;
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        border-radius:18px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(5,150,105,0.35), 0 0 0 3px rgba(5,150,105,0.12);
        flex-shrink:0; position:relative;
    }
    .header-icon::before { content:''; position:absolute; inset:0; border-radius:inherit; background:linear-gradient(135deg,rgba(255,255,255,0.22),transparent); }
    .header-icon svg { color:#fff; width:26px; height:26px; position:relative; z-index:1; }
    .header-title { font-size:1.9rem; font-weight:900; color:#1e293b; letter-spacing:-0.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:0.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .header-sub { color:#94a3b8; }

    .btn-back {
        display:inline-flex; align-items:center; gap:0.55rem;
        padding:0.75rem 1.6rem;
        background:rgba(255,255,255,.6); backdrop-filter:blur(12px);
        color:#64748b; border-radius:14px; font-weight:800; font-size:0.88rem;
        text-decoration:none; border:1px solid rgba(255,255,255,.7);
        box-shadow:0 2px 12px rgba(0,0,0,.04);
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1); flex-shrink:0;
    }
    .dark .btn-back { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.5); color:#94a3b8; }
    .btn-back:hover { color:#059669; border-color:rgba(5,150,105,.35); box-shadow:0 4px 20px rgba(5,150,105,.18); transform:translateY(-2px); }
    .btn-back i { transition:transform .22s; font-size:.78rem; }
    .btn-back:hover i { transform:translateX(3px); }

    /* ===== CREATE CARD ===== */
    .create-card {
        background:rgba(255,255,255,0.52); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,0.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,0.07), 0 1px 0 rgba(255,255,255,0.85) inset;
        overflow:hidden;
        animation:slideUp 0.6s 0.1s cubic-bezier(0.34,1.56,0.64,1) both;
        position:relative;
    }
    .dark .create-card { background:rgba(15,23,42,0.55); border-color:rgba(51,65,85,0.42); box-shadow:0 8px 40px rgba(0,0,0,0.32); }
    .create-card::before { content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(5,150,105,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
    .dark .create-card::before { display:block; }

    @keyframes slideUp { from{opacity:0;transform:translateY(18px);} to{opacity:1;transform:translateY(0);} }

    /* ===== FORM GRID ===== */
    .form-grid { display:grid; grid-template-columns:1fr; gap:2.5rem; padding:2rem; }
    @media(min-width:1024px){ .form-grid { grid-template-columns:300px 1fr; gap:3rem; padding:2.5rem; } }

    /* ===== IMAGE UPLOAD ===== */
    .image-section { display:flex; flex-direction:column; align-items:center; gap:1.2rem; }
    .image-label { font-size:0.72rem; font-weight:900; color:#059669; text-transform:uppercase; letter-spacing:0.09em; }
    .dark .image-label { color:#34d399; }

    .image-zone-wrap { position:relative; width:100%; max-width:260px; }
    .image-glow { position:absolute; inset:-4px; background:linear-gradient(135deg,#059669,#2563EB); border-radius:2rem; opacity:0.18; filter:blur(12px); transition:opacity 0.3s; }
    .image-zone-wrap:hover .image-glow { opacity:0.32; }

    .image-zone {
        position:relative; width:100%; aspect-ratio:1;
        border-radius:2rem; border:2px dashed rgba(148,163,184,0.35);
        background:rgba(255,255,255,0.4); backdrop-filter:blur(12px);
        display:flex; align-items:center; justify-content:center;
        overflow:hidden; cursor:pointer; transition:all 0.3s ease;
    }
    .dark .image-zone { background:rgba(15,23,42,0.4); border-color:rgba(71,85,105,0.35); }
    .image-zone:hover { border-color:rgba(5,150,105,0.45); box-shadow:0 8px 30px rgba(5,150,105,0.12); transform:translateY(-2px); }
    .image-zone.drag-over { border-color:#059669; background:rgba(5,150,105,0.06); }

    .image-preview { width:100%; height:100%; object-fit:cover; display:none; transition:transform 0.5s; }
    .image-zone:hover .image-preview { transform:scale(1.05); }

    .image-placeholder { display:flex; flex-direction:column; align-items:center; gap:0.6rem; color:#94a3b8; transition:all 0.3s; }
    .image-zone:hover .image-placeholder { transform:scale(1.05); }
    .ph-icon {
        width:64px; height:64px; border-radius:20px;
        background:linear-gradient(135deg,rgba(5,150,105,0.08),rgba(37,99,235,0.06));
        border:1px solid rgba(5,150,105,0.1);
        display:flex; align-items:center; justify-content:center;
    }
    .ph-icon svg { width:28px; height:28px; opacity:0.5; }
    .ph-text { font-size:0.8rem; font-weight:800; letter-spacing:0.05em; }
    .ph-sub { font-size:0.7rem; opacity:0.7; }

    .image-overlay {
        position:absolute; inset:0;
        background:linear-gradient(to top, rgba(0,0,0,0.6) 0%, transparent 60%);
        display:none; align-items:flex-end; justify-content:center; padding-bottom:1.5rem;
    }
    .image-zone.has-image:hover .image-overlay { display:flex; }
    .overlay-text {
        background:rgba(255,255,255,0.15); backdrop-filter:blur(12px);
        border:1px solid rgba(255,255,255,0.2);
        color:#fff; font-size:0.8rem; font-weight:800;
        padding:0.4rem 1rem; border-radius:999px;
    }

    .remove-image-btn {
        position:absolute; top:-10px; right:-10px; z-index:10;
        width:32px; height:32px; border-radius:50%;
        background:linear-gradient(135deg,#ef4444,#dc2626);
        color:#fff; border:2px solid #fff; cursor:pointer;
        display:none; align-items:center; justify-content:center;
        box-shadow:0 4px 12px rgba(239,68,68,0.35);
        transition:all 0.2s;
    }
    .remove-image-btn.show { display:flex; }
    .remove-image-btn:hover { transform:scale(1.1); }

    .image-meta { text-align:center; font-size:0.75rem; color:#94a3b8; margin-top:0.5rem; line-height:1.6; }
    .file-name { display:none; margin-top:0.5rem; padding:0.2rem 0.8rem; background:rgba(5,150,105,0.08); color:#059669; border-radius:999px; font-weight:700; font-size:0.75rem; }
    .file-error { display:none; margin-top:0.5rem; padding:0.2rem 0.8rem; background:rgba(239,68,68,0.08); color:#dc2626; border-radius:999px; font-weight:700; font-size:0.75rem; }

    /* ===== TIP CARD ===== */
    .tip-card {
        width:100%; max-width:260px;
        background:rgba(255,255,255,0.45); backdrop-filter:blur(16px);
        border:1px solid rgba(255,255,255,0.6); border-radius:1.3rem;
        padding:1.1rem; display:flex; align-items:start; gap:0.8rem;
        box-shadow:0 4px 18px rgba(0,0,0,0.04);
    }
    .dark .tip-card { background:rgba(15,23,42,0.35); border-color:rgba(51,65,85,0.35); }
    .tip-icon { width:36px; height:36px; border-radius:10px; background:rgba(5,150,105,0.1); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .tip-icon svg { width:18px; height:18px; color:#059669; }
    .tip-title { font-size:0.85rem; font-weight:800; color:#1e293b; margin-bottom:0.2rem; }
    .dark .tip-title { color:#f1f5f9; }
    .tip-text { font-size:0.78rem; color:#64748b; line-height:1.5; }
    .dark .tip-text { color:#94a3b8; }

    /* ===== SECTIONS ===== */
    .form-section { margin-bottom:2rem; }
    .section-header { display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem; }
    .section-icon { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 14px rgba(0,0,0,0.08); }
    .section-icon.blue    { background:linear-gradient(135deg,#059669,#2563EB); }
    .section-icon.emerald { background:linear-gradient(135deg,#10b981,#059669); }
    .section-icon svg { width:20px; height:20px; color:#fff; }
    .section-title { font-size:1.05rem; font-weight:900; color:#1e293b; }
    .dark .section-title { color:#f1f5f9; }
    .section-line { height:3px; width:24px; border-radius:2px; margin-top:0.3rem; }
    .section-line.blue    { background:linear-gradient(90deg,#059669,#2563EB); }
    .section-line.emerald { background:linear-gradient(90deg,#10b981,#059669); }

    /* ===== INPUTS ===== */
    .field-group { margin-bottom:1.1rem; }
    .field-label { display:block; font-size:0.8rem; font-weight:800; color:#475569; margin-bottom:0.4rem; transition:color 0.2s; }
    .dark .field-label { color:#94a3b8; }
    .field-group:focus-within .field-label { color:#059669; }

    .input-wrap { position:relative; }
    .form-input {
        width:100%; padding:0.85rem 2.7rem 0.85rem 1rem;
        background:rgba(255,255,255,0.6); backdrop-filter:blur(12px);
        border:1.5px solid rgba(203,213,225,0.55); border-radius:14px;
        font-size:0.9rem; font-family:'Cairo',sans-serif; color:#1e293b;
        box-shadow:0 2px 10px rgba(0,0,0,0.04); transition:all 0.22s ease;
        outline:none; direction:rtl;
    }
    .dark .form-input { background:rgba(15,23,42,0.6); border-color:rgba(71,85,105,0.4); color:#f1f5f9; }
    .form-input::placeholder { color:#94a3b8; }
    .form-input:focus {
        border-color:rgba(5,150,105,0.45);
        box-shadow:0 0 0 3px rgba(5,150,105,0.10), 0 4px 18px rgba(5,150,105,0.08);
        background:rgba(255,255,255,0.88);
    }
    .dark .form-input:focus { background:rgba(15,23,42,0.88); }
    select.form-input { appearance:none; cursor:pointer; padding-left:2.5rem; }

    .input-icon { position:absolute; right:1rem; top:50%; transform:translateY(-50%); color:#94a3b8; pointer-events:none; transition:color 0.2s; }
    .field-group:focus-within .input-icon { color:#059669; }
    .input-action { position:absolute; left:1rem; top:50%; transform:translateY(-50%); color:#94a3b8; cursor:pointer; background:none; border:none; padding:0; display:flex; align-items:center; transition:color 0.2s; }
    .input-action:hover { color:#059669; }

    /* ── password match indicator ── */
    .pwd-match-bar { height:3px; border-radius:99px; margin-top:.35rem; transition:all .3s ease; width:0; }
    .pwd-match-bar.match    { width:100%; background:linear-gradient(90deg,#059669,#10B981); }
    .pwd-match-bar.no-match { width:100%; background:linear-gradient(90deg,#EF4444,#DC2626); }

    .pwd-match-hint { font-size:.72rem; font-weight:700; margin-top:.25rem; display:none; transition:color .25s; }
    .pwd-match-hint.visible   { display:block; }
    .pwd-match-hint.match    { color:#059669; }
    .pwd-match-hint.no-match { color:#EF4444; }

    /* ===== SUB-CARD ===== */
    .sub-card {
        background:rgba(255,255,255,0.4); backdrop-filter:blur(16px);
        border:1px solid rgba(255,255,255,0.5); border-radius:1.3rem;
        padding:1.3rem; box-shadow:0 4px 18px rgba(0,0,0,0.04);
    }
    .dark .sub-card { background:rgba(15,23,42,0.3); border-color:rgba(51,65,85,0.3); }

    /* ===== ACTIONS ===== */
    .actions-bar {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1rem; padding-top:1.5rem;
        border-top:1px solid rgba(148,163,184,0.15); margin-top:1rem;
    }
    .btn {
        display:inline-flex; align-items:center; justify-content:center; gap:0.5rem;
        padding:0.8rem 1.8rem; border-radius:14px; font-weight:800; font-size:0.9rem;
        text-decoration:none; border:none; cursor:pointer;
        transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);
        position:relative; overflow:hidden;
    }
    .btn-secondary {
        background:rgba(255,255,255,0.6); backdrop-filter:blur(8px);
        border:1px solid rgba(203,213,225,0.5); color:#64748b;
    }
    .dark .btn-secondary { background:rgba(30,41,59,0.5); border-color:rgba(71,85,105,0.3); color:#94a3b8; }
    .btn-secondary:hover { background:rgba(255,255,255,0.9); transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,0.08); }

    .btn-primary {
        background:linear-gradient(135deg,#059669 0%,#2563EB 100%);
        color:#fff; border:1px solid rgba(255,255,255,0.18);
        box-shadow:0 6px 22px rgba(5,150,105,0.32);
    }
    .btn-primary::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.18),transparent); transition:left 0.5s; }
    .btn-primary:hover::before { left:150%; }
    .btn-primary:hover { transform:translateY(-2px) scale(1.03); box-shadow:0 10px 30px rgba(5,150,105,0.45); }
    .btn-primary:active { transform:scale(0.97); }
    .btn-primary:disabled { opacity:0.7; cursor:not-allowed; transform:none; }
    .btn-primary i { transition:transform .3s cubic-bezier(.34,1.56,.64,1); }
    .btn-primary:not(:disabled):hover i { transform:rotate(15deg) scale(1.15); }

    /* loading spin */
    @keyframes spin { to{transform:rotate(360deg)} }
    .spin-icon { animation:spin .8s linear infinite; display:inline-block; }

    /* ===== GRID UTILS ===== */
    .grid-2 { display:grid; grid-template-columns:1fr; gap:1rem; }
    @media(min-width:768px){ .grid-2 { grid-template-columns:1fr 1fr; gap:1.2rem; } }
    .grid-3 { display:grid; grid-template-columns:1fr; gap:1rem; }
    @media(min-width:768px){ .grid-3 { grid-template-columns:repeat(3,1fr); gap:1.2rem; } }

    /* ===== CUSTOM ALERT ===== */
    .ca-overlay {
        position:fixed; inset:0; z-index:9999;
        display:flex; align-items:center; justify-content:center; padding:1rem;
        background:rgba(2,10,28,.44); backdrop-filter:blur(10px);
        opacity:0; pointer-events:none; transition:opacity .3s ease;
    }
    .ca-overlay.ca-show { opacity:1; pointer-events:all; }
    .ca-card {
        width:100%; max-width:440px;
        background:rgba(255,255,255,.74); backdrop-filter:blur(28px);
        border:1px solid rgba(255,255,255,.68); border-radius:2rem; overflow:hidden;
        box-shadow:0 2px 0 rgba(255,255,255,.92) inset, 0 32px 64px rgba(0,0,0,.17);
        transform:scale(.83) translateY(26px); opacity:0;
        transition:transform .42s cubic-bezier(.34,1.56,.64,1), opacity .28s ease;
        direction:rtl;
    }
    .dark .ca-card { background:rgba(10,17,34,.82); border-color:rgba(51,65,85,.55); }
    .ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0); opacity:1; }
    .ca-bar { height:4px; }
    .ca-bar.success { background:linear-gradient(90deg,#059669,#2563EB); }
    .ca-bar.error   { background:linear-gradient(90deg,#EF4444,#DC2626); }
    .ca-bar.warning { background:linear-gradient(90deg,#F59E0B,#D97706); }
    .ca-body { padding:2rem 2rem 1.5rem; display:flex; flex-direction:column; align-items:center; text-align:center; }
    .ca-ring { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:1.2rem; }
    .ca-ring.success { background:radial-gradient(circle at 35% 35%,rgba(5,150,105,.22),rgba(5,150,105,.06)); border:1.5px solid rgba(5,150,105,.3); box-shadow:0 0 0 8px rgba(5,150,105,.07); }
    .ca-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.20),rgba(239,68,68,.05));  border:1.5px solid rgba(239,68,68,.28); box-shadow:0 0 0 8px rgba(239,68,68,.06); }
    .ca-ring.warning { background:radial-gradient(circle at 35% 35%,rgba(245,158,11,.22),rgba(245,158,11,.06));border:1.5px solid rgba(245,158,11,.3); box-shadow:0 0 0 8px rgba(245,158,11,.07); }
    .ca-ring svg { width:34px; height:34px; overflow:visible; }
    .ca-cc  { stroke:#059669; stroke-width:2.5; fill:none; stroke-dasharray:166; stroke-dashoffset:166; }
    .ca-cm  { stroke:#059669; stroke-width:3; fill:none; stroke-linecap:round; stroke-linejoin:round; stroke-dasharray:48; stroke-dashoffset:48; }
    .ca-ec  { stroke:#EF4444; stroke-width:2.5; fill:none; stroke-dasharray:166; stroke-dashoffset:166; }
    .ca-ex1,.ca-ex2 { stroke:#EF4444; stroke-width:3; stroke-linecap:round; stroke-dasharray:30; stroke-dashoffset:30; }
    .ca-wc  { stroke:#F59E0B; stroke-width:2.5; fill:none; stroke-dasharray:166; stroke-dashoffset:166; }
    .ca-wl  { stroke:#F59E0B; stroke-width:3; stroke-linecap:round; stroke-dasharray:22; stroke-dashoffset:22; }
    .ca-wd  { stroke:#F59E0B; stroke-width:3; stroke-linecap:round; stroke-dasharray:6; stroke-dashoffset:6; }
    .ca-overlay.ca-show .ca-cc  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-cm  { animation:caS .38s .55s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ec  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ex1 { animation:caS .28s .55s ease forwards; }
    .ca-overlay.ca-show .ca-ex2 { animation:caS .28s .72s ease forwards; }
    .ca-overlay.ca-show .ca-wc  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-wl  { animation:caS .30s .55s ease forwards; }
    .ca-overlay.ca-show .ca-wd  { animation:caS .20s .82s ease forwards; }
    @keyframes caS { to{stroke-dashoffset:0} }
    .ca-title { font-size:1.2rem; font-weight:900; color:#1e293b; letter-spacing:-.025em; line-height:1.25; margin-bottom:.45rem; }
    .dark .ca-title { color:#f1f5f9; }
    .ca-msg  { font-size:.88rem; font-weight:600; color:#64748b; line-height:1.7; }
    .dark .ca-msg { color:#94a3b8; }
    .ca-err-list { list-style:none; text-align:right; width:100%; margin-top:.3rem; }
    .ca-err-list li { display:flex; align-items:center; justify-content:flex-end; gap:.5rem; font-size:.83rem; font-weight:700; color:#EF4444; padding:.18rem 0; }
    .ca-err-list li::after { content:''; width:6px; height:6px; border-radius:50%; background:#EF4444; flex-shrink:0; }
    .ca-prog-wrap { width:100%; height:3px; background:rgba(148,163,184,.12); margin-top:1.4rem; border-radius:99px; overflow:hidden; }
    .ca-prog-fill { height:100%; border-radius:99px; background:linear-gradient(90deg,#059669,#2563EB); transform-origin:left; }
    .ca-prog-fill.run { animation:caP var(--ca-dur,3.8s) linear forwards; }
    @keyframes caP { from{transform:scaleX(1)} to{transform:scaleX(0)} }
    .ca-foot { padding:0 2rem 1.8rem; display:flex; justify-content:center; }
    .ca-btn { font-family:'Cairo',sans-serif; font-weight:800; font-size:.9rem; padding:.68rem 2.4rem; border-radius:.95rem; border:none; cursor:pointer; transition:all .25s cubic-bezier(.34,1.56,.64,1); position:relative; overflow:hidden; }
    .ca-btn.success { background:linear-gradient(135deg,#059669,#2563EB); color:#fff; box-shadow:0 5px 18px rgba(5,150,105,.38); }
    .ca-btn.success:hover { transform:translateY(-2px) scale(1.04); }
    .ca-btn.error   { background:linear-gradient(135deg,#EF4444,#DC2626); color:#fff; box-shadow:0 5px 18px rgba(239,68,68,.32); }
    .ca-btn.error:hover { transform:translateY(-2px) scale(1.04); }
    .ca-btn.warning { background:linear-gradient(135deg,#F59E0B,#D97706); color:#fff; box-shadow:0 5px 18px rgba(245,158,11,.35); }
    .ca-btn.warning:hover { transform:translateY(-2px) scale(1.04); }
    .ca-btn:active { transform:scale(.96); }
    .ca-btn::before { content:''; position:absolute; top:0; left:-100%; width:55%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent); transition:left .5s; }
    .ca-btn:hover::before { left:160%; }

    @media(max-width:640px){
        .page-header { flex-direction:column; align-items:flex-start; }
        .header-title { font-size:1.5rem; }
        .form-grid { padding:1.5rem; }
    }
</style>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="create-page" dir="rtl">
<div class="page-wrap">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-left">
            <div class="header-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <div>
                <h1 class="header-title">تسجيل موظف جديد</h1>
                <p class="header-sub">أدخل البيانات المطلوبة لإنشاء حساب الموظف في النظام</p>
            </div>
        </div>
        <a href="{{ route('users.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            عودة للقائمة
        </a>
    </div>

    {{-- CREATE CARD --}}
    <div class="create-card">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" id="employee-form">
            @csrf
            
            <div class="form-grid">
                
                {{-- IMAGE COLUMN --}}
                <div class="image-section">
                    <div class="image-label">الصورة الشخصية</div>
                    
                    <div class="image-zone-wrap">
                        <div class="image-glow"></div>
                        <div class="image-zone" id="image-container">
                            <img id="image-preview" class="image-preview" src="" alt="Preview">
                            <div class="image-placeholder" id="placeholder-icon">
                                <div class="ph-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ph-text">اضغط للرفع</div>
                                <div class="ph-sub">أو اسحب الصورة هنا</div>
                            </div>
                            <div class="image-overlay" id="image-overlay">
                                <span class="overlay-text">تغيير الصورة</span>
                            </div>
                            <input type="file" name="image" id="image-input" style="position:absolute;inset:0;opacity:0;cursor:pointer;z-index:5;" accept="image/jpeg,image/png,image/jpg">
                        </div>
                        <button type="button" class="remove-image-btn" id="remove-image">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    
                    <div class="image-meta">
                        الحد الأقصى: 2 ميجابايت | JPG, PNG
                        <div class="file-name" id="file-name"></div>
                        <div class="file-error" id="file-error"></div>
                    </div>

                    <div class="tip-card">
                        <div class="tip-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="tip-title">نصيحة</div>
                            <div class="tip-text">استخدم صورة واضحة بخلفية بيضاء للحصول على أفضل نتيجة في بطاقة الهوية.</div>
                        </div>
                    </div>
                </div>

                {{-- FORM COLUMN --}}
                <div>
                    
                    {{-- Personal Info --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon blue">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <div class="section-title">المعلومات الشخصية</div>
                                <div class="section-line blue"></div>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="field-group">
                                <label class="field-label">الاسم الكامل <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="مثال: أحمد محمد العلي">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">البريد الإلكتروني <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="example@company.com" dir="ltr" style="text-align:right">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="field-group">
                                <label class="field-label">كلمة المرور <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <input type="password" name="password" id="password" required class="form-input" placeholder="••••••••">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    <button type="button" class="input-action" onclick="togglePassword('password', this)">
                                        <svg id="eye-password" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">تأكيد كلمة المرور <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required class="form-input" placeholder="••••••••">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <button type="button" class="input-action" onclick="togglePassword('password_confirmation', this)">
                                        <svg id="eye-confirm" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </div>
                                {{-- live match bar + hint injected by JS --}}
                                <div class="pwd-match-bar" id="pwdMatchBar"></div>
                                <div class="pwd-match-hint" id="pwdMatchHint"></div>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="field-group">
                                <label class="field-label">رقم الهاتف <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required class="form-input" placeholder="+213 555 123 456">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">تاريخ التوظيف</label>
                                <div class="input-wrap">
                                    <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="form-input">
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Additional Info --}}
                    <div class="sub-card" style="margin-bottom:2rem;">
                        <div class="grid-3">
                            <div class="field-group" style="margin-bottom:0;">
                                <label class="field-label" style="font-size:0.75rem;">العمر</label>
                                <div class="input-wrap">
                                    <input type="number" name="age" value="{{ old('age') }}" min="18" max="100" required class="form-input" style="padding:0.7rem 2.2rem 0.7rem 0.8rem;">
                                    <svg class="input-icon" style="width:16px;height:16px;right:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <div class="field-group" style="margin-bottom:0;">
                                <label class="field-label" style="font-size:0.75rem;">الجنس</label>
                                <div class="input-wrap">
                                    <select name="gender" class="form-input" style="padding:0.7rem 2.2rem 0.7rem 0.8rem;">
                                        <option value="Male">ذكر</option>
                                        <option value="Female">أنثى</option>
                                    </select>
                                    <svg class="input-icon" style="width:16px;height:16px;right:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <div class="field-group" style="margin-bottom:0;">
                                <label class="field-label" style="font-size:0.75rem;">المسمى الوظيفي</label>
                                <div class="input-wrap">
                                    <input type="text" name="job_title" value="{{ old('job_title') }}" required class="form-input" placeholder="محاسب" style="padding:0.7rem 2.2rem 0.7rem 0.8rem;">
                                    <svg class="input-icon" style="width:16px;height:16px;right:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Work Info --}}
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon emerald">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <div class="section-title">معلومات العمل</div>
                                <div class="section-line emerald"></div>
                            </div>
                        </div>

                        <div class="grid-3">
                            <div class="field-group">
                                <label class="field-label">المخزن <span style="color:#ef4444">*</span></label>
                                <div class="input-wrap">
                                    <select name="warehouse_id" required class="form-input">
                                        <option value="">اختر المخزن...</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">الراتب (د.ج)</label>
                                <div class="input-wrap">
                                    <input type="number" step="0.01" name="salary" value="{{ old('salary') }}" class="form-input" placeholder="0.00">
                                    <span class="input-icon" style="font-size:0.78rem;font-weight:800;">DA</span>
                                </div>
                            </div>
                            <div class="field-group">
                                <label class="field-label">حالة الموظف</label>
                                <div class="input-wrap">
                                    <select name="status" class="form-input">
                                        <option value="active">نشط</option>
                                        <option value="inactive">غير نشط</option>
                                        <option value="on_leave">في إجازة</option>
                                    </select>
                                    <svg class="input-icon" style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="actions-bar">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            إلغاء وعودة
                        </a>
                        
                        <div style="display:flex; gap:0.75rem;">
                            <button type="reset" class="btn btn-secondary" onclick="resetForm()">
                                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                إعادة تعيين
                            </button>
                            
                            <button type="submit" class="btn btn-primary" id="submit-btn">
                                <span id="btn-text" style="display:flex;align-items:center;gap:0.5rem;">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    إنشاء حساب الموظف
                                </span>
                                <span id="btn-loading" style="display:none;align-items:center;gap:0.5rem;">
                                    <svg class="spin-icon" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    جاري الإنشاء...
                                </span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <div style="text-align:center; margin-top:1.5rem; font-size:0.75rem; color:#94a3b8;">
        جميع البيانات مشفرة ومحمية بمعايير الأمان العالية
    </div>

</div>
</div>

{{-- ===== CUSTOM ALERT ===== --}}
<div class="ca-overlay" id="caOverlay">
    <div class="ca-card">
        <div class="ca-bar" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-ring" id="caRing"></div>
            <p class="ca-title" id="caTitle"></p>
            <div id="caContent"></div>
            <div class="ca-prog-wrap" id="caPW" style="display:none">
                <div class="ca-prog-fill" id="caPF"></div>
            </div>
        </div>
        <div class="ca-foot">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ════════════════════════════
   CUSTOM ALERT ENGINE
════════════════════════════ */
const CA_SVG = {
    success: `<svg viewBox="0 0 52 52"><circle class="ca-cc" cx="26" cy="26" r="25"/><path class="ca-cm" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
    error:   `<svg viewBox="0 0 52 52"><circle class="ca-ec" cx="26" cy="26" r="25"/><line class="ca-ex1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-ex2" x1="36" y1="16" x2="16" y2="36"/></svg>`,
    warning: `<svg viewBox="0 0 52 52"><circle class="ca-wc" cx="26" cy="26" r="25"/><line class="ca-wl" x1="26" y1="14" x2="26" y2="30"/><line class="ca-wd" x1="26" y1="36" x2="26" y2="38"/></svg>`
};
let caTimer = null;

function caShow({ type, title, content, btnText, autoClose }) {
    const o   = document.getElementById('caOverlay');
    const bar = document.getElementById('caBar');
    const rng = document.getElementById('caRing');
    const t   = document.getElementById('caTitle');
    const c   = document.getElementById('caContent');
    const btn = document.getElementById('caBtn');
    const pw  = document.getElementById('caPW');
    const pf  = document.getElementById('caPF');

    o.classList.remove('ca-show');
    bar.className   = `ca-bar ${type}`;
    rng.className   = `ca-ring ${type}`;
    rng.innerHTML   = CA_SVG[type];
    t.textContent   = title;
    c.innerHTML     = content || '';
    btn.className   = `ca-btn ${type}`;
    btn.textContent = btnText || 'حسناً';

    if (autoClose) {
        pw.style.display = 'block';
        pf.className = 'ca-prog-fill';
        pf.style.setProperty('--ca-dur', autoClose / 1000 + 's');
        void pf.offsetWidth;
        pf.classList.add('run');
        caTimer = setTimeout(caClose, autoClose);
    } else { pw.style.display = 'none'; }

    requestAnimationFrame(() => o.classList.add('ca-show'));
}
function caClose() {
    clearTimeout(caTimer);
    document.getElementById('caOverlay').classList.remove('ca-show');
}
document.getElementById('caOverlay').addEventListener('click', function(e) {
    if (e.target === this) caClose();
});

/* ════════════════════════════
   IMAGE UPLOAD
════════════════════════════ */
const imageInput     = document.getElementById('image-input');
const imagePreview   = document.getElementById('image-preview');
const placeholderIcon= document.getElementById('placeholder-icon');
const imageContainer = document.getElementById('image-container');
const imageOverlay   = document.getElementById('image-overlay');
const removeBtn      = document.getElementById('remove-image');
const fileName       = document.getElementById('file-name');
const fileError      = document.getElementById('file-error');
const MAX_SIZE = 2*1024*1024;
const ALLOWED  = ['image/jpeg','image/png','image/jpg'];

function resetImage() {
    imagePreview.src = '';
    imagePreview.style.display = 'none';
    placeholderIcon.style.display = 'flex';
    imageOverlay.style.display   = 'none';
    removeBtn.classList.remove('show');
    fileName.style.display  = 'none';
    fileError.style.display = 'none';
    imageContainer.classList.remove('has-image');
    imageInput.value = '';
}

function resetForm() { resetImage(); }

imageInput.addEventListener('change', function () {
    const file = this.files[0];
    fileError.style.display = 'none';
    if (!file) return;
    if (!ALLOWED.includes(file.type)) { fileError.textContent='صيغة غير مدعومة — JPG/PNG فقط'; fileError.style.display='block'; resetImage(); return; }
    if (file.size > MAX_SIZE)         { fileError.textContent='الحجم يتجاوز 2 ميجابايت'; fileError.style.display='block'; resetImage(); return; }
    const r = new FileReader();
    r.onload = e => {
        imagePreview.src = e.target.result; imagePreview.style.display = 'block';
        placeholderIcon.style.display = 'none'; imageOverlay.style.display = 'flex';
        removeBtn.classList.add('show');
        fileName.textContent = file.name; fileName.style.display = 'block';
        imageContainer.classList.add('has-image');
    };
    r.readAsDataURL(file);
});
removeBtn.addEventListener('click', e => { e.preventDefault(); resetImage(); });

['dragenter','dragover','dragleave','drop'].forEach(ev =>
    imageContainer.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); }));
['dragenter','dragover'].forEach(ev =>
    imageContainer.addEventListener(ev, () => imageContainer.classList.add('drag-over')));
['dragleave','drop'].forEach(ev =>
    imageContainer.addEventListener(ev, () => imageContainer.classList.remove('drag-over')));
imageContainer.addEventListener('drop', e => {
    imageInput.files = e.dataTransfer.files;
    imageInput.dispatchEvent(new Event('change'));
});

/* ════════════════════════════
   PASSWORD TOGGLE
════════════════════════════ */
const EYE_ON  = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
const EYE_OFF = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';

function togglePassword(id, btn) {
    const inp  = document.getElementById(id);
    const show = inp.type === 'password';
    inp.type   = show ? 'text' : 'password';
    btn.querySelector('svg').innerHTML = show ? EYE_OFF : EYE_ON;
}

/* ════════════════════════════
   LIVE PASSWORD MATCH
════════════════════════════ */
(function () {
    const pwd  = document.getElementById('password');
    const conf = document.getElementById('password_confirmation');
    const bar  = document.getElementById('pwdMatchBar');
    const hint = document.getElementById('pwdMatchHint');

    function check() {
        const p = pwd.value, c = conf.value;
        if (!c) {
            bar.className  = 'pwd-match-bar';
            hint.className = 'pwd-match-hint';
            hint.textContent = '';
            conf.style.borderColor = '';
            return;
        }
        if (p === c) {
            bar.className  = 'pwd-match-bar match';
            hint.className = 'pwd-match-hint visible match';
            hint.textContent = '✓ كلمتا المرور متطابقتان';
            conf.style.borderColor = 'rgba(5,150,105,.5)';
        } else {
            bar.className  = 'pwd-match-bar no-match';
            hint.className = 'pwd-match-hint visible no-match';
            hint.textContent = '✗ كلمتا المرور غير متطابقتين';
            conf.style.borderColor = 'rgba(239,68,68,.5)';
        }
    }

    pwd.addEventListener('input',  check);
    conf.addEventListener('input', check);
})();

/* ════════════════════════════
   FORM SUBMIT — validate + loader
════════════════════════════ */
const form       = document.getElementById('employee-form');
const submitBtn  = document.getElementById('submit-btn');
const btnText    = document.getElementById('btn-text');
const btnLoading = document.getElementById('btn-loading');

form.addEventListener('submit', function (e) {
    const pwd  = document.getElementById('password').value;
    const conf = document.getElementById('password_confirmation').value;

    if (pwd !== conf) {
        e.preventDefault();
        caShow({
            type:    'warning',
            title:   'كلمات المرور غير متطابقة',
            content: '<p class="ca-msg">تأكد من أن كلمة المرور وتأكيدها متطابقتان تماماً قبل المتابعة.</p>',
            btnText: 'حسناً، سأصحح'
        });
        document.getElementById('password_confirmation').focus();
        return;
    }

    submitBtn.disabled = true;
    btnText.style.display    = 'none';
    btnLoading.style.display = 'flex';
});

/* ════════════════════════════
   BLADE FLASH MESSAGES
════════════════════════════ */
@if(session('success'))
window.addEventListener('DOMContentLoaded', () => {
    caShow({
        type:      'success',
        title:     'تمت العملية!',
        content:   '<p class="ca-msg">{{ session("success") }}</p>',
        btnText:   'حسناً',
        autoClose: 3800
    });
});
@endif

@if($errors->any())
window.addEventListener('DOMContentLoaded', () => {
    let li = '';
    @foreach($errors->all() as $error)
        li += '<li>{{ $error }}</li>';
    @endforeach
    caShow({
        type:    'error',
        title:   'خطأ في البيانات!',
        content: '<ul class="ca-err-list">' + li + '</ul>',
        btnText: 'سأصحح الآن'
    });
});
@endif
</script>
@endpush