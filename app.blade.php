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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
     <style>
        body { font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif; }
        /* تحسينات للتمرير في السايد بار */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#020617] text-white flex overflow-x-hidden" >
  @include('layouts.partials.sidebar')
   <div id="main-content" class="flex-1 min-h-screen transition-all duration-300 mr-72 flex flex-col">
    @include('layouts.partials.navbar')
<main class='p-8 flex-1'>
        @yield('content')
</main>    
</div>
   
    
   
    @stack('scripts')
</body>
</html>