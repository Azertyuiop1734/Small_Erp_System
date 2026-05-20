@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&family=Tajawal:wght@400;500;700;800&display=swap');
    * { font-family: 'Cairo', 'Tajawal', sans-serif; }

    /* ===== BG ===== */
    .rpt-page { min-height:100vh; padding:2rem 1rem 4rem; position:relative; overflow-x:hidden; }
    .rpt-page::before {
        content:''; position:fixed; inset:0; pointer-events:none; z-index:0;
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.09)  0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(99,102,241,.07) 0%, transparent 60%),
            radial-gradient(ellipse 40% 40% at 55% 30%,  rgba(59,130,246,.05) 0%, transparent 50%);
    }
    .dark .rpt-page::before {
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%,  rgba(37,99,235,.14) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 85%,  rgba(99,102,241,.12) 0%, transparent 60%);
    }
    .orb { position:fixed; border-radius:50%; filter:blur(72px); pointer-events:none; z-index:0; animation:floatOrb 13s ease-in-out infinite; }
    .orb-1 { width:340px;height:340px; background:rgba(37,99,235,.07);   top:-90px;  right:-90px; animation-delay:0s;  }
    .orb-2 { width:260px;height:260px; background:rgba(99,102,241,.06);  bottom:10%; left:-60px;  animation-delay:-5s; }
    .orb-3 { width:190px;height:190px; background:rgba(59,130,246,.05);  top:40%;    right:3%;    animation-delay:-9s; }
    .dark .orb-1 { background:rgba(37,99,235,.13); }
    .dark .orb-2 { background:rgba(99,102,241,.11); }
    @keyframes floatOrb { 0%,100%{transform:translateY(0) scale(1)} 50%{transform:translateY(-28px) scale(1.06)} }

    /* ===== LAYOUT ===== */
    .page-container { max-width:1100px; margin:0 auto; position:relative; z-index:1; }

    /* ===== GLASS BASE ===== */
    .glass {
        background:rgba(255,255,255,.55); backdrop-filter:blur(24px); -webkit-backdrop-filter:blur(24px);
        border:1px solid rgba(255,255,255,.65); border-radius:2rem;
        box-shadow:0 4px 32px rgba(0,0,0,.07),0 1px 0 rgba(255,255,255,.85) inset;
    }
    .dark .glass {
        background:rgba(10,17,34,.65); border-color:rgba(51,65,85,.45);
        box-shadow:0 4px 32px rgba(0,0,0,.35);
    }

    /* ===== HEADER CARD ===== */
    .header-card {
        display:flex; align-items:center; justify-content:space-between;
        flex-wrap:wrap; gap:1.2rem;
        padding:1.5rem 2rem; margin-bottom:1.8rem;
        position:relative; overflow:hidden;
        animation:slideDown .6s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes slideDown { from{opacity:0;transform:translateY(-18px)} to{opacity:1;transform:translateY(0)} }
    .header-card::before { content:'';position:absolute;top:-70px;right:-70px;width:240px;height:240px;background:rgba(37,99,235,.05);border-radius:50%;filter:blur(70px);pointer-events:none;display:none; }
    .dark .header-card::before { display:block; }

    .header-brand { display:flex; align-items:center; gap:1.2rem; }
    .header-icon {
        width:62px; height:62px; flex-shrink:0;
        background:linear-gradient(135deg,#2563EB 0%,#4F46E5 100%);
        border-radius:19px; display:flex; align-items:center; justify-content:center;
        box-shadow:0 8px 28px rgba(37,99,235,.38),0 0 0 3px rgba(37,99,235,.15);
        position:relative;
    }
    .header-icon::after { content:'';position:absolute;inset:-3px;border-radius:22px;background:linear-gradient(135deg,rgba(255,255,255,.28),transparent);pointer-events:none; }
    .header-icon i { color:#fff; font-size:1.45rem; position:relative; z-index:1; }

    .header-title { font-size:1.8rem; font-weight:900; color:#1e293b; letter-spacing:-.03em; line-height:1.1; }
    .dark .header-title { color:#f1f5f9; }
    .header-sub { font-size:.82rem; color:#64748b; font-weight:600; margin-top:4px; display:flex; align-items:center; gap:.5rem; }
    .dark .header-sub { color:#94a3b8; }
    .pulse-dot { width:7px;height:7px;border-radius:50%;background:#2563EB;animation:pulse 1.8s ease-in-out infinite; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

    /* count badge */
    .count-badge {
        display:flex; flex-direction:column; align-items:center;
        padding:.7rem 1.4rem;
        background:rgba(255,255,255,.6); backdrop-filter:blur(12px);
        border:1px solid rgba(255,255,255,.7); border-radius:1.2rem;
        box-shadow:0 2px 12px rgba(0,0,0,.05);
    }
    .dark .count-badge { background:rgba(15,23,42,.55); border-color:rgba(51,65,85,.5); }
    .count-label { font-size:.65rem;font-weight:900;color:#94a3b8;text-transform:uppercase;letter-spacing:.09em;margin-bottom:.2rem; }
    .count-value { font-size:1.7rem;font-weight:900;color:#2563EB;letter-spacing:-.04em;line-height:1; }
    .dark .count-value { color:#60a5fa; }

    /* ===== TABLE CARD ===== */
    .table-card {
        overflow:hidden; position:relative;
        animation:slideUp .6s .15s cubic-bezier(.34,1.56,.64,1) both;
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .table-card::before { content:'';position:absolute;top:-80px;right:-80px;width:260px;height:260px;background:rgba(37,99,235,.05);border-radius:50%;filter:blur(80px);pointer-events:none;display:none; }
    .dark .table-card::before { display:block; }

    /* strip */
    .table-strip {
        background:linear-gradient(135deg,rgba(37,99,235,.07) 0%,rgba(99,102,241,.05) 100%);
        border-bottom:1px solid rgba(37,99,235,.09);
        padding:1rem 2rem; display:flex; align-items:center; gap:.7rem;
    }
    .dark .table-strip { background:linear-gradient(135deg,rgba(37,99,235,.11) 0%,rgba(99,102,241,.08) 100%); border-bottom-color:rgba(51,65,85,.4); }
    .strip-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7);flex-shrink:0; }
    .strip-lbl { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
    .dark .strip-lbl { color:#60a5fa; }
    .strip-count { margin-right:auto;font-size:.72rem;font-weight:800;color:#64748b;background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.15);padding:.22rem .75rem;border-radius:999px; }
    .dark .strip-count { background:rgba(37,99,235,.14);color:#94a3b8; }

    /* table */
    .tbl-scroll { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; text-align:right; }
    thead tr { background:linear-gradient(135deg,rgba(37,99,235,.05) 0%,rgba(99,102,241,.04) 100%); border-bottom:1px solid rgba(148,163,184,.10); }
    .dark thead tr { background:rgba(15,23,42,.4); border-bottom-color:rgba(51,65,85,.3); }
    thead th { padding:.85rem 1.4rem;font-size:.67rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#94a3b8;white-space:nowrap; }
    tbody tr { border-bottom:1px solid rgba(148,163,184,.07); transition:background .15s ease; }
    .dark tbody tr { border-bottom-color:rgba(51,65,85,.18); }
    tbody tr:last-child { border-bottom:none; }
    tbody tr:hover { background:rgba(37,99,235,.035); }
    .dark tbody tr:hover { background:rgba(37,99,235,.07); }
    tbody td { padding:.95rem 1.4rem;font-size:.87rem;font-weight:600;color:#334155;white-space:nowrap; }
    .dark tbody td { color:#cbd5e1; }

    /* title cell */
    .td-title { font-weight:900;color:#1e293b;font-size:.9rem; }
    .dark .td-title { color:#f1f5f9; }
    .td-desc { font-size:.75rem;color:#94a3b8;font-weight:600;margin-top:2px;max-width:200px;overflow:hidden;text-overflow:ellipsis; }

    /* user avatar */
    .user-cell { display:flex;align-items:center;gap:.65rem; }
    .user-av {
        width:34px;height:34px;border-radius:11px;flex-shrink:0;
        background:linear-gradient(135deg,#2563EB,#4F46E5);
        display:flex;align-items:center;justify-content:center;
        color:#fff;font-size:.72rem;font-weight:900;
        box-shadow:0 2px 8px rgba(37,99,235,.3);
    }
    .user-name { font-size:.85rem;font-weight:700;color:#475569; }
    .dark .user-name { color:#94a3b8; }

    /* warehouse badge */
    .wh-badge {
        display:inline-flex;align-items:center;gap:.35rem;
        padding:.3rem .8rem;border-radius:.6rem;
        background:rgba(249,115,22,.08);color:#F97316;
        border:1px solid rgba(249,115,22,.18);
        font-size:.72rem;font-weight:800;
    }
    .dark .wh-badge { background:rgba(249,115,22,.13);border-color:rgba(249,115,22,.25); }

    /* time cell */
    .time-cell { text-align:center; }
    .time-date { font-size:.82rem;font-weight:800;color:#1e293b; }
    .dark .time-date { color:#e2e8f0; }
    .time-hour { font-size:.72rem;color:#94a3b8;font-weight:600; }

    /* action buttons */
    .action-cell { display:flex;align-items:center;justify-content:center;gap:.55rem; }
    .btn-view, .btn-del {
        width:36px;height:36px;border-radius:.75rem;border:none;cursor:pointer;
        display:flex;align-items:center;justify-content:center;font-size:.85rem;
        transition:all .22s cubic-bezier(.34,1.56,.64,1);
    }
    .btn-view { background:rgba(37,99,235,.09);color:#2563EB; }
    .dark .btn-view { background:rgba(37,99,235,.16); }
    .btn-view:hover { background:linear-gradient(135deg,#2563EB,#4F46E5);color:#fff;transform:scale(1.12);box-shadow:0 4px 14px rgba(37,99,235,.35); }
    .btn-del  { background:rgba(239,68,68,.08);color:#EF4444; }
    .dark .btn-del  { background:rgba(239,68,68,.14); }
    .btn-del:hover  { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;transform:scale(1.12);box-shadow:0 4px 14px rgba(239,68,68,.35); }

    /* empty */
    .empty-state { padding:4.5rem 2rem;text-align:center; }
    .empty-icon { width:76px;height:76px;border-radius:50%;background:rgba(37,99,235,.08);border:1px solid rgba(37,99,235,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.2rem;font-size:1.9rem;color:#2563EB; }
    .dark .empty-icon { background:rgba(37,99,235,.14); }
    .empty-title { font-size:1rem;font-weight:800;color:#64748b;margin-bottom:.3rem; }
    .dark .empty-title { color:#94a3b8; }
    .empty-sub { font-size:.82rem;font-weight:600;color:#94a3b8; }

    /* ===== VIEW MODAL ===== */
    .view-overlay {
        position:fixed;inset:0;z-index:9000;display:flex;align-items:center;justify-content:center;padding:1rem;
        background:rgba(2,10,28,.45);backdrop-filter:blur(10px);
        opacity:0;pointer-events:none;transition:opacity .3s ease;
    }
    .view-overlay.open { opacity:1;pointer-events:all; }
    .view-card {
        width:100%;max-width:520px;
        background:rgba(255,255,255,.74);backdrop-filter:blur(28px);
        border:1px solid rgba(255,255,255,.68);border-radius:2rem;overflow:hidden;
        box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.17);
        transform:scale(.84) translateY(22px);opacity:0;
        transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;
        direction:rtl;
    }
    .dark .view-card { background:rgba(10,17,34,.83);border-color:rgba(51,65,85,.55); }
    .view-overlay.open .view-card { transform:scale(1) translateY(0);opacity:1; }

    .view-strip { background:linear-gradient(135deg,rgba(37,99,235,.08),rgba(99,102,241,.06));border-bottom:1px solid rgba(37,99,235,.1);padding:1rem 1.8rem;display:flex;align-items:center;gap:.7rem; }
    .dark .view-strip { background:linear-gradient(135deg,rgba(37,99,235,.12),rgba(99,102,241,.09));border-bottom-color:rgba(51,65,85,.4); }
    .view-dot { width:8px;height:8px;border-radius:50%;background:#2563EB;box-shadow:0 0 9px rgba(37,99,235,.7); }
    .view-strip-lbl { font-size:.71rem;font-weight:900;color:#2563EB;text-transform:uppercase;letter-spacing:.1em; }
    .dark .view-strip-lbl { color:#60a5fa; }
    .view-close { margin-right:auto;width:28px;height:28px;border-radius:50%;border:none;background:rgba(148,163,184,.12);color:#94a3b8;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.8rem;transition:all .2s; }
    .view-close:hover { background:rgba(239,68,68,.12);color:#EF4444; }

    .view-body { padding:1.8rem 2rem; }
    .view-title { font-size:1.2rem;font-weight:900;color:#1e293b;letter-spacing:-.025em;margin-bottom:1rem; }
    .dark .view-title { color:#f1f5f9; }
    .view-meta { display:flex;flex-wrap:wrap;gap:.6rem;margin-bottom:1.3rem; }
    .meta-tag { display:inline-flex;align-items:center;gap:.35rem;padding:.3rem .85rem;border-radius:999px;font-size:.75rem;font-weight:800; }
    .meta-tag.blue { background:rgba(37,99,235,.1);color:#2563EB;border:1px solid rgba(37,99,235,.2); }
    .meta-tag.orange { background:rgba(249,115,22,.1);color:#F97316;border:1px solid rgba(249,115,22,.2); }
    .dark .meta-tag.blue { background:rgba(37,99,235,.18); }
    .dark .meta-tag.orange { background:rgba(249,115,22,.16); }
    .view-content {
        background:rgba(248,250,252,.8);backdrop-filter:blur(8px);
        border:1px solid rgba(148,163,184,.15);border-right:4px solid #2563EB;
        border-radius:.9rem;padding:1.2rem 1.4rem;
        font-size:.9rem;font-weight:600;color:#334155;line-height:1.75;
    }
    .dark .view-content { background:rgba(15,23,42,.55);border-color:rgba(51,65,85,.35);border-right-color:#3B82F6;color:#cbd5e1; }
    .view-footer { padding:0 2rem 1.8rem;display:flex;justify-content:center; }
    .btn-close-view {
        display:inline-flex;align-items:center;gap:.6rem;
        padding:.72rem 2rem;background:linear-gradient(135deg,#2563EB,#4F46E5);
        color:#fff;border-radius:.9rem;font-weight:800;font-size:.9rem;
        border:none;cursor:pointer;
        box-shadow:0 5px 18px rgba(37,99,235,.38);
        transition:all .25s cubic-bezier(.34,1.56,.64,1);font-family:'Cairo',sans-serif;
    }
    .btn-close-view:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(37,99,235,.52); }
    .btn-close-view:active { transform:scale(.96); }

    /* ===== DELETE CONFIRM ===== */
    .del-overlay { position:fixed;inset:0;z-index:9100;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(2,10,28,.45);backdrop-filter:blur(10px);opacity:0;pointer-events:none;transition:opacity .3s ease; }
    .del-overlay.open { opacity:1;pointer-events:all; }
    .del-card { width:100%;max-width:380px;background:rgba(255,255,255,.74);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.68);border-radius:2rem;overflow:hidden;box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.18);transform:scale(.84) translateY(22px);opacity:0;transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;direction:rtl; }
    .dark .del-card { background:rgba(10,17,34,.83);border-color:rgba(51,65,85,.55); }
    .del-overlay.open .del-card { transform:scale(1) translateY(0);opacity:1; }
    .del-bar { height:4px;background:linear-gradient(90deg,#EF4444,#DC2626); }
    .del-body { padding:2rem 1.8rem 1.4rem;text-align:center; }
    .del-icon { width:68px;height:68px;border-radius:50%;background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.22),rgba(239,68,68,.06));border:1.5px solid rgba(239,68,68,.3);box-shadow:0 0 0 8px rgba(239,68,68,.07);display:flex;align-items:center;justify-content:center;margin:0 auto 1.1rem;font-size:1.7rem;color:#EF4444; }
    .del-title { font-size:1.1rem;font-weight:900;color:#1e293b;margin-bottom:.42rem; }
    .dark .del-title { color:#f1f5f9; }
    .del-msg { font-size:.84rem;font-weight:600;color:#64748b;line-height:1.65; }
    .dark .del-msg { color:#94a3b8; }
    .del-footer { padding:0 1.8rem 1.8rem;display:flex;gap:.7rem; }
    .btn-del-ok { flex:1;padding:.72rem;background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;border-radius:.85rem;font-weight:800;font-size:.88rem;border:none;cursor:pointer;font-family:'Cairo',sans-serif;box-shadow:0 5px 16px rgba(239,68,68,.38);transition:all .22s cubic-bezier(.34,1.56,.64,1); }
    .btn-del-ok:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(239,68,68,.52); }
    .btn-del-no { flex:1;padding:.72rem;background:rgba(148,163,184,.1);border:1px solid rgba(148,163,184,.2);color:#64748b;border-radius:.85rem;font-weight:700;font-size:.88rem;cursor:pointer;font-family:'Cairo',sans-serif;transition:all .2s; }
    .dark .btn-del-no { background:rgba(71,85,105,.22);border-color:rgba(71,85,105,.3);color:#94a3b8; }
    .btn-del-no:hover { background:rgba(148,163,184,.2); }

    /* ===== CUSTOM ALERT ===== */
    .ca-overlay { position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:1rem;background:rgba(2,10,28,.42);backdrop-filter:blur(10px);opacity:0;pointer-events:none;transition:opacity .3s ease; }
    .ca-overlay.ca-show { opacity:1;pointer-events:all; }
    .ca-card { width:100%;max-width:400px;background:rgba(255,255,255,.72);backdrop-filter:blur(28px);border:1px solid rgba(255,255,255,.65);border-radius:2rem;overflow:hidden;box-shadow:0 2px 0 rgba(255,255,255,.9) inset,0 32px 64px rgba(0,0,0,.16);transform:scale(.82) translateY(28px);opacity:0;transition:transform .42s cubic-bezier(.34,1.56,.64,1),opacity .28s ease;direction:rtl; }
    .dark .ca-card { background:rgba(10,17,34,.82);border-color:rgba(51,65,85,.55); }
    .ca-overlay.ca-show .ca-card { transform:scale(1) translateY(0);opacity:1; }
    .ca-bar { height:4px; }
    .ca-bar.success { background:linear-gradient(90deg,#2563EB,#4F46E5); }
    .ca-bar.error   { background:linear-gradient(90deg,#EF4444,#DC2626); }
    .ca-body { padding:2rem 2rem 1.5rem;display:flex;flex-direction:column;align-items:center;text-align:center; }
    .ca-ring { width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem; }
    .ca-ring.success { background:radial-gradient(circle at 35% 35%,rgba(37,99,235,.22),rgba(37,99,235,.06));border:1.5px solid rgba(37,99,235,.3);box-shadow:0 0 0 8px rgba(37,99,235,.07); }
    .ca-ring.error   { background:radial-gradient(circle at 35% 35%,rgba(239,68,68,.20),rgba(239,68,68,.05));border:1.5px solid rgba(239,68,68,.28);box-shadow:0 0 0 8px rgba(239,68,68,.06); }
    .ca-ring svg { width:34px;height:34px;overflow:visible; }
    .ca-cc { stroke:#2563EB;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-cm { stroke:#2563EB;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:48;stroke-dashoffset:48; }
    .ca-ec { stroke:#EF4444;stroke-width:2.5;fill:none;stroke-dasharray:166;stroke-dashoffset:166; }
    .ca-ex1,.ca-ex2 { stroke:#EF4444;stroke-width:3;stroke-linecap:round;stroke-dasharray:30;stroke-dashoffset:30; }
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
    .ca-prog-fill { height:100%;border-radius:99px;background:linear-gradient(90deg,#2563EB,#4F46E5);transform-origin:left; }
    .ca-prog-fill.run { animation:caP var(--ca-dur,3.8s) linear forwards; }
    @keyframes caP { from{transform:scaleX(1)} to{transform:scaleX(0)} }
    .ca-foot { padding:0 2rem 1.8rem;display:flex;justify-content:center; }
    .ca-btn { font-family:'Cairo',sans-serif;font-weight:800;font-size:.9rem;padding:.65rem 2.2rem;border-radius:.9rem;border:none;cursor:pointer;transition:all .25s cubic-bezier(.34,1.56,.64,1);position:relative;overflow:hidden; }
    .ca-btn.success { background:linear-gradient(135deg,#2563EB,#4F46E5);color:#fff;box-shadow:0 5px 18px rgba(37,99,235,.38); }
    .ca-btn.success:hover { transform:translateY(-2px) scale(1.04);box-shadow:0 8px 26px rgba(37,99,235,.55); }
    .ca-btn.error   { background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;box-shadow:0 5px 18px rgba(239,68,68,.32); }
    .ca-btn:active { transform:scale(.96); }
    .ca-btn::before { content:'';position:absolute;top:0;left:-100%;width:55%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.22),transparent);transition:left .5s ease; }
    .ca-btn:hover::before { left:160%; }

    @media(max-width:700px){
        .header-card { flex-direction:column;align-items:flex-start; }
        .count-badge { align-self:stretch;flex-direction:row;justify-content:space-between;align-items:center; }
    }
</style>

<!-- Orbs -->
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<div class="rpt-page" dir="rtl">
<div class="page-container">

    <!-- Header -->
    <div class="glass header-card">
        <div class="header-brand">
            <div class="header-icon"><i class="fas fa-file-contract"></i></div>
            <div>
                <h1 class="header-title">سجل التقارير العامة</h1>
                <p class="header-sub">
                    <span class="pulse-dot"></span>
                    إدارة ومراجعة كافة تقارير الموظفين المرفوعة
                </p>
            </div>
        </div>
        <div class="count-badge">
            <span class="count-label">إجمالي التقارير</span>
            <span class="count-value">{{ $reports->count() }}</span>
        </div>
    </div>

    <!-- Table -->
    <div class="glass table-card">
        <div class="table-strip">
            <div class="strip-dot"></div>
            <span class="strip-lbl">التقارير المرفوعة</span>
            <span class="strip-count">{{ $reports->count() }} تقرير</span>
        </div>

        <div class="tbl-scroll">
            <table>
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>الموظف</th>
                        <th>المستودع</th>
                        <th style="text-align:center">التوقيت</th>
                        <th style="text-align:center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            <div class="td-title">{{ $report->title }}</div>
                            <div class="td-desc">{{ Str::limit($report->description, 55) }}</div>
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-av">{{ strtoupper(mb_substr($report->user->name, 0, 1)) }}</div>
                                <span class="user-name">{{ $report->user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="wh-badge">
                                <i class="fas fa-warehouse" style="font-size:.65rem"></i>
                                {{ $report->user->warehouse->name ?? 'غير محدد' }}
                            </span>
                        </td>
                        <td>
                            <div class="time-cell">
                                <div class="time-date">{{ $report->created_at->format('Y/m/d') }}</div>
                                <div class="time-hour">{{ $report->created_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="action-cell">
                                <!-- View -->
                                <button class="btn-view"
                                    onclick="openViewModal(
                                        '{{ addslashes($report->title) }}',
                                        '{{ addslashes($report->description) }}',
                                        '{{ addslashes($report->user->name) }}',
                                        '{{ addslashes($report->user->warehouse->name ?? 'غير محدد') }}'
                                    )"
                                    title="عرض التقرير">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- Delete -->
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="del-form" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn-del" onclick="openDelModal(this)" title="حذف">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>
                            <p class="empty-title">لا توجد تقارير مسجّلة حالياً</p>
                            <p class="empty-sub">ستظهر هنا تقارير الموظفين فور رفعها</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

<!-- ===== VIEW MODAL ===== -->
<div class="view-overlay" id="viewOverlay">
    <div class="view-card">
        <div class="view-strip">
            <div class="view-dot"></div>
            <span class="view-strip-lbl">تفاصيل التقرير</span>
            <button class="view-close" onclick="closeViewModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="view-body">
            <p class="view-title" id="viewTitle"></p>
            <div class="view-meta">
                <span class="meta-tag blue" id="viewUser"></span>
                <span class="meta-tag orange" id="viewWarehouse"></span>
            </div>
            <div class="view-content" id="viewDesc"></div>
        </div>
        <div class="view-footer">
            <button class="btn-close-view" onclick="closeViewModal()">
                <i class="fas fa-times"></i> إغلاق
            </button>
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
            <p class="del-msg">هل أنت متأكد من حذف هذا التقرير نهائياً؟<br>لا يمكن التراجع عن هذه الخطوة.</p>
        </div>
        <div class="del-footer">
            <button class="btn-del-ok" id="delConfirmBtn">نعم، احذف</button>
            <button class="btn-del-no" onclick="closeDelModal()">إلغاء</button>
        </div>
    </div>
</div>

<!-- ===== CUSTOM ALERT ===== -->
<div class="ca-overlay" id="caOverlay">
    <div class="ca-card">
        <div class="ca-bar" id="caBar"></div>
        <div class="ca-body">
            <div class="ca-ring" id="caRing"></div>
            <p class="ca-title" id="caTitle"></p>
            <p class="ca-msg"   id="caMsg"></p>
            <div class="ca-prog-wrap" id="caPW" style="display:none">
                <div class="ca-prog-fill" id="caPF"></div>
            </div>
        </div>
        <div class="ca-foot">
            <button class="ca-btn" id="caBtn" onclick="caClose()"></button>
        </div>
    </div>
</div>

<script>
/* ── View Modal ── */
function openViewModal(title, desc, user, warehouse) {
    document.getElementById('viewTitle').textContent = title;
    document.getElementById('viewDesc').textContent  = desc;
    document.getElementById('viewUser').innerHTML      = '<i class="fas fa-user-circle" style="font-size:.7rem"></i> ' + user;
    document.getElementById('viewWarehouse').innerHTML = '<i class="fas fa-warehouse" style="font-size:.7rem"></i> ' + warehouse;
    document.getElementById('viewOverlay').classList.add('open');
}
function closeViewModal() { document.getElementById('viewOverlay').classList.remove('open'); }
document.getElementById('viewOverlay').addEventListener('click', function(e){ if(e.target===this)closeViewModal(); });

/* ── Delete confirm ── */
let pendingForm = null;
function openDelModal(btn) {
    pendingForm = btn.closest('.del-form');
    document.getElementById('delOverlay').classList.add('open');
}
function closeDelModal() { document.getElementById('delOverlay').classList.remove('open'); pendingForm=null; }
document.getElementById('delConfirmBtn').addEventListener('click', () => { if(pendingForm) pendingForm.submit(); });
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
    bar.className=`ca-bar ${type}`;rng.className=`ca-ring ${type}`;
    rng.innerHTML=CA_SVG[type];t.textContent=title;m.textContent=msg;
    btn.className=`ca-btn ${type}`;btn.textContent=btnText;
    if(autoClose){ pw.style.display='block';pf.className='ca-prog-fill';pf.style.setProperty('--ca-dur',autoClose/1000+'s');void pf.offsetWidth;pf.classList.add('run');caTimer=setTimeout(caClose,autoClose); }
    else { pw.style.display='none'; }
    requestAnimationFrame(()=>o.classList.add('ca-show'));
}
function caClose(){ clearTimeout(caTimer);document.getElementById('caOverlay').classList.remove('ca-show'); }
document.getElementById('caOverlay').addEventListener('click',function(e){if(e.target===this)caClose();});

@if(session('success'))
window.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'success',title:'تمت العملية!',msg:'{{ session("success") }}',btnText:'حسناً',autoClose:3800});
});
@endif
@if($errors->any())
window.addEventListener('DOMContentLoaded',()=>{
    caShow({type:'error',title:'خطأ',msg:'{{ $errors->first() }}',btnText:'حسناً'});
});
@endif
</script>

@endsection