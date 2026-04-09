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
     <style>
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
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-[#020617] dark:text-white flex overflow-x-hidden transition-colors duration-300">
  @include('layouts.partials.sidebar')
   <div id="main-content" class="flex-1 min-h-screen transition-all duration-300 mr-72 flex flex-col">
    @include('layouts.partials.navbar')
<main class='p-8 flex-1'>
        @yield('content')
</main>    
</div>
   
    <script>
  tailwind.config = {
    darkMode: 'class',
  }
</script>
<script>
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    const themeToggleBtn = document.getElementById('theme-toggle');

    // 1. التحقق من التفضيل المحفوظ أو إعدادات النظام
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        document.documentElement.classList.remove('dark');
        themeToggleDarkIcon.classList.remove('hidden');
    }

    // 2. مستمع الأحداث عند الضغط على الزر
    themeToggleBtn.addEventListener('click', function() {
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
</script>
   
    @stack('scripts')
</body>
</html>