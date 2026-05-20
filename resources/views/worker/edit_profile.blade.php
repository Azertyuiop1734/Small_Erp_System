<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الملف الشخصي</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    </style>
</head>

<body class="bg-gray-50 dark:bg-[#020617] transition-colors duration-500">
    <div class="fixed top-8 left-8 z-50">
 
         <button id="theme-toggle" type="button"  class="w-14 h-14 flex items-center justify-center rounded-2xl bg-white/90 dark:bg-slate-800/90 shadow-xl border border-gray-200 dark:border-slate-700 transition-all hover:scale-110 active:scale-95 group backdrop-blur-sm">
            <i id="theme-icon" class="fas fa-moon text-xl text-indigo-500 group-hover:rotate-12 transition-transform"></i>
        </button>
    </div>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 relative overflow-hidden">
        
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="max-w-4xl w-full space-y-8 animate-fade-in relative z-10">
            
            <div class="relative overflow-hidden bg-white dark:bg-[#0a1120] p-8 rounded-[2.5rem] border border-gray-100 dark:border-white/5 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600/20 rounded-2xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-user-edit text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-black text-gray-800 dark:text-white tracking-tight">تعديل الملف الشخصي</h1>
                            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">تحديث بيانات الحساب بشكل مستقل</p>
                        </div>
                    </div>
                    <a href="{{ route('profile') }}" class="p-3 bg-gray-100 dark:bg-white/5 text-gray-500 rounded-2xl hover:text-blue-500 transition-all">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-[#0a1120]/80 backdrop-blur-xl p-8 md:p-12 rounded-[3rem] shadow-2xl border border-gray-100 dark:border-white/5">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col items-center mb-10">
                        <div class="relative group">
                            <div class="absolute inset-0 bg-blue-500 rounded-full blur opacity-20 group-hover:opacity-40 transition-opacity"></div>
                            <img src="{{ $user->image ? asset('storage/'.$user->image) : asset('images/default-user.png') }}" 
                                 class="relative w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-2xl mb-4">
                            <label class="absolute bottom-4 right-0 bg-blue-600 p-2 rounded-full text-white cursor-pointer hover:scale-110 transition-transform shadow-lg">
                                <i class="fas fa-camera"></i>
                                <input type="file" name="image" class="hidden">
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-gray-400 text-xs font-black uppercase mr-2">الاسم الكامل</label>
                            <input type="text" name="name" value="{{ $user->name }}" required 
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 px-6 py-4 rounded-2xl text-gray-800 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-bold">
</div>

                        <div class="space-y-2">
    <label class="block text-gray-400 dark:text-gray-300 text-xs font-black uppercase tracking-[0.2em] mr-2">
        رقم الهاتف
    </label>
    <input type="text" 
           name="phone" 
           value="{{ old('phone', $user->phone ?? '') }}"
           placeholder="0XXXXXXXXX" 
           maxlength="10" 
           minlength="10"
           pattern="0[0-9]{9}"
           title="يجب أن يبدأ بـ 0 ويتكون من 10 أرقام"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
           class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 px-6 py-4 rounded-2xl text-gray-800 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-bold text-left" 
           dir="ltr">
    
   @error('phone')
    <div class="flex items-center gap-2 mt-2 px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-xl animate-pulse">
        <div class="flex-shrink-0 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation text-[8px] text-white"></i>
        </div>
        
        <p class="text-red-500 text-[11px] font-black uppercase tracking-tighter">
            {{ $message }}
        </p>
    </div>
@enderror
</div>
  </div>


                    @php
                        $detailsArray = [];
                        if($user->details) {
                            $parts = explode(';', $user->details);
                            foreach($parts as $part) {
                                $item = explode(':', $part);
                                if(count($item) == 2) $detailsArray[trim($item[0])] = trim($item[1]);
                            }
                        }
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <label class="block text-gray-400 text-xs font-black uppercase mr-2">العمر</label>
                            <input type="number" name="age" value="{{ $detailsArray['Age'] ?? '' }}" 
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 px-6 py-4 rounded-2xl text-gray-800 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-bold">
                        </div>

                        <div class="space-y-2 text-right">
                            <label class="block text-gray-400 text-xs font-black uppercase mr-2">الجنس</label>
                            <select name="gender" class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 px-6 py-4 rounded-2xl text-gray-800 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-bold appearance-none cursor-pointer">
                                <option value="Male" class="bg-white dark:bg-[#1e293b]" {{ ($detailsArray['Gender'] ?? '') == 'Male' ? 'selected' : '' }}>ذكر</option>
                                <option value="Female" class="bg-white dark:bg-[#1e293b]" {{ ($detailsArray['Gender'] ?? '') == 'Female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-gray-400 text-xs font-black uppercase mr-2">المسمى الوظيفي</label>
                            <input type="text" name="job" value="{{ $detailsArray['Job'] ?? '' }}" 
                                   class="w-full bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10 px-6 py-4 rounded-2xl text-gray-800 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-bold">
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100 dark:border-white/5 flex flex-col md:flex-row justify-between gap-4">
                        <a href="{{ route('profile') }}" 
                           class="px-8 py-4 bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400 rounded-2xl font-black uppercase tracking-widest hover:bg-red-500/10 hover:text-red-500 transition-all text-center text-sm">
                            إلغاء
                        </a>
                        <button type="submit" 
                                class="px-12 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest shadow-2xl shadow-blue-600/30 hover:scale-[1.02] transition-all">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
  

    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const htmlElement = document.documentElement; // استهداف عنصر html لتغيير الوضع

    // دالة لتحديث الواجهة بناءً على الوضع الحالي
    function updateTheme() {
        if (localStorage.getItem('theme') === 'dark' || 
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            htmlElement.classList.add('dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        } else {
            htmlElement.classList.remove('dark');
            themeIcon.classList.replace('fa-sun', 'fa-moon');
        }
    }

    // تشغيل الفحص عند تحميل الصفحة
    updateTheme();

    // إضافة مستمع للحدث عند الضغط على الزر
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            if (htmlElement.classList.contains('dark')) {
                htmlElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
            } else {
                htmlElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
            }
        });
    }


    // التحقق من التفضيلات المحفوظة عند تحميل الصفحة
    (function() {
        const savedTheme = localStorage.getItem('theme');
        const icon = document.getElementById('theme-icon');
        
        if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if(icon) icon.classList.replace('fa-moon', 'fa-sun');
        } else {
            document.documentElement.classList.remove('dark');
            if(icon) icon.classList.replace('fa-sun', 'fa-moon');
        }
    })();

    // كود فحص الهاتف السابق (تأكد من بقائه)
    // ... validatePhone code ...

        const phoneInput = document.getElementById('phone_input');
        const errorMsg = document.getElementById('phone_error_msg');
        const statusIcon = document.getElementById('status_icon');
        const submitBtn = document.getElementById('submit_btn');

        function validate() {
            let val = phoneInput.value;

            // 1. تنظيف المدخلات (أرقام فقط)
            val = val.replace(/[^0-9]/g, '');
            phoneInput.value = val;

            // 2. فحص الشروط
            const startsWithZero = val.startsWith('0');
            const isTenDigits = val.length === 10;

            if (val.length === 0) {
                // حالة الفراغ
                showStatus('info', false);
            } else if (startsWithZero && isTenDigits) {
                // حالة النجاح
                showStatus('success', true);
            } else {
                // حالة الخطأ
                showStatus('error', false);
            }
        }

        function showStatus(type, isValid) {
            if (type === 'success') {
                statusIcon.innerHTML = '<i class="fas fa-check-circle text-green-500 animate-bounce"></i>';
                phoneInput.className = phoneInput.className.replace(/border-[^ ]+/g, '') + ' border-green-500';
                errorMsg.classList.add('hidden');
                submitBtn.disabled = false;
            } else if (type === 'error') {
                statusIcon.innerHTML = '<i class="fas fa-times-circle text-red-500"></i>';
                phoneInput.className = phoneInput.className.replace(/border-[^ ]+/g, '') + ' border-red-500';
                errorMsg.classList.remove('hidden');
                submitBtn.disabled = true;
            } else {
                statusIcon.innerHTML = '<i class="fas fa-circle-info text-gray-300"></i>';
                phoneInput.className = phoneInput.className.replace(/border-[^ ]+/g, '') + ' border-gray-100 dark:border-white/10';
                errorMsg.classList.add('hidden');
                submitBtn.disabled = true;
            }
        }

        // تشغيل الفحص عند الكتابة وعند التحميل (في حال وجود قيمة قديمة)
        phoneInput.addEventListener('input', validate);
        window.onload = validate;
        
    </script>
</body>
</html>