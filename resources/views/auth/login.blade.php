<!DOCTYPE html>
 HEAD
<html lang="ar" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>POS System Login</title>
    <style>
        body {
            background: radial-gradient(circle at center, #1a233a 0%, #090d16 100%);
        }
        .login-card {
            background-color: #111827;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .custom-gradient-btn {
            background: linear-gradient(to right, #2563eb, #0891b2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center font-sans text-white p-4">
    <div class="flex items-center gap-3 mb-8">
        <div class="bg-blue-500 p-2 rounded-lg shadow-[0_0_15px_rgba(59,130,246,0.5)]">
            <i class="fas fa-shopping-cart text-white text-xl"></i>
        </div>
        <span class="font-bold text-xl tracking-wider uppercase">Erp System</span>
    </div>

    <div class="login-card w-full mx-auto p-8 rounded-[2rem] shadow-2xl max-w-md">
        
        <h1 class="text-4xl font-serif font-semibold mb-2">Welcome Back!</h1>
        <p class="text-gray-400 text-sm mb-8">Login to your account to continue</p>

@if($errors->any())
    <div class="bg-red-500/20 text-red-400 p-3 rounded-lg mb-4 text-sm">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="login" class="space-y-6">
    @csrf
    <div class="space-y-2">
        <label class="block text-sm font-medium ml-1">Email Address</label>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                <i class="far fa-envelope"></i>
            </span>
            <input type="email"
                   name="email"
                   placeholder="yourname@gmail.com"
                   class="w-full bg-[#0d121d] border border-transparent focus:border-blue-500 rounded-xl py-4 pl-12 pr-4 text-gray-300 outline-none transition-all placeholder:text-gray-600"
                    required>
        </div>
    </div>
    <div class="space-y-2">
        <div class="flex justify-between items-center px-1">
            <label class="text-sm font-medium">Password</label>
            <a href="#" class="text-blue-500 text-xs hover:underline">Forgot password?</a>
        </div>
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                <i class="fas fa-lock"></i>
            </span>
            <input type="password"
                   name="password"
                   placeholder="••••••••••••" 
                   class="w-full bg-[#0d121d] border border-transparent focus:border-blue-500 rounded-xl py-4 pl-12 pr-12 text-gray-300 outline-none transition-all"
                   required>
        </div>
    </div>
    <button type="submit"
    class="w-full custom-gradient-btn text-white font-semibold py-4 rounded-xl mt-4 hover:opacity-90 transition-opacity shadow-lg">
    Login
   </button>
</form>
</div>

<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
            <h1 class="text-white text-4xl font-semibold mb-2">Welcome Back!</h1>
            <p class="text-gray-400 text-sm mb-8">Login to your account to continue</p>

            @if($errors->any())
                <div class="mb-6 p-3 bg-red-900/30 border border-red-500/50 rounded-lg text-red-400 text-xs flex items-center gap-2">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

          <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="space-y-2">
                    <label class="block text-white text-sm font-medium">Email Address</label>
                    <div class="relative flex items-center">
                        <i class="far fa-envelope absolute left-4 text-gray-500 text-lg"></i>
                        <input type="email" name="email" required
                               placeholder="yourname@gmail.com"
                               class="input-dark w-full py-4 pl-12 pr-4 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all border">
                    </div>
                </div>

                <div class="space-y-2 text-right">
                    <div class="flex justify-between items-center">
                        <label class="block text-white text-sm font-medium text-right">Password</label>
                        <a href="#" class="text-blue-500 text-xs hover:underline">Forgot password?</a>
                    </div>
                    <div class="relative flex items-center">
                        <i class="fas fa-lock absolute left-4 text-gray-500"></i>
                        <input type="password" name="password" required
                               placeholder="••••••••••••"
                               class="input-dark w-full py-4 pl-12 pr-12 rounded-xl text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all border">
                        <i class="far fa-eye absolute right-4 text-gray-500 cursor-pointer hover:text-white transition-colors"></i>
                    </div>
                </div>

                <button type="submit" 
                        class="btn-gradient w-full py-4 rounded-xl text-white font-semibold text-lg shadow-lg shadow-blue-600/20 hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                    Login
                </button>
            </form>
        </div>
    </div>
 origin/main

</body>
</html>