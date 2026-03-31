<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
        }
        .glass-card {
            background-color: #111827;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .input-dark {
            background-color: #030712;
            border-color: #1f2937;
        }
        .btn-gradient {
            background: linear-gradient(90deg, #2563eb 0%, #0891b2 100%);
        }
        /* تعديل مكان الأيقونات لتناسب RTL */
        .icon-left { left: 1rem; right: auto; }
        .icon-right { right: 1rem; left: auto; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <div class="flex items-center justify-center gap-3 mb-8">
            <div class="bg-blue-500 p-2 rounded-xl shadow-lg shadow-blue-500/20">
                <i class="fas fa-shopping-cart text-white text-xl"></i>
            </div>
            <span class="text-white font-bold tracking-widest text-lg">POS SYSTEM</span>
        </div>

        <div class="glass-card rounded-[32px] p-10 shadow-2xl">
            <h1 class="text-white text-3xl font-semibold mb-2 text-center">مرحباً بك مجدداً!</h1>
            <p class="text-gray-400 text-sm mb-8 text-center">قم بتسجيل الدخول لمتابعة العمل</p>

            @if($errors->any())
                <div class="mb-6 p-3 bg-red-900/30 border border-red-500/50 rounded-lg text-red-400 text-xs flex items-center gap-2">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-6 space-y-2">
                    <label class="block text-white text-sm font-medium mr-1">البريد الإلكتروني</label>
                    <div class="relative flex items-center">
                        <i class="far fa-envelope absolute icon-right text-gray-500 text-lg"></i>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               placeholder="example@gmail.com"
                               class="input-dark w-full py-4 pr-12 pl-4 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all border text-left" dir="ltr">
                    </div>
                </div>

                <div class="mb-6 space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="block text-white text-sm font-medium">كلمة المرور</label>
                        <a href="{{ route('password.request') }}" class="text-blue-500 text-xs hover:underline">نسيت كلمة المرور؟</a>
                    </div>
                    <div class="relative flex items-center">
                        <i class="fas fa-lock absolute icon-right text-gray-500"></i>
                        <input type="password" id="password" name="password" required
                               placeholder="••••••••"
                               class="input-dark w-full py-4 pr-12 pl-12 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all border text-left" dir="ltr">
                        
                        <button type="button" onclick="togglePassword()" class="absolute icon-left text-gray-500 hover:text-white transition-colors focus:outline-none">
                            <i id="eye-icon" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" 
                        class="btn-gradient w-full py-4 rounded-xl text-white font-semibold text-lg shadow-lg shadow-blue-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                    تسجيل الدخول
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>