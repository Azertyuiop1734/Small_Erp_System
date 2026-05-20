<!DOCTYPE html>
<html lang="ar" dir="rtl" id="main-html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <script>
        // إعداد Tailwind لدعم التبديل اليدوي للوضع الداكن
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            transition: background 0.5s ease;
        }
        /* الوضع العادي */
        .light {
            background: radial-gradient(circle at top right, #f8fafc 0%, #e2e8f0 100%);
        }
        .light .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }
        .light .text-white { color: #1e293b; }
        .light .text-gray-400 { color: #64748b; }
        .light .bg-black\/30 { background: rgba(0, 0, 0, 0.05); border-color: rgba(0, 0, 0, 0.1); color: #1e293b; }

        /* الوضع الداكن */
        .dark {
            background: radial-gradient(circle at top right, #1e293b 0%, #0f172a 100%);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .animate-up { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body id="vanta-bg" class="dark min-h-screen flex items-center justify-center p-4 overflow-y-auto">    <div class="fixed top-8 left-8 z-50">
        <button onclick="toggleTheme()" class="p-4 rounded-3xl bg-white/10 dark:bg-black/20 border border-white/10 backdrop-blur-xl shadow-2xl transition-all hover:scale-110 active:scale-90 text-yellow-500 dark:text-blue-400">
            <i id="theme-icon" class="fas fa-moon text-2xl"></i>
        </button>
    </div>

    <div class="w-full max-w-lg animate-up">
        <div class="text-center mb-10">
            <div class="inline-flex p-4 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-[2rem] shadow-2xl mb-4 transition-transform hover:rotate-12 duration-300">
                <i class="fas fa-shopping-cart text-3xl text-white"></i>
            </div>
            <h2 class="text-white font-black tracking-[0.2em] text-xl uppercase">POS System</h2>
        </div>

        <div class="glass-card rounded-[3.5rem] p-10 md:p-14 transition-all duration-500">
            <div class="mb-10 text-center">
                <h1 class="text-white text-4xl font-black mb-3">تسجيل الدخول</h1>
                <p class="text-gray-400 font-medium italic">مرحباً بك مجدداً في نظامك الذكي</p>
            </div>
 @if($errors->any())
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl text-red-400 text-sm flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="space-y-8">
                @csrf
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-8">
                @csrf
                <div class="space-y-3">
                    <label class="block text-gray-400 dark:text-gray-300 text-sm font-black mr-2 uppercase tracking-widest">البريد الإلكتروني</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                            <i class="far fa-envelope text-gray-500 group-focus-within:text-blue-500 text-xl transition-colors"></i>
                        </div>
                        <input type="email" name="email" required class="w-full bg-black/30 border border-white/10 pr-14 pl-6 py-5 rounded-[1.5rem] text-white focus:outline-none focus:border-blue-500 transition-all text-left font-medium" dir="ltr">
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center mr-2">
                        <label class="block text-gray-400 dark:text-gray-300 text-sm font-black uppercase tracking-widest">كلمة المرور</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-focus-within:text-blue-500 text-xl transition-colors"></i>
                        </div>
                        <input type="password" id="password" name="password" required class="w-full bg-black/30 border border-white/10 pr-14 pl-14 py-5 rounded-[1.5rem] text-white focus:outline-none focus:border-blue-500 transition-all text-left font-medium" dir="ltr">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-500 hover:text-blue-500  transition-colors">
                            <i id="eye-icon" class="far fa-eye text-lg"></i>
                        </button>
                    </div>
                    <div class="flex justify-start mt-1">
    <a href="{{ route('password.request') }}" class="text-xs text-blue-500 hover:text-blue-400 font-black tracking-widest transition-colors">
        نسيت كلمة المرور؟
    </a>
</div>
        </div>

        

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:scale-[1.02] active:scale-[0.98] py-5 rounded-[1.5rem] text-white font-black text-xl shadow-2xl shadow-blue-600/30 transition-all">
                    دخول النظام
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const icon = document.getElementById('theme-icon');
            
            if (body.classList.contains('dark')) {
                body.classList.replace('dark', 'light');
                icon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.replace('light', 'dark');
                icon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'dark');
            }
        }

        // حفظ تفضيلات المستخدم عند تحديث الصفحة
        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.replace('dark', 'light');
            document.getElementById('theme-icon').classList.replace('fa-moon', 'fa-sun');
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        }
        // تشغيل خلفية Vanta.js
let vantaEffect = null;

function initVanta() {
    // تدمير التأثير القديم إذا كان موجوداً لتجنب استهلاك الذاكرة
    if (vantaEffect) vantaEffect.destroy();

    const isDark = document.body.classList.contains('dark');

    vantaEffect = VANTA.NET({
        el: "#vanta-bg",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        scale: 1.00,
        scaleMobile: 1.00,
        // تغيير الألوان بناءً على الوضع
        color: isDark ? 0x3b82f6 : 0x2563eb,          // خيوط زرقاء فاتحة للداكن، وأغمق قليلاً للنهاري
        backgroundColor: isDark ? 0x020617 : 0xf8fafc, // خلفية سوداء للداكن، ورمادي فاتح جداً للنهاري
        points: 10.00,
        maxDistance: 20.00,
        spacing: 15.00,
        forceAnimate: true
    });
}

// تشغيل التأثير لأول مرة عند تحميل الصفحة
initVanta();

// تعديل دالة toggleTheme الموجودة لديك لتشمل تحديث الفانتا
function toggleTheme() {
    const body = document.body;
    const icon = document.getElementById('theme-icon');
    
    if (body.classList.contains('dark')) {
        body.classList.replace('dark', 'light');
        icon.classList.replace('fa-moon', 'fa-sun');
        localStorage.setItem('theme', 'light');
    } else {
        body.classList.replace('light', 'dark');
        icon.classList.replace('fa-sun', 'fa-moon');
        localStorage.setItem('theme', 'dark');
    }

    // نداء دالة إعادة تشغيل الخلفية بالألوان الجديدة
    initVanta();
}
    </script>
</body>
</html>