<!DOCTYPE html>
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
        <span class="font-bold text-xl tracking-wider uppercase">Pos System</span>
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

</body>
</html>
