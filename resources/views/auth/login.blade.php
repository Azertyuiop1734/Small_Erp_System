<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | نظام إدارة المستودعات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        // إعداد Tailwind ليتعرف على كلاس dark عند إضافته للـ html
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc; /* لون فاتح افتراضي */
            transition: background 0.3s ease;
        }
        /* تعريف الألوان في الوضع الداكن باستخدام الكلاس */
        .dark body {
            background: #020617; 
        }
        .login-gradient {
            background: radial-gradient(circle at top right, #f1f5f9 0%, #e2e8f0 100%);
        }
        .dark .login-gradient {
            background: radial-gradient(circle at top right, #1e293b 0%, #020617 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .dark .glass-effect {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .input-focus-effect:focus {
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body class="h-full login-gradient flex items-center justify-center p-4">

    <div class="fixed left-6 top-6 z-50">
        <button id="page-theme-toggle" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md transition-all">
            <div class="relative w-10 h-5 bg-gray-200 dark:bg-blue-600 rounded-full transition-colors">
                <div class="absolute right-1 top-0.5 w-4 h-4 bg-white rounded-full transition-transform duration-300 transform dark:-translate-x-4 flex items-center justify-center shadow-sm">
                    <i class="fas fa-sun text-[10px] text-amber-500 dark:hidden"></i>
                    <i class="fas fa-moon text-[10px] text-blue-600 hidden dark:block"></i>
                </div>
            </div>
        </button>
    </div>

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex p-4 bg-blue-600 rounded-2xl shadow-xl shadow-blue-600/30 mb-4 transform hover:rotate-12 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight transition-colors">نظام المستودعات <span class="text-blue-500">ERP</span></h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm font-medium">مرحباً بك مجدداً، يرجى تسجيل الدخول للمتابعة</p>
        </div>

        <div class="glass-effect p-8 rounded-3xl shadow-2xl transition-all">
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mr-1">البريد الإلكتروني</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <input type="email" name="email" required
                            class="w-full bg-white dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-xl py-4 pr-12 pl-4 outline-none focus:border-blue-500 input-focus-effect transition-all placeholder-gray-400"
                            placeholder="admin@example.com">
                    </div>
                </div>

               <div class="space-y-2">
    <div class="flex justify-between items-center mr-1">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">كلمة المرور</label>
    </div>
    <div class="relative group">
        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-blue-500 transition-colors">
            <i class="fas fa-lock"></i>
        </div>
        
        <input type="password" id="password" name="password" required
            class="w-full bg-white dark:bg-[#030712] border border-gray-200 dark:border-gray-800 text-gray-900 dark:text-white rounded-xl py-4 pr-12 pl-12 outline-none focus:border-blue-500 input-focus-effect transition-all placeholder-gray-400"
            placeholder="••••••••••••">
        
        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 hover:text-blue-500 transition-colors">
            <i class="far fa-eye" id="toggleIcon"></i>
        </button>
    </div>
            <a href="#" class="text-xs text-blue-500 hover:text-blue-400 font-bold transition">نسيت؟</a>

</div>
<div class="flex items-center gap-2 mr-1">
    <input type="checkbox" id="remember" name="remember" 
        class="w-4 h-4 rounded border-gray-300 dark:border-gray-800 bg-white dark:bg-[#030712] text-blue-600 focus:ring-blue-500">
    <label for="remember" class="text-sm text-gray-500 dark:text-gray-400 cursor-pointer select-none">تذكر تسجيل دخولي</label>
</div>
                <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-600/20 transform active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    <span>دخول إلى النظام</span>
                </button>
            </form>
        </div>
        <footer class="mt-8 pb-4 text-center">
    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 tracking-widest uppercase">
        &copy; {{ date('Y') }} جميع الحقوق محفوظة | <span class="text-blue-500 font-bold">نظام إدارة المستودعات</span>
    </p>
</footer>
    </div>

<script>
    // 1. تعريف الدالة في النطاق العام لتكون قابلة للاستدعاء من onclick
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // استخدام أسماء كلاسات FontAwesome الصحيحة (far للعادية و fas للممتلئة)
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const themeBtn = document.getElementById('page-theme-toggle');
        const htmlElement = document.documentElement;

        // 2. التحقق من التفضيل المحفوظ للوضع الليلي
        const savedTheme = localStorage.getItem('color-theme');
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            htmlElement.classList.add('dark');
        } else {
            htmlElement.classList.remove('dark');
        }

        // 3. تفعيل زر التبديل
        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                if (htmlElement.classList.contains('dark')) {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        }
    });

</script>
</body>
</html>