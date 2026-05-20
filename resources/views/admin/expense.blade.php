@extends('layouts.app')

@section('title', 'سجل المصاريف والنفقات')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== PAGE BG ===== */
    .exp-page { min-height:100vh; padding:2rem 1rem; position:relative; overflow-x:hidden; }
    .exp-page::before {
        content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%,  rgba(239,68,68,.08)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%,  rgba(217,70,239,.06) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 60% 30%,  rgba(251,113,133,.05)0%, transparent 50%);
    }
    .dark .exp-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 20% 10%,  rgba(239,68,68,.13)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 80% 80%,  rgba(217,70,239,.10) 0%, transparent 60%);
    }
    .orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:320px;height:320px; background:rgba(239,68,68,.07);   top:-80px;  right:-80px; animation-delay:0s;  }
    .orb-2 { width:240px;height:240px; background:rgba(217,70,239,.06);  bottom:10%; left:-60px;  animation-delay:-5s; }
    .orb-3 { width:180px;height:180px; background:rgba(251,113,133,.05); top:45%;    right:4%;    animation-delay:-9s; }
    .dark .orb-1 { background:rgba(239,68,68,.13); }
    .dark .orb-2 { background:rgba(217,70,239,.11); }
    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

    /* ===== CONTAINER ===== */
    .page-container { max-width:1100px; margin:0 auto; position:relative; z-index:1; }

    /* ===== TOP ROW ===== */
    .top-row { display:grid; grid-template-columns:1fr 2fr; gap:1.2rem; margin-bottom:1.8rem; animation:slideDown .6s cubic-bezier(.34,1.56,.64,1) both; }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }

    /* stat card */
    .stat-card {
        background:rgba(255,255,255,.55); backdrop-filter:blur(22px); -webkit-backdrop-filter:blur(22px);
        border:1px solid rgba(255,255,255,.65); border-radius:1.6rem;
        padding:1.5rem 1.8rem;
        box-shadow:0 4px 20px rgba(0,0,0,.06),0 1px 0 rgba(255,255,255,.8) inset;
        display:flex; align-items:center; gap:1.1rem;
        transition:transform .25s cubic-bezier(.34,1.56,.64,1);
        position:relative; overflow:hidden;
    }
    .dark .stat-card { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.45); box-shadow:0 4px 20px rgba(0,0,0,.28); }
    .stat-card:hover { transform:translateY(-3px); }
    .stat-icon-wrap {
        width:52px; height:52px; border-radius:14px; flex-shrink:0;
        background:rgba(239,68,68,.12); display:flex; align-items:center; justify-content:center;
        color:#EF4444; font-size:1.3rem;
    }
    .dark .stat-icon-wrap { background:rgba(239,68,68,.2); }
    .stat-label { font-size:.72rem; font-weight:900; color:#94a3b8; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.3rem; }
    .stat-value { font-size:1.55rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1; }
    .dark .stat-value { color:#f1f5f9; }
    .stat-value small { font-size:.7rem; font-weight:700; color:#94a3b8; margin-right:.25rem; }

    /* header card */
    .header-card {
        background:rgba(255,255,255,.55); backdrop-filter:blur(22px); -webkit-backdrop-filter:blur(22px);
        border:1px solid rgba(255,255,255,.65); border-radius:1.6rem;
        padding:1.5rem 1.8rem;
        box-shadow:0 4px 20px rgba(0,0,0,.06),0 1px 0 rgba(255,255,255,.8) inset;
        display:flex; align-items:center; justify-content:space-between; gap:1rem;
        position:relative; overflow:hidden;
    }
    .dark .header-card { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.45); box-shadow:0 4px 20px rgba(0,0,0,.28); }
    .header-card::before { content:'';position:absolute;top:-60px;left:-60px;width:200px;height:200px;background:rgba(239,68,68,.04);border-radius:50%;filter:blur(60px);pointer-events:none;display:none; }
    .dark .header-card::before { display:block; }

    .hc-title { font-size:1.2rem; font-weight:900; color:#1e293b; letter-spacing:-.02em; }
    .dark .hc-title { color:#f1f5f9; }
    .hc-sub { font-size:.82rem; color:#64748b; font-weight:600; margin-top:3px; }
    .dark .hc-sub { color:#94a3b8; }

    .btn-add {
        display:inline-flex; align-items:center; gap:.6rem;
        padding:.75rem 1.5rem;
        background:linear-gradient(135deg,#EF4444 0%,#DC2626 100%);
        color:#fff; border-radius:.95rem; font-weight:800; font-size:.88rem;
        border:none; cursor:pointer;
        box-shadow:0 6px 22px rgba(239,68,68,.38);
        transition:all .25s cubic-bezier(.34,1.56,.64,1);
        font-family:'Cairo',sans-serif; position:relative; overflow:hidden; flex-shrink:0;
    }
    .btn-add::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .btn-add:hover::before { left:160%; }
    .btn-add:hover { transform:translateY(-2px) scale(1.04); box-shadow:0 10px 30px rgba(239,68,68,.52); }
    .btn-add:active { transform:scale(.96); }

    /* ===== TABLE CARD ===== */
    .table-card {
        background:rgba(255,255,255,.55); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem;
        box-shadow:0 8px 40px rgba(0,0,0,.08),0 1px 0 rgba(255,255,255,.8) inset;
        overflow:hidden; position:relative;
        animation:slideUp .6s .15s cubic-bezier(.34,1.56,.64,1) both;
    }
    .dark .table-card { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.45); box-shadow:0 8px 40px rgba(0,0,0,.3); }
    .table-card::before { content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(239,68,68,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
    .dark .table-card::before { display:block; }
    @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }

    .table-strip {
        background:linear-gradient(135deg,rgba(239,68,68,.07) 0%,rgba(220,38,38,.05) 100%);
        border-bottom:1px solid rgba(239,68,68,.09);
        padding:1rem 1.8rem; display:flex; align-items:center; gap:.7rem;
    }
    .dark .table-strip { background:linear-gradient(135deg,rgba(239,68,68,.11) 0%,rgba(220,38,38,.08) 100%); border-bottom-color:rgba(51,65,85,.4); }
    .strip-dot { width:8px;height:8px;border-radius:50%;background:#EF4444;box-shadow:0 0 9px rgba(239,68,68,.7);flex-shrink:0; }
    .strip-label { font-size:.71rem;font-weight:900;color:#EF4444;text-transform:uppercase;letter-spacing:.1em; }
    .dark .strip-label { color:#f87171; }
    .strip-count { margin-right:auto;font-size:.72rem;font-weight:800;color:#64748b;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.15);padding:.22rem .75rem;border-radius:999px; }
    .dark .strip-count { background:rgba(239,68,68,.14);color:#94a3b8; }

    /* table */
    .tbl-scroll { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; text-align:right; }
    thead tr { background:linear-gradient(135deg,rgba(239,68,68,.05) 0%,rgba(220,38,38,.04) 100%); border-bottom:1px solid rgba(148,163,184,.10); }
    .dark thead tr { background:rgba(15,23,42,.4); border-bottom-color:rgba(51,65,85,.3); }
    thead th { padding:.85rem 1.3rem;font-size:.68rem;font-weight:900;text-transform:uppercase;letter-spacing:.07em;color:#94a3b8;white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(148,163,184,.07); transition:background .15s ease; }
    .dark tbody tr { border-bottom-color:rgba(51,65,85,.18); }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(239,68,68,.03); }
    .dark tbody tr:hover { background:rgba(239,68,68,.06); }
    tbody td { padding:.9rem 1.3rem;font-size:.87rem;font-weight:600;color:#334155;white-space:nowrap; }
    .dark tbody td { color:#cbd5e1; }

    .td-date { font-size:.82rem; color:#64748b; font-variant-numeric:tabular-nums; }
    .dark .td-date { color:#94a3b8; }
    .td-desc { font-weight:800; color:#1e293b; }
    .dark .td-desc { color:#f1f5f9; }
    .td-amount { font-weight:900; color:#EF4444; font-size:.9rem; }
    .dark .td-amount { color:#f87171; }

    /* category badge */
    .cat-badge {
        display:inline-flex; align-items:center;
        padding:.28rem .75rem; border-radius:.55rem;
        font-size:.68rem; font-weight:800; background:rgba(148,163,184,.1);
        color:#64748b; border:1px solid rgba(148,163,184,.18);
    }
    .dark .cat-badge { background:rgba(71,85,105,.25); color:#94a3b8; border-color:rgba(71,85,105,.3); }

    /* user avatar */
    .user-cell { display:flex; align-items:center; gap:.6rem; }
    .user-avatar {
        width:30px; height:30px; border-radius:50%; flex-shrink:0;
        background:linear-gradient(135deg,#EF4444,#DC2626);
        display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:.7rem; font-weight:900;
        box-shadow:0 2px 8px rgba(239,68,68,.3);
    }
    .user-name { font-size:.83rem; font-weight:700; color:#475569; }
    .dark .user-name { color:#94a3b8; }

    /* delete button */
    .btn-delete {
        width:34px; height:34px; border-radius:.7rem; border:none; cursor:pointer;
        background:rgba(239,68,68,.08); color:#EF4444;
        display:flex; align-items:center; justify-content:center;
        transition:all .22s cubic-bezier(.34,1.56,.64,1);
        font-size:.85rem;
    }
    .dark .btn-delete { background:rgba(239,68,68,.13); }
    .btn-delete:hover { background:rgba(239,68,68,.18); transform:scale(1.12); box-shadow:0 4px 14px rgba(239,68,68,.28); }
    .btn-delete:active { transform:scale(.95); }

    /* empty state */
    .empty-state { padding:4rem 2rem; text-align:center; }
    .empty-icon { width:72px;height:72px;border-radius:50%;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;font-size:1.8rem;color:#EF4444; }
    .dark .empty-icon { background:rgba(239,68,68,.14); }
    .empty-state p { font-size:.9rem;font-weight:700;color:#94a3b8; }

    /* pagination */
    .pagination-wrap { padding:1.2rem 1.8rem;border-top:1px solid rgba(148,163,184,.1);display:flex;justify-content:center; }
    .dark .pagination-wrap { border-top-color:rgba(51,65,85,.3); }

    /* ===== MODAL ===== */
    .modal-overlay {
        position:fixed; inset:0; z-index:8888;
        display:flex; align-items:center; justify-content:center; padding:1rem;
        background:rgba(2,10,28,.45);
        backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px);
        opacity:0; pointer-events:none; transition:opacity .3s ease;
    }
    .modal-overlay.open { opacity:1; pointer-events:all; }
    .modal-card {
        width:100%; max-width:500px;
        background:rgba(255,255,255,.72); backdrop-filter:blur(28px); -webkit-backdrop-filter:blur(28px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem; overflow:hidden;
        box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.18);
        transform:scale(.85) translateY(24px); opacity:0;
        transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
        direction:rtl;
    }
    .dark .modal-card { background:rgba(10,17,34,.82); border-color:rgba(51,65,85,.55); }
    .modal-overlay.open .modal-card { transform:scale(1) translateY(0); opacity:1; }

    .modal-strip { background:linear-gradient(135deg,rgba(239,68,68,.08),rgba(220,38,38,.06));border-bottom:1px solid rgba(239,68,68,.1);padding:1rem 1.8rem;display:flex;align-items:center;gap:.7rem; }
    .dark .modal-strip { background:linear-gradient(135deg,rgba(239,68,68,.12),rgba(220,38,38,.09));border-bottom-color:rgba(51,65,85,.4); }
    .modal-dot { width:8px;height:8px;border-radius:50%;background:#EF4444;box-shadow:0 0 9px rgba(239,68,68,.7); }
    .modal-strip-label { font-size:.71rem;font-weight:900;color:#EF4444;text-transform:uppercase;letter-spacing:.1em; }
    .dark .modal-strip-label { color:#f87171; }
    .modal-close-btn { margin-right:auto;width:28px;height:28px;border-radius:50%;border:none;background:rgba(148,163,184,.12);color:#94a3b8;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.8rem;transition:all .2s ease; }
    .modal-close-btn:hover { background:rgba(239,68,68,.12);color:#EF4444; }

    .modal-body { padding:1.8rem 2rem 1.4rem; }
    .modal-title { font-size:1.15rem;font-weight:900;color:#1e293b;letter-spacing:-.02em;margin-bottom:1.4rem; }
    .dark .modal-title { color:#f1f5f9; }

    .modal-fields { display:flex; flex-direction:column; gap:1.2rem; }
    .modal-grid { display:grid; grid-template-columns:1fr 1fr; gap:1.1rem; }

    .m-field-label { font-size:.69rem;font-weight:900;color:#EF4444;text-transform:uppercase;letter-spacing:.08em;display:flex;align-items:center;gap:.35rem;margin-bottom:.42rem; }
    .dark .m-field-label { color:#f87171; }
    .m-field-label i { font-size:.6rem;opacity:.85; }

    .m-input {
        width:100%; padding:.82rem 1.1rem;
        background:rgba(255,255,255,.62); backdrop-filter:blur(8px);
        border:1px solid rgba(148,163,184,.22); border-radius:.9rem;
        font-size:.9rem; font-family:'Cairo',sans-serif; font-weight:600; color:#1e293b;
        outline:none; direction:rtl; box-sizing:border-box;
        transition:border-color .22s ease,box-shadow .22s ease,background .22s ease;
    }
    .dark .m-input { background:rgba(15,23,42,.52); border-color:rgba(51,65,85,.48); color:#f1f5f9; }
    .m-input::placeholder { color:#94a3b8; font-weight:500; }
    .m-input:focus { border-color:rgba(239,68,68,.5);box-shadow:0 0 0 3px rgba(239,68,68,.12);background:rgba(255,255,255,.9); }
    .dark .m-input:focus { background:rgba(15,23,42,.9);box-shadow:0 0 0 3px rgba(239,68,68,.2); }
    .m-wrap { position:relative; }
    .m-suffix { position:absolute;left:1rem;top:50%;transform:translateY(-50%);font-size:.68rem;font-weight:800;color:#94a3b8;background:rgba(148,163,184,.1);padding:2px 7px;border-radius:5px;pointer-events:none; }
    .dark .m-suffix { background:rgba(71,85,105,.28);color:#64748b; }
    .m-input.has-s { padding-left:3.2rem; }

    .modal-footer { padding:0 2rem 1.8rem; display:flex; align-items:center; justify-content:flex-start; gap:.8rem; flex-direction:row-reverse; }
    .modal-divider { border:none;border-top:1px solid rgba(148,163,184,.12);margin:.2rem 2rem .2rem; }
    .dark .modal-divider { border-color:rgba(51,65,85,.3); }

    .btn-modal-submit {
        display:inline-flex; align-items:center; gap:.6rem;
        padding:.75rem 2rem;
        background:linear-gradient(135deg,#EF4444,#DC2626); color:#fff;
        border-radius:.9rem; font-weight:800; font-size:.88rem;
        border:none; cursor:pointer;
        box-shadow:0 5px 18px rgba(239,68,68,.38);
        transition:all .25s cubic-bezier(.34,1.56,.64,1);
        font-family:'Cairo',sans-serif; position:relative; overflow:hidden;
    }
    .btn-modal-submit::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);transition:left .5s ease; }
    .btn-modal-submit:hover::before { left:160%; }
    .btn-modal-submit:hover { transform:translateY(-2px) scale(1.03);box-shadow:0 8px 26px rgba(239,68,68,.52); }
    .btn-modal-submit:active { transform:scale(.96); }

    .btn-modal-cancel {
        padding:.75rem 1.5rem;background:rgba(148,163,184,.1);border:1px solid rgba(148,163,184,.2);
        color:#64748b;border-radius:.9rem;font-weight:700;font-size:.87rem;
        cursor:pointer;font-family:'Cairo',sans-serif;transition:all .2s ease;
    }
    .dark .btn-modal-cancel { background:rgba(71,85,105,.22);border-color:rgba(71,85,105,.3);color:#94a3b8; }
    .btn-modal-cancel:hover { background:rgba(148,163,184,.2); }

    /* ===== CONFIRM DELETE MODAL ===== */
    .del-overlay {
        position:fixed; inset:0; z-index:9000;
        display:flex; align-items:center; justify-content:center; padding:1rem;
        background:rgba(2,10,28,.45); backdrop-filter:blur(10px);
        opacity:0; pointer-events:none; transition:opacity .3s ease;
    }
    .del-overlay.open { opacity:1; pointer-events:all; }
    .del-card {
        width:100%; max-width:380px;
        background:rgba(255,255,255,.72); backdrop-filter:blur(28px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem; overflow:hidden;
        box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.18);
        transform:scale(.85) translateY(20px); opacity:0;
        transition:transform .4s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
        direction:rtl;
    }
    .dark .del-card { background:rgba(10,17,34,.82); border-color:rgba(51,65,85,.55); }
    .del-overlay.open .del-card { transform:scale(1) translateY(0); opacity:1; }
    .del-bar { height:4px; background:linear-gradient(90deg,#EF4444,#DC2626); }
    .del-body { padding:2rem 1.8rem 1.5rem; text-align:center; }
    .del-icon { width:68px;height:68px;border-radius:50%;background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.22),rgba(239,68,68,.06));border:1.5px solid rgba(239,68,68,.3);box-shadow:0 0 0 8px rgba(239,68,68,.07);display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;font-size:1.7rem;color:#EF4444; }
    .del-title { font-size:1.1rem;font-weight:900;color:#1e293b;margin-bottom:.4rem; }
    .dark .del-title { color:#f1f5f9; }
    .del-msg { font-size:.84rem;font-weight:600;color:#64748b;line-height:1.65; }
    .dark .del-msg { color:#94a3b8; }
    .del-footer { padding:0 1.8rem 1.8rem;display:flex;gap:.7rem;justify-content:center; }
    .btn-del-confirm { flex:1;padding:.72rem 1rem;background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;border-radius:.85rem;font-weight:800;font-size:.88rem;border:none;cursor:pointer;font-family:'Cairo',sans-serif;box-shadow:0 5px 16px rgba(239,68,68,.38);transition:all .22s cubic-bezier(.34,1.56,.64,1); }
    .btn-del-confirm:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(239,68,68,.52); }
    .btn-del-cancel { flex:1;padding:.72rem 1rem;background:rgba(148,163,184,.1);border:1px solid rgba(148,163,184,.2);color:#64748b;border-radius:.85rem;font-weight:700;font-size:.88rem;cursor:pointer;font-family:'Cairo',sans-serif;transition:all .2s ease; }
    .dark .btn-del-cancel { background:rgba(71,85,105,.22);border-color:rgba(71,85,105,.3);color:#94a3b8; }
    .btn-del-cancel:hover { background:rgba(148,163,184,.2); }

    /* ===== CUSTOM ALERT (toast) ===== */
    .ca-overlay { position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(2,10,28,.42);backdrop-filter:blur(10px);opacity:0;pointer-events:none;transition:opacity .3s ease; }
    .ca-overlay.ca-show { opacity:1;pointer-events:all; }
    .ca-card { width:100%;max-width:400px;background:rgba(255,255,255,.72);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.65);border-radius:2rem;overflow:hidden;box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.16);transform:scale(.82) translateY(28px);opacity:0;transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;direction:rtl; }
    .dark .ca-card { background:rgba(10,17,34,.82);border-color:rgba(51,65,85,.55); }
    .ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0);opacity:1; }
    .ca-bar-top { height:4px; }
    .ca-bar-top.success { background:linear-gradient(90deg,#EF4444,#DC2626); }
    .ca-bar-top.error   { background:linear-gradient(90deg,#f97316,#ea580c); }
    .ca-body { padding:2rem 2rem 1.5rem;display:flex;flex-direction:column;align-items:center;text-align:center; }
    .ca-ring { width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem;flex-shrink:0; }
    .ca-ring.success { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.22),rgba(239,68,68,.06));border:1.5px solid rgba(239,68,68,.3);box-shadow:0 0 0 8px rgba(239,68,68,.07); }
    .ca-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(249,115,22,.2),rgba(249,115,22,.05));border:1.5px solid rgba(249,115,22,.28);box-shadow:0 0 0 8px rgba(249,115,22,.06); }
    .ca-ring svg { width:34px;height:34px;overflow:visible; }
    .ca-cc { stroke:#EF4444;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-cm { stroke:#EF4444;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48; }
    .ca-ec { stroke:#f97316;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-ex1,.ca-ex2 { stroke:#f97316;stroke-width:3;stroke-linecap:round;stroke-dasharray:30;stroke-dashoffset:30; }
    .ca-overlay.ca-show .ca-cc  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-cm  { animation:caS .38s .55s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ec  { animation:caS .55s .15s cubic-bezier(.65,0,.45,1) forwards; }
    .ca-overlay.ca-show .ca-ex1 { animation:caS .28s .55s ease forwards; }
    .ca-overlay.ca-show .ca-ex2 { animation:caS .28s .72s ease forwards; }
    @keyframes caS { to{stroke-dashoffset:0} }
    .ca-title { font-size:1.18rem;font-weight:900;color:#1e293b;letter-spacing:-.025em;line-height:1.25;margin-bottom:.42rem; }
    .dark .ca-title { color:#f1f5f9; }
    .ca-msg { font-size:.87rem;font-weight:600;color:#64748b;line-height:1.7; }
    .dark .ca-msg { color:#94a3b8; }
    .ca-prog-wrap { width:100%;height:3px;background:rgba(148,163,184,.12);margin-top:1.4rem;border-radius:99px;overflow:hidden; }
    .ca-prog-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#EF4444,#DC2626);transform-origin:left; }
    .ca-prog-fill.run { animation:caP var(--ca-dur,3.8s) linear forwards; }
    @keyframes caP { from{transform:scaleX(1)} to{transform:scaleX(0)} }
    .ca-footer-btn { padding:0 2rem 1.8rem;display:flex;justify-content:center; }
    .ca-btn { font-family:'Cairo',sans-serif;font-weight:800;font-size:.9rem;padding:.65rem 2.2rem;border-radius:.9rem;border:none;cursor:pointer;transition:all .25s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden; }
    .ca-btn.success { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;box-shadow:0 5px 18px rgba(239,68,68,.38); }
    .ca-btn.success:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(239,68,68,.55); }
    .ca-btn.error   { background:linear-gradient(135deg,#f97316,#ea580c);color:#fff;box-shadow:0 5px 18px rgba(249,115,22,.32); }
    .ca-btn:active { transform:scale(.96); }
    .ca-btn::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .ca-btn:hover::before { left:160%; }

    @media(max-width:768px) {
        .top-row { grid-template-columns:1fr; }
        .modal-grid { grid-template-columns:1fr; }
    }
</style>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="exp-page" dir="rtl">
<div class="page-container">

    <!-- Top row -->
    <div class="top-row">
        <!-- Stat -->
        <div class="stat-card">
            <div class="stat-icon-wrap"><i class="fas fa-chart-line"></i></div>
            <div>
                <p class="stat-label">إجمالي المصاريف</p>
                <p class="stat-value"><small>DA</small>{{ number_format($expenses->sum('amount'), 2) }}</p>
            </div>
        </div>
        <!-- Header -->
        <div class="header-card">
            <div>
                <p class="hc-title">إدارة المصاريف</p>
                <p class="hc-sub">تتبع كافة المصاريف التشغيلية للمؤسسة</p>
            </div>
            <button class="btn-add" onclick="openAddModal()">
                <i class="fas fa-plus"></i>
                إضافة مصاريف
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        <div class="table-strip">
            <div class="strip-dot"></div>
            <span class="strip-label">سجل المصاريف</span>
            <span class="strip-count">{{ $expenses->count() }} سجل</span>
        </div>

        <div class="tbl-scroll">
            <table>
                <thead>
                    <tr>
                        <th>التاريخ</th>
                        <th>الوصف / البيان</th>
                        <th>الفئة</th>
                        <th>بواسطة</th>
                        <th style="text-align:center">المبلغ</th>
                        <th style="text-align:center">حذف</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td><span class="td-date">{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}</span></td>
                        <td><span class="td-desc">{{ $expense->description }}</span></td>
                        <td><span class="cat-badge">{{ $expense->category ?? 'عام' }}</span></td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ mb_substr($expense->user->name ?? 'A', 0, 1) }}</div>
                                <span class="user-name">{{ $expense->user->name ?? 'غير معروف' }}</span>
                            </div>
                        </td>
                        <td style="text-align:center"><span class="td-amount">{{ number_format($expense->amount, 2) }} DA</span></td>
                        <td style="text-align:center">
                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn-delete" onclick="confirmDelete(this)" title="حذف">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
                            <p>لا توجد مصاريف مسجّلة حالياً</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($expenses, 'hasPages') && $expenses->hasPages())
        <div class="pagination-wrap">{{ $expenses->links() }}</div>
        @endif
    </div>

</div>
</div>

<!-- ===== ADD MODAL ===== -->
<div class="modal-overlay" id="addModal">
    <div class="modal-card">
        <div class="modal-strip">
            <div class="modal-dot"></div>
            <span class="modal-strip-label">مصروف جديد</span>
            <button class="modal-close-btn" onclick="closeAddModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p class="modal-title">إضافة مصاريف جديدة</p>
            <form id="addExpenseForm" action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="modal-fields">
                    <div>
                        <label class="m-field-label"><i class="fas fa-tag"></i> عنوان المصروف</label>
                        <div class="m-wrap">
                            <input type="text" name="title" required class="m-input" placeholder="مثال: فاتورة الكهرباء">
                        </div>
                    </div>
                    <div class="modal-grid">
                        <div>
                            <label class="m-field-label"><i class="fas fa-coins"></i> المبلغ</label>
                            <div class="m-wrap">
                                <input type="number" step="0.01" name="amount" required class="m-input has-s" placeholder="0.00">
                                <span class="m-suffix">DA</span>
                            </div>
                        </div>
                        <div>
                            <label class="m-field-label"><i class="fas fa-calendar-alt"></i> التاريخ</label>
                            <div class="m-wrap">
                                <input type="date" name="expense_date" required class="m-input" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="m-field-label"><i class="fas fa-align-right"></i> الوصف (اختياري)</label>
                        <textarea name="description" rows="3" class="m-input" placeholder="تفاصيل إضافية..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        <hr class="modal-divider">
        <div class="modal-footer">
            <button class="btn-modal-submit" onclick="document.getElementById('addExpenseForm').submit()">
                <i class="fas fa-check"></i> حفظ المصروف
            </button>
            <button class="btn-modal-cancel" onclick="closeAddModal()">إلغاء</button>
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRM ===== -->
<div class="del-overlay" id="delOverlay">
    <div class="del-card">
        <div class="del-bar"></div>
        <div class="del-body">
            <div class="del-icon"><i class="fas fa-trash-alt"></i></div>
            <p class="del-title">تأكيد الحذف</p>
            <p class="del-msg">هل أنت متأكد من حذف هذا السجل؟<br>لن تتمكن من استرجاعه لاحقاً.</p>
        </div>
        <div class="del-footer">
            <button class="btn-del-confirm" id="delConfirmBtn">نعم، احذف</button>
            <button class="btn-del-cancel" onclick="closeDelModal()">إلغاء</button>
        </div>
    </div>
</div>

<!-- ===== CUSTOM ALERT ===== -->
<div class="ca-overlay" id="caOverlay">
    <div class="ca-card">
        <div class="ca-bar-top" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-ring" id="caRing"></div>
            <p class="ca-title" id="caTitle"></p>
            <p class="ca-msg"   id="caMsg"></p>
            <div class="ca-prog-wrap" id="caPW" style="display:none">
                <div class="ca-prog-fill" id="caPF"></div>
            </div>
        </div>
        <div class="ca-footer-btn">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

<script>
/* ── Add Modal ── */
function openAddModal()  { document.getElementById('addModal').classList.add('open'); }
function closeAddModal() { document.getElementById('addModal').classList.remove('open'); }
document.getElementById('addModal').addEventListener('click', function(e){ if(e.target===this)closeAddModal(); });

/* ── Delete confirm ── */
let pendingDeleteForm = null;
function confirmDelete(btn) {
    pendingDeleteForm = btn.closest('.delete-form');
    document.getElementById('delOverlay').classList.add('open');
}
function closeDelModal() { document.getElementById('delOverlay').classList.remove('open'); pendingDeleteForm=null; }
document.getElementById('delConfirmBtn').addEventListener('click', function(){
    if(pendingDeleteForm) pendingDeleteForm.submit();
});
document.getElementById('delOverlay').addEventListener('click', function(e){ if(e.target===this)closeDelModal(); });

/* ── Custom Alert ── */
const CA_SVG = {
    success:`<svg viewBox="0 0 52 52"><circle class="ca-cc" cx="26" cy="26" r="25"/><path class="ca-cm" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>`,
    error:  `<svg viewBox="0 0 52 52"><circle class="ca-ec" cx="26" cy="26" r="25"/><line class="ca-ex1" x1="16" y1="16" x2="36" y2="36"/><line class="ca-ex2" x1="36" y1="16" x2="16" y2="36"/></svg>`
};
let caTimer=null;
function caShow({type,title,msg,btnText,autoClose}){
    const o=document.getElementById('caOverlay'),bar=document.getElementById('caBar'),
          rng=document.getElementById('caRing'),t=document.getElementById('caTitle'),
          m=document.getElementById('caMsg'),btn=document.getElementById('caBtn'),
          pw=document.getElementById('caPW'),pf=document.getElementById('caPF');
    o.classList.remove('ca-show');
    bar.className=`ca-bar-top ${type}`;rng.className=`ca-ring ${type}`;
    rng.innerHTML=CA_SVG[type];t.textContent=title;m.textContent=msg;
    btn.className=`ca-btn ${type}`;btn.textContent=btnText;
    if(autoClose){ pw.style.display='block';pf.className='ca-prog-fill';pf.style.setProperty('--ca-dur',autoClose/1000+'s');void pf.offsetWidth;pf.classList.add('run');caTimer=setTimeout(caClose,autoClose); }
    else { pw.style.display='none'; }
    requestAnimationFrame(()=>o.classList.add('ca-show'));
}
function caClose(){ clearTimeout(caTimer);document.getElementById('caOverlay').classList.remove('ca-show'); }
document.getElementById('caOverlay').addEventListener('click',function(e){if(e.target===this)caClose();});

/* ── Blade triggers ── */
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