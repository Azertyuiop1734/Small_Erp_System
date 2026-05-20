<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتج | {{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    tailwind.config = {
        darkMode: 'class', 
    }
</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap');
        body { font-family: 'Cairo', sans-serif; }
    </style>
    <script>
        // تفعيل الوضع الليلي بناءً على التفضيلات
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-[#020617] min-h-screen flex items-center justify-center p-4 transition-colors duration-300">

    <div class="max-w-4xl w-full animate__animated animate__fadeIn">
        
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-gray-500 hover:text-blue-600 dark:text-gray-400 transition-colors gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
            
           <div class="flex items-center justify-center p-2">
    <button id="theme-toggle" type="button" 
        class="group relative inline-flex items-center justify-center p-3 overflow-hidden font-medium transition-all duration-500 rounded-2xl bg-white/10 dark:bg-slate-800/50 backdrop-blur-lg border border-gray-200 dark:border-slate-700 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(59,130,246,0.1)] active:scale-95 group">
        
        <div class="absolute inset-0 w-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 transition-all duration-500 ease-out group-hover:w-full"></div>

        <div class="relative flex items-center justify-center w-6 h-6">
            <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6 text-slate-700 transition-all duration-500 transform group-hover:rotate-12 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            
            <svg id="theme-toggle-light-icon" class="hidden w-6 h-6 text-amber-400 transition-all duration-500 transform group-hover:rotate-90 group-hover:scale-110 drop-shadow-[0_0_8px_rgba(251,191,36,0.5)]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path>
            </svg>
        </div>
    </button>
</div>
        </div>

        <div class="bg-white dark:bg-[#0f172a] rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden">
            
            <div class="p-8 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-[#020617]/30 text-center">
                <div class="inline-flex p-4 rounded-2xl bg-blue-600/10 text-blue-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تعديل بيانات المنتج</h2>
                <p class="text-gray-500 dark:text-gray-400 mt-1">أنت تقوم بتعديل: <span class="text-blue-600 font-bold">{{ $product->name }}</span></p>
            </div>

            <form id="editProductForm" action="{{ route('products.update', $product->id) }}" method="POST" class="p-10 space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-gray-300 mr-2">اسم المنتج</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-2xl px-5 py-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none shadow-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-400 dark:text-gray-500 mr-2">الباركود (غير قابل للتعديل)</label>
                        <input type="text" value="{{ $product->barcode }}" disabled
                            class="w-full bg-gray-100 dark:bg-[#020617]/50 border border-gray-200 dark:border-gray-800 rounded-2xl px-5 py-4 text-gray-400 cursor-not-allowed font-mono">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 dark:text-gray-300 mr-2">القسم</label>
                        <select name="category_id" 
                            class="w-full bg-gray-50 dark:bg-[#020617] border border-gray-200 dark:border-gray-700 rounded-2xl px-5 py-4 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition outline-none shadow-sm appearance-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-emerald-600 dark:text-emerald-500 mr-2">سعر البيع (د.ج)</label>
                        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                            class="w-full bg-gray-50 dark:bg-[#020617] border border-emerald-100 dark:border-emerald-900/30 rounded-2xl px-5 py-4 text-emerald-600 dark:text-emerald-400 font-bold focus:ring-2 focus:ring-emerald-500 transition outline-none shadow-sm text-center text-xl">
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-100 dark:border-gray-800 flex flex-col md:flex-row gap-4">
                    <button type="button" onclick="confirmUpdate()"
                        class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all shadow-xl shadow-blue-600/25 flex items-center justify-center gap-3 text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ التعديلات
                    </button>
                    
                    <a href="{{ route('products.index') }}" 
                        class="flex-1 bg-gray-100 dark:bg-[#020617] hover:bg-gray-200 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold py-4 rounded-2xl transition-all text-center border border-gray-200 dark:border-gray-700 flex items-center justify-center">
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // وظيفة التنبيه (SweetAlert)
        function showStyledAlert(config) {
            const isDark = document.documentElement.classList.contains('dark');
            return Swal.fire({
                ...config,
                background: isDark ? '#0f172a' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: isDark ? '#334155' : '#94a3b8',
                customClass: {
                    popup: 'rounded-[2rem] border border-gray-100 dark:border-gray-800 shadow-2xl',
                    confirmButton: 'rounded-xl px-8 py-3 font-bold',
                    cancelButton: 'rounded-xl px-8 py-3 font-bold'
                }
            });
        }

        function confirmUpdate() {
            showStyledAlert({
                icon: 'question',
                title: 'تأكيد الحفظ',
                text: "سيتم تحديث بيانات المنتج فوراً.",
                showCancelButton: true,
                confirmButtonText: 'نعم، حفظ',
                cancelButtonText: 'تراجع'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('editProductForm').submit();
                }
            });
        }

        // تبديل الوضع الليلي
const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    function updateIcons() {
        if (document.documentElement.classList.contains('dark')) {
            lightIcon.classList.remove('hidden');
            lightIcon.classList.add('animate__animated', 'animate__rotateIn');
            darkIcon.classList.add('hidden');
        } else {
            darkIcon.classList.remove('hidden');
            darkIcon.classList.add('animate__animated', 'animate__bounceIn');
            lightIcon.classList.add('hidden');
        }
    }

    // التحقق المبدئي
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
    updateIcons();

    themeToggleBtn.addEventListener('click', function() {
        // إضافة أنيميشن تلاشي سريع للمحتوى بالكامل عند التبديل
        document.body.classList.add('opacity-0');
        
        setTimeout(() => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
            updateIcons();
            document.body.classList.remove('opacity-0');
            document.body.classList.add('transition-opacity', 'duration-500', 'opacity-100');
        }, 150);
    });
    </script>
</body>
</html>