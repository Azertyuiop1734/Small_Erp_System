<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'نظام POS')</title>
    @if(View::hasSection('page_icon_url'))
        <link rel="icon" type="image/png" href="@yield('page_icon_url')">
    @else
        {{-- الأيقونة الافتراضية للنظام في حال لم نحدد واحدة --}}
        <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <style>
        html,body {
    overflow-x: hidden;
   
}
        /* تنسيق سكرول بار نحيف ومتناسق مع التصميم المظلم والفاتح */

.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #1e293b; /* لون رمادي غامق يناسب التصميم */
    border-radius: 10px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #334155;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #3b82f6; /* يتحول للأزرق عند التحويم */
}
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }
        /* تحسينات للتمرير في السايد بار */

    /* الحالة الافتراضية: السايد بار مفتوح */
    :root { --sidebar-width: 18rem; } /* 72 */
    
    /* عندما يتم تفعيل الكلاس المصغر */
    .mini-sidebar { --sidebar-width: 5rem; } /* 20 */

#sidebar {
    width: var(--sidebar-width) !important;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: fixed; /* تأكد أنه ثابت */
    right: 0;
    top: 0;
    height: 100vh;
    z-index: 50;
}
#main-content {
    /* الحل السحري: العرض هو 100% ناقص عرض السايد بار */
    width: calc(100% - var(--sidebar-width)) !important;
    margin-right: var(--sidebar-width) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 100vh;
}
    /* إخفاء النصوص والأسهم تلقائياً عند التصغير */
    .mini-sidebar .sidebar-text,
    .mini-sidebar .logo-container span,
    .mini-sidebar .fa-chevron-down {
        opacity: 0 !important;
        display: none !important;
    }

    /* جعل الأيقونات في المنتصف تماماً */
    .mini-sidebar #sidebar a, 
    .mini-sidebar #sidebar button {
        justify-content: center !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* منع تكسر الروابط */
    #sidebar a, #sidebar button {
        white-space: nowrap;
    }
    #navbar {
    width: calc(100% - var(--sidebar-width)) !important;
    margin-right: var(--sidebar-width) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
/* تحسين توافق SweetAlert مع الوضع الداكن */
.dark .swal2-popup {
    background-color: #0f172a !important; /* نفس لون خلفية تطبيقك */
    border: 1px solid #1e293b !important;
}

.dark .swal2-title, 
.dark .swal2-html-container, 
.dark .swal2-content {
    color: #f8fafc !important;
}

/* تعديل لون نص الأخطاء داخل القائمة */
.dark .text-rose-500 {
    color: #fb7185 !important;
}
canvas.vanta-canvas {
    width: 100% !important;
    height: 100% !important;
    position: fixed !important;
    top: 0;
    left: 0;
    z-index: -1; /* لضمان بقائها خلف المحتوى */
}
    </style>
</head>
<body class="min-h-screen flex overflow-x-hidden transition-colors duration-300 
    /* وضع الفاتح: تدرج من الأبيض (المركز) إلى السماوي (الأطراف) */
    bg-[radial-gradient(ellipse_at_center,_#ffffff_0%,_#f0f9ff_40%,_#bae6fd_100%)] text-gray-900 
    /* وضع المظلم: إشعاع سماوي على خلفية داكنة */
    dark:bg-[radial-gradient(ellipse_at_center,_#0ea5e9_0%,_#0c4a6e_40%,_#040c18_100%)] dark:text-white">  @auth
    @if(auth()->user()->role->role_name === 'Admin')
        @include('layouts.partials.sidebar') {{-- تأكد من اسم ملف سايدبار الادمن لديك --}}
    @else
        @include('layouts.partials.worker_sidebar')
    @endif
@endauth
<div id="main-content" class="flex-1 min-h-screen transition-all duration-300 flex flex-col">
        @include('layouts.partials.navbar')
<main class='p-8 flex-1'>
        @yield('content')
</main>    
</div>
   
    @stack('scripts')
    <script>
  tailwind.config = {
    darkMode: 'class',
  }
</script>
<script>
    // --- 1. إعدادات الثيم (الوضع الليلي والنهاري) ---
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleBtn = document.getElementById('theme-toggle');

    // التحقق الأولي
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        if(themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        if(themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
    }

    themeToggleBtn?.addEventListener('click', function() {
        themeToggleDarkIcon?.classList.toggle('hidden');
        themeToggleLightIcon?.classList.toggle('hidden');

        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }

        // تحديث Vanta فوراً ليتناسب مع اللون الجديد
        if (typeof updateVantaTheme === 'function') {
            updateVantaTheme();
        }
    });

    // --- 2. إدارة السايد بار والمنحنيات ---
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleSidebar');
if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        // 1. تبديل حالة السايد بار
        document.body.classList.toggle('mini-sidebar');

        // 2. تحديث Vanta أثناء الحركة (لنعومة أفضل)
        let startTime = null;
        function updateStep(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = timestamp - startTime;

            if (window.vantaEffect && typeof window.vantaEffect.resize === 'function') {
                window.vantaEffect.resize();
            }

            // استمرار التحديث لمدة 400ms (مدة الانتقال في CSS)
            if (progress < 400) {
                window.requestAnimationFrame(updateStep);
            }
        }
        window.requestAnimationFrame(updateStep);

        // 3. تحديث نهائي للمنحنى والخلفية بعد انتهاء الأنميشن تماماً
        setTimeout(() => {
            if (window.vantaEffect) window.vantaEffect.resize();
            
            if (window.myChart) {
                window.myChart.resize();
                window.myChart.update();
            }
            window.dispatchEvent(new Event('resize'));
        });
    });
}

        // --- 3. إدارة القوائم المنسدلة (Dropdowns) ---
        const dropdownBtns = ['supplierBtn', 'warehouseBtn', 'employeeBtn', 'expensesBtn', 'CustomersBtn', 'purchasesBtn', 'statisticsBtn'];

        dropdownBtns.forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (!btn) return;

            btn.addEventListener('click', function () {
                const isMini = document.body.classList.contains('mini-sidebar');

                // إذا كان السايد بار مصغراً، افتحه أولاً ثم افتح القائمة
                if (isMini) {
                    document.body.classList.remove('mini-sidebar');
                    setTimeout(() => openDropdown(btnId), 320);
                } else {
                    toggleDropdown(btnId);
                }
            });
        });

        function getMenuId(btnId) { return btnId.replace('Btn', 'Menu'); }
        function getArrowId(btnId) { return btnId.replace('Btn', 'Arrow'); }

        function openDropdown(btnId) {
            const menu = document.getElementById(getMenuId(btnId));
            const arrow = document.getElementById(getArrowId(btnId));
            if (menu) menu.style.maxHeight = '500px';
            if (arrow) arrow.classList.add('rotate-180');
        }

        function toggleDropdown(btnId) {
            const menu = document.getElementById(getMenuId(btnId));
            const arrow = document.getElementById(getArrowId(btnId));
            if (!menu) return;

            const isOpen = menu.style.maxHeight !== '0px' && menu.style.maxHeight !== '';
            
            if (isOpen) {
                menu.style.maxHeight = '0px';
                arrow?.classList.remove('rotate-180');
            } else {
                // إغلاق أي قائمة مفتوحة أخرى للحفاظ على نظافة الواجهة
                ['supplierMenu','warehouseMenu','employeeMenu','purchasesMenu','statisticsMenu','expensesMenu','CustomersMenu'].forEach(id => {
                    const m = document.getElementById(id);
                    const a = document.getElementById(id.replace('Menu','Arrow'));
                    if (m && id !== getMenuId(btnId)) {
                        m.style.maxHeight = '0px';
                        a?.classList.remove('rotate-180');
                    }
                });
                menu.style.maxHeight = '500px';
                arrow?.classList.add('rotate-180');
            }
        }
    });
</script>
   
 @stack('scripts')
</body>
</html>